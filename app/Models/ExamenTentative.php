<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenTentative extends Model
{
    use HasFactory;

    protected $table = 'examen_tentatives';

    protected $fillable = [
        'examen_id',
        'user_id',
        'heure_debut',
        'heure_fin_prevue',
        'soumis',
        'soumis_le',
    ];

    protected $casts = [
        'heure_debut' => 'datetime',
        'heure_fin_prevue' => 'datetime',
        'soumis' => 'boolean',
        'soumis_le' => 'datetime',
    ];

    // Relation avec l'examen
    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    // Relation avec l'apprenant
    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
