<?php

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CommentService extends BaseService implements CommentServiceInterface
{
    private CacheServiceInterface $cacheService;

    public function __construct(
        Comment $model,
        CacheServiceInterface $cacheService,
    ) {
        parent::__construct($model);
        $this->cacheService = $cacheService;
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->with(['post', 'user'])
            ->latest()
            ->paginate($qty);
    }

    public function getWaiting(int $qty = null): Paginator
    {
        return $this->model
            ->with('user')
            ->inActive()
            ->latest()
            ->paginate($qty);
    }

    public function store(Request $request, Post $post): void
    {
        $parent = $this->model->find($request->parent);

        $comment = new Comment();
        $comment->post_id = $post->id;
        $comment->parent_id = $parent?->id;
        $comment->user_id = Auth::id();
        $comment->lang = App::currentLocale();
        $comment->body = $request->body;

        $comment->save();
        $this->cacheDelete($post->id);
    }

    public function update(Request $request, Comment $comment): void
    {
        $comment->body = $request->body;
        $comment->save();
    }

    public function delete(Comment $comment): void
    {
        $this->cacheDelete($comment->post_id);
        $comment->delete();
    }

    public function confirm(int $id): void
    {
        $comment = $this->model
            ->inActive()
            ->findOrFail($id);
        $comment->status = true;

        $comment->save();
        $this->cacheDelete($comment->post->id);
    }

    private function cacheDelete($val): void
    {
        $this->cacheService->delete(self::TAG, $val);
    }
}
