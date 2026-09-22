<?php

namespace App\Http\Dto\Posts;

use App\Enums\SortingType;
use App\Http\Dto\Base\ListDto;
use Carbon\Carbon;

final readonly class PostListDto extends ListDto
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        int $limit,
        int $offset,
        public SortingType $sort,
        public ?Carbon $dateFrom,
        public ?Carbon $dateTo,
    ) {
        parent::__construct(
            limit: $limit,
            offset: $offset,
        );
    }
}
