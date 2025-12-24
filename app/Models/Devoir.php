<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Devoir extends Model
{
    protected $fillable = [
        'formateur_id',
        'matiere_id',
        'titre',
        'description',
        'image_couverture',
        'date_devoir',
        'heure_debut',
        'heure_fin',
        'points_total',
        'actif',
        'code_securite',
    ];
    
    protected $casts = [
        'date_devoir' => 'date',
        'actif' => 'boolean',
        'points_total' => 'integer',
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
        return $this->hasMany(DevoirQuestion::class, 'devoir_id')->orderBy('ordre');
    }

    public function reponses()
    {
        return $this->hasMany(DevoirReponse::class, 'devoir_id');
    }
}
