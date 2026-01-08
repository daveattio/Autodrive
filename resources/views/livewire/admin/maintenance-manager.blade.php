<div class="p-6 bg-gray-50 min-h-screen">

    <!-- EN-TÊTE -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Atelier & Maintenance</h2>
            <p class="text-sm text-gray-500 font-medium">Gérez les indisponibilités et suivez les coûts d'entretien.</p>
        </div>

        <!-- BARRE DE FILTRES -->
        <div class="flex gap-2 bg-white p-1.5 rounded-xl border border-gray-200 shadow-sm">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Véhicule..."
                       class="pl-8 border-none text-sm focus:ring-0 bg-transparent w-40 placeholder-gray-400 font-bold text-slate-700">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="w-px bg-gray-200 my-1"></div>
            <select wire:model.live="filterType" class="border-none text-sm focus:ring-0 bg-transparent text-slate-600 font-bold cursor-pointer hover:text-blue-600 transition">
                <option value="">Tous les types</option>
                <option>Vidange</option>
                <option>Pneus</option>
                <option>Panne Mécanique</option>
                <option>Contrôle Technique</option>
                <option>Nettoyage Approfondi</option>
            </select>
        </div>
    </div>

    <!-- NOTIFICATIONS -->
    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-8 rounded-r shadow-sm flex items-center gap-3 animate-fade-in-down">
            <div class="bg-emerald-200 p-1 rounded-full"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg></div>
            <span class="font-bold text-sm">{{ session('message') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- COLONNE GAUCHE : FORMULAIRE (Sticky) -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 sticky top-6">

                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-black text-slate-800 flex items-center gap-2">
                        <span class="bg-slate-900 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </span>
                        {{ $isEditMode ? 'Modifier Fiche' : 'Nouveau Ticket' }}
                    </h3>
                    @if($isEditMode)
                        <button wire:click="cancelEdit" class="text-xs text-red-500 font-bold hover:underline">Annuler</button>
                    @endif
                </div>

                <form wire:submit.prevent="saveMaintenance" class="space-y-5">

                    <!-- Sélection Véhicule -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Véhicule concerné</label>
                        <select wire:model="vehicle_id" class="w-full border-gray-200 bg-slate-50 rounded-xl text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500 py-3">
                            <option value="">-- Sélectionner --</option>
                            @foreach($vehicles as $v)
                                <option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }} ({{ $v->type }})</option>
                            @endforeach
                        </select>
                        @error('vehicle_id') <span class="text-red-500 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Type & Coût -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Intervention</label>
                            <select wire:model="type" class="w-full border-gray-200 bg-slate-50 rounded-xl text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500 py-3">
                                <option value="">-- Type --</option>
                                <option>Vidange</option>
                                <option>Pneus</option>
                                <option>Panne Mécanique</option>
                                <option>Contrôle Technique</option>
                                <option>Nettoyage Approfondi</option>
                            </select>
                            @error('type') <span class="text-red-500 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Coût (FCFA)</label>
                            <input type="number" wire:model="cost" placeholder="0" class="w-full border-gray-200 bg-slate-50 rounded-xl text-sm font-bold text-slate-700 focus:ring-blue-500 focus:border-blue-500 py-3">
                            @error('cost') <span class="text-red-500 text-xs ml-1 font-bold">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="bg-blue-50/50 p-4 rounded-xl border border-blue-100">
                        <p class="text-xs text-blue-600 font-bold mb-3 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Période d'immobilisation
                        </p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[9px] font-bold text-blue-400 uppercase mb-1">Du</label>
                                <input type="date" wire:model="start_date" class="w-full border-blue-200 bg-white rounded-lg text-xs font-bold text-slate-700 focus:ring-blue-500">
                                @error('start_date') <span class="text-red-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-[9px] font-bold text-blue-400 uppercase mb-1">Au</label>
                                <input type="date" wire:model="end_date" class="w-full border-blue-200 bg-white rounded-lg text-xs font-bold text-slate-700 focus:ring-blue-500">
                                @error('end_date') <span class="text-red-500 text-[9px] font-bold">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1.5 ml-1">Note / Détails</label>
                        <textarea wire:model="description" rows="3" class="w-full border-gray-200 bg-slate-50 rounded-xl text-sm text-slate-700 focus:ring-blue-500 focus:border-blue-500" placeholder="Ex: Changement filtre à huile et plaquettes..."></textarea>
                    </div>

                    <!-- Bouton Submit -->
                    <button type="submit" class="w-full bg-slate-900 hover:bg-blue-600 text-white font-bold py-3.5 rounded-xl shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        @if($isEditMode)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Mettre à jour
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Enregistrer & Bloquer
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- COLONNE DROITE : LISTE (Tableau) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
                <table class="min-w-full text-left">
                    <thead class="bg-slate-50 border-b border-gray-200 text-[10px] text-gray-500 uppercase font-black tracking-wider">
                        <tr>
                            <th class="px-6 py-4">Véhicule</th>
                            <th class="px-6 py-4">Intervention</th>
                            <th class="px-6 py-4">Détails</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @foreach($maintenances as $m)
                            <!-- LOGIQUE D'AFFICHAGE DES BADGES -->
                            @php
                                $badgeStyle = match($m->type) {
                                    'Vidange' => 'bg-amber-50 text-amber-700 border-amber-200',
                                    'Pneus' => 'bg-slate-100 text-slate-700 border-slate-200',
                                    'Panne Mécanique' => 'bg-red-50 text-red-700 border-red-200',
                                    'Contrôle Technique' => 'bg-blue-50 text-blue-700 border-blue-200',
                                    'Nettoyage Approfondi' => 'bg-teal-50 text-teal-700 border-teal-200',
                                    default => 'bg-gray-50 text-gray-600 border-gray-200',
                                };
                                $icon = match($m->type) {
                                    'Vidange' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                                    'Panne Mécanique' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
                                    'Contrôle Technique' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                    default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />',
                                };
                            @endphp

                            <tr class="hover:bg-slate-50 transition group">

                                <!-- 1. VÉHICULE -->
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <!-- Miniature Image -->
                                        <div class="w-14 h-14 bg-gray-200 rounded-lg overflow-hidden border border-gray-200 flex-shrink-0 relative shadow-sm">
                                            @if($m->vehicle && $m->vehicle->image)
                                                <img src="{{ asset('storage/'.$m->vehicle->image) }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="flex items-center justify-center h-full text-gray-400"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg></div>
                                            @endif
                                        </div>
                                        <div>
                                            @if($m->vehicle)
                                                <div class="font-bold text-slate-900 text-sm">{{ $m->vehicle->brand }} {{ $m->vehicle->name }}</div>
                                                <div class="text-[10px] text-slate-500 uppercase tracking-wide mt-0.5 bg-gray-100 inline-block px-1.5 rounded">{{ $m->vehicle->type }}</div>
                                            @else
                                                <span class="text-red-500 font-bold text-xs italic">Véhicule supprimé</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <!-- 2. TYPE & DATES -->
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-start gap-2">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[10px] font-black uppercase border {{ $badgeStyle }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                                            {{ $m->type }}
                                        </span>
                                        <div class="text-xs font-medium text-slate-500 flex items-center gap-1.5 bg-white border border-gray-200 px-2 py-1 rounded-md shadow-sm">
                                            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            {{ \Carbon\Carbon::parse($m->start_date)->format('d/m') }} <span class="text-slate-300">➜</span> {{ \Carbon\Carbon::parse($m->end_date)->format('d/m/Y') }}
                                        </div>
                                    </div>
                                </td>

                                <!-- 3. NOTE & COÛT -->
                                <td class="px-6 py-4">
                                    <div class="mb-1">
                                        <span class="font-black text-slate-800 text-sm">{{ number_format($m->cost, 0, ',', ' ') }}</span>
                                        <span class="text-[10px] text-slate-400 font-bold">FCFA</span>
                                    </div>
                                    @if($m->description)
                                        <div class="text-xs text-slate-500 italic bg-slate-50 p-2 rounded border border-slate-100 max-w-[200px]">
                                            "{{ Str::limit($m->description, 50) }}"
                                        </div>
                                    @else
                                        <span class="text-[10px] text-gray-300 italic">Aucune note</span>
                                    @endif
                                </td>

                                <!-- 4. ACTIONS (MODIFIER / SUPPRIMER) -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- MODIFIER -->
                                        <button wire:click="editMaintenance({{ $m->id }})" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-blue-600 hover:border-blue-200 hover:shadow-md transition group" title="Modifier">
                                            <svg class="w-4 h-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>

                                        <!-- SUPPRIMER -->
                                        <button wire:click="deleteMaintenance({{ $m->id }})" wire:confirm="Supprimer cette maintenance ?" class="p-2 bg-white border border-slate-200 rounded-lg text-slate-500 hover:text-red-600 hover:border-red-200 hover:shadow-md transition group" title="Supprimer">
                                            <svg class="w-4 h-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $maintenances->links() }}
            </div>
        </div>

    </div>
</div>
