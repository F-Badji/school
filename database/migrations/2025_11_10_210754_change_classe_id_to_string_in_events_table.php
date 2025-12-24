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
        Schema::table('events', function (Blueprint $table) {
            // Changer classe_id de unsignedBigInteger à string
            $table->string('classe_id', 50)->nullable()->change();
            
            // Modifier le type enum pour supprimer "Session"
            // Note: Laravel ne supporte pas directement la modification d'enum, 
            // donc on doit le faire manuellement via DB::statement si nécessaire
            // Pour l'instant, on laisse le type tel quel car la validation se fait dans le contrôleur
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            // Revenir à unsignedBigInteger
            $table->unsignedBigInteger('classe_id')->nullable()->change();
        });
    }
};