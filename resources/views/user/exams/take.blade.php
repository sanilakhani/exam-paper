@extends('layouts.app')

@section('title', 'Take Exam')

@section('content')

<div class="bg-white rounded-lg shadow p-6">
    <div class="mb-6 flex justify-between items-center">
        <h1 class="text-3xl font-bold">{{ $exam->title }}</h1>
        <div id="timer" class="text-2xl font-bold text-red-600"></div>
    </div>

    <div class="mb-4 bg-blue-100 p-4 rounded">
        <p class="font-bold">Instructions:</p>
        <ul class="list-disc list-inside mt-2">
            <li>This exam has {{ $exam->questions->count() }} questions</li>
            <li>Duration: {{ $exam->duration_minutes }} minutes</li>
            <li>Passing score: {{ $exam->passing_percentage }}%</li>
            <li>Select one answer for each question</li>
            <li>Click "Submit Exam" when you're done</li>
        </ul>
    </div>

    <form method="POST" action="{{ route('user.exams.submit', $attempt) }}" id="examForm">
        @csrf

        @foreach($exam->questions as $question)
            <div class="mb-6 p-4 border rounded">
                <p class="font-bold text-lg mb-3">{{ $loop->iteration }}. {{ $question->question_text }}</p>
                
                <div class="space-y-2">
                    @foreach(['a', 'b', 'c', 'd'] as $option)
                        <label class="flex items-center p-3 border rounded hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}" required
                                class="mr-3">
                            <span>{{ strtoupper($option) }}) {{ $question->{'option_' . $option} }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex justify-end space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded hover:bg-blue-600 font-bold"
                onclick="return confirm('Are you sure you want to submit your exam?')">
                Submit Exam
            </button>
        </div>
    </form>
</div>


<script>
    // Timer functionality
    const startTime = new Date().getTime();
    const durationMinutes = parseInt('{{ $exam->duration_minutes }}');
    const duration = durationMinutes * 60 * 1000;
    const endTime = startTime + duration;

    function updateTimer() {
        const now = new Date().getTime();
        const remaining = endTime - now;

        if (remaining <= 0) {
            document.getElementById('timer').textContent = 'Time Up!';
            document.getElementById('examForm').submit();
            return;
        }

        const minutes = Math.floor((remaining % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((remaining % (1000 * 60)) / 1000);

        document.getElementById('timer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }

    updateTimer();
    setInterval(updateTimer, 1000);

    // Warn before leaving page
    window.addEventListener('beforeunload', function (e) {
        e.preventDefault();
        e.returnValue = '';
    });

    // Remove warning when submitting
    document.getElementById('examForm').addEventListener('submit', function() {
        window.removeEventListener('beforeunload', function() {});
    });
</script>
@endsection