<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    private CategoryServiceInterface $categoryService;
    private CacheServiceInterface $cacheService;

    public function __construct(
        CategoryServiceInterface $categoryService,
        CacheServiceInterface $cacheService,
    ) {
        $this->categoryService = $categoryService;
        $this->cacheService = $cacheService;
    }

    public function index(Request $request, string $alias)
    {
        $page = $request->page ?: 1;
        $key = $this->cacheService->localName(CategoryServiceInterface::TAG, $alias, $page);
        $ttl = Carbon::now()->addHour();

        $posts = Cache::tags(PostServiceInterface::TAG)
            ->remember($key, $ttl, function () use ($alias) {
                $category = $this->categoryService->getByAlias($alias);
                return $this->categoryService->getPosts($category, 20);
            });

        return new PostCollection($posts);
    }
}
