<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Interfaces\CacheServiceInterface;

class CacheController extends Controller
{
    private CacheServiceInterface $cacheService;

    public function __construct(CacheServiceInterface $cacheService)
    {
        $this->middleware('can:cache');
        $this->cacheService = $cacheService;
    }

    public function index()
    {
        return view('home.admin.cache.index', ['data' => $this->cacheService->values()]);
    }

    public function clear($name = null, $key = null)
    {
        if ($name && $key) {
            if (!$this->cacheService->forget($name, $key))
                return back();

            return redirect()
                ->route('cache.index')
                ->with('status', 'Cache is empty! [' . $name . ']');
        }

        $this->cacheService->flush();

        return redirect()
            ->route('cache.index')
            ->with('status', 'Cache is empty!');
    }
}
