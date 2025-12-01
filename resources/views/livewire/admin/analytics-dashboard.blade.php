<div class="space-y-8">

    <!-- 1. KPI CARDS (Grille de 3 colonnes -> 6 Cartes au total) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Carte 1 : Chiffre d'Affaires (Noir/Bleu) -->
        <div class="bg-gray-900 text-white p-6 rounded-2xl shadow-lg flex items-center justify-between">
            <div>
                <div class="text-gray-400 text-xs uppercase tracking-widest mb-1">Revenu Total</div>
                <div class="text-2xl font-black text-blue-400">{{ number_format($totalRevenue, 0, ',', ' ') }} <span class="text-sm text-gray-500">FCFA</span></div>
            </div>
            <div class="p-3 bg-gray-800 rounded-lg text-blue-500">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Carte 2 : Clients (Vert) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-green-500 flex items-center justify-between">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Clients Inscrits</div>
                <div class="text-3xl font-bold text-gray-800">{{ $totalClients }}</div>
            </div>
            <div class="p-3 bg-green-50 rounded-lg text-green-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Carte 3 : Réservations Totales (Violet) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-purple-500 flex items-center justify-between">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Total Réservations</div>
                <div class="text-3xl font-bold text-gray-800">{{ $totalBookings }}</div>
            </div>
            <div class="p-3 bg-purple-50 rounded-lg text-purple-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                </svg>
            </div>
        </div>

        <!-- Carte 4 : À Traiter (Rouge/Orange - Urgent) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-orange-500 flex items-center justify-between">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">À traiter</div>
                <div class="text-3xl font-bold text-orange-600">{{ $pendingCount }}</div>
            </div>
            <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Carte 5 : Flotte (Bleu) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-blue-500 flex items-center justify-between">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Parc Automobile</div>
                <div class="text-3xl font-bold text-gray-800">{{ $totalVehicles }}</div>
            </div>
            <div class="p-3 bg-blue-50 rounded-lg text-blue-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>

        <!-- Carte 6 : Revenu Mois (Teal) -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border-l-4 border-teal-500 flex items-center justify-between">
            <div>
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-1">Revenu du mois</div>
                <div class="text-3xl font-bold text-gray-800">{{ number_format($monthlyRevenue, 0, ',', ' ') }}</div>
            </div>
            <div class="p-3 bg-teal-50 rounded-lg text-teal-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
            </div>
        </div>

    </div>

    <!-- 2. PARTIE BASSE (Stats détaillées) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- RÉPARTITION CLIENTS -->
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100 flex flex-col justify-between h-full">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                Types de Clients
            </h3>

            <div class="space-y-6">

                <!-- Particuliers (User) -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-gray-700">Particuliers</span>
                            <span class="font-bold text-blue-600">{{ round($clientStats['particulier']) }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $clientStats['particulier'] }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Entreprises (Immeuble/Valise) -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-gray-700">Entreprises</span>
                            <span class="font-bold text-purple-600">{{ round($clientStats['entreprise']) }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-purple-600 h-2 rounded-full transition-all duration-1000" style="width: {{ $clientStats['entreprise'] }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Touristes (Avion/Monde) -->
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-500 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-grow">
                        <div class="flex justify-between items-center mb-1">
                            <span class="font-bold text-gray-700">Touristes</span>
                            <span class="font-bold text-orange-500">{{ round($clientStats['touriste']) }}%</span>
                        </div>
                        <div class="w-full bg-gray-100 rounded-full h-2">
                            <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $clientStats['touriste'] }}%"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TOP VÉHICULES -->
        <div class="bg-white p-6 rounded-2xl shadow-md border border-gray-100">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                </svg>
                Les Stars du Parc
            </h3>

            <div class="space-y-4">
                @forelse($topVehicles as $index => $stat)
                <div class="flex items-center gap-4 p-3 hover:bg-gray-50 rounded-xl transition border border-transparent hover:border-gray-100">
                    <!-- Rang -->
                    <div class="text-xl font-black text-gray-200">#{{ $index + 1 }}</div>

                    <!-- Image -->
                    <div class="w-12 h-12 bg-gray-200 rounded-lg overflow-hidden shrink-0">
                        @if($stat->vehicle && $stat->vehicle->image)
                        <img src="{{ asset('storage/'.$stat->vehicle->image) }}" class="w-full h-full object-cover">
                        @endif
                    </div>

                    <!-- Info -->
                    <div class="flex-grow">
                        <h4 class="font-bold text-gray-900 text-sm">{{ $stat->vehicle->brand ?? 'Inconnu' }} {{ $stat->vehicle->name ?? '' }}</h4>
                        <p class="text-xs text-gray-500">{{ $stat->vehicle->type ?? '' }}</p>
                    </div>

                    <!-- Score -->
                    <div class="text-right">
                        <span class="block font-black text-xl text-blue-600">{{ $stat->total }}</span>
                        <span class="text-[10px] text-gray-400 uppercase font-bold">Locations</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-10">Pas encore assez de données</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
