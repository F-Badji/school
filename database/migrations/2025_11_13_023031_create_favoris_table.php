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
        Schema::create('favoris', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->string('matiere_nom');
            $table->timestamps();
            
            // S'assurer qu'un utilisateur ne peut ajouter qu'une seule fois un formateur/matière en favoris
            $table->unique(['user_id', 'formateur_id', 'matiere_nom'], 'favoris_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favoris');
    }
};
