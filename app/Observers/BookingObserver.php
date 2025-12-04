<?php

namespace App\Observers;

use App\Models\Booking;
use App\Services\SecurityLogger; // On utilise ton service
use Illuminate\Support\Facades\Auth;

class BookingObserver
{
    /**
     * Handle the Booking "updated" event.
     * Se déclenche à chaque modification.
     */
   public function updated(Booking $booking)
{
    // 1. SURVEILLANCE DU STATUT (Validation/Annulation)
    if ($booking->isDirty('status')) {
        $newStatus = $booking->status;
        $paiement = $booking->payment_status;

        // ANOMALIE 1 : L'admin valide alors que ce n'est pas payé (RISQUE)
        if ($newStatus === 'confirmée' && $paiement !== 'payé') {
            SecurityLogger::record(
                'ALERTE_SECURITE',
                "Réservation #{$booking->id}",
                "⚠️ Validation forcée d'une commande IMPAYÉE par " . (Auth::user()->name ?? 'Système')
            );
        }

        // ANOMALIE 2 : L'admin annule alors que c'est déjà payé (REMBOURSEMENT)
        elseif ($newStatus === 'annulée' && $paiement === 'payé') {
            SecurityLogger::record(
                'ALERTE_FINANCIERE',
                "Réservation #{$booking->id}",
                "⚠️ Annulation d'une commande PAYÉE. Vérifier le remboursement."
            );
        }

        // ICI, J'AI SUPPRIMÉ LE "ELSE".
        // Si c'est une validation normale (Payé + Confirmé), on ne logue RIEN. Silence radio.
    }

    // 2. SURVEILLANCE DU PAIEMENT (Argent)
    if ($booking->isDirty('payment_status')) {
        $oldPay = $booking->getOriginal('payment_status');
        $newPay = $booking->payment_status;

        // On garde juste l'encaissement (C'est bon à savoir pour la compta)
        if ($newPay === 'payé') {
            SecurityLogger::record(
                'PAIEMENT_RECU',
                "Réservation #{$booking->id}",
                "💰 Paiement encaissé : {$booking->total_price} FCFA"
            );
        }
        // Si quelqu'un remet en "impayé", c'est louche -> On logue
        else {
            SecurityLogger::record(
                'ALTERATION_PAIEMENT',
                "Réservation #{$booking->id}",
                "⚠️ Statut paiement modifié suspect : $oldPay -> $newPay"
            );
        }
    }
}

    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking)
    {
        // On logue juste la création, c'est standard
        // SecurityLogger::record('NOUVELLE_RESERVATION', "Réservation #{$booking->id}", "Créée par le client");
    }
    /**
     * Handle the Booking "deleted" event.
     * Se déclenche quand une réservation est supprimée via Laravel.
     */
    public function deleted(Booking $booking)
    {
        // On récupère qui a fait l'action (si c'est via le site)
        $actor = Auth::user() ? Auth::user()->name : 'Système/Console';

        SecurityLogger::record(
            'SUPPRESSION_CRITIQUE',
            "Réservation #{$booking->id}",
            "🚨 Réservation supprimée définitivement par $actor. (Client: {$booking->user->name}, Montant: {$booking->total_price})"
        );
    }
}
