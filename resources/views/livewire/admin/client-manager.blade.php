<div class="p-6 bg-gray-50 min-h-screen">

    <!-- EN-TÊTE & STATS RAPIDES -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Clients & KYC</h2>
            <p class="text-sm text-gray-500">
                <strong>{{ $users->total() }}</strong> clients inscrits. Validez les documents pour autoriser les paiements.
            </p>
        </div>

        <!-- BARRE DE FILTRES -->
        <div class="flex flex-wrap gap-2 bg-white p-2 rounded-xl shadow-sm border border-gray-100 items-center">

            <!-- Recherche -->
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher (Nom, Ville, Tél)..."
                       class="pl-8 pr-3 py-2 border border-gray-200 rounded-lg text-sm w-48 focus:ring-blue-500">
                <svg class="w-4 h-4 text-gray-400 absolute left-2.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <!-- Dates -->
            <div class="flex items-center gap-1 bg-gray-50 px-2 py-1 rounded-lg border border-gray-200">
                <input type="date" wire:model.live="dateStart" class="text-xs bg-transparent border-none p-0 focus:ring-0 text-gray-600">
                <span class="text-gray-400">-</span>
                <input type="date" wire:model.live="dateEnd" class="text-xs bg-transparent border-none p-0 focus:ring-0 text-gray-600">
            </div>

            <!-- Type -->
            <select wire:model.live="typeFilter" class="border border-gray-200 rounded-lg text-sm px-2 py-2 focus:ring-blue-500 bg-white">
                <option value="">Tous types</option>
                <option value="particulier">👤 Particuliers</option>
                <option value="entreprise">🏢 Entreprises</option>
                <option value="touriste">✈️ Touristes</option>
            </select>

            <!-- Statut -->
            <select wire:model.live="kycFilter" class="border border-gray-200 rounded-lg text-sm px-2 py-2 focus:ring-blue-500 font-bold text-slate-600">
                <option value="">Tous états</option>
                <option value="pending">⚠️ À valider</option>
                <option value="verified">✅ Validés</option>
                <option value="incomplete">❌ Incomplets</option>
            </select>

            @if($search || $dateStart || $typeFilter || $kycFilter)
                <button wire:click="resetFilters" class="text-red-500 hover:bg-red-50 p-2 rounded-lg" title="Effacer filtres">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif
        </div>
    </div>

    <!-- MESSAGES -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded shadow-sm mb-4 text-sm font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <!-- TABLEAU -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead class="bg-slate-900 text-white uppercase text-xs font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Client</th>
                        <th class="px-6 py-4">Infos & Date</th>
                        <th class="px-6 py-4">Documents Requis</th>
                        <th class="px-6 py-4 text-center">État & Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50 transition group">

                        <!-- COLONNE 1 : IDENTITÉ AVEC ICÔNE -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <!-- Icône selon le type -->
                                <div class="w-10 h-10 rounded-full flex items-center justify-center shadow-sm
                                    {{ $user->client_type == 'entreprise' ? 'bg-purple-100 text-purple-600' : ($user->client_type == 'touriste' ? 'bg-teal-100 text-teal-600' : 'bg-blue-100 text-blue-600') }}">
                                    @if($user->client_type == 'entreprise')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    @elseif($user->client_type == 'touriste')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $user->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                    <div class="text-[10px] uppercase font-bold tracking-wider mt-0.5
                                        {{ $user->client_type == 'entreprise' ? 'text-purple-600' : ($user->client_type == 'touriste' ? 'text-teal-600' : 'text-blue-600') }}">
                                        {{ $user->client_type }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- COLONNE 2 : INFOS & DATE -->
                        <td class="px-6 py-4">
                            <div class="text-xs text-slate-600 space-y-1">
                                <div class="flex items-center gap-1" title="Date inscription">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $user->created_at->format('d/m/Y') }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    {{ $user->phone ?? 'N/A' }}
                                </div>
                                <div class="flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    {{ $user->city ?? 'N/A' }}
                                </div>
                            </div>
                        </td>

                        <!-- COLONNE 3 : DOCUMENTS -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col gap-1.5">
                                <!-- Permis (Tous) -->
                                <div class="flex items-center justify-between text-xs bg-slate-50 p-1.5 rounded border border-slate-100">
                                    <span class="text-slate-600 font-medium">Permis</span>
                                    @if($user->license_path)
                                        <a href="{{ asset('storage/'.$user->license_path) }}" target="_blank" class="text-blue-600 hover:underline font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Voir
                                        </a>
                                    @else
                                        <span class="text-red-400 text-[10px] uppercase">Manquant</span>
                                    @endif
                                </div>

                                <!-- Docs spécifiques -->
                                @if($user->client_type == 'touriste')
                                    <div class="flex items-center justify-between text-xs bg-slate-50 p-1.5 rounded border border-slate-100">
                                        <span class="text-slate-600 font-medium">Passeport</span>
                                        @if($user->passport_path)
                                            <a href="{{ asset('storage/'.$user->passport_path) }}" target="_blank" class="text-teal-600 hover:underline font-bold flex items-center gap-1">
                                                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Voir</a>
                                        @else
                                            <span class="text-red-400 text-[10px] uppercase">Manquant</span>
                                        @endif
                                    </div>
                                @endif

                                @if($user->client_type == 'entreprise')
                                    <div class="flex items-center justify-between text-xs bg-slate-50 p-1.5 rounded border border-slate-100">
                                        <span class="text-slate-600 font-medium">RCCM/NIF</span>
                                        @if($user->company_doc_path)
                                            <a href="{{ asset('storage/'.$user->company_doc_path) }}" target="_blank" class="text-indigo-600 hover:underline font-bold flex items-center gap-1">
                                                 <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Voir</a>
                                        @else
                                            <span class="text-red-400 text-[10px] uppercase">Manquant</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- COLONNE 4 : VALIDATION -->
                        <td class="px-6 py-4 text-center align-middle">
                            @if($user->kyc_verified_at)
                                <div class="inline-flex flex-col items-center">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 cursor-default">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                        Validé
                                    </span>
                                    <button wire:click="revokeUser({{ $user->id }})" wire:confirm="Attention : Cela va bloquer les paiements de ce client." class="text-[10px] text-gray-400 hover:text-red-500 underline mt-1">Révoquer</button>
                                </div>
                            @elseif($user->license_path)
                                <!-- A des docs mais pas validé -->
                                <button wire:click="verifyUser({{ $user->id }})"
                                        wire:confirm="Confirmez-vous la validité des documents ?"
                                        class="group bg-slate-900 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md transition transform hover:scale-105 text-xs font-bold flex items-center justify-center gap-2 mx-auto">
                                    <svg class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Valider Dossier
                                </button>
                            @else
                                <span class="text-xs text-gray-400 italic">En attente d'envoi</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
