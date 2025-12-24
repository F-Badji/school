<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FormateurController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher');
        
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
        
        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        
        $formateurs = $query->with('matieres')->latest()->paginate(15);
        
        return view('admin.formateurs.index', compact('formateurs'));
    }
    
    public function create()
    {
        $matieres = Matiere::orderBy('nom_matiere')->get();
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        return view('admin.formateurs.create', compact('matieres', 'filieres'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'date_naissance' => 'nullable|date',
            'phone' => 'nullable|string|max:255|unique:users,phone',
            'location' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:2',
            'filiere' => 'nullable|string',
            'classe_id' => 'nullable|string|in:licence_1,licence_2,licence_3',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
            'photo' => 'nullable|image|max:2048',
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
        
        $data = $request->except('matieres');
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'teacher';
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
        
        $formateur = User::create($data);
        
        // Attacher les matières si sélectionnées
        if ($request->filled('matieres')) {
            $formateur->matieres()->sync($request->matieres);
        }
        
        return redirect()->route('admin.formateurs.index')
            ->with('success', 'Formateur créé avec succès.');
    }
    
    public function show(User $formateur)
    {
        $formateur->load('matieres', 'cours');
        return view('admin.formateurs.show', compact('formateur'));
    }
    
    public function edit(User $formateur)
    {
        $matieres = Matiere::orderBy('nom_matiere')->get();
        $filieres = Matiere::select('filiere')
            ->distinct()
            ->whereNotNull('filiere')
            ->where('filiere', '!=', '')
            ->orderBy('filiere')
            ->pluck('filiere');
        $formateur->load('matieres');
        return view('admin.formateurs.edit', compact('formateur', 'matieres', 'filieres'));
    }
    
    public function update(Request $request, User $formateur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$formateur->id,
            'password' => 'nullable|string|min:8',
            'date_naissance' => 'nullable|date',
            'phone' => 'nullable|string|max:255|unique:users,phone,'.$formateur->id,
            'location' => 'nullable|string|max:255',
            'nationalite' => 'nullable|string|max:2',
            'filiere' => 'nullable|string',
            'classe_id' => 'nullable|string|in:licence_1,licence_2,licence_3',
            'matieres' => 'nullable|array',
            'matieres.*' => 'exists:matieres,id',
            'photo' => 'nullable|image|max:2048',
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
        
        $data = $request->except(['password', 'matieres']);
        $data['name'] = $request->nom . ' ' . $request->prenom;
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        if ($request->hasFile('photo')) {
            if ($formateur->photo) {
                Storage::disk('public')->delete($formateur->photo);
            }
            $data['photo'] = $request->file('photo')->store('photos', 'public');
        }
        
        $formateur->update($data);
        
        // Synchroniser les matières
        if ($request->has('matieres')) {
            $formateur->matieres()->sync($request->matieres);
        } else {
            $formateur->matieres()->detach();
        }
        
        return redirect()->route('admin.formateurs.index')
            ->with('success', 'Formateur modifié avec succès.');
    }
    
    public function destroy(User $formateur)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        if ($formateur->photo) {
            Storage::disk('public')->delete($formateur->photo);
        }
        $formateur->matieres()->detach();
        $formateur->delete();
        
        return redirect()->route('admin.formateurs.index')
            ->with('success', 'Formateur supprimé avec succès.');
    }
    
    public function toggleBlock(Request $request, User $formateur)
    {
        $action = $request->input('action', 'toggle');
        
        if ($action === 'block') {
            // Bloquer le formateur avec motif
            $request->validate([
                'motif_blocage' => 'required|string|max:1000',
            ]);
            
            $formateur->statut = 'bloque';
            $formateur->motif_blocage = $request->input('motif_blocage');
            $formateur->save();
            
            return redirect()->back()
                ->with('success', 'Formateur bloqué avec succès.');
        } elseif ($action === 'unblock') {
            // Débloquer le formateur
            $formateur->statut = 'actif';
            $formateur->motif_blocage = null;
            $formateur->save();
            
            return redirect()->back()
                ->with('success', 'Formateur débloqué avec succès.');
        } else {
            // Comportement par défaut (toggle)
            $formateur->statut = $formateur->statut === 'bloque' ? 'actif' : 'bloque';
            if ($formateur->statut === 'actif') {
                $formateur->motif_blocage = null;
            }
            $formateur->save();
            
            return redirect()->back()
                ->with('success', $formateur->statut === 'bloque' ? 'Formateur bloqué.' : 'Formateur débloqué.');
        }
    }
    
    /**
     * API sécurisée pour récupérer les licences disponibles pour une filière
     */
    public function getLicencesByFiliere(Request $request)
    {
        try {
            // Vérification de sécurité : seul l'admin peut accéder
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json(['error' => 'Accès refusé'], 403);
            }
            
            $request->validate([
                'filiere' => 'required|string|max:255',
            ]);
            
            // Récupérer les niveaux d'étude distincts pour cette filière
            $niveaux = Matiere::select('niveau_etude')
                ->where('filiere', $request->filiere)
                ->whereIn('niveau_etude', ['Licence 1', 'Licence 2', 'Licence 3'])
                ->distinct()
                ->orderByRaw("
                    CASE niveau_etude 
                        WHEN 'Licence 1' THEN 1
                        WHEN 'Licence 2' THEN 2
                        WHEN 'Licence 3' THEN 3
                        ELSE 4
                    END
                ")
                ->pluck('niveau_etude');
            
            // Mapper les niveaux d'étude aux valeurs de licence
            $niveauMap = [
                'Licence 1' => 'licence_1',
                'Licence 2' => 'licence_2',
                'Licence 3' => 'licence_3',
            ];
            
            $licences = $niveaux->map(function($niveau) use ($niveauMap) {
                return [
                    'value' => $niveauMap[$niveau] ?? null,
                    'label' => $niveau
                ];
            })->filter(function($item) {
                return $item['value'] !== null;
            })->values();
            
            return response()->json([
                'success' => true,
                'licences' => $licences
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur getLicencesByFiliere: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors de la récupération des licences',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * API sécurisée pour récupérer les filières disponibles pour une licence
     */
    public function getFilieresByLicence(Request $request)
    {
        try {
            // Vérification de sécurité : seul l'admin peut accéder
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json(['error' => 'Accès refusé'], 403);
            }
            
            $request->validate([
                'licence' => 'required|string|in:licence_1,licence_2,licence_3',
            ]);
            
            // Mapper les valeurs de licence aux niveaux d'étude
            $niveauMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3',
            ];
            
            $niveauEtude = $niveauMap[$request->licence] ?? null;
            
            if (!$niveauEtude) {
                return response()->json(['error' => 'Licence invalide'], 400);
            }
            
            // Récupérer les filières distinctes pour ce niveau d'étude
            $filieres = Matiere::select('filiere')
                ->where('niveau_etude', $niveauEtude)
                ->whereNotNull('filiere')
                ->where('filiere', '!=', '')
                ->distinct()
                ->orderBy('filiere')
                ->pluck('filiere');
            
            return response()->json([
                'success' => true,
                'filieres' => $filieres
            ]);
        } catch (\Exception $e) {
            \Log::error('Erreur getFilieresByLicence: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors de la récupération des filières',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * API sécurisée pour récupérer les matières par licence
     */
    public function getMatieresByLicence(Request $request)
    {
        try {
            // Vérification de sécurité : seul l'admin peut accéder
            if (!auth()->check() || auth()->user()->role !== 'admin') {
                return response()->json(['error' => 'Accès refusé'], 403);
            }
            
            $request->validate([
                'licence' => 'required|string|in:licence_1,licence_2,licence_3',
                'filiere' => 'nullable|string|max:255',
            ]);
            
            // Mapper les valeurs de licence aux niveaux d'étude
            $niveauMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3',
            ];
            
            $niveauEtude = $niveauMap[$request->licence] ?? null;
            
            if (!$niveauEtude) {
                return response()->json(['error' => 'Licence invalide'], 400);
            }
            
            // Récupérer les matières correspondant au niveau d'étude ET à la filière
            $query = Matiere::where('niveau_etude', $niveauEtude);
            
            // Filtrer par filière si elle est fournie
            if ($request->filled('filiere') && $request->filiere !== '') {
                $query->where('filiere', $request->filiere);
            }
            
            $matieres = $query->orderBy('nom_matiere')
                ->get(['id', 'nom_matiere', 'filiere', 'niveau_etude']);
            
            return response()->json([
                'success' => true,
                'matieres' => $matieres,
                'count' => $matieres->count(),
                'niveau_etude' => $niveauEtude
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Erreur de validation',
                'details' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Erreur getMatieresByLicence: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);
            return response()->json([
                'error' => 'Erreur lors de la récupération des matières',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
