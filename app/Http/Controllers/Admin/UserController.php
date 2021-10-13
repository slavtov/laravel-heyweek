<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getPagination(10);
        return view('home.admin.users.index', ['users' => $users]);
    }

    public function show(Request $request, User $user)
    {
        $this->authorize('update-users');

        $userPosts = $this->userService->getPostsWithQuery($request, $user, 5);
        $userComments = $this->userService->getCommentsWithQuery($request, $user, 5);

        return view('home.admin.users.show', [
            'user' => $user,
            'posts' => $userPosts,
            'comments' => $userComments,
        ]);
    }

    public function edit(User $user)
    {
        $this->authorize('update-users');
        return view('home.admin.users.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update-users');
        $this->userService->update($request, $user);

        return back()
            ->with('status', 'The user updated successfully!');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete-users');
        $this->userService->delete($user);

        return redirect()
            ->route('users.index');
    }
}
