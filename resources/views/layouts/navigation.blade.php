<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            {{-- Logo + links principales --}}
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-9 w-auto">
                    <span class="text-white font-bold text-lg hidden sm:block">Segunda Marcha</span>
                </a>

                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-1">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('dashboard') ? 'bg-gray-800 text-yellow-400' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                        Panel
                    </a>
                    <a href="{{ route('cars.index') }}"
                       class="px-3 py-2 rounded-md text-sm font-medium transition
                              {{ request()->routeIs('cars.*') ? 'bg-gray-800 text-yellow-400' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                        Mis coches
                    </a>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium transition
                                  {{ request()->routeIs('admin.*') ? 'bg-gray-800 text-yellow-400' : 'text-gray-300 hover:text-white hover:bg-gray-800' }}">
                            Admin
                        </a>
                    @endif
                </div>
            </div>

            {{-- Derecha: idioma + usuario --}}
            <div class="hidden sm:flex sm:items-center gap-3">

                {{-- Selector idioma --}}
                <div class="flex items-center gap-1">
                    <a href="{{ route('lang.switch', 'es') }}"
                       class="px-2 py-1 text-xs rounded font-medium transition
                              {{ app()->getLocale() === 'es' ? 'bg-yellow-400 text-gray-900' : 'text-gray-400 hover:text-white' }}">ES</a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-2 py-1 text-xs rounded font-medium transition
                              {{ app()->getLocale() === 'en' ? 'bg-yellow-400 text-gray-900' : 'text-gray-400 hover:text-white' }}">EN</a>
                </div>

                {{-- Botón publicar --}}
                <a href="{{ route('cars.create') }}"
                   class="px-4 py-1.5 bg-yellow-400 hover:bg-yellow-300 text-gray-900 text-sm font-bold rounded-lg transition">
                    + Publicar
                </a>

                {{-- Dropdown usuario --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-gray-800 transition">
                            <div class="w-7 h-7 rounded-full bg-yellow-400 flex items-center justify-center text-gray-900 font-bold text-xs">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.me')">Mi perfil</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">Configuración</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger móvil --}}
            <div class="flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-800 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú móvil --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-gray-800 border-t border-gray-700">
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">Panel</a>
            <a href="{{ route('cars.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">Mis coches</a>
            @if(Auth::user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-md text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">Admin</a>
            @endif
        </div>
        <div class="px-4 py-3 border-t border-gray-700">
            <p class="text-sm font-medium text-white">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-gray-700">Configuración</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-3 py-2 rounded-md text-sm text-gray-300 hover:text-white hover:bg-gray-700">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>
