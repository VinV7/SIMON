<?php

namespace App\Http\Resources\Api\v1\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    { 
        return [
            'success' => true,
            'message' => 'Authenticated successfully',
            'data' => [
                'admin' => $this->resource['admin'],
                'token' => $this->resource['token']
            ]
        ];
    }
}
