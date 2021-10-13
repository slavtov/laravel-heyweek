<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    private PostServiceInterface $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    public function index()
    {
        $posts = Cache::tags(PostServiceInterface::TAG)
            ->remember(
                App::currentLocale(),
                Carbon::now()->addMinute(),
                fn() => $this->postService->getAll(),
            );

        return response()
            ->view('sitemap.index', ['posts' => $posts])
            ->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        return response()
            ->view('sitemap.robots')
            ->header('Content-Type', 'text/plain');
    }
}
