@extends('layouts.tutor')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">My Sessions</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <ul class="divide-y divide-gray-200">
        @forelse($sessions as $session)
        <li class="py-4 flex justify-between items-center">
            <div>
                <h3 class="font-bold">Session with {{ $session->student->name }}</h3>
                <p class="text-sm text-gray-600">
                    Subject: {{ $session->tutorPackage->subject->name }} | Date: {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($session->session_time)->format('h:i A') }}
                </p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                    @if($session->status == 'completed') bg-green-200 text-green-800
                    @elseif($session->status == 'pending') bg-yellow-200 text-yellow-800 @endif">
                    {{ ucfirst($session->status) }}
                </span>
                @if($session->status === 'pending')
                <form action="{{ route('tutor.session.complete', $session->id) }}" method="POST" class="mt-2">
                    @csrf
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white text-sm font-bold py-1 px-4 rounded-full transition duration-200">
                        Mark as Completed
                    </button>
                </form>
                @endif
            </div>
        </li>
        @empty
        <p class="text-center text-gray-600">You have no upcoming sessions.</p>
        @endforelse
    </ul>
</div>
@endsection