<div class="p-6 bg-gray-50 min-h-screen">

    <!-- HEADER & FILTRES -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-6">

        <!-- Ligne du haut : Titre + Export -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Pilotage des Réservations</h2>
                <p class="text-sm text-gray-500 font-medium">
                    <span class="text-blue-600 font-bold">{{ $bookings->total() }}</span> dossier(s) trouvé(s)
                </p>
            </div>

            <!-- BOUTON EXPORT (Logique conservée) -->
            <div>
                @if(count($selectedRows) > 0)
                    <button wire:click="export('selection')"
                            class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Exporter la sélection ({{ count($selectedRows) }})
                    </button>
                @else
                    <button wire:click="export('all')"
                            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Exporter le résultat
                    </button>
                @endif
            </div>
        </div>

        <!-- Ligne du bas : Filtres (Grille intelligente) -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-center">

            <!-- Recherche (Prend 4 colonnes) -->
            <div class="md:col-span-4 relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher (Nom, ID, Auto)..."
                       class="w-full pl-10 pr-4 py-2.5 border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50 focus:bg-white transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </div>

            <!-- Selects (Prennent 2 colonnes chacun) -->
            <div class="md:col-span-2">
                <select wire:model.live="statusFilter" class="w-full border-gray-200 rounded-lg py-2.5 text-sm focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-pointer">
                    <option value="">Tous statuts</option>
                    <option value="en_attente">En attente</option>
                    <option value="confirmée">Confirmée</option>
                    <option value="annulée">Annulée</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <select wire:model.live="paymentFilter" class="w-full border-gray-200 rounded-lg py-2.5 text-sm focus:ring-2 focus:ring-blue-500 bg-gray-50 cursor-pointer">
                    <option value="">Tous paiements</option>
                    <option value="payé">Payé</option>
                    <option value="impayé">Impayé</option>
                </select>
            </div>

            <!-- Dates (Prennent 3 colonnes) -->
            <div class="md:col-span-3 flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-lg px-2">
                <input type="date" wire:model.live="dateStart" class="w-full border-none bg-transparent text-xs p-2 focus:ring-0 text-gray-600">
                <span class="text-gray-400">à</span>
                <input type="date" wire:model.live="dateEnd" class="w-full border-none bg-transparent text-xs p-2 focus:ring-0 text-gray-600">
            </div>

            <!-- Bouton Reset (Prend 1 colonne) -->
            <div class="md:col-span-1 text-right">
                @if($search || $statusFilter || $paymentFilter || $dateStart || $dateEnd)
                    <button wire:click="resetFilters" class="text-red-500 hover:text-red-700 text-xs font-bold underline transition" title="Effacer tous les filtres">
                        Effacer
                    </button>
                @endif
            </div>
        </div>
    </div>

    <!-- MESSAGES -->
    @if (session()->has('message'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('warning'))
        <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            {{ session('warning') }}
        </div>
    @endif

    <!-- TABLEAU (DESIGN PREMIUM) -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 text-gray-500 uppercase text-[10px] font-bold tracking-wider">
                        <th class="px-6 py-4 text-center w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </th>
                        <th class="px-6 py-4 text-left">Client / Référence</th>
                        <th class="px-6 py-4 text-left">Véhicule</th>
                        <th class="px-6 py-4 text-left">Période</th>
                        <th class="px-6 py-4 text-right">Montant</th> <!-- Align Right pour argent -->
                        <th class="px-6 py-4 text-center">État</th>
                        <th class="px-6 py-4 text-center">Contrat</th>
                        <th class="px-6 py-4 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-indigo-50/30 transition duration-150 group {{ in_array($booking->id, $selectedRows) ? 'bg-indigo-50' : '' }}">

                        <!-- Checkbox -->
                        <td class="px-6 py-4 text-center">
                            <input type="checkbox" wire:model.live="selectedRows" value="{{ $booking->id }}" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        </td>

                        <!-- Client -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-9 h-9 bg-slate-100 text-slate-600 rounded-full flex items-center justify-center font-bold text-xs border border-slate-200">
                                    {{ substr($booking->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-bold text-gray-900">{{ $booking->user->name }}</p>
                                    <div class="flex flex-col">
                                        <span class="text-xs text-gray-500">{{ $booking->user->email }}</span>
                                        <span class="text-[10px] text-gray-400 font-mono mt-0.5">ID: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Véhicule -->
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-gray-800 uppercase">{{ $booking->vehicle->brand }}</span>
                                <span class="text-xs text-gray-500">{{ $booking->vehicle->name }}</span>
                            </div>
                        </td>

                        <!-- Dates (Whitespace nowrap pour empêcher le retour à la ligne) -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col">
                                <span class="text-xs font-medium text-gray-700 bg-gray-100 px-2 py-1 rounded inline-block text-center border border-gray-200">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m') }}
                                    <span class="text-gray-400 mx-1">➜</span>
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                                </span>
                                <span class="text-[10px] text-gray-400 mt-1 text-center">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} jours
                                </span>
                            </div>
                        </td>

                        <!-- Montant (Align Right) -->
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <span class="text-sm font-black text-gray-900 block">{{ number_format($booking->total_price, 0, ',', ' ') }}</span>
                            <span class="text-[10px] text-gray-500 uppercase">FCFA</span>
                        </td>

                        <!-- État (Statut + Paiement regroupés pour gagner de la place) -->
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <!-- Statut -->
                                @if($booking->status == 'en_attente')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-yellow-100 text-yellow-700 border border-yellow-200">En attente</span>
                                @elseif($booking->status == 'confirmée')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 border border-green-200">Confirmée</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 border border-red-200">Annulée</span>
                                @endif

                                <!-- Paiement -->
                                @if($booking->payment_status == 'payé')
                                    <span class="text-[10px] font-bold text-green-600 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Payé
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold text-red-400">Impayé</span>
                                @endif
                            </div>
                        </td>

                        <!-- Contrat -->
                        <td class="px-6 py-4 text-center">
                            @if($booking->status === 'confirmée')
                                <a href="{{ route('admin.contract', $booking->id) }}" target="_blank"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:text-red-600 hover:bg-red-50 border border-gray-200 transition-all"
                                   title="PDF Contrat">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                </a>
                            @else
                                <span class="text-gray-200 text-xl">•</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            @if($booking->status === 'en_attente')
                             <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500 animate-pulse">
                                À traiter
                            </span>
                                <div class="flex justify-center gap-2">
                                    <button wire:click="updateStatus({{ $booking->id }}, 'confirmée')" class="p-1.5 rounded-md bg-green-50 text-green-600 hover:bg-green-600 hover:text-white border border-green-200 transition shadow-sm" title="Valider">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </button>
                                    <button wire:click="updateStatus({{ $booking->id }}, 'annulée')" wire:confirm="Refuser ?" class="p-1.5 rounded-md bg-red-50 text-red-600 hover:bg-red-600 hover:text-white border border-red-200 transition shadow-sm" title="Refuser">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </div>
                            @elseif($booking->status === 'confirmée')
                                <div class="text-center">
                                    <span class="text-[10px] text-gray-400 font-medium block">Traité le</span>
                                    <span class="text-[10px] text-gray-600 font-bold">{{ $booking->updated_at->format('d/m') }}</span>
                                </div>
                            @else
                                <span class="text-gray-300 text-sm italic">Refusé</span>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex items-center justify-between">
            <span class="text-xs text-gray-500">Affichage de 10 résultats par page</span>
            <div>{{ $bookings->links() }}</div>
        </div>
    </div>
</div>
