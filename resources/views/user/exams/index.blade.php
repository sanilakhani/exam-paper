@extends('layouts.app')

@section('title', 'Available Exams')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Available Exams</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($exams as $exam)
            <div class="border rounded-lg p-6 hover:shadow-lg transition">
                <h3 class="text-xl font-bold mb-2">{{ $exam->title }}</h3>
                
                @if($exam->description)
                    <p class="text-gray-600 mb-4">{{ Str::limit($exam->description, 100) }}</p>
                @endif

                <div class="space-y-2 text-sm text-gray-700 mb-4">
                    <p><strong>Duration:</strong> {{ $exam->duration_minutes }} minutes</p>
                    <p><strong>Questions:</strong> {{ $exam->questions->count() }}</p>
                    <p><strong>Passing Score:</strong> {{ $exam->passing_percentage }}%</p>
                    @if($exam->category)
                        <p><strong>Category:</strong> {{ $exam->category->name }}</p>
                    @endif
                </div>

                <form action="{{ route('user.exams.start', $exam) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600">
                        Start Exam
                    </button>
                </form>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-500 py-12">
                <p class="text-xl">No exams available at the moment.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection