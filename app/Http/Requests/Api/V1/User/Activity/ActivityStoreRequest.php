<?php

namespace App\Http\Requests\Api\V1\User\Activity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ActivityStoreRequest extends FormRequest
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
            'description' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:activity_categories,id'],
            'time_started' => ['required', 'string', 'date_format:H:i'],
            'time_ended' => ['required', 'string', 'date_format:H:i', 'after:time_started'],
        ];
    }

    public function messages() {
        return [
            'description.required' => 'Description is required',
            'category_id.required' => 'Category ID is required',
            'category_id.exists' => 'Category does not exist',
            'time_started.required' => 'Start time is required',
            'time_started.date_format' => 'Start time must be in HH:MM format',
            'time_ended.date_format' => 'End time must be in HH:MM format',
            'time_ended.after' => 'End time must be after start time',
        ];
    }
}