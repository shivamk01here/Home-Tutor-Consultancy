@extends('layouts.student')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">My Sessions</h1>
<div class="bg-white p-6 rounded-lg shadow-md">
    <ul class="divide-y divide-gray-200">
        @forelse($sessions as $session)
        <li class="py-4">
            <div class="flex justify-between items-center">
                <div>
                    <h3 class="font-bold">{{ $session->tutorPackage->subject->name }} with {{ $session->tutor->name }}</h3>
                    <p class="text-sm text-gray-600">
                        Date: {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }} at {{ \Carbon\Carbon::parse($session->session_time)->format('h:i A') }}
                    </p>
                    <p class="text-sm text-gray-500 capitalize">Package: {{ str_replace('_', ' ', $session->tutorPackage->package_type) }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                        @if($session->status == 'completed') bg-green-200 text-green-800
                        @elseif($session->status == 'pending') bg-yellow-200 text-yellow-800
                        @else bg-gray-200 text-gray-800 @endif">
                        {{ ucfirst($session->status) }}
                    </span>
                    <span class="block text-xs mt-1 text-gray-500">
                        Payment: {{ ucfirst(str_replace('_', ' ', $session->payment_status)) }}
                    </span>
                </div>
            </div>
        </li>
        @empty
        <p class="text-center text-gray-600">You have no booked sessions yet.</p>
        @endforelse
    </ul>
</div>
@endsection