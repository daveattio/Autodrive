<div class="space-y-8">

    <!-- 1. FORMULAIRE D'AJOUT / MODIFICATION (Design Clean) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                {{ $isEditMode ? 'Modifier la promotion' : 'Créer une nouvelle offre' }}
            </h2>
            @if($isEditMode)
                <button wire:click="cancelEdit" class="text-sm text-red-500 hover:underline">Annuler l'édition</button>
            @endif
        </div>

        <div class="p-6">
            @if (session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded text-sm">{{ session('message') }}</div>
            @endif

            <form wire:submit.prevent="savePromo" class="space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Colonne Gauche -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Titre de l'offre</label>
                            <input type="text" wire:model="title" placeholder="Ex: Soldes d'Hiver" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Réduction (%)</label>
                                <div class="relative">
                                    <input type="number" wire:model="discount_percent" class="w-full pl-8 border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <span class="absolute left-3 top-2 text-gray-400 font-bold">-</span>
                                </div>
                                @error('discount_percent') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Véhicule Cible</label>
                                <select wire:model="vehicle_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    <option value="">-- Toute la flotte --</option>
                                    @foreach($vehicles_list as $v)
                                        <option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Début</label>
                                <input type="date" wire:model="start_date" class="w-full border-gray-300 rounded-lg text-sm shadow-sm">
                                @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Fin</label>
                                <input type="date" wire:model="end_date" class="w-full border-gray-300 rounded-lg text-sm shadow-sm">
                                @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Colonne Droite (Image & Description) -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Image promotionnelle</label>
                            <div class="flex items-center gap-4">
                                <div class="flex-grow">
                                    <input type="file" wire:model="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 border border-gray-300 rounded-lg p-1">
                                </div>
                                @if ($image && !is_string($image))
                                    <img src="{{ $image->temporaryUrl() }}" class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                                @elseif($isEditMode && $oldImage)
                                    <img src="{{ asset('storage/'.$oldImage) }}" class="h-16 w-16 object-cover rounded-lg border border-gray-200">
                                @endif
                            </div>
                            @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Conditions de l'offre..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-bold shadow-md transition transform hover:scale-[1.02] flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ $isEditMode ? 'Mettre à jour' : 'Publier l\'offre' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. TABLEAU DES PROMOTIONS EN COURS -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Promotions actives</h3>
        </div>

        <table class="min-w-full divide-y divide-gray-100">
            <tbody class="divide-y divide-gray-100">
                @forelse($promotions as $promo)
                <tr class="hover:bg-gray-50 transition">
                    <!-- Image -->
                    <td class="px-6 py-4 whitespace-nowrap w-24">
                        @if($promo->image)
                            <img src="{{ asset('storage/' . $promo->image) }}" class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                        @else
                            <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 font-bold">%</div>
                        @endif
                    </td>

                    <!-- Infos -->
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-gray-900">{{ $promo->title }}</div>
                        <div class="text-xs text-gray-500">
                            {{ \Carbon\Carbon::parse($promo->start_date)->format('d/m') }} au {{ \Carbon\Carbon::parse($promo->end_date)->format('d/m/Y') }}
                        </div>
                    </td>

                    <!-- Réduction -->
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold bg-red-100 text-red-600">
                            -{{ $promo->discount_percent }}%
                        </span>
                    </td>

                    <!-- Véhicule Cible -->
                    <td class="px-6 py-4">
                        @if($promo->vehicle)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $promo->vehicle->brand }} {{ $promo->vehicle->name }}
                            </span>
                        @else
                            <span class="text-xs text-gray-400 italic">Toute la boutique</span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="px-6 py-4 text-right text-sm font-medium">
                        <div class="flex justify-end gap-3">
                            <button wire:click="editPromo({{ $promo->id }})" class="text-blue-600 hover:text-blue-900 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                Éditer
                            </button>
                            <button wire:click="deletePromo({{ $promo->id }})" wire:confirm="Supprimer cette offre ?" class="text-red-600 hover:text-red-900 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                Suppr.
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        Aucune promotion active. Créez-en une ci-dessus !
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
