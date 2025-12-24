<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    protected $table = 'emploi_du_temps';
    
    protected $fillable = [
        'classe',
        'fichier',
        'type_fichier',
    ];
}
