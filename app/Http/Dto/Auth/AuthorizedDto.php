<?php

namespace App\Http\Dto\Auth;

use Laravel\Sanctum\NewAccessToken;

final readonly class AuthorizedDto
{
    public function __construct(
        public NewAccessToken $accessToken,
    ) {}
}
