<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevoirReponse extends Model
{
    use HasFactory;

    protected $table = 'devoir_reponses';

    protected $fillable = [
        'devoir_id',
        'devoir_question_id',
        'user_id',
        'reponse',
        'reponses_multiple',
        'soumis_le',
    ];

    protected $casts = [
        'reponses_multiple' => 'array',
        'soumis_le' => 'datetime',
    ];

    // Relation avec le devoir
    public function devoir()
    {
        return $this->belongsTo(Devoir::class, 'devoir_id');
    }

    // Relation avec la question
    public function question()
    {
        return $this->belongsTo(DevoirQuestion::class, 'devoir_question_id');
    }

    // Relation avec l'apprenant
    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
