<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classe extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'code',
        'filiere',
        'niveau_etude',
        'description',
        'actif',
    ];
    
    protected $casts = [
        'actif' => 'boolean',
    ];
    
    public function apprenants()
    {
        // SÉCURITÉ CRITIQUE : Ne retourner que les apprenants dont le paiement est effectué
        // Les apprenants en attente de paiement ne doivent pas apparaître dans la classe
        return $this->belongsToMany(User::class, 'classe_user', 'classe_id', 'user_id')
            ->where(function($q) {
                $q->where('users.role', 'student')->orWhereNull('users.role');
            })
            ->where('users.paiement_statut', 'effectué'); // SÉCURITÉ CRITIQUE : Paiement effectué uniquement
    }
    
    // Relation directe avec la table pivot classe_semestre
    public function classeSemestres()
    {
        return $this->hasMany(\App\Models\ClasseSemestre::class);
    }
    
    // Accesseur pour obtenir les semestres actifs
    public function getSemestresActifsAttribute()
    {
        return $this->classeSemestres()->where('actif', true)->pluck('semestre')->sort()->values();
    }
    
    // Accesseur pour obtenir le nom complet de la classe
    public function getNomCompletAttribute()
    {
        return ($this->filiere ?? '') . ' - ' . ($this->niveau_etude ?? '');
    }
}
