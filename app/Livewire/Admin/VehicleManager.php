<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle; // On importe le modèle Vehicle
use Livewire\WithFileUploads; // Nécessaire pour uploader des images

class VehicleManager extends Component
{
    use WithFileUploads;

    // Ici, on définit les variables qui seront liées au formulaire
    public $name, $brand, $type, $daily_price, $transmission, $description, $image;

    // Cette fonction s'exécute quand on clique sur "Enregistrer"
    public function saveVehicle()
    {
        // 1. On valide que les champs sont bien remplis
        $this->validate([
            'name' => 'required',
            'brand' => 'required',
            'daily_price' => 'required|numeric',
            'image' => 'image|max:1024', // Max 1MB
        ]);

        // 2. On gère l'image si elle existe
        $imagePath = null;
        if ($this->image) {
            $imagePath = $this->image->store('vehicles', 'public');
        }

        // 3. On crée la voiture dans la base de données
        Vehicle::create([
            'name' => $this->name,
            'brand' => $this->brand,
            'type' => $this->type ?? 'Economique', // Valeur par défaut si vide
            'transmission' => $this->transmission ?? 'Manuelle',
            'daily_price' => $this->daily_price,
            'description' => $this->description,
            'image' => $imagePath,
        ]);

        // 4. Petit message de succès et on vide le formulaire
        session()->flash('message', 'Voiture ajoutée avec succès !');
        $this->reset();
    }

    public function render()
    {
        // On retourne la vue, et on lui envoie la liste des voitures existantes (pour les voir en bas du formulaire)
        return view('livewire.admin.vehicle-manager', [
            'vehicles' => Vehicle::all()
        ]);
    }
}