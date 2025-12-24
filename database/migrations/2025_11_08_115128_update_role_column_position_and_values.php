<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Étape 1: Modifier le type de la colonne role pour accepter les nouvelles valeurs
        // D'abord, changer le type de la colonne en VARCHAR pour permettre toutes les valeurs
        if (Schema::hasColumn('users', 'role')) {
            DB::statement('ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NULL');
        } else {
            // Si la colonne n'existe pas, la créer
            Schema::table('users', function (Blueprint $table) {
                $table->string('role')->nullable();
            });
        }
        
        // Étape 2: Mettre à jour les valeurs de role existantes
        DB::table('users')
            ->where('role', 'apprenant')
            ->update(['role' => 'student']);
        
        DB::table('users')
            ->where('role', 'formateur')
            ->update(['role' => 'teacher']);
        
        // S'assurer que admin reste admin
        DB::table('users')
            ->where('role', 'admin')
            ->update(['role' => 'admin']);
        
        // Étape 3: Déplacer la colonne role après photo
        DB::statement('ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NULL AFTER photo');
        
        // Étape 4: Créer le compte professeur s'il n'existe pas
        $existingTeacher = DB::table('users')
            ->where('email', 'mouhamed123@gmail.com')
            ->first();
        
        if (!$existingTeacher) {
            DB::table('users')->insert([
                'name' => 'Mouhamed',
                'nom' => 'Professeur',
                'prenom' => 'Mouhamed',
                'email' => 'mouhamed123@gmail.com',
                'password' => Hash::make('Password'),
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        } else {
            // Mettre à jour le rôle si le compte existe déjà
            DB::table('users')
                ->where('email', 'mouhamed123@gmail.com')
                ->update(['role' => 'teacher']);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remettre les valeurs originales
        DB::table('users')
            ->where('role', 'student')
            ->update(['role' => 'apprenant']);
        
        DB::table('users')
            ->where('role', 'teacher')
            ->update(['role' => 'formateur']);
        
        // Remettre la colonne role à sa position originale (après niveau_etude)
        if (Schema::hasColumn('users', 'role')) {
            DB::statement('ALTER TABLE users MODIFY COLUMN role VARCHAR(255) NULL AFTER niveau_etude');
        }
    }
};
