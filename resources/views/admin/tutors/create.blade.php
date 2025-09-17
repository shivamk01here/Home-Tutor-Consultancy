@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Add New Tutor</h1>
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <form action="{{ route('admin.tutors.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Basic Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Name</label>
                <input type="text" name="name" id="name" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="profile_photo" class="block text-gray-700 font-semibold mb-2">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" class="w-full">
            </div>
            <div>
                <label for="identity_proof" class="block text-gray-700 font-semibold mb-2">Identity Proof (PDF/DOC)</label>
                <input type="file" name="identity_proof" id="identity_proof" class="w-full">
            </div>
            <div>
                <label for="location_id" class="block text-gray-700 font-semibold mb-2">Location</label>
                <select name="location_id" id="location_id" class="border rounded-md px-3 py-2 w-full">
                    @foreach($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <h2 class="text-xl font-semibold mb-4">Tutor Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="qualification" class="block text-gray-700 font-semibold mb-2">Qualification</label>
                <input type="text" name="qualification" id="qualification" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="experience_years" class="block text-gray-700 font-semibold mb-2">Experience (Years)</label>
                <input type="number" name="experience_years" id="experience_years" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="current_designation" class="block text-gray-700 font-semibold mb-2">Current Designation</label>
                <input type="text" name="current_designation" id="current_designation" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating</label>
                <input type="number" name="rating" id="rating" step="0.1" min="0" max="5" class="border rounded-md px-3 py-2 w-full">
            </div>
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Subjects & Rates</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($subjects as $subject)
                <div class="flex items-center space-x-2">
                    <input type="checkbox" name="subject_ids[]" id="subject_{{ $subject->id }}" value="{{ $subject->id }}" class="form-checkbox">
                    <label for="subject_{{ $subject->id }}" class="text-gray-700">{{ $subject->name }}</label>
                    <input type="number" name="hourly_rates[{{ $subject->id }}]" placeholder="Rate" class="border rounded-md px-2 py-1 w-24">
                </div>
                @endforeach
            </div>
        </div>
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Packages (JSON)</h3>
            <textarea name="packages" id="packages" rows="4" class="border rounded-md w-full p-2" placeholder='{"package1": "description", "package2": "description"}'></textarea>
        </div>
        
        <div class="mb-6">
            <label for="is_verified" class="inline-flex items-center">
                <input type="checkbox" name="is_verified" id="is_verified" class="form-checkbox h-5 w-5 text-blue-600">
                <span class="ml-2 text-gray-700 font-semibold">Verified?</span>
            </label>
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded w-full">Add Tutor</button>
    </form>
</div>
@endsection