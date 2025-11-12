@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Welcome, {{ auth()->user()->name }}!</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('user.exams.index') }}" class="bg-blue-500 text-white p-6 rounded-lg hover:bg-blue-600">
            <h3 class="text-xl font-bold">Available Exams</h3>
            <p class="mt-2">View and take available exams</p>
        </a>

        <a href="{{ route('user.results.index') }}" class="bg-green-500 text-white p-6 rounded-lg hover:bg-green-600">
            <h3 class="text-xl font-bold">My Results</h3>
            <p class="mt-2">View your exam history and results</p>
        </a>
    </div>
</div>
@endsection