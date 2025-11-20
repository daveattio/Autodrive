<div class="container mx-auto px-4 py-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="md:flex">
            <!-- Colonne Gauche : La Photo -->
            <div class="md:w-1/2">
                @if($vehicle->image)
                <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->name }}" class="w-full h-full object-cover">
                @else
                <div class="h-96 bg-gray-200 flex items-center justify-center">Pas d'image</div>
                @endif
            </div>

            <!-- Colonne Droite : Infos & Réservation -->
            <div class="md:w-1/2 p-8">
                <div class="uppercase tracking-wide text-sm text-blue-600 font-bold">{{ $vehicle->brand }}</div>
                <h1 class="block mt-1 text-3xl leading-tight font-bold text-black">{{ $vehicle->name }}</h1>
                <p class="mt-2 text-gray-500">{{ $vehicle->description ?? 'Aucune description disponible.' }}</p>

                <div class="mt-4">
                    <span class="text-gray-600">Type :</span> <span class="font-semibold">{{ $vehicle->type }}</span><br>
                    <span class="text-gray-600">Transmission :</span> <span class="font-semibold">{{ $vehicle->transmission }}</span>
                </div>

                <div class="mt-6 mb-6">
                    <span class="text-3xl font-bold text-gray-900">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} FCFA</span>
                    <span class="text-gray-600">/ jour</span>
                </div>

                <hr class="border-gray-200 mb-6">

                <!-- Formulaire de Réservation -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-xl font-bold mb-4">Réserver ce véhicule</h3>

                    <form wire:submit.prevent="bookVehicle">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Date de début</label>
                                <!-- wire:model.live connecte le champ à la variable PHP en temps réel -->
                                <input type="date" wire:model.live="startDate" class="w-full border p-2 rounded">
                                @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Date de fin</label>
                                <input type="date" wire:model.live="endDate" class="w-full border p-2 rounded">
                                @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Affichage du prix total calculé -->
                        @if($totalPrice > 0)
                        <div class="mb-4 p-3 bg-blue-100 text-blue-800 rounded font-bold text-center">
                            Total estimé : {{ number_format($totalPrice, 0, ',', ' ') }} FCFA
                        </div>
                        @endif

                        @auth
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded transition">
                            Confirmer la réservation
                        </button>
                        @else
                        <a href="{{ route('login') }}" class="block text-center w-full bg-gray-500 text-white font-bold py-3 px-4 rounded">
                            Connectez-vous pour réserver
                        </a>
                        @endauth
                    </form>
                </div>
            </div>
        </div>
    </div>