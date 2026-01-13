<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promotion;
use App\Models\Vehicle;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class PromotionManager extends Component
{
    use WithFileUploads;

    public $title, $description, $discount_percent, $start_date, $end_date, $image, $vehicle_id;
    public $showEditModal = false;
    public $promoIdToEdit = null;
    public $oldImage = null;
    public $iteration = 1;

    // Pour la prévisualisation intelligente
    public $selectedVehicleImage = null;

    protected $rules = [
        'title' => 'required',
        'discount_percent' => 'required|numeric|max:100',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'image' => 'nullable|image|max:2048',
        'vehicle_id' => 'nullable',
    ];

    // Magie : Quand on choisit un véhicule, on charge son image
    public function updatedVehicleId($value)
    {
        if($value) {
            $v = Vehicle::find($value);
            $this->selectedVehicleImage = $v ? $v->image : null;
        } else {
            $this->selectedVehicleImage = null;
        }
    }

    public function savePromo()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'discount_percent' => $this->discount_percent,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'vehicle_id' => $this->vehicle_id ?: null,
        ];

        if ($this->image) {
            $data['image'] = $this->image->store('promos', 'public');
        } elseif ($this->selectedVehicleImage) {
            // Optionnel : On pourrait copier l'image du véhicule si pas d'image promo spécifique
            // Mais ici on laisse null, le front gérera l'affichage
        }

        Promotion::create($data);
        session()->flash('message', 'Campagne lancée !');
        $this->resetFields();
    }

    public function editPromo($id)
    {
        $p = Promotion::find($id);
        if ($p) {
            $this->promoIdToEdit = $p->id;
            $this->title = $p->title;
            $this->description = $p->description;
            $this->discount_percent = $p->discount_percent;
            $this->start_date = $p->start_date->format('Y-m-d');
            $this->end_date = $p->end_date->format('Y-m-d');
            $this->vehicle_id = $p->vehicle_id;
            $this->oldImage = $p->image;

            // Si pas d'image promo mais véhicule lié, on montre l'image du véhicule
            if (!$p->image && $p->vehicle) {
                $this->selectedVehicleImage = $p->vehicle->image;
            }

            $this->showEditModal = true;
        }
    }

    public function updatePromo()
    {
        $this->validate();
        $p = Promotion::find($this->promoIdToEdit);

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'discount_percent' => $this->discount_percent,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'vehicle_id' => $this->vehicle_id ?: null,
        ];

        if ($this->image) {
            if($p->image) Storage::disk('public')->delete($p->image);
            $data['image'] = $this->image->store('promos', 'public');
        }

        $p->update($data);
        session()->flash('message', 'Campagne mise à jour.');
        $this->closeModal();
    }

    public function deletePromo($id)
    {
        $p = Promotion::find($id);
        if($p->image) Storage::disk('public')->delete($p->image);
        $p->delete();
    }

    public function closeModal()
    {
        $this->showEditModal = false;
        $this->resetFields();
    }

    public function resetFields()
    {
        $this->reset(['title', 'description', 'discount_percent', 'start_date', 'end_date', 'image', 'vehicle_id', 'promoIdToEdit', 'oldImage', 'selectedVehicleImage']);
        $this->iteration++;
    }

    public function render()
    {
        return view('livewire.admin.promotion-manager', [
            'promotions' => Promotion::with('vehicle')->latest()->paginate(10),
            'vehicles_list' => Vehicle::all()
        ]);
    }
}
