<?php

namespace App\Http\Resources\Api\v1\User\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityUpdateResource extends JsonResource
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
            'message' => 'Activity data created successfully',
            'data' => [
                'id' => $this->id,
                'description' => $this->description,
                'category' => [
                    'id' => $this->category->id,
                    'name' => $this->category->name
                ],
                'duration' => $this->started_at->diffInMinutes($this->finished_at),
                'started_at' => $this->started_at,
                'finished_at' => $this->finished_at,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at
            ],
        ];
    }
}
