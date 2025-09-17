@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Mock Tests</h1>
<div class="flex justify-between items-center mb-6">
    <form action="{{ route('admin.mock-tests.index') }}" method="GET" class="flex space-x-4">
        <select name="subject_id" class="border rounded-md px-3 py-2">
            <option value="">Filter by Subject</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
            @endforeach
        </select>
        <select name="topic_id" class="border rounded-md px-3 py-2">
            <option value="">Filter by Topic</option>
            @foreach($topics as $topic)
            <option value="{{ $topic->id }}" {{ request('topic_id') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Filter</button>
    </form>
    <a href="{{ route('admin.mock-tests.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Create Mock Test</a>
</div>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Available Mock Tests</h2>
    <ul class="divide-y divide-gray-200">
        @forelse($mockTests as $test)
        <li class="py-3">
            <h3 class="font-bold">{{ $test->title }}</h3>
            <p class="text-sm text-gray-600">Subject: {{ $test->subject->name }} | Topic: {{ $test->topic->name }}</p>
            <p class="text-sm text-gray-500">{{ $test->questions->count() }} Questions</p>
        </li>
        @empty
        <p>No mock tests found.</p>
        @endforelse
    </ul>
</div>
@endsection