<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreJobVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'job_category_id' => ['required', 'exists:job_categories,id'],
            'description' => ['required', 'string'],
            'requirements' => ['nullable', 'string'],
            'benefits' => ['nullable', 'string'],
            'salary_min' => ['nullable', 'numeric', 'min:0', 'max:999999999.99'],
            'salary_max' => ['nullable', 'numeric', 'min:0', 'max:999999999.99', 'gte:salary_min'],
            'employment_type' => ['required', 'in:full_time,part_time,contract,temporary,seasonal,internship'],
            'location' => ['required', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'slots_available' => ['required', 'integer', 'min:1', 'max:999'],
            'application_deadline' => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'salary_max.gte' => 'Maximum salary must be greater than or equal to minimum salary.',
            'application_deadline.after_or_equal' => 'Application deadline must be today or a future date.',
        ];
    }
}
