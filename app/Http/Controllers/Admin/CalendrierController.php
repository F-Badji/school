<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Matiere;
use Illuminate\Http\Request;

class CalendrierController extends Controller
{
    public function index()
    {
        $events = Event::latest()->limit(50)->get();
        return view('admin.calendrier.index', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string|in:Examen,Devoir',
            'date' => 'required|date',
            'heure' => 'required',
            'classe' => 'nullable|string|in:Licence 1,Licence 2,Licence 3',
            'cours_id' => 'nullable|integer|exists:matieres,id',
            'rappel_minutes' => 'nullable|integer|min:0',
        ]);

        Event::create([
            'titre' => $validated['titre'],
            'type' => $validated['type'],
            'scheduled_at' => date('Y-m-d H:i:s', strtotime($validated['date'] . ' ' . $validated['heure'])),
            'classe_id' => $validated['classe'] ?? null,
            'cours_id' => $validated['cours_id'] ?? null,
            'rappel_minutes' => $validated['rappel_minutes'] ?? null,
        ]);

        return redirect()->route('admin.calendrier.index')->with('success', 'Événement programmé.');
    }

    public function events()
    {
        $query = Event::query();
        
        // Filtrer par classe si l'utilisateur est un formateur ou un apprenant
        $user = auth()->user();
        if ($user && ($user->role === 'teacher' || $user->role === 'student') && $user->classe_id) {
            // Mapper classe_id (licence_1, licence_2, licence_3) vers le format de events (Licence 1, Licence 2, Licence 3)
            $classeMap = [
                'licence_1' => 'Licence 1',
                'licence_2' => 'Licence 2',
                'licence_3' => 'Licence 3'
            ];
            $classeEvent = $classeMap[$user->classe_id] ?? null;
            
            if ($classeEvent) {
                $query->where('classe_id', $classeEvent);
            }
        }
        
        $events = $query->orderBy('scheduled_at')
            ->get()
            ->map(function($e) {
                $matiere = $e->cours_id ? Matiere::find($e->cours_id) : null;
                $matiereNom = $matiere ? ($matiere->nom_matiere ?? $matiere->nom ?? '') : '';
                $date = $e->scheduled_at ? $e->scheduled_at->format('d/m/Y') : '';
                $heure = $e->scheduled_at ? $e->scheduled_at->format('H:i') : '';
                
                $title = '';
                if ($e->rappel_minutes) {
                    $title = 'Rappel ' . $e->type;
                    if ($matiereNom) {
                        // Utiliser "d'" si le nom commence par une voyelle, sinon "de "
                        $preposition = (in_array(strtolower(substr($matiereNom, 0, 1)), ['a', 'e', 'i', 'o', 'u', 'é', 'è', 'ê', 'à', 'â'])) ? 'd\'' : 'de ';
                        $title .= ' ' . $preposition . $matiereNom;
                    }
                    if ($date && $heure) {
                        $title .= ', programmé le : ' . $date . ' à ' . $heure;
                    } elseif ($date) {
                        $title .= ', programmé le : ' . $date;
                    } elseif ($heure) {
                        $title .= ', programmé à ' . $heure;
                    }
                } else {
                    $title = $e->titre . ' (' . $e->type . ')';
                    if ($matiereNom) {
                        $title .= ' - ' . $matiereNom;
                    }
                    if ($date && $heure) {
                        $title .= ' - ' . $date . ' à ' . $heure;
                    } elseif ($date) {
                        $title .= ' - ' . $date;
                    } elseif ($heure) {
                        $title .= ' à ' . $heure;
                    }
                }
                
                return [
                    'title' => $title,
                    'type' => $e->type,
                    'start' => optional($e->scheduled_at)->format('Y-m-d'),
                    'full_start' => optional($e->scheduled_at)->toIso8601String(),
                    'date' => $date,
                    'heure' => $heure,
                    'matiere_nom' => $matiereNom,
                ];
            });

        return response()->json($events);
    }
    
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('admin.calendrier.show', compact('event'));
    }
    
    public function edit($id)
    {
        $event = Event::findOrFail($id);
        $matieres = Matiere::orderBy('nom_matiere')->get();
        return view('admin.calendrier.edit', compact('event', 'matieres'));
    }
    
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required|string|in:Examen,Devoir',
            'date' => 'required|date',
            'heure' => 'required',
            'classe' => 'nullable|string|in:Licence 1,Licence 2,Licence 3',
            'cours_id' => 'nullable|integer|exists:matieres,id',
            'rappel_minutes' => 'nullable|integer|min:0',
        ]);

        $event->update([
            'titre' => $validated['titre'],
            'type' => $validated['type'],
            'scheduled_at' => date('Y-m-d H:i:s', strtotime($validated['date'] . ' ' . $validated['heure'])),
            'classe_id' => $validated['classe'] ?? null,
            'cours_id' => $validated['cours_id'] ?? null,
            'rappel_minutes' => $validated['rappel_minutes'] ?? null,
        ]);

        return redirect()->route('admin.calendrier.index')->with('success', 'Événement modifié avec succès.');
    }
    
    public function destroy($id)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.calendrier.index')->with('success', 'Événement supprimé avec succès.');
    }
}
