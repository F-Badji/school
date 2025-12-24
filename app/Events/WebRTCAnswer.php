<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebRTCAnswer implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sessionId;
    public $fromUserId;
    public $toUserId;
    public $answer;

    /**
     * Create a new event instance.
     */
    public function __construct($sessionId, $fromUserId, $toUserId, $answer)
    {
        $this->sessionId = $sessionId;
        $this->fromUserId = $fromUserId;
        $this->toUserId = $toUserId;
        $this->answer = $answer;
    }

    /**
     * Get the channels the event should broadcast on.
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
        return 'webrtc.answer';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'from_user_id' => $this->fromUserId,
            'to_user_id' => $this->toUserId,
            'answer' => $this->answer,
        ];
    }
}
