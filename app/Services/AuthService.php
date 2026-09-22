<?php

namespace App\Services;

use App\Exceptions\InvalidCredentialsException;
use App\Http\Dto\Auth\AuthorizedDto;
use App\Http\Dto\Auth\EmailPasswordLoginDto;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class AuthService 
{
    /**
     * @throws InvalidCredentialsException
     */
    public function login(EmailPasswordLoginDto $data): AuthorizedDto
    {
        $user = User::where('email', $data->email)->first();
        if ($user === null) {
            throw new InvalidCredentialsException();
        }

        if (!Hash::check($data->password, $user->password)) {
            throw new InvalidCredentialsException();
        }

        $token = $user->createToken('mobile');
        
        return new AuthorizedDto(
            accessToken: $token,
        );
    }
}