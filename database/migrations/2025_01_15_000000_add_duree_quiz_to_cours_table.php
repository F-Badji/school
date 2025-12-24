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
        Schema::table('cours', function (Blueprint $table) {
            if (!Schema::hasColumn('cours', 'duree_quiz')) {
                $table->integer('duree_quiz')->nullable()->after('duree')->comment('Durée du quiz en minutes');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            if (Schema::hasColumn('cours', 'duree_quiz')) {
                $table->dropColumn('duree_quiz');
            }
        });
    }
};










