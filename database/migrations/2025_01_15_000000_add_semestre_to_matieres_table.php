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
        if (!Schema::hasColumn('matieres', 'semestre')) {
            Schema::table('matieres', function (Blueprint $table) {
                $table->integer('semestre')->nullable()->after('niveau_etude');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('matieres', 'semestre')) {
            Schema::table('matieres', function (Blueprint $table) {
                $table->dropColumn('semestre');
            });
        }
    }
};

















