<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Scopes\Post\StatusScope;
use App\Services\BaseService;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService extends BaseService implements PostServiceInterface
{
    public Post $post;
    public Collection $random;
    public Collection $comments;
    public int $commentsCount;
    private CacheServiceInterface $cacheService;
    private string $locale;

    public function __construct(
        Post $model,
        CacheServiceInterface $cacheService,
    ) {
        parent::__construct($model);
        $this->cacheService = $cacheService;
        $this->locale = App::currentLocale();
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->with(['categories', 'views'])
            ->withCount('comments')
            ->latest()
            ->paginate($qty);
    }

    public function getPaginationWithQuery(Request $request, int $qty = null): Paginator
    {
        return $this->model
            ->with(['user', 'views'])
            ->withQuery($qty, $request->query());
    }

    public function getSearchPagination(Request $request, int $qty = null): Paginator
    {
        return $this->model
            ->search($request->q)
            ->paginate($qty);
    }

    public function getSearchResults(Request $request, int $limit): Collection
    {
        return $this->model
            ->search($request->q)
            ->limit($limit)
            ->get();
    }

    public function getWaiting(int $qty = null): Paginator
    {
        return $this->model
            ->with('user')
            ->latestInActive()
            ->paginate($qty);
    }

    public function getRandom(int $limit): Collection
    {
        return $this->model
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    public function getLeaderboard(CarbonInterface $date): Collection
    {
        return $this->model
            ->with('user')
            ->withoutGlobalScope(StatusScope::class)
            ->where('created_at', '>=', $date)
            ->get()
            ->groupBy('user.name')
            ->sortDesc()
            ->slice(-3)
            ->keys();
    }

    public function getPopular(CarbonInterface $date, int $limit): Collection
    {
        $key = $this->cacheService->localName('popular');
        $ttl = Carbon::now()->addMinute();

        return Cache::tags(CacheServiceInterface::HIT)
            ->remember($key, $ttl, function () use ($date, $limit) {
                return $this->model
                    ->with('categories')
                    ->viewsJoin()
                    ->activeViews($date)
                    ->latest('post_views.today')
                    ->limit($limit)
                    ->get();
            });
    }

    public function getWeek(int $limit): Collection
    {
        $key = $this->cacheService->localName('week');
        $ttl = Carbon::now()->addMinute();

        return Cache::tags(CacheServiceInterface::HIT)
            ->remember($key, $ttl, function () use ($limit) {
                $date = Carbon::now()->startOfWeek();

                return $this->model
                    ->viewsJoin()
                    ->activeViews($date)
                    ->latest('post_views.week')
                    ->limit($limit)
                    ->get();
            });
    }

    public function getInteresting(int $limit): Collection
    {
        $key = $this->cacheService->localName('interesting');
        $ttl = Carbon::now()->addMinute();

        return Cache::tags(CacheServiceInterface::HIT)
            ->remember($key, $ttl, function () use ($limit) {
                return $this->model
                    ->viewsJoin()
                    ->latest('post_views.all')
                    ->limit($limit)
                    ->get();
            });
    }

    public function getByAlias(string $alias): Post
    {
        return $this->model
            ->findByAlias($alias);
    }

    public function getOneWithoutScopes(int $id): Post
    {
        return $this->model
            ->withoutGlobalScopes()
            ->findOrFail($id);
    }

    public function setOne(string $alias): void
    {
        $this->setPost($alias);
        $this->setComments();
        $this->setRandom(3);

        (new PostViewService($this->post, $this->cacheService))->addViews();
    }

    public function store(Request $request): void
    {
        $post = new Post();
        $post->user_id = Auth::id();
        $post->alias = Str::slug($request->title);
        $this->setParams($request, $post);

        $post->save();
        $post->categories()
            ->attach($request->category);
        $post->views()
            ->create();
    }

    public function update(Request $request, Post $post): void
    {
        $this->validate($request, $post);
        $this->setParams($request, $post);

        $post->save();
        $post->categories()
            ->sync($request->category);

        $this->cacheDelete($post->alias);
        $this->cacheClear();
    }

    public function delete(Post $post): void
    {
        $this->cacheDelete($post->alias);
        $this->cacheClear();
        $post->delete();
    }

    public function confirm(int $id): void
    {
        $post = $this->model
            ->withoutGlobalScopes()
            ->inActive()
            ->findOrFail($id);
        $post->status = true;

        $post->save();
        $this->cacheDelete($post->alias);
        $this->cacheClear();
    }

    private function validate(Request $request, Post $post): void
    {
        if ($post['title_' . $this->locale] !== $request->title)
            $request->validate(['title' => 'unique:posts,title_' . $this->locale]);
        if ($this->locale === 'en')
            $post->alias = Str::slug($request->title);
    }

    private function setPost(string $alias): void
    {
        $key = $this->cacheService->localName(self::TAG, $alias);
        $ttl = Carbon::now()->addMinutes(10);

        $this->post = Cache::remember($key, $ttl, function () use ($alias) {
            $post = $this->getByAlias($alias);
            $post->views->touch();

            return $post;
        });
    }

    private function setComments(): void
    {
        $key = $this->cacheService->localName(CommentServiceInterface::TAG, $this->post->id);
        $ttl = Carbon::now()->addMinutes(10);

        $comments = Cache::remember($key, $ttl, function () {
            return $this->post
                ->comments()
                ->with('user')
                ->active()
                ->get();
        });

        $this->commentsCount = $comments->count();
        $this->comments = $comments->groupBy('parent_id');
    }

    private function setRandom(int $limit): void
    {
        $key = $this->cacheService->localName(self::TAG, $this->post->id);
        $ttl = Carbon::now()->addMinutes(5);

        $this->random = Cache::tags(CacheServiceInterface::RANDOM)
            ->remember($key, $ttl, fn() => $this->getRandom($limit));
    }

    private function setParams(Request $request, Post $post): void
    {
        $post['title_' . $this->locale] = $request->title;
        $post['body_' . $this->locale] = $request->body;

        if ($request->file('img'))
            $post['img_' . $this->locale] = Storage::put('images', $request->file('img'));
    }

    private function cacheDelete($val): void
    {
        $this->cacheService->delete(self::TAG, $val);
    }

    private function cacheClear(): void
    {
        $this->cacheService->flush([
            self::TAG,
            CacheServiceInterface::HIT,
            CacheServiceInterface::RANDOM,
        ]);
    }
}
