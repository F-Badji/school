<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoSession extends Model
{
    protected $fillable = [
        'session_id',
        'cours_id',
        'formateur_id',
        'pinned_participant_id',
        'titre',
        'description',
        'statut',
        'vue_mode',
        'enregistrement_actif',
        'is_muted_globally',
        'date_debut',
        'date_fin',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin' => 'datetime',
        'is_muted_globally' => 'boolean',
        'enregistrement_actif' => 'boolean',
    ];

    /**
     * Relation avec le cours
     */
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    /**
     * Relation avec le formateur
     */
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }

    /**
     * Relation avec les participants
     */
    public function participants()
    {
        return $this->hasMany(VideoSessionParticipant::class, 'video_session_id');
    }

    /**
     * Participants acceptés et présents
     */
    public function participantsActifs()
    {
        return $this->participants()
            ->whereIn('statut', ['accepte', 'present']);
    }

    /**
     * Participants en attente
     */
    public function participantsEnAttente()
    {
        return $this->participants()
            ->where('statut', 'en_attente');
    }

    /**
     * Relation avec le participant épinglé
     */
    public function pinnedParticipant()
    {
        return $this->belongsTo(VideoSessionParticipant::class, 'pinned_participant_id');
    }

    /**
     * Générer un ID de session unique
     */
    public static function generateSessionId()
    {
        return 'session-' . uniqid() . '-' . time();
    }
}
