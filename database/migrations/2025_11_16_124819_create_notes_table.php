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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('matricule');
            $table->string('nom');
            $table->string('prenom');
            $table->date('annee_naissance')->nullable();
            $table->string('classe');
            $table->string('semestre')->nullable();
            $table->string('coefficient')->nullable();
            $table->decimal('devoir', 5, 2)->default(0);
            $table->decimal('examen', 5, 2)->default(0);
            $table->decimal('quiz', 5, 2)->default(0);
            $table->decimal('moyenne', 5, 2)->default(0);
            $table->boolean('redoubler')->default(false);
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('matricule');
            $table->index(['nom', 'prenom']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
