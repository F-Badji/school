<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu d'Inscription - BJ Académie</title>
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
            font-size: 11px;
            color: #1a1a1a;
            line-height: 1.5;
            padding: 0;
        }
        
        .header {
            background: linear-gradient(135deg, #065b32 0%, #087a45 100%);
            color: white;
            padding: 15px 30px;
            text-align: center;
            margin-bottom: 12px;
            border-radius: 4px;
        }
        
        .header h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
            letter-spacing: 1px;
        }
        
        .header p {
            font-size: 11px;
            opacity: 0.95;
        }
        
        .receipt-info {
            text-align: center;
            margin-bottom: 12px;
            padding-bottom: 10px;
            border-bottom: 2px solid #065b32;
        }
        
        .receipt-info h2 {
            font-size: 16px;
            color: #065b32;
            margin-bottom: 4px;
            font-weight: bold;
        }
        
        .receipt-info .receipt-number {
            font-size: 10px;
            color: #666;
        }
        
        .content-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .column {
            display: table-cell;
            width: 48%;
            vertical-align: top;
            padding: 0 10px;
        }
        
        .column:first-child {
            padding-left: 0;
        }
        
        .column:last-child {
            padding-right: 0;
        }
        
        .section {
            margin-bottom: 12px;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 4px;
            border-left: 3px solid #065b32;
        }
        
        .section-title {
            font-size: 11px;
            font-weight: bold;
            color: #065b32;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-row {
            padding: 5px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        .info-row:last-child {
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #555;
            display: inline-block;
            width: 45%;
            margin-right: 5%;
        }
        
        .info-value {
            font-weight: 600;
            color: #111;
            display: inline-block;
            width: 50%;
            text-align: right;
        }
        
        .payment-section {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            border: 2px solid #065b32;
            padding: 15px;
            border-radius: 4px;
            margin: 12px 0;
            text-align: center;
        }
        
        .payment-section .section-title {
            text-align: center;
            margin-bottom: 10px;
            font-size: 12px;
        }
        
        .payment-section .amount {
            font-size: 26px;
            font-weight: bold;
            color: #065b32;
            margin: 8px 0;
            letter-spacing: 1px;
        }
        
        .payment-details {
            margin-top: 10px;
            text-align: left;
        }
        
        .payment-details .info-row {
            justify-content: space-between;
        }
        
        .footer {
            margin-top: 50px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 9px;
        }
        
        .signature-section {
            margin-top: 25px;
            text-align: right;
            padding-right: 10px;
            margin-bottom: 35px;
        }
        
        .signature-container {
            display: inline-block;
            text-align: center;
            width: 180px;
        }
        
        .signature-image {
            max-width: 140px;
            max-height: 55px;
            margin-bottom: 8px;
            object-fit: contain;
        }
        
        .signature-text {
            font-size: 10px;
            color: #333;
            font-weight: 600;
            margin-top: 5px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        
        .footer-text {
            margin-top: 12px;
            font-size: 9px;
            color: #888;
            line-height: 1.4;
        }
        
    </style>
</head>
<body>
    <div class="header">
        <h1>BJ ACADÉMIE</h1>
        <p>Reçu d'Inscription et de Paiement</p>
    </div>
    
    <div class="receipt-info">
        <h2>REÇU N° {{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}-{{ $date->format('Ymd') }}</h2>
        <p class="receipt-number">Date d'émission : {{ $date->format('d/m/Y à H:i') }}</p>
    </div>
    
    <div class="content-grid">
        <div class="column">
            <!-- Informations de l'apprenant -->
            <div class="section">
                <div class="section-title">Informations de l'Apprenant</div>
                <div class="info-row">
                    <span class="info-label">Nom complet :</span>
                    <span class="info-value">{{ $user->nom }} {{ $user->prenom }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Adresse e-mail :</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date de naissance :</span>
                    <span class="info-value">{{ $user->date_naissance ? $user->date_naissance->format('d/m/Y') : 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Date d'inscription :</span>
                    <span class="info-value">{{ $user->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        </div>
        
        <div class="column">
            <!-- Informations de formation -->
            <div class="section">
                <div class="section-title">Informations de Formation</div>
                <div class="info-row">
                    <span class="info-label">Catégorie :</span>
                    <span class="info-value">{{ $user->categorie_formation ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Filière :</span>
                    <span class="info-value">{{ $user->filiere ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Niveau d'étude :</span>
                    <span class="info-value">{{ $user->niveau_etude ?? 'N/A' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Canal de découverte :</span>
                    <span class="info-value">{{ $user->canal_decouverte ?? 'N/A' }}</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Paiement -->
    <div class="payment-section">
        <div class="section-title">Détails du Paiement</div>
        <div class="amount">{{ number_format($user->montant_paye ?? 25000, 0, ',', ' ') }} FCFA</div>
        <div class="payment-details">
            <div class="info-row">
                <span class="info-label">Méthode de paiement :</span>
                <span class="info-value">
                    @php
                        $paymentMethods = [
                            'Orange Money' => 'Orange Money',
                            'orange' => 'Orange Money', // Compatibilité avec les anciennes données
                            'Wave' => 'Wave',
                            'wave' => 'Wave', // Compatibilité avec les anciennes données
                            'yass' => 'Mixx By Yass',
                            'paypal' => 'PayPal',
                        ];
                        $method = $user->paiement_method ?? null;
                        echo $method && isset($paymentMethods[$method]) ? $paymentMethods[$method] : ($method ? ucfirst($method) : 'N/A');
                    @endphp
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Statut :</span>
                <span class="info-value" style="color: #059669; font-weight: bold;">{{ ucfirst($user->paiement_statut ?? 'effectué') }}</span>
            </div>
            @if($user->date_paiement)
            <div class="info-row">
                <span class="info-label">Date de paiement :</span>
                <span class="info-value">{{ $user->date_paiement->format('d/m/Y à H:i') }}</span>
            </div>
            @endif
        </div>
    </div>
    
    <div class="signature-section">
        <div class="signature-container">
            @php
                $signaturePath = null;
                $extensions = ['png', 'jpg', 'jpeg'];
                foreach ($extensions as $ext) {
                    $path = public_path('assets/images/signature-bj-academie.' . $ext);
                    if (file_exists($path)) {
                        $signaturePath = $path;
                        break;
                    }
                }
            @endphp
            @if($signaturePath)
                <img src="{{ $signaturePath }}" alt="Signature BJ Académie" class="signature-image" />
            @endif
            <div class="signature-text">Cachet et Signature BJ Académie</div>
        </div>
    </div>
    
    <div class="footer">
        <div class="footer-text">
            <p><strong>BJ ACADÉMIE</strong></p>
            <p>Ce document certifie que l'inscription a été effectuée et enregistrée dans notre système.</p>
            <p>Ce reçu est valable pour toutes les démarches administratives.</p>
            <p style="margin-top: 10px;">Document généré le {{ $date->format('d/m/Y à H:i') }}</p>
        </div>
    </div>
</body>
</html>
