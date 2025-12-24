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
        Schema::create('devoir_tentatives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('devoir_id')->constrained('devoirs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('heure_debut')->nullable();
            $table->timestamp('heure_fin_prevue')->nullable();
            $table->boolean('soumis')->default(false);
            $table->timestamp('soumis_le')->nullable();
            $table->timestamps();
            
            // Index pour éviter plusieurs tentatives simultanées (uniquement pour les tentatives non soumises)
            $table->index(['devoir_id', 'user_id', 'soumis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devoir_tentatives');
    }
};
