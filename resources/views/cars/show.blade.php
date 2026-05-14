@extends('layouts.app')

@section('title', ($car->maker->name ?? '') . ' ' . ($car->model->name ?? '') . ' — Segunda Marcha')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">
                {{ $car->maker->name ?? '—' }} {{ $car->model->name ?? '—' }}
            </h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ $car->year }} · {{ number_format($car->mileage) }} km</p>
        </div>
        <a href="{{ route('cars.index') }}"
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg transition">
            ← Volver
        </a>
    </div>
@endsection

@section('content')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Columna principal --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Imagen principal --}}
            <div class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 aspect-video min-h-48 flex items-center justify-center">
                @if($car->primaryImage)
                    <img src="{{ $car->primaryImage->url }}"
                         alt="{{ $car->maker->name }} {{ $car->model->name }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="flex flex-col items-center text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="mt-2 text-sm">Sin fotos</p>
                    </div>
                @endif
            </div>

            {{-- Ficha técnica --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Datos del vehículo</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Marca</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $car->maker->name ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Modelo</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $car->model->name ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Año</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $car->year }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Kilometraje</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ number_format($car->mileage) }} km</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Combustible</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $car->fuelType->name ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">Tipo</p>
                        <p class="font-semibold text-gray-800 mt-0.5">{{ $car->carType->name ?? '—' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-3 col-span-2">
                        <p class="text-xs text-gray-400 uppercase tracking-wide">VIN</p>
                        <p class="font-mono font-semibold text-gray-800 mt-0.5">{{ $car->vin }}</p>
                    </div>
                </div>
            </div>

            {{-- Descripción --}}
            @if($car->description)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-lg font-bold text-gray-900 mb-3">Descripción</h2>
                    <p class="text-gray-600 leading-relaxed">{{ $car->description }}</p>
                </div>
            @endif
        </div>

        {{-- Sidebar precio y contacto --}}
        <div class="space-y-6">

            {{-- Precio --}}
            <div class="bg-gray-900 rounded-2xl p-6 text-white">
                <p class="text-gray-400 text-sm">Precio</p>
                <p class="text-4xl font-black text-yellow-400 mt-1">
                    {{ number_format($car->price, 0, ',', '.') }} €
                </p>

                @can('update', $car)
                    <div class="mt-5 space-y-2">
                        <a href="{{ route('cars.edit', $car) }}"
                           class="block w-full text-center px-4 py-2.5 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-bold rounded-lg transition text-sm">
                            ✏️ Editar anuncio
                        </a>
                        <form action="{{ route('cars.destroy', $car) }}" method="POST"
                              onsubmit="return confirm('¿Seguro que quieres eliminar este anuncio?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full px-4 py-2.5 bg-red-600 hover:bg-red-500 text-white font-semibold rounded-lg transition text-sm">
                                🗑 Eliminar
                            </button>
                        </form>
                    </div>
                @endcan
            </div>

            {{-- Descargar PDF --}}
            @auth
            <a href="{{ route('cars.pdf', $car) }}"
               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-semibold rounded-2xl shadow-sm transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
                Descargar ficha PDF
            </a>
            @endauth

            {{-- Contacto --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4">Contacto</h2>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-yellow-100 rounded-full flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Teléfono</p>
                            <p class="font-semibold text-gray-800">{{ $car->phone }}</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="w-9 h-9 bg-yellow-100 rounded-full flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400">Ubicación</p>
                            <p class="font-semibold text-gray-800">{{ $car->city->name ?? '—' }}</p>
                            <p class="text-sm text-gray-500">{{ $car->address }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
