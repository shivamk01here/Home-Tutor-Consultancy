@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Payment Management</h1>
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($sessions->isEmpty())
            <p class="text-gray-500">No completed sessions to track payments for.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Session</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tutor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($sessions as $session)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $session->subject->name }} on {{ \Carbon\Carbon::parse($session->session_date)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $session->tutor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $session->student->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($session->payment && $session->payment->status === 'paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Paid</span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if(!$session->payment || $session->payment->status !== 'paid')
                                    <form action="{{ route('admin.payments.mark', $session->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900">Mark as Paid</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection