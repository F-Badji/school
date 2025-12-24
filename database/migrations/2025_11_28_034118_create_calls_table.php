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
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('caller_id'); // Expéditeur (qui a appelé)
            $table->unsignedBigInteger('receiver_id'); // Destinataire (qui a reçu l'appel)
            $table->timestamp('started_at'); // Date et heure de début d'appel
            $table->timestamp('ended_at')->nullable(); // Date et heure de fin d'appel
            $table->integer('duration')->nullable(); // Durée en secondes
            $table->enum('status', ['missed', 'rejected', 'ended', 'answered'])->default('missed'); // Statut de l'appel
            $table->boolean('was_answered')->default(false); // Si l'appel a été répondu
            $table->timestamps();

            $table->foreign('caller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['caller_id', 'receiver_id']);
            $table->index('started_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calls');
    }
};
