@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Student Feedback</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-2xl font-bold text-center">
        Average Rating: <span class="text-blue-600">{{ number_format($averageRating, 1) }} / 5</span>
    </h2>
</div>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">All Feedback Submissions</h2>
    <ul class="divide-y divide-gray-200">
        @forelse($feedbacks as $feedback)
        <li class="py-4">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-gray-800">{{ $feedback->user->name }}</h3>
                <div class="flex items-center space-x-2">
                    <span class="text-sm font-semibold">Rating: {{ $feedback->rating }}/5</span>
                </div>
            </div>
            <div class="mt-2 text-gray-700 space-y-2">
                @if($feedback->likes)<p class="text-green-600 font-semibold">Likes: {{ $feedback->likes }}</p>@endif
                @if($feedback->dislikes)<p class="text-red-600 font-semibold">Dislikes: {{ $feedback->dislikes }}</p>@endif
                @if($feedback->suggestions)<p class="text-gray-800 font-semibold">Suggestions: {{ $feedback->suggestions }}</p>@endif
            </div>
        </li>
        @empty
        <p class="text-center text-gray-600">No feedback has been submitted yet.</p>
        @endforelse
    </ul>
</div>
@endsection