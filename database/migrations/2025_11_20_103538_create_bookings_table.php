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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        // Relie la réservation à un utilisateur (le client)
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        // Relie la réservation à un véhicule
        $table->foreignId('vehicle_id')->constrained()->onDelete('cascade'); 
        
        $table->date('start_date'); // Date début
        $table->date('end_date');   // Date fin
        $table->decimal('total_price', 10, 2); // Prix total calculé
        $table->string('status')->default('en_attente'); // en_attente, confirmée, terminée, annulée
        
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
