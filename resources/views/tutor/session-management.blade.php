@extends('layouts.tutor')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Manage Session</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2 text-gray-800">Details</h2>
            <p class="text-gray-600"><strong>Student:</strong> {{ $session->student->name }}</p>
            <p class="text-gray-600"><strong>Subject:</strong> {{ $session->subject->name }}</p>
            <p class="text-gray-600"><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y') }}</p>
            <p class="text-gray-600"><strong>Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('h:i A') }}</p>
        </div>

        <form action="{{ route('tutor.session.complete', $session->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="tutor_notes" class="block text-gray-700 font-semibold mb-2">Session Notes / Progress Report</label>
                <textarea name="tutor_notes" id="tutor_notes" rows="6" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" placeholder="Write detailed notes on the student's progress, topics covered, and homework assigned."></textarea>
                @error('tutor_notes')<p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>@enderror
            </div>
            
            <div class="mb-6">
                <label for="session_status" class="block text-gray-700 font-semibold mb-2">Session Status</label>
                <select name="session_status" id="session_status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline">
                    <option value="completed">Completed</option>
                    <option value="canceled">Canceled</option>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                Submit Report & Update Status
            </button>
        </form>
    </div>
</div>
@endsection