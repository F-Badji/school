<?php

/**
 * Script de configuration Gmail pour BJ Académie
 * 
 * Ce script configure automatiquement Gmail dans le fichier .env
 * 
 * IMPORTANT : Vous devez d'abord créer un mot de passe d'application Gmail :
 * 1. Allez sur https://myaccount.google.com/
 * 2. Sécurité > Validation en deux étapes (activez-la si nécessaire)
 * 3. Mots de passe des applications > Générer un nouveau mot de passe
 * 4. Copiez le mot de passe de 16 caractères généré
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    die("❌ Le fichier .env n'existe pas. Veuillez le créer d'abord.\n");
}

// Lire le contenu actuel du .env
$envContent = file_get_contents($envFile);

// Configuration Gmail
$gmailConfig = [
    'MAIL_MAILER' => 'smtp',
    'MAIL_HOST' => 'smtp.gmail.com',
    'MAIL_PORT' => '587',
    'MAIL_USERNAME' => 'contact.bjacademie@gmail.com',
    'MAIL_PASSWORD' => '', // À remplir manuellement avec le mot de passe d'application
    'MAIL_ENCRYPTION' => 'tls',
    'MAIL_FROM_ADDRESS' => 'contact.bjacademie@gmail.com',
    'MAIL_FROM_NAME' => 'BJ Académie',
];

// Fonction pour mettre à jour ou ajouter une variable dans .env
function updateEnvVariable($content, $key, $value) {
    $pattern = "/^{$key}=.*/m";
    $replacement = "{$key}={$value}";
    
    if (preg_match($pattern, $content)) {
        // Variable existe, la remplacer
        return preg_replace($pattern, $replacement, $content);
    } else {
        // Variable n'existe pas, l'ajouter
        return $content . "\n{$replacement}";
    }
}

// Mettre à jour toutes les variables
foreach ($gmailConfig as $key => $value) {
    if ($key === 'MAIL_PASSWORD' && empty($value)) {
        // Ne pas écraser le mot de passe s'il existe déjà
        if (!preg_match("/^MAIL_PASSWORD=.*/m", $envContent)) {
            $envContent = updateEnvVariable($envContent, $key, 'VOTRE_MOT_DE_PASSE_APPLICATION_ICI');
        }
    } else {
        $envContent = updateEnvVariable($envContent, $key, $value);
    }
}

// Écrire le fichier .env
file_put_contents($envFile, $envContent);

echo "✅ Configuration Gmail ajoutée dans .env\n";
echo "\n";
echo "⚠️  IMPORTANT : Vous devez maintenant :\n";
echo "1. Créer un mot de passe d'application Gmail sur https://myaccount.google.com/\n";
echo "2. Remplacer 'VOTRE_MOT_DE_PASSE_APPLICATION_ICI' dans .env par le mot de passe généré\n";
echo "3. Exécuter : php artisan config:clear\n";
echo "\n";





