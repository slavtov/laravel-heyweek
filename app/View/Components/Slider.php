<?php

namespace App\View\Components;

use App\Services\Interfaces\SliderServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Slider extends Component
{
    private Collection $slider;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(SliderServiceInterface $sliderService)
    {
        $this->slider = $sliderService->getAll();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.slider', ['slider' => $this->slider]);
    }
}
