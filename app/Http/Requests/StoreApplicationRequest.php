<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isJobSeeker();
    }

    public function rules(): array
    {
        return [
            'cover_letter' => ['nullable', 'string', 'max:5000'],
            'resume' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'resume.mimes' => 'Resume must be a PDF file.',
            'resume.max' => 'Resume must not exceed 5MB in size.',
            'cover_letter.max' => 'Cover letter must not exceed 5000 characters.',
        ];
    }
}
