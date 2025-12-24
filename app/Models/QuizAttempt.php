<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cours_id',
        'section_index',
        'attempt_number',
        'score',
        'total_questions',
        'answers',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'section_index' => 'integer',
        'attempt_number' => 'integer',
        'score' => 'integer',
        'total_questions' => 'integer',
    ];

    /**
     * Boot method pour ajouter des vérifications de sécurité
     */
    protected static function boot()
    {
        parent::boot();

        // SÉCURITÉ : Empêcher la création de tentatives avec attempt_number > 2
        static::creating(function ($quizAttempt) {
            // Vérifier que attempt_number est valide (1 ou 2 uniquement)
            if ($quizAttempt->attempt_number > 2) {
                Log::warning('SÉCURITÉ QUIZ : Tentative de création avec attempt_number > 2', [
                    'user_id' => $quizAttempt->user_id,
                    'cours_id' => $quizAttempt->cours_id,
                    'section_index' => $quizAttempt->section_index,
                    'attempt_number' => $quizAttempt->attempt_number,
                ]);
                return false; // Empêcher la création
            }

            // SÉCURITÉ : Vérifier qu'il n'y a pas déjà 2 tentatives complétées
            $existingCompletedAttempts = self::where('user_id', $quizAttempt->user_id)
                ->where('cours_id', $quizAttempt->cours_id)
                ->where('section_index', $quizAttempt->section_index)
                ->whereNotNull('completed_at')
                ->where('attempt_number', '<=', 2)
                ->count();

            if ($existingCompletedAttempts >= 2) {
                Log::warning('SÉCURITÉ QUIZ : Tentative de création alors que 2 tentatives déjà complétées', [
                    'user_id' => $quizAttempt->user_id,
                    'cours_id' => $quizAttempt->cours_id,
                    'section_index' => $quizAttempt->section_index,
                    'existing_completed' => $existingCompletedAttempts,
                ]);
                return false; // Empêcher la création
            }

            // SÉCURITÉ : Vérifier le nombre maximum de tentatives (complétées ou non)
            $maxAttemptNumber = self::where('user_id', $quizAttempt->user_id)
                ->where('cours_id', $quizAttempt->cours_id)
                ->where('section_index', $quizAttempt->section_index)
                ->where('attempt_number', '<=', 2)
                ->max('attempt_number') ?? 0;

            // Si attempt_number est supérieur au maximum + 1, c'est suspect
            if ($quizAttempt->attempt_number > $maxAttemptNumber + 1) {
                Log::warning('SÉCURITÉ QUIZ : Tentative de création avec attempt_number suspect', [
                    'user_id' => $quizAttempt->user_id,
                    'cours_id' => $quizAttempt->cours_id,
                    'section_index' => $quizAttempt->section_index,
                    'attempt_number' => $quizAttempt->attempt_number,
                    'max_attempt' => $maxAttemptNumber,
                ]);
                return false; // Empêcher la création
            }

            return true;
        });

        // SÉCURITÉ : Empêcher la modification de attempt_number après création
        static::updating(function ($quizAttempt) {
            // Si attempt_number est modifié et > 2, empêcher
            if ($quizAttempt->isDirty('attempt_number') && $quizAttempt->attempt_number > 2) {
                Log::warning('SÉCURITÉ QUIZ : Tentative de modification de attempt_number > 2', [
                    'user_id' => $quizAttempt->user_id,
                    'cours_id' => $quizAttempt->cours_id,
                    'section_index' => $quizAttempt->section_index,
                    'attempt_number' => $quizAttempt->attempt_number,
                ]);
                return false; // Empêcher la modification
            }

            return true;
        });
    }

    // Relation avec l'utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation avec le cours
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'cours_id');
    }

    /**
     * SÉCURITÉ : Vérifier si l'utilisateur peut créer une nouvelle tentative
     */
    public static function canCreateNewAttempt($userId, $coursId, $sectionIndex)
    {
        // Compter les tentatives complétées
        $completedAttempts = self::where('user_id', $userId)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->whereNotNull('completed_at')
            ->where('attempt_number', '<=', 2)
            ->count();

        if ($completedAttempts >= 2) {
            return false;
        }

        // Vérifier le attempt_number maximum
        $maxAttemptNumber = self::where('user_id', $userId)
            ->where('cours_id', $coursId)
            ->where('section_index', $sectionIndex)
            ->where('attempt_number', '<=', 2)
            ->max('attempt_number') ?? 0;

        return $maxAttemptNumber < 2;
    }
}
