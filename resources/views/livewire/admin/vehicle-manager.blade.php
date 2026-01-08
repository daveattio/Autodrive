<div class="p-6 bg-gray-50 min-h-screen">

    <!-- TITRE & NOTIFS -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Gestion du Parc Automobile</h2>
        <p class="text-sm text-gray-500">Ajoutez, modifiez ou supprimez les véhicules de la flotte.</p>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- FORMULAIRE D'AJOUT / MODIFICATION -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 mb-10">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-700 uppercase tracking-wide text-xs">
                {{ $isEditMode ? 'Modifier la fiche véhicule' : 'Nouveau Véhicule' }}
            </h3>
        </div>

        <form wire:submit.prevent="saveVehicle" class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Marque & Modèle -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Marque</label>
                <input type="text" wire:model="brand" placeholder="Ex: Toyota" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @error('brand') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Modèle</label>
                <input type="text" wire:model="name" placeholder="Ex: Rav4" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Specs -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Catégorie</label>
                <select wire:model="type" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Choisir --</option>
                    <option value="Economique">Economique</option>
                    <option value="Berline">Berline</option>
                    <option value="SUV / 4x4">SUV / 4x4</option>
                    <option value="Luxe">Luxe</option>
                    <option value="Utilitaire">Utilitaire</option>
                </select>
                @error('type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Transmission</label>
                <select wire:model="transmission" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Choisir --</option>
                    <option value="Manuelle">Manuelle</option>
                    <option value="Automatique">Automatique</option>
                </select>
                @error('transmission') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Prix & Photo -->
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Prix Journalier (FCFA)</label>
                <!-- min="1" empêche de taper des nombres négatifs dans le navigateur -->
                <input type="number" min="1" wire:model="daily_price" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                @error('daily_price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-4">
                <div class="flex-grow">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Photo du véhicule</label>
                    <input type="file" wire:model="image" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition"/>
                    @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <!-- Aperçu Image -->
                @if ($image && !is_string($image))
                    <img src="{{ $image->temporaryUrl() }}" class="h-12 w-12 rounded object-cover border border-gray-200">
                @elseif($isEditMode && $oldImage)
                    <img src="{{ asset('storage/'.$oldImage) }}" class="h-12 w-12 rounded object-cover border border-gray-200">
                @endif
            </div>

            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Description</label>
                <textarea wire:model="description" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" placeholder="Caractéristiques principales..."></textarea>
                @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Actions -->
            <div class="md:col-span-2 flex justify-end gap-3 pt-4 border-t border-gray-100">
                @if($isEditMode)
                    <button type="button" wire:click="cancelEdit" class="px-5 py-2.5 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-100 transition">Annuler</button>
                @endif
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition transform hover:scale-105 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ $isEditMode ? 'Mettre à jour' : 'Ajouter au parc' }}
                </button>
            </div>
        </form>
    </div>

    <!-- LISTE DES VÉHICULES (Style Promotion) -->
    <div class="space-y-4">
        <h3 class="font-bold text-gray-500 uppercase text-xs mb-4 pl-1">Véhicules Actifs ({{ $vehicles->count() }})</h3>

        @foreach($vehicles as $vehicle)
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex flex-col md:flex-row items-center justify-between gap-4 hover:shadow-md transition duration-300 group">

                <!-- Info Gauche : Image + Nom -->
                <div class="flex items-center gap-4 w-full md:w-1/2">
                    <div class="w-16 h-12 bg-gray-100 rounded-lg overflow-hidden border border-gray-100 flex-shrink-0 relative">
                        @if($vehicle->image)
                            <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover">
                        @else
                            <div class="flex items-center justify-center h-full text-gray-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>

                    <div>
                        <h4 class="font-bold text-gray-900 group-hover:text-blue-600 transition">{{ $vehicle->brand }} {{ $vehicle->name }}</h4>
                        <div class="flex gap-2 text-xs text-gray-500 mt-0.5">
                            <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $vehicle->type }}</span>
                            <span class="bg-gray-100 px-2 py-0.5 rounded">{{ $vehicle->transmission }}</span>
                        </div>
                    </div>
                </div>

                <!-- Info Centre : Prix -->
                <div class="text-right md:text-center w-full md:w-auto">
                    <span class="block font-black text-lg text-slate-800">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-xs font-normal text-gray-400">FCFA/j</span></span>
                </div>

                <!-- Info Droite : Actions -->
                <div class="flex items-center gap-3 w-full md:w-auto justify-end">
                    <button wire:click="editVehicle({{ $vehicle->id }})" class="flex items-center gap-1 text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Éditer
                    </button>

                    <button wire:click="deleteVehicle({{ $vehicle->id }})" wire:confirm="Retirer ce véhicule ?" class="flex items-center gap-1 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Suppr.
                    </button>
                </div>

            </div>
        @endforeach
    </div>
</div>
