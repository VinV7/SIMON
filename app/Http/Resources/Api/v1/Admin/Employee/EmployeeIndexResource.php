<?php

namespace App\Http\Resources\Api\v1\Admin\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $pageData = $this->resource['data']->toArray();

        return [
            'success' => true,
            'message' => 'Employees data returned successfully',
            'count'   => $this->resource['count'],
            'data'    => collect($pageData['data'])->map(function ($item) {
                return [
                    'id'         => $item['id'],
                    'name'       => $item['name'],
                    'email'      => $item['email'],
                    'address'    => $item['address'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ];
            }),
            'links'   => [
                'first' => $pageData['first_page_url'],
                'last'  => $pageData['last_page_url'],
                'prev'  => $pageData['prev_page_url'],
                'next'  => $pageData['next_page_url'],
            ],
            'meta'    => [
                'current_page' => $pageData['current_page'],
                'from'         => $pageData['from'],
                'links'        => collect($pageData['links'])->map(function ($item) {
                    return [
                        'url'    => $item['url'],
                        'label'  => $item['label'],
                        'active' => $item['active'],
                    ];
                }),
                'last_page'    => $pageData['last_page'],
                'path'         => $pageData['path'],
                'per_page'     => $pageData['per_page'],
                'to'           => $pageData['to'],
                'total'        => $pageData['total'],
            ],
        ];
    }
}
