<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\ForumGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MesMessagesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        
        // Récupérer tous les apprenants (role = 'student' ou null)
        $apprenants = User::where(function($q) {
                $q->where('role', 'student')->orWhereNull('role');
            })
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
        
        // Récupérer tous les professeurs (role = 'teacher')
        $professeurs = User::where('role', 'teacher')
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
        
        // Combiner tous les contacts autorisés
        $contactsAutorises = $apprenants->concat($professeurs);

        // Récupérer les groupes de forum de l'utilisateur
        $forumGroups = $user->forumGroups()->with('users:id,name,prenom,nom,email,photo')->get();

        // Récupérer tous les messages où l'utilisateur est soit l'expéditeur soit le destinataire
        $messages = Message::with(['sender:id,name,email,role,prenom,nom,photo,last_seen', 'receiver:id,name,email,role,prenom,nom,photo,last_seen'])
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Construire les éléments pour la liste de chat
        $pinnedItems = [];
        foreach($forumGroups as $group) {
            $pinnedItems['group_' . $group->id] = [
                'type' => 'group',
                'group' => $group,
                'last_message' => null, // Pour l'instant, pas de messages de groupe
                'unread_count' => 0
            ];
        }

        // Construire les conversations à partir des messages existants
        $conversations = [];
        foreach($messages as $message) {
            $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            if (!isset($conversations[$otherUserId])) {
                $conversations[$otherUserId] = [
                    'type' => 'user',
                    'user' => $message->sender_id == $user->id ? $message->receiver : $message->sender,
                    'last_message' => $message,
                    'unread_count' => 0
                ];
            }
            if ($message->receiver_id == $user->id && !$message->read_at) {
                $conversations[$otherUserId]['unread_count']++;
            }
            if ($message->created_at > $conversations[$otherUserId]['last_message']->created_at) {
                $conversations[$otherUserId]['last_message'] = $message;
            }
        }

        // Ajouter tous les contacts autorisés qui n'ont pas encore de conversation
        foreach($contactsAutorises as $contact) {
            if (!isset($conversations[$contact->id])) {
                $conversations[$contact->id] = [
                    'type' => 'user',
                    'user' => $contact,
                    'last_message' => null,
                    'unread_count' => 0
                ];
            }
        }

        // Combiner les éléments épinglés (groupes) avec les conversations
        $allItems = $pinnedItems + $conversations;

        // Trier seulement les conversations utilisateur par dernier message
        $userConversations = array_filter($allItems, function($item) {
            return $item['type'] === 'user';
        });
        uasort($userConversations, function($a, $b) {
            if ($a['last_message'] && $b['last_message']) {
                return $b['last_message']->created_at <=> $a['last_message']->created_at;
            } elseif ($a['last_message']) {
                return -1;
            } elseif ($b['last_message']) {
                return 1;
            }
            // Si aucun n'a de message, trier par nom
            $nameA = ($a['user']->prenom ?? '') . ' ' . ($a['user']->nom ?? '');
            $nameB = ($b['user']->prenom ?? '') . ' ' . ($b['user']->nom ?? '');
            return strcmp($nameA, $nameB);
        });

        // Recombinar avec les groupes épinglés en premier
        $allItems = $pinnedItems + $userConversations;

        $activeChatId = request()->get('chat', null);

        return view('admin.mes-messages.index', compact('messages', 'contactsAutorises', 'forumGroups', 'allItems', 'activeChatId'));
    }

    public function send(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé. Seuls les administrateurs peuvent envoyer des messages.'
            ], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'content' => 'required|string|max:5000',
            'label' => 'nullable|in:Normal,Signalement,Urgent,System',
        ]);

        $receiver = User::findOrFail($request->receiver_id);
        
        // SÉCURITÉ : Empêcher l'envoi de message à soi-même
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous envoyer un message à vous-même.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Pour les messages système (appels), vérifier qu'ils sont bien envoyés entre l'utilisateur connecté et le receiver
        $isSystemMessage = $request->label === 'System' || 
                          strpos($request->content, '📞❌') !== false || 
                          strpos($request->content, '📞✅') !== false ||
                          strpos($request->content, 'Appel manqué') !== false ||
                          strpos($request->content, 'Appel terminé') !== false;
        
        // Vérifier que le destinataire est un apprenant ou un professeur (pas un admin)
        $contactAutorise = false;
        if (($receiver->role === 'student' || !$receiver->role) || $receiver->role === 'teacher') {
            $contactAutorise = true;
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas envoyer de message à cette personne. Accès limité aux apprenants et professeurs.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Pour les messages système, double vérification
        // Le message système doit être envoyé uniquement entre l'utilisateur connecté et le receiver spécifié
        if ($isSystemMessage) {
            // Vérifier que le receiver_id correspond bien à une conversation valide
            if ($receiver->id !== $request->receiver_id) {
                \Log::warning("⚠️ [SÉCURITÉ admin] Tentative d'envoi de message système avec receiver_id invalide", [
                    'user_id' => $user->id,
                    'requested_receiver_id' => $request->receiver_id,
                    'actual_receiver_id' => $receiver->id,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Erreur de sécurité : receiver_id invalide pour le message système.'
                ], 403);
            }
        }

        // SÉCURITÉ CRITIQUE : Forcer l'utilisation de l'ID de l'utilisateur connecté comme expéditeur
        // Ne jamais faire confiance aux données du client
        $message = Message::create([
            'sender_id' => $user->id, // TOUJOURS l'utilisateur connecté
            'receiver_id' => $request->receiver_id,
            'content' => $request->content,
            'label' => $request->label ?? 'Normal',
            'read_at' => null, // Les nouveaux messages ne sont pas lus par défaut
        ]);

        // Calculer le nombre total de messages non lus pour le destinataire
        $receiverUnreadCount = Message::where('receiver_id', $request->receiver_id)
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'message' => $message->load(['sender:id,name,email,role,prenom,nom,photo,last_seen', 'receiver:id,name,email,role,prenom,nom,photo,last_seen']),
            'receiver_unread_count' => $receiverUnreadCount,
        ]);
    }

    public function storeCall(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'started_at' => 'required|date',
            'ended_at' => 'nullable|date',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:missed,rejected,ended,answered',
            'was_answered' => 'required|boolean',
        ]);
        
        $receiver = User::findOrFail($request->receiver_id);
        
        // SÉCURITÉ : Empêcher l'enregistrement d'appel à soi-même
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas vous appeler vous-même.'
            ], 403);
        }
        
        // L'admin peut appeler tous les apprenants et formateurs
        $contactAutorise = false;
        if (($receiver->role === 'student' || !$receiver->role) || $receiver->role === 'teacher') {
            $contactAutorise = true;
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false, 
                'message' => 'Vous ne pouvez pas appeler cette personne. Accès limité aux apprenants et formateurs.'
            ], 403);
        }
        
        // SÉCURITÉ : Forcer l'utilisation de l'ID de l'utilisateur connecté comme expéditeur
        $call = \App\Models\Call::create([
            'caller_id' => $user->id,
            'receiver_id' => $request->receiver_id,
            'started_at' => $request->started_at,
            'ended_at' => $request->ended_at,
            'duration' => $request->duration,
            'status' => $request->status,
            'was_answered' => $request->was_answered,
        ]);
        
        return response()->json([
            'success' => true,
            'call' => $call->load(['caller:id,name,prenom,nom,email,photo,role', 'receiver:id,name,prenom,nom,email,photo,role']),
        ]);
    }

    public function getThread($receiverId)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé. Seuls les administrateurs peuvent accéder aux conversations.'
            ], 403);
        }
        
        $receiver = User::findOrFail($receiverId);
        
        // SÉCURITÉ : Empêcher l'accès à sa propre conversation
        if ($receiver->id === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas accéder à votre propre conversation.'
            ], 403);
        }
        
        // Vérifier que le destinataire est un apprenant ou un professeur (pas un admin)
        $contactAutorise = false;
        if (($receiver->role === 'student' || !$receiver->role) || $receiver->role === 'teacher') {
            $contactAutorise = true;
        }
        
        if (!$contactAutorise) {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé. Vous ne pouvez pas accéder à cette conversation.'
            ], 403);
        }
        
        // SÉCURITÉ CRITIQUE : Récupérer UNIQUEMENT les messages entre l'utilisateur connecté et le destinataire
        // Utiliser des conditions strictes pour éviter toute fuite de données
        $messages = Message::with(['sender:id,name,email,role,prenom,nom,photo,last_seen', 'receiver:id,name,email,role,prenom,nom,photo,last_seen'])
            ->where(function($query) use ($user, $receiverId) {
                // Message envoyé par l'utilisateur connecté au destinataire
                $query->where(function($q) use ($user, $receiverId) {
                    $q->where('sender_id', $user->id)
                      ->where('receiver_id', $receiverId);
                })
                // OU message envoyé par le destinataire à l'utilisateur connecté
                ->orWhere(function($q) use ($user, $receiverId) {
                    $q->where('sender_id', $receiverId)
                      ->where('receiver_id', $user->id);
                });
            })
            ->orderBy('created_at', 'asc')
            ->get();
        
        // SÉCURITÉ : Vérification finale - s'assurer que tous les messages appartiennent bien à cette conversation
        $messages = $messages->filter(function($message) use ($user, $receiverId) {
            $isFromUser = $message->sender_id == $user->id && $message->receiver_id == $receiverId;
            $isToUser = $message->sender_id == $receiverId && $message->receiver_id == $user->id;
            return $isFromUser || $isToUser;
        })->values();
        
        $receiver->refresh(); // Ensure latest last_seen
        
        // Compter les messages non lus pour cette conversation
        $unreadCount = Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        return response()->json([
            'success' => true,
            'messages' => $messages,
            'receiver' => $receiver->only(['id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen']),
            'unread_count' => $unreadCount,
        ]);
    }

    public function getContacts()
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        // Récupérer tous les apprenants (role = 'student' ou null)
        $apprenants = User::where(function($q) {
                $q->where('role', 'student')->orWhereNull('role');
            })
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
        
        // Récupérer tous les professeurs (role = 'teacher')
        $professeurs = User::where('role', 'teacher')
            ->where('id', '!=', $user->id)
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role', 'last_seen')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();
        
        // Combiner tous les contacts autorisés
        $contactsAutorises = $apprenants->concat($professeurs);
        
        // Récupérer tous les messages où l'utilisateur est soit l'expéditeur soit le destinataire
        $messages = Message::with(['sender:id,name,email,role,prenom,nom,photo,last_seen', 'receiver:id,name,email,role,prenom,nom,photo,last_seen'])
            ->where(function($query) use ($user) {
                $query->where('sender_id', $user->id)
                      ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Construire les conversations
        $conversations = [];
        foreach($messages as $message) {
            $otherUserId = $message->sender_id == $user->id ? $message->receiver_id : $message->sender_id;
            if (!isset($conversations[$otherUserId])) {
                $conversations[$otherUserId] = [
                    'user' => $message->sender_id == $user->id ? $message->receiver : $message->sender,
                    'last_message' => $message,
                    'unread_count' => 0
                ];
            }
            if ($message->receiver_id == $user->id && !$message->read_at) {
                $conversations[$otherUserId]['unread_count']++;
            }
            if ($message->created_at > $conversations[$otherUserId]['last_message']->created_at) {
                $conversations[$otherUserId]['last_message'] = $message;
            }
        }
        
        // Ajouter tous les contacts autorisés qui n'ont pas encore de conversation
        foreach($contactsAutorises as $contact) {
            if (!isset($conversations[$contact->id])) {
                $conversations[$contact->id] = [
                    'user' => $contact,
                    'last_message' => null,
                    'unread_count' => 0
                ];
            }
        }
        
        // Trier par dernier message (les conversations avec messages en premier)
        uasort($conversations, function($a, $b) {
            if ($a['last_message'] && $b['last_message']) {
                return $b['last_message']->created_at <=> $a['last_message']->created_at;
            } elseif ($a['last_message']) {
                return -1;
            } elseif ($b['last_message']) {
                return 1;
            }
            // Si aucun n'a de message, trier par nom
            $nameA = ($a['user']->prenom ?? '') . ' ' . ($a['user']->nom ?? '');
            $nameB = ($b['user']->prenom ?? '') . ' ' . ($b['user']->nom ?? '');
            return strcmp($nameA, $nameB);
        });
        
        // Formater les conversations pour le JSON
        $formattedConversations = [];
        foreach($conversations as $otherUserId => $conversation) {
            $otherUser = $conversation['user'];
            $lastMessage = $conversation['last_message'];
            
            $formattedConversations[] = [
                'user_id' => $otherUserId,
                'user' => [
                    'id' => $otherUser->id,
                    'name' => $otherUser->name,
                    'prenom' => $otherUser->prenom,
                    'nom' => $otherUser->nom,
                    'email' => $otherUser->email,
                    'photo' => $otherUser->photo,
                    'role' => $otherUser->role,
                    'last_seen' => $otherUser->last_seen,
                ],
                'last_message' => $lastMessage ? [
                    'id' => $lastMessage->id,
                    'content' => $lastMessage->content,
                    'created_at' => $lastMessage->created_at->toISOString(),
                ] : null,
                'unread_count' => $conversation['unread_count'],
            ];
        }
        
        return response()->json([
            'success' => true,
            'conversations' => $formattedConversations,
        ]);
    }

    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        
        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }
        
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
        ]);
        
        $receiverId = $request->receiver_id;
        
        // SÉCURITÉ : Marquer uniquement les messages reçus par l'utilisateur connecté depuis ce destinataire
        $updated = Message::where('sender_id', $receiverId)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);
        
        // Calculer le nouveau nombre de messages non lus
        $totalUnread = Message::where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->count();
        
        return response()->json([
            'success' => true,
            'updated' => $updated,
            'total_unread' => $totalUnread,
        ]);
    }

    public function storeForumGroup(Request $request)
    {
        try {
            $user = Auth::user();

            // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
            if (!$user || $user->role !== 'admin') {
                return response()->json([
                    'success' => false,
                    'message' => 'Accès refusé. Seuls les administrateurs peuvent créer des groupes de forum.'
                ], 403);
            }

            \Log::info('Forum group creation attempt', [
                'user_id' => $user->id,
                'request_data' => $request->all()
            ]);

            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'user_ids' => 'required|array|min:1',
                'user_ids.*' => 'exists:users,id',
            ]);

            \Log::info('Validation passed, creating group');

            // Créer le groupe
            $group = ForumGroup::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => $user->id,
            ]);

            \Log::info('Group created', ['group_id' => $group->id]);

            // Ajouter le créateur et les utilisateurs sélectionnés
            $userIds = array_merge([$user->id], $request->user_ids);
            $group->users()->attach($userIds);

            \Log::info('Users attached to group');

            return response()->json([
                'success' => true,
                'message' => 'Groupe de forum créé avec succès.',
                'group' => $group->load('users'),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error creating forum group', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du groupe: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUsersForGroup()
    {
        $user = Auth::user();

        // SÉCURITÉ : Vérifier que l'utilisateur est bien authentifié et est un admin
        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'Accès refusé.'
            ], 403);
        }

        // Récupérer tous les utilisateurs (sauf l'admin actuel)
        $users = User::where('id', '!=', $user->id)
            ->select('id', 'name', 'prenom', 'nom', 'email', 'photo', 'role')
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return response()->json([
            'success' => true,
            'users' => $users,
        ]);
    }

    public function updateForumGroup(Request $request, ForumGroup $group)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'user_ids' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
            'restrict_messages' => 'nullable|in:0,1'
        ]);

        $group->name = $request->name;
        $group->description = $request->description;

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('group_avatars', 'public');
            $group->avatar = $path;
        }

        $group->save();

        // Sync users if provided
        $userIds = [];
        if ($request->filled('user_ids')) {
            $decoded = json_decode($request->user_ids, true);
            if (is_array($decoded)) {
                $userIds = array_map('intval', $decoded);
            }
        }

        if (!empty($userIds)) {
            $group->users()->sync($userIds);
        }

        // store restrict flag if group has such column (optional)
        if ($request->has('restrict_messages')) {
            if (in_array('restrict_messages', $group->getFillable())) {
                $group->restrict_messages = $request->restrict_messages;
                $group->save();
            }
        }

        $group->load('users:id,name,prenom,nom,email,photo');
        $group->refresh();

        return response()->json([
            'success' => true, 
            'group' => [
                'id' => $group->id,
                'name' => $group->name,
                'description' => $group->description,
                'avatar' => $group->avatar,
                'restrict_messages' => $group->restrict_messages ?? 0,
                'users' => $group->users->map(function($u) {
                    return [
                        'id' => $u->id,
                        'name' => $u->name,
                        'prenom' => $u->prenom,
                        'nom' => $u->nom,
                        'email' => $u->email,
                        'photo' => $u->photo
                    ];
                })
            ]
        ]);
    }

    public function removeMemberFromGroup(Request $request, ForumGroup $group)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        try {
            $userId = $request->user_id;
            
            // Prevent removing the creator
            if ($group->created_by == $userId) {
                return response()->json(['success' => false, 'message' => 'Le créateur du groupe ne peut pas être supprimé.'], 400);
            }

            // Remove user from group
            $group->users()->detach($userId);
            
            // Also remove from authorized users if exists
            \DB::table('forum_group_authorized_users')
                ->where('forum_group_id', $group->id)
                ->where('user_id', $userId)
                ->delete();

            return response()->json(['success' => true, 'message' => 'Membre supprimé du groupe avec succès.']);
        } catch (\Exception $e) {
            \Log::error('Error removing member from forum group', ['error' => $e->getMessage(), 'group_id' => $group->id]);
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression du membre.'], 500);
        }
    }

    public function getAuthorizedMembers(Request $request, ForumGroup $group)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        try {
            $authorizedUserIds = \DB::table('forum_group_authorized_users')
                ->where('forum_group_id', $group->id)
                ->pluck('user_id')
                ->toArray();

            return response()->json([
                'success' => true,
                'authorized_user_ids' => $authorizedUserIds
            ]);
        } catch (\Exception $e) {
            \Log::error('Error getting authorized members', ['error' => $e->getMessage(), 'group_id' => $group->id]);
            return response()->json(['success' => false, 'message' => 'Erreur lors de la récupération des permissions.'], 500);
        }
    }

    public function manageAuthorizedMembers(Request $request, ForumGroup $group)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        $request->validate([
            'authorized_user_ids' => 'nullable|array',
            'authorized_user_ids.*' => 'exists:users,id',
        ]);

        try {
            $authorizedUserIds = $request->authorized_user_ids ?? [];
            
            // Sync authorized users
            \DB::table('forum_group_authorized_users')
                ->where('forum_group_id', $group->id)
                ->delete();
            
            if (!empty($authorizedUserIds)) {
                $insertData = array_map(function($userId) use ($group) {
                    return [
                        'forum_group_id' => $group->id,
                        'user_id' => $userId,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }, $authorizedUserIds);
                
                \DB::table('forum_group_authorized_users')->insert($insertData);
            }

            return response()->json([
                'success' => true, 
                'message' => 'Permissions mises à jour avec succès.',
                'authorized_users' => $authorizedUserIds
            ]);
        } catch (\Exception $e) {
            \Log::error('Error managing authorized members', ['error' => $e->getMessage(), 'group_id' => $group->id]);
            return response()->json(['success' => false, 'message' => 'Erreur lors de la mise à jour des permissions.'], 500);
        }
    }

    public function destroyForumGroup(Request $request, ForumGroup $group)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'admin') {
            return response()->json(['success' => false, 'message' => 'Accès refusé.'], 403);
        }

        try {
            // Detach all users from the group to clean pivot table
            $group->users()->detach();
            
            // Delete authorized users
            \DB::table('forum_group_authorized_users')
                ->where('forum_group_id', $group->id)
                ->delete();
            
            // Optionally delete avatar file if stored (skipped here)
            $group->delete();

            return response()->json(['success' => true, 'message' => 'Groupe supprimé avec succès.']);
        } catch (\Exception $e) {
            \Log::error('Error deleting forum group', ['error' => $e->getMessage(), 'group_id' => $group->id]);
            return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression du groupe.'], 500);
        }
    }
}
