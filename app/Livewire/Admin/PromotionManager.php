<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Promotion;
use Livewire\WithFileUploads;
use App\Models\Vehicle; // Import du modèle Vehicle

class PromotionManager extends Component
{
    use WithFileUploads;

    //IMPORTANT : On déclare la variable pour la liste
    public $vehicle_id;
    public $vehicles_list;
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
        $this->vehicles_list = Vehicle::all(); // Charger la liste des véhicules
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
            $this->vehicle_id = $promo->vehicle_id; // Charger le vehicle_id existant
        }
    }

    // 2. SAUVEGARDER (Création OU Modification)
    public function savePromo()
    {
        // 1. Validation (Note que j'utilise discount_percent ici aussi)
        $this->validate([
            'title' => 'required',
            'discount_percent' => 'required|integer|min:1|max:100', // Correspond à ta BDD
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048',
            'vehicle_id' => 'nullable|exists:vehicles,id', // On valide que le véhicule existe
        ]);

        // 2. Préparation des données
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'discount_percent' => $this->discount_percent, // Ton nouveau nom de colonne
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            // C'EST ICI QUE ÇA BLOQUAIT :
            // Si la liste est sur "Aucun" (vide), on met NULL. Sinon on met l'ID.
            'vehicle_id' => $this->vehicle_id === "" ? null : $this->vehicle_id,
        ];

        // 3. Gestion Image
        if ($this->image) {
            $data['image'] = $this->image->store('promos', 'public');
        }

        // 4. Sauvegarde
        if ($this->isEditMode) {
            $promo = Promotion::find($this->promoIdToEdit);
            $promo->update($data);
            session()->flash('message', 'Promotion modifiée !');
        } else {
            Promotion::create($data);
            session()->flash('message', 'Promotion créée !');
        }

        $this->cancelEdit();
        $this->refreshPromos();
    }

    // 3. ANNULER / RESET
    public function cancelEdit()
    {
        $this->reset(['title', 'description', 'discount_percent', 'start_date', 'end_date', 'image', 'promoIdToEdit', 'isEditMode', 'oldImage', 'vehicle_id']);
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
