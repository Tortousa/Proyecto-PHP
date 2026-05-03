@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $user->name }}
            </h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white text-xs font-bold uppercase rounded-md hover:bg-yellow-600 transition">
                    {{ __('Edit') }}
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-xs font-bold uppercase rounded-md hover:bg-gray-700 transition">
                    {{ __('Back') }}
                </a>
            </div>
        </div>
@endsection

@section('content')
<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Info del usuario --}}
            <div class="bg-white shadow sm:rounded-lg p-6 flex items-center gap-6">
                <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-3xl font-bold text-indigo-600">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    @if($user->phone)
                        <p class="text-gray-500 text-sm">{{ $user->phone }}</p>
                    @endif
                    <span class="mt-2 inline-block px-3 py-1 text-xs font-semibold rounded-full
                        {{ $user->isAdmin() ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $user->rol }}
                    </span>
                </div>
                <div class="ml-auto grid grid-cols-2 gap-6 text-center">
                    <div>
                        <p class="text-3xl font-bold text-indigo-600">{{ $user->cars->count() }}</p>
                        <p class="text-sm text-gray-500">{{ __('Cars listed') }}</p>
                    </div>
                    <div>
                        <p class="text-3xl font-bold text-pink-500">{{ $user->favouriteCars->count() }}</p>
                        <p class="text-sm text-gray-500">{{ __('Favourites') }}</p>
                    </div>
                </div>
            </div>

            {{-- Coches del usuario --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('Cars listed') }}</h3>

                @if($user->cars->isEmpty())
                    <p class="text-gray-500 text-center py-8">{{ __('This user has no cars listed.') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($user->cars as $car)
                            <x-car-card :car="$car" :manage="true" />
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Favoritos del usuario --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-6">{{ __('Favourites') }}</h3>

                @if($user->favouriteCars->isEmpty())
                    <p class="text-gray-500 text-center py-8">{{ __('This user has no favourites.') }}</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($user->favouriteCars as $car)
                            <x-car-card :car="$car" />
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
@endsection
