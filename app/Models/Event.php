<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'type',
        'scheduled_at',
        'classe_id',
        'cours_id',
        'rappel_minutes',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'cours_id');
    }
}









