<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private CommentServiceInterface $commentService;
    private UserServiceInterface $userService;

    public function __construct(
        CommentServiceInterface $commentService,
        UserServiceInterface $userService,
    ) {
        $this->commentService = $commentService;
        $this->userService = $userService;
    }

    public function index()
    {
        $comments = $this->userService
            ->getComments(Auth::user(), 10);

        return view('home.comments', ['comments' => $comments]);
    }

    public function store(CommentRequest $request, Post $post)
    {
        $this->commentService->store($request, $post);
        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $this->commentService->delete($comment);

        return back();
    }
}
