<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#111827">
    <title>@yield('title', 'Segunda Marcha')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('head')
</head>
<body class="font-sans antialiased bg-gray-900 flex flex-col min-h-screen">

    @include('layouts.navigation')

    @hasSection('header')
        <header class="bg-gray-900 border-b border-gray-800/80">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        </header>
    @endif

    <main class="flex-1 bg-gray-50 pt-5 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @include('layouts.partials.flash')
            @yield('content')
        </div>
    </main>

    @include('layouts.partials.footer')

    @livewireScripts
    @stack('scripts')
</body>
</html>
