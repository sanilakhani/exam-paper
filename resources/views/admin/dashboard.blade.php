@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <h1 class="text-3xl font-bold mb-6">Admin Dashboard</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="{{ route('admin.exams.index') }}" class="bg-blue-500 text-white p-6 rounded-lg hover:bg-blue-600">
            <h3 class="text-xl font-bold">Manage Exams</h3>
            <p class="mt-2">Create and manage exams</p>
        </a>

        <a href="{{ route('admin.categories.index') }}" class="bg-green-500 text-white p-6 rounded-lg hover:bg-green-600">
            <h3 class="text-xl font-bold">Categories</h3>
            <p class="mt-2">Manage exam categories</p>
        </a>

        <a href="{{ route('admin.reports.index') }}" class="bg-purple-500 text-white p-6 rounded-lg hover:bg-purple-600">
            <h3 class="text-xl font-bold">View Reports</h3>
            <p class="mt-2">Student performance analytics</p>
        </a>
    </div>
</div>
@endsection