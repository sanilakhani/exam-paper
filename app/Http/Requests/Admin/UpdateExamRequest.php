<?php

namespace App\Http\Requests\Admin;

use App\Enums\ExamStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     */
    public function authorize(): bool
    {
        return auth()->user()->isAdmin();
    }

    /**
     * Get the validation rules for updating exam
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1', 'max:300'],
            'passing_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', Rule::in(ExamStatus::values())],
            'scheduled_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after:scheduled_at'],
            'instructions' => ['nullable', 'string'],
        ];
    }
}