<div class="space-y-4">

    {{-- Buscador --}}
    <input wire:model.live.debounce.300ms="search"
           type="text" placeholder="Buscar por nombre o email..."
           class="w-full px-4 py-2 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 outline-none">

    {{-- Tabla --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Nombre</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Email</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Rol</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-600">Coches</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 bg-white">
                @foreach($users as $user)
                    @if($editingId === $user->id)
                        <tr class="bg-yellow-50">
                            <td class="px-4 py-2">
                                <input wire:model="editName" class="w-full border rounded px-2 py-1 text-sm">
                                @error('editName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-4 py-2">
                                <input wire:model="editEmail" class="w-full border rounded px-2 py-1 text-sm">
                                @error('editEmail') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </td>
                            <td class="px-4 py-2">
                                <select wire:model="editRol" class="border rounded px-2 py-1 text-sm">
                                    <option value="user">user</option>
                                    <option value="admin">admin</option>
                                </select>
                            </td>
                            <td class="px-4 py-2 text-gray-500">{{ $user->cars_count ?? $user->cars->count() }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <button wire:click="save" class="px-3 py-1 bg-green-600 text-white rounded-lg text-xs font-semibold hover:bg-green-700">Guardar</button>
                                <button wire:click="cancel" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-lg text-xs font-semibold hover:bg-gray-300">Cancelar</button>
                            </td>
                        </tr>
                    @else
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $user->rol === 'admin' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                                    {{ $user->rol }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">{{ $user->cars->count() }}</td>
                            <td class="px-4 py-3 flex gap-2">
                                <button wire:click="edit({{ $user->id }})" class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100">Editar</button>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="¿Eliminar este usuario?"
                                        class="px-3 py-1 bg-red-50 text-red-700 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100">Borrar</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <div>{{ $users->links() }}</div>

</div>
