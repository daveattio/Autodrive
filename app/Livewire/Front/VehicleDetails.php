<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\Booking;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

class VehicleDetails extends Component
{
    public $vehicle;
    public $startDate, $endDate;
    public $totalPrice = 0;
    public $originalPrice = 0;
    public $activePromo = null;

    // --- NOUVELLES VARIABLES CLIENT ---
    public $client_type = 'particulier'; // par défaut
    public $phone, $address, $city;
    public $license_number; // Pour Particulier
    public $passport_number, $origin_country; // Pour Touriste
    public $company_name, $company_id; // Pour Entreprise

    public function mount($id)
    {
        $this->vehicle = Vehicle::findOrFail($id);
        $currentVehicleId = $this->vehicle->id;

        // Récupération Promo (Ton code existant...)
        $this->activePromo = Promotion::where('is_active', true)
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function($query) use ($currentVehicleId) {
                $query->where('vehicle_id', $currentVehicleId)->orWhereNull('vehicle_id');
            })->orderBy('discount_percent', 'desc')->first();

        $this->calculatePrice();

        // PRÉ-REMPLISSAGE DES INFOS SI DÉJÀ CONNECTÉ
        if (Auth::check()) {
            $user = Auth::user();
            $this->client_type = $user->client_type ?? 'particulier';
            $this->phone = $user->phone;
            $this->address = $user->address;
            $this->city = $user->city;
            $this->license_number = $user->license_number;
            $this->passport_number = $user->passport_number;
            $this->origin_country = $user->origin_country;
            $this->company_name = $user->company_name;
            $this->company_id = $user->company_id;
        }
    }
    // Ajoute cette fonction dans ta classe VehicleDetails

public function setClientType($type)
{
    $this->client_type = $type;

    // 1. On efface les erreurs rouges
    $this->resetValidation();

    // 2. On vide MANUELLEMENT les variables spécifiques
    $this->license_number = '';
    $this->passport_number = '';
    $this->origin_country = '';
    $this->company_name = '';
    $this->company_id = '';

    // Astuce : Parfois Livewire a besoin de ça pour rafraîchir les inputs
    $this->dispatch('client-type-changed');
}

    public function updated($fields) { $this->calculatePrice(); }

    public function calculatePrice() {
        // ... (Garde ta logique de calcul de prix actuelle) ...
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
            } else { $this->totalPrice = 0; }
        }
    }

    public function bookVehicle()
    {
        if (!Auth::check()) { return redirect()->route('login'); }

        // 1. Validation de base (Dates)
        $rules = [
            'startDate' => 'required|date|after_or_equal:today',
            'endDate'   => 'required|date|after_or_equal:startDate',
            'phone'     => 'required|min:8',
            'address'   => 'required',
            'city'      => 'required',
        ];

        // 2. Validation Dynamique selon le type de client
        if ($this->client_type === 'particulier') {
            $rules['license_number'] = 'required';
        } elseif ($this->client_type === 'entreprise') {
            $rules['company_name'] = 'required';
            $rules['company_id'] = 'required'; // NIF
        } elseif ($this->client_type === 'touriste') {
            $rules['passport_number'] = 'required';
            $rules['origin_country'] = 'required';
            $rules['license_number'] = 'required'; // Touriste a aussi besoin d'un permis
        }

        $this->validate($rules);

        // 3. Vérification Disponibilité (Ton code existant...)
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
            $this->addError('startDate', 'Véhicule indisponible.');
            return;
        }

        // 4. MISE À JOUR DES INFOS USER (Sauvegarde les données légales)
        Auth::user()->update([
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

        session()->flash('message', 'Réservation réussie !');
        return redirect()->route('user.bookings');
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.vehicle-details');
    }
}
