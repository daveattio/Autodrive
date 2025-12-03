<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('audit_logs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained(); // Qui ? (Null si invité)
        $table->string('action');       // Quoi ? (ex: "update_booking")
        $table->string('target');       // Sur quoi ? (ex: "Booking #15")
        $table->text('details')->nullable(); // Détails (ex: "Statut changé de En attente à Confirmée")
        $table->string('ip_address');   // D'où ? (IP)
        $table->string('user_agent');   // Avec quoi ? (Navigateur/OS)
        $table->timestamps(); // Quand ?
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
