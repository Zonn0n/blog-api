<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Client\Request;
use OpenApi\Attributes as OA;

class UserController extends Controller 
{
    #[OA\Get(
        path: '/user/{id}',
        summary: "Данные пользователя",
        tags: ["User"],
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
    public function show(Request $request) {
        $user = $request->user();
        return new UserResource($user);
    }
}
