@extends('layouts.tutor')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Tutor Dashboard</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600">Upcoming Sessions</h3>
            <p class="text-4xl font-bold text-blue-500">{{ $sessions->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600">Total Earnings</h3>
            <p class="text-4xl font-bold text-green-500">₹{{ number_format($totalEarnings, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-600">Pending Payments</h3>
            <p class="text-4xl font-bold text-yellow-500">₹{{ number_format($pendingPayments, 2) }}</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4 text-gray-800">Your Calendar</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($sessions->isEmpty())
            <p class="text-gray-500">You have no upcoming sessions.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($sessions as $session)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="text-lg font-semibold text-gray-800">
                                Session with {{ $session->student->name }}
                            </p>
                           </div>
                        <div>
                        @if($session->status === 'scheduled')
                            <a href="{{ route('tutor.session.manage', $session->id) }}" class="px-3 py-1 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors">Manage</a>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($session->status) }}
                            </span>
                        @endif
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection