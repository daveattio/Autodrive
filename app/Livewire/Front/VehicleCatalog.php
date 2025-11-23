<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithPagination; // Pour avoir plusieurs pages si beaucoup de voitures

class VehicleCatalog extends Component
{
    use WithPagination;

    // Variables de filtres (reliées aux inputs du HTML)
    public $search = '';
    public $type = '';
    public $brand = '';
    public $maxPrice = 100000; // Prix max par défaut

    // Remet à la page 1 quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedType() { $this->resetPage(); }

    public function render()
    {
        // On construit la requête petit à petit
        $query = Vehicle::query();

        // Filtre par recherche (Nom ou Marque)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('brand', 'like', '%'.$this->search.'%');
            });
        }

        // Filtre par Type (SUV, Economique...)
        if ($this->type) {
            $query->where('type', $this->type);
        }

        // Filtre par Prix Max
        if ($this->maxPrice) {
            $query->where('daily_price', '<=', $this->maxPrice);
        }

        // On récupère les résultats (6 par page)
        return view('livewire.front.vehicle-catalog', [
            'vehicles' => $query->paginate(6),
            // On envoie aussi la liste des types uniques pour le menu déroulant
            'types' => Vehicle::select('type')->distinct()->get()
        ]);
    }
}