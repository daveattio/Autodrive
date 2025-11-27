<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promotion;
use Livewire\WithFileUploads;

class PromotionManager extends Component
{
    use WithFileUploads;

    // Variables du formulaire
    public $title, $description, $discount_percent, $start_date, $end_date, $image;

    // Variables pour la gestion (Édition & Liste)
    public $promotions;
    public $promoIdToEdit = null;
    public $isEditMode = false;
    public $oldImage = null; // Pour afficher l'image existante en modif

    protected $rules = [
        'title' => 'required|min:3',
        'discount_percent' => 'required|integer|min:1|max:100', // Vérifie que c'est un entier
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'description' => 'required',
        'image' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function mount()
    {
        $this->refreshPromos();
    }

    public function refreshPromos()
    {
        $this->promotions = Promotion::latest()->get();
    }

    // 1. CHARGER LA PROMO POUR MODIFIER
    public function editPromo($id)
    {
        $promo = Promotion::find($id);
        if ($promo) {
            $this->promoIdToEdit = $promo->id;
            $this->title = $promo->title;
            $this->description = $promo->description;
            $this->discount_percent = $promo->discount_percent;
            $this->start_date = $promo->start_date; // Assure-toi que c'est au format Y-m-d
            $this->end_date = $promo->end_date;
            $this->oldImage = $promo->image;
            $this->isEditMode = true;
        }
    }

    // 2. SAUVEGARDER (Création OU Modification)
    public function savePromo()
    {
        $this->validate();

        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'discount_percent' => $this->discount_percent,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ];

        // Gestion de l'image
        if ($this->image) {
            $data['image'] = $this->image->store('promos', 'public');
        }

        if ($this->isEditMode) {
            // MODE MODIFICATION
            $promo = Promotion::find($this->promoIdToEdit);
            $promo->update($data);
            session()->flash('message', 'Promotion mise à jour avec succès !');
        } else {
            // MODE CRÉATION
            // On ajoute l'image seulement si elle existe (sinon null)
            if (!isset($data['image'])) {
                $data['image'] = null;
            }
            Promotion::create($data);
            session()->flash('message', 'Promotion créée avec succès !');
        }

        $this->cancelEdit();
        $this->refreshPromos();
    }

    // 3. ANNULER / RESET
    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'discount_percent', 'start_date', 'end_date', 'image', 'promoIdToEdit', 'isEditMode', 'oldImage']);
    }

    public function deletePromo($id)
    {
        Promotion::find($id)->delete();
        $this->refreshPromos();
        session()->flash('message', 'Promotion supprimée.');
    }

    public function render()
    {
        return view('livewire.admin.promotion-manager');
    }
}
