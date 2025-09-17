@extends('layouts.student')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Give Us Your Feedback</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('student.feedback.submit') }}" method="POST" class="space-y-6">
        @csrf
        <div>
            <label for="likes" class="block text-gray-700 font-bold mb-2">What did you like?</label>
            <textarea name="likes" id="likes" rows="4" class="w-full p-3 border rounded-md"></textarea>
        </div>
        <div>
            <label for="dislikes" class="block text-gray-700 font-bold mb-2">What could be better? (Dislikes)</label>
            <textarea name="dislikes" id="dislikes" rows="4" class="w-full p-3 border rounded-md"></textarea>
        </div>
        <div>
            <label for="suggestions" class="block text-gray-700 font-bold mb-2">Any suggestions?</label>
            <textarea name="suggestions" id="suggestions" rows="4" class="w-full p-3 border rounded-md"></textarea>
        </div>
        <div>
            <label for="rating" class="block text-gray-700 font-bold mb-2">Your Rating</label>
            <select name="rating" id="rating" class="w-full p-3 border rounded-md">
                <option value="5">5 - Excellent</option>
                <option value="4">4 - Good</option>
                <option value="3">3 - Average</option>
                <option value="2">2 - Poor</option>
                <option value="1">1 - Very Poor</option>
            </select>
        </div>
        <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 rounded-full">Submit Feedback</button>
    </form>
</div>
@endsection