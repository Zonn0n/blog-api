<?php

namespace App\Services;

use App\Http\Dto\Posts\CreatePostDto;
use App\Http\Dto\Posts\PostDto;
use App\Http\Dto\Posts\PostListDto;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class PostService
{
    /**
     * @return array<PostDto>
     */
    public function list(PostListDto $data): array
    {
        return  $this->getPosts(
            Post::query(),
            $data,
        );    
    }

    /**
     * @return array<PostDto>
     */
    public function listForUser(User $user, PostListDto $data): array
    {
        return $this->getPosts(
            $user->posts()->getQuery(),
            $data,
        );
    }

    public function get(int $id): PostDto
    {
        $post = Post::findOrFail($id);

        return PostDto::fromPost($post);
    }

    public function create(User $user, CreatePostDto $data): PostDto
    {
        $post = $user->posts()->create([
            'title' => $data->title,
            'text' => $data->text,
        ]);

        return PostDto::fromPost($post);
    }

    /**
     * @return array<PostDto>
     */
    private function getPosts(
        Builder $query, 
        PostListDto $data,
    ): array
    {
        if ($data->dateFrom !== null) {
            $query->whereDate(
                'created_at',
                '>=',
                $data->dateFrom,
            );
        }
        if ($data->dateTo !== null) {
            $query->whereDate(
                'created_at',
                '<=',
                $data->dateTo,
            );
        }

        $query = $query
            ->orderBy($data->sort->value)
            ->offset($data->offset)
            ->limit($data->limit);

        $posts = $query->get()
            ->map(fn(Post $post) => PostDto::fromPost($post))
            ->all();

        return $posts;
    }
}