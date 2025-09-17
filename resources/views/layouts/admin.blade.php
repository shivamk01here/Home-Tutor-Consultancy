<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 bg-gray-800 text-white min-h-screen p-4">
        <div class="text-2xl font-bold mb-6">Admin Panel</div>
        <nav>
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-book-open mr-2"></i> Subjects
            </a>
            <a href="{{ route('admin.tutors.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-chalkboard-teacher mr-2"></i> Tutors
            </a>
            <a href="{{ route('admin.students.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-user-graduate mr-2"></i> Students
            </a>
            <a href="{{ route('admin.payments') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-receipt mr-2"></i> Payments
            </a>
            <a href="{{ route('admin.topics.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-list-alt mr-2"></i> Topics
            </a>
            <a href="{{ route('admin.mock-tests.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                <i class="fas fa-clipboard-list mr-2"></i> Mock Tests
            </a>
        </nav>
        <div class="mt-auto pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <main class="flex-1 p-6">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>