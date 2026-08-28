<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:255'],
            'province' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'birth_date' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'education' => ['nullable', 'string', 'max:5000'],
            'skills' => ['nullable', 'string', 'max:2000'],
            'work_experience' => ['nullable', 'string', 'max:10000'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'profile_photo.max' => 'Profile photo must not exceed 2MB.',
            'resume.max' => 'Resume must not exceed 5MB.',
            'resume.mimes' => 'Resume must be a PDF file.',
            'birth_date.before' => 'Birth date must be a date in the past.',
        ];
    }
}
