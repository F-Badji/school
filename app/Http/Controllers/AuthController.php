<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = filter_var($request->login, FILTER_VALIDATE_EMAIL)
            ? ['email' => $request->login, 'password' => $request->password]
            : ['name' => $request->login, 'password' => $request->password];

        // D'abord vérifier si les identifiants sont corrects (sécurité : ne pas révéler si un compte existe)
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Maintenant que les identifiants sont corrects, vérifier le statut bloqué
            if ($user->statut === 'bloque') {
                // Déconnecter l'utilisateur immédiatement
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                // Afficher le motif de blocage
                $message = 'Votre compte a été bloqué. Motif : ' . ($user->motif_blocage ?? 'Aucun motif spécifié.');
                Log::info('User is blocked after successful auth', [
                    'user_id' => $user->id,
                    'message' => $message,
                ]);
                
                throw ValidationException::withMessages([
                    'login' => [$message],
                ]);
            }
            
            // Mettre à jour last_seen lors de la connexion
            $user->update(['last_seen' => now()]);
            
            // Si le paiement est validé et que l'orientation n'est pas encore marquée comme complète, finaliser automatiquement
            if (($user->role === 'student' || !$user->role)
                && $user->paiement_statut === 'effectué'
                && !$user->orientation_complete
                && !empty($user->motivation)
                && !empty($user->canal_decouverte)
                && !empty($user->filiere)) {
                $user->orientation_complete = true;
                $user->date_orientation = $user->date_orientation ?? now();
                $user->date_paiement = $user->date_paiement ?? now();
                $user->classe_id = $user->classe_id ?? 'licence_1';
                $user->niveau_etude = $user->niveau_etude ?? 'Licence 1';
                $user->save();
            }
            
            // Vérifier si l'utilisateur a un paiement en attente (quelque soit le mode de paiement)
            // Si oui, rediriger vers la page d'orientation pour afficher l'alerte
            if (($user->role === 'student' || !$user->role) && 
                $user->paiement_statut === 'en attente') {
                return redirect()->route('orientation.show')->with('payment_pending', true);
            }
            
            // Redirection selon le rôle uniquement (sécurité basée sur le rôle)
            if ($user->role === 'admin') {
                // Admin : rediriger vers le dashboard admin
                return redirect()->route('dashboard');
            } elseif ($user->role === 'teacher') {
                // Formateur/Professeur : rediriger vers le dashboard formateur
                return redirect()->route('formateur.dashboard');
            } elseif ($user->role === 'student' || !$user->role) {
                // Apprenant : rediriger vers le dashboard apprenant
                return redirect()->route('apprenant.dashboard');
            } else {
                // Rôle inconnu : rediriger vers le dashboard apprenant par défaut
                return redirect()->route('apprenant.dashboard');
            }
        }

        // Si l'authentification a échoué, afficher le message par défaut
        // (ne pas révéler si un compte existe ou s'il est bloqué si les identifiants sont incorrects)
        throw ValidationException::withMessages([
            'login' => ['Les identifiants fournis sont incorrects.'],
        ]);
    }

    public function register(Request $request)
    {
        // SÉCURITÉ CRITIQUE : Vérifier que la session est valide et le token CSRF est présent
        if (!$request->has('_token') || !$request->session()->has('_token')) {
            Log::warning('Tentative d\'inscription sans token CSRF', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
            ]);
            return redirect()->route('login.get')
                ->with('error', '⚠️ Votre session a expiré. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput();
        }
        
        // Vérifier que le token CSRF correspond
        if ($request->session()->token() !== $request->input('_token')) {
            Log::warning('Tentative d\'inscription avec token CSRF invalide', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
            ]);
            return redirect()->route('login.get')
                ->with('error', '⚠️ Token de sécurité invalide. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput();
        }
        
        // Vérifier que la session n'a pas expiré
        if (!$request->session()->isStarted()) {
            Log::warning('Tentative d\'inscription avec session expirée', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
            ]);
            return redirect()->route('login.get')
                ->with('error', '⚠️ Votre session a expiré. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput();
        }
        
        // Initialiser les variables de fichiers pour pouvoir les supprimer en cas d'erreur
        $photoPath = null;
        $diplomePath = null;
        $carteIdentitePath = null;
        
        try {
            $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'date_naissance' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'location' => 'required|string|max:255',
            'nationalite' => 'required|string|max:2',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'diplome' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'carte_identite' => 'required|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            'terms' => 'accepted',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'date_naissance.required' => 'La date de naissance est obligatoire.',
            'date_naissance.date' => 'La date de naissance doit être une date valide.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser une autre adresse email.',
            'phone.required' => 'Le numéro de téléphone est obligatoire.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé. Veuillez utiliser un autre numéro.',
            'location.required' => 'La ville est obligatoire.',
            'nationalite.required' => 'La nationalité est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'password.regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, une lettre minuscule et un chiffre.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'terms.accepted' => 'Vous devez accepter les conditions d\'utilisation.',
            'photo.required' => 'La photo est obligatoire.',
            'photo.image' => 'La photo doit être une image.',
            'photo.mimes' => 'La photo doit être au format JPEG, PNG, JPG ou GIF.',
            'photo.max' => '⚠️ La taille de la photo doit être inférieure à 5 MB. Veuillez choisir un fichier plus petit.',
            'diplome.required' => 'Le diplôme est obligatoire.',
            'diplome.file' => 'Le diplôme doit être un fichier.',
            'diplome.mimes' => 'Le diplôme doit être au format PDF, JPEG, PNG ou JPG.',
            'diplome.max' => '⚠️ La taille du diplôme doit être inférieure à 5 MB. Veuillez choisir un fichier plus petit.',
            'carte_identite.required' => 'La carte d\'identité est obligatoire.',
            'carte_identite.file' => 'La carte d\'identité doit être un fichier.',
            'carte_identite.mimes' => 'La carte d\'identité doit être au format PDF, JPEG, PNG ou JPG.',
            'carte_identite.max' => '⚠️ La taille de la carte d\'identité doit être inférieure à 5 MB. Veuillez choisir un fichier plus petit.',
        ]);

            // SÉCURITÉ : Vérifier à nouveau le token avant de traiter les fichiers
            if ($request->session()->token() !== $request->input('_token')) {
                Log::warning('Token CSRF modifié pendant le traitement de l\'inscription', [
                    'ip' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'email' => $request->input('email'),
                ]);
                return redirect()->route('login.get')
                    ->with('error', '⚠️ Token de sécurité invalide. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                    ->withInput();
            }
            
            // Upload de la photo
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photo = $request->file('photo');
                $photoName = time() . '_photo_' . $photo->getClientOriginalName();
                $photoPath = $photo->storeAs('photos', $photoName, 'public');
            }

            // Upload du diplôme
            $diplomePath = null;
            if ($request->hasFile('diplome')) {
                $diplome = $request->file('diplome');
                $diplomeName = time() . '_diplome_' . $diplome->getClientOriginalName();
                $diplomePath = $diplome->storeAs('documents', $diplomeName, 'public');
            }

            // Upload de la carte d'identité
            $carteIdentitePath = null;
            if ($request->hasFile('carte_identite')) {
                $carteIdentite = $request->file('carte_identite');
                $carteIdentiteName = time() . '_carte_identite_' . $carteIdentite->getClientOriginalName();
                $carteIdentitePath = $carteIdentite->storeAs('documents', $carteIdentiteName, 'public');
            }

            // Créer le nom complet à partir de nom et prenom
            $name = $request->nom . ' ' . $request->prenom;

            // Générer le matricule : Année d'inscription + Date de naissance (DDMMYYYY)
            $anneeInscription = date('Y'); // Année actuelle
            $dateNaissance = Carbon::parse($request->date_naissance);
            $dateNaissanceFormatee = $dateNaissance->format('dmY'); // Format DDMMYYYY
            $matricule = $anneeInscription . $dateNaissanceFormatee;

            $user = User::create([
                'name' => $name,
                'nom' => $request->nom,
                'prenom' => $request->prenom,
                'date_naissance' => $request->date_naissance,
                'matricule' => $matricule,
                'email' => $request->email,
                'phone' => $request->phone,
                'location' => $request->location,
                'nationalite' => $request->nationalite,
                'photo' => $photoPath,
                'diplome' => $diplomePath,
                'carte_identite' => $carteIdentitePath,
                'password' => Hash::make($request->password),
                'role' => 'student', // SÉCURITÉ : Tous les nouveaux inscrits sont automatiquement des étudiants
                'niveau_etude' => 'Licence 1', // Classe par défaut pour toutes les inscriptions
                'classe_id' => 'licence_1',
            ]);

            Auth::login($user);
            
            // Mettre à jour last_seen lors de l'inscription
            $user->update(['last_seen' => now()]);

            // Redirection selon le rôle uniquement (sécurité basée sur le rôle)
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role === 'teacher') {
                return redirect()->route('formateur.dashboard');
            } elseif ($user->role === 'student' || !$user->role) {
                // Pour les apprenants : rediriger vers l'orientation (obligatoire avant d'accéder au dashboard)
                return redirect()->route('orientation.show')->with('success', 'Inscription réussie ! Veuillez compléter votre orientation.');
            } else {
                // Rôle inconnu : rediriger vers l'orientation par défaut
                return redirect()->route('orientation.show')->with('success', 'Inscription réussie ! Veuillez compléter votre orientation.');
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // En cas d'erreur de validation, rediriger avec les erreurs
            Log::info('Erreur de validation lors de l\'inscription', [
                'errors' => $e->errors(),
                'email' => $request->input('email'),
            ]);
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Illuminate\Session\TokenMismatchException $e) {
            // Token CSRF expiré ou invalide - SÉCURITÉ CRITIQUE
            Log::warning('Token CSRF expiré lors de l\'inscription - INSCRIPTION REJETÉE', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
            ]);
            
            // Supprimer les fichiers uploadés si ils existent (sécurité)
            if ($request->hasFile('photo')) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photoPath ?? '');
                } catch (\Exception $ex) {}
            }
            if ($request->hasFile('diplome')) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($diplomePath ?? '');
                } catch (\Exception $ex) {}
            }
            if ($request->hasFile('carte_identite')) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($carteIdentitePath ?? '');
                } catch (\Exception $ex) {}
            }
            
            return redirect()->route('login.get')
                ->with('error', '⚠️ Votre session a expiré. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput($request->except(['password', 'password_confirmation', '_token', 'photo', 'diplome', 'carte_identite']));
        } catch (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e) {
            // Erreur 404 - SÉCURITÉ CRITIQUE
            Log::warning('Erreur 404 lors de l\'inscription - INSCRIPTION REJETÉE', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
                'url' => $request->fullUrl(),
            ]);
            
            // Supprimer les fichiers uploadés si ils existent (sécurité)
            if (isset($photoPath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photoPath);
                } catch (\Exception $ex) {}
            }
            if (isset($diplomePath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($diplomePath);
                } catch (\Exception $ex) {}
            }
            if (isset($carteIdentitePath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($carteIdentitePath);
                } catch (\Exception $ex) {}
            }
            
            return redirect()->route('login.get')
                ->with('error', '⚠️ Erreur de session. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput($request->except(['password', 'password_confirmation', '_token', 'photo', 'diplome', 'carte_identite']));
        } catch (\Exception $e) {
            // Toute autre erreur - SÉCURITÉ CRITIQUE
            Log::error('Erreur lors de l\'inscription - INSCRIPTION REJETÉE', [
                'error' => $e->getMessage(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'email' => $request->input('email'),
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Supprimer les fichiers uploadés si ils existent (sécurité)
            if (isset($photoPath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($photoPath);
                } catch (\Exception $ex) {}
            }
            if (isset($diplomePath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($diplomePath);
                } catch (\Exception $ex) {}
            }
            if (isset($carteIdentitePath)) {
                try {
                    \Illuminate\Support\Facades\Storage::disk('public')->delete($carteIdentitePath);
                } catch (\Exception $ex) {}
            }
            
            return redirect()->route('login.get')
                ->with('error', '⚠️ Une erreur est survenue lors de votre inscription. Pour des raisons de sécurité, veuillez recommencer votre inscription depuis le début.')
                ->withInput($request->except(['password', 'password_confirmation', '_token', 'photo', 'diplome', 'carte_identite']));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
