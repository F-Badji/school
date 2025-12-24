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
        Schema::table('devoirs', function (Blueprint $table) {
            // Renommer date_limite en date_devoir
            $table->renameColumn('date_limite', 'date_devoir');
            
            // Ajouter les champs heure_debut et heure_fin
            $table->time('heure_debut')->nullable()->after('date_devoir');
            $table->time('heure_fin')->nullable()->after('heure_debut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('devoirs', function (Blueprint $table) {
            // Supprimer les champs heure_debut et heure_fin
            $table->dropColumn(['heure_debut', 'heure_fin']);
            
            // Renommer date_devoir en date_limite
            $table->renameColumn('date_devoir', 'date_limite');
        });
    }
};
