<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            // Méthode choisie : 'tmoney', 'flooz', 'carte', 'virement'
           // 1. On vérifie si 'payment_method' n'existe PAS avant de l'ajouter
        if (!Schema::hasColumn('bookings', 'payment_method')) {
            $table->string('payment_method')->nullable();
        }

            // Référence de la transaction (ex: ID T-Money ou N° Carte masqué)
            $table->string('transaction_ref')->nullable();

            // PREUVE (Image uploadée par le client pour T-Money/Flooz)
            $table->string('payment_proof_path')->nullable();

            // Date du paiement déclaré
            $table->dateTime('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'transaction_ref', 'payment_proof_path', 'paid_at']);
        });
    }
};
