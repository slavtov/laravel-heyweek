<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\SearchCollection;
use App\Services\Interfaces\PostServiceInterface;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request, PostServiceInterface $postService)
    {
        if ($request->q) {
            $posts = $postService->getSearchResults($request, 5);
            return new SearchCollection($posts);
        }

        return response()
            ->json(['message' => 'Query was empty'], 403);
    }
}
