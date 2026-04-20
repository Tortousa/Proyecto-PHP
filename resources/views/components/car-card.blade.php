@props(['car'])

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

        @if(isset($showLink) && $showLink)
            <a href="{{ route('cars.show', $car) }}" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">
                {{ __('View Details') }}
            </a>
        @endif
    </div>
</div>