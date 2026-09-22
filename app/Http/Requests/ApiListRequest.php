<?php

namespace App\Http\Requests;

use App\Http\Dto\Base\ListDto;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiListRequest extends FormRequest
{
    protected const DEFAULT_LIMIT = 20;
    protected const MAX_LIMIT = 100;
    protected const DEFAULT_OFFSET = 0;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'limit' => [
                'sometimes',
                'integer',
                'min:1',
                'max:' . static::MAX_LIMIT,
            ],
            'offset' => [
                'sometimes',
                'integer',
                'min:0',
            ],
        ];
    }

    public function toBaseDto(): ListDto
    {
        return new ListDto(
            limit: $this->integer('limit', static::DEFAULT_LIMIT),
            offset: $this->integer('offset', static::DEFAULT_OFFSET),
        );
    }
}
