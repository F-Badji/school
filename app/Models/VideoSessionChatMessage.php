<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSessionChatMessage extends Model
{
    protected $table = 'video_session_chat_messages';

    protected $fillable = [
        'video_session_id',
        'user_id',
        'message',
    ];

    /**
     * Relation avec la session vidéo
     */
    public function videoSession()
    {
        return $this->belongsTo(VideoSession::class, 'video_session_id');
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
