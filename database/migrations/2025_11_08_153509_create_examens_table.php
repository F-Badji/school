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
        Schema::create('examens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->onDelete('set null');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_examen')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->integer('duree_minutes')->nullable();
            $table->integer('points_total')->default(20);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        Schema::create('examen_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('examen_id')->constrained('examens')->onDelete('cascade');
            $table->enum('type', ['vrai_faux', 'choix_multiple', 'texte_libre', 'image', 'numerique'])->default('vrai_faux');
            $table->text('question');
            $table->json('options')->nullable();
            $table->string('image')->nullable();
            $table->text('reponse_correcte')->nullable();
            $table->integer('ordre')->default(0);
            $table->integer('points')->default(1);
            $table->text('explication')->nullable();
            $table->timestamps();
            
            $table->index(['examen_id', 'ordre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('examen_questions');
        Schema::dropIfExists('examens');
    }
};
