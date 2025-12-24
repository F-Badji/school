<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cours;
use App\Models\Classe;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Vérification de sécurité basée sur le rôle uniquement
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        
        // Vérifier que l'utilisateur est un administrateur
        if ($user->role !== 'admin') {
            // Rediriger selon le rôle de l'utilisateur
            if ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard')->with('error', 'Accès refusé. Cette section est réservée à l\'administrateur.');
            } elseif ($user->role === 'student' || !$user->role) {
                return redirect()->route('apprenant.dashboard')->with('error', 'Accès refusé. Cette section est réservée à l\'administrateur.');
            } else {
                abort(403, 'Accès refusé. Cette section est réservée à l\'administrateur.');
            }
        }
        // Statistiques globales
        $totalApprenants = User::where('role', 'student')->orWhereNull('role')->count();
        $totalFormateurs = User::where('role', 'teacher')->count();
        $totalCours = Cours::count();
        $totalClasses = Classe::count();
        
        // Cours disponibles vs en cours
        // Utiliser 'actif' au lieu de 'statut' car la table cours utilise 'actif' (boolean)
        $coursDisponibles = Cours::where('actif', true)
            ->orWhereNull('actif')
            ->count();
        $coursEnCours = Cours::where('actif', false)->count();
        
        // Événements à venir (depuis la table events créée dans le calendrier)
        // Inclure les événements d'aujourd'hui et futurs (à partir de maintenant)
        $evenementsAvenir = Event::with('matiere')
            ->whereNotNull('scheduled_at')
            ->where('scheduled_at', '>=', Carbon::now())
            ->orderBy('scheduled_at', 'asc')
            ->limit(5)
            ->get();
        
        // Paiements récents (à implémenter avec le modèle Paiement)
        $paiementsRecents = collect([]); // Placeholder
        
        // Statistiques mensuelles pour graphiques
        $inscriptionsMensuelles = User::selectRaw('EXTRACT(MONTH FROM created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->get()
            ->pluck('count', 'month');
        
        // Utilisateurs en ligne (dernière connexion < 15 min)
        // Vérifier si la colonne last_seen existe avant de l'utiliser
        $utilisateursEnLigne = 0;
        if (Schema::hasColumn('users', 'last_seen')) {
            $utilisateursEnLigne = User::where('last_seen', '>=', Carbon::now()->subMinutes(15))
                ->count();
        }
        
        // 4 derniers apprenants connectés récemment
        $apprenantsRecents = User::where(function($query) {
                $query->where('role', 'student')
                      ->orWhereNull('role');
            })
            ->get()
            ->map(function($user) {
                // Déterminer la date de dernière activité
                $lastActivity = $user->last_seen ?? $user->updated_at ?? $user->created_at;
                return [
                    'user' => $user,
                    'last_activity' => $lastActivity ? Carbon::parse($lastActivity) : Carbon::now(),
                ];
            })
            ->sortByDesc('last_activity')
            ->take(4)
            ->map(function($item) {
                $user = $item['user'];
                $lastActivity = $item['last_activity'];
                // Déterminer la date de dernière activité (nombre entier de jours)
                $daysAgo = $lastActivity ? intval($lastActivity->diffInDays(Carbon::now())) : null;
                
                // Générer les initiales
                $initials = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
                if (empty($initials)) {
                    $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                }
                
                // Déterminer la couleur de l'avatar (rotation basée sur l'ID)
                $colors = ['bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-success', 'bg-gradient-warning'];
                $colorIndex = ($user->id % 4);
                
                return [
                    'id' => $user->id,
                    'name' => $user->name ?? ($user->prenom . ' ' . $user->nom) ?? 'Utilisateur',
                    'photo' => $user->photo ?? null,
                    'initials' => $initials,
                    'avatar_color' => $colors[$colorIndex],
                    'days_ago' => $daysAgo,
                    'last_activity' => $lastActivity,
                ];
            })
            ->values();
        
        // 4 derniers formateurs connectés récemment
        $formateursRecents = User::where('role', 'teacher')
            ->get()
            ->map(function($user) {
                // Déterminer la date de dernière activité
                $lastActivity = $user->last_seen ?? $user->updated_at ?? $user->created_at;
                return [
                    'user' => $user,
                    'last_activity' => $lastActivity ? Carbon::parse($lastActivity) : Carbon::now(),
                ];
            })
            ->sortByDesc('last_activity')
            ->take(4)
            ->map(function($item) {
                $user = $item['user'];
                $lastActivity = $item['last_activity'];
                // Déterminer la date de dernière activité (nombre entier de jours)
                $daysAgo = $lastActivity ? intval($lastActivity->diffInDays(Carbon::now())) : null;
                
                // Générer les initiales
                $initials = strtoupper(substr($user->prenom ?? '', 0, 1) . substr($user->nom ?? '', 0, 1));
                if (empty($initials)) {
                    $initials = strtoupper(substr($user->name ?? 'U', 0, 2));
                }
                
                // Déterminer la couleur de l'avatar (rotation basée sur l'ID)
                $colors = ['bg-gradient-primary', 'bg-gradient-info', 'bg-gradient-success', 'bg-gradient-warning'];
                $colorIndex = ($user->id % 4);
                
                return [
                    'id' => $user->id,
                    'name' => $user->name ?? ($user->prenom . ' ' . $user->nom) ?? 'Utilisateur',
                    'photo' => $user->photo ?? null,
                    'initials' => $initials,
                    'avatar_color' => $colors[$colorIndex],
                    'days_ago' => $daysAgo,
                    'last_activity' => $lastActivity,
                ];
            })
            ->values();
        
        return view('dashboard', compact(
            'totalApprenants',
            'totalFormateurs',
            'totalCours',
            'totalClasses',
            'coursDisponibles',
            'coursEnCours',
            'evenementsAvenir',
            'paiementsRecents',
            'inscriptionsMensuelles',
            'utilisateursEnLigne',
            'apprenantsRecents',
            'formateursRecents'
        ));
    }
}