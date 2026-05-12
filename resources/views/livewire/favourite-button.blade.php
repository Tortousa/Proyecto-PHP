{{-- Vista del componente FavouriteButton.
     wire:click llama al método toggle() del componente PHP.
     El corazón cambia de color según el estado $isFavourite. --}}
<div>
    <button wire:click="toggle"
            title="{{ $isFavourite ? 'Quitar de favoritos' : 'Añadir a favoritos' }}"
            class="p-1.5 rounded-full bg-white/80 backdrop-blur-sm shadow-sm hover:scale-110 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg"
             class="h-5 w-5 transition-colors {{ $isFavourite ? 'text-red-500 fill-red-500' : 'text-gray-400' }}"
             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
        </svg>
    </button>
</div>
