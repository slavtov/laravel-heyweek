<?php

namespace App\Services;

use App\Services\Interfaces\AdminServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class AdminService implements AdminServiceInterface
{
    public Collection $posts;
    public Collection $users;
    public Collection $comments;
    private PostServiceInterface $postService;
    private UserServiceInterface $userService;
    private CommentServiceInterface $commentService;

    public function __construct(
        PostServiceInterface $postService,
        UserServiceInterface $userService,
        CommentServiceInterface $commentService,
    ) {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->commentService = $commentService;
    }

    public function getStatistics(): object
    {
        $this->posts = $this->postService->getAll();
        $this->users = $this->userService->getAll();
        $this->comments = $this->commentService->getAll();

        $post = $user = $comment = [];
        $time = [
            'today' => Carbon::today(),
            'week' => Carbon::now()->subWeek(),
            'month' => Carbon::now()->subMonth(),
            'year' => Carbon::now()->subYear(),
        ];
        $res = [
            [&$post, &$this->posts],
            [&$user, &$this->users],
            [&$comment, &$this->comments],
        ];

        foreach ($time as $key => $val)
            foreach ($res as $el)
                $el[0][$key] = $el[1]
                    ->where('created_at', '>=', $val)
                    ->count();

        return (object) [
            'post' => $post,
            'user' => $user,
            'comment' => $comment,
        ];
    }
}
