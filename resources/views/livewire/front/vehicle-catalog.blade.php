<div class="container mx-auto px-4 py-8">
    
    <div class="flex flex-col md:flex-row gap-8">
        
        <!-- COLONNE DE GAUCHE : FILTRES -->
        <div class="md:w-1/4 bg-white p-6 rounded-lg shadow-md h-fit">
            <h3 class="font-bold text-xl mb-4 border-b pb-2">Filtrer</h3>
            
            <!-- Recherche -->
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Recherche</label>
                <input wire:model.live="search" type="text" placeholder="Marque, Modèle..." class="w-full border p-2 rounded">
            </div>

            <!-- Type -->
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Catégorie</label>
                <select wire:model.live="type" class="w-full border p-2 rounded">
                    <option value="">Toutes les catégories</option>
                    @foreach($types as $t)
                        <option value="{{ $t->type }}">{{ $t->type }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Prix Max -->
            <div class="mb-4">
                <label class="block text-sm font-bold mb-2">Budget Max / Jour</label>
                <input wire:model.live="maxPrice" type="range" min="5000" max="200000" step="5000" class="w-full">
                <div class="text-right font-bold text-blue-600">{{ number_format($maxPrice, 0, ',', ' ') }} FCFA</div>
            </div>
            
            <button wire:click="$set('search', '')" class="text-sm text-gray-500 underline">Réinitialiser les filtres</button>
        </div>

        <!-- COLONNE DE DROITE : GRILLE DES VOITURES -->
        <div class="md:w-3/4">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Nos Véhicules</h2>

            <!-- Grille -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="h-48 bg-gray-200 w-full relative">
                            @if($vehicle->image)
                                <img src="{{ asset('storage/' . $vehicle->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-500">Pas d'image</div>
                            @endif
                            <div class="absolute top-0 right-0 bg-blue-600 text-white px-3 py-1 rounded-bl-lg font-bold">
                                {{ number_format($vehicle->daily_price, 0, ',', ' ') }} FCFA
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="text-sm text-blue-600 font-semibold">{{ $vehicle->brand }}</div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $vehicle->name }}</h3>
                            <div class="flex justify-between text-gray-600 text-sm mb-4">
                                <span>{{ $vehicle->transmission }}</span>
                                <span>{{ $vehicle->type }}</span>
                            </div>
                            <a href="{{ route('vehicle.show', $vehicle->id) }}" class="block text-center w-full bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition">
                                Voir détails
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $vehicles->links() }}
            </div>
        </div>
    </div>
</div>