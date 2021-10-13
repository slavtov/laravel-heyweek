<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Models\PostView;
use App\Services\Interfaces\CacheServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class PostViewService
{
    private string $viewsName;
    private string $viewsNowName;
    private string $viewsTodayName;
    private string $weeklyViewsName;
    private Post $post;
    private PostView $postViews;
    private CacheServiceInterface $cacheService;

    public function __construct(
        Post $post,
        CacheServiceInterface $cacheService,
    ) {
        $this->post = $post;
        $this->postViews = $post->views;
        $this->cacheService = $cacheService;
    }

    public function addViews(): void
    {
        $limit = rand(11, 20);

        $this->cacheKeys();
        $this->addView($limit);
        $this->addViewToday($limit);
        $this->addWeeklyView($limit);
    }

    private function getViews(): string
    {
        return $this->cacheService
            ->value($this->viewsName, 0, Carbon::now()->addMonth());
    }

    private function getViewsToday(): string
    {
        return $this->cacheService
            ->value($this->viewsTodayName, 0, Carbon::now()->addDay());
    }

    private function getWeeklyViews(): string
    {
        return $this->cacheService
            ->value($this->weeklyViewsName, 0, Carbon::now()->addWeek());
    }

    private function resetViewsToday(): void
    {
        $this->postViews->refresh();
        $this->postViews->today = 0;
        $this->postViews->save();
    }

    private function resetWeeklyViews(): void
    {
        $this->postViews->refresh();
        $this->postViews->week = 0;
        $this->postViews->save();
    }

    private function addView(int $limit): void
    {
        $views = $this->getViews();
        $this->cacheService
            ->value($this->viewsNowName, $this->postViews->all, 600);

        if ($views >= $limit) {
            $this->postViews->increment('all', $views);

            Cache::increment($this->viewsNowName, $views);
            Cache::forget($this->viewsName);
        }

        Cache::increment($this->viewsName);
    }

    private function addViewToday(int $limit): void
    {
        if ($this->postViews->updated_at >= Carbon::today()) {
            $viewsToday = $this->getViewsToday();

            if ($viewsToday >= $limit) {
                $this->postViews->increment('today', $viewsToday);
                Cache::forget($this->viewsTodayName);
            }

            Cache::increment($this->viewsTodayName);
        } else {
            $this->resetViewsToday();
        }
    }

    private function addWeeklyView(int $limit): void
    {
        if ($this->postViews->updated_at >= Carbon::now()->startOfWeek()) {
            $weeklyViews = $this->getWeeklyViews();

            if ($weeklyViews >= $limit) {
                $this->postViews->increment('week', $weeklyViews);
                Cache::forget($this->weeklyViewsName);
            }

            Cache::increment($this->weeklyViewsName);
        } else {
            $this->resetWeeklyViews();
        }
    }

    private function cacheKeys(): void
    {
        $this->viewsName = $this->cacheService
            ->name('views', 'all', $this->post->id);
        $this->viewsNowName = $this->cacheService
            ->name('views', 'now', $this->post->id);
        $this->viewsTodayName = $this->cacheService
            ->name('views', 'today', $this->post->id);
        $this->weeklyViewsName = $this->cacheService
            ->name('views', 'week', $this->post->id);
    }
}
