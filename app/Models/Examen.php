<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Examen extends Model
{
    protected $fillable = [
        'formateur_id',
        'matiere_id',
        'titre',
        'description',
        'image_couverture',
        'date_examen',
        'heure_debut',
        'heure_fin',
        'duree_minutes',
        'points_total',
        'actif',
        'code_securite',
    ];
    
    protected $casts = [
        'date_examen' => 'date',
        'actif' => 'boolean',
        'points_total' => 'integer',
        'duree_minutes' => 'integer',
    ];
    
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
    
    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'matiere_id');
    }
    
    public function questions()
    {
        return $this->hasMany(ExamenQuestion::class, 'examen_id')->orderBy('ordre');
    }

    public function reponses()
    {
        return $this->hasMany(ExamenReponse::class, 'examen_id');
    }
}
