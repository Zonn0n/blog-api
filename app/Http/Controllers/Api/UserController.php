<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller 
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    #[OA\Get(
        path: '/user',
        summary: "Данные пользователя",
        tags: ["User"],
        security: [
            ['sanctum' => []]
        ],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Ответ",
                content: new OA\JsonContent(
                    type: "object", 
                    ref: '#/components/schemas/UserResource',
                ),
            ),
            new OA\Response(
                response: 401,
                description: "Пользователь не авторизован",
            ),
        ]
    )]
    public function show(Request $request) 
    {
        $user = $this->userService->get(
            $request->user(),
        );
        return [
            'user' => new UserResource($user),
        ];
    }
}
