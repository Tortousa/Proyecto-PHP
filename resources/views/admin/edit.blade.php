@extends('layouts.app')

@section('header')
    <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit User') }}: {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.show', $user) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-xs font-bold uppercase rounded-md hover:bg-gray-700 transition">
                {{ __('Back') }}
            </a>
        </div>
@endsection

@section('content')
<div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">

                @if(session('status') === 'user-updated')
                    <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                        <p class="text-green-700 text-sm">{{ __('User updated successfully.') }}</p>
                    </div>
                @endif

                <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PATCH')

                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                            :value="old('name', $user->name)" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                            :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                            :value="old('phone', $user->phone)" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="rol" :value="__('Role')" />
                        <select id="rol" name="rol"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="user"  {{ old('rol', $user->rol) === 'user'  ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('rol', $user->rol) === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <x-input-error :messages="$errors->get('rol')" class="mt-2" />
                    </div>

                    <div class="border-t pt-6">
                        <p class="text-sm text-gray-500 mb-4">{{ __('Leave blank to keep current password.') }}</p>

                        <div>
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                        </div>
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>{{ __('Save Changes') }}</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
