<?php

namespace App\Services;

use App\Http\Dto\User\UserDto;
use App\Models\User;

class UserService
{
    public function get(User $user): UserDto
    {
        return UserDto::fromUser($user);
    }
}
