<div>

{{-- ── FILTROS ──────────────────────────────────────────────────────────────── --}}
<section class="bg-white border-b border-gray-100 py-4 sticky top-16 z-40 shadow-sm"
         x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Fila superior: búsqueda + botón filtros (móvil) + contador --}}
        <div class="flex items-center gap-3">

            {{-- Search --}}
            <div class="relative flex-1 sm:flex-none">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400 pointer-events-none"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search"
                       type="text"
                       placeholder="{{ __('Search make or model...') }}"
                       class="pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm w-full sm:w-56
                              focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none
                              transition-all duration-200 bg-gray-50 focus:bg-white">
            </div>

            {{-- Filtros desktop: siempre visibles --}}
            <div class="hidden sm:flex items-center gap-3">
                <select wire:model.live="fuelType"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50
                               focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none
                               transition-all duration-200 cursor-pointer focus:bg-white">
                    <option value="">{{ __('All fuel types') }}</option>
                    @foreach($fuelTypes as $ft)
                        <option value="{{ $ft->id }}">{{ $ft->name }}</option>
                    @endforeach
                </select>

                <select wire:model.live="sortBy"
                        class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50
                               focus:ring-2 focus:ring-yellow-400 focus:border-yellow-400 outline-none
                               transition-all duration-200 cursor-pointer focus:bg-white">
                    <option value="latest">{{ __('Latest') }}</option>
                    <option value="price_asc">{{ __('Price: low to high') }}</option>
                    <option value="price_desc">{{ __('Price: high to low') }}</option>
                </select>

                @if($search || $fuelType || $sortBy !== 'latest')
                    <button wire:click="$set('search', ''); $set('fuelType', ''); $set('sortBy', 'latest')"
                            class="px-3 py-2.5 text-sm text-gray-400 hover:text-gray-700 hover:bg-gray-100
                                   rounded-xl transition-all duration-150 flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ __('Clear') }}
                    </button>
                @endif
            </div>

            {{-- Botón filtros móvil --}}
            <button @click="open = !open"
                    class="sm:hidden flex items-center gap-1.5 px-3 py-2.5 rounded-xl border text-sm font-medium
                           transition-all duration-150"
                    :class="open ? 'border-yellow-400 bg-yellow-50 text-gray-900' : 'border-gray-200 bg-gray-50 text-gray-600'">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
                </svg>
                {{ __('Filters') }}
                @if($fuelType || $sortBy !== 'latest')
                    <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                @endif
            </button>

            {{-- Loading --}}
            <div wire:loading class="flex items-center gap-1.5 text-gray-400 text-sm ml-auto">
                <svg class="animate-spin h-4 w-4 text-yellow-400" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"/>
                </svg>
            </div>

            {{-- Contador --}}
            <div class="ml-auto sm:ml-0 text-sm text-gray-400 font-medium" wire:loading.remove>
                <span class="tabular-nums font-semibold text-gray-700">{{ $cars->total() }}</span>
                {{ $cars->total() === 1 ? __('result') : __('results') }}
            </div>
        </div>

        {{-- Panel filtros móvil colapsable --}}
        <div x-show="open"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 -translate-y-1"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-1"
             class="sm:hidden mt-3 pt-3 border-t border-gray-100 flex flex-col gap-2.5"
             style="display:none">
            <select wire:model.live="fuelType"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50
                           focus:ring-2 focus:ring-yellow-400 outline-none w-full cursor-pointer">
                <option value="">{{ __('All fuel types') }}</option>
                @foreach($fuelTypes as $ft)
                    <option value="{{ $ft->id }}">{{ $ft->name }}</option>
                @endforeach
            </select>

            <select wire:model.live="sortBy"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm bg-gray-50
                           focus:ring-2 focus:ring-yellow-400 outline-none w-full cursor-pointer">
                <option value="latest">{{ __('Latest') }}</option>
                <option value="price_asc">{{ __('Price: low to high') }}</option>
                <option value="price_desc">{{ __('Price: high to low') }}</option>
            </select>

            @if($search || $fuelType || $sortBy !== 'latest')
                <button wire:click="$set('search', ''); $set('fuelType', ''); $set('sortBy', 'latest')"
                        @click="open = false"
                        class="w-full px-3 py-2.5 text-sm text-gray-500 hover:text-gray-700 hover:bg-gray-100
                               rounded-xl transition-all duration-150 flex items-center justify-center gap-1.5 border border-gray-200">
                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    {{ __('Clear filters') }}
                </button>
            @endif
        </div>

    </div>
</section>

{{-- ── GRID DE COCHES ───────────────────────────────────────────────────────── --}}
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    @if($cars->isEmpty())
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-5">
                <svg class="h-10 w-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <p class="text-xl font-bold text-gray-700">{{ __('No results') }}</p>
            <p class="text-gray-400 text-sm mt-1">{{ __('Try a different search or change the filters') }}</p>
            <button wire:click="$set('search', '')"
                    class="mt-5 btn-primary-sm font-semibold">
                {{ __('See all cars') }}
            </button>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5"
             wire:loading.class="opacity-50 pointer-events-none">

            @foreach($cars as $car)
            <article class="card-hover group overflow-hidden flex flex-col relative">

                {{-- Favourite --}}
                @auth
                <div class="absolute top-3 right-3 z-10">
                    <button wire:click="toggleFavourite({{ $car->id }})"
                            class="w-8 h-8 rounded-full glass flex items-center justify-center
                                   hover:scale-110 transition-transform duration-150 shadow-sm">
                        <svg class="h-4 w-4 transition-colors duration-150
                                    {{ in_array($car->id, $favouriteIds, true)
                                       ? 'text-red-500 fill-red-500' : 'text-gray-400 hover:text-red-400' }}"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </button>
                </div>
                @endauth

                <a href="{{ route('cars.show', $car) }}" class="block flex-1">

                    {{-- Image --}}
                    <div class="aspect-video overflow-hidden bg-gray-100 relative">
                        @if($car->primaryImage)
                            <img src="{{ $car->primaryImage->url }}"
                                 alt="{{ $car->maker->name ?? '' }} {{ $car->model->name ?? '' }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 loading="lazy">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                          d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif

                        {{-- Fuel badge --}}
                        @if($car->fuelType)
                            <span class="absolute bottom-2 left-2 badge-dark text-xs">
                                {{ $car->fuelType->name }}
                            </span>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div class="p-4">
                        <h3 class="font-bold text-gray-900 text-sm truncate leading-snug">
                            {{ $car->maker->name ?? '—' }} {{ $car->model->name ?? '—' }}
                        </h3>
                        <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1.5">
                            <span>{{ $car->year }}</span>
                            <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                            <span>{{ number_format($car->mileage) }} km</span>
                            @if($car->city)
                                <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                                <span class="truncate">{{ $car->city->name }}</span>
                            @endif
                        </p>
                        <div class="flex items-center justify-between mt-3.5 pt-3.5 border-t border-gray-50">
                            <span class="price-tag text-xl">
                                {{ number_format($car->price, 0, ',', '.') }} €
                            </span>
                            <span class="text-xs text-gray-400 group-hover:text-yellow-500
                                         transition-colors duration-150 font-medium flex items-center gap-0.5">
                                {{ __('View') }}
                                <svg class="h-3 w-3 transition-transform duration-150 group-hover:translate-x-0.5"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10 flex justify-center">
            {{ $cars->links() }}
        </div>
    @endif
</section>

</div>
