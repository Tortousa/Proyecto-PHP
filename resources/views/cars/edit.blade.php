@extends('layouts.app')

@section('title', 'Editar — ' . ($car->maker->name ?? '') . ' ' . ($car->model->name ?? ''))

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Editar anuncio</h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ $car->maker->name }} {{ $car->model->name }} · {{ $car->year }}</p>
        </div>
        <a href="{{ route('cars.show', $car) }}"
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

    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Datos del vehículo</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-select name="maker_id" label="Marca" :options="$makers" :selected="old('maker_id', $car->maker_id)" />
                        <x-form-select name="model_id" label="Modelo" :options="$models" :selected="old('model_id', $car->model_id)" />
                        <x-form-select name="car_type_id" label="Carrocería" :options="$carTypes" :selected="old('car_type_id', $car->car_type_id)" />
                        <x-form-select name="fuel_type_id" label="Combustible" :options="$fuelTypes" :selected="old('fuel_type_id', $car->fuel_type_id)" />
                        <x-form-input name="year" label="Año" type="number" :value="old('year', $car->year)" />
                        <x-form-input name="mileage" label="Kilometraje (km)" type="number" :value="old('mileage', $car->mileage)" />
                        <x-form-input name="vin" label="Número VIN" :value="old('vin', $car->vin)" :required="true" />
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Precio y contacto</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="price" label="Precio (€)" type="number" :value="old('price', $car->price)" />
                        <x-form-input name="phone" label="Teléfono" :value="old('phone', $car->phone)" />
                        <x-form-select name="city_id" label="Ciudad" :options="$cities" :selected="old('city_id', $car->city_id)" />
                        <x-form-input name="address" label="Dirección" :value="old('address', $car->address)" />
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-bold text-gray-900 mb-4">Descripción</h2>
                    <x-form-textarea name="description" label="" :value="old('description', $car->description)" :rows="4" />
                </div>

            </div>

            <div class="space-y-6">

                {{-- Gestión de imágenes (Livewire CRUD) --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <livewire:car-images :car="$car" />
                </div>

                <div class="bg-gray-900 rounded-2xl p-6">
                    <button type="submit"
                            class="w-full py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-black text-base rounded-xl transition">
                        Guardar cambios
                    </button>
                </div>

            </div>
        </div>
    </form>

@endsection
