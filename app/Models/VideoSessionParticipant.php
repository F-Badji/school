<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSessionParticipant extends Model
{
    protected $table = 'video_session_participants';

    protected $fillable = [
        'video_session_id',
        'user_id',
        'statut',
        'micro_actif',
        'camera_active',
        'micro_controle_par_formateur',
        'camera_controlee_par_formateur',
        'main_levée',
        'est_epingle',
        'raison_refus',
        'date_entree',
        'date_sortie',
    ];

    protected $casts = [
        'micro_actif' => 'boolean',
        'camera_active' => 'boolean',
        'micro_controle_par_formateur' => 'boolean',
        'camera_controlee_par_formateur' => 'boolean',
        'main_levée' => 'boolean',
        'est_epingle' => 'boolean',
        'date_entree' => 'datetime',
        'date_sortie' => 'datetime',
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
