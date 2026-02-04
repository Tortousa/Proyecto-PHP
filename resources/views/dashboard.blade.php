<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('cars.create') }}"
               class="inline-flex items-center ml-8 px-2 py-2 bg-indigo-400 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700 transition ease-in-out duration-150 shadow-sm">
                {{ __('Sell my car') }}
            </a>
        </div>
    </div>
</x-app-layout>
