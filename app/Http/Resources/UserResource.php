<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

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
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'is_admin' => $this->is_admin,
        ];
    }
}