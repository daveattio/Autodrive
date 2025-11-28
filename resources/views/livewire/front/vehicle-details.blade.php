<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-7xl">

        <!-- EN-TÊTE : NAVIGATION & PRIX (Nouveau Style "Encoche") -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">

            <!-- Bouton Retour & Titre -->
            <div>
                <!-- BOUTON RETOUR : Encoche bleue à gauche + Animation -->
                <a href="{{ route('vehicles.index') }}" class="inline-flex items-center gap-2 bg-white px-5 py-2.5 rounded-r-lg border-l-4 border-blue-600 shadow-sm text-sm font-bold text-gray-700 hover:shadow-md hover:pl-6 transition-all duration-300 mb-5 group">
                    <svg class="w-4 h-4 text-blue-600 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Retour au catalogue
                </a>

                <h1 class="text-4xl md:text-6xl font-black text-gray-900 tracking-tighter leading-none">
                    {{ $vehicle->brand }} <span class="text-blue-700">{{ $vehicle->name }}</span>
                </h1>

                <div class="flex items-center gap-3 mt-4">
                    <!-- Badges avec style technique -->
                    <span class="bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-sm uppercase tracking-widest border-l-2 border-gray-500">
                        {{ $vehicle->type }}
                    </span>
                    @if($vehicle->is_available)
                    <span class="flex items-center gap-2 text-green-700 font-bold text-sm bg-green-50 px-3 py-1 rounded-sm border-l-2 border-green-500">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                        </span>
                        Disponible
                    </span>
                    @else
                    <span class="text-red-600 font-bold text-sm bg-red-50 px-3 py-1 rounded-sm border-l-2 border-red-500">Loué</span>
                    @endif
                </div>
            </div>

            <!-- Prix (Style Encoche Droite & Sombre) -->
            <div class="bg-gray-900 text-white p-5 rounded-l-xl rounded-br-xl shadow-2xl min-w-[240px] border-r-8 border-blue-500 relative overflow-hidden group">
                <!-- Petit effet de brillance en arrière plan -->
                <div class="absolute top-0 right-0 w-20 h-full bg-white/5 skew-x-12 -mr-10 transition group-hover:mr-0 duration-500"></div>

                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1 font-semibold">Tarif journalier</p>
                @if($activePromo)
                <!-- CAS : PROMO ACTIVE -->
                <div class="flex flex-col items-end">
                    <!-- Badge Rouge -->
                    <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded mb-1 animate-pulse">
                        PROMO -{{ $activePromo->discount_discount_percent }}%
                    </span>

                    <!-- Ancien prix barré -->
                    <span class="text-gray-500 line-through text-sm decoration-red-500">
                        {{ number_format($vehicle->daily_price, 0, ',', ' ') }}
                    </span>

                    <!-- Nouveau Prix -->
                    <div class="text-4xl font-black text-blue-400 flex items-baseline justify-end gap-1">
                        @php
                        $newPrice = $vehicle->daily_price * (1 - $activePromo->discount_percent / 100);
                        @endphp
                        {{ number_format($newPrice, 0, ',', ' ') }}
                        <span class="text-sm font-medium text-gray-500">FCFA</span>
                    </div>
                </div>
                @else
                <!-- CAS : PRIX NORMAL -->
                <div class="text-4xl font-black flex items-baseline justify-end gap-1">
                    {{ number_format($vehicle->daily_price, 0, ',', ' ') }}
                    <span class="text-sm font-medium text-gray-500">FCFA</span>
                </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- COLONNE GAUCHE : IMAGE & SPECS (65%) -->
            <div class="lg:w-2/3 space-y-8">

                <!-- 1. LA PHOTO (Cadre réduit et affiné) -->
                <!-- J'ai mis p-1 au lieu de p-2 et réduit les arrondis pour que ça fasse moins "gros" -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 p-1">
                    <div class="relative w-full rounded-[1.3rem] overflow-hidden bg-gray-100 group">
                        @if($vehicle->image)
                        <!-- Effet zoom conservé -->
                        <img src="{{ asset('storage/' . $vehicle->image) }}"
                            class="w-full h-auto object-cover hover:scale-110 transition duration-[800ms] ease-in-out transform"
                            alt="{{ $vehicle->name }}">

                        <!-- Petit gradient en bas pour le style -->
                        <div class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-black/30 to-transparent opacity-0 group-hover:opacity-100 transition duration-500"></div>
                        @else
                        <div class="aspect-video flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24 opacity-20" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- 2. FICHE TECHNIQUE (JE N'AI PAS TOUCHÉ, COMME DEMANDÉ) -->
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                        Performances & Détails
                    </h3>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 border border-blue-100 p-4 rounded-2xl hover:-translate-y-2 hover:shadow-lg hover:shadow-blue-100 transition duration-300 cursor-default group">
                            <div class="w-10 h-10 bg-blue-200 text-blue-700 rounded-full flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-blue-400 font-bold uppercase tracking-wider">Boîte</p>
                            <p class="font-black text-gray-800 text-lg">{{ $vehicle->transmission }}</p>
                        </div>
                        <div class="bg-violet-50 border border-violet-100 p-4 rounded-2xl hover:-translate-y-2 hover:shadow-lg hover:shadow-violet-100 transition duration-300 cursor-default group">
                            <div class="w-10 h-10 bg-violet-200 text-violet-700 rounded-full flex items-center justify-center mb-3 group-hover:bg-violet-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-violet-400 font-bold uppercase tracking-wider">Type</p>
                            <p class="font-black text-gray-800 text-lg">{{ $vehicle->type }}</p>
                        </div>
                        <div class="bg-emerald-50 border border-emerald-100 p-4 rounded-2xl hover:-translate-y-2 hover:shadow-lg hover:shadow-emerald-100 transition duration-300 cursor-default group">
                            <div class="w-10 h-10 bg-emerald-200 text-emerald-700 rounded-full flex items-center justify-center mb-3 group-hover:bg-emerald-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-emerald-400 font-bold uppercase tracking-wider">État</p>
                            <p class="font-black text-gray-800 text-lg">Excellent</p>
                        </div>
                        <div class="bg-orange-50 border border-orange-100 p-4 rounded-2xl hover:-translate-y-2 hover:shadow-lg hover:shadow-orange-100 transition duration-300 cursor-default group">
                            <div class="w-10 h-10 bg-orange-200 text-orange-700 rounded-full flex items-center justify-center mb-3 group-hover:bg-orange-600 group-hover:text-white transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <p class="text-xs text-orange-400 font-bold uppercase tracking-wider">Assurance</p>
                            <p class="font-black text-gray-800 text-lg">Tous risques</p>
                        </div>
                    </div>
                </div>

                <!-- 3. DESCRIPTION -->
                <div class="bg-white rounded-2xl shadow-sm border-l-4 border-gray-900 p-8 relative">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">Description du véhicule</h3>
                    <div class="prose text-gray-600 leading-relaxed font-light text-lg">
                        {{ $vehicle->description ?? "Aucune description détaillée n'est disponible pour ce véhicule." }}
                    </div>
                </div>

            </div>

            <!-- COLONNE DROITE : FORMULAIRE SOMBRE AMÉLIORÉ -->
            <div class="lg:w-1/3">
                <div class="sticky top-24">

                    <!-- Ajout d'une bordure supérieure colorée (L'encoche dont tu parlais) -->
                    <div class="bg-slate-900 rounded-[1.5rem] shadow-2xl border-t-4 border-blue-500 overflow-hidden relative">

                        <div class="p-8 relative z-10">
                            <div class="mb-8 flex items-center justify-between">
                                <div>
                                    <h3 class="text-2xl font-white text-white font-bold">Réservation</h3>
                                    <p class="text-slate-400 text-xs mt-1">Annulation gratuite 48h</p>
                                </div>
                                <div class="w-10 h-10 bg-slate-800 rounded-lg flex items-center justify-center text-blue-500">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <!-- Bloc d'information Disponibilité -->
                            @php
                            // On récupère les dates occupées pour ce véhicule

                            $busyDates = \App\Models\Booking::where('vehicle_id', $vehicle->id)
                            ->where('status', '!=', 'annulée')
                            ->whereDate('end_date', '>=', now()) // Seulement le futur
                            ->orderBy('start_date')
                            ->get();
                            @endphp

                            @if($busyDates->count() > 0)
                            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md mb-6">
                                <h4 class="text-red-700 font-bold text-sm mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Véhicule indisponible aux dates suivantes :
                                </h4>
                                <ul class="text-xs text-red-600 space-y-1 ml-1">
                                    @foreach($busyDates as $busy)
                                    <li>
                                        • Du <strong>{{ \Carbon\Carbon::parse($busy->start_date)->format('d/m') }}</strong>
                                        au <strong>{{ \Carbon\Carbon::parse($busy->end_date)->format('d/m/Y') }}</strong>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @else
                            <div class="bg-green-50 border-l-4 border-green-500 p-3 rounded-md mb-6 text-green-700 text-sm flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Ce véhicule est entièrement disponible !
                            </div>
                            @endif
                            <form wire:submit.prevent="bookVehicle" class="space-y-6">

                                <div class="space-y-4">
                                    <!-- Champ Date Début (Avec bordure focus colorée) -->
                                    <div class="group">
                                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Date de départ</label>
                                        <div class="relative">
                                            <input type="date" wire:model.live="startDate"
                                                class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg focus:ring-0 focus:border-blue-500 focus:border-l-4 transition-all py-3 pl-4">
                                        </div>
                                        @error('startDate') <span class="text-red-400 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Champ Date Fin -->
                                    <div class="group">
                                        <label class="block text-xs font-bold text-slate-400 uppercase mb-2 ml-1">Date de retour</label>
                                        <div class="relative">
                                            <input type="date" wire:model.live="endDate"
                                                class="w-full bg-slate-800 border border-slate-700 text-white rounded-lg focus:ring-0 focus:border-blue-500 focus:border-l-4 transition-all py-3 pl-4">
                                        </div>
                                        @error('endDate') <span class="text-red-400 text-xs mt-1 block ml-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Ticket de Prix Intelligent -->
                                @if($totalPrice > 0)
                                <div class="bg-slate-800/50 rounded-lg p-5 border-l-4 border-blue-500 mt-6 backdrop-blur-sm">

                                    <!-- Détail jours -->
                                    <div class="flex justify-between items-center text-slate-400 text-sm mb-2">
                                        <span class="flex items-center gap-2">
                                            {{ \Carbon\Carbon::parse($startDate)->diffInDays(\Carbon\Carbon::parse($endDate)) + 1 }} jours
                                        </span>
                                        <span>x {{ number_format($vehicle->daily_price, 0, ',', ' ') }}</span>
                                    </div>

                                    <!-- SI PROMO ACTIVE : On affiche le détail -->
                                    @if($activePromo)
                                    <div class="flex justify-between items-center text-green-400 text-sm mb-2 font-bold animate-pulse">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                            </svg>
                                            <!-- CORRECTION ICI : discount_percent -->
                                            Promo : -{{ $activePromo->discount_percent }}%
                                        </span>
                                        <span class="text-xs bg-green-900/50 px-2 py-1 rounded">{{ $activePromo->title }}</span>
                                    </div>

                                    <div class="border-b border-dashed border-slate-600 my-2"></div>

                                    <!-- Prix Barré -->
                                    <div class="text-right flex flex-col">
                                        <span class="text-slate-500 text-xs">Prix normal</span>
                                        <span class="text-slate-400 line-through text-sm">{{ number_format($originalPrice, 0, ',', ' ') }} FCFA</span>
                                    </div>
                                    @else
                                    <div class="border-b border-dashed border-slate-600 my-3"></div>
                                    @endif

                                    <!-- Total Final -->
                                    <div class="flex justify-between items-end mt-2 pt-2 border-t border-slate-700">
                                        <span class="text-slate-300 font-bold uppercase text-xs tracking-widest">Total à payer</span>
                                        <span class="font-black text-3xl text-white">
                                            {{ number_format($totalPrice, 0, ',', ' ') }}
                                            <span class="text-sm font-normal text-blue-400">FCFA</span>
                                        </span>
                                    </div>
                                </div>
                                @endif

                                <!-- Bouton d'action (Effet bouton 3D / Encoche bas) -->
                                @auth
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-lg border-b-4 border-blue-800 active:border-b-0 active:translate-y-1 transition-all flex justify-center items-center gap-2 mt-4">
                                    <span>Confirmer la réservation</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="block w-full bg-slate-800 border-b-4 border-slate-950 text-slate-300 font-bold py-4 rounded-lg text-center hover:bg-slate-700 hover:text-white active:border-b-0 active:translate-y-1 transition mt-4">
                                    Se connecter pour réserver
                                </a>
                                @endauth

                            </form>
                        </div>
                    </div>

                    <!-- Garantie -->
                    <div class="mt-6 text-center">
                        <p class="text-gray-400 text-xs flex items-center justify-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                            Paiement sécurisé & instantané
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
