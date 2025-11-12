<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ExamService;
use App\Services\ResultService;
use App\Models\Exam;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(
        protected ExamService $examService,
        protected ResultService $resultService
    ) {
        // $this->middleware('auth');
    }

    public function index()
    {
        $exams = $this->examService->getAvailableExams();
        return view('user.exams.index', compact('exams'));
    }

    public function show(Exam $exam)
    {
        if (!$exam->isAvailable()) {
            abort(403, 'This exam is not available.');
        }

        return view('user.exams.show', compact('exam'));
    }

    public function start(Exam $exam)
    {
        if (!$exam->isAvailable()) {
            abort(403, 'This exam is not available.');
        }

        $attempt = $this->resultService->startExam($exam->id, auth()->id());

        return redirect()->route('user.exams.take', $attempt->id);
    }

    public function take(ExamAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->completed_at) {
            return redirect()->route('user.results.show', $attempt->id);
        }

        $exam = $attempt->exam->load('questions');
        
        return view('user.exams.take', compact('attempt', 'exam'));
    }

    public function submit(Request $request, ExamAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        if ($attempt->completed_at) {
            return redirect()->route('user.results.show', $attempt->id);
        }

        $validated = $request->validate([
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'in:a,b,c,d'],
        ]);

        foreach ($validated['answers'] as $questionId => $answer) {
            $this->resultService->submitAnswer($attempt, $questionId, $answer);
        }

        $attempt = $this->resultService->completeExam($attempt);

        return redirect()->route('user.results.show', $attempt->id)
            ->with('success', 'Exam submitted successfully!');
    }
}