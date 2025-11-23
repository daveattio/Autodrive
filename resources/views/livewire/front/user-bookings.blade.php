<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
    <a href="{{ url('/') }}" class="inline-flex items-center text-gray-600 hover:text-blue-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Retour à l'accueil
    </a>
</div>
    <h1 class="text-3xl font-bold mb-6">Mes Réservations</h1>

    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 p-4 mb-4 rounded">{{ session('message') }}</div>
    @endif

    <div class="grid gap-4">
        @foreach($bookings as $booking)
            <div class="bg-white p-6 rounded-lg shadow flex justify-between items-center">
                <div>
                    <h3 class="text-xl font-bold text-blue-600">{{ $booking->vehicle->brand }} {{ $booking->vehicle->name }}</h3>
                    <p class="text-gray-600">Du {{ $booking->start_date }} au {{ $booking->end_date }}</p>
                    <p class="font-bold mt-2">Total : {{ number_format($booking->total_price, 0, ',', ' ') }} FCFA</p>
                    
                    <div class="mt-2">
                        Statut : 
                        <span class="px-2 py-1 rounded text-xs {{ $booking->status == 'confirmée' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                            {{ $booking->status }}
                        </span>
                    </div>
                </div>

                <div class="text-right">
                    @if($booking->payment_status == 'payé')
                        <span class="text-green-600 font-bold border border-green-600 px-4 py-2 rounded">Payé ✅</span>
                    @else
                        <span class="text-red-500 text-sm block mb-2">En attente de paiement</span>
                        <!-- Bouton Payer -->
                        <button wire:click="payBooking({{ $booking->id }})" 
                                wire:confirm="Simuler le paiement de {{ $booking->total_price }} FCFA ?"
                                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Payer maintenant
                        </button>
                    @endif
                </div>
            </div>
        @endforeach

        @if($bookings->isEmpty())
            <p class="text-gray-500">Vous n'avez aucune réservation.</p>
        @endif
    </div>
</div>