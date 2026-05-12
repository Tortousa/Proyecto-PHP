@extends('layouts.app')

@section('title', 'Panel — Segunda Marcha')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Panel</h1>
            <p class="text-gray-400 text-sm mt-0.5">Coches publicados por otros usuarios</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('cars.index') }}"
               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg transition">
                Mis coches
            </a>
            <a href="{{ route('cars.create') }}"
               class="px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold rounded-lg transition">
                + Publicar coche
            </a>
        </div>
    </div>
@endsection

@section('content')

    {{-- Filtros Blade (recarga de página) --}}
    <x-car-filters />

    @if($featuredCars->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 9v2m0 4h.01M5.07 19H19a2 2 0 001.75-2.96L13.75 4a2 2 0 00-3.5 0L3.25 16.04A2 2 0 005.07 19z"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium text-lg">No hay coches disponibles ahora mismo</p>
            <a href="{{ route('cars.create') }}" class="mt-4 inline-block text-yellow-500 hover:text-yellow-600 font-semibold text-sm">
                ¡Sé el primero en publicar uno →
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredCars as $car)
                <x-car-card :car="$car" />
            @endforeach
        </div>
        <div class="mt-8">
            {{ $featuredCars->appends(request()->query())->links() }}
        </div>
    @endif

    {{-- ── COMPONENTE LIVEWIRE: mis favoritos ──────────────────────────────────── --}}
    {{-- FavouritesList permite editar la nota y eliminar favoritos en tiempo real   --}}
    <div class="mt-12">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Mis favoritos</h2>
            <livewire:favourites-list />
        </div>
    </div>

@endsection
