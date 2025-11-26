<div class="bg-gray-50 min-h-screen pb-20">

    <!-- 1. HEADER IMMERSIF (Image + Titre superposé) -->
    <div class="relative w-full h-[60vh] bg-gray-900 overflow-hidden">
        @if($vehicle->image)
            <img src="{{ asset('storage/' . $vehicle->image) }}" class="w-full h-full object-cover opacity-90">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-800 text-gray-500">
                <svg class="w-32 h-32 opacity-20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif

        <!-- Dégradé pour lisibilité -->
        <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>

        <!-- Titre Flottant en bas de l'image -->
        <div class="absolute bottom-0 left-0 w-full p-6 md:p-12 z-10">
            <div class="container mx-auto">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="text-white">
                        <div class="inline-block bg-blue-600 text-white text-xs font-bold px-3 py-1 rounded-full mb-3 uppercase tracking-wider shadow-lg">
                            {{ $vehicle->type }}
                        </div>
                        <h1 class="text-4xl md:text-6xl font-black tracking-tight mb-2 leading-tight">
                            {{ $vehicle->brand }} <span class="text-gray-300 font-light">{{ $vehicle->name }}</span>
                        </h1>
                        <p class="text-gray-300 text-lg flex items-center gap-2">
                            @if($vehicle->is_available)
                                <span class="w-3 h-3 bg-green-500 rounded-full shadow-[0_0_10px_rgba(34,197,94,0.8)]"></span> Disponible immédiatement
                            @else
                                <span class="w-3 h-3 bg-red-500 rounded-full"></span> Actuellement loué
                            @endif
                        </p>
                    </div>
                    <!-- Prix en gros sur l'image -->
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-2xl text-white min-w-[200px] text-center">
                        <p class="text-xs text-gray-300 uppercase tracking-widest mb-1">Tarif journalier</p>
                        <p class="text-3xl font-bold">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-sm font-normal">FCFA</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 -mt-8 relative z-20">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- 2. COLONNE GAUCHE : SPECS & DESCRIPTION (Design épuré) -->
            <div class="lg:w-2/3">
                <!-- Tuiles de Spécifications -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition duration-300">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        </div>
                        <span class="text-xs text-gray-400 uppercase">Boîte</span>
                        <span class="font-bold text-gray-800">{{ $vehicle->transmission }}</span>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition duration-300">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="text-xs text-gray-400 uppercase">Catégorie</span>
                        <span class="font-bold text-gray-800">{{ $vehicle->type }}</span>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition duration-300">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-xs text-gray-400 uppercase">État</span>
                        <span class="font-bold text-gray-800">Excellent</span>
                    </div>

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center justify-center text-center hover:-translate-y-1 transition duration-300">
                        <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center mb-2 text-gray-600">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <span class="text-xs text-gray-400 uppercase">Assurance</span>
                        <span class="font-bold text-gray-800">Incluse</span>
                    </div>
                </div>

                <!-- Texte Description Stylisé -->
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-2 h-full bg-blue-600"></div> <!-- Barre latérale décorative -->
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 font-serif italic">"L'expérience de conduite..."</h3>
                    <div class="prose text-gray-600 leading-loose text-lg">
                        {{ $vehicle->description ?? "Découvrez le confort absolu de ce véhicule. Parfaitement entretenu et prêt à vous emmener partout où vous le souhaitez. Une expérience de conduite fluide et sécurisée vous attend." }}
                    </div>
                </div>
            </div>

            <!-- 3. COLONNE DROITE : LE "BLACK PANEL" DE RÉSERVATION -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">
                    <!-- Design sombre pour le contraste -->
                    <div class="bg-gray-900 text-white rounded-3xl shadow-2xl p-8 relative overflow-hidden">
                        <!-- Effet de cercle décoratif en fond -->
                        <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-600 rounded-full blur-3xl opacity-20"></div>

                        <h3 class="text-2xl font-bold mb-1 relative z-10">Planifier votre trajet</h3>
                        <p class="text-gray-400 text-sm mb-6 relative z-10">Réservez en 3 clics.</p>

                        <form wire:submit.prevent="bookVehicle" class="space-y-5 relative z-10">

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-xs text-gray-400 uppercase font-bold tracking-wider ml-1">Départ</label>
                                    <div class="relative mt-1">
                                        <input type="date" wire:model.live="startDate" class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">
                                    </div>
                                    @error('startDate') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="text-xs text-gray-400 uppercase font-bold tracking-wider ml-1">Retour</label>
                                    <div class="relative mt-1">
                                        <input type="date" wire:model.live="endDate" class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-blue-500 focus:border-blue-500 py-3 px-4">
                                    </div>
                                    @error('endDate') <span class="text-red-400 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <!-- Ticket de prix dynamique -->
                            @if($totalPrice > 0)
                                <div class="bg-gray-800/50 rounded-xl p-4 border border-gray-700 mt-4 animate-pulse-once">
                                    <div class="flex justify-between items-center text-sm text-gray-400 mb-2">
                                        <span>Durée</span>
                                        <span>{{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} jours</span>
                                    </div>
                                    <div class="border-t border-gray-700 pt-3 flex justify-between items-end">
                                        <span class="text-gray-300">Total à payer</span>
                                        <span class="text-2xl font-bold text-blue-400">{{ number_format($totalPrice, 0, ',', ' ') }} <span class="text-sm">FCFA</span></span>
                                    </div>
                                </div>
                            @endif

                            @auth
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-4 rounded-xl shadow-lg transform transition hover:scale-[1.02] mt-4 flex justify-center items-center gap-2">
                                    <span>Confirmer la réservation</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="block w-full bg-gray-700 text-gray-300 font-bold py-4 rounded-xl text-center hover:bg-gray-600 transition mt-4">
                                    Connexion requise
                                </a>
                            @endauth
                        </form>
                    </div>

                    <!-- Carte Agence mini -->
                    <div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-bold uppercase">Agence de retrait</p>
                            <p class="font-bold text-gray-900">AutoDrive Lomé Centre</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
