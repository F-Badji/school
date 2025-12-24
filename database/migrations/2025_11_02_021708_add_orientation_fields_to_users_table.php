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
            // Informations complémentaires
            $table->text('motivation')->nullable()->after('photo');
            $table->string('canal_decouverte')->nullable()->after('motivation'); // Réseaux sociaux, Ami/Collègue, etc.
            
            // Choix de formation
            $table->string('categorie_formation')->nullable()->after('canal_decouverte');
            $table->string('filiere')->nullable()->after('categorie_formation');
            
            // Paiement
            $table->string('paiement_method')->nullable()->after('filiere'); // Wave, Orange Money, etc.
            $table->string('paiement_statut')->default('en attente')->after('paiement_method'); // en attente, effectué
            $table->decimal('montant_paye', 10, 2)->nullable()->after('paiement_statut');
            $table->dateTime('date_paiement')->nullable()->after('montant_paye');
            
            // Statut d'orientation
            $table->boolean('orientation_complete')->default(false)->after('date_paiement');
            $table->dateTime('date_orientation')->nullable()->after('orientation_complete');
            
            // Niveau d'étude
            $table->string('niveau_etude')->default('Licence 1')->after('date_orientation');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'motivation',
                'canal_decouverte',
                'categorie_formation',
                'filiere',
                'paiement_method',
                'paiement_statut',
                'montant_paye',
                'date_paiement',
                'orientation_complete',
                'date_orientation',
                'niveau_etude',
            ]);
        });
    }
};
