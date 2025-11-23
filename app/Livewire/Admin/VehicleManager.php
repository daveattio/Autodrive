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
    // Variables du formulaire
    public $name, $brand, $type, $daily_price, $transmission, $description, $image;

    // Pour gérer le mode "Modification"
    public $vehicleIdToEdit = null;
    public $isEditMode = false;

    // Cette fonction remplace render() pour récupérer les véhicules
    public function mount()
    {
        $this->vehicles = Vehicle::all();
    }

    // Mettre à jour la liste après chaque action
    public function refreshVehicles()
    {
        $this->vehicles = Vehicle::all();
    }

    // 1. SUPPRIMER UN VÉHICULE
    public function deleteVehicle($id)
    {
        $vehicle = Vehicle::find($id);
        if ($vehicle) {
            $vehicle->delete();
            $this->refreshVehicles();
            session()->flash('message', 'Véhicule supprimé avec succès.');
        }
    }

    // 2. CHARGER LES INFOS POUR MODIFIER
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
            $this->isEditMode = true;
        }
    }

    // 3. SAUVEGARDER (Soit Création, Soit Modification)
    public function saveVehicle()
    {
        $this->validate([
            'name' => 'required',
            'brand' => 'required',
            'daily_price' => 'required|numeric',
        ]);

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

            if ($this->image) {
                $data['image'] = $this->image->store('vehicles', 'public');
            }

            $vehicle->update($data);
            session()->flash('message', 'Véhicule modifié !');
        } else {
            // MODE CRÉATION
            $imagePath = $this->image ? $this->image->store('vehicles', 'public') : null;

            Vehicle::create([
                'name' => $this->name,
                'brand' => $this->brand,
                'type' => $this->type ?? 'Economique',
                'transmission' => $this->transmission ?? 'Manuelle',
                'daily_price' => $this->daily_price,
                'description' => $this->description,
                'image' => $imagePath,
            ]);
            session()->flash('message', 'Véhicule créé !');
        }

        $this->reset(['name', 'brand', 'type', 'daily_price', 'transmission', 'description', 'image', 'vehicleIdToEdit', 'isEditMode']);
        $this->refreshVehicles();
    }

    public function cancelEdit()
    {
        $this->reset(['name', 'brand', 'type', 'daily_price', 'transmission', 'description', 'image', 'vehicleIdToEdit', 'isEditMode']);
    }

    public function render()
    {
        return view('livewire.admin.vehicle-manager');
    }
}
