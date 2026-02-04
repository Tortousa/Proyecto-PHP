<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Coches') }}
            </h2>
            <a href="{{ route('cars.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
                + Añadir Coche
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

                <table class="min-w-full border">
                    <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Marca</th>
                        <th class="border px-4 py-2">Modelo</th>
                        <th class="border px-4 py-2">Precio</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cars as $car)
                        <tr>
                            <td class="border px-4 py-2">{{ $car->maker->name }}</td>
                            <td class="border px-4 py-2">{{ $car->model->name }}</td>
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
                @endif
            </div>
        </div>
    </div>
</x-app-layout>