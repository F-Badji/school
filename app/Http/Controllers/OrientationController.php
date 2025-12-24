<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Matiere;

class OrientationController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student' && !$user->role)) {
            return redirect()->route('login')->with('error', 'Accès refusé.');
        }
        
        // Si l'orientation est déjà complète et le paiement validé, rediriger vers le dashboard
        if ($user->orientation_complete && $user->paiement_statut === 'effectué') {
            return redirect()->route('apprenant.dashboard');
        }
        
        // Si le paiement est en attente, permettre l'accès à la page pour voir le statut
        
        // Récupérer uniquement les filières en informatique de Licence 1 depuis la base de données
        // L'inscription n'est que pour la Licence 1
        $filieresInformatique = Matiere::select('filiere')
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->where('niveau_etude', 'Licence 1') // Filtrer uniquement Licence 1
            ->distinct()
            ->orderBy('filiere')
            ->pluck('filiere')
            ->toArray();
        
        // Organiser les catégories avec les filières récupérées de la base
        $categories = [
            'Informatique' => $filieresInformatique,
        ];
        
        // Canaux de découverte
        $canaux = [
            'Réseaux sociaux (Facebook, Instagram, Twitter, LinkedIn)',
            'Site web de BJ Académie',
            'Ami/Collègue/Famille',
            'Publicité (Radio, TV, Affiches)',
            'Moteur de recherche (Google, Bing)',
            'Événement/Salon/Forum',
            'Email/Newsletter',
            'Autre',
        ];
        
        // SÉCURITÉ CRITIQUE : Verrouiller le formulaire si le paiement est en attente
        // Empêcher toute modification une fois que les données sont soumises
        // IMPORTANT : Ne pas verrouiller pour les nouveaux utilisateurs (paiement_statut = null)
        // Conditions requises pour verrouiller :
        // 1. Filière sélectionnée
        // 2. Mode de paiement choisi
        // 3. Motivation renseignée
        // 4. Date d'orientation présente (formulaire soumis)
        // 5. Statut de paiement non null (pas un nouvel utilisateur)
        $hasCompletedOrientation = !empty($user->filiere) && 
                                  !empty($user->paiement_method) && 
                                  !empty($user->motivation) && 
                                  !empty($user->date_orientation);
        
        // Vérifier que le statut de paiement n'est pas null (nouvel utilisateur)
        $hasPaymentStatus = !is_null($user->paiement_statut) && $user->paiement_statut !== '';
        
        // Le formulaire est verrouillé SEULEMENT si :
        // - L'orientation est complétée (toutes les données sont présentes)
        // - ET le statut de paiement existe (pas un nouvel utilisateur)
        // - ET (le paiement est en attente OU l'orientation est complète mais le paiement n'est pas effectué)
        $orientationLocked = $hasCompletedOrientation && 
                           $hasPaymentStatus && 
                           (($user->paiement_statut === 'en attente') || 
                            ($user->orientation_complete && $user->paiement_statut !== 'effectué'));
        
        return view('orientation_apprenant', compact('user', 'categories', 'canaux', 'orientationLocked'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student' && !$user->role)) {
            return redirect()->route('login')->with('error', 'Accès refusé.');
        }
        
        // SÉCURITÉ CRITIQUE : Empêcher toute modification si le paiement est en attente ET l'orientation est complète
        // Protection anti-fraude : rejeter toute tentative de modification seulement si l'utilisateur a déjà soumis son orientation
        $hasCompletedOrientation = !empty($user->filiere) && 
                                  !empty($user->paiement_method) && 
                                  !empty($user->motivation) && 
                                  !empty($user->date_orientation);
        
        // Bloquer seulement si l'orientation est complète ET le paiement est en attente
        if (($user->paiement_statut === 'en attente' && $hasCompletedOrientation) || $request->has('form_locked')) {
            \Log::warning('Tentative de modification du formulaire d\'orientation avec paiement en attente', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'form_locked' => $request->has('form_locked'),
                'paiement_statut' => $user->paiement_statut,
                'hasCompletedOrientation' => $hasCompletedOrientation,
            ]);
            return redirect()->route('orientation.show')
                ->with('error', 'SÉCURITÉ : Votre formulaire est verrouillé. Vous ne pouvez plus modifier vos informations tant que l\'administrateur n\'a pas validé votre dossier.');
        }
        
        // Récupérer uniquement les filières valides de Licence 1 depuis la base de données pour la validation
        // L'inscription n'est que pour la Licence 1
        $filieresValides = Matiere::select('filiere')
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->where('niveau_etude', 'Licence 1') // Filtrer uniquement Licence 1
            ->distinct()
            ->pluck('filiere')
            ->toArray();
        
        // Validation stricte
        $validated = $request->validate([
            'motivation' => 'required|string|min:10|max:200',
            'canal_decouverte' => 'required|string|max:255',
            'categorie_formation' => 'required|string|in:Informatique',
            'filiere' => ['required', 'string', 'max:255', function ($attribute, $value, $fail) use ($filieresValides) {
                if (!in_array($value, $filieresValides)) {
                    $fail('La filière sélectionnée n\'est pas valide.');
                }
            }],
            'paiement_method' => 'required|string',
            'paiement_statut' => 'required|string|in:effectué,en attente',
            'montant_paye' => 'required|numeric|min:25000|max:25000', // Montant fixe de 25000 FCFA
            'paiement_confirmation' => 'required|accepted',
        ], [
            'motivation.required' => 'La motivation est obligatoire.',
            'motivation.min' => 'La motivation doit contenir au moins 10 caractères.',
            'motivation.max' => 'La motivation ne doit pas dépasser 200 caractères.',
            'canal_decouverte.required' => 'Le canal de découverte est obligatoire.',
            'categorie_formation.required' => 'La catégorie de formation est obligatoire.',
            'categorie_formation.in' => 'La catégorie de formation doit être "Informatique".',
            'filiere.required' => 'La filière est obligatoire.',
            'paiement_method.required' => 'La méthode de paiement est obligatoire.',
            'paiement_confirmation.required' => 'Vous devez confirmer avoir lu et compris les instructions de paiement.',
            'paiement_confirmation.accepted' => 'Vous devez confirmer avoir lu et compris les instructions de paiement.',
            'montant_paye.required' => 'Le montant est obligatoire.',
            'montant_paye.min' => 'Le montant minimum est de 25000 FCFA.',
            'montant_paye.max' => 'Le montant maximum est de 25000 FCFA.',
        ]);
        
        // Normaliser la méthode de paiement (wave -> Wave, etc.)
        $paiementMethod = strtolower(trim($validated['paiement_method']));
        $methodesValides = ['wave', 'orange money', 'yass', 'paypal'];
        
        // Log pour déboguer
        Log::info('Méthode de paiement reçue', [
            'user_id' => $user->id,
            'email' => $user->email,
            'methode_originale' => $validated['paiement_method'],
            'methode_normalisee' => $paiementMethod,
            'methodes_valides' => $methodesValides,
        ]);
        
        if (!in_array($paiementMethod, $methodesValides)) {
            Log::warning('Tentative de fraude détectée - Méthode de paiement invalide', [
                'user_id' => $user->id,
                'email' => $user->email,
                'methode_soumise' => $validated['paiement_method'],
                'methode_normalisee' => $paiementMethod,
            ]);
            return back()->withErrors(['paiement_method' => 'Méthode de paiement invalide.'])->withInput();
        }
        
        // Si Wave est sélectionné, sauvegarder les données et rediriger vers le lien de paiement Wave
        if ($paiementMethod === 'wave') {
            Log::info('Wave détecté - Redirection vers paiement Wave', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
            // SÉCURITÉ : Sauvegarder les données dans la base AVANT de rediriger
            // Mettre le statut à "en attente" pour que le formulaire soit verrouillé
            $user->update([
                'motivation' => $validated['motivation'],
                'canal_decouverte' => $validated['canal_decouverte'],
                'categorie_formation' => $validated['categorie_formation'],
                'filiere' => $validated['filiere'],
                'paiement_method' => 'Wave',
                'paiement_statut' => 'en attente', // SÉCURITÉ : Toujours en attente jusqu'à validation admin
                'montant_paye' => 25000,
                'date_paiement' => null, // Pas encore payé, sera mis à jour après confirmation
                'orientation_complete' => false, // Pas encore complète car en attente de validation admin
                'date_orientation' => now(),
                'niveau_etude' => 'Licence 1',
                'classe_id' => 'licence_1',
            ]);
            
            // Sauvegarder temporairement les données dans la session pour le callback
            session([
                'orientation_data' => [
                    'motivation' => $validated['motivation'],
                    'canal_decouverte' => $validated['canal_decouverte'],
                    'categorie_formation' => $validated['categorie_formation'],
                    'filiere' => $validated['filiere'],
                    'paiement_method' => 'Wave',
                    'paiement_statut' => 'en attente',
                    'montant_paye' => 25000,
                ],
                'orientation_user_id' => $user->id,
            ]);
            
            Log::info('Orientation Wave sauvegardée - En attente de paiement', [
                'user_id' => $user->id,
                'email' => $user->email,
                'filiere' => $user->filiere,
                'paiement_method' => 'Wave',
                'paiement_statut' => 'en attente',
            ]);
            
            // URL de retour après paiement
            $returnUrl = urlencode(route('orientation.wave.callback'));
            
            // Lien Wave avec le montant de 25000 FCFA et l'URL de retour
            $wavePaymentLink = 'https://pay.wave.com/m/M_sn_HmJztf8soV_5/c/sn/?amount=25000&return_url=' . $returnUrl;
            
            Log::info('Redirection vers Wave', [
                'user_id' => $user->id,
                'email' => $user->email,
                'wave_link' => $wavePaymentLink,
            ]);
            
            // Rediriger vers le lien de paiement Wave
            return redirect()->away($wavePaymentLink);
        }
        
        // Normaliser les méthodes de paiement pour la base de données
        $methodMapping = [
            'wave' => 'Wave',
            'orange money' => 'Orange Money',
            'yass' => 'yass',
            'paypal' => 'paypal',
        ];
        $validated['paiement_method'] = $methodMapping[$paiementMethod];
        
        // SÉCURITÉ : Pour Orange Money, forcer le statut à "en attente" (l'admin doit valider)
        // Empêcher toute tentative de fraude en modifiant le statut côté client
        if ($paiementMethod === 'orange money') {
            // Vérifier si l'utilisateur a tenté de forcer le statut à "effectué"
            if ($validated['paiement_statut'] === 'effectué') {
                Log::warning('Tentative de fraude détectée - Statut de paiement Orange Money modifié', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                    'statut_soumis' => $validated['paiement_statut'],
                    'statut_attendu' => 'en attente',
                ]);
            }
            // Forcer le statut à "en attente" pour Orange Money (sécurité)
            $validated['paiement_statut'] = 'en attente';
        }
        
        // Vérifier que le montant est exactement 25000 FCFA (sécurité anti-fraude)
        if ($validated['montant_paye'] != 25000) {
            Log::warning('Tentative de fraude détectée - Montant incorrect', [
                'user_id' => $user->id,
                'email' => $user->email,
                'montant_soumis' => $validated['montant_paye'],
                'montant_attendu' => 25000,
            ]);
            return back()->withErrors(['montant_paye' => 'Le montant doit être exactement de 25000 FCFA.'])->withInput();
        }
        
        // Vérifier que la filière existe bien dans la base de données (double vérification de sécurité)
        if (!in_array($validated['filiere'], $filieresValides)) {
            Log::warning('Tentative de fraude détectée - Filière invalide', [
                'user_id' => $user->id,
                'email' => $user->email,
                'filiere_soumise' => $validated['filiere'],
                'filieres_valides' => $filieresValides,
            ]);
            return back()->withErrors(['filiere' => 'La filière sélectionnée n\'est pas valide.'])->withInput();
        }
        
        // Mettre à jour l'utilisateur
        $user->update([
            'motivation' => $validated['motivation'],
            'canal_decouverte' => $validated['canal_decouverte'],
            'categorie_formation' => $validated['categorie_formation'],
            'filiere' => $validated['filiere'],
            'paiement_method' => $validated['paiement_method'],
            'paiement_statut' => $validated['paiement_statut'],
            'montant_paye' => $validated['montant_paye'],
            'date_paiement' => $validated['paiement_statut'] === 'effectué' ? now() : null,
            'orientation_complete' => $validated['paiement_statut'] === 'effectué' ? true : false, // Complète uniquement si le paiement est effectué
            'date_orientation' => now(),
            'niveau_etude' => 'Licence 1', // Par défaut pour les nouveaux inscrits
            'classe_id' => 'licence_1',
        ]);
        
        Log::info('Orientation complétée', [
            'user_id' => $user->id,
            'email' => $user->email,
            'filiere' => $user->filiere,
            'paiement_method' => $user->paiement_method,
            'paiement_statut' => $user->paiement_statut,
        ]);
        
        // Si le paiement est en attente (quelque soit le mode de paiement), rediriger vers la page d'orientation avec un message
        if ($validated['paiement_statut'] === 'en attente') {
            return redirect()->route('orientation.show')->with('payment_pending', true);
        }
        
        // Pour les autres méthodes avec paiement effectué, rediriger vers la page de succès
        if ($validated['paiement_statut'] === 'effectué') {
            return redirect()->route('orientation.success');
        }
        
        // Sinon, rediriger vers la page d'orientation
        return redirect()->route('orientation.show');
    }
    
    public function success()
    {
        $user = Auth::user();
        
        if (!$user || !$user->orientation_complete) {
            return redirect()->route('orientation.show');
        }
        
        return view('orientation_success', compact('user'));
    }
    
    public function waveCallback(Request $request)
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est authentifié
        if (!$user) {
            return redirect()->route('login')->with('error', 'Session expirée. Veuillez vous reconnecter.');
        }
        
        // Récupérer les données d'orientation depuis la session
        $orientationData = session('orientation_data');
        $orientationUserId = session('orientation_user_id');
        
        // Vérifier que les données de session existent et correspondent à l'utilisateur
        if (!$orientationData || $orientationUserId != $user->id) {
            return redirect()->route('orientation.show')->with('error', 'Session expirée. Veuillez recommencer le processus d\'inscription.');
        }
        
        // Récupérer uniquement les filières valides de Licence 1 depuis la base de données pour la validation
        // L'inscription n'est que pour la Licence 1
        $filieresValides = Matiere::select('filiere')
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->where('niveau_etude', 'Licence 1') // Filtrer uniquement Licence 1
            ->distinct()
            ->pluck('filiere')
            ->toArray();
        
        // Vérifier que la filière existe bien dans la base de données
        if (!in_array($orientationData['filiere'], $filieresValides)) {
            Log::warning('Tentative de fraude détectée - Filière invalide après paiement Wave', [
                'user_id' => $user->id,
                'email' => $user->email,
                'filiere_soumise' => $orientationData['filiere'],
            ]);
            session()->forget(['orientation_data', 'orientation_user_id']);
            return redirect()->route('orientation.show')->with('error', 'Erreur lors de la validation. Veuillez contacter le support.');
        }
        
        // Mettre à jour l'utilisateur avec les données d'orientation
        // SÉCURITÉ : Le statut reste "en attente" jusqu'à validation par l'admin
        $user->update([
            'motivation' => $orientationData['motivation'],
            'canal_decouverte' => $orientationData['canal_decouverte'],
            'categorie_formation' => $orientationData['categorie_formation'],
            'filiere' => $orientationData['filiere'],
            'paiement_method' => $orientationData['paiement_method'],
            'paiement_statut' => 'en attente', // SÉCURITÉ : Toujours en attente jusqu'à validation admin
            'montant_paye' => $orientationData['montant_paye'],
            'date_paiement' => now(), // Date de soumission du paiement
            'orientation_complete' => false, // Pas encore complète car en attente de validation admin
            'date_orientation' => now(),
            'niveau_etude' => 'Licence 1',
            'classe_id' => 'licence_1',
        ]);
        
        // Nettoyer la session
        session()->forget(['orientation_data', 'orientation_user_id']);
        
        Log::info('Paiement Wave effectué - En attente de validation admin', [
            'user_id' => $user->id,
            'email' => $user->email,
            'filiere' => $user->filiere,
            'montant' => $user->montant_paye,
            'paiement_statut' => 'en attente',
        ]);
        
        // Rediriger vers la page d'orientation avec le message "en attente" (comme Orange Money)
        return redirect()->route('orientation.show')->with('payment_pending', true);
    }
    
    public function wavePayment()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est authentifié et est un apprenant
        if (!$user || ($user->role && $user->role !== 'student' && !$user->role)) {
            return redirect()->route('login')->with('error', 'Accès refusé.');
        }
        
        // Montant fixe de 25000 FCFA
        $montant = 25000;
        
        return view('orientation_wave_payment', compact('user', 'montant'));
    }
}
