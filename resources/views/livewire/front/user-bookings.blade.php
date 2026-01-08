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
                        <div class="inline-flex items-center gap-2 mt-3 text-gray-600 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
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

                <!-- Actions et Statuts (Zone Footer) -->
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">

                    <!-- GAUCHE : INDICATEURS (Badges alignés) -->
                    <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto justify-center sm:justify-start">

                        <!-- 1. STATUT VALIDATION (Admin) -->
                        @if($booking->status == 'confirmée')
                        <div class="h-10 px-4 rounded-lg bg-green-50 text-green-700 border border-green-200 font-bold text-xs flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Validé par l'agence
                        </div>
                        @elseif($booking->status == 'annulée')
                        <div class="h-10 px-4 rounded-lg bg-gray-100 text-gray-500 font-bold text-xs flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Réservation annulée
                        </div>
                        @else
                        <div class="h-10 px-4 rounded-lg bg-yellow-50 text-yellow-800 border border-yellow-200 font-bold text-xs flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            En attente validation
                        </div>
                        @endif

                        <!-- 2. STATUT PAIEMENT (Financier) -->
                        @if($booking->payment_status == 'payé')
                        <div class="h-10 px-4 rounded-lg bg-blue-50 text-blue-700 border border-blue-100 font-bold text-xs flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Payé
                        </div>
                        @elseif($booking->status != 'annulée')
                        <div class="h-10 px-4 rounded-lg bg-red-50 text-red-600 border border-red-100 font-bold text-xs flex items-center gap-2 whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Règlement en attente
                        </div>
                        @endif
                    </div>

                    <!-- DROITE : BOUTON ACTION PRINCIPAL (Prioritaire) -->
                    <div class="w-full sm:w-auto">

                        @if($booking->status == 'annulée')
                        <!-- Pas d'action si annulé -->
                        <span class="hidden sm:block text-xs text-gray-400 font-medium italic">Dossier clos</span>

                        @elseif($booking->payment_status == 'payé')

                        <!-- BOUTON FACTURE (Si payé) -->
                        <a href="{{ route('invoice.download', $booking->id) }}" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-700 text-white font-bold py-2.5 px-4 rounded-lg shadow-sm transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs">
                            <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Facture
                        </a>
                        @elseif($booking->payment_status == 'en_attente_validation')
                        <div class="w-full bg-blue-50 text-blue-700 border border-blue-200 py-3 rounded-lg text-center font-bold text-xs flex items-center justify-center gap-2 animate-pulse">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Paiement en cours de validation...
                        </div>


                        @else
                        <!-- SINON : Choix entre Payer ou Docs -->

                        <!-- REMPLACE JUSTE CETTE PARTIE DANS LA BOUCLE -->
                        @if($isProfileComplete)
                        <!-- Nouveau bouton qui ouvre la Modale -->
                        <button wire:click="openPaymentModal({{ $booking->id }})"
                            class="w-full sm:w-auto bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-2.5 px-6 rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2 text-xs">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            Payer maintenant
                        </button>
                        @else
                        <!-- Bouton Documents (Reste inchangé) -->
                        <a href="{{ route('user.documents') }}" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-orange-500 hover:bg-orange-600 text-white text-xs font-bold py-2.5 px-6 rounded-xl border-b-4 border-orange-700 active:border-b-0 active:translate-y-1 transition-all animate-pulse shadow-orange-200 shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Documents requis
                        </a>
                        @endif

                        @endif
                    </div>

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

    <!-- ================= MODALE DE PAIEMENT ================= -->
    @if($showPaymentModal && $selectedBooking)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/70 backdrop-blur-sm p-4 transition-opacity">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative animate-fade-in-up">

            <!-- Close Button -->
            <button wire:click="closeModal" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 bg-gray-100 p-2 rounded-full transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            <div class="p-6 md:p-8">
                <h2 class="text-2xl font-black text-slate-900 text-center mb-1">Caisse de paiement</h2>
                <p class="text-center text-gray-500 text-sm mb-6">Commande #{{ str_pad($selectedBooking->id, 5, '0', STR_PAD_LEFT) }} • {{ number_format($selectedBooking->total_price, 0, ',', ' ') }} FCFA</p>

                <!-- Tabs Méthodes -->
                <div class="grid grid-cols-3 gap-2 mb-6 p-1 bg-gray-100 rounded-xl">
                    <button wire:click="$set('paymentMethod', 'tmoney')" class="py-2 text-xs font-bold rounded-lg transition {{ $paymentMethod == 'tmoney' ? 'bg-yellow-400 text-black shadow-md' : 'text-gray-500 hover:text-gray-700' }}">T-Money</button>
                    <button wire:click="$set('paymentMethod', 'flooz')" class="py-2 text-xs font-bold rounded-lg transition {{ $paymentMethod == 'flooz' ? 'bg-blue-800 text-white shadow-md' : 'text-gray-500 hover:text-gray-700' }}">Flooz</button>
                    <button wire:click="$set('paymentMethod', 'card')" class="py-2 text-xs font-bold rounded-lg transition {{ $paymentMethod == 'card' ? 'bg-slate-900 text-white shadow-md' : 'text-gray-500 hover:text-gray-700' }}">Carte</button>
                </div>

                <!-- CONTENU DYNAMIQUE SELON MÉTHODE -->

                <!-- Onglets Méthodes -->


                <!-- 1. T-MONEY (TOGOCOM) -->
                @if($paymentMethod == 'tmoney')
                <div class="text-center space-y-5 animate-fade-in-up">
                    <div class="bg-yellow-50 border border-dashed border-yellow-300 p-5 rounded-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-2 opacity-10"><svg class="w-16 h-16 text-yellow-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05 1.18 1.91 2.53 1.91 1.29 0 2.13-.72 2.13-1.55 0-.8-.68-1.38-2.66-1.9-2.08-.54-3.37-1.68-3.37-3.2 0-1.72 1.44-2.88 3.14-3.16V5h2.67v1.95c1.61.34 2.89 1.42 2.99 3.12h-1.95c-.14-1.02-1.01-1.63-2.16-1.63-1.36 0-2.12.75-2.12 1.57 0 .91.81 1.42 2.76 1.91 2.05.51 3.27 1.58 3.27 3.14 0 1.76-1.52 3.03-3.25 3.32z" />
                            </svg></div>
                        <p class="text-xs text-yellow-700 uppercase font-bold mb-2">Envoyer via T-Money au</p>
                        <p class="text-3xl font-black tracking-widest text-yellow-600">90 00 00 00</p>
                        <p class="text-xs text-yellow-600 mt-2 font-medium">Nom : AutoDrive TG</p>
                    </div>

                    <form wire:submit.prevent="processMobilePayment" class="text-left space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">ID Transaction (SMS)</label>
                            <input type="text" wire:model="transaction_ref" placeholder="Ex: 235689745" class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-yellow-500 focus:border-yellow-500 text-sm font-bold">
                            @error('transaction_ref') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Preuve (Capture d'écran)</label>
                            <input type="file" wire:model="payment_proof" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-yellow-100 file:text-yellow-700 hover:file:bg-yellow-200 transition border border-gray-200 rounded-xl cursor-pointer" />
                            @error('payment_proof') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3.5 rounded-xl shadow-lg transition flex justify-center items-center gap-2 mt-4">
                            <span wire:loading.remove>Confirmer T-Money</span>
                            <span wire:loading>Envoi...</span>
                        </button>
                    </form>
                </div>
                @endif

                <!-- 2. FLOOZ (MOOV) -->
                @if($paymentMethod == 'flooz')
                <div class="text-center space-y-5 animate-fade-in-up">
                    <div class="bg-blue-50 border border-dashed border-blue-300 p-5 rounded-xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-2 opacity-10"><svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05 1.18 1.91 2.53 1.91 1.29 0 2.13-.72 2.13-1.55 0-.8-.68-1.38-2.66-1.9-2.08-.54-3.37-1.68-3.37-3.2 0-1.72 1.44-2.88 3.14-3.16V5h2.67v1.95c1.61.34 2.89 1.42 2.99 3.12h-1.95c-.14-1.02-1.01-1.63-2.16-1.63-1.36 0-2.12.75-2.12 1.57 0 .91.81 1.42 2.76 1.91 2.05.51 3.27 1.58 3.27 3.14 0 1.76-1.52 3.03-3.25 3.32z" />
                            </svg></div>
                        <p class="text-xs text-blue-700 uppercase font-bold mb-2">Envoyer via Flooz au</p>
                        <p class="text-3xl font-black tracking-widest text-blue-600">99 00 00 00</p> <!-- Numéro Différent -->
                        <p class="text-xs text-blue-600 mt-2 font-medium">Nom : AutoDrive TG</p>
                    </div>

                    <form wire:submit.prevent="processMobilePayment" class="text-left space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">ID Transaction (SMS)</label>
                            <input type="text" wire:model="transaction_ref" placeholder="Ex: M123456" class="w-full border-gray-200 bg-gray-50 rounded-xl focus:ring-blue-500 focus:border-blue-500 text-sm font-bold">
                            @error('transaction_ref') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Preuve (Capture d'écran)</label>
                            <input type="file" wire:model="payment_proof" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-100 file:text-blue-700 hover:file:bg-blue-200 transition border border-gray-200 rounded-xl cursor-pointer" />
                            @error('payment_proof') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg transition flex justify-center items-center gap-2 mt-4">
                            <span wire:loading.remove>Confirmer Flooz</span>
                            <span wire:loading>Envoi...</span>
                        </button>
                    </form>
                </div>
                @endif

                <!-- 3. CARTE BANCAIRE (Avec Upload Preuve) -->
                @if($paymentMethod == 'card')
                <div class="space-y-5 animate-fade-in-up">
                    <!-- Fausse Carte Visuelle -->
                    <div class="bg-gradient-to-br from-slate-800 to-black text-white p-6 rounded-2xl shadow-xl relative overflow-hidden h-48 flex flex-col justify-between">
                        <div class="absolute top-0 right-0 p-6 opacity-20"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2 10h20v2H2zm0-2h20V5H2zm0 11h20v-7H2zm0-16h20c1.105 0 2 .895 2 2v14c0 1.105-.895 2-2 2H2c-1.105 0-2-.895-2-2V5c0-1.105.895-2 2-2z" />
                            </svg></div>
                        <div class="flex justify-between items-start relative z-10">
                            <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 14a2 2 0 100-4 2 2 0 000 4zm-4-1a1 1 0 110-2 1 1 0 010 2zm10-1a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg> <!-- Puce -->
                            <span class="text-xs font-bold tracking-widest opacity-70">DEBIT</span>
                        </div>
                        <div class="relative z-10">
                            <p class="text-xl font-mono tracking-widest mb-1 shadow-black drop-shadow-md">
                                {{ $card_number ? chunk_split($card_number, 4, ' ') : '•••• •••• •••• ••••' }}
                            </p>
                        </div>
                        <div class="flex justify-between relative z-10">
                            <div>
                                <p class="text-[8px] text-slate-400 uppercase tracking-wider">Titulaire</p>
                                <p class="text-sm font-bold uppercase tracking-wide">{{ $card_name ?? 'NOM PRÉNOM' }}</p>
                            </div>
                            <div>
                                <p class="text-[8px] text-slate-400 uppercase tracking-wider">Exp</p>
                                <p class="text-sm font-bold">{{ $card_expiry ?? 'MM/AA' }}</p>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="processCardPayment" class="space-y-3">
                        <div>
                            <input type="text" wire:model.live="card_name" placeholder="Nom sur la carte" class="w-full border-gray-200 bg-gray-50 rounded-lg text-sm py-2.5 px-4 focus:ring-slate-800 focus:border-slate-800">
                            @error('card_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <input type="text" wire:model.live="card_number" placeholder="0000 0000 0000 0000" maxlength="16" class="w-full border-gray-200 bg-gray-50 rounded-lg text-sm py-2.5 px-4 font-mono focus:ring-slate-800 focus:border-slate-800">
                            @error('card_number') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="text" wire:model.live="card_expiry" placeholder="MM/AA" maxlength="5" class="w-full border-gray-200 bg-gray-50 rounded-lg text-sm py-2.5 px-4 text-center focus:ring-slate-800 focus:border-slate-800">
                            <input type="text" wire:model="card_cvc" placeholder="CVC" maxlength="3" class="w-full border-gray-200 bg-gray-50 rounded-lg text-sm py-2.5 px-4 text-center focus:ring-slate-800 focus:border-slate-800">
                        </div>
                        <!-- AJOUT : PREUVE POUR CARTE -->
                        <div class="pt-2 border-t border-gray-100">
                            <label class="block text-xs font-bold text-gray-700 mb-1.5 ml-1">Reçu de paiement (PDF/IMG)</label>
                            <input type="file" wire:model="payment_proof" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 transition border border-gray-200 rounded-xl cursor-pointer" />
                            @error('payment_proof') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full bg-slate-900 hover:bg-slate-800 text-white font-bold py-3.5 rounded-xl shadow-lg transition flex justify-center items-center gap-2 mt-2">
                            <span wire:loading.remove>Valider Paiement</span>
                            <span wire:loading>Traitement...</span>
                        </button>
                    </form>
                </div>
                @endif

            </div>
        </div>
    </div>
    @endif

</div>
