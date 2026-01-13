<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;

class VehicleManager extends Component
{
    use WithFileUploads;

    // Champs Formulaire
    public $brand, $name, $type, $transmission, $daily_price, $description, $image;

    // États
    public $search = '';
    public $showEditModal = false;
    public $vehicleIdToEdit = null;
    public $oldImage = null; // L'image déjà en base
    public $iteration = 1;   // Astuce pour reset le champ file

    // Validation
    protected $rules = [
        'brand' => 'required|min:2',
        'name' => 'required',
        'type' => 'required',
        'transmission' => 'required',
        'daily_price' => 'required|numeric|min:1',
        'description' => 'required|min:10',
        'image' => 'nullable|image|max:4096', // 4MB Max
    ];

    public function updatedSearch() { $this->resetPage(); }

    // --- 1. CRÉATION ---
    public function saveVehicle()
    {
        $this->validate();

        $data = [
            'brand' => $this->brand,
            'name' => $this->name,
            'type' => $this->type,
            'transmission' => $this->transmission,
            'daily_price' => $this->daily_price,
            'description' => $this->description,
            'is_available' => true,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('vehicles', 'public');
        }

        Vehicle::create($data);

        session()->flash('message', 'Véhicule ajouté au parc avec succès !');
        $this->resetInputFields();
    }

    // --- 2. PRÉPARATION ÉDITION ---
    public function editVehicle($id)
    {
        $v = Vehicle::find($id);
        if ($v) {
            $this->vehicleIdToEdit = $v->id;
            $this->brand = $v->brand;
            $this->name = $v->name;
            $this->type = $v->type;
            $this->transmission = $v->transmission;
            $this->daily_price = $v->daily_price;
            $this->description = $v->description;
            $this->oldImage = $v->image; // On garde l'ancienne image pour l'affichage

            $this->showEditModal = true; // Ouverture Modale
            $this->resetValidation();
        }
    }

    // --- 3. MISE À JOUR ---
    public function updateVehicle()
    {
        $this->validate();

        $v = Vehicle::find($this->vehicleIdToEdit);

        $data = [
            'brand' => $this->brand,
            'name' => $this->name,
            'type' => $this->type,
            'transmission' => $this->transmission,
            'daily_price' => $this->daily_price,
            'description' => $this->description,
        ];

        // Si une nouvelle image est chargée
        if ($this->image) {
            // On supprime l'ancienne du disque pour ne pas encombrer
            if($v->image) Storage::disk('public')->delete($v->image);
            $data['image'] = $this->image->store('vehicles', 'public');
        }

        $v->update($data);

        session()->flash('message', 'Fiche véhicule mise à jour.');
        $this->closeModal();
    }

    // --- 4. SUPPRESSION ---
    public function deleteVehicle($id)
    {
        $v = Vehicle::find($id);
        if ($v) {
            if($v->image) Storage::disk('public')->delete($v->image);
            $v->delete();
            session()->flash('message', 'Véhicule retiré du parc.');
        }
    }

    // --- UTILITAIRES ---
    public function closeModal()
    {
        $this->showEditModal = false;
        $this->resetInputFields();
    }

    public function resetInputFields()
    {
        $this->reset(['brand', 'name', 'type', 'transmission', 'daily_price', 'description', 'image', 'vehicleIdToEdit', 'oldImage']);
        $this->iteration++; // Force le champ file à se vider visuellement
    }

    public function render()
    {
        $query = Vehicle::query();
        if ($this->search) {
            $query->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('brand', 'like', '%'.$this->search.'%');
        }

        return view('livewire.admin.vehicle-manager', [
            'vehicles' => $query->latest()->paginate(10) // 10 cartes par page
        ]);
    }
}
