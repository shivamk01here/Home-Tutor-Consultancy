@extends('layouts.app')

@section('content')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <h1 class="text-6xl font-extrabold text-gray-900 dark:text-white">Home Tutor Consultancy</h1>
        </div>
        <p class="mt-4 text-center sm:text-left text-xl text-gray-600 dark:text-gray-400">
            Connecting students with verified, qualified tutors for personalized learning.
        </p>

        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            For Students & Parents
                        </div>
                    </div>
                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            Find the perfect tutor for your child based on subject, location, and budget. Track their progress transparently.
                        </div>
                        <a href="{{ route('student.discovery') }}" class="block mt-4 text-blue-500 hover:text-blue-700 font-semibold">
                            Find a Tutor &rarr;
                        </a>
                    </div>
                </div>

                <div class="p-6 border-t border-gray-200 dark:border-gray-700 md:border-t-0 md:border-l">
                    <div class="flex items-center">
                        <div class="ml-4 text-lg leading-7 font-semibold text-gray-900 dark:text-white">
                            For Tutors
                        </div>
                    </div>
                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            Join our trusted network, manage your schedule, and grow your teaching business with a reliable platform.
                        </div>
                        <a href="{{ route('register.tutor') }}" class="block mt-4 text-green-500 hover:text-green-700 font-semibold">
                            Become a Tutor &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
            <div class="text-center text-sm text-gray-500 sm:text-left">
                &copy; {{ date('Y') }} Home Tutor Consultancy. All Rights Reserved.
            </div>
        </div>
    </div>
</div>
@endsection