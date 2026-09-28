<?php

namespace App\Http\Resources\Api\v1\User\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileUpdateResource extends JsonResource
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
            'message' => 'User data updated successfully',
            'data' => [
                'NIK' => $this->NIK,
                'phone_number' => $this->phone_number,
                'image_path' => $this->image_url
            ]
        ];
    }
}
