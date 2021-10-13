<?php

namespace App\View\Components;

use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Trending extends Component
{
    private Collection $week;
    private Collection $trending;
    private Collection $interesting;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        PostServiceInterface $postService,
        CategoryServiceInterface $categoryService,
    ) {
        $this->week = $postService->getWeek(4);
        $this->trending = $categoryService->getTrendingPosts(4);
        $this->interesting = $postService->getInteresting(4);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.trending', [
            'week' => $this->week,
            'trending' => $this->trending,
            'interesting' => $this->interesting,
        ]);
    }
}
