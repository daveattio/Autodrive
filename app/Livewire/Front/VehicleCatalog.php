<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

class VehicleCatalog extends Component
{
    use WithPagination;

    // Variables de filtres
    public $search = '';
    public $type = '';
    public $transmission = ''; // <--- NOUVEAU
    public $maxPrice = 200000; // Augmenté un peu par défaut

    // Remet à la page 1 quand on change un filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedType() { $this->resetPage(); }
    public function updatedTransmission() { $this->resetPage(); } // <--- NOUVEAU
    public function updatedMaxPrice() { $this->resetPage(); }

    #[Layout('layouts.front')]
    public function render()
    {
        $query = Vehicle::query();

        // 1. Recherche (Marque ou Modèle)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('brand', 'like', '%'.$this->search.'%');
            });
        }

        // 2. Filtre Type (SUV, Berline...)
        if ($this->type) {
            $query->where('type', $this->type);
        }

        // 3. Filtre Transmission (Manuelle/Auto) <--- NOUVEAU
        if ($this->transmission) {
            $query->where('transmission', $this->transmission);
        }

        // 4. Filtre Prix
        if ($this->maxPrice) {
            $query->where('daily_price', '<=', $this->maxPrice);
        }

        // On ne montre que les véhicules disponibles par défaut (Optionnel)
        $query->where('is_available', true);

        return view('livewire.front.vehicle-catalog', [
            'vehicles' => $query->latest()->paginate(6),
            // On récupère les catégories uniques pour le menu déroulant
            'types' => Vehicle::select('type')->distinct()->pluck('type'),
        ]);
    }

    // Ajoute ceci dans ta classe VehicleCatalog
    public function resetFilters()
    {
        $this->reset(['search', 'type', 'transmission']);
        $this->maxPrice = 300000; // Remet le prix au maximum du slider
        $this->resetPage(); // Revient à la page 1
    }
}
