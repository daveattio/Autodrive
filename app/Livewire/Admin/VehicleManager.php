<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class VehicleManager extends Component
{
    use WithFileUploads;

    public $vehicles;

    // Champs du formulaire
    public $name, $brand, $type, $daily_price, $transmission, $description, $image;

    // État de l'édition
    public $vehicleIdToEdit = null;
    public $isEditMode = false;
    public $oldImage = null;

    public function mount() {
        $this->refreshVehicles();
    }

    public function refreshVehicles() {
        $this->vehicles = Vehicle::latest()->get();
    }

    // Règles de validation (Prix positif ajouté)
    protected $rules = [
        'brand' => 'required|min:2',
        'name' => 'required',
        'type' => 'required',
        'transmission' => 'required',
        'daily_price' => 'required|numeric|min:1', // <--- PRIX POSITIF OBLIGATOIRE
        'description' => 'required|min:10',
        'image' => 'nullable|image|max:2048', // Max 2MB
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
            $this->oldImage = $vehicle->image;
            $this->isEditMode = true;
        }
    }

    public function saveVehicle()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'brand' => $this->brand,
            'type' => $this->type,
            'transmission' => $this->transmission,
            'daily_price' => $this->daily_price,
            'description' => $this->description,
        ];

        // Gestion de l'image
        if ($this->image) {
            $data['image'] = $this->image->store('vehicles', 'public');
        }

        if ($this->isEditMode) {
            $vehicle = Vehicle::find($this->vehicleIdToEdit);
            $vehicle->update($data);
            session()->flash('message', 'Véhicule modifié avec succès !');
        } else {
            // Par défaut disponible
            $data['is_available'] = true;
            Vehicle::create($data);
            session()->flash('message', 'Nouveau véhicule ajouté au parc !');
        }

        $this->cancelEdit();
        $this->refreshVehicles();
    }

    public function deleteVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $vehicle->delete();
            $this->refreshVehicles();
            session()->flash('message', 'Véhicule retiré du parc.');
        }
    }

    public function cancelEdit() {
        $this->reset(['name', 'brand', 'type', 'daily_price', 'transmission', 'description', 'image', 'vehicleIdToEdit', 'isEditMode', 'oldImage']);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-manager');
    }
}
