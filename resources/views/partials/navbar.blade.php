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

            <!-- Zone Droite : Connexion / Admin -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                    <!-- LOGIQUE DES RÔLES -->
                    @if(Auth::user()->role === 'admin')
                        <!-- Lien rouge pour l'Admin -->
                        <a href="{{ route('admin.dashboard') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm font-bold">
                            ADMINISTRATION
                        </a>
                    @else
                        <!-- Lien bleu pour le Client -->
                        <a href="{{ route('user.bookings') }}" class="text-blue-600 font-bold hover:underline">
                            Mes Réservations
                        </a>
                    @endif

                    <!-- MENU PROFIL & DÉCONNEXION (Simple) -->
                    <div class="ml-4 border-l pl-4 flex items-center gap-3">
                        <span class="text-sm text-gray-500">Hello, {{ Auth::user()->name }}</span>
                        
                        <!-- Formulaire de déconnexion -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-sm text-gray-500 hover:text-red-500">
                                (Déconnexion)
                            </button>
                        </form>
                    </div>

                @else
                    <!-- Si pas connecté -->
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">Inscription</a>
                @endauth
            </div>
        </div>
    </div>
</nav>