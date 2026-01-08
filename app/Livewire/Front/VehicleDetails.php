<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Promotion;
use App\Models\User; // Don't forget to import the User model
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Carbon\CarbonPeriod;
use App\Models\Maintenance;

class VehicleDetails extends Component
{
    public $vehicle;
    public $startDate;
    public $endDate;
    public $totalPrice = 0;
    public $originalPrice = 0;
    public $activePromo = null;

    // Infos Client
    public $client_type = 'particulier';
    public $phone, $address, $city;
    public $license_number;
    public $passport_number, $origin_country;
    public $company_name, $company_id;

    public $profileLocked = false; // Nouvelle variable
    public $bookedDates = []; // Liste des dates indisponibles
    public function mount($id)
    {
        $this->vehicle = Vehicle::findOrFail($id);
        $currentVehicleId = $this->vehicle->id;

        // Recherche Promo
        $this->activePromo = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function ($query) use ($currentVehicleId) {
                $query->where('vehicle_id', $currentVehicleId)
                    ->orWhereNull('vehicle_id');
            })
            ->orderBy('discount_percent', 'desc')
            ->first();

        // Pré-remplissage si connecté
        if (Auth::check()) {
            $user = Auth::user();
            $this->phone = $user->phone;
            $this->address = $user->address;
            $this->city = $user->city;

            // VÉRIFICATION : Est-ce que ce client a déjà commandé chez nous ?
            $hasHistory = Booking::where('user_id', $user->id)->exists();

            if ($hasHistory) {
                $this->client_type = $user->client_type;
                $this->profileLocked = true; // ON VERROUILLE

                // On charge les infos spécifiques
                $this->license_number = $user->license_number;
                $this->passport_number = $user->passport_number;
                $this->origin_country = $user->origin_country;
                $this->company_name = $user->company_name;
                $this->company_id = $user->company_id;
            } else {
                // NON : C'est un nouveau (ou n'a jamais commandé)
                $this->profileLocked = false; // On laisse le choix LIBRE
                $this->client_type = 'particulier'; // On met particulier par défaut, mais il peut changer
            }
        }
        // --- CALCUL DES DATES INDISPONIBLES (Pour le calendrier visuel) ---
        $bookings = Booking::where('vehicle_id', $this->vehicle->id)
            ->where('status', '!=', 'annulée')
            ->whereDate('end_date', '>=', now()) // On ne regarde que le futur
            ->get();

        foreach ($bookings as $booking) {
            // On prend chaque jour entre le début et la fin de la résa
            $period = \Carbon\CarbonPeriod::create($booking->start_date, $booking->end_date);
            foreach ($period as $date) {
                // On l'ajoute à la liste noire au format Y-m-d (Compatible MySQL)
                $this->bookedDates[] = $date->format('Y-m-d');
            }
        }
        // 2. Les Maintenances (NOUVEAU)
        // Assure-toi d'importer le modèle en haut : use App\Models\Maintenance;
        $maintenances = \App\Models\Maintenance::where('vehicle_id', $this->vehicle->id)
            ->whereDate('end_date', '>=', now())
            ->get();

        foreach ($maintenances as $maintenance) {
            $period = \Carbon\CarbonPeriod::create($maintenance->start_date, $maintenance->end_date);
            foreach ($period as $date) {
                $this->bookedDates[] = $date->format('Y-m-d');
            }
        }
    }

    public function setClientType($type)
    {
        $this->client_type = $type;
        $this->resetValidation();

        // Vide les champs spécifiques
        $this->reset(['license_number', 'passport_number', 'origin_country', 'company_name', 'company_id']);
    }

    public function updated($fields)
    {
        $this->calculatePrice();
    }

    public function calculatePrice()
    {
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);

            if ($end->gte($start)) {
                $days = $start->diffInDays($end) + 1;
                $this->originalPrice = $days * $this->vehicle->daily_price;

                if ($this->activePromo) {
                    $discount = $this->originalPrice * ($this->activePromo->discount_percent / 100);
                    $this->totalPrice = $this->originalPrice - $discount;
                } else {
                    $this->totalPrice = $this->originalPrice;
                }
            } else {
                $this->totalPrice = 0;
            }
        }
    }

    // Limite : 3 tentatives en 2 minutes

    public function bookVehicle()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 1. Règles de base
        $rules = [
            'startDate' => 'required|date|after_or_equal:today',
            'endDate'   => 'required|date|after_or_equal:startDate',
            'phone'     => 'required|min:8',
            'address'   => 'required',
            'city'      => 'required',
        ];

        // 2. Règles DYNAMIQUES
        if ($this->client_type === 'particulier') {
            $rules['license_number'] = 'required';
        } elseif ($this->client_type === 'entreprise') {
            $rules['company_name'] = 'required';
            $rules['company_id'] = 'required';
        } elseif ($this->client_type === 'touriste') {
            $rules['passport_number'] = 'required';
            $rules['origin_country'] = 'required';
            $rules['license_number'] = 'required';
        }

        $this->validate($rules);

        // 3. Vérif Disponibilité
        $isBooked = Booking::where('vehicle_id', $this->vehicle->id)
            ->where('status', '!=', 'annulée')
            ->where(function ($query) {
                $query->whereBetween('start_date', [$this->startDate, $this->endDate])
                    ->orWhereBetween('end_date', [$this->startDate, $this->endDate])
                    ->orWhere(function ($q) {
                        $q->where('start_date', '<', $this->startDate)
                            ->where('end_date', '>', $this->endDate);
                    });
            })->exists();

        if ($isBooked) {
            $this->addError('startDate', 'Véhicule déjà réservé à ces dates.');
            return;
        }

        // 4. Sauvegarde des infos utilisateur (CORRECTION HERE)
        // Explicitly fetch the User model to ensure Eloquent methods work
        $user = User::find(Auth::id());

        if ($user) {
            $user->update([
                'client_type' => $this->client_type,
                'phone' => $this->phone,
                'address' => $this->address,
                'city' => $this->city,
                'license_number' => $this->license_number,
                'passport_number' => $this->passport_number,
                'origin_country' => $this->origin_country,
                'company_name' => $this->company_name,
                'company_id' => $this->company_id,
            ]);
        }

        // 5. Création Réservation
        Booking::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $this->vehicle->id,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'total_price' => $this->totalPrice,
            'status' => 'en_attente',
            'payment_status' => 'impayé'
        ]);

        session()->flash('message', 'Réservation envoyée avec succès !');
        return redirect()->route('user.bookings');
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.vehicle-details');
    }
}
