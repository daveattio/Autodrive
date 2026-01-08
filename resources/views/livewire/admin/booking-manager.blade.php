<div class="p-6 bg-gray-50 min-h-screen">

    <!-- HEADER & FILTRES -->
    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-200 mb-6">

        <!-- Ligne du haut : Titre + Export -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Pilotage des Réservations</h2>

            </div>

            <!-- BOUTON EXPORT (Logique conservée) -->
            <div>
                @if(count($selectedRows) > 0)
                <button wire:click="export('selection')"
                    class="flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Exporter ({{ count($selectedRows) }})
                </button>
                @else
                <button wire:click="export('all')"
                    class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Exporter
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
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
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
                <input type="date" wire:model.live="dateStart" class="w-full border-none bg-transparent text-xs p-2 focus:ring-0 text-black-900">
                <span class="text-gray-400">à</span>
                <input type="date" wire:model.live="dateEnd" class="w-full border-none bg-transparent text-xs p-2 focus:ring-0 text-black-900">
            </div>

            <!-- Bouton Reset -->
            <div class="md:col-span-1 text-right">
                @if($search || $statusFilter || $paymentFilter || $dateStart || $dateEnd)
                <button wire:click="resetFilters"
                    class="inline-flex items-center gap-1.5 text-red-600 hover:text-red-800 text-sm font-medium px-2.5 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 border border-red-200 transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300 shadow-sm"
                    title="Effacer tous les filtres"
                    aria-label="Réinitialiser tous les filtres">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Effacer
                </button>
                @endif
            </div>
        </div>
    </div>

    <!-- MESSAGES -->
    @if (session()->has('message'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('warning'))
    <div class="bg-orange-100 border-l-4 border-orange-500 text-orange-800 p-4 mb-6 rounded-r-lg shadow-sm flex items-center gap-3">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
        </svg>
        {{ session('warning') }}
    </div>
    @endif

    <!-- TABLEAU (DESIGN PREMIUM) -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                @php
                $headers = [
                ['key' => 'select', 'label' => '', 'align' => 'center', 'width' => 'w-12'],
                ['key' => 'client_reference', 'label' => 'Client / Référence', 'align' => 'left'],
                ['key' => 'vehicle', 'label' => 'Véhicule', 'align' => 'left'],
                ['key' => 'period', 'label' => 'Période', 'align' => 'left'],
                ['key' => 'amount', 'label' => 'Montant', 'align' => 'right'],
                ['key' => 'status', 'label' => 'État', 'align' => 'center'],
                ['key' => 'contract', 'label' => 'Contrat', 'align' => 'center'],
                ['key' => 'actions', 'label' => 'Action', 'align' => 'center'],
                ];
                @endphp

                <thead>
                    <tr class="bg-slate-50 border-b border-gray-200 hover:bg-slate-100 transition-colors duration-150">
                        @foreach ($headers as $header)
                        @if ($header['key'] === 'select')
                        <th scope="col" class="px-6 py-4 {{ $header['width'] ?? '' }} text-center">
                            <input
                                type="checkbox"
                                wire:model.live="selectAll"
                                class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-2"
                                aria-label="Tout sélectionner">
                        </th>
                        @else
                        <th scope="col" class="px-6 py-4 text-{{ $header['align'] }} text-xs font-bold uppercase tracking-wider text-gray-700">
                            {{ $header['label'] }}
                        </th>
                        @endif
                        @endforeach
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
                                        <span class="text-[12px] text-black-900 font-mono mt-0.5">ID: #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
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

                        <!-- Dates -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-semibold text-gray-800 bg-gray-100 px-2.5 py-1 rounded border border-gray-200">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->format('d/m') }}
                                    <svg class="w-3 h-3 text-gray-500 inline mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($booking->end_date)->format('d/m/y') }}
                                </span>
                                <span class="text-xs font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-200">
                                    {{ \Carbon\Carbon::parse($booking->start_date)->diffInDays(\Carbon\Carbon::parse($booking->end_date)) + 1 }}j
                                </span>
                            </div>
                        </td>

                        <!-- Montant (Align Right) -->
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <span class="text-lg font-black text-black-500 block">{{ number_format($booking->total_price, 0, ',', ' ') }}</span>
                            <span class="text-[12px] text-gray-500 uppercase">FCFA</span>
                        </td>

                        <!-- État (Statut + Paiement regroupés pour gagner de la place) -->
                        <td class="px-6 py-4 text-center align-top">
                            <div class="flex flex-col items-center gap-2">
                                <!-- Statut (badge plus visible) -->
                                @if($booking->status == 'en_attente')
                                <span class="px-3 py-1 rounded-lg text-sm font-semibold bg-yellow-50 text-yellow-800 border border-yellow-200 shadow-sm">
                                    En attente
                                </span>
                                @elseif($booking->status == 'confirmée')
                                <span class="px-3 py-1 rounded-lg text-sm font-semibold bg-green-50 text-green-800 border border-green-200 shadow-sm">
                                    Confirmée
                                </span>
                                @else
                                <span class="px-3 py-1 rounded-lg text-sm font-semibold bg-red-50 text-red-800 border border-red-200 shadow-sm">
                                    Annulée
                                </span>
                                @endif

                                <!-- Paiement -->
                                @if($booking->payment_status == 'payé')
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                PAYÉ
            </span>
        @elseif($booking->payment_status == 'en_attente_validation')
            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-100 text-blue-700 border border-blue-200 animate-pulse">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                VÉRIFICATION
            </span>
        @else
            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100">
                IMPAYÉ
            </span>
        @endif

        <!-- 2. ACTIONS DE PREUVE (Si une preuve existe) -->
        @if($booking->payment_proof_path)
            <div class="flex flex-col gap-1 w-full">

                <!-- A. Voir la preuve (Ouvre dans un nouvel onglet) -->
                <a href="{{ asset('storage/' . $booking->payment_proof_path) }}" target="_blank"
                   class="group flex items-center justify-center gap-1 text-[10px] font-bold text-gray-500 hover:text-blue-600 border border-gray-200 rounded px-2 py-1 bg-white hover:bg-blue-50 transition"
                   title="Voir le reçu">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    Voir Preuve
                </a>

                <!-- B. Bouton Valider (Seulement si pas encore payé) -->
                @if($booking->payment_status == 'en_attente_validation')
                    <button wire:click="validatePayment({{ $booking->id }})"
                            wire:confirm="Avez-vous bien vérifié la réception de l'argent ?"
                            class="flex items-center justify-center gap-1 text-[10px] font-bold text-white bg-blue-600 hover:bg-blue-700 rounded px-2 py-1 shadow-sm transition">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Confirmer Reçu
                    </button>
                @endif
            </div>
        @endif
                            </div>
                        </td>
                        <!-- Contrat -->
                        <td class="px-6 py-4 text-center">
                            @if($booking->status === 'confirmée')
                            <a href="{{ route('admin.contract', $booking->id) }}" target="_blank"
                                class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-indigo-50 text-indigo-700 hover:text-indigo-800 hover:bg-indigo-100 border border-indigo-200 transition-all hover:shadow-md relative"
                                title="Télécharger le contrat (PDF)"
                                aria-label="Télécharger le contrat en PDF">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <!-- Fichier PDF -->
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 02 2h12a2 2 0 0 02-2V8l-6-6z" fill="#f10915ff" />
                                    <path d="M14 2v6h6" fill="none" stroke="white" stroke-width="1.5" />
                                    <!-- Tampon "Contrat" -->
                                    <circle cx="17" cy="17" r="2.5" fill="white" />
                                    <text x="17" y="18" font-size="3" text-anchor="middle" fill="#6366f1" font-family="sans-serif" font-weight="bold">C</text>
                                </svg>
                            </a>
                            @else
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-50 text-gray-400 border border-gray-200"
                                title="Contrat indisponible">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" opacity="0.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 02 2h12a2 2 0 0 02-2V8l-6-6z" />
                                    <path d="M14 2v6h6" fill="none" stroke="#a0aec0" stroke-width="1.5" />
                                </svg>
                            </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="px-6 py-4 text-center">
                            @if($booking->status === 'en_attente')
                            <!-- État : En attente -->
                            <div class="flex flex-col items-center gap-3">
                                <span class="text-sm font-bold uppercase tracking-wide text-orange-700 animate-pulse bg-gradient-to-r from-orange-50 to-orange-100 px-3.5 py-2 rounded-full border border-orange-200 shadow-sm inline-flex items-center gap-1">
                                    À traiter
                                </span>
                                <div class="flex gap-2">
                                    <!-- Bouton Valider -->
                                    <button
                                        wire:click="updateStatus({{ $booking->id }}, 'confirmée')"
                                        class="p-2.5 rounded-lg bg-gradient-to-r from-green-100 to-green-50 text-green-700 hover:from-green-500 hover:to-green-600 hover:text-white border border-green-200 transition-all duration-200 hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-300"
                                        title="Valider la réservation"
                                        aria-label="Valider la réservation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </button>
                                    <!-- Bouton Refuser -->
                                    <button
                                        wire:click="updateStatus({{ $booking->id }}, 'annulée')"
                                        wire:confirm="Êtes-vous sûr de vouloir refuser cette réservation ?"
                                        class="p-2.5 rounded-lg bg-gradient-to-r from-red-100 to-red-50 text-red-700 hover:from-red-500 hover:to-red-600 hover:text-white border border-red-200 transition-all duration-200 hover:shadow-lg hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-300"
                                        title="Refuser la réservation"
                                        aria-label="Refuser la réservation">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            @elseif($booking->status === 'confirmée' && $booking->payment_status === 'payé')
                            <!-- État : Confirmée -->
                            <div class="text-center">
                                <span class="text-xs text-gray-500 font-medium block">Traitée le</span>
                                <span class="text-xs font-semibold text-gray-700 bg-gradient-to-r from-gray-50 to-gray-100 px-2.5 py-1 rounded-full border border-gray-200 shadow-sm">
                                    {{ $booking->updated_at->format('d/m/Y') }}
                                </span>
                            </div>
                            @elseif($booking->status === 'annulée' && $booking->payment_status === 'impayé')
                            <!-- État : Annulée -->
                            <span class="text-xs font-bold text-red-600 bg-gradient-to-r from-red-50 to-red-100 px-3 py-1.5 rounded-full border border-red-200 shadow-sm">
                                Refusée
                            </span>
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
