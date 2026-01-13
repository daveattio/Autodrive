<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Maintenance;
use App\Models\Vehicle;
use Livewire\WithPagination;

class MaintenanceManager extends Component
{
    use WithPagination;

    // Champs
    public $vehicle_id, $type, $start_date, $end_date, $cost, $description;

    // Filtres
    public $search = '';
    public $filterType = '';

    // Modal
    public $showEditModal = false;
    public $maintenanceIdToEdit = null;

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterType() { $this->resetPage(); }

    public function saveMaintenance()
    {
        $this->validateData();
        Maintenance::create($this->getData());
        session()->flash('message', 'Maintenance enregistrée. Véhicule bloqué.');
        $this->resetForm();
    }

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
            $this->showEditModal = true;
        }
    }

    public function updateMaintenance()
    {
        $this->validateData();
        Maintenance::find($this->maintenanceIdToEdit)->update($this->getData());
        session()->flash('message', 'Fiche maintenance mise à jour.');
        $this->closeModal();
    }

    public function deleteMaintenance($id)
    {
        Maintenance::find($id)->delete();
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->resetForm();
    }

    private function resetForm() {
        $this->reset(['vehicle_id', 'type', 'start_date', 'end_date', 'cost', 'description', 'maintenanceIdToEdit']);
    }

    private function validateData() {
        $this->validate([
            'vehicle_id' => 'required',
            'type' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'cost' => 'required|numeric|min:0',
        ]);
    }

    private function getData() {
        return [
            'vehicle_id' => $this->vehicle_id, 'type' => $this->type,
            'start_date' => $this->start_date, 'end_date' => $this->end_date,
            'cost' => $this->cost, 'description' => $this->description,
        ];
    }

    public function render()
    {
        $query = Maintenance::with('vehicle');
        if ($this->search) {
            $query->whereHas('vehicle', function($q) {
                $q->where('name', 'like', '%'.$this->search.'%')->orWhere('brand', 'like', '%'.$this->search.'%');
            });
        }
        if ($this->filterType) $query->where('type', $this->filterType);

        return view('livewire.admin.maintenance-manager', [
            'maintenances' => $query->latest()->paginate(10), // 10 cartes par page
            'vehicles' => Vehicle::all()
        ]);
    }
}
