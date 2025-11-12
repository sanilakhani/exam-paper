@extends('layouts.app')

@section('title', 'Add Question')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Add Question to: {{ $exam->title }}</h1>

    <form method="POST" action="{{ route('admin.questions.store', $exam) }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Question Text</label>
            <textarea name="question_text" rows="3" required
                class="w-full px-3 py-2 border rounded @error('question_text') border-red-500 @enderror">{{ old('question_text') }}</textarea>
            @error('question_text')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Option A</label>
                <input type="text" name="option_a" value="{{ old('option_a') }}" required
                    class="w-full px-3 py-2 border rounded @error('option_a') border-red-500 @enderror">
                @error('option_a')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Option B</label>
                <input type="text" name="option_b" value="{{ old('option_b') }}" required
                    class="w-full px-3 py-2 border rounded @error('option_b') border-red-500 @enderror">
                @error('option_b')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Option C</label>
                <input type="text" name="option_c" value="{{ old('option_c') }}" required
                    class="w-full px-3 py-2 border rounded @error('option_c') border-red-500 @enderror">
                @error('option_c')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Option D</label>
                <input type="text" name="option_d" value="{{ old('option_d') }}" required
                    class="w-full px-3 py-2 border rounded @error('option_d') border-red-500 @enderror">
                @error('option_d')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 font-bold mb-2">Correct Answer</label>
                <select name="correct_answer" required class="w-full px-3 py-2 border rounded">
                    <option value="">-- Select Correct Answer --</option>
                    <option value="a" {{ old('correct_answer') === 'a' ? 'selected' : '' }}>Option A</option>
                    <option value="b" {{ old('correct_answer') === 'b' ? 'selected' : '' }}>Option B</option>
                    <option value="c" {{ old('correct_answer') === 'c' ? 'selected' : '' }}>Option C</option>
                    <option value="d" {{ old('correct_answer') === 'd' ? 'selected' : '' }}>Option D</option>
                </select>
                @error('correct_answer')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">Marks</label>
                <input type="number" name="marks" value="{{ old('marks', 1) }}" min="1" required
                    class="w-full px-3 py-2 border rounded">
            </div>
        </div>

        <div class="flex space-x-4">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                Add Question
            </button>
            <a href="{{ route('admin.questions.index', $exam) }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection