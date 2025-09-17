@extends('layouts.student')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Mock Test: {{ $mockTest->title }}</h1>
<form action="{{ route('student.mock-tests.submit', $mockTest->id) }}" method="POST">
    @csrf
    @foreach($mockTest->questions as $index => $question)
    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <p class="font-bold text-lg mb-4">Q{{ $index + 1 }}. {{ $question->question_text }}</p>
        <div class="space-y-2">
            @foreach(['A', 'B', 'C', 'D', 'E'] as $option)
                @if ($question->{'option_'.strtolower($option)})
                <label class="flex items-center space-x-2">
                    <input type="radio" name="q{{ $question->id }}" value="{{ $option }}" class="form-radio text-blue-600">
                    <span class="text-gray-700">{{ $option }}. {{ $question->{'option_'.strtolower($option)} }}</span>
                </label>
                @endif
            @endforeach
        </div>
    </div>
    @endforeach
    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded-full w-full">Submit Test</button>
</form>
@endsection