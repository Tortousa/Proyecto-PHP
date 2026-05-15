<footer class="bg-gray-900 border-t border-gray-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Top section --}}
        <div class="py-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

            {{-- Brand --}}
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-9 w-auto">
                    <span class="text-white font-bold text-xl tracking-tight">
                        Segunda<span class="text-yellow-400"> Marcha</span>
                    </span>
                </a>
                <p class="text-gray-400 text-sm leading-relaxed max-w-xs">
                    {{ __('The most complete used car marketplace. Buy and sell with confidence.') }}
                </p>
                <div class="flex gap-3 mt-5">
                    <a href="{{ route('register') }}"
                       class="btn-primary-sm text-sm font-bold">
                        {{ __('Post for free') }}
                    </a>
                </div>
            </div>

            {{-- Links --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">{{ __('Platform') }}</h4>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('home') }}"
                           class="text-sm text-gray-400 hover:text-white transition-colors duration-150">
                            {{ __('Home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}"
                           class="text-sm text-gray-400 hover:text-white transition-colors duration-150">
                            {{ __('Log in') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}"
                           class="text-sm text-gray-400 hover:text-white transition-colors duration-150">
                            {{ __('Register') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Ventajas --}}
            <div>
                <h4 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">{{ __('Why us?') }}</h4>
                <ul class="space-y-3">
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                        {{ __('100% free to post') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                        {{ __('Available 24/7') }}
                    </li>
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-400"></span>
                        {{ __('No commissions') }}
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom bar --}}
        <div class="border-t border-gray-800 py-5 flex flex-col sm:flex-row items-center justify-between gap-3">
            <p class="text-xs text-gray-600">
                &copy; {{ date('Y') }} Segunda Marcha. {{ __('All rights reserved.') }}
            </p>
            <p class="text-xs text-gray-600">
                {{ __('Developed by') }} <span class="text-gray-400 font-medium">Daniel Tortosa Burtseva</span>
            </p>
        </div>
    </div>
</footer>
