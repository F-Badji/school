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
        Schema::table('video_sessions', function (Blueprint $table) {
            $table->foreignId('pinned_participant_id')->nullable()->after('formateur_id')->constrained('video_session_participants')->onDelete('set null');
            $table->string('vue_mode')->default('grille')->after('statut'); // grille, galerie, presentation
            $table->boolean('enregistrement_actif')->default(false)->after('vue_mode');
        });

        Schema::table('video_session_participants', function (Blueprint $table) {
            $table->boolean('est_epingle')->default(false)->after('camera_controlee_par_formateur');
            $table->text('raison_refus')->nullable()->after('est_epingle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video_sessions', function (Blueprint $table) {
            $table->dropForeign(['pinned_participant_id']);
            $table->dropColumn(['pinned_participant_id', 'vue_mode', 'enregistrement_actif']);
        });

        Schema::table('video_session_participants', function (Blueprint $table) {
            $table->dropColumn(['est_epingle', 'raison_refus']);
        });
    }
};
