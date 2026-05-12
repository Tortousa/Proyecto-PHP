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
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    @include('layouts.navigation')

    @hasSection('header')
        <header class="bg-gray-900 border-b border-gray-800">
            <div class="max-w-7xl mx-auto py-5 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    <main class="flex-1 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('layouts.partials.flash')
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.footer')

    @livewireScripts
</body>
</html>
