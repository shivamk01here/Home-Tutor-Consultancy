<div class="bg-gray-100 p-6 rounded-lg">
    <h3 class="text-xl font-bold mb-4">Packages</h3>
    
    <h4 class="font-semibold mb-2">Offline Packages</h4>
    <div class="mb-4 space-y-2">
        <input type="text" name="packages_offline_title" placeholder="Title (e.g., In-person Group Classes)" class="border rounded-md p-2 w-full" value="{{ $tutor->tutorProfile->packages['offline']['title'] ?? '' }}">
        <textarea name="packages_offline_description" placeholder="Description..." class="border rounded-md p-2 w-full">{{ $tutor->tutorProfile->packages['offline']['description'] ?? '' }}</textarea>
    </div>

    <h4 class="font-semibold mb-2">Online (Limited Seats) Packages</h4>
    <div class="mb-4 space-y-2">
        <input type="text" name="packages_online_title" placeholder="Title (e.g., Online Batch Sessions)" class="border rounded-md p-2 w-full" value="{{ $tutor->tutorProfile->packages['online']['title'] ?? '' }}">
        <textarea name="packages_online_description" placeholder="Description..." class="border rounded-md p-2 w-full">{{ $tutor->tutorProfile->packages['online']['description'] ?? '' }}</textarea>
    </div>

    <h4 class="font-semibold mb-2">One-on-One Consultancy Packages</h4>
    <div class="mb-4 space-y-2">
        <input type="text" name="packages_one_on_one_title" placeholder="Title (e.g., Personalized Coaching)" class="border rounded-md p-2 w-full" value="{{ $tutor->tutorProfile->packages['one_on_one']['title'] ?? '' }}">
        <textarea name="packages_one_on_one_description" placeholder="Description..." class="border rounded-md p-2 w-full">{{ $tutor->tutorProfile->packages['one_on_one']['description'] ?? '' }}</textarea>
    </div>
</div>