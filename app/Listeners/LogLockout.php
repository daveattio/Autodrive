<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Lockout;
use App\Services\SecurityLogger;
use Illuminate\Support\Facades\Request;

class LogLockout
{
    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
        $request = $event->request;
        $email = null;

        // --- STRATÉGIE 1 : Scanner le texte brut avec une Regex ---
        try {
            // On prend tout le contenu brut de la requête (JSON, Form data, tout)
            $rawContent = $request->getContent();

            // Expression régulière pour trouver un email dans un texte en vrac
            // Elle cherche : truc + @ + truc + . + truc
            $pattern = '/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/';

            if (preg_match($pattern, $rawContent, $matches)) {
                // $matches[0] contient le premier email trouvé dans le paquet
                $email = $matches[0];
            }
        } catch (\Exception $e) {
            // Silence en cas d'erreur de parsing
        }

        // --- STRATÉGIE 2 : La méthode classique (Filet de sécurité) ---
        if (!$email) {
            // On regarde dans les endroits habituels de Breeze/Livewire
            $email = $request->input('email')
                  ?? $request->input('form.email')
                  ?? $request->input('username')
                  ?? $request->input('login');
        }

        // --- RÉSULTAT ---
        $finalEmail = $email ?: 'Non identifié';

        SecurityLogger::record(
            'ALERTE_BRUTE_FORCE',
            "Compte visé : $finalEmail",
            "🚨 Rate Limiting activé. IP: " . $request->ip()
        );
    }
}
