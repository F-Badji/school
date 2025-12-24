# Configuration Gmail pour l'envoi d'emails

## Étapes pour configurer Gmail SMTP

### 1. Créer un mot de passe d'application Gmail

1. Allez sur https://myaccount.google.com/
2. Cliquez sur "Sécurité" dans le menu de gauche
3. Activez la "Validation en deux étapes" si ce n'est pas déjà fait
4. Allez dans "Mots de passe des applications"
5. Sélectionnez "Autre (nom personnalisé)" et entrez "BJ Académie Laravel"
6. Cliquez sur "Générer"
7. **Copiez le mot de passe généré** (vous ne pourrez plus le voir après)

### 2. Configurer le fichier .env

Ajoutez ou modifiez ces lignes dans votre fichier `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-mot-de-passe-application
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=votre-email@gmail.com
MAIL_FROM_NAME="BJ Académie"
```

**Important :**
- `MAIL_USERNAME` : Votre adresse Gmail complète
- `MAIL_PASSWORD` : Le mot de passe d'application généré (pas votre mot de passe Gmail normal)
- `MAIL_FROM_ADDRESS` : La même adresse que MAIL_USERNAME

### 3. Vérifier la configuration

Après avoir modifié le `.env`, exécutez :
```bash
php artisan config:clear
php artisan cache:clear
```

### 4. Tester l'envoi

Testez le formulaire de contact sur le site. Les emails seront envoyés à `contact.bjacademie@gmail.com`.





