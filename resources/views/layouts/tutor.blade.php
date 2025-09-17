<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex">
    <aside class="w-64 bg-green-600 text-white min-h-screen p-4">
        <div class="text-2xl font-bold mb-6">Tutor Panel</div>
        <nav>
            <a href="{{ route('tutor.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700">
                <i class="fas fa-home mr-2"></i> Dashboard
            </a>
            <a href="{{ route('tutor.profile.show') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700">
                <i class="fas fa-user-circle mr-2"></i> My Profile
            </a>
            <a href="{{ route('tutor.resources') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700">
                <i class="fas fa-folder-open mr-2"></i> Resources
            </a>
            <a href="#" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-green-700">
                <i class="fas fa-calendar-alt mr-2"></i> Schedule
            </a>
        </nav>
        <div class="mt-auto pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-2.5 px-4 rounded transition duration-200 hover:bg-green-700">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</body>
</html> 