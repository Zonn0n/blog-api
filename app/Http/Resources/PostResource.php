<?php

namespace App\Http\Resources;

use App\Http\Dto\Posts\PostDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property PostDto $resource
 */
#[OA\Schema(
    type: "object",
    schema: "PostResource",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            description: "ID поста",
        ),
        new OA\Property(
            property: "title",
            type: "string",
            description: "Название поста",
        ),
        new OA\Property(
            property: "text",
            type: "string",
            description: "Текст поста",
        ),
        new OA\Property(
            property: "created_at",
            type: "string",
            description: "Дата создания",
        ),
    ],
)]
class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'text' => $this->resource->text,
            'created_at' => $this->resource->createdAt->toDateTimeString(),
        ];
    }
}
