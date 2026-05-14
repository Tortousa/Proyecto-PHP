<div class="space-y-4">

    <h3 class="text-sm font-semibold text-gray-700">Imágenes del anuncio</h3>

    {{-- Grid de imágenes actuales --}}
    @if($images->isNotEmpty())
        <div class="grid grid-cols-3 gap-3">
            @foreach($images as $image)
                <div class="relative group">
                    <img src="{{ $image->url }}" class="w-full h-28 object-cover rounded-lg border border-gray-200">
                    <button wire:click="delete({{ $image->id }})"
                            wire:confirm="¿Eliminar esta imagen?"
                            class="absolute top-1 right-1 bg-red-600 text-white rounded-full w-6 h-6 text-xs hidden group-hover:flex items-center justify-center">
                        ✕
                    </button>
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
