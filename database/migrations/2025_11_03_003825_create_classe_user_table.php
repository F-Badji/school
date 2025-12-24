<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // La table existe déjà, on s'assure juste que l'index unique existe
        if (Schema::hasTable('classe_user')) {
            // Vérifier si l'index unique existe déjà
            $indexes = DB::select("SHOW INDEXES FROM classe_user WHERE Key_name = 'classe_user_classe_id_user_id_unique'");
            if (empty($indexes)) {
                Schema::table('classe_user', function (Blueprint $table) {
                    $table->unique(['classe_id', 'user_id'], 'classe_user_classe_id_user_id_unique');
                });
            }
        } else {
            Schema::create('classe_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->timestamps();
                
                // S'assurer qu'un apprenant ne peut être ajouté qu'une seule fois à une classe
                $table->unique(['classe_id', 'user_id'], 'classe_user_classe_id_user_id_unique');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classe_user');
    }
};
