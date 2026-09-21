<?php

namespace App\Http\Requests\Api\V1\Admin\Employee;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ];
    }

    public function messages() {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'address.required' => 'Address is required',
            'name.max' => 'Name must not exceed 255 characters',
            'email.max' => 'Email must not exceed 255 characters',
            'address.max' => 'Address must not exceed 255 characters',
        ];
    }
}
