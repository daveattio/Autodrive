<div class="p-6 bg-gray-50 min-h-screen">

    <!-- EN-TÊTE & BARRE D'OUTILS INTELLIGENTE -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Gestion des Réservations</h2>
            <p class="text-sm text-gray-500">Pilotez les locations et générez les contrats</p>
        </div>

        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto bg-white p-2 rounded-xl shadow-sm border border-gray-100">
            <!-- Recherche (Client, ID, Voiture) -->
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher (Client, ID, Voiture)..."
                    class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-64 text-sm bg-gray-50 focus:bg-white transition">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filtre Statut -->
            <select wire:model.live="statusFilter" class="border border-gray-200 rounded-lg py-2 px-3 focus:ring-blue-500 text-sm bg-gray-50 cursor-pointer hover:bg-white transition">
                <option value="">Tous les statuts</option>
                <option value="en_attente">En attente</option>
                <option value="confirmée">Confirmée</option>
                <option value="annulée">Annulée</option>
            </select>

            <!-- Filtre Paiement -->
            <select wire:model.live="paymentFilter" class="border border-gray-200 rounded-lg py-2 px-3 focus:ring-blue-500 text-sm bg-gray-50 cursor-pointer hover:bg-white transition">
                <option value="">Tous paiements</option>
                <option value="payé">Payé</option>
                <option value="impayé">Impayé</option>
            </select>
            <!-- Bouton Export Excel -->
            <button wire:click="exportExcel"
                class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-sm transition-all transform hover:scale-105">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Excel
            </button>
        </div>
    </div>

    <!-- NOTIFICATIONS -->
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('warning'))
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 mb-6 rounded shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        {{ session('warning') }}
    </div>
    @endif

    <!-- TABLEAU DE BORD -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 text-gray-600 uppercase text-xs font-bold tracking-wider">
                        <th class="px-5 py-4 text-left">ID / Client</th>
                        <th class="px-5 py-4 text-left">Véhicule</th>
                        <th class="px-5 py-4 text-left">Période</th>
                        <th class="px-5 py-4 text-right">Montant</th>
                        <th class="px-5 py-4 text-center">Paiement</th>
                        <th class="px-5 py-4 text-center">Statut</th>
                        <th class="px-5 py-4 text-center">Contrat</th> <!-- NOUVELLE COLONNE -->
                        <th class="px-5 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-blue-50/50 transition duration-150 group">

                        <!-- 1. Client -->
                        <td class="px-5 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-200 text-blue-700 rounded-full flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr($booking->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-bold whitespace-no-wrap text-sm">
                                        {{ $booking->user->name }}
                                    </p>
                                    <div class="flex items-center gap-2">
                                        <span class="text-gray-400 text-xs">ID: #{{ $booking->id }}</span>
                                        <span class="text-gray-300">|</span>
                                        <span class="text-gray-500 text-xs">{{ $booking->user->email }}</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- 2. Véhicule -->
                        <td class="px-5 py-4">
                            <div class="text-sm">
                                <p class="text-gray-900 font-bold uppercase tracking-wide">{{ $booking->vehicle->brand }}</p>
                                <p class="text-gray-500">{{ $booking->vehicle->name }}</p>
                            </div>
                        </td>

                        <!-- 3. Dates -->
                        <td class="px-5 py-4">
                            <div class="text-xs text-gray-600 bg-gray-100 px-2 py-1.5 rounded-md inline-block border border-gray-200 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}
                                <span class="text-gray-400 mx-1">➜</span>
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1 font-medium pl-1">
                                {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} jours
                            </div>
                        </td>

                        <!-- 4. Montant -->
                        <td class="px-5 py-4 text-right font-bold text-gray-800 text-sm">
                            {{ number_format($booking->total_price, 0, ',', ' ') }} <span class="text-xs font-normal text-gray-500">FCFA</span>
                        </td>

                        <!-- 5. Paiement -->
                        <td class="px-5 py-4 text-center">
                            @if($booking->payment_status == 'payé')
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Payé
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                                Impayé
                            </span>
                            @endif
                        </td>

                        <!-- 6. Statut -->
                        <td class="px-5 py-4 text-center">
                            @if($booking->status == 'en_attente')
                            <span class="px-3 py-1 font-bold text-yellow-700 bg-yellow-100 rounded-full text-xs border border-yellow-200">
                                En attente
                            </span>
                            @elseif($booking->status == 'confirmée')
                            <span class="px-3 py-1 font-bold text-green-700 bg-green-100 rounded-full text-xs border border-green-200">
                                Confirmée
                            </span>
                            @else
                            <span class="px-3 py-1 font-bold text-red-700 bg-red-100 rounded-full text-xs border border-red-200">
                                Annulée
                            </span>
                            @endif
                        </td>

                        <!-- 7. CONTRAT (NOUVELLE COLONNE) -->
                        <td class="px-5 py-4 text-center">
                            @if($booking->status === 'confirmée')
                            <a href="{{ route('admin.contract', $booking->id) }}" target="_blank"
                                class="inline-flex items-center justify-center w-8 h-8 bg-white border border-gray-200 rounded-lg text-gray-500 hover:text-blue-600 hover:border-blue-300 hover:bg-blue-50 transition-all shadow-sm"
                                title="Imprimer le contrat">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </a>
                            @else
                            <span class="text-gray-300 text-lg">-</span>
                            @endif
                        </td>

                        <!-- 8. ACTIONS / TRAITEMENT -->
                        <td class="px-5 py-4 text-center">

                            @if($booking->status === 'en_attente')
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500 animate-pulse">
                                À traiter
                            </span>
                            <!-- BOUTONS D'ACTION -->
                            <div class="flex justify-center gap-2">
                                <button wire:click="updateStatus({{ $booking->id }}, 'confirmée')"
                                    class="p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-500 hover:text-white transition shadow-sm border border-green-200" title="Valider">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </button>
                                <button wire:click="updateStatus({{ $booking->id }}, 'annulée')"
                                    wire:confirm="Refuser cette réservation ?"
                                    class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-500 hover:text-white transition shadow-sm border border-red-200" title="Refuser">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            @else
                            <!-- BADGE TRAITÉ -->
                            <div class="flex flex-col items-center opacity-70">
                                <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Traité
                                </span>
                                <span class="text-[9px] text-gray-400">
                                    le {{ $booking->updated_at->format('d/m/y') }}
                                </span>
                            </div>
                            @endif
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-4 border-t border-gray-200 bg-gray-50">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
