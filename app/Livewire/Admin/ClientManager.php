<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Livewire\WithPagination; // Important pour la pagination

class ClientManager extends Component
{
    use WithPagination;

    // Variables de recherche
    public $search = '';
    public $dateStart = '';
    public $dateEnd = '';

    // Remettre à la page 1 quand on cherche
    public function updatedSearch() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }

    public function resetFilters()
{
    $this->reset(['search', 'dateStart', 'dateEnd']);
    $this->resetPage(); // Important : revenir à la page 1
}

    public function render()
    {
        $query = User::query();

        // 1. Recherche Globale (Nom, Email, Téléphone, Ville/Kara)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%')
                  ->orWhere('phone', 'like', '%'.$this->search.'%')
                  ->orWhere('city', 'like', '%'.$this->search.'%') // Recherche par ville
                  ->orWhere('id', 'like', '%'.$this->search.'%');
            });
        }

        // 2. Filtre par Date d'inscription
        if ($this->dateStart) {
            $query->whereDate('created_at', '>=', $this->dateStart);
        }
        if ($this->dateEnd) {
            $query->whereDate('created_at', '<=', $this->dateEnd);
        }

        // On trie par les plus récents
        $users = $query->latest()->paginate(10);

        return view('livewire.admin.client-manager', [
            'users' => $users
        ]);
    }
}
