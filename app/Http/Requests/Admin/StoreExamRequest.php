<?php

namespace App\Http\Requests\Admin;

use App\Enums\ExamStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules for creating exam
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'],
            'passing_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', Rule::in(ExamStatus::values())],
            'scheduled_at' => ['nullable', 'date', 'after:now'],
            'ends_at' => ['nullable', 'date', 'after:scheduled_at'],
            'instructions' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Exam title is required.',
            'duration_minutes.min' => 'Duration must be at least 1 minute.',
            'duration_minutes.max' => 'Duration cannot exceed 300 minutes.',
            'passing_percentage.min' => 'Passing percentage must be at least 0%.',
            'passing_percentage.max' => 'Passing percentage cannot exceed 100%.',
            'scheduled_at.after' => 'Scheduled date must be in the future.',
            'ends_at.after' => 'End date must be after scheduled date.',
        ];
    }
}