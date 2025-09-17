@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Enroll New Student</h1>
<div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto">
    <form action="{{ route('admin.students.create') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-2">Student Name</label>
                <input type="text" name="name" id="name" class="border rounded-md px-3 py-2 w-full" required>
            </div>
            <div>
                <label for="surname" class="block text-gray-700 font-semibold mb-2">Student Surname</label>
                <input type="text" name="surname" id="surname" class="border rounded-md px-3 py-2 w-full">
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email" class="border rounded-md px-3 py-2 w-full" required>
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password</label>
                <input type="password" name="password" id="password" class="border rounded-md px-3 py-2 w-full" required>
            </div>
            <div>
                <label for="parent_name" class="block text-gray-700 font-semibold mb-2">Parent's Name</label>
                <input type="text" name="parent_name" id="parent_name" class="border rounded-md px-3 py-2 w-full" required>
            </div>
            <div>
                <label for="parent_contact" class="block text-gray-700 font-semibold mb-2">Parent's Contact</label>
                <input type="text" name="parent_contact" id="parent_contact" class="border rounded-md px-3 py-2 w-full" required>
            </div>
            <div>
                <label for="profile_photo" class="block text-gray-700 font-semibold mb-2">Profile Photo</label>
                <input type="file" name="profile_photo" id="profile_photo" class="w-full">
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
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-2">Subjects of Interest (Max 5)</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($subjects as $subject)
                <label class="inline-flex items-center">
                    <input type="checkbox" name="subjects_of_interest[]" value="{{ $subject->id }}" class="form-checkbox">
                    <span class="ml-2 text-gray-700">{{ $subject->name }}</span>
                </label>
                @endforeach
            </div>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded w-full">Enroll Student</button>
    </form>
</div>
@endsection