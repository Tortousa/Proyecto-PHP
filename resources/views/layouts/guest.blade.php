<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Segunda Marcha')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-900 flex flex-col min-h-screen items-center justify-center px-4">

    {{-- Logo centrado --}}
    <a href="{{ route('home') }}" class="flex flex-col items-center mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-20 w-auto drop-shadow-xl">
        <span class="text-white font-bold text-xl mt-2">Segunda Marcha</span>
    </a>

    {{-- Card del formulario --}}
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        @yield('content')
    </div>

    <p class="text-gray-600 text-xs mt-6">
        &copy; {{ date('Y') }} Segunda Marcha · Desarrollado por Daniel Tortosa Burtseva
    </p>

</body>
</html>
