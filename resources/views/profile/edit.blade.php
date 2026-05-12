@extends('layouts.app')

@section('title', 'Configuración — Segunda Marcha')

@section('header')
    <div>
        <h1 class="text-2xl font-bold text-white">Configuración</h1>
        <p class="text-gray-400 text-sm mt-0.5">Gestiona tu cuenta y contraseña</p>
    </div>
@endsection

@section('content')

    <div class="max-w-2xl mx-auto space-y-6">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-bold text-gray-900 mb-5">Información personal</h2>
            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-base font-bold text-gray-900 mb-5">Cambiar contraseña</h2>
            @include('profile.partials.update-password-form')
        </div>

        <div class="bg-red-50 border border-red-100 rounded-2xl p-6">
            <h2 class="text-base font-bold text-red-700 mb-1">Zona de peligro</h2>
            <p class="text-sm text-red-500 mb-5">Esta acción es irreversible. Se eliminarán todos tus datos y anuncios.</p>
            @include('profile.partials.delete-user-form')
        </div>

    </div>

@endsection
