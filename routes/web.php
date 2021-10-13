<?php

use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/robots.txt', [SitemapController::class, 'robots']);

if (!App::isLocale('en')) 
    Route::redirect('/', '/' . Config::get('lang'));
else
    Route::redirect('/en', '/');

Route::group(['prefix' => Config::get('lang')], function () {
    Auth::routes(['verify' => true]);

    // Main
    Route::get('/', [PostController::class, 'index'])->name('main');
    Route::get('/contact', [IndexController::class, 'contact'])->name('contact');
    Route::post('/contact', [IndexController::class, 'submit'])->name('contact.submit');
    Route::get('/search', [IndexController::class, 'search'])->name('search');
    Route::get('/category/{alias}', [CategoryController::class, 'show'])->name('category.show');
    Route::post('/comment/{post}', [CommentController::class, 'store'])->name('comment.store');
    Route::get('/sitemap.xml', [SitemapController::class, 'index']);
    Route::get('/privacy', [IndexController::class, 'privacy'])->name('privacy');
    Route::get('/cookies', [IndexController::class, 'cookies'])->name('cookies');
    Route::get('/terms', [IndexController::class, 'terms'])->name('terms');

    // Home
    Route::group(['middleware' => ['auth', 'verified']], function () {
        Route::prefix('home')->name('home.')->group(function () {
            Route::get('/', [HomeController::class, 'index'])->name('index');
            Route::get('/posts', [HomeController::class, 'posts'])->name('posts');
            Route::get('/comments', [CommentController::class, 'index'])->name('comments');
            Route::get('/settings', [HomeController::class, 'settings'])->name('settings');
            Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
        });

        Route::prefix('change')->name('home.')->group(function () {
            Route::match(['get', 'post'], '/email', [HomeController::class, 'updateEmail'])->name('email');
            Route::match(['get', 'post'], '/username', [HomeController::class, 'updateUsername'])->name('username');
            Route::match(['get', 'post'], '/password', [HomeController::class, 'updatePassword'])->name('password');
        });

        // Post
        Route::get('/create', [PostController::class, 'create'])->name('post.create');
        Route::post('/', [PostController::class, 'store'])->name('post.store');
        Route::put('/{post}', [PostController::class, 'update'])->name('post.update');
        Route::delete('/{post}', [PostController::class, 'destroy'])->name('post.destroy');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('post.edit');

        // Admin
        Route::group(['prefix' => 'admin', 'middleware' => 'role'], function () {
            Route::get('/', [AdminHomeController::class, 'index'])->name('admin.dashboard');
            Route::get('/posts', [AdminPostController::class, 'index'])->name('admin.posts');
            Route::put('/posts/{id}/confirm', [AdminPostController::class, 'confirm'])->whereNumber('id')->name('post.confirm');
            Route::put('/comments/{id}/confirm', [AdminCommentController::class, 'confirm'])->name('comments.confirm');
            Route::delete('/posts/{id}', [AdminPostController::class, 'delete'])->whereNumber('id')->name('post.delete');
            Route::get('/cache/clear/{name?}/{key?}', [CacheController::class, 'clear'])->name('cache.clear');
            Route::get('/email/{user}/confirm', [AdminHomeController::class, 'confirmEmail'])->name('confirm.email');
            Route::match(['get', 'post'], '/roles/{role}/add', [RoleController::class, 'add'])->name('roles.add');
            Route::match(['get', 'post'], '/email/{user}/change', [AdminHomeController::class, 'updateEmail'])->name('change.email');
            Route::match(['get', 'post'], '/username/{user}/change', [AdminHomeController::class, 'updateUsername'])->name('change.username');
            Route::match(['get', 'post'], '/password/{user}/change', [AdminHomeController::class, 'updatePassword'])->name('change.password');
            Route::delete('/roles/{user}/user', [RoleController::class, 'delete'])->name('roles.delete');
            Route::resource('categories', AdminCategoryController::class)->except(['show'])->middleware('can:categories');
            Route::resource('permissions', PermissionController::class)->except('show')->middleware('can:permissions');
            Route::resource('comments', AdminCommentController::class)->except(['create', 'store', 'show']);
            Route::resource('users', UserController::class)->except(['create', 'store']);
            Route::resources([
                'roles' => RoleController::class,
                'cache' => CacheController::class
            ]);
        });
    });

    Route::get('/{alias}', [PostController::class, 'show'])->name('post.show');
});
