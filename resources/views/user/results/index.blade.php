@extends('layouts.app')

@section('title', 'My Results')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">My Exam History</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Exam</th>
                    <th class="px-4 py-2 text-left">Score</th>
                    <th class="px-4 py-2 text-left">Percentage</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Date</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attempts as $attempt)
                    <tr class="border-b">
                        <td class="px-4 py-2">
                            <div>
                                <p class="font-bold">{{ $attempt->exam->title }}</p>
                                @if($attempt->exam->category)
                                    <p class="text-xs text-gray-500">{{ $attempt->exam->category->name }}</p>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-2">{{ $attempt->correct_answers }}/{{ $attempt->total_questions }}</td>
                        <td class="px-4 py-2">{{ $attempt->score_percentage }}%</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($attempt->status->value === 'pass') bg-green-200 text-green-800
                                @else bg-red-200 text-red-800 @endif">
                                {{ $attempt->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $attempt->completed_at->format('Y-m-d H:i') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('user.results.show', $attempt) }}" class="text-blue-500 hover:underline">
                                View Details
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No exam attempts yet</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $attempts->links() }}
    </div>
</div>
@endsection