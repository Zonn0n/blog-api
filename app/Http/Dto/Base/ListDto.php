<?php

namespace App\Http\Dto\Base;

readonly class ListDto
{
    public function __construct(
        public int $limit,
        public int $offset,
    )
    {}
}
