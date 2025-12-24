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
        Schema::create('apprenant_cours_statut', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->string('matiere_nom');
            $table->enum('statut', ['en_cours', 'termine', 'enregistre'])->default('en_cours');
            $table->timestamps();
            
            // S'assurer qu'un apprenant ne peut avoir qu'un seul statut par formateur/matière
            $table->unique(['user_id', 'formateur_id', 'matiere_nom'], 'apprenant_cours_statut_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apprenant_cours_statut');
    }
};
