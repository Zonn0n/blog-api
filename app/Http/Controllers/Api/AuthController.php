<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {}

    #[OA\Post(
        path: "/register",
        summary: "Регистрация пользователя",
        tags: ["Registration"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password"],
                properties: [
                    new OA\Property(
                        property: 'name',
                        type: 'string',
                        example: 'Акакий',
                    ),
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
    public function register(RegisterRequest $request) 
    {    
        return $this->authService->register($request->validated());
    }

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
    public function login(LoginRequest $request) {
        return $this->authService->login($request->validated());
    }
}
