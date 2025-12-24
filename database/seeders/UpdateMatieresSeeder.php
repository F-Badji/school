<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matiere;
use Illuminate\Support\Facades\DB;

class UpdateMatieresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Désactiver temporairement les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Supprimer les enregistrements liés dans formateur_matiere
        DB::table('formateur_matiere')->truncate();
        $this->command->info('Enregistrements de formateur_matiere supprimés.');
        
        // Supprimer toutes les matières existantes
        DB::table('matieres')->truncate();
        $this->command->info('Toutes les matières existantes ont été supprimées.');
        
        // Réactiver les vérifications de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $matieres = [
            // ========== LICENCE 1 – Génie Informatique ==========
            // Semestre 1
            ['nom_matiere' => 'Introduction à l\'informatique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 1],
            ['nom_matiere' => 'Algorithmique', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 2],
            ['nom_matiere' => 'Initiation à la programmation (HTML, CSS, JavaScript)', 'filiere' => 'Génie Informatique', 'niveau_etude' => 'Licence 1', 'semestre' => 1, 'ordre' => 3],
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

            // ========== LICENCE 2 – Génie Logiciel ==========
            // Semestre 3
            ['nom_matiere' => 'Algorithmique avancée', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Programmation orientée objet (Java)', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Programmation (PHP)', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Programmation (C#)', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Développement mobile', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Conception et modélisation UML', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            ['nom_matiere' => 'Systèmes d\'exploitation', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 7],
            ['nom_matiere' => 'Gestion de projet', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 8],
            ['nom_matiere' => 'Mathématiques', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 9],
            ['nom_matiere' => 'Anglais technique', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 10],
            // Semestre 4
            ['nom_matiere' => 'Bases de données relationnelles et NoSQL', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Conception d\'interfaces et ergonomie logicielle', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Sécurité applicative', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Gestion de version (Git / GitHub)', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],
            ['nom_matiere' => 'Projet d\'équipe (application complète)', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 5],

            // ========== LICENCE 2 – Informatique Appliquée à la Gestion des Entreprises (IAGE) ==========
            // Semestre 3
            ['nom_matiere' => 'Programmation orientée objet (Java)', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Programmation (PHP)', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Systèmes de gestion de bases de données (SGBD)', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Comptabilité analytique', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Analyse et conception de systèmes d\'information', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Mathématiques financières', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            ['nom_matiere' => 'Anglais des affaires', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 7],
            // Semestre 4
            ['nom_matiere' => 'Développement mobile', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Gestion de projet', 'filiere' => 'Informatique Appliquée à la Gestion des Entreprises (IAGE)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],

            // ========== LICENCE 2 – Cloud Computing et Big Data ==========
            // Semestre 3
            ['nom_matiere' => 'Introduction au cloud computing', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Virtualisation et conteneurisation', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Systèmes d\'exploitation Linux pour le cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Programmation Python', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Bases de données distribuées', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Réseaux et sécurité dans le cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            ['nom_matiere' => 'Communication technique en anglais', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 7],
            // Semestre 4
            ['nom_matiere' => 'Services cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Big Data', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Analyse de données', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Sécurité et conformité dans le cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],
            ['nom_matiere' => 'Administration cloud et déploiement continu', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 5],

            // ========== LICENCE 2 – Cybersécurité ==========
            // Semestre 3
            ['nom_matiere' => 'Introduction à la cybersécurité', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Réseaux informatiques', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Systèmes d\'exploitation et sécurité', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Cryptographie de base', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Sécurité des applications web', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Droit du numérique et éthique', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            ['nom_matiere' => 'Communication technique', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 7],
            // Semestre 4
            ['nom_matiere' => 'Sécurité avancée des réseaux', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Audit et test d\'intrusion', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Sécurité des systèmes et serveurs', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Gestion des incidents et forensic', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],
            ['nom_matiere' => 'Gouvernance et politique de sécurité', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 5],

            // ========== LICENCE 2 – Data Science ==========
            // Semestre 3
            ['nom_matiere' => 'Statistiques et probabilités avancées', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Programmation en Python', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Bases de données et SQL avancé', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Introduction au Machine Learning', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Visualisation de données', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Anglais scientifique', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            // Semestre 4
            ['nom_matiere' => 'Machine Learning appliqué', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Deep Learning', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Big Data et analyse prédictive', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Data Mining et entrepôts de données', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],

            // ========== LICENCE 2 – Intelligence Artificielle (IA) ==========
            // Semestre 3
            ['nom_matiere' => 'Mathématiques', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Programmation Python', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Logique et raisonnement automatique', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Introduction au Machine Learning', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Bases de données et traitement des données', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Anglais technique', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            // Semestre 4
            ['nom_matiere' => 'Deep Learning et réseaux neuronaux', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Traitement du langage naturel', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Vision par ordinateur', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Éthique et réglementation de l\'IA', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],

            // ========== LICENCE 2 – Réseaux et Télécommunications ==========
            // Semestre 3
            ['nom_matiere' => 'Réseaux informatiques', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 1],
            ['nom_matiere' => 'Protocoles de communication', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 2],
            ['nom_matiere' => 'Systèmes d\'exploitation réseaux', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 3],
            ['nom_matiere' => 'Câblage, commutation et routage de base', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 4],
            ['nom_matiere' => 'Sécurité des réseaux I', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 5],
            ['nom_matiere' => 'Anglais technique des réseaux', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 3, 'ordre' => 6],
            // Semestre 4
            ['nom_matiere' => 'Réseaux avancés', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 1],
            ['nom_matiere' => 'Télécommunications', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 2],
            ['nom_matiere' => 'Administration et maintenance réseau', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 3],
            ['nom_matiere' => 'Sécurité des réseaux II', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 2', 'semestre' => 4, 'ordre' => 4],

            // ========== LICENCE 3 – Génie Logiciel ==========
            // Semestre 5
            ['nom_matiere' => 'Ingénierie des exigences et modélisation avancée', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Tests automatisés et qualité logicielle', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Dev Mobile', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'DevOps', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Projet collectif en équipe', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            // Semestre 6
            ['nom_matiere' => 'Architecture logicielle distribuée', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Intelligence logicielle', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'Assurance qualité logicielle & audit logiciel', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'ARM', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],
            ['nom_matiere' => 'Management de produit logiciel', 'filiere' => 'Génie Logiciel', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 5],

            // ========== LICENCE 3 – Cybersécurité ==========
            // Semestre 5
            ['nom_matiere' => 'Sécurité des réseaux et infrastructures critiques', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Surveillance, détection d\'intrusion et réponse aux incidents', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Cyber‑crime et forensic numérique', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'Cryptographie avancée', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Stage ou mise en situation professionnelle', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            // Semestre 6
            ['nom_matiere' => 'Gouvernance, conformité et norme ISO 27001', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Sécurité des systèmes embarqués & IoT', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'ARM', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'Anglais technique spécialisé en sécurité', 'filiere' => 'Cybersécurité', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],

            // ========== LICENCE 3 – Data Science ==========
            // Semestre 5
            ['nom_matiere' => 'Machine Learning avancé & Deep Learning', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Big Data engineering', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Visualisation interactive & storytelling de données', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'Projet d\'analyse de données réelles', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Anglais scientifique approfondi', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            // Semestre 6
            ['nom_matiere' => 'Intelligence artificielle appliquée & systèmes prédictifs', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Data Science opérationnelle et mise en production', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'Éthique des données & réglementation', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'ARM', 'filiere' => 'Data Science', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],

            // ========== LICENCE 3 – Intelligence Artificielle (IA) ==========
            // Semestre 5
            ['nom_matiere' => 'Machine Learning avancé', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Deep Learning et réseaux neuronaux', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Traitement du langage naturel avancé', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'Vision par ordinateur avancée', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Projet pratique et mini‑stage', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            ['nom_matiere' => 'Anglais technique IA', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 6],
            // Semestre 6
            ['nom_matiere' => 'Systèmes intelligents et agents autonomes', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Robotique et IA embarquée', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'Éthique et réglementation de l\'IA appliquée', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'ARM', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],
            ['nom_matiere' => 'Gestion de projet scientifique', 'filiere' => 'Intelligence Artificielle (IA)', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 5],

            // ========== LICENCE 3 – Cloud Computing et Big Data ==========
            // Semestre 5
            ['nom_matiere' => 'Architecture Cloud et services distribués', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Virtualisation avancée et conteneurisation (Docker, Kubernetes)', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Big Data & systèmes distribués', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'Sécurité et conformité Cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Projet pratique sur Cloud et Big Data', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            // Semestre 6
            ['nom_matiere' => 'Administration Cloud et déploiement continu', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Analyse de données massives et Data Engineering', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'Intelligence artificielle dans le Cloud', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'ARM', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],
            ['nom_matiere' => 'Anglais technique avancé', 'filiere' => 'Cloud Computing et Big Data', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 5],

            // ========== LICENCE 3 – Réseaux et Télécommunications ==========
            // Semestre 5
            ['nom_matiere' => 'Réseaux avancés et optimisation', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 1],
            ['nom_matiere' => 'Télécommunications et VoIP', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 2],
            ['nom_matiere' => 'Administration réseau et serveurs', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 3],
            ['nom_matiere' => 'Sécurité des réseaux avancée', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 4],
            ['nom_matiere' => 'Projet pratique en réseau', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 5],
            ['nom_matiere' => 'Anglais technique réseaux', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 5, 'ordre' => 6],
            // Semestre 6
            ['nom_matiere' => 'Administration et maintenance réseau avancée', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 1],
            ['nom_matiere' => 'Réseaux mobiles et sans fil', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 2],
            ['nom_matiere' => 'Sécurité des réseaux et systèmes', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 3],
            ['nom_matiere' => 'Gestion de projet réseau', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 4],
            ['nom_matiere' => 'ARM', 'filiere' => 'Réseaux et Télécommunications', 'niveau_etude' => 'Licence 3', 'semestre' => 6, 'ordre' => 5],
        ];

        foreach ($matieres as $matiere) {
            Matiere::create($matiere);
            $this->command->info('Ajouté: ' . $matiere['nom_matiere'] . ' - ' . $matiere['filiere'] . ' - ' . $matiere['niveau_etude'] . ' - Semestre ' . $matiere['semestre']);
        }
        
        $this->command->info('✅ Toutes les matières ont été ajoutées avec succès!');
        $this->command->info('Total: ' . count($matieres) . ' matières');
    }
}

