@extends('layouts.tutor')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">My Packages</h1>

<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-xl font-semibold mb-4">Create New Package</h2>
    <form action="{{ route('tutor.packages.create') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="subject_id" class="block text-gray-700">Subject</label>
            <select name="subject_id" id="subject_id" class="border rounded-md p-2 w-full">
                @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="package_type" class="block text-gray-700">Package Type</label>
            <select name="package_type" id="package_type" class="border rounded-md p-2 w-full">
                <option value="one_on_one">One-on-One</option>
                <option value="online_batch">Online (Batch)</option>
                <option value="offline">Offline</option>
            </select>
        </div>
        <div class="flex space-x-4">
            <div class="w-1/2">
                <label for="rate" class="block text-gray-700">Rate</label>
                <input type="number" name="rate" id="rate" class="border rounded-md p-2 w-full" required>
            </div>
            <div class="w-1/2">
                <label for="rate_unit" class="block text-gray-700">Rate Unit</label>
                <select name="rate_unit" id="rate_unit" class="border rounded-md p-2 w-full">
                    <option value="per_hour">Per Hour</option>
                    <option value="per_month">Per Month</option>
                </select>
            </div>
        </div>
        <div>
            <label for="description" class="block text-gray-700">Description</label>
            <textarea name="description" id="description" rows="3" class="border rounded-md p-2 w-full"></textarea>
        </div>
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded-full transition duration-200">
            Create Package
        </button>
    </form>
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Existing Packages</h2>
    <ul class="divide-y divide-gray-200">
        @forelse($packages as $package)
        <li class="py-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold capitalize">{{ str_replace('_', ' ', $package->package_type) }}</h3>
                <p class="text-gray-600">Subject: {{ $package->subject->name }}</p>
                <p class="text-gray-600">Rate: ₹{{ $package->rate }} {{ str_replace('_', ' ', $package->rate_unit) }}</p>
                @if($package->description)
                    <p class="text-sm text-gray-500 mt-1">{{ $package->description }}</p>
                @endif
            </div>
            </li>
        @empty
        <p class="text-center text-gray-600">You have not created any packages yet.</p>
        @endforelse
    </ul>
</div>
@endsection