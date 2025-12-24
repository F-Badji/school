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
            $table->string('image_couverture')->nullable()->after('description');
            $table->json('contenu')->nullable()->after('image_couverture'); // Pour stocker les sections de contenu avec leurs détails
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['image_couverture', 'contenu']);
        });
    }
};
