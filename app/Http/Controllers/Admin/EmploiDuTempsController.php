<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmploiDuTemps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmploiDuTempsController extends Controller
{
    public function index()
    {
        $emplois = EmploiDuTemps::orderBy('created_at', 'desc')->get();
        return view('admin.emploi-du-temps.index', compact('emplois'));
    }
    
    public function create()
    {
        return view('admin.emploi-du-temps.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'classe' => 'required|string|in:licence_1,licence_2,licence_3',
            'fichier' => 'required|file|mimes:png,jpg,jpeg,svg,pdf|max:10240',
        ], [
            'classe.required' => 'Veuillez sélectionner une classe.',
            'classe.in' => 'La classe sélectionnée n\'est pas valide.',
            'fichier.required' => 'Veuillez sélectionner un fichier.',
            'fichier.mimes' => 'Le fichier doit être au format PNG, JPG, JPEG, SVG ou PDF.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ]);
        
        $file = $request->file('fichier');
        $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9.-]/', '_', $file->getClientOriginalName());
        $path = $file->storeAs('emploi-du-temps', $fileName, 'public');
        $typeFichier = $file->getClientOriginalExtension();
        
        // Supprimer l'ancien emploi du temps pour cette classe s'il existe
        $ancienEmploi = EmploiDuTemps::where('classe', $request->classe)->first();
        if ($ancienEmploi) {
            Storage::disk('public')->delete($ancienEmploi->fichier);
            $ancienEmploi->delete();
        }
        
        EmploiDuTemps::create([
            'classe' => $request->classe,
            'fichier' => $path,
            'type_fichier' => $typeFichier,
        ]);
        
        return redirect()->route('admin.emploi-du-temps.index')
            ->with('success', 'Emploi du temps envoyé avec succès.');
    }
    
    public function destroy(EmploiDuTemps $emploiDuTemps)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        Storage::disk('public')->delete($emploiDuTemps->fichier);
        $emploiDuTemps->delete();
        
        return redirect()->route('admin.emploi-du-temps.index')
            ->with('success', 'Emploi du temps supprimé avec succès.');
    }
}