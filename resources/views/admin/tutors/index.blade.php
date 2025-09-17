@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Tutors</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Tutor List</h2>
        <a href="{{ route('admin.tutors.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200">Add New Tutor</a>
    </div>

    <form action="{{ route('admin.tutors.index') }}" method="GET" class="mb-4">
        <div class="flex items-center space-x-4">
            <select name="location_id" class="border rounded-md px-3 py-2">
                <option value="">Filter by Location</option>
                @foreach($locations as $location)
                <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                @endforeach
            </select>
            <select name="subject_id" class="border rounded-md px-3 py-2">
                <option value="">Filter by Subject</option>
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                @endforeach
            </select>
            <input type="number" name="experience" placeholder="Min. Exp. (Years)" class="border rounded-md px-3 py-2" value="{{ request('experience') }}">
            <input type="number" name="rating" placeholder="Min. Rating" step="0.1" min="0" max="5" class="border rounded-md px-3 py-2" value="{{ request('rating') }}">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Apply Filters</button>
            <a href="{{ route('admin.tutors.index') }}" class="text-gray-600 hover:text-gray-800">Reset</a>
        </div>
    </form>
    
    <ul class="divide-y divide-gray-200">
        @foreach($tutors as $tutor)
        <li class="py-4 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/' . $tutor->profile_photo_path) }}" alt="Profile Photo" class="w-12 h-12 rounded-full object-cover">
                <div>
                    <h3 class="text-lg font-semibold">{{ $tutor->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $tutor->tutorProfile->qualification }}</p>
                </div>
            </div>
            <div class="text-sm">
                @if($tutor->is_verified)
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                @else
                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                @endif
            </div>
            <a href="{{ route('admin.tutors.show', $tutor->id) }}" class="text-indigo-600 hover:text-indigo-900">View Details</a>
        </li>
        @endforeach
    </ul>
    <div class="mt-4">
        {{ $tutors->links() }}
    </div>
</div>
@endsection