<nav class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                <span>🚗</span> AutoDrive
            </a>

            <!-- Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600 font-medium">Accueil</a>
                <a href="{{ route('promotions') }}" class="text-gray-700 hover:text-blue-600 font-medium">Promotions</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium">À propos</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
            </div>

            <!-- Boutons Connexion -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="bg-gray-100 text-gray-800 px-4 py-2 rounded hover:bg-gray-200">Mon Compte</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Inscription</a>
                @endauth
            </div>
        </div>
    </div>
</nav>