<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url; // N'oublie pas l'import

class VehicleCatalog extends Component
{
    use WithPagination;

    // Filtres
    #[Url]
    public $search = '';
    #[Url]
    public $type = '';
    public $transmission = '';
    public $maxPrice = 300000;

    // Nouveaux Filtres Dates
    public $dateStart = '';
    public $dateEnd = '';

    // Gestion de l'affichage des filtres avancés
    public $showAdvancedFilters = false;

    // Reset pagination quand on filtre
    public function updatedSearch() { $this->resetPage(); }
    public function updatedType() { $this->resetPage(); }
    public function updatedTransmission() { $this->resetPage(); }
    public function updatedMaxPrice() { $this->resetPage(); }
    public function updatedDateStart() { $this->resetPage(); }
    public function updatedDateEnd() { $this->resetPage(); }

    // Fonction intelligente pour la transmission (Sélectionner / Désélectionner)
    public function toggleTransmission($value)
    {
        if ($this->transmission === $value) {
            $this->transmission = ''; // On désélectionne si c'est déjà actif
        } else {
            $this->transmission = $value;
        }
        $this->resetPage();
    }

    public function toggleAdvancedFilters()
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function resetFilters()
    {
        $this->reset(['search', 'type', 'transmission', 'dateStart', 'dateEnd']);
        $this->maxPrice = 300000;
        $this->resetPage();
    }

    #[Layout('layouts.front')]
    public function render()
    {
        $query = Vehicle::query();

        // 1. Recherche
        if ($this->search) {
            $query->where(function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('brand', 'like', '%'.$this->search.'%');
            });
        }

        // 2. Type
        if ($this->type) {
            $query->where('type', $this->type);
        }

        // 3. Transmission
        if ($this->transmission) {
            $query->where('transmission', $this->transmission);
        }

        // 4. Prix
        if ($this->maxPrice < 300000) {
            $query->where('daily_price', '<=', $this->maxPrice);
        }

        // 5. FILTRE DE DISPONIBILITÉ PAR DATE (Le plus important)
        if ($this->dateStart && $this->dateEnd) {
            $query->whereDoesntHave('bookings', function (Builder $q) {
                // On exclut les véhicules qui ont une réservation CHEVAUCHANT la période demandée
                // Et qui n'est pas annulée
                $q->where('status', '!=', 'annulée')
                  ->where(function ($sub) {
                      $sub->whereBetween('start_date', [$this->dateStart, $this->dateEnd])
                          ->orWhereBetween('end_date', [$this->dateStart, $this->dateEnd])
                          ->orWhere(function ($inner) {
                              $inner->where('start_date', '<', $this->dateStart)
                                    ->where('end_date', '>', $this->dateEnd);
                          });
                  });
            });
        }

        // Toujours afficher les véhicules disponibles (statut global)
        $query->where('is_available', true);

        return view('livewire.front.vehicle-catalog', [
            'vehicles' => $query->latest()->paginate(9), // 9 par page comme demandé
            'types' => Vehicle::select('type')->distinct()->pluck('type'),
        ]);
    }
}
