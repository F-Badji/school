<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cours;
use App\Models\User;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    public function index()
    {
        // Récupérer tous les cours avec leurs formateurs, triés par date de création décroissante
        $cours = Cours::with('formateur')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.cours.index', compact('cours'));
    }
    
    public function create()
    {
        $formateurs = User::where('role', 'teacher')->orderBy('nom')->orderBy('prenom')->get();
        return view('admin.cours.create', compact('formateurs'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'filiere' => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:255',
            'formateur_id' => 'nullable|exists:users,id',
            'duree' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);
        
        $data = $request->all();
        $data['actif'] = $request->has('actif') ? true : false;
        
        Cours::create($data);
        
        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours créé avec succès.');
    }
    
    public function show(Cours $cour)
    {
        $cour->load('formateur');
        return view('admin.cours.show', compact('cour'));
    }
    
    public function edit(Cours $cour)
    {
        $formateurs = User::where('role', 'teacher')->orderBy('nom')->orderBy('prenom')->get();
        return view('admin.cours.edit', compact('cour', 'formateurs'));
    }
    
    public function update(Request $request, Cours $cour)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'filiere' => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:255',
            'formateur_id' => 'nullable|exists:users,id',
            'duree' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
            'actif' => 'nullable|boolean',
        ]);
        
        $data = $request->all();
        $data['actif'] = $request->has('actif') ? true : false;
        
        $cour->update($data);
        
        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours modifié avec succès.');
    }
    
    public function destroy(Cours $cour)
    {
        $cour->delete();
        
        return redirect()->route('admin.cours.index')
            ->with('success', 'Cours supprimé avec succès.');
    }
}
