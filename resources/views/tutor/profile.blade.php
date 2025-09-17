@extends('layouts.tutor')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">My Profile</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <form action="{{ route('tutor.profile.update') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                <textarea name="bio" id="bio" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">{{ $tutor->tutorProfile->bio }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="hourly_rate" class="block text-gray-700 text-sm font-bold mb-2">Hourly Rate (₹)</label>
                <input type="number" name="hourly_rate" id="hourly_rate" value="{{ old('hourly_rate', $tutor->subjects->first()->pivot->hourly_rate ?? '') }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Subjects Taught</label>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @foreach($allSubjects as $subject)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}" class="form-checkbox h-4 w-4 text-blue-600"
                                @if(in_array($subject->id, $tutorSubjects)) checked @endif>
                            <span class="ml-2 text-gray-700">{{ $subject->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
            @if($tutor->tutorProfile->packages)
            <div class="bg-gray-100 p-6 rounded-lg mb-6">
                <h3 class="text-xl font-bold mb-4">Packages Offered</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @if(isset($tutor->tutorProfile->packages['offline']))
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h4 class="font-bold text-gray-800">{{ $tutor->tutorProfile->packages['offline']['title'] }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $tutor->tutorProfile->packages['offline']['description'] }}</p>
                    </div>
                    @endif
                    @if(isset($tutor->tutorProfile->packages['online']))
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h4 class="font-bold text-gray-800">{{ $tutor->tutorProfile->packages['online']['title'] }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $tutor->tutorProfile->packages['online']['description'] }}</p>
                    </div>
                    @endif
                    @if(isset($tutor->tutorProfile->packages['one_on_one']))
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <h4 class="font-bold text-gray-800">{{ $tutor->tutorProfile->packages['one_on_one']['title'] }}</h4>
                        <p class="text-sm text-gray-600 mt-1">{{ $tutor->tutorProfile->packages['one_on_one']['description'] }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Update Profile
                </button>
            </div>
        </form>
    </div>
</div>
@endsection