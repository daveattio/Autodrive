<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;

class VehicleCatalog extends Component
{
    public function render()
    {
        // On récupère toutes les voitures (plus tard on ajoutera les filtres ici)
        $vehicles = Vehicle::all();

        return view('livewire.front.vehicle-catalog', [
            'vehicles' => $vehicles
        ]);
    }
}