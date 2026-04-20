@props([])

<!-- Formulario de filtros -->
<form method="GET" action="{{ url()->current() }}" class="mb-6 p-4 bg-gray-50 rounded-lg">
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
                @foreach($fuelTypes as $fuelType)
                    <option value="{{ $fuelType->id }}" {{ request('fuel_type') == $fuelType->id ? 'selected' : '' }}>{{ $fuelType->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-4 flex justify-between">
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Filtrar</button>
        <a href="{{ url()->current() }}" class="text-gray-600 underline">Limpiar filtros</a>
    </div>
</form>