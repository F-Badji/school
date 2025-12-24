<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\StudentResult;
use App\Models\User;
use App\Models\Matiere;
use App\Models\QuizAttempt;
use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FormateurNoteController extends Controller
{
    /**
     * Afficher toutes les notes des apprenants
     */
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        // Récupérer toutes les matières enseignées par ce formateur
        $matieres = $user->matieres()->get();
        
        // Récupérer les apprenants avec la même classe et filière
        $apprenants = collect();
        
        if ($user->classe_id && $user->filiere) {
            // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
            $apprenants = User::where('role', 'student')
                ->where('classe_id', $user->classe_id)
                ->where('filiere', $user->filiere)
                ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                ->orderBy('nom')
                ->orderBy('prenom')
                ->get();
        }
        
        // Récupérer tous les cours du formateur
        $coursDuFormateur = Cours::where('formateur_id', $user->id)
            ->where('actif', true)
            ->with('formateur')
            ->get();
        
        // Créer un mapping cours -> matières basé sur les matières enseignées par le formateur
        // Si le formateur enseigne une seule matière, tous ses cours lui sont associés
        // Sinon, on utilise le titre du cours pour déterminer la matière
        $coursMatiereMap = [];
        $matieresCount = $matieres->count();
        
        foreach ($coursDuFormateur as $cours) {
            $coursMatiereMap[$cours->id] = [];
            
            if ($matieresCount == 1) {
                // Si le formateur n'enseigne qu'une seule matière, associer tous les cours à cette matière
                $coursMatiereMap[$cours->id][] = $matieres->first()->id;
            } else {
                // Si plusieurs matières, essayer de trouver la correspondance via le titre
                $coursTitreLower = strtolower($cours->titre ?? '');
                
                foreach ($matieres as $matiere) {
                    $matiereNomLower = strtolower($matiere->nom_matiere ?? '');
                    
                    // Vérifier si le nom de la matière est dans le titre du cours
                    if (str_contains($coursTitreLower, $matiereNomLower) || str_contains($matiereNomLower, $coursTitreLower)) {
                        $coursMatiereMap[$cours->id][] = $matiere->id;
                    }
                }
                
                // Si aucune correspondance trouvée, associer à toutes les matières du formateur
                if (empty($coursMatiereMap[$cours->id])) {
                    $coursMatiereMap[$cours->id] = $matieres->pluck('id')->toArray();
                }
            }
        }
        
        // Organiser les notes par apprenant et par matière
        $notesParApprenant = [];
        
        foreach ($apprenants as $apprenant) {
            $notesParApprenant[$apprenant->id] = [
                'apprenant' => $apprenant,
                'matieres' => []
            ];
            
            // Récupérer tous les quiz attempts de l'apprenant pour les cours du formateur
            $quizAttempts = QuizAttempt::where('user_id', $apprenant->id)
                ->whereIn('cours_id', $coursDuFormateur->pluck('id'))
                ->whereNotNull('completed_at')
                ->whereNotNull('score')
                ->whereNotNull('total_questions')
                ->with('cours')
                ->get();
            
            // Grouper les quiz attempts par matière et prendre la dernière tentative
            $quizParMatiere = [];
            foreach ($quizAttempts as $attempt) {
                $coursId = $attempt->cours_id;
                if (isset($coursMatiereMap[$coursId])) {
                    foreach ($coursMatiereMap[$coursId] as $matiereId) {
                        if (!isset($quizParMatiere[$matiereId])) {
                            $quizParMatiere[$matiereId] = [];
                        }
                        // Calculer la note sur 20 (arrondir à l'entier, pas de décimales)
                        $noteSur20 = $attempt->total_questions > 0 
                            ? round(($attempt->score / $attempt->total_questions) * 20)
                            : 0;
                        $quizParMatiere[$matiereId][] = [
                            'note' => $noteSur20,
                            'score' => $attempt->score,
                            'total' => $attempt->total_questions,
                            'cours' => $attempt->cours->titre ?? 'Cours',
                            'date' => $attempt->completed_at,
                        ];
                    }
                }
            }
            
            // Pour chaque matière, prendre la dernière tentative (la plus récente)
            foreach ($quizParMatiere as $matiereId => $tentatives) {
                if (!empty($tentatives)) {
                    // Trier par date décroissante et prendre la première (la plus récente)
                    usort($tentatives, function($a, $b) {
                        return $b['date'] <=> $a['date'];
                    });
                    $quizParMatiere[$matiereId] = [$tentatives[0]]; // Garder seulement la dernière
                }
            }
            
            foreach ($matieres as $matiere) {
                // Récupérer les notes manuelles depuis StudentResult
                // Récupérer les résultats par semestre
                $resultats = StudentResult::where('user_id', $apprenant->id)
                    ->where('classe', $matiere->nom_matiere)
                    ->get();
                
                // Organiser les notes par semestre
                $notesParSemestre = [];
                foreach ($resultats as $resultat) {
                    $semestreKey = $resultat->semestre ?? 'null';
                    if (!isset($notesParSemestre[$semestreKey])) {
                        $notesParSemestre[$semestreKey] = [
                            'quiz' => null,
                            'devoir' => null,
                            'examen' => null,
                            'resultat_id' => null,
                            'semestre' => $resultat->semestre,
                        ];
                    }
                    
                    if ($resultat->quiz !== null) {
                        $notesParSemestre[$semestreKey]['quiz'] = $resultat->quiz;
                    }
                    if ($resultat->devoir !== null) {
                        $notesParSemestre[$semestreKey]['devoir'] = $resultat->devoir;
                    }
                    if ($resultat->examen !== null) {
                        $notesParSemestre[$semestreKey]['examen'] = $resultat->examen;
                    }
                    $notesParSemestre[$semestreKey]['resultat_id'] = $resultat->id;
                }
                
                // Pour compatibilité, garder aussi les valeurs globales
                $quiz = null;
                $devoir = null;
                $examen = null;
                $semestre = null;
                $resultatId = null;
                
                // Prendre le premier résultat trouvé (ou le plus récent)
                if ($resultats->count() > 0) {
                    $premierResultat = $resultats->first();
                    $quiz = $premierResultat->quiz;
                    $devoir = $premierResultat->devoir;
                    $examen = $premierResultat->examen;
                    $semestre = $premierResultat->semestre;
                    $resultatId = $premierResultat->id;
                }
                
                // Si on a des résultats de quiz automatiques, utiliser la dernière tentative
                // Le quiz sera ajouté à tous les semestres ou au semestre le plus récent
                if (isset($quizParMatiere[$matiere->id]) && !empty($quizParMatiere[$matiere->id])) {
                    // Prendre la dernière tentative (déjà triée par date décroissante)
                    $derniereTentative = $quizParMatiere[$matiere->id][0];
                    $derniereNote = $derniereTentative['note']; // Déjà arrondie à l'entier
                    
                    // Utiliser la dernière note automatique (elle remplace toujours la note manuelle)
                    $quiz = $derniereNote;
                    
                    // Ajouter le quiz à tous les semestres dans notesParSemestre
                    foreach ($notesParSemestre as $semKey => &$noteSem) {
                        $noteSem['quiz'] = $derniereNote;
                    }
                    unset($noteSem);
                    
                    // Si aucun semestre n'existe, créer une entrée pour le quiz
                    if (empty($notesParSemestre)) {
                        $notesParSemestre['null'] = [
                            'quiz' => $derniereNote,
                            'devoir' => null,
                            'examen' => null,
                            'resultat_id' => null,
                            'semestre' => null,
                        ];
                    }
                    
                    // Sauvegarder automatiquement la dernière note dans StudentResult
                    if (!$resultatId) {
                        $resultat = StudentResult::where('user_id', $apprenant->id)
                            ->where('classe', $matiere->nom_matiere)
                            ->first();
                        
                        if (!$resultat) {
                            StudentResult::create([
                                'matricule' => $apprenant->matricule ?? $apprenant->id,
                                'nom' => $apprenant->nom ?? '',
                                'prenom' => $apprenant->prenom ?? '',
                                'classe' => $matiere->nom_matiere,
                                'user_id' => $apprenant->id,
                                'quiz' => $derniereNote,
                            ]);
                            $resultatId = StudentResult::where('user_id', $apprenant->id)
                                ->where('classe', $matiere->nom_matiere)
                                ->value('id');
                        } else {
                            // Mettre à jour avec la dernière note
                            $resultat->update(['quiz' => $derniereNote]);
                            $resultatId = $resultat->id;
                        }
                    } else {
                        // Mettre à jour la note existante avec la dernière note
                        $resultat = StudentResult::find($resultatId);
                        if ($resultat) {
                            $resultat->update(['quiz' => $derniereNote]);
                        }
                    }
                }
                
                // Récupérer le titre du cours pour le quiz (de la dernière tentative)
                $coursTitreQuiz = null;
                if (isset($quizParMatiere[$matiere->id]) && !empty($quizParMatiere[$matiere->id])) {
                    $derniereTentative = $quizParMatiere[$matiere->id][0];
                    $coursTitreQuiz = $derniereTentative['cours'] ?? null;
                }
                
                // Stocker les notes par semestre
                $notesParApprenant[$apprenant->id]['matieres'][$matiere->id] = [
                    'matiere' => $matiere->nom_matiere,
                    'matiere_id' => $matiere->id,
                    'quiz' => $quiz,
                    'quiz_cours_titre' => $coursTitreQuiz,
                    'devoir' => $devoir,
                    'examen' => $examen,
                    'semestre' => $semestre,
                    'resultat_id' => $resultatId,
                    'notes_par_semestre' => $notesParSemestre, // Stocker toutes les notes par semestre
                ];
            }
        }
        
        // Déterminer les semestres selon la classe du formateur
        $semestresMapping = [
            'licence_1' => [1, 2],
            'licence_2' => [3, 4],
            'licence_3' => [5, 6],
            'master_1' => [7, 8],
            'master_2' => [9, 10],
        ];
        
        $classeId = $user->classe_id ?? 'licence_1';
        $semestres = $semestresMapping[$classeId] ?? [1, 2];
        $semestre1 = $semestres[0];
        $semestre2 = $semestres[1];
        
        // Passer les apprenants avec leurs informations pour le JavaScript
        $apprenantsData = $apprenants->map(function($apprenant) {
            return [
                'id' => $apprenant->id,
                'nom' => $apprenant->nom,
                'prenom' => $apprenant->prenom,
                'niveau_etude' => $apprenant->niveau_etude ?? 'Licence 1',
            ];
        });
        
        return view('formateur.notes', compact('user', 'notesParApprenant', 'matieres', 'apprenants', 'apprenantsData', 'semestre1', 'semestre2'));
    }
    
    /**
     * Enregistrer ou mettre à jour une note
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'semestre' => 'required|integer|min:1|max:10',
            'notes' => 'required|array',
            'notes.*.quiz' => 'nullable|numeric|min:0|max:20',
            'notes.*.devoir' => 'nullable|numeric|min:0|max:20',
            'notes.*.examen' => 'nullable|numeric|min:0|max:20',
        ]);
        
        $apprenant = User::findOrFail($validated['user_id']);
        
        // Vérifier que l'apprenant est dans la même classe et filière que le formateur
        if ($apprenant->classe_id !== $user->classe_id || $apprenant->filiere !== $user->filiere) {
            return back()->with('error', 'Accès refusé. Cet apprenant ne fait pas partie de votre classe.');
        }
        
        $savedCount = 0;
        
        // Traiter chaque matière
        foreach ($validated['notes'] as $matiereId => $noteData) {
            $matiere = Matiere::find($matiereId);
            
            if (!$matiere) {
                continue;
            }
            
            // Vérifier que la matière appartient au formateur
            if (!$user->matieres()->where('matieres.id', $matiere->id)->exists()) {
                continue;
            }
            
            // Chercher un résultat existant (par user_id ET classe pour correspondance exacte)
            $resultat = StudentResult::where('user_id', $apprenant->id)
                ->where('classe', $matiere->nom_matiere)
                ->first();
            
            // Si pas trouvé par user_id, chercher aussi par nom et prénom (pour compatibilité)
            if (!$resultat && $apprenant->nom && $apprenant->prenom) {
                $resultat = StudentResult::where('nom', $apprenant->nom)
                    ->where('prenom', $apprenant->prenom)
                    ->where('classe', $matiere->nom_matiere)
                    ->first();
            }
            
            if ($resultat) {
                // Mettre à jour - utiliser array_key_exists() pour accepter 0 comme valeur valide
                $updateData = [
                    'user_id' => $apprenant->id, // S'assurer que user_id est défini
                    'semestre' => $validated['semestre'],
                ];
                
                // Mettre à jour quiz si présent (accepter 0)
                if (array_key_exists('quiz', $noteData)) {
                    $updateData['quiz'] = $noteData['quiz'];
                } else {
                    $updateData['quiz'] = $resultat->quiz;
                }
                
                // Mettre à jour devoir si présent (accepter 0)
                if (array_key_exists('devoir', $noteData)) {
                    $updateData['devoir'] = $noteData['devoir'];
                } else {
                    $updateData['devoir'] = $resultat->devoir;
                }
                
                // Mettre à jour examen si présent (accepter 0)
                if (array_key_exists('examen', $noteData)) {
                    $updateData['examen'] = $noteData['examen'];
                } else {
                    $updateData['examen'] = $resultat->examen;
                }
                
                $resultat->update($updateData);
            } else {
                // Créer un nouveau résultat
                StudentResult::create([
                    'matricule' => $apprenant->matricule ?? $apprenant->id,
                    'nom' => $apprenant->nom ?? '',
                    'prenom' => $apprenant->prenom ?? '',
                    'classe' => $matiere->nom_matiere,
                    'user_id' => $apprenant->id,
                    'semestre' => $validated['semestre'],
                    'quiz' => array_key_exists('quiz', $noteData) ? $noteData['quiz'] : null,
                    'devoir' => array_key_exists('devoir', $noteData) ? $noteData['devoir'] : null,
                    'examen' => array_key_exists('examen', $noteData) ? $noteData['examen'] : null,
                ]);
            }
            
            $savedCount++;
        }
        
        if ($savedCount > 0) {
            return back()->with('success', 'Notes enregistrées avec succès.');
        } else {
            return back()->with('error', 'Aucune note n\'a pu être enregistrée.');
        }
    }
    
    /**
     * Supprimer une note
     */
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $resultat = StudentResult::findOrFail($id);
        
        // Vérifier que le résultat appartient à un apprenant de la même classe/filière
        $apprenant = $resultat->user;
        if (!$apprenant || $apprenant->classe_id !== $user->classe_id || $apprenant->filiere !== $user->filiere) {
            return back()->with('error', 'Accès refusé.');
        }
        
        // Vérifier que la matière appartient au formateur
        $matiere = $user->matieres()->where('nom_matiere', $resultat->classe)->first();
        if (!$matiere) {
            return back()->with('error', 'Accès refusé.');
        }
        
        $resultat->delete();
        
        return back()->with('success', 'Note supprimée avec succès.');
    }
    
    /**
     * Envoyer les notes à l'administrateur
     */
    public function sendToAdmin(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien un formateur
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $validated = $request->validate([
            'apprenant_id' => 'required|exists:users,id',
        ]);
        
        $apprenant = User::findOrFail($validated['apprenant_id']);
        
        // SÉCURITÉ : Vérifier que l'apprenant est dans la même classe et filière
        if ($apprenant->classe_id !== $user->classe_id || $apprenant->filiere !== $user->filiere) {
            return back()->with('error', 'Accès refusé. L\'apprenant n\'est pas dans votre classe ou filière.');
        }
        
        // SÉCURITÉ : Vérifier que l'apprenant a le statut de paiement effectué
        if ($apprenant->paiement_statut !== 'effectué') {
            return back()->with('error', 'Accès refusé. L\'apprenant n\'a pas effectué son paiement.');
        }
        
        // Récupérer toutes les notes de l'apprenant pour toutes les matières du formateur
        $matieres = $user->matieres()->get();
        
        if ($matieres->isEmpty()) {
            return back()->with('error', 'Aucune matière assignée à votre compte.');
        }
        
        // Récupérer les cours du formateur
        $coursDuFormateur = Cours::where('formateur_id', $user->id)
            ->where('actif', true)
            ->get();
        
        // Créer le mapping cours -> matières (même logique que dans index)
        $coursMatiereMap = [];
        $matieresCount = $matieres->count();
        
        foreach ($coursDuFormateur as $cours) {
            $coursMatiereMap[$cours->id] = [];
            
            if ($matieresCount == 1) {
                $coursMatiereMap[$cours->id][] = $matieres->first()->id;
            } else {
                $coursTitreLower = strtolower($cours->titre ?? '');
                foreach ($matieres as $matiere) {
                    $matiereNomLower = strtolower($matiere->nom_matiere ?? '');
                    if (str_contains($coursTitreLower, $matiereNomLower) || str_contains($matiereNomLower, $coursTitreLower)) {
                        $coursMatiereMap[$cours->id][] = $matiere->id;
                    }
                }
                if (empty($coursMatiereMap[$cours->id])) {
                    $coursMatiereMap[$cours->id] = $matieres->pluck('id')->toArray();
                }
            }
        }
        
        // Récupérer les quiz attempts
        $quizAttempts = QuizAttempt::where('user_id', $apprenant->id)
            ->whereIn('cours_id', $coursDuFormateur->pluck('id'))
            ->whereNotNull('completed_at')
            ->whereNotNull('score')
            ->whereNotNull('total_questions')
            ->with('cours')
            ->get();
        
        // Grouper les quiz par matière et prendre la dernière tentative
        $quizParMatiere = [];
        foreach ($quizAttempts as $attempt) {
            $coursId = $attempt->cours_id;
            if (isset($coursMatiereMap[$coursId])) {
                foreach ($coursMatiereMap[$coursId] as $matiereId) {
                    if (!isset($quizParMatiere[$matiereId])) {
                        $quizParMatiere[$matiereId] = [];
                    }
                    $noteSur20 = $attempt->total_questions > 0 
                        ? round(($attempt->score / $attempt->total_questions) * 20, 2)
                        : 0;
                    $quizParMatiere[$matiereId][] = [
                        'note' => $noteSur20,
                        'date' => $attempt->completed_at,
                    ];
                }
            }
        }
        
        // Pour chaque matière, prendre la dernière tentative (la plus récente)
        foreach ($quizParMatiere as $matiereId => $tentatives) {
            if (!empty($tentatives)) {
                // Trier par date décroissante et prendre la première (la plus récente)
                usort($tentatives, function($a, $b) {
                    return $b['date'] <=> $a['date'];
                });
                $quizParMatiere[$matiereId] = $tentatives[0]['note']; // Garder seulement la note de la dernière
            }
        }
        
        // Récupérer toutes les notes de l'apprenant (tous les semestres)
        $studentResults = StudentResult::where('user_id', $apprenant->id)
            ->whereIn('classe', $matieres->pluck('nom_matiere'))
            ->get();
        
        $notesEnregistrees = 0;
        $notesEnvoyees = [];
        
        // Pour chaque matière et chaque semestre, créer un enregistrement dans la table notes
        foreach ($matieres as $matiere) {
            // Récupérer les notes pour cette matière (tous les semestres)
            $resultatsMatiere = $studentResults->where('classe', $matiere->nom_matiere);
            
            // Si pas de résultats, créer quand même une entrée si on a un quiz
            if ($resultatsMatiere->isEmpty()) {
                $quiz = isset($quizParMatiere[$matiere->id]) ? $quizParMatiere[$matiere->id] : null;
                
                if ($quiz !== null) {
                    // Créer une entrée avec seulement le quiz
                    // Pour les quiz seuls, la moyenne est 0 car il n'y a pas de devoir ni d'examen
                    $moyenne = 0;
                    // Formater la date de naissance correctement
                    $dateNaissance = null;
                    if ($apprenant->date_naissance) {
                        try {
                            $dateNaissance = Carbon::parse($apprenant->date_naissance)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dateNaissance = null;
                        }
                    }
                    
                    \DB::table('notes')->insert([
                        'matricule' => $apprenant->matricule ?? $apprenant->id,
                        'nom' => $apprenant->nom ?? '',
                        'prenom' => $apprenant->prenom ?? '',
                        'annee_naissance' => $dateNaissance,
                        'classe' => $matiere->nom_matiere, // Nom de la matière (Cours)
                        'niveau_etude' => $apprenant->niveau_etude ?? 'Licence 1', // Niveau d'étude de l'étudiant (Classe)
                        'semestre' => null, // Semestre non défini pour les quiz seuls
                        'coefficient' => $matiere->coefficient ?? '1',
                        'devoir' => 0,
                        'examen' => 0,
                        'quiz' => $quiz,
                        'moyenne' => $moyenne,
                        'redoubler' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $notesEnregistrees++;
                    $notesEnvoyees[] = $matiere->nom_matiere;
                }
            } else {
                // Pour chaque résultat (chaque semestre)
                foreach ($resultatsMatiere as $resultat) {
            $quiz = null;
            
            // Si on a des résultats automatiques, utiliser la dernière tentative
            if (isset($quizParMatiere[$matiere->id])) {
                $quiz = $quizParMatiere[$matiere->id];
                    } elseif ($resultat->quiz !== null) {
                // Sinon, utiliser la note manuelle si elle existe
                        $quiz = round($resultat->quiz, 2);
                    }
                    
                    // Calculer la moyenne : (Devoir + Examen) / 2
                    $devoir = $resultat->devoir ?? 0;
                    $examen = $resultat->examen ?? 0;
                    $quizValue = $quiz ?? 0;
                    
                    // La moyenne est toujours calculée comme (Devoir + Examen) / 2
                    $moyenne = round(($devoir + $examen) / 2, 2);
                    
                    // Déterminer le semestre (convertir 1,2,3... en "Semestre 1", "Semestre 2", etc.)
                    $semestreString = null;
                    if ($resultat->semestre) {
                        $semestreString = 'Semestre ' . $resultat->semestre;
                    }
                    
                    // Formater la date de naissance correctement
                    $dateNaissance = null;
                    if ($apprenant->date_naissance) {
                        try {
                            $dateNaissance = Carbon::parse($apprenant->date_naissance)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $dateNaissance = null;
                        }
                    }
                    
                    // Enregistrer dans la table notes
                    \DB::table('notes')->insert([
                        'matricule' => $apprenant->matricule ?? $apprenant->id,
                        'nom' => $apprenant->nom ?? '',
                        'prenom' => $apprenant->prenom ?? '',
                        'annee_naissance' => $dateNaissance,
                        'classe' => $matiere->nom_matiere, // Nom de la matière (Cours)
                        'niveau_etude' => $apprenant->niveau_etude ?? 'Licence 1', // Niveau d'étude de l'étudiant (Classe)
                        'semestre' => $semestreString,
                        'coefficient' => $matiere->coefficient ?? '1',
                        'devoir' => round($devoir, 2),
                        'examen' => round($examen, 2),
                        'quiz' => round($quizValue, 2),
                        'moyenne' => $moyenne,
                        'redoubler' => false,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $notesEnregistrees++;
                    $notesEnvoyees[] = $matiere->nom_matiere . ($semestreString ? ' (' . $semestreString . ')' : '');
                }
            }
        }
        
        // Créer une notification professionnelle pour l'administrateur
        $admin = User::where('role', 'admin')->first();
        
        if ($admin && $notesEnregistrees > 0) {
            // Formater le nom du formateur (M. ou Mme selon le cas)
            $formateurTitre = 'M.';
            $formateurNom = trim(($user->nom ?? '') . ' ' . ($user->prenom ?? ''));
            if (empty($formateurNom)) {
                $formateurNom = $user->name ?? 'Formateur';
            }
            
            // Message professionnel formaté comme demandé
            $message = 'Le professeur ' . $formateurTitre . ' ' . $formateurNom . ' vient de vous envoyer une note concernant un apprenant.';
            
            \App\Models\OutboxNotification::create([
                'title' => 'Nouvelle note reçue',
                'body' => $message,
                'audience' => 'utilisateur',
                'user_id' => $admin->id,
                'status' => 'enregistré',
                'read_at' => null, // Non lue par défaut
            ]);
        }
        
        if ($notesEnregistrees > 0) {
            return back()->with('success', $notesEnregistrees . ' note(s) envoyée(s) à l\'administrateur avec succès.');
        } else {
            return back()->with('error', 'Aucune note à envoyer pour cet apprenant.');
        }
    }
}

