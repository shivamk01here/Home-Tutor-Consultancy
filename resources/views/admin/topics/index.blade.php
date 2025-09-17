@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Topics</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Create New Topic</h2>
    <form action="{{ route('admin.topics.create') }}" method="POST">
        @csrf
        <div class="flex space-x-4 items-center">
            <select name="subject_id" class="border rounded-md px-3 py-2">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
            <input type="text" name="name" placeholder="Topic Name" class="border rounded-md px-3 py-2 w-full max-w-sm" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Add Topic</button>
        </div>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Existing Topics</h2>
    <ul class="divide-y divide-gray-200">
        @foreach($topics as $topic)
        <li class="py-2">
            <strong>{{ $topic->name }}</strong> (Subject: {{ $topic->subject->name }})
        </li>
        @endforeach
    </ul>
</div>
@endsection