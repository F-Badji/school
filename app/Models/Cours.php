<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    // Nom de la table (optionnel, Laravel le déduit automatiquement)
    protected $table = 'cours';
    
    protected $fillable = [
        'titre',
        'description',
        'image_couverture',
        'contenu',
        'filiere',
        'niveau_etude',
        'formateur_id',
        'duree',
        'duree_quiz',
        'ordre',
        'actif',
    ];
    
    protected $casts = [
        'actif' => 'boolean',
        'ordre' => 'integer',
        'formateur_id' => 'integer',
        'contenu' => 'array',
    ];
    
    // Relation avec le formateur
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
    
    // Relation avec les questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'cours_id');
    }
}
