@extends('layouts.app')

@section('title', 'Editar usuario — ' . $user->name)

@section('header')
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-white">Editar usuario</h1>
            <p class="text-gray-400 text-sm mt-0.5">{{ $user->name }}</p>
        </div>
        <a href="{{ route('admin.users.show', $user) }}"
           class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm font-semibold rounded-lg transition">
            ← Volver
        </a>
    </div>
@endsection

@section('content')

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-5">
                @csrf @method('PATCH')

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Rol</label>
                    <select name="rol"
                            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                        <option value="user"  {{ old('rol', $user->rol) === 'user'  ? 'selected' : '' }}>Usuario</option>
                        <option value="admin" {{ old('rol', $user->rol) === 'admin' ? 'selected' : '' }}>Administrador</option>
                    </select>
                </div>

                <div class="border-t border-gray-100 pt-5">
                    <p class="text-xs text-gray-400 mb-4">Deja en blanco para mantener la contraseña actual.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nueva contraseña</label>
                            <input type="password" name="password" autocomplete="new-password"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Confirmar contraseña</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-yellow-400 focus:border-transparent outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                            class="w-full py-3 bg-yellow-400 hover:bg-yellow-300 text-gray-900 font-black rounded-xl transition">
                        Guardar cambios
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection
