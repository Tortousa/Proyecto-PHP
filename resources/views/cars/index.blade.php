<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Cars') }}
            </h2>
            <a href="{{ route('cars.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 shadow-sm transition">
                {{ __('Sell my car') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulario de filtros -->
                <form method="GET" action="{{ route('cars.index') }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="maker" class="block text-sm font-medium text-gray-700">Marca</label>
                            <input type="text" name="maker" id="maker" value="{{ request('maker') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Buscar por marca">
                        </div>

                        <div>
                            <label for="min_price" class="block text-sm font-medium text-gray-700">Precio Mínimo</label>
                            <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="0">
                        </div>

                        <div>
                            <label for="max_price" class="block text-sm font-medium text-gray-700">Precio Máximo</label>
                            <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="100000">
                        </div>

                        <div>
                            <label for="fuel_type" class="block text-sm font-medium text-gray-700">Tipo de Combustible</label>
                            <select name="fuel_type" id="fuel_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="1" {{ request('fuel_type') == '1' ? 'selected' : '' }}>Gasolina</option>
                                <option value="2" {{ request('fuel_type') == '2' ? 'selected' : '' }}>Diésel</option>
                                <!-- Agrega más opciones según tus fuel_types -->
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filtrar</button>
                        <a href="{{ route('cars.index') }}" class="text-gray-600 underline">Limpiar filtros</a>
                    </div>
                </form>

                <table class="min-w-full border">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Marca</th>
                        <th class="border px-4 py-2">Modelo</th>
                        <th class="border px-4 py-2">Foto</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td class="border px-4 py-2">{{ $car->maker->name }}</td>
                            <td class="border px-4 py-2">{{ $car->model->name }}</td>
                            <td class="border px-4 py-2">
                                @if($car->primaryImage)
                                    @php
                                        $imgPath = $car->primaryImage->image_path;
                                        $src = (strpos($imgPath, 'http') === 0) ? $imgPath : asset('storage/' . $imgPath);
                                    @endphp
                                    <img src="{{ $src }}" alt="" class="w-24 h-16 object-cover rounded" />
                                @else
                                    <span class="text-xs text-gray-500">No image</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ number_format($car->price, 2) }}€</td>
                            <td class="border px-4 py-2 text-center">
                                <a href="{{ route('cars.edit', $car) }}" class="text-blue-600">Editar</a>
                                <form action="{{ route('cars.destroy', $car) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 ml-2" onclick="return confirm('¿Seguro?')">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if($cars->isEmpty())
                    <p class="text-center py-4">No tienes coches guardados todavía.</p>
                @else
                    <!-- Paginación -->
                    <div class="mt-6">
                        {{ $cars->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>