<div class="container mx-auto px-4 py-10 max-w-5xl">

    <!-- En-tête avec bouton retour -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-10">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">Mes Réservations</h1>
            <p class="text-gray-500 mt-2">Gérez vos locations et vos paiements en un clin d'œil.</p>
        </div>
        <a href="{{ url('/') }}" class="mt-4 md:mt-0 group flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-gray-600 font-medium hover:border-blue-600 hover:text-blue-600 transition-all shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Retour à l'accueil
        </a>
    </div>

    @if (session()->has('message'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-8 rounded-r flex items-center gap-3 animate-fade-in-down">
        <div class="text-green-500">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <span class="text-green-800 font-medium">{{ session('message') }}</span>
    </div>
    @endif

    <div class="grid gap-6">
        @forelse($bookings as $booking)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col md:flex-row">

            <!-- 1. Image du véhicule (Gauche) -->
            <div class="md:w-1/3 bg-gray-100 relative min-h-[200px]">
                @if($booking->vehicle->image)
                <img src="{{ asset('storage/' . $booking->vehicle->image) }}" class="absolute inset-0 w-full h-full object-cover">
                @else
                <div class="flex items-center justify-center h-full text-gray-400">
                    <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                @endif
                <!-- Badge ID -->
                <div class="absolute top-3 left-3 bg-black/50 backdrop-blur text-white text-xs px-2 py-1 rounded">
                    #{{ $booking->id }}
                </div>
            </div>

            <!-- 2. Informations (Centre & Droite) -->
            <div class="p-6 md:w-2/3 flex flex-col justify-between">

                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm text-blue-600 font-bold uppercase tracking-wider mb-1">{{ $booking->vehicle->brand }}</p>
                        <h3 class="text-2xl font-bold text-gray-900">{{ $booking->vehicle->name }}</h3>

                        <!-- Dates avec icône -->
                        <div class="flex items-center gap-2 mt-3 text-gray-600 bg-gray-50 inline-flex px-3 py-1.5 rounded-lg border border-gray-100">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($booking->start_date)->format('d M Y') }}
                                <span class="text-gray-400 mx-1">➜</span>
                                {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}
                            </span>
                        </div>
                    </div>

                    <!-- Prix -->
                    <div class="text-right">
                        <div class="text-2xl font-extrabold text-gray-900">{{ number_format($booking->total_price, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-500">FCFA</span></div>
                        <div class="text-xs text-gray-400 mt-1">Total estimé</div>
                    </div>
                </div>

                <hr class="border-dashed border-gray-200 my-4">

                <!-- Actions et Statuts -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                    <!-- Badges de Statut -->
                    <div class="flex gap-3">
                        <!-- Statut Réservation -->
                        <div class="flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $booking->status == 'confirmée' ? 'bg-green-100 text-green-700' : ($booking->status == 'annulée' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            <span class="w-2 h-2 rounded-full {{ $booking->status == 'confirmée' ? 'bg-green-500' : ($booking->status == 'annulée' ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
                            {{ $booking->status }}
                        </div>

                        <!-- Statut Paiement -->
                        @if($booking->payment_status == 'payé')
                        <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-bold uppercase border border-blue-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Payé
                        </div>
                        @else
                        <div class="flex items-center gap-1 px-3 py-1 rounded-full bg-gray-100 text-gray-600 text-xs font-bold uppercase">
                            En attente
                        </div>
                        @endif
                    </div>

                    <!-- Bouton d'action -->
                    @if($booking->payment_status != 'payé' && $booking->status != 'annulée')
                    <button wire:click="payBooking({{ $booking->id }})"
                        wire:confirm="Confirmer le paiement de {{ number_format($booking->total_price, 0, ',', ' ') }} FCFA ?"
                        class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        Payer maintenant
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-3xl shadow-sm border border-gray-100">
            <div class="inline-block p-4 rounded-full bg-gray-50 mb-4">
                <svg class="h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">Aucune réservation</h3>
            <p class="text-gray-500 mt-2 mb-6">Vous n'avez pas encore loué de véhicule chez nous.</p>
            <a href="{{ route('vehicles.index') }}" class="text-blue-600 font-bold hover:underline">Découvrir nos voitures</a>
        </div>
        @endforelse
    </div>
</div>
