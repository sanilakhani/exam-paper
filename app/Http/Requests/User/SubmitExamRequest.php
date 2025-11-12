<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class SubmitExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules for submitting exam
     */
    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'exists:exams,id'],
            'started_at' => ['required', 'date'],
            'answers' => ['required', 'array'],
            'answers.*' => ['nullable', 'in:a,b,c,d'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'exam_id.required' => 'Exam ID is required.',
            'exam_id.exists' => 'Invalid exam selected.',
            'started_at.required' => 'Start time is required.',
            'answers.required' => 'Answers are required.',
            'answers.*.in' => 'Invalid answer format.',
        ];
    }
}