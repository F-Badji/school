<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricule',
        'nom',
        'prenom',
        'annee_naissance',
        'classe',
        'semestre',
        'coefficient',
        'devoir',
        'examen',
        'quiz',
        'moyenne',
        'redoubler',
        'user_id',
    ];

    protected $casts = [
        'annee_naissance' => 'date',
        'redoubler' => 'boolean',
        'devoir' => 'decimal:2',
        'examen' => 'decimal:2',
        'quiz' => 'decimal:2',
        'moyenne' => 'decimal:2',
    ];
    
    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}