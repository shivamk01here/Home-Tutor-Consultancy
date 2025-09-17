@extends('layouts.student')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex items-center space-x-6">
            <div class="flex-shrink-0">
                <img class="h-24 w-24 object-cover rounded-full border-4 border-gray-200" src="{{ $tutor->tutorProfile->profile_photo_path ? asset('storage/' . $tutor->tutorProfile->profile_photo_path) : 'https://ui-avatars.com/api/?name=' . urlencode($tutor->name) }}" alt="{{ $tutor->name }}'s profile photo">
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $tutor->name }}</h1>
                <p class="text-gray-600">{{ $tutor->tutorProfile->current_designation ?? 'Tutor' }}</p>
                <div class="mt-2 text-sm text-gray-500 flex items-center space-x-4">
                    <span><i class="fas fa-map-marker-alt"></i> {{ $tutor->tutorProfile->location->name ?? 'N/A' }}</span>
                    <span><i class="fas fa-star text-yellow-400"></i> {{ number_format($tutor->tutorProfile->rating ?? 0, 1) }}/5</span>
                    <span><i class="fas fa-briefcase"></i> {{ $tutor->tutorProfile->experience_years ?? 'N/A' }} years exp.</span>
                </div>
            </div>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800">About Me</h2>
            <p class="mt-2 text-gray-600">{{ $tutor->tutorProfile->bio ?? 'No bio available.' }}</p>
        </div>
        <div class="mt-6">
            <h2 class="text-xl font-semibold text-gray-800">Subjects I Teach</h2>
            <div class="mt-2 flex flex-wrap gap-2">
                @forelse($tutor->subjects as $subject)
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $subject->name }}</span>
                @empty
                <p class="text-gray-500 text-sm">No subjects listed yet.</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md mb-6">
        <h2 class="text-xl font-bold mb-4">Packages Offered</h2>
        @forelse($tutor->tutorPackages->groupBy('package_type') as $type => $packages)
        <div class="mb-4">
            <h3 class="font-bold text-lg capitalize mb-2">{{ str_replace('_', ' ', $type) }}</h3>
            <ul class="space-y-3">
                @foreach($packages as $package)
                <li class="p-4 bg-gray-50 rounded-lg flex justify-between items-center border border-gray-200">
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $package->subject->name }}</h4>
                        <p class="text-sm text-gray-600 mt-1">
                            <span class="font-bold">Rate:</span> ₹{{ $package->rate }} {{ str_replace('_', ' ', $package->rate_unit) }}
                        </p>
                        @if($package->description)
                            <p class="text-xs text-gray-500 mt-1">{{ $package->description }}</p>
                        @endif
                    </div>
                    @if($package->package_type === 'one_on_one')
                        <button id="bookBtn{{ $package->id }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full transition duration-200">Book Now</button>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @empty
        <p class="text-gray-500 text-center">This tutor has not created any packages yet.</p>
        @endforelse
    </div>

    <div id="bookingModal" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Book a Session</h3>
                <button id="closeModalBtn" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <form id="bookingForm" action="{{ route('student.book.session') }}" method="POST">
                @csrf
                <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                <input type="hidden" name="tutor_package_id" id="packageIdInput">
                <div class="mb-4">
                    <label for="session_date" class="block text-gray-700">Date</label>
                    <input type="date" name="session_date" id="session_date" class="border rounded-md p-2 w-full" required>
                </div>
                <div class="mb-4">
                    <label for="session_time" class="block text-gray-700">Time</label>
                    <input type="time" name="session_time" id="session_time" class="border rounded-md p-2 w-full" required>
                </div>
                <div class="flex items-center space-x-2">
                    <input type="radio" name="payment_method" value="cod" id="cod" checked>
                    <label for="cod">Cash on Delivery (COD)</label>
                </div>
                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full mt-4">Confirm Booking</button>
            </form>
        </div>
    </div>
    
    
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Tutor Resources</h2>
        @forelse($tutor->resources as $resource)
        <div class="py-2 border-b last:border-b-0 flex justify-between items-center">
            <span class="font-semibold">{{ $resource->title }}</span>
            <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="text-blue-500 hover:underline">View Document</a>
        </div>
        @empty
        <p class="text-gray-500 text-center">This tutor has not uploaded any resources yet.</p>
        @endforelse
    </div>
</div>

<script>
    document.querySelectorAll('[id^="bookBtn"]').forEach(btn => {
        btn.addEventListener('click', function() {
            const packageId = this.id.replace('bookBtn', '');
            document.getElementById('packageIdInput').value = packageId;
            document.getElementById('bookingModal').classList.remove('hidden');
        });
    });
    document.getElementById('closeModalBtn').addEventListener('click', function() {
        document.getElementById('bookingModal').classList.add('hidden');
    });
</script>
@endsection