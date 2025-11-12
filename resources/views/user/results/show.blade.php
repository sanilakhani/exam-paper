@extends('layouts.app')

@section('title', 'Exam Result')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Exam Result: {{ $attempt->exam->title }}</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-blue-100 p-6 rounded-lg">
            <p class="text-gray-600">Score</p>
            <p class="text-3xl font-bold">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</p>
        </div>

        <div class="bg-purple-100 p-6 rounded-lg">
            <p class="text-gray-600">Percentage</p>
            <p class="text-3xl font-bold">{{ $attempt->score_percentage }}%</p>
        </div>

        <div class="p-6 rounded-lg @if($attempt->isPassed()) bg-green-100 @else bg-red-100 @endif">
            <p class="text-gray-600">Status</p>
            <p class="text-3xl font-bold">{{ $attempt->status->label() }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-2xl font-bold mb-4">Question Review</h2>
        
        @foreach($attempt->answers as $answer)
            <div class="mb-4 p-4 border rounded @if($answer->is_correct) bg-green-50 @else bg-red-50 @endif">
                <p class="font-bold mb-2">{{ $loop->iteration }}. {{ $answer->question->question_text }}</p>
                
                <div class="space-y-1 text-sm">
                    @foreach(['a', 'b', 'c', 'd'] as $option)
                        <p class="
                            @if($option === $answer->question->correct_answer) text-green-600 font-bold 
                            @elseif($option === $answer->selected_answer && !$answer->is_correct) text-red-600 font-bold
                            @endif">
                            {{ strtoupper($option) }}) {{ $answer->question->{'option_' . $option} }}
                            @if($option === $answer->question->correct_answer) ✓ @endif
                            @if($option === $answer->selected_answer && !$answer->is_correct) ✗ (Your answer) @endif
                        </p>
                    @endforeach
                </div>

                <p class="mt-2 text-xs">
                    @if($answer->is_correct)
                        <span class="text-green-600">✓ Correct</span>
                    @else
                        <span class="text-red-600">✗ Incorrect - Correct answer is {{ strtoupper($answer->question->correct_answer) }}</span>
                    @endif
                </p>
            </div>
        @endforeach
    </div>

    <div>
        <a href="{{ route('user.results.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
            Back to Results
        </a>
    </div>
</div>
@endsection