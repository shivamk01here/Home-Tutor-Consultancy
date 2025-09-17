@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Subjects</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Create New Subject</h2>
    <form action="{{ route('admin.subjects.create') }}" method="POST">
        @csrf
        <div class="flex space-x-4 items-center">
            <input type="text" name="name" placeholder="Subject Name" class="border rounded-md px-3 py-2 w-full max-w-sm" required>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Add Subject</button>
        </div>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Existing Subjects</h2>
    <ul class="divide-y divide-gray-200">
        @foreach($subjects as $subject)
        <li class="py-2">{{ $subject->name }}</li>
        @endforeach
    </ul>
</div>
@endsection