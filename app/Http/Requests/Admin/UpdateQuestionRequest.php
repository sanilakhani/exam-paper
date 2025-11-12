<?php

namespace App\Http\Requests\Admin;

use App\Enums\QuestionDifficulty;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules for updating question
     */
    public function rules(): array
    {
        return [
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
}