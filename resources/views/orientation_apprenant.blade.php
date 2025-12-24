<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Étape d'Orientation — BJ Académie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #f8f9fa;
            color: #212529;
            line-height: 1.6;
            position: relative;
            min-height: 100vh;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/assets/images/Contact.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            opacity: 0.55;
            z-index: 0;
            pointer-events: none;
        }
        
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(248, 249, 250, 0.55);
            z-index: 1;
            pointer-events: none;
        }
        
        .container-orientation {
            max-width: 800px;
            margin: 0 auto;
            padding: 3rem 1.5rem;
            position: relative;
            z-index: 2;
        }
        
        .header-orientation {
            text-align: center;
            margin-bottom: 3rem;
            padding-bottom: 2rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .header-orientation h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .header-orientation p {
            font-size: 1rem;
            color: #6c757d;
        }
        
        .card {
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 2rem;
            overflow: hidden;
        }
        
        .card-header {
            background: #f8f9fa;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
        }
        
        .card-header h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #212529;
            margin: 0;
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }
        
        .info-item {
            padding: 1rem;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 6px;
        }
        
        .info-item label {
            display: block;
            font-size: 0.75rem;
            color: #6c757d;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-item .value {
            font-size: 0.9375rem;
            color: #212529;
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group:last-child {
            margin-bottom: 0;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            color: #212529;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .form-group label .required {
            color: #dc3545;
            margin-left: 0.25rem;
        }
        
        .form-control {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 0.9375rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            font-family: 'Inter', sans-serif;
            background: #ffffff;
            color: #212529;
        }
        
        .form-control::placeholder {
            color: #adb5bd;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #065b32;
            box-shadow: 0 0 0 3px rgba(6, 91, 50, 0.1);
        }
        
        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }
        
        select.form-control {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23495057'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 1.25em;
            padding-right: 2.5rem;
        }
        
        select.form-control:disabled {
            background-color: #e9ecef;
            cursor: not-allowed;
            color: #6c757d;
        }
        
        .btn-primary {
            background: #065b32;
            color: white;
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease;
            width: 100%;
        }
        
        .btn-primary:hover:not(:disabled) {
            background: #054a28;
        }
        
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background: #6c757d;
        }
        
        .paiement-info {
            background: #fff3cd;
            padding: 1.5rem;
            border-radius: 6px;
            border: 1px solid #ffc107;
            margin-bottom: 1.5rem;
            text-align: center;
        }
        
        .paiement-info h3 {
            color: #856404;
            font-size: 1rem;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .paiement-info .montant {
            font-size: 2rem;
            font-weight: 700;
            color: #856404;
            margin: 0.5rem 0;
        }
        
        .paiement-info p {
            color: #856404;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .payment-methods {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1rem;
        }
        
        .payment-method {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            border: 2px solid #dee2e6;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            background: #ffffff;
            text-decoration: none;
            color: inherit;
            min-height: 140px;
            position: relative;
        }
        
        .payment-method.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }
        
        .payment-method:hover:not(.disabled) {
            border-color: #065b32;
            background: #f8f9fa;
        }
        
        .payment-method.active {
            border-color: #065b32;
            background: #f0f9f4;
        }
        
        .payment-method.active::after {
            content: '✓';
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            width: 24px;
            height: 24px;
            background: #065b32;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 0.875rem;
        }
        
        .payment-method img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 0.75rem;
        }
        
        .payment-label {
            font-weight: 600;
            color: #212529;
            font-size: 0.875rem;
        }
        
        .payment-method.active .payment-label {
            color: #065b32;
        }
        
        .niveau-auto {
            background: #f8f9fa;
            padding: 1.25rem;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            text-align: center;
        }
        
        .niveau-auto .label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .niveau-auto .value {
            font-size: 1.125rem;
            font-weight: 600;
            color: #065b32;
        }
        
        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .payment-note {
            margin-top: 1rem;
            padding: 1rem;
            background: #d1ecf1;
            border-radius: 6px;
            border-left: 4px solid #0c5460;
        }
        
        .payment-note p {
            margin: 0;
            font-size: 0.875rem;
            color: #0c5460;
            line-height: 1.5;
        }
        
        .payment-note p strong {
            font-weight: 600;
        }
        
        #motivation-counter {
            color: #6c757d;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }
        
        .readonly-field {
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 1rem 1.25rem;
            background: rgba(248, 249, 250, 0.85);
            color: #212529;
        }
        
        .readonly-field .readonly-label {
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 0.35rem;
        }
        
        .readonly-field .readonly-value {
            font-size: 1rem;
            font-weight: 600;
            color: #111827;
            white-space: pre-wrap;
            word-break: break-word;
        }
        
        /* SÉCURITÉ : Styles pour formulaire verrouillé */
        form[data-locked="true"] {
            position: relative;
        }
        
        form[data-locked="true"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.5);
            z-index: 1000;
            pointer-events: all;
            cursor: not-allowed;
        }
        
        form[data-locked="true"] input,
        form[data-locked="true"] textarea,
        form[data-locked="true"] select,
        form[data-locked="true"] button {
            pointer-events: none !important;
            cursor: not-allowed !important;
            opacity: 0.6 !important;
            user-select: none !important;
        }
        
        @media (max-width: 768px) {
            .container-orientation {
                padding: 2rem 1rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
            
            .payment-methods {
                grid-template-columns: 1fr;
            }
            
            .header-orientation h1 {
                font-size: 1.75rem;
            }
        }
        
        @keyframes slideInDown {
            from {
                transform: translateX(-50%) translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateX(-50%) translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
<body>
    @php
        // Utiliser la variable passée par le contrôleur (ne pas redéfinir)
        // Le contrôleur vérifie déjà toutes les conditions nécessaires
    @endphp
    <div class="container-orientation">
        <div class="header-orientation">
            <h1>Étape d'Orientation</h1>
            <p>Complétez votre profil pour finaliser votre inscription</p>
        </div>
        
        @php
            $paiementMethod = $user->paiement_method ?? null;
            // L'alerte ne doit s'afficher que si l'utilisateur a complété son orientation
            // Vérifier que l'utilisateur a choisi une filière, un mode de paiement, une motivation ET a une date d'orientation
            // Cela garantit qu'il a bien soumis le formulaire d'orientation
            $hasCompletedOrientation = !empty($user->filiere) && 
                                      !empty($user->paiement_method) && 
                                      !empty($user->motivation) && 
                                      !empty($user->date_orientation);
            
            // SÉCURITÉ : Vérifier aussi que paiement_statut n'est pas null (nouvel utilisateur)
            $hasPaymentStatus = !is_null($user->paiement_statut) && $user->paiement_statut !== '';
            
            // L'alerte s'affiche seulement si :
            // 1. Il y a une session flash (payment_pending, etc.) ET l'orientation est complétée ET le statut de paiement existe
            // 2. OU le paiement est en attente ET l'orientation est complétée ET le statut de paiement existe
            $showAlert = (session('payment_pending') || session('orange_money_pending') || session('payment_success')) && $hasCompletedOrientation && $hasPaymentStatus;
            $showAlert = $showAlert || ($user->paiement_statut === 'en attente' && $hasCompletedOrientation && $hasPaymentStatus);
        @endphp
        
        @if($showAlert)
            @if(strtolower($paiementMethod) === 'orange money' || $paiementMethod === 'Orange Money')
            <!-- Alerte pour Orange Money -->
            <div class="alert alert-warning-fixed" id="payment-pending-alert" style="display: block !important; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 600px; width: 90%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.25rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); animation: slideInDown 0.5s ease-out;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; margin-top: 0.125rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.125rem; margin-bottom: 0.5rem; font-weight: 600;">En attente de validation de l'administrateur</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.6; opacity: 0.95;">Votre demande d'inscription avec paiement Orange Money a été enregistrée avec succès. Votre inscription est actuellement en attente de validation par l'administrateur. Vous recevrez une notification par email ou par WhatsApp une fois votre inscription validée et votre paiement confirmé.</p>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <a href="{{ route('home') }}" style="background: #065b32; color: white; padding: 0.625rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background-color 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Aller vers la page d'accueil
                    </a>
                </div>
            </div>
            @elseif(strtolower($paiementMethod) === 'wave' || $paiementMethod === 'Wave')
            <!-- Alerte pour Wave -->
            <div class="alert alert-warning-fixed" id="payment-pending-alert" style="display: block !important; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 600px; width: 90%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.25rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); animation: slideInDown 0.5s ease-out;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; margin-top: 0.125rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.125rem; margin-bottom: 0.5rem; font-weight: 600;">En attente de validation de l'administrateur</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.6; opacity: 0.95;">Votre demande d'inscription avec paiement Wave a été enregistrée avec succès. Votre inscription est actuellement en attente de validation par l'administrateur. Vous recevrez une notification par email ou par WhatsApp une fois votre inscription validée et votre paiement confirmé.</p>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <a href="{{ route('home') }}" style="background: #065b32; color: white; padding: 0.625rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background-color 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Aller vers la page d'accueil
                    </a>
                </div>
            </div>
            @elseif($paiementMethod === 'yass' || strtolower($paiementMethod) === 'yass')
            <!-- Alerte pour Mixx By Yass -->
            <div class="alert alert-warning-fixed" id="payment-pending-alert" style="display: block !important; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 600px; width: 90%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.25rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); animation: slideInDown 0.5s ease-out;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; margin-top: 0.125rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.125rem; margin-bottom: 0.5rem; font-weight: 600;">En attente de validation de l'administrateur</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.6; opacity: 0.95;">Votre demande d'inscription avec paiement Mixx By Yass a été enregistrée avec succès. Votre inscription est actuellement en attente de validation par l'administrateur. Vous recevrez une notification par email ou par WhatsApp une fois votre inscription validée et votre paiement confirmé.</p>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <a href="{{ route('home') }}" style="background: #065b32; color: white; padding: 0.625rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background-color 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Aller vers la page d'accueil
                    </a>
                </div>
            </div>
            @elseif($paiementMethod === 'paypal' || strtolower($paiementMethod) === 'paypal')
            <!-- Alerte pour PayPal -->
            <div class="alert alert-warning-fixed" id="payment-pending-alert" style="display: block !important; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 600px; width: 90%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.25rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); animation: slideInDown 0.5s ease-out;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; margin-top: 0.125rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.125rem; margin-bottom: 0.5rem; font-weight: 600;">En attente de validation de l'administrateur</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.6; opacity: 0.95;">Votre demande d'inscription avec paiement PayPal a été enregistrée avec succès. Votre inscription est actuellement en attente de validation par l'administrateur. Vous recevrez une notification par email ou par WhatsApp une fois votre inscription validée et votre paiement confirmé.</p>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <a href="{{ route('home') }}" style="background: #065b32; color: white; padding: 0.625rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background-color 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Aller vers la page d'accueil
                    </a>
                </div>
            </div>
            @else
            <!-- Alerte générique pour les autres modes de paiement -->
            <div class="alert alert-warning-fixed" id="payment-pending-alert" style="display: block !important; position: fixed; top: 20px; left: 50%; transform: translateX(-50%); z-index: 9999; max-width: 600px; width: 90%; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 1.25rem 1.5rem; border-radius: 12px; box-shadow: 0 10px 25px rgba(245, 158, 11, 0.3); animation: slideInDown 0.5s ease-out;">
                <div style="display: flex; align-items: flex-start; gap: 1rem;">
                    <svg style="width: 1.5rem; height: 1.5rem; flex-shrink: 0; margin-top: 0.125rem;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div style="flex: 1;">
                        <strong style="display: block; font-size: 1.125rem; margin-bottom: 0.5rem; font-weight: 600;">En attente de validation de l'administrateur</strong>
                        <p style="margin: 0; font-size: 0.9375rem; line-height: 1.6; opacity: 0.95;">Votre demande d'inscription avec paiement {{ $user->paiement_method ?? 'sélectionné' }} a été enregistrée avec succès. Votre inscription est actuellement en attente de validation par l'administrateur. Vous recevrez une notification par email ou par WhatsApp une fois votre inscription validée et votre paiement confirmé.</p>
                    </div>
                </div>
                <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                    <a href="{{ route('home') }}" style="background: #065b32; color: white; padding: 0.625rem 1.25rem; border-radius: 6px; text-decoration: none; font-weight: 600; font-size: 0.875rem; transition: background-color 0.15s ease; display: inline-flex; align-items: center; gap: 0.5rem; white-space: nowrap;">
                        <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Aller vers la page d'accueil
                    </a>
                </div>
            </div>
            @endif
        @endif
        
        @if($orientationLocked)
        <div class="readonly-field" style="margin-top: 4.5rem; margin-bottom: 1.5rem; background: rgba(255, 255, 255, 0.92);">
            <div class="readonly-value" style="font-weight: 500; font-size: 0.95rem;">
                Vos informations d'orientation et de paiement ont été enregistrées et sont en cours de vérification. Elles ne peuvent plus être modifiées. Pour toute modification ou question, veuillez contacter l'administrateur via la page d'accueil.
            </div>
        </div>
        @endif
        
        <form method="POST" action="{{ route('orientation.store') }}" id="orientationForm" data-locked="{{ $orientationLocked ? 'true' : 'false' }}" @if($orientationLocked) onsubmit="return false;" style="pointer-events: none; opacity: 0.7;" @endif>
            @csrf
            @if($orientationLocked)
                <!-- Protection anti-fraude : champ caché pour empêcher la soumission -->
                <input type="hidden" name="form_locked" value="1">
            @endif
            
            <!-- Section 1: Informations personnelles -->
            <div class="card">
                <div class="card-header">
                    <h2>Informations Personnelles</h2>
                </div>
                <div class="card-body">
                    <div class="info-grid">
                        <div class="info-item">
                            <label>Nom</label>
                            <div class="value">{{ $user->nom }}</div>
                        </div>
                        <div class="info-item">
                            <label>Prénom</label>
                            <div class="value">{{ $user->prenom }}</div>
                        </div>
                        <div class="info-item">
                            <label>Adresse e-mail</label>
                            <div class="value">{{ $user->email }}</div>
                        </div>
                        <div class="info-item">
                            <label>Date d'inscription</label>
                            <div class="value">{{ $user->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Section 2: Informations complémentaires -->
            <div class="card">
                <div class="card-header">
                    <h2>Informations Complémentaires</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            Pourquoi souhaitez-vous suivre ces cours ?
                            <span class="required">*</span>
                        </label>
                        @if($orientationLocked)
                            <div class="readonly-field">
                                <div class="readonly-label">Réponse enregistrée</div>
                                <div class="readonly-value">{{ $user->motivation ?? 'Non renseigné' }}</div>
                            </div>
                        @else
                        <textarea 
                            name="motivation" 
                            id="motivation"
                            class="form-control" 
                            required 
                            minlength="10" 
                                maxlength="200"
                            placeholder="Décrivez vos motivations..."
                            rows="5"
                            >{{ old('motivation', $user->motivation) }}</textarea>
                            <div id="motivation-counter" class="text-sm mt-1">
                                <span id="motivation-count">0</span> / 200 caractères maximum
                        </div>
                        @error('motivation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>
                            Comment avez-vous entendu parler de cette formation ?
                            <span class="required">*</span>
                        </label>
                        @if($orientationLocked)
                            <div class="readonly-field">
                                <div class="readonly-label">Canal de découverte enregistré</div>
                                <div class="readonly-value">{{ $user->canal_decouverte ?? 'Non renseigné' }}</div>
                            </div>
                        @else
                        <select name="canal_decouverte" id="canal_decouverte" class="form-control" required>
                            <option value="">-- Sélectionnez une option --</option>
                            @foreach($canaux as $canal)
                                    <option value="{{ $canal }}" {{ old('canal_decouverte', $user->canal_decouverte) === $canal ? 'selected' : '' }}>
                                    {{ $canal }}
                                </option>
                            @endforeach
                        </select>
                        @error('canal_decouverte')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Section 3: Choix du domaine de formation -->
            <div class="card">
                <div class="card-header">
                    <h2>Choix du Domaine de Formation</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label>
                            Catégorie de formation
                            <span class="required">*</span>
                        </label>
                        @if($orientationLocked)
                            <div class="readonly-field">
                                <div class="readonly-label">Catégorie sélectionnée</div>
                                <div class="readonly-value">{{ $user->categorie_formation ?? 'Informatique' }}</div>
                            </div>
                        @else
                        <select name="categorie_formation" id="categorie_formation" class="form-control" required>
                            <option value="">-- Sélectionnez une catégorie --</option>
                            @foreach($categories as $categorie => $filieres)
                                    <option value="{{ $categorie }}" {{ old('categorie_formation', $user->categorie_formation) === $categorie ? 'selected' : '' }}>
                                    {{ $categorie }}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_formation')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        @endif
                    </div>
                    
                    <div class="form-group">
                        <label>
                            Filière
                            <span class="required">*</span>
                        </label>
                        @if($orientationLocked)
                            <div class="readonly-field">
                                <div class="readonly-label">Filière sélectionnée</div>
                                <div class="readonly-value">{{ $user->filiere ?? 'Non renseignée' }}</div>
                            </div>
                        @else
                            <select name="filiere" id="filiere" class="form-control" required disabled data-initial-filiere="{{ old('filiere', $user->filiere) }}">
                                <option value="" selected disabled>-- Sélectionnez d'abord une catégorie --</option>
                        </select>
                        @error('filiere')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Section 4: Modalités de paiement -->
            <div class="card">
                <div class="card-header">
                    <h2>Paiement des Frais d'Inscription</h2>
                </div>
                <div class="card-body">
                    <div class="paiement-info">
                        <h3>Montant à payer</h3>
                        <div class="montant">25 000 FCFA</div>
                        <p>Frais d'inscription pour toutes les filières de première année (Licence 1)</p>
                    </div>
                    
                    @if($orientationLocked)
                        <div class="readonly-field" style="margin-bottom: 1rem;">
                            <div class="readonly-label">Méthode de paiement enregistrée</div>
                            <div class="readonly-value">{{ $user->paiement_method ?? 'Non renseignée' }}</div>
                        </div>
                        <div class="readonly-field" style="margin-bottom: 1rem;">
                            <div class="readonly-label">Statut du paiement</div>
                            <div class="readonly-value">{{ ucfirst($user->paiement_statut ?? 'en attente') }}</div>
                        </div>
                        <div class="readonly-field" style="margin-bottom: 1rem;">
                            <div class="readonly-label">Montant payé</div>
                            <div class="readonly-value">
                                @if($user->montant_paye)
                                    {{ number_format($user->montant_paye, 0, ',', ' ') }} FCFA
                                @else
                                    25 000 FCFA
                                @endif
                            </div>
                        </div>
                        <div class="readonly-field">
                            <div class="readonly-label">Date de paiement ou de soumission</div>
                            <div class="readonly-value">{{ $user->date_paiement ? \Carbon\Carbon::parse($user->date_paiement)->format('d/m/Y H:i') : 'En attente de validation' }}</div>
                        </div>
                    @else
                    <div class="form-group">
                        <label style="margin-bottom: 1rem;">
                            Choisissez votre méthode de paiement
                            <span class="required">*</span>
                        </label>
                        <div class="payment-methods">
                            <div class="payment-method wave" data-method="wave">
                                <img src="{{ asset('assets/images/wave.png') }}" alt="Wave" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="payment-method-fallback" style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%; background: #00d9ff; color: white; font-weight: 600; border-radius: 6px; font-size: 1.25rem;">
                                    <span>WAVE</span>
                                </div>
                                <span class="payment-label">Wave</span>
                            </div>
                            
                            <div class="payment-method orange-money" data-method="Orange Money">
                                <img src="{{ asset('assets/images/orange_money.png') }}" alt="Orange Money" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="payment-method-fallback" style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%; background: #ff6600; color: white; font-weight: 600; border-radius: 6px; font-size: 1.25rem;">
                                    <span>ORANGE MONEY</span>
                                </div>
                                <span class="payment-label">Orange Money</span>
                            </div>
                            
                            <div class="payment-method yass disabled" data-method="yass" style="opacity: 0.5; cursor: not-allowed; pointer-events: none;">
                                <img src="{{ asset('assets/images/yass.jpg.svg') }}" alt="Mixx By Yass" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="payment-method-fallback" style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%; background: #e60012; color: white; font-weight: 600; border-radius: 6px; font-size: 1.25rem;">
                                    <span>MIXX BY YASS</span>
                                </div>
                                <span class="payment-label">Mixx By Yass</span>
                            </div>
                            
                            <div class="payment-method paypal disabled" data-method="paypal" style="opacity: 0.5; cursor: not-allowed; pointer-events: none;">
                                <img src="{{ asset('assets/images/paypal.png') }}" alt="PayPal" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="payment-method-fallback" style="display: none; align-items: center; justify-content: center; width: 100%; height: 100%; background: #003087; color: white; font-weight: 600; border-radius: 6px; font-size: 1.25rem;">
                                    <span>PAYPAL</span>
                                </div>
                                <span class="payment-label">PayPal</span>
                            </div>
                        </div>
                        
                            <input type="hidden" name="paiement_method" id="paiement_method" value="{{ old('paiement_method', $user->paiement_method) }}" required>
                            <input type="hidden" name="paiement_statut" id="paiement_statut" value="effectué">
                            <input type="hidden" name="montant_paye" id="montant_paye" value="25000" readonly>
                        @error('paiement_method')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                        
                        <div class="payment-note">
                            <p>
                                    <strong>Important :</strong> Après avoir effectué le paiement, veuillez patienter que l'administrateur valide votre inscription. Vous recevrez une notification une fois votre inscription validée.
                            </p>
                        </div>
                            
                            <div class="form-group" style="margin-top: 1.5rem;">
                                <label style="display: flex; align-items: flex-start; cursor: pointer; font-weight: 500; color: #212529;">
                                    <input type="checkbox" name="paiement_confirmation" id="paiement_confirmation" required style="margin-right: 0.75rem; margin-top: 0.25rem; width: 1.125rem; height: 1.125rem; cursor: pointer;">
                                    <span style="font-size: 0.875rem; line-height: 1.5;">
                                        J'ai lu et compris que je dois patienter la validation de mon inscription par l'administrateur après avoir effectué le paiement.
                                    </span>
                                </label>
                    </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Section 5: Niveau d'étude -->
            <div class="card">
                <div class="card-header">
                    <h2>Niveau d'Étude</h2>
                </div>
                <div class="card-body">
                    <div class="niveau-auto">
                        <div class="label">Niveau automatique</div>
                        <div class="value">Licence 1 (Première année)</div>
                    </div>
                </div>
            </div>
            
            @unless($orientationLocked)
            <!-- Validation finale -->
            <div class="card">
                <div class="card-body">
                    <button type="submit" id="btn-submit" class="btn-primary" disabled>
                        Valider mon inscription
                    </button>
                </div>
            </div>
            @endunless
        </form>
    </div>
    
    <script>
        const orientationForm = document.getElementById('orientationForm');
        const formLocked = orientationForm && orientationForm.dataset.locked === 'true';
        const categories = @json($categories);
        const defaultCategorie = @json(old('categorie_formation', $user->categorie_formation));
        const defaultFiliere = @json(old('filiere', $user->filiere));
        const defaultPaymentMethod = @json(old('paiement_method', $user->paiement_method));
        
        // SÉCURITÉ CRITIQUE : Désactiver complètement tous les champs si le formulaire est verrouillé
        if (formLocked) {
            // SUPPRIMER IMMÉDIATEMENT tout textarea, input, select modifiable du DOM
            function removeAllEditableFields() {
                // Supprimer tous les textareas (PRIORITÉ ABSOLUE)
                const textareas = document.querySelectorAll('textarea[name="motivation"]');
                textareas.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer tous les selects modifiables
                const selects = orientationForm.querySelectorAll('select[name="canal_decouverte"], select[name="categorie_formation"], select[name="filiere"]');
                selects.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer tous les inputs modifiables (sauf hidden)
                const allInputs = orientationForm.querySelectorAll('input:not([type="hidden"]):not([name="form_locked"]), button');
                allInputs.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer COMPLÈTEMENT toutes les méthodes de paiement (divs cliquables)
                const paymentMethods = orientationForm.querySelectorAll('.payment-method');
                paymentMethods.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer le conteneur des méthodes de paiement
                const paymentMethodsContainer = orientationForm.querySelector('.payment-methods');
                if (paymentMethodsContainer && paymentMethodsContainer.parentNode) {
                    paymentMethodsContainer.parentNode.removeChild(paymentMethodsContainer);
                }
                
                // Supprimer le label "Choisissez votre méthode de paiement"
                const paymentLabel = orientationForm.querySelector('label:has(+ .payment-methods)');
                if (paymentLabel && paymentLabel.textContent.includes('Choisissez votre méthode de paiement')) {
                    const formGroup = paymentLabel.closest('.form-group');
                    if (formGroup && formGroup.parentNode) {
                        formGroup.parentNode.removeChild(formGroup);
                    }
                }
                
                // Supprimer aussi le form-group qui contient les méthodes de paiement
                const paymentFormGroups = orientationForm.querySelectorAll('.form-group');
                paymentFormGroups.forEach(function(formGroup) {
                    const hasPaymentMethods = formGroup.querySelector('.payment-methods');
                    if (hasPaymentMethods && formGroup.parentNode) {
                        formGroup.parentNode.removeChild(formGroup);
                    }
                });
                
                // Supprimer les checkboxes de confirmation
                const checkboxes = orientationForm.querySelectorAll('input[type="checkbox"][name="paiement_confirmation"]');
                checkboxes.forEach(function(element) {
                    if (element && element.parentNode) {
                        // Supprimer aussi le label parent si c'est un label
                        const label = element.closest('label');
                        if (label && label.parentNode) {
                            label.parentNode.removeChild(label);
                        } else if (element.parentNode) {
                            element.parentNode.removeChild(element);
                        }
                    }
                });
            }
            
            // Exécuter immédiatement
            removeAllEditableFields();
            
            // Réexécuter après le chargement complet du DOM
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', removeAllEditableFields);
            } else {
                setTimeout(removeAllEditableFields, 100);
            }
            
            // Surveiller en continu pour empêcher toute réinsertion
            setInterval(function() {
                // Supprimer les textareas
                const textareas = document.querySelectorAll('textarea[name="motivation"]');
                textareas.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer les méthodes de paiement
                const paymentMethods = document.querySelectorAll('.payment-method');
                paymentMethods.forEach(function(element) {
                    if (element && element.parentNode) {
                        element.parentNode.removeChild(element);
                    }
                });
                
                // Supprimer le conteneur des méthodes de paiement
                const paymentMethodsContainer = document.querySelector('.payment-methods');
                if (paymentMethodsContainer && paymentMethodsContainer.parentNode) {
                    paymentMethodsContainer.parentNode.removeChild(paymentMethodsContainer);
                }
                
                // Supprimer les form-groups contenant les méthodes de paiement
                const paymentFormGroups = document.querySelectorAll('.form-group');
                paymentFormGroups.forEach(function(formGroup) {
                    const hasPaymentMethods = formGroup.querySelector('.payment-methods');
                    if (hasPaymentMethods && formGroup.parentNode) {
                        formGroup.parentNode.removeChild(formGroup);
                    }
                });
                
                // Supprimer les checkboxes de confirmation
                const checkboxes = document.querySelectorAll('input[type="checkbox"][name="paiement_confirmation"]');
                checkboxes.forEach(function(element) {
                    if (element && element.parentNode) {
                        const label = element.closest('label');
                        if (label && label.parentNode) {
                            label.parentNode.removeChild(label);
                        } else if (element.parentNode) {
                            element.parentNode.removeChild(element);
                        }
                    }
                });
            }, 500);
            
            // Supprimer les compteurs de caractères et autres éléments interactifs
            const counters = orientationForm.querySelectorAll('#motivation-counter, #motivation-count');
            counters.forEach(function(element) {
                if (element.parentNode) {
                    element.parentNode.removeChild(element);
                }
            });
            
            // Supprimer les checkboxes et leurs labels
            const checkboxes = orientationForm.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(element) {
                if (element.parentNode) {
                    element.parentNode.removeChild(element);
                }
            });
            
            // Empêcher toute soumission du formulaire
            if (orientationForm) {
                orientationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    e.stopImmediatePropagation();
                    alert('SÉCURITÉ : Votre formulaire est verrouillé. Vous ne pouvez plus modifier vos informations tant que l\'administrateur n\'a pas validé votre dossier.');
                    return false;
                }, true);
                
                // Empêcher toute modification via JavaScript
                orientationForm.addEventListener('change', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }, true);
                
                orientationForm.addEventListener('input', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    return false;
                }, true);
            }
            
            // Désactiver tous les event listeners sur les champs
            document.addEventListener('DOMContentLoaded', function() {
                const allFormElements = orientationForm.querySelectorAll('input, textarea, select, button');
                allFormElements.forEach(function(element) {
                    // Supprimer tous les event listeners
                    const newElement = element.cloneNode(true);
                    element.parentNode.replaceChild(newElement, element);
                    // Désactiver le nouvel élément
                    newElement.disabled = true;
                    newElement.readOnly = true;
                    newElement.style.pointerEvents = 'none';
                });
            });
        }
        
        function validateForm() {
            if (formLocked) {
                const submitBtnLocked = document.getElementById('btn-submit');
                if (submitBtnLocked) {
                    submitBtnLocked.disabled = true;
                }
                return true;
            }
            const motivationEl = document.querySelector('textarea[name="motivation"]');
            const canalDecouverteEl = document.getElementById('canal_decouverte');
            const categorieFormationEl = document.getElementById('categorie_formation');
            const filiereEl = document.getElementById('filiere');
            const paiementMethodEl = document.getElementById('paiement_method');
            
            const motivation = motivationEl ? motivationEl.value.trim() : '';
            const canalDecouverte = canalDecouverteEl ? canalDecouverteEl.value : '';
            const categorieFormation = categorieFormationEl ? categorieFormationEl.value : '';
            const filiere = filiereEl ? filiereEl.value : '';
            const paiementMethod = paiementMethodEl ? paiementMethodEl.value : '';
            
            const motivationTrimmed = motivation.trim();
            const motivationValid = motivationTrimmed.length >= 10 && motivationTrimmed.length <= 200;
            const canalValid = canalDecouverte !== '' && canalDecouverte !== null;
            const categorieValid = categorieFormation !== '' && categorieFormation !== null;
            const filiereValid = filiere !== '' && filiere !== null && (!filiereEl || !filiereEl.disabled);
            const paiementValid = paiementMethod !== '' && paiementMethod !== null;
            const paiementConfirmationEl = document.getElementById('paiement_confirmation');
            const paiementConfirmationValid = paiementConfirmationEl ? paiementConfirmationEl.checked : false;
            
            // Déboguer la validation
            if (!paiementValid) {
                console.warn('DÉBOGAGE - Paiement invalide', {
                    'paiementMethod': paiementMethod,
                    'paiementMethodEl': paiementMethodEl ? 'EXISTE' : 'NON TROUVÉ',
                    'paiementMethod_value': paiementMethodEl ? paiementMethodEl.value : 'N/A'
                });
            }
            
            const isValid = motivationValid && canalValid && categorieValid && filiereValid && paiementValid && paiementConfirmationValid;
            
            const submitBtn = document.getElementById('btn-submit');
            if (submitBtn) {
                submitBtn.disabled = !isValid;
                
                let helpMessage = '';
                if (!motivationValid) {
                    if (motivationTrimmed.length < 10) {
                    helpMessage = 'La motivation doit contenir au moins 10 caractères (actuellement: ' + motivationTrimmed.length + '). ';
                    } else if (motivationTrimmed.length > 200) {
                        helpMessage = 'La motivation ne doit pas dépasser 200 caractères (actuellement: ' + motivationTrimmed.length + '). ';
                    }
                }
                if (!canalValid) {
                    helpMessage += 'Sélectionnez un canal de découverte. ';
                }
                if (!categorieValid) {
                    helpMessage += 'Sélectionnez une catégorie de formation. ';
                }
                if (!filiereValid) {
                    helpMessage += 'Sélectionnez une filière. ';
                }
                if (!paiementValid) {
                    helpMessage += 'Sélectionnez une méthode de paiement. ';
                }
                if (!paiementConfirmationValid) {
                    helpMessage += 'Vous devez confirmer avoir lu et compris les instructions de paiement. ';
                }
                if (!paiementConfirmationValid) {
                    helpMessage += 'Vous devez confirmer avoir lu et compris les instructions de paiement. ';
                }
                
                if (!isValid && helpMessage) {
                    submitBtn.setAttribute('title', helpMessage.trim());
                } else {
                    submitBtn.removeAttribute('title');
                }
            }
            
            return isValid;
        }
        
        const categorieSelect = document.getElementById('categorie_formation');
        const filiereSelect = document.getElementById('filiere');
        
        if (!formLocked && categorieSelect) {
            categorieSelect.addEventListener('change', function() {
                const selectedCategorie = this.value;
                filiereSelect.innerHTML = '<option value="">-- Sélectionnez une filière --</option>';
                
                if (selectedCategorie && categories[selectedCategorie]) {
                    filiereSelect.disabled = false;
                    filiereSelect.style.color = '#212529';
                    filiereSelect.style.border = '1px solid #ced4da';
                    filiereSelect.style.backgroundColor = '#ffffff';
                    categories[selectedCategorie].forEach(function(filiere) {
                        const option = document.createElement('option');
                        option.value = filiere;
                        option.textContent = filiere;
                        filiereSelect.appendChild(option);
                    });
                } else {
                    filiereSelect.disabled = true;
                    filiereSelect.style.color = '#6c757d';
                    filiereSelect.style.border = '1px solid #ced4da';
                    filiereSelect.style.backgroundColor = '#e9ecef';
                }
                
                setTimeout(validateForm, 100);
            });
        }
        
        if (!formLocked && filiereSelect && defaultCategorie && categories[defaultCategorie]) {
                filiereSelect.disabled = false;
            filiereSelect.style.color = '#212529';
            filiereSelect.style.border = '1px solid #ced4da';
            filiereSelect.style.backgroundColor = '#ffffff';
            filiereSelect.innerHTML = '<option value="">-- Sélectionnez une filière --</option>';
            categories[defaultCategorie].forEach(function(filiere) {
                    const option = document.createElement('option');
                    option.value = filiere;
                    option.textContent = filiere;
                if (defaultFiliere && filiere === defaultFiliere) {
                        option.selected = true;
                    }
                    filiereSelect.appendChild(option);
                });
            }
        
        const paymentMethods = document.querySelectorAll('.payment-method');
        const paiementMethodInput = document.getElementById('paiement_method');
        
        if (!formLocked && defaultPaymentMethod && paiementMethodInput) {
            const selectedMethod = document.querySelector(`[data-method="${defaultPaymentMethod}"]`);
            // Ne pas activer les méthodes désactivées (yass, paypal)
            if (selectedMethod && !selectedMethod.classList.contains('disabled')) {
                selectedMethod.classList.add('active');
                paiementMethodInput.value = defaultPaymentMethod;
            } else if (selectedMethod && selectedMethod.classList.contains('disabled')) {
                // Si la méthode par défaut est désactivée, réinitialiser
                paiementMethodInput.value = '';
            }
        }
        
        const motivationField = document.querySelector('textarea[name="motivation"]');
        const canalDecouverteField = document.getElementById('canal_decouverte');
        
        if (!formLocked && motivationField) {
            const motivationCounter = document.getElementById('motivation-counter');
            const motivationCount = document.getElementById('motivation-count');
            
            function updateMotivationCounter() {
                const text = motivationField.value.trim();
                const count = text.length;
                if (motivationCount) {
                    motivationCount.textContent = count;
                    if (count < 10) {
                        motivationCount.style.color = '#dc3545';
                        if (motivationCounter) {
                            motivationCounter.style.color = '#dc3545';
                            motivationCounter.innerHTML = '<span id="motivation-count">' + count + '</span> / 200 caractères maximum <span style="color: #dc3545;">(minimum 10 caractères requis, ' + (10 - count) + ' restants)</span>';
                        }
                    } else if (count > 200) {
                        motivationCount.style.color = '#dc3545';
                        if (motivationCounter) {
                            motivationCounter.style.color = '#dc3545';
                            motivationCounter.innerHTML = '<span id="motivation-count">' + count + '</span> / 200 caractères maximum <span style="color: #dc3545;">(dépassement de ' + (count - 200) + ' caractères)</span>';
                        }
                    } else {
                        motivationCount.style.color = '#065b32';
                        if (motivationCounter) {
                            motivationCounter.style.color = '#065b32';
                            motivationCounter.innerHTML = '<span id="motivation-count">' + count + '</span> / 200 caractères maximum ✓';
                        }
                    }
                }
            }
            
            motivationField.addEventListener('input', function() {
                updateMotivationCounter();
                setTimeout(validateForm, 50);
            });
            motivationField.addEventListener('change', function() {
                updateMotivationCounter();
                validateForm();
            });
            motivationField.addEventListener('keyup', function() {
                updateMotivationCounter();
                setTimeout(validateForm, 50);
            });
            
            updateMotivationCounter();
        }
        
        if (!formLocked && canalDecouverteField) {
            canalDecouverteField.addEventListener('change', function() {
                setTimeout(validateForm, 50);
            });
        }
        
        if (!formLocked && categorieSelect) {
            categorieSelect.addEventListener('input', function() {
                setTimeout(validateForm, 150);
            });
        }
        
        if (!formLocked && filiereSelect) {
            filiereSelect.addEventListener('change', function() {
                setTimeout(validateForm, 50);
            });
        }
        
        // Valider quand la case de confirmation est cochée/décochée
        const paiementConfirmationEl = document.getElementById('paiement_confirmation');
        if (!formLocked && paiementConfirmationEl) {
            paiementConfirmationEl.addEventListener('change', function() {
                setTimeout(validateForm, 50);
            });
        }
        
        if (!formLocked && paymentMethods && paymentMethods.length > 0 && paiementMethodInput) {
            const paiementStatutInput = document.getElementById('paiement_statut');
            
            paymentMethods.forEach(function(method) {
                method.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Empêcher la sélection des méthodes désactivées
                    if (this.classList.contains('disabled')) {
                        return false;
                    }
                    
                    paymentMethods.forEach(m => m.classList.remove('active'));
                    this.classList.add('active');
                    const methodValue = this.getAttribute('data-method');
                    
                    // SÉCURITÉ : Forcer le statut à "en attente" pour Orange Money
                    // Empêcher toute manipulation côté client
                    if (methodValue && methodValue.toLowerCase() === 'orange money' && paiementStatutInput) {
                        paiementStatutInput.value = 'en attente';
                    } else if (paiementStatutInput) {
                        // Pour les autres méthodes, permettre "effectué" (sera validé côté serveur)
                        paiementStatutInput.value = 'effectué';
                    }
                    if (paiementMethodInput) {
                        paiementMethodInput.value = methodValue;
                        console.log('DÉBOGAGE - Méthode de paiement sélectionnée', {
                            'methodValue': methodValue,
                            'paiement_method_value': paiementMethodInput.value
                        });
                    }
                    
                    // Wave sera géré lors de la soumission du formulaire
                    
                    setTimeout(validateForm, 100);
                });
            });
        }
        
        function initValidation() {
            if (formLocked) {
                return;
            }
            setTimeout(function() {
                validateForm();
                setInterval(validateForm, 500);
            }, 300);
        }
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initValidation);
        } else {
            initValidation();
        }
        
        if (orientationForm) {
            orientationForm.addEventListener('submit', function(e) {
                if (formLocked) {
                e.preventDefault();
                    alert('Votre formulaire est verrouillé. Vous ne pouvez plus modifier vos informations tant que l\'administrateur n\'a pas validé votre dossier.');
                    return false;
                }
                
                // Déboguer : afficher les valeurs avant validation
                const paiementMethodDebug = document.getElementById('paiement_method');
                const paiementMethodValue = paiementMethodDebug ? paiementMethodDebug.value : '';
                
                console.log('DÉBOGAGE - Soumission du formulaire', {
                    'paiement_method': paiementMethodValue,
                    'paiement_statut': document.getElementById('paiement_statut') ? document.getElementById('paiement_statut').value : 'NON TROUVÉ',
                    'motivation': document.querySelector('textarea[name="motivation"]') ? document.querySelector('textarea[name="motivation"]').value.length : 'NON TROUVÉ',
                    'filiere': document.getElementById('filiere') ? document.getElementById('filiere').value : 'NON TROUVÉ',
                });
                
                // Si Wave est sélectionné, permettre la soumission même si la validation échoue
                // car le serveur gérera la redirection
                const isWave = paiementMethodValue && (paiementMethodValue.toLowerCase() === 'wave' || paiementMethodValue === 'Wave');
                
                // Valider le formulaire
                const isValid = validateForm();
                
                if (!isValid && !isWave) {
                    e.preventDefault();
                    const paiementMethodEl = document.getElementById('paiement_method');
                    const paiementMethod = paiementMethodEl ? paiementMethodEl.value : '';
                    console.error('DÉBOGAGE - Validation échouée', {
                        'paiement_method': paiementMethod,
                        'raison': 'Formulaire invalide'
                    });
                alert('Veuillez remplir tous les champs obligatoires correctement.');
                return false;
            }
                
                // Déboguer : confirmer que le formulaire va être soumis
                console.log('DÉBOGAGE - Formulaire soumis', {
                    'isWave': isWave,
                    'paiement_method': paiementMethodValue,
                    'isValid': isValid,
                    'formAction': orientationForm.action
                });
                
                // Si Wave est sélectionné, s'assurer que le formulaire est soumis
                if (isWave) {
                    console.log('DÉBOGAGE - Wave détecté, soumission forcée vers:', orientationForm.action);
                }
            });
        }
    </script>
</body>
</html>
