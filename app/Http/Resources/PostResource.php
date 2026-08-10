<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    type: "object",
    schema: "PostResource",
    required: ['id', 'title', 'text'],
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
            'id' => $this->id,
            'title' => $this->title,
            'text' => $this->text,
            'created_at' => $this->created_at,
        ];
    }
}
