<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination; // 1. Pour la pagination
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationConfirmed; // N'oublie pas l'import !
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Services\SecurityLogger; // N'oublie pas l'import

class BookingManager extends Component
{
    use WithPagination;

    // 2. Variables de filtres
    public $search = '';
    public $statusFilter = '';
    public $paymentFilter = '';

    // NOUVEAUX FILTRES & SÉLECTION
    public $dateStart = '';
    public $dateEnd = '';
    public $selectedRows = []; // Pour les cases à cocher
    public $selectAll = false; // Pour "Tout cocher"

    // Reset pagination quand on filtre
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedStatusFilter()
    {
        $this->resetPage();
    }
    public function updatedPaymentFilter()
    {
        $this->resetPage();
    }
    public function updatedDateStart()
    {
        $this->resetPage();
    }
    public function updatedDateEnd()
    {
        $this->resetPage();
    }

    // Gestion du "Tout cocher"
    // Gestion du "Tout cocher" de la page actuelle
    public function updatedSelectAll($value)
    {
        if ($value) {
            // On récupère uniquement les IDs de la page visible (10 éléments)
            // en respectant EXACTEMENT le même tri que l'affichage
            $this->selectedRows = $this->getVisibleBookingIds();
        } else {
            $this->selectedRows = [];
        }
    }

    // Helper pour récupérer les IDs de la page courante avec le tri complexe
    private function getVisibleBookingIds()
    {
        $query = Booking::with(['user', 'vehicle']);

        // 1. On réapplique les filtres (Copie de la méthode render)
        if ($this->search) {
             $query->where(function($q) {
                $q->whereHas('user', function($u) {
                    $u->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('email', 'like', '%'.$this->search.'%');
                })
                ->orWhereHas('vehicle', function($v) {
                    $v->where('name', 'like', '%'.$this->search.'%')
                      ->orWhere('brand', 'like', '%'.$this->search.'%');
                })
                ->orWhere('id', 'like', '%'.$this->search.'%');
            });
        }
        if ($this->statusFilter) $query->where('status', $this->statusFilter);
        if ($this->paymentFilter) $query->where('payment_status', $this->paymentFilter);
        if ($this->dateStart) $query->whereDate('created_at', '>=', $this->dateStart);
        if ($this->dateEnd) $query->whereDate('created_at', '<=', $this->dateEnd);

        // 2. On réapplique le TRI INTELLIGENT
        return $query
            ->orderByRaw("CASE
                WHEN status = 'en_attente' THEN 3
                WHEN payment_status = 'en_attente_validation' THEN 2
                ELSE 1 END DESC")
            ->orderBy('id', 'desc')
            ->paginate(10) // On pagine comme dans la vue
            ->pluck('id')  // On prend juste les ID
            ->map(fn($id) => (string) $id) // On convertit en string pour la checkbox
            ->toArray();
    }

    // EXPORT INTELLIGENT
    public function export($type = 'all')
    {
        // Nettoyage mémoire
        if (ob_get_length()) { ob_end_clean(); }

        if ($type === 'selection' && count($this->selectedRows) > 0) {
            // 1. Export de la sélection
            return Excel::download(new BookingsExport($this->selectedRows), 'selection_reservations.xlsx');
        } else {
            // 2. Export du filtrage actuel
            $filters = [
                'search' => $this->search,
                'status' => $this->statusFilter,
                'payment' => $this->paymentFilter,
                'date_start' => $this->dateStart,
                'date_end' => $this->dateEnd,
            ];
            return Excel::download(new BookingsExport(null, $filters), 'reservations_filtrees.xlsx');
        }
    }
    public function updateStatus($bookingId, $status): void
    {
        $booking = Booking::find($bookingId);

        if ($booking) {
            // Sécurité paiement (comme vu précédemment)
            if ($status === 'annulée' && $booking->payment_status === 'payé') {
                session()->flash('warning', 'Attention : Cette réservation était payée. Remboursement manuel requis.');
            }

            $booking->status = $status;
            $booking->save();

            if (!session()->has('warning')) {
                session()->flash('message', 'Statut mis à jour.');
            }

            if ($status === 'confirmée') {
                // On envoie le mail au client
                Mail::to($booking->user->email)->send(new ReservationConfirmed($booking));
                session()->flash('message', 'Statut mis à jour et Email de confirmation envoyé !');
            }
        }
    }

    public function render()
    {
        // 3. Construction de la requête intelligente
        $query = Booking::with(['user', 'vehicle']);

        // Filtre Recherche (Nom client, Email, ou Marque voiture)
        if ($this->search) {
            $query->where(function ($q) {
                $q->whereHas('user', function ($u) {
                    $u->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                })
                    ->orWhereHas('vehicle', function ($v) {
                        $v->where('name', 'like', '%' . $this->search . '%')
                            ->orWhere('brand', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('id', 'like', '%' . $this->search . '%');
            });
        }

        // Filtre Statut
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filtre Paiement
        if ($this->paymentFilter) {
            $query->where('payment_status', $this->paymentFilter);
        }

        // Filtres Dates (Nouveau)
        if ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart); // MAINTENANT
        }
        if ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);   // MAINTENANT
        }

       // TRI INTELLIGENT & INFALLIBLE
        $bookings = $query
            // 1. D'abord l'urgence (En attente ou Validation Paiement)
            ->orderByRaw("CASE
                WHEN status = 'en_attente' THEN 3
                WHEN payment_status = 'en_attente_validation' THEN 2
                ELSE 1 END DESC")

            // 2. ENSUITE PAR ID DÉCROISSANT (Le dernier créé est TOUJOURS en haut)
            ->orderBy('id', 'desc')

            ->paginate(10);

        return view('livewire.admin.booking-manager', [
            'bookings' => $bookings
        ]);
    }
    public function resetFilters()
    {
        $this->reset(['search', 'statusFilter', 'paymentFilter', 'dateStart', 'dateEnd']);
        $this->resetPage();
    }

    // Valider uniquement le paiement (après avoir vu la preuve)
    public function validatePayment($bookingId)
    {
        $booking = Booking::find($bookingId);
        if ($booking) {
            $booking->update(['payment_status' => 'payé']);
            session()->flash('message', 'Paiement validé avec succès !');
        }
    }
    // Helper pour récupérer les IDs de la page (pour le Select All)
   private function getCurrentPageIds()
    {
        // On réexécute la requête pour avoir les IDs (simplifié)
        // Note: Dans un vrai gros projet on optimiserait, mais ici c'est ok.
        return Booking::latest()->paginate(10)->pluck('id')->map(fn($id) => (string) $id)->toArray();
    }
}
