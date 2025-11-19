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
    Schema::create('vehicles', function (Blueprint $table) {
        $table->id();
        $table->string('name');             // La colonne qui manquait
        $table->string('brand');
        $table->string('type');
        $table->string('transmission');
        // CORRECTION DU PRIX ICI : (12, 2) permet d'aller jusqu'à 9 milliards. C'est large.
        $table->decimal('daily_price', 12, 2); 
        $table->text('description')->nullable();
        $table->string('image')->nullable();
        $table->boolean('is_available')->default(true);
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
