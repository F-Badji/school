<?php

namespace App\Events;

use App\Models\VideoSessionParticipant;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoSessionParticipantStatusChanged implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $participant;
    public $sessionId;
    public $changes;

    /**
     * Create a new event instance.
     */
    public function __construct(VideoSessionParticipant $participant, array $changes = [])
    {
        $this->participant = $participant;
        $this->sessionId = $participant->video_session_id;
        $this->changes = $changes;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('video-session.' . $this->sessionId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'participant.status.changed';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        $user = $this->participant->user;
        return [
            'participant_id' => $this->participant->id,
            'user_id' => $this->participant->user_id,
            'nom' => ($user->nom ?? '') . ' ' . ($user->prenom ?? ''),
            'statut' => $this->participant->statut,
            'micro_actif' => $this->participant->micro_actif,
            'camera_active' => $this->participant->camera_active,
            'main_levée' => $this->participant->main_levée,
            'micro_controle_par_formateur' => $this->participant->micro_controle_par_formateur,
            'camera_controlee_par_formateur' => $this->participant->camera_controlee_par_formateur,
            'changes' => $this->changes,
        ];
    }
}
