<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateJobVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'job_category_id' => ['sometimes', 'required', 'exists:job_categories,id'],
            'description' => ['sometimes', 'required', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'max:999999999.99', 'gte:salary_min'],
            'employment_type' => ['sometimes', 'required', 'in:full_time,part_time,contract,temporary,seasonal,internship'],
            'location' => ['sometimes', 'required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'slots_available' => ['sometimes', 'required', 'integer', 'min:1', 'max:999'],
            'application_deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'is_open' => ['boolean'],
            'is_active' => ['boolean'],
        ];
    }
}
