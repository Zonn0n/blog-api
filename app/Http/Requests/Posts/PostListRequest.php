<?php

namespace App\Http\Requests\Posts;

use App\Enums\SortingType;
use App\Http\Dto\Posts\PostListDto;
use App\Http\Requests\ApiListRequest;
use Illuminate\Validation\Rule;

class PostListRequest extends ApiListRequest
{
    public function rules(): array
    {
        return [
            ...parent::rules(),
            'sort' => [
                'sometimes',
                Rule::enum(SortingType::class),
            ],
            'date_from' => [
                'sometimes',
                'date',
            ],
            'date_to' => [
                'sometimes',
                'date',
                'after_or_equal:date_from',
            ],
        ];
    }

    public function toDto(): PostListDto
    {
        $baseDto = $this->toBaseDto();

        return new PostListDto(
            limit: $baseDto->limit,
            offset: $baseDto->offset,
            sort: SortingType::tryFrom(
                $this->input('sort')
            ) ?? SortingType::default(),
            dateFrom: $this->date('date_from'),
            dateTo: $this->date('date_to'),
        );
    }
}
