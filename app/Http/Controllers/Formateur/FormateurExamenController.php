<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Examen;
use App\Models\ExamenQuestion;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormateurExamenController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $examens = Examen::where('formateur_id', $user->id)
            ->with(['matiere', 'questions', 'reponses.apprenant', 'reponses.question'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Récupérer automatiquement les images de couverture des cours du formateur
        $coursAvecImages = \App\Models\Cours::where('formateur_id', $user->id)
            ->whereNotNull('image_couverture')
            ->get()
            ->pluck('image_couverture')
            ->toArray();
        
        foreach($examens as $index => $examen) {
            if (!$examen->image_couverture && !empty($coursAvecImages)) {
                // Utiliser une image de cours de manière cyclique
                $imageIndex = $index % count($coursAvecImages);
                $examen->image_couverture = $coursAvecImages[$imageIndex];
            }
        }
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.examens', compact('user', 'examens', 'matieres'));
    }
    
    public function create()
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.examens-create', compact('user', 'matieres'));
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
            'matiere_id' => 'nullable|exists:matieres,id',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_examen' => 'nullable|date',
            'heure_debut' => 'nullable',
            'heure_fin' => 'nullable',
            'duree_minutes' => 'nullable|integer|min:1',
            'points_total' => 'nullable|integer|min:1',
            'questions' => 'nullable|array',
            'questions.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.question' => 'nullable|string',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $imagePath = null;
        if ($request->hasFile('image_couverture')) {
            $image = $request->file('image_couverture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $directory = 'examens/couvertures';
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $imagePath = $image->storeAs($directory, $imageName, 'public');
        }
        
        $examen = Examen::create([
            'formateur_id' => $user->id,
            'matiere_id' => $validated['matiere_id'] ?? null,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'image_couverture' => $imagePath,
            'date_examen' => $validated['date_examen'] ?? null,
            'heure_debut' => $validated['heure_debut'] ?? null,
            'heure_fin' => $validated['heure_fin'] ?? null,
            'duree_minutes' => $validated['duree_minutes'] ?? null,
            'points_total' => $validated['points_total'] ?? 20,
            'code_securite' => $validated['code_securite'] ?? null,
            'actif' => true,
        ]);
        
        $this->processQuestions($request, $examen);
        
        return redirect()->route('formateur.examens')->with('success', 'Examen créé avec succès.');
    }
    
    public function edit($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = Examen::where('id', $id)
            ->where('formateur_id', $user->id)
            ->with(['questions' => function($query) {
                $query->orderBy('ordre');
            }])
            ->firstOrFail();
        
        $matieres = $user->matieres()->get();
        
        return view('formateur.examens-create', compact('user', 'examen', 'matieres'));
    }
    
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = Examen::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'matiere_id' => 'nullable|exists:matieres,id',
            'image_couverture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_examen' => 'nullable|date',
            'heure_debut' => 'nullable',
            'heure_fin' => 'nullable',
            'duree_minutes' => 'nullable|integer|min:1',
            'points_total' => 'nullable|integer|min:1',
            'code_securite' => 'required|string|size:6|regex:/^[0-9]{6}$/',
            'questions' => 'nullable|array',
            'questions.*.type' => 'nullable|in:vrai_faux,choix_multiple,texte_libre,image,numerique',
            'questions.*.question' => 'nullable|string',
            'questions.*.points' => 'nullable|integer|min:1',
            'questions.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($request->hasFile('image_couverture')) {
            if ($examen->image_couverture && Storage::disk('public')->exists($examen->image_couverture)) {
                Storage::disk('public')->delete($examen->image_couverture);
            }
            
            $image = $request->file('image_couverture');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $directory = 'examens/couvertures';
            
            if (!Storage::disk('public')->exists($directory)) {
                Storage::disk('public')->makeDirectory($directory);
            }
            
            $imagePath = $image->storeAs($directory, $imageName, 'public');
            $validated['image_couverture'] = $imagePath;
        }
        
        $examen->update([
            'matiere_id' => $validated['matiere_id'] ?? null,
            'titre' => $validated['titre'],
            'description' => $validated['description'] ?? null,
            'image_couverture' => $validated['image_couverture'] ?? $examen->image_couverture,
            'date_examen' => $validated['date_examen'] ?? null,
            'heure_debut' => $validated['heure_debut'] ?? null,
            'heure_fin' => $validated['heure_fin'] ?? null,
            'duree_minutes' => $validated['duree_minutes'] ?? null,
            'points_total' => $validated['points_total'] ?? 20,
            'code_securite' => $validated['code_securite'] ?? null,
        ]);
        
        $this->processQuestions($request, $examen);
        
        return redirect()->route('formateur.examens')->with('success', 'Examen mis à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $user = Auth::user();
        
        if (!$user || $user->role !== 'teacher') {
            abort(403, 'Accès refusé.');
        }
        
        $examen = Examen::where('id', $id)
            ->where('formateur_id', $user->id)
            ->firstOrFail();
        
        $examen->delete();
        
        return redirect()->route('formateur.examens')->with('success', 'Examen supprimé avec succès.');
    }
    
    private function processQuestions(Request $request, Examen $examen)
    {
        ExamenQuestion::where('examen_id', $examen->id)->delete();
        
        $questions = $request->input('questions', []);
        
        if (empty($questions) || !is_array($questions)) {
            return;
        }
        
        $ordre = 0;
        
        foreach ($questions as $questionIndex => $questionData) {
            if (empty($questionData['question'])) {
                continue;
            }
            
            $question = new ExamenQuestion();
            $question->examen_id = $examen->id;
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
                        $imagePath = $image->storeAs('examens/images', $imageName, 'public');
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
