<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this['token'],
            'token_type' => 'bearer',
//            'expires_in' => auth('jwt-guard')->factory()->getTTL() * 60
        ];
    }
}
