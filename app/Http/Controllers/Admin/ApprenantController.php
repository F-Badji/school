<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Classe;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ApprenantController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where(function($q) {
            $q->where('role', 'student')->orWhereNull('role');
        });
        
        // Filtres
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%')
                  ->orWhere('nom', 'like', '%'.$request->search.'%')
                  ->orWhere('prenom', 'like', '%'.$request->search.'%');
            });
        }
        
        if ($request->filled('filiere')) {
            $query->where('filiere', $request->filiere);
        }
        
        if ($request->filled('classe_id')) {
            $query->where('classe_id', $request->classe_id);
        }
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $apprenants = $query->with('classe')->latest()->paginate(15);
        $classes = Classe::all();
        
        return view('admin.apprenants.index', compact('apprenants', 'classes'));
    }
    
    public function create()
    {
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        return view('admin.apprenants.create', compact('filieres'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'date_naissance' => 'nullable|date',
            'filiere' => 'nullable|string',
            'phone' => 'nullable|string|max:255|unique:users,phone',
            'location' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:2',
            'classe_id' => 'nullable|string|in:licence_1,licence_2,licence_3',
            'photo' => 'nullable|image|max:2048',
            'diplome' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'carte_identite' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser une autre adresse email.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé. Veuillez utiliser un autre numéro.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);
        
        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'student';
        $data['name'] = $request->nom . ' ' . $request->prenom;
        
        // Générer le matricule : Année d'inscription + Date de naissance (DDMMYYYY)
        if ($request->date_naissance) {
            $anneeInscription = date('Y'); // Année actuelle
            $dateNaissance = \Carbon\Carbon::parse($request->date_naissance);
            $dateNaissanceFormatee = $dateNaissance->format('dmY'); // Format DDMMYYYY
            $data['matricule'] = $anneeInscription . $dateNaissanceFormatee;
        }
        
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        if ($request->hasFile('diplome')) {
            $data['diplome'] = $request->file('diplome')->store('documents', 'public');
        }
        
        if ($request->hasFile('carte_identite')) {
            $data['carte_identite'] = $request->file('carte_identite')->store('documents', 'public');
        }
        
        User::create($data);
        
        return redirect()->route('admin.apprenants.index')
            ->with('success', 'Apprenant créé avec succès.');
    }
    
    public function show(User $apprenant)
    {
        $apprenant->load(['classe', 'evaluations', 'evaluations.evaluation']);
        return view('admin.apprenants.show', compact('apprenant'));
    }
    
    public function edit(User $apprenant)
    {
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        return view('admin.apprenants.edit', compact('apprenant', 'filieres'));
    }
    
    public function update(Request $request, User $apprenant)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$apprenant->id,
            'password' => 'nullable|string|min:8',
            'date_naissance' => 'nullable|date',
            'filiere' => 'nullable|string',
            'phone' => 'nullable|string|max:255|unique:users,phone,'.$apprenant->id,
            'location' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:2',
            'classe_id' => 'nullable|string|in:licence_1,licence_2,licence_3',
            'photo' => 'nullable|image|max:2048',
            'diplome' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'carte_identite' => 'nullable|file|mimes:pdf,jpeg,png,jpg|max:5120',
            'statut' => 'nullable|in:actif,bloque,inactif',
        ], [
            'nom.required' => 'Le nom est obligatoire.',
            'prenom.required' => 'Le prénom est obligatoire.',
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email doit être valide.',
            'email.unique' => 'Cet email est déjà utilisé. Veuillez utiliser une autre adresse email.',
            'phone.unique' => 'Ce numéro de téléphone est déjà utilisé. Veuillez utiliser un autre numéro.',
            'password.min' => 'Le mot de passe doit contenir au moins 8 caractères.',
        ]);
        
        $data = $request->except('password');
        $data['name'] = $request->nom . ' ' . $request->prenom;
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        if ($request->hasFile('photo')) {
            if ($apprenant->photo) {
                Storage::disk('public')->delete($apprenant->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        if ($request->hasFile('diplome')) {
            if ($apprenant->diplome) {
                Storage::disk('public')->delete($apprenant->diplome);
            }
            $data['diplome'] = $request->file('diplome')->store('documents', 'public');
        }
        
        if ($request->hasFile('carte_identite')) {
            if ($apprenant->carte_identite) {
                Storage::disk('public')->delete($apprenant->carte_identite);
            }
            $data['carte_identite'] = $request->file('carte_identite')->store('documents', 'public');
        }
        
        $apprenant->update($data);
        
        return redirect()->route('admin.apprenants.index')
            ->with('success', 'Apprenant modifié avec succès.');
    }
    
    public function destroy(User $apprenant)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        if ($apprenant->photo) {
            Storage::disk('public')->delete($apprenant->photo);
        }
        if ($apprenant->diplome) {
            Storage::disk('public')->delete($apprenant->diplome);
        }
        if ($apprenant->carte_identite) {
            Storage::disk('public')->delete($apprenant->carte_identite);
        }
        $apprenant->delete();
        
        return redirect()->route('admin.apprenants.index')
            ->with('success', 'Apprenant supprimé avec succès.');
    }
    
    public function toggleBlock(Request $request, User $apprenant)
    {
        $action = $request->input('action', 'toggle');
        
        if ($action === 'block') {
            // Bloquer l'apprenant avec motif
            $request->validate([
                'motif_blocage' => 'required|string|max:1000',
            ]);
            
            $apprenant->statut = 'bloque';
            $apprenant->motif_blocage = $request->input('motif_blocage');
            $apprenant->save();
            
            return redirect()->back()
                ->with('success', 'Apprenant bloqué avec succès.');
        } elseif ($action === 'unblock') {
            // Débloquer l'apprenant
            $apprenant->statut = 'actif';
            $apprenant->motif_blocage = null;
            $apprenant->save();
            
            return redirect()->back()
                ->with('success', 'Apprenant débloqué avec succès.');
        } else {
            // Comportement par défaut (toggle)
            $apprenant->statut = $apprenant->statut === 'bloque' ? 'actif' : 'bloque';
            if ($apprenant->statut === 'actif') {
                $apprenant->motif_blocage = null;
            }
            $apprenant->save();
            
            return redirect()->back()
                ->with('success', $apprenant->statut === 'bloque' ? 'Apprenant bloqué.' : 'Apprenant débloqué.');
        }
    }
    
    public function generateBulletin(User $apprenant)
    {
        // Logique pour générer le bulletin
        // À implémenter avec DomPDF ou similaire
        return view('admin.apprenants.bulletin', compact('apprenant'));
    }
    
    /**
     * Afficher la liste de tous les apprenants avec possibilité de marquer comme admis ou redoublant
     */
    public function adminRedoublants(Request $request)
    {
        // Utiliser la même logique que la méthode index pour récupérer tous les apprenants
        $query = User::where(function($q) {
            $q->where('role', 'student')->orWhereNull('role');
        });
        
        // Filtrer par type (optionnel)
        if ($request->filled('type')) {
            if ($request->type === 'admin') {
                // Apprenants promus (passés en classe supérieure)
                $query->where('est_promu', true);
            } elseif ($request->type === 'redoublant') {
                // Redoublants
                $query->where('est_redoublant', true);
            }
        }
        
        // Recherche
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%'.$searchTerm.'%')
                  ->orWhere('email', 'like', '%'.$searchTerm.'%')
                  ->orWhere('nom', 'like', '%'.$searchTerm.'%')
                  ->orWhere('prenom', 'like', '%'.$searchTerm.'%')
                  ->orWhere('matricule', 'like', '%'.$searchTerm.'%');
            });
        }
        
        // EXACTEMENT COMME LA MÉTHODE index QUI FONCTIONNE
        $apprenants = $query->with('classe')->latest()->paginate(15);
        $classes = Classe::all();
        
        // DEBUG
        \Log::info('adminRedoublants appelé - Total: ' . $apprenants->total());
        
        return view('admin.apprenants-admin-redoublants.index', compact('apprenants', 'classes'));
    }
    
    /**
     * Marquer un apprenant comme admis (promu)
     */
    public function markAsAdmis(User $apprenant)
    {
        $apprenant->est_promu = true;
        $apprenant->est_redoublant = false;
        $apprenant->save();
        
        return redirect()->back()->with('success', 'Apprenant marqué comme admis (promu) avec succès.');
    }
    
    /**
     * Marquer un apprenant comme redoublant
     */
    public function markAsRedoublant(User $apprenant)
    {
        $apprenant->est_redoublant = true;
        $apprenant->est_promu = false;
        $apprenant->save();
        
        return redirect()->back()->with('success', 'Apprenant marqué comme redoublant avec succès.');
    }
    
    /**
     * Afficher les détails d'un apprenant admin/redoublant
     */
    public function showAdminRedoublant(User $apprenant)
    {
        $apprenant->load('classe');
        return view('admin.apprenants-admin-redoublants.show', compact('apprenant'));
    }
    
    /**
     * Afficher le formulaire d'édition
     */
    public function editAdminRedoublant(User $apprenant)
    {
        $classes = Classe::all();
        return view('admin.apprenants-admin-redoublants.edit', compact('apprenant', 'classes'));
    }
    
    /**
     * Mettre à jour un apprenant promu/redoublant
     */
    public function updateAdminRedoublant(Request $request, User $apprenant)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$apprenant->id,
            'phone' => 'nullable|string|max:20',
            'classe_id' => 'nullable|exists:classes,id',
            'filiere' => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:255',
            'est_promu' => 'nullable|boolean',
            'est_redoublant' => 'nullable|boolean',
            'annee_academique' => 'nullable|string|max:255',
        ]);
        
        // Gérer les checkboxes boolean
        $validated['est_promu'] = $request->has('est_promu') ? true : false;
        $validated['est_redoublant'] = $request->has('est_redoublant') ? true : false;
        
        $apprenant->update($validated);
        
        return redirect()->route('admin.apprenants-admin-redoublants.index')
            ->with('success', 'Apprenant mis à jour avec succès.');
    }
    
    /**
     * Supprimer un apprenant admin/redoublant
     */
    public function destroyAdminRedoublant(User $apprenant)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        $apprenant->delete();
        
        return redirect()->route('admin.apprenants-admin-redoublants.index')
            ->with('success', 'Apprenant supprimé avec succès.');
    }
}
