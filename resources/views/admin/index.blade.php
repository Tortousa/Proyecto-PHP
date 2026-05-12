@extends('layouts.app')

@section('title', 'Gestión de usuarios — Segunda Marcha')

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Gestión de usuarios</h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ $users->total() }} usuarios registrados</p>
        </div>
    </div>
@endsection

@section('content')

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead>
                <tr class="bg-gray-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Coches</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Registro</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-full bg-yellow-400 flex items-center justify-center font-bold text-gray-900 text-sm shrink-0">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex px-2.5 py-1 text-xs font-semibold rounded-full
                                {{ $user->isAdmin() ? 'bg-gray-900 text-yellow-400' : 'bg-gray-100 text-gray-600' }}">
                                {{ $user->rol }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-700">
                            {{ $user->cars_count }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-400">
                            {{ $user->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition">
                                    Ver
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="px-3 py-1.5 text-xs font-semibold text-gray-900 bg-yellow-400 hover:bg-yellow-300 rounded-lg transition">
                                    Editar
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('¿Eliminar a {{ $user->name }}?')"
                                            class="px-3 py-1.5 text-xs font-semibold text-white bg-red-500 hover:bg-red-600 rounded-lg transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-6 py-4 border-t border-gray-100">
            {{ $users->links() }}
        </div>
    </div>

@endsection
