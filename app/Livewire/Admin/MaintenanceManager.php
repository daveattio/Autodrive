<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Livewire\WithPagination;

class MaintenanceManager extends Component
{
    use WithPagination;

    // Champs Formulaire
    public $vehicle_id, $type, $start_date, $end_date, $cost, $description;

    // Filtres
    public $search = '';
    public $filterType = '';

    // Mode Édition
    public $maintenanceIdToEdit = null;
    public $isEditMode = false;

    // Reset pagination lors de la recherche
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterType() { $this->resetPage(); }

    public function editMaintenance($id)
    {
        $m = Maintenance::find($id);
        if ($m) {
            $this->maintenanceIdToEdit = $m->id;
            $this->vehicle_id = $m->vehicle_id;
            $this->type = $m->type;
            $this->start_date = $m->start_date->format('Y-m-d');
            $this->end_date = $m->end_date->format('Y-m-d');
            $this->cost = $m->cost;
            $this->description = $m->description;
            $this->isEditMode = true;
        }
    }

    public function cancelEdit()
    {
        $this->reset(['vehicle_id', 'type', 'start_date', 'end_date', 'cost', 'description', 'maintenanceIdToEdit', 'isEditMode']);
    }

    public function saveMaintenance()
    {
        $this->validate([
            'vehicle_id' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cost' => 'required|numeric|min:0',
        ]);

        $data = [
            'vehicle_id' => $this->vehicle_id,
            'type' => $this->type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'cost' => $this->cost,
            'description' => $this->description,
        ];

        if ($this->isEditMode) {
            Maintenance::find($this->maintenanceIdToEdit)->update($data);
            session()->flash('message', 'Fiche maintenance mise à jour.');
        } else {
            Maintenance::create($data);
            session()->flash('message', 'Maintenance enregistrée. Véhicule bloqué.');
        }

        $this->cancelEdit();
    }

    public function deleteMaintenance($id)
    {
        Maintenance::find($id)->delete();
    }

    public function render()
    {
        $query = Maintenance::with('vehicle');

        // Filtrage
        if ($this->search) {
            $query->whereHas('vehicle', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('brand', 'like', '%'.$this->search.'%');
            });
        }

        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        return view('livewire.admin.maintenance-manager', [
            'maintenances' => $query->latest()->paginate(10),
            'vehicles' => Vehicle::all()
        ]);
    }
}
