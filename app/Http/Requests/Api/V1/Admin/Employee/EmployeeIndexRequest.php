<?php

namespace App\Http\Requests\Api\V1\Admin\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeIndexRequest extends FormRequest
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
            'keyword' => ['nullable', 'string', 'max:255'],
            'orderBy' => ['nullable', Rule::in(['name', 'email', 'address'])],
            'orderDirection' => ['nullable', Rule::in(['asc', 'desc'])]
        ];
    }

    public function messages(): array
    {
        return [
            'keyword.max' => 'The keyword may not be greater than 255 characters.',
            'orderBy.in' => 'The order by must be one of the following values: name, email, address.',
            'orderDirection.in' => 'The order direction must be one of the following values: asc, desc.'
        ];
    }
}
