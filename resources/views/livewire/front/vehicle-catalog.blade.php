<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Nos Véhicules Disponibles</h2>

    <!-- Grille responsive : 1 colonne sur mobile, 3 sur ordi -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @foreach($vehicles as $vehicle)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                
                <!-- Image du véhicule -->
                <div class="h-48 bg-gray-200 w-full relative">
                    @if($vehicle->image)
                        <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500">
                            Pas d'image
                        </div>
                    @endif
                    
                    <!-- Badge Prix -->
                    <div class="absolute top-0 right-0 bg-blue-600 text-white px-3 py-1 rounded-bl-lg font-bold">
                        {{ number_format($vehicle->daily_price, 0, ',', ' ') }} FCFA / jour
                    </div>
                </div>

                <!-- Détails -->
                <div class="p-4">
                    <div class="text-sm text-blue-600 font-semibold">{{ $vehicle->brand }}</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $vehicle->name }}</h3>
                    
                    <div class="flex justify-between text-gray-600 text-sm mb-4">
                        <span>Transmission : {{ $vehicle->transmission }}</span>
                        <span>{{ $vehicle->type }}</span>
                    </div>

                    <!-- Bouton Réserver -->
                    <button class="w-full bg-gray-900 text-white py-2 rounded hover:bg-gray-700 transition">
                        Voir les détails
                    </button>
                </div>
            </div>
        @endforeach

    </div>
</div>