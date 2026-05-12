<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">

        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo.png') }}" alt="Segunda Marcha" class="h-10 w-auto">
            <span class="text-xl font-bold text-gray-800 hidden sm:block">Segunda Marcha</span>
        </a>

        <div class="flex items-center gap-4">
            @auth
                <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                    Panel
                </a>
                <a href="{{ route('cars.create') }}"
                   class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-sm font-semibold rounded-lg transition">
                    + Publicar anuncio
                </a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-gray-900 font-medium">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-gray-900 text-sm font-semibold rounded-lg transition">
                    Registrarse
                </a>
            @endauth
        </div>

    </div>
</nav>
