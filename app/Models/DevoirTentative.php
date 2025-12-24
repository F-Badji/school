<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevoirTentative extends Model
{
    use HasFactory;

    protected $table = 'devoir_tentatives';

    protected $fillable = [
        'devoir_id',
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

    // Relation avec le devoir
    public function devoir()
    {
        return $this->belongsTo(Devoir::class, 'devoir_id');
    }

    // Relation avec l'apprenant
    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
