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
        Schema::create('devoir_reponses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devoir_id')->constrained('devoirs')->onDelete('cascade');
            $table->foreignId('devoir_question_id')->constrained('devoir_questions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('reponse')->nullable(); // Réponse de l'apprenant
            $table->json('reponses_multiple')->nullable(); // Pour les choix multiples
            $table->timestamp('soumis_le')->default(now());
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['devoir_id', 'user_id']);
            $table->index(['devoir_question_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoir_reponses');
    }
};
