@extends('layouts.app')

@section('title', __('My listings') . ' — Segunda Marcha')

@section('header')
<div class="flex items-center justify-between gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">{{ __('My listings') }}</h1>
        <p class="text-gray-400 text-sm mt-0.5">{{ __('Manage your listings') }}</p>
    </div>
    <a href="{{ route('cars.create') }}" class="btn-primary-sm font-bold text-xs sm:text-sm">
        {{ __('+ Publish car') }}
    </a>
</div>
@endsection

@section('content')

<x-car-filters />

@if($cars->isEmpty())
    <div class="text-center py-28">
        <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
            <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
        </div>
        <p class="text-xl font-bold text-gray-700">{{ __('No listings yet') }}</p>
        <p class="text-gray-400 text-sm mt-1">{{ __('Publish your first car for free in minutes') }}</p>
        <a href="{{ route('cars.create') }}"
           class="mt-5 inline-flex btn-primary-sm font-bold text-sm">
            {{ __('Publish my first car') }}
        </a>
    </div>
@else
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($cars as $car)
            <x-car-card :car="$car" :manage="true" />
        @endforeach
    </div>
    <div class="mt-8">
        {{ $cars->appends(request()->query())->links() }}
    </div>
@endif

@endsection
