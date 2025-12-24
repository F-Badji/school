<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\User;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CoursController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Vérification de sécurité basée sur le rôle uniquement
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->role && $user->role !== 'student') {
            // Rediriger selon le rôle de l'utilisateur
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
            } else {
                abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
            }
        }
        
        // Récupérer les formateurs (professeurs) qui enseignent dans la même filière, niveau ET classe assignée que l'apprenant
        // SÉCURITÉ : Un formateur doit avoir EXACTEMENT la même classe assignée que l'étudiant
        $apprenants = collect();
        
        // LOG 1: Données de l'étudiant
        Log::info('🔍 [MES PROFESSEURS] Début - Données de l\'étudiant', [
            'etudiant_id' => $user->id,
            'etudiant_email' => $user->email,
            'etudiant_classe_id' => $user->classe_id,
            'etudiant_filiere' => $user->filiere,
            'etudiant_niveau_etude' => $user->niveau_etude ?? 'N/A'
        ]);
        
        // Mapper classe_id de l'étudiant (licence_1, licence_2, licence_3) vers niveau_etude des cours (Licence 1, Licence 2, Licence 3)
        $classeToNiveauMap = [
            'licence_1' => 'Licence 1',
            'licence_2' => 'Licence 2',
            'licence_3' => 'Licence 3'
        ];
        
        $niveauEtude = null;
        if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
            $niveauEtude = $classeToNiveauMap[$user->classe_id];
        }
        
        // LOG 2: Vérification des données de l'étudiant
        Log::info('🔍 [MES PROFESSEURS] Vérification des données de l\'étudiant', [
            'etudiant_classe_id' => $user->classe_id,
            'etudiant_filiere' => $user->filiere,
            'has_classe_id' => !empty($user->classe_id),
            'has_filiere' => !empty($user->filiere)
        ]);
        
        // SÉCURITÉ SIMPLE : Récupérer DIRECTEMENT les formateurs avec la même classe_id ET la même filière
        // Ne pas passer par les cours, récupérer directement les formateurs
        if (!$user->classe_id || !$user->filiere) {
            Log::warning('⚠️ [MES PROFESSEURS] Étudiant sans classe ou filière assignée - Aucun formateur ne sera affiché', [
                'etudiant_email' => $user->email,
                'etudiant_classe_id' => $user->classe_id,
                'etudiant_filiere' => $user->filiere
            ]);
            $apprenants = collect();
            return view('apprenant.professeurs', compact('user', 'apprenants'));
        }
        
        // LOG 3: Avant la requête directe des formateurs
        Log::info('🔍 [MES PROFESSEURS] Avant requête directe des formateurs', [
            'etudiant_classe_id' => $user->classe_id,
            'etudiant_filiere' => $user->filiere,
            'requete' => 'role=teacher AND classe_id=' . $user->classe_id . ' AND filiere=' . $user->filiere
        ]);
        
        // Récupérer DIRECTEMENT les formateurs avec la même classe_id ET la même filière
        $formateursQuery = User::where('role', 'teacher')
            ->where('classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
            ->where('filiere', '=', $user->filiere); // SÉCURITÉ : Même filière
        
        $apprenants = $formateursQuery->get();
        
        // LOG 4: Formateurs trouvés après requête directe
        Log::info('🔍 [MES PROFESSEURS] Formateurs trouvés après requête directe', [
            'formateurs_count' => $apprenants->count(),
            'formateurs' => $apprenants->map(function($f) {
                return [
                    'id' => $f->id,
                    'nom' => ($f->nom ?? '') . ' ' . ($f->prenom ?? ''),
                    'email' => $f->email ?? '',
                    'classe_id' => $f->classe_id ?? 'N/A',
                    'filiere' => $f->filiere ?? 'N/A',
                    'role' => $f->role ?? 'N/A'
                ];
            })->toArray()
        ]);
        
        // Vérification supplémentaire de sécurité : double vérification manuelle
        $apprenants = $apprenants->filter(function($formateur) use ($user) {
            $formateurClasseId = $formateur->classe_id ?? null;
            $formateurFiliere = $formateur->filiere ?? null;
            $etudiantClasseId = $user->classe_id;
            $etudiantFiliere = $user->filiere;
            
            // Vérifier classe ET filière (les deux doivent correspondre)
            if ($formateurClasseId !== $etudiantClasseId || $formateurFiliere !== $etudiantFiliere) {
                Log::warning('🚫 [MES PROFESSEURS] Formateur rejeté - Classe ou filière ne correspond pas', [
                    'formateur_id' => $formateur->id,
                    'formateur_email' => $formateur->email ?? 'N/A',
                    'formateur_nom' => ($formateur->nom ?? '') . ' ' . ($formateur->prenom ?? ''),
                    'formateur_classe_id' => $formateurClasseId,
                    'formateur_filiere' => $formateurFiliere,
                    'etudiant_classe_id' => $etudiantClasseId,
                    'etudiant_filiere' => $etudiantFiliere,
                    'etudiant_email' => $user->email
                ]);
                return false;
            }
            
            return true;
        })->values();
        
        // LOG 5: Formateurs après filtrage manuel
        Log::info('🔍 [MES PROFESSEURS] Formateurs après filtrage manuel', [
            'formateurs_count' => $apprenants->count(),
            'formateurs' => $apprenants->map(function($f) {
                return [
                    'id' => $f->id,
                    'nom' => ($f->nom ?? '') . ' ' . ($f->prenom ?? ''),
                    'email' => $f->email ?? '',
                    'classe_id' => $f->classe_id ?? 'N/A',
                    'filiere' => $f->filiere ?? 'N/A'
                ];
            })->toArray()
        ]);
        
        // Récupérer les cours pour les statistiques (mais pas pour filtrer les formateurs)
        $cours = Cours::where('actif', true)->get();
        
        // SÉCURITÉ : Ne JAMAIS utiliser le fallback qui récupère tous les formateurs
        // Si aucun formateur n'est trouvé, retourner une collection vide
        
        // LOG 6: Résultat final
        Log::info('✅ [MES PROFESSEURS] Résultat final', [
            'etudiant_email' => $user->email,
            'etudiant_classe_id' => $user->classe_id,
            'etudiant_filiere' => $user->filiere,
            'formateurs_count' => $apprenants->count(),
            'formateurs' => $apprenants->map(function($f) {
                return [
                    'id' => $f->id,
                    'nom' => ($f->nom ?? '') . ' ' . ($f->prenom ?? ''),
                    'email' => $f->email ?? '',
                    'classe_id' => $f->classe_id ?? 'N/A',
                    'filiere' => $f->filiere ?? 'N/A'
                ];
            })->toArray()
        ]);
        
        // Récupérer les statistiques et matières pour chaque formateur
        $apprenants = $apprenants->map(function($apprenant) use ($cours) {
            $resultats = StudentResult::where('user_id', $apprenant->id)->get();
            
            // Nombre de tâches (devoirs + examens + quiz)
            $nombreTaches = $resultats->count();
            
            // Note moyenne (moyenne générale)
            $noteMoyenne = $resultats->avg('moyenne') ?? 0;
            $nombreAvis = $resultats->whereNotNull('moyenne')->count();
            
            // Récupérer les cours de ce formateur
            $coursFormateur = $cours->where('formateur_id', $apprenant->id);
            
            // Récupérer les matières enseignées par ce formateur
            $matieres = $apprenant->matieres()->get();
            
            // Déterminer la matière principale (première matière ou basée sur les cours)
            $matierePrincipale = $matieres->first();
            if (!$matierePrincipale && $coursFormateur->isNotEmpty()) {
                // Essayer de trouver la matière depuis les cours
                $matiereNom = $coursFormateur->first()->filiere ?? null;
            } else {
                $matiereNom = $matierePrincipale->nom_matiere ?? $matierePrincipale->nom ?? null;
            }
            
            $apprenant->nombre_taches = $nombreTaches;
            $apprenant->note_moyenne = round($noteMoyenne, 1);
            $apprenant->nombre_avis = $nombreAvis;
            $apprenant->matiere_nom = $matiereNom;
            $apprenant->matieres = $matieres;
            
            return $apprenant;
        });
        
        return view('apprenant.professeurs', compact('user', 'apprenants'));
    }
    
    public function voirProfilProfesseur($id)
    {
        $user = Auth::user();
        
        // Vérification de sécurité
        if (!$user) {
            return redirect()->route('login');
        }
        
        if ($user->role && $user->role !== 'student') {
            if ($user->role === 'admin') {
                return redirect()->route('dashboard')->with('error', 'Accès refusé.');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard')->with('error', 'Accès refusé.');
            } else {
                abort(403, 'Accès refusé.');
            }
        }
        
        // SÉCURITÉ SIMPLE : Vérifier que le professeur a la même classe_id ET la même filière que l'étudiant
        // Vérifier que l'étudiant a une classe ET une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            Log::warning('⚠️ Étudiant sans classe ou filière assignée dans voirProfilProfesseur() - Accès refusé', [
                'etudiant_email' => $user->email,
                'etudiant_classe_id' => $user->classe_id,
                'etudiant_filiere' => $user->filiere,
                'professeur_id' => $id
            ]);
            abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
        }
        
        // Récupérer le professeur avec vérification de classe_id ET filière
        $professeur = User::where('id', $id)
            ->where('role', 'teacher')
            ->where('classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
            ->where('filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
            ->first();
        
        if (!$professeur) {
            Log::warning('🚫 Accès refusé dans voirProfilProfesseur() - Professeur non trouvé ou classe/filière ne correspond pas', [
                'etudiant_email' => $user->email,
                'etudiant_classe_id' => $user->classe_id,
                'etudiant_filiere' => $user->filiere,
                'professeur_id' => $id
            ]);
            abort(403, 'Accès refusé. Ce professeur ne fait pas partie de votre classe et filière assignées.');
        }
        
        // Vérification supplémentaire de sécurité
        $professeurClasseId = $professeur->classe_id ?? null;
        $professeurFiliere = $professeur->filiere ?? null;
        
        if ($professeurClasseId !== $user->classe_id || $professeurFiliere !== $user->filiere) {
            Log::warning('🚫 Accès refusé dans voirProfilProfesseur() - Classe ou filière ne correspond pas après vérification', [
                'etudiant_email' => $user->email,
                'etudiant_classe_id' => $user->classe_id,
                'etudiant_filiere' => $user->filiere,
                'professeur_id' => $professeur->id,
                'professeur_classe_id' => $professeurClasseId,
                'professeur_filiere' => $professeurFiliere
            ]);
            abort(403, 'Accès refusé. Ce professeur ne fait pas partie de votre classe et filière assignées.');
        }
        
        Log::info('✅ Accès autorisé dans voirProfilProfesseur() (classe + filière)', [
            'etudiant_email' => $user->email,
            'etudiant_classe_id' => $user->classe_id,
            'etudiant_filiere' => $user->filiere,
            'professeur_id' => $professeur->id,
            'professeur_email' => $professeur->email ?? 'N/A',
            'professeur_classe_id' => $professeurClasseId,
            'professeur_filiere' => $professeurFiliere
        ]);
        
        // Passer le professeur pour la vue apprenant (vue séparée pour la sécurité)
        return view('apprenant.professeur-profil', ['professeur' => $professeur, 'user' => $user]);
    }
}