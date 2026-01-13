<div class="p-6 bg-gray-50 min-h-screen relative">

    <!-- EN-TÊTE -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
        <div>
            <h2 class="text-3xl font-black text-slate-800 tracking-tight">Atelier & Maintenance</h2>
            <p class="text-sm text-gray-500 font-medium">Suivi technique et coûts d'entretien.</p>
        </div>

        <!-- FILTRES -->
        <div class="flex gap-2 bg-white p-1.5 rounded-xl border border-gray-200 shadow-sm">
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Véhicule..." class="pl-8 border-none text-sm focus:ring-0 bg-transparent w-40 font-bold text-slate-700 placeholder-gray-400">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <div class="w-px bg-gray-200 my-1"></div>
            <select wire:model.live="filterType" class="border-none text-sm focus:ring-0 bg-transparent text-slate-600 font-bold cursor-pointer hover:text-orange-600 transition">
                <option value="">Tous types</option>
                <option>Vidange</option><option>Pneus</option><option>Panne Mécanique</option><option>Contrôle Technique</option><option>Nettoyage Approfondi</option>
            </select>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-6 rounded-r shadow-sm font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- GAUCHE : FORMULAIRE -->
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-200 sticky top-6">
                <h3 class="font-black text-slate-800 flex items-center gap-2 mb-6">
                    <span class="bg-orange-600 text-white w-8 h-8 rounded-lg flex items-center justify-center text-sm shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </span>
                    Nouveau Ticket
                </h3>

                <form wire:submit.prevent="saveMaintenance" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-bold text-slate-400 uppercase ml-1">Véhicule</label>
                        <select wire:model="vehicle_id" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm font-bold"><option value="">-- Choisir --</option>@foreach($vehicles as $v)<option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>@endforeach</select>
                        @error('vehicle_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <select wire:model="type" class="bg-slate-50 border-slate-200 rounded-lg text-xs font-bold text-slate-600">
                             <option value="">-- Type --</option><option>Vidange</option><option>Pneus</option><option>Panne Mécanique</option><option>Contrôle Technique</option><option>Nettoyage Approfondi</option>
                        </select>
                        <div class="relative">
                            <input type="number" wire:model="cost" class="w-full bg-slate-50 border-slate-200 rounded-lg pl-3 pr-8 text-sm font-bold" placeholder="0">
                            <span class="absolute right-3 top-2.5 text-xs text-gray-400 font-bold">F</span>
                        </div>
                    </div>

                    <div class="bg-orange-50 p-3 rounded-xl border border-orange-100 grid grid-cols-2 gap-3">
                        <div>
                            <label class="text-[9px] font-bold text-orange-400 uppercase">Début</label>
                            <input type="date" wire:model="start_date" class="w-full border-none bg-white rounded text-xs font-bold text-slate-700">
                        </div>
                        <div>
                            <label class="text-[9px] font-bold text-orange-400 uppercase">Fin</label>
                            <input type="date" wire:model="end_date" class="w-full border-none bg-white rounded text-xs font-bold text-slate-700">
                        </div>
                    </div>

                    <textarea wire:model="description" rows="2" class="w-full bg-slate-50 border-slate-200 rounded-lg text-sm" placeholder="Détails techniques..."></textarea>

                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-3 rounded-xl shadow-lg hover:bg-orange-600 transition">Enregistrer</button>
                </form>
            </div>
        </div>

        <!-- DROITE : LISTE (Grid Cards) -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($maintenances as $m)
                    @php
                        $color = match($m->type) { 'Vidange' => 'amber', 'Panne Mécanique' => 'red', 'Pneus' => 'slate', default => 'blue' };
                        $icon = match($m->type) {
                            'Vidange' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />',
                            'Panne Mécanique' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />',
                            default => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />',
                        };
                    @endphp

                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 flex gap-4 hover:border-{{ $color }}-200 transition group relative">

                        <!-- Image Véhicule -->
                        <div class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0 border border-gray-100">
                            @if($m->vehicle && $m->vehicle->image)
                                <img src="{{ asset('storage/'.$m->vehicle->image) }}" class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-300"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z"/></svg></div>
                            @endif
                        </div>

                        <div class="flex-grow flex flex-col justify-between py-0.5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-slate-900 text-xs">{{ $m->vehicle->brand }} {{ $m->vehicle->name }}</h4>
                                    <div class="inline-flex items-center gap-1 text-[10px] font-bold uppercase text-{{ $color }}-600 bg-{{ $color }}-50 px-1.5 py-0.5 rounded mt-1 border border-{{ $color }}-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $icon !!}</svg>
                                        {{ $m->type }}
                                    </div>
                                </div>
                                <span class="font-black text-slate-800 text-sm">{{ number_format($m->cost, 0, ',', ' ') }} F</span>
                            </div>

                            <div class="flex justify-between items-end mt-2">
                                <div class="text-[10px] text-gray-500 font-medium">
                                    {{ \Carbon\Carbon::parse($m->start_date)->format('d/m') }} ➜ {{ \Carbon\Carbon::parse($m->end_date)->format('d/m') }}
                                </div>

                                <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition">
                                    <button wire:click="editMaintenance({{ $m->id }})" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg></button>
                                    <button wire:click="deleteMaintenance({{ $m->id }})" class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-100"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $maintenances->links() }}</div>
        </div>

    </div>

    <!-- MODALE ÉDITION -->
    @if($showEditModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4">
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl animate-fade-in-up">
            <div class="bg-orange-600 p-4 flex justify-between items-center text-white">
                <h3 class="font-bold">Modifier Maintenance</h3>
                <button wire:click="closeModal" class="hover:text-orange-200">✕</button>
            </div>
            <div class="p-6">
                <form wire:submit.prevent="updateMaintenance" class="space-y-4">
                    <!-- Copie du formulaire ... -->
                    <select wire:model="vehicle_id" class="w-full border-gray-200 bg-slate-50 rounded-lg text-sm font-bold"><option value="">-- Choisir --</option>@foreach($vehicles as $v)<option value="{{ $v->id }}">{{ $v->brand }} {{ $v->name }}</option>@endforeach</select>

                    <div class="grid grid-cols-2 gap-3">
                        <select wire:model="type" class="w-full border-gray-200 bg-slate-50 rounded-lg text-xs font-bold text-slate-600"><option>Vidange</option><option>Pneus</option><option>Panne Mécanique</option><option>Contrôle Technique</option><option>Nettoyage Approfondi</option></select>
                        <input type="number" wire:model="cost" class="w-full border-gray-200 bg-slate-50 rounded-lg font-bold">
                    </div>

                    <div class="grid grid-cols-2 gap-3 bg-orange-50 p-2 rounded-lg">
                        <input type="date" wire:model="start_date" class="border-none bg-white rounded text-xs font-bold">
                        <input type="date" wire:model="end_date" class="border-none bg-white rounded text-xs font-bold">
                    </div>

                    <textarea wire:model="description" rows="2" class="w-full border-gray-200 rounded-lg text-sm"></textarea>

                    <button type="submit" class="w-full bg-orange-600 text-white font-bold py-3 rounded-xl hover:bg-orange-700">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
