<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithFileUploads;

class VehicleManager extends Component
{
    use WithFileUploads;

    public $vehicles;

    // Tous les champs nécessaires
    public $name, $brand, $type, $daily_price, $transmission, $description, $image;

    // Pour gérer l'édition
    public $vehicleIdToEdit = null;
    public $isEditMode = false;
    public $oldImage = null; // Pour afficher l'image existante en modif

    public function mount()
    {
        $this->refreshVehicles();
    }

    public function refreshVehicles()
    {
        $this->vehicles = Vehicle::latest()->get();
    }

    // Validation des données
    protected $rules = [
        'brand' => 'required|min:2',
        'name' => 'required',
        'type' => 'required', // On oblige l'admin à choisir
        'transmission' => 'required', // On oblige l'admin à choisir
        'daily_price' => 'required|numeric|min:1000',
        'description' => 'required|min:10', // Description obligatoire
        'image' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function editVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $this->vehicleIdToEdit = $vehicle->id;
            $this->name = $vehicle->name;
            $this->brand = $vehicle->brand;
            $this->type = $vehicle->type;
            $this->daily_price = $vehicle->daily_price;
            $this->transmission = $vehicle->transmission;
            $this->description = $vehicle->description;
            $this->oldImage = $vehicle->image; // On garde l'ancienne image en mémoire
            $this->isEditMode = true;
        }
    }

    public function saveVehicle()
    {
        $this->validate();

        if ($this->isEditMode) {
            // MODE MODIFICATION
            $vehicle = Vehicle::find($this->vehicleIdToEdit);

            $data = [
                'name' => $this->name,
                'brand' => $this->brand,
                'type' => $this->type,
                'transmission' => $this->transmission,
                'daily_price' => $this->daily_price,
                'description' => $this->description,
            ];

            // Si une nouvelle image est uploadée, on remplace l'ancienne
            if ($this->image) {
                $data['image'] = $this->image->store('vehicles', 'public');
            }

            $vehicle->update($data);
            session()->flash('message', 'Véhicule modifié avec succès !');
        } else {
            // MODE CRÉATION
            // Ici, plus de valeurs par défaut ! On prend ce qu'il y a dans le formulaire.
            $imagePath = $this->image ? $this->image->store('vehicles', 'public') : null;

            Vehicle::create([
                'name' => $this->name,
                'brand' => $this->brand,
                'type' => $this->type,
                'transmission' => $this->transmission,
                'daily_price' => $this->daily_price,
                'description' => $this->description,
                'image' => $imagePath,
                'is_available' => true
            ]);
            session()->flash('message', 'Véhicule ajouté avec succès !');
        }

        $this->cancelEdit(); // Réinitialiser le formulaire
        $this->refreshVehicles();
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'brand', 'type', 'daily_price', 'transmission', 'description', 'image', 'vehicleIdToEdit', 'isEditMode', 'oldImage']);
    }

    public function deleteVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $vehicle->delete();
            $this->refreshVehicles();
            session()->flash('message', 'Véhicule supprimé.');
        }
    }

    public function render()
    {
        return view('livewire.admin.vehicle-manager');
    }
}
