<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;

class GenieInformatiqueL1Seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $matieres = [
            // Semestre 1
            ['nom_matiere' => 'Introduction à l\'informatique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 1],
            ['nom_matiere' => 'Algorithmique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 2],
            ['nom_matiere' => 'Initiation à la programmation (HTML, CSS, JAVASCRIPT)', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 3],
            ['nom_matiere' => 'Bureautique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 4],
            ['nom_matiere' => 'Introduction aux systèmes d\'exploitation', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 5],
            ['nom_matiere' => 'Mathématiques générales', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 6],
            ['nom_matiere' => 'Logique mathématique et raisonnement booléen', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 7],
            ['nom_matiere' => 'Probabilités et statistiques de base', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 8],
            ['nom_matiere' => 'Méthodologie du travail universitaire', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 9],
            ['nom_matiere' => 'Anglais', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 10],
            ['nom_matiere' => 'Introduction à l\'économie ou à la gestion', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 11],
            // Semestre 2
            ['nom_matiere' => 'Programmation (C, C++)', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 1],
            ['nom_matiere' => 'Introduction aux bases de données', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 2],
            ['nom_matiere' => 'Architecture des ordinateurs', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 3],
            ['nom_matiere' => 'Systèmes d\'exploitation', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 4],
            ['nom_matiere' => 'Introduction au réseau informatique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 5],
            ['nom_matiere' => 'Mathématiques appliquées à l\'informatique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 6],
            ['nom_matiere' => 'Recherche opérationnelle', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 7],
            ['nom_matiere' => 'Comptabilité générale', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 8],
            ['nom_matiere' => 'Anglais technique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 9],
            ['nom_matiere' => 'Projet informatique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 2, 'ordre' => 10],
        ];

        foreach ($matieres as $matiere) {
            // Vérifier si la matière existe déjà
            $exists = Matiere::where('nom_matiere', $matiere['nom_matiere'])
                ->where('filiere', $matiere['filiere'])
                ->where('niveau_etude', $matiere['niveau_etude'])
                ->first();
            
            if (!$exists) {
                Matiere::create($matiere);
                $this->command->info('Ajouté: ' . $matiere['nom_matiere']);
            } else {
                // Mettre à jour si elle existe déjà
                $exists->update($matiere);
                $this->command->warn('Mis à jour: ' . $matiere['nom_matiere']);
            }
        }
        
        $this->command->info('Toutes les matières de Licence 1 - Génie Informatique ont été ajoutées/mises à jour!');
    }
}

















