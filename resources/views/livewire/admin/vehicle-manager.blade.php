<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">Ajouter un véhicule</h2>

    <!-- Message de succès -->
    @if (session()->has('message'))
    <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
        {{ session('message') }}
    </div>
    @endif

    <form wire:submit.prevent="saveVehicle">
        <div class="grid grid-cols-2 gap-4">
            <!-- Marque -->
            <div>
                <label class="block font-bold">Marque</label>
                <input type="text" wire:model="brand" class="w-full border p-2 rounded" placeholder="Ex: Toyota">
                @error('brand') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Modèle -->
            <div>
                <label class="block font-bold">Modèle (Nom)</label>
                <input type="text" wire:model="name" class="w-full border p-2 rounded" placeholder="Ex: Corolla">
                @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Prix -->
            <div>
                <label class="block font-bold">Prix / Jour</label>
                <input type="number" wire:model="daily_price" class="w-full border p-2 rounded">
                @error('daily_price') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Photo -->
            <div>
                <label class="block font-bold">Photo</label>
                <input type="file" wire:model="image" class="w-full border p-2 rounded">
            </div>
        </div>

        <div class="flex gap-2 mt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
                {{ $isEditMode ? 'Mettre à jour' : 'Ajouter le véhicule' }}
            </button>

            @if($isEditMode)
            <button type="button" wire:click="cancelEdit" class="bg-gray-500 text-white px-4 py-2 rounded">
                Annuler
            </button>
            @endif
        </div>
    </form>

    <hr class="my-8">

    <h3 class="text-lg font-bold">Véhicules en base de données :</h3>
    <ul>
        <table class="w-full mt-8 border">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">Véhicule</th>
                    <th class="p-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($vehicles as $vehicle)
                <tr class="border-t">
                    <td class="p-2">{{ $vehicle->brand }} - {{ $vehicle->name }} ({{ $vehicle->daily_price }} FCFA)</td>
                    <td class="p-2 flex gap-2 justify-center">
                        <button wire:click="editVehicle({{ $vehicle->id }})" class="bg-yellow-500 text-white px-2 py-1 rounded text-sm">Modifier</button>
                        <button wire:click="deleteVehicle({{ $vehicle->id }})" wire:confirm="Sûr de vouloir supprimer ?" class="bg-red-500 text-white px-2 py-1 rounded text-sm">Supprimer</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </ul>
</div>