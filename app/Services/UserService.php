<?php

namespace App\Services;

use App\Models\User;
use App\Services\Interfaces\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService implements UserServiceInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getPagination(int $qty = null): Paginator
    {
        return $this->model
            ->with('roles')
            ->latest()
            ->paginate($qty);
    }

    public function getByUsername(string $name): User
    {
        return $this->model
            ->findByName($name);
    }

    public function getPosts(User $user, int $qty = null): Paginator
    {
        return $user->posts()
            ->latest()
            ->paginate($qty);
    }

    public function getPostsWithQuery(Request $request, User $user, int $qty = null): Paginator
    {
        return $user->posts()
            ->withQuery($qty, $request->query());
    }

    public function getComments(User $user, int $qty = null): Paginator
    {
        return $user->comments()
            ->with('post')
            ->latest()
            ->paginate($qty);
    }

    public function getCommentsWithQuery(Request $request, User $user, int $qty = null): Paginator
    {
        return $user->comments()
            ->with('post')
            ->latest()
            ->paginate($qty, '*', 'comment')
            ->appends($request->query());
    }

    public function getLatestPosts(User $user, int $limit): Collection
    {
        return $user->posts()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getLatestComments(User $user, int $limit): Collection
    {
        return $user->comments()
            ->with('post')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function getWaitingPosts(User $user): Collection
    {
        return $user->posts()
            ->latestInActive()
            ->get();
    }

    public function update(Request $request, User $user): void
    {
        $this->validate($request, $user);
        $user->update($request->only(['name', 'email']));
    }

    public function updateEmail(Request $request, User $user): void
    {
        $user->email = $request->email;
        $user->email_verified_at = null;
        $user->save();
    }

    public function updateUsername(Request $request, User $user): void
    {
        $user->name = $request->name;
        $user->save();
    }

    public function updatePassword(Request $request, User $user): void
    {
        $user->password = Hash::make($request->password);
        $user->save();
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function detachRole(Request $request, User $user): void
    {
        $user->roles()
            ->detach($request->role);
    }

    public function confirmEmail(User $user): void
    {
        $user->email_verified_at = Carbon::now();
        $user->save();
    }

    private function validate(Request $request, User $user): void
    {
        if ($user->name != $request->name)
            $request->validate(['name' => 'min:2|unique:users']);
        if ($user->email != $request->email)
            $request->validate(['email' => 'email|min:6|unique:users']);
    }
}
