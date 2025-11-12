@extends('layouts.app')

@section('title', 'Manage Questions')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold">Questions for: {{ $exam->title }}</h1>
            <p class="text-gray-600 mt-2">Total Questions: {{ $questions->count() }}</p>
        </div>
        <a href="{{ route('admin.questions.create', $exam) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add Question
        </a>
    </div>

    <div class="space-y-4">
        @forelse($questions as $question)
            <div class="border rounded-lg p-4 hover:shadow-md transition">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <p class="font-bold text-lg mb-2">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <p class="@if($question->correct_answer === 'a') text-green-600 font-bold @endif">A) {{ $question->option_a }}</p>
                            <p class="@if($question->correct_answer === 'b') text-green-600 font-bold @endif">B) {{ $question->option_b }}</p>
                            <p class="@if($question->correct_answer === 'c') text-green-600 font-bold @endif">C) {{ $question->option_c }}</p>
                            <p class="@if($question->correct_answer === 'd') text-green-600 font-bold @endif">D) {{ $question->option_d }}</p>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Correct Answer: {{ strtoupper($question->correct_answer) }} | Marks: {{ $question->marks }}</p>
                    </div>
                    <div class="ml-4 space-x-2">
                        <a href="{{ route('admin.questions.edit', [$exam, $question]) }}" class="text-blue-500 hover:underline">Edit</a>
                        <form action="{{ route('admin.questions.destroy', [$exam, $question]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-500 py-8">No questions added yet. Click "Add Question" to get started.</p>
        @endforelse
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.exams.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Exams
        </a>
    </div>
</div>
@endsection