<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        $token = $user->createToken('mobile')->plainTextToken;

        return [
            'access_token' => $token,
        ];
    }

    public function login(Request $request) 
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user === null) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        if (!Hash::check($request->input('password'), $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
        
        $token = $user->createToken('mobile')->plainTextToken;
        return [
            'access_token' => $token,
        ];
    }
}
