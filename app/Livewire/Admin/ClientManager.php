<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination;

class ClientManager extends Component
{
    use WithPagination;

    // Filtres
    public $search = '';
    public $dateStart = '';
    public $dateEnd = '';
    public $kycFilter = ''; // 'pending', 'verified', 'incomplete'
    public $typeFilter = ''; // 'particulier', 'entreprise', 'touriste'

    // Reset pagination
    public function updatedSearch() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }
    public function updatedKycFilter() { $this->resetPage(); }

    public function resetFilters()
    {
        $this->reset(['search', 'dateStart', 'dateEnd', 'kycFilter', 'typeFilter']);
        $this->resetPage();
    }

    // ACTIONS DE VALIDATION
    public function verifyUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['kyc_verified_at' => now()]);
            // On pourrait envoyer un mail ici pour dire "Compte validé"
            session()->flash('message', "Le dossier de {$user->name} est validé ! Paiement autorisé.");
        }
    }

    public function revokeUser($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->update(['kyc_verified_at' => null]);
            session()->flash('warning', "Le dossier de {$user->name} est invalidé. Paiement bloqué.");
        }
    }

    public function render()
    {
        $query = User::query()->where('role', 'client');

        // 1. Recherche (Nom, Email, Tel, Ville)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%')
                  ->orWhere('phone', 'like', '%'.$this->search.'%')
                  ->orWhere('city', 'like', '%'.$this->search.'%')
                  ->orWhere('company_name', 'like', '%'.$this->search.'%');
            });
        }

        // 2. Filtre Date Inscription
        if ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        }
        if ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        // 3. Filtre Type Client
        if ($this->typeFilter) {
            $query->where('client_type', $this->typeFilter);
        }

        // 4. Filtre État Dossier
        if ($this->kycFilter === 'pending') {
            $query->whereNotNull('license_path')->whereNull('kyc_verified_at');
        } elseif ($this->kycFilter === 'verified') {
            $query->whereNotNull('kyc_verified_at');
        } elseif ($this->kycFilter === 'incomplete') {
            $query->whereNull('license_path');
        }

        $users = $query->orderByRaw("CASE WHEN license_path IS NOT NULL AND kyc_verified_at IS NULL THEN 1 ELSE 0 END DESC")
                       ->orderBy('id', 'desc')
                       ->paginate(10);

        return view('livewire.admin.client-manager', [
            'users' => $users
        ]);
    }
}
