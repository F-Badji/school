<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseSemestre extends Model
{
    use HasFactory;
    
    protected $table = 'classe_semestre';
    
    protected $fillable = [
        'classe_id',
        'semestre',
        'actif',
    ];
    
    protected $casts = [
        'actif' => 'boolean',
        'semestre' => 'integer',
    ];
    
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
