@extends('layouts.app')

@section('title', 'Admin — Gestión de usuarios')

@section('header')
<div class="flex items-center justify-between gap-4 flex-wrap">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <span class="badge-yellow text-xs">Admin</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">Gestión de usuarios</h1>
        <p class="text-gray-400 text-sm mt-0.5">
            <span class="tabular-nums font-semibold text-gray-300">{{ $users->total() }}</span>
            usuarios registrados en la plataforma
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.cars.report.pdf') }}" target="_blank"
           class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-500
                  text-white text-sm font-bold rounded-xl transition-all duration-200 shadow-sm">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h4a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
            Informe PDF de anuncios
        </a>
    </div>
</div>
@endsection

@section('content')

{{-- Stats row --}}
<div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-7">
    <div class="stat-card">
        <p class="stat-label">Total usuarios</p>
        <p class="stat-value tabular-nums">{{ $users->total() }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Administradores</p>
        <p class="stat-value tabular-nums text-yellow-500">
            {{ $users->getCollection()->filter(fn($u) => $u->hasRole('admin'))->count() }}
        </p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Esta página</p>
        <p class="stat-value tabular-nums">{{ $users->count() }}</p>
    </div>
    <div class="stat-card">
        <p class="stat-label">Páginas</p>
        <p class="stat-value tabular-nums">{{ $users->lastPage() }}</p>
    </div>
</div>

{{-- Users table --}}
<div class="card overflow-hidden">
    <livewire:admin-users />
</div>

@endsection
