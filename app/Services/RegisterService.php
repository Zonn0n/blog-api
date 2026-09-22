<?php

namespace App\Services;

use App\Http\Dto\Auth\RegisterUserDto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final class RegisterService
{
    /**
     * @return array{access_token: string}
     */
    public function register(RegisterUserDto $data): array 
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data->name,
                'email' => $data->email,
                'password' => $data->password,
            ]);

            return [
                'access_token' => $user
                    ->createToken('mobile')
                    ->plainTextToken,
            ];
        });
    } 
}
