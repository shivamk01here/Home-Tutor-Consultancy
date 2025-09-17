@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Students</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Student List</h2>
        <a href="{{ route('admin.students.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200">Enroll New Student</a>
    </div>
    
    <ul class="divide-y divide-gray-200">
        @foreach($students as $student)
        <li class="py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/' . $student->profile_photo_path) }}" alt="Profile Photo" class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-semibold">{{ $student->name }}</h3>
                    <p class="text-sm text-gray-500">
    Parent: {{ $student->studentProfile?->parent_name }}
</p>

                </div>
            </div>
            <a href="{{ route('admin.students.show', $student->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
        </li>
        @endforeach
    </ul>
    <div class="mt-4">
        {{ $students->links() }}
    </div>
</div>
@endsection