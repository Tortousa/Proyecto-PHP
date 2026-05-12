@extends('layouts.app')

@section('title', 'Mis Coches — Segunda Marcha')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Mis coches</h1>
            <p class="text-gray-400 text-sm mt-0.5">Gestiona tus anuncios publicados</p>
        </div>
        <a href="{{ route('cars.create') }}"
           class="px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold rounded-lg transition">
            + Publicar coche
        </a>
    </div>
@endsection

@section('content')

    <x-car-filters />

    @if($cars->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
            </div>
            <p class="text-gray-500 font-medium text-lg">Todavía no tienes anuncios</p>
            <a href="{{ route('cars.create') }}"
               class="mt-4 inline-block px-6 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold rounded-lg text-sm transition">
                Publicar mi primer coche
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($cars as $car)
                <x-car-card :car="$car" :manage="true" />
            @endforeach
        </div>
        <div class="mt-8">
            {{ $cars->appends(request()->query())->links() }}
        </div>
    @endif

@endsection
