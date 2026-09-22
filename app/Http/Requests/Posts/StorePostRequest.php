<?php

namespace App\Http\Requests\Posts;

use App\Http\Dto\Posts\CreatePostDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'text' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }
    public function toDto(): CreatePostDto
    {
        return new CreatePostDto(
            title: $this->string('title')->toString(),
            text: $this->string('text')->toString(),
        );
    }
}
