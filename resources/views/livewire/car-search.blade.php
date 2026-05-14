{{-- Vista del componente CarSearch.
     wire:model.live actualiza la propiedad PHP al instante sin submit.
     wire:loading muestra el spinner mientras Livewire hace la petición al servidor. --}}
<div>

    {{-- ── BANDA ESTADÍSTICAS (dinámica) ──────────────────────────────── --}}
    <section class="bg-yellow-400 py-5">
        <div class="max-w-4xl mx-auto px-4 flex flex-wrap justify-center gap-10 text-gray-900 text-center">
            <div>
                <p class="text-3xl font-black">{{ $cars->total() }}</p>
                <p class="text-sm font-semibold">Anuncios encontrados</p>
            </div>
            <div>
                <p class="text-3xl font-black">100%</p>
                <p class="text-sm font-semibold">Gratis para publicar</p>
            </div>
            <div>
                <p class="text-3xl font-black">24/7</p>
                <p class="text-sm font-semibold">Disponible siempre</p>
            </div>
        </div>
    </section>

    {{-- ── FILTROS ──────────────────────────────────────────────────────── --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-4">
        <div class="flex flex-wrap gap-3 items-center">

            {{-- Búsqueda por texto: se actualiza con debounce de 300ms --}}
            <input
                wire:model.live.debounce.300ms="search"
                type="text"
                placeholder="Marca o modelo..."
                class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm w-52 focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none">

            {{-- Filtro combustible: se actualiza al instante --}}
            <select wire:model.live="fuelType"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none">
                <option value="">Todos los combustibles</option>
                @foreach($fuelTypes as $ft)
                    <option value="{{ $ft->id }}">{{ $ft->name }}</option>
                @endforeach
            </select>

            {{-- Ordenación --}}
            <select wire:model.live="sortBy"
                    class="px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none">
                <option value="latest">Más recientes</option>
                <option value="price_asc">Precio: menor a mayor</option>
                <option value="price_desc">Precio: mayor a menor</option>
            </select>

            {{-- Spinner visible mientras Livewire espera respuesta --}}
            <div wire:loading class="flex items-center gap-2 text-gray-400 text-sm">
                <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                Buscando...
            </div>
        </div>
    </section>

    {{-- ── RESULTADOS ───────────────────────────────────────────────────── --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

        @if($cars->isEmpty())
            <div class="text-center py-24 text-gray-400">
                <p class="text-xl font-semibold">No hay anuncios que coincidan con tu búsqueda</p>
                <button wire:click="$set('search', '')" class="mt-4 text-yellow-500 hover:text-yellow-600 text-sm font-semibold">
                    Limpiar búsqueda →
                </button>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-4"
                 wire:loading.class="opacity-50">

                @foreach($cars as $car)
                    <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-200 overflow-hidden border border-gray-100 group relative">

                        {{-- Botón favorito --}}
                        @auth
                        <div class="absolute top-2 right-2 z-10">
                            <button wire:click="toggleFavourite({{ $car->id }})"
                                    class="p-1.5 rounded-full bg-white/80 backdrop-blur-sm shadow-sm hover:scale-110 transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-5 w-5 transition-colors {{ in_array($car->id, $favouriteIds, true) ? 'text-red-500 fill-red-500' : 'text-gray-400' }}"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </button>
                        </div>
                        @endauth

                        <a href="{{ route('cars.show', $car) }}">
                            {{-- Imagen --}}
                            <div class="aspect-video bg-gray-100 overflow-hidden">
                                @if($car->primaryImage)
                                    <img src="{{ $car->primaryImage->url }}"
                                         alt="{{ $car->maker->name ?? '' }} {{ $car->model->name ?? '' }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-14 w-14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                                @if($car->fuelType)
                                    <span class="absolute top-2 left-2 px-2 py-0.5 bg-gray-900/70 text-white text-xs rounded-full">
                                        {{ $car->fuelType->name }}
                                    </span>
                                @endif
                            </div>

                            {{-- Info --}}
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 text-base truncate">
                                    {{ $car->maker->name ?? '—' }} {{ $car->model->name ?? '—' }}
                                </h3>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $car->year }} · {{ number_format($car->mileage) }} km
                                    @if($car->city) · {{ $car->city->name }} @endif
                                </p>
                                <div class="mt-3 flex items-center justify-between">
                                    <span class="text-xl font-black text-yellow-500">
                                        {{ number_format($car->price, 0, ',', '.') }} €
                                    </span>
                                    <span class="text-xs text-gray-400 bg-gray-100 px-2 py-1 rounded-full">Ver más →</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $cars->links() }}
            </div>
        @endif
    </section>

</div>
