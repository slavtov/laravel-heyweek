<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\SliderServiceInterface;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private PostServiceInterface $postService;
    private SliderServiceInterface $sliderService;

    public function __construct(
        PostServiceInterface $postService,
        SliderServiceInterface $sliderService,
    ) {
        $this->postService = $postService;
        $this->sliderService = $sliderService;
    }

    public function index(Request $request)
    {
        $posts = $this->postService->getPaginationWithQuery($request, 10);
        $slider = $this->sliderService->getPaginationWithQuery($request, 4);

        return view('home.admin.posts', [
            'posts' => $posts, 
            'slider' => $slider
        ]);
    }

    public function confirm($id)
    {
        $this->authorize('admin');
        $this->postService->confirm((int) $id);

        return redirect()
            ->route('admin.dashboard');
    }

    public function delete($id)
    {
        $this->authorize('admin');

        $post = $this->postService->getOneWithoutScopes((int) $id);
        $this->postService->delete($post);

        return redirect()
            ->route('admin.dashboard');
    }
}
