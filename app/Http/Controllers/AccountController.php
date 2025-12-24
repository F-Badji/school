<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Models\OutboxNotification;
use App\Models\StudentResult;
use App\Models\Matiere;
use Illuminate\Support\Facades\Log;

class AccountController extends Controller
{
    public function settings()
    {
        $user = Auth::user();
        
        // Recharger l'utilisateur depuis la base de données pour avoir les dernières données
        $user->refresh();
        
        \Log::info('[SETTINGS] Accès à la page settings', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'route_name' => request()->route()->getName(),
            'photo_path' => $user->photo,
            'photo_basename' => $user->photo ? basename($user->photo) : null,
            'photo_exists' => $user->photo ? 'yes' : 'no',
        ]);
        
        // Si l'utilisateur est un admin et accède via la route account, rediriger vers admin.settings
        if ($user->role === 'admin' && request()->routeIs('account.settings')) {
            \Log::info('[SETTINGS] Admin accède via account.settings, redirection vers admin.settings');
            return redirect()->route('admin.settings');
        }
        
        // Récupérer toutes les sessions actives de l'utilisateur depuis la base de données
        $dbSessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('last_activity', '>', now()->subMinutes(config('session.lifetime', 120))->timestamp)
            ->orderBy('last_activity', 'desc')
            ->get();
        
        // Récupérer la session actuelle
        $currentSessionId = session()->getId();
        $currentUserAgent = request()->userAgent();
        $currentIpAddress = request()->ip();
        
        // Vérifier si la session actuelle est dans la base de données
        $currentSessionInDb = $dbSessions->firstWhere('id', $currentSessionId);
        
        $sessions = collect();
        
        // Ajouter la session actuelle en premier (même si elle n'est pas encore dans la DB)
        if (!$currentSessionInDb) {
            $deviceInfo = $this->parseUserAgent($currentUserAgent);
            $sessions->push([
                'id' => $currentSessionId,
                'ip_address' => $currentIpAddress,
                'user_agent' => $currentUserAgent,
                'device_name' => $deviceInfo['device'],
                'browser' => $deviceInfo['browser'],
                'platform' => $deviceInfo['platform'],
                'last_activity' => now()->format('Y-m-d H:i:s'),
                'is_current' => true,
            ]);
        }
        
        // Ajouter toutes les autres sessions de la base de données
        foreach ($dbSessions as $session) {
            if ($session->id !== $currentSessionId) {
                $userAgent = $session->user_agent ?? '';
                $deviceInfo = $this->parseUserAgent($userAgent);
                
                $sessions->push([
                    'id' => $session->id,
                    'ip_address' => $session->ip_address,
                    'user_agent' => $userAgent,
                    'device_name' => $deviceInfo['device'],
                    'browser' => $deviceInfo['browser'],
                    'platform' => $deviceInfo['platform'],
                    'last_activity' => date('Y-m-d H:i:s', $session->last_activity),
                    'is_current' => false,
                ]);
            } else {
                // Mettre à jour la session actuelle si elle est dans la DB
                $userAgent = $session->user_agent ?? $currentUserAgent;
                $deviceInfo = $this->parseUserAgent($userAgent);
                
                $sessions->prepend([
                    'id' => $session->id,
                    'ip_address' => $session->ip_address ?? $currentIpAddress,
                    'user_agent' => $userAgent,
                    'device_name' => $deviceInfo['device'],
                    'browser' => $deviceInfo['browser'],
                    'platform' => $deviceInfo['platform'],
                    'last_activity' => date('Y-m-d H:i:s', $session->last_activity),
                    'is_current' => true,
                ]);
            }
        }
        
        return view('account.settings', compact('sessions'));
    }
    
    public function destroySession(Request $request, $sessionId)
    {
        $user = Auth::user();
        $currentSessionId = session()->getId();
        
        // Si c'est la session actuelle, déconnecter complètement l'utilisateur
        if ($sessionId === $currentSessionId) {
            // Supprimer toutes les sessions de l'utilisateur
            DB::table('sessions')
                ->where('user_id', $user->id)
                ->delete();
            
            // Déconnecter l'utilisateur
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('home')
                ->with('success', 'Vous avez été déconnecté avec succès.');
        }
        
        // Supprimer la session spécifique de la base de données
        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', $user->id)
            ->delete();
        
        // Rediriger vers la bonne route selon le rôle
        $redirectRoute = ($user->role === 'admin' && request()->routeIs('admin.*')) 
            ? route('admin.settings') 
            : route('account.settings');
        
        return redirect($redirectRoute)
            ->with('success', 'Appareil déconnecté avec succès.');
    }
    
    private function parseUserAgent($userAgent)
    {
        $device = 'Appareil inconnu';
        $browser = 'Navigateur inconnu';
        $platform = 'OS inconnu';
        
        if (empty($userAgent)) {
            return ['device' => $device, 'browser' => $browser, 'platform' => $platform];
        }
        
        // Détecter le navigateur
        if (preg_match('/Chrome/i', $userAgent) && !preg_match('/Edg|OPR/i', $userAgent)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox/i', $userAgent)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari/i', $userAgent) && !preg_match('/Chrome/i', $userAgent)) {
            $browser = 'Safari';
        } elseif (preg_match('/Edg/i', $userAgent)) {
            $browser = 'Edge';
        } elseif (preg_match('/OPR/i', $userAgent)) {
            $browser = 'Opera';
        }
        
        // Détecter la plateforme
        if (preg_match('/Windows/i', $userAgent)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac/i', $userAgent)) {
            $platform = 'macOS';
        } elseif (preg_match('/Linux/i', $userAgent)) {
            $platform = 'Linux';
        } elseif (preg_match('/Android/i', $userAgent)) {
            $platform = 'Android';
        } elseif (preg_match('/iPhone|iPad|iPod/i', $userAgent)) {
            $platform = 'iOS';
        }
        
        // Détecter le type d'appareil
        if (preg_match('/Mobile|Android|iPhone|iPad|iPod/i', $userAgent)) {
            if (preg_match('/iPhone/i', $userAgent)) {
                $device = 'iPhone';
            } elseif (preg_match('/iPad/i', $userAgent)) {
                $device = 'iPad';
            } elseif (preg_match('/Android/i', $userAgent)) {
                $device = 'Android';
            } else {
                $device = 'Mobile';
            }
        } else {
            $device = 'Desktop';
        }
        
        return [
            'device' => $device,
            'browser' => $browser,
            'platform' => $platform,
        ];
    }

    /**
     * Détermine les semestres à afficher selon le niveau d'étude
     * SÉCURITÉ : Normalise le niveau d'étude pour éviter les problèmes de casse/espaces
     */
    private function getSemestresByNiveau($niveauEtude)
    {
        \Log::info('=== GETSEMESTRESBYNIVEAU - DÉBUT ===', [
            'niveauEtude_reçu' => $niveauEtude,
            'type' => gettype($niveauEtude),
        ]);
        
        // Normaliser le niveau d'étude (trim, casse)
        $niveau = trim($niveauEtude ?? 'Licence 1');
        \Log::info('=== GETSEMESTRESBYNIVEAU - APRÈS TRIM ===', [
            'niveau' => $niveau,
        ]);
        
        // Mapping des niveaux vers les semestres (insensible à la casse)
        // Ce mapping couvre tous les semestres de 1 à 10
        // - Licence 1: semestres 1-2
        // - Licence 2: semestres 3-4
        // - Licence 3: semestres 5-6
        // - Master 1: semestres 7-8
        // - Master 2: semestres 9-10
        // Pour ajouter de nouveaux niveaux à l'avenir, ajoutez-les ici avec leurs semestres correspondants
        $semestresMapping = [
            'licence 1' => [1, 2],
            'licence 2' => [3, 4],
            'licence 3' => [5, 6],
            'master 1' => [7, 8],
            'master 2' => [9, 10],
        ];
        
        // Convertir en minuscules pour la comparaison
        $niveauLower = strtolower($niveau);
        \Log::info('=== GETSEMESTRESBYNIVEAU - APRÈS STRTOLOWER ===', [
            'niveauLower' => $niveauLower,
            'key_exists' => isset($semestresMapping[$niveauLower]),
        ]);
        
        // SÉCURITÉ : Retourner les semestres correspondants ou [1, 2] par défaut
        $result = $semestresMapping[$niveauLower] ?? [1, 2];
        \Log::info('=== GETSEMESTRESBYNIVEAU - RÉSULTAT ===', [
            'result' => $result,
            'is_default' => !isset($semestresMapping[$niveauLower]),
        ]);
        
        return $result;
    }
    
    public function notes()
    {
        $user = Auth::user();
        
        // LOG DÉBUT
        \Log::info('=== NOTES PAGE - DÉBUT ===', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'niveau_etude_AVANT_REFRESH' => $user->niveau_etude ?? 'NULL',
        ]);
        
        // Vérifier si c'est un apprenant
        if ($user->role === 'student' || !$user->role) {
            // SÉCURITÉ : Recharger l'utilisateur depuis la base de données pour avoir les données à jour
            $user->refresh();
            
            \Log::info('=== APRÈS REFRESH ===', [
                'user_id' => $user->id,
                'niveau_etude_APRÈS_REFRESH' => $user->niveau_etude ?? 'NULL',
            ]);
            
            // Déterminer les semestres selon le niveau d'étude
            $niveauEtude = $user->niveau_etude ?? 'Licence 1';
            
            \Log::info('=== NIVEAU ÉTUDE INITIAL ===', [
                'niveau_etude' => $niveauEtude,
            ]);
            
            // SÉCURITÉ : Normaliser et valider le niveau d'étude
            \Log::info('=== AVANT NORMALISATION ===', [
                'niveauEtude_avant_trim' => $niveauEtude,
                'type' => gettype($niveauEtude),
            ]);
            
            $niveauEtude = trim($niveauEtude);
            \Log::info('=== APRÈS TRIM ===', [
                'niveauEtude_après_trim' => $niveauEtude,
            ]);
            
            $niveauEtudeLower = strtolower($niveauEtude);
            \Log::info('=== APRÈS STRTOLOWER ===', [
                'niveauEtudeLower' => $niveauEtudeLower,
                'niveauEtude' => $niveauEtude,
            ]);
            
            // SÉCURITÉ : Liste des niveaux valides (insensible à la casse)
            $niveauxValides = ['licence 1', 'licence 2', 'licence 3', 'master 1', 'master 2'];
            
            \Log::info('=== VÉRIFICATION VALIDITÉ ===', [
                'niveauEtudeLower' => $niveauEtudeLower,
                'in_array' => in_array($niveauEtudeLower, $niveauxValides),
                'empty' => empty($niveauEtude),
            ]);
            
            if (empty($niveauEtude) || !in_array($niveauEtudeLower, $niveauxValides)) {
                // SÉCURITÉ : Si le niveau n'est pas valide, utiliser Licence 1 par défaut
                \Log::warning('=== NIVEAU INVALIDE - UTILISATION PAR DÉFAUT ===', [
                    'niveauEtude_original' => $niveauEtude,
                    'niveauEtudeLower' => $niveauEtudeLower,
                ]);
                $niveauEtude = 'Licence 1';
                $niveauEtudeLower = 'licence 1';
                
                // SÉCURITÉ : Mettre à jour dans la base de données si nécessaire
                if ($user->niveau_etude !== 'Licence 1') {
                    $user->niveau_etude = 'Licence 1';
                    $user->save();
                    \Log::info('=== MISE À JOUR BDD ===', [
                        'ancien_niveau' => $user->niveau_etude,
                        'nouveau_niveau' => 'Licence 1',
                    ]);
                }
            } else {
                // Normaliser le format (première lettre en majuscule)
                $niveauEtude = ucwords($niveauEtudeLower);
                \Log::info('=== APRÈS UCWORDS ===', [
                    'niveauEtude' => $niveauEtude,
                    'niveauEtudeLower' => $niveauEtudeLower,
                ]);
            }
            
            // SÉCURITÉ : Forcer l'utilisation des bons semestres selon le niveau
            \Log::info('=== AVANT GETSEMESTRESBYNIVEAU ===', [
                'niveauEtude' => $niveauEtude,
                'niveauEtudeLower' => $niveauEtudeLower,
            ]);
            $semestres = $this->getSemestresByNiveau($niveauEtude);
            \Log::info('=== APRÈS GETSEMESTRESBYNIVEAU ===', [
                'semestres' => $semestres,
                'semestres_type' => gettype($semestres),
            ]);
            $semestre1 = $semestres[0];
            $semestre2 = $semestres[1];
            \Log::info('=== SEMESTRES EXTRACTED ===', [
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
                'semestre1_type' => gettype($semestre1),
                'semestre2_type' => gettype($semestre2),
            ]);
            
            // SÉCURITÉ : Vérification finale - les semestres doivent correspondre au niveau
            // Si un étudiant en Licence 2 voit Semestre 1 et 2, c'est une faille de sécurité
            if ($niveauEtudeLower === 'licence 2' && ($semestre1 != 3 || $semestre2 != 4)) {
                \Log::error('SÉCURITÉ : Semestres incorrects pour Licence 2', [
                    'user_id' => $user->id,
                    'niveau_etude' => $niveauEtude,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
                // Forcer les bons semestres
                $semestre1 = 3;
                $semestre2 = 4;
            } elseif ($niveauEtudeLower === 'licence 3' && ($semestre1 != 5 || $semestre2 != 6)) {
                \Log::error('SÉCURITÉ : Semestres incorrects pour Licence 3', [
                    'user_id' => $user->id,
                    'niveau_etude' => $niveauEtude,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
                $semestre1 = 5;
                $semestre2 = 6;
            } elseif ($niveauEtudeLower === 'master 1' && ($semestre1 != 7 || $semestre2 != 8)) {
                \Log::error('SÉCURITÉ : Semestres incorrects pour Master 1', [
                    'user_id' => $user->id,
                    'niveau_etude' => $niveauEtude,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
                $semestre1 = 7;
                $semestre2 = 8;
            } elseif ($niveauEtudeLower === 'master 2' && ($semestre1 != 9 || $semestre2 != 10)) {
                \Log::error('SÉCURITÉ : Semestres incorrects pour Master 2', [
                    'user_id' => $user->id,
                    'niveau_etude' => $niveauEtude,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
                $semestre1 = 9;
                $semestre2 = 10;
            }
            
            // SÉCURITÉ : Log pour déboguer
            \Log::info('Notes page - User niveau (SÉCURISÉ)', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'niveau_etude' => $niveauEtude,
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
            ]);
            
            // SÉCURITÉ : Récupérer UNIQUEMENT les notes de l'apprenant connecté
            // Double vérification : par user_id ET par nom/prenom pour sécurité maximale
            $studentResults = StudentResult::where(function($query) use ($user) {
                    // Priorité : user_id (le plus sûr)
                    $query->where('user_id', $user->id);
                })
                ->orWhere(function($query) use ($user) {
                    // Fallback : nom et prénom (seulement si user_id n'existe pas)
                    if ($user->nom && $user->prenom) {
                        $query->where('nom', $user->nom)
                              ->where('prenom', $user->prenom);
                    }
                })
                ->latest()
                ->get();
            
            // SÉCURITÉ : Récupérer toutes les matières valides pour cet apprenant (filière + niveau)
            $matieresValides = \App\Models\Matiere::where('filiere', $user->filiere)
                ->where('niveau_etude', $niveauEtude)
                ->pluck('nom_matiere')
                ->map(function($nom) {
                    return strtolower(trim($nom));
                })
                ->toArray();
            
            // SÉCURITÉ : Récupérer les matières enseignées par les professeurs de la même classe/filière
            $formateursDeLaClasse = \App\Models\User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->with('matieres')
                ->get();
            
            $matieresEnseignees = collect();
            foreach ($formateursDeLaClasse as $formateur) {
                foreach ($formateur->matieres as $matiere) {
                    if ($matiere->filiere == $user->filiere && $matiere->niveau_etude == $niveauEtude) {
                        $matieresEnseignees->push(strtolower(trim($matiere->nom_matiere)));
                    }
                }
            }
            
            // Combiner les matières valides et enseignées
            $matieresAutorisees = array_unique(array_merge($matieresValides, $matieresEnseignees->toArray()));
            
            // SÉCURITÉ : Filtrer une deuxième fois pour s'assurer que toutes les notes appartiennent à l'utilisateur
            // ET que la matière correspond à une matière valide enseignée par un professeur
            $studentResults = $studentResults->filter(function($result) use ($user, $matieresAutorisees) {
                // Vérifier que la note appartient bien à l'utilisateur
                $belongsToUser = ($result->user_id == $user->id) || 
                                 ($result->nom == $user->nom && $result->prenom == $user->prenom);
                
                if (!$belongsToUser) {
                    \Log::warning('SÉCURITÉ : Note rejetée - n\'appartient pas à l\'utilisateur', [
                        'note_id' => $result->id,
                        'note_user_id' => $result->user_id,
                        'note_nom' => $result->nom,
                        'note_prenom' => $result->prenom,
                        'current_user_id' => $user->id,
                        'current_user_nom' => $user->nom,
                        'current_user_prenom' => $user->prenom,
                    ]);
                    return false;
                }
                
                // SÉCURITÉ : Vérifier que la matière de la note correspond à une matière valide
                $matiereNote = strtolower(trim($result->classe ?? ''));
                // Normaliser les espaces multiples
                $matiereNote = preg_replace('/\s+/', ' ', $matiereNote);
                $matiereValide = false;
                
                // Normaliser aussi les matières autorisées
                $matieresAutoriseesNormalized = array_map(function($m) {
                    return preg_replace('/\s+/', ' ', strtolower(trim($m)));
                }, $matieresAutorisees);
                
                // Vérification exacte
                if (in_array($matiereNote, $matieresAutoriseesNormalized)) {
                    $matiereValide = true;
                } else {
                    // Vérification partielle (pour gérer les variations de nom)
                    foreach ($matieresAutoriseesNormalized as $matiereAutorisee) {
                        if (stripos($matiereNote, $matiereAutorisee) !== false || 
                            stripos($matiereAutorisee, $matiereNote) !== false) {
                            $matiereValide = true;
                            break;
                        }
                    }
                }
                
                if (!$matiereValide) {
                    \Log::warning('SÉCURITÉ : Note rejetée - matière non autorisée', [
                        'note_id' => $result->id,
                        'user_id' => $user->id,
                        'matiere_note' => $result->classe,
                        'matiere_note_normalized' => $matiereNote,
                        'matieres_autorisees' => $matieresAutorisees,
                        'matieres_autorisees_normalized' => $matieresAutoriseesNormalized,
                        'user_filiere' => $user->filiere,
                        'user_niveau' => $user->niveau_etude ?? 'N/A',
                        'devoir' => $result->devoir ?? 'N/A',
                        'examen' => $result->examen ?? 'N/A',
                        'semestre' => $result->semestre ?? 'N/A',
                    ]);
                    return false;
                }
                
                // Log pour déboguer les notes acceptées
                \Log::info('Note acceptée pour apprenant', [
                    'note_id' => $result->id,
                    'user_id' => $user->id,
                    'matiere' => $result->classe,
                    'semestre' => $result->semestre ?? 'N/A',
                    'devoir' => $result->devoir ?? 'N/A',
                    'examen' => $result->examen ?? 'N/A',
                    'quiz' => $result->quiz ?? 'N/A',
                ]);
                
                return true;
            });
            
            // Organiser les notes par semestre et type
            // SÉCURITÉ : Forcer les semestres selon le niveau pour éviter toute manipulation
            // IMPORTANT : Si une note a plusieurs types (devoir ET examen), créer une entrée pour chaque type
            $notes = collect();
            
            foreach ($studentResults as $result) {
                // SÉCURITÉ : Utiliser le semestre stocké dans la base de données si disponible
                $semestre = $result->semestre ?? null;
                
                // SÉCURITÉ : Si pas de semestre dans la base, déterminer selon la date
                // Mais toujours valider que le semestre correspond au niveau
                if (!$semestre) {
                    $month = $result->created_at->month;
                    $semestre = ($month >= 1 && $month <= 6) ? $semestre1 : $semestre2;
                }
                
                // SÉCURITÉ : Vérifier que le semestre correspond au niveau de l'utilisateur
                // Mapping des niveaux vers les semestres valides
                $semestresValides = [
                    'licence 1' => [1, 2],
                    'licence 2' => [3, 4],
                    'licence 3' => [5, 6],
                    'master 1' => [7, 8],
                    'master 2' => [9, 10],
                ];
                
                $semestresAutorises = $semestresValides[$niveauEtudeLower] ?? [1, 2];
                
                // Si le semestre ne correspond pas au niveau, utiliser le semestre par défaut du niveau
                if (!in_array($semestre, $semestresAutorises)) {
                    \Log::warning('SÉCURITÉ : Semestre invalide pour le niveau - correction automatique', [
                        'user_id' => $user->id,
                        'niveau' => $niveauEtudeLower,
                        'semestre_original' => $semestre,
                        'semestres_autorises' => $semestresAutorises,
                    ]);
                    $semestre = $semestresAutorises[0]; // Utiliser le premier semestre du niveau
                }
                
                // Créer une entrée pour chaque type de note (devoir, examen, quiz)
                // Cela permet d'afficher devoir ET examen pour la même matière
                $baseData = [
                    'id' => $result->id,
                    'matricule' => $result->matricule,
                    'nom' => $result->nom,
                    'prenom' => $result->prenom,
                    'classe' => $result->classe,
                    'moyenne' => $result->moyenne ?? 0,
                    'semestre' => (int)$semestre, // SÉCURITÉ : Forcer en entier
                    'matiere' => $result->classe ?? 'Matière',
                    'created_at' => $result->created_at,
                    'user_id' => $result->user_id,
                ];
                
                // Si devoir existe, créer une entrée pour devoir (accepter 0 et 00)
                if (isset($result->devoir) && $result->devoir !== null && $result->devoir >= 0) {
                    $notes->push((object)(array_merge($baseData, [
                        'devoir' => $result->devoir, // Ne pas utiliser ?? car cela peut écraser 0
                        'examen' => 0,
                        'quiz' => 0,
                        'type' => 'devoir',
                    ])));
                }
                
                // Si examen existe, créer une entrée pour examen (accepter 0 et 00)
                if (isset($result->examen) && $result->examen !== null && $result->examen >= 0) {
                    $notes->push((object)(array_merge($baseData, [
                        'devoir' => 0,
                        'examen' => $result->examen, // Ne pas utiliser ?? car cela peut écraser 0
                        'quiz' => 0,
                        'type' => 'examen',
                    ])));
                    
                    // Log pour déboguer
                    \Log::info('Note d\'examen créée pour apprenant', [
                        'user_id' => $user->id,
                        'result_id' => $result->id,
                        'matiere' => $result->classe,
                        'semestre' => $semestre,
                        'examen' => $result->examen,
                        'user_id_note' => $result->user_id,
                        'nom_note' => $result->nom,
                        'prenom_note' => $result->prenom,
                    ]);
                }
                
                // Si quiz existe, créer une entrée pour quiz (accepter 0 et 00)
                if (isset($result->quiz) && $result->quiz !== null && $result->quiz >= 0) {
                    $notes->push((object)(array_merge($baseData, [
                        'devoir' => 0,
                        'examen' => 0,
                        'quiz' => $result->quiz, // Ne pas utiliser ?? car cela peut écraser 0
                        'type' => 'exercice',
                    ])));
                }
            }
            
            // Récupérer les bulletins PDF envoyés par l'administrateur
            $userId = $user->id;
            // SÉCURITÉ : Récupérer les bulletins envoyés depuis la table student_bulletins
            // Uniquement pour cet apprenant et pour les semestres de son niveau
            // Convertir les semestres en entiers pour la comparaison
            $semestre1Int = (int)$semestre1;
            $semestre2Int = (int)$semestre2;
            
            Log::info('[NOTES] Récupération des bulletins pour apprenant', [
                'user_id' => $user->id,
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
                'semestre1Int' => $semestre1Int,
                'semestre2Int' => $semestre2Int,
            ]);
            
            $bulletinsEnvoyes = DB::table('student_bulletins')
                ->where('user_id', $user->id)
                ->whereIn('semestre', [$semestre1Int, $semestre2Int])
                ->get()
                ->map(function($b) {
                    // Vérifier que le fichier existe toujours
                    if (!Storage::disk('public')->exists($b->file_path)) {
                        Log::warning('[NOTES] Fichier bulletin introuvable', [
                            'file_path' => $b->file_path,
                            'user_id' => $b->user_id,
                            'semestre' => $b->semestre,
                        ]);
                        return null;
                    }
                    return [
                        'path' => $b->file_path,
                        'name' => basename($b->file_path),
                        'url' => Storage::url($b->file_path),
                        'semestre' => (int)$b->semestre, // S'assurer que c'est un entier
                        'sent_at' => $b->created_at,
                    ];
                })
                ->filter() // Retirer les null
                ->values();
            
            Log::info('[NOTES] Bulletins envoyés récupérés', [
                'user_id' => $user->id,
                'count' => $bulletinsEnvoyes->count(),
                'bulletins' => $bulletinsEnvoyes->toArray(),
            ]);
            
            // Récupérer aussi les bulletins uploadés par l'apprenant lui-même (ancien système)
            $folder = "bulletins/{$userId}";
            $files = [];
            if (Storage::disk('public')->exists($folder)) {
                $files = Storage::disk('public')->files($folder);
                // Filtrer uniquement les fichiers PDF
                $files = array_filter($files, function($file) {
                    return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
                });
            }
            
            $bulletinsUploades = collect($files)->map(function($p) use ($semestre1, $semestre2) {
                $name = basename($p);
                // Essayer de détecter le semestre depuis le nom du fichier
                $semestre = $semestre1; // Par défaut
                
                // Chercher le numéro de semestre dans le nom du fichier
                if (preg_match('/semestre[\s_-]*(\d+)/i', $name, $matches) || 
                    preg_match('/sem[\s_-]*(\d+)/i', $name, $matches)) {
                    $semestreNum = (int)$matches[1];
                    // Si le numéro correspond à l'un des semestres du niveau, l'utiliser
                    if ($semestreNum == $semestre1 || $semestreNum == $semestre2) {
                        $semestre = $semestreNum;
                    }
                }
                
                return [
                    'path' => $p,
                    'name' => $name,
                    'url' => Storage::url($p),
                    'semestre' => $semestre,
                ];
            })->values();
            
            // Combiner les bulletins envoyés et uploadés (éviter les doublons)
            $bulletins = $bulletinsEnvoyes->merge($bulletinsUploades)->unique('path')->values();
            
            // Séparer les bulletins par semestre (comparaison stricte avec conversion en entier)
            $semestre1Int = (int)$semestre1;
            $semestre2Int = (int)$semestre2;
            
            $bulletinsSem1 = $bulletins->filter(function($b) use ($semestre1Int) {
                $bSemestre = isset($b['semestre']) ? (int)$b['semestre'] : null;
                return $bSemestre !== null && $bSemestre == $semestre1Int;
            })->values();
            
            $bulletinsSem2 = $bulletins->filter(function($b) use ($semestre2Int) {
                $bSemestre = isset($b['semestre']) ? (int)$b['semestre'] : null;
                return $bSemestre !== null && $bSemestre == $semestre2Int;
            })->values();
            
            Log::info('[NOTES] Bulletins séparés par semestre', [
                'semestre1' => $semestre1Int,
                'semestre2' => $semestre2Int,
                'bulletinsSem1_count' => $bulletinsSem1->count(),
                'bulletinsSem2_count' => $bulletinsSem2->count(),
                'bulletinsSem1' => $bulletinsSem1->toArray(),
                'bulletinsSem2' => $bulletinsSem2->toArray(),
            ]);
            
            // SÉCURITÉ : Récupérer TOUS les quiz attempts de l'apprenant pour identifier les matières
            // Toujours regarder dans la base les matières des quiz complétés
            $allQuizAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
                ->whereNotNull('completed_at')
                ->whereNotNull('score')
                ->whereNotNull('total_questions')
                ->with('cours')
                ->get();
            
            // SÉCURITÉ : Récupérer les cours associés aux quiz attempts
            // Filtrer uniquement les cours de la filière et du niveau de l'utilisateur
            $coursIds = $allQuizAttempts->pluck('cours_id')->unique();
            $coursAvecQuiz = \App\Models\Cours::whereIn('id', $coursIds)
                ->where('filiere', $user->filiere) // SÉCURITÉ : Même filière
                ->where('niveau_etude', $niveauEtude) // SÉCURITÉ : Même niveau
                ->where('actif', true)
                ->get();
            
            // Créer une collection de matières basée sur les cours avec quiz complétés
            $matieresDepuisQuiz = collect();
            foreach ($coursAvecQuiz as $cours) {
                // Utiliser le titre du cours comme nom de matière
                $matieresDepuisQuiz->push((object)[
                    'id' => 'cours_' . $cours->id,
                    'nom_matiere' => $cours->titre,
                    'filiere' => $cours->filiere,
                    'niveau_etude' => $cours->niveau_etude,
                    'semestre' => null, // Sera déterminé plus tard
                    'ordre' => $cours->ordre ?? 999,
                    'from_quiz' => true,
                    'cours_id' => $cours->id
                ]);
            }
            
            // Récupérer toutes les matières de la filière et du niveau (sans filtrer par semestre car semestre peut être NULL)
            // Tri alphabétique par nom de matière
            $toutesMatieres = Matiere::where('filiere', $user->filiere)
                ->where('niveau_etude', $niveauEtude)
                ->orderBy('nom_matiere', 'asc')
                ->get();
            
            // COMBINER les matières de la table avec celles des quiz complétés
            // Éviter les doublons en utilisant le nom de la matière comme clé
            $matieresUniques = collect();
            $matieresDejaAjoutees = [];
            
            // D'abord, ajouter toutes les matières de la table
            foreach ($toutesMatieres as $matiere) {
                $key = strtolower(trim($matiere->nom_matiere));
                if (!isset($matieresDejaAjoutees[$key])) {
                    $matieresUniques->push($matiere);
                    $matieresDejaAjoutees[$key] = true;
                }
            }
            
            // Ensuite, ajouter les matières depuis les quiz complétés (si elles n'existent pas déjà)
            foreach ($matieresDepuisQuiz as $matiereQuiz) {
                $key = strtolower(trim($matiereQuiz->nom_matiere));
                // Vérifier si une matière similaire existe déjà
                $existeDeja = false;
                foreach ($matieresUniques as $matiereExistante) {
                    $keyExistante = strtolower(trim($matiereExistante->nom_matiere ?? ''));
                    // Comparaison flexible pour détecter les matières similaires
                    if ($key == $keyExistante || 
                        stripos($key, $keyExistante) !== false || 
                        stripos($keyExistante, $key) !== false) {
                        $existeDeja = true;
                        break;
                    }
                }
                
                if (!$existeDeja && !isset($matieresDejaAjoutees[$key])) {
                    $matieresUniques->push($matiereQuiz);
                    $matieresDejaAjoutees[$key] = true;
                }
            }
            
            // Trier toutes les matières combinées PAR ORDRE ALPHABÉTIQUE
            $toutesMatieres = $matieresUniques->sortBy(function($matiere) {
                // Tri alphabétique strict par nom de matière (insensible à la casse)
                return strtolower(trim($matiere->nom_matiere ?? ''));
            })->values();
            
            // Si les matières ont un champ semestre défini, les filtrer par semestre
            // Sinon, diviser les matières en deux groupes (première moitié = semestre 1, deuxième moitié = semestre 2)
            // Cette logique fonctionne pour tous les niveaux (Licence 1 à Master 2, semestres 1-10)
            $matieresAvecSemestre = $toutesMatieres->filter(function($matiere) {
                return isset($matiere->semestre) && $matiere->semestre !== null && $matiere->semestre != '';
            });
            
            if ($matieresAvecSemestre->count() > 0) {
                // Utiliser le champ semestre si disponible
                // Fonctionne pour tous les semestres de 1 à 10 et au-delà
                $matieresTableSem1 = $toutesMatieres->filter(function($matiere) use ($semestre1) {
                    return isset($matiere->semestre) && ($matiere->semestre == $semestre1 || $matiere->semestre == (string)$semestre1);
                })->sortBy(function($matiere) {
                    // Tri alphabétique pour le semestre 1
                    return strtolower(trim($matiere->nom_matiere ?? ''));
                })->values();
                
                $matieresTableSem2 = $toutesMatieres->filter(function($matiere) use ($semestre2) {
                    return isset($matiere->semestre) && ($matiere->semestre == $semestre2 || $matiere->semestre == (string)$semestre2);
                })->sortBy(function($matiere) {
                    // Tri alphabétique pour le semestre 2
                    return strtolower(trim($matiere->nom_matiere ?? ''));
                })->values();
            } else {
                // Diviser les matières en deux groupes égaux pour les deux semestres du niveau
                // Cette logique fonctionne automatiquement pour tous les niveaux :
                // - Licence 1: semestres 1-2
                // - Licence 2: semestres 3-4
                // - Licence 3: semestres 5-6
                // - Master 1: semestres 7-8
                // - Master 2: semestres 9-10
                // - Et tout niveau futur ajouté
                $totalMatieres = $toutesMatieres->count();
                $moitie = ceil($totalMatieres / 2);
                
                $matieresTableSem1 = $toutesMatieres->take($moitie)->sortBy(function($matiere) {
                    // Tri alphabétique pour le semestre 1
                    return strtolower(trim($matiere->nom_matiere ?? ''));
                })->values();
                
                $matieresTableSem2 = $toutesMatieres->skip($moitie)->sortBy(function($matiere) {
                    // Tri alphabétique pour le semestre 2
                    return strtolower(trim($matiere->nom_matiere ?? ''));
                })->values();
            }
            
            // Utiliser les matières combinées (table + quiz complétés) pour chaque semestre
            // On affiche toutes les matières du semestre, même sans quiz
            // Toutes les matières sont triées par ordre alphabétique
            // Cette logique fonctionne pour tous les semestres de 1 à 10 et au-delà
            $matieresSem1 = $matieresTableSem1;
            $matieresSem2 = $matieresTableSem2;
            
            // Calculer les notes finales de quiz par matière pour le semestre 1
            // SÉCURITÉ : Toutes les notes sont filtrées par user_id et validées
            $quizNotesSem1 = [];
            foreach ($matieresSem1 as $matiere) {
                // Trouver les cours associés à cette matière
                $coursIds = [];
                if (isset($matiere->cours_id)) {
                    // Si la matière vient d'un quiz, utiliser directement le cours_id
                    $coursIds = [$matiere->cours_id];
                } else {
                    // Sinon, chercher par titre avec plusieurs stratégies
                    // 1. Recherche exacte ou partielle du nom de la matière dans le titre
                    $coursIds = \App\Models\Cours::where('filiere', $user->filiere)
                        ->where('niveau_etude', $niveauEtude)
                        ->where(function($query) use ($matiere) {
                            $query->where('titre', 'like', '%' . $matiere->nom_matiere . '%')
                                  ->orWhere('titre', 'like', '%' . str_replace(' ', '%', $matiere->nom_matiere) . '%')
                                  // Recherche inversée : titre du cours dans le nom de la matière
                                  ->orWhereRaw('? LIKE CONCAT("%", titre, "%")', [$matiere->nom_matiere]);
                        })
                        ->where('actif', true)
                        ->pluck('id')
                        ->toArray();
                    
                    // 2. Si aucun cours trouvé, chercher tous les cours de la filière/niveau et vérifier les quiz attempts
                    // SÉCURITÉ : Cette recherche alternative est STRICTE - elle nécessite au moins 2 mots-clés significatifs en commun
                    // pour éviter les associations frauduleuses
                    if (empty($coursIds)) {
                        $allCoursIds = \App\Models\Cours::where('filiere', $user->filiere)
                            ->where('niveau_etude', $niveauEtude)
                            ->where('actif', true)
                            ->pluck('id')
                            ->toArray();
                        
                        // Vérifier si l'utilisateur a des quiz attempts pour ces cours
                        $attemptsWithCours = \App\Models\QuizAttempt::where('user_id', $user->id)
                            ->whereIn('cours_id', $allCoursIds)
                            ->whereNotNull('completed_at')
                            ->whereNotNull('score')
                            ->whereNotNull('total_questions')
                            ->with('cours')
                            ->get()
                            ->filter(function($attempt) use ($matiere) {
                                if (!$attempt->cours) {
                                    return false;
                                }
                                // SÉCURITÉ : Vérification STRICTE - nécessite au moins 2 mots-clés significatifs en commun
                                $coursTitre = strtolower($attempt->cours->titre);
                                $matiereNom = strtolower($matiere->nom_matiere);
                                
                                // Normaliser les caractères accentués
                                $coursTitre = str_replace(['à', 'é', 'è', 'ê', 'ë', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'], ['a', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'], $coursTitre);
                                $matiereNom = str_replace(['à', 'é', 'è', 'ê', 'ë', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'], ['a', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'], $matiereNom);
                                
                                // CORRESPONDANCE SPÉCIALE : "algorithme" et "informatique" sont considérés comme équivalents
                                // car "Introduction a l'algorithme" = "Introduction à l'informatique" dans ce contexte
                                $coursTitreNormalized = str_replace(['algorithme', 'algorithmes'], 'informatique', $coursTitre);
                                $matiereNomNormalized = str_replace(['algorithme', 'algorithmes'], 'informatique', $matiereNom);
                                
                                // Extraire les mots clés de la matière (mots de plus de 5 caractères, exclure les mots communs)
                                $motsExclus = ['introduction', 'introduction', 'initiation', 'initiation', 'general', 'generale', 'applique', 'appliquee', 'systeme', 'systemes'];
                                $motsMatiere = array_filter(explode(' ', $matiereNomNormalized), function($mot) use ($motsExclus) {
                                    $mot = trim($mot);
                                    return strlen($mot) > 5 && !in_array($mot, $motsExclus);
                                });
                                
                                // SÉCURITÉ : Nécessite au moins 2 mots-clés significatifs en commun (pas juste 1)
                                $matches = 0;
                                foreach ($motsMatiere as $mot) {
                                    if (strpos($coursTitreNormalized, trim($mot)) !== false) {
                                        $matches++;
                                    }
                                }
                                
                                // SÉCURITÉ RENFORCÉE : Nécessite au moins 2 mots-clés correspondants
                                // Exception : Si la matière contient "informatique" et le cours contient "algorithme" (ou vice versa),
                                // et qu'ils contiennent tous les deux "introduction", c'est une correspondance valide
                                if (strpos($matiereNom, 'informatique') !== false && strpos($coursTitre, 'algorithme') !== false && 
                                    strpos($matiereNom, 'introduction') !== false && strpos($coursTitre, 'introduction') !== false) {
                                    return true;
                                }
                                
                                return $matches >= 2;
                            })
                            ->pluck('cours_id')
                            ->unique()
                            ->toArray();
                        
                        if (!empty($attemptsWithCours)) {
                            $coursIds = $attemptsWithCours;
                        }
                    }
                }
                
                // SÉCURITÉ : Récupérer UNIQUEMENT les tentatives de quiz de l'apprenant connecté
                // Double vérification : user_id ET validation que le cours appartient à la bonne filière/niveau
                $quizAttempts = collect();
                if (!empty($coursIds)) {
                    $quizAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
                        ->whereIn('cours_id', $coursIds)
                        ->whereNotNull('completed_at')
                        ->whereNotNull('score')
                        ->whereNotNull('total_questions')
                        ->get();
                    
                    // SÉCURITÉ : Vérifier que tous les cours appartiennent bien à la filière et au niveau de l'utilisateur
                    $quizAttempts = $quizAttempts->filter(function($attempt) use ($user, $niveauEtude) {
                        $cours = \App\Models\Cours::find($attempt->cours_id);
                        if (!$cours) {
                            return false;
                        }
                        
                        // Vérifier que le cours correspond à la filière et au niveau de l'utilisateur
                        $coursValide = ($cours->filiere == $user->filiere) && 
                                      ($cours->niveau_etude == $niveauEtude) && 
                                      ($cours->actif == true);
                        
                        if (!$coursValide) {
                            \Log::warning('SÉCURITÉ : Tentative de quiz rejetée - cours ne correspond pas', [
                                'user_id' => $user->id,
                                'attempt_id' => $attempt->id,
                                'cours_id' => $attempt->cours_id,
                                'cours_filiere' => $cours->filiere,
                                'cours_niveau' => $cours->niveau_etude,
                                'user_filiere' => $user->filiere,
                                'user_niveau' => $niveauEtude,
                            ]);
                        }
                        
                        return $coursValide;
                    });
                }
                
                // Calculer la note finale : TOUJOURS la dernière tentative effectuée (pas la meilleure)
                // Si 2 tentatives : afficher la note de la 2ème tentative
                // Si 1 tentative : afficher la note de la 1ère tentative
                $noteFinale = null;
                $dateQuiz = null;
                
                if ($quizAttempts->count() > 0) {
                    // Trouver la dernière tentative effectuée (par date completed_at la plus récente)
                    // Si plusieurs tentatives ont la même date, prendre celle avec attempt_number le plus élevé
                    $derniereTentative = $quizAttempts->sortByDesc(function($attempt) {
                        // Trier par completed_at (plus récent en premier), puis par attempt_number
                        $date = $attempt->completed_at ? strtotime($attempt->completed_at) : 0;
                        $attemptNum = $attempt->attempt_number ?? 0;
                        return $date . '_' . $attemptNum;
                    })->first();
                    
                    if ($derniereTentative && $derniereTentative->total_questions > 0) {
                        // Calculer la note et arrondir SANS décimales
                        $noteFinale = round(($derniereTentative->score / $derniereTentative->total_questions) * 20);
                        $dateQuiz = $derniereTentative->completed_at;
                    }
                }
                
                // Si pas de quiz attempts, vérifier dans les notes existantes
                if (!$noteFinale) {
                    $noteExercice = collect($notes)->first(function($note) use ($matiere, $semestre1) {
                        return $note->semestre == $semestre1 
                            && $note->type == 'exercice' 
                            && $note->quiz
                            && (stripos($note->matiere ?? '', $matiere->nom_matiere) !== false || stripos($matiere->nom_matiere, $note->matiere ?? '') !== false);
                    });
                    
                    if ($noteExercice) {
                        // Arrondir SANS décimales
                        $noteFinale = round($noteExercice->quiz);
                        $dateQuiz = $noteExercice->created_at;
                    }
                }
                
                // Compter le nombre réel de tentatives complétées
                // Pour chaque section, compter jusqu'à 2 tentatives maximum (attempt_number 1 et 2)
                $nombreTentatives = 0;
                if ($quizAttempts->count() > 0) {
                    // Grouper par section (cours_id + section_index)
                    $groupedBySection = $quizAttempts->groupBy(function($attempt) {
                        return $attempt->cours_id . '_' . $attempt->section_index;
                    });
                    
                    // Pour chaque section, compter jusqu'à 2 tentatives maximum
                    foreach ($groupedBySection as $sectionKey => $sectionAttempts) {
                        // Filtrer pour ne garder que les attempt_number 1 et 2
                        $validAttempts = $sectionAttempts->filter(function($attempt) {
                            return $attempt->attempt_number <= 2;
                        });
                        
                        // Ajouter le nombre de tentatives valides (max 2 par section)
                        $nombreTentatives += min($validAttempts->count(), 2);
                    }
                }
                
                $matiereId = isset($matiere->cours_id) ? 'cours_' . $matiere->cours_id : $matiere->id;
                $quizNotesSem1[$matiereId] = [
                    'note' => $noteFinale,
                    'date' => $dateQuiz,
                    'tentatives' => $nombreTentatives
                ];
            }
            
            // Calculer les notes finales de quiz par matière pour le semestre 2
            // SÉCURITÉ : Toutes les notes sont filtrées par user_id et validées
            $quizNotesSem2 = [];
            foreach ($matieresSem2 as $matiere) {
                // Trouver les cours associés à cette matière
                $coursIds = [];
                if (isset($matiere->cours_id)) {
                    // Si la matière vient d'un quiz, utiliser directement le cours_id
                    $coursIds = [$matiere->cours_id];
                } else {
                    // Sinon, chercher par titre avec plusieurs stratégies
                    // 1. Recherche exacte ou partielle du nom de la matière dans le titre
                    $coursIds = \App\Models\Cours::where('filiere', $user->filiere)
                        ->where('niveau_etude', $niveauEtude)
                        ->where(function($query) use ($matiere) {
                            $query->where('titre', 'like', '%' . $matiere->nom_matiere . '%')
                                  ->orWhere('titre', 'like', '%' . str_replace(' ', '%', $matiere->nom_matiere) . '%')
                                  // Recherche inversée : titre du cours dans le nom de la matière
                                  ->orWhereRaw('? LIKE CONCAT("%", titre, "%")', [$matiere->nom_matiere]);
                        })
                        ->where('actif', true)
                        ->pluck('id')
                        ->toArray();
                    
                    // 2. Si aucun cours trouvé, chercher tous les cours de la filière/niveau et vérifier les quiz attempts
                    // SÉCURITÉ : Cette recherche alternative est STRICTE - elle nécessite au moins 2 mots-clés significatifs en commun
                    // pour éviter les associations frauduleuses
                    if (empty($coursIds)) {
                        $allCoursIds = \App\Models\Cours::where('filiere', $user->filiere)
                            ->where('niveau_etude', $niveauEtude)
                            ->where('actif', true)
                            ->pluck('id')
                            ->toArray();
                        
                        // Vérifier si l'utilisateur a des quiz attempts pour ces cours
                        $attemptsWithCours = \App\Models\QuizAttempt::where('user_id', $user->id)
                            ->whereIn('cours_id', $allCoursIds)
                            ->whereNotNull('completed_at')
                            ->whereNotNull('score')
                            ->whereNotNull('total_questions')
                            ->with('cours')
                            ->get()
                            ->filter(function($attempt) use ($matiere) {
                                if (!$attempt->cours) {
                                    return false;
                                }
                                // SÉCURITÉ : Vérification STRICTE - nécessite au moins 2 mots-clés significatifs en commun
                                $coursTitre = strtolower($attempt->cours->titre);
                                $matiereNom = strtolower($matiere->nom_matiere);
                                
                                // Normaliser les caractères accentués
                                $coursTitre = str_replace(['à', 'é', 'è', 'ê', 'ë', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'], ['a', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'], $coursTitre);
                                $matiereNom = str_replace(['à', 'é', 'è', 'ê', 'ë', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'], ['a', 'e', 'e', 'e', 'e', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'], $matiereNom);
                                
                                // CORRESPONDANCE SPÉCIALE : "algorithme" et "informatique" sont considérés comme équivalents
                                // car "Introduction a l'algorithme" = "Introduction à l'informatique" dans ce contexte
                                $coursTitreNormalized = str_replace(['algorithme', 'algorithmes'], 'informatique', $coursTitre);
                                $matiereNomNormalized = str_replace(['algorithme', 'algorithmes'], 'informatique', $matiereNom);
                                
                                // Extraire les mots clés de la matière (mots de plus de 5 caractères, exclure les mots communs)
                                $motsExclus = ['introduction', 'introduction', 'initiation', 'initiation', 'general', 'generale', 'applique', 'appliquee', 'systeme', 'systemes'];
                                $motsMatiere = array_filter(explode(' ', $matiereNomNormalized), function($mot) use ($motsExclus) {
                                    $mot = trim($mot);
                                    return strlen($mot) > 5 && !in_array($mot, $motsExclus);
                                });
                                
                                // SÉCURITÉ : Nécessite au moins 2 mots-clés significatifs en commun (pas juste 1)
                                $matches = 0;
                                foreach ($motsMatiere as $mot) {
                                    if (strpos($coursTitreNormalized, trim($mot)) !== false) {
                                        $matches++;
                                    }
                                }
                                
                                // SÉCURITÉ RENFORCÉE : Nécessite au moins 2 mots-clés correspondants
                                // Exception : Si la matière contient "informatique" et le cours contient "algorithme" (ou vice versa),
                                // et qu'ils contiennent tous les deux "introduction", c'est une correspondance valide
                                if (strpos($matiereNom, 'informatique') !== false && strpos($coursTitre, 'algorithme') !== false && 
                                    strpos($matiereNom, 'introduction') !== false && strpos($coursTitre, 'introduction') !== false) {
                                    return true;
                                }
                                
                                return $matches >= 2;
                            })
                            ->pluck('cours_id')
                            ->unique()
                            ->toArray();
                        
                        if (!empty($attemptsWithCours)) {
                            $coursIds = $attemptsWithCours;
                        }
                    }
                }
                
                // SÉCURITÉ : Récupérer UNIQUEMENT les tentatives de quiz de l'apprenant connecté
                // Double vérification : user_id ET validation que le cours appartient à la bonne filière/niveau
                $quizAttempts = collect();
                if (!empty($coursIds)) {
                    $quizAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
                        ->whereIn('cours_id', $coursIds)
                        ->whereNotNull('completed_at')
                        ->whereNotNull('score')
                        ->whereNotNull('total_questions')
                        ->get();
                    
                    // SÉCURITÉ : Vérifier que tous les cours appartiennent bien à la filière et au niveau de l'utilisateur
                    $quizAttempts = $quizAttempts->filter(function($attempt) use ($user, $niveauEtude) {
                        $cours = \App\Models\Cours::find($attempt->cours_id);
                        if (!$cours) {
                            return false;
                        }
                        
                        // Vérifier que le cours correspond à la filière et au niveau de l'utilisateur
                        $coursValide = ($cours->filiere == $user->filiere) && 
                                      ($cours->niveau_etude == $niveauEtude) && 
                                      ($cours->actif == true);
                        
                        if (!$coursValide) {
                            \Log::warning('SÉCURITÉ : Tentative de quiz rejetée - cours ne correspond pas', [
                                'user_id' => $user->id,
                                'attempt_id' => $attempt->id,
                                'cours_id' => $attempt->cours_id,
                                'cours_filiere' => $cours->filiere,
                                'cours_niveau' => $cours->niveau_etude,
                                'user_filiere' => $user->filiere,
                                'user_niveau' => $niveauEtude,
                            ]);
                        }
                        
                        return $coursValide;
                    });
                }
                
                // Calculer la note finale : TOUJOURS la dernière tentative effectuée (pas la meilleure)
                // Si 2 tentatives : afficher la note de la 2ème tentative
                // Si 1 tentative : afficher la note de la 1ère tentative
                $noteFinale = null;
                $dateQuiz = null;
                
                if ($quizAttempts->count() > 0) {
                    // Trouver la dernière tentative effectuée (par date completed_at la plus récente)
                    // Si plusieurs tentatives ont la même date, prendre celle avec attempt_number le plus élevé
                    $derniereTentative = $quizAttempts->sortByDesc(function($attempt) {
                        // Trier par completed_at (plus récent en premier), puis par attempt_number
                        $date = $attempt->completed_at ? strtotime($attempt->completed_at) : 0;
                        $attemptNum = $attempt->attempt_number ?? 0;
                        return $date . '_' . $attemptNum;
                    })->first();
                    
                    if ($derniereTentative && $derniereTentative->total_questions > 0) {
                        // Calculer la note et arrondir SANS décimales
                        $noteFinale = round(($derniereTentative->score / $derniereTentative->total_questions) * 20);
                        $dateQuiz = $derniereTentative->completed_at;
                    }
                }
                
                // Si pas de quiz attempts, vérifier dans les notes existantes
                if (!$noteFinale) {
                    $noteExercice = collect($notes)->first(function($note) use ($matiere, $semestre2) {
                        return $note->semestre == $semestre2 
                            && $note->type == 'exercice' 
                            && $note->quiz
                            && (stripos($note->matiere ?? '', $matiere->nom_matiere) !== false || stripos($matiere->nom_matiere, $note->matiere ?? '') !== false);
                    });
                    
                    if ($noteExercice) {
                        // Arrondir SANS décimales
                        $noteFinale = round($noteExercice->quiz);
                        $dateQuiz = $noteExercice->created_at;
                    }
                }
                
                // Compter le nombre réel de tentatives complétées
                // Pour chaque section, compter jusqu'à 2 tentatives maximum (attempt_number 1 et 2)
                $nombreTentatives = 0;
                if ($quizAttempts->count() > 0) {
                    // Grouper par section (cours_id + section_index)
                    $groupedBySection = $quizAttempts->groupBy(function($attempt) {
                        return $attempt->cours_id . '_' . $attempt->section_index;
                    });
                    
                    // Pour chaque section, compter jusqu'à 2 tentatives maximum
                    foreach ($groupedBySection as $sectionKey => $sectionAttempts) {
                        // Filtrer pour ne garder que les attempt_number 1 et 2
                        $validAttempts = $sectionAttempts->filter(function($attempt) {
                            return $attempt->attempt_number <= 2;
                        });
                        
                        // Ajouter le nombre de tentatives valides (max 2 par section)
                        $nombreTentatives += min($validAttempts->count(), 2);
                    }
                }
                
                $matiereId = isset($matiere->cours_id) ? 'cours_' . $matiere->cours_id : $matiere->id;
                $quizNotesSem2[$matiereId] = [
                    'note' => $noteFinale,
                    'date' => $dateQuiz,
                    'tentatives' => $nombreTentatives
                ];
            }
            
            // SÉCURITÉ CRITIQUE : Vérification finale et FORCAGE des semestres selon le niveau
            // Cette vérification est ABSOLUMENT CRITIQUE pour la sécurité
            // UTILISER $niveauEtudeLower qui est déjà normalisé en minuscules
            $niveauFinal = $niveauEtudeLower;
            
            // SÉCURITÉ : Forcer les semestres selon le niveau - AUCUNE EXCEPTION
            \Log::info('=== AVANT SWITCH ===', [
                'niveauFinal' => $niveauFinal,
                'niveauEtude' => $niveauEtude,
                'niveauEtudeLower' => $niveauEtudeLower,
            ]);
            
            switch ($niveauFinal) {
                case 'licence 1':
                    $semestre1 = 1;
                    $semestre2 = 2;
                    \Log::critical('SWITCH: Licence 1 -> Semestres 1 et 2', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
                case 'licence 2':
                    $semestre1 = 3;
                    $semestre2 = 4;
                    \Log::critical('SWITCH: Licence 2 -> Semestres 3 et 4', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
                case 'licence 3':
                    $semestre1 = 5;
                    $semestre2 = 6;
                    \Log::critical('SWITCH: Licence 3 -> Semestres 5 et 6', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
                case 'master 1':
                    $semestre1 = 7;
                    $semestre2 = 8;
                    \Log::critical('SWITCH: Master 1 -> Semestres 7 et 8', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
                case 'master 2':
                    $semestre1 = 9;
                    $semestre2 = 10;
                    \Log::critical('SWITCH: Master 2 -> Semestres 9 et 10', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
                default:
                    // Par défaut, Licence 1
                    $semestre1 = 1;
                    $semestre2 = 2;
                    \Log::critical('SWITCH: DEFAULT -> Semestres 1 et 2', [
                        'user_id' => $user->id,
                        'niveauFinal' => $niveauFinal,
                        'semestre1' => $semestre1,
                        'semestre2' => $semestre2,
                    ]);
                    break;
            }
            
            \Log::critical('=== APRÈS SWITCH ===', [
                'user_id' => $user->id,
                'niveauFinal' => $niveauFinal,
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
                'semestre1_type' => gettype($semestre1),
                'semestre2_type' => gettype($semestre2),
            ]);
            
            // SÉCURITÉ : Vérification finale absolue - FORCER les semestres pour TOUS les niveaux
            // Cette vérification est CRITIQUE pour garantir que les bons semestres sont toujours utilisés
            if ($niveauFinal === 'licence 1') {
                $semestre1 = 1;
                $semestre2 = 2;
                \Log::critical('=== FORCÉ APRÈS SWITCH : Licence 1 -> Semestres 1 et 2 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'licence 2') {
                $semestre1 = 3;
                $semestre2 = 4;
                \Log::critical('=== FORCÉ APRÈS SWITCH : Licence 2 -> Semestres 3 et 4 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'licence 3') {
                $semestre1 = 5;
                $semestre2 = 6;
                \Log::critical('=== FORCÉ APRÈS SWITCH : Licence 3 -> Semestres 5 et 6 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'master 1') {
                $semestre1 = 7;
                $semestre2 = 8;
                \Log::critical('=== FORCÉ APRÈS SWITCH : Master 1 -> Semestres 7 et 8 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'master 2') {
                $semestre1 = 9;
                $semestre2 = 10;
                \Log::critical('=== FORCÉ APRÈS SWITCH : Master 2 -> Semestres 9 et 10 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } else {
                // Par défaut, Licence 1
                $semestre1 = 1;
                $semestre2 = 2;
                \Log::critical('=== FORCÉ APRÈS SWITCH : DEFAULT -> Semestres 1 et 2 ===', [
                    'user_id' => $user->id,
                    'niveauFinal' => $niveauFinal,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            }
            
            // SÉCURITÉ : Log final pour vérification
            \Log::info('=== VARIABLES FINALES AVANT VUE ===', [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'niveau_etude' => $niveauEtude,
                'niveauFinal' => $niveauFinal,
                'semestre1_FINAL' => $semestre1,
                'semestre2_FINAL' => $semestre2,
                'semestre1_type' => gettype($semestre1),
                'semestre2_type' => gettype($semestre2),
            ]);
            
            // SÉCURITÉ : S'assurer que les variables sont bien des entiers
            $semestre1 = (int)$semestre1;
            $semestre2 = (int)$semestre2;
            
            \Log::info('=== VARIABLES FINALES APRÈS CAST ===', [
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
            ]);
            
            // Vérification critique avant de passer à la vue - FORCER les bons semestres pour TOUS les niveaux
            // Cette vérification est une DOUBLE SÉCURITÉ pour garantir les bons semestres
            if ($niveauFinal === 'licence 1') {
                $semestre1 = 1;
                $semestre2 = 2;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : Licence 1 -> Semestres 1 et 2 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'licence 2') {
                $semestre1 = 3;
                $semestre2 = 4;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : Licence 2 -> Semestres 3 et 4 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'licence 3') {
                $semestre1 = 5;
                $semestre2 = 6;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : Licence 3 -> Semestres 5 et 6 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'master 1') {
                $semestre1 = 7;
                $semestre2 = 8;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : Master 1 -> Semestres 7 et 8 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } elseif ($niveauFinal === 'master 2') {
                $semestre1 = 9;
                $semestre2 = 10;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : Master 2 -> Semestres 9 et 10 ===', [
                    'user_id' => $user->id,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            } else {
                // Par défaut, Licence 1
                $semestre1 = 1;
                $semestre2 = 2;
                \Log::critical('=== DERNIÈRE VÉRIFICATION : DEFAULT -> Semestres 1 et 2 ===', [
                    'user_id' => $user->id,
                    'niveauFinal' => $niveauFinal,
                    'semestre1' => $semestre1,
                    'semestre2' => $semestre2,
                ]);
            }
            
            \Log::info('=== PASSAGE À LA VUE ===', [
                'view' => 'apprenant.notes',
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
                'semestre1_type' => gettype($semestre1),
                'semestre2_type' => gettype($semestre2),
                'niveauEtude' => $niveauEtude,
                'niveauEtudeLower' => $niveauEtudeLower,
                'user_niveau_etude' => $user->niveau_etude,
            ]);
            
            // DERNIÈRE VÉRIFICATION ABSOLUE AVANT LA VUE
            \Log::critical('=== DERNIÈRE VÉRIFICATION AVANT VUE ===', [
                'user_id' => $user->id,
                'user_niveau_etude_BDD' => $user->niveau_etude,
                'niveauEtudeLower' => $niveauEtudeLower,
                'semestre1' => $semestre1,
                'semestre2' => $semestre2,
                'attendu_licence1' => ($niveauEtudeLower === 'licence 1') ? '1,2' : 'N/A',
                'attendu_licence2' => ($niveauEtudeLower === 'licence 2') ? '3,4' : 'N/A',
            ]);
            
            return view('apprenant.notes', compact(
                'notes', 
                'user', 
                'bulletinsSem1', 
                'bulletinsSem2', 
                'matieresSem1', 
                'matieresSem2',
                'semestre1',
                'semestre2',
                'niveauEtude',
                'quizNotesSem1',
                'quizNotesSem2'
            ));
        }
        
        // Pour les admins/formateurs, garder l'ancienne interface
        $userId = Auth::id();
        $folder = "bulletins/{$userId}";
        
        Log::info('[NOTES] Loading notes page', [
            'user_id' => $userId,
            'folder' => $folder,
            'folder_exists' => Storage::disk('public')->exists($folder),
            'storage_path' => storage_path("app/public/{$folder}"),
        ]);
        
        $files = [];
        if (Storage::disk('public')->exists($folder)) {
            $files = Storage::disk('public')->files($folder);
            // Filtrer uniquement les fichiers PDF
            $files = array_filter($files, function($file) {
                return pathinfo($file, PATHINFO_EXTENSION) === 'pdf';
            });
        }
        
        $bulletins = collect($files)->map(function($p) {
            $name = basename($p);
            return [
                'path' => $p, // Chemin relatif depuis public/
                'full_path' => storage_path("app/public/{$p}"),
                'name' => $name,
                'url' => Storage::url($p),
                'exists' => Storage::disk('public')->exists($p),
            ];
        })->values();
        
        Log::info('[NOTES] Bulletins loaded', [
            'user_id' => $userId,
            'bulletins_count' => $bulletins->count(),
            'bulletins' => $bulletins->toArray(),
        ]);
        
        // Charger les apprenants avec leur classe et matricule pour le filtrage sécurisé
        $apprenants = User::where('role', 'student')->get(['id','name','email','classe_id','matricule']);
        
        // Récupérer les semestres depuis la table notes (base de données)
        $semestres = DB::table('notes')
            ->whereNotNull('semestre')
            ->where('semestre', '!=', '')
            ->distinct()
            ->orderBy('semestre')
            ->pluck('semestre')
            ->map(function($sem) {
                // Normaliser le format (peut être "1", "Semestre 1", "S1", etc.)
                if (preg_match('/(\d+)/', $sem, $matches)) {
                    return (int)$matches[1];
                }
                return $sem;
            })
            ->unique()
            ->sort()
            ->values();
        
        Log::info('[NOTES] Semestres récupérés depuis la base de données', [
            'count' => $semestres->count(),
            'semestres' => $semestres->toArray(),
            'raw_query' => 'SELECT DISTINCT semestre FROM notes WHERE semestre IS NOT NULL AND semestre != ""',
        ]);
        
        // Pour chaque apprenant, récupérer ses semestres depuis ses notes (via matricule)
        $apprenantsAvecSemestres = $apprenants->map(function($apprenant) {
            // Utiliser le matricule pour lier les notes aux apprenants
            $matricule = $apprenant->matricule ?? null;
            $semestresApprenant = [];
            $notesApprenant = [];
            
            if ($matricule) {
                // Récupérer toutes les notes de l'apprenant avec leur classe et semestre
                $notesApprenant = DB::table('notes')
                    ->where('matricule', $matricule)
                    ->whereNotNull('semestre')
                    ->where('semestre', '!=', '')
                    ->select('semestre', 'classe')
                    ->get();
                
                $semestresApprenant = $notesApprenant
                    ->pluck('semestre')
                    ->map(function($sem) {
                        if (preg_match('/(\d+)/', $sem, $matches)) {
                            return (int)$matches[1];
                        }
                        return $sem;
                    })
                    ->unique()
                    ->values()
                    ->toArray();
            }
            
            $apprenant->semestres = $semestresApprenant;
            $apprenant->notes_details = $notesApprenant; // Pour debug
            
            Log::info('[NOTES] Apprenant avec semestres', [
                'id' => $apprenant->id,
                'name' => $apprenant->name,
                'email' => $apprenant->email,
                'matricule' => $matricule,
                'classe_id' => $apprenant->classe_id,
                'semestres' => $semestresApprenant,
                'notes_count' => count($notesApprenant),
                'notes_details' => $notesApprenant->map(function($n) {
                    return ['semestre' => $n->semestre, 'classe' => $n->classe];
                })->toArray(),
            ]);
            
            return $apprenant;
        });
        
        Log::info('[NOTES] Apprenants loaded for bulletin modal', [
            'count' => $apprenants->count(),
            'semestres_disponibles' => $semestres->toArray(),
            'sample' => $apprenants->take(5)->toArray(),
        ]);
        
        // Récupérer les bulletins envoyés aux apprenants avec leurs informations détaillées
        $bulletinsEnvoyes = DB::table('student_bulletins')
            ->join('users', 'student_bulletins.user_id', '=', 'users.id')
            ->leftJoin('users as senders', 'student_bulletins.sent_by', '=', 'senders.id')
            ->select(
                'student_bulletins.id',
                'student_bulletins.user_id',
                'student_bulletins.file_path',
                'student_bulletins.semestre',
                'student_bulletins.classe',
                'student_bulletins.created_at as sent_at',
                'users.name as apprenant_name',
                'users.email as apprenant_email',
                'users.matricule as apprenant_matricule',
                'users.nom as apprenant_nom',
                'users.prenom as apprenant_prenom',
                'senders.name as sender_name'
            )
            ->orderBy('student_bulletins.created_at', 'desc')
            ->get()
            ->map(function($bulletin) {
                // Vérifier que le fichier existe toujours
                $fileExists = Storage::disk('public')->exists($bulletin->file_path);
                return [
                    'id' => $bulletin->id,
                    'user_id' => $bulletin->user_id,
                    'file_path' => $bulletin->file_path,
                    'file_name' => basename($bulletin->file_path),
                    'file_url' => $fileExists ? Storage::url($bulletin->file_path) : null,
                    'file_exists' => $fileExists,
                    'semestre' => $bulletin->semestre,
                    'classe' => $bulletin->classe,
                    'sent_at' => $bulletin->sent_at,
                    'apprenant_name' => $bulletin->apprenant_name,
                    'apprenant_email' => $bulletin->apprenant_email,
                    'apprenant_matricule' => $bulletin->apprenant_matricule,
                    'apprenant_nom' => $bulletin->apprenant_nom,
                    'apprenant_prenom' => $bulletin->apprenant_prenom,
                    'sender_name' => $bulletin->sender_name,
                ];
            })
            ->filter(function($bulletin) {
                return $bulletin['file_exists']; // Ne garder que les bulletins dont le fichier existe
            })
            ->values();
        
        Log::info('[NOTES] Bulletins envoyés chargés', [
            'count' => $bulletinsEnvoyes->count(),
        ]);
        
        return view('account.notes', compact('bulletins','apprenants','semestres','apprenantsAvecSemestres','bulletinsEnvoyes'));
    }

    public function notesPdf()
    {
        // Pour l'instant, on réutilise la vue PDF existante si nécessaire
        $user = Auth::user();
        $date = now();
        return response()->view('pdf.receipt', compact('user','date'));
    }

    public function uploadBulletin(Request $request)
    {
        try {
            $request->validate([
                'bulletin_pdf' => 'required|file|mimes:pdf|max:10240',
            ], [
                'bulletin_pdf.required' => 'Veuillez sélectionner un fichier PDF.',
                'bulletin_pdf.mimes' => 'Le fichier doit être au format PDF.',
                'bulletin_pdf.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
            ]);

            $userId = Auth::id();
            $file = $request->file('bulletin_pdf');
            
            Log::info('[NOTES] Upload started', [
                'user_id' => $userId,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ]);
            
            // Créer le dossier s'il n'existe pas
            $directory = "bulletins/{$userId}";
            $fullPath = storage_path("app/public/{$directory}");
            
            Log::info('[NOTES] Directory check', [
                'directory' => $directory,
                'full_path' => $fullPath,
                'exists' => Storage::disk('public')->exists($directory),
            ]);
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory, 0755, true);
                Log::info('[NOTES] Directory created', ['directory' => $directory]);
            }

            // Générer un nom de fichier unique
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.-]/', '_', $file->getClientOriginalName());
            
            // Stocker le fichier directement dans le dossier public
            $path = $file->storeAs($directory, $fileName, 'public');
            
            Log::info('[NOTES] File stored', [
                'user_id' => $userId,
                'original' => $file->getClientOriginalName(),
                'stored_as' => $fileName,
                'path' => $path,
                'full_path' => storage_path("app/public/{$path}"),
                'file_exists' => Storage::disk('public')->exists($path),
                'size' => $file->getSize(),
            ]);

            // Vérifier que le fichier existe bien
            if (!Storage::disk('public')->exists($path)) {
                Log::error('[NOTES] File not found after storage', ['path' => $path]);
                throw new \Exception('Le fichier n\'a pas pu être stocké correctement.');
            }

            // Compter les fichiers après upload pour le message
            $fileCount = count(Storage::disk('public')->files($directory));
            Log::info('[NOTES] Upload completed', ['total_files' => $fileCount]);

            // Rediriger vers la bonne route selon le rôle de l'utilisateur
            $user = Auth::user();
            $redirectRoute = ($user && $user->role === 'admin') ? 'admin.notes' : 'account.notes';
            
            return redirect()->route($redirectRoute)->with('success', 'Bulletin importé avec succès. (' . $fileCount . ' fichier(s) disponible(s))');
        } catch (\Illuminate\Validation\ValidationException $e) {
            $user = Auth::user();
            $redirectRoute = ($user && $user->role === 'admin') ? 'admin.notes' : 'account.notes';
            return redirect()->route($redirectRoute)->withErrors($e->errors());
        } catch (\Exception $e) {
            $user = Auth::user();
            $redirectRoute = ($user && $user->role === 'admin') ? 'admin.notes' : 'account.notes';
            return redirect()->route($redirectRoute)->with('error', 'Erreur lors de l\'import : ' . $e->getMessage());
        }
    }

    public function sendBulletin(Request $request)
    {
        Log::info('[NOTES] ===== SEND BULLETIN START =====');
        Log::info('[NOTES] Request data:', $request->all());
        Log::info('[NOTES] Request URL:', ['url' => $request->fullUrl()]);
        Log::info('[NOTES] Request method:', ['method' => $request->method()]);
        Log::info('[NOTES] Previous URL:', ['previous' => $request->header('referer')]);
        Log::info('[NOTES] Current user:', [
            'id' => Auth::id(),
            'name' => Auth::user()->name ?? null,
            'role' => Auth::user()->role ?? null,
        ]);
        
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,id',
                'file_path' => 'required|string',
                'semestre' => 'required|integer|min:1|max:10',
            ]);
            
            Log::info('[NOTES] Validation passed:', $data);
            
            $recipient = User::findOrFail($data['user_id']);
            $fileName = basename($data['file_path']);
            $semestre = (int)$data['semestre'];
            
            Log::info('[NOTES] Recipient found:', [
                'id' => $recipient->id,
                'name' => $recipient->name,
                'email' => $recipient->email,
                'role' => $recipient->role,
            ]);
            
            // SÉCURITÉ : Vérifier que le fichier existe
            $fileExists = Storage::disk('public')->exists($data['file_path']);
            Log::info('[NOTES] File check:', [
                'file_path' => $data['file_path'],
                'exists' => $fileExists,
                'storage_path' => storage_path("app/public/{$data['file_path']}"),
            ]);
            
            if (!$fileExists) {
                Log::error('[NOTES] File not found', ['file_path' => $data['file_path']]);
                return redirect()->back()->with('error', 'Le fichier bulletin n\'existe pas.');
            }
            
            // SÉCURITÉ : Vérifier que l'utilisateur qui envoie est admin
            $sender = Auth::user();
            Log::info('[NOTES] Sender check:', [
                'sender_exists' => $sender !== null,
                'sender_id' => $sender->id ?? null,
                'sender_role' => $sender->role ?? null,
                'is_admin' => $sender && $sender->role === 'admin',
            ]);
            
            if (!$sender || $sender->role !== 'admin') {
                Log::error('[NOTES] Unauthorized bulletin send attempt', [
                    'sender_id' => $sender->id ?? null,
                    'sender_role' => $sender->role ?? null,
                ]);
                abort(403, 'Accès refusé. Seuls les administrateurs peuvent envoyer des bulletins.');
            }
        
        // SÉCURITÉ : Vérifier que le destinataire est bien un apprenant
        if ($recipient->role !== 'student') {
            Log::error('[NOTES] Invalid recipient role', [
                'recipient_id' => $recipient->id,
                'recipient_role' => $recipient->role,
            ]);
            return redirect()->back()->with('error', 'Le destinataire doit être un apprenant.');
        }
        
        // Déterminer la classe de l'apprenant
        $classeLabelMap = [
            'licence_1' => 'Licence 1',
            'licence_2' => 'Licence 2',
            'licence_3' => 'Licence 3',
            'master_1'  => 'Master 1',
            'master_2'  => 'Master 2',
        ];
        $classe = isset($recipient->classe_id) && isset($classeLabelMap[$recipient->classe_id]) 
            ? $classeLabelMap[$recipient->classe_id] 
            : ($recipient->niveau_etude ?? 'Non spécifié');
        
        Log::info('[NOTES] Sending bulletin', [
            'recipient_id' => $data['user_id'],
            'recipient_name' => $recipient->name,
            'recipient_email' => $recipient->email,
            'file_path' => $data['file_path'],
            'semestre' => $semestre,
            'classe' => $classe,
            'sender_id' => $sender->id,
            'file_exists' => Storage::disk('public')->exists($data['file_path']),
        ]);
        
        // SÉCURITÉ : Stocker le bulletin dans la table student_bulletins
        DB::table('student_bulletins')->insert([
            'user_id' => $data['user_id'],
            'file_path' => $data['file_path'],
            'semestre' => $semestre,
            'classe' => $classe,
            'sent_by' => $sender->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        
        // Générer une notification avec lien vers le PDF
        $url = Storage::url($data['file_path']);
        OutboxNotification::create([
            'title' => 'Bulletin de notes disponible - Semestre ' . $semestre,
            'body' => 'Votre bulletin de notes "' . $fileName . '" pour le Semestre ' . $semestre . ' est maintenant disponible. Vous pouvez le consulter dans votre interface "Mes Notes".',
            'audience' => 'utilisateur',
            'user_id' => $data['user_id'],
            'status' => 'enregistré',
        ]);

            // Rediriger vers la même page avec un message de succès
            // Utiliser la route appropriée selon le contexte
            $referer = $request->header('referer');
            $isAdminRoute = $referer && str_contains($referer, '/admin/notes');
            
            if ($isAdminRoute) {
                $redirectUrl = route('admin.notes');
            } else {
                $redirectUrl = route('account.notes');
            }
            
            $successMessage = 'Bulletin envoyé avec succès à ' . $recipient->name . ' pour le Semestre ' . $semestre . '.';
            
            Log::info('[NOTES] Redirect info:', [
                'referer' => $referer,
                'is_admin_route' => $isAdminRoute,
                'redirect_url' => $redirectUrl,
                'success_message' => $successMessage,
                'route_admin_notes' => route('admin.notes'),
                'route_account_notes' => route('account.notes'),
            ]);
            
            Log::info('[NOTES] ===== SEND BULLETIN SUCCESS =====');
            
            return redirect($redirectUrl)->with('success', $successMessage);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('[NOTES] Validation error:', [
                'errors' => $e->errors(),
                'request_data' => $request->all(),
            ]);
            return redirect()->back()->withErrors($e->errors());
        } catch (\Exception $e) {
            Log::error('[NOTES] Exception in sendBulletin:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()->with('error', 'Erreur lors de l\'envoi du bulletin : ' . $e->getMessage());
        }
    }

    public function deleteBulletin(Request $request)
    {
        try {
            $request->validate([
                'file_path' => 'required|string',
            ]);

            $userId = Auth::id();
            $filePath = $request->input('file_path');
            
            // Vérifier que le fichier appartient bien à l'utilisateur connecté
            $userFolder = "bulletins/{$userId}";
            if (!str_starts_with($filePath, $userFolder)) {
                throw new \Exception('Vous n\'avez pas le droit de supprimer ce fichier.');
            }

            // Vérifier que le fichier existe
            if (!Storage::disk('public')->exists($filePath)) {
                throw new \Exception('Le fichier n\'existe pas.');
            }

            // Supprimer le fichier
            Storage::disk('public')->delete($filePath);

            Log::info('[NOTES] Bulletin deleted', [
                'user_id' => $userId,
                'file_path' => $filePath,
            ]);

            // Rediriger vers la bonne route selon le rôle de l'utilisateur
            $user = Auth::user();
            $redirectRoute = ($user && $user->role === 'admin') ? 'admin.notes' : 'account.notes';
            
            return redirect()->route($redirectRoute)->with('success', 'Bulletin supprimé avec succès.');
        } catch (\Exception $e) {
            $user = Auth::user();
            $redirectRoute = ($user && $user->role === 'admin') ? 'admin.notes' : 'account.notes';
            return redirect()->route($redirectRoute)->with('error', 'Erreur lors de la suppression : ' . $e->getMessage());
        }
    }

    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'matricule' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'annee_naissance' => 'nullable|date',
            'classe' => 'nullable|string|in:Licence 1,Licence 2,Licence 3',
            'semestre' => 'nullable|string|in:Semestre 1,Semestre 2,Semestre 3,Semestre 4,Semestre 5,Semestre 6',
            'coefficient' => 'nullable|integer|min:1|max:10',
            'devoir' => 'nullable|numeric|min:0|max:20',
            'examen' => 'nullable|numeric|min:0|max:20',
            'quiz' => 'nullable|numeric|min:0|max:20',
            'moyenne' => 'nullable|numeric|min:0|max:20',
            'redoubler' => 'nullable|boolean',
        ]);

        // Gérer le champ redoubler : si la checkbox n'est pas cochée, elle n'envoie rien
        $validated['redoubler'] = $request->has('redoubler') ? (bool)$request->input('redoubler') : false;

        // Calculer la moyenne si non fournie : (Devoir + Examen) / 2
        if (!isset($validated['moyenne']) || $validated['moyenne'] === '') {
            if (isset($validated['devoir']) && isset($validated['examen'])) {
                $validated['moyenne'] = ($validated['devoir'] + $validated['examen']) / 2;
            }
        }

        // Trouver l'utilisateur par nom et prénom
        $user = User::where('nom', $validated['nom'])
            ->where('prenom', $validated['prenom'])
            ->first();

        $validated['user_id'] = $user ? $user->id : null;

        StudentResult::create($validated);

        // Rediriger vers la bonne route selon le rôle de l'utilisateur
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.notes')->with('success', 'Note enregistrée avec succès.');
        }

        return redirect()->route('account.notes')->with('success', 'Note enregistrée avec succès.');
    }

    public function showNote($id)
    {
        // Récupérer la note depuis la table 'notes' au lieu de 'student_results'
        $note = DB::table('notes')->where('id', $id)->first();
        
        if (!$note) {
            abort(404, 'Note non trouvée.');
        }
        
        return view('account.notes-show', compact('note'));
    }

    public function editNote($id)
    {
        // Récupérer la note depuis la table 'notes' au lieu de 'student_results'
        $note = DB::table('notes')->where('id', $id)->first();
        
        if (!$note) {
            abort(404, 'Note non trouvée.');
        }
        
        return view('account.notes-edit', compact('note'));
    }

    public function updateNote(Request $request, $id)
    {
        // Vérifier que la note existe dans la table 'notes'
        $note = DB::table('notes')->where('id', $id)->first();
        
        if (!$note) {
            abort(404, 'Note non trouvée.');
        }
        
        $validated = $request->validate([
            'matricule' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'annee_naissance' => 'nullable|date',
            'classe' => 'nullable|string', // Nom de la matière (Cours)
            'niveau_etude' => 'nullable|string', // Niveau d'étude de l'étudiant (Classe)
            'semestre' => 'nullable|string',
            'coefficient' => 'nullable|string',
            'devoir' => 'nullable|numeric|min:0|max:20',
            'examen' => 'nullable|numeric|min:0|max:20',
            'quiz' => 'nullable|numeric|min:0|max:20',
            'moyenne' => 'nullable|numeric|min:0|max:20',
            'redoubler' => 'nullable|boolean',
        ]);

        // Gérer le champ redoubler : si la checkbox n'est pas cochée, elle n'envoie rien
        $validated['redoubler'] = $request->has('redoubler') ? (bool)$request->input('redoubler') : false;

        // Calculer la moyenne : (Devoir + Examen) / 2
        $devoir = $validated['devoir'] ?? 0;
        $examen = $validated['examen'] ?? 0;
        $validated['moyenne'] = round(($devoir + $examen) / 2, 2);

        // Mettre à jour la note dans la table 'notes'
        DB::table('notes')->where('id', $id)->update($validated);

        // Rediriger vers la bonne route selon le rôle de l'utilisateur
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.notes')->with('success', 'Note modifiée avec succès.');
        }
        
        return redirect()->route('account.notes')->with('success', 'Note modifiée avec succès.');
    }

    public function destroyNote($id)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        // Vérifier que la note existe dans la table 'notes'
        $note = DB::table('notes')->where('id', $id)->first();
        
        if (!$note) {
            abort(404, 'Note non trouvée.');
        }
        
        // Supprimer la note de la table 'notes'
        DB::table('notes')->where('id', $id)->delete();

        // Rediriger vers la bonne route selon le rôle de l'utilisateur
        $user = Auth::user();
        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.notes')->with('success', 'Note supprimée avec succès.');
        }
        
        return redirect()->route('account.notes')->with('success', 'Note supprimée avec succès.');
    }

    public function security()
    {
        $deletePassword = config('delete_password.password', '022001');
        return view('account.security', compact('deletePassword'));
    }

    public function updateDeletePassword(Request $request)
    {
        // Vérifier que l'utilisateur est admin
        $user = Auth::user();
        if (!$user || ($user->role !== 'admin' && !$user->is_admin)) {
            return redirect()->back()
                ->with('error', 'Vous n\'avez pas les permissions nécessaires pour modifier ce paramètre.');
        }

        // Récupérer l'ancien mot de passe depuis la configuration
        $currentPassword = config('delete_password.password', '022001');

        $request->validate([
            'current_delete_password' => [
                'required',
                function ($attribute, $value, $fail) use ($currentPassword) {
                    if ($value !== $currentPassword) {
                        $fail('L\'ancien mot de passe est incorrect.');
                    }
                },
            ],
            'new_delete_password' => [
                'required',
                'string',
                'min:4',
                'confirmed',
                'regex:/^[0-9]+$/',
            ],
        ], [
            'current_delete_password.required' => 'L\'ancien mot de passe est requis.',
            'new_delete_password.required' => 'Le nouveau mot de passe est requis.',
            'new_delete_password.min' => 'Le mot de passe doit contenir au moins 4 chiffres.',
            'new_delete_password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'new_delete_password.regex' => 'Le mot de passe doit contenir uniquement des chiffres.',
        ]);

        try {
            // Lire le fichier .env
            $envFile = base_path('.env');
            
            if (!file_exists($envFile)) {
                return redirect()->back()
                    ->with('error', 'Le fichier de configuration .env est introuvable.');
            }
            
            $envContent = file_get_contents($envFile);
            $newPassword = $request->new_delete_password;
            
            // Mettre à jour ou ajouter DELETE_PASSWORD dans .env
            if (preg_match('/^DELETE_PASSWORD=.*$/m', $envContent)) {
                // Remplacer la valeur existante
                $envContent = preg_replace('/^DELETE_PASSWORD=.*$/m', 'DELETE_PASSWORD=' . $newPassword, $envContent);
            } else {
                // Ajouter à la fin du fichier
                $envContent .= "\nDELETE_PASSWORD=" . $newPassword . "\n";
            }
            
            // Écrire le fichier .env
            if (file_put_contents($envFile, $envContent) === false) {
                return redirect()->back()
                    ->with('error', 'Impossible d\'écrire dans le fichier de configuration. Vérifiez les permissions.');
            }
            
            // Vider le cache de configuration
            \Artisan::call('config:clear');
            
            return redirect()->back()
                ->with('success', 'Le mot de passe de suppression a été mis à jour avec succès.');
                
        } catch (\Exception $e) {
            Log::error('Erreur lors de la mise à jour du mot de passe de suppression', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du mot de passe. Veuillez réessayer.');
        }
    }

    public function profile()
    {
        return view('account.profile');
    }

    public function updateProfile(Request $request)
    {
        \Log::info('[UPDATE PROFILE] Début de la méthode', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()->role,
            'route_name' => request()->route()->getName(),
            'request_data' => $request->all(),
        ]);

        $user = Auth::user();

        try {
        $validated = $request->validate([
            'prenom' => 'nullable|string|max:255',
            'nom' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:255|unique:users,phone,' . $user->id,
            'location' => 'nullable|string|max:255',
                'nationalite' => 'nullable|string|max:2',
            'date_naissance' => 'nullable|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser une autre adresse email.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé. Veuillez utiliser un autre numéro.',
            'photo.image' => 'La photo doit être une image.',
            'photo.mimes' => 'La photo doit être au format JPEG, PNG, JPG ou GIF.',
            'photo.max' => '⚠️ La taille de la photo doit être inférieure à 2 MB. Veuillez choisir un fichier plus petit.',
        ]);

            \Log::info('[UPDATE PROFILE] Validation réussie', ['validated' => $validated]);

        // Mettre à jour le nom complet (name) si prénom et nom sont fournis
        if ($request->filled('prenom') && $request->filled('nom')) {
            $validated['name'] = trim($request->prenom . ' ' . $request->nom);
        }

        // Gérer l'upload de la photo
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $path = $request->file('photo')->store('avatars', 'public');
            $validated['photo'] = $path;
                \Log::info('[UPDATE PROFILE] Photo uploadée', ['path' => $path]);
        }

            // Mettre à jour tous les champs validés
        $user->update($validated);

            \Log::info('[UPDATE PROFILE] Utilisateur mis à jour', [
                'user_id' => $user->id,
                'updated_fields' => array_keys($validated),
            ]);

            // Déterminer la route de redirection selon la route actuelle
            $currentRoute = request()->route()->getName();
            $redirectRoute = 'account.settings';
            
            if ($user->role === 'admin' && strpos($currentRoute, 'admin.') === 0) {
                $redirectRoute = 'admin.settings';
            } elseif ($user->role === 'admin') {
                // Si admin mais route account, rediriger vers admin
                $redirectRoute = 'admin.settings';
            }

            \Log::info('[UPDATE PROFILE] Redirection', [
                'current_route' => $currentRoute,
                'user_role' => $user->role,
                'redirect_route' => $redirectRoute
            ]);

            return redirect()->route($redirectRoute)
            ->with('success', 'Profil mis à jour avec succès.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('[UPDATE PROFILE] Erreur de validation', [
                'errors' => $e->errors(),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('[UPDATE PROFILE] Erreur', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de la mise à jour du profil.')
                ->withInput();
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:6|confirmed',
            ], [
                'current_password.required' => 'Le mot de passe actuel est requis.',
                'new_password.required' => 'Le nouveau mot de passe est requis.',
                'new_password.min' => 'Le nouveau mot de passe doit contenir au moins 6 caractères.',
                'new_password.confirmed' => 'Les mots de passe ne correspondent pas.',
            ]);
        } catch (ValidationException $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['errors' => $e->errors()], 422);
            }
            throw $e;
        }

        // Vérifier le mot de passe actuel
        if (!Hash::check($request->current_password, $user->password)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'errors' => ['current_password' => ['Le mot de passe actuel est incorrect.']]
                ], 422);
            }
            throw ValidationException::withMessages([
                'current_password' => ['Le mot de passe actuel est incorrect.'],
            ]);
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Mot de passe mis à jour avec succès.']);
        }

        // Rediriger vers la bonne route selon le rôle de l'utilisateur
        if ($user->role === 'admin' && request()->routeIs('admin.settings.updatePassword')) {
            return redirect()->route('admin.settings')
                ->with('success', 'Mot de passe mis à jour avec succès.');
        }

        return redirect()->route('account.settings')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function invoice()
    {
        return view('account.invoice');
    }
}