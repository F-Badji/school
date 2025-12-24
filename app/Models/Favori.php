<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;
    
    protected $table = 'favoris';
    
    protected $fillable = [
        'user_id',
        'formateur_id',
        'matiere_nom',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function formateur()
    {
        return $this->belongsTo(User::class, 'formateur_id');
    }
}