<?php

namespace App\Http\Requests\Api\v1\User\Activity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActivitySummaryRequest extends FormRequest
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
            'date' => [Rule::date()->format('Y-m-d')]
        ];
    }

    public function messages(): array
    {
        return [
            'date.date_format' => 'Date format must be YYYY-MM-D'
        ];
    }
}
