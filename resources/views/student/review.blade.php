@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Review Your Session</h1>
    <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
        <div class="mb-6">
            <h2 class="text-2xl font-semibold mb-2 text-gray-800">Session with {{ $session->tutor->name }}</h2>
            <p class="text-gray-600"><strong>Subject:</strong> {{ $session->subject->name }}</p>
            <p class="text-gray-600"><strong>Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y') }}</p>
        </div>

        <form action="{{ route('student.review.submit', $session->id) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="rating" class="block text-gray-700 font-semibold mb-2">Rating (1-5)</label>
                <input type="number" name="rating" id="rating" min="1" max="5" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required>
            </div>
            
            <div class="mb-6">
                <label for="comment" class="block text-gray-700 font-semibold mb-2">Comment (Optional)</label>
                <textarea name="comment" id="comment" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" placeholder="Share your experience..."></textarea>
            </div>
            
            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                Submit Review
            </button>
        </form>
    </div>
</div>
@endsection