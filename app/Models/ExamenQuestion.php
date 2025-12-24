<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamenQuestion extends Model
{
    protected $fillable = [
        'examen_id',
        'type',
        'question',
        'options',
        'image',
        'reponse_correcte',
        'ordre',
        'points',
        'explication',
    ];
    
    protected $casts = [
        'options' => 'array',
        'ordre' => 'integer',
        'points' => 'integer',
    ];
    
    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }
}
