<div class="p-6 bg-white border-b border-gray-200 min-h-screen">

    <!-- Header avec Stats -->
    <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Utilisateurs & Clients</h2>
            <p class="text-sm text-gray-500">Gérez votre base de données clients.</p>
        </div>

        <!-- Stats Rapides -->
        <div class="flex gap-3">
            <div class="bg-blue-50 text-blue-800 px-4 py-2 rounded-lg font-bold border border-blue-200 text-sm flex flex-col items-center">
                <span class="text-2xl leading-none">{{ \App\Models\User::where('role', '!=', 'admin')->count() }}</span>
                <span class="text-[10px] uppercase">Clients</span>
            </div>
            <div class="bg-purple-50 text-purple-800 px-4 py-2 rounded-lg font-bold border border-purple-200 text-sm flex flex-col items-center">
                <span class="text-2xl leading-none">{{ \App\Models\User::where('client_type', 'entreprise')->count() }}</span>
                <span class="text-[10px] uppercase">Entreprises</span>
            </div>
        </div>
    </div>

    <!-- BARRE DE RECHERCHE & FILTRES -->
    <div class="bg-gray-50 p-3 rounded-xl border border-gray-200 mb-6 grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

        <!-- Champ Recherche -->
        <div class="md:col-span-6 relative">
            <input wire:model.live.debounce.300ms="search" type="text"
                placeholder="Rechercher (Nom, Email, Tél, Ville, ID)..."
                class="pl-9 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full text-sm shadow-sm">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
        </div>

        <!-- Filtres Dates (Inscription) -->
        <div class="md:col-span-6 flex items-center gap-2">
            <span class="text-xs font-bold text-gray-500 uppercase whitespace-nowrap">Inscrit du :</span>
            <input type="date" wire:model.live="dateStart" class="w-full border border-gray-300 rounded-lg py-2 px-2 text-xs focus:ring-blue-500">
            <span class="text-gray-400">au</span>
            <input type="date" wire:model.live="dateEnd" class="w-full border border-gray-300 rounded-lg py-2 px-2 text-xs focus:ring-blue-500">

            <!-- Bouton Reset -->
            @if($search || $dateStart || $dateEnd)
            <button wire:click="resetFilters"
                class="p-2 text-red-500 hover:bg-red-100 rounded-full transition shadow-sm border border-red-100 bg-white"
                title="Effacer les filtres">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            @endif
        </div>
    </div>

    <!-- TABLEAU -->
    <div class="overflow-x-auto rounded-lg border border-gray-200 shadow-sm">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rôle & Type</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact & Ville</th>
                    <th class="py-3 px-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date Inscription</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($users as $user)
                <tr class="hover:bg-blue-50/50 transition duration-150">
                    <td class="py-3 px-4 text-gray-500 font-mono text-xs">#{{ $user->id }}</td>

                    <td class="py-3 px-4">
                        <div class="flex items-center">
                            <!-- Avatar Initiale -->
                            <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm
                                {{ $user->role === 'admin' ? 'bg-red-600' : 'bg-blue-600' }}">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td class="py-3 px-4">
                        @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            ADMIN
                        </span>
                        @else
                        @if($user->client_type === 'entreprise')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-purple-100 text-purple-700 border border-purple-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            ENTREPRISE
                        </span>
                        @elseif($user->client_type === 'touriste')
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            TOURISTE
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            PARTICULIER
                        </span>
                        @endif
                        @endif
                    </td>

                    <td class="py-3 px-4">
                        @if($user->phone)
                        <div class="text-sm text-gray-900 font-medium">{{ $user->phone }}</div>
                        @else
                        <span class="text-xs text-gray-400 italic">Non renseigné</span>
                        @endif

                        @if($user->city)
                        <div class="text-xs text-blue-600 font-bold uppercase mt-1 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            {{ $user->city }}
                        </div>
                        @endif
                    </td>

                    <td class="py-3 px-4 text-sm text-gray-600">
                        {{ $user->created_at->format('d/m/Y') }}
                        <span class="text-xs text-gray-400 block">{{ $user->created_at->diffForHumans() }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                        Aucun utilisateur trouvé pour cette recherche.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
