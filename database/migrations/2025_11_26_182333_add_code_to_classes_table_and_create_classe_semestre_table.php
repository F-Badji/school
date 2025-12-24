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
        // Ajouter la colonne code à la table classes
        Schema::table('classes', function (Blueprint $table) {
            $table->string('code', 50)->nullable()->after('id');
        });
        
        // Créer la table classe_semestre pour gérer les semestres de chaque classe
        Schema::create('classe_semestre', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->integer('semestre')->comment('Numéro du semestre (1-10)');
            $table->boolean('actif')->default(true);
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['classe_id', 'semestre']);
            $table->unique(['classe_id', 'semestre']); // Un semestre ne peut être qu'une fois par classe
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_semestre');
        
        Schema::table('classes', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
