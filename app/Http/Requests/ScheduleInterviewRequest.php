<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleInterviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'application_id' => ['sometimes', 'required', 'exists:applications,id'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'location' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:online,in_person,phone'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'scheduled_at.after' => 'Interview must be scheduled in the future.',
        ];
    }
}
