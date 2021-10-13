<?php

namespace App\Services\Interfaces;

use App\Models\Post;
use Carbon\CarbonInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Enumerable;

interface PostServiceInterface extends BaseServiceInterface
{
    public const TAG = 'posts';

    public function getPaginationWithQuery(Request $request, int $qty = null): Paginator;
    public function getSearchPagination(Request $request, int $qty = null): Paginator;
    public function getSearchResults(Request $request, int $limit): Enumerable;
    public function getWaiting(int $qty = null): Paginator;
    public function getRandom(int $limit): Enumerable;
    public function getLeaderboard(CarbonInterface $date): Enumerable;
    public function getPopular(CarbonInterface $date, int $limit): Enumerable;
    public function getWeek(int $limit): Enumerable;
    public function getInteresting(int $limit): Enumerable;
    public function getByAlias(string $alias): Model;
    public function getOneWithoutScopes(int $id): Model;
    public function setOne(string $alias): void;
    public function store(Request $request): void;
    public function update(Request $request, Post $post): void;
    public function delete(Post $post): void;
    public function confirm(int $id): void;
}
