<div class="min-h-screen bg-slate-950 text-slate-300 font-mono p-6">

    <!-- 1. HEADER & STATS -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8 items-center">

        <!-- Titre + Bouclier Animé -->
        <div class="lg:col-span-2 flex items-center gap-4">
            <div class="relative">
                <div class="absolute inset-0 bg-blue-500 blur-xl opacity-20 animate-pulse"></div>
                <div class="bg-slate-900 p-3 rounded-2xl border border-slate-800 shadow-2xl relative z-10">
                    <!-- ICONE BOUCLIER -->
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h2 class="text-3xl font-black text-white tracking-tight">SECURITY <span class="text-blue-500">LOGS</span></h2>
                <p class="text-xs text-slate-500 uppercase tracking-widest mt-1">Surveillance Temps Réel & Intégrité</p>
            </div>
        </div>

        <!-- Stat : Total Events -->
        <div class="bg-slate-900/50 border border-slate-800 rounded-xl p-4 flex items-center justify-between hover:border-blue-500/30 transition duration-500">
            <div>
                <p class="text-slate-500 text-xs uppercase font-bold">Total Events</p>
                <p class="text-2xl font-bold text-white">{{ $stats['total'] }}</p>
            </div>
            <div class="text-slate-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
        </div>

        <!-- Stat : Menaces Critiques (Rouge) -->
        <div class="bg-slate-900/50 border border-red-900/30 rounded-xl p-4 flex items-center justify-between hover:border-red-500/50 transition duration-500 relative overflow-hidden">
            @if($stats['critical'] > 0)
            <div class="absolute inset-0 bg-red-500/5 animate-pulse"></div>
            @endif
            <div class="relative z-10">
                <p class="text-red-400 text-xs uppercase font-bold">Alertes Critiques</p>
                <p class="text-2xl font-bold text-red-500">{{ $stats['critical'] }}</p>
            </div>
            <div class="relative z-10 text-red-900">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- 2. CONSOLE DE FILTRAGE (Style Terminal) -->
    <div class="bg-slate-900 border border-slate-800 rounded-lg p-5 mb-6 shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <!-- Search -->
            <div class="md:col-span-5">
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Requête (grep)</label>
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-green-500 font-bold">></span>
                    <input wire:model.live.debounce.300ms="search" type="text"
                        class="w-full bg-slate-950 border border-slate-700 text-white text-sm rounded-md px-3 py-2 pl-7 focus:ring-1 focus:ring-green-500 focus:border-green-500 placeholder-slate-600 font-mono transition"
                        placeholder="Search IP, User, Details...">
                </div>
            </div>

            <!-- Action Filter -->
            <div class="md:col-span-3">
                <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Filtrer par Event</label>
                <select wire:model.live="actionFilter" class="w-full bg-slate-950 border border-slate-700 text-slate-300 text-sm rounded-md px-3 py-2 focus:ring-1 focus:ring-blue-500 font-mono">
                    <option value="">[*] ALL EVENTS</option>
                    @foreach($actionsList as $act)
                    <option value="{{ $act }}">{{ $act }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dates -->
            <div class="md:col-span-3 flex gap-2">
                <div class="w-1/2">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Début</label>
                    <input type="date" wire:model.live="dateStart" class="w-full bg-slate-950 border border-slate-700 text-slate-300 text-xs rounded-md px-2 py-2">
                </div>
                <div class="w-1/2">
                    <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Fin</label>
                    <input type="date" wire:model.live="dateEnd" class="w-full bg-slate-950 border border-slate-700 text-slate-300 text-xs rounded-md px-2 py-2">
                </div>
            </div>

            <!-- Reset -->
            <div class="md:col-span-1">
                <button wire:click="resetFilters" class="w-full bg-slate-800 hover:bg-red-900/50 text-slate-400 hover:text-red-400 text-xs font-bold py-2.5 rounded border border-slate-700 transition uppercase tracking-wider">
                    Reset
                </button>
            </div>
        </div>
    </div>

    <!-- 3. TABLEAU DES LOGS (Style Matrix) -->
    <div class="overflow-hidden rounded-lg border border-slate-800 shadow-2xl">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-900 text-slate-400 uppercase text-[10px] tracking-wider font-bold">
                <tr>
                    <th class="px-6 py-4 border-b border-slate-800">Date / IP</th>
                    <th class="px-6 py-4 border-b border-slate-800">Acteur & Rôle</th>
                    <th class="px-6 py-4 border-b border-slate-800">Action</th>
                    <th class="px-6 py-4 border-b border-slate-800">Payload / Détails</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800 bg-slate-950">
                @forelse($logs as $log)
                <tr class="hover:bg-slate-900/80 transition duration-150 group">

                    <!-- Colonne 1 : Date & IP -->
                    <td class="px-6 py-4 align-top whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="h-2 w-2 rounded-full {{ str_contains($log->action, 'ALERTE') ? 'bg-red-500 animate-pulse' : 'bg-slate-600' }}"></div>
                            <span class="text-emerald-500 font-bold font-mono text-xs">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                        <div class="text-slate-600 text-[10px] font-mono mt-1 ml-4">{{ $log->ip_address }}</div>
                    </td>

                    <!-- Colonne 2 : Acteur & Rôle (Avec Stickers) -->
<td class="px-6 py-4 align-top">
    <div class="flex items-center gap-3">

        <!-- 1. LE STICKER (AVATAR) -->
        @if($log->user)
            <!-- CAS : UTILISATEUR CONNECTÉ -->
            @if($log->user_role === 'super_admin')
                <!-- Sticker SUPER ADMIN (Couronne/Bouclier Doré) -->
                <div class="w-10 h-10 rounded-xl bg-yellow-900/30 border border-yellow-600/50 flex items-center justify-center text-yellow-500 shadow-[0_0_10px_rgba(234,179,8,0.2)]">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
            @elseif($log->user_role === 'admin')
                <!-- Sticker ADMIN (Cravate/Badge Violet) -->
                <div class="w-10 h-10 rounded-xl bg-purple-900/30 border border-purple-600/50 flex items-center justify-center text-purple-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            @else
                <!-- Sticker CLIENT (Bonhomme Bleu) -->
                <div class="w-10 h-10 rounded-xl bg-slate-800 border border-slate-700 flex items-center justify-center text-blue-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
            @endif

        @else
            <!-- CAS : NON CONNECTÉ (Invité ou Pirate) -->
            @if(str_contains($log->action, 'ALERTE') || str_contains($log->action, 'BRUTE'))
                <!-- Sticker PIRATE (Incognito Rouge/Noir) -->
                <div class="w-10 h-10 rounded-xl bg-red-950 border border-red-600/50 flex items-center justify-center text-red-500 shadow-[0_0_15px_rgba(220,38,38,0.4)] animate-pulse">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
                </div>
            @else
                <!-- Sticker INVITÉ (Fantôme Gris) -->
                <div class="w-10 h-10 rounded-xl bg-slate-900 border border-slate-800 flex items-center justify-center text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            @endif
        @endif

        <!-- 2. LE TEXTE (Nom & Rôle) -->
        <div>
            @if($log->user)
                <div class="text-slate-200 font-bold text-sm">{{ $log->user->name }}</div>

                <!-- Badge Rôle Coloré -->
                @php
                    $roleConfig = match($log->user_role) {
                        'super_admin' => ['text' => 'Super Admin', 'class' => 'text-yellow-400 border-yellow-500/30 bg-yellow-500/10'],
                        'admin'       => ['text' => 'Admin', 'class' => 'text-purple-400 border-purple-500/30 bg-purple-500/10'],
                        'client'      => ['text' => 'Client', 'class' => 'text-blue-400 border-blue-500/30 bg-blue-500/10'],
                        default       => ['text' => 'Utilisateur', 'class' => 'text-slate-400 border-slate-500/30 bg-slate-500/10']
                    };
                @endphp
                <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold border {{ $roleConfig['class'] }}">
                    {{ $roleConfig['text'] }}
                </span>
            @else
                <!-- Texte pour Invité / Pirate -->
                @if(str_contains($log->action, 'ALERTE'))
                    <div class="text-red-500 font-bold text-sm uppercase tracking-wider">SUSPECT</div>
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold border border-red-500/30 bg-red-500/10 text-red-400">
                        Intrus non identifié
                    </span>
                @else
                    <div class="text-slate-500 font-bold text-sm">Visiteur</div>
                    <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[10px] uppercase font-bold border border-slate-700 bg-slate-800 text-slate-500">
                        Invité
                    </span>
                @endif
            @endif
        </div>
    </div>
</td>
                    <!-- Colonne 3 : Action (Badges Néons) -->
                    <td class="px-6 py-4 align-top">
                        @php
                        $badgeClass = 'text-slate-400 border-slate-700 bg-slate-800';
                        if(str_contains($log->action, 'ALERTE')) $badgeClass = 'text-red-400 border-red-500/50 bg-red-900/20 shadow-[0_0_10px_rgba(239,68,68,0.2)]';
                        if(str_contains($log->action, 'SUPPRESSION')) $badgeClass = 'text-orange-400 border-orange-500/50 bg-orange-900/20';
                        if(str_contains($log->action, 'PAIEMENT')) $badgeClass = 'text-green-400 border-green-500/50 bg-green-900/20';
                        if(str_contains($log->action, 'MODIFICATION')) $badgeClass = 'text-blue-400 border-blue-500/50 bg-blue-900/20';
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-md text-[10px] font-bold border {{ $badgeClass }}">
                            {{ $log->action }}
                        </span>
                        <div class="text-[12px] text-slate-500 mt-2 font-mono">Target: {{ $log->target }}</div>
                    </td>

                    <!-- Colonne 4 : Détails -->
                    <td class="px-6 py-4 align-top">
                        <div class="text-slate-300 text-xs leading-relaxed bg-slate-900/50 p-2 rounded border border-slate-800/50">
                            {{ $log->details }}
                        </div>
                        <div class="text-[10px] text-slate-600 mt-1 truncate max-w-xs font-mono opacity-60" title="{{ $log->user_agent }}">
                            UA: {{ $log->user_agent }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center text-slate-600">
                            <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="text-sm">Aucune trace détectée pour cette recherche.</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Dark -->
    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
