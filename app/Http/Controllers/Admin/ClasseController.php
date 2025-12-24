<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\ClasseSemestre;
use App\Models\User;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClasseController extends Controller
{
    public function index()
    {
        Log::info('[CLASSES] ===== DÉBUT CHARGEMENT CLASSES =====');
        
        // ÉTAPE 1: Récupérer UNIQUEMENT les combinaisons filière + niveau_etude qui existent RÉELLEMENT dans la table matieres
        // Filtrer à partir de Licence 1 jusqu'à la fin (Licence 1, 2, 3, Master 1, 2, 3)
        $niveauxAutorises = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2', 'Master 3'];
        
        $combinaisonsReelles = DB::table('matieres')
            ->whereNotNull('filiere')
            ->whereNotNull('niveau_etude')
            ->where('filiere', '!=', '')
            ->where('niveau_etude', '!=', '')
            ->whereIn('niveau_etude', $niveauxAutorises)  // Filtrer à partir de Licence 1
            ->select('filiere', 'niveau_etude', DB::raw("CASE niveau_etude WHEN 'Licence 1' THEN 1 WHEN 'Licence 2' THEN 2 WHEN 'Licence 3' THEN 3 WHEN 'Master 1' THEN 4 WHEN 'Master 2' THEN 5 WHEN 'Master 3' THEN 6 ELSE 7 END as sort_order"))
            ->distinct()
            ->orderBy('filiere')
            ->orderBy('sort_order')
            ->get();
        
        Log::info('[CLASSES] Combinaisons réelles trouvées dans matieres', [
            'total' => $combinaisonsReelles->count(),
            'combinaisons' => $combinaisonsReelles->map(function($c) {
                return $c->filiere . ' - ' . $c->niveau_etude;
            })->toArray(),
        ]);
        
        // ÉTAPE 2: Pour chaque combinaison réelle, récupérer ou créer la classe correspondante
        $classesUniques = collect();
        
        foreach ($combinaisonsReelles as $combinaison) {
            Log::info('[CLASSES] Traitement combinaison', [
                'filiere' => $combinaison->filiere,
                'niveau_etude' => $combinaison->niveau_etude,
            ]);
            
            // Chercher la classe correspondante dans la table classes
            $classe = Classe::where('filiere', $combinaison->filiere)
                ->where('niveau_etude', $combinaison->niveau_etude)
                ->with(['classeSemestres' => function($query) {
                    $query->where('actif', true)->orderBy('semestre');
                }])
                ->first();
            
            if (!$classe) {
                Log::warning('[CLASSES] Classe non trouvée dans table classes', [
                    'filiere' => $combinaison->filiere,
                    'niveau_etude' => $combinaison->niveau_etude,
                ]);
                // Si la classe n'existe pas dans la table classes, on la crée
                $code = strtoupper(substr($combinaison->filiere, 0, 3)) . '-' . str_replace(' ', '', $combinaison->niveau_etude);
                $classe = Classe::create([
                    'code' => $code,
                    'filiere' => $combinaison->filiere,
                    'niveau_etude' => $combinaison->niveau_etude,
                    'description' => 'Classe créée depuis les données réelles des apprenants',
                    'actif' => true,
                ]);
                // Charger la relation classeSemestres pour la nouvelle classe
                $classe->load(['classeSemestres' => function($query) {
                    $query->where('actif', true)->orderBy('semestre');
                }]);
                Log::info('[CLASSES] Classe créée', [
                    'classe_id' => $classe->id,
                    'filiere' => $classe->filiere,
                    'niveau_etude' => $classe->niveau_etude,
                ]);
            } else {
                Log::info('[CLASSES] Classe trouvée', [
                    'classe_id' => $classe->id,
                    'filiere' => $classe->filiere,
                    'niveau_etude' => $classe->niveau_etude,
                ]);
            }
            
            // ÉTAPE 2.5: Créer automatiquement les semestres selon le niveau d'étude
            $semestresParNiveau = [
                'Licence 1' => [1, 2],
                'Licence 2' => [3, 4],
                'Licence 3' => [5, 6],
                'Master 1' => [7, 8],
                'Master 2' => [9, 10],
            ];
            
            $semestresAttendus = $semestresParNiveau[$classe->niveau_etude] ?? [];
            
            if (!empty($semestresAttendus)) {
                // Vérifier quels semestres existent déjà
                $semestresExistants = $classe->classeSemestres->pluck('semestre')->toArray();
                
                // Créer les semestres manquants
                foreach ($semestresAttendus as $semestre) {
                    if (!in_array($semestre, $semestresExistants)) {
                        ClasseSemestre::create([
                            'classe_id' => $classe->id,
                            'semestre' => $semestre,
                            'actif' => true,
                        ]);
                        Log::info('[CLASSES] Semestre créé automatiquement', [
                            'classe_id' => $classe->id,
                            'niveau_etude' => $classe->niveau_etude,
                            'semestre' => $semestre,
                        ]);
                    }
                }
                
                // Recharger les semestres pour la classe
                $classe->load(['classeSemestres' => function($query) {
                    $query->where('actif', true)->orderBy('semestre');
                }]);
            }
            
            // ÉTAPE 3: Compter les apprenants pour cette combinaison exacte
            // Utiliser la table users pour comprendre la classe de chaque apprenant et leur filière
            // Inclure les apprenants avec paiement effectué ET en attente (futurs étudiants)
            $niveauNormalise = strtolower(str_replace(' ', '_', $combinaison->niveau_etude));
            
            // Récupérer tous les IDs d'apprenants uniques via méthodes explicites
            $apprenantIds = collect();
            
            // Méthode 1: Via classe_user (table pivot) - Relation explicite
            $idsViaPivot = DB::table('classe_user')
                ->where('classe_user.classe_id', $classe->id)
                ->join('users', 'classe_user.user_id', '=', 'users.id')
                ->where(function($q) {
                    $q->where('users.role', 'student')->orWhereNull('users.role');
                })
                // Inclure paiement effectué ET en attente (futurs étudiants)
                ->whereIn('users.paiement_statut', ['effectué', 'en attente'])
                ->pluck('users.id');
            $apprenantIds = $apprenantIds->merge($idsViaPivot);
            
            // Méthode 2: Via classe_id dans users - SÉCURISÉ : vérifier classe_id ET filiere ET niveau_etude
            // Cette méthode vérifie la table users pour comprendre la classe de chaque apprenant
            $idsViaClasseId = DB::table('users')
                ->where(function($q) use ($classe, $niveauNormalise) {
                    // Chercher par code de classe si existe (correspondance exacte)
                    if ($classe->code) {
                        $q->where('classe_id', $classe->code);
                    }
                    // Chercher par ID de classe (string) - correspondance exacte
                    $q->orWhere('classe_id', (string)$classe->id);
                    // Chercher par niveau normalisé MAIS avec vérification filiere + niveau_etude pour sécurité
                    if ($niveauNormalise) {
                        $q->orWhere('classe_id', $niveauNormalise);
                    }
                })
                // SÉCURITÉ CRITIQUE : Vérifier aussi filiere ET niveau_etude pour éviter les correspondances incorrectes
                ->where('filiere', $combinaison->filiere)
                ->where('niveau_etude', $combinaison->niveau_etude)
                ->where(function($q) {
                    $q->where('role', 'student')->orWhereNull('role');
                })
                // Inclure paiement effectué ET en attente (futurs étudiants)
                ->whereIn('paiement_statut', ['effectué', 'en attente'])
                ->pluck('id');
            $apprenantIds = $apprenantIds->merge($idsViaClasseId);
            
            // Compter les apprenants uniques (seulement ceux explicitement liés)
            // Inclut les apprenants avec paiement effectué ET en attente
            $apprenantsValides = $apprenantIds->unique()->count();
            
            $classe->apprenants_count = $apprenantsValides;
            
            // S'assurer que la relation classeSemestres est bien chargée
            if (!$classe->relationLoaded('classeSemestres')) {
                $classe->load(['classeSemestres' => function($query) {
                    $query->where('actif', true)->orderBy('semestre');
                }]);
            }
            
            $classesUniques->push($classe);
            
            Log::info('[CLASSES] Comptage apprenants pour classe', [
                'classe_id' => $classe->id,
                'filiere' => $classe->filiere,
                'niveau_etude' => $classe->niveau_etude,
                'apprenants_count' => $apprenantsValides,
                'semestres_count' => $classe->classeSemestres->count(),
                'semestres' => $classe->classeSemestres->pluck('semestre')->toArray(),
            ]);
        }
        
        Log::info('[CLASSES] ===== FIN CHARGEMENT CLASSES =====', [
            'total_classes_affichees' => $classesUniques->count(),
        ]);
        
        Log::info('[CLASSES] Classes chargées depuis la base de données', [
            'total_classes_db' => Classe::count(),
            'total_classes_uniques' => $classesUniques->count(),
            'classes' => $classesUniques->map(function($c) {
                return [
                    'id' => $c->id,
                    'filiere' => $c->filiere,
                    'niveau_etude' => $c->niveau_etude,
                    'semestres_count' => $c->classeSemestres->count(),
                    'semestres' => $c->classeSemestres->pluck('semestre')->toArray(),
                    'apprenants_count' => $c->apprenants_count,
                ];
            })->toArray(),
        ]);
        
        
        // Récupérer toutes les filières disponibles depuis la base de données
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere')
            ->toArray();
        
        // Récupérer aussi les filières depuis les classes existantes
        $filieresFromClasses = Classe::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->pluck('filiere')
            ->toArray();
        
        // Fusionner et dédupliquer
        $filieres = array_unique(array_merge($filieres, $filieresFromClasses));
        sort($filieres);
        
        // Niveaux d'étude possibles (uniquement ceux qui existent dans la base)
        $niveauxEtude = $classesUniques->pluck('niveau_etude')->unique()->sort()->values()->toArray();
        // Si aucun niveau, utiliser les niveaux par défaut
        if (empty($niveauxEtude)) {
            $niveauxEtude = ['Licence 1', 'Licence 2', 'Licence 3', 'Master 1', 'Master 2'];
        }
        
        return view('admin.classes.index', compact('classesUniques', 'filieres', 'niveauxEtude'));
    }
    
    public function create()
    {
        // Récupérer uniquement les apprenants déjà inscrits (pas les formateurs) ET avec paiement effectué
        // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
        $apprenants = User::where(function($q) {
            $q->where('role', 'student')->orWhereNull('role');
        })
        ->where('paiement_statut', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
        ->orderBy('nom')->orderBy('prenom')->get();
        
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        
        return view('admin.classes.create', compact('apprenants', 'filieres'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'nullable|string|max:50|unique:classes,code',
            'filiere' => 'required|string|max:255',
            'niveau_etude' => 'required|string|max:255',
            'description' => 'nullable|string',
            'semestres' => 'required|array|min:1',
            'semestres.*' => 'integer|min:1|max:10',
            'actif' => 'nullable|boolean',
        ]);
        
        DB::beginTransaction();
        try {
            $data = $request->except(['semestres']);
        $data['actif'] = $request->has('actif') ? true : false;
            
            // Générer un code automatique si non fourni
            if (empty($data['code'])) {
                $data['code'] = strtoupper(substr($data['filiere'], 0, 3)) . '-' . str_replace(' ', '', $data['niveau_etude']) . '-' . time();
            }
        
        $classe = Classe::create($data);
        
            // Créer les semestres pour cette classe
            foreach ($request->semestres as $semestre) {
                ClasseSemestre::create([
                    'classe_id' => $classe->id,
                    'semestre' => (int)$semestre,
                    'actif' => true,
                ]);
            }
            
            // Synchroniser avec les utilisateurs qui ont cette classe dans leur classe_id
            // Mettre à jour leur filière et niveau d'étude
            User::where('classe_id', $classe->code ?? (string)$classe->id)
                ->orWhere('filiere', $classe->filiere)
                ->where('niveau_etude', $classe->niveau_etude)
                ->update([
                    'filiere' => $classe->filiere,
                    'niveau_etude' => $classe->niveau_etude,
                    'classe_id' => $classe->code ?? (string)$classe->id,
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Classe créée avec succès.',
                'classe' => $classe->load('classeSemestres')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[CLASSES] Erreur lors de la création de la classe', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la classe: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function show(Classe $classe)
    {
        $classe->load('apprenants');
        return view('admin.classes.show', compact('classe'));
    }
    
    public function edit(Classe $classe)
    {
        // Récupérer uniquement les apprenants déjà inscrits
        $apprenants = User::where(function($q) {
            $q->where('role', 'student')->orWhereNull('role');
        })->orderBy('nom')->orderBy('prenom')->get();
        
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        
        $classe->load('apprenants');
        return view('admin.classes.edit', compact('classe', 'apprenants', 'filieres'));
    }
    
    public function update(Request $request, Classe $classe)
    {
        $request->validate([
            'code' => 'nullable|string|max:50|unique:classes,code,' . $classe->id,
            'filiere' => 'required|string|max:255',
            'niveau_etude' => 'required|string|max:255',
            'description' => 'nullable|string',
            'semestres' => 'required|array|min:1',
            'semestres.*' => 'integer|min:1|max:10',
            'actif' => 'nullable|boolean',
        ]);
        
        DB::beginTransaction();
        try {
            $data = $request->except(['semestres']);
        $data['actif'] = $request->has('actif') ? true : false;
        
        $classe->update($data);
        
            // Synchroniser les semestres
            $semestresExistants = $classe->classeSemestres()->pluck('semestre')->toArray();
            $semestresNouveaux = array_map('intval', $request->semestres);
            
            // Supprimer les semestres qui ne sont plus dans la liste
            $semestresASupprimer = array_diff($semestresExistants, $semestresNouveaux);
            if (!empty($semestresASupprimer)) {
                $classe->classeSemestres()->whereIn('semestre', $semestresASupprimer)->delete();
            }
            
            // Ajouter les nouveaux semestres
            $semestresAAjouter = array_diff($semestresNouveaux, $semestresExistants);
            foreach ($semestresAAjouter as $semestre) {
                ClasseSemestre::create([
                    'classe_id' => $classe->id,
                    'semestre' => $semestre,
                    'actif' => true,
                ]);
            }
            
            // Synchroniser avec les utilisateurs qui ont cette classe dans leur classe_id
            // Mettre à jour leur filière et niveau d'étude
            User::where('classe_id', $classe->code ?? (string)$classe->id)
                ->orWhere(function($q) use ($classe) {
                    $q->where('filiere', $classe->getOriginal('filiere'))
                      ->where('niveau_etude', $classe->getOriginal('niveau_etude'));
                })
                ->update([
                    'filiere' => $classe->filiere,
                    'niveau_etude' => $classe->niveau_etude,
                    'classe_id' => $classe->code ?? (string)$classe->id,
                ]);
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Classe modifiée avec succès.',
                'classe' => $classe->fresh()->load('classeSemestres')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[CLASSES] Erreur lors de la modification de la classe', [
                'classe_id' => $classe->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la modification de la classe: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function destroy(Classe $classe)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return response()->json([
                'success' => false,
                'message' => 'Mot de passe incorrect. La suppression a été annulée.'
            ], 403);
        }
        
        DB::beginTransaction();
        try {
        // Détacher tous les apprenants avant de supprimer la classe
        $classe->apprenants()->detach();
            
            // Supprimer tous les semestres associés
            $classe->classeSemestres()->delete();
            
            // Mettre à jour les utilisateurs qui ont cette classe
            User::where('classe_id', $classe->code ?? $classe->id)
                ->update([
                    'classe_id' => null,
                    'filiere' => null,
                    'niveau_etude' => null,
                ]);
            
        $classe->delete();
        
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Classe supprimée avec succès.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('[CLASSES] Erreur lors de la suppression de la classe', [
                'classe_id' => $classe->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression de la classe: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function toggleBlock(Classe $classe)
    {
        $classe->actif = !$classe->actif;
        $classe->save();
        
        return response()->json([
            'success' => true,
            'message' => $classe->actif ? 'Classe activée avec succès.' : 'Classe désactivée avec succès.',
            'actif' => $classe->actif
        ]);
    }
    
    // Récupérer une classe pour l'édition (AJAX)
    public function get(Classe $classe)
    {
        $classe->load('classeSemestres');
        return response()->json([
            'success' => true,
            'classe' => [
                'id' => $classe->id,
                'code' => $classe->code,
                'filiere' => $classe->filiere,
                'niveau_etude' => $classe->niveau_etude,
                'description' => $classe->description,
                'actif' => $classe->actif,
                'semestres' => $classe->classeSemestres->where('actif', true)->pluck('semestre')->toArray(),
            ]
        ]);
    }
}