<?php

namespace App\Services;

use App\Enums\ExamStatus;
use App\Models\Exam;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ExamService
{
    public function getAllExams(): LengthAwarePaginator
    {
        return Exam::with(['category', 'creator', 'questions'])
            ->latest()
            ->paginate(15);
    }

    public function getAvailableExams(): Collection
    {
        return Exam::with(['category', 'questions'])
            ->where('status', ExamStatus::PUBLISHED)
            ->where(function ($query) {
                $query->whereNull('scheduled_at')
                    ->orWhere('scheduled_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
            })
            ->get();
    }

    public function createExam(array $data): Exam
    {
        return Exam::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'duration_minutes' => $data['duration_minutes'],
            'passing_percentage' => $data['passing_percentage'] ?? 60.00,
            'status' => $data['status'] ?? ExamStatus::DRAFT,
            'scheduled_at' => $data['scheduled_at'] ?? null,
            'expires_at' => $data['expires_at'] ?? null,
            'category_id' => $data['category_id'] ?? null,
            'created_by' => auth()->id(),
        ]);
    }

    public function updateExam(Exam $exam, array $data): Exam
    {
        $exam->update([
            'title' => $data['title'] ?? $exam->title,
            'description' => $data['description'] ?? $exam->description,
            'duration_minutes' => $data['duration_minutes'] ?? $exam->duration_minutes,
            'passing_percentage' => $data['passing_percentage'] ?? $exam->passing_percentage,
            'status' => $data['status'] ?? $exam->status,
            'scheduled_at' => $data['scheduled_at'] ?? $exam->scheduled_at,
            'expires_at' => $data['expires_at'] ?? $exam->expires_at,
            'category_id' => $data['category_id'] ?? $exam->category_id,
        ]);

        return $exam->fresh();
    }

    public function deleteExam(Exam $exam): bool
    {
        return $exam->delete();
    }

    public function getExamById(int $id): ?Exam
    {
        return Exam::with(['category', 'questions', 'creator'])->find($id);
    }
}