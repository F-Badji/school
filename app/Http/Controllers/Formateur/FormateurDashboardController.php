<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Matiere;
use App\Models\Cours;
use App\Models\Event;
use App\Models\StudentResult;
use App\Models\Classe;
use App\Models\Message;
use App\Models\ForumGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FormateurDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Vérification de sécurité
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérifier que l'utilisateur est un formateur
        if ($user->role !== 'teacher') {
            abort(403, 'Accès refusé. Cette section est réservée aux formateurs.');
        }
        
        // Récupérer les matières enseignées par ce formateur (pour affichage)
        $matieres = $user->matieres()->get();
        
        // Récupérer les cours du formateur (pour affichage)
        $cours = Cours::where('formateur_id', $user->id)->get();
        
        // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les apprenants avec la même classe_id ET la même filière
        $apprenants = collect();
        
        // Vérifier que le formateur a une classe ET une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            \Log::warning('⚠️ Formateur sans classe ou filière assignée - Aucun étudiant ne sera affiché', [
                'formateur_id' => $user->id,
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere
            ]);
        } else {
            // Récupérer UNIQUEMENT les étudiants avec la même classe_id ET la même filière ET paiement effectué
            // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
            $apprenants = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                ->where('classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                ->where('filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                ->where('paiement_statut', '=', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->get();
            
            // Vérification supplémentaire de sécurité : double vérification manuelle
            $apprenants = $apprenants->filter(function($apprenant) use ($user) {
                $apprenantClasseId = $apprenant->classe_id ?? null;
                $apprenantFiliere = $apprenant->filiere ?? null;
                $formateurClasseId = $user->classe_id;
                $formateurFiliere = $user->filiere;
                
                // Vérifier classe ET filière
                if ($apprenantClasseId !== $formateurClasseId || $apprenantFiliere !== $formateurFiliere) {
                    \Log::warning('🚫 Étudiant rejeté - Classe ou filière ne correspond pas', [
                        'etudiant_id' => $apprenant->id,
                        'etudiant_email' => $apprenant->email ?? 'N/A',
                        'etudiant_classe_id' => $apprenantClasseId,
                        'etudiant_filiere' => $apprenantFiliere,
                        'formateur_classe_id' => $formateurClasseId,
                        'formateur_filiere' => $formateurFiliere,
                        'formateur_email' => $user->email
                    ]);
                    return false;
                }
                
                return true;
            })->values();
            
            \Log::info('✅ Étudiants validés (classe + filière) pour le formateur', [
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere,
                'etudiants_count' => $apprenants->count(),
                'etudiants' => $apprenants->map(fn($e) => ['id' => $e->id, 'nom' => ($e->nom ?? '') . ' ' . ($e->prenom ?? ''), 'email' => $e->email ?? '', 'classe_id' => $e->classe_id ?? 'N/A', 'filiere' => $e->filiere ?? 'N/A'])->toArray()
            ]);
        }
        
        // Statistiques
        $totalApprenants = $apprenants->count();
        $totalCours = $cours->count();
        $totalMatieres = $matieres->count();
        
        // Nombre total de devoirs créés par le formateur
        $totalDevoirs = \App\Models\Devoir::where('formateur_id', $user->id)->count();
        
        // Nombre total d'examens créés par le formateur
        $totalExamens = \App\Models\Examen::where('formateur_id', $user->id)->count();
        
        // Devoirs à corriger (StudentResult sans note de devoir)
        $devoirsACorriger = 0;
        $examensANoter = 0;
        
        if ($apprenants->count() > 0) {
            $apprenantIds = $apprenants->pluck('id')->toArray();
            
            $devoirsACorriger = StudentResult::whereIn('user_id', $apprenantIds)
                ->where(function($q) {
                    $q->whereNull('devoir')->orWhere('devoir', 0);
                })
                ->count();
            
            // Examens à noter
            $examensANoter = StudentResult::whereIn('user_id', $apprenantIds)
                ->where(function($q) {
                    $q->whereNull('examen')->orWhere('examen', 0);
                })
                ->count();
        }
        
        // Événements à venir (depuis la table events créée dans le calendrier)
        // Filtrer par la classe assignée au formateur
        $evenementsAvenir = Event::with('matiere')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', Carbon::now());
        
        // Filtrer par classe si le formateur a une classe assignée
        if ($user->classe_id) {
            // Mapper classe_id du formateur (licence_1, licence_2, licence_3) vers le format de events (Licence 1, Licence 2, Licence 3)
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
        
        $evenementsAvenir = $evenementsAvenir->orderBy('scheduled_at', 'asc')
            ->limit(5)
            ->get();
        
        // Performance des apprenants (moyennes) - pour affichage futur si nécessaire
        // SÉCURITÉ : Utiliser uniquement les apprenants déjà filtrés par classe assignée
        $performanceData = [];
        if ($matieres->count() > 0 && $apprenants->count() > 0) {
            // Utiliser directement la collection $apprenants déjà filtrée par classe assignée
            $apprenantIds = $apprenants->pluck('id')->toArray();
            
            foreach ($matieres as $matiere) {
                // Filtrer les apprenants de cette matière parmi ceux déjà validés
                $apprenantsMatiere = $apprenants->filter(function($apprenant) use ($matiere) {
                    $apprenantFiliere = $apprenant->filiere ?? null;
                    $apprenantNiveau = $apprenant->niveau_etude ?? null;
                    
                    $matchFiliere = !$matiere->filiere || $apprenantFiliere === $matiere->filiere;
                    $matchNiveau = !$matiere->niveau_etude || $apprenantNiveau === $matiere->niveau_etude;
                    
                    return $matchFiliere && $matchNiveau;
                });
                
                if ($apprenantsMatiere->count() > 0) {
                    $moyennes = StudentResult::whereIn('user_id', $apprenantsMatiere->pluck('id'))
                        ->whereNotNull('moyenne')
                        ->avg('moyenne');
                    
                    $performanceData[] = [
                        'matiere' => $matiere->nom_matiere,
                        'moyenne' => round($moyennes ?? 0, 2),
                        'apprenants' => $apprenantsMatiere->count()
                    ];
                }
            }
        }
        
        // Statistiques pour graphiques (évolution sur les dernières semaines)
        $evolutionData = [];
        $apprenantIds = $apprenants->pluck('id')->toArray();
        
        if (count($apprenantIds) > 0) {
            for ($i = 9; $i >= 0; $i--) {
                $weekStart = Carbon::now()->subWeeks($i)->startOfWeek();
                $weekEnd = Carbon::now()->subWeeks($i)->endOfWeek();
                
                $devoirsCorriges = StudentResult::whereIn('user_id', $apprenantIds)
                    ->whereNotNull('devoir')
                    ->where('devoir', '>', 0)
                    ->whereBetween('updated_at', [$weekStart, $weekEnd])
                    ->count();
                
                $examensNotes = StudentResult::whereIn('user_id', $apprenantIds)
                    ->whereNotNull('examen')
                    ->where('examen', '>', 0)
                    ->whereBetween('updated_at', [$weekStart, $weekEnd])
                    ->count();
                
                $evolutionData[] = [
                    'week' => 'Semaine ' . (10 - $i),
                    'devoirs' => $devoirsCorriges,
                    'examens' => $examensNotes,
                ];
            }
        } else {
            // Si pas d'apprenants, créer des données vides
            for ($i = 9; $i >= 0; $i--) {
                $evolutionData[] = [
                    'week' => 'Semaine ' . (10 - $i),
                    'devoirs' => 0,
                    'examens' => 0,
                ];
            }
        }
        
        return view('formateur.dashboard', compact(
            'user',
            'matieres',
            'cours',
            'apprenants',
            'totalApprenants',
            'totalDevoirs',
            'totalExamens',
            'totalCours',
            'totalMatieres',
            'devoirsACorriger',
            'examensANoter',
            'evenementsAvenir',
            'performanceData',
            'evolutionData'
        ));
    }
    
    /**
     * Afficher la page Notes pour le formateur
     */
    public function notes()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        // Récupérer toutes les matières enseignées par ce formateur (pour affichage)
        $matieres = $user->matieres()->get();
        
        // Récupérer les cours du formateur (pour affichage)
        $cours = Cours::where('formateur_id', $user->id)->get();
        
        // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les apprenants avec la même classe_id ET la même filière
        $apprenants = collect();
        
        // Vérifier que le formateur a une classe ET une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            \Log::warning('⚠️ Formateur sans classe ou filière assignée dans notes() - Aucun étudiant ne sera affiché', [
                'formateur_id' => $user->id,
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere
            ]);
        } else {
            // Récupérer UNIQUEMENT les étudiants avec la même classe_id ET la même filière ET paiement effectué
            // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
            $apprenants = User::where('role', 'student')
                ->where('classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                ->where('filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                ->where('paiement_statut', '=', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                ->get();
            
            // Vérification supplémentaire de sécurité : double vérification manuelle
            $apprenants = $apprenants->filter(function($apprenant) use ($user) {
                $apprenantClasseId = $apprenant->classe_id ?? null;
                $apprenantFiliere = $apprenant->filiere ?? null;
                $formateurClasseId = $user->classe_id;
                $formateurFiliere = $user->filiere;
                
                // Vérifier classe ET filière
                if ($apprenantClasseId !== $formateurClasseId || $apprenantFiliere !== $formateurFiliere) {
                    \Log::warning('🚫 Étudiant rejeté dans notes() - Classe ou filière ne correspond pas', [
                        'etudiant_id' => $apprenant->id,
                        'etudiant_email' => $apprenant->email ?? 'N/A',
                        'etudiant_classe_id' => $apprenantClasseId,
                        'etudiant_filiere' => $apprenantFiliere,
                        'formateur_classe_id' => $formateurClasseId,
                        'formateur_filiere' => $formateurFiliere,
                        'formateur_email' => $user->email
                    ]);
                    return false;
                }
                
                return true;
            })->values();
            
            \Log::info('✅ Étudiants validés (classe + filière) dans notes() pour le formateur', [
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere,
                'etudiants_count' => $apprenants->count()
            ]);
        }
        
        // Organiser les notes par apprenant et par matière
        $notesParApprenant = [];
        
        foreach ($apprenants as $apprenant) {
            $notesParApprenant[$apprenant->id] = [
                'apprenant' => $apprenant,
                'matieres' => []
            ];
            
            // Pour chaque matière, récupérer les notes
            foreach ($matieres as $matiere) {
                $resultats = StudentResult::where('user_id', $apprenant->id)
                    ->where('classe', $matiere->nom_matiere)
                    ->get();
                
                $exercice = null;
                $devoir = null;
                $examen = null;
                
                foreach ($resultats as $resultat) {
                    if ($resultat->quiz !== null) {
                        $exercice = $resultat->quiz;
                    }
                    if ($resultat->devoir !== null) {
                        $devoir = $resultat->devoir;
                    }
                    if ($resultat->examen !== null) {
                        $examen = $resultat->examen;
                    }
                }
                
                // Si au moins une note existe pour cette matière, l'ajouter
                if ($exercice !== null || $devoir !== null || $examen !== null) {
                    $notesParApprenant[$apprenant->id]['matieres'][$matiere->id] = [
                        'matiere' => $matiere->nom_matiere,
                        'exercice' => $exercice,
                        'devoir' => $devoir,
                        'examen' => $examen,
                    ];
                }
            }
        }
        
        return view('formateur.notes', compact('user', 'notesParApprenant', 'cours', 'matieres'));
    }
    
    /**
     * Afficher la page Calendrier pour le formateur
     */
    public function calendrier()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        return view('formateur.calendrier', compact('user'));
    }
    
    public function getEmploiDuTemps()
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien un formateur
        if (!$user || $user->role !== 'teacher') {
            return response()->json(['error' => 'Accès refusé'], 403);
        }
        
        // Récupérer la classe du formateur (licence_1, licence_2, licence_3, master_1, master_2)
        $classe = $user->classe_id;
        
        if (!$classe) {
            return response()->json(['error' => 'Aucune classe assignée'], 404);
        }
        
        // SÉCURITÉ : Récupérer l'emploi du temps uniquement pour la classe du formateur
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
    
    /**
     * Afficher la page Messages pour le formateur
     */
    public function messages()
    {
        // LOG: Début de la méthode
        \Log::info('FormateurDashboardController::messages() - Début', [
            'user_id' => Auth::id(),
            'user_role' => Auth::user()?->role,
        ]);
        
        try {
            $user = Auth::user();
            
            if (!$user || $user->role !== 'teacher') {
                \Log::warning('FormateurDashboardController::messages() - Accès refusé', [
                    'user_id' => $user?->id,
                    'user_role' => $user?->role,
                ]);
                abort(403, 'Accès refusé.');
            }
            
            // SÉCURITÉ : Récupérer uniquement les apprenants avec la même classe_id et la même filière
            $apprenants = collect();
            if ($user->classe_id && $user->filiere) {
                $apprenants = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                    ->where('classe_id', $user->classe_id)
                    ->where('filiere', $user->filiere)
                    ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
                    ->orderBy('nom')
                    ->orderBy('prenom')
                    ->get();
            }
            
            \Log::info('FormateurDashboardController::messages() - Apprenants récupérés', [
                'count' => $apprenants->count(),
            ]);
            
            // Récupérer les groupes de forum du formateur
            $forumGroups = $user->forumGroups()->with('users:id,name,prenom,nom,email,photo')->get();
            
            // Récupérer les messages du formateur
            $messages = Message::with(['sender:id,name,prenom,nom,email,photo,role,last_seen', 'receiver:id,name,prenom,nom,email,photo,role,last_seen'])
                ->where(function($query) use ($user) {
                    $query->where('sender_id', $user->id)
                          ->orWhere('receiver_id', $user->id);
                })
                ->orderBy('created_at', 'desc')
                ->get();
            
            \Log::info('FormateurDashboardController::messages() - Messages récupérés', [
                'count' => $messages->count(),
            ]);
            
            // LOG: Vérification de l'existence de la vue
            $viewPath = resource_path('views/formateur/messages.blade.php');
            $viewExists = file_exists($viewPath);
            \Log::info('FormateurDashboardController::messages() - Vérification de la vue', [
                'view_path' => $viewPath,
                'view_exists' => $viewExists,
                'view_readable' => $viewExists ? is_readable($viewPath) : false,
            ]);
            
            // LOG: Vérification du contenu CSS dans la vue
            if ($viewExists) {
                $viewContent = file_get_contents($viewPath);
                $hasStyleTag = strpos($viewContent, '<style>') !== false;
                $hasSidebarBg = strpos($viewContent, '.sidebar-bg') !== false;
                \Log::info('FormateurDashboardController::messages() - Contenu de la vue', [
                    'has_style_tag' => $hasStyleTag,
                    'has_sidebar_bg' => $hasSidebarBg,
                    'content_length' => strlen($viewContent),
                ]);
            }
            
            \Log::info('FormateurDashboardController::messages() - Retour de la vue');
            return view('formateur.messages', compact('user', 'apprenants', 'messages', 'forumGroups'));
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
            
        } catch (\Exception $e) {
            \Log::error('FormateurDashboardController::messages() - Erreur', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }
    
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un formateur
        if (!$user || $user->role !== 'teacher') {
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
        
        // SÉCURITÉ CRITIQUE : Pour les messages système (appels), vérifier qu'ils sont bien envoyés entre l'utilisateur connecté et le receiver
        $isSystemMessage = $request->label === 'System' || 
                          strpos($request->content, '📞❌') !== false || 
                          strpos($request->content, '📞✅') !== false ||
                          strpos($request->content, 'Appel manqué') !== false ||
                          strpos($request->content, 'Appel terminé') !== false;
        
        // SÉCURITÉ : Vérifier que le destinataire est un apprenant de la même classe et filière
        $contactAutorise = false;
        
        // L'admin peut toujours recevoir des messages des formateurs
        if ($receiver->role === 'admin') {
            $contactAutorise = true;
        } elseif ($user->classe_id && $user->filiere) {
            if (($receiver->role === 'student' || !$receiver->role) && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Vous ne pouvez pas envoyer de message à cette personne. Accès limité aux apprenants de votre classe et à l\'administrateur.'
            ], 403);
        }
        
        // LOG : Vérifier les messages système
        if ($isSystemMessage) {
            \Log::info("🔍 [DEBUG formateur sendMessage] Message système reçu:", [
                'user_id' => $user->id,
                'receiver_id' => $request->receiver_id,
                'content' => $request->content,
                'label' => $request->label,
                'contact_autorise' => $contactAutorise
            ]);
        }
        
        // SÉCURITÉ CRITIQUE : Pour les messages système, double vérification
        // Le message système doit être envoyé uniquement entre l'utilisateur connecté et le receiver spécifié
        if ($isSystemMessage) {
            // Vérifier que le receiver_id correspond bien à une conversation valide
            // Utiliser == au lieu de !== pour gérer les différences de type (string vs int)
            // Cette vérification est déjà faite ci-dessus avec $contactAutorise, mais on la réitère pour être sûr
            if ((int)$receiver->id != (int)$request->receiver_id) {
                \Log::warning("⚠️ [SÉCURITÉ formateur] Tentative d'envoi de message système avec receiver_id invalide", [
                    'user_id' => $user->id,
                    'requested_receiver_id' => $request->receiver_id,
                    'requested_receiver_id_type' => gettype($request->receiver_id),
                    'actual_receiver_id' => $receiver->id,
                    'actual_receiver_id_type' => gettype($receiver->id),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de sécurité : receiver_id invalide pour le message système.'
                ], 403);
            }
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

        // LOG : Vérifier que le message système est bien créé
        if ($isSystemMessage) {
            \Log::info("✅ [DEBUG formateur sendMessage] Message système créé avec succès:", [
                'message_id' => $message->id,
                'sender_id' => $message->sender_id,
                'receiver_id' => $message->receiver_id,
                'content' => $message->content,
                'label' => $message->label,
                'created_at' => $message->created_at
            ]);
        }

        // Calculer le nombre total de messages non lus pour le destinataire
        $receiverUnreadCount = Message::where('receiver_id', $request->receiver_id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'message' => $message->load(['sender:id,name,prenom,nom,email,photo,role,last_seen', 'receiver:id,name,prenom,nom,email,photo,role,last_seen']),
            'receiver_unread_count' => $receiverUnreadCount,
        ]);
    }

    public function storeCall(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un formateur
        if (!$user || $user->role !== 'teacher') {
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
        
        // SÉCURITÉ : Vérifier que le destinataire est un apprenant de la même classe et filière
        $contactAutorise = false;
        
        if ($user->classe_id && $user->filiere) {
            if (($receiver->role === 'student' || !$receiver->role) && 
                $receiver->classe_id === $user->classe_id && 
                $receiver->filiere === $user->filiere) {
                $contactAutorise = true;
            }
        }
        
        // L'admin peut toujours être appelé
        if ($receiver->role === 'admin') {
            $contactAutorise = true;
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Vous ne pouvez pas appeler cette personne. Accès limité aux apprenants de votre classe et à l\'administrateur.'
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
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un formateur
        if (!$user || $user->role !== 'teacher') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $receiver = User::findOrFail($receiverId);
        
        // SÉCURITÉ : Empêcher l'accès à sa propre conversation
        if ($receiver->id === $user->id) {
            return response()->json(['success' => false, 'message' => 'Vous ne pouvez pas accéder à votre propre conversation.'], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Récupérer UNIQUEMENT les messages entre l'utilisateur connecté et le receiver
        // Vérification stricte pour éviter toute fuite de données
        $messages = Message::with(['sender:id,name,prenom,nom,email,photo,role', 'receiver:id,name,prenom,nom,email,photo,role'])
            ->where(function($query) use ($user, $receiver) {
                // Message envoyé par l'utilisateur connecté au receiver
                $query->where(function($q) use ($user, $receiver) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $receiver->id);
                })
                // OU message envoyé par le receiver à l'utilisateur connecté
                ->orWhere(function($q) use ($user, $receiver) {
                    $q->where('sender_id', $receiver->id)
                      ->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        // SÉCURITÉ : Vérification finale - s'assurer que tous les messages appartiennent bien à cette conversation
        $messages = $messages->filter(function($message) use ($user, $receiver) {
            $isFromUser = $message->sender_id == $user->id && $message->receiver_id == $receiver->id;
            $isToUser = $message->sender_id == $receiver->id && $message->receiver_id == $user->id;
            return $isFromUser || $isToUser;
        })->values();
        
        // LOG : Vérifier les messages système dans la réponse
        $systemMessages = $messages->filter(function($msg) {
            return $msg->label === 'System' || 
                   strpos($msg->content ?? '', '📞❌') !== false || 
                   strpos($msg->content ?? '', '📞✅') !== false ||
                   strpos($msg->content ?? '', 'Appel manqué') !== false ||
                   strpos($msg->content ?? '', 'Appel terminé') !== false;
        });
        
        \Log::info("🔍 [DEBUG formateur getThread] Messages pour conversation:", [
            'user_id' => $user->id,
            'receiver_id' => $receiver->id,
            'total_messages' => $messages->count(),
            'system_messages_count' => $systemMessages->count(),
            'all_messages_ids' => $messages->pluck('id')->toArray(),
            'system_messages_details' => $systemMessages->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'label' => $msg->label,
                    'content' => $msg->content,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'created_at' => $msg->created_at,
                ];
            })->toArray()
        ]);
        
        return response()->json([
            'success' => true,
            'messages' => $messages->map(function($msg) {
                // S'assurer que tous les champs nécessaires sont inclus, notamment le label
                return [
                    'id' => $msg->id,
                    'sender_id' => $msg->sender_id,
                    'receiver_id' => $msg->receiver_id,
                    'content' => $msg->content,
                    'label' => $msg->label ?? 'Normal', // S'assurer que le label est toujours présent
                    'created_at' => $msg->created_at,
                    'sender' => $msg->sender,
                    'receiver' => $msg->receiver,
                ];
            }),
            'receiver' => $receiver->only(['id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen']),
        ]);
    }
    
    public function getThreadOld($receiverId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un formateur
        if (!$user || $user->role !== 'teacher') {
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
        
        // SÉCURITÉ : Vérifier que le destinataire est un apprenant de la même classe et filière
        $contactAutorise = false;
        
        if ($user->classe_id && $user->filiere) {
            if (($receiver->role === 'student' || !$receiver->role) && 
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
        
        // SÉCURITÉ : Vérification finale - s'assurer que tous les messages appartiennent bien à cette conversation
        $messages = $messages->filter(function($message) use ($user, $receiverId) {
            $isFromUser = $message->sender_id == $user->id && $message->receiver_id == $receiverId;
            $isToUser = $message->sender_id == $receiverId && $message->receiver_id == $user->id;
            return $isFromUser || $isToUser;
        })->values();
        
        $receiver->refresh(); // Ensure latest last_seen
        
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
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un formateur
        if (!$user || $user->role !== 'teacher') {
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
    
    /**
     * Afficher la page Mes apprenants pour le formateur
     */
    public function apprenants()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        // SÉCURITÉ SIMPLE : Récupérer UNIQUEMENT les apprenants avec la même classe_id ET la même filière
        $apprenants = collect();
        
        // Vérifier que le formateur a une classe ET une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            \Log::warning('⚠️ Formateur sans classe ou filière assignée dans apprenants() - Aucun étudiant ne sera affiché', [
                'formateur_id' => $user->id,
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere
            ]);
        } else {
            // Récupérer UNIQUEMENT les étudiants avec la même classe_id ET la même filière ET paiement effectué
            // SÉCURITÉ CRITIQUE : Ne pas afficher les apprenants en attente de paiement
            $apprenants = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                ->where('classe_id', '=', $user->classe_id) // SÉCURITÉ : Même classe
                ->where('filiere', '=', $user->filiere) // SÉCURITÉ : Même filière
                ->where('paiement_statut', '=', 'effectué') // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
                    ->get();
            
            // Vérification supplémentaire de sécurité : double vérification manuelle
            $apprenants = $apprenants->filter(function($apprenant) use ($user) {
                $apprenantClasseId = $apprenant->classe_id ?? null;
                $apprenantFiliere = $apprenant->filiere ?? null;
                $formateurClasseId = $user->classe_id;
                $formateurFiliere = $user->filiere;
                
                // Vérifier classe ET filière
                if ($apprenantClasseId !== $formateurClasseId || $apprenantFiliere !== $formateurFiliere) {
                    \Log::warning('🚫 Étudiant rejeté dans apprenants() - Classe ou filière ne correspond pas', [
                        'etudiant_id' => $apprenant->id,
                        'etudiant_email' => $apprenant->email ?? 'N/A',
                        'etudiant_classe_id' => $apprenantClasseId,
                        'etudiant_filiere' => $apprenantFiliere,
                        'formateur_classe_id' => $formateurClasseId,
                        'formateur_filiere' => $formateurFiliere,
                        'formateur_email' => $user->email
                    ]);
                    return false;
                }
                
                return true;
            })->values();
            
            \Log::info('✅ Étudiants validés (classe + filière) dans apprenants() pour le formateur', [
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere,
                'etudiants_count' => $apprenants->count(),
                'etudiants' => $apprenants->map(fn($e) => ['id' => $e->id, 'nom' => ($e->nom ?? '') . ' ' . ($e->prenom ?? ''), 'email' => $e->email ?? '', 'classe_id' => $e->classe_id ?? 'N/A', 'filiere' => $e->filiere ?? 'N/A'])->toArray()
            ]);
        }
        
        // Récupérer les statistiques pour chaque apprenant
        $apprenantsAvecStats = $apprenants->map(function($apprenant) {
            $resultats = StudentResult::where('user_id', $apprenant->id)->get();
            
            // Nombre de tâches (devoirs + examens + quiz)
            $nombreTaches = $resultats->count();
            
            // Note moyenne (moyenne générale)
            $noteMoyenne = $resultats->avg('moyenne') ?? 0;
            $nombreAvis = $resultats->whereNotNull('moyenne')->count();
            
            $apprenant->nombre_taches = $nombreTaches;
            $apprenant->note_moyenne = round($noteMoyenne, 1);
            $apprenant->nombre_avis = $nombreAvis;
            
            return $apprenant;
        });
        
        return view('formateur.apprenants', compact('user', 'apprenants', 'apprenantsAvecStats'));
    }
    
    public function profil()
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }

        return view('formateur.profil', compact('user'));
    }
    
    public function parametres()
    {
        $user = Auth::user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérification basée sur le rôle uniquement
        if ($user->role === 'admin') {
            return redirect()->route('dashboard')->with('error', 'Accès refusé. Cette section est réservée aux formateurs.');
        }
        
        if ($user->role && $user->role !== 'teacher') {
            abort(403, 'Accès refusé. Cette section est réservée aux formateurs.');
        }
        
        // Recharger l'utilisateur avec tous les champs nécessaires
        $userId = $user->id;
        $user = User::select('id', 'name', 'email', 'photo', 'prenom', 'nom', 'date_naissance', 'phone', 'location', 'filiere', 'classe_id', 'niveau_etude', 'last_seen', 'created_at', 'role', 'statut', 'nationalite')
            ->where('id', $userId)
            ->first();
        
        return view('formateur.parametres', compact('user'));
    }
    
    public function voirProfilApprenant($id)
    {
        $user = Auth::user();
        
        // Vérification de sécurité
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        // Récupérer l'apprenant
        $apprenant = User::where('id', $id)
            ->where(function($q) {
                $q->where('role', 'student')->orWhereNull('role');
            })
            ->first();
        
        if (!$apprenant) {
            abort(404, 'Apprenant non trouvé');
        }
        
        // SÉCURITÉ SIMPLE : Vérifier que l'apprenant a la même classe_id ET la même filière que le formateur
        $hasAccess = false;
        
        // Vérifier que le formateur a une classe ET une filière assignées
        if (!$user->classe_id || !$user->filiere) {
            \Log::warning('⚠️ Formateur sans classe ou filière assignée dans voirProfilApprenant() - Accès refusé', [
                'formateur_id' => $user->id,
                'formateur_email' => $user->email,
                'formateur_classe_id' => $user->classe_id,
                'formateur_filiere' => $user->filiere,
                'apprenant_id' => $apprenant->id,
                'apprenant_email' => $apprenant->email ?? 'N/A'
            ]);
            abort(403, 'Accès refusé. Vous n\'avez pas de classe ou filière assignée.');
        }
        
        // Vérifier que l'apprenant a la même classe_id ET la même filière
        $apprenantClasseId = $apprenant->classe_id ?? null;
        $apprenantFiliere = $apprenant->filiere ?? null;
        $formateurClasseId = $user->classe_id;
        $formateurFiliere = $user->filiere;
        
        // Vérifier classe ET filière (les deux doivent correspondre)
        if ($apprenantClasseId === $formateurClasseId && $apprenantFiliere === $formateurFiliere) {
            $hasAccess = true;
        } else {
            \Log::warning('🚫 Accès refusé dans voirProfilApprenant() - Classe ou filière ne correspond pas', [
                'formateur_id' => $user->id,
                'formateur_email' => $user->email,
                'formateur_classe_id' => $formateurClasseId,
                'formateur_filiere' => $formateurFiliere,
                'apprenant_id' => $apprenant->id,
                'apprenant_email' => $apprenant->email ?? 'N/A',
                'apprenant_classe_id' => $apprenantClasseId,
                'apprenant_filiere' => $apprenantFiliere
            ]);
        }
        
        if (!$hasAccess) {
            abort(403, 'Accès refusé. Cet apprenant ne fait pas partie de votre classe et filière assignées.');
        }
        
        \Log::info('✅ Accès autorisé dans voirProfilApprenant() (classe + filière)', [
            'formateur_email' => $user->email,
            'formateur_classe_id' => $user->classe_id,
            'formateur_filiere' => $user->filiere,
            'apprenant_email' => $apprenant->email ?? 'N/A',
            'apprenant_classe_id' => $apprenantClasseId,
            'apprenant_filiere' => $apprenantFiliere
        ]);
        
        return view('formateur.apprenant-profil', ['apprenant' => $apprenant, 'user' => $user]);
    }
    
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }

        // Vérifier d'abord que le mot de passe actuel est fourni
        if (!$request->filled('current_password')) {
            return redirect(route('formateur.parametres') . '#password')
                ->withErrors(['current_password' => 'L\'ancien mot de passe est requis.'])
                ->withInput();
        }

        // Vérifier le mot de passe actuel AVANT de valider le nouveau
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect(route('formateur.parametres') . '#password')
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
            return redirect(route('formateur.parametres') . '#password')
                ->withErrors($e->errors())
                ->withInput();
        }

        // Vérifier que le nouveau mot de passe est différent de l'ancien
        if (Hash::check($request->new_password, $user->password)) {
            return redirect(route('formateur.parametres') . '#password')
                ->withErrors(['new_password' => 'Le nouveau mot de passe doit être différent de l\'ancien mot de passe.'])
                ->withInput();
        }

        // Mettre à jour le mot de passe
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect(route('formateur.parametres') . '#password')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }
}

