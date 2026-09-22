<?php

namespace App\Http\Resources;

use App\Http\Dto\Auth\AuthorizedDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property AuthorizedDto $resource
 */
class AuthorizedResource extends JsonResource
{
    public static $wrap = null;

    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource->accessToken->plainTextToken,
        ];
    }
}
