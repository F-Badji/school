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
        // Étape 1: Identifier les matières uniques à garder (celles avec le plus petit ID pour chaque nom_matiere)
        $uniqueMatieres = DB::table('matieres')
            ->selectRaw('MIN(id) as id_to_keep, nom_matiere')
            ->groupBy('nom_matiere')
            ->get();

        // Créer un mapping des anciens IDs vers le nouvel ID unique
        $idMapping = [];
        foreach ($uniqueMatieres as $unique) {
            $allIds = DB::table('matieres')
                ->where('nom_matiere', $unique->nom_matiere)
                ->pluck('id')
                ->toArray();
            
            foreach ($allIds as $oldId) {
                if ($oldId != $unique->id_to_keep) {
                    $idMapping[$oldId] = $unique->id_to_keep;
                }
            }
        }

        // Étape 2: Si la table pivot existe, migrer les relations vers les IDs uniques
        if (Schema::hasTable('formateur_matiere')) {
            foreach ($idMapping as $oldId => $newId) {
                // Récupérer tous les user_id qui ont une relation avec l'ancien ID
                $usersWithOldId = DB::table('formateur_matiere')
                    ->where('matiere_id', $oldId)
                    ->pluck('user_id')
                    ->toArray();
                
                foreach ($usersWithOldId as $userId) {
                    // Vérifier si une relation existe déjà avec le nouvel ID pour ce user
                    $existing = DB::table('formateur_matiere')
                        ->where('user_id', $userId)
                        ->where('matiere_id', $newId)
                        ->exists();
                    
                    if (!$existing) {
                        // Mettre à jour la relation existante vers le nouvel ID
                        DB::table('formateur_matiere')
                            ->where('user_id', $userId)
                            ->where('matiere_id', $oldId)
                            ->update(['matiere_id' => $newId]);
                    } else {
                        // Si la relation existe déjà, supprimer l'ancienne relation
                        DB::table('formateur_matiere')
                            ->where('user_id', $userId)
                            ->where('matiere_id', $oldId)
                            ->delete();
                    }
                }
            }
            
            // Supprimer les doublons de relations restants (si un formateur a plusieurs fois la même matière)
            $duplicateRelations = DB::table('formateur_matiere')
                ->select('user_id', 'matiere_id', DB::raw('COUNT(*) as count'))
                ->groupBy('user_id', 'matiere_id')
                ->having('count', '>', 1)
                ->get();
            
            foreach ($duplicateRelations as $dup) {
                // Garder la première relation (ID le plus petit), supprimer les autres
                $toKeep = DB::table('formateur_matiere')
                    ->where('user_id', $dup->user_id)
                    ->where('matiere_id', $dup->matiere_id)
                    ->orderBy('id')
                    ->first();
                
                if ($toKeep) {
                    DB::table('formateur_matiere')
                        ->where('user_id', $dup->user_id)
                        ->where('matiere_id', $dup->matiere_id)
                        ->where('id', '!=', $toKeep->id)
                        ->delete();
                }
            }
        }

        // Étape 3: Supprimer les matières dupliquées
        $idsToDelete = array_keys($idMapping);
        
        if (!empty($idsToDelete)) {
            // Supprimer par lots pour éviter les problèmes de mémoire
            $chunks = array_chunk($idsToDelete, 500);
            foreach ($chunks as $chunk) {
                DB::table('matieres')
                    ->whereIn('id', $chunk)
                    ->delete();
            }
        }
    }

    /**
     * Reverse the migrations.
     * 
     * Note: Cette opération ne peut pas être inversée car les données ont été supprimées.
     */
    public function down(): void
    {
        // Cette migration supprime des données, elle ne peut pas être inversée
        // Si nécessaire, restaurez depuis une sauvegarde de la base de données
    }
};
