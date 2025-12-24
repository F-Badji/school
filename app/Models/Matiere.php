<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $fillable = [
        'nom_matiere',
        'filiere',
        'niveau_etude',
        'semestre',
        'ordre',
    ];
    
    // Accessor pour compatibilité
    public function getNomAttribute()
    {
        return $this->nom_matiere;
    }
    
    public function getLibelleAttribute()
    {
        return $this->nom_matiere;
    }
}
