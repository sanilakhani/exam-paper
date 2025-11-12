@extends('layouts.app')

@section('title', 'Exam Details')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">{{ $exam->title }}</h1>
        <div class="space-x-2">
            <a href="{{ route('admin.questions.index', $exam) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Manage Questions
            </a>
            <a href="{{ route('admin.exams.edit', $exam) }}" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                Edit Exam
            </a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div>
            <p class="text-gray-600">Duration</p>
            <p class="text-xl font-bold">{{ $exam->duration_minutes }} minutes</p>
        </div>
        <div>
            <p class="text-gray-600">Passing Percentage</p>
            <p class="text-xl font-bold">{{ $exam->passing_percentage }}%</p>
        </div>
        <div>
            <p class="text-gray-600">Status</p>
            <p class="text-xl font-bold">{{ $exam->status->label() }}</p>
        </div>
        <div>
            <p class="text-gray-600">Total Questions</p>
            <p class="text-xl font-bold">{{ $exam->questions->count() }}</p>
        </div>
    </div>

    @if($exam->description)
        <div class="mb-6">
            <p class="text-gray-600">Description</p>
            <p class="mt-2">{{ $exam->description }}</p>
        </div>
    @endif

    <div class="mt-6">
        <a href="{{ route('admin.exams.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            Back to Exams
        </a>
    </div>
</div>
@endsection