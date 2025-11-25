<nav class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ url('/') }}" class="text-2xl font-bold text-blue-600 flex items-center gap-2">
                <span>🚗</span> AutoDrive
            </a>

            <!-- Menu Principal -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('vehicles.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Véhicules</a>
                <a href="{{ route('promotions') }}" class="text-gray-700 hover:text-blue-600 font-medium">Promotions</a>
                <a href="{{ route('about') }}" class="text-gray-700 hover:text-blue-600 font-medium">À propos</a>
                <a href="{{ route('contact') }}" class="text-gray-700 hover:text-blue-600 font-medium">Contact</a>
            </div>

            <!-- Partie Droite : Connexion / Admin -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                <!-- 1. Bouton Administration (Seulement pour l'Admin) -->
                @if(Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="mr-2 bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 text-sm font-bold shadow-md transition transform hover:scale-105">
                    Administration
                </a>
                @endif

                <!-- 2. Bouton Mes Réservations (POUR TOUT LE MONDE, même l'admin) -->
                <a href="{{ route('user.bookings') }}" class="mr-2 bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-gray-700 text-sm font-bold shadow-md transition transform hover:scale-105">
                    <span>Mes Réservations</span>
                </a>


                <!-- JOLI MENU UTILISATEUR -->
                <div class="ml-4 flex items-center gap-3 pl-4 border-l border-gray-200">
                    <div class="flex flex-col text-right">
                        <span class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</span>
                        <span class="text-xs text-gray-500">Connecté</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 p-2 rounded-full transition" title="Déconnexion">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>

                @else
                <!-- Si pas connecté -->
                <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 font-medium">Connexion</a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-5 py-2.5 rounded-full font-bold hover:bg-blue-700 shadow-md transition transform hover:scale-105">
                    Inscription
                </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
