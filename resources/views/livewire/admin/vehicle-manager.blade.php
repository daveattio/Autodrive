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

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">
            Enregistrer le véhicule
        </button>
    </form>

    <hr class="my-8">

    <h3 class="text-lg font-bold">Véhicules en base de données :</h3>
    <ul>
        @foreach($vehicles as $vehicle)
            <li class="border-b py-2">{{ $vehicle->brand }} {{ $vehicle->name }} - {{ $vehicle->daily_price }} FCFA</li>
        @endforeach
    </ul>
</div>