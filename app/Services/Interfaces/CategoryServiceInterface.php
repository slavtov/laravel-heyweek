<?php

namespace App\Services\Interfaces;

use App\Models\Category;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Enumerable;

interface CategoryServiceInterface extends BaseServiceInterface
{
    public const TAG = 'categories';

    public function getPosts(Category $category, int $qty = null): Paginator;
    public function getTrendingPosts(int $limit): Enumerable;
    public function getByAlias(string $alias): Model;
    public function store(Request $request): void;
    public function update(Request $request, Category $category): void;
    public function delete(Category $category): void;
}
