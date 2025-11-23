<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\Attributes\Layout; // <--- IMPORTANT : On importe l'attribut Layout
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class UserBookings extends Component
{
    // Fonction de simulation de paiement
    public function payBooking($bookingId)
    {
        $booking = Booking::where('id', $bookingId)
            ->where('user_id', Auth::id())
            ->first();

        if ($booking) {
            $booking->payment_status = 'payé';
            $booking->save();
            session()->flash('message', 'Paiement validé (Simulation) !');
        }
    }

    // C'EST ICI LA SOLUTION MAGIQUE :
    // On met l'attribut juste au-dessus de la fonction render
    #[Layout('layouts.front')] 
    public function render()
    {
        return view('livewire.front.user-bookings', [
            'bookings' => Booking::with('vehicle')
                ->where('user_id', Auth::id())
                ->latest()
                ->get(),
        ]);
        // Plus besoin de ->layout() à la fin, l'attribut au-dessus s'en charge !
    }
}