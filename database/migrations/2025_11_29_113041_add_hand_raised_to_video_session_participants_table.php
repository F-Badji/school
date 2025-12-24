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
        Schema::table('video_session_participants', function (Blueprint $table) {
            $table->boolean('main_levée')->default(false)->after('camera_controlee_par_formateur');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_session_participants', function (Blueprint $table) {
            $table->dropColumn('main_levée');
        });
    }
};
