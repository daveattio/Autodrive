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
        // 1. Le Permis (Obligatoire pour louer, donc on le prévoit pour tous)
        $table->string('license_path')->nullable();

        // 2. Le Passeport / CNI (Pour Touristes ou Particuliers)
        $table->string('passport_path')->nullable();

        // 3. Document Officiel (Pour Entreprises - ex: Registre commerce)
        $table->string('company_doc_path')->nullable();
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
