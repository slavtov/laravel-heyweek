<?php

namespace App\Services\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Enumerable;

interface UserServiceInterface extends BaseServiceInterface
{
    public function getPosts(User $user, int $qty = null): Paginator;
    public function getPostsWithQuery(Request $request, User $user, int $qty = null): Paginator;
    public function getComments(User $user, int $qty = null): Paginator;
    public function getCommentsWithQuery(Request $request, User $user, int $qty = null): Paginator;
    public function getLatestPosts(User $user, int $limit): Enumerable;
    public function getLatestComments(User $user, int $limit): Enumerable;
    public function getWaitingPosts(User $user): Enumerable;
    public function getByUsername(string $name): Model;
    public function update(Request $request, User $user): void;
    public function updateEmail(Request $request, User $user): void;
    public function updateUsername(Request $request, User $user): void;
    public function updatePassword(Request $request, User $user): void;
    public function delete(User $user): void;
    public function detachRole(Request $request, User $user): void;
    public function confirmEmail(User $user): void;
}
