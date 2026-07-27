<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\AuthService;
use Hash;

class AuthController extends Controller
{
    public function register(RegisterRequest $request) 
    {    
        $user = User::create($request->validated());
        $token = $user->createToken('mobile')->plainTextToken;

        return [
            'access_token' => $token,
        ];
    }

    public function login(
        LoginRequest $request, 
        AuthService $authService
    ) {
        return $authService->login($request->validated());
    }
}
