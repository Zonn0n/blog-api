<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService 
{
    public function register(array $data): array 
    {
        $user  = User::create($data);
        
        return [
            'access_token' => $$user->createToken('mobile')->plainTextToken,
        ];
    } 

    /**
     * @throws InvalidCredentialsException
     */
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();
        if ($user === null) {
            throw new InvalidCredentialsException();
        }

        if (!Hash::check($data['password'], $user->password)) {
            throw new InvalidCredentialsException();
        }
        
        return [
            'access_token' => $$user->createToken('mobile')->plainTextToken,
        ];
    }
}