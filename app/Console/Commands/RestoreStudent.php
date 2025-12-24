<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RestoreStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'student:restore {email=filybadji2020@gmail.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restaurer un étudiant supprimé par accident';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        // Vérifier si l'utilisateur existe déjà
        $existingUser = User::where('email', $email)->first();
        
        if ($existingUser) {
            $this->error("❌ L'utilisateur {$email} existe déjà.");
            $this->info("ID: {$existingUser->id}");
            $this->info("Nom: {$existingUser->nom} {$existingUser->prenom}");
            return 1;
        }
        
        $this->info("🔄 Restauration de l'étudiant: {$email}");
        
        // Demander les informations manquantes
        $nom = $this->ask('Nom de famille', 'Badji');
        $prenom = $this->ask('Prénom', 'Fily');
        $dateNaissance = $this->ask('Date de naissance (format: YYYY-MM-DD, optionnel)', null);
        $phone = $this->ask('Téléphone (optionnel)', null);
        $location = $this->ask('Ville (optionnel)', null);
        $nationalite = $this->ask('Nationalité (code pays 2 lettres, optionnel)', null);
        $password = $this->secret('Mot de passe (laisser vide pour générer un mot de passe temporaire)');
        
        if (empty($password)) {
            $password = 'password123';
            $this->warn("⚠️  Mot de passe temporaire généré: {$password}");
            $this->warn("⚠️  Veuillez le changer après la première connexion!");
        }
        
        // Générer le matricule
        $matricule = null;
        if ($dateNaissance) {
            try {
                $anneeInscription = date('Y');
                $dateNaissanceObj = Carbon::parse($dateNaissance);
                $dateNaissanceFormatee = $dateNaissanceObj->format('dmY');
                $matricule = $anneeInscription . $dateNaissanceFormatee;
            } catch (\Exception $e) {
                $this->warn("Erreur lors du parsing de la date de naissance, matricule non généré");
            }
        }
        
        if (!$matricule) {
            $matricule = date('Y') . '00000000';
            $this->warn("Matricule temporaire généré: {$matricule}");
        }
        
        // Données de l'étudiant basées sur les logs
        $studentData = [
            'email' => $email,
            'name' => $nom . ' ' . $prenom,
            'nom' => $nom,
            'prenom' => $prenom,
            'password' => Hash::make($password),
            'role' => 'student',
            'filiere' => 'Génie Informatique',
            'classe_id' => 'licence_1',
            'niveau_etude' => 'Licence 1',
            'statut' => 'actif',
            'matricule' => $matricule,
            'date_naissance' => $dateNaissance ? Carbon::parse($dateNaissance) : null,
            'phone' => $phone,
            'location' => $location,
            'nationalite' => $nationalite,
        ];
        
        try {
            $user = User::create($studentData);
            
            $this->info("✅ Étudiant restauré avec succès!");
            $this->table(
                ['Champ', 'Valeur'],
                [
                    ['ID', $user->id],
                    ['Email', $user->email],
                    ['Nom complet', $user->name],
                    ['Filière', $user->filiere],
                    ['Classe', $user->niveau_etude],
                    ['Matricule', $user->matricule],
                    ['Statut', $user->statut],
                ]
            );
            
            $this->warn("\n⚠️  IMPORTANT:");
            $this->warn("   - Vérifiez et complétez les informations manquantes dans l'interface admin");
            if ($password === 'password123') {
                $this->warn("   - Mot de passe temporaire: {$password}");
                $this->warn("   - Changez le mot de passe immédiatement après la première connexion");
            }
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error("❌ Erreur lors de la création de l'étudiant:");
            $this->error($e->getMessage());
            return 1;
        }
    }
}
