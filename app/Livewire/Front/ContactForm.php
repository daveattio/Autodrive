<?php

namespace App\Livewire\Front;

use Livewire\Component;

class ContactForm extends Component
{
    public $name;
    public $email;
    public $message;

    // Règles de validation (pour éviter les champs vides)
    protected $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email',
        'message' => 'required|min:10',
    ];

    public function submitMessage()
    {
        // 1. Vérifie si tout est correct
        $this->validate();

        // 2. Simulation de l'envoi (Ici, tu pourrais envoyer un vrai mail ou sauver en BDD)
        // Pour l'examen, un message flash suffit souvent, sauf si on t'a demandé de stocker les messages.

        session()->flash('success', 'Merci ! Votre message a bien été envoyé. Nous vous répondrons sous 24h.');

        // 3. On vide le formulaire
        $this->reset();
    }

    public function render()
    {
        return view('livewire.front.contact-form');
    }
}
