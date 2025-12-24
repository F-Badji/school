<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'nom',
        'prenom',
        'date_naissance',
        'matricule',
        'photo',
        'diplome',
        'carte_identite',
        'email',
        'password',
        'phone',
        'location',
        'nationalite',
        'role',
        'statut',
        'motif_blocage',
        'filiere',
        'niveau_etude',
        'classe_id',
        'is_admin',
        'last_seen',
        'montant_paye',
        'date_paiement',
        'paiement_method',
        'paiement_statut',
        'motivation',
        'canal_decouverte',
        'categorie_formation',
        'orientation_complete',
        'date_orientation',
        'est_promu',
        'est_redoublant',
        'annee_academique',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_naissance' => 'date',
            'password' => 'hashed',
            'last_seen' => 'datetime',
        ];
    }
    
    // Relations
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
    
    // Relation many-to-many avec les classes (pour permettre plusieurs classes)
    public function classes()
    {
        return $this->belongsToMany(Classe::class, 'classe_user')
            ->withTimestamps();
    }
    
    public function evaluations()
    {
        return $this->hasMany(EvaluationResultat::class);
    }
    
    public function matieres()
    {
        return $this->belongsToMany(Matiere::class, 'formateur_matiere');
    }
    
    public function cours()
    {
        return $this->hasMany(Cours::class, 'formateur_id');
    }

    public function forumGroups()
    {
        return $this->belongsToMany(ForumGroup::class, 'forum_group_user');
    }

    protected static function booted(): void
    {
        static::saving(function (self $user) {
            if (($user->role === 'student' || is_null($user->role))
                && $user->paiement_statut === 'effectué'
                && empty($user->orientation_complete)
                && !empty($user->motivation)
                && !empty($user->canal_decouverte)
                && !empty($user->filiere)) {
                $user->orientation_complete = true;
                $user->date_orientation = $user->date_orientation ?? now();
                $user->date_paiement = $user->date_paiement ?? now();
                $user->classe_id = $user->classe_id ?? 'licence_1';
                $user->niveau_etude = $user->niveau_etude ?? 'Licence 1';
            }
        });
    }
}
