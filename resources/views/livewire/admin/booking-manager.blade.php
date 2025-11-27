<div class="p-6 bg-gray-50 min-h-screen">

    <!-- EN-TÊTE & FILTRES -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Gestion des Réservations</h2>

        <div class="flex flex-col md:flex-row gap-3 w-full md:w-auto">
            <!-- Recherche -->
            <div class="relative">
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher (Client, ID, Voiture)..."
                    class="pl-10 pr-4 py-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full md:w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <!-- Filtres alignés horizontalement -->
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <!-- Filtre Statut -->
                <div class="flex-1 min-w-[180px]">
                    <label for="statusFilter" class="sr-only">Statut</label>
                    <select
                        id="statusFilter"
                        wire:model.live="statusFilter"
                        class="w-full border rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer shadow-sm">
                        <option value="">Tous les statuts</option>
                        <option value="en_attente">En attente</option>
                        <option value="confirmée">Confirmée</option>
                        <option value="annulée">Annulée</option>
                    </select>
                </div>

                <!-- Filtre Paiement -->
                <div class="flex-1 min-w-[180px]">
                    <label for="paymentFilter" class="sr-only">Paiement</label>
                    <select
                        id="paymentFilter"
                        wire:model.live="paymentFilter"
                        class="w-full border rounded-lg py-2 px-3 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 cursor-pointer shadow-sm">
                        <option value="">Tous paiements</option>
                        <option value="payé">Payé</option>
                        <option value="impayé">Impayé</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- MESSAGES ALERTES -->
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded shadow-sm">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('warning'))
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 mb-4 rounded shadow-sm font-bold">
        ⚠️ {{ session('warning') }}
    </div>
    @endif

    <!-- TABLEAU MODERNE -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100 text-gray-600 uppercase text-xs font-bold tracking-wider">
                        <th class="px-5 py-4 text-left">ID / Client</th>
                        <th class="px-5 py-4 text-left">Véhicule</th>
                        <th class="px-5 py-4 text-left">Période</th>
                        <th class="px-5 py-4 text-right">Montant</th>
                        <th class="px-5 py-4 text-center">Paiement</th>
                        <th class="px-5 py-4 text-center">Statut</th>
                        <th class="px-5 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition duration-150">

                        <!-- Client -->
                        <td class="px-5 py-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold text-sm">
                                    {{ substr($booking->user->name, 0, 2) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-bold whitespace-no-wrap">
                                        {{ $booking->user->name }}
                                    </p>
                                    <p class="text-gray-500 text-xs">ID: #{{ $booking->id }}</p>
                                    <p class="text-gray-400 text-xs">{{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </td>

                        <!-- Véhicule -->
                        <td class="px-5 py-4">
                            <div class="text-sm">
                                <p class="text-gray-900 font-bold">{{ $booking->vehicle->brand }}</p>
                                <p class="text-gray-600">{{ $booking->vehicle->name }}</p>
                            </div>
                        </td>

                        <!-- Dates -->
                        <td class="px-5 py-4">
                            <div class="text-xs text-gray-700 bg-gray-100 px-2 py-1 rounded inline-block">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}
                                <span class="text-gray-400 mx-1">➜</span>
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }} jours
                            </div>
                        </td>

                        <!-- Total -->
                        <td class="px-5 py-4 text-right font-bold text-gray-800">
                            {{ number_format($booking->total_price, 0, ',', ' ') }} <span class="text-xs font-normal text-gray-500">FCFA</span>
                        </td>

                        <!-- Paiement -->
                        <td class="px-5 py-4 text-center">
                            @if($booking->payment_status == 'payé')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Payé
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Impayé
                            </span>
                            @endif
                        </td>

                        <!-- Statut -->
                        <td class="px-5 py-4 text-center">
                            @if($booking->status == 'en_attente')
                            <span class="px-3 py-1 font-semibold leading-tight text-yellow-700 bg-yellow-100 rounded-full text-xs">
                                En attente
                            </span>
                            @elseif($booking->status == 'confirmée')
                            <span class="px-3 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full text-xs">
                                Confirmée
                            </span>
                            @else
                            <span class="px-3 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full text-xs">
                                Annulée
                            </span>
                            @endif
                        </td>

                        <!-- Actions & État de Traitement -->
                        <td class="px-5 py-4 text-center align-middle">
                            @if($booking->status === 'en_attente')

                            <!-- CAS 1 : NON TRAITÉ -->
                            <div class="flex flex-col items-center gap-2">
                                <!-- Badge indicatif -->
                                <span class="text-[10px] font-extrabold uppercase tracking-widest text-orange-500 animate-pulse">
                                    À traiter
                                </span>

                                <!-- Boutons d'action -->
                                <div class="flex justify-center gap-2">
                                    <button wire:click="updateStatus({{ $booking->id }}, 'confirmée')"
                                        class="group bg-green-50 hover:bg-green-500 border border-green-200 text-green-600 hover:text-white p-2 rounded-lg transition-all duration-200 shadow-sm"
                                        title="Accepter la réservation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>

                                    <button wire:click="updateStatus({{ $booking->id }}, 'annulée')"
                                        wire:confirm="Êtes-vous sûr de vouloir refuser cette réservation ?"
                                        class="group bg-red-50 hover:bg-red-500 border border-red-200 text-red-600 hover:text-white p-2 rounded-lg transition-all duration-200 shadow-sm"
                                        title="Refuser la réservation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>

                                </div>

                                @else

                                <!-- CAS 2 : DÉJÀ TRAITÉ -->
                                <div class="flex flex-col items-center justify-center opacity-60">
                                    <span class="inline-flex items-center gap-1 text-xs font-bold text-black-500 uppercase tracking-wider bg-black-100 px-2 py-1 rounded">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Traité
                                    </span>
                                    <span class="text-[10px] text-black-400 mt-1">
                                        le {{ $booking->updated_at->format('d/m') }}
                                    </span>
                                    <!-- Bouton Contrat PDF -->
                                    <a href="{{ route('admin.contract', $booking->id) }}" target="_blank"
                                        class="group bg-gray-50 hover:bg-blue-500 border border-gray-200 text-gray-500 hover:text-white p-2 rounded-lg transition-all duration-200 shadow-sm"
                                        title="Télécharger le contrat PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                    </a>
                                </div>

                                @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-5 py-5 border-t border-gray-200">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
