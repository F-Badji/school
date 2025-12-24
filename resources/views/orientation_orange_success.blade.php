<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Effectué avec Succès - BJ Academie</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 2rem 1rem;
            color: #1f2937;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .success-header {
            text-align: center;
            background: linear-gradient(135deg, #065b32 0%, #059669 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 1rem 1rem 0 0;
            box-shadow: 0 10px 25px rgba(6, 91, 50, 0.3);
        }
        
        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        
        .success-icon svg {
            width: 50px;
            height: 50px;
            color: #059669;
        }
        
        .success-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .success-header p {
            font-size: 1.125rem;
            opacity: 0.95;
        }
        
        .welcome-section {
            background: white;
            padding: 2rem;
            border-bottom: 3px solid #059669;
        }
        
        .welcome-title {
            color: #065b32;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-align: center;
        }
        
        .welcome-message {
            background: #f0fdf4;
            border-left: 4px solid #059669;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #1f2937;
        }
        
        .welcome-message strong {
            color: #065b32;
        }
        
        .info-section {
            background: white;
            padding: 2rem;
            border-radius: 0 0 1rem 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .info-title {
            color: #065b32;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid #e5e7eb;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
        }
        
        .info-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .info-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 600;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
        }
        
        .payment-info {
            background: #fef3c7;
            border: 2px solid #fcd34d;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .payment-info h3 {
            color: #92400e;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .payment-info .amount {
            font-size: 1.75rem;
            font-weight: 700;
            color: #c2410c;
        }
        
        .payment-info .method {
            margin-top: 0.5rem;
            color: #78350f;
            font-weight: 500;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #065b32 0%, #059669 100%);
            color: white;
            box-shadow: 0 4px 6px rgba(6, 91, 50, 0.3);
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(6, 91, 50, 0.4);
        }
        
        .btn-secondary {
            background: white;
            color: #065b32;
            border: 2px solid #065b32;
        }
        
        .btn-secondary:hover {
            background: #065b32;
            color: white;
        }
        
        .encouragement-note {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-top: 2rem;
            color: #1e40af;
            line-height: 1.8;
        }
        
        .encouragement-note strong {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }
        
        @media (max-width: 768px) {
            .action-buttons {
                grid-template-columns: 1fr;
            }
            
            .success-header h1 {
                font-size: 1.5rem;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-header">
            <div class="success-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1>Paiement Effectué avec Succès</h1>
            <p>Votre inscription a été confirmée</p>
        </div>
        
        <div class="welcome-section">
            <h2 class="welcome-title">Bienvenue dans BJ Academie !</h2>
            <div class="welcome-message">
                <p>
                    Félicitations <strong>{{ $user->prenom }} {{ $user->nom }}</strong> ! Votre inscription à BJ Academie a été validée avec succès. 
                    Nous sommes ravis de vous accueillir dans notre communauté d'apprentissage.
                </p>
            </div>
        </div>
        
        <div class="info-section">
            <h3 class="info-title">Vos Informations d'Inscription</h3>
            
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nom complet</span>
                    <span class="info-value">{{ $user->nom }} {{ $user->prenom }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Date de naissance</span>
                    <span class="info-value">{{ $user->date_naissance ? $user->date_naissance->format('d/m/Y') : 'Non renseignée' }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Adresse e-mail</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Date d'inscription</span>
                    <span class="info-value">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Niveau d'étude</span>
                    <span class="info-value">{{ $user->niveau_etude ?? 'Licence 1' }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Catégorie de formation</span>
                    <span class="info-value">{{ $user->categorie_formation ?? 'Non renseignée' }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Filière choisie</span>
                    <span class="info-value">{{ $user->filiere ?? 'Non renseignée' }}</span>
                </div>
                
                <div class="info-item">
                    <span class="info-label">Date de validation</span>
                    <span class="info-value">
                        @php
                            $dateOrientation = $user->date_orientation;
                            if ($dateOrientation) {
                                // Si c'est déjà un objet Carbon
                                if (is_object($dateOrientation) && method_exists($dateOrientation, 'format')) {
                                    echo $dateOrientation->format('d/m/Y à H:i');
                                } 
                                // Si c'est une string, essayer de la convertir
                                elseif (is_string($dateOrientation)) {
                                    try {
                                        echo \Carbon\Carbon::parse($dateOrientation)->format('d/m/Y à H:i');
                                    } catch (\Exception $e) {
                                        echo now()->format('d/m/Y à H:i');
                                    }
                                } else {
                                    echo now()->format('d/m/Y à H:i');
                                }
                            } else {
                                echo now()->format('d/m/Y à H:i');
                            }
                        @endphp
                    </span>
                </div>
            </div>
            
            <div class="payment-info">
                <h3>Détails du Paiement</h3>
                <div class="amount">{{ number_format($user->montant_paye ?? 25000, 0, ',', ' ') }} FCFA</div>
                <div class="method">Méthode de paiement : Orange Money</div>
                <div style="margin-top: 0.75rem; font-size: 0.875rem; color: #78350f;">
                    Statut : <strong>Paiement confirmé</strong>
                </div>
            </div>
            
            <div class="encouragement-note">
                <strong>💡 Message d'encouragement</strong>
                <p>
                    Nous vous encourageons vivement à consulter régulièrement votre tableau de bord pour suivre vos cours, 
                    consulter vos messages, prendre connaissance des nouvelles informations, évaluations et annonces importantes. 
                    Votre engagement et votre régularité sont les clés de votre réussite académique. 
                    Nous sommes là pour vous accompagner tout au long de votre parcours d'apprentissage.
                </p>
            </div>
            
            <div class="action-buttons">
                <a href="{{ route('orientation.receipt') }}" class="btn btn-secondary">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Télécharger ma facture
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-primary">
                    Passer à mon dashboard
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</body>
</html>


