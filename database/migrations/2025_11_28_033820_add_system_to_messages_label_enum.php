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
        // Modifier l'enum de la colonne label pour inclure 'System'
        DB::statement("ALTER TABLE messages MODIFY COLUMN label ENUM('Normal','Signalement','Urgent','System') DEFAULT 'Normal'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Retirer 'System' de l'enum (mettre les messages System à Normal)
        DB::statement("UPDATE messages SET label = 'Normal' WHERE label = 'System'");
        DB::statement("ALTER TABLE messages MODIFY COLUMN label ENUM('Normal','Signalement','Urgent') DEFAULT 'Normal'");
    }
};
