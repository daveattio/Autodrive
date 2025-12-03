<nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm transition-all duration-300">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">

            <!-- 1. LOGO (Gauche) -->
            <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                <!-- Icône Voiture stylisée -->
                <div class="bg-blue-600 text-white p-2 rounded-lg shadow-lg shadow-blue-500/30 transform group-hover:rotate-12 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <span class="text-2xl font-black tracking-tighter text-gray-900">
                    Auto<span class="text-blue-600">Drive</span>
                </span>
            </a>

            <!-- 2. MENU CENTRAL (Liens avec animation soulignée) -->
            <div class="hidden md:flex space-x-8">
                @foreach([
                ['route' => 'vehicles.index', 'label' => 'Véhicules'],
                ['route' => 'promotions', 'label' => 'Promotions'],
                ['route' => 'about', 'label' => 'À propos'],
                 ['route' => 'blog', 'label' => 'Blog'],
                ['route' => 'contact', 'label' => 'Contact']
                ] as $link)
                <a href="{{ route($link['route']) }}"
                    class="relative text-gray-600 font-medium hover:text-blue-600 transition duration-300 py-2 group">
                    {{ $link['label'] }}
                    <!-- Ligne animée au survol -->
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 transition-all duration-300 group-hover:w-full"></span>
                </a>
                @endforeach
            </div>

            <!-- 3. ZONE DROITE (Auth & Actions) -->
            <div class="hidden md:flex items-center gap-4">
                @auth
                <!-- Actions Dynamiques -->
                <div class="flex items-center gap-3">
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="bg-gradient-to-r from-red-600 to-red-500 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-red-500/30 hover:shadow-red-500/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Administration
                    </a>
                    @endif

                    <a href="{{ route('user.bookings') }}"
                        class="bg-blue-600 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-blue-500/30 hover:shadow-blue-500/50 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Mes Réservations
                    </a>
                </div>

                <!-- Séparateur -->
                <div class="h-8 w-px bg-gray-200 mx-2"></div>

                <!-- Profil Utilisateur (Pilule Grise) -->
                <div class="flex items-center bg-gray-100 rounded-full p-1 pr-4 transition hover:bg-gray-200">
                    <div class="bg-white p-2 rounded-full shadow-sm text-gray-700 mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex flex-col mr-3">
                        <span class="text-xs font-bold text-gray-800 leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-green-500 uppercase tracking-wider">Connecté</span>
                    </div>

                    <!-- Bouton Logout Discret -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-gray-400 hover:text-red-500 transition" title="Se déconnecter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </button>
                    </form>
                </div>

                @else
                <!-- Non Connecté -->
                <div class="flex items-center gap-4">
                    <a href="{{ route('login') }}" class="text-gray-600 font-bold hover:text-blue-600 transition">Connexion</a>
                    <a href="{{ route('register') }}" class="bg-gray-900 text-white px-6 py-2.5 rounded-full font-bold shadow-lg hover:bg-gray-800 hover:shadow-xl transition transform hover:-translate-y-0.5">
                        Inscription
                    </a>
                </div>
                @endauth
            </div>

            <!-- Mobile Menu Button (Hamburger) -->
            <div class="md:hidden flex items-center">
                <button class="text-gray-600 focus:outline-none p-2">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
