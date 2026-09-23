<?php

namespace App\Http\Resources\Api\v1\User\Activity;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivitySummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => $this[0],
            'longest_activity' => [
                'id' => $this[1]->id,
                'category' => [
                    'id' => $this[1]->category->id,
                    'name' => $this[1]->category->name
                ],
                'description' => $this[1]->description,
                'duration' => $this[1]->started_at->diffInMinutes($this[1]->finished_at)
            ]
        ];
    }
}
