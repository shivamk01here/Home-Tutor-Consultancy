@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">Find the Perfect Tutor for You</h1>

    <div class="bg-white p-8 rounded-lg shadow-xl mb-8">
        <form action="{{ route('student.discovery') }}" method="GET" class="space-y-6">
            <div class="flex items-center justify-center">
                <input type="text" name="name" placeholder="Search by Tutor Name..." class="w-full max-w-2xl px-5 py-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200" value="{{ request('name') }}">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                <div>
                    <label for="subject_id" class="block text-gray-700 font-semibold mb-2">Subject</label>
                    <select name="subject_id" id="subject_id" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="location_id" class="block text-gray-700 font-semibold mb-2">Location</label>
                    <select name="location_id" id="location_id" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Locations</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->id }}" {{ request('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="min_rating" class="block text-gray-700 font-semibold mb-2">Min. Rating</label>
                    <select name="min_rating" id="min_rating" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Any</option>
                        <option value="4.5" {{ request('min_rating') == 4.5 ? 'selected' : '' }}>4.5 & Up</option>
                        <option value="4.0" {{ request('min_rating') == 4.0 ? 'selected' : '' }}>4.0 & Up</option>
                        <option value="3.5" {{ request('min_rating') == 3.5 ? 'selected' : '' }}>3.5 & Up</option>
                    </select>
                </div>
                <div>
                    <label for="min_experience" class="block text-gray-700 font-semibold mb-2">Min. Experience</label>
                    <select name="min_experience" id="min_experience" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Any</option>
                        <option value="1" {{ request('min_experience') == 1 ? 'selected' : '' }}>1+ Year</option>
                        <option value="3" {{ request('min_experience') == 3 ? 'selected' : '' }}>3+ Years</option>
                        <option value="5" {{ request('min_experience') == 5 ? 'selected' : '' }}>5+ Years</option>
                    </select>
                </div>
                <div>
                    <label for="min_rate" class="block text-gray-700 font-semibold mb-2">Min. Rate</label>
                    <input type="number" name="min_rate" id="min_rate" placeholder="₹" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('min_rate') }}">
                </div>
                <div>
                    <label for="max_rate" class="block text-gray-700 font-semibold mb-2">Max. Rate</label>
                    <input type="number" name="max_rate" id="max_rate" placeholder="₹" class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" value="{{ request('max_rate') }}">
                </div>
            </div>

            <div class="flex justify-center items-center space-x-4 pt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full transition duration-200">
                    Apply Filters
                </button>
                <a href="{{ route('student.discovery') }}" class="text-gray-600 hover:text-gray-800">Reset</a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($tutors as $tutor)
            <div class="bg-white p-6 rounded-lg shadow-md flex flex-col items-center text-center">
                @if($tutor->profile_photo_path)
                    <img src="{{ Storage::url($tutor->profile_photo_path) }}" alt="{{ $tutor->name }}" class="w-24 h-24 rounded-full object-cover mb-4">
                @else
                    <div class="w-24 h-24 rounded-full flex items-center justify-center bg-gray-200 text-gray-600 text-2xl font-bold mb-4">
                        {{ strtoupper(substr($tutor->name, 0, 1)) }}
                    </div>
                @endif
                
                <h3 class="text-xl font-bold text-gray-800">{{ $tutor->name }}</h3>
                <p class="text-gray-600">{{ $tutor->tutorProfile->qualification }}</p>
                
                <div class="mt-2 text-yellow-400">
                    @for ($i = 0; $i < floor($tutor->tutorProfile->rating); $i++)
                        <i class="fas fa-star"></i>
                    @endfor
                    @if ($tutor->tutorProfile->rating - floor($tutor->tutorProfile->rating) >= 0.5)
                        <i class="fas fa-star-half-alt"></i>
                    @endif
                    <span class="text-gray-500 text-sm ml-2">({{ number_format($tutor->tutorProfile->rating, 1) }})</span>
                </div>
                
                <div class="mt-4 flex flex-wrap justify-center gap-2">
                    @foreach($tutor->subjects as $subject)
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $subject->name }}</span>
                    @endforeach
                </div>
                
                <a href="{{ route('student.tutor.profile', $tutor->id) }}" class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-full transition duration-200">
                    View Profile
                </a>
            </div>
        @empty
            <div class="md:col-span-3 text-center py-10 bg-white rounded-lg shadow-md">
                <p class="text-gray-600 text-lg">No tutors found matching your criteria.</p>
                <p class="text-gray-500 text-sm mt-2">Try adjusting your filters or search terms.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8 flex justify-center">
        {{ $tutors->links() }}
    </div>
</div>
@endsection