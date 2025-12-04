<?php

namespace App\Observers;

use App\Models\Vehicle;
use App\Services\SecurityLogger;
use Illuminate\Support\Facades\Auth;

class VehicleObserver
{
    /**
     * Handle the Vehicle "updated" event.
     */
    public function updated(Vehicle $vehicle)
    {
        // 1. SURVEILLANCE DU PRIX (Critique pour le business)
        if ($vehicle->isDirty('daily_price')) {
            $oldPrice = $vehicle->getOriginal('daily_price');
            $newPrice = $vehicle->daily_price;

            SecurityLogger::record(
                'CHANGEMENT_PRIX',
                "Véhicule {$vehicle->brand} {$vehicle->name}",
                "Prix modifié : $oldPrice -> $newPrice FCFA"
            );
        }

        // 2. On ignore les descriptions et les photos (Bruit inutile)
    }

    /**
     * Handle the Vehicle "deleted" event.
     */
    public function deleted(Vehicle $vehicle)
    {
        SecurityLogger::record(
            'SUPPRESSION_VEHICULE',
            "Véhicule {$vehicle->brand} {$vehicle->name} (ID: {$vehicle->id})",
            "⚠️ Véhicule supprimé définitivement de la flotte par " . (Auth::user()->name ?? 'Inconnu')
        );
    }
}
