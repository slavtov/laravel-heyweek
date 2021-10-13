<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Update\PasswordRequest;
use App\Http\Requests\Update\EmailRequest;
use App\Http\Requests\Update\UsernameRequest;
use App\Models\User;
use App\Services\Interfaces\AdminServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;

class HomeController extends Controller
{
    private AdminServiceInterface $adminService;
    private UserServiceInterface $userService;
    private PostServiceInterface $postService;
    private CategoryServiceInterface $categoryService;

    public function __construct(
        AdminServiceInterface $adminService,
        UserServiceInterface $userService,
        PostServiceInterface $postService,
        CategoryServiceInterface $categoryService,
    ) {
        $this->adminService = $adminService;
        $this->userService = $userService;
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $statistics = $this->adminService->getStatistics();

        return view('home.admin.index', [
            'posts' => $this->adminService->posts,
            'users' => $this->adminService->users,
            'categories' => $this->categoryService->getAll(),
            'comments' => $this->adminService->comments,
            'leaderboard' => $this->postService->getLeaderboard(Carbon::today()),
            'waitingPosts' => $this->postService->getWaiting(5),
            'datePost' => $statistics->post,
            'dateUser' => $statistics->user,
            'dateComment' => $statistics->comment,
        ]);
    }

    public function updateEmail(EmailRequest $request, User $user)
    {
        $this->authorize('update-users');

        if ($request->isMethod('post')) {
            $this->userService->updateEmail($request, $user);
            event(new Registered($user));

            return redirect()
                ->route('users.show', $user->id)
                ->with('status', 'The email changed successfully!');
        }

        return view('home.admin.users.update.email', ['user' => $user]);
    }

    public function updateUsername(UsernameRequest $request, User $user)
    {
        $this->authorize('update-users');

        if ($request->isMethod('post')) {
            $this->userService->updateUsername($request, $user);

            return redirect()
                ->route('users.show', $user->id)
                ->with('status', 'The username changed successfully!');
        }

        return view('home.admin.users.update.username', ['user' => $user]);
    }

    public function updatePassword(PasswordRequest $request, User $user)
    {
        $this->authorize('update-users');

        if ($request->isMethod('post')) {
            $this->userService->updatePassword($request, $user);

            return redirect()
                ->route('users.show', $user->id)
                ->with('status', 'Password changed successfully!');
        }

        return view('home.admin.users.update.password', ['user' => $user]);
    }

    public function confirmEmail(User $user)
    {
        $this->authorize('update-users');
        $this->userService->confirmEmail($user);

        return back();
    }
}
