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
        Schema::table('matieres', function (Blueprint $table) {
            // Changer le type de colonne de integer à string pour accepter "Semestre 1", "Semestre 2", etc.
            $table->string('semestre')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matieres', function (Blueprint $table) {
            // Revenir à integer si nécessaire
            $table->integer('semestre')->nullable()->change();
        });
    }
};
