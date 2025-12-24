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
        Schema::create('examen_reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained('examens')->onDelete('cascade');
            $table->foreignId('examen_question_id')->constrained('examen_questions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('reponse')->nullable(); // Réponse de l'apprenant
            $table->json('reponses_multiple')->nullable(); // Pour les choix multiples
            $table->timestamp('soumis_le')->default(now());
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['examen_id', 'user_id']);
            $table->index(['examen_question_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_reponses');
    }
};
