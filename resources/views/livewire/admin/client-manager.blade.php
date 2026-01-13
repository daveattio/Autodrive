<div class="p-6 bg-gray-50 min-h-screen">

    <!-- 1. BARRE D'OUTILS COMPACTE (Titre + Filtres alignés) -->
    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="flex flex-col xl:flex-row justify-between items-center gap-4">

            <!-- Titre & Compteur -->
            <div class="flex items-center gap-3 w-full xl:w-auto">
                <div class="bg-slate-900 text-white p-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800 leading-none">Clients</h2>
                    <p class="text-xs text-slate-500 font-medium mt-1">{{ $users->total() }} dossiers enregistrés</p>
                </div>
            </div>

            <!-- Zone Filtres (Grid sur mobile, Flex sur Desktop) -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-3 w-full xl:w-auto">

                <!-- Recherche -->
                <div class="relative">
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Nom, Ville, Tél..."
                           class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <!-- Dates (Début - Fin) -->
                <div class="flex items-center bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <input type="date" wire:model.live="dateStart" class="border-none text-xs text-slate-600 focus:ring-0 p-2 w-full" title="Date Inscription Début">
            
                    <input type="date" wire:model.live="dateEnd" class="border-none text-xs text-slate-600 focus:ring-0 p-2 w-full" title="Date Inscription Fin">
                </div>

                <!-- Type -->
                <select wire:model.live="typeFilter" class="border border-gray-200 rounded-lg text-sm px-3 py-2 text-slate-600 focus:ring-blue-500 cursor-pointer">
                    <option value="">Tous profils</option>
                    <option value="particulier">Particulier</option>
                    <option value="entreprise">Entreprise</option>
                    <option value="touriste">Touriste</option>
                </select>

                <!-- Statut KYC -->
                <select wire:model.live="kycFilter" class="border border-gray-200 rounded-lg text-sm px-3 py-2 font-bold text-slate-700 focus:ring-blue-500 cursor-pointer">
                    <option value="">Tous états</option>
                    <option value="pending"> À Valider</option>
                    <option value="verified"> Validés</option>
                    <option value="incomplete"> Incomplets</option>
                </select>
            </div>

            <!-- Reset -->
            @if($search || $dateStart || $typeFilter || $kycFilter)
                <button wire:click="resetFilters" class="text-red-500 hover:bg-red-50 p-2 rounded-lg transition" title="Réinitialiser les filtres">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif

        </div>
    </div>

    <!-- MESSAGES FLASH -->
    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- 2. TABLEAU PRO -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <table class="min-w-full text-left">
            <thead class="bg-slate-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Identité</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Coordonnées</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Dossier (KYC)</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Validation</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 transition group">

                    <!-- IDENTITÉ -->
                    <td class="px-6 py-4 align-top">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full flex items-center justify-center text-xs font-bold uppercase
                                {{ $user->client_type == 'entreprise' ? 'bg-purple-100 text-purple-700' :
                                  ($user->client_type == 'touriste' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700') }}">
                                {{ substr($user->client_type, 0, 2) }}
                            </div>
                            <div>
                                <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                <div class="text-[10px] font-bold uppercase tracking-wide mt-0.5
                                    {{ $user->client_type == 'entreprise' ? 'text-purple-600' :
                                      ($user->client_type == 'touriste' ? 'text-orange-600' : 'text-blue-600') }}">
                                    {{ $user->client_type }}
                                </div>
                                <div class="text-xs text-gray-400 mt-1">Inscrit le {{ $user->created_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    </td>

                    <!-- COORDONNÉES -->
                    <td class="px-6 py-4 align-top">
                        <div class="space-y-1.5">
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                {{ $user->email }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                {{ $user->phone ?? '-' }}
                            </div>
                            <div class="flex items-center gap-2 text-xs text-slate-600">
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $user->city ?? '-' }}
                            </div>
                        </div>
                    </td>

                    <!-- DOCUMENTS (GRID) -->
                    <td class="px-6 py-4 align-top">
                        <div class="grid grid-cols-1 gap-2">

                            <!-- Permis (Commun) -->
                            <div class="flex items-center justify-between bg-white border border-gray-200 rounded px-2 py-1.5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">Permis</span>
                                @if($user->license_path)
                                    <a href="{{ asset('storage/'.$user->license_path) }}" target="_blank" class="text-blue-600 hover:bg-blue-50 p-1 rounded transition" title="Voir le document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @else
                                    <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                            </div>

                            <!-- Doc Spécifique -->
                            @php
                                $docLabel = $user->client_type == 'entreprise' ? 'RCCM/NIF' : 'Passeport';
                                $docPath = $user->client_type == 'entreprise' ? $user->company_doc_path : $user->passport_path;
                                $needed = $user->client_type != 'particulier';
                            @endphp

                            @if($needed)
                            <div class="flex items-center justify-between bg-white border border-gray-200 rounded px-2 py-1.5">
                                <span class="text-[10px] font-bold text-gray-500 uppercase">{{ $docLabel }}</span>
                                @if($docPath)
                                    <a href="{{ asset('storage/'.$docPath) }}" target="_blank" class="text-blue-600 hover:bg-blue-50 p-1 rounded transition" title="Voir le document">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                @else
                                    <svg class="w-4 h-4 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @endif
                            </div>
                            @endif
                        </div>
                    </td>

                    <!-- ACTION / STATUT -->
                    <td class="px-6 py-4 text-center align-middle">
                        @if($user->kyc_verified_at)
                            <div class="inline-flex flex-col items-center gap-1">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 cursor-default">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Validé
                                </span>
                                <button wire:click="revokeUser({{ $user->id }})" class="text-[10px] text-gray-400 hover:text-red-500 underline transition">Annuler</button>
                            </div>
                        @elseif($user->license_path)
                            <button wire:click="verifyUser({{ $user->id }})"
                                    wire:confirm="Confirmer la validité du dossier ?"
                                    class="bg-slate-900 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105 text-xs font-bold flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Valider
                            </button>
                        @else
                            <span class="text-xs text-gray-400 italic">En attente docs</span>
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
