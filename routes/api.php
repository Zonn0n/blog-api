<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', [PostController::class, 'index']);

Route::get('/my-posts', [PostController::class, 'myPosts'])
    ->middleware('auth:sanctum');

Route::get('/posts/{id}', [PostController::class, 'show']);

Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
