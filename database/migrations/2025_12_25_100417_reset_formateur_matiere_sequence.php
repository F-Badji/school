<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset the sequence for formateur_matiere table to avoid duplicate key errors
        DB::statement("SELECT setval('formateur_matiere_id_seq', (SELECT COALESCE(MAX(id), 1) FROM formateur_matiere))");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this
    }
};