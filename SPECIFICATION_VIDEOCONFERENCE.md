# Spécification Technique : Système de Visioconférence Intégré

## 1. Vue d'ensemble

### 1.1 Objectif
Implémenter un système de visioconférence intégré à la plateforme éducative, permettant aux apprenants de rejoindre des sessions vidéo depuis l'interface "Mes cours" et offrant aux formateurs un contrôle complet sur la gestion des sessions.

### 1.2 Portée
Cette fonctionnalité doit offrir une expérience similaire à Google Meet, avec des mécanismes de contrôle d'accès et de gestion des participants adaptés au contexte éducatif.

---

## 2. Flux Utilisateur Principal

### 2.1 Point d'entrée
- **Localisation** : Interface Apprenant → Section "Mes cours"
- **Élément déclencheur** : Bouton "Accéder au cours" situé dans le bloc "Aperçu du cours"
- **Action** : Clic sur le bouton → Redirection automatique vers la session de visioconférence

### 2.2 Processus de connexion

#### Phase 1 : Demande d'accès
1. L'apprenant clique sur "Accéder au cours"
2. Le système redirige vers la page de visioconférence
3. L'apprenant est placé en état d'attente (salle d'attente virtuelle)
4. Une notification est envoyée au formateur concernant la demande d'accès

#### Phase 2 : Autorisation
- **Seul le formateur** peut accepter ou refuser l'entrée d'un apprenant
- Le formateur reçoit une notification avec les informations de l'apprenant (nom, photo de profil)
- Le formateur peut :
  - Accepter la demande → L'apprenant rejoint la session
  - Refuser la demande → L'apprenant reste en salle d'attente avec un message d'information

---

## 3. Fonctionnalités Apprenant

### 3.1 Contrôles de base
L'apprenant dispose des fonctionnalités suivantes une fois dans la session :

#### 3.1.1 Gestion du microphone
- **Activation/Désactivation** : Bouton toggle pour activer ou désactiver le microphone
- **Indicateur visuel** : Affichage de l'état (actif/inactif) avec icône appropriée
- **Demande d'autorisation** : Demande automatique d'autorisation navigateur lors de la première activation

#### 3.1.2 Gestion de la caméra
- **Activation/Désactivation** : Bouton toggle pour activer ou désactiver la caméra
- **Indicateur visuel** : Affichage de l'état (actif/inactif) avec icône appropriée
- **Demande d'autorisation** : Demande automatique d'autorisation navigateur lors de la première activation
- **Prévisualisation** : Affichage de la prévisualisation vidéo avant activation

#### 3.1.3 Quitter la session
- **Bouton de sortie** : Bouton "Quitter l'appel" visible en permanence
- **Confirmation** : Modal de confirmation avant de quitter définitivement la session
- **Action** : Déconnexion immédiate et retour à la page précédente

### 3.2 Affichage des participants
- **Liste des participants** : Panneau latéral affichant tous les participants présents dans la session
- **Informations affichées** :
  - Nom complet
  - Photo de profil (ou initiales)
  - Statut (micro/caméra actif/inactif)
  - Indicateur de rôle (Formateur/Apprenant)

---

## 4. Fonctionnalités Formateur (Hôte)

### 4.1 Contrôle d'accès
Le formateur dispose de droits exclusifs pour gérer les participants :

#### 4.1.1 Gestion des demandes d'accès
- **Notification en temps réel** : Alerte visuelle et sonore lors d'une nouvelle demande
- **Panneau de gestion** : Interface dédiée listant toutes les demandes en attente
- **Actions disponibles** :
  - **Accepter** : Permet à l'apprenant de rejoindre la session
  - **Refuser** : Rejette la demande avec possibilité d'ajouter un message

### 4.2 Contrôle des participants actifs

#### 4.2.1 Gestion du microphone
- **Coupure à distance** : Le formateur peut désactiver le microphone d'un apprenant
- **Réactivation** : Possibilité de réactiver le microphone d'un apprenant
- **Notification** : L'apprenant est informé lorsque son microphone est coupé par le formateur

#### 4.2.2 Gestion de la caméra
- **Désactivation à distance** : Le formateur peut désactiver la caméra d'un apprenant
- **Réactivation** : Possibilité de réactiver la caméra d'un apprenant
- **Notification** : L'apprenant est informé lorsque sa caméra est désactivée par le formateur

#### 4.2.3 Expulsion de participants
- **Bouton d'expulsion** : Option disponible pour chaque participant (sauf le formateur)
- **Confirmation** : Modal de confirmation avant expulsion
- **Action** : L'apprenant est immédiatement déconnecté et ne peut pas rejoindre la session sans nouvelle autorisation

### 4.3 Droits d'hôte
- **Contrôle total** : Le formateur conserve tous les droits de contrôle même après avoir accordé l'accès
- **Gestion de session** : Possibilité de mettre fin à la session pour tous les participants
- **Enregistrement** : Option pour enregistrer la session (fonctionnalité future)

---

## 5. Spécifications Techniques

### 5.1 Technologies recommandées
- **WebRTC** : Pour la communication peer-to-peer
- **Socket.IO** : Pour la communication en temps réel (notifications, contrôle)
- **MediaStream API** : Pour l'accès aux périphériques audio/vidéo
- **Backend** : Laravel (framework existant) pour la gestion des sessions et autorisations

### 5.2 Architecture proposée
```
Interface Apprenant (Mes cours)
    ↓
Bouton "Accéder au cours"
    ↓
Page de visioconférence
    ↓
Salle d'attente (si non autorisé)
    ↓
Session vidéo active (si autorisé)
```

### 5.3 Sécurité et permissions
- **Authentification requise** : Seuls les utilisateurs authentifiés peuvent accéder
- **Vérification des rôles** : Distinction claire entre formateur et apprenant
- **Contrôle d'accès** : Validation côté serveur pour toutes les actions de contrôle
- **Chiffrement** : Communication chiffrée pour la vidéo/audio (WebRTC natif)

---

## 6. Interface Utilisateur

### 6.1 Vue Apprenant
- **Vue principale** : Grille de vidéos des participants
- **Contrôles** : Barre d'outils en bas avec boutons micro/caméra/quitter
- **Panneau latéral** : Liste des participants avec statuts
- **Indicateurs** : Badges visuels pour l'état du micro/caméra

### 6.2 Vue Formateur
- **Vue principale** : Identique à l'apprenant avec contrôles supplémentaires
- **Panneau de gestion** : Section dédiée pour les demandes d'accès
- **Contrôles avancés** : Menu contextuel sur chaque participant avec options de contrôle
- **Indicateurs** : Badge "Hôte" visible pour le formateur

---

## 7. Cas d'usage

### 7.1 Scénario 1 : Connexion réussie
1. Apprenant clique sur "Accéder au cours"
2. Redirection vers la page de visioconférence
3. Demande d'autorisation envoyée au formateur
4. Formateur accepte la demande
5. Apprenant rejoint la session avec micro/caméra désactivés par défaut
6. Apprenant active ses périphériques après autorisation navigateur

### 7.2 Scénario 2 : Refus d'accès
1. Apprenant clique sur "Accéder au cours"
2. Redirection vers la page de visioconférence
3. Demande d'autorisation envoyée au formateur
4. Formateur refuse la demande
5. Apprenant voit un message : "Votre demande d'accès a été refusée. Veuillez contacter le formateur."

### 7.3 Scénario 3 : Contrôle par le formateur
1. Apprenant est dans la session avec micro activé
2. Formateur coupe le micro de l'apprenant
3. Apprenant reçoit une notification : "Votre microphone a été désactivé par le formateur"
4. L'apprenant ne peut pas réactiver son micro (contrôle désactivé)

---

## 8. Points d'attention

### 8.1 Performance
- Optimisation de la bande passante (qualité vidéo adaptative)
- Limitation du nombre de participants simultanés si nécessaire
- Gestion des déconnexions réseau

### 8.2 Compatibilité
- Support des navigateurs modernes (Chrome, Firefox, Safari, Edge)
- Détection des périphériques disponibles
- Fallback si WebRTC n'est pas supporté

### 8.3 Expérience utilisateur
- Messages d'erreur clairs et informatifs
- Indicateurs de chargement pendant la connexion
- Feedback visuel pour toutes les actions

---

## 9. Évolutions futures possibles

- Partage d'écran
- Chat textuel pendant la session
- Enregistrement des sessions
- Tableau blanc collaboratif
- Salles de discussion (breakout rooms)
- Statistiques de participation

---

**Document rédigé le** : {{ date }}
**Version** : 1.0
**Statut** : Spécification initiale







