@props(['car', 'manage' => false])

<article class="card-hover group overflow-hidden flex flex-col relative">

    {{-- Favourite --}}
    <div class="absolute top-3 right-3 z-10">
        <livewire:favourite-button :car-id="$car->id" :key="'card-fav-'.$car->id" />
    </div>

    <a href="{{ route('cars.show', $car) }}" class="block flex-1">

        {{-- Image --}}
        <div class="aspect-video overflow-hidden bg-gray-100 relative">
            @if($car->primaryImage)
                <img src="{{ $car->primaryImage->url }}"
                     alt="{{ $car->maker->name }} {{ $car->model->name }}"
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

            @if($car->fuelType)
                <span class="absolute bottom-2 left-2 badge-dark text-xs">
                    {{ $car->fuelType->name }}
                </span>
            @endif
        </div>

        {{-- Info --}}
        <div class="p-4">
            <h4 class="font-bold text-gray-900 text-sm truncate leading-snug">
                {{ $car->maker->name }} {{ $car->model->name }}
            </h4>
            <p class="text-xs text-gray-400 mt-0.5 flex items-center gap-1.5">
                <span>{{ $car->year }}</span>
                <span class="w-0.5 h-0.5 rounded-full bg-gray-300"></span>
                <span>{{ number_format($car->mileage) }} km</span>
                @if($car->city ?? null)
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
                    Ver
                    <svg class="h-3 w-3 transition-transform duration-150 group-hover:translate-x-0.5"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            </div>
        </div>
    </a>

    @if($manage)
        <div class="px-4 pb-4 flex gap-2">
            <a href="{{ route('cars.edit', $car) }}"
               class="flex-1 btn-secondary-sm text-xs font-semibold text-center justify-center">
                Editar
            </a>
            <form action="{{ route('cars.destroy', $car) }}" method="POST" class="flex-1">
                @csrf @method('DELETE')
                <button type="submit"
                        onclick="return confirm('{{ __('¿Seguro que deseas eliminar este coche?') }}')"
                        class="w-full btn-danger text-xs font-semibold">
                    Borrar
                </button>
            </form>
        </div>
    @endif
</article>
