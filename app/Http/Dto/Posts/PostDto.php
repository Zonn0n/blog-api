<?php

namespace App\Http\Dto\Posts;

use App\Models\Post;
use Carbon\Carbon;

final readonly class PostDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $text,
        public Carbon $createdAt,
    )
    {}

    public static function fromPost(Post $post) : static
    {
        return new self(
            id: $post->id,
            title: $post->title,
            text: $post->text,
            createdAt: $post->created_at,
        );
    }
}
