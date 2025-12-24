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
            // Champ pour confirmer que l'administration a validé le paiement
            $table->boolean('paiement_confirme')->default(false)->after('paiement_statut');
            $table->dateTime('date_confirmation_paiement')->nullable()->after('paiement_confirme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['paiement_confirme', 'date_confirmation_paiement']);
        });
    }
};
