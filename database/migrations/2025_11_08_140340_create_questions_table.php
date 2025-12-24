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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->integer('section_index')->default(0); // Index de la section dans le contenu du cours
            $table->enum('type', ['vrai_faux', 'choix_multiple', 'texte_libre', 'image', 'numerique'])->default('vrai_faux');
            $table->text('question'); // Texte de la question
            $table->json('options')->nullable(); // Pour les choix multiples : [{"texte": "Option 1", "correcte": true}, ...]
            $table->string('image')->nullable(); // Chemin vers l'image si type = 'image'
            $table->text('reponse_correcte')->nullable(); // Pour texte_libre et numerique
            $table->integer('ordre')->default(0); // Pour le drag & drop
            $table->integer('points')->default(1); // Points attribués pour cette question
            $table->text('explication')->nullable(); // Explication de la réponse
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['cours_id', 'section_index']);
            $table->index('ordre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
