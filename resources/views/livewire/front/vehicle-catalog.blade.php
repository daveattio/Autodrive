<div class="container mx-auto px-4 py-8">

    <div class="flex flex-col lg:flex-row gap-8">

        <!-- COLONNE DE GAUCHE : FILTRES MODERNES -->
        <!-- "sticky top-24" permet au filtre de suivre le scroll -->
        <div class="lg:w-1/4 h-fit sticky top-24 z-10">
            <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-100">
                <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                    <h3 class="font-extrabold text-xl text-gray-800 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                        </svg>
                        Filtrer
                    </h3>

                    <!-- CONDITION CORRIGÉE : S'affiche si n'importe quel filtre est modifié -->
                    @if($search !== '' || $type !== '' || $transmission !== '' || $maxPrice < 300000)
                        <button wire:click="resetFilters"
                        class="bg-gray-100 hover:bg-red-100 text-gray-600 hover:text-red-600 px-3 py-1 rounded-full text-xs font-bold transition flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Effacer
                        </button>
                        @endif
                </div>

                <!-- 1. Recherche -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Recherche</label>
                    <div class="relative">
                        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Marque, Modèle..."
                            class="w-full pl-10 pr-4 py-3 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 transition shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- 2. Catégorie (Select stylisé) -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Catégorie</label>
                    <select wire:model.live="type" class="w-full py-3 px-4 border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500 shadow-sm cursor-pointer">
                        <option value="">Toutes les catégories</option>
                        @foreach($types as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- 3. Transmission (Boutons Radio Modernes) -->
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Transmission</label>
                    <div class="flex gap-2">
                        <button wire:click="$set('transmission', 'Manuelle')"
                            class="flex-1 py-2 px-3 rounded-lg text-sm font-bold border transition duration-200
                                {{ $transmission === 'Manuelle' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                            Manuelle
                        </button>
                        <button wire:click="$set('transmission', 'Automatique')"
                            class="flex-1 py-2 px-3 rounded-lg text-sm font-bold border transition duration-200
                                {{ $transmission === 'Automatique' ? 'bg-blue-600 text-white border-blue-600' : 'bg-gray-50 text-gray-600 border-gray-200 hover:bg-gray-100' }}">
                            Auto
                        </button>
                    </div>
                    <!-- Petit bouton pour désélectionner la transmission si besoin -->
                    @if($transmission)
                    <div wire:click="$set('transmission', '')" class="text-xs text-gray-400 mt-1 text-center cursor-pointer hover:text-blue-500">
                        Afficher tout
                    </div>
                    @endif
                </div>

                <!-- 4. Prix Max (Slider amélioré) -->
                <div class="mb-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2 flex justify-between">
                        <span>Budget Max</span>
                        <span class="text-blue-600">{{ number_format($maxPrice, 0, ',', ' ') }} FCFA</span>
                    </label>
                    <input wire:model.live="maxPrice" type="range" min="5000" max="300000" step="5000"
                        class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer accent-blue-600">
                    <div class="flex justify-between text-xs text-gray-400 mt-1">
                        <span>5 000</span>
                        <span>300 000+</span>
                    </div>
                </div>

            </div>
        </div>

        <!-- COLONNE DE DROITE : GRILLE DES VOITURES -->
        <div class="lg:w-3/4">
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-3xl font-extrabold text-gray-900">Nos Véhicules</h2>
                <span class="text-gray-500 text-sm font-medium">{{ $vehicles->total() }} résultat(s)</span>
            </div>

            <!-- Grille -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vehicles as $vehicle)
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full group">

                    <!-- Image avec Badge -->
                    <div class="h-52 bg-gray-100 w-full relative overflow-hidden">
                        @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                        <div class="flex items-center justify-center h-full text-gray-400 bg-gray-50">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif

                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm text-gray-800 px-3 py-1 rounded-full text-xs font-bold shadow-sm">
                            {{ $vehicle->type }}
                        </div>
                    </div>

                    <!-- Contenu -->
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">{{ $vehicle->brand }}</div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $vehicle->name }}</h3>

                        <!-- Caractéristiques (Icônes) -->
                        <div class="flex items-center gap-4 text-gray-500 text-sm mb-4">
                            <div class="flex items-center gap-1" title="Transmission">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                </svg>
                                {{ $vehicle->transmission }}
                            </div>
                            <!-- Tu pourras ajouter le nombre de places ici plus tard si tu l'ajoutes en base -->
                        </div>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-gray-900">{{ number_format($vehicle->daily_price, 0, ',', ' ') }}</span>
                                <span class="text-xs text-gray-500 font-medium">FCFA / jour</span>
                            </div>
                            <a href="{{ route('vehicle.show', $vehicle->id) }}" class="bg-gray-900 text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-blue-600 transition shadow-md">
                                Réserver
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-12">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Aucun véhicule trouvé</h3>
                    <p class="text-gray-500 mt-1">Essayez de modifier vos filtres.</p>
                    <button wire:click="$set('search', ''); $set('type', ''); $set('transmission', ''); $set('maxPrice', 300000)" class="mt-4 text-blue-600 font-bold hover:underline">
                        Tout effacer
                    </button>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>
