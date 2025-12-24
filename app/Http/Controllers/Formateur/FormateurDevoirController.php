<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Devoir;
use App\Models\DevoirQuestion;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormateurDevoirController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $devoirs = Devoir::where('formateur_id', $user->id)
            ->with(['matiere', 'questions', 'reponses.apprenant', 'reponses.question'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Récupérer automatiquement les images de couverture des cours du formateur
        $coursAvecImages = \App\Models\Cours::where('formateur_id', $user->id)
            ->whereNotNull('image_couverture')
            ->get()
            ->pluck('image_couverture')
            ->toArray();
        
        foreach($devoirs as $index => $devoir) {
            if (!$devoir->image_couverture && !empty($coursAvecImages)) {
                // Utiliser une image de cours de manière cyclique
                $imageIndex = $index % count($coursAvecImages);
                $devoir->image_couverture = $coursAvecImages[$imageIndex];
            }
        }
        
        // Récupérer tous les apprenants de la classe du formateur
        $apprenants = collect();
        if ($user->classe_id && $user->filiere) {
            $apprenants = User::where(function($q) {
                        $q->where('role', 'student')->orWhereNull('role');
                    })
                ->where('classe_id', '=', $user->classe_id)
                ->where('filiere', '=', $user->filiere)
                ->where('paiement_statut', '=', 'effectué')
                ->get();
        }
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.devoirs', compact('user', 'devoirs', 'matieres', 'apprenants'));
    }
    
    public function create()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.devoirs-create', compact('user', 'matieres'));
    }
    
    public function store(Request $request)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'matiere_id' => 'nullable|exists:matieres,id',
            'date_devoir' => 'nullable|date',
            'heure_debut' => 'nullable',
            'heure_fin' => 'nullable',
            'points_total' => 'nullable|integer|min:1',
            'code_securite' => 'nullable|string|size:6|regex:/^[0-9]{6}$/',
            'questions' => 'nullable|array',
            'questions.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.question' => 'nullable|string',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Gérer l'upload de l'image de couverture
        $imagePath = null;
        if ($request->hasFile('image_couverture')) {
            $image = $request->file('image_couverture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $directory = 'devoirs/couvertures';
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $imagePath = $image->storeAs($directory, $imageName, 'public');
        }
        
        // Générer un code de sécurité si non fourni
        $codeSecurite = $validated['code_securite'] ?? str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        
        $devoir = Devoir::create([
            'formateur_id' => $user->id,
            'matiere_id' => $validated['matiere_id'] ?? null,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'image_couverture' => $imagePath,
            'date_devoir' => $validated['date_devoir'] ?? null,
            'heure_debut' => $validated['heure_debut'] ?? null,
            'heure_fin' => $validated['heure_fin'] ?? null,
            'points_total' => $validated['points_total'] ?? 20,
            'code_securite' => $codeSecurite,
            'actif' => true,
        ]);
        
        $this->processQuestions($request, $devoir);
        
        return redirect()->route('formateur.devoirs')->with('success', 'Devoir créé avec succès.');
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = Devoir::where('id', $id)
            ->where('formateur_id', $user->id)
            ->with(['questions' => function($query) {
                $query->orderBy('ordre');
            }])
            ->firstOrFail();
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.devoirs-create', compact('user', 'devoir', 'matieres'));
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = Devoir::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'matiere_id' => 'nullable|exists:matieres,id',
            'date_devoir' => 'nullable|date',
            'heure_debut' => 'nullable',
            'heure_fin' => 'nullable',
            'points_total' => 'nullable|integer|min:1',
            'code_securite' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'questions' => 'nullable|array',
            'questions.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.question' => 'nullable|string',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Gérer l'upload de l'image de couverture
        if ($request->hasFile('image_couverture')) {
            // Supprimer l'ancienne image si elle existe
            if ($devoir->image_couverture && Storage::disk('public')->exists($devoir->image_couverture)) {
                Storage::disk('public')->delete($devoir->image_couverture);
            }
            
            $image = $request->file('image_couverture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $directory = 'devoirs/couvertures';
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $imagePath = $image->storeAs($directory, $imageName, 'public');
            $validated['image_couverture'] = $imagePath;
        }
        
        $devoir->update([
            'matiere_id' => $validated['matiere_id'] ?? null,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'date_devoir' => $validated['date_devoir'] ?? null,
            'heure_debut' => $validated['heure_debut'] ?? null,
            'heure_fin' => $validated['heure_fin'] ?? null,
            'points_total' => $validated['points_total'] ?? 20,
            'code_securite' => $validated['code_securite'],
            'image_couverture' => $validated['image_couverture'] ?? $devoir->image_couverture,
        ]);
        
        $this->processQuestions($request, $devoir);
        
        return redirect()->route('formateur.devoirs')->with('success', 'Devoir mis à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $devoir = Devoir::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        $devoir->delete();
        
        return redirect()->route('formateur.devoirs')->with('success', 'Devoir supprimé avec succès.');
    }
    
    private function processQuestions(Request $request, Devoir $devoir)
    {
        DevoirQuestion::where('devoir_id', $devoir->id)->delete();
        
        $questions = $request->input('questions', []);
        
        if (empty($questions) || !is_array($questions)) {
            return;
        }
        
        $ordre = 0;
        
        foreach ($questions as $questionIndex => $questionData) {
            if (empty($questionData['question'])) {
                continue;
            }
            
            $question = new DevoirQuestion();
            $question->devoir_id = $devoir->id;
            $question->type = $questionData['type'] ?? 'vrai_faux';
            $question->question = $questionData['question'];
            $question->ordre = $ordre++;
            $question->points = $questionData['points'] ?? 1;
            $question->explication = $questionData['explication'] ?? null;
            
            switch ($question->type) {
                case 'vrai_faux':
                    $question->reponse_correcte = $questionData['reponse_vrai_faux'] ?? null;
                    break;
                
                case 'choix_multiple':
                    $options = [];
                    if (isset($questionData['options']) && is_array($questionData['options'])) {
                        foreach ($questionData['options'] as $opt) {
                            if (!empty($opt['texte'])) {
                                $options[] = [
                                    'texte' => $opt['texte'],
                                    'correcte' => isset($opt['correcte']) && $opt['correcte'] == '1',
                                ];
                            }
                        }
                    }
                    $question->options = $options;
                    break;
                
                case 'texte_libre':
                    $question->reponse_correcte = $questionData['reponse_texte_libre'] ?? null;
                    break;
                
                case 'image':
                    $imageKey = 'questions.' . $questionIndex . '.image_file';
                    if ($request->hasFile($imageKey)) {
                        $image = $request->file($imageKey);
                        $imageName = time() . '_' . $image->getClientOriginalName();
                        $imagePath = $image->storeAs('devoirs/images', $imageName, 'public');
                        $question->image = $imagePath;
                    } elseif (isset($questionData['image'])) {
                        $question->image = $questionData['image'];
                    }
                    $question->reponse_correcte = $questionData['reponse_image'] ?? null;
                    break;
                
                case 'numerique':
                    $question->reponse_correcte = $questionData['reponse_numerique'] ?? null;
                    break;
            }
            
            $question->save();
        }
    }
}
