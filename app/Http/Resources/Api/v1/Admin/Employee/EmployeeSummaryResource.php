<?php

namespace App\Http\Resources\Api\v1\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeSummaryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_employees' => $this[0],
            'total_active_employees' => $this[1],
            'active_employees' => $this[2],
            'passive_employees' => $this[3]
        ];
    }
}
