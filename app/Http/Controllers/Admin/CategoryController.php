<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreRequest;
use App\Http\Requests\Admin\Category\UpdateRequest;
use App\Models\Category;
use App\Services\Interfaces\CategoryServiceInterface;

class CategoryController extends Controller
{
    private CategoryServiceInterface $categoryService;

    public function __construct(CategoryServiceInterface $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getPagination();
        return view('home.admin.categories.index', ['categories' => $categories]);
    }

    public function create()
    {
        return view('home.admin.categories.create');
    }

    public function store(StoreRequest $request)
    {
        $this->categoryService->store($request);

        return redirect()
            ->route('categories.index')
            ->with('status', 'The category added successfully!');
    }

    public function edit(Category $category)
    {
        return view('home.admin.categories.edit', ['category' => $category]);
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $this->categoryService->update($request, $category);

        return redirect()
            ->route('categories.index')
            ->with('status', 'The category updated successfully!');
    }

    public function destroy(Category $category)
    {
        $this->categoryService->delete($category);

        return redirect()
            ->route('categories.index');
    }
}
