@extends('layouts.app')

@section('title', $user->name . ' — Admin')

@section('header')
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-400 flex items-center justify-center text-gray-900 font-black text-xl">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="text-2xl font-bold text-white">{{ $user->name }}</h1>
                <p class="text-gray-400 text-sm">{{ $user->email }}</p>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.users.edit', $user) }}"
               class="px-4 py-2 bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold rounded-lg transition">
                Editar
            </a>
            <a href="{{ route('admin.users.index') }}"
               class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg transition">
                ← {{ __('Back') }}
            </a>
        </div>
    </div>
@endsection

@section('content')

    {{-- Estadísticas --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-black text-gray-900">{{ $user->cars->count() }}</p>
            <p class="text-sm text-gray-400 mt-1">Coches publicados</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-3xl font-black text-yellow-400">{{ $user->favouriteCars->count() }}</p>
            <p class="text-sm text-gray-400 mt-1">Favoritos</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <span class="inline-flex px-3 py-1.5 text-sm font-bold rounded-full
                {{ $user->hasRole('admin') ? 'bg-gray-900 text-yellow-400' : 'bg-gray-100 text-gray-600' }}">
                {{ $user->rol }}
            </span>
            <p class="text-sm text-gray-400 mt-2">Rol</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
            <p class="text-lg font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</p>
            <p class="text-sm text-gray-400 mt-1">Registrado</p>
        </div>
    </div>

    {{-- Coches del usuario --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
        <h2 class="text-lg font-bold text-gray-900 mb-5">Coches publicados</h2>
        @if($user->cars->isEmpty())
            <p class="text-center text-gray-400 py-8">Este usuario no tiene coches publicados.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($user->cars as $car)
                    <x-car-card :car="$car" :manage="true" />
                @endforeach
            </div>
        @endif
    </div>

    {{-- Favoritos --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-5">{{ __('Favourite cars') }}</h2>
        @if($user->favouriteCars->isEmpty())
            <p class="text-center text-gray-400 py-8">{{ __('This user has no favourites.') }}</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($user->favouriteCars as $car)
                    <x-car-card :car="$car" />
                @endforeach
            </div>
        @endif
    </div>

@endsection
