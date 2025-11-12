@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Student Performance Reports</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Student</th>
                    <th class="px-4 py-2 text-left">Exam</th>
                    <th class="px-4 py-2 text-left">Score</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Completed At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $result)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $result->user->name }}</td>
                        <td class="px-4 py-2">{{ $result->exam->title }}</td>
                        <td class="px-4 py-2">
                            {{ $result->correct_answers }}/{{ $result->total_questions }} 
                            ({{ $result->score_percentage }}%)
                        </td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($result->status->value === 'pass') bg-green-200 text-green-800
                                @else bg-red-200 text-red-800 @endif">
                                {{ $result->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $result->completed_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">No results found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $results->links() }}
    </div>
</div>
@endsection