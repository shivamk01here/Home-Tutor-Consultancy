@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Choose Your Role</h2>
        <p class="text-center text-gray-600 mb-6">Are you a student or a tutor?</p>
        <div class="space-y-4">
            <a href="{{ route('register.student') }}" class="block w-full text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-3 px-4 rounded transition duration-200">
                Register as a Student
            </a>
            <a href="{{ route('register.tutor') }}" class="block w-full text-center bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded transition duration-200">
                Register as a Tutor
            </a>
        </div>
        <p class="mt-6 text-center text-sm text-gray-500">
            Already have an account? 
            <a href="{{ route('login') }}" class="font-semibold text-indigo-600 hover:text-indigo-500">
                Login here
            </a>
        </p>
    </div>
</div>
@endsection