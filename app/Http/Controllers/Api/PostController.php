<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Posts\PostListRequest;
use App\Http\Requests\Posts\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use OpenApi\Attributes as OA;

class PostController extends Controller
{    public function __construct(
        private readonly PostService $postService
    ) {}

    #[OA\Get(
        path: "/posts",
        summary: "Список постов",
        tags: ["Posts"],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Ответ",
                content: new OA\JsonContent(
                    type: "array", 
                    items: new OA\Items(ref: "#/components/schemas/PostResource")
                ),
            ),
        ]
    )]
    public function index(PostListRequest $request) 
    {
        $posts = $this->postService->list($request->toDto());
        return [
            'posts' => PostResource::collection($posts)
        ];
    }

    #[OA\Get(
        path: "/my-posts",
        summary: "Список постов",
        tags: ["Posts"],
        security: [
            ['sanctum' => []]
        ],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Ответ",
                content: new OA\JsonContent(
                    type: "array", 
                    items: new OA\Items(ref: "#/components/schemas/PostResource")
                ),
            ),
        ]
    )]
    public function myPosts(PostListRequest $request) 
    {

        $posts = $this->postService->listForUser(
            $request->user(), 
            $request->toDto(),
        );

        return [
            'posts' => PostResource::collection($posts)
        ];
    }

    #[OA\Get(
        path: "/posts/{id}",
        summary: "Детали поста",
        tags: ["Posts"],
        parameters: [
            new OA\Parameter(
                name: "id",
                required: true,
                schema: new OA\Schema(type: "integer"),
                description: "ID поста",
                in: "path",
            ),
        ],
        responses: [
            new OA\Response(
                response: 200, 
                description: "Ответ",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/PostResource",
                )
            ),
        ],
    )]
    public function show(int $id) 
    {
        $post = $this->postService->get($id);

        return [
            'post' => PostResource::make($post),
        ];
    }

    #[OA\Post(
        path: "/posts",
        summary: "Создание поста",
        tags: ["Posts"],
        security: [
            ['sanctum' => []],
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['title', 'text'],
                properties: [
                    new OA\Property(
                        property: 'title',
                        type: 'string',
                        example: 'Мой новый пост',
                    ),
                    new OA\Property(
                        property: 'text',
                        type: 'string',
                        example: 'Текст моего нового поста',
                    ),
                ],
            ),
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пост создан',
                content: new OA\JsonContent(
                    ref: '#/components/schemas/PostResource',
                ),
            ),
            new OA\Response(
                response: 401,
                description: 'Не авторизован',
            ),
            new OA\Response(
                response: 422,
                description: 'Ошибка валидации',
            ),
        ],
    )]
    public function store(StorePostRequest $request)
    {
        $post = $this->postService->create(
            $request->user(), 
            $request->toDto(),
        );

        return [
            'post' => PostResource::make($post),
        ];
    }
}
