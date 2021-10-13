<?php

namespace App\Http\Controllers;

use App\Http\Requests\Update\EmailRequest;
use App\Http\Requests\Update\PasswordRequest;
use App\Http\Requests\Update\UsernameRequest;
use App\Services\Interfaces\UserServiceInterface;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    private UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $user = Auth::user();

        return view('home.index', [
            'latestPosts' => $this->userService->getLatestPosts($user, 3),
            'latestComments' => $this->userService->getlatestComments($user, 3),
            'qtyPosts' => $user->posts->count(),
            'qtyComments' => $user->comments->count(),
            'waitingPosts' => $this->userService->getWaitingPosts($user),
        ]);
    }

    public function posts()
    {
        $posts = $this->userService->getPosts(Auth::user(), 10);
        return view('home.posts', ['posts' => $posts]);
    }

    public function settings()
    {
        return view('home.settings');
    }

    public function updateEmail(EmailRequest $request)
    {
        if ($request->isMethod('post')) {
            $user = Auth::user();

            $this->userService->updateEmail($request, $user);
            event(new Registered($user));

            return back();
        }

        return view('home.update.email');
    }

    public function updateUsername(UsernameRequest $request)
    {
        if ($request->isMethod('post')) {
            $this->userService->updateUsername($request, Auth::user());

            return redirect()
                ->route('home.settings')
                ->with('status', 'The username changed successfully!');
        }

        return view('home.update.username');
    }

    public function updatePassword(PasswordRequest $request)
    {
        if ($request->isMethod('post')) {
            $user = Auth::user();

            if (Hash::check($request->old_password, $user->password)) {
                $this->userService->updatePassword($request, $user);

                return redirect()
                    ->route('home.settings')
                    ->with('status', 'Password changed successfully!');
            }

            return back()
                ->withErrors('The old password is incorrect');
        }

        return view('home.update.password');
    }
}
