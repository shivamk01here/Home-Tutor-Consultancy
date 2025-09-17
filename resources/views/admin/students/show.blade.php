@extends('layouts.admin')

@section('content')
<h1 class="text-3xl font-bold mb-6 text-gray-800">Student Details</h1>
<div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
    <div class="flex items-center space-x-6 mb-6">
        <img src="{{ asset('storage/' . $student->profile_photo_path) }}" alt="Student Photo" class="w-32 h-32 rounded-full object-cover">
        <div>
            <h2 class="text-2xl font-bold">{{ $student->name }}</h2>
            <p class="text-gray-600">Enrolled through Admin</p>
        </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <h3 class="text-xl font-semibold mb-2">Personal Information</h3>
            <ul class="space-y-2 text-gray-700">
                <li><strong>Email:</strong> {{ $student->email }}</li>
                <p class="text-sm text-gray-500">
    Parent: {{ $student->studentProfile?->parent_name }}
</p>
                <li><strong>Parent's Contact: {{ $student->studentProfile?->parent_contact }}
</p>

                <li><strong>Location:</strong> {{ $student->studentProfile->location->name ?? 'N/A' }}</li>
            </ul>
        </div>
        <div>
            <h3 class="text-xl font-semibold mb-2">Subjects of Interest</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($student->subjectsOfInterest as $subject)
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded-full">
                    {{ $subject->name }}
                </span>
                @endforeach
            </div>
        </div>
        <div>
            <h3 class="text-xl font-semibold mb-2">Billing History</h3>
            @if($payments->isEmpty())
            <p class="text-gray-500">No billing history found.</p>
            @else
            <ul class="divide-y divide-gray-200">
                @foreach($payments as $payment)
                <li class="py-2">
                    <p class="font-semibold">{{ $payment->created_at->format('M d, Y') }} - ₹{{ number_format($payment->amount, 2) }}</p>
                    <p class="text-sm text-gray-600">Session ID: {{ $payment->session_id }}</p>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>
@endsection