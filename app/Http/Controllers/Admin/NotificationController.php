<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OutboxNotification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $apprenants = User::where('role', 'student')->get(['id','name','email']);
        $formateurs = User::where('role', 'teacher')->get(['id','name','email']);
        $messages = OutboxNotification::latest()->limit(50)->get();
        return view('admin.notifications.index', compact('apprenants','formateurs','messages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|string|in:tous,apprenants,formateurs,utilisateur',
            'user_id' => 'nullable|integer|exists:users,id',
        ]);

        $users = collect();

        // Déterminer les utilisateurs ciblés selon l'audience
        switch ($validated['audience']) {
            case 'tous':
                $users = User::all();
                break;
            case 'apprenants':
                $users = User::where('role', 'student')->get();
                break;
            case 'formateurs':
                $users = User::where('role', 'teacher')->get();
                break;
            case 'utilisateur':
                if ($validated['user_id']) {
                    $users = User::where('id', $validated['user_id'])->get();
                }
                break;
        }

        // Créer une notification pour chaque utilisateur ciblé
        foreach ($users as $user) {
            OutboxNotification::create([
                'title' => $validated['title'],
                'body' => $validated['body'],
                'audience' => $validated['audience'],
                'user_id' => $user->id,
                'status' => 'enregistré',
                'read_at' => null,
            ]);
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Notification envoyée à ' . $users->count() . ' utilisateur(s).');
    }

    public function destroy($id)
    {
        // Vérifier le mot de passe
        $requiredPassword = config('delete_password.password', '022001');
        if (request('delete_password') !== $requiredPassword) {
            return redirect()->back()
                ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
        }
        
        $notification = OutboxNotification::findOrFail($id);
        $notification->delete();

        return redirect()->route('admin.notifications.index')->with('success', 'Notification supprimée avec succès.');
    }

    public function getUnreadCount()
    {
        // Fonctionne pour admin, apprenants et formateurs
        $unreadCount = OutboxNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->count();
        
        return response()->json(['count' => $unreadCount]);
    }

    public function getUnread()
    {
        // Fonctionne pour admin, apprenants et formateurs
        $notifications = OutboxNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $notification = OutboxNotification::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();
        
        $notification->update(['read_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}





