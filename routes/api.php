<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\SearchController;
use App\Http\Controllers\API\UploadController;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'throttle:100'], function () {
    Route::get('/search', SearchController::class);
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/categories/{alias}', [CategoryController::class, 'index']);
});

Route::post('/upload', UploadController::class)->middleware('throttle:10');
