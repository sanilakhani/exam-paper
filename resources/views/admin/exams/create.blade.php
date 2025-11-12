@extends('layouts.app')

@section('title', 'Create Exam')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Create New Exam</h1>

    <form method="POST" action="{{ route('admin.exams.store') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required
                class="w-full px-3 py-2 border rounded @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Description</label>
            <textarea name="description" rows="4" class="w-full px-3 py-2 border rounded">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Duration (minutes)</label>
                <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 60) }}" required
                    class="w-full px-3 py-2 border rounded @error('duration_minutes') border-red-500 @enderror">
                @error('duration_minutes')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Passing Percentage</label>
                <input type="number" step="0.01" name="passing_percentage" value="{{ old('passing_percentage', 60) }}" required
                    class="w-full px-3 py-2 border rounded @error('passing_percentage') border-red-500 @enderror">
                @error('passing_percentage')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Category</label>
            <select name="category_id" class="w-full px-3 py-2 border rounded">
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Status</label>
            <select name="status" class="w-full px-3 py-2 border rounded" required>
                <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Scheduled At (Optional)</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at') }}"
                    class="w-full px-3 py-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Expires At (Optional)</label>
                <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                    class="w-full px-3 py-2 border rounded">
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Create Exam
            </button>
            <a href="{{ route('admin.exams.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection