<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    private PostServiceInterface $postService;
    private CacheServiceInterface $cacheService;

    public function __construct(
        PostServiceInterface $postService,
        CacheServiceInterface $cacheService,
    ) {
        $this->postService = $postService;
        $this->cacheService = $cacheService;
    }

    public function index(Request $request)
    {
        $page = $request->page ?: 1;
        $key = $this->cacheService->localName($page);
        $ttl = Carbon::now()->addMinutes(5);

        $posts = Cache::tags(PostServiceInterface::TAG)
            ->remember($key, $ttl, function () {
                return $this->postService->getPagination();
            });

        return new PostCollection($posts);
    }
}
