<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                + {{ __('Sell my car') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-6 text-gray-900">

                    <h3 class="text-lg font-bold mb-4 text-gray-700">{{ __('My Listings') }}</h3>

                    @if($cars->isEmpty())
                        <div class="text-center py-12">
                            <p class="text-gray-500 mb-4">{{ __("You haven't uploaded any cars yet.") }}</p>
                            <a href="{{ route('cars.create') }}" class="text-indigo-600 font-bold hover:underline">
                                {{ __('Upload your first car now') }}
                            </a>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3">{{ __('Car') }}</th>
                                    <th class="px-6 py-3">{{ __('Price') }}</th>
                                    <th class="px-6 py-3">{{ __('Year') }}</th>
                                    <th class="px-6 py-3 text-right">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cars as $car)
                                    <tr class="bg-white border-b hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 font-medium text-gray-900">
                                            {{ $car->maker->name }} {{ $car->model->name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ number_format($car->price, 0, ',', '.') }} €
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ $car->year }}
                                        </td>
                                        <td class="px-6 py-4 text-right flex justify-end gap-3">
                                            {{-- BOTÓN EDITAR --}}
                                            <a href="{{ route('cars.edit', $car) }}" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                                {{ __('Edit') }}
                                            </a>

                                            {{-- BOTÓN BORRAR --}}
                                            <form action="{{ route('cars.destroy', $car) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 font-bold">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>