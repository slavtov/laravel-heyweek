<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Models\Post;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    private PostServiceInterface $postService;
    private CategoryServiceInterface $categoryService;

    public function __construct(
        PostServiceInterface $postService,
        CategoryServiceInterface $categoryService,
    ) {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('posts.index');
    }

    public function create()
    {
        $categories = $this->categoryService->getAll();
        return view('posts.create', ['categories' => $categories]);
    }

    public function store(StoreRequest $request)
    {
        $this->postService->store($request);

        return redirect()
            ->route('home.index')
            ->with('status', 'The post added successfully! Wait check');
    }

    public function show(string $alias)
    {
        $this->postService->setOne($alias);

        return view('posts.show', [
            'post' => $this->postService->post,
            'comments' => $this->postService->comments,
            'commentsCount' => $this->postService->commentsCount,
            'randomPosts' => $this->postService->random,
        ]);
    }

    public function edit($id)
    {
        $post = $this->postService->getOneWithoutScopes((int) $id);

        if (Gate::none(['update', 'update-posts'], $post))
            abort(403);

        return view('posts.edit', [
            'post' => $post,
            'categories' => $this->categoryService->getAll(),
        ]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $post = $this->postService->getOneWithoutScopes((int) $id);

        if (Gate::none(['update', 'update-posts'], $post))
            abort(403);

        $this->postService->update($request, $post);

        return back()
            ->with('status', 'The post is updated successfully!');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $this->postService->delete($post);

        return redirect()
            ->route('main');
    }
}
