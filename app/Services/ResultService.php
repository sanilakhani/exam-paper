<?php

namespace App\Services;

use App\Enums\ResultStatus;
use App\Models\ExamAttempt;
use App\Models\Exam;
use App\Models\Answer;
use Illuminate\Support\Facades\DB;

class ResultService
{
    public function startExam(int $examId, int $userId): ExamAttempt
    {
        $exam = Exam::with('questions')->findOrFail($examId);

        return ExamAttempt::create([
            'user_id' => $userId,
            'exam_id' => $examId,
            'started_at' => now(),
            'total_questions' => $exam->questions->count(),
        ]);
    }

    public function submitAnswer(ExamAttempt $attempt, int $questionId, string $answer): Answer
    {
        $question = $attempt->exam->questions()->findOrFail($questionId);
        
        $isCorrect = strtolower($answer) === strtolower($question->correct_answer);

        return Answer::create([
            'exam_attempt_id' => $attempt->id,
            'question_id' => $questionId,
            'selected_answer' => strtolower($answer),
            'is_correct' => $isCorrect,
        ]);
    }

    public function completeExam(ExamAttempt $attempt): ExamAttempt
    {
        DB::transaction(function () use ($attempt) {
            $correctAnswers = $attempt->answers()->where('is_correct', true)->count();
            $totalQuestions = $attempt->total_questions;
            
            $scorePercentage = $totalQuestions > 0 
                ? ($correctAnswers / $totalQuestions) * 100 
                : 0;

            $passingPercentage = $attempt->exam->passing_percentage;
            $status = $scorePercentage >= $passingPercentage 
                ? ResultStatus::PASS 
                : ResultStatus::FAIL;

            $attempt->update([
                'completed_at' => now(),
                'correct_answers' => $correctAnswers,
                'score_percentage' => round($scorePercentage, 2),
                'status' => $status,
            ]);
        });

        return $attempt->fresh();
    }

    public function getUserAttempts(int $userId)
    {
        return ExamAttempt::with(['exam', 'exam.category'])
            ->where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->paginate(15);
    }

    public function getAttemptDetails(int $attemptId): ?ExamAttempt
    {
        return ExamAttempt::with([
            'exam',
            'answers.question',
            'user'
        ])->find($attemptId);
    }
}