<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;

class ClientManager extends Component
{
    public function render()
    {
        // Liste tous les utilisateurs sauf les admins (si tu as un rôle admin)
        // Pour l'instant on liste tout le monde
        return view('livewire.admin.client-manager', [
            'users' => User::all()
        ]);
    }
}
