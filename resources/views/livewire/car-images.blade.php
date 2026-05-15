<div class="space-y-4">

    <h3 class="text-sm font-semibold text-gray-700">{{ __('Listing images') }}</h3>

    {{-- Grid de imágenes actuales --}}
    @if($images->isNotEmpty())
        <div class="grid grid-cols-3 gap-3">
            @foreach($images as $image)
                <div class="relative group">
                    <img src="{{ $image->url }}" class="w-full h-28 object-cover rounded-lg border border-gray-200">
                    {{-- Overlay de acciones: visible al hacer hover --}}
                    <div class="absolute inset-0 hidden group-hover:flex flex-col items-end justify-between p-1 gap-1">
                        <button wire:click="delete({{ $image->id }})"
                                wire:confirm="¿Eliminar esta imagen?"
                                class="bg-red-600 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                            ✕
                        </button>
                        @if($image->position !== 0)
                        <button wire:click="setPrimary({{ $image->id }})"
                                title="Marcar como imagen principal"
                                class="bg-yellow-400 text-gray-900 rounded-full w-6 h-6 text-xs flex items-center justify-center font-bold">
                            ★
                        </button>
                        @else
                        <span class="bg-yellow-400 text-gray-900 rounded-full w-6 h-6 text-xs flex items-center justify-center font-bold" title="Imagen principal">
                            ★
                        </span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-sm text-gray-400">Sin imágenes todavía.</p>
    @endif

    {{-- Subir nueva imagen --}}
    <div class="flex items-center gap-3">
        <input type="file" wire:model="newImage" accept="image/*"
               class="text-sm text-gray-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:text-indigo-700 file:text-sm file:font-semibold hover:file:bg-indigo-100">
        <button wire:click="upload"
                class="px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg transition">
            Subir
        </button>
    </div>

    @error('newImage')
        <p class="text-red-500 text-xs">{{ $message }}</p>
    @enderror

    <div wire:loading wire:target="upload" class="text-sm text-gray-400">Subiendo...</div>

</div>
