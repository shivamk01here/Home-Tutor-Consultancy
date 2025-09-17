@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-600">Total Students</h3>
            <p class="text-4xl font-bold text-blue-500">{{ $totalStudents }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-600">Total Tutors</h3>
            <p class="text-4xl font-bold text-green-500">{{ $totalTutors }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-600">Pending Tutors</h3>
            <p class="text-4xl font-bold text-red-500">{{ $pendingTutors->count() }}</p>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-4 text-gray-800">Pending Tutor Applications</h2>
    <div class="bg-white p-6 rounded-lg shadow-md">
        @if($pendingTutors->isEmpty())
            <p class="text-gray-500">No new tutor applications pending.</p>
        @else
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qualification</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Experience</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($pendingTutors as $tutor)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tutor->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tutor->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tutor->tutorProfile->qualification }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $tutor->tutorProfile->experience_years }} years</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <form action="{{ route('admin.tutor.verify', $tutor->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Verify</button>
                                </form>
                                <form action="{{ route('admin.tutor.delete', $tutor->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection