@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">My Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-600">Upcoming Sessions</h3>
            @if($upcomingSessions->isEmpty())
                <p class="text-gray-500">You have no upcoming sessions.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($upcomingSessions as $session)
                        <li class="py-4">
                            <p class="text-lg font-semibold text-gray-800">Session with {{ $session->tutor->name }}</p>
                            <p class="text-sm text-gray-600">{{ $session->subject->name }} on {{ \Carbon\Carbon::parse($session->session_date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($session->start_time)->format('h:i A') }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold mb-4 text-gray-600">My Progress Reports</h3>
            @if($progressReports->isEmpty())
                <p class="text-gray-500">No progress reports available yet.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($progressReports as $report)
                        <li class="py-4">
                            <p class="font-semibold text-gray-800">{{ $report->subject->name }} - {{ \Carbon\Carbon::parse($report->session_date)->format('F j, Y') }}</p>
                            <p class="text-sm text-gray-600">Tutor: {{ $report->tutor->name }}</p>
                            <p class="text-sm text-gray-700 mt-2">{{ $report->tutor_notes }}</p>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection