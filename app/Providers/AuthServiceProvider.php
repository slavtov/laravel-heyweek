<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Post;
use App\Policies\CommentPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Comment::class => CommentPolicy::class,
    ];

    protected $permissions = [
        // Actions
        'update-posts',
        'delete-posts',
        'update-users',
        'delete-users',
        'update-comments',
        'delete-comments',

        // Views
        'users',
        'categories',
        'cache',
        'roles',
        'permissions',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach ($this->permissions as $val)
            Gate::define($val, fn($user) => $user->permission($val));

        // Group
        Gate::define('admin', fn($user) => $user->isAdmin());
        Gate::define('all', fn($user) => $user->isCreator());
    }
}
