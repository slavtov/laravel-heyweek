<?php

namespace App\View\Components;

use App\Services\Interfaces\CategoryServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Categories extends Component
{
    private Collection $categories;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categories = $categoryService->getAll();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.categories', ['categories' => $this->categories]);
    }
}
