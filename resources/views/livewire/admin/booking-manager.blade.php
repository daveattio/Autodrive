<div class="p-6 bg-white border-b border-gray-200">
    <h2 class="text-2xl font-bold mb-4">Gestion des Réservations</h2>

    <!-- ZONE DES MESSAGES (Placée AVANT le tableau) -->
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-4 mb-4 rounded shadow-sm border-l-4 border-green-500">
            ✅ {{ session('message') }}
        </div>
    @endif

    @if (session()->has('warning'))
        <div class="bg-orange-100 text-orange-800 p-4 mb-4 rounded shadow-sm border-l-4 border-orange-500 font-bold">
            ⚠️ {{ session('warning') }}
        </div>
    @endif
    <!-- FIN ZONE MESSAGES -->

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100 text-left text-gray-600 uppercase text-sm">
                    <th class="py-3 px-6 border-b">ID</th>
                    <th class="py-3 px-6 border-b">Client</th>
                    <th class="py-3 px-6 border-b">Véhicule</th>
                    <th class="py-3 px-6 border-b">Dates</th>
                    <th class="py-3 px-6 border-b">Total</th>
                    <th class="py-3 px-6 border-b">Statut</th>
                    <th class="py-3 px-6 border-b">Actions</th>
                    <th class="py-3 px-6 border-b">Paiement</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @foreach($bookings as $booking)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3 px-6">{{ $booking->id }}</td>
                    <td class="py-3 px-6">
                        <div class="font-bold">{{ $booking->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                    </td>
                    <td class="py-3 px-6">{{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</td>
                    <td class="py-3 px-6">
                        Du {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m/Y') }}<br>
                        Au {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/Y') }}
                    </td>
                    <td class="py-3 px-6 font-bold">{{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</td>
                    <td class="py-3 px-6">
                        @if($booking->status == 'en_attente')
                            <span class="bg-yellow-200 text-yellow-800 py-1 px-3 rounded-full text-xs">En attente</span>
                        @elseif($booking->status == 'confirmée')
                            <span class="bg-green-200 text-green-800 py-1 px-3 rounded-full text-xs">Confirmée</span>
                        @else
                            <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs">Annulée</span>
                        @endif
                    </td>
                    <td class="py-3 px-6 flex gap-2">
                        @if($booking->status === 'en_attente')
                            <button wire:click="updateStatus({{ $booking->id }}, 'confirmée')" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-xs">
                                Valider
                            </button>
                            <button wire:click="updateStatus({{ $booking->id }}, 'annulée')"
                                wire:confirm="Êtes-vous sûr de vouloir annuler cette réservation ?"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-xs">
                                Refuser
                            </button>
                        @else
                            <span class="text-gray-400 italic">Traité</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @if($booking->payment_status == 'payé')
                            <span class="bg-green-100 text-green-800 py-1 px-3 rounded-full text-xs font-bold">
                                Payé ✅
                            </span>
                        @else
                            <span class="bg-red-100 text-red-800 py-1 px-3 rounded-full text-xs">
                                Impayé
                            </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($bookings->isEmpty())
            <div class="text-center py-8 text-gray-500">Aucune réservation pour le moment.</div>
        @endif
    </div>
</div>