<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\ResultService;
use App\Models\ExamAttempt;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function __construct(
        protected ResultService $resultService
    ) {
        // $this->middleware('auth');
    }

    public function index()
    {
        $attempts = $this->resultService->getUserAttempts(auth()->id());
        return view('user.results.index', compact('attempts'));
    }

    public function show(ExamAttempt $attempt)
    {
        if ($attempt->user_id !== auth()->id()) {
            abort(403);
        }

        $attempt = $this->resultService->getAttemptDetails($attempt->id);

        return view('user.results.show', compact('attempt'));
    }
}