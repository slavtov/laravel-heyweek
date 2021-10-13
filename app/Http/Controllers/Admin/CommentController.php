<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Services\Interfaces\CommentServiceInterface;

class CommentController extends Controller
{
    private CommentServiceInterface $commentService;

    function __construct(CommentServiceInterface $commentService)
    {
        $this->commentService = $commentService;
    }

    public function index()
    {
        return view('home.admin.comments.index', [
            'comments' => $this->commentService->getPagination(), 
            'waitingComments' => $this->commentService->getWaiting(5),
        ]);
    }

    public function edit(Comment $comment)
    {
        $this->authorize('update-comments');
        return view('home.admin.comments.edit', ['comment' => $comment]);
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $this->authorize('update-comments');
        $this->commentService->update($request, $comment);

        return redirect()
            ->route('comments.index')
            ->with('status', 'The comment updated successfully!');
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete-comments');
        $this->commentService->delete($comment);

        return redirect()
            ->route('comments.index');
    }

    public function confirm($id)
    {
        $this->authorize('update-comments');
        $this->commentService->confirm((int) $id);

        return redirect()
            ->route('comments.index');
    }
}
