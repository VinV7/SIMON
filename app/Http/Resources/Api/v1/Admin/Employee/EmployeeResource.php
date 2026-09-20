<?php

namespace App\Http\Resources\Api\v1\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
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
            'message' => 'Employees data returned successfully',
            'count'   => $this->resource['count'],
            'data'    => $this->resource['data']->map(function ($item) {
                return [
                    'id'         => $item->id,
                    'name'       => $item->name,
                    'email'      => $item->email,
                    'address'    => $item->address,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                ];
            })
        ];
    }
}
