<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevoirQuestion extends Model
{
    protected $fillable = [
        'devoir_id',
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
    
    public function devoir()
    {
        return $this->belongsTo(Devoir::class, 'devoir_id');
    }
}
