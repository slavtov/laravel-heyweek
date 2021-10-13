<?php

namespace App\Providers;

use App\Http\Resources\SearchResource;
use App\Services\AdminService;
use App\Services\CacheService;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\Interfaces\AdminServiceInterface;
use App\Services\Interfaces\CacheServiceInterface;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\Interfaces\CommentServiceInterface;
use App\Services\Interfaces\PermissionServiceInterface;
use App\Services\Interfaces\PostServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Services\Interfaces\SliderServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\PermissionService;
use App\Services\Post\PostService;
use App\Services\RoleService;
use App\Services\SliderService;
use App\Services\UserService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(PostServiceInterface::class, PostService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(CategoryServiceInterface::class, CategoryService::class);
        $this->app->bind(CommentServiceInterface::class, CommentService::class);
        $this->app->bind(RoleServiceInterface::class, RoleService::class);
        $this->app->bind(PermissionServiceInterface::class, PermissionService::class);
        $this->app->bind(SliderServiceInterface::class, SliderService::class);
        $this->app->bind(AdminServiceInterface::class, AdminService::class);
        $this->app->bind(CacheServiceInterface::class, CacheService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        SearchResource::withoutWrapping();
    }
}
