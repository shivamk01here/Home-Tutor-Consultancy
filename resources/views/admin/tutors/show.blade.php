@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Tutor Details</h1>
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <div class="flex items-center space-x-6 mb-6">
        <img src="{{ asset('storage/' . $tutor->profile_photo_path) }}" alt="Tutor Photo" class="w-32 h-32 rounded-full object-cover">
        <div>
            <h2 class="text-2xl font-bold">{{ $tutor->name }}</h2>
            <p class="text-gray-600">{{ $tutor->tutorProfile->current_designation }}</p>
            <div class="mt-2">
                @if($tutor->is_verified)
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                @else
                <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending Verification</span>
                @endif
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-xl font-semibold mb-2">Personal Information</h3>
            <ul class="space-y-2 text-gray-700">
                <li><strong>Email:</strong> {{ $tutor->email }}</li>
                <li><strong>Qualification:</strong> {{ $tutor->tutorProfile->qualification }}</li>
                <li><strong>Location:</strong> {{ $tutor->tutorProfile->location->name ?? 'N/A' }}</li>
                <li><strong>Experience:</strong> {{ $tutor->tutorProfile->experience_years }} years</li>
                <li><strong>Rating:</strong> {{ number_format($tutor->tutorProfile->rating, 1) }} / 5</li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-semibold mb-2">Taught Subjects & Expertise</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($tutor->subjects as $subject)
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    {{ $subject->name }} (₹{{ $subject->pivot->hourly_rate }}/hr)
                </span>
                @endforeach
            </div>
        </div>
        @if($tutor->tutorProfile->packages)
        <div>
            <h3 class="text-xl font-semibold mb-2">Packages</h3>
            <ul class="list-disc list-inside text-gray-700">
                @foreach($tutor->tutorProfile->packages as $packageName => $description)
                <li><strong>{{ $packageName }}:</strong> {{ $description }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if($tutor->tutorProfile->identity_proof_path)
        <div>
            <h3 class="text-xl font-semibold mb-2">Documents (Admin Only)</h3>
            <a href="{{ Storage::url($tutor->tutorProfile->identity_proof_path) }}" target="_blank" class="text-blue-500 hover:underline">
                View Identity Proof
            </a>
        </div>
        @endif
    </div>
</div>
@endsection