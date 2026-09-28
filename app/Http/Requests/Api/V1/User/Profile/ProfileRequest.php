<?php

namespace App\Http\Requests\Api\V1\User\Profile;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'NIK' => ['required', 'integer', 'min:16'],
            'phone_number' => ['required', 'integer', 'max:15'],
            'avatar' => ['required', 'image', 'mimes:jpeg,jpg', 'max:2048']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'NIK.required' => 'NIK is required.',
            'NIK.integer' => 'NIK must be an integer.',
            'NIK.min' => 'NIK must be at least 16 characters long.',
            
            'phone_number.required' => 'Phone number is required.',
            'phone_number.integer' => 'Phone number must be an integer.',
            'phone_number.max' => 'Phone number must not exceed 15 digits.',
            
            'avatar.required' => 'Avatar image is required.',
            'avatar.image' => 'Avatar must be an image.',
            'avatar.mimes' => 'Avatar must be a JPEG or JPG file.',
            'avatar.max' => 'Avatar size must not exceed 2MB.',
        ];
    }
}