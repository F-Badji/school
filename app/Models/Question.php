<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'cours_id',
        'section_index',
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
        'section_index' => 'integer',
        'ordre' => 'integer',
        'points' => 'integer',
    ];
    
    // Relation avec le cours
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }
}
