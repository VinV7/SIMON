<?php

namespace App\Http\Requests\Api\v1\User\Activity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivityUpdateRequest extends FormRequest
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
            'description' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:activity_categories,id'],
            'started_at' => ['nullable', Rule::date()->format('H:i')],
            'ended_at' => ['nullable', Rule::date()->format('H:i')],
        ];
    }

    public function messages() {
        return [
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'description.max' => 'Description may not be greater than 255 characters',
            'category_id.required' => 'Category ID is required',
            'category_id.integer' => 'Category ID must be an integer',
            'category_id.exists' => 'Selected category does not exist',
            'started_at.date_format' => 'Start time must be in HH:MM format',
            'ended_at.date_format' => 'End time must be in HH:MM format',
        ];
    }
}
