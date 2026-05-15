@extends('layouts.public')

@section('title', 'Segunda Marcha — Compra y vende tu coche')

@section('content')

{{-- ══════════════════════════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════════════════════════ --}}
<section class="relative hero-gradient min-h-screen flex items-center overflow-hidden">

    {{-- Ambient background blobs --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] rounded-full opacity-[0.07]"
             style="background: radial-gradient(circle, #FACC15, transparent 70%)"></div>
        <div class="absolute -bottom-60 -left-20 w-[500px] h-[500px] rounded-full opacity-[0.05]"
             style="background: radial-gradient(circle, #4F46E5, transparent 70%)"></div>
        {{-- Grid overlay --}}
        <div class="absolute inset-0 opacity-[0.03]"
             style="background-image: linear-gradient(rgba(255,255,255,0.5) 1px, transparent 1px),
                                      linear-gradient(90deg, rgba(255,255,255,0.5) 1px, transparent 1px);
                    background-size: 60px 60px;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 pb-24">
        <div class="max-w-3xl">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full border border-yellow-400/30
                        bg-yellow-400/10 text-yellow-400 text-xs font-semibold mb-6 animate-fade-up">
                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 animate-pulse"></span>
                {{ __('#1 marketplace for used cars') }}
            </div>

            <h1 class="text-5xl sm:text-6xl lg:text-7xl font-black text-white leading-[1.05] tracking-tight
                       text-balance animate-fade-up" style="animation-delay:0.05s">
                {{ __('Find your') }}<br>
                <span class="text-gradient-yellow">{{ __('perfect car.') }}</span>
            </h1>

            <p class="mt-6 text-lg sm:text-xl text-gray-400 leading-relaxed max-w-xl animate-fade-up"
               style="animation-delay:0.1s">
                {{ __('Thousands of verified vehicles. Transparent pricing. No hidden fees. The smartest way to buy or sell your car.') }}
            </p>

            {{-- Hero CTAs --}}
            <div class="flex flex-wrap gap-3 mt-10 animate-fade-up" style="animation-delay:0.15s">
                @guest
                    <a href="{{ route('register') }}"
                       class="btn-primary px-7 py-3.5 text-base font-bold animate-pulse-yellow">
                        {{ __('Post free listing') }}
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>
                    <a href="{{ route('login') }}"
                       class="btn px-7 py-3.5 text-base font-semibold text-gray-300 hover:text-white
                              border border-gray-700 hover:border-gray-500 rounded-[10px]
                              transition-all duration-200">
                        {{ __('Log in') }}
                    </a>
                @else
                    <a href="{{ route('cars.create') }}"
                       class="btn-primary px-7 py-3.5 text-base font-bold">
                        {{ __('+ List my car') }}
                    </a>
                    <a href="{{ route('dashboard') }}"
                       class="btn px-7 py-3.5 text-base font-semibold text-gray-300 hover:text-white
                              border border-gray-700 hover:border-gray-500 rounded-[10px]
                              transition-all duration-200">
                        {{ __('Go to dashboard') }}
                    </a>
                @endguest
            </div>

            {{-- Trust signals --}}
            <div class="flex flex-wrap items-center gap-6 mt-12 animate-fade-up" style="animation-delay:0.2s">
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('No commissions') }}
                </div>
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('100% free') }}
                </div>
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    {{ __('Available 24/7') }}
                </div>
            </div>
        </div>
    </div>

    {{-- Scroll indicator --}}
    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 animate-bounce">
        <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     STATS BAND
══════════════════════════════════════════════════════════════ --}}
<section class="bg-yellow-400 py-6">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-12 text-gray-900 text-center">
            <div>
                <p class="text-4xl font-black tabular-nums">+500</p>
                <p class="text-sm font-semibold mt-0.5 opacity-75">{{ __('Active listings') }}</p>
            </div>
            <div>
                <p class="text-4xl font-black tabular-nums">100%</p>
                <p class="text-sm font-semibold mt-0.5 opacity-75">{{ __('Post for free') }}</p>
            </div>
            <div>
                <p class="text-4xl font-black tabular-nums">24/7</p>
                <p class="text-sm font-semibold mt-0.5 opacity-75">{{ __('Always available') }}</p>
            </div>
            <div>
                <p class="text-4xl font-black tabular-nums">0€</p>
                <p class="text-sm font-semibold mt-0.5 opacity-75">{{ __('No fees') }}</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     LIVEWIRE: BUSCADOR + CATÁLOGO
══════════════════════════════════════════════════════════════ --}}
<section id="catalogo" class="bg-gray-50">
    <livewire:car-search />
</section>

{{-- ══════════════════════════════════════════════════════════════
     HOW IT WORKS
══════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-20 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-center mb-14">
            <h2 class="section-title yellow-line inline-block">{{ __('How does it work?') }}</h2>
            <p class="section-subtitle max-w-lg mx-auto mt-5">
                {{ __('Buying or selling your next car has never been easier.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['01', __('Create your account'),  __('Sign up for free in seconds. No credit card required.'),
                 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                ['02', __('Post your listing'),     __('Add photos, price and description. Your car will be visible in minutes.'),
                 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                ['03', __('Connect and sell'),      __('Buyers contact you directly. No middlemen or commissions.'),
                 'M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z'],
            ] as [$num, $title, $desc, $icon])
            <div class="relative group">
                <div class="card p-7 h-full hover:shadow-card-hover transition-all duration-300 hover:-translate-y-1">
                    <div class="flex items-start gap-4 mb-5">
                        <span class="text-xs font-black text-yellow-400 bg-yellow-50 rounded-lg px-2.5 py-1
                                     border border-yellow-200 tabular-nums">
                            {{ $num }}
                        </span>
                    </div>
                    <div class="w-11 h-11 bg-gray-900 rounded-xl flex items-center justify-center mb-5">
                        <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $title }}</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">{{ $desc }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════════════════
     CTA FINAL
══════════════════════════════════════════════════════════════ --}}
<section class="bg-gray-900 py-20">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl sm:text-5xl font-black text-white tracking-tight text-balance">
            {{ __('Ready to sell') }}<br>
            <span class="text-gradient-yellow">{{ __('your car today?') }}</span>
        </h2>
        <p class="mt-5 text-gray-400 text-lg">
            {{ __('Thousands of buyers are waiting. Post for free in under 5 minutes.') }}
        </p>
        <div class="flex flex-wrap justify-center gap-4 mt-10">
            @guest
                <a href="{{ route('register') }}"
                   class="btn-primary px-8 py-4 text-base font-bold">
                    {{ __("Get started — it's free") }}
                </a>
            @else
                <a href="{{ route('cars.create') }}"
                   class="btn-primary px-8 py-4 text-base font-bold">
                    {{ __('+ List my car') }}
                </a>
            @endguest
        </div>
    </div>
</section>

@endsection
