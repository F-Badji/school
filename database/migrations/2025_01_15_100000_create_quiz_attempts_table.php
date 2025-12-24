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
        Schema::create('quiz_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cours_id')->constrained('cours')->onDelete('cascade');
            $table->integer('section_index')->default(0);
            $table->integer('attempt_number')->default(1); // Numéro de la tentative (1 ou 2)
            $table->integer('score')->nullable(); // Score obtenu
            $table->integer('total_questions')->nullable();
            $table->json('answers')->nullable(); // Réponses de l'étudiant
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'cours_id', 'section_index']);
            $table->unique(['user_id', 'cours_id', 'section_index', 'attempt_number'], 'unique_quiz_attempt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz_attempts');
    }
};










