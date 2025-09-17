<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Tutor Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* A simple style to make active links stand out */
        .nav-link.active {
            font-weight: bold;
            color: #3B82F6; /* Blue-500 */
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-xl font-bold text-gray-800">Home Tutor</a>
            <div class="space-x-4">
                @guest
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-800 transition duration-200">Login</a>
                    <a href="{{ route('register.choice') }}" class="text-gray-600 hover:text-gray-800 transition duration-200">Register</a>
                @else
                    @if(Auth::user()->role->name === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link text-gray-600 hover:text-gray-800">Dashboard</a>
                    @elseif(Auth::user()->role->name === 'tutor')
                        <a href="{{ route('tutor.dashboard') }}" class="nav-link text-gray-600 hover:text-gray-800">Dashboard</a>
                        <a href="{{ route('tutor.profile.show') }}" class="nav-link text-gray-600 hover:text-gray-800">My Profile</a>
                    @elseif(Auth::user()->role->name === 'student')
                        <a href="{{ route('student.dashboard') }}" class="nav-link text-gray-600 hover:text-gray-800">My Dashboard</a>
                        <a href="{{ route('student.discovery') }}" class="nav-link text-gray-600 hover:text-gray-800">Find a Tutor</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800 transition duration-200">Logout</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    <main class="py-6">
        @if(session('success'))
            <div class="container mx-auto px-4 mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="container mx-auto px-4 mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                {{ session('error') }}
            </div>
        @endif
        @yield('content')
    </main>
</body>
</html>