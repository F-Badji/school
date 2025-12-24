<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    public function index()
    {
        // Trier par niveau d'étude (Licence 1 à 3) puis par nom de matière
        $matieres = Matiere::orderByRaw("
            CASE niveau_etude 
                WHEN 'Licence 1' THEN 1
                WHEN 'Licence 2' THEN 2
                WHEN 'Licence 3' THEN 3
                WHEN 'Master 1' THEN 4
                WHEN 'Master 2' THEN 5
                ELSE 6
            END
        ")->orderBy('nom_matiere')->paginate(20);
        
        return view('admin.matieres.index', compact('matieres'));
    }
    
    public function create()
    {
        return view('admin.matieres.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nom_matiere' => 'required|string|max:255|unique:matieres,nom_matiere',
            'filiere' => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
        ]);
        
        Matiere::create($request->all());
        
        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière créée avec succès.');
    }
    
    public function show(Matiere $matiere)
    {
        return view('admin.matieres.show', compact('matiere'));
    }
    
    public function edit(Matiere $matiere)
    {
        return view('admin.matieres.edit', compact('matiere'));
    }
    
    public function update(Request $request, Matiere $matiere)
    {
        $request->validate([
            'nom_matiere' => 'required|string|max:255|unique:matieres,nom_matiere,' . $matiere->id,
            'filiere' => 'nullable|string|max:255',
            'niveau_etude' => 'nullable|string|max:255',
            'semestre' => 'nullable|string|max:255',
            'ordre' => 'nullable|integer|min:0',
        ]);
        
        $matiere->update($request->all());
        
        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière modifiée avec succès.');
    }
    
    public function destroy(Matiere $matiere)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        $matiere->delete();
        
        return redirect()->route('admin.matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}
