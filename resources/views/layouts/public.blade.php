<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Segunda Marcha')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
{{-- flex flex-col min-h-screen empuja el footer al final aunque la página tenga poco contenido --}}
<body class="font-sans antialiased bg-gray-50 flex flex-col min-h-screen">

    @include('layouts.partials.navbar')

    <main class="flex-1">
        @include('layouts.partials.flash')
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @livewireScripts
</body>
</html>
