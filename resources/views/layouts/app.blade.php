<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Trip System') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 min-h-screen">

<nav class="bg-white shadow">
    <div class="max-w-7xl mx-auto px-4 flex justify-between h-16 items-center">
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="font-bold text-lg text-indigo-600">Trip System</a>
            @auth
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('trips.index') }}" class="text-gray-700 hover:text-indigo-600">Trips</a>
                    <a href="{{ route('bookings.my') }}" class="text-gray-700 hover:text-indigo-600">My Bookings</a>
                @else
                    <a href="{{ route('admin.trips.index') }}" class="text-gray-700 hover:text-indigo-600">Manage Trips</a>
                    <a href="{{ route('admin.bookings.index') }}" class="text-gray-700 hover:text-indigo-600">Bookings</a>
                @endif
            @endauth
        </div>
        <div class="flex items-center gap-4">
            @auth
                <span class="text-sm text-gray-600">
                    {{ auth()->user()->name }}
                    <span class="ml-1 px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 uppercase">{{ auth()->user()->role }}</span>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm text-red-600 hover:underline">Logout</button>
                </form>
            @endauth
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto py-6 px-4">
    @if(session('success'))
        <div class="mb-4 p-3 rounded bg-green-100 text-green-800">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-3 rounded bg-red-100 text-red-800">{{ session('error') }}</div>
    @endif

    @yield('content')
</main>

</body>
</html>