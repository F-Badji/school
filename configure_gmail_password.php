<?php

/**
 * Script pour configurer le mot de passe Gmail dans .env
 * Usage : php configure_gmail_password.php
 */

$envFile = __DIR__ . '/.env';

if (!file_exists($envFile)) {
    die("❌ Le fichier .env n'existe pas.\n");
}

echo "\n";
echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║     CONFIGURATION DU MOT DE PASSE GMAIL                   ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";

echo "📋 INSTRUCTIONS :\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "1. Allez sur : https://myaccount.google.com/apppasswords\n";
echo "   (Ou : Sécurité > Mots de passe des applications)\n\n";
echo "2. Si vous ne voyez pas cette option, activez d'abord :\n";
echo "   → Validation en deux étapes\n\n";
echo "3. Sélectionnez 'Autre (nom personnalisé)'\n";
echo "4. Nom : 'BJ Académie Laravel'\n";
echo "5. Cliquez sur 'Générer'\n";
echo "6. COPIEZ le mot de passe de 16 caractères\n\n";

echo "─────────────────────────────────────────────────────────────\n\n";

echo "🔑 Entrez le mot de passe d'application (16 caractères) :\n";
echo "   → Vous pouvez coller avec espaces, ils seront supprimés automatiquement\n";
echo "   → Exemple : abcd efgh ijkl mnop\n\n";
echo "Mot de passe : ";

// Lire le mot de passe (masqué pour la sécurité)
$password = trim(fgets(STDIN));

// Supprimer les espaces du mot de passe
$password = str_replace(' ', '', $password);

if (empty($password)) {
    die("\n❌ Erreur : Le mot de passe ne peut pas être vide.\n");
}

if (strlen($password) < 16) {
    die("\n❌ Erreur : Le mot de passe doit contenir au moins 16 caractères.\n   Vous avez entré : " . strlen($password) . " caractères.\n");
}

// Lire le contenu actuel
$envContent = file_get_contents($envFile);

// Remplacer MAIL_PASSWORD
$pattern = "/^MAIL_PASSWORD=.*/m";
$replacement = "MAIL_PASSWORD={$password}";

if (preg_match($pattern, $envContent)) {
    $envContent = preg_replace($pattern, $replacement, $envContent);
} else {
    $envContent .= "\nMAIL_PASSWORD={$password}";
}

// Écrire le fichier
file_put_contents($envFile, $envContent);

echo "\n";
echo "✅ Mot de passe configuré avec succès dans .env !\n\n";

echo "🔄 Vidage du cache de configuration...\n";
exec('php artisan config:clear 2>&1', $output, $returnCode);
if ($returnCode === 0) {
    echo "✅ Cache vidé avec succès !\n\n";
} else {
    echo "⚠️  Erreur lors du vidage du cache.\n";
    echo "   Exécutez manuellement : php artisan config:clear\n\n";
}

echo "╔═══════════════════════════════════════════════════════════╗\n";
echo "║     ✅ CONFIGURATION TERMINÉE !                           ║\n";
echo "╚═══════════════════════════════════════════════════════════╝\n\n";
echo "📧 Les emails du formulaire de contact seront maintenant\n";
echo "   envoyés à : contact.bjacademie@gmail.com\n\n";
echo "🧪 Pour tester :\n";
echo "   1. Allez sur http://localhost:8000\n";
echo "   2. Remplissez le formulaire de contact\n";
echo "   3. Cliquez sur 'ENVOYER LE MESSAGE'\n";
echo "   4. Vérifiez votre boîte email : contact.bjacademie@gmail.com\n\n";

