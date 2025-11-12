<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ExamService;
use App\Models\Exam;
use App\Models\Category;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(
        protected ExamService $examService
    ) {
        // $this->middleware('admin');
    }

    /**
     * list of exams
     *
     * @return mixed
     */
    public function index()
    {
        $exams = $this->examService->getAllExams();
        return view('admin.exams.index', compact('exams'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.exams.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'passing_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'string', 'in:draft,published,archived'],
            'scheduled_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:scheduled_at'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $exam = $this->examService->createExam($validated);

        return redirect()->route('admin.exams.show', $exam->id)
            ->with('success', 'Exam created successfully!');
    }

    public function show(Exam $exam)
    {
        $exam->load(['questions', 'category', 'attempts']);
        return view('admin.exams.show', compact('exam'));
    }

    public function edit(Exam $exam)
    {
        $categories = Category::all();
        return view('admin.exams.edit', compact('exam', 'categories'));
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration_minutes' => ['required', 'integer', 'min:1'],
            'passing_percentage' => ['required', 'numeric', 'min:0', 'max:100'],
            'status' => ['required', 'string', 'in:draft,published,archived'],
            'scheduled_at' => ['nullable', 'date'],
            'expires_at' => ['nullable', 'date', 'after:scheduled_at'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ]);

        $this->examService->updateExam($exam, $validated);

        return redirect()->route('admin.exams.show', $exam->id)
            ->with('success', 'Exam updated successfully!');
    }

    public function destroy(Exam $exam)
    {
        $this->examService->deleteExam($exam);

        return redirect()->route('admin.exams.index')
            ->with('success', 'Exam deleted successfully!');
    }
}