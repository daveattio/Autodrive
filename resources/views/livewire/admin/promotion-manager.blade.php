<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">{{ $isEditMode ? 'Modifier la promotion' : 'Ajouter une promotion' }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="savePromo" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <!-- Titre -->
        <div>
            <label class="block font-bold text-sm">Titre</label>
            <input type="text" wire:model="title" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Pourcentage (Nommé 'discount_percent' pour correspondre à la BDD) -->
        <div>
            <label class="block font-bold text-sm">% Réduction</label>
            <input type="number" wire:model="discount_percent" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
            @error('discount_percent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Véhicule Concerné -->
        <div>
            <label class="block font-bold text-sm">Véhicule concerné</label>
            <select wire:model="vehicle_id" class="w-full border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="">-- Aucun (Promo générale) --</option>
                @foreach($vehicles_list as $v)
                    <option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Date Début -->
        <div>
            <label class="block font-bold text-sm">Date Début</label>
            <input type="date" wire:model="start_date" class="w-full border-gray-300 rounded">
            @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Date Fin -->
        <div>
            <label class="block font-bold text-sm">Date Fin</label>
            <input type="date" wire:model="end_date" class="w-full border-gray-300 rounded">
            @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Image avec Aperçu -->
        <div class="md:col-span-2">
            <label class="block font-bold text-sm">Image Promo</label>
            <input type="file" wire:model="image" class="w-full border border-gray-300 rounded p-2">

            <div class="mt-2">
                @if ($image && !is_string($image))
                    <p class="text-xs text-gray-500">Nouvelle image :</p>
                    <img src="{{ $image->temporaryUrl() }}" class="h-24 w-auto rounded shadow object-cover">
                @elseif($isEditMode && $oldImage)
                    <p class="text-xs text-gray-500">Image actuelle :</p>
                    <img src="{{ asset('storage/'.$oldImage) }}" class="h-24 w-auto rounded shadow object-cover">
                @endif
            </div>
            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="md:col-span-2">
            <label class="block font-bold text-sm">Description</label>
            <textarea wire:model="description" class="w-full border-gray-300 rounded" rows="3"></textarea>
        </div>

        <!-- Boutons -->
        <div class="md:col-span-2 flex gap-2 mt-2">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition font-bold">
                {{ $isEditMode ? 'Mettre à jour' : 'Ajouter la promotion' }}
            </button>
            @if($isEditMode)
                <button type="button" wire:click="cancelEdit" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600 transition font-bold">
                    Annuler
                </button>
            @endif
        </div>
    </form>

    <hr class="my-8 border-gray-200">

    <!-- Tableau -->
    <h3 class="font-bold text-lg mb-4 text-gray-700">Promotions en cours</h3>
    <table class="w-full border text-sm rounded-lg overflow-hidden">
        <thead class="bg-gray-100 text-gray-700">
            <tr>
                <th class="p-3 text-left">Titre</th>
                <th class="p-3 text-left">Réduction</th>
                <th class="p-3 text-left">Véhicule Lié</th>
                <th class="p-3 text-left">Période</th>
                <th class="p-3 text-center">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @foreach($promotions as $promo)
            <tr class="hover:bg-gray-50">
                <td class="p-3 font-medium">{{ $promo->title }}</td>
                <td class="p-3 font-bold text-green-600">-{{ $promo->discount_percent }}%</td>
                <td class="p-3">
                    @if($promo->vehicle)
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full font-bold">
                            {{ $promo->vehicle->brand }} {{ $promo->vehicle->name }}
                        </span>
                    @else
                        <span class="text-gray-400 italic">Générale</span>
                    @endif
                </td>
                <td class="p-3 text-gray-600">
                    {{ \Carbon\Carbon::parse($promo->start_date)->format('d/m') }} au {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}
                </td>
                <td class="p-3 text-center flex justify-center gap-3">
                    <button wire:click="editPromo({{ $promo->id }})" class="text-blue-600 hover:text-blue-800 font-medium">Modifier</button>
                    <button wire:click="deletePromo({{ $promo->id }})" wire:confirm="Sûr de vouloir supprimer ?" class="text-red-600 hover:text-red-800 font-medium">Supprimer</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($promotions->isEmpty())
        <div class="text-center text-gray-500 py-4 italic">Aucune promotion créée.</div>
    @endif
</div>
