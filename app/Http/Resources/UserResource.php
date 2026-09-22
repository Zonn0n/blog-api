<?php

namespace App\Http\Resources;

use App\Http\Dto\User\UserDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property UserDto $resource
 */
#[OA\Schema(
    type: "object",
    schema: "UserResource",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            description: "ID пользователя",
        ),
        new OA\Property(
            property: "name",
            type: "string",
            description: "Имя пользователя",
        ),
        new OA\Property(
            property: "email",
            type: "string",
            description: "Email пользователя",
        ),
    ],
)]
class UserResource extends JsonResource 
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
            'name' => $this->resource->name,
            'email' => $this->resource->email,
        ];
    }
}