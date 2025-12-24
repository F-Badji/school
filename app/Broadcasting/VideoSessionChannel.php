<?php

namespace App\Broadcasting;

use App\Models\VideoSession;
use App\Models\User;

class VideoSessionChannel
{
    /**
     * Create a new channel instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Authenticate the user's access to the channel.
     */
    public function join(User $user, $sessionId): array|bool
    {
        $session = VideoSession::find($sessionId);
        
        if (!$session) {
            return false;
        }
        
        // Si c'est le formateur
        if ($session->formateur_id === $user->id) {
            return true;
        }
        
        // Si c'est un participant
        $participant = \App\Models\VideoSessionParticipant::where('video_session_id', $sessionId)
            ->where('user_id', $user->id)
            ->first();
        
        return $participant !== null;
    }
}
