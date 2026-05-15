@extends('layouts.app')

@section('title', ($car->maker->name ?? '') . ' ' . ($car->model->name ?? '') . ' — Segunda Marcha')

@section('header')
<div class="flex items-center justify-between gap-4">
    <div class="min-w-0">
        <div class="flex items-center gap-2 mb-1">
            <a href="{{ url()->previous() }}"
               class="text-gray-500 hover:text-white transition-colors duration-150 flex items-center gap-1 text-sm">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                {{ __('Back') }}
            </a>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-white truncate tracking-tight">
            {{ $car->maker->name ?? '—' }} {{ $car->model->name ?? '—' }}
        </h1>
        <p class="text-gray-400 text-sm mt-0.5 flex items-center gap-2">
            <span>{{ $car->year }}</span>
            <span class="text-gray-700">·</span>
            <span>{{ number_format($car->mileage) }} km</span>
            @if($car->fuelType)
                <span class="text-gray-700">·</span>
                <span>{{ $car->fuelType->name }}</span>
            @endif
            @if($car->city)
                <span class="text-gray-700">·</span>
                <span>{{ $car->city->name }}</span>
            @endif
        </p>
    </div>
    <div class="shrink-0 text-right">
        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">{{ __('Price') }}</p>
        <p class="price-tag-lg">{{ number_format($car->price, 0, ',', '.') }} €</p>
    </div>
</div>
@endsection

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-7">

    {{-- ── COLUMNA PRINCIPAL ────────────────────────────────────────────── --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- Imagen principal --}}
        <div class="card overflow-hidden aspect-video min-h-52 flex items-center justify-center bg-gray-100">
            @if($car->primaryImage)
                <img src="{{ $car->primaryImage->url }}"
                     alt="{{ $car->maker->name }} {{ $car->model->name }}"
                     class="w-full h-full object-cover">
            @else
                <div class="flex flex-col items-center gap-3 text-gray-300">
                    <svg class="h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-sm">{{ __('No photos') }}</p>
                </div>
            @endif
        </div>

        {{-- Ficha técnica --}}
        <div class="card p-6">
            <h2 class="font-bold text-gray-900 text-base mb-5 yellow-line">{{ __('Vehicle data') }}</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                @foreach([
                    [__('Make'),     $car->maker->name ?? '—'],
                    [__('Model'),     $car->model->name ?? '—'],
                    [__('Year'),      $car->year],
                    [__('Mileage'),   number_format($car->mileage) . ' km'],
                    [__('Fuel type'), $car->fuelType->name ?? '—'],
                    [__('Body type'), $car->carType->name ?? '—'],
                ] as [$label, $value])
                <div class="data-cell">
                    <p class="data-label">{{ $label }}</p>
                    <p class="data-value">{{ $value }}</p>
                </div>
                @endforeach

                <div class="data-cell col-span-2 sm:col-span-3">
                    <p class="data-label">VIN</p>
                    <p class="data-value font-mono text-xs tracking-wider">{{ $car->vin }}</p>
                </div>
            </div>
        </div>

        {{-- Descripción --}}
        @if($car->description)
        <div class="card p-6">
            <h2 class="font-bold text-gray-900 text-base mb-4 yellow-line">{{ __('Description') }}</h2>
            <p class="text-gray-600 leading-relaxed text-sm">{{ $car->description }}</p>
        </div>
        @endif
    </div>

    {{-- ── SIDEBAR ──────────────────────────────────────────────────────── --}}
    <div class="space-y-5">

        {{-- Precio card --}}
        <div class="bg-gray-900 rounded-2xl p-6 border border-gray-800">
            <p class="text-gray-500 text-xs uppercase tracking-wider font-semibold mb-1">{{ __('Sale price') }}</p>
            <p class="price-tag-lg">{{ number_format($car->price, 0, ',', '.') }} €</p>

            @can('update', $car)
                <div class="mt-5 space-y-2.5">
                    <a href="{{ route('cars.edit', $car) }}"
                       class="btn-primary w-full py-3 font-bold text-sm">
                        {{ __('Edit listing') }}
                    </a>
                    <form action="{{ route('cars.destroy', $car) }}" method="POST"
                          onsubmit="return confirm('¿Seguro que quieres eliminar este anuncio?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger w-full py-3 text-sm font-semibold">
                            {{ __('Delete listing') }}
                        </button>
                    </form>
                </div>
            @endcan
        </div>

        {{-- PDF --}}
        @auth
        <a href="{{ route('cars.pdf', $car) }}"
           class="card flex items-center gap-3 px-5 py-3.5 hover:shadow-card-hover
                  transition-all duration-200 hover:-translate-y-px">
            <div class="w-9 h-9 bg-red-50 rounded-lg flex items-center justify-center shrink-0">
                <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800">{{ __('Download PDF') }}</p>
                <p class="text-xs text-gray-400">{{ __('Full spec sheet') }}</p>
            </div>
            <svg class="h-4 w-4 text-gray-300 ml-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
        @endauth

        {{-- Contacto --}}
        <div class="card p-6">
            <h2 class="font-bold text-gray-900 text-base mb-5 yellow-line">{{ __('Contact') }}</h2>
            <div class="space-y-4">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-yellow-50 border border-yellow-100 rounded-xl
                                flex items-center justify-center shrink-0">
                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="data-label">{{ __('Phone') }}</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ $car->phone }}</p>
                    </div>
                </div>

                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-yellow-50 border border-yellow-100 rounded-xl
                                flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="data-label">{{ __('Location') }}</p>
                        <p class="font-semibold text-gray-800 text-sm">{{ $car->city->name ?? '—' }}</p>
                        @if($car->address)
                            <p class="text-xs text-gray-400 mt-0.5">{{ $car->address }}</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Favorito --}}
        @auth
        <div class="card p-4 flex items-center gap-3">
            <div class="flex-1 text-sm text-gray-600">{{ __('Save to favourites') }}</div>
            <livewire:favourite-button :car-id="$car->id" :key="'show-fav-'.$car->id" />
        </div>
        @endauth

    </div>
</div>

@endsection
