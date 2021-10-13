<?php

namespace App\Services;

use App\Models\Category;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class CategoryService extends BaseService implements CategoryServiceInterface
{
    private PostServiceInterface $postService;
    private CacheServiceInterface $cacheService;
    private string $locale;

    public function __construct(
        Category $model,
        PostServiceInterface $postService,
        CacheServiceInterface $cacheService,
    ) {
        parent::__construct($model);

        $this->postService = $postService;
        $this->cacheService = $cacheService;
        $this->locale = App::currentLocale();
    }

    public function getAll(): Collection
    {
        return Cache::tags(self::TAG)
            ->rememberForever('index', fn() => $this->model->all());
    }

    public function getPosts(Category $category, int $qty = null): Paginator
    {
        return $category->posts()
            ->with('categories')
            ->latest()
            ->paginate($qty);
    }

    public function getTrendingPosts(int $limit): Collection
    {
        $key = $this->cacheService->localName('trending');
        $ttl = Carbon::now()->addMinute();

        return Cache::tags(CacheServiceInterface::HIT)
            ->remember($key, $ttl, function () use ($limit) {
                $category = $this->model
                    ->inRandomOrder()
                    ->first();

                if ($category) {
                    return $category->posts()
                        ->latest()
                        ->limit($limit)
                        ->get();
                }

                return $this->postService
                    ->getRandom($limit);
            });
    }

    public function getByAlias(string $alias): Category
    {
        return $this->model
            ->findByAlias($alias);
    }

    public function store(Request $request): void
    {
        $category = new Category();

        foreach (Config::get('app.languages') as $lang)
            $category['name_' . $lang] = $request->name;

        $category->alias = Str::slug($request->name);
        $category->color = $request->color;

        $category->save();
        $this->cacheClear();
    }

    public function update(Request $request, Category $category): void
    {
        if ($category['name_' . $this->locale] != $request->name)
            $request->validate(['name' => 'unique:categories,name_' . $this->locale]);

        $category['name_' . $this->locale] = $request->name;
        $category->color = $request->color;

        $category->save();
        $this->cacheClear();
    }

    public function delete(Category $category): void
    {
        $category->delete();
        $this->cacheClear();
    }

    private function cacheClear(): void
    {
        $this->cacheService->flush(self::TAG);
    }
}
