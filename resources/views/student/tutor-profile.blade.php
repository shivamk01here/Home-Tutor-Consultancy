@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-4xl mx-auto">
        <div class="md:flex">
            <div class="md:flex-shrink-0">
                <img src="{{ $tutor->profile_photo_path ? asset('storage/' . $tutor->profile_photo_path) : 'https://via.placeholder.com/200' }}" alt="Tutor Photo" class="w-48 h-48 rounded-full mx-auto md:mx-0 object-cover">
            </div>
            <div class="mt-4 md:mt-0 md:ml-6 text-center md:text-left">
                <h1 class="text-3xl font-bold text-gray-900">{{ $tutor->name }}</h1>
                <p class="text-xl text-gray-600">{{ $tutor->tutorProfile->qualification }}</p>
                <div class="flex items-center justify-center md:justify-start mt-2">
                    <div class="text-yellow-400">
                        @for($i = 0; $i < round($tutor->tutorProfile->rating); $i++) ⭐ @endfor
                        <span class="text-gray-500 text-sm">({{ number_format($tutor->tutorProfile->rating, 1) }})</span>
                    </div>
                    @if($tutor->is_verified)
                        <span class="ml-2 text-blue-500 font-bold text-sm">Verified Tutor</span>
                    @endif
                </div>
                <p class="mt-4 text-gray-700">{{ $tutor->tutorProfile->bio }}</p>
                
                <h3 class="text-lg font-bold mt-6 mb-2">Subjects & Pricing</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($tutor->subjects as $subject)
                        <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                            {{ $subject->name }} (₹{{ $subject->pivot->hourly_rate }}/hr)
                        </span>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Book a Session</h3>
            <form action="{{ route('student.book.session') }}" method="POST">
                @csrf
                <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="subject_id" class="block text-gray-700 font-semibold">Subject</label>
                        <select name="subject_id" id="subject_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            @foreach($tutor->subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="session_date" class="block text-gray-700 font-semibold">Date</label>
                        <input type="date" name="session_date" id="session_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="start_time" class="block text-gray-700 font-semibold">Start Time</label>
                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div>
                        <label for="end_time" class="block text-gray-700 font-semibold">End Time</label>
                        <input type="time" name="end_time" id="end_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>
                <div class="mt-6">
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-200">
                        Book Session
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8">
            <h3 class="text-2xl font-bold mb-4">Reviews</h3>
            @if($reviews->isEmpty())
                <p class="text-gray-500">No reviews yet.</p>
            @else
                <div class="space-y-4">
                    @foreach($reviews as $review)
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="flex items-center mb-2">
                                <div class="font-semibold text-gray-800">{{ $review->student->name }}</div>
                                <div class="ml-auto text-sm text-yellow-400">
                                    @for($i = 0; $i < $review->rating; $i++) ⭐ @endfor
                                </div>
                            </div>
                            <p class="text-gray-600 italic">"{{ $review->comment }}"</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection