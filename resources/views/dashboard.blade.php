<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex gap-4">
                <a href="{{ route('cars.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-gray-700 shadow-sm transition">
                    {{ __('My Cars') }}
                </a>
                <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                    + {{ __('Sell my car') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900">

                <h3 class="text-lg font-bold mb-6 text-gray-700">{{ __('Featured Cars') }}</h3>

                @if($featuredCars->isEmpty())
                    <div class="text-center py-12">
                        <p class="text-gray-500 mb-4">{{ __("No cars available at the moment.") }}</p>
                        <a href="{{ route('cars.create') }}" class="text-indigo-600 font-bold hover:underline">
                            {{ __('Be the first to sell a car') }}
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($featuredCars as $car)
                            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                                <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                                    @if($car->primaryImage)
                                        @php
                                            $imgPath = $car->primaryImage->image_path;
                                            $src = (strpos($imgPath, 'http') === 0) ? $imgPath : asset('storage/' . $imgPath);
                                        @endphp
                                        <img src="{{ $src }}" alt="{{ $car->maker->name }} {{ $car->model->name }}" class="w-full h-48 object-cover" />
                                    @else
                                        <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                                            <span class="text-gray-500 text-sm">{{ __('No image') }}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-4">
                                    <h4 class="font-bold text-lg text-gray-900 mb-1">
                                        {{ $car->maker->name }} {{ $car->model->name }}
                                    </h4>

                                    <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
                                        <span>{{ $car->year }}</span>
                                        <span>{{ $car->city->name ?? '' }}</span>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <span class="text-xl font-bold text-indigo-600">
                                            {{ number_format($car->price, 0, ',', '.') }} €
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $car->mileage }} km
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                        {{ Str::limit($car->description ?? __('No description available.'), 100) }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
            </div>

            <!-- API Integration Info Section -->
            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-bold text-blue-900 mb-2">API Documentation Available</h4>
                            <p class="text-sm text-blue-700 mb-3">
                                This application includes a complete REST API with 2 fully functional CRUDs:
                            </p>
                            <ul class="text-sm text-blue-700 space-y-1 mb-3">
                                <li>✅ <strong>CRUD 1 - Cars (Public):</strong> GET /api/cars - List and retrieve published cars</li>
                                <li>✅ <strong>CRUD 2 - Car Images (Authenticated):</strong> GET, POST, PUT, DELETE /api/car-images - Manage your car images with Laravel Sanctum</li>
                            </ul>
                            <p class="text-xs text-blue-600">
                                📖 See <code class="bg-blue-100 px-2 py-1 rounded">API_DOCUMENTATION.md</code> for complete endpoint reference
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>