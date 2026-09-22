<?php

namespace App\Http\Resources\Api\v1\User\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityShowResource extends JsonResource
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
            'description' => $this->description,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name,
                'description' => $this->category->description
            ],
            'duration' => $this->started_at->diffInMinutes($this->finished_at),
            'started_at' => $this->started_at,
            'ended_at' => $this->finished_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
