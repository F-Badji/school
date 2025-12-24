<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function sendContactForm(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'mf-text' => 'required|string|max:255',
            'mf-email' => 'required|email|max:255',
            'mf-telephone' => 'required|string|max:20',
            'mf-select' => 'required|string',
            'mf-textarea' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez remplir tous les champs correctement.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Récupérer les valeurs
        $nomComplet = $request->input('mf-text');
        $email = $request->input('mf-email');
        $telephone = $request->input('mf-telephone');
        $jeSuis = $request->input('mf-select');
        $message = $request->input('mf-textarea');

        // Mapper les valeurs du dropdown
        $jeSuisMap = [
            'value-1' => 'Etudiant',
            'value-2' => 'Professeur',
            'value-3' => 'Parent',
            'value-4' => 'Visiteur',
        ];
        $jeSuisLabel = $jeSuisMap[$jeSuis] ?? $jeSuis;

        try {
            // Envoyer l'email
            Mail::raw(
                "Nouveau message de contact depuis le site BJ Académie\n\n" .
                "Nom Complet: {$nomComplet}\n" .
                "Adresse E-mail: {$email}\n" .
                "Numéro de Téléphone: {$telephone}\n" .
                "Je suis: {$jeSuisLabel}\n\n" .
                "Message:\n{$message}",
                function ($message) use ($nomComplet, $email) {
                    $message->to('contact.bjacademie@gmail.com')
                            ->subject("Nouveau message de contact - {$nomComplet}")
                            ->replyTo($email, $nomComplet);
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'envoi de l\'email de contact', [
                'error' => $e->getMessage(),
                'data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.'
            ], 500);
        }
    }

    public function subscribeNewsletter(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Veuillez remplir tous les champs correctement.',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->input('email');

        try {
            // Envoyer l'email professionnel
            Mail::raw(
                "Nouvel abonnement à la newsletter - BJ Académie\n\n" .
                "Un nouvel utilisateur vient de s'abonner pour recevoir les dernières informations et actualités de Bj Académie.\n\n" .
                "Détails de l'abonnement :\n" .
                "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n" .
                "Adresse Email : {$email}\n" .
                "Date d'abonnement : " . now()->format('d/m/Y à H:i') . "\n" .
                "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n" .
                "Cet utilisateur souhaite recevoir :\n" .
                "• Les dernières informations de Bj Académie\n" .
                "• Les actualités et nouveautés\n" .
                "• Les mises à jour des programmes de formation\n\n" .
                "Vous pouvez répondre directement à cet email pour contacter l'abonné.",
                function ($message) use ($email) {
                    $message->to('contact.bjacademie@gmail.com')
                            ->subject("Nouvel abonnement newsletter - {$email}")
                            ->replyTo($email);
                }
            );

            return response()->json([
                'success' => true,
                'message' => 'Merci pour votre abonnement ! Vous recevrez désormais les dernières informations et actualités de Bj Académie.'
            ], 200);

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'abonnement newsletter', [
                'error' => $e->getMessage(),
                'email' => $email
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de votre abonnement. Veuillez réessayer plus tard.'
            ], 500);
        }
    }
}





