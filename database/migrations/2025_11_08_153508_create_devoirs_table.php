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
        Schema::create('devoirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('matiere_id')->nullable()->constrained('matieres')->onDelete('set null');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_limite')->nullable();
            $table->integer('points_total')->default(20);
            $table->boolean('actif')->default(true);
            $table->timestamps();
        });
        
        Schema::create('devoir_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devoir_id')->constrained('devoirs')->onDelete('cascade');
            $table->enum('type', ['vrai_faux', 'choix_multiple', 'texte_libre', 'image', 'numerique'])->default('vrai_faux');
            $table->text('question');
            $table->json('options')->nullable();
            $table->string('image')->nullable();
            $table->text('reponse_correcte')->nullable();
            $table->integer('ordre')->default(0);
            $table->integer('points')->default(1);
            $table->text('explication')->nullable();
            $table->timestamps();
            
            $table->index(['devoir_id', 'ordre']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoir_questions');
        Schema::dropIfExists('devoirs');
    }
};
