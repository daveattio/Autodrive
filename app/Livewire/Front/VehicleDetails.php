<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VehicleDetails extends Component
{
    public $vehicle;
    
    // Variables pour le formulaire
    public $startDate;
    public $endDate;
    public $totalPrice = 0;

    public function mount($id)
    {
        $this->vehicle = Vehicle::findOrFail($id);
    }

    // Cette fonction se lance automatiquement à chaque fois que les dates changent
    public function updated($propertyName)
    {
        // On ne calcule que si les deux dates sont remplies
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);

            if ($end->gte($start)) {
                // Différence en jours (minimum 1 jour)
                $days = $start->diffInDays($end) + 1; 
                $this->totalPrice = $days * $this->vehicle->daily_price;
            } else {
                $this->totalPrice = 0;
            }
        }
    }

    public function bookVehicle()
    {
        // 1. Vérifier si l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Validation des données
        $this->validate([
            'startDate' => 'required|date|after_or_equal:today',
            'endDate'   => 'required|date|after_or_equal:startDate',
        ]);

        // 3. Création de la réservation
        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $this->vehicle->id,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'total_price' => $this->totalPrice,
            'status' => 'en_attente'
        ]);

        // 4. Redirection ou message de succès
        session()->flash('message', 'Réservation effectuée avec succès !');
        return redirect()->route('dashboard'); // Ou une page "Mes réservations"
    }

    public function render()
    {
        return view('livewire.front.vehicle-details');
    }
}