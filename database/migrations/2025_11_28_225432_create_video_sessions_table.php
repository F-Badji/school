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
        Schema::create('video_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->unique(); // Identifiant unique de la session
            $table->foreignId('cours_id')->nullable()->constrained('cours')->onDelete('cascade');
            $table->foreignId('formateur_id')->constrained('users')->onDelete('cascade');
            $table->string('titre')->nullable();
            $table->text('description')->nullable();
            $table->enum('statut', ['en_attente', 'active', 'terminee'])->default('en_attente');
            $table->timestamp('date_debut')->nullable();
            $table->timestamp('date_fin')->nullable();
            $table->timestamps();
        });

        Schema::create('video_session_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_session_id')->constrained('video_sessions')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('statut', ['en_attente', 'accepte', 'refuse', 'present', 'expulse'])->default('en_attente');
            $table->boolean('micro_actif')->default(false);
            $table->boolean('camera_active')->default(false);
            $table->boolean('micro_controle_par_formateur')->default(false);
            $table->boolean('camera_controlee_par_formateur')->default(false);
            $table->timestamp('date_entree')->nullable();
            $table->timestamp('date_sortie')->nullable();
            $table->timestamps();
            
            $table->unique(['video_session_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_session_participants');
        Schema::dropIfExists('video_sessions');
    }
};
