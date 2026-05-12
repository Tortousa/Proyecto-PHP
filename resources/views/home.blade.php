@extends('layouts.public')

@section('title', 'Segunda Marcha — Compra y vende tu coche')

@section('content')

    {{-- ── HERO ────────────────────────────────────────────────────────────────── --}}
    <section class="bg-gray-900 text-white py-20">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-28 w-auto mx-auto mb-6 drop-shadow-xl">
            <h1 class="text-5xl font-bold mb-3">
                Compra y vende tu coche
            </h1>
            <p class="text-gray-400 text-xl mb-10">
                El marketplace de coches de segunda mano más completo
            </p>
            @guest
                <div class="flex gap-4 justify-center">
                    <a href="{{ route('register') }}"
                       class="px-8 py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold rounded-xl transition">
                        Publicar anuncio gratis
                    </a>
                    <a href="{{ route('login') }}"
                       class="px-8 py-3 bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-xl transition">
                        Iniciar sesión
                    </a>
                </div>
            @endguest
        </div>
    </section>

    {{-- ── COMPONENTE LIVEWIRE: buscador + estadísticas + grid de coches ────────── --}}
    {{-- CarSearch gestiona los filtros y la paginación de forma reactiva            --}}
    <livewire:car-search />

@endsection
