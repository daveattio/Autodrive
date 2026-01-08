<?php

namespace App\Livewire\Front;

use Livewire\Component;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads; // Pour l'upload de la preuve
use Livewire\Attributes\Layout;

class UserBookings extends Component
{
    use WithFileUploads;

    public $bookings;
    public $isProfileComplete = false;
    public $hasAnyBooking = false;

    // Gestion de la Modale Paiement
    public $showPaymentModal = false;
    public $selectedBooking = null;
    public $paymentMethod = 'tmoney'; // 'tmoney', 'flooz', 'card'

    // Formulaire Mobile Money
    public $transaction_ref;
    public $payment_proof;

    // Formulaire Carte (Fictif pour la simulation)
    public $card_number, $card_expiry, $card_cvc, $card_name;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->bookings = Booking::with('vehicle')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        $this->hasAnyBooking = $this->bookings->count() > 0;

        // Vérif KYC
        $user = Auth::user();
        $this->isProfileComplete =
            !empty($user->license_path) &&
            ($user->client_type !== 'touriste' || !empty($user->passport_path)) &&
            ($user->client_type !== 'entreprise' || !empty($user->company_doc_path)) &&
            $user->kyc_verified_at !== null; // L'admin doit avoir validé
    }

    // Ouvrir la modale
    public function openPaymentModal($bookingId)
    {
        $this->selectedBooking = Booking::find($bookingId);
        $this->showPaymentModal = true;
        $this->reset(['transaction_ref', 'payment_proof', 'card_number', 'card_expiry', 'card_cvc', 'card_name']);
    }

    // Traitement Paiement Mobile (Preuve à valider par Admin)
    public function processMobilePayment()
    {
        $this->validate([
            'transaction_ref' => 'required|min:5',
            'payment_proof' => 'required|image|max:4096', // 4MB Max
        ]);

        $path = $this->payment_proof->store('payments/proofs', 'public');

        $this->selectedBooking->update([
            'payment_method' => $this->paymentMethod,
            'transaction_ref' => $this->transaction_ref,
            'payment_proof_path' => $path,
            'payment_status' => 'en_attente_validation', // <--- L'admin devra valider
            'paid_at' => now(),
        ]);

        $this->closeModal();
        session()->flash('message', 'Preuve envoyée ! Paiement en cours de validation par l\'agence.');
    }

    // Traitement Paiement Carte (Simulation immédiate)
    // Traitement Paiement Carte (Mise à jour)
    public function processCardPayment()
    {
        $this->validate([
            'card_name' => 'required',
            'card_number' => 'required|min:16',
            'card_expiry' => 'required',
            'card_cvc' => 'required|min:3',
            // On ajoute la preuve ici aussi (Reçu de la banque ou du TPE)
            'payment_proof' => 'required|image|max:4096',
        ]);

        $path = $this->payment_proof->store('payments/proofs', 'public');

        $this->selectedBooking->update([
            'payment_method' => 'carte_bancaire',
            // On masque le numéro de carte pour la sécu (ne garder que les 4 derniers)
            'transaction_ref' => 'CB-****-' . substr($this->card_number, -4),
            'payment_proof_path' => $path,
            'payment_status' => 'en_attente_validation', // <--- CHANGEMENT IMPORTANT
            'paid_at' => now(),
        ]);

        $this->closeModal();
        session()->flash('message', 'Paiement carte enregistré ! En attente de validation par l\'agence.');
    }
    public function closeModal()
    {
        $this->showPaymentModal = false;
        $this->selectedBooking = null;
        $this->refreshData();
    }

    #[Layout('layouts.front')]
    public function render()
    {
        return view('livewire.front.user-bookings');
    }
}
