<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu de Paiement - BJ Academie</title>
    <style>
        @page {
            margin: 15mm;
            size: A4;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            line-height: 1.6;
            padding: 0;
        }
        
        .header {
            background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%);
            color: white;
            padding: 25px 30px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 2px;
        }
        
        .header p {
            font-size: 13px;
            opacity: 0.95;
        }
        
        .receipt-info {
            text-align: center;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 3px solid #1a1f3a;
        }
        
        .receipt-info h2 {
            font-size: 18px;
            color: #1a1f3a;
            margin-bottom: 8px;
            font-weight: bold;
        }
        
        .receipt-info .receipt-number {
            font-size: 12px;
            color: #666;
            font-weight: 600;
        }
        
        .content-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        
        .column {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding: 0 15px;
        }
        
        .column:first-child {
            padding-left: 0;
        }
        
        .column:last-child {
            padding-right: 0;
        }
        
        .section {
            margin-bottom: 18px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border-left: 4px solid #1a1f3a;
        }
        
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1a1f3a;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            display: table-cell;
            width: 45%;
            font-weight: 600;
            color: #4b5563;
            font-size: 11px;
        }
        
        .info-value {
            display: table-cell;
            width: 55%;
            color: #1f2937;
            font-weight: 500;
            font-size: 11px;
            text-align: right;
        }
        
        .payment-summary {
            margin-top: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
            border-radius: 8px;
            border: 2px solid #1a1f3a;
        }
        
        .payment-summary-title {
            font-size: 16px;
            font-weight: bold;
            color: #1a1f3a;
            margin-bottom: 15px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .payment-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            padding: 10px 0;
        }
        
        .payment-label {
            display: table-cell;
            width: 60%;
            font-weight: 600;
            color: #374151;
            font-size: 12px;
        }
        
        .payment-value {
            display: table-cell;
            width: 40%;
            color: #1a1f3a;
            font-weight: bold;
            font-size: 13px;
            text-align: right;
        }
        
        .total-row {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 2px solid #1a1f3a;
            font-size: 14px;
        }
        
        .total-label {
            font-weight: bold;
            color: #1a1f3a;
        }
        
        .total-value {
            font-weight: bold;
            color: #1a1f3a;
            font-size: 16px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 10px;
        }
        
        .footer p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BJ ACADEMIE</h1>
        <p>Reçu de Paiement</p>
    </div>
    
    <div class="receipt-info">
        <h2>REÇU N° {{ $invoiceNumber }}</h2>
        <p class="receipt-number">Date d'émission : {{ $date->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</p>
    </div>
    
    <div class="content-grid">
        <div class="column">
            <!-- Informations de l'apprenant -->
            <div class="section">
                <div class="section-title">Informations de l'Apprenant</div>
                <div class="info-row">
                    <span class="info-label">Nom complet :</span>
                    <span class="info-value">{{ strtoupper($user->nom ?? '') }} {{ $user->prenom ?? '' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse e-mail :</span>
                    <span class="info-value">{{ $user->email ?? 'N/A' }}</span>
                </div>
                @if($user->date_naissance)
                <div class="info-row">
                    <span class="info-label">Date de naissance :</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($user->date_naissance)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Date d'inscription :</span>
                    <span class="info-value">{{ $user->created_at->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
        
        <div class="column">
            <!-- Informations de formation -->
            <div class="section">
                <div class="section-title">Informations de Formation</div>
                <div class="info-row">
                    <span class="info-label">Filière :</span>
                    <span class="info-value">{{ $user->filiere ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Classe :</span>
                    <span class="info-value">{{ $user->niveau_etude ?? 'N/A' }}</span>
                </div>
                @if($user->date_paiement)
                <div class="info-row">
                    <span class="info-label">Date de paiement :</span>
                    <span class="info-value">{{ \Carbon\Carbon::parse($user->date_paiement)->locale('fr')->isoFormat('D MMMM YYYY') }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Mode de paiement :</span>
                    <span class="info-value">{{ ucfirst($user->paiement_method ?? 'N/A') }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="payment-summary">
        <div class="payment-summary-title">Détails du Paiement</div>
        <div class="payment-row">
            <span class="payment-label">Montant payé :</span>
            <span class="payment-value">{{ number_format($user->montant_paye ?? 0, 0, ',', ' ') }} FCFA</span>
        </div>
        <div class="payment-row">
            <span class="payment-label">Statut :</span>
            <span class="payment-value">{{ ucfirst($user->paiement_statut ?? 'N/A') }}</span>
        </div>
        <div class="payment-row total-row">
            <span class="payment-label total-label">TOTAL PAYÉ :</span>
            <span class="payment-value total-value">{{ number_format($user->montant_paye ?? 0, 0, ',', ' ') }} FCFA</span>
        </div>
    </div>
    
    <div class="footer">
        <p><strong>BJ ACADEMIE</strong></p>
        <p>Merci pour votre confiance !</p>
        <p>Ce document est généré automatiquement et certifie votre paiement.</p>
    </div>
</body>
</html>

