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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('est_promu')->default(false)->after('niveau_etude');
            $table->boolean('est_redoublant')->default(false)->after('est_promu');
            $table->string('annee_academique')->nullable()->after('est_redoublant');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['est_promu', 'est_redoublant', 'annee_academique']);
        });
    }
};
