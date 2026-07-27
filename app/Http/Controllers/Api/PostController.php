<?php

namespace App\Http\Controllers\Api;

use App\Enums\SortingType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request) 
    {
        $limit = $request->integer('limit', 20);
        $offset = $request->integer('offset', 0);
        $sort = SortingType::tryFrom(
            $request->query('sort', SortingType::default()->value)
        ) ?? SortingType::default();

        $query = Post::query();
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

    public function myPosts(Request $request) 
    {
        $limit = $request->integer('limit', 20);
        $offset = $request->integer('offset', 0);
        $sort = SortingType::tryFrom(
            $request->query('sort', SortingType::default()->value)
        ) ?? SortingType::default();

        $query = $request
            ->user()
            ->posts();
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

    public function show(int $id) 
    {
        return new PostResource(
            Post::findOrFail($id)
        );
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create(
            $request->validated()
        );

        return new PostResource(
            $post
        );
    }
}
