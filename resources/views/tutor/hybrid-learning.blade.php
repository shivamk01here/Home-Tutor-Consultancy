@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">My Learning Resources</h1>
    <div class="bg-white p-8 rounded-lg shadow-md mb-6">
        <h2 class="text-2xl font-bold mb-4">Upload a New Resource</h2>
        <form action="{{ route('tutor.resources.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Resource Title</label>
                <input type="text" name="title" id="title" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required>
            </div>
            <div class="mb-4">
                <label for="file" class="block text-gray-700 font-semibold mb-2">Upload File</label>
                <input type="file" name="file" id="file" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" required>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded transition duration-200">
                Upload Resource
            </button>
        </form>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4">My Uploaded Resources</h2>
        @if($resources->isEmpty())
            <p class="text-gray-500">You have not uploaded any resources yet.</p>
        @else
            <ul class="divide-y divide-gray-200">
                @foreach($resources as $resource)
                    <li class="py-4 flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $resource->title }}</p>
                            <p class="text-sm text-gray-600">Uploaded: {{ $resource->created_at->format('F j, Y') }}</p>
                        </div>
                        <a href="{{ Storage::url($resource->file_path) }}" target="_blank" class="text-blue-500 hover:underline">Download</a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection