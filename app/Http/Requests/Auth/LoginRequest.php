<?php

namespace App\Http\Requests\Auth;

use App\Http\Dto\Auth\EmailPasswordLoginDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function toDto(): EmailPasswordLoginDto
    {
        return new EmailPasswordLoginDto(
            email: $this->string('email')->toString(),
            password: $this->string('password')->toString(),
        );
    }
}
