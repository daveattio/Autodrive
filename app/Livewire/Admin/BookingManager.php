<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;
use Livewire\WithPagination; // 1. Pour la pagination

class BookingManager extends Component
{
    use WithPagination;

    // 2. Variables de filtres
    public $search = '';
    public $statusFilter = '';
    public $paymentFilter = '';

    // Remettre à la page 1 quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }
    public function updatedPaymentFilter() { $this->resetPage(); }

    public function updateStatus($bookingId, $status)
    {
        $booking = Booking::find($bookingId);

        if($booking) {
            // Sécurité paiement (comme vu précédemment)
            if ($status === 'annulée' && $booking->payment_status === 'payé') {
                session()->flash('warning', 'Attention : Cette réservation était payée. Remboursement manuel requis.');
            }

            $booking->status = $status;
            $booking->save();

            if (!session()->has('warning')) {
                session()->flash('message', 'Statut mis à jour.');
            }
        }
    }

    public function render()
    {
        // 3. Construction de la requête intelligente
        $query = Booking::with(['user', 'vehicle']);

        // Filtre Recherche (Nom client, Email, ou Marque voiture)
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

        // Filtre Statut
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filtre Paiement
        if ($this->paymentFilter) {
            $query->where('payment_status', $this->paymentFilter);
        }

        return view('livewire.admin.booking-manager', [
            'bookings' => $query->latest()->paginate(10) // 10 par page
        ]);
    }
}
