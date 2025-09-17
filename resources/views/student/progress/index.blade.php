@extends('layouts.student')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">My Mock Test Progress</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    @forelse($results as $result)
    <div class="py-4 border-b last:border-b-0 flex justify-between items-center">
        <div>
            <h3 class="text-lg font-bold">{{ $result->mockTest->title }}</h3>
            <p class="text-sm text-gray-600">Score: {{ number_format($result->score, 2) }}%</p>
            <p class="text-sm text-gray-500">Submitted: {{ $result->submitted_at->diffForHumans() }}</p>
        </div>
        <div class="space-x-2">
            <a href="{{ route('student.mock-tests.results', $result->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white text-sm font-semibold py-2 px-4 rounded-full">See Results</a>
            <a href="{{ route('student.mock-tests.give', $result->mock_test_id) }}" class="bg-gray-500 hover:bg-gray-600 text-white text-sm font-semibold py-2 px-4 rounded-full">Retry</a>
        </div>
    </div>
    @empty
    <p class="text-center text-gray-600">You haven't attempted any mock tests yet.</p>
    @endforelse
</div>
@endsection