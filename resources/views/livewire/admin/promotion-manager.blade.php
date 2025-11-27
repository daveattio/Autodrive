<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-xl font-bold mb-4">{{ $isEditMode ? 'Modifier la promotion' : 'Ajouter une promotion' }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">{{ session('message') }}</div>
    @endif

    <form wire:submit.prevent="savePromo" class="grid grid-cols-1 md:grid-cols-2 gap-4">

        <div>
            <label class="block font-bold text-sm">Titre</label>
            <input type="text" wire:model="title" class="w-full border-gray-300 rounded">
            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-bold text-sm">% Réduction</label>
            <input type="number" wire:model="discount_percent" class="w-full border-gray-300 rounded">
            @error('discount_percent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block font-bold text-sm">Date Début</label>
            <input type="date" wire:model="start_date" class="w-full border-gray-300 rounded">
        </div>

        <div>
            <label class="block font-bold text-sm">Date Fin</label>
            <input type="date" wire:model="end_date" class="w-full border-gray-300 rounded">
        </div>

        <!-- IMAGE AVEC APERÇU -->
        <div class="md:col-span-2">
            <label class="block font-bold text-sm">Image Promo</label>
            <input type="file" wire:model="image" class="w-full border border-gray-300 rounded p-2">

            <div class="mt-2">
                @if ($image && !is_string($image))
                    <p class="text-xs text-gray-500">Nouvelle image :</p>
                    <img src="{{ $image->temporaryUrl() }}" class="h-24 w-auto rounded shadow">
                @elseif($isEditMode && $oldImage)
                    <p class="text-xs text-gray-500">Image actuelle :</p>
                    <img src="{{ asset('storage/'.$oldImage) }}" class="h-24 w-auto rounded shadow">
                @endif
            </div>
        </div>

        <div class="md:col-span-2">
            <label class="block font-bold text-sm">Description</label>
            <textarea wire:model="description" class="w-full border-gray-300 rounded"></textarea>
        </div>

        <div class="md:col-span-2 flex gap-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                {{ $isEditMode ? 'Mettre à jour' : 'Ajouter la promotion' }}
            </button>
            @if($isEditMode)
                <button type="button" wire:click="cancelEdit" class="bg-gray-500 text-white px-4 py-2 rounded">Annuler</button>
            @endif
        </div>
    </form>

    <hr class="my-8">

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 text-left">Titre</th>
                <th class="p-2 text-left">Réduction</th>
                <th class="p-2 text-left">Période</th>
                <th class="p-2 text-center">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promo)
                <tr class="border-t">
                    <td class="p-2">{{ $promo->title }}</td>
                    <td class="p-2 font-bold text-green-600">-{{ $promo->discount_percent }}%</td>
                    <td class="p-2">{{ $promo->start_date }} au {{ $promo->end_date }}</td>
                    <td class="p-2 text-center flex justify-center gap-2">
                        <button wire:click="editPromo({{ $promo->id }})" class="text-blue-600 hover:underline">Modifier</button>
                        <button wire:click="deletePromo({{ $promo->id }})" class="text-red-600 hover:underline">Supprimer</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
