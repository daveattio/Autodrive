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
        Schema::table('users', function (Blueprint $table) {
            // Type de client
            $table->string('client_type')->default('particulier'); // particulier, entreprise, touriste

            // Infos communes
            $table->text('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();

            // Spécifique Particulier / Touriste
            $table->text('license_number')->nullable(); // N° Permis

            // Spécifique Touriste
            $table->text('passport_number')->nullable();
            $table->text('origin_country')->nullable();

            // Spécifique Entreprise
            $table->text('company_name')->nullable();
            $table->text('company_id')->nullable(); // NIF ou RCCM
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
