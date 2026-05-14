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

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <livewire:admin-users />
    </div>

@endsection
