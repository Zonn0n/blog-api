<?php

namespace App\Http\Controllers\Api;

use App\Enums\SortingType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Attributes as OA;

class PostController extends Controller
{
    private const DEFAULT_LIMIT = 20;
    private const MAX_LIMIT = 100;

    private const DEFAULT_OFFSET = 0;

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
    public function index(Request $request) 
    {
        return $this->getPostsCollection(
            Post::query(),
            $request,
        );
    }

    #[OA\Get(
        path: "/my-posts",
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
    public function myPosts(Request $request) 
    {
        return $this->getPostsCollection(
            $request->user()->posts(),
            $request,
        );
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
        return new PostResource(Post::findOrFail($id));
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
        $post = $request->user()->posts()->create(
            $request->validated()
        );

        return new PostResource($post);
    }

    private function getPostsCollection(
        Builder|HasMany $query, 
        Request $request
    ): AnonymousResourceCollection
    {
        $limit = min(
            $request->integer('limit', self::DEFAULT_LIMIT), 
            self::MAX_LIMIT
        );
        $offset = $request->integer('offset', self::DEFAULT_OFFSET);
        $sort = SortingType::tryFrom(
            $request->query('sort', SortingType::default()->value)
        ) ?? SortingType::default();

        if ($request->filled('date_from')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->date('date_from'),
            );
        }

        if ($request->filled('date_to')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->date('date_to'),
            );
        }

        return PostResource::collection(
            $query
                ->orderBy($sort->value)
                ->offset($offset)
                ->limit($limit)
                ->get()
        );
    }
}
