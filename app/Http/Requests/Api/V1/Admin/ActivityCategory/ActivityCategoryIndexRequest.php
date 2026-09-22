<?php

namespace App\Http\Requests\Api\V1\Admin\ActivityCategory;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ActivityCategoryIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'orderBy' => ['nullable', 'string'],
            'orderDirection' => ['nullable', 'string', 'in:asc,desc'],
            'keyword' => ['nullable', 'string']
        ];
    }
}