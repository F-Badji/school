<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use App\Models\User;
use App\Models\Classe;
use App\Models\Event;
use App\Models\StudentResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Models\Favori;
use App\Models\ApprenantCoursStatut;
use App\Models\Cours;
use App\Models\DevoirTentative;
use App\Models\Devoir;
use App\Models\ExamenTentative;
use App\Models\Examen;
use App\Models\Message;
use App\Models\ForumGroup;
use App\Models\VideoSession;

class ApprenantDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Vérification de sécurité supplémentaire
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification de sécurité basée sur le rôle uniquement
        // Vérifier que l'utilisateur est un apprenant
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
        
        // SÉCURITÉ CRITIQUE : Vérifier que l'orientation est complète et le paiement effectué
        if (!$user->orientation_complete) {
            \Log::warning('Tentative d\'accès au dashboard sans orientation complète', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return redirect()->route('orientation.show')->with('error', 'Vous devez compléter votre orientation avant d\'accéder au tableau de bord.');
        }
        
        // Vérifier que la filière est définie (sécurité supplémentaire)
        if (!$user->filiere) {
            \Log::warning('Tentative d\'accès au dashboard sans filière définie', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            return redirect()->route('orientation.show')->with('error', 'Vous devez sélectionner une filière avant d\'accéder au tableau de bord.');
        }
        
        // Vérifier que le paiement est effectué (sécurité anti-fraude)
        if ($user->paiement_statut !== 'effectué') {
            \Log::warning('Tentative d\'accès au dashboard sans paiement effectué', [
                'user_id' => $user->id,
                'email' => $user->email,
                'paiement_statut' => $user->paiement_statut,
            ]);
            return redirect()->route('orientation.show')->with('error', 'Vous devez effectuer le paiement des frais d\'inscription avant d\'accéder au tableau de bord.');
        }
        
        // Récupérer les matières filtrées par la filière et la classe de l'étudiant
        $matieres = collect();
        
        try {
            // Mapper classe_id de l'étudiant (licence_1, licence_2, licence_3) vers niveau_etude des matières (Licence 1, Licence 2, Licence 3)
            $classeToNiveauMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3'
            ];
            
            $niveauEtude = null;
            if ($user->classe_id && isset($classeToNiveauMap[$user->classe_id])) {
                $niveauEtude = $classeToNiveauMap[$user->classe_id];
            }
            
            // Construire la requête avec filtres
            $query = Matiere::query();
            
            // Filtrer par filière si l'étudiant a une filière
            if ($user->filiere) {
                $query->where('filiere', $user->filiere);
            }
            
            // Filtrer par niveau d'étude si l'étudiant a une classe assignée
            if ($niveauEtude) {
                $query->where('niveau_etude', $niveauEtude);
            }
            
            $matieres = $query->get();
            
            // Log pour debug (à retirer en production)
            \Log::info('Filtrage des matières pour l\'étudiant', [
                'user_id' => $user->id,
                'email' => $user->email,
                'filiere' => $user->filiere,
                'classe_id' => $user->classe_id,
                'niveau_etude' => $niveauEtude,
                'matieres_count' => $matieres->count(),
                'matieres' => $matieres->pluck('nom_matiere')->toArray()
            ]);
            
            } catch (\Exception $e) {
            \Log::error('Erreur lors de la récupération des matières', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);
                $matieres = collect();
        }
        
        // Pour chaque matière, récupérer les formateurs associés
        $matieresAvecFormateurs = collect();
        
        foreach ($matieres as $matiere) {
            // Récupérer l'ID de la matière (peut être un objet ou un array)
            $matiereId = null;
            if (is_object($matiere)) {
                $matiereId = $matiere->id ?? null;
            } elseif (is_array($matiere)) {
                $matiereId = $matiere['id'] ?? null;
            }
            
            if (!$matiereId) {
                continue; // Passer à la matière suivante si pas d'ID
            }
            
            // Récupérer le nom de la matière d'abord
            $nomMatiere = '';
            if (is_object($matiere)) {
                $nomMatiere = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? 'Matière';
            } elseif (is_array($matiere)) {
                $nomMatiere = $matiere['nom_matiere'] ?? $matiere['nom'] ?? $matiere['libelle'] ?? $matiere['name'] ?? 'Matière';
            }
            
            // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
            try {
                // Vérifier que l'étudiant a une classe ET une filière assignées
                if (!$user->classe_id || !$user->filiere) {
                    \Log::warning('⚠️ Étudiant sans classe ou filière assignée - Aucun formateur ne sera affiché', [
                        'etudiant_email' => $user->email,
                        'etudiant_classe_id' => $user->classe_id,
                        'etudiant_filiere' => $user->filiere,
                        'matiere_id' => $matiereId,
                        'matiere_nom' => $nomMatiere
                    ]);
                    $formateurs = collect();
                    continue; // Passer à la matière suivante
                }
                
                // Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                $formateursQuery = DB::table('formateur_matiere')
                    ->join('users', 'formateur_matiere.user_id', '=', 'users.id')
                    ->where('formateur_matiere.matiere_id', $matiereId)
                    ->where('users.role', 'teacher')
                    ->where('users.classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                    ->where('users.filiere', '=', $user->filiere); // SÉCURITÉ : Même filière
                
                $formateurs = $formateursQuery->select('users.*')->get();
                
                // Vérification supplémentaire de sécurité : double vérification manuelle
                $formateurs = $formateurs->filter(function($formateur) use ($user) {
                    $formateurClasseId = $formateur->classe_id ?? null;
                    $formateurFiliere = $formateur->filiere ?? null;
                    $etudiantClasseId = $user->classe_id;
                    $etudiantFiliere = $user->filiere;
                    
                    // Vérifier classe ET filière (les deux doivent correspondre)
                    if ($formateurClasseId !== $etudiantClasseId || $formateurFiliere !== $etudiantFiliere) {
                        \Log::warning('🚫 Formateur rejeté - Classe ou filière ne correspond pas', [
                            'formateur_id' => $formateur->id,
                            'formateur_email' => $formateur->email ?? 'N/A',
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
                
                \Log::info('✅ Formateurs validés (classe + filière) pour la matière', [
                    'etudiant_email' => $user->email,
                    'etudiant_classe_id' => $user->classe_id,
                    'etudiant_filiere' => $user->filiere,
                    'matiere_id' => $matiereId,
                    'matiere_nom' => $nomMatiere,
                    'formateurs_count' => $formateurs->count(),
                    'formateurs' => $formateurs->map(function($f) {
                        return [
                            'id' => $f->id,
                            'nom' => ($f->nom ?? '') . ' ' . ($f->prenom ?? ''),
                            'email' => $f->email ?? '',
                            'classe_id' => $f->classe_id ?? 'N/A',
                            'filiere' => $f->filiere ?? 'N/A'
                        ];
                    })->toArray()
                ]);
                
            } catch (\Exception $e) {
                \Log::error('❌ Erreur lors de la récupération des formateurs', [
                    'error' => $e->getMessage(),
                    'etudiant_email' => $user->email,
                    'matiere_id' => $matiereId,
                    'user_id' => $user->id,
                    'etudiant_classe_id' => $user->classe_id,
                    'etudiant_filiere' => $user->filiere,
                    'trace' => $e->getTraceAsString()
                ]);
                $formateurs = collect();
            }
            
            // Si pas de formateur, créer une entrée vide pour quand même afficher la matière
            if ($formateurs->isEmpty()) {
                $formateurs = collect([(object)['name' => 'Professeur', 'prenom' => '', 'nom' => '', 'photo' => null, 'id' => null]]);
            }
            
            // Pour chaque formateur, créer une entrée matière-formateur
            foreach ($formateurs as $formateur) {
                $matieresAvecFormateurs->push([
                    'matiere' => $matiere,
                    'formateur' => $formateur,
                    'nom_matiere' => $nomMatiere,
                ]);
            }
        }
        
        // Récupérer les statistiques pour le dashboard
        // Événements à venir (depuis la table events créée dans le calendrier)
        // Filtrer par la classe de l'apprenant
        $evenementsAvenir = Event::with('matiere')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', Carbon::now());
        
        // Filtrer par classe si l'apprenant a une classe assignée
        if ($user->classe_id) {
            // Mapper classe_id de l'apprenant (licence_1, licence_2, licence_3) vers le format de events (Licence 1, Licence 2, Licence 3)
            $classeMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3'
            ];
            $classeEvent = $classeMap[$user->classe_id] ?? null;
            
            if ($classeEvent) {
                $evenementsAvenir->where('classe_id', $classeEvent);
            }
        }
        
        $evenementsAvenir = $evenementsAvenir->get();
        
        // Récupérer les devoirs et examens programmés pour l'apprenant
        // Récupérer les formateurs avec la même classe et filière que l'apprenant
        $formateursIds = [];
        if ($user->classe_id && $user->filiere) {
            $formateursIds = User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->pluck('id')
                ->toArray();
        }
        
        // Récupérer les devoirs programmés (actifs et avec date future)
        $devoirsProgrammes = collect();
        if (!empty($formateursIds)) {
            $devoirs = Devoir::whereIn('formateur_id', $formateursIds)
                ->where('actif', true)
                ->whereNotNull('date_devoir')
                ->where('date_devoir', '>=', Carbon::now()->startOfDay())
                ->with('matiere')
            ->get();
            
            foreach ($devoirs as $devoir) {
                // Créer une date/heure complète pour le devoir
                $dateDevoir = Carbon::parse($devoir->date_devoir);
                $heureDebut = $devoir->heure_debut ? Carbon::parse($devoir->heure_debut)->format('H:i') : '08:00';
                $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', $dateDevoir->format('Y-m-d') . ' ' . $heureDebut);
                
                if ($scheduledAt >= Carbon::now()) {
                    $devoirsProgrammes->push((object)[
                        'id' => 'devoir_' . $devoir->id,
                        'titre' => $devoir->titre,
                        'type' => 'Devoir',
                        'scheduled_at' => $scheduledAt->toDateTimeString(),
                        'matiere' => $devoir->matiere,
                    ]);
                }
            }
        }
        
        // Récupérer les examens programmés (actifs et avec date future)
        $examensProgrammes = collect();
        if (!empty($formateursIds)) {
            $examens = Examen::whereIn('formateur_id', $formateursIds)
                ->where('actif', true)
                ->whereNotNull('date_examen')
                ->where('date_examen', '>=', Carbon::now()->startOfDay())
                ->with('matiere')
                ->get();
            
            foreach ($examens as $examen) {
                // Créer une date/heure complète pour l'examen
                $dateExamen = Carbon::parse($examen->date_examen);
                $heureDebut = $examen->heure_debut ? Carbon::parse($examen->heure_debut)->format('H:i') : '08:00';
                $scheduledAt = Carbon::createFromFormat('Y-m-d H:i', $dateExamen->format('Y-m-d') . ' ' . $heureDebut);
                
                if ($scheduledAt >= Carbon::now()) {
                    $examensProgrammes->push((object)[
                        'id' => 'examen_' . $examen->id,
                        'titre' => $examen->titre,
                        'type' => 'Examen',
                        'scheduled_at' => $scheduledAt->toDateTimeString(),
                        'matiere' => $examen->matiere,
                    ]);
                }
            }
        }
        
        // Fusionner tous les événements (événements admin + devoirs + examens)
        // Ne pas limiter le nombre pour afficher tous les devoirs programmés
        $tousEvenements = $evenementsAvenir
            ->concat($devoirsProgrammes)
            ->concat($examensProgrammes)
            ->sortBy('scheduled_at')
            ->values();
        
        // Statistiques des notes (Devoir, Examen, Quiz)
        // SÉCURITÉ : Compter uniquement les devoirs soumis par l'apprenant connecté
        // Utiliser DevoirTentative pour avoir le nombre réel de devoirs complétés
        $totalDevoirs = DevoirTentative::where('user_id', $user->id)
            ->where('soumis', true)
            ->count();
        
        // SÉCURITÉ : Calculer le total des devoirs disponibles pour l'apprenant
        // Récupérer les formateurs avec la même classe et filière que l'apprenant
        $formateursIds = [];
        if ($user->classe_id && $user->filiere) {
            $formateursIds = \App\Models\User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->pluck('id')
                ->toArray();
        }
        
        // Récupérer le total des devoirs actifs disponibles pour l'apprenant
        $totalDevoirsDisponibles = 0;
        if (!empty($formateursIds)) {
            $totalDevoirsDisponibles = Devoir::whereIn('formateur_id', $formateursIds)
                ->where('actif', true)
            ->count();
        }
        
        // Calculer le pourcentage de progression
        // Pour le premier devoir (1 devoir), la barre doit être à 0.9%
        if ($totalDevoirs == 1) {
            // Pour le premier devoir, toujours afficher 0.9%
            $pourcentageProgression = 0.9;
        } elseif ($totalDevoirs > 0 && $totalDevoirsDisponibles > 0) {
            // Pour les autres cas, calculer normalement
            $pourcentageProgression = ($totalDevoirs / $totalDevoirsDisponibles) * 100;
        } else {
            $pourcentageProgression = 0;
        }
        
        // SÉCURITÉ : Compter uniquement les examens soumis par l'apprenant connecté
        // Utiliser ExamenTentative pour avoir le nombre réel d'examens complétés
        $totalExamens = ExamenTentative::where('user_id', $user->id)
            ->where('soumis', true)
            ->count();
        
        // SÉCURITÉ : Calculer le total des examens disponibles pour l'apprenant
        // Utiliser les mêmes formateursIds déjà calculés pour les devoirs
        $totalExamensDisponibles = 0;
        if (!empty($formateursIds)) {
            $totalExamensDisponibles = Examen::whereIn('formateur_id', $formateursIds)
                ->where('actif', true)
                ->count();
        }
        
        // Calculer le pourcentage de progression pour les examens
        // Pour le premier examen (1 examen), la barre doit être à 0.9%
        if ($totalExamens == 1) {
            // Pour le premier examen, toujours afficher 0.9%
            $pourcentageProgressionExamens = 0.9;
        } elseif ($totalExamens > 0 && $totalExamensDisponibles > 0) {
            // Pour les autres cas, calculer normalement
            $pourcentageProgressionExamens = ($totalExamens / $totalExamensDisponibles) * 100;
        } else {
            $pourcentageProgressionExamens = 0;
        }
        
        // SÉCURITÉ : Compter uniquement les quiz complétés par l'apprenant connecté
        // Utiliser QuizAttempt pour avoir le nombre réel de quiz complétés
        // Compter les combinaisons uniques de cours_id + section_index complétées
        // Récupérer toutes les tentatives complétées et compter les combinaisons uniques
        $quizAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->select('cours_id', 'section_index')
            ->get();
        
        // Compter les combinaisons uniques (cours_id, section_index)
        $uniqueQuizCombinations = $quizAttempts->map(function($attempt) {
            return $attempt->cours_id . '-' . $attempt->section_index;
        })->unique();
        
        $totalQuiz = $uniqueQuizCombinations->count();
        
        // SÉCURITÉ : Calculer le total des quiz disponibles pour l'apprenant
        // Récupérer les cours actifs des formateurs de la même classe et filière
        $totalQuizDisponibles = 0;
        if (!empty($formateursIds)) {
            // Récupérer tous les cours actifs des formateurs
            $coursDisponibles = Cours::whereIn('formateur_id', $formateursIds)
                ->where('actif', true)
                ->get();
            
            // Compter les sections avec quiz dans chaque cours
            foreach ($coursDisponibles as $cours) {
                if ($cours->contenu && is_array($cours->contenu)) {
                    foreach ($cours->contenu as $index => $section) {
                        // Vérifier si la section a un quiz en vérifiant :
                        // 1. Si duree_quiz_heures ou duree_quiz_minutes est défini et > 0
                        // 2. Si des questions existent dans la table questions pour ce cours et cette section
                        $hasQuizDuration = (isset($section['duree_quiz_heures']) && $section['duree_quiz_heures'] > 0) 
                            || (isset($section['duree_quiz_minutes']) && $section['duree_quiz_minutes'] > 0)
                            || (isset($section['duree_quiz']) && $section['duree_quiz'] > 0);
                        
                        // Vérifier si des questions existent pour ce cours et cette section
                        $hasQuestions = \App\Models\Question::where('cours_id', $cours->id)
                            ->where('section_index', $index)
                            ->exists();
                        
                        if ($hasQuizDuration || $hasQuestions) {
                            $totalQuizDisponibles++;
                        }
                    }
                }
            }
        }
        
        // Calculer le pourcentage de progression pour les quiz
        // Pour le premier quiz (1 quiz), la barre doit être à 0.9%
        if ($totalQuiz == 1) {
            // Pour le premier quiz, toujours afficher 0.9%
            $pourcentageProgressionQuiz = 0.9;
        } elseif ($totalQuiz > 0 && $totalQuizDisponibles > 0) {
            // Pour les autres cas, calculer normalement
            $pourcentageProgressionQuiz = ($totalQuiz / $totalQuizDisponibles) * 100;
        } else {
            $pourcentageProgressionQuiz = 0;
        }
        
        // Calculer les absences (simulation - à adapter selon votre logique métier)
        // Pour l'instant, on peut utiliser une valeur par défaut ou calculer depuis une table d'absences si elle existe
        $totalAbsents = 0; // À adapter selon votre logique
        
        // Statistiques pour les graphiques (performance sur les derniers mois)
        // Calculer les moyennes de notes normalisées (0.1 à 1.0) par mois
        $performanceData = [];
        for ($i = 9; $i >= 0; $i--) {
            $monthStart = Carbon::now()->subMonths($i)->startOfMonth();
            $monthEnd = Carbon::now()->subMonths($i)->endOfMonth();
            
            // SÉCURITÉ : Récupérer les notes de devoirs de l'apprenant pour ce mois
            $notesDevoirs = StudentResult::where('user_id', $user->id)
                ->whereNotNull('devoir')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->pluck('devoir')
                ->filter(function($note) {
                    return $note !== null && $note > 0;
                });
            
            // SÉCURITÉ : Récupérer les notes d'examens de l'apprenant pour ce mois
            $notesExamens = StudentResult::where('user_id', $user->id)
                ->whereNotNull('examen')
                ->whereBetween('created_at', [$monthStart, $monthEnd])
                ->pluck('examen')
                ->filter(function($note) {
                    return $note !== null && $note > 0;
                });
            
            // Calculer la moyenne des notes de devoirs sur 20
            // Si pas de notes, utiliser 0
            $moyenneDevoirs = 0;
            if ($notesDevoirs->count() > 0) {
                $moyenneDevoirs = $notesDevoirs->avg();
            }
            
            // Calculer la moyenne des notes d'examens sur 20
            // Si pas de notes, utiliser 0
            $moyenneExamens = 0;
            if ($notesExamens->count() > 0) {
                $moyenneExamens = $notesExamens->avg();
            }
            
            $performanceData[] = [
                'week' => 'Mois ' . (10 - $i),
                'devoirs' => round($moyenneDevoirs, 2),
                'examens' => round($moyenneExamens, 2),
            ];
        }
        
        // Vérifier quelle route est appelée pour retourner la bonne vue
        $routeName = request()->route()->getName();
        
        if ($routeName === 'apprenant.cours') {
            // Récupérer les favoris de l'utilisateur
            $favoris = Favori::where('user_id', $user->id)->get();
            $favorisMap = $favoris->mapWithKeys(function($favori) {
                return [$favori->formateur_id . '_' . $favori->matiere_nom => true];
            })->toArray();
            $favorisCount = $favoris->count();
            
            // Récupérer les statuts des cours pour cet apprenant
            $statuts = ApprenantCoursStatut::where('user_id', $user->id)->get();
            $statutsMap = $statuts->mapWithKeys(function($statut) {
                return [$statut->formateur_id . '_' . $statut->matiere_nom => $statut->statut];
            })->toArray();
            
            // Compter les cadres par statut
            $totalCadres = count($matieresAvecFormateurs ?? []);
            $enCoursCount = 0;
            $termineCount = 0;
            $enregistreCount = 0;
            
            foreach ($matieresAvecFormateurs ?? [] as $item) {
                $formateur = $item['formateur'];
                $nomMatiere = $item['nom_matiere'];
                $formateurId = $formateur->id ?? null;
                
                if ($formateurId) {
                    $key = $formateurId . '_' . $nomMatiere;
                    $statut = $statutsMap[$key] ?? null;
                    
                    if ($statut === 'en_cours') {
                        $enCoursCount++;
                    } elseif ($statut === 'termine') {
                        $termineCount++;
                    } elseif ($statut === 'enregistre') {
                        $enregistreCount++;
                    } else {
                        // Si pas de statut défini, considérer comme "en cours" par défaut
                        $enCoursCount++;
                    }
                } else {
                    // Si pas de formateur ID, considérer comme "en cours"
                    $enCoursCount++;
                }
            }
            
            // Pour la route "Cours", utiliser l'ancienne interface avec les professeurs
            return view('apprenant.cours-old', compact('user', 'matieres', 'matieresAvecFormateurs', 'favorisMap', 'favorisCount', 'totalCadres', 'statutsMap', 'enCoursCount', 'termineCount', 'enregistreCount'));
        }
        
        // Récupérer les autres apprenants (même filière et niveau, excluant l'utilisateur actuel)
        // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
        $autresApprenants = collect();
        if ($user->filiere && $user->niveau_etude) {
            try {
                $autresApprenants = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('id', '!=', $user->id)
                    ->where('filiere', $user->filiere)
                    ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->where(function($q) use ($user) {
                        $niveau = strtolower($user->niveau_etude);
                        $q->where('niveau_etude', $user->niveau_etude)
                          ->orWhere('niveau_etude', 'LIKE', '%' . $niveau . '%')
                          ->orWhere('niveau_etude', 'LIKE', '%' . ucfirst($niveau) . '%');
                    })
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->limit(20)
                    ->get();
            } catch (\Exception $e) {
                $autresApprenants = collect();
            }
        }
        
        // Pour la route "Dashboard", utiliser la nouvelle interface avec statistiques
        return view('apprenant.dashboard', compact(
            'user', 
            'matieres', 
            'matieresAvecFormateurs',
            'tousEvenements',
            'totalDevoirs',
            'totalDevoirsDisponibles',
            'pourcentageProgression',
            'totalExamens',
            'totalExamensDisponibles',
            'pourcentageProgressionExamens',
            'totalQuiz',
            'totalQuizDisponibles',
            'pourcentageProgressionQuiz',
            'totalAbsents',
            'performanceData',
            'autresApprenants'
        ));
    }
    
    public function professeurInformatiqueGestion()
    {
        $user = Auth::user();
        
        // Vérification de sécurité supplémentaire
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification de sécurité basée sur le rôle uniquement
        // Vérifier que l'utilisateur est un apprenant
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
        
        // Récupérer uniquement la matière "Introduction à l'Informatique de Gestion"
        $matiereNom = 'Introduction à l\'Informatique de Gestion';
        
        try {
            $matieres = DB::table('matieres')
                ->where('nom_matiere', 'like', '%' . $matiereNom . '%')
                ->orWhere('nom_matiere', 'like', '%Informatique de Gestion%')
                ->orWhere('nom_matiere', 'like', '%informatique de gestion%')
                ->get();
        } catch (\Exception $e) {
            try {
                $matieres = Matiere::where('nom_matiere', 'like', '%' . $matiereNom . '%')
                    ->orWhere('nom_matiere', 'like', '%Informatique de Gestion%')
                    ->orWhere('nom_matiere', 'like', '%informatique de gestion%')
                    ->get();
            } catch (\Exception $e2) {
                $matieres = collect();
            }
        }
        
        // Si toujours vide, essayer de récupérer toutes les matières et filtrer en PHP
        if ($matieres->isEmpty()) {
            try {
                $allMatieres = DB::table('matieres')->get();
                $matieres = $allMatieres->filter(function($matiere) use ($matiereNom) {
                    $nom = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? '';
                    return stripos($nom, 'informatique de gestion') !== false || 
                           stripos($nom, 'introduction à l\'informatique') !== false;
                })->values();
            } catch (\Exception $e) {
                $matieres = collect();
            }
        }
        
        // Pour chaque matière, récupérer les formateurs associés
        $matieresAvecFormateurs = collect();
        
        foreach ($matieres as $matiere) {
            // Récupérer l'ID de la matière
            $matiereId = null;
            if (is_object($matiere)) {
                $matiereId = $matiere->id ?? null;
            } elseif (is_array($matiere)) {
                $matiereId = $matiere['id'] ?? null;
            }
            
            if (!$matiereId) {
                continue;
            }
            
            // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
            try {
                // Vérifier que l'étudiant a une classe ET une filière assignées
                if (!$user->classe_id || !$user->filiere) {
                    $formateurs = collect();
                } else {
                    // Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                $formateurs = DB::table('formateur_matiere')
                    ->join('users', 'formateur_matiere.user_id', '=', 'users.id')
                    ->where('formateur_matiere.matiere_id', $matiereId)
                    ->where('users.role', 'teacher')
                        ->where('users.classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                        ->where('users.filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                    ->select('users.*')
                    ->get();
                    
                    // Vérification supplémentaire de sécurité
                    $formateurs = $formateurs->filter(function($formateur) use ($user) {
                        return ($formateur->classe_id ?? null) === $user->classe_id && 
                               ($formateur->filiere ?? null) === $user->filiere;
                    })->values();
                }
            } catch (\Exception $e) {
                $formateurs = collect();
            }
            
            // Récupérer le nom de la matière
            $nomMatiere = '';
            if (is_object($matiere)) {
                $nomMatiere = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? 'Matière';
            } elseif (is_array($matiere)) {
                $nomMatiere = $matiere['nom_matiere'] ?? $matiere['nom'] ?? $matiere['libelle'] ?? $matiere['name'] ?? 'Matière';
            }
            
            // Si pas de formateur, créer une entrée vide pour quand même afficher la matière
            if ($formateurs->isEmpty()) {
                $formateurs = collect([(object)['name' => 'Professeur', 'prenom' => '', 'nom' => '', 'photo' => null]]);
            }
            
            // Pour chaque formateur, créer une entrée matière-formateur
            foreach ($formateurs as $formateur) {
                $matieresAvecFormateurs->push([
                    'matiere' => $matiere,
                    'formateur' => $formateur,
                    'nom_matiere' => $nomMatiere,
                ]);
            }
        }
        
        // Récupérer les apprenants de Licence 1 selon la filière de l'utilisateur connecté
        $apprenantsLicence1 = collect();
        
        if ($user->filiere) {
            try {
                // Récupérer les apprenants qui ont la même filière et sont en Licence 1
                // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
                $apprenantsLicence1 = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('filiere', $user->filiere)
                    ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->where(function($q) {
                        $q->where('niveau_etude', 'Licence 1')
                          ->orWhere('niveau_etude', 'licence 1')
                          ->orWhere('niveau_etude', 'L1')
                          ->orWhere('niveau_etude', 'l1')
                          ->orWhere('niveau_etude', 'LIKE', '%licence 1%')
                          ->orWhere('niveau_etude', 'LIKE', '%Licence 1%');
                    })
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
            } catch (\Exception $e) {
                // Si erreur, essayer avec une requête plus simple
                try {
                    $apprenantsLicence1 = User::where(function($q) {
                            $q->where('role', 'student')->orWhereNull('role');
                        })
                        ->where('filiere', $user->filiere)
                        ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                        ->where('niveau_etude', 'LIKE', '%licence 1%')
                        ->orderBy('nom')
                        ->orderBy('prenom')
                        ->get();
                } catch (\Exception $e2) {
                    $apprenantsLicence1 = collect();
                }
            }
            
            // Si toujours vide, essayer de récupérer via les classes
            if ($apprenantsLicence1->isEmpty()) {
                try {
                    $classeLicence1 = Classe::where('filiere', $user->filiere)
                        ->where(function($q) {
                            $q->where('niveau_etude', 'Licence 1')
                              ->orWhere('niveau_etude', 'licence 1')
                              ->orWhere('niveau_etude', 'L1')
                              ->orWhere('niveau_etude', 'LIKE', '%licence 1%');
                        })
                        ->first();
                    
                    if ($classeLicence1) {
                        $apprenantsLicence1 = $classeLicence1->apprenants()
                            ->orderBy('nom')
                            ->orderBy('prenom')
                            ->get();
                    }
                } catch (\Exception $e) {
                    $apprenantsLicence1 = collect();
                }
            }
        }
        
        // Utiliser la même vue que cours-old mais avec les données filtrées
        return view('apprenant.professeur-informatique-gestion', compact('user', 'matieres', 'matieresAvecFormateurs', 'apprenantsLicence1'));
    }
    
    public function coursEditeur(Request $request)
    {
        $user = Auth::user();
        
        // Vérification de sécurité supplémentaire
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification de sécurité basée sur le rôle uniquement
        // Vérifier que l'utilisateur est un apprenant
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
        
        // Récupérer le cours et la section depuis la requête
        $coursId = $request->get('cours_id');
        $sectionIndex = $request->get('section', 0);
        $week = $request->get('week', 1); // Pour compatibilité avec l'ancien système
        
        $cours = null;
        $section = null;
        
        // Si un ID de cours est fourni, récupérer le cours et la section correspondante
        if ($coursId) {
            $cours = \App\Models\Cours::where('id', $coursId)
                ->where('actif', true)
                ->first();
            
            if ($cours && $cours->contenu && is_array($cours->contenu) && isset($cours->contenu[$sectionIndex])) {
                $section = $cours->contenu[$sectionIndex];
            }
        }
        
        return view('apprenant.cours-editeur', compact('user', 'week', 'cours', 'section', 'sectionIndex'));
    }
    
    public function professeurProgrammationPhp()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        $matiereNom = 'Programmation en PHP';
        
        try {
            $matieres = DB::table('matieres')
                ->where('nom_matiere', 'like', '%' . $matiereNom . '%')
                ->orWhere('nom_matiere', 'like', '%PHP%')
                ->orWhere('nom_matiere', 'like', '%php%')
                ->get();
        } catch (\Exception $e) {
            try {
                $matieres = Matiere::where('nom_matiere', 'like', '%' . $matiereNom . '%')
                    ->orWhere('nom_matiere', 'like', '%PHP%')
                    ->orWhere('nom_matiere', 'like', '%php%')
                    ->get();
            } catch (\Exception $e2) {
                $matieres = collect();
            }
        }
        
        if ($matieres->isEmpty()) {
            try {
                $allMatieres = DB::table('matieres')->get();
                $matieres = $allMatieres->filter(function($matiere) {
                    $nom = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? '';
                    return stripos($nom, 'php') !== false || stripos($nom, 'programmation') !== false;
                })->values();
            } catch (\Exception $e) {
                $matieres = collect();
            }
        }
        
        $matieresAvecFormateurs = collect();
        foreach ($matieres as $matiere) {
            $matiereId = null;
            if (is_object($matiere)) {
                $matiereId = $matiere->id ?? null;
            } elseif (is_array($matiere)) {
                $matiereId = $matiere['id'] ?? null;
            }
            
            if (!$matiereId) {
                continue;
            }
            
            // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
            try {
                // Vérifier que l'étudiant a une classe ET une filière assignées
                if (!$user->classe_id || !$user->filiere) {
                    $formateurs = collect();
                } else {
                    // Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                $formateurs = DB::table('formateur_matiere')
                    ->join('users', 'formateur_matiere.user_id', '=', 'users.id')
                    ->where('formateur_matiere.matiere_id', $matiereId)
                    ->where('users.role', 'teacher')
                        ->where('users.classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                        ->where('users.filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                    ->select('users.*')
                    ->get();
                    
                    // Vérification supplémentaire de sécurité
                    $formateurs = $formateurs->filter(function($formateur) use ($user) {
                        return ($formateur->classe_id ?? null) === $user->classe_id && 
                               ($formateur->filiere ?? null) === $user->filiere;
                    })->values();
                }
            } catch (\Exception $e) {
                $formateurs = collect();
            }
            
            $nomMatiere = '';
            if (is_object($matiere)) {
                $nomMatiere = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? 'Matière';
            } elseif (is_array($matiere)) {
                $nomMatiere = $matiere['nom_matiere'] ?? $matiere['nom'] ?? $matiere['libelle'] ?? $matiere['name'] ?? 'Matière';
            }
            
            if ($formateurs->isEmpty()) {
                $formateurs = collect([(object)['name' => 'Professeur', 'prenom' => '', 'nom' => '', 'photo' => null]]);
            }
            
            foreach ($formateurs as $formateur) {
                // Récupérer le cours pour ce formateur et cette matière
                $formateurId = is_object($formateur) ? ($formateur->id ?? null) : null;
                $cours = null;
                
                if ($formateurId) {
                    // Mapper classe_id vers niveau_etude
                    $classeToNiveauMap = [
                        'licence_1' => 'Licence 1',
                        'licence_2' => 'Licence 2',
                        'licence_3' => 'Licence 3'
                    ];
                    $niveauEtude = isset($classeToNiveauMap[$user->classe_id ?? '']) ? $classeToNiveauMap[$user->classe_id] : null;
                    
                    // Récupérer le cours le plus récent pour ce formateur, cette matière et cette filière
                    $cours = Cours::with(['formateur.matieres', 'questions'])
                        ->where('formateur_id', $formateurId)
                        ->where('filiere', $user->filiere)
                        ->where('actif', true)
                        ->when($niveauEtude, function($q) use ($niveauEtude) {
                            return $q->where('niveau_etude', $niveauEtude);
                        })
                        ->orderBy('updated_at', 'desc')
                        ->first();
                }
                
                $matieresAvecFormateurs->push([
                    'matiere' => $matiere,
                    'formateur' => $formateur,
                    'nom_matiere' => $nomMatiere,
                    'cours' => $cours,
                ]);
            }
        }
        
        $apprenantsLicence1 = collect();
        if ($user->filiere) {
            try {
                // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
                $apprenantsLicence1 = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('filiere', $user->filiere)
                    ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->where(function($q) {
                        $q->where('niveau_etude', 'Licence 1')
                          ->orWhere('niveau_etude', 'licence 1')
                          ->orWhere('niveau_etude', 'L1')
                          ->orWhere('niveau_etude', 'l1')
                          ->orWhere('niveau_etude', 'LIKE', '%licence 1%')
                          ->orWhere('niveau_etude', 'LIKE', '%Licence 1%');
                    })
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
            } catch (\Exception $e) {
                try {
                    $apprenantsLicence1 = User::where(function($q) {
                            $q->where('role', 'student')->orWhereNull('role');
                        })
                        ->where('filiere', $user->filiere)
                        ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                        ->where('niveau_etude', 'LIKE', '%licence 1%')
                        ->orderBy('nom')
                        ->orderBy('prenom')
                        ->get();
                } catch (\Exception $e2) {
                    $apprenantsLicence1 = collect();
                }
            }
            
            if ($apprenantsLicence1->isEmpty()) {
                try {
                    $classeLicence1 = Classe::where('filiere', $user->filiere)
                        ->where(function($q) {
                            $q->where('niveau_etude', 'Licence 1')
                              ->orWhere('niveau_etude', 'licence 1')
                              ->orWhere('niveau_etude', 'L1')
                              ->orWhere('niveau_etude', 'LIKE', '%licence 1%');
                        })
                        ->first();
                    
                    if ($classeLicence1) {
                        $apprenantsLicence1 = $classeLicence1->apprenants()
                            ->orderBy('nom')
                            ->orderBy('prenom')
                            ->get();
                    }
                } catch (\Exception $e) {
                    $apprenantsLicence1 = collect();
                }
            }
        }
        
        // Récupérer le cours principal (le plus récent) pour l'affichage
        $coursPrincipal = null;
        if ($matieresAvecFormateurs->isNotEmpty()) {
            $premierItem = $matieresAvecFormateurs->first();
            $coursPrincipal = $premierItem['cours'] ?? null;
        }
        
        return view('apprenant.professeur-programmation-php', compact('user', 'matieres', 'matieresAvecFormateurs', 'apprenantsLicence1', 'coursPrincipal'));
    }
    
    public function professeurAlgorithmes()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        $matiereNom = 'Algorithmes';
        
        try {
            $matieres = DB::table('matieres')
                ->where('nom_matiere', 'like', '%' . $matiereNom . '%')
                ->orWhere('nom_matiere', 'like', '%Algorithme%')
                ->orWhere('nom_matiere', 'like', '%algorithme%')
                ->get();
        } catch (\Exception $e) {
            try {
                $matieres = Matiere::where('nom_matiere', 'like', '%' . $matiereNom . '%')
                    ->orWhere('nom_matiere', 'like', '%Algorithme%')
                    ->orWhere('nom_matiere', 'like', '%algorithme%')
                    ->get();
            } catch (\Exception $e2) {
                $matieres = collect();
            }
        }
        
        if ($matieres->isEmpty()) {
            try {
                $allMatieres = DB::table('matieres')->get();
                $matieres = $allMatieres->filter(function($matiere) {
                    $nom = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? '';
                    return stripos($nom, 'algorithme') !== false;
                })->values();
            } catch (\Exception $e) {
                $matieres = collect();
            }
        }
        
        $matieresAvecFormateurs = collect();
        foreach ($matieres as $matiere) {
            $matiereId = null;
            if (is_object($matiere)) {
                $matiereId = $matiere->id ?? null;
            } elseif (is_array($matiere)) {
                $matiereId = $matiere['id'] ?? null;
            }
            
            if (!$matiereId) {
                continue;
            }
            
            // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
            try {
                // Vérifier que l'étudiant a une classe ET une filière assignées
                if (!$user->classe_id || !$user->filiere) {
                    $formateurs = collect();
                } else {
                    // Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                $formateurs = DB::table('formateur_matiere')
                    ->join('users', 'formateur_matiere.user_id', '=', 'users.id')
                    ->where('formateur_matiere.matiere_id', $matiereId)
                    ->where('users.role', 'teacher')
                        ->where('users.classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                        ->where('users.filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                    ->select('users.*')
                    ->get();
                    
                    // Vérification supplémentaire de sécurité
                    $formateurs = $formateurs->filter(function($formateur) use ($user) {
                        return ($formateur->classe_id ?? null) === $user->classe_id && 
                               ($formateur->filiere ?? null) === $user->filiere;
                    })->values();
                }
            } catch (\Exception $e) {
                $formateurs = collect();
            }
            
            $nomMatiere = '';
            if (is_object($matiere)) {
                $nomMatiere = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? 'Matière';
            } elseif (is_array($matiere)) {
                $nomMatiere = $matiere['nom_matiere'] ?? $matiere['nom'] ?? $matiere['libelle'] ?? $matiere['name'] ?? 'Matière';
            }
            
            if ($formateurs->isEmpty()) {
                $formateurs = collect([(object)['name' => 'Professeur', 'prenom' => '', 'nom' => '', 'photo' => null]]);
            }
            
            foreach ($formateurs as $formateur) {
                // Récupérer le cours pour ce formateur et cette matière
                $formateurId = is_object($formateur) ? ($formateur->id ?? null) : null;
                $cours = null;
                
                if ($formateurId) {
                    // Mapper classe_id vers niveau_etude
                    $classeToNiveauMap = [
                        'licence_1' => 'Licence 1',
                        'licence_2' => 'Licence 2',
                        'licence_3' => 'Licence 3'
                    ];
                    $niveauEtude = isset($classeToNiveauMap[$user->classe_id ?? '']) ? $classeToNiveauMap[$user->classe_id] : null;
                    
                    // Récupérer le cours le plus récent pour ce formateur, cette matière et cette filière
                    Log::info('🔍 [PROFESSEUR ALGORITHMES] Recherche du cours', [
                        'formateur_id' => $formateurId,
                        'user_filiere' => $user->filiere,
                        'niveau_etude' => $niveauEtude,
                        'nom_matiere' => $nomMatiere,
                    ]);
                    
                    $cours = Cours::with(['formateur.matieres', 'questions'])
                        ->where('formateur_id', $formateurId)
                        ->where('filiere', $user->filiere)
                        ->where('actif', true)
                        ->when($niveauEtude, function($q) use ($niveauEtude) {
                            return $q->where('niveau_etude', $niveauEtude);
                        })
                        ->orderBy('updated_at', 'desc')
                        ->first();
                    
                    Log::info('🔍 [PROFESSEUR ALGORITHMES] Résultat de la recherche', [
                        'formateur_id' => $formateurId,
                        'cours_trouve' => $cours ? 'OUI' : 'NON',
                        'cours_id' => $cours->id ?? 'N/A',
                        'cours_titre' => $cours->titre ?? 'N/A',
                        'cours_description' => $cours->description ? 'PRESENT (' . strlen($cours->description) . ' chars)' : 'VIDE',
                        'cours_image_couverture' => $cours->image_couverture ?? 'N/A',
                        'cours_contenu_count' => $cours && is_array($cours->contenu) ? count($cours->contenu) : 0,
                        'cours_contenu_raw' => $cours && $cours->contenu ? json_encode($cours->contenu, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) : 'N/A',
                        'cours_filiere' => $cours->filiere ?? 'N/A',
                        'cours_niveau_etude' => $cours->niveau_etude ?? 'N/A',
                        'cours_duree' => $cours->duree ?? 'N/A',
                        'cours_ordre' => $cours->ordre ?? 'N/A',
                    ]);
                }
                
                $matieresAvecFormateurs->push([
                    'matiere' => $matiere,
                    'formateur' => $formateur,
                    'nom_matiere' => $nomMatiere,
                    'cours' => $cours,
                ]);
            }
        }
        
        $apprenantsLicence1 = collect();
        if ($user->filiere) {
            try {
                // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
                $apprenantsLicence1 = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('filiere', $user->filiere)
                    ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->where(function($q) {
                        $q->where('niveau_etude', 'Licence 1')
                          ->orWhere('niveau_etude', 'licence 1')
                          ->orWhere('niveau_etude', 'L1')
                          ->orWhere('niveau_etude', 'l1')
                          ->orWhere('niveau_etude', 'LIKE', '%licence 1%')
                          ->orWhere('niveau_etude', 'LIKE', '%Licence 1%');
                    })
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
            } catch (\Exception $e) {
                try {
                    $apprenantsLicence1 = User::where(function($q) {
                            $q->where('role', 'student')->orWhereNull('role');
                        })
                        ->where('filiere', $user->filiere)
                        ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                        ->where('niveau_etude', 'LIKE', '%licence 1%')
                        ->orderBy('nom')
                        ->orderBy('prenom')
                        ->get();
                } catch (\Exception $e2) {
                    $apprenantsLicence1 = collect();
                }
            }
            
            if ($apprenantsLicence1->isEmpty()) {
                try {
                    $classeLicence1 = Classe::where('filiere', $user->filiere)
                        ->where(function($q) {
                            $q->where('niveau_etude', 'Licence 1')
                              ->orWhere('niveau_etude', 'licence 1')
                              ->orWhere('niveau_etude', 'L1')
                              ->orWhere('niveau_etude', 'LIKE', '%licence 1%');
                        })
                        ->first();
                    
                    if ($classeLicence1) {
                        $apprenantsLicence1 = $classeLicence1->apprenants()
                            ->orderBy('nom')
                            ->orderBy('prenom')
                            ->get();
                    }
                } catch (\Exception $e) {
                    $apprenantsLicence1 = collect();
                }
            }
        }
        
        // Récupérer le cours principal (le plus récent) pour l'affichage
        $coursPrincipal = null;
        if ($matieresAvecFormateurs->isNotEmpty()) {
            $premierItem = $matieresAvecFormateurs->first();
            $coursPrincipal = $premierItem['cours'] ?? null;
        }
        
        Log::info('🔍 [PROFESSEUR ALGORITHMES] Cours principal final', [
            'user_email' => $user->email,
            'user_classe_id' => $user->classe_id,
            'user_filiere' => $user->filiere,
            'cours_principal_trouve' => $coursPrincipal ? 'OUI' : 'NON',
            'cours_principal_id' => $coursPrincipal->id ?? 'N/A',
            'cours_principal_titre' => $coursPrincipal->titre ?? 'N/A',
            'cours_principal_description' => $coursPrincipal->description ? 'PRESENT (' . strlen($coursPrincipal->description) . ' chars)' : 'VIDE',
            'cours_principal_image_couverture' => $coursPrincipal->image_couverture ?? 'N/A',
            'cours_principal_filiere' => $coursPrincipal->filiere ?? 'N/A',
            'cours_principal_niveau_etude' => $coursPrincipal->niveau_etude ?? 'N/A',
            'cours_principal_duree' => $coursPrincipal->duree ?? 'N/A',
            'cours_principal_ordre' => $coursPrincipal->ordre ?? 'N/A',
            'cours_principal_contenu_count' => $coursPrincipal && is_array($coursPrincipal->contenu) ? count($coursPrincipal->contenu) : 0,
            'cours_principal_contenu_details' => $coursPrincipal && is_array($coursPrincipal->contenu) ? array_map(function($section, $index) {
                return [
                    'section_index' => $index,
                    'titre' => $section['titre'] ?? 'N/A',
                    'sous_titres' => isset($section['sous_titres']) ? (is_array($section['sous_titres']) ? $section['sous_titres'] : [$section['sous_titres']]) : [],
                    'sous_titres_count' => isset($section['sous_titres']) ? (is_array($section['sous_titres']) ? count($section['sous_titres']) : 1) : 0,
                    'description' => !empty($section['description']) ? 'PRESENT' : 'VIDE',
                    'lien_video' => $section['lien_video'] ?? 'N/A',
                    'fichier_pdf' => $section['fichier_pdf'] ?? 'N/A',
                ];
            }, $coursPrincipal->contenu, array_keys($coursPrincipal->contenu)) : 'AUCUN',
            'matieres_avec_formateurs_count' => $matieresAvecFormateurs->count(),
        ]);
        
        return view('apprenant.professeur-algorithmes', compact('user', 'matieres', 'matieresAvecFormateurs', 'apprenantsLicence1', 'coursPrincipal'));
    }
    
    /**
     * Méthode générique pour toutes les matières
     * Prend le nom de la matière en paramètre et génère la vue appropriée
     */
    public function professeurMatiere(Request $request, $matiereSlug = null)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // Récupérer le nom de la matière depuis le slug ou le paramètre
        $matiereNom = $request->get('matiere', $matiereSlug);
        
        // Si c'est un slug, le convertir en nom de matière
        if ($matiereSlug) {
            $matiereNom = str_replace('-', ' ', $matiereSlug);
            $matiereNom = ucwords($matiereNom);
        }
        
        // Si pas de nom de matière, essayer de récupérer depuis la requête
        if (!$matiereNom) {
            $matiereNom = $request->get('nom_matiere');
        }
        
        // Si toujours pas de nom, retourner une erreur
        if (!$matiereNom) {
            abort(404, 'Matière non trouvée');
        }
        
        // Récupérer les matières correspondantes
        try {
            $matieres = DB::table('matieres')
                ->where('nom_matiere', 'like', '%' . $matiereNom . '%')
                ->orWhere('nom_matiere', 'like', '%' . strtolower($matiereNom) . '%')
                ->orWhere('nom_matiere', 'like', '%' . ucfirst($matiereNom) . '%')
                ->get();
        } catch (\Exception $e) {
            try {
                $matieres = Matiere::where('nom_matiere', 'like', '%' . $matiereNom . '%')
                    ->orWhere('nom_matiere', 'like', '%' . strtolower($matiereNom) . '%')
                    ->orWhere('nom_matiere', 'like', '%' . ucfirst($matiereNom) . '%')
                    ->get();
            } catch (\Exception $e2) {
                $matieres = collect();
            }
        }
        
        // Si vide, essayer de filtrer toutes les matières
        if ($matieres->isEmpty()) {
            try {
                $allMatieres = DB::table('matieres')->get();
                $matieres = $allMatieres->filter(function($matiere) use ($matiereNom) {
                    $nom = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? '';
                    return stripos($nom, strtolower($matiereNom)) !== false;
                })->values();
            } catch (\Exception $e) {
                $matieres = collect();
            }
        }
        
        // Si toujours vide, créer une matière fictive avec le nom fourni
        if ($matieres->isEmpty()) {
            $matieres = collect([(object)[
                'id' => null,
                'nom_matiere' => $matiereNom,
                'filiere' => null,
                'niveau_etude' => null
            ]]);
        }
        
        $matieresAvecFormateurs = collect();
        foreach ($matieres as $matiere) {
            $matiereId = null;
            if (is_object($matiere)) {
                $matiereId = $matiere->id ?? null;
            } elseif (is_array($matiere)) {
                $matiereId = $matiere['id'] ?? null;
            }
            
            if ($matiereId) {
                // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                try {
                    // Vérifier que l'étudiant a une classe ET une filière assignées
                    if (!$user->classe_id || !$user->filiere) {
                        $formateurs = collect();
                    } else {
                        // Récupérer UNIQUEMENT les formateurs avec la même classe_id ET la même filière
                    $formateurs = DB::table('formateur_matiere')
                        ->join('users', 'formateur_matiere.user_id', '=', 'users.id')
                        ->where('formateur_matiere.matiere_id', $matiereId)
                        ->where('users.role', 'teacher')
                            ->where('users.classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                            ->where('users.filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                        ->select('users.*')
                        ->get();
                        
                        // Vérification supplémentaire de sécurité
                        $formateurs = $formateurs->filter(function($formateur) use ($user) {
                            return ($formateur->classe_id ?? null) === $user->classe_id && 
                                   ($formateur->filiere ?? null) === $user->filiere;
                        })->values();
                    }
                } catch (\Exception $e) {
                    $formateurs = collect();
                }
            } else {
                $formateurs = collect();
            }
            
            $nomMatiere = '';
            if (is_object($matiere)) {
                $nomMatiere = $matiere->nom_matiere ?? $matiere->nom ?? $matiere->libelle ?? $matiere->name ?? $matiereNom;
            } elseif (is_array($matiere)) {
                $nomMatiere = $matiere['nom_matiere'] ?? $matiere['nom'] ?? $matiere['libelle'] ?? $matiere['name'] ?? $matiereNom;
            } else {
                $nomMatiere = $matiereNom;
            }
            
            if ($formateurs->isEmpty()) {
                $formateurs = collect([(object)['name' => 'Professeur', 'prenom' => '', 'nom' => '', 'photo' => null]]);
            }
            
            foreach ($formateurs as $formateur) {
                // Récupérer le cours pour ce formateur et cette matière
                $formateurId = is_object($formateur) ? ($formateur->id ?? null) : null;
                $cours = null;
                
                if ($formateurId) {
                    // Mapper classe_id vers niveau_etude
                    $classeToNiveauMap = [
                        'licence_1' => 'Licence 1',
                        'licence_2' => 'Licence 2',
                        'licence_3' => 'Licence 3'
                    ];
                    $niveauEtude = isset($classeToNiveauMap[$user->classe_id ?? '']) ? $classeToNiveauMap[$user->classe_id] : null;
                    
                    // Récupérer le cours le plus récent pour ce formateur, cette matière et cette filière
                    $cours = Cours::with(['formateur.matieres', 'questions'])
                        ->where('formateur_id', $formateurId)
                        ->where('filiere', $user->filiere)
                        ->where('actif', true)
                        ->when($niveauEtude, function($q) use ($niveauEtude) {
                            return $q->where('niveau_etude', $niveauEtude);
                        })
                        ->orderBy('updated_at', 'desc')
                        ->first();
                }
                
                $matieresAvecFormateurs->push([
                    'matiere' => $matiere,
                    'formateur' => $formateur,
                    'nom_matiere' => $nomMatiere,
                    'cours' => $cours,
                ]);
            }
        }
        
        // Récupérer les apprenants de Licence 1
        $apprenantsLicence1 = collect();
        if ($user->filiere) {
            try {
                // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
                $apprenantsLicence1 = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('filiere', $user->filiere)
                    ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->where(function($q) {
                        $q->where('niveau_etude', 'Licence 1')
                          ->orWhere('niveau_etude', 'licence 1')
                          ->orWhere('niveau_etude', 'L1')
                          ->orWhere('niveau_etude', 'l1')
                          ->orWhere('niveau_etude', 'LIKE', '%licence 1%')
                          ->orWhere('niveau_etude', 'LIKE', '%Licence 1%');
                    })
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
            } catch (\Exception $e) {
                try {
                    $apprenantsLicence1 = User::where(function($q) {
                            $q->where('role', 'student')->orWhereNull('role');
                        })
                        ->where('filiere', $user->filiere)
                        ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                        ->where('niveau_etude', 'LIKE', '%licence 1%')
                        ->orderBy('nom')
                        ->orderBy('prenom')
                        ->get();
                } catch (\Exception $e2) {
                    $apprenantsLicence1 = collect();
                }
            }
            
            if ($apprenantsLicence1->isEmpty()) {
                try {
                    $classeLicence1 = Classe::where('filiere', $user->filiere)
                        ->where(function($q) {
                            $q->where('niveau_etude', 'Licence 1')
                              ->orWhere('niveau_etude', 'licence 1')
                              ->orWhere('niveau_etude', 'L1')
                              ->orWhere('niveau_etude', 'LIKE', '%licence 1%');
                        })
                        ->first();
                    
                    if ($classeLicence1) {
                        $apprenantsLicence1 = $classeLicence1->apprenants()
                            ->orderBy('nom')
                            ->orderBy('prenom')
                            ->get();
                    }
                } catch (\Exception $e) {
                    $apprenantsLicence1 = collect();
                }
            }
        }
        
        // Récupérer le cours principal (le plus récent) pour l'affichage
        $coursPrincipal = null;
        if ($matieresAvecFormateurs->isNotEmpty()) {
            $premierItem = $matieresAvecFormateurs->first();
            $coursPrincipal = $premierItem['cours'] ?? null;
        }
        
        // Récupérer le statut de la session vidéo pour ce cours
        $sessionVideo = null;
        $sessionStatut = 'bientot_disponible'; // Par défaut : bientôt disponible
        if ($coursPrincipal && $coursPrincipal->id) {
            // Chercher une session active (en cours)
            $sessionActive = VideoSession::where('cours_id', $coursPrincipal->id)
                ->where('statut', '!=', 'terminee')
                ->whereNull('date_fin')
                ->orderBy('date_debut', 'desc')
                ->first();
            
            if ($sessionActive) {
                $sessionVideo = $sessionActive;
                $sessionStatut = 'en_cours';
            } else {
                // Chercher la dernière session terminée
                $sessionTerminee = VideoSession::where('cours_id', $coursPrincipal->id)
                    ->where('statut', 'terminee')
                    ->orderBy('date_fin', 'desc')
                    ->first();
                
                if ($sessionTerminee) {
                    $sessionVideo = $sessionTerminee;
                    $sessionStatut = 'termine';
                }
            }
        }
        
        // Utiliser le nom de la matière pour déterminer quelle vue utiliser
        $nomMatiereFinal = $matieresAvecFormateurs->first()['nom_matiere'] ?? $matiereNom;
        
        // Vérifier si un fichier spécifique existe, sinon utiliser le template générique
        $viewName = 'apprenant.professeur-matiere-generique';
        
        // Vérifier les cas spéciaux
        if (stripos($nomMatiereFinal, 'informatique de gestion') !== false) {
            $viewName = 'apprenant.professeur-informatique-gestion';
        } elseif (stripos($nomMatiereFinal, 'php') !== false || stripos($nomMatiereFinal, 'programmation') !== false) {
            $viewName = 'apprenant.professeur-programmation-php';
        } elseif (stripos($nomMatiereFinal, 'algorithme') !== false) {
            $viewName = 'apprenant.professeur-algorithmes';
        }
        
        Log::info('🔍 [PROFESSEUR MATIERE] Cours principal final', [
            'matiere_nom' => $nomMatiereFinal,
            'cours_principal_trouve' => $coursPrincipal ? 'OUI' : 'NON',
            'cours_principal_id' => $coursPrincipal->id ?? 'N/A',
            'cours_principal_titre' => $coursPrincipal->titre ?? 'N/A',
            'cours_principal_contenu' => $coursPrincipal && is_array($coursPrincipal->contenu) ? count($coursPrincipal->contenu) . ' sections' : 'AUCUN',
            'view_name' => $viewName,
        ]);
        
        return view($viewName, compact('user', 'matieres', 'matieresAvecFormateurs', 'apprenantsLicence1', 'nomMatiereFinal', 'coursPrincipal', 'sessionVideo', 'sessionStatut'));
    }
    
    public function messages()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // SÉCURITÉ : Récupérer uniquement les camarades de classe (même classe_id et même filière ET paiement effectué)
        // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
        $camaradesClasse = collect();
        if ($user->classe_id && $user->filiere) {
            $camaradesClasse = User::where(function($q) {
                    $q->where('role', 'student')->orWhereNull('role');
                })
                ->where('id', '!=', $user->id)
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
        }
        
        // SÉCURITÉ : Récupérer uniquement les professeurs attitrés (même classe_id et même filière)
        $professeursAttitres = collect();
        if ($user->classe_id && $user->filiere) {
            $professeursAttitres = User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
        }
        
        // SÉCURITÉ : Récupérer l'administrateur (peut communiquer avec tous les apprenants)
        // L'admin doit toujours figurer dans la liste de contacts de tous les apprenants
        $admin = User::where('role', 'admin')
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
            ->first();
        
        // Fusionner les contacts autorisés - L'admin en premier pour être toujours visible
        $contactsAutorises = collect();
        if ($admin) {
            $contactsAutorises->push($admin);
        }
        $contactsAutorises = $contactsAutorises->concat($camaradesClasse)->concat($professeursAttitres);
        
        // Récupérer les messages de l'apprenant avec vérification de sécurité
        // SÉCURITÉ CRITIQUE : Les messages avec l'admin doivent TOUJOURS être inclus et ne JAMAIS disparaître
        $adminId = $admin ? $admin->id : null;
        $contactsIds = $contactsAutorises->pluck('id')->toArray();
        
        $messages = Message::with(['sender:id,name,prenom,nom,email,photo,role,classe_id,filiere', 'receiver:id,name,prenom,nom,email,photo,role,classe_id,filiere'])
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->where(function($query) use ($user, $contactsIds, $adminId) {
                // SÉCURITÉ : Vérifier que les messages sont uniquement avec les contacts autorisés
                // IMPORTANT : Les messages avec l'admin sont TOUJOURS inclus explicitement
                $query->where(function($q) use ($user, $contactsIds, $adminId) {
                    // Messages envoyés par l'utilisateur aux contacts autorisés
                    $q->where('sender_id', $user->id)
                      ->whereIn('receiver_id', $contactsIds);
                    
                    // SÉCURITÉ CRITIQUE : Toujours inclure explicitement les messages avec l'admin
                    if ($adminId) {
                        $q->orWhere(function($subQ) use ($user, $adminId) {
                            $subQ->where('sender_id', $user->id)
                                 ->where('receiver_id', $adminId);
                        });
                    }
                })->orWhere(function($q) use ($user, $contactsIds, $adminId) {
                    // Messages reçus par l'utilisateur des contacts autorisés
                    $q->where('receiver_id', $user->id)
                      ->whereIn('sender_id', $contactsIds);
                    
                    // SÉCURITÉ CRITIQUE : Toujours inclure explicitement les messages avec l'admin
                    if ($adminId) {
                        $q->orWhere(function($subQ) use ($user, $adminId) {
                            $subQ->where('receiver_id', $user->id)
                                 ->where('sender_id', $adminId);
                        });
                    }
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // LOG : Avant filtrage final
        $messagesBeforeFinalFilter = $messages->count();
        $adminMessagesBeforeFinal = $messages->filter(function($m) use ($adminId) {
            return $m->sender_id == $adminId || $m->receiver_id == $adminId;
        })->count();
        \Log::info("🔍 [DEBUG messages()] Avant filtrage final: {$messagesBeforeFinalFilter} messages, dont {$adminMessagesBeforeFinal} avec admin (adminId: {$adminId})");
        
        // SÉCURITÉ FINALE : Double vérification - s'assurer que tous les messages avec l'admin sont présents
        // Ne jamais supprimer les messages avec l'admin
        if ($adminId) {
            $messages = $messages->filter(function($message) use ($user, $adminId, $contactsIds) {
                // Si c'est un message avec l'admin, toujours l'inclure
                if ($message->sender_id == $adminId || $message->receiver_id == $adminId) {
                    // Vérifier que l'autre partie est bien l'utilisateur connecté
                    $otherPartyId = $message->sender_id == $adminId ? $message->receiver_id : $message->sender_id;
                    if ($otherPartyId == $user->id) {
                        \Log::info("✅ [DEBUG messages()] Message avec admin CONSERVÉ - ID: {$message->id}");
                        return true;
                    } else {
                        \Log::warning("⚠️ [DEBUG messages()] Message avec admin mais autre partie incorrecte - ID: {$message->id}, otherPartyId: {$otherPartyId}, userId: {$user->id}");
                    }
                }
                
                // Pour les autres messages, vérifier qu'ils sont avec des contacts autorisés
                $isFromUser = $message->sender_id == $user->id && in_array($message->receiver_id, $contactsIds);
                $isToUser = $message->receiver_id == $user->id && in_array($message->sender_id, $contactsIds);
                return $isFromUser || $isToUser;
            })->values();
        }
        
        // LOG : Après filtrage final
        $messagesAfterFinalFilter = $messages->count();
        $adminMessagesAfterFinal = $messages->filter(function($m) use ($adminId) {
            return $m->sender_id == $adminId || $m->receiver_id == $adminId;
        })->count();
        \Log::info("🔍 [DEBUG messages()] Après filtrage final: {$messagesAfterFinalFilter} messages, dont {$adminMessagesAfterFinal} avec admin");
        
        if ($adminMessagesBeforeFinal > $adminMessagesAfterFinal) {
            \Log::error("❌ [DEBUG messages()] ALERTE: Messages avec admin perdus lors du filtrage final! Avant: {$adminMessagesBeforeFinal}, Après: {$adminMessagesAfterFinal}");
        }
        
        // LOG : Message IDs finaux
        $finalMessageIds = $messages->pluck('id')->toArray();
        \Log::info("🔍 [DEBUG messages()] Message IDs finaux: " . implode(', ', array_slice($finalMessageIds, 0, 10)) . (count($finalMessageIds) > 10 ? '...' : ''));
        
        // Récupérer les groupes de forum de l'apprenant
        $forumGroups = $user->forumGroups()->with('users:id,name,prenom,nom,email,photo')->get();
        
        return view('apprenant.messages', compact('user', 'contactsAutorises', 'messages', 'forumGroups'));
    }
    
    public function getGroupMembers(ForumGroup $group)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est membre du groupe
        if (!$group->users->contains($user->id)) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $members = $group->users->map(function($u) {
            return [
                'id' => $u->id,
                'prenom' => $u->prenom,
                'nom' => $u->nom,
                'email' => $u->email,
                'photo' => $u->photo
            ];
        });
        
        return response()->json(['success' => true, 'members' => $members]);
    }
    
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student')) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:5000',
            'label' => 'nullable|in:Normal,Signalement,Urgent,System',
        ]);
        
        $receiver = User::findOrFail($request->receiver_id);
        
        // SÉCURITÉ : Empêcher l'envoi de message à soi-même
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous envoyer un message à vous-même.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Pour les messages système (appels), vérifier que le receiver_id correspond bien à une conversation valide
        // Les messages système ne peuvent être envoyés qu'entre l'utilisateur connecté et le receiver spécifié
        $isSystemMessage = $request->label === 'System' || 
                          strpos($request->content, '📞❌') !== false || 
                          strpos($request->content, '📞✅') !== false ||
                          strpos($request->content, 'Appel manqué') !== false ||
                          strpos($request->content, 'Appel terminé') !== false;
        
        if ($isSystemMessage) {
            // SÉCURITÉ : Les messages système doivent être envoyés uniquement entre l'utilisateur connecté et le receiver
            // Vérifier que le receiver est bien un contact autorisé (même logique que pour les messages normaux)
            // Cette vérification est déjà faite plus bas, mais on la fait ici aussi pour être sûr
        }
        
        // SÉCURITÉ : Vérifier que le destinataire est un contact autorisé
        // Doit être soit un camarade de classe, soit un professeur attitré, soit l'admin
        $contactAutorise = false;
        
        // L'admin peut toujours recevoir des messages des apprenants
        if ($receiver->role === 'admin') {
            $contactAutorise = true;
        } elseif ($user->classe_id && $user->filiere) {
            // Vérifier si c'est un camarade de classe
            if (($receiver->role === 'student' || !$receiver->role) && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
            
            // Vérifier si c'est un professeur attitré
            if ($receiver->role === 'teacher' && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Vous ne pouvez pas envoyer de message à cette personne. Accès limité aux membres de votre classe et à l\'administrateur.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Forcer l'utilisation de l'ID de l'utilisateur connecté comme expéditeur
        // Ne jamais faire confiance aux données du client
        $message = Message::create([
            'sender_id' => $user->id, // TOUJOURS l'utilisateur connecté
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'label' => $request->label ?? 'Normal',
            'read_at' => null, // Les nouveaux messages ne sont pas lus par défaut
        ]);
        
        // Calculer le nombre total de messages non lus pour le destinataire
        $receiverUnreadCount = Message::where('receiver_id', $request->receiver_id)
            ->whereNull('read_at')
            ->count();
        
        return response()->json([
            'success' => true,
            'message' => $message->load(['sender:id,name,prenom,nom,email,photo,role', 'receiver:id,name,prenom,nom,email,photo,role']),
            'receiver_unread_count' => $receiverUnreadCount,
        ]);
    }

    public function storeCall(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student')) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:missed,rejected,ended,answered',
            'was_answered' => 'required|boolean',
        ]);
        
        $receiver = User::findOrFail($request->receiver_id);
        
        // SÉCURITÉ : Empêcher l'enregistrement d'appel à soi-même
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous appeler vous-même.'
            ], 403);
        }
        
        // SÉCURITÉ : Vérifier que le destinataire est un contact autorisé
        $contactAutorise = false;
        
        // L'admin peut toujours recevoir des appels des apprenants
        if ($receiver->role === 'admin') {
            $contactAutorise = true;
        } elseif ($user->classe_id && $user->filiere) {
            // Vérifier si c'est un camarade de classe
            if (($receiver->role === 'student' || !$receiver->role) && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
            
            // Vérifier si c'est un professeur attitré
            if ($receiver->role === 'teacher' && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Vous ne pouvez pas appeler cette personne. Accès limité aux membres de votre classe et à l\'administrateur.'
            ], 403);
        }
        
        // SÉCURITÉ : Forcer l'utilisation de l'ID de l'utilisateur connecté comme expéditeur
        $call = \App\Models\Call::create([
            'caller_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'duration' => $request->duration,
            'status' => $request->status,
            'was_answered' => $request->was_answered,
        ]);
        
        return response()->json([
            'success' => true,
            'call' => $call->load(['caller:id,name,prenom,nom,email,photo,role', 'receiver:id,name,prenom,nom,email,photo,role']),
        ]);
    }
    
    public function getThread($receiverId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student')) {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $receiver = User::findOrFail($receiverId);
        
        // SÉCURITÉ : Empêcher l'accès à sa propre conversation
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas accéder à votre propre conversation.'
            ], 403);
        }
        
        // SÉCURITÉ : Vérifier que le destinataire est un contact autorisé
        $contactAutorise = false;
        
        // L'admin peut toujours communiquer avec les apprenants
        if ($receiver->role === 'admin') {
            $contactAutorise = true;
        } elseif ($user->classe_id && $user->filiere) {
            // Camarades de classe
            if (($receiver->role === 'student' || !$receiver->role) && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
            
            // Professeurs attitrés
            if ($receiver->role === 'teacher' && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Accès refusé. Vous ne pouvez pas accéder à cette conversation.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Récupérer UNIQUEMENT les messages entre l'utilisateur connecté et le destinataire
        // Utiliser des conditions strictes pour éviter toute fuite de données
        // IMPORTANT : Ne jamais filtrer les messages avec l'admin - ils doivent toujours être présents
        $messages = Message::with(['sender:id,name,prenom,nom,email,photo,role,last_seen', 'receiver:id,name,prenom,nom,email,photo,role,last_seen'])
            ->where(function($query) use ($user, $receiverId) {
                // Message envoyé par l'utilisateur connecté au destinataire
                $query->where(function($q) use ($user, $receiverId) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $receiverId);
                })
                // OU message envoyé par le destinataire à l'utilisateur connecté
                ->orWhere(function($q) use ($user, $receiverId) {
                    $q->where('sender_id', $receiverId)
                      ->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        // LOG : Avant filtrage
        $messagesBeforeFilter = $messages->count();
        $adminMessagesBefore = $messages->filter(function($m) {
            return ($m->sender && $m->sender->role === 'admin') || ($m->receiver && $m->receiver->role === 'admin');
        })->count();
        \Log::info("🔍 [DEBUG getThread] Avant filtrage: {$messagesBeforeFilter} messages, dont {$adminMessagesBefore} avec admin");
        
        // SÉCURITÉ : Vérification finale - s'assurer que tous les messages appartiennent bien à cette conversation
        // IMPORTANT : Ne jamais supprimer les messages avec l'admin - ils sont toujours valides
        $messages = $messages->filter(function($message) use ($user, $receiverId, $receiver) {
            $isFromUser = $message->sender_id == $user->id && $message->receiver_id == $receiverId;
            $isToUser = $message->sender_id == $receiverId && $message->receiver_id == $user->id;
            
            // SÉCURITÉ CRITIQUE : Les messages avec l'admin sont TOUJOURS valides
            $isWithAdmin = ($message->sender && $message->sender->role === 'admin') || 
                          ($message->receiver && $message->receiver->role === 'admin');
            
            // LOG : Détail de chaque message
            if ($isWithAdmin) {
                \Log::info("🔍 [DEBUG getThread] Message avec admin trouvé - ID: {$message->id}, sender_id: {$message->sender_id}, receiver_id: {$message->receiver_id}, isFromUser: " . ($isFromUser ? 'true' : 'false') . ", isToUser: " . ($isToUser ? 'true' : 'false'));
            }
            
            // Si c'est un message avec l'admin, toujours l'inclure
            if ($isWithAdmin && ($isFromUser || $isToUser)) {
                \Log::info("✅ [DEBUG getThread] Message avec admin CONSERVÉ - ID: {$message->id}");
                return true;
            }
            
            // Sinon, vérifier normalement
            $shouldKeep = $isFromUser || $isToUser;
            if ($isWithAdmin && !$shouldKeep) {
                \Log::warning("⚠️ [DEBUG getThread] Message avec admin pourrait être supprimé - ID: {$message->id}, isFromUser: " . ($isFromUser ? 'true' : 'false') . ", isToUser: " . ($isToUser ? 'true' : 'false'));
            }
            return $shouldKeep;
        })->values();
        
        // LOG : Après filtrage
        $messagesAfterFilter = $messages->count();
        $adminMessagesAfter = $messages->filter(function($m) {
            return ($m->sender && $m->sender->role === 'admin') || ($m->receiver && $m->receiver->role === 'admin');
        })->count();
        \Log::info("🔍 [DEBUG getThread] Après filtrage: {$messagesAfterFilter} messages, dont {$adminMessagesAfter} avec admin");
        
        if ($adminMessagesBefore > $adminMessagesAfter) {
            \Log::error("❌ [DEBUG getThread] ALERTE: Messages avec admin perdus! Avant: {$adminMessagesBefore}, Après: {$adminMessagesAfter}");
        }
        
        // Recharger le receiver avec last_seen
        $receiver->refresh();
        
        // LOG : Message IDs retournés
        $messageIds = $messages->pluck('id')->toArray();
        \Log::info("🔍 [DEBUG getThread] Message IDs retournés: " . implode(', ', $messageIds));
        \Log::info("🔍 [DEBUG getThread] Nombre total de messages retournés: " . $messages->count());
        \Log::info("🔍 [DEBUG getThread] Receiver ID: {$receiverId}, Receiver role: {$receiver->role}");
        \Log::info("🔍 [DEBUG getThread] User ID: {$user->id}");
        
        // Compter les messages non lus pour cette conversation
        $unreadCount = Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        return response()->json([
            'success' => true,
            'messages' => $messages,
            'receiver' => $receiver->only(['id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen']),
            'unread_count' => $unreadCount,
        ]);
    }
    
    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student')) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);
        
        $receiverId = $request->receiver_id;
        
        // SÉCURITÉ : Marquer uniquement les messages reçus par l'utilisateur connecté depuis ce destinataire
        $updated = Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        // Calculer le nouveau nombre de messages non lus
        $totalUnread = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        return response()->json([
            'success' => true,
            'updated' => $updated,
            'total_unread' => $totalUnread,
        ]);
    }
    
    public function calendrier()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        return view('apprenant.calendrier', compact('user'));
    }
    
    public function getEmploiDuTemps()
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien un apprenant
        if (!$user || ($user->role && $user->role !== 'student')) {
            return response()->json(['error' => 'Accès refusé'], 403);
        }
        
        // Récupérer la classe de l'apprenant (licence_1, licence_2, licence_3, master_1, master_2)
        $classe = $user->classe_id;
        
        if (!$classe) {
            return response()->json(['error' => 'Aucune classe assignée'], 404);
        }
        
        // SÉCURITÉ : Récupérer l'emploi du temps uniquement pour la classe de l'apprenant
        // Les formateurs et apprenants avec le même classe_id recevront le même emploi du temps
        $emploiDuTemps = \App\Models\EmploiDuTemps::where('classe', $classe)->first();
        
        if (!$emploiDuTemps) {
            return response()->json(['error' => 'Aucun emploi du temps disponible pour votre classe'], 404);
        }
        
        // SÉCURITÉ : Vérifier que le fichier existe
        if (!\Storage::disk('public')->exists($emploiDuTemps->fichier)) {
            return response()->json(['error' => 'Fichier introuvable'], 404);
        }
        
        return response()->json([
            'fichier' => asset('storage/' . $emploiDuTemps->fichier),
            'type_fichier' => $emploiDuTemps->type_fichier,
        ]);
    }
    
    public function quiz(Request $request)
    {
        \Log::info('=== QUIZ() DÉBUT ===', [
            'user_id' => Auth::id(),
            'cours_id' => $request->get('cours_id'),
            'section' => $request->get('section', 0),
            'retry' => $request->get('retry'),
            'url' => $request->fullUrl()
        ]);
        
        $user = Auth::user();
        
        if (!$user) {
            \Log::info('QUIZ() - Pas d\'utilisateur, redirection vers login');
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            \Log::info('QUIZ() - Utilisateur admin, redirection vers dashboard');
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            \Log::info('QUIZ() - Rôle invalide, abort 403');
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // Récupérer le cours et la section depuis la requête
        $coursId = $request->get('cours_id');
        $sectionIndex = $request->get('section', 0);
        
        \Log::info('QUIZ() - Paramètres récupérés', [
            'coursId' => $coursId,
            'sectionIndex' => $sectionIndex
        ]);
        
        $cours = null;
        $questions = collect();
        $section = null;
        $attemptsCount = 0;
        $remainingAttempts = 2;
        $currentAttempt = null;
        
        // Si un ID de cours est fourni, récupérer le cours et les questions correspondantes
        if ($coursId) {
            $cours = \App\Models\Cours::where('id', $coursId)
                ->where('actif', true)
                ->first();
            
            if ($cours) {
                // SÉCURITÉ : Vérifier si le quiz a déjà été complété pour cette tentative (session)
                // Mais permettre de reprendre si l'utilisateur a cliqué sur "Reprendre le quiz"
                $quizCompletedKey = 'quiz_completed_' . $user->id . '_' . $cours->id . '_' . $sectionIndex;
                $quizLockedKey = 'quiz_locked_' . $user->id . '_' . $cours->id . '_' . $sectionIndex;
                $quizExpiredKey = 'quiz_expired_' . $user->id . '_' . $cours->id . '_' . $sectionIndex;
                $allowRetry = $request->get('retry') === 'true';
                
                // SÉCURITÉ : Vérifier les tentatives (complétées ou non) pour compter correctement EN PREMIER
                // Trouver le attempt_number maximum utilisé (complété ou non) MAIS limiter à 2 maximum
                $maxAttemptNumberRaw = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->where('attempt_number', '<=', 2)
                    ->max('attempt_number') ?? 0;
                
                // Limiter à 2 maximum pour éviter les problèmes de données corrompues
                $maxAttemptNumber = min($maxAttemptNumberRaw, 2);
                
                \Log::info('QUIZ() - Tentatives vérifiées', [
                    'maxAttemptNumber' => $maxAttemptNumber,
                    'allowRetry' => $allowRetry,
                    'cours_id' => $cours->id,
                    'section_index' => $sectionIndex
                ]);
                
                // Si l'utilisateur a déjà utilisé ses 2 tentatives, rediriger directement vers les résultats
                // AVANT de vérifier les clés de session pour éviter les boucles
                if ($maxAttemptNumber >= 2 && !$allowRetry) {
                    \Log::info('QUIZ() - REDIRECTION vers quiz-results (tentatives épuisées)', [
                        'maxAttemptNumber' => $maxAttemptNumber,
                        'allowRetry' => $allowRetry
                    ]);
                    return redirect()->route('apprenant.quiz-results', [
                        'cours_id' => $coursId,
                        'section' => $sectionIndex
                    ])->with('error', 'Vous avez déjà utilisé toutes vos tentatives pour ce quiz.');
                }
                
                // Compter les tentatives complétées pour l'affichage
                $attemptsCount = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->whereNotNull('completed_at')
                    ->count();
                
                // Calculer les tentatives restantes basé sur le attempt_number maximum utilisé
                $remainingAttempts = max(0, 2 - $maxAttemptNumber);
                
                // SÉCURITÉ : Vérifier si l'interface du quiz est expirée (seulement si tentatives disponibles)
                if (session()->has($quizExpiredKey) && !$allowRetry && $maxAttemptNumber < 2) {
                    $expiredTimestamp = session()->get($quizExpiredKey);
                    \Log::info('QUIZ() - REDIRECTION vers quiz-results (interface expirée)', [
                        'quizExpiredKey' => $quizExpiredKey,
                        'expiredTimestamp' => $expiredTimestamp
                    ]);
                    // L'interface est expirée, rediriger vers les résultats
                    return redirect()->route('apprenant.quiz-results', [
                        'cours_id' => $coursId,
                        'section' => $sectionIndex
                    ])->with('error', 'L\'interface du quiz a expiré. Cliquez sur "Reprendre le quiz" pour continuer.');
                }
                
                // Si le quiz est verrouillé et que l'utilisateur n'a pas explicitement demandé à reprendre (seulement si tentatives disponibles)
                if (session()->has($quizLockedKey) && !$allowRetry && $maxAttemptNumber < 2) {
                    \Log::info('QUIZ() - REDIRECTION vers quiz-results (quiz verrouillé)', [
                        'quizLockedKey' => $quizLockedKey
                    ]);
                    // Le quiz est verrouillé, rediriger vers les résultats
                    return redirect()->route('apprenant.quiz-results', [
                        'cours_id' => $coursId,
                        'section' => $sectionIndex
                    ])->with('error', 'Le quiz est verrouillé. Cliquez sur "Reprendre le quiz" pour continuer.');
                }
                
                // Si l'utilisateur demande à reprendre, déverrouiller le quiz et réinitialiser l'expiration
                if ($allowRetry && (session()->has($quizLockedKey) || session()->has($quizExpiredKey))) {
                    session()->forget($quizLockedKey);
                    session()->forget($quizExpiredKey);
                    // Ne pas supprimer quiz_completed pour garder l'historique, mais permettre une nouvelle tentative
                    session()->save();
                }
                
                // SÉCURITÉ : Vérifier s'il existe une tentative complétée récente (pour empêcher l'accès via URL copiée)
                // Vérifier toutes les tentatives complétées, pas seulement les 24 dernières heures
                $recentCompletedAttempt = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->whereNotNull('completed_at')
                    ->orderBy('completed_at', 'desc')
                    ->first();
                
                if ($recentCompletedAttempt) {
                    // Vérifier si c'est la même tentative que celle en cours (si elle existe)
                    $currentAttemptIncomplete = \App\Models\QuizAttempt::where('user_id', $user->id)
                        ->where('cours_id', $cours->id)
                        ->where('section_index', $sectionIndex)
                        ->whereNull('completed_at')
                        ->orderBy('attempt_number', 'desc')
                        ->first();
                    
                    // Si aucune tentative incomplète n'existe, rediriger vers les résultats
                    if (!$currentAttemptIncomplete) {
                        return redirect()->route('apprenant.quiz-results', [
                            'cours_id' => $coursId,
                            'section' => $sectionIndex
                        ])->with('error', 'Vous avez déjà terminé ce quiz. Vous ne pouvez pas y revenir.');
                    }
                    
                    // SÉCURITÉ : Vérifier que la tentative incomplète est bien la plus récente
                    // Si une tentative complétée est plus récente qu'une incomplète, c'est suspect
                    if ($recentCompletedAttempt->completed_at && $currentAttemptIncomplete->started_at) {
                        if ($recentCompletedAttempt->completed_at > $currentAttemptIncomplete->started_at) {
                            // La tentative complétée est plus récente, rediriger
                            return redirect()->route('apprenant.quiz-results', [
                                'cours_id' => $coursId,
                                'section' => $sectionIndex
                            ])->with('error', 'Vous avez déjà terminé ce quiz. Vous ne pouvez pas y revenir.');
                        }
                    }
                }
                
                // Récupérer la tentative actuelle non complétée ou créer une nouvelle
                $currentAttempt = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->whereNull('completed_at')
                    ->orderBy('attempt_number', 'desc')
                    ->first();
                
                if (!$currentAttempt) {
                    // SÉCURITÉ : Vérifier strictement avant de créer une nouvelle tentative
                    if (!\App\Models\QuizAttempt::canCreateNewAttempt($user->id, $cours->id, $sectionIndex)) {
                        \Log::warning('SÉCURITÉ QUIZ : Tentative de création bloquée - limite atteinte', [
                            'user_id' => $user->id,
                            'cours_id' => $cours->id,
                            'section_index' => $sectionIndex,
                        ]);
                        return redirect()->route('apprenant.quiz-results', [
                            'cours_id' => $coursId,
                            'section' => $sectionIndex
                        ])->with('error', 'Vous avez déjà utilisé toutes vos tentatives pour ce quiz.');
                    }
                    
                    // Créer une nouvelle tentative avec le bon attempt_number
                    $newAttemptNumber = $maxAttemptNumber + 1;
                    // SÉCURITÉ : Double vérification avant création
                    if ($newAttemptNumber > 2) {
                        \Log::warning('SÉCURITÉ QUIZ : Tentative de création avec attempt_number > 2', [
                            'user_id' => $user->id,
                            'cours_id' => $cours->id,
                            'section_index' => $sectionIndex,
                            'new_attempt_number' => $newAttemptNumber,
                        ]);
                        return redirect()->route('apprenant.quiz-results', [
                            'cours_id' => $coursId,
                            'section' => $sectionIndex
                        ])->with('error', 'Vous avez déjà utilisé toutes vos tentatives pour ce quiz.');
                    }
                    
                    try {
                        $currentAttempt = \App\Models\QuizAttempt::create([
                            'user_id' => $user->id,
                            'cours_id' => $cours->id,
                            'section_index' => $sectionIndex,
                            'attempt_number' => $newAttemptNumber,
                            'started_at' => now(),
                        ]);
                    } catch (\Exception $e) {
                        // Si la création échoue (contrainte unique ou autre), vérifier à nouveau
                        \Log::error('SÉCURITÉ QUIZ : Erreur lors de la création de tentative', [
                            'user_id' => $user->id,
                            'cours_id' => $cours->id,
                            'section_index' => $sectionIndex,
                            'error' => $e->getMessage(),
                        ]);
                        return redirect()->route('apprenant.quiz-results', [
                            'cours_id' => $coursId,
                            'section' => $sectionIndex
                        ])->with('error', 'Erreur lors de la création de la tentative. Vous avez peut-être déjà utilisé toutes vos tentatives.');
                    }
                }
                
                // Récupérer la section de contenu
                if ($cours->contenu && is_array($cours->contenu) && isset($cours->contenu[$sectionIndex])) {
                    $section = $cours->contenu[$sectionIndex];
                }
                
                // Récupérer les questions pour cette section
                $questions = \App\Models\Question::where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->orderBy('ordre')
                    ->get();
            }
        }
        
        $currentQuestionIndex = $request->get('q', 0);
        
        // SÉCURITÉ : Générer un token unique pour cette tentative de quiz
        $quizToken = null;
        if ($currentAttempt) {
            $quizTokenKey = 'quiz_token_' . $user->id . '_' . $coursId . '_' . $sectionIndex . '_' . $currentAttempt->id;
            if (!session()->has($quizTokenKey)) {
                $quizToken = bin2hex(random_bytes(32)); // Token sécurisé de 64 caractères
                session()->put($quizTokenKey, $quizToken);
                session()->save();
            } else {
                $quizToken = session()->get($quizTokenKey);
            }
        }
        
        return view('apprenant.quiz', compact('user', 'cours', 'questions', 'section', 'sectionIndex', 'currentQuestionIndex', 'coursId', 'attemptsCount', 'remainingAttempts', 'currentAttempt', 'quizToken'));
    }
    
    public function submitQuiz(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // Récupérer les paramètres
        $coursId = $request->input('cours_id');
        $sectionIndex = $request->input('section', 0);
        $quizToken = $request->input('quiz_token');
        $attemptId = $request->input('attempt_id');
        
        // SÉCURITÉ : Vérifier le token de session
        if (!$quizToken || !$attemptId) {
            return redirect()->route('apprenant.quiz', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Token de sécurité invalide. Veuillez recommencer le quiz.');
        }
        
        $quizTokenKey = 'quiz_token_' . $user->id . '_' . $coursId . '_' . $sectionIndex . '_' . $attemptId;
        $storedToken = session()->get($quizTokenKey);
        
        if (!$storedToken || $storedToken !== $quizToken) {
            return redirect()->route('apprenant.quiz', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Token de sécurité invalide. Veuillez recommencer le quiz.');
        }
        
        // Vérifier que le quiz n'a pas déjà été soumis
        $quizCompletedKey = 'quiz_completed_' . $user->id . '_' . $coursId . '_' . $sectionIndex;
        if (session()->has($quizCompletedKey)) {
            return redirect()->route('apprenant.quiz-results', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Vous avez déjà terminé ce quiz. Vous ne pouvez pas y revenir.');
        }
        
        // SÉCURITÉ : Vérifier la tentative avec des vérifications strictes
        $currentAttempt = \App\Models\QuizAttempt::where('id', $attemptId)
            ->where('user_id', $user->id)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->whereNull('completed_at')
            ->where('attempt_number', '<=', 2) // SÉCURITÉ : Vérifier que attempt_number est valide
            ->first();
        
        if (!$currentAttempt) {
            \Log::warning('SÉCURITÉ QUIZ : Tentative de soumission avec tentative invalide', [
                'user_id' => $user->id,
                'cours_id' => $coursId,
                'section_index' => $sectionIndex,
                'attempt_id' => $attemptId,
            ]);
            return redirect()->route('apprenant.quiz', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Tentative invalide. Veuillez recommencer le quiz.');
        }
        
        // SÉCURITÉ : Vérifier qu'il n'y a pas déjà 2 tentatives complétées
        $completedAttempts = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->whereNotNull('completed_at')
            ->where('attempt_number', '<=', 2)
            ->count();
        
        if ($completedAttempts >= 2) {
            \Log::warning('SÉCURITÉ QUIZ : Tentative de soumission alors que 2 tentatives déjà complétées', [
                'user_id' => $user->id,
                'cours_id' => $coursId,
                'section_index' => $sectionIndex,
                'completed_attempts' => $completedAttempts,
            ]);
            return redirect()->route('apprenant.quiz-results', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Vous avez déjà utilisé toutes vos tentatives pour ce quiz.');
        }
        
        // Récupérer le cours et les questions
        $cours = \App\Models\Cours::where('id', $coursId)
            ->where('actif', true)
            ->first();
        
        if (!$cours) {
            return redirect()->route('apprenant.cours')->with('error', 'Cours introuvable.');
        }
        
        $questions = \App\Models\Question::where('cours_id', $cours->id)
            ->where('section_index', $sectionIndex)
            ->orderBy('ordre')
            ->get();
        
        // Collecter les réponses
        $studentAnswers = [];
        foreach ($questions as $question) {
            $questionKey = 'question_' . $question->id;
            $studentAnswer = null;
            
            if ($question->type === 'vrai_faux') {
                $studentAnswer = $request->input($questionKey . '_reponse');
            } elseif ($question->type === 'choix_multiple') {
                $selectedOptions = [];
                if ($question->options && is_array($question->options)) {
                    foreach ($question->options as $optIndex => $option) {
                        if ($request->has($questionKey . '_option_' . $optIndex) || $request->input($questionKey . '_option_' . $optIndex) === '1') {
                            $selectedOptions[] = $option['texte'] ?? '';
                        }
                    }
                }
                $studentAnswer = $selectedOptions;
            } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                $studentAnswer = $request->input($questionKey . '_reponse');
            }
            
            $studentAnswers[$question->id] = $studentAnswer;
        }
        
        // Calculer les scores
        $correctCount = 0;
        $totalQuestions = $questions->count();
        $totalPoints = 0;
        $earnedPoints = 0;
        
        foreach ($questions as $question) {
            $studentAnswer = $studentAnswers[$question->id] ?? null;
            
            $isCorrect = false;
            if ($question->type === 'vrai_faux') {
                $normalizedStudentAnswer = $this->normalizeVraiFauxAnswer($studentAnswer);
                $normalizedCorrectAnswer = $this->normalizeVraiFauxAnswer($question->reponse_correcte);
                $isCorrect = ($normalizedStudentAnswer === $normalizedCorrectAnswer);
            } elseif ($question->type === 'choix_multiple') {
                $correctOptions = [];
                if ($question->options && is_array($question->options)) {
                    foreach ($question->options as $option) {
                        if (isset($option['correcte']) && $option['correcte']) {
                            $correctOptions[] = trim($option['texte'] ?? '');
                        }
                    }
                }
                $studentAnswerArray = is_array($studentAnswer) ? $studentAnswer : [];
                $normalizedStudentAnswers = array_map(function($answer) {
                    return trim($answer);
                }, $studentAnswerArray);
                
                sort($correctOptions);
                sort($normalizedStudentAnswers);
                $isCorrect = ($correctOptions === $normalizedStudentAnswers);
            } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                $normalizedStudent = strtolower(trim($studentAnswer ?? ''));
                $normalizedCorrect = strtolower(trim($question->reponse_correcte ?? ''));
                $isCorrect = ($normalizedStudent === $normalizedCorrect && $normalizedStudent !== '');
            }
            
            if ($isCorrect) {
                $correctCount++;
                $earnedPoints += $question->points ?? 1;
            }
            
            $totalPoints += $question->points ?? 1;
        }
        
        // SÉCURITÉ : Vérifier une dernière fois avant de mettre à jour
        // Compter les tentatives complétées AVANT cette tentative
        $completedBeforeThis = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->where('id', '!=', $currentAttempt->id) // Exclure la tentative actuelle
            ->whereNotNull('completed_at')
            ->where('attempt_number', '<=', 2)
            ->count();
        
        if ($completedBeforeThis >= 2) {
            \Log::warning('SÉCURITÉ QUIZ SUBMIT : Tentative de soumission alors que 2 tentatives déjà complétées', [
                'user_id' => $user->id,
                'cours_id' => $coursId,
                'section_index' => $sectionIndex,
                'attempt_id' => $currentAttempt->id,
                'completed_before' => $completedBeforeThis,
            ]);
            return redirect()->route('apprenant.quiz-results', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Vous avez déjà utilisé toutes vos tentatives pour ce quiz.');
        }
        
        // SÉCURITÉ : Vérifier que attempt_number est valide (1 ou 2 uniquement)
        if ($currentAttempt->attempt_number > 2) {
            \Log::warning('SÉCURITÉ QUIZ SUBMIT : Tentative de soumission avec attempt_number > 2', [
                'user_id' => $user->id,
                'cours_id' => $coursId,
                'section_index' => $sectionIndex,
                'attempt_id' => $currentAttempt->id,
                'attempt_number' => $currentAttempt->attempt_number,
            ]);
            return redirect()->route('apprenant.quiz-results', [
                'cours_id' => $coursId,
                'section' => $sectionIndex
            ])->with('error', 'Tentative invalide. Veuillez contacter l\'administrateur.');
        }
        
        // Mettre à jour la tentative avec les résultats
        $currentAttempt->update([
            'score' => $correctCount,
            'total_questions' => $totalQuestions,
            'answers' => $studentAnswers,
            'completed_at' => now(),
        ]);
        
        // Sauvegarder automatiquement le résultat dans StudentResult
        if ($coursId && $cours) {
            $formateur = $cours->formateur;
            if ($formateur) {
                // Récupérer les matières enseignées par le formateur
                $matieres = $formateur->matieres()->get();
                
                // Calculer la note sur 20 (arrondir à l'entier, pas de décimales)
                $noteSur20 = $totalQuestions > 0 
                    ? round(($correctCount / $totalQuestions) * 20)
                    : 0;
                
                // Trouver la matière correspondante
                $matiereTrouvee = null;
                $coursTitreLower = strtolower($cours->titre ?? '');
                
                if ($matieres->count() == 1) {
                    $matiereTrouvee = $matieres->first();
                } else {
                    // Chercher la matière dans le titre du cours
                    foreach ($matieres as $matiere) {
                        $matiereNomLower = strtolower($matiere->nom_matiere ?? '');
                        if (str_contains($coursTitreLower, $matiereNomLower) || str_contains($matiereNomLower, $coursTitreLower)) {
                            $matiereTrouvee = $matiere;
                            break;
                        }
                    }
                    // Si aucune correspondance, prendre la première matière
                    if (!$matiereTrouvee && $matieres->count() > 0) {
                        $matiereTrouvee = $matieres->first();
                    }
                }
                
                // Sauvegarder dans StudentResult si une matière a été trouvée
                if ($matiereTrouvee) {
                    $resultat = \App\Models\StudentResult::where('user_id', $user->id)
                        ->where('classe', $matiereTrouvee->nom_matiere)
                        ->first();
                    
                    if ($resultat) {
                        // Toujours mettre à jour avec la dernière note (pas la meilleure)
                        $resultat->update(['quiz' => $noteSur20]);
                    } else {
                        // Créer un nouveau résultat
                        \App\Models\StudentResult::create([
                            'matricule' => $user->matricule ?? $user->id,
                            'nom' => $user->nom ?? '',
                            'prenom' => $user->prenom ?? '',
                            'classe' => $matiereTrouvee->nom_matiere,
                            'user_id' => $user->id,
                            'quiz' => $noteSur20,
                        ]);
                    }
                }
            }
        }
        
        // SÉCURITÉ : Marquer le quiz comme complété et verrouillé dans la session
        session()->put($quizCompletedKey, true);
        $quizLockedKey = 'quiz_locked_' . $user->id . '_' . $coursId . '_' . $sectionIndex;
        session()->put($quizLockedKey, true);
        
        // SÉCURITÉ : Marquer l'interface du quiz comme expirée avec un timestamp
        $quizExpiredKey = 'quiz_expired_' . $user->id . '_' . $coursId . '_' . $sectionIndex;
        session()->put($quizExpiredKey, now()->timestamp);
        
        // Supprimer le token pour empêcher la réutilisation
        session()->forget($quizTokenKey);
        session()->save();
        
        // Rediriger vers les résultats
        return redirect()->route('apprenant.quiz-results', [
            'cours_id' => $coursId,
            'section' => $sectionIndex
        ])->with('success', 'Quiz soumis avec succès.');
    }
    
    public function quizResults(Request $request)
    {
        try {
            \Log::info('=== QUIZ-RESULTS() DÉBUT ===', [
                'user_id' => Auth::id(),
                'cours_id' => $request->get('cours_id'),
                'section' => $request->get('section', 0),
                'url' => $request->fullUrl(),
                'referer' => $request->header('referer')
            ]);
            
        $user = Auth::user();
        
        if (!$user) {
            \Log::info('QUIZ-RESULTS() - Pas d\'utilisateur, redirection vers login');
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            \Log::info('QUIZ-RESULTS() - Utilisateur admin, redirection vers dashboard');
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            \Log::info('QUIZ-RESULTS() - Rôle invalide, abort 403');
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // Récupérer le cours et la section depuis la requête
        $coursId = $request->get('cours_id');
        $sectionIndex = (int) $request->get('section', 0);
        
        \Log::info('QUIZ-RESULTS() - Paramètres récupérés', [
            'coursId' => $coursId,
            'sectionIndex' => $sectionIndex
        ]);
        
        $cours = null;
        $questions = collect();
        $section = null;
        $studentAnswers = [];
        $correctCount = 0;
        $totalQuestions = 0;
        $totalPoints = 0;
        $earnedPoints = 0;
        
        // Si un ID de cours est fourni, récupérer le cours et les questions correspondantes
        if ($coursId) {
            $cours = \App\Models\Cours::where('id', $coursId)
                ->where('actif', true)
                ->first();
            
            if ($cours) {
                // Récupérer la section de contenu
                if ($cours->contenu && is_array($cours->contenu) && isset($cours->contenu[$sectionIndex])) {
                    $section = $cours->contenu[$sectionIndex];
                }
                
                // Récupérer les questions pour cette section
                $questions = \App\Models\Question::where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->orderBy('ordre')
                    ->get();
                
                $totalQuestions = $questions->count();
                
                // SÉCURITÉ : Vérifier qu'au moins une tentative a été complétée avant d'afficher les résultats
                $lastCompletedAttempt = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->whereNotNull('completed_at')
                    ->orderBy('completed_at', 'desc')
                    ->first();
                
                // Vérifier le attempt_number maximum utilisé pour éviter les boucles de redirection
                // IMPORTANT : Vérifier cela EN PREMIER pour éviter toute redirection si toutes les tentatives sont utilisées
                // Limiter à 2 maximum pour éviter les problèmes de données corrompues
                $maxAttemptNumberRaw = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $cours->id)
                    ->where('section_index', $sectionIndex)
                    ->where('attempt_number', '<=', 2)
                    ->max('attempt_number') ?? 0;
                
                $maxAttemptNumber = min($maxAttemptNumberRaw, 2);
                
                \Log::info('QUIZ-RESULTS() - Tentatives vérifiées', [
                    'maxAttemptNumber' => $maxAttemptNumber,
                    'lastCompletedAttempt' => $lastCompletedAttempt ? 'exists' : 'null',
                    'cours_id' => $cours->id,
                    'section_index' => $sectionIndex
                ]);
                
                // SÉCURITÉ : Vérifier aussi dans la session si le quiz a été complété
                $quizCompletedKey = 'quiz_completed_' . $user->id . '_' . $coursId . '_' . $sectionIndex;
                $isCompletedInSession = session()->has($quizCompletedKey);
                
                \Log::info('QUIZ-RESULTS() - État de la session', [
                    'quizCompletedKey' => $quizCompletedKey,
                    'isCompletedInSession' => $isCompletedInSession,
                    'request_params' => $request->except(['cours_id', 'section']),
                    'lastCompletedAttempt_exists' => $lastCompletedAttempt ? 'yes' : 'no'
                ]);
                
                \Log::info('QUIZ-RESULTS() - Après vérification session, avant condition redirection');
                
                // Si aucune tentative n'a été complétée (ni en BDD ni en session) et qu'il n'y a pas de réponses dans la requête
                // ET que l'utilisateur n'a pas encore utilisé ses 2 tentatives, rediriger vers le quiz
                // IMPORTANT : Si toutes les tentatives sont utilisées (maxAttemptNumber >= 2), JAMAIS rediriger vers quiz
                // Toujours afficher les résultats même si vides pour éviter les boucles
                if (!$lastCompletedAttempt && !$isCompletedInSession && empty($request->except(['cours_id', 'section']))) {
                    \Log::info('QUIZ-RESULTS() - Aucune tentative complétée trouvée', [
                        'maxAttemptNumber' => $maxAttemptNumber,
                        'will_redirect' => $maxAttemptNumber < 2
                    ]);
                    
                    // Seulement rediriger si l'utilisateur a encore des tentatives disponibles
                    // Cette condition est CRITIQUE pour éviter les boucles de redirection
                    if ($maxAttemptNumber < 2) {
                        \Log::info('QUIZ-RESULTS() - REDIRECTION vers quiz (tentatives disponibles)', [
                            'maxAttemptNumber' => $maxAttemptNumber
                        ]);
                    return redirect()->route('apprenant.quiz', [
                        'cours_id' => $coursId,
                        'section' => $sectionIndex
                    ])->with('error', 'Vous devez compléter le quiz avant de voir les résultats.');
                }
                    // Si maxAttemptNumber >= 2, continuer pour afficher les résultats (même vides) - PAS DE REDIRECTION
                    \Log::info('QUIZ-RESULTS() - Pas de redirection, toutes tentatives utilisées, affichage des résultats');
                } else {
                    \Log::info('QUIZ-RESULTS() - Condition redirection non remplie, continuation normale', [
                        'has_lastCompletedAttempt' => $lastCompletedAttempt ? 'yes' : 'no',
                        'has_isCompletedInSession' => $isCompletedInSession ? 'yes' : 'no',
                        'request_params_empty' => empty($request->except(['cours_id', 'section'])) ? 'yes' : 'no'
                    ]);
                }
                
                \Log::info('QUIZ-RESULTS() - Après vérification redirection, avant récupération réponses');
                
                try {
                // Si une tentative a été complétée mais qu'il n'y a pas de réponses dans la requête, utiliser les réponses sauvegardées
                $useSavedAnswers = false;
                if ($lastCompletedAttempt && $lastCompletedAttempt->answers && empty($request->except(['cours_id', 'section']))) {
                        \Log::info('QUIZ-RESULTS() - Utilisation des réponses sauvegardées');
                    $useSavedAnswers = true;
                    $studentAnswers = $lastCompletedAttempt->answers ?? [];
                    $correctCount = $lastCompletedAttempt->score ?? 0;
                }
                    
                    \Log::info('QUIZ-RESULTS() - Avant récupération réponses depuis requête', ['useSavedAnswers' => $useSavedAnswers]);
                
                // Récupérer les réponses de l'étudiant depuis la requête (si nouvelle soumission) ou depuis la tentative sauvegardée
                if (!$useSavedAnswers) {
                        \Log::info('QUIZ-RESULTS() - Récupération réponses depuis requête', ['questions_count' => $questions->count()]);
                    foreach ($questions as $question) {
                    $questionKey = 'question_' . $question->id;
                    $studentAnswer = null;
                    
                    if ($question->type === 'vrai_faux') {
                        $studentAnswer = $request->get($questionKey . '_reponse');
                    } elseif ($question->type === 'choix_multiple') {
                        // Pour les choix multiples, récupérer toutes les options cochées
                        $selectedOptions = [];
                        if ($question->options && is_array($question->options)) {
                            foreach ($question->options as $optIndex => $option) {
                                if ($request->has($questionKey . '_option_' . $optIndex) || $request->get($questionKey . '_option_' . $optIndex) === '1') {
                                    $selectedOptions[] = $option['texte'] ?? '';
                                }
                            }
                        }
                        $studentAnswer = $selectedOptions;
                    } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                        $studentAnswer = $request->get($questionKey . '_reponse');
                    }
                    
                    $studentAnswers[$question->id] = $studentAnswer;
                    }
                }
                
                // Calculer les scores si on n'utilise pas les réponses sauvegardées
                if (!$useSavedAnswers) {
                    $correctCount = 0;
                    $totalPoints = 0;
                    $earnedPoints = 0;
                    
                    foreach ($questions as $question) {
                        $studentAnswer = $studentAnswers[$question->id] ?? null;
                        
                        // Vérifier si la réponse est correcte
                        $isCorrect = false;
                        if ($question->type === 'vrai_faux') {
                            // Normaliser les réponses pour la comparaison
                            $normalizedStudentAnswer = $this->normalizeVraiFauxAnswer($studentAnswer);
                            $normalizedCorrectAnswer = $this->normalizeVraiFauxAnswer($question->reponse_correcte);
                            $isCorrect = ($normalizedStudentAnswer === $normalizedCorrectAnswer);
                        } elseif ($question->type === 'choix_multiple') {
                            // Pour les choix multiples, comparer avec les options correctes
                            $correctOptions = [];
                            if ($question->options && is_array($question->options)) {
                                foreach ($question->options as $option) {
                                    if (isset($option['correcte']) && $option['correcte']) {
                                        $correctOptions[] = trim($option['texte'] ?? '');
                                    }
                                }
                            }
                            // Normaliser les réponses de l'étudiant
                            $studentAnswerArray = is_array($studentAnswer) ? $studentAnswer : [];
                            $normalizedStudentAnswers = array_map(function($answer) {
                                return trim($answer);
                            }, $studentAnswerArray);
                            
                            // Trier pour la comparaison
                            sort($correctOptions);
                            sort($normalizedStudentAnswers);
                            $isCorrect = ($correctOptions === $normalizedStudentAnswers);
                        } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                            // Pour texte libre et numérique, comparer directement (insensible à la casse)
                            $normalizedStudent = strtolower(trim($studentAnswer ?? ''));
                            $normalizedCorrect = strtolower(trim($question->reponse_correcte ?? ''));
                            $isCorrect = ($normalizedStudent === $normalizedCorrect && $normalizedStudent !== '');
                        }
                        
                        if ($isCorrect) {
                            $correctCount++;
                            $earnedPoints += $question->points ?? 1;
                        }
                        
                        $totalPoints += $question->points ?? 1;
                    }
                } else {
                    // Utiliser les scores sauvegardés
                    $totalPoints = $totalQuestions;
                    $earnedPoints = $correctCount;
                }
                
                \Log::info('QUIZ-RESULTS() - Après calcul des scores', [
                    'correctCount' => $correctCount,
                    'totalQuestions' => $totalQuestions
                ]);
                
                } catch (\Exception $e) {
                    \Log::error('QUIZ-RESULTS() - ERREUR dans le bloc try', [
                        'error' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e;
                }
            }
        }
        
        // Calculer le pourcentage
        $percentage = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100) : 0;
        
        // Déterminer la performance
        $performance = 'Excellent';
        if ($percentage < 50) {
            $performance = 'À améliorer';
        } elseif ($percentage < 70) {
            $performance = 'Moyen';
        } elseif ($percentage < 90) {
            $performance = 'Bien';
        }
        
        // Enregistrer la tentative complétée
        $attemptsCount = 0;
        $remainingAttempts = 0;
        if ($coursId && $user) {
            // Trouver le attempt_number maximum utilisé (complété ou non)
            // Limiter à 2 maximum pour éviter les problèmes de données corrompues
            $maxAttemptNumberRaw = \App\Models\QuizAttempt::where('user_id', $user->id)
                ->where('cours_id', $coursId)
                ->where('section_index', $sectionIndex)
                ->where('attempt_number', '<=', 2)
                ->max('attempt_number') ?? 0;
            
            $maxAttemptNumber = min($maxAttemptNumberRaw, 2);
            
            // Compter les tentatives complétées (avec completed_at non null) pour l'affichage
            $attemptsCount = \App\Models\QuizAttempt::where('user_id', $user->id)
                ->where('cours_id', $coursId)
                ->where('section_index', $sectionIndex)
                ->whereNotNull('completed_at')
                ->count();
            
            // Récupérer la tentative actuelle (la plus récente non complétée)
            // IMPORTANT : Ne créer une nouvelle tentative QUE si on vient de soumettre le quiz
            // Si on affiche juste les résultats, ne pas créer de nouvelle tentative
            $currentAttempt = \App\Models\QuizAttempt::where('user_id', $user->id)
                ->where('cours_id', $coursId)
                ->where('section_index', $sectionIndex)
                ->whereNull('completed_at')
                ->orderBy('attempt_number', 'desc')
                ->first();
            
            // Ne créer une nouvelle tentative QUE si on a des réponses dans la requête (soumission)
            // Si on affiche juste les résultats, ne pas créer de tentative
            if (!$currentAttempt && !empty($request->except(['cours_id', 'section']))) {
                // SÉCURITÉ : Vérifier strictement avant de créer une nouvelle tentative
                if (!\App\Models\QuizAttempt::canCreateNewAttempt($user->id, $coursId, $sectionIndex)) {
                    \Log::warning('SÉCURITÉ QUIZ-RESULTS : Tentative de création bloquée - limite atteinte', [
                        'user_id' => $user->id,
                        'cours_id' => $coursId,
                        'section_index' => $sectionIndex,
                    ]);
                    // Ne pas créer de tentative, continuer pour afficher les résultats
                } else {
                    \Log::info('QUIZ-RESULTS() - Création nouvelle tentative (soumission quiz)');
                    // Créer une nouvelle tentative si aucune n'existe avec le bon attempt_number
                    $newAttemptNumber = $maxAttemptNumber + 1;
                    // SÉCURITÉ : Double vérification avant création
                    if ($newAttemptNumber > 2) {
                        \Log::warning('SÉCURITÉ QUIZ-RESULTS : Tentative de création avec attempt_number > 2', [
                            'user_id' => $user->id,
                            'cours_id' => $coursId,
                            'section_index' => $sectionIndex,
                            'new_attempt_number' => $newAttemptNumber,
                        ]);
                        // Ne pas créer de tentative
                    } else {
                        try {
                            $currentAttempt = \App\Models\QuizAttempt::create([
                                'user_id' => $user->id,
                                'cours_id' => $coursId,
                                'section_index' => $sectionIndex,
                                'attempt_number' => $newAttemptNumber,
                                'started_at' => now(),
                            ]);
                        } catch (\Exception $e) {
                            \Log::error('SÉCURITÉ QUIZ-RESULTS : Erreur lors de la création de tentative', [
                                'user_id' => $user->id,
                                'cours_id' => $coursId,
                                'section_index' => $sectionIndex,
                                'error' => $e->getMessage(),
                            ]);
                            // Ne pas créer de tentative en cas d'erreur
                        }
                    }
                }
            }
            
            // Mettre à jour la tentative avec les résultats UNIQUEMENT si on a des réponses (soumission)
            if ($currentAttempt && !empty($request->except(['cours_id', 'section']))) {
                \Log::info('QUIZ-RESULTS() - Mise à jour tentative avec résultats');
                $currentAttempt->update([
                    'score' => $correctCount,
                    'total_questions' => $totalQuestions,
                    'answers' => $studentAnswers,
                    'completed_at' => now(),
                ]);
                
                // Sauvegarder automatiquement le résultat dans StudentResult
                if ($cours) {
                    $formateur = $cours->formateur;
                    if ($formateur) {
                        // Récupérer les matières enseignées par le formateur
                        $matieres = $formateur->matieres()->get();
                        
                        // Calculer la note sur 20 (arrondir à l'entier, pas de décimales)
                        $noteSur20 = $totalQuestions > 0 
                            ? round(($correctCount / $totalQuestions) * 20)
                            : 0;
                        
                        // Trouver la matière correspondante
                        $matiereTrouvee = null;
                        $coursTitreLower = strtolower($cours->titre ?? '');
                        
                        if ($matieres->count() == 1) {
                            $matiereTrouvee = $matieres->first();
                        } else {
                            // Chercher la matière dans le titre du cours
                            foreach ($matieres as $matiere) {
                                $matiereNomLower = strtolower($matiere->nom_matiere ?? '');
                                if (str_contains($coursTitreLower, $matiereNomLower) || str_contains($matiereNomLower, $coursTitreLower)) {
                                    $matiereTrouvee = $matiere;
                                    break;
                                }
                            }
                            // Si aucune correspondance, prendre la première matière
                            if (!$matiereTrouvee && $matieres->count() > 0) {
                                $matiereTrouvee = $matieres->first();
                            }
                        }
                        
                        // Sauvegarder dans StudentResult si une matière a été trouvée
                        if ($matiereTrouvee) {
                            $resultat = \App\Models\StudentResult::where('user_id', $user->id)
                                ->where('classe', $matiereTrouvee->nom_matiere)
                                ->first();
                            
                            if ($resultat) {
                                // Toujours mettre à jour avec la dernière note (pas la meilleure)
                                $resultat->update(['quiz' => $noteSur20]);
                            } else {
                                // Créer un nouveau résultat
                                \App\Models\StudentResult::create([
                                    'matricule' => $user->matricule ?? $user->id,
                                    'nom' => $user->nom ?? '',
                                    'prenom' => $user->prenom ?? '',
                                    'classe' => $matiereTrouvee->nom_matiere,
                                    'user_id' => $user->id,
                                    'quiz' => $noteSur20,
                                ]);
                            }
                        }
                    }
                }
                
                // SÉCURITÉ : Marquer le quiz comme complété dans la session pour empêcher le retour
                $quizCompletedKey = 'quiz_completed_' . $user->id . '_' . $coursId . '_' . $sectionIndex;
                session()->put($quizCompletedKey, true);
                session()->save();
                
                // Recompter après la mise à jour
                $attemptsCount = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('cours_id', $coursId)
                    ->where('section_index', $sectionIndex)
                    ->whereNotNull('completed_at')
                    ->count();
            } else {
                \Log::info('QUIZ-RESULTS() - Pas de mise à jour tentative (affichage résultats seulement)');
            }
        }
        
        // Calculer les tentatives restantes basé sur le attempt_number maximum utilisé
        // Limiter à 2 maximum pour éviter les problèmes de données corrompues
        $maxAttemptNumberRaw = \App\Models\QuizAttempt::where('user_id', $user->id)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->where('attempt_number', '<=', 2)
            ->max('attempt_number') ?? 0;
        
        $maxAttemptNumber = min($maxAttemptNumberRaw, 2);
        
        $remainingAttempts = max(0, 2 - $maxAttemptNumber);
        
        \Log::info('QUIZ-RESULTS() - AVANT return view()', [
            'maxAttemptNumber' => $maxAttemptNumber,
            'remainingAttempts' => $remainingAttempts,
            'coursId' => $coursId,
            'sectionIndex' => $sectionIndex,
            'cours' => $cours ? 'exists' : 'null',
            'totalQuestions' => $totalQuestions
        ]);
        
        try {
            \Log::info('QUIZ-RESULTS() - Création de la vue');
            $view = view('apprenant.quiz-results', compact(
            'user',
            'cours',
            'questions',
            'section',
            'sectionIndex',
            'coursId',
            'studentAnswers',
            'correctCount',
            'totalQuestions',
            'totalPoints',
            'earnedPoints',
            'percentage',
            'performance',
            'remainingAttempts',
            'attemptsCount'
        ));
            \Log::info('QUIZ-RESULTS() - Vue créée, retour de la réponse');
            return $view;
        } catch (\Exception $e) {
            \Log::error('QUIZ-RESULTS() - ERREUR lors de la création de la vue', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
        } catch (\Exception $e) {
            \Log::error('QUIZ-RESULTS() - ERREUR GLOBALE DANS LA MÉTHODE', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            // Ne pas rediriger vers quiz-results pour éviter la boucle
            return redirect()->route('apprenant.cours-editeur', [
                'cours_id' => $request->get('cours_id'),
                'section' => $request->get('section', 0)
            ])->with('error', 'Une erreur est survenue lors de l\'affichage des résultats du quiz.');
        }
    }
    
    /**
     * Normalise une réponse VRAI/FAUX pour la comparaison
     * Gère tous les formats possibles : true, false, Vrai, Faux, VRAI, FAUX, etc.
     */
    private function normalizeVraiFauxAnswer($answer)
    {
        if (is_null($answer) || $answer === '') {
            return null;
        }
        
        // Convertir en chaîne et normaliser
        $answer = trim(strtolower((string)$answer));
        
        // Mapper toutes les variations possibles vers "vrai" ou "faux"
        $vraiVariations = ['true', 'vrai', '1', 'yes', 'oui', 'o'];
        $fauxVariations = ['false', 'faux', '0', 'no', 'non', 'n'];
        
        if (in_array($answer, $vraiVariations)) {
            return 'vrai';
        } elseif (in_array($answer, $fauxVariations)) {
            return 'faux';
        }
        
        // Si aucune correspondance, retourner la valeur originale normalisée
        return $answer;
    }
    
    public function parametres()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé. Cette section est réservée aux apprenants.');
        }
        
        // Récupérer les paiements de l'utilisateur depuis la base de données
        // Recharger l'utilisateur avec tous les champs nécessaires
        $userId = $user->id;
        $user = User::select('id', 'name', 'email', 'photo', 'prenom', 'nom', 'date_naissance', 'phone', 'location', 'date_paiement', 'montant_paye', 'paiement_statut', 'paiement_method', 'filiere', 'classe_id', 'niveau_etude', 'last_seen', 'created_at', 'role', 'statut', 'nationalite')
            ->where('id', $userId)
            ->first();
        
        $transactions = [];
        
        // Vérifier si l'utilisateur a des paiements enregistrés dans la base de données
        // Vérifier date_paiement, montant_paye, ou statut effectué
        if ($user && ($user->date_paiement || $user->montant_paye || ($user->paiement_statut && strtolower($user->paiement_statut) === 'effectué'))) {
            $transactions[] = [
                'invoice' => '#3066',
                'date' => $user->date_paiement ?? ($user->created_at ?? now()),
                'status' => (strtolower($user->paiement_statut) === 'effectué') ? 'Payé' : ((strtolower($user->paiement_statut) === 'en attente') ? 'En attente' : 'Annulé'),
                'classe' => $user->niveau_etude ?? 'Licence 1',
                'filiere' => $user->filiere ?? 'Informatique de Gestion',
                'payment_method' => $user->paiement_method ?? 'Mastercard',
                'montant' => $user->montant_paye ?? 0,
            ];
        }
        
        return view('apprenant.parametres', compact('user', 'transactions'));
    }
    
    public function telechargerRecu($invoice)
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé.');
        }
        
        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        // Recharger l'utilisateur avec tous les champs nécessaires
        $user = User::select('id', 'name', 'email', 'photo', 'prenom', 'nom', 'date_naissance', 'date_paiement', 'montant_paye', 'paiement_statut', 'paiement_method', 'filiere', 'niveau_etude', 'created_at')
            ->where('id', $user->id)
            ->first();
        
        $date = now();
        
        // Ajouter le # au numéro de facture pour l'affichage
        $invoiceNumber = '#' . $invoice;
        
        $pdf = Pdf::loadView('apprenant.recu-pdf', compact('user', 'date', 'invoiceNumber'));
        return $pdf->download('recu-' . $invoice . '.pdf');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé.');
        }

        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }

        // Vérifier d'abord que le mot de passe actuel est fourni
        if (!$request->filled('current_password')) {
            return redirect(route('apprenant.parametres') . '#password')
                ->withErrors(['current_password' => 'L\'ancien mot de passe est requis.'])
                ->withInput();
        }

        // Vérifier le mot de passe actuel AVANT de valider le nouveau
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect(route('apprenant.parametres') . '#password')
                ->withErrors(['current_password' => 'Votre mot de passe est incorrect.'])
                ->withInput();
        }

        // Maintenant que l'ancien mot de passe est correct, valider le nouveau
        try {
            $request->validate([
                'new_password' => [
                    'required',
                    'min:8',
                    'confirmed',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
                ],
            ], [
                'new_password.required' => 'Le nouveau mot de passe est requis.',
                'new_password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
                'new_password.confirmed' => 'Les deux mots de passe sont différents.',
                'new_password.regex' => 'Votre mot de passe doit comporter au moins 8 caractères, des lettres miniscules et majuscules et au moins un chiffre.',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect(route('apprenant.parametres') . '#password')
                ->withErrors($e->errors())
                ->withInput();
        }

        // Vérifier que le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->new_password, $user->password)) {
            return redirect(route('apprenant.parametres') . '#password')
                ->withErrors(['new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien mot de passe.'])
                ->withInput();
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect(route('apprenant.parametres') . '#password')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function telechargerBulletin()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé.');
        }

        if ($user->role && $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }

        // Recharger l'utilisateur avec tous les champs nécessaires
        $user = User::select('id', 'name', 'email', 'photo', 'prenom', 'nom', 'date_naissance', 'filiere', 'niveau_etude', 'created_at')
            ->where('id', $user->id)
            ->first();

        // Récupérer toutes les notes de l'apprenant
        $notes = \App\Models\StudentResult::where('user_id', $user->id)
            ->orWhere(function($q) use ($user) {
                // Recherche par nom et prénom uniquement (matricule n'existe pas dans users)
                $q->where('nom', $user->nom ?? null)
                  ->where('prenom', $user->prenom ?? null);
            })
            ->latest()
            ->get();

        $date = now();

        $pdf = Pdf::loadView('apprenant.bulletin-pdf', compact('user', 'date', 'notes'));
        return $pdf->download('bulletin-notes-' . $user->id . '.pdf');
    }

    public function devoirs()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        // Récupérer les formateurs avec la même classe et filière que l'apprenant
        $formateursIds = [];
        if ($user->classe_id && $user->filiere) {
            $formateursIds = \App\Models\User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->pluck('id')
                ->toArray();
        }
        
        // Récupérer les devoirs actifs créés par ces formateurs
        $devoirs = \App\Models\Devoir::whereIn('formateur_id', $formateursIds)
            ->where('actif', true)
            ->with(['matiere', 'formateur', 'questions'])
            ->orderBy('date_devoir', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Récupérer automatiquement les images de couverture des cours des formateurs
        $coursAvecImages = \App\Models\Cours::whereIn('formateur_id', $formateursIds)
            ->whereNotNull('image_couverture')
            ->get()
            ->pluck('image_couverture')
            ->toArray();
        
        foreach($devoirs as $index => $devoir) {
            if (!$devoir->image_couverture && !empty($coursAvecImages)) {
                // Utiliser une image de cours de manière cyclique
                $imageIndex = $index % count($coursAvecImages);
                $devoir->image_couverture = $coursAvecImages[$imageIndex];
            }
        }
        
        // Récupérer les tentatives soumises pour chaque devoir
        $tentativesSoumises = DevoirTentative::where('user_id', $user->id)
            ->where('soumis', true)
            ->with('devoir')
            ->get()
            ->keyBy('devoir_id');
        
        return view('apprenant.devoirs', compact('user', 'devoirs', 'tentativesSoumises'));
    }

    public function passerDevoir($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = \App\Models\Devoir::with(['matiere', 'formateur', 'questions' => function($query) {
            $query->orderBy('ordre');
        }])->findOrFail($id);
        
        // Vérifier que le devoir est actif
        if (!$devoir->actif) {
            return redirect()->route('apprenant.devoirs')->with('error', 'Ce devoir n\'est plus actif.');
        }
        
        // Vérifier que le formateur a la même classe et filière que l'apprenant
        $formateur = $devoir->formateur;
        if (!$formateur || $formateur->classe_id !== $user->classe_id || $formateur->filiere !== $user->filiere) {
            abort(403, 'Accès refusé. Ce devoir ne vous est pas destiné.');
        }
        
        // Vérifier si une tentative soumise existe déjà - SÉCURITÉ CRITIQUE
        $tentativeSoumise = DevoirTentative::where('devoir_id', $devoir->id)
            ->where('user_id', $user->id)
            ->where('soumis', true)
            ->first();
        
        if ($tentativeSoumise) {
            return redirect()->route('apprenant.devoirs')->with('error', 'Vous avez déjà soumis ce devoir. Vous ne pouvez plus le repasser.');
        }
        
        // Vérifier la date et l'heure
        $now = \Carbon\Carbon::now();
        $dateDevoir = $devoir->date_devoir ? \Carbon\Carbon::parse($devoir->date_devoir) : null;
        
        if ($dateDevoir) {
            $dateDevoir->setTime(0, 0, 0);
            $nowDate = $now->copy()->setTime(0, 0, 0);
            
            if ($nowDate->lt($dateDevoir)) {
                return redirect()->route('apprenant.devoirs')->with('error', 'Ce devoir n\'est pas encore disponible.');
            }
        }
        
        // Gérer la tentative de devoir (créer ou récupérer)
        $tentative = DevoirTentative::where('devoir_id', $devoir->id)
            ->where('user_id', $user->id)
            ->where('soumis', false)
            ->first();
        
        // Calculer le temps restant basé sur heure_debut et heure_fin
        $tempsRestant = null;
        $tempsTotal = null;
        $heureFinPrevue = null;
        
        if ($devoir->heure_debut && $devoir->heure_fin) {
            // Extraire uniquement la date (sans l'heure) de date_devoir
            $dateDevoirOnly = $devoir->date_devoir ? \Carbon\Carbon::parse($devoir->date_devoir)->format('Y-m-d') : date('Y-m-d');
            $heureDebut = \Carbon\Carbon::parse($dateDevoirOnly . ' ' . $devoir->heure_debut);
            $heureFin = \Carbon\Carbon::parse($dateDevoirOnly . ' ' . $devoir->heure_fin);
            
            // Si on est avant l'heure de début
            if ($now->lt($heureDebut)) {
                return redirect()->route('apprenant.devoirs')->with('error', 'Le devoir n\'a pas encore commencé. Il commencera à ' . $devoir->heure_debut);
            }
            
            // Si une tentative existe et que le temps est écoulé, soumettre automatiquement
            if ($tentative && $tentative->heure_fin_prevue && $now->gte($tentative->heure_fin_prevue)) {
                // Soumettre automatiquement le devoir
                $this->autoSubmitDevoir($devoir->id, $user->id);
                return redirect()->route('apprenant.devoirs')->with('success', 'Le temps imparti est écoulé. Votre devoir a été soumis automatiquement.');
            }
            
            // Si aucune tentative n'existe, en créer une nouvelle
            if (!$tentative) {
                $tentative = DevoirTentative::create([
                    'devoir_id' => $devoir->id,
                    'user_id' => $user->id,
                    'heure_debut' => $now,
                    'heure_fin_prevue' => $heureFin,
                    'soumis' => false,
                ]);
            }
            
            // Calculer le temps restant jusqu'à l'heure de fin prévue de la tentative
            $heureFinPrevue = $tentative->heure_fin_prevue;
            $tempsRestant = max(0, $now->diffInSeconds($heureFinPrevue, false));
            $tempsTotal = $tentative->heure_debut->diffInSeconds($heureFinPrevue);
            
            // Si le temps est écoulé, soumettre automatiquement
            if ($tempsRestant <= 0) {
                $this->autoSubmitDevoir($devoir->id, $user->id);
                return redirect()->route('apprenant.devoirs')->with('success', 'Le temps imparti est écoulé. Votre devoir a été soumis automatiquement.');
            }
        }
        
        // Récupérer le code de sécurité depuis la base de données
        $codeSecurite = $devoir->code_securite;
        
        if (!$codeSecurite) {
            return redirect()->route('apprenant.devoirs')->with('error', 'Ce devoir n\'a pas de code de sécurité configuré.');
        }
        
        $questions = $devoir->questions;
        $currentQuestionIndex = request()->get('q', 0);
        // Toujours demander le code, même si l'utilisateur a déjà déverrouillé
        // Le code doit être saisi à chaque fois qu'on accède à la page
        $codeUnlocked = false;
        
        return view('apprenant.devoir-pass', compact('user', 'devoir', 'questions', 'currentQuestionIndex', 'tempsRestant', 'tempsTotal', 'codeSecurite', 'codeUnlocked'));
    }

    public function submitDevoir(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = \App\Models\Devoir::with(['matiere', 'formateur', 'questions'])->findOrFail($id);
        
        // Vérifier que le devoir est actif
        if (!$devoir->actif) {
            return redirect()->route('apprenant.devoirs')->with('error', 'Ce devoir n\'est plus actif.');
        }
        
        // Vérifier que le formateur a la même classe et filière que l'apprenant
        $formateur = $devoir->formateur;
        if (!$formateur || $formateur->classe_id !== $user->classe_id || $formateur->filiere !== $user->filiere) {
            abort(403, 'Accès refusé.');
        }
        
        // Vérifier si une tentative soumise existe déjà - SÉCURITÉ CRITIQUE
        $tentativeSoumise = DevoirTentative::where('devoir_id', $devoir->id)
            ->where('user_id', $user->id)
            ->where('soumis', true)
            ->first();
        
        if ($tentativeSoumise) {
            return redirect()->route('apprenant.devoirs')->with('error', 'Vous avez déjà soumis ce devoir. Vous ne pouvez plus le soumettre à nouveau.');
        }
        
        // Vérifier l'heure de fin
        $now = \Carbon\Carbon::now();
        if ($devoir->heure_debut && $devoir->heure_fin) {
            // Extraire uniquement la date (sans l'heure) de date_devoir
            $dateDevoirOnly = $devoir->date_devoir ? \Carbon\Carbon::parse($devoir->date_devoir)->format('Y-m-d') : date('Y-m-d');
            $heureFin = \Carbon\Carbon::parse($dateDevoirOnly . ' ' . $devoir->heure_fin);
            if ($now->gt($heureFin)) {
                return redirect()->route('apprenant.devoirs')->with('error', 'Le temps imparti pour ce devoir est écoulé.');
            }
        }
        
        $questions = $devoir->questions;
        
        // Récupérer les réponses de l'apprenant
        foreach ($questions as $question) {
            $questionKey = 'question_' . $question->id;
            $reponse = null;
            $reponsesMultiple = [];
            
            if ($question->type === 'vrai_faux') {
                $reponse = $request->input($questionKey . '_reponse');
            } elseif ($question->type === 'choix_multiple') {
                if ($question->options && is_array($question->options)) {
                    foreach ($question->options as $optIndex => $option) {
                        if ($request->has($questionKey . '_option_' . $optIndex) || $request->input($questionKey . '_option_' . $optIndex) === '1') {
                            $reponsesMultiple[] = $option['texte'] ?? '';
                        }
                    }
                }
            } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                $reponse = $request->input($questionKey . '_reponse');
            }
            
            // Sauvegarder la réponse
            \App\Models\DevoirReponse::updateOrCreate(
                [
                    'devoir_id' => $devoir->id,
                    'devoir_question_id' => $question->id,
                    'user_id' => $user->id,
                ],
                [
                    'reponse' => $reponse,
                    'reponses_multiple' => !empty($reponsesMultiple) ? $reponsesMultiple : null,
                    'soumis_le' => $now,
                ]
            );
        }
        
            // Marquer la tentative comme soumise
            $tentative = DevoirTentative::where('devoir_id', $devoir->id)
                ->where('user_id', $user->id)
                ->where('soumis', false)
                ->first();
            
            if ($tentative) {
                // Supprimer les anciennes tentatives soumises pour éviter la violation de contrainte unique
                DevoirTentative::where('devoir_id', $devoir->id)
                    ->where('user_id', $user->id)
                    ->where('soumis', true)
                    ->where('id', '!=', $tentative->id)
                    ->delete();
                
                $tentative->update([
                    'soumis' => true,
                    'soumis_le' => $now,
                ]);
            }
            
            // Nettoyer l'état de déverrouillage après soumission
            session()->forget('devoir_unlocked_' . $devoir->id);
            
            return redirect()->route('apprenant.devoirs')->with('success', 'Votre devoir a été soumis avec succès !');
        }

        // Méthode pour soumettre automatiquement le devoir quand le temps est écoulé
        private function autoSubmitDevoir($devoirId, $userId)
        {
            $devoir = \App\Models\Devoir::with(['questions'])->findOrFail($devoirId);
            $user = \App\Models\User::findOrFail($userId);
            
            // Vérifier si une tentative soumise existe déjà - SÉCURITÉ CRITIQUE
            $tentativeSoumise = DevoirTentative::where('devoir_id', $devoir->id)
                ->where('user_id', $user->id)
                ->where('soumis', true)
                ->first();
            
            if ($tentativeSoumise) {
                // La tentative est déjà soumise, ne rien faire
                return;
            }
            
            // Récupérer les réponses existantes de l'apprenant
            $questions = $devoir->questions;
            
            foreach ($questions as $question) {
                // Récupérer la dernière réponse de l'apprenant pour cette question
                $reponseExistante = \App\Models\DevoirReponse::where('devoir_id', $devoir->id)
                    ->where('devoir_question_id', $question->id)
                    ->where('user_id', $user->id)
                    ->latest()
                    ->first();
                
                // Si aucune réponse n'existe, créer une réponse vide
                if (!$reponseExistante) {
                    \App\Models\DevoirReponse::create([
                        'devoir_id' => $devoir->id,
                        'devoir_question_id' => $question->id,
                        'user_id' => $user->id,
                        'reponse' => null,
                        'reponses_multiple' => null,
                        'soumis_le' => \Carbon\Carbon::now(),
                    ]);
                } else {
                    // Mettre à jour la date de soumission
                    $reponseExistante->update([
                        'soumis_le' => \Carbon\Carbon::now(),
                    ]);
                }
            }
            
            // Marquer la tentative comme soumise
            $tentative = DevoirTentative::where('devoir_id', $devoir->id)
                ->where('user_id', $user->id)
                ->where('soumis', false)
                ->first();
            
            if ($tentative) {
                // Supprimer les anciennes tentatives soumises pour éviter la violation de contrainte unique
                DevoirTentative::where('devoir_id', $devoir->id)
                    ->where('user_id', $user->id)
                    ->where('soumis', true)
                    ->where('id', '!=', $tentative->id)
                    ->delete();
                
                $tentative->update([
                    'soumis' => true,
                    'soumis_le' => \Carbon\Carbon::now(),
                ]);
            }
        }

        // Vérifier le temps restant et soumettre automatiquement si nécessaire
        public function checkDevoirTime($id)
        {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'student') {
                return response()->json(['error' => 'Accès refusé.'], 403);
            }
            
            $devoir = \App\Models\Devoir::findOrFail($id);
            $now = \Carbon\Carbon::now();
            
            // Vérifier si une tentative soumise existe déjà - SÉCURITÉ CRITIQUE
            $tentativeSoumise = DevoirTentative::where('devoir_id', $devoir->id)
                ->where('user_id', $user->id)
                ->where('soumis', true)
                ->first();
            
            if ($tentativeSoumise) {
                return response()->json(['error' => 'Vous avez déjà soumis ce devoir.'], 403);
            }
            
            // Récupérer la tentative
            $tentative = DevoirTentative::where('devoir_id', $devoir->id)
                ->where('user_id', $user->id)
                ->where('soumis', false)
                ->first();
            
            if (!$tentative) {
                return response()->json(['error' => 'Aucune tentative active.'], 404);
            }
            
            // Vérifier si le temps est écoulé
            if ($tentative->heure_fin_prevue && $now->gte($tentative->heure_fin_prevue)) {
                // Soumettre automatiquement
                $this->autoSubmitDevoir($devoir->id, $user->id);
                return response()->json([
                    'temps_ecoule' => true,
                    'message' => 'Le temps est écoulé. Le devoir a été soumis automatiquement.'
                ]);
            }
            
            // Calculer le temps restant
            $tempsRestant = max(0, $now->diffInSeconds($tentative->heure_fin_prevue, false));
            
            return response()->json([
                'temps_ecoule' => false,
                'temps_restant' => $tempsRestant,
                'heure_fin_prevue' => $tentative->heure_fin_prevue->toIso8601String(),
            ]);
        }

    public function unlockDevoir(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = \App\Models\Devoir::findOrFail($id);
        
        // Vérifier si une tentative soumise existe déjà - SÉCURITÉ CRITIQUE
        $tentativeSoumise = DevoirTentative::where('devoir_id', $devoir->id)
            ->where('user_id', $user->id)
            ->where('soumis', true)
            ->first();
        
        if ($tentativeSoumise) {
            return response()->json(['success' => false, 'message' => 'Vous avez déjà soumis ce devoir. Vous ne pouvez plus y accéder.'], 403);
        }
        
        $codeSaisi = $request->input('code');
        $codeCorrect = $devoir->code_securite;
        
        if (!$codeCorrect) {
            return response()->json(['success' => false, 'message' => 'Ce devoir n\'a pas de code de sécurité configuré.']);
        }
        
        if ($codeSaisi === $codeCorrect) {
            session(['devoir_unlocked_' . $devoir->id => true]);
            return response()->json(['success' => true, 'message' => 'Code correct ! L\'interface est déverrouillée.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Code incorrect. Veuillez réessayer.']);
        }
    }

    public function examens()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        // Récupérer les formateurs avec la même classe et filière que l'apprenant
        $formateursIds = [];
        if ($user->classe_id && $user->filiere) {
            $formateursIds = \App\Models\User::where('role', 'teacher')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->pluck('id')
                ->toArray();
        }
        
        // Récupérer les examens actifs créés par ces formateurs
        $examens = \App\Models\Examen::whereIn('formateur_id', $formateursIds)
            ->where('actif', true)
            ->with(['matiere', 'formateur', 'questions'])
            ->orderBy('date_examen', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Récupérer automatiquement les images de couverture des cours des formateurs
        $coursAvecImages = \App\Models\Cours::whereIn('formateur_id', $formateursIds)
            ->whereNotNull('image_couverture')
            ->get()
            ->pluck('image_couverture')
            ->toArray();
        
        foreach($examens as $index => $examen) {
            if (!$examen->image_couverture && !empty($coursAvecImages)) {
                // Utiliser une image de cours de manière cyclique
                $imageIndex = $index % count($coursAvecImages);
                $examen->image_couverture = $coursAvecImages[$imageIndex];
            }
        }
        
        // Récupérer les tentatives soumises pour chaque examen
        $tentativesSoumises = ExamenTentative::where('user_id', $user->id)
            ->where('soumis', true)
            ->with('examen')
            ->get()
            ->keyBy('examen_id');
        
        return view('apprenant.examens', compact('user', 'examens', 'tentativesSoumises'));
    }

    public function passerExamen($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = \App\Models\Examen::with(['matiere', 'formateur', 'questions' => function($query) {
            $query->orderBy('ordre');
        }])->findOrFail($id);
        
        // Vérifier que l'examen est actif
        if (!$examen->actif) {
            return redirect()->route('apprenant.examens')->with('error', 'Cet examen n\'est plus actif.');
        }
        
        // Vérifier que le formateur a la même classe et filière que l'apprenant
        $formateur = $examen->formateur;
        if (!$formateur || $formateur->classe_id !== $user->classe_id || $formateur->filiere !== $user->filiere) {
            abort(403, 'Accès refusé. Cet examen ne vous est pas destiné.');
        }
        
        // Vérifier la date et l'heure
        $now = \Carbon\Carbon::now();
        $dateExamen = $examen->date_examen ? \Carbon\Carbon::parse($examen->date_examen) : null;
        
        if ($dateExamen) {
            $dateExamen->setTime(0, 0, 0);
            $nowDate = $now->copy()->setTime(0, 0, 0);
            
            if ($nowDate->lt($dateExamen)) {
                return redirect()->route('apprenant.examens')->with('error', 'Cet examen n\'est pas encore disponible.');
            }
        }
        
        // Gérer la tentative d'examen (créer ou récupérer)
        $tentative = ExamenTentative::where('examen_id', $examen->id)
            ->where('user_id', $user->id)
            ->where('soumis', false)
            ->first();
        
        // Calculer le temps restant basé sur heure_debut et heure_fin
        $tempsRestant = null;
        $tempsTotal = null;
        $heureFinPrevue = null;
        
        if ($examen->heure_debut && $examen->heure_fin) {
            // Extraire uniquement la date (sans l'heure) de date_examen
            $dateExamenOnly = $examen->date_examen ? \Carbon\Carbon::parse($examen->date_examen)->format('Y-m-d') : date('Y-m-d');
            $heureDebut = \Carbon\Carbon::parse($dateExamenOnly . ' ' . $examen->heure_debut);
            $heureFin = \Carbon\Carbon::parse($dateExamenOnly . ' ' . $examen->heure_fin);
            
            // Si on est avant l'heure de début
            if ($now->lt($heureDebut)) {
                return redirect()->route('apprenant.examens')->with('error', 'L\'examen n\'a pas encore commencé. Il commencera à ' . $examen->heure_debut);
            }
            
            // Si une tentative existe et que le temps est écoulé, soumettre automatiquement
            if ($tentative && $tentative->heure_fin_prevue && $now->gte($tentative->heure_fin_prevue)) {
                // Soumettre automatiquement l'examen
                $this->autoSubmitExamen($examen->id, $user->id);
                return redirect()->route('apprenant.examens')->with('success', 'Le temps imparti est écoulé. Votre examen a été soumis automatiquement.');
            }
            
            // Si aucune tentative n'existe, en créer une nouvelle
            if (!$tentative) {
                $tentative = ExamenTentative::create([
                    'examen_id' => $examen->id,
                    'user_id' => $user->id,
                    'heure_debut' => $now,
                    'heure_fin_prevue' => $heureFin,
                    'soumis' => false,
                ]);
            }
            
            // Calculer le temps restant jusqu'à l'heure de fin prévue de la tentative
            $heureFinPrevue = $tentative->heure_fin_prevue;
            $tempsRestant = max(0, $now->diffInSeconds($heureFinPrevue, false));
            $tempsTotal = $tentative->heure_debut->diffInSeconds($heureFinPrevue);
            
            // Si le temps est écoulé, soumettre automatiquement
            if ($tempsRestant <= 0) {
                $this->autoSubmitExamen($examen->id, $user->id);
                return redirect()->route('apprenant.examens')->with('success', 'Le temps imparti est écoulé. Votre examen a été soumis automatiquement.');
            }
        }
        
        // Récupérer le code de sécurité depuis la base de données
        $codeSecurite = $examen->code_securite;
        
        if (!$codeSecurite) {
            return redirect()->route('apprenant.examens')->with('error', 'Cet examen n\'a pas de code de sécurité configuré.');
        }
        
        $questions = $examen->questions;
        $currentQuestionIndex = request()->get('q', 0);
        // Toujours demander le code, même si l'utilisateur a déjà déverrouillé
        // Le code doit être saisi à chaque fois qu'on accède à la page
        $codeUnlocked = false;
        
        return view('apprenant.examen-pass', compact('user', 'examen', 'questions', 'currentQuestionIndex', 'tempsRestant', 'tempsTotal', 'codeSecurite', 'codeUnlocked', 'tentative'));
    }

    public function submitExamen(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = \App\Models\Examen::with(['matiere', 'formateur', 'questions'])->findOrFail($id);
        
        // Vérifier que l'examen est actif
        if (!$examen->actif) {
            return redirect()->route('apprenant.examens')->with('error', 'Cet examen n\'est plus actif.');
        }
        
        // Vérifier que le formateur a la même classe et filière que l'apprenant
        $formateur = $examen->formateur;
        if (!$formateur || $formateur->classe_id !== $user->classe_id || $formateur->filiere !== $user->filiere) {
            abort(403, 'Accès refusé.');
        }
        
        // Vérifier l'heure de fin
        $now = \Carbon\Carbon::now();
        if ($examen->heure_debut && $examen->heure_fin) {
            // Extraire uniquement la date (sans l'heure) de date_examen
            $dateExamenOnly = $examen->date_examen ? \Carbon\Carbon::parse($examen->date_examen)->format('Y-m-d') : date('Y-m-d');
            $heureFin = \Carbon\Carbon::parse($dateExamenOnly . ' ' . $examen->heure_fin);
            if ($now->gt($heureFin)) {
                return redirect()->route('apprenant.examens')->with('error', 'Le temps imparti pour cet examen est écoulé.');
            }
        }
        
        $questions = $examen->questions;
        
        // Récupérer les réponses de l'apprenant
        foreach ($questions as $question) {
            $questionKey = 'question_' . $question->id;
            $reponse = null;
            $reponsesMultiple = [];
            
            if ($question->type === 'vrai_faux') {
                $reponse = $request->input($questionKey . '_reponse');
            } elseif ($question->type === 'choix_multiple') {
                if ($question->options && is_array($question->options)) {
                    foreach ($question->options as $optIndex => $option) {
                        if ($request->has($questionKey . '_option_' . $optIndex) || $request->input($questionKey . '_option_' . $optIndex) === '1') {
                            $reponsesMultiple[] = $option['texte'] ?? '';
                        }
                    }
                }
            } elseif ($question->type === 'texte_libre' || $question->type === 'numerique') {
                $reponse = $request->input($questionKey . '_reponse');
            }
            
            // Sauvegarder la réponse
            \App\Models\ExamenReponse::updateOrCreate(
                [
                    'examen_id' => $examen->id,
                    'examen_question_id' => $question->id,
                    'user_id' => $user->id,
                ],
                [
                    'reponse' => $reponse,
                    'reponses_multiple' => !empty($reponsesMultiple) ? $reponsesMultiple : null,
                    'soumis_le' => $now,
                ]
            );
        }
        
        // Marquer la tentative comme soumise
        $tentative = ExamenTentative::where('examen_id', $examen->id)
            ->where('user_id', $user->id)
            ->where('soumis', false)
            ->first();
        
        if ($tentative) {
            $tentative->update([
                'soumis' => true,
                'soumis_le' => $now,
            ]);
        }
        
        // Nettoyer l'état de déverrouillage après soumission
        session()->forget('examen_unlocked_' . $examen->id);
        
        return redirect()->route('apprenant.examens')->with('success', 'Votre examen a été soumis avec succès !');
    }

    // Méthode pour soumettre automatiquement l'examen quand le temps est écoulé
    private function autoSubmitExamen($examenId, $userId)
    {
        $examen = \App\Models\Examen::with(['questions'])->findOrFail($examenId);
        $user = \App\Models\User::findOrFail($userId);
        
        // Récupérer les réponses existantes de l'apprenant
        $questions = $examen->questions;
        
        foreach ($questions as $question) {
            // Récupérer la dernière réponse de l'apprenant pour cette question
            $reponseExistante = \App\Models\ExamenReponse::where('examen_id', $examen->id)
                ->where('examen_question_id', $question->id)
                ->where('user_id', $user->id)
                ->latest()
                ->first();
            
            // Si aucune réponse n'existe, créer une réponse vide
            if (!$reponseExistante) {
                \App\Models\ExamenReponse::create([
                    'examen_id' => $examen->id,
                    'examen_question_id' => $question->id,
                    'user_id' => $user->id,
                    'reponse' => null,
                    'reponses_multiple' => null,
                    'soumis_le' => \Carbon\Carbon::now(),
                ]);
            } else {
                // Mettre à jour la date de soumission
                $reponseExistante->update([
                    'soumis_le' => \Carbon\Carbon::now(),
                ]);
            }
        }
        
        // Marquer la tentative comme soumise
        $tentative = ExamenTentative::where('examen_id', $examen->id)
            ->where('user_id', $user->id)
            ->where('soumis', false)
            ->first();
        
        if ($tentative) {
            $tentative->update([
                'soumis' => true,
                'soumis_le' => \Carbon\Carbon::now(),
            ]);
        }
    }

    // Vérifier le temps restant et soumettre automatiquement si nécessaire
    public function checkExamenTime($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            return response()->json(['error' => 'Accès refusé.'], 403);
        }
        
        $examen = \App\Models\Examen::findOrFail($id);
        $now = \Carbon\Carbon::now();
        
        // Récupérer la tentative
        $tentative = ExamenTentative::where('examen_id', $examen->id)
            ->where('user_id', $user->id)
            ->where('soumis', false)
            ->first();
        
        if (!$tentative) {
            return response()->json(['error' => 'Aucune tentative active.'], 404);
        }
        
        // Vérifier si le temps est écoulé
        if ($tentative->heure_fin_prevue && $now->gte($tentative->heure_fin_prevue)) {
            // Soumettre automatiquement
            $this->autoSubmitExamen($examen->id, $user->id);
            return response()->json([
                'temps_ecoule' => true,
                'message' => 'Le temps est écoulé. L\'examen a été soumis automatiquement.'
            ]);
        }
        
        // Calculer le temps restant
        $tempsRestant = max(0, $now->diffInSeconds($tentative->heure_fin_prevue, false));
        
        return response()->json([
            'temps_ecoule' => false,
            'temps_restant' => $tempsRestant,
            'heure_fin_prevue' => $tentative->heure_fin_prevue->toIso8601String(),
        ]);
    }

    public function unlockExamen(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = \App\Models\Examen::findOrFail($id);
        $codeSaisi = $request->input('code');
        $codeCorrect = $examen->code_securite;
        
        if (!$codeCorrect) {
            return response()->json(['success' => false, 'message' => 'Cet examen n\'a pas de code de sécurité configuré.']);
        }
        
        if ($codeSaisi === $codeCorrect) {
            session(['examen_unlocked_' . $examen->id => true]);
            return response()->json(['success' => true, 'message' => 'Code correct ! L\'interface est déverrouillée.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Code incorrect. Veuillez réessayer.']);
        }
    }
    
    public function toggleFavori(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Non authentifié'], 401);
        }
        
        $request->validate([
            'formateur_id' => 'required|integer|exists:users,id',
            'matiere_nom' => 'required|string',
        ]);
        
        $favori = Favori::where('user_id', $user->id)
            ->where('formateur_id', $request->formateur_id)
            ->where('matiere_nom', $request->matiere_nom)
            ->first();
        
        if ($favori) {
            // Retirer des favoris
            $favori->delete();
            $isFavori = false;
        } else {
            // Ajouter aux favoris
            Favori::create([
                'user_id' => $user->id,
                'formateur_id' => $request->formateur_id,
                'matiere_nom' => $request->matiere_nom,
            ]);
            $isFavori = true;
        }
        
        // Compter les favoris
        $favorisCount = Favori::where('user_id', $user->id)->count();
        
        return response()->json([
            'success' => true,
            'is_favori' => $isFavori,
            'favoris_count' => $favorisCount,
        ]);
    }
    
    public function getFavorisCount()
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['count' => 0], 401);
        }
        
        $count = Favori::where('user_id', $user->id)->count();
        
        return response()->json(['count' => $count]);
    }
}
