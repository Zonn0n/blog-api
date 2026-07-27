<?php

namespace App\Http\Controllers\Api;

use App\Enums\SortingType;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
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

        return Post::query()
            ->orderBy($sort->value)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function myPosts(Request $request) 
    {
        $limit = $request->integer('limit', 20);
        $offset = $request->integer('offset', 0);
        $sort = SortingType::tryFrom(
            $request->query('sort', SortingType::default()->value)
        ) ?? SortingType::default();

        return $request->user()
            ->posts()
            ->orderBy($sort->value)
            ->offset($offset)
            ->limit($limit)
            ->get();
    }

    public function show(int $id) 
    {
        return Post::findOrFail($id);
    }

    public function store(StorePostRequest $request)
    {
        $post = $request->user()->posts()->create(
            $request->validated()
        );

        return $post;
    }
}
