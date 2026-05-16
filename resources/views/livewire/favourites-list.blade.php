{{-- Vista del componente FavouritesList.
     wire:click llama al método PHP del componente sin recargar la página.
     wire:model vincula el textarea con la propiedad $editingNote en tiempo real. --}}
<div>
    @if($favourites->isEmpty())
        <div class="text-center py-12 text-gray-400">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
            <p class="font-semibold">{{ __('You have no favourites yet') }}</p>
            <a href="{{ route('home') }}" class="mt-2 inline-block text-yellow-500 hover:text-yellow-600 text-sm font-semibold">
                Explorar coches →
            </a>
        </div>
    @else
        <ul class="divide-y divide-gray-100">
            @foreach($favourites as $car)
                <li class="flex items-start gap-4 py-4">

                    {{-- Miniatura --}}
                    <a href="{{ route('cars.show', $car) }}" class="shrink-0">
                        @if($car->primaryImage)
                            <img src="{{ $car->primaryImage->url }}"
                                 alt="{{ $car->maker->name }}"
                                 class="w-20 h-14 object-cover rounded-lg border border-gray-100">
                        @else
                            <div class="w-20 h-14 bg-gray-100 rounded-lg flex items-center justify-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14" />
                                </svg>
                            </div>
                        @endif
                    </a>

                    {{-- Datos del coche --}}
                    <div class="flex-1 min-w-0">
                        <a href="{{ route('cars.show', $car) }}"
                           class="font-bold text-gray-900 hover:text-yellow-500 transition truncate block">
                            {{ $car->maker->name }} {{ $car->model->name }}
                        </a>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ number_format($car->price, 0, ',', '.') }} €
                            · Añadido {{ \Carbon\Carbon::parse($car->pivot->added_at)->diffForHumans() }}
                        </p>

                        {{-- Modo edición de nota --}}
                        @if($editingId === $car->id)
                            <div class="mt-2">
                                <textarea
                                    wire:model="editingNote"
                                    rows="2"
                                    placeholder="Tu nota personal sobre este coche..."
                                    class="w-full text-sm px-3 py-2 border border-yellow-300 rounded-lg focus:ring-2 focus:ring-yellow-400 outline-none resize-none">
                                </textarea>
                                <div class="flex gap-2 mt-1.5">
                                    <button wire:click="saveNote"
                                            class="px-3 py-1 bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-xs font-bold rounded-lg transition">
                                        Guardar
                                    </button>
                                    <button wire:click="cancelEdit"
                                            class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-semibold rounded-lg transition">
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        @else
                            {{-- Muestra la nota si existe --}}
                            @if($car->pivot->notes)
                                <p class="text-xs text-gray-500 mt-1 italic">"{{ $car->pivot->notes }}"</p>
                            @endif
                        @endif
                    </div>

                    {{-- Acciones --}}
                    <div class="flex items-center gap-2 shrink-0">
                        @unless($editingId === $car->id)
                            <button wire:click="startEdit({{ $car->id }})"
                                    title="Editar nota"
                                    class="p-1.5 text-gray-400 hover:text-yellow-500 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                        @endunless

                        <button wire:click="remove({{ $car->id }})"
                                wire:confirm="¿Quitar este coche de favoritos?"
                                title="Eliminar favorito"
                                class="p-1.5 text-gray-400 hover:text-red-500 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
