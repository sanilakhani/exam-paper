<?php

namespace App\Models;

use App\Enums\ResultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamAttempt extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'exam_id',
        'started_at',
        'completed_at',
        'total_questions',
        'correct_answers',
        'score_percentage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'completed_at' => 'datetime',
            'score_percentage' => 'decimal:2',
            'status' => ResultStatus::class,
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function isPassed(): bool
    {
        return $this->status === ResultStatus::PASS;
    }
}