<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'status'      => ['required', Rule::in(Task::STATUSES)],
            'priority'    => ['required', Rule::in(Task::PRIORITIES)],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    /**
     * Custom human-readable attribute names.
     */
    public function attributes(): array
    {
        return [
            'due_date' => 'due date',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'title.required'        => 'A task title is required.',
            'title.max'             => 'The task title may not exceed 255 characters.',
            'status.required'       => 'Please select a status.',
            'status.in'             => 'The selected status is invalid.',
            'priority.required'     => 'Please select a priority.',
            'priority.in'           => 'The selected priority is invalid.',
            'due_date.after_or_equal' => 'The due date must be today or a future date.',
        ];
    }
}