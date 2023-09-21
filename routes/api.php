<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/users', [\App\Http\Controllers\UserController::class, 'index']);
    Route::get('/users/{user}/posts', [\App\Http\Controllers\UserController::class, 'post']);
    Route::get('/users/{user}/toggle-following', [\App\Http\Controllers\UserController::class, 'toggleFollowing']);
    Route::get('/users/followed-posts', [\App\Http\Controllers\UserController::class, 'followedPosts']);

    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/post-images', [\App\Http\Controllers\PostImageController::class, 'store']);
    Route::post('/posts/{post}/toggle-like', [\App\Http\Controllers\PostController::class, 'toggleLike']);
    Route::post('/posts/{post}/repost', [\App\Http\Controllers\PostController::class, 'repost']);
    Route::post('/posts/{post}/comment', [\App\Http\Controllers\PostController::class, 'comment']);
    Route::get('/posts/{post}/comment', [\App\Http\Controllers\PostController::class, 'commentList']);
});

