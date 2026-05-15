@extends('layouts.app')

@section('title', 'Panel — Segunda Marcha')

@section('header')
<div class="flex items-center justify-between gap-4">
    <div>
        <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold mb-0.5">{{ __('Welcome') }}</p>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
            {{ explode(' ', Auth::user()->name)[0] }}<span class="text-yellow-400">.</span>
        </h1>
        <p class="text-gray-400 text-sm mt-0.5">{{ __('Cars available in the marketplace') }}</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('cars.index') }}" class="btn-secondary-sm font-semibold text-xs">
            {{ __('My Cars') }}
        </a>
        <a href="{{ route('cars.create') }}" class="btn-primary-sm font-bold text-xs">
            {{ __('+ Publish car') }}
        </a>
    </div>
</div>
@endsection

@section('content')

{{-- ── FILTROS ── --}}
<x-car-filters />

{{-- ── GRID O EMPTY STATE ── --}}
@if($featuredCars->isEmpty())
    <div class="text-center py-24">
        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <p class="text-xl font-bold text-gray-700">{{ __('No cars available') }}</p>
        <p class="text-gray-400 text-sm mt-1">{{ __('Be the first to publish a listing') }}</p>
        <a href="{{ route('cars.create') }}"
           class="mt-5 inline-flex btn-primary-sm font-bold">
            {{ __('Publish my first car') }}
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($featuredCars as $car)
            <x-car-card :car="$car" />
        @endforeach
    </div>
    <div class="mt-8">
        {{ $featuredCars->appends(request()->query())->links() }}
    </div>
@endif

{{-- ── FAVORITOS ── --}}
<div class="mt-12">
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-bold text-gray-900 text-base yellow-line">{{ __('My Favourites') }}</h2>
        </div>
        <livewire:favourites-list />
    </div>
</div>

@endsection
