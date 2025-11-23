<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;

class BookingManager extends Component
{
   public function updateStatus($bookingId, $status)
{
    $booking = Booking::find($bookingId);
    
    if($booking) {
        // Règle de gestion : Si l'admin veut annuler une réservation payée
        if ($status === 'annulée' && $booking->payment_status === 'payé') {
            // Ici, dans un vrai projet, on déclencherait un remboursement Stripe.
            // Pour ton TP, on va juste changer le statut mais on ajoute un message spécifique.
            session()->flash('warning', 'Attention : Cette réservation était payée. Vous devez rembourser le client manuellement.');
        }

        $booking->status = $status;
        $booking->save();
        
        // Message de succès standard si pas de warning
        if (!session()->has('warning')) {
            session()->flash('message', 'Statut mis à jour avec succès.');
        }
    }
}

    public function render()
    {
        // On récupère les réservations du plus récent au plus ancien
        // with('user', 'vehicle') permet d'éviter de faire trop de requêtes SQL
        return view('livewire.admin.booking-manager', [
            'bookings' => Booking::with(['user', 'vehicle'])->latest()->get()
        ]);
    }
}