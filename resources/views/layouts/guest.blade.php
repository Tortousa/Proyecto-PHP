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
</head>
<body class="font-sans antialiased flex min-h-screen">

    {{-- Left panel (decorative) --}}
    <div class="hidden lg:flex lg:w-1/2 hero-gradient relative overflow-hidden flex-col justify-between p-12">
        {{-- Background blobs --}}
        <div class="absolute inset-0 pointer-events-none" aria-hidden="true">
            <div class="absolute top-0 right-0 w-80 h-80 rounded-full opacity-10"
                 style="background: radial-gradient(circle, #FACC15, transparent 70%)"></div>
            <div class="absolute bottom-0 left-0 w-60 h-60 rounded-full opacity-[0.06]"
                 style="background: radial-gradient(circle, #4F46E5, transparent 70%)"></div>
            <div class="absolute inset-0 opacity-[0.03]"
                 style="background-image: linear-gradient(rgba(255,255,255,0.4) 1px, transparent 1px),
                                          linear-gradient(90deg, rgba(255,255,255,0.4) 1px, transparent 1px);
                        background-size: 48px 48px;"></div>
        </div>

        {{-- Top --}}
        <a href="{{ route('home') }}" class="relative flex items-center gap-3 group w-fit">
            <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha"
                 class="h-10 w-auto transition-transform duration-200 group-hover:scale-105">
            <span class="text-white font-bold text-xl tracking-tight">
                Segunda<span class="text-yellow-400"> Marcha</span>
            </span>
        </a>

        {{-- Center --}}
        <div class="relative">
            <h2 class="text-4xl xl:text-5xl font-black text-white leading-tight tracking-tight text-balance">
                El marketplace de coches más<br>
                <span class="text-gradient-yellow">inteligente.</span>
            </h2>
            <p class="text-gray-400 mt-5 text-lg leading-relaxed max-w-sm">
                Miles de vehículos verificados. Sin comisiones. Gratis para publicar.
            </p>

            <div class="flex flex-col gap-3 mt-8">
                @foreach(['Sin comisiones ocultas', '100% gratuito para publicar', 'Anuncios visibles al instante'] as $feat)
                <div class="flex items-center gap-3 text-gray-400 text-sm">
                    <div class="w-5 h-5 rounded-full bg-yellow-400 flex items-center justify-center shrink-0">
                        <svg class="h-3 w-3 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    {{ $feat }}
                </div>
                @endforeach
            </div>
        </div>

        {{-- Bottom --}}
        <p class="relative text-xs text-gray-600">
            &copy; {{ date('Y') }} Segunda Marcha
        </p>
    </div>

    {{-- Right panel (form) --}}
    <div class="flex-1 bg-gray-50 flex flex-col items-center justify-center px-6 py-12">

        {{-- Mobile logo --}}
        <a href="{{ route('home') }}" class="lg:hidden flex items-center gap-2 mb-10">
            <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-10 w-auto">
            <span class="text-gray-900 font-bold text-lg">Segunda<span class="text-yellow-500"> Marcha</span></span>
        </a>

        <div class="w-full max-w-sm">
            <div class="card p-8 shadow-premium">
                @yield('content')
            </div>

            <p class="text-center text-xs text-gray-400 mt-6">
                &copy; {{ date('Y') }} Segunda Marcha · Daniel Tortosa Burtseva
            </p>
        </div>
    </div>

</body>
</html>
