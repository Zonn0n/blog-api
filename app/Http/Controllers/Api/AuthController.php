<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthorizedResource;
use App\Services\AuthService;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    #[OA\Post(
        path: "/login",
        summary: "Логин",
        tags: ["Login"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(
                        property: 'email',
                        type: 'string',
                        example: 'email@mail.ru',
                    ),
                    new OA\Property(
                        property: 'password',
                        type: 'string',
                        example: '123456',
                    ),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пользователь зарегистрирован',
                content: new OA\JsonContent(properties: [new OA\Property(property: 'access_token', type: 'string')]),
            ),
            new OA\Response(
                response: 422,
                description: 'Ошибка валидации',
            ),
        ],
    )]
    public function login(LoginRequest $request): AuthorizedResource
    {
        $authorizedDto = $this->authService->login(
            $request->toDto(),
        );
        return AuthorizedResource::make($authorizedDto);
    }
}
