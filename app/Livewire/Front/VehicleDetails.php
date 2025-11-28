<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;
use App\Models\Promotion; // Import du modèle
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class VehicleDetails extends Component
{
    public $vehicle;

    // Variables pour le formulaire
    public $startDate;
    public $endDate;
    public $totalPrice = 0;
    public $originalPrice = 0; // Prix sans réduction
    public $activePromo = null; // La promo active

    public function mount($id)
    {
        // 1. On charge le véhicule
        $this->vehicle = Vehicle::findOrFail($id);

        // 2. On sécurise l'ID dans une variable locale pour la requête
        $currentVehicleId = $this->vehicle->id;

        // 3. RECHERCHE INTELLIGENTE DE PROMO
        $this->activePromo = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->where(function ($query) use ($currentVehicleId) { // <--- ICI : On utilise "use" pour passer la variable
                // Soit la promo est liée spécifiquement à ce véhicule
                $query->where('vehicle_id', $currentVehicleId);
            })
            ->orderBy('discount_percent', 'desc') // On prend la plus grosse réduction
            ->first();

        // 4. Initialisation du calcul
        $this->calculatePrice();
    }
    // Cette fonction se lance automatiquement à chaque fois que les dates changent
    public function updated($propertyName)
    {
        $this->calculatePrice();
    }
    public function calculatePrice()
    {
        // On ne calcule que si les deux dates sont remplies
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);

            if ($end->gte($start)) {
                // Différence en jours (minimum 1 jour)
                $days = $start->diffInDays($end) + 1;
                $this->totalPrice = $days * $this->vehicle->daily_price;
                // 1. Calcul du prix normal
                $this->originalPrice = $days * $this->vehicle->daily_price;

                // 2. Application de la réduction si promo active
                if ($this->activePromo) {
                    $discountAmount = $this->originalPrice * ($this->activePromo->discount_percent / 100);
                    $this->totalPrice = $this->originalPrice - $discountAmount;
                } else {
                    $this->totalPrice = $this->originalPrice;
                }
            } else {
                $this->totalPrice = 0;
                $this->originalPrice = 0;
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
        // 3. VÉRIFICATION DISPONIBILITÉ (Le point critique)
        // On cherche s'il existe UNE réservation qui chevauche tes dates
        $isBooked = Booking::where('vehicle_id', $this->vehicle->id)
            ->where('status', '!=', 'annulée') // On ignore les annulées
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<', $this->startDate)
                            ->where('end_date', '>', $this->endDate);
                    });
            })
            ->exists();

        if ($isBooked) {
            // Si c'est pris, on envoie une erreur et ON ARRÊTE TOUT
            $this->addError('startDate', 'Désolé, ce véhicule est déjà réservé sur cette période.');
            return;
        }

        // 4. Création
        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $this->vehicle->id,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'total_price' => $this->totalPrice,
            'status' => 'en_attente',
            'payment_status' => 'impayé'
        ]);

        session()->flash('message', 'Réservation envoyée !');
        return redirect()->route('user.bookings');
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.vehicle-details');
    }
}
