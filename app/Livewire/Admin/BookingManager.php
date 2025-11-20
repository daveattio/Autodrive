<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;

class BookingManager extends Component
{
    public function updateStatus($bookingId, $status)
    {
        // Permet de changer le statut : 'confirmée' ou 'annulée'
        $booking = Booking::find($bookingId);
        if($booking) {
            $booking->status = $status;
            $booking->save();
            session()->flash('message', 'Statut de la réservation mis à jour.');
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