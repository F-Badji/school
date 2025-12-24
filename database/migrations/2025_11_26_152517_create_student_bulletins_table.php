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
        Schema::create('student_bulletins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_path'); // Chemin du fichier bulletin
            $table->integer('semestre'); // Semestre (1-10)
            $table->string('classe')->nullable(); // Classe de l'apprenant au moment de l'envoi
            $table->foreignId('sent_by')->nullable()->constrained('users')->onDelete('set null'); // Admin qui a envoyé
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index(['user_id', 'semestre']);
            $table->index('semestre');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_bulletins');
    }
};
