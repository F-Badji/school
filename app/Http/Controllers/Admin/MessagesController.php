<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index(Request $request)
    {
        $query = Message::with(['sender:id,name,role','receiver:id,name,role'])->latest();
        
        // Filtre par date "Du"
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }
        
        // Filtre par date "Au"
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }
        
        // Filtre par étiquette
        if ($request->filled('label')) {
            $query->where('label', $request->input('label'));
        }
        
        // Filtre par rôle expéditeur (mapping des valeurs du formulaire vers les valeurs de la base)
        if ($request->filled('sender_role')) {
            $roleFilter = $request->input('sender_role');
            
            $query->whereHas('sender', function($q) use ($roleFilter) {
                if ($roleFilter === 'apprenant') {
                    // Les apprenants ont role = 'student' ou null
                    $q->where(function($subQ) {
                        $subQ->where('role', 'student')->orWhereNull('role');
                    });
                } elseif ($roleFilter === 'formateur') {
                    // Les formateurs ont role = 'teacher'
                    $q->where('role', 'teacher');
                } elseif ($roleFilter === 'admin') {
                    // Les admins ont role = 'admin'
                    $q->where('role', 'admin');
                }
            });
        }
        
        $messages = $query->limit(500)->get();
        return view('admin.messages.index', compact('messages'));
    }

    public function thread($senderId, $receiverId)
    {
        $messages = Message::with(['sender:id,name,role','receiver:id,name,role'])
            ->where(function($q) use ($senderId, $receiverId){
                $q->where('sender_id', $senderId)->where('receiver_id', $receiverId);
            })
            ->orWhere(function($q) use ($senderId, $receiverId){
                $q->where('sender_id', $receiverId)->where('receiver_id', $senderId);
            })
            ->orderBy('created_at')
            ->get();
        return view('admin.messages.thread', compact('messages'));
    }

    /**
     * Supprimer tous les messages privés entre apprenants
     */
    public function deleteStudentsMessages(Request $request)
    {
        // Récupérer tous les IDs des apprenants (role = 'student' ou null)
        $studentIds = \App\Models\User::where(function($q) {
                $q->where('role', 'student')->orWhereNull('role');
            })
            ->pluck('id')
            ->toArray();

        if (empty($studentIds)) {
            return redirect()->route('admin.messages.index')
                ->with('error', 'Aucun apprenant trouvé.');
        }

        // Supprimer tous les messages où l'expéditeur ET le destinataire sont des apprenants
        $deleted = Message::whereIn('sender_id', $studentIds)
            ->whereIn('receiver_id', $studentIds)
            ->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', "{$deleted} message(s) entre apprenants supprimé(s) avec succès.");
    }

    /**
     * Supprimer tous les messages privés entre professeurs
     */
    public function deleteTeachersMessages(Request $request)
    {
        // Récupérer tous les IDs des professeurs (role = 'teacher')
        $teacherIds = \App\Models\User::where('role', 'teacher')
            ->pluck('id')
            ->toArray();

        if (empty($teacherIds)) {
            return redirect()->route('admin.messages.index')
                ->with('error', 'Aucun professeur trouvé.');
        }

        // Supprimer tous les messages où l'expéditeur ET le destinataire sont des professeurs
        $deleted = Message::whereIn('sender_id', $teacherIds)
            ->whereIn('receiver_id', $teacherIds)
            ->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', "{$deleted} message(s) entre professeurs supprimé(s) avec succès.");
    }

    /**
     * Afficher un message
     */
    public function show($id)
    {
        $message = Message::with(['sender:id,name,role,email', 'receiver:id,name,role,email'])->findOrFail($id);
        return view('admin.messages.show', compact('message'));
    }

    /**
     * Afficher le formulaire d'édition d'un message
     */
    public function edit($id)
    {
        $message = Message::findOrFail($id);
        return view('admin.messages.edit', compact('message'));
    }

    /**
     * Mettre à jour un message
     */
    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        
        $request->validate([
            'content' => 'required|string|max:5000',
            'label' => 'nullable|in:Normal,Signalement,Urgent',
        ]);
        
        $message->update([
            'content' => $request->content,
            'label' => $request->label ?? 'Normal',
        ]);
        
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message modifié avec succès.');
    }

    /**
     * Supprimer un message
     */
    public function destroy($id)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        $message = Message::findOrFail($id);
        $message->delete();
        
        return redirect()->route('admin.messages.index')
            ->with('success', 'Message supprimé avec succès.');
    }
}


