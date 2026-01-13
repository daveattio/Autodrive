<div class="p-6 bg-gray-50 min-h-screen relative">

    <!-- EN-TÊTE -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Gestion de la Flotte</h2>
            <p class="text-sm text-gray-500 font-medium">Ajoutez et maintenez votre parc automobile.</p>
        </div>

        <!-- Recherche -->
        <div class="bg-white p-2 rounded-xl border border-gray-200 shadow-sm w-full md:w-64">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher marque, modèle..."
                       class="pl-9 w-full border-none text-sm focus:ring-0 bg-transparent font-bold text-slate-700 placeholder-gray-400">
                <svg class="w-4 h-4 text-gray-400 absolute left-2 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
        </div>
    </div>

    <!-- NOTIFICATION -->
    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r-lg shadow-sm font-bold flex items-center gap-3 animate-fade-in-down">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- GAUCHE : FORMULAIRE CRÉATION (Fixe) -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 sticky top-6">
                <h3 class="font-black text-slate-800 flex items-center gap-2 mb-6">
                    <div class="bg-slate-900 text-white w-8 h-8 rounded-lg flex items-center justify-center shadow-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    Nouveau Véhicule
                </h3>

                <form wire:submit.prevent="saveVehicle" class="space-y-4">

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Marque</label>
                            <input type="text" wire:model="brand" placeholder="Ex: Toyota" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm font-bold focus:ring-blue-500">
                            @error('brand') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Modèle</label>
                            <input type="text" wire:model="name" placeholder="Ex: Corolla" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm font-bold focus:ring-blue-500">
                            @error('name') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Catégorie</label>
                            <select wire:model="type" class="w-full bg-slate-50 border-slate-200 rounded-lg text-xs font-bold text-slate-600">
                                <option value="">-- Choisir --</option>
                                <option>Economique</option><option>Berline</option><option>SUV / 4x4</option><option>Luxe</option><option>Utilitaire</option>
                            </select>
                            @error('type') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Boîte</label>
                            <select wire:model="transmission" class="w-full bg-slate-50 border-slate-200 rounded-lg text-xs font-bold text-slate-600">
                                <option value="">-- Choisir --</option>
                                <option>Manuelle</option><option>Automatique</option>
                            </select>
                            @error('transmission') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Prix Journalier</label>
                        <div class="relative">
                            <input type="number" min="1" wire:model="daily_price" class="w-full bg-slate-50 border-slate-200 rounded-lg pl-3 pr-10 text-sm font-bold text-slate-800">
                            <span class="absolute right-3 top-2.5 text-xs text-slate-400 font-bold">FCFA</span>
                        </div>
                        @error('daily_price') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <!-- UPLOAD AVEC APERÇU -->
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Photo</label>
                        <input type="file" wire:model="image" id="upload{{ $iteration }}" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 transition border border-gray-200 rounded-lg"/>
                        @error('image') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror

                        <!-- Aperçu Création -->
                        @if ($image && !is_string($image))
                            <div class="mt-2 relative w-full h-32 rounded-lg overflow-hidden border border-gray-200">
                                <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-full">
                            </div>
                        @endif
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Description</label>
                        <textarea wire:model="description" rows="2" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm text-slate-600" placeholder="État, options..."></textarea>
                        @error('description') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-blue-600 transition transform active:scale-95 flex justify-center items-center gap-2">
                        <span wire:loading.remove>Ajouter au Parc</span>
                        <span wire:loading>Enregistrement...</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- DROITE : LISTE (Grid Cards) -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($vehicles as $vehicle)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex gap-4 hover:border-blue-300 hover:shadow-md transition group">

                        <!-- Image -->
                        <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 relative border border-gray-100">
                            @if($vehicle->image)
                                <img src="{{ asset('storage/'.$vehicle->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300"><svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg></div>
                            @endif
                            <!-- Badge Type -->
                            <span class="absolute top-0 right-0 bg-slate-900 text-white text-[9px] font-bold px-1.5 py-0.5 rounded-bl-lg">
                                {{ strtoupper(substr($vehicle->type, 0, 3)) }}
                            </span>
                        </div>

                        <div class="flex-grow flex flex-col justify-between py-1">
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm leading-tight">{{ $vehicle->brand }} {{ $vehicle->name }}</h4>
                                <div class="flex flex-wrap gap-2 mt-1">
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded border border-gray-200">{{ $vehicle->transmission }}</span>
                                    <span class="text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded border border-gray-200">{{ $vehicle->type }}</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-end">
                                <span class="font-black text-lg text-blue-600">{{ number_format($vehicle->daily_price, 0, ',', ' ') }} <span class="text-xs text-gray-400 font-medium">F</span></span>

                                <div class="flex gap-2">
                                    <button wire:click="editVehicle({{ $vehicle->id }})" class="p-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition shadow-sm" title="Modifier">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                    <button wire:click="deleteVehicle({{ $vehicle->id }})" wire:confirm="Supprimer ce véhicule ?" class="p-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition shadow-sm" title="Supprimer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $vehicles->links() }}</div>
        </div>

    </div>

    <!-- ================= MODALE ÉDITION ================= -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl animate-fade-in-up">

            <div class="bg-slate-900 p-4 flex justify-between items-center text-white border-b border-slate-800">
                <h3 class="font-bold flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Modifier Véhicule
                </h3>
                <button wire:click="closeModal" class="hover:text-red-400 transition"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>

            <div class="p-6">
                <form wire:submit.prevent="updateVehicle" class="space-y-4">

                    <!-- APERÇU IMAGE MODIFICATION (La clé du confort) -->
                    <div class="flex justify-center mb-4">
                        @if ($image && !is_string($image))
                            <!-- Nouvelle image choisie -->
                            <img src="{{ $image->temporaryUrl() }}" class="h-32 w-full object-cover rounded-xl border-2 border-blue-500 shadow-md">
                        @elseif ($oldImage)
                            <!-- Ancienne image -->
                            <img src="{{ asset('storage/'.$oldImage) }}" class="h-32 w-full object-cover rounded-xl border border-gray-200">
                        @else
                            <div class="h-32 w-full bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">Aucune image</div>
                        @endif
                    </div>

                    <!-- Champs Copiés -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Marque</label>
                            <input type="text" wire:model="brand" class="w-full border-gray-200 bg-slate-50 rounded-lg text-sm font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Modèle</label>
                            <input type="text" wire:model="name" class="w-full border-gray-200 bg-slate-50 rounded-lg text-sm font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Catégorie</label>
                            <select wire:model="type" class="w-full border-gray-200 bg-slate-50 rounded-lg text-xs font-bold">
                                <option>Economique</option><option>Berline</option><option>SUV / 4x4</option><option>Luxe</option><option>Utilitaire</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Boîte</label>
                            <select wire:model="transmission" class="w-full border-gray-200 bg-slate-50 rounded-lg text-xs font-bold">
                                <option>Manuelle</option><option>Automatique</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Prix / Jour</label>
                            <input type="number" wire:model="daily_price" class="w-full border-gray-200 bg-slate-50 rounded-lg font-bold">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-400 uppercase">Changer Photo</label>
                            <input type="file" wire:model="image" id="editUpload{{ $iteration }}" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-[10px] file:bg-slate-200 hover:file:bg-slate-300"/>
                        </div>
                    </div>

                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Description</label>
                        <textarea wire:model="description" rows="2" class="w-full border-gray-200 bg-slate-50 rounded-lg text-sm"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 shadow-lg mt-2">
                        <span wire:loading.remove>Enregistrer les modifications</span>
                        <span wire:loading>Mise à jour...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
