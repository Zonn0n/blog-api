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

class PostController extends Controller
{
    private const DEFAULT_LIMIT = 20;
    private const MAX_LIMIT = 100;

    private const DEFAULT_OFFSET = 0;

    public function index(Request $request) 
    {
        return $this->getPostsCollection(
            Post::query(),
            $request,
        );
    }

    public function myPosts(Request $request) 
    {
        return $this->getPostsCollection(
            $request->user()->posts(),
            $request,
        );
    }

    public function show(int $id) 
    {
        return new PostResource(Post::findOrFail($id));
    }

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
