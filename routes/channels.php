<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('video-session.{sessionId}', function ($user, $sessionId) {
    // Vérifier que l'utilisateur est participant ou formateur de la session
    $session = \App\Models\VideoSession::find($sessionId);
    
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
});







