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
                    {{ __('Sell my car') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
            <div class="p-6 text-gray-900">

                <h3 class="text-lg font-bold mb-6 text-gray-700">{{ __('Featured Cars') }}</h3>

                <x-car-filters />

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
                            <x-car-card :car="$car" />
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $featuredCars->appends(request()->query())->links() }}
                    </div>
                @endif

            </div>
            </div>
        </div>
    </div>
</x-app-layout>