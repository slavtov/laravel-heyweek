<?php

namespace App\Services\Interfaces;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;

interface CommentServiceInterface extends BaseServiceInterface
{
    public const TAG = 'comments';

    public function getWaiting(int $qty = null): Paginator;
    public function store(Request $request, Post $post): void;
    public function update(Request $request, Comment $comment): void;
    public function delete(Comment $comment): void;
    public function confirm(int $id): void;
}
