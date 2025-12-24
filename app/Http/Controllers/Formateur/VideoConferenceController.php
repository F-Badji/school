<?php

namespace App\Http\Controllers\Formateur;

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
     * Afficher la page de gestion de la visioconférence pour le formateur
     */
    public function manage($coursId)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est un formateur
        if (!$user || $user->role !== 'teacher') {
            return redirect()->route('formateur.dashboard')
                ->with('error', 'Accès refusé. Cette fonctionnalité est réservée aux formateurs.');
        }

        // Récupérer le cours
        $cours = Cours::findOrFail($coursId);
        
        // Vérifier que le formateur est le propriétaire du cours
        if ($cours->formateur_id !== $user->id) {
            return redirect()->route('formateur.cours')
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
                'formateur_id' => $user->id,
                'titre' => $cours->titre,
                'description' => $cours->description,
                'statut' => 'active',
                'date_debut' => now(),
            ]);
        }

        // Charger les relations
        $session->load(['formateur', 'participants.user', 'cours']);

        return view('formateur.video-conference', compact('session', 'cours'));
    }

    /**
     * Accepter un apprenant dans la session
     */
    public function acceptParticipant(Request $request, $sessionId, $participantId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->statut = 'accepte';
        $participant->date_entree = now();
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantJoined($participant))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Apprenant accepté dans la session.'
        ]);
    }

    /**
     * Refuser un apprenant
     */
    public function rejectParticipant(Request $request, $sessionId, $participantId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->statut = 'refuse';
        $participant->raison_refus = $request->input('raison', null);
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['statut' => 'refuse']))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Demande d\'accès refusée.'
        ]);
    }

    /**
     * Couper le micro d'un apprenant
     */
    public function muteParticipant(Request $request, $sessionId, $participantId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('id', $participantId)
            ->firstOrFail();

        // Toggle: si le micro est actif, le couper; sinon, le réactiver
        $oldMicroActif = $participant->micro_actif;
        $participant->micro_actif = !$participant->micro_actif;
        
        // Si on coupe le micro, le formateur prend le contrôle
        // Si on réactive, on peut libérer le contrôle ou le garder
        if (!$participant->micro_actif) {
            $participant->micro_controle_par_formateur = true;
        }
        
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['micro_actif' => $oldMicroActif, 'micro_controle_par_formateur' => !$participant->micro_actif]))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $participant->micro_actif ? 'Microphone activé.' : 'Microphone coupé.',
            'micro_actif' => $participant->micro_actif
        ]);
    }

    /**
     * Désactiver/Réactiver la caméra d'un apprenant
     */
    public function disableCamera(Request $request, $sessionId, $participantId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('id', $participantId)
            ->firstOrFail();

        // Toggle: si la caméra est active, la désactiver; sinon, la réactiver
        $oldCameraActive = $participant->camera_active;
        $participant->camera_active = !$participant->camera_active;
        
        // Si on désactive la caméra, le formateur prend le contrôle
        // Si on réactive, on peut libérer le contrôle ou le garder
        if (!$participant->camera_active) {
            $participant->camera_controlee_par_formateur = true;
        }
        
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantStatusChanged($participant, ['camera_active' => $oldCameraActive, 'camera_controlee_par_formateur' => !$participant->camera_active]))->toOthers();

        return response()->json([
            'success' => true,
            'message' => $participant->camera_active ? 'Caméra activée.' : 'Caméra désactivée.',
            'camera_active' => $participant->camera_active
        ]);
    }

    /**
     * Expulser un apprenant de la session
     */
    public function expelParticipant(Request $request, $sessionId, $participantId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participant = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('id', $participantId)
            ->firstOrFail();

        $participant->statut = 'expulse';
        $participant->date_sortie = now();
        $participant->micro_actif = false;
        $participant->camera_active = false;
        $participant->load('user');
        $participant->save();

        // Émettre l'événement
        broadcast(new VideoSessionParticipantLeft($participant))->toOthers();

        return response()->json([
            'success' => true,
            'message' => 'Apprenant expulsé de la session.'
        ]);
    }

    /**
     * Obtenir la liste des participants en attente
     */
    public function getPendingParticipants($sessionId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participants = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('statut', 'en_attente')
            ->with('user')
            ->get();

        return response()->json([
            'success' => true,
            'participants' => $participants->map(function($p) {
                // Sécuriser le chemin de la photo
                $photoPath = null;
                if ($p->user && $p->user->photo) {
                    // Valider que le chemin ne contient pas de caractères dangereux
                    $photo = $p->user->photo;
                    // Vérifier que le chemin commence par photos/ ou avatars/ et ne contient pas de ../
                    if (preg_match('/^(photos|avatars)\/[a-zA-Z0-9_\-\.]+$/', $photo)) {
                        // Vérifier que le fichier existe réellement
                        if (\Storage::disk('public')->exists($photo)) {
                            $photoPath = $photo;
                        }
                    }
                }
                
                return [
                    'id' => $p->id,
                    'user_id' => $p->user_id,
                    'nom' => ($p->user->nom ?? '') . ' ' . ($p->user->prenom ?? ''),
                    'email' => $p->user->email ?? '',
                    'photo' => $photoPath,
                ];
            })
        ]);
    }

    /**
     * Obtenir la liste des participants actifs
     */
    public function getActiveParticipants($sessionId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participants = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present'])
            ->with('user')
            ->get();

        return response()->json([
            'success' => true,
            'participants' => $participants->map(function($p) {
                $user = $p->user;
                
                // Sécuriser le chemin de la photo
                $photoPath = null;
                if ($user && $user->photo) {
                    // Valider que le chemin ne contient pas de caractères dangereux
                    $photo = $user->photo;
                    // Vérifier que le chemin commence par photos/ ou avatars/ et ne contient pas de ../
                    if (preg_match('/^(photos|avatars)\/[a-zA-Z0-9_\-\.]+$/', $photo)) {
                        // Vérifier que le fichier existe réellement
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
                ];
            })
        ]);
    }

    /**
     * Obtenir tous les participants (actifs et absents)
     */
    public function getAllParticipants($sessionId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $participants = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present', 'absent'])
            ->with('user')
            ->get();

        return response()->json([
            'success' => true,
            'participants' => $participants->map(function($p) {
                $user = $p->user;
                return [
                    'id' => $p->id,
                    'user_id' => $p->user_id,
                    'nom' => ($user->nom ?? '') . ' ' . ($user->prenom ?? ''),
                    'email' => $user->email ?? '',
                    'photo' => $user->photo ?? null,
                    'micro_actif' => $p->micro_actif,
                    'camera_active' => $p->camera_active,
                    'main_levée' => $p->main_levée ?? false,
                    'statut' => $p->statut,
                ];
            })
        ]);
    }

    /**
     * Terminer la session
     */
    public function endSession($sessionId)
    {
        $user = Auth::user();
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $session->statut = 'terminee';
        $session->date_fin = now();
        $session->save();

        // Mettre à jour tous les participants
        VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present'])
            ->update([
                'date_sortie' => now(),
                'micro_actif' => false,
                'camera_active' => false,
            ]);

        return redirect()->route('formateur.cours')
            ->with('success', 'Session vidéo terminée.');
    }

    /**
     * Envoyer un message de chat
     */
    public function sendChatMessage(Request $request, $sessionId)
    {
        $user = Auth::user();
        
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $chatMessage = VideoSessionChatMessage::create([
            'video_session_id' => $sessionId,
            'user_id' => $user->id,
            'message' => $request->message,
        ]);

        // Charger la relation user
        $chatMessage->load('user');

        // Émettre l'événement
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
        
        $session = VideoSession::findOrFail($sessionId);
        
        // Vérifier que l'utilisateur est le formateur de la session
        if ($session->formateur_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $messages = VideoSessionChatMessage::where('video_session_id', $sessionId)
            ->with('user')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages->map(function($msg) {
                return [
                    'id' => $msg->id,
                    'user_id' => $msg->user_id,
                    'nom' => ($msg->user->nom ?? '') . ' ' . ($msg->user->prenom ?? ''),
                    'photo' => $msg->user->photo ?? null,
                    'message' => $msg->message,
                    'created_at' => $msg->created_at->toDateTimeString(),
                ];
            })
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
            ->first();
        
        if (!$participant && $session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

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
            ->first();
        
        if (!$participant && $session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

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
            ->first();
        
        if (!$participant && $session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

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
     * Changer le mode de vue
     */
    public function changeViewMode(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        if ($session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

        $vueMode = $request->input('vue_mode');
        
        if (!in_array($vueMode, ['grille', 'galerie', 'presentation', 'fullscreen'])) {
            return response()->json(['success' => false, 'message' => 'Mode de vue invalide'], 400);
        }

        $session->vue_mode = $vueMode;
        $session->save();

        return response()->json([
            'success' => true,
            'vue_mode' => $vueMode
        ]);
    }

    /**
     * Couper/Réactiver tous les micros (toggle)
     */
    public function muteAll(Request $request, $sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        if ($session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

        // Inverser l'état actuel
        $newState = !$session->is_muted_globally;

        // Mettre à jour tous les micros des participants actifs
        VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present'])
            ->update([
                'micro_actif' => $newState,
                'micro_controle_par_formateur' => !$newState
            ]);

        // Mettre à jour le flag global
        $session->is_muted_globally = $newState;
        $session->save();

        return response()->json([
            'success' => true,
            'message' => $newState ? 'Tous les micros ont été coupés' : 'Tous les micros ont été réactivés',
            'is_muted_globally' => $newState
        ]);
    }

    /**
     * Obtenir les statistiques de la session
     */
    public function getStatistics($sessionId)
    {
        $user = Auth::user();
        $session = VideoSession::findOrFail($sessionId);
        
        if ($session->formateur_id !== $user->id) {
            return response()->json(['success' => false, 'message' => 'Accès refusé'], 403);
        }

        $activeCount = VideoSessionParticipant::where('video_session_id', $sessionId)
            ->whereIn('statut', ['accepte', 'present'])
            ->count();

        $duration = 0;
        if ($session->date_debut) {
            $diff = now()->diffInMinutes($session->date_debut);
            // S'assurer que la durée n'est pas négative
            $duration = max(0, $diff);
        }

        return response()->json([
            'success' => true,
            'statistics' => [
                'participants_count' => $activeCount,
                'duration_minutes' => $duration,
                'started_at' => $session->date_debut?->format('Y-m-d H:i:s'),
                'is_muted_globally' => $session->is_muted_globally ?? false,
            ]
        ]);
    }

    /**
     * Vérifier les sessions actives du formateur
     */
    public function getActiveSessions()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        $sessions = VideoSession::where('formateur_id', $user->id)
            ->where('statut', 'active')
            ->with(['cours'])
            ->get()
            ->map(function($session) {
                $duration = $session->date_debut ? now()->diffInMinutes($session->date_debut) : 0;
                $hours = floor($duration / 60);
                $minutes = $duration % 60;
                
                return [
                    'id' => $session->id,
                    'session_id' => $session->session_id,
                    'cours_id' => $session->cours_id,
                    'titre' => $session->titre ?? $session->cours->titre ?? 'Session vidéo',
                    'date_debut' => $session->date_debut?->format('Y-m-d H:i:s'),
                    'duration_minutes' => $duration,
                    'duration_formatted' => sprintf('%02d:%02d', $hours, $minutes),
                    'url' => route('formateur.video-conference.manage', $session->cours_id),
                ];
            });

        return response()->json([
            'success' => true,
            'sessions' => $sessions
        ]);
    }
}
