<nav x-data="{ open: false }" class="bg-gray-900 border-b border-gray-800/80 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-15 py-3">

            {{-- Logo + main links --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha"
                         class="h-8 w-auto transition-transform duration-200 group-hover:scale-105">
                    <span class="text-white font-bold text-base hidden sm:block tracking-tight">
                        Segunda<span class="text-yellow-400"> Marcha</span>
                    </span>
                </a>

                <div class="hidden sm:flex items-center gap-0.5">
                    <a href="{{ route('dashboard') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150
                              {{ request()->routeIs('dashboard') ? 'nav-link-active' : 'nav-link-idle' }}">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('cars.index') }}"
                       class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150
                              {{ request()->routeIs('cars.*') ? 'nav-link-active' : 'nav-link-idle' }}">
                        {{ __('My Cars') }}
                    </a>
                    @auth
                    @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.users.index') }}"
                           class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150
                                  {{ request()->routeIs('admin.*') ? 'nav-link-active' : 'nav-link-idle' }}">
                            <span class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                                {{ __('Admin') }}
                            </span>
                        </a>
                    @endif
                    @endauth
                </div>
            </div>

            {{-- Right side --}}
            <div class="hidden sm:flex items-center gap-2">

                {{-- Language switcher --}}
                <div class="flex items-center rounded-lg border border-gray-700 overflow-hidden">
                    <a href="{{ route('lang.switch', 'es') }}"
                       class="px-2.5 py-1.5 text-xs font-semibold transition-all duration-150
                              {{ app()->getLocale() === 'es'
                                 ? 'bg-yellow-400 text-gray-900'
                                 : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        ES
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-2.5 py-1.5 text-xs font-semibold transition-all duration-150
                              {{ app()->getLocale() === 'en'
                                 ? 'bg-yellow-400 text-gray-900'
                                 : 'text-gray-400 hover:text-white hover:bg-gray-800' }}">
                        EN
                    </a>
                </div>

                @auth
                {{-- Publish CTA --}}
                <a href="{{ route('cars.create') }}"
                   class="btn-primary-sm text-xs font-bold px-4 py-2">
                    {{ __('+ Publish') }}
                </a>

                {{-- User dropdown --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center gap-2.5 px-2.5 py-1.5 rounded-lg
                                       text-sm text-gray-300 hover:text-white hover:bg-gray-800
                                       transition-all duration-150 group">
                            <div class="w-7 h-7 rounded-full bg-yellow-400 flex items-center justify-center
                                        text-gray-900 font-black text-xs shrink-0">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="hidden lg:block max-w-32 truncate text-sm font-medium">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="h-3.5 w-3.5 text-gray-500 group-hover:text-gray-300 transition-colors"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd"/>
                            </svg>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div class="px-4 py-2.5 border-b border-gray-100">
                            <p class="text-xs font-semibold text-gray-900 truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-dropdown-link :href="route('profile.me')">{{ __('My Profile') }}</x-dropdown-link>
                        <x-dropdown-link :href="route('profile.edit')">{{ __('Settings') }}</x-dropdown-link>
                        <div class="border-t border-gray-100 mt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}"
                   class="text-sm text-gray-400 hover:text-white px-3 py-1.5 rounded-lg hover:bg-gray-800 transition-all font-medium">
                    {{ __('Log in') }}
                </a>
                <a href="{{ route('register') }}"
                   class="btn-primary-sm text-xs font-bold px-4 py-2">
                    {{ __('Sign up free') }}
                </a>
                @endauth
            </div>

            {{-- Mobile hamburger --}}
            <button @click="open = !open"
                    class="sm:hidden p-2 rounded-lg text-gray-400 hover:text-white hover:bg-gray-800 transition-all">
                <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden"
                          stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden bg-gray-800 border-t border-gray-700/60">
        @auth
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('dashboard') ? 'bg-gray-700 text-yellow-400' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                {{ __('Dashboard') }}
            </a>
            <a href="{{ route('cars.index') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium
                      {{ request()->routeIs('cars.*') ? 'bg-gray-700 text-yellow-400' : 'text-gray-300 hover:text-white hover:bg-gray-700' }}">
                {{ __('My Cars') }}
            </a>
            @if(Auth::user()->hasRole('admin'))
                <a href="{{ route('admin.users.index') }}"
                   class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                    {{ __('Admin') }}
                </a>
            @endif
        </div>
        <div class="px-4 py-3 border-t border-gray-700 space-y-1">
            <div class="px-3 py-2">
                <p class="text-sm font-semibold text-white">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
            </div>
            <a href="{{ route('profile.me') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-gray-700">{{ __('My Profile') }}</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-gray-700">{{ __('Settings') }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm text-gray-300 hover:text-white hover:bg-gray-700">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
        @else
        <div class="px-4 py-3 space-y-1">
            <a href="{{ route('login') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-700">
                {{ __('Log in') }}
            </a>
            <a href="{{ route('register') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium text-yellow-400 hover:text-yellow-300 hover:bg-gray-700">
                {{ __('Sign up free') }}
            </a>
        </div>
        @endauth
    </div>
</nav>
