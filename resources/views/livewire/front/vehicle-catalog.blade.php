<div class="container mx-auto px-4 py-8 max-w-7xl">

    <!-- CHARGEMENT FLATPICKR (Si pas déjà dans le layout) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/dark.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- 1. BARRE DE FILTRES PRINCIPALE (Horizontale & Moderne) -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 mb-8 sticky top-20 z-30 transition-all duration-300">
        <div class="flex flex-col lg:flex-row gap-4 items-center">

            <!-- Recherche -->
            <div class="relative w-full lg:w-1/3">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher une marque, un modèle..."
                    class="w-full pl-10 pr-4 py-3 bg-gray-50 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition font-medium">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Sélecteur de Dates (Flatpickr avec wire:ignore) -->
            <!-- Sélecteur de Dates (ROBUSTE) -->
            <div class="w-full lg:w-1/3 flex gap-2" wire:ignore>

                <!-- DÉPART -->
                <div class="relative w-1/2"
                    x-data
                    x-init="
             flatpickr($refs.start, {
                 dateFormat: 'Y-m-d',
                 altInput: true, altFormat: 'j F Y',
                 minDate: 'today',
                 theme: 'dark',
                 onChange: function(selectedDates, dateStr) { @this.set('dateStart', dateStr); }
             });
         ">
                    <input x-ref="start" type="text" placeholder="Départ"
                        class="w-full pl-10 pr-3 py-3 bg-gray-50 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 font-medium cursor-pointer">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg></div>
                </div>

                <!-- RETOUR -->
                <div class="relative w-1/2"
                    x-data
                    x-init="
             flatpickr($refs.end, {
                 dateFormat: 'Y-m-d',
                 altInput: true, altFormat: 'j F Y',
                 minDate: 'today',
                 theme: 'dark',
                 onChange: function(selectedDates, dateStr) { @this.set('dateEnd', dateStr); }
             });
         ">
                    <input x-ref="end" type="text" placeholder="Retour"
                        class="w-full pl-10 pr-3 py-3 bg-gray-50 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 font-medium cursor-pointer">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none"><svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg></div>
                </div>
            </div>
            <!-- Boutons Actions -->
            <div class="w-full lg:w-1/3 flex gap-3">
                <button wire:click="toggleAdvancedFilters"
                    class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl font-bold transition border border-gray-200 hover:border-gray-300 {{ $showAdvancedFilters ? 'bg-slate-900 text-white' : 'bg-white text-gray-700' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                    </svg>
                    Filtres {{ $showAdvancedFilters ? '(-)' : '(+)' }}
                </button>

                @if($search || $type || $transmission || $maxPrice < 300000 || $dateStart || $dateEnd)
                    <button wire:click="resetFilters" class="px-4 py-3 text-red-500 hover:bg-red-50 rounded-xl font-bold transition" title="Tout effacer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    </button>
                    @endif
            </div>
        </div>

        <!-- 2. PANNEAU FILTRES AVANCÉS (Repliable) -->
        @if($showAdvancedFilters)
        <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-1 md:grid-cols-3 gap-6 animate-fade-in-down">

            <!-- Transmission (Toggle désélectionnable) -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Boîte de vitesse</label>
                <div class="flex gap-2">
                    <button wire:click="toggleTransmission('Manuelle')"
                        class="flex-1 py-2 px-3 rounded-lg text-sm font-bold border transition
                                {{ $transmission === 'Manuelle' ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-200' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                        Manuelle
                    </button>
                    <button wire:click="toggleTransmission('Automatique')"
                        class="flex-1 py-2 px-3 rounded-lg text-sm font-bold border transition
                                {{ $transmission === 'Automatique' ? 'bg-blue-600 text-white border-blue-600 ring-2 ring-blue-200' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                        Auto
                    </button>
                </div>
            </div>

            <!-- Catégorie -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Catégorie</label>
                <select wire:model.live="type" class="w-full py-2 px-3 bg-gray-50 border-gray-200 rounded-lg text-sm font-medium focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Toutes les catégories</option>
                    @foreach($types as $t)
                    <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Budget -->
            <div>
                <label class="text-xs font-bold text-gray-500 uppercase mb-2 flex justify-between">
                    <span>Budget Max</span>
                    <span class="text-blue-600">{{ number_format($maxPrice, 0, ',', ' ') }} FCFA</span>
                </label>
                <input wire:model.live="maxPrice" type="range" min="5000" max="300000" step="5000" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
            </div>
        </div>
        @endif
    </div>

    <!-- 3. RÉSULTATS (Titre + Compteur) -->
    <div class="mb-8">
        <h2 class="text-3xl font-black text-gray-900">
            @if($dateStart && $dateEnd)
            Véhicules disponibles <span class="text-blue-600 text-lg block md:inline md:ml-2 font-medium">du {{ \Carbon\Carbon::parse($dateStart)->format('d/m') }} au {{ \Carbon\Carbon::parse($dateEnd)->format('d/m') }}</span>
            @else
            Nos Véhicules
            @endif
        </h2>
        <div class="h-1 w-20 bg-blue-600 rounded-full mt-2"></div>
    </div>

    <!-- 4. GRILLE VÉHICULES (Large 3x3) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($vehicles as $vehicle)
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full group">

            <!-- Image -->
            <div class="h-60 bg-gray-100 w-full relative overflow-hidden">
                @if($vehicle->image)
                <img src="{{ asset('storage/' . $vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                @else
                <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif

                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm text-gray-900 px-3 py-1 rounded-full text-xs font-bold shadow-sm uppercase tracking-wider">
                    {{ $vehicle->type }}
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-6 flex flex-col flex-grow">
                <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">{{ $vehicle->brand }}</div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">{{ $vehicle->name }}</h3>

                <!-- Specs -->
                <div class="flex items-center gap-4 text-gray-500 text-sm mb-6 bg-gray-50 p-3 rounded-xl">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        <span class="font-bold">{{ $vehicle->transmission }}</span>
                    </div>
                    <div class="h-4 w-px bg-gray-300"></div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Dispo</span>
                    </div>
                </div>

                <div class="mt-auto flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-black text-slate-900">{{ number_format($vehicle->daily_price, 0, ',', ' ') }}</span>
                        <span class="text-xs text-gray-500 font-bold">FCFA / jour</span>
                    </div>

                    <!-- BOUTON AVEC LOGO -->
                    <!-- BOUTON AVEC LOGO GAUCHE & EFFET FLASH -->
                    <a href="{{ route('vehicle.show', $vehicle->id) }}"
                        class="group bg-slate-900 text-white px-5 py-3 rounded-xl font-bold text-sm hover:bg-blue-900 transition shadow-lg flex items-center gap-3 overflow-hidden relative">

                        <!-- Logo (Gauche, Sans bordure, Effet Flash Jaune/Or) -->
                        <svg class="w-4 h-4 text-blue-400 group-hover:text-yellow-400 group-hover:scale-125 transition duration-300 ease-out transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>

                        <!-- Texte -->
                        <span class="relative z-10">Réserver</span>

                        <!-- Petit effet de lumière qui passe au survol (Optionnel mais joli) -->
                        <div class="absolute inset-0 h-full w-full bg-white/10 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition duration-700 ease-in-out"></div>
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center">
            <div class="inline-block p-6 rounded-full bg-gray-100 mb-4">
                <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Aucun véhicule trouvé</h3>
            <p class="text-gray-500 mt-2">Essayez de modifier vos dates ou vos filtres.</p>
            <button wire:click="resetFilters" class="mt-6 text-blue-600 font-bold hover:underline">Voir toute la flotte</button>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-12">
        {{ $vehicles->links() }}
    </div>

</div>
