<nav x-data="{ scrolled: false, mobileOpen: false }"
     x-init="window.addEventListener('scroll', () => scrolled = window.scrollY > 20)"
     :class="scrolled ? 'glass-dark shadow-float' : 'bg-transparent'"
     class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha"
                     class="h-9 w-auto transition-transform duration-200 group-hover:scale-105">
                <span class="text-white font-bold text-lg hidden sm:block tracking-tight">
                    Segunda<span class="text-yellow-400"> Marcha</span>
                </span>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-1">
                <a href="{{ route('home') }}"
                   class="px-3 py-2 text-sm font-medium rounded-lg transition-all duration-150
                          {{ request()->routeIs('home') ? 'text-yellow-400 bg-white/10' : 'text-gray-300 hover:text-white hover:bg-white/10' }}">
                    {{ __('Home') }}
                </a>
                <a href="#catalogo"
                   class="px-3 py-2 text-sm font-medium rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-all duration-150">
                    {{ __('Catalog') }}
                </a>
            </div>

            {{-- CTA buttons --}}
            <div class="flex items-center gap-3">

                {{-- Language switcher --}}
                <div class="hidden sm:flex items-center rounded-lg border border-white/20 overflow-hidden">
                    <a href="{{ route('lang.switch', 'es') }}"
                       class="px-2.5 py-1.5 text-xs font-semibold transition-all duration-150
                              {{ app()->getLocale() === 'es' ? 'bg-yellow-400 text-gray-900' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                        ES
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}"
                       class="px-2.5 py-1.5 text-xs font-semibold transition-all duration-150
                              {{ app()->getLocale() === 'en' ? 'bg-yellow-400 text-gray-900' : 'text-gray-400 hover:text-white hover:bg-white/10' }}">
                        EN
                    </a>
                </div>
                @auth
                    <a href="{{ route('dashboard') }}"
                       class="hidden sm:inline-flex btn-ghost text-sm text-gray-300 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-all duration-150">
                        {{ __('Dashboard') }}
                    </a>
                    <a href="{{ route('cars.create') }}" class="btn-primary-sm font-bold text-xs sm:text-sm px-4 py-2">
                        {{ __('+ Post listing') }}
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex text-sm text-gray-300 hover:text-white px-3 py-2 rounded-lg hover:bg-white/10 transition-all duration-150 font-medium">
                        {{ __('Log in') }}
                    </a>
                    <a href="{{ route('register') }}" class="btn-primary-sm text-xs sm:text-sm px-4 py-2 font-bold">
                        {{ __('Sign up free') }}
                    </a>
                @endauth

                {{-- Mobile toggle --}}
                <button @click="mobileOpen = !mobileOpen"
                        class="md:hidden p-2 rounded-lg text-gray-300 hover:text-white hover:bg-white/10 transition-all">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" style="display:none"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden glass-dark border-t border-white/10 px-4 py-4 space-y-1"
         style="display:none">
        <a href="{{ route('home') }}"
           class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10">
            {{ __('Home') }}
        </a>
        <a href="#catalogo"
           class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10">
            {{ __('Catalog') }}
        </a>
        @auth
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10">
                {{ __('My dashboard') }}
            </a>
        @else
            <a href="{{ route('login') }}"
               class="block px-3 py-2.5 rounded-lg text-sm font-medium text-gray-200 hover:text-white hover:bg-white/10">
                {{ __('Log in') }}
            </a>
        @endauth
    </div>
</nav>
