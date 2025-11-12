@extends('layouts.app')

@section('title', 'Manage Exams')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Manage Exams</h1>
        <a href="{{ route('admin.exams.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Create New Exam
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 text-left">Title</th>
                    <th class="px-4 py-2 text-left">Duration</th>
                    <th class="px-4 py-2 text-left">Pass %</th>
                    <th class="px-4 py-2 text-left">Status</th>
                    <th class="px-4 py-2 text-left">Questions</th>
                    <th class="px-4 py-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exams as $exam)
                    <tr class="border-b">
                        <td class="px-4 py-2">{{ $exam->title }}</td>
                        <td class="px-4 py-2">{{ $exam->duration_minutes }} min</td>
                        <td class="px-4 py-2">{{ $exam->passing_percentage }}%</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($exam->status->value === 'published') bg-green-200 text-green-800
                                @elseif($exam->status->value === 'draft') bg-yellow-200 text-yellow-800
                                @else bg-gray-200 text-gray-800 @endif">
                                {{ $exam->status->label() }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $exam->questions_count ?? 0 }}</td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.questions.index', $exam) }}" class="text-blue-500 hover:underline">Questions</a>
                            <a href="{{ route('admin.exams.edit', $exam) }}" class="text-green-500 hover:underline">Edit</a>
                            <form action="{{ route('admin.exams.destroy', $exam) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-2 text-center text-gray-500">No exams found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $exams->links() }}
    </div>
</div>
@endsection