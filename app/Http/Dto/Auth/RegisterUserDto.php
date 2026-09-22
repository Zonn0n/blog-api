<?php

namespace App\Http\Dto\Auth;

final readonly class RegisterUserDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
    ) {}
}
