<?php

namespace App\Http\Dto\Auth;

final readonly class EmailPasswordLoginDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $email,
        public string $password,
    ) {}
}
