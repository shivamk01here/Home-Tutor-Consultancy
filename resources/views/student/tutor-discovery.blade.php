@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Find a Tutor</h1>
    
    <form action="{{ route('student.discovery') }}" method="GET" class="mb-8">
        <div class="flex items-center space-x-4">
            <label for="subject_id" class="text-gray-700 font-semibold">Filter by Subject:</label>
            <select name="subject_id" id="subject_id" class="form-select border rounded-md shadow-sm">
                <option value="">All Subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">Search</button>
        </div>
    </form>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @if($tutors->isEmpty())
            <p class="text-gray-500">No tutors found matching your criteria.</p>
        @else
            @foreach($tutors as $tutor)
                <a href="{{ route('student.tutor.profile', $tutor->id) }}" class="block">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <img src="{{ $tutor->profile_photo_path ? asset('storage/' . $tutor->profile_photo_path) : 'https://via.placeholder.com/150' }}" alt="Tutor Photo" class="w-full h-48 object-cover">
                        <div class="p-4">
                            <h3 class="text-xl font-bold text-gray-800">{{ $tutor->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $tutor->tutorProfile->qualification }}</p>
                            <div class="mt-2 text-yellow-400">
                                @for($i = 0; $i < round($tutor->tutorProfile->rating); $i++) ⭐ @endfor
                                <span class="text-gray-500 text-sm">({{ number_format($tutor->tutorProfile->rating, 1) }})</span>
                            </div>
                            <div class="mt-4">
                                <span class="text-xs font-semibold text-gray-600">Subjects:</span>
                                @foreach($tutor->subjects as $subject)
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 mb-2">{{ $subject->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
</div>
@endsection