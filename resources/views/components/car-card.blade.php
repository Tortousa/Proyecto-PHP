@props(['car', 'manage' => false])

<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
    <div class="aspect-w-16 aspect-h-9 bg-gray-200">
        @if($car->primaryImage)
            @php
                $imgPath = $car->primaryImage->image_path;
                $src = (strpos($imgPath, 'http') === 0) ? $imgPath : asset('storage/' . $imgPath);
            @endphp
            <img src="{{ $src }}" alt="{{ $car->maker->name }} {{ $car->model->name }}" class="w-full h-48 object-cover" />
        @else
            <div class="w-full h-48 bg-gray-300 flex items-center justify-center">
                <span class="text-gray-500 text-sm">{{ __('No image') }}</span>
            </div>
        @endif
    </div>

    <div class="p-4">
        <h4 class="font-bold text-lg text-gray-900 mb-1">
            {{ $car->maker->name }} {{ $car->model->name }}
        </h4>

        <div class="flex items-center justify-between text-sm text-gray-600 mb-2">
            <span>{{ $car->year }}</span>
            <span>{{ $car->city->name ?? '' }}</span>
        </div>

        <div class="flex items-center justify-between">
            <span class="text-xl font-bold text-indigo-600">
                {{ number_format($car->price, 0, ',', '.') }} €
            </span>
            <span class="text-sm text-gray-500">
                {{ $car->mileage }} km
            </span>
        </div>

        <p class="text-sm text-gray-600 mt-2 line-clamp-2">
            {{ Str::limit($car->description ?? __('No description available.'), 100) }}
        </p>

        @if($manage)
            <div class="mt-4 flex flex-col gap-2">
                <a href="{{ route('cars.edit', $car) }}" class="inline-flex justify-center items-center rounded-md border border-indigo-600 bg-indigo-50 px-3 py-2 text-sm font-semibold text-indigo-700 hover:bg-indigo-100">
                    {{ __('Editar') }}
                </a>
                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline-flex">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex justify-center items-center rounded-md border border-red-600 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100" onclick="return confirm('{{ __('¿Seguro que deseas eliminar este coche?') }}')">
                        {{ __('Borrar') }}
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>