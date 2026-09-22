<?php

namespace App\Http\Dto\User;

use App\Models\User;

final readonly class UserDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
    ) {}

    public static function fromUser(User $user): static
    {
        return new self(
            id: $user->id,
            name: $user->name,
            email: $user->email,
        );
    }
}
