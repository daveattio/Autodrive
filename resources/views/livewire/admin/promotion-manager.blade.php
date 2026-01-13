<div class="p-6 bg-gray-50 min-h-screen relative">

    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Campagnes Marketing</h2>
            <p class="text-sm text-gray-500 font-medium">Créez des offres flash pour booster vos locations.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r shadow-sm font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- GAUCHE : FORMULAIRE -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 sticky top-6">
                <h3 class="font-black text-slate-800 flex items-center gap-2 mb-6">
                    <span class="bg-red-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </span>
                    Nouvelle Promo
                </h3>

                <form wire:submit.prevent="savePromo" class="space-y-4">

                    <input type="text" wire:model="title" placeholder="Titre de l'offre (ex: Soldes Hiver)" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm font-bold focus:ring-red-500">

                    <div class="grid grid-cols-2 gap-3">
                         <div class="relative">
                            <input type="number" wire:model="discount_percent" class="w-full bg-slate-50 border-slate-200 rounded-lg pl-3 pr-8 text-sm font-bold text-red-600" placeholder="Ex: 20">
                            <span class="absolute right-3 top-2.5 text-xs text-gray-400 font-bold">%</span>
                        </div>
                        <select wire:model.live="vehicle_id" class="w-full bg-slate-50 border-slate-200 rounded-lg text-xs font-bold text-slate-600">
                            <option value="">-- Cible (Optionnel) --</option>
                            @foreach($vehicles_list as $v)<option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>@endforeach
                        </select>
                    </div>

                    <!-- APERÇU INTELLIGENT -->
                    <!-- Si on choisit une image promo, on l'affiche. Sinon, si on choisit une voiture, on affiche sa photo -->
                    <div class="flex flex-col gap-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Visuel</label>
                        <input type="file" wire:model="image" id="promoImg{{ $iteration }}" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 transition"/>

                        @if ($image && !is_string($image))
                             <div class="mt-2 h-32 w-full rounded-lg overflow-hidden border border-red-200 relative"><img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover"></div>
                        @elseif($selectedVehicleImage)
                             <div class="mt-2 h-32 w-full rounded-lg overflow-hidden border border-slate-200 relative opacity-80" title="Image du véhicule sélectionné">
                                <img src="{{ asset('storage/'.$selectedVehicleImage) }}" class="w-full h-full object-cover">
                                <span class="absolute bottom-2 right-2 bg-black/50 text-white text-[9px] px-2 py-1 rounded">Image Véhicule</span>
                             </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3 bg-red-50 p-3 rounded-xl border border-red-100">
                        <div>
                            <label class="text-[9px] font-bold text-red-400 uppercase">DÉBUT</label>
                            <input type="date" wire:model="start_date" class="w-full border-none bg-white rounded text-xs font-bold text-slate-700">
                        </div>
                        <div>
                            <label class="text-[9px] font-bold text-red-400 uppercase">FIN</label>
                            <input type="date" wire:model="end_date" class="w-full border-none bg-white rounded text-xs font-bold text-slate-700">
                        </div>
                    </div>

                    <textarea wire:model="description" rows="2" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm" placeholder="Conditions..."></textarea>

                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-red-700 transition">Lancer la Campagne</button>
                </form>
            </div>
        </div>

        <!-- DROITE : LISTE (Grid Cards) -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                @foreach($promotions as $p)
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex gap-4 hover:border-red-200 transition group">

                        <!-- Image -->
                        <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 relative border border-gray-100">
                            @if($p->image)
                                <img src="{{ asset('storage/'.$p->image) }}" class="w-full h-full object-cover">
                            @elseif($p->vehicle && $p->vehicle->image)
                                <img src="{{ asset('storage/'.$p->vehicle->image) }}" class="w-full h-full object-cover opacity-80">
                            @else
                                <div class="flex items-center justify-center h-full bg-red-50 text-red-300 font-black text-xl">%</div>
                            @endif

                            <!-- Badge Réduction -->
                            <div class="absolute bottom-0 w-full bg-red-600 text-white text-center text-xs font-black py-1">
                                -{{ $p->discount_percent }}%
                            </div>
                        </div>

                        <div class="flex-grow flex flex-col justify-between py-1">
                            <div>
                                <h4 class="font-bold text-slate-900 leading-tight">{{ $p->title }}</h4>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($p->start_date)->format('d/m') }} <span class="text-slate-300">➜</span> {{ \Carbon\Carbon::parse($p->end_date)->format('d/m/Y') }}
                                </div>
                            </div>

                            <div class="flex justify-between items-end mt-2">
                                <div>
                                    @if($p->vehicle)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded border border-blue-100">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            {{ $p->vehicle->brand }}
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold text-gray-500 bg-gray-100 px-2 py-1 rounded">GLOBAL</span>
                                    @endif
                                </div>

                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button wire:click="editPromo({{ $p->id }})" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-600 hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                    <button wire:click="deletePromo({{ $p->id }})" wire:confirm="Supprimer ?" class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-600 hover:text-white transition"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $promotions->links() }}</div>
        </div>

    </div>

    <!-- MODALE ÉDITION -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl animate-fade-in-up">
            <div class="bg-red-600 p-4 flex justify-between items-center text-white">
                <h3 class="font-bold">Modifier Promotion</h3>
                <button wire:click="closeModal" class="hover:text-red-200">✕</button>
            </div>
            <div class="p-6">
                <form wire:submit.prevent="updatePromo" class="space-y-4">
                    <!-- ... MEMES CHAMPS QUE LE FORMULAIRE DE CRÉATION ... -->
                    <input type="text" wire:model="title" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm font-bold">

                    <div class="flex justify-center mb-4">
                        @if ($image && !is_string($image))
                            <img src="{{ $image->temporaryUrl() }}" class="h-24 w-full object-cover rounded-lg border-2 border-red-500">
                        @elseif ($oldImage)
                            <img src="{{ asset('storage/'.$oldImage) }}" class="h-24 w-full object-cover rounded-lg border border-gray-200">
                        @elseif ($selectedVehicleImage)
                            <img src="{{ asset('storage/'.$selectedVehicleImage) }}" class="h-24 w-full object-cover rounded-lg opacity-80">
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" wire:model="discount_percent" class="w-full border-slate-200 rounded-lg font-bold text-red-600">
                        <select wire:model.live="vehicle_id" class="w-full border-slate-200 rounded-lg text-xs font-bold">
                            <option value="">-- Toute la flotte --</option>
                            @foreach($vehicles_list as $v)<option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>@endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3 bg-red-50 p-2 rounded-lg">
                        <input type="date" wire:model="start_date" class="border-none bg-transparent text-xs font-bold">
                        <input type="date" wire:model="end_date" class="border-none bg-transparent text-xs font-bold">
                    </div>

                    <div class="pt-2">
                        <label class="text-[10px] font-bold text-slate-400 uppercase">Changer Image</label>
                        <input type="file" wire:model="image" id="editPromoImg{{ $iteration }}" class="block w-full text-xs text-slate-500 file:mr-2 file:py-1 file:px-2 file:rounded-full file:border-0 file:text-[10px] file:bg-red-50 file:text-red-600 hover:file:bg-red-100"/>
                    </div>

                    <textarea wire:model="description" rows="2" class="w-full border-slate-200 rounded-lg text-sm"></textarea>

                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-xl hover:bg-red-700">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    @endif

</div>
