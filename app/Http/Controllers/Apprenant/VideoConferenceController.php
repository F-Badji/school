<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\VideoSession;
use App\Models\VideoSessionParticipant;
use App\Models\VideoSessionChatMessage;
use App\Models\Cours;
use App\Events\VideoSessionParticipantJoined;
use App\Events\VideoSessionParticipantLeft;
use App\Events\VideoSessionParticipantStatusChanged;
use App\Events\VideoSessionChatMessage as ChatMessageEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class VideoConferenceController extends Controller
{
    /**
     * Afficher la page de visioconférence pour un cours
     */
    public function join($coursId)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est un apprenant
        if (!$user || $user->role !== 'student') {
            return redirect()->route('apprenant.professeurs')
                ->with('error', 'Accès refusé. Cette fonctionnalité est réservée aux apprenants.');
        }

        // Récupérer le cours
        $cours = Cours::findOrFail($coursId);
        
        // Vérifier que le formateur du cours correspond à la classe et filière de l'apprenant
        $formateur = $cours->formateur;
        if (!$formateur || 
            $formateur->classe_id !== $user->classe_id || 
            $formateur->filiere !== $user->filiere) {
            return redirect()->route('apprenant.professeurs')
                ->with('error', 'Vous n\'avez pas accès à ce cours.');
        }

        // Chercher ou créer une session vidéo active pour ce cours
        $session = VideoSession::where('cours_id', $coursId)
            ->where('statut', 'active')
            ->first();

        if (!$session) {
            // Créer une nouvelle session
            $session = VideoSession::create([
                'session_id' => VideoSession::generateSessionId(),
                'cours_id' => $coursId,
                'formateur_id' => $formateur->id,
                'titre' => $cours->titre,
                'description' => $cours->description,
                'statut' => 'active',
                'date_debut' => now(),
            ]);
        }

        // Vérifier si l'apprenant est déjà participant
        $participant = VideoSessionParticipant::where('video_session_id', $session->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$participant) {
            // Créer une demande d'accès (en attente)
            $participant = VideoSessionParticipant::create([
                'video_session_id' => $session->id,
                'user_id' => $user->id,
                'statut' => 'en_attente',
                'micro_actif' => false,
                'camera_active' => false,
            ]);
            
            // Charger la relation user pour l'événement
            $participant->load('user');
            
            // Émettre l'événement pour notifier le formateur
            broadcast(new VideoSessionParticipantJoined($participant))->toOthers();
        } else {
            // Si l'apprenant était absent, le remettre comme présent automatiquement
            if ($participant->statut === 'absent') {
                $participant->statut = 'present';
                $participant->date_entree = now();
                $participant->date_sortie = null;
                $participant->load('user');
                $participant->save();
                
                // Émettre l'événement pour notifier le formateur
                broadcast(new VideoSessionParticipantStatusChanged($participant, ['statut' => 'absent']))->toOthers();
            }
            
            // Charger la relation user
            $participant->load('user');
        }

        // Charger les relations
        $session->load(['formateur', 'participants.user', 'cours']);

        return view('apprenant.video-conference', compact('session', 'participant', 'cours'));
    }

    /**
     * Vérifier le statut de la demande d'accès
     */
    public function checkStatus($sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->with('videoSession')
            ->firstOrFail();

        return response()->json([
            'statut' => $participant->statut,
            'micro_actif' => $participant->micro_actif,
            'camera_active' => $participant->camera_active,
            'micro_controle_par_formateur' => $participant->micro_controle_par_formateur,
            'camera_controlee_par_formateur' => $participant->camera_controlee_par_formateur,
        ]);
    }

    /**
     * Mettre à jour le statut du micro
     */
    public function toggleMicro(Request $request, $sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Vérifier si le micro est contrôlé par le formateur
        if ($participant->micro_controle_par_formateur) {
            return response()->json([
                'success' => false,
                'message' => 'Votre microphone est contrôlé par le formateur.'
            ], 403);
        }

        // Vérifier que l'apprenant est accepté
        if (!in_array($participant->statut, ['accepte', 'present'])) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à rejoindre la session.'
            ], 403);
        }

        $oldValue = $participant->micro_actif;
        $participant->micro_actif = !$participant->micro_actif;
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['micro_actif' => $oldValue]))->toOthers();

        return response()->json([
            'success' => true,
            'micro_actif' => $participant->micro_actif
        ]);
    }

    /**
     * Mettre à jour le statut de la caméra
     */
    public function toggleCamera(Request $request, $sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Vérifier si la caméra est contrôlée par le formateur
        if ($participant->camera_controlee_par_formateur) {
            return response()->json([
                'success' => false,
                'message' => 'Votre caméra est contrôlée par le formateur.'
            ], 403);
        }

        // Vérifier que l'apprenant est accepté
        if (!in_array($participant->statut, ['accepte', 'present'])) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à rejoindre la session.'
            ], 403);
        }

        $oldValue = $participant->camera_active;
        $participant->camera_active = !$participant->camera_active;
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['camera_active' => $oldValue]))->toOthers();

        return response()->json([
            'success' => true,
            'camera_active' => $participant->camera_active
        ]);
    }

    /**
     * Quitter la session
     */
    public function leave($sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Si l'apprenant est en attente, supprimer complètement sa demande
        if ($participant->statut === 'en_attente') {
            // Charger la relation user avant de supprimer pour l'événement
            $participant->load('user');
            
            // Émettre l'événement avant de supprimer
            broadcast(new VideoSessionParticipantLeft($participant))->toOthers();
            
            // Supprimer le participant
            $participant->delete();

            return redirect()->route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique'])
                ->with('success', 'Votre demande a été annulée.');
        }

        // Si l'apprenant est accepté/présent, mettre à jour son statut
        $participant->date_sortie = now();
        $participant->micro_actif = false;
        $participant->camera_active = false;
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantLeft($participant))->toOthers();

        return redirect()->route('apprenant.professeur.matiere', ['matiereSlug' => 'algorithmique'])
            ->with('success', 'Vous avez quitté la session vidéo.');
    }

    /**
     * Envoyer un message de chat
     */
    public function sendChatMessage(Request $request, $sessionId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est un apprenant
        if (!$user || $user->role !== 'student') {
            Log::warning('Tentative d\'envoi de message par un non-apprenant', [
                'user_id' => $user->id ?? null,
                'role' => $user->role ?? null,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        $request->validate([
            'message' => 'required|string|max:1000|min:1',
        ]);

        // SÉCURITÉ : Vérifier que la session existe et est active
        $session = VideoSession::find($sessionId);
        if (!$session) {
            Log::warning('Tentative d\'envoi de message dans une session inexistante', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Session introuvable.'
            ], 404);
        }
        
        if ($session->statut !== 'active') {
            Log::warning('Tentative d\'envoi de message dans une session inactive', [
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'statut' => $session->statut
            ]);
            return response()->json([
                'success' => false,
                'message' => 'La session n\'est plus active.'
            ], 403);
        }

        // SÉCURITÉ : Vérifier que l'apprenant est bien un participant accepté/présent de cette session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->first();
            
        if (!$participant) {
            Log::warning('Tentative d\'envoi de message par un non-participant', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un participant de cette session.'
            ], 403);
        }
        
        // SÉCURITÉ : Nettoyer le message pour éviter les injections XSS
        $cleanMessage = strip_tags($request->message);
        $cleanMessage = htmlspecialchars($cleanMessage, ENT_QUOTES, 'UTF-8');

        $chatMessage = VideoSessionChatMessage::create([
            'video_session_id' => $sessionId,
            'user_id' => $user->id,
            'message' => $cleanMessage,
        ]);

        // Charger la relation user
        $chatMessage->load('user');

        // Émettre l'événement uniquement aux autres participants de cette session
        broadcast(new ChatMessageEvent($chatMessage))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $chatMessage
        ]);
    }

    /**
     * Récupérer les messages de chat
     */
    public function getChatMessages($sessionId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est un apprenant
        if (!$user || $user->role !== 'student') {
            Log::warning('Tentative d\'accès aux messages par un non-apprenant', [
                'user_id' => $user->id ?? null,
                'role' => $user->role ?? null,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        // SÉCURITÉ : Vérifier que la session existe et est active
        $session = VideoSession::find($sessionId);
        if (!$session) {
            Log::warning('Tentative d\'accès aux messages d\'une session inexistante', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Session introuvable.'
            ], 404);
        }
        
        if ($session->statut !== 'active') {
            Log::warning('Tentative d\'accès aux messages d\'une session inactive', [
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'statut' => $session->statut
            ]);
            return response()->json([
                'success' => false,
                'message' => 'La session n\'est plus active.'
            ], 403);
        }
        
        // SÉCURITÉ : Vérifier que l'apprenant est bien un participant accepté/présent de cette session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->first();
            
        if (!$participant) {
            Log::warning('Tentative d\'accès aux messages par un non-participant', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un participant de cette session.'
            ], 403);
        }

        // SÉCURITÉ : Récupérer UNIQUEMENT les messages de cette session spécifique
        $messages = VideoSessionChatMessage::where('video_session_id', $sessionId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function($msg) {
                // SÉCURITÉ : Sécuriser les chemins de photos
                $photoPath = null;
                if ($msg->user && $msg->user->photo) {
                    $photo = $msg->user->photo;
                    if (preg_match('/^(photos|avatars)\/[a-zA-Z0-9_\-\.]+$/', $photo)) {
                        if (\Storage::disk('public')->exists($photo)) {
                            $photoPath = $photo;
                        }
                    }
                }
                
                return [
                    'id' => $msg->id,
                    'user_id' => $msg->user_id,
                    'nom' => ($msg->user->nom ?? '') . ' ' . ($msg->user->prenom ?? ''),
                    'photo' => $photoPath,
                    'message' => htmlspecialchars($msg->message, ENT_QUOTES, 'UTF-8'), // SÉCURITÉ : Échapper le HTML
                    'created_at' => $msg->created_at->toDateTimeString(),
                ];
            })
        ]);
    }

    /**
     * Obtenir les informations de la session (vue mode, participant épinglé, etc.)
     */
    public function getSessionInfo($sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->firstOrFail();

        $session = VideoSession::with(['pinnedParticipant.user'])->findOrFail($sessionId);

        return response()->json([
            'success' => true,
            'session' => [
                'vue_mode' => $session->vue_mode,
                'pinned_participant_id' => $session->pinned_participant_id,
                'pinned_participant' => $session->pinnedParticipant ? [
                    'id' => $session->pinnedParticipant->id,
                    'user_id' => $session->pinnedParticipant->user_id,
                    'nom' => ($session->pinnedParticipant->user->nom ?? '') . ' ' . ($session->pinnedParticipant->user->prenom ?? ''),
                ] : null,
            ]
        ]);
    }

    /**
     * Traiter une offre WebRTC
     */
    public function handleWebRTCOffer(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est participant de la session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->firstOrFail();

        $targetUserId = $request->input('target_user_id');
        $offer = $request->input('offer');

        // Diffuser l'offre au participant cible via Laravel Broadcasting
        broadcast(new \App\Events\WebRTCOffer($sessionId, $user->id, $targetUserId, $offer))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => 'Offre WebRTC envoyée'
        ]);
    }

    /**
     * Traiter une réponse WebRTC
     */
    public function handleWebRTCAnswer(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est participant de la session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->firstOrFail();

        $targetUserId = $request->input('target_user_id');
        $answer = $request->input('answer');

        // Diffuser la réponse au participant cible via Laravel Broadcasting
        broadcast(new \App\Events\WebRTCAnswer($sessionId, $user->id, $targetUserId, $answer))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => 'Réponse WebRTC envoyée'
        ]);
    }

    /**
     * Traiter un candidat ICE
     */
    public function handleWebRTCIceCandidate(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est participant de la session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->firstOrFail();

        $targetUserId = $request->input('target_user_id');
        $candidate = $request->input('candidate');

        // Diffuser le candidat ICE au participant cible via Laravel Broadcasting
        broadcast(new \App\Events\WebRTCIceCandidate($sessionId, $user->id, $targetUserId, $candidate))->toOthers();
        
        return response()->json([
            'success' => true,
            'message' => 'Candidat ICE envoyé'
        ]);
    }

    /**
     * Lever/baisser la main
     */
    public function toggleRaiseHand(Request $request, $sessionId)
    {
        $user = Auth::user();
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->firstOrFail();

        $participant->main_levée = !$participant->main_levée;
        $participant->save();

        // Diffuser l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['main_levée' => $participant->main_levée]))->toOthers();

        return response()->json([
            'success' => true,
            'main_levée' => $participant->main_levée
        ]);
    }

    /**
     * Vérifier si l'apprenant a été accepté dans une session en attente
     */
    public function checkAcceptedRequests()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        // Récupérer les participants acceptés/présents dans des sessions actives
        // Vérifier ceux qui ont été acceptés récemment (dans les 5 dernières minutes)
        $acceptedParticipant = VideoSessionParticipant::where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->whereHas('videoSession', function($query) {
                $query->where('statut', 'active');
            })
            ->where('date_entree', '>=', now()->subMinutes(5))
            ->with(['videoSession.formateur', 'videoSession.cours'])
            ->orderBy('date_entree', 'desc')
            ->first();

        if ($acceptedParticipant) {
            $session = $acceptedParticipant->videoSession;
            $formateur = $session->formateur;
            
            return response()->json([
                'success' => true,
                'accepted' => true,
                'session' => [
                    'id' => $session->id,
                    'cours_id' => $session->cours_id,
                    'titre' => $session->titre ?? $session->cours->titre ?? 'Session vidéo',
                    'formateur_nom' => ($formateur->nom ?? '') . ' ' . ($formateur->prenom ?? ''),
                    'url' => route('apprenant.video-conference.join', ['coursId' => $session->cours_id]),
                    'date_entree' => $acceptedParticipant->date_entree?->format('Y-m-d H:i:s'),
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'accepted' => false
        ]);
    }

    /**
     * Récupérer les sessions actives auxquelles l'apprenant peut rejoindre
     */
    /**
     * Obtenir la liste des participants actifs pour un apprenant
     */
    public function getActiveParticipants($sessionId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est un apprenant
        if (!$user || $user->role !== 'student') {
            Log::warning('Tentative d\'accès aux participants par un non-apprenant', [
                'user_id' => $user->id ?? null,
                'role' => $user->role ?? null,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        // SÉCURITÉ : Vérifier que la session existe et est active
        $session = VideoSession::find($sessionId);
        if (!$session) {
            Log::warning('Tentative d\'accès aux participants d\'une session inexistante', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Session introuvable.'
            ], 404);
        }
        
        if ($session->statut !== 'active') {
            Log::warning('Tentative d\'accès aux participants d\'une session inactive', [
                'user_id' => $user->id,
                'session_id' => $sessionId,
                'statut' => $session->statut
            ]);
            return response()->json([
                'success' => false,
                'message' => 'La session n\'est plus active.'
            ], 403);
        }
        
        // SÉCURITÉ : Vérifier que l'apprenant est bien un participant de cette session
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();
            
        if (!$participant) {
            Log::warning('Tentative d\'accès aux participants par un non-participant', [
                'user_id' => $user->id,
                'session_id' => $sessionId
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas un participant de cette session.'
            ], 403);
        }

        // Récupérer tous les participants actifs (formateur + apprenants acceptés/présents)
        $participants = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present'])
            ->with('user')
            ->get();
        
        // Ajouter le formateur
        $formateur = $session->formateur;
        $allParticipants = $participants->map(function($p) {
            $user = $p->user;
            
            // Sécuriser le chemin de la photo
            $photoPath = null;
            if ($user && $user->photo) {
                $photo = $user->photo;
                if (preg_match('/^(photos|avatars)\/[a-zA-Z0-9_\-\.]+$/', $photo)) {
                    if (\Storage::disk('public')->exists($photo)) {
                        $photoPath = $photo;
                    }
                }
            }
            
            return [
                'id' => $p->id,
                'user_id' => $p->user_id,
                'nom' => ($user->nom ?? '') . ' ' . ($user->prenom ?? ''),
                'email' => $user->email ?? '',
                'photo' => $photoPath,
                'micro_actif' => $p->micro_actif,
                'camera_active' => $p->camera_active,
                'main_levée' => $p->main_levée ?? false,
                'statut' => $p->statut,
                'is_formateur' => false,
            ];
        });
        
        // Ajouter le formateur en premier
        $formateurPhoto = null;
        if ($formateur && $formateur->photo) {
            $photo = $formateur->photo;
            if (preg_match('/^(photos|avatars)\/[a-zA-Z0-9_\-\.]+$/', $photo)) {
                if (\Storage::disk('public')->exists($photo)) {
                    $formateurPhoto = $photo;
                }
            }
        }
        
        $formateurData = [
            'id' => 0,
            'user_id' => $formateur->id,
            'nom' => ($formateur->nom ?? '') . ' ' . ($formateur->prenom ?? ''),
            'email' => $formateur->email ?? '',
            'photo' => $formateurPhoto,
            'micro_actif' => true,
            'camera_active' => true,
            'main_levée' => false, // Le formateur ne lève pas la main
            'statut' => 'present',
            'is_formateur' => true,
        ];
        
        $allParticipants = collect([$formateurData])->merge($allParticipants);

        return response()->json([
            'success' => true,
            'participants' => $allParticipants->values()
        ]);
    }

    /**
     * Vérifier le statut de la session vidéo pour un cours
     */
    public function checkSessionStatus($coursId)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est un apprenant
        if (!$user || $user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        // Vérifier que le cours existe
        $cours = Cours::find($coursId);
        if (!$cours) {
            return response()->json([
                'success' => false,
                'message' => 'Cours introuvable.'
            ], 404);
        }
        
        // Chercher une session active (en cours)
        $sessionActive = VideoSession::where('cours_id', $coursId)
            ->where('statut', '!=', 'terminee')
            ->whereNull('date_fin')
            ->orderBy('date_debut', 'desc')
            ->first();
        
        if ($sessionActive) {
            return response()->json([
                'success' => true,
                'statut' => 'en_cours',
                'session_id' => $sessionActive->id
            ]);
        }
        
        // Chercher la dernière session terminée
        $sessionTerminee = VideoSession::where('cours_id', $coursId)
            ->where('statut', 'terminee')
            ->orderBy('date_fin', 'desc')
            ->first();
        
        if ($sessionTerminee) {
            return response()->json([
                'success' => true,
                'statut' => 'termine',
                'session_id' => $sessionTerminee->id
            ]);
        }
        
        // Aucune session trouvée
        return response()->json([
            'success' => true,
            'statut' => 'bientot_disponible'
        ]);
    }

    public function getActiveSessions()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'student') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        // Récupérer les sessions actives où l'apprenant est participant (même s'il est absent)
        $sessions = VideoSession::where('statut', 'active')
            ->whereHas('participants', function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->whereIn('statut', ['accepte', 'present', 'absent']);
            })
            ->with(['cours', 'formateur'])
            ->get()
            ->filter(function($session) use ($user) {
                // Vérifier que le formateur correspond à la classe et filière de l'apprenant
                $formateur = $session->formateur;
                return $formateur && 
                       $formateur->classe_id === $user->classe_id && 
                       $formateur->filiere === $user->filiere;
            })
            ->map(function($session) {
                $duration = $session->date_debut ? now()->diffInMinutes($session->date_debut) : 0;
                
                return [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'cours_id' => $session->cours_id,
                    'titre' => $session->titre ?? $session->cours->titre ?? 'Session vidéo',
                    'date_debut' => $session->date_debut?->format('Y-m-d H:i:s'),
                    'duration_minutes' => $duration,
                    'url' => route('apprenant.video-conference.join', ['coursId' => $session->cours_id]),
                ];
            })
            ->values();

        return response()->json([
            'success' => true,
            'sessions' => $sessions
        ]);
    }

    /**
     * Marquer l'apprenant comme absent (déconnexion)
     */
    public function markAsAbsent($sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->whereIn('statut', ['accepte', 'present'])
            ->first();

        if ($participant) {
            $participant->statut = 'absent';
            $participant->date_sortie = now();
            $participant->load('user');
            $participant->save();

            // Émettre l'événement pour notifier le formateur
            broadcast(new VideoSessionParticipantStatusChanged($participant, ['statut' => 'present']))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Apprenant marqué comme absent.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Participant non trouvé.'
        ], 404);
    }

    /**
     * Marquer l'apprenant comme présent (reconnexion)
     */
    public function markAsPresent($sessionId)
    {
        $user = Auth::user();
        
        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->where('statut', 'absent')
            ->first();

        if ($participant) {
            $participant->statut = 'present';
            $participant->date_entree = now();
            $participant->date_sortie = null;
            $participant->load('user');
            $participant->save();

            // Émettre l'événement pour notifier le formateur
            broadcast(new VideoSessionParticipantStatusChanged($participant, ['statut' => 'absent']))->toOthers();

            return response()->json([
                'success' => true,
                'message' => 'Apprenant marqué comme présent.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Participant non trouvé ou déjà présent.'
        ], 404);
    }
}
