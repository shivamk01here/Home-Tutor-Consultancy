@extends('layouts.student')

@section('content')
<div class="text-center bg-white p-8 rounded-lg shadow-md">
    <h1 class="text-4xl font-bold text-gray-800 mb-4">Test Submitted!</h1>
    <h2 class="text-xl font-semibold mb-6">Your Performance in: {{ $result->mockTest->title }}</h2>
    <div class="flex justify-center space-x-10 mb-8">
        <div class="bg-green-100 p-4 rounded-lg">
            <p class="text-3xl font-bold text-green-600">{{ $result->correct_answers }}</p>
            <p class="text-gray-600">Correct</p>
        </div>
        <div class="bg-red-100 p-4 rounded-lg">
            <p class="text-3xl font-bold text-red-600">{{ $result->incorrect_answers }}</p>
            <p class="text-gray-600">Incorrect</p>
        </div>
        <div class="bg-gray-100 p-4 rounded-lg">
            <p class="text-3xl font-bold text-gray-600">{{ $result->unattempted_questions }}</p>
            <p class="text-gray-600">Unattempted</p>
        </div>
    </div>
    <div class="mb-8">
        <h3 class="text-3xl font-bold">Score: {{ number_format($result->score, 2) }}%</h3>
    </div>
    <a href="{{ route('student.progress.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full transition duration-200">
        View All Progress
    </a>
</div>
@endsection