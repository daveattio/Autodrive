<div class="bg-gray-50 min-h-screen py-10">
    <div class="container mx-auto px-4 max-w-7xl">

        <!-- EN-TÊTE : NAVIGATION & PRIX -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">

            <!-- Bouton Retour & Titre -->
            <div>
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

            <!-- Prix (Style Encoche Droite) -->
            <div class="bg-gray-900 text-white p-5 rounded-l-xl rounded-br-xl shadow-2xl min-w-[240px] border-r-8 border-blue-500 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-20 h-full bg-white/5 skew-x-12 -mr-10 transition group-hover:mr-0 duration-500"></div>

                <p class="text-gray-400 text-xs uppercase tracking-widest mb-1 font-semibold">Tarif journalier</p>
                @if($activePromo)
                <div class="flex flex-col items-end">
                    <span class="bg-red-600 text-white text-[10px] font-bold px-2 py-0.5 rounded mb-1 animate-pulse">
                        PROMO -{{ $activePromo->discount_percent }}%
                    </span>
                    <span class="text-gray-500 line-through text-sm decoration-red-500">
                        {{ number_format($vehicle->daily_price, 0, ',', ' ') }}
                    </span>
                    <div class="text-4xl font-black text-blue-400 flex items-baseline justify-end gap-1">
                        @php $newPrice = $vehicle->daily_price * (1 - $activePromo->discount_percent / 100); @endphp
                        {{ number_format($newPrice, 0, ',', ' ') }}
                        <span class="text-sm font-medium text-gray-500">FCFA</span>
                    </div>
                </div>
                @else
                <div class="text-4xl font-black flex items-baseline justify-end gap-1">
                    {{ number_format($vehicle->daily_price, 0, ',', ' ') }}
                    <span class="text-sm font-medium text-gray-500">FCFA</span>
                </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- COLONNE GAUCHE : IMAGE & SPECS (66%) -->
            <div class="lg:w-2/3 space-y-8">

                <!-- 1. LA PHOTO -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200 p-1">
                    <div class="relative w-full rounded-[1.3rem] overflow-hidden bg-gray-100 group">
                        @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}"
                            class="w-full h-auto object-cover hover:scale-110 transition duration-[800ms] ease-in-out transform"
                            alt="{{ $vehicle->name }}">
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

            <!-- COLONNE DROITE : FORMULAIRE OPTIMISÉ (33%) -->
            <div class="lg:w-1/3">

                <!-- Style Scrollbar -->
                <style>
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 6px;
                    }

                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: #0f172a;
                    }

                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background-color: #334155;
                        border-radius: 20px;
                    }

                    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                        background-color: #475569;
                    }
                </style>

                <div class="sticky top-24">
                    <!-- Hauteur Max et Flexbox pour le scroll -->
                    <div class="bg-slate-900 rounded-[1.5rem] shadow-2xl border-t-4 border-blue-500 overflow-hidden relative flex flex-col max-h-[85vh]">

                        <!-- En-tête Fixe -->
                        <div class="p-6 pb-2 border-b border-slate-800 bg-slate-900 z-20 shrink-0">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-white text-white font-bold">Réservation</h3>
                                    <p class="text-slate-400 text-xs mt-1">Annulation gratuite 48h</p>
                                </div>
                                @if($activePromo)
                                <span class="bg-red-600 text-white text-xs font-bold px-2 py-1 rounded animate-pulse">-{{ $activePromo->discount_percent }}%</span>
                                @else
                                <div class="w-8 h-8 bg-slate-800 rounded-lg flex items-center justify-center text-blue-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- ZONE SCROLLABLE -->
                        <div class="p-6 pt-4 overflow-y-auto custom-scrollbar flex-grow">

                            <!-- Disponibilité -->
                            @php
                            $busyDates = \App\Models\Booking::where('vehicle_id', $vehicle->id)
                            ->where('status', '!=', 'annulée')
                            ->whereDate('end_date', '>=', now())
                            ->orderBy('start_date')
                            ->get();
                            @endphp

                            @if($busyDates->count() > 0)
                            <div class="bg-red-900/30 border border-red-500/50 p-3 rounded-lg mb-5">
                                <h4 class="text-red-400 font-bold text-xs mb-1 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Dates indisponibles :
                                </h4>
                                <div class="flex flex-wrap gap-1">
                                    @foreach($busyDates as $busy)
                                    <span class="text-[10px] bg-red-500/20 text-red-300 px-2 py-0.5 rounded border border-red-500/30">
                                        {{ \Carbon\Carbon::parse($busy->start_date)->format('d/m/Y') }}
                                        au
                                        {{ \Carbon\Carbon::parse($busy->end_date)->format('d/m/Y') }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <form wire:submit.prevent="bookVehicle" class="space-y-5">

                                <!-- 1. TYPE DE CLIENT (Avec Réinitialisation) -->
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Je suis</label>
                                    <div class="grid grid-cols-3 gap-1 bg-slate-800 p-1 rounded-lg">

                                        <button type="button" wire:click="setClientType('particulier')"
                                            class="py-1.5 text-xs font-bold rounded transition text-center {{ $client_type == 'particulier' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                                            Particulier
                                        </button>

                                        <button type="button" wire:click="setClientType('entreprise')"
                                            class="py-1.5 text-xs font-bold rounded transition text-center {{ $client_type == 'entreprise' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                                            Entreprise
                                        </button>

                                        <button type="button" wire:click="setClientType('touriste')"
                                            class="py-1.5 text-xs font-bold rounded transition text-center {{ $client_type == 'touriste' ? 'bg-blue-600 text-white shadow' : 'text-slate-400 hover:text-white hover:bg-slate-700' }}">
                                            Touriste
                                        </button>

                                    </div>
                                </div>

                                <!-- INFOS DYNAMIQUES -->
                                <div class="space-y-3 pb-2 border-b border-slate-800">
                                    <div class="grid grid-cols-2 gap-3">
                                        <input type="text" wire:model="phone" placeholder="Téléphone" class="bg-slate-800 border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-500">
                                        <input type="text" wire:model="city" placeholder="Ville" class="bg-slate-800 border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-500">
                                    </div>

                                    <input type="text" wire:model="address" placeholder="Adresse complète" class="w-full bg-slate-800 border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-500">

                                    <!-- ... (Tes champs téléphone et adresse restent ici) ... -->

                                    <!-- SI PARTICULIER -->
                                    @if($client_type == 'particulier')
                                    <div wire:key="fields-particulier">
                                        <input type="text" wire:model="license_number" placeholder="Numéro de Permis de conduire"
                                            class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 focus:ring-blue-500 focus:border-blue-500 placeholder-slate-500 transition-all">
                                        @error('license_number') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    @endif

                                    <!-- SI ENTREPRISE -->
                                    @if($client_type == 'entreprise')
                                    <div wire:key="fields-entreprise" class="grid grid-cols-2 gap-3">
                                        <div>
                                            <input type="text" wire:model="company_name" placeholder="Nom Société"
                                                class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 placeholder-slate-500">
                                            @error('company_name') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <input type="text" wire:model="company_id" placeholder="NIF / RCCM"
                                                class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 placeholder-slate-500">
                                            @error('company_id') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    @endif

                                    <!-- SI TOURISTE -->
                                    @if($client_type == 'touriste')
                                    <div wire:key="fields-touriste" class="space-y-3">
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <input type="text" wire:model="passport_number" placeholder="N° Passeport"
                                                    class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 placeholder-slate-500">
                                                @error('passport_number') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <input type="text" wire:model="origin_country" placeholder="Pays"
                                                    class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 placeholder-slate-500">
                                                @error('origin_country') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div>
                                            <input type="text" wire:model="license_number" placeholder="Permis International"
                                                class="w-full bg-slate-800 border border-slate-700 text-white text-xs rounded-lg py-2.5 px-3 placeholder-slate-500">
                                            @error('license_number') <span class="text-red-400 text-xs mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- DATES -->
                                <div class="space-y-3">
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="group">
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1 ml-1">Départ</label>
                                            <input type="date" wire:model.live="startDate" class="w-full bg-slate-800 border border-slate-700 text-white text-sm rounded-lg py-2 px-3 focus:border-blue-500">
                                            @error('startDate') <span class="text-red-400 text-[10px] block">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="group">
                                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1 ml-1">Retour</label>
                                            <input type="date" wire:model.live="endDate" class="w-full bg-slate-800 border border-slate-700 text-white text-sm rounded-lg py-2 px-3 focus:border-blue-500">
                                            @error('endDate') <span class="text-red-400 text-[10px] block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- TICKET PRIX -->
                                @if($totalPrice > 0)
                                <div class="bg-slate-800/80 rounded-lg p-4 border-l-4 border-blue-500 backdrop-blur-sm mt-4">
                                    <div class="flex justify-between items-end">
                                        <div class="flex justify-between items-end mt-2 pt-2 border-t border-slate-700">
                                        <span class="text-slate-300 font-bold uppercase text-xs tracking-widest">Total à payer</span>
                                        <span class="font-black text-3xl text-white">
                                            {{ number_format($totalPrice, 0, ',', ' ') }}
                                            <span class="text-sm font-normal text-blue-400">FCFA</span>
                                        </span>
                                    </div>

                                        @if($activePromo)
                                        <div class="text-right">
                                            <span class="text-[10px] text-slate-500 line-through block">{{ number_format($originalPrice, 0, ',', ' ') }}</span>
                                            <span class="text-xs text-green-400 font-bold">Promo -{{ $activePromo->discount_percent }}%</span>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endif

                                <!-- BOUTON -->
                                @auth
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-3.5 rounded-lg shadow-lg border-b-4 border-blue-800 active:border-b-0 active:translate-y-1 transition-all flex justify-center items-center gap-2 mt-4">
                                    <span>Confirmer la réservation</span>
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </button>
                                @else
                                <a href="{{ route('login') }}" class="block w-full bg-slate-800 border border-slate-700 text-slate-300 font-bold py-3 rounded-lg text-center hover:bg-slate-700 hover:text-white transition mt-4">
                                    Se connecter pour réserver
                                </a>
                                @endauth

                            </form>
                        </div>

                        <!-- Footer Fixe -->
                        <div class="bg-slate-950 p-3 text-center border-t border-slate-800 z-20 shrink-0">
                            <p class="text-slate-500 text-[10px] flex items-center justify-center gap-2">
                                <svg class="w-3 h-3 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Données chiffrées et sécurisées
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
