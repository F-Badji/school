<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PaiementController extends Controller
{
    public function index()
    {
        $paiements = User::query()
            ->where(function($q){
                $q->whereNotNull('montant_paye')
                  ->orWhere('paiement_statut', 'effectué');
            })
            ->orderByDesc('date_paiement')
            ->limit(200)
            ->get();

        return view('admin.paiements.index', compact('paiements'));
    }

    public function create()
    {
        // Récupérer tous les apprenants (étudiants)
        $apprenants = User::where(function($q) {
                $q->where('role', 'student')->orWhereNull('role');
            })
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('admin.paiements.create', compact('apprenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'montant_paye' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'heure_paiement' => ['required', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
            'paiement_method' => 'required|string|in:Carte bancaire,Orange Money,Wave',
            'paiement_statut' => 'required|in:effectué,en attente',
        ]);

        // Trouver l'utilisateur
        $user = User::findOrFail($validated['user_id']);

        // Combiner date et heure
        $datePaiement = $validated['date_paiement'] . ' ' . $validated['heure_paiement'] . ':00';

        // Mettre à jour les informations de paiement
        $user->montant_paye = $validated['montant_paye'];
        $user->date_paiement = $datePaiement;
        $user->paiement_method = $validated['paiement_method'];
        $user->paiement_statut = $validated['paiement_statut'];
        $user->save();

        return redirect()->route('admin.paiements.index')->with('success', 'Paiement créé avec succès.');
    }

    public function show(User $user)
    {
        return view('admin.paiements.show', ['user' => $user]);
    }

    public function updateStatus(Request $request, User $user)
    {
        $validated = $request->validate([
            'paiement_statut' => 'required|in:effectué,en attente',
        ]);
        $user->paiement_statut = $validated['paiement_statut'];
        if ($validated['paiement_statut'] === 'effectué' && !$user->date_paiement) {
            $user->date_paiement = now();
        }
        $user->save();

        return redirect()->route('admin.paiements.show', $user->id)->with('success', 'Statut de paiement mis à jour.');
    }

    public function receipt(User $user)
    {
        $date = now();
        return response()->view('pdf.receipt', compact('user', 'date'));
    }

    public function edit(User $user)
    {
        return view('admin.paiements.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'montant_paye' => 'nullable|numeric|min:0',
            'date_paiement' => 'nullable|date',
            'heure_paiement' => ['nullable', 'regex:/^([0-1][0-9]|2[0-3]):[0-5][0-9]$/'],
            'paiement_method' => 'nullable|string|max:255',
            'paiement_statut' => 'nullable|in:effectué,en attente',
        ]);

        // Préparer les données à mettre à jour
        $updateData = [];
        
        // Montant payé
        if ($request->filled('montant_paye')) {
            $updateData['montant_paye'] = $validated['montant_paye'];
        } elseif ($request->has('montant_paye') && $request->input('montant_paye') === '') {
            $updateData['montant_paye'] = null;
        }
        
        // Méthode de paiement
        if ($request->filled('paiement_method')) {
            $updateData['paiement_method'] = $validated['paiement_method'];
        } elseif ($request->has('paiement_method') && $request->input('paiement_method') === '') {
            $updateData['paiement_method'] = null;
        }
        
        // Statut - TOUJOURS définir une valeur valide (le champ est toujours présent dans le formulaire)
        // Récupérer la valeur directement depuis la requête
        $statutInput = trim((string)$request->input('paiement_statut', ''));
        
        // Si une valeur valide est fournie, l'utiliser
        if (!empty($statutInput) && in_array($statutInput, ['effectué', 'en attente'])) {
            $updateData['paiement_statut'] = $statutInput;
        } else {
            // Valeur vide ou invalide : conserver la valeur existante ou utiliser 'en attente'
            // Ne jamais mettre null car la colonne ne l'accepte pas
            $existingStatut = $user->paiement_statut;
            // S'assurer que la valeur existante est valide, sinon utiliser 'en attente'
            if (!empty($existingStatut) && in_array($existingStatut, ['effectué', 'en attente'])) {
                $updateData['paiement_statut'] = $existingStatut;
            } else {
                // Valeur existante invalide ou null : utiliser 'en attente'
                $updateData['paiement_statut'] = 'en attente';
            }
        }
        
        // S'assurer que paiement_statut est toujours défini (sécurité supplémentaire)
        if (!isset($updateData['paiement_statut']) || empty($updateData['paiement_statut'])) {
            $updateData['paiement_statut'] = 'en attente';
        }
        
        // Gérer la date et l'heure
        $datePaiement = $request->input('date_paiement');
        $heurePaiement = $request->input('heure_paiement');
        
        if ($datePaiement || $heurePaiement) {
            if ($datePaiement && $heurePaiement) {
                // Les deux sont fournis : combiner
                $updateData['date_paiement'] = $datePaiement . ' ' . $heurePaiement . ':00';
            } elseif ($datePaiement && !$heurePaiement && $user->date_paiement) {
                // Seule la date est fournie : conserver l'heure existante
                $existingDateTime = \Carbon\Carbon::parse($user->date_paiement);
                $updateData['date_paiement'] = $datePaiement . ' ' . $existingDateTime->format('H:i:s');
            } elseif (!$datePaiement && $heurePaiement && $user->date_paiement) {
                // Seule l'heure est fournie : conserver la date existante
                $existingDateTime = \Carbon\Carbon::parse($user->date_paiement);
                $updateData['date_paiement'] = $existingDateTime->format('Y-m-d') . ' ' . $heurePaiement . ':00';
            } elseif ($datePaiement && !$heurePaiement && !$user->date_paiement) {
                // Seule la date est fournie et pas de date existante : mettre minuit
                $updateData['date_paiement'] = $datePaiement . ' 00:00:00';
            } elseif (!$datePaiement && $heurePaiement && !$user->date_paiement) {
                // Seule l'heure est fournie et pas de date existante : utiliser la date du jour
                $updateData['date_paiement'] = now()->format('Y-m-d') . ' ' . $heurePaiement . ':00';
            }
        } elseif ($request->has('date_paiement') && empty($datePaiement) && $request->has('heure_paiement') && empty($heurePaiement)) {
            // Les deux champs sont vides : supprimer la date de paiement
            $updateData['date_paiement'] = null;
        }

        $user->update($updateData);

        return redirect()->route('admin.paiements.index')->with('success', 'Paiement modifié avec succès.');
    }

    public function destroy(User $user)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        // Réinitialiser les informations de paiement
        $user->montant_paye = null;
        $user->date_paiement = null;
        $user->paiement_method = null;
        // Ne pas mettre paiement_statut à null car la colonne ne l'accepte pas
        $user->paiement_statut = 'en attente';
        $user->save();

        return redirect()->route('admin.paiements.index')->with('success', 'Paiement supprimé avec succès.');
    }
}
