<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Support\Facades\Route;

Route::controller(PostController::class)
    ->group(function() {
        Route::get('/posts', [PostController::class, 'index']);

        Route::get('/posts/{id}', [PostController::class, 'show']);

        Route::get('/my-posts', [PostController::class, 'myPosts'])
            ->middleware('auth:sanctum');

        Route::post('/posts', [PostController::class, 'store'])
            ->middleware('auth:sanctum');
    });
