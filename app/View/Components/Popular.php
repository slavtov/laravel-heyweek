<?php

namespace App\View\Components;

use App\Services\Interfaces\PostServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Popular extends Component
{
    private Collection $posts;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(PostServiceInterface $postService)
    {
        $this->posts = $postService->getPopular(Carbon::today(), 5);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.popular', ['posts' => $this->posts]);
    }
}
