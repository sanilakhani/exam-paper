<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\QuestionService;
use App\Models\Exam;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function __construct(
        protected QuestionService $questionService
    ) {
        // $this->middleware('admin');
    }

    public function index(Exam $exam)
    {
        $questions = $this->questionService->getQuestionsByExam($exam->id);
        return view('admin.questions.index', compact('exam', 'questions'));
    }

    public function create(Exam $exam)
    {
        return view('admin.questions.create', compact('exam'));
    }

    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'in:a,b,c,d,A,B,C,D'],
            'marks' => ['nullable', 'integer', 'min:1'],
        ]);

        $validated['exam_id'] = $exam->id;
        $this->questionService->createQuestion($validated);

        return redirect()->route('admin.questions.index', $exam->id)
            ->with('success', 'Question added successfully!');
    }

    public function edit(Exam $exam, Question $question)
    {
        return view('admin.questions.edit', compact('exam', 'question'));
    }

    public function update(Request $request, Exam $exam, Question $question)
    {
        $validated = $request->validate([
            'question_text' => ['required', 'string'],
            'option_a' => ['required', 'string', 'max:255'],
            'option_b' => ['required', 'string', 'max:255'],
            'option_c' => ['required', 'string', 'max:255'],
            'option_d' => ['required', 'string', 'max:255'],
            'correct_answer' => ['required', 'in:a,b,c,d,A,B,C,D'],
            'marks' => ['nullable', 'integer', 'min:1'],
        ]);

        $this->questionService->updateQuestion($question, $validated);

        return redirect()->route('admin.questions.index', $exam->id)
            ->with('success', 'Question updated successfully!');
    }

    public function destroy(Exam $exam, Question $question)
    {
        $this->questionService->deleteQuestion($question);

        return redirect()->route('admin.questions.index', $exam->id)
            ->with('success', 'Question deleted successfully!');
    }
}