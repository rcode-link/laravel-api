<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicPostController;
use App\Http\Middleware\JsonMiddleware;

Route::post('/user/register', RegisterController::class);
Route::post('/login', LoginController::class);

Route::middleware(['auth:sanctum', JsonMiddleware::class])
    ->prefix('/admin')
    ->group(function(){
    Route::apiResource('/posts', PostController::class)->names('admin.posts');
});
Route::middleware(['auth:sanctum', JsonMiddleware::class])
    ->group(function(){
    Route::apiResource('/comment/post', CommentController::class)->names('comments');
    Route::post('/logout', LogoutController::class);
});
Route::get('/posts', [PublicPostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post}', [PublicPostController::class, 'show'])->name('posts.show');
