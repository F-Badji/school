<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inscription Validée — BJ Académie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-green: #065b32;
            --brand-green-hover: #077a43;
            --brand-green-light: #087a45;
        }
        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e8f5e9 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .success-container {
            max-width: 600px;
            width: 100%;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }
        
        .success-header {
            background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-green-light) 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
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
            font-size: 3rem;
            color: var(--brand-green);
            animation: scaleIn 0.5s ease-out;
        }
        
        @keyframes scaleIn {
            from {
                transform: scale(0);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .success-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }
        
        .success-header p {
            opacity: 0.95;
            font-size: 1rem;
        }
        
        .success-body {
            padding: 2rem;
        }
        
        .alert-success {
            background: #ecfdf5;
            border: 2px solid var(--brand-green);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .alert-success p {
            color: var(--brand-green);
            font-weight: 600;
            margin: 0;
            font-size: 1rem;
        }
        
        .info-summary {
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 0.5rem;
            margin-bottom: 2rem;
        }
        
        .info-summary h3 {
            color: var(--brand-green);
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-item:last-child {
            border-bottom: none;
        }
        
        .info-item .label {
            color: #6b7280;
            font-weight: 500;
        }
        
        .info-item .value {
            color: #111827;
            font-weight: 600;
        }
        
        .action-buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        
        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 0.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-download {
            background: #f3f4f6;
            color: #374151;
            border: 2px solid #e5e7eb;
        }
        
        .btn-download:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
        }
        
        .btn-continue {
            background: linear-gradient(135deg, var(--brand-green) 0%, var(--brand-green-light) 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(6, 91, 50, 0.3);
        }
        
        .btn-continue:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(6, 91, 50, 0.4);
        }
        
        @media (max-width: 640px) {
            .action-buttons {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-header">
            <div class="success-icon">✅</div>
            <h1>Inscription Validée !</h1>
            <p>Votre demande a été enregistrée avec succès</p>
        </div>
        
        <div class="success-body">
            <div class="alert-success">
                <p>✅ Votre inscription a été validée avec succès et est en attente de confirmation par l'administration.</p>
            </div>
            
            <div class="info-summary">
                <h3>📋 Résumé de votre inscription</h3>
                <div class="info-item">
                    <span class="label">Nom complet</span>
                    <span class="value">{{ $user->nom }} {{ $user->prenom }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Filière</span>
                    <span class="value">{{ $user->filiere }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Catégorie</span>
                    <span class="value">{{ $user->categorie_formation }}</span>
                </div>
                <div class="info-item">
                    <span class="label">Niveau</span>
                    <span class="value">{{ $user->niveau_etude }}</span>
                </div>
                @if($user->paiement_statut === 'effectué')
                <div class="info-item">
                    <span class="label">Montant payé</span>
                    <span class="value">{{ number_format($user->montant_paye ?? 25000, 0, ',', ' ') }} FCFA</span>
                </div>
                @endif
            </div>
            
            <div class="action-buttons">
                @if($user->paiement_statut === 'effectué')
                <a href="{{ route('orientation.receipt') }}" class="btn btn-download">
                    📥 Télécharger le reçu
                </a>
                @endif
                <a href="{{ route('apprenant.dashboard') }}" class="btn btn-continue">
                    Accéder au tableau de bord →
                </a>
            </div>
        </div>
    </div>
</body>
</html>



