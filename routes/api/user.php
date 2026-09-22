<?php

use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)
    ->middleware('auth:sanctum')
    ->prefix('/user')->group(function() {
        Route::get('/', 'show');
    });
