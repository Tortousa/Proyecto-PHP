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
                            <ul class="mt-2 list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('cars.update', $car) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            {{-- Marca --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Maker') }}</label>
                                <select name="maker_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($makers as $maker)
                                        {{-- CAMBIO 3: old('campo', $car->campo) para cargar el valor actual --}}
                                        <option value="{{ $maker->id }}" {{ old('maker_id', $car->maker_id) == $maker->id ? 'selected' : '' }}>
                                            {{ $maker->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Modelo --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Model') }}</label>
                                <select name="model_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($models as $model)
                                        <option value="{{ $model->id }}" {{ old('model_id', $car->model_id) == $model->id ? 'selected' : '' }}>
                                            {{ $model->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Ciudad --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('City') }}</label>
                                <select name="city_id" class="w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ old('city_id', $car->city_id) == $city->id ? 'selected' : '' }}>
                                            {{ $city->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tipo de Coche --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Body Type') }}</label>
                                <select name="car_type_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($carTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('car_type_id', $car->car_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Combustible --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Fuel Type') }}</label>
                                <select name="fuel_type_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @foreach($fuelTypes as $fuel)
                                        <option value="{{ $fuel->id }}" {{ old('fuel_type_id', $car->fuel_type_id) == $fuel->id ? 'selected' : '' }}>
                                            {{ $fuel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Año --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Year') }}</label>
                                <input type="number" name="year" value="{{ old('year', $car->year) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Precio --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Price') }} (€)</label>
                                <input type="number" name="price" value="{{ old('price', $car->price) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Kilometraje --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Mileage') }}</label>
                                <input type="number" name="mileage" value="{{ old('mileage', $car->mileage) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- VIN --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('VIN Number') }}</label>
                                <input type="text" name="vin" value="{{ old('vin', $car->vin) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>

                            {{-- Teléfono --}}
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Phone') }}</label>
                                <input type="text" name="phone" value="{{ old('phone', $car->phone) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                        </div>

                        {{-- Dirección --}}
                        <div class="mt-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Address') }}</label>
                            <input type="text" name="address" value="{{ old('address', $car->address) }}" class="w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        {{-- Descripción --}}
                        <div class="mt-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">{{ __('Description') }}</label>
                            <textarea name="description" rows="3" class="w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $car->description) }}</textarea>
                        </div>

                        <div class="mt-8 flex items-center gap-4">
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