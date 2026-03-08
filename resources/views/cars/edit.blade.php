<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Car') }}: {{ $car->maker->name }} {{ $car->model->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    {{-- Errores de validación --}}
                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                            <p class="font-bold">{{ __('Whoops! Something went wrong.') }}</p>
                        </div>
                    @endif

                    <form action="{{ route('cars.update', $car) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Marca --}}
                            <x-form-select
                                name="maker_id"
                                label="{{ __('Maker') }}"
                                :options="$makers"
                                :selected="old('maker_id', $car->maker_id)"
                                    {{-- :required="true" --}}
                            />

                            {{-- Modelo --}}
                            <x-form-select
                                name="model_id"
                                label="{{ __('Model') }}"
                                :options="$models"
                                :selected="old('model_id', $car->model_id)"
                                    {{-- :required="true" --}}
                            />

                            {{-- Ciudad --}}
                            <x-form-select
                                name="city_id"
                                label="{{ __('City') }}"
                                :options="$cities"
                                :selected="old('city_id', $car->city_id)"
                                :required="true"
                            />

                            {{-- Tipo de Coche --}}
                            <x-form-select
                                name="car_type_id"
                                label="{{ __('Body Type') }}"
                                :options="$carTypes"
                                :selected="old('car_type_id', $car->car_type_id)"
                                :required="true"
                            />

                            {{-- Combustible --}}
                            <x-form-select
                                name="fuel_type_id"
                                label="{{ __('Fuel Type') }}"
                                :options="$fuelTypes"
                                :selected="old('fuel_type_id', $car->fuel_type_id)"
                                :required="true"
                            />

                            {{-- Año --}}
                            <x-form-input
                                name="year"
                                label="{{ __('Year') }}"
                                type="number"
                                :value="old('year', $car->year)"
                                :required="true"
                            />

                            {{-- Precio --}}
                            <x-form-input
                                name="price"
                                label="{{ __('Price') }} (€)"
                                type="number"
                                :value="old('price', $car->price)"
                                :required="true"
                            />

                            {{-- Kilometraje --}}
                            <x-form-input
                                name="mileage"
                                label="{{ __('Mileage') }} (km)"
                                type="number"
                                :value="old('mileage', $car->mileage)"
                                :required="true"
                            />

                            {{-- VIN --}}
                            <x-form-input
                                name="vin"
                                label="{{ __('VIN Number') }}"
                                :value="old('vin', $car->vin)"
                                :required="true"
                            />

                            {{-- Teléfono --}}
                            <x-form-input
                                name="phone"
                                label="{{ __('Phone') }}"
                                :value="old('phone', $car->phone)"
                                :required="true"
                            />
                        </div>

                        {{-- Dirección --}}
                        <x-form-input
                            name="address"
                            label="{{ __('Address') }}"
                            :value="old('address', $car->address)"
                            :required="true"
                        />

                        {{-- Descripción --}}
                        <x-form-textarea
                            name="description"
                            label="{{ __('Description') }}"
                            :value="old('description', $car->description)"
                            :rows="3"
                        />

                        {{-- Imágenes existentes --}}
                        @if($car->images->count() > 0)
                            <div class="mt-4">
                                <label class="block text-sm font-medium text-gray-700">{{ __('Current Photos') }}</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                                    @foreach($car->images->sortBy('position') as $image)
                                        <div class="relative">
                                            @php
                                                $imgPath = $image->image_path;
                                                $src = (strpos($imgPath, 'http') === 0) ? $imgPath : asset('storage/' . $imgPath);
                                            @endphp
                                            <img src="{{ $src }}" alt="" class="w-full h-24 object-cover rounded border" />
                                            <span class="absolute top-1 left-1 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                                                {{ $image->position }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Agregar nuevas imágenes --}}
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700">{{ __('Add New Photos') }} ({{ __('Optional') }})</label>
                            <input type="file" name="images[]" accept="image/*" multiple class="mt-1 block w-full" />
                            <p class="text-xs text-gray-500">Tipos permitidos: jpg, jpeg, png, gif, webp. Máx 5MB por imagen.</p>
                        </div>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-bold text-white uppercase tracking-widest hover:bg-indigo-700 shadow-md transition duration-150">
                                {{ __('Update Car') }}
                            </button>
                            <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
