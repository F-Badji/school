# Guide d'Installation - Système de Visioconférence

## ✅ Fonctionnalités Implémentées

### 1. **WebRTC - Connexion Peer-to-Peer**
- ✅ Accès aux médias (caméra et microphone)
- ✅ Contrôle local de la vidéo/audio
- ✅ Partage d'écran
- ⚠️ **Note**: Pour une connexion peer-to-peer complète entre participants, un serveur de signalisation WebRTC est nécessaire (ex: Simple-Peer, Socket.IO pour la signalisation)

### 2. **Socket.IO / Laravel Broadcasting**
- ✅ Événements configurés (ParticipantJoined, ParticipantLeft, StatusChanged, ChatMessage)
- ✅ Canaux privés configurés
- ✅ Support Pusher (prêt à l'emploi)
- ⚠️ **Configuration requise**: Ajouter les clés Pusher dans `.env`

### 3. **Partage d'écran**
- ✅ Bouton de partage d'écran dans les vues apprenant et formateur
- ✅ Utilisation de l'API `getDisplayMedia()`
- ✅ Arrêt automatique du partage

### 4. **Chat textuel**
- ✅ Interface de chat complète
- ✅ Envoi et réception de messages en temps réel
- ✅ Historique des messages
- ✅ Messages persistants en base de données

## 📋 Configuration Requise

### 1. Variables d'environnement (.env)

Pour activer les notifications en temps réel avec Pusher, ajoutez dans votre fichier `.env`:

```env
BROADCAST_CONNECTION=pusher

PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=mt1
```

**Alternative (gratuite)**: Utiliser Laravel Reverb (inclus dans Laravel 11+) ou Soketi (alternative open-source à Pusher).

### 2. Installation des dépendances

Les dépendances sont déjà installées :
- ✅ `pusher/pusher-php-server` (Composer)
- ✅ `pusher-js`, `laravel-echo`, `socket.io-client` (NPM)

### 3. Migration de la base de données

Les migrations ont été exécutées :
- ✅ `video_sessions`
- ✅ `video_session_participants`
- ✅ `video_session_chat_messages`

## 🚀 Utilisation

### Pour les Apprenants

1. Accéder à la section "Mes cours"
2. Cliquer sur "Accéder au cours" dans le bloc "Aperçu du cours"
3. Attendre l'autorisation du formateur (salle d'attente)
4. Une fois accepté :
   - Activer/désactiver le micro
   - Activer/désactiver la caméra
   - Partager l'écran
   - Utiliser le chat
   - Quitter la session

### Pour les Formateurs

1. Accéder à "Mes cours"
2. Cliquer sur "Visioconférence" pour un cours
3. Gérer les participants :
   - Accepter/refuser les demandes d'accès
   - Couper le micro d'un apprenant
   - Désactiver la caméra d'un apprenant
   - Expulser un apprenant
4. Utiliser le chat
5. Partager l'écran
6. Terminer la session

## 🔧 Configuration Avancée

### Activer Pusher (Notifications en temps réel)

1. Créer un compte sur [pusher.com](https://pusher.com) (gratuit jusqu'à 200k messages/jour)
2. Créer une nouvelle app
3. Copier les clés dans `.env`
4. Dans les vues, changer `usePusher = false` à `usePusher = true`

### Alternative : Utiliser Soketi (gratuit, auto-hébergé)

```bash
npm install -g @soketi/soketi
soketi start
```

Puis dans `.env`:
```env
BROADCAST_CONNECTION=pusher
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_ID=app-id
PUSHER_APP_KEY=app-key
PUSHER_APP_SECRET=app-secret
```

## 📝 Notes Techniques

### WebRTC Peer-to-Peer

Le système actuel utilise WebRTC pour l'accès local aux médias. Pour une connexion peer-to-peer complète entre tous les participants, il faudrait :

1. **Serveur de signalisation** : WebSocket/Socket.IO pour échanger les offres/réponses WebRTC
2. **STUN/TURN servers** : Pour le NAT traversal (ex: Google STUN, ou serveur TURN personnalisé)

**Solution recommandée** : Utiliser une bibliothèque comme `simple-peer` ou `peerjs` qui gère automatiquement la signalisation.

### Architecture Actuelle

- **Vidéo locale** : WebRTC (getUserMedia, getDisplayMedia)
- **Notifications** : Laravel Broadcasting + Pusher/Soketi
- **Chat** : Laravel Broadcasting + Base de données
- **Contrôles** : API REST + Broadcasting pour synchronisation

## 🐛 Dépannage

### Les notifications en temps réel ne fonctionnent pas

1. Vérifier que `BROADCAST_CONNECTION=pusher` dans `.env`
2. Vérifier les clés Pusher
3. Vérifier que `usePusher = true` dans les vues JavaScript
4. Vérifier la console du navigateur pour les erreurs

### Le partage d'écran ne fonctionne pas

- Vérifier que le navigateur supporte `getDisplayMedia()` (Chrome, Firefox, Edge)
- Vérifier les permissions du navigateur

### Les messages de chat ne s'affichent pas

- Vérifier la console du navigateur
- Vérifier que les routes sont correctes
- Vérifier les permissions de la base de données

## 📚 Documentation

- [Laravel Broadcasting](https://laravel.com/docs/broadcasting)
- [Pusher Documentation](https://pusher.com/docs)
- [WebRTC API](https://developer.mozilla.org/en-US/docs/Web/API/WebRTC_API)
- [getDisplayMedia API](https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices/getDisplayMedia)







