<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;

class QuestionService
{
    public function getQuestionsByExam(int $examId): Collection
    {
        return Question::where('exam_id', $examId)
            ->orderBy('order')
            ->get();
    }

    public function createQuestion(array $data): Question
    {
        $maxOrder = Question::where('exam_id', $data['exam_id'])->max('order') ?? 0;

        return Question::create([
            'exam_id' => $data['exam_id'],
            'question_text' => $data['question_text'],
            'option_a' => $data['option_a'],
            'option_b' => $data['option_b'],
            'option_c' => $data['option_c'],
            'option_d' => $data['option_d'],
            'correct_answer' => strtolower($data['correct_answer']),
            'marks' => $data['marks'] ?? 1,
            'order' => $data['order'] ?? ($maxOrder + 1),
        ]);
    }

    public function updateQuestion(Question $question, array $data): Question
    {
        $question->update([
            'question_text' => $data['question_text'] ?? $question->question_text,
            'option_a' => $data['option_a'] ?? $question->option_a,
            'option_b' => $data['option_b'] ?? $question->option_b,
            'option_c' => $data['option_c'] ?? $question->option_c,
            'option_d' => $data['option_d'] ?? $question->option_d,
            'correct_answer' => isset($data['correct_answer']) 
                ? strtolower($data['correct_answer']) 
                : $question->correct_answer,
            'marks' => $data['marks'] ?? $question->marks,
            'order' => $data['order'] ?? $question->order,
        ]);

        return $question->fresh();
    }

    public function deleteQuestion(Question $question): bool
    {
        return $question->delete();
    }

    public function getQuestionById(int $id): ?Question
    {
        return Question::find($id);
    }
}