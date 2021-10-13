<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\CategoryServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function show(string $alias, CategoryServiceInterface $categoryService)
    {
        $category = Cache::tags(CategoryServiceInterface::TAG)
            ->remember(
                $alias,
                Carbon::now()->addDay(),
                fn() => $categoryService->getByAlias($alias),
            );

        return view('category.show', ['category' => $category]);
    }
}
