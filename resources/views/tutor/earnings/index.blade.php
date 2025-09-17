@extends('layouts.tutor')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">My Earnings</h1>
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <h2 class="text-2xl font-bold">Total Earnings: <span class="text-green-600">₹{{ number_format($totalEarnings, 2) }}</span></h2>
</div>
<div class="bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-semibold mb-4">Completed Sessions</h2>
    <ul class="divide-y divide-gray-200">
        @forelse($completedSessions as $session)
        <li class="py-4">
            <h3 class="font-bold">Session with {{ $session->student->name }}</h3>
            <p class="text-sm text-gray-600">Subject: {{ $session->tutorPackage->subject->name }}</p>
            <p class="text-sm text-gray-500">
                Date: {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }} | Amount: ₹{{ $session->tutorPackage->rate }}
            </p>
        </li>
        @empty
        <p class="text-center text-gray-600">No completed sessions yet.</p>
        @endforelse
    </ul>
</div>
@endsection