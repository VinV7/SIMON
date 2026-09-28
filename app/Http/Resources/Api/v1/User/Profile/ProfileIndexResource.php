<?php

namespace App\Http\Resources\Api\v1\User\Profile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileIndexResource extends JsonResource
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
            'message' => 'User profile data retrieved successfully',
            'data' => [
                'NIK' => $this->NIK,
                'phoneNumber' => $this->phone_number,
                'imageUrl' => $this->image_path,
                'address' => $this->address
            ]
        ];
    }
}
