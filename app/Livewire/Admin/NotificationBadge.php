<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Booking;

class NotificationBadge extends Component
{
    public $count = 0;

    public function render()
    {
        // On compte les réservations en attente
        $this->count = Booking::where('status', 'en_attente')->count();

        return view('livewire.admin.notification-badge');
    }
}
