<?php

namespace App\Http\Dto\Posts;

final readonly class CreatePostDto
{
    public function __construct(
        public string $title,
        public string $text,
    ) {}
}
