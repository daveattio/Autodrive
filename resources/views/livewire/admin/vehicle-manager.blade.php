<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">{{ $isEditMode ? 'Modifier le véhicule' : 'Ajouter un nouveau véhicule' }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="saveVehicle">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <!-- Marque -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Marque</label>
                <input type="text" wire:model="brand" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Toyota">
                @error('brand') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Modèle (Nom) -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Modèle</label>
                <input type="text" wire:model="name" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Corolla">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Catégorie (Type) -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Catégorie</label>
                <select wire:model="type" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Choisir une catégorie...</option>
                    <option value="Economique">Economique</option>
                    <option value="Berline">Berline</option>
                    <option value="SUV / 4x4">SUV / 4x4</option>
                    <option value="Luxe">Luxe</option>
                    <option value="Utilitaire">Utilitaire</option>
                </select>
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Transmission -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Transmission</label>
                <select wire:model="transmission" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Choisir...</option>
                    <option value="Manuelle">Manuelle</option>
                    <option value="Automatique">Automatique</option>
                </select>
                @error('transmission') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Prix -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Prix / Jour (FCFA)</label>
                <input type="number" wire:model="daily_price" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('daily_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Photo -->
            <div>
                <label class="block font-bold text-sm text-gray-700">Photo</label>
                <input type="file" wire:model="image" class="w-full border-gray-300 rounded shadow-sm text-sm">
                @if ($image && !is_string($image))
                    <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 object-cover mt-2 rounded">
                @elseif($isEditMode && $oldImage)
                    <img src="{{ asset('storage/'.$oldImage) }}" class="w-20 h-20 object-cover mt-2 rounded">
                @endif
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Description (Prend toute la largeur) -->
            <div class="md:col-span-2">
                <label class="block font-bold text-sm text-gray-700">Description détaillée</label>
                <textarea wire:model="description" rows="3" class="w-full border-gray-300 rounded shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ex: Climatisation, GPS inclus, faible consommation..."></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

        </div>

        <div class="flex gap-2 mt-6">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-500 font-bold transition">
                {{ $isEditMode ? 'Mettre à jour' : 'Enregistrer' }}
            </button>

            @if($isEditMode)
                <button type="button" wire:click="cancelEdit" class="bg-gray-500 text-white px-6 py-2 rounded shadow hover:bg-gray-600 font-bold transition">
                    Annuler
                </button>
            @endif
        </div>
    </form>

    <!-- ... (Garde ton tableau <table> existant en dessous pour la liste) ... -->
    <hr class="my-8">

    <!-- Je te remets le début du tableau pour être sûr que tu affiches bien les infos -->
    <h3 class="font-bold text-lg mb-4">Liste des véhicules</h3>
    <table class="w-full border bg-white shadow-sm rounded overflow-hidden">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3 text-left">Info</th>
                <th class="p-3 text-left">Catégorie</th>
                <th class="p-3 text-left">Prix</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vehicles as $vehicle)
                <tr class="border-t hover:bg-gray-50">
                    <td class="p-3">
                        <div class="font-bold">{{ $vehicle->brand }} {{ $vehicle->name }}</div>
                        <div class="text-xs text-gray-500">{{ $vehicle->transmission }}</div>
                    </td>
                    <td class="p-3">{{ $vehicle->type }}</td>
                    <td class="p-3 font-bold text-blue-600">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} FCFA</td>
                    <td class="p-3 text-center flex justify-center gap-2">
                         <button wire:click="editVehicle({{ $vehicle->id }})" class="mr-2 bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 text-sm font-bold shadow-md transition transform hover:scale-105">Modifier</button>
                         <button wire:click="deleteVehicle({{ $vehicle->id }})" wire:confirm="Supprimer ?" class="mr-2 bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 text-sm font-bold shadow-md transition transform hover:scale-105">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
