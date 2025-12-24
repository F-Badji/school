<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamenReponse extends Model
{
    use HasFactory;

    protected $table = 'examen_reponses';

    protected $fillable = [
        'examen_id',
        'examen_question_id',
        'user_id',
        'reponse',
        'reponses_multiple',
        'soumis_le',
    ];

    protected $casts = [
        'reponses_multiple' => 'array',
        'soumis_le' => 'datetime',
    ];

    // Relation avec l'examen
    public function examen()
    {
        return $this->belongsTo(Examen::class, 'examen_id');
    }

    // Relation avec la question
    public function question()
    {
        return $this->belongsTo(ExamenQuestion::class, 'examen_question_id');
    }

    // Relation avec l'apprenant
    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
