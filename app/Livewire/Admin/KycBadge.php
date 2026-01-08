<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class KycBadge extends Component
{
    public $count = 0;

    public function render()
    {
        // On compte ceux qui ont envoyé le permis mais ne sont pas encore validés
        $this->count = User::whereNotNull('license_path')
                           ->whereNull('kyc_verified_at')
                           ->where('role', 'client')
                           ->count();

        return view('livewire.admin.kyc-badge');
    }
}
