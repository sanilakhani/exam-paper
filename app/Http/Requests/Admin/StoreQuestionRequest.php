<?php

namespace App\Http\Requests\Admin;

use App\Enums\QuestionDifficulty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules for creating question
     */
    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'exists:exams,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'question_text' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:500'],
            'option_b' => ['required', 'string', 'max:500'],
            'option_c' => ['required', 'string', 'max:500'],
            'option_d' => ['required', 'string', 'max:500'],
            'correct_answer' => ['required', Rule::in(['a', 'b', 'c', 'd'])],
            'marks' => ['required', 'integer', 'min:1'],
            'difficulty' => ['required', Rule::in(QuestionDifficulty::values())],
            'explanation' => ['nullable', 'string'],
        ];
    }

    /**
     * Custom error messages
     */
    public function messages(): array
    {
        return [
            'exam_id.required' => 'Please select an exam.',
            'exam_id.exists' => 'Selected exam does not exist.',
            'question_text.required' => 'Question text is required.',
            'option_a.required' => 'Option A is required.',
            'option_b.required' => 'Option B is required.',
            'option_c.required' => 'Option C is required.',
            'option_d.required' => 'Option D is required.',
            'correct_answer.required' => 'Please select the correct answer.',
            'correct_answer.in' => 'Correct answer must be a, b, c, or d.',
            'marks.min' => 'Marks must be at least 1.',
        ];
    }
}