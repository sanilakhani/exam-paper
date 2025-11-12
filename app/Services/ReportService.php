<?php

namespace App\Services;

use App\Models\ExamAttempt;
use App\Models\Exam;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getAllResults()
    {
        return ExamAttempt::with(['user', 'exam'])
            ->whereNotNull('completed_at')
            ->latest('completed_at')
            ->paginate(20);
    }

    public function getExamStatistics(int $examId): array
    {
        $exam = Exam::findOrFail($examId);
        
        $attempts = ExamAttempt::where('exam_id', $examId)
            ->whereNotNull('completed_at')
            ->get();

        return [
            'exam' => $exam,
            'total_attempts' => $attempts->count(),
            'pass_count' => $attempts->where('status', 'pass')->count(),
            'fail_count' => $attempts->where('status', 'fail')->count(),
            'average_score' => $attempts->avg('score_percentage'),
            'highest_score' => $attempts->max('score_percentage'),
            'lowest_score' => $attempts->min('score_percentage'),
        ];
    }

    public function getUserPerformance(int $userId): array
    {
        $attempts = ExamAttempt::where('user_id', $userId)
            ->whereNotNull('completed_at')
            ->get();

        return [
            'total_exams' => $attempts->count(),
            'passed_exams' => $attempts->where('status', 'pass')->count(),
            'failed_exams' => $attempts->where('status', 'fail')->count(),
            'average_score' => $attempts->avg('score_percentage'),
        ];
    }
}