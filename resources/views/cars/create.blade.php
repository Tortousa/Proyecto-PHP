@extends('layouts.app')

@section('title', 'Publicar coche — Segunda Marcha')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">{{ __('Publish New Car') }}</h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ __('Fill in your listing details') }}</p>
        </div>
        <a href="{{ route('cars.index') }}"
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg transition">
            ← Cancelar
        </a>
    </div>
@endsection

@section('content')

    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm">
            ⚠ Revisa los campos marcados e inténtalo de nuevo.
        </div>
    @endif

    <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Formulario principal --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- Vehículo --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Datos del vehículo</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-select name="maker_id" label="Marca" :options="$makers" :selected="old('maker_id')" />
                        <x-form-select name="model_id" label="Modelo" :options="$models" :selected="old('model_id')" />
                        <x-form-select name="car_type_id" label="Carrocería" :options="$carTypes" :selected="old('car_type_id')" />
                        <x-form-select name="fuel_type_id" label="Combustible" :options="$fuelTypes" :selected="old('fuel_type_id')" />
                        <x-form-input name="year" label="Año" type="number" :value="old('year', 2024)" />
                        <x-form-input name="mileage" label="Kilometraje (km)" type="number" :value="old('mileage')" placeholder="50000" />
                        <x-form-input name="vin" label="Número VIN" :value="old('vin')" :required="true" />
                    </div>
                </div>

                {{-- Precio y contacto --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">{{ __('Price and contact') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="price" label="Precio (€)" type="number" :value="old('price')" placeholder="15000" :required="true" />
                        <x-form-input name="phone" label="Teléfono" :value="old('phone')" :required="true" />
                        <x-form-select name="city_id" label="Ciudad" :options="$cities" :selected="old('city_id')" />
                        <x-form-input name="address" label="Dirección" :value="old('address')" :required="true" />
                    </div>
                </div>

                {{-- Descripción --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Descripción <span class="text-gray-400 font-normal text-sm">(opcional)</span></h2>
                    <x-form-textarea name="description" label="" :value="old('description')" :rows="4" />
                </div>

            </div>

            {{-- Sidebar fotos + acción --}}
            <div class="space-y-6">

                {{-- Fotos --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-1">Fotos <span class="text-gray-400 font-normal text-sm">(opcional)</span></h2>
                    <p class="text-xs text-gray-400 mb-3">jpg, png, webp · máx 5 MB por imagen</p>
                    <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-yellow-400 hover:bg-yellow-50 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-300 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="text-sm text-gray-400">Haz clic para subir imágenes</span>
                        <input type="file" name="images[]" accept="image/*" multiple class="hidden">
                    </label>
                </div>

                {{-- Botón publicar --}}
                <div class="bg-gray-900 rounded-2xl p-6">
                    <p class="text-gray-400 text-sm mb-4">{{ __('The listing will be published immediately and visible to all.') }}</p>
                    <button type="submit"
                            class="w-full py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-black text-base rounded-xl transition">
                        Publicar anuncio
                    </button>
                </div>

            </div>
        </div>
    </form>

@endsection
