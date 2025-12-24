<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paiement Wave — BJ Académie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
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
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }
        
        .payment-container {
            max-width: 500px;
            width: 100%;
            background: #ffffff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 2px solid #e9ecef;
        }
        
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            color: #212529;
            margin-bottom: 0.5rem;
        }
        
        .header p {
            font-size: 1rem;
            color: #6c757d;
        }
        
        .amount-section {
            background: #fff3cd;
            padding: 1.5rem;
            border-radius: 6px;
            border: 1px solid #ffc107;
            margin-bottom: 2rem;
            text-align: center;
        }
        
        .amount-section .label {
            font-size: 0.875rem;
            color: #856404;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .amount-section .amount {
            font-size: 2rem;
            font-weight: 700;
            color: #856404;
        }
        
        .qr-section {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .qr-code-container {
            display: inline-block;
            padding: 1.5rem;
            background: #ffffff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        #qrcode {
            display: inline-block;
        }
        
        .instructions {
            background: #d1ecf1;
            border-left: 4px solid #0c5460;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 2rem;
        }
        
        .instructions h3 {
            color: #0c5460;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
        }
        
        .instructions ol {
            margin-left: 1.5rem;
            color: #0c5460;
        }
        
        .instructions li {
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }
        
        .btn {
            padding: 0.875rem 2rem;
            border: none;
            border-radius: 6px;
            font-size: 0.9375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.15s ease;
            width: 100%;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
        
        .btn-primary {
            background: #065b32;
            color: white;
        }
        
        .btn-primary:hover {
            background: #054a28;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-top: 1rem;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
        }
        
        .wave-logo {
            text-align: center;
            margin-bottom: 1rem;
        }
        
        .wave-logo img {
            height: 60px;
            width: auto;
        }
    </style>
</head>
<body>
    <div class="payment-container">
        <div class="header">
            <h1>Paiement Wave</h1>
            <p>Scannez le QR code pour effectuer votre paiement</p>
        </div>
        
        <div class="wave-logo">
            <img src="{{ asset('assets/images/wave.png') }}" alt="Wave">
        </div>
        
        <div class="amount-section">
            <div class="label">Montant à payer</div>
            <div class="amount">{{ number_format($montant, 0, ',', ' ') }} FCFA</div>
        </div>
        
        <div class="qr-section">
            <div class="qr-code-container">
                <div id="qrcode"></div>
            </div>
            <p style="font-size: 0.875rem; color: #6c757d; margin-top: 1rem;">
                Scannez ce QR code avec l'application Wave pour effectuer le paiement
            </p>
        </div>
        
        <div class="instructions">
            <h3>Instructions de paiement</h3>
            <ol>
                <li>Ouvrez l'application Wave sur votre téléphone</li>
                <li>Scannez le QR code ci-dessus</li>
                <li>Confirmez le montant de {{ number_format($montant, 0, ',', ' ') }} FCFA</li>
                <li>Validez votre paiement</li>
                <li>Revenez sur cette page et cliquez sur "J'ai effectué le paiement"</li>
            </ol>
        </div>
        
        <a href="{{ route('orientation.show') }}" class="btn btn-primary">
            J'ai effectué le paiement
        </a>
        
        <a href="{{ route('orientation.show') }}" class="btn btn-secondary">
            Retour au formulaire
        </a>
    </div>
    
    <script>
        // Générer le QR code Wave avec le montant de 25000 FCFA
        const montant = {{ $montant }};
        const userEmail = '{{ $user->email }}';
        const userName = '{{ $user->nom }} {{ $user->prenom }}';
        
        // Format du lien Wave pour le paiement
        // Format: wave://payment?amount=25000&currency=XOF&merchant=BJAcademie
        const wavePaymentLink = `wave://payment?amount=${montant}&currency=XOF&merchant=BJAcademie&reference=INSCRIPTION-{{ $user->id }}`;
        
        // Alternative: lien web Wave si l'app n'est pas installée
        const waveWebLink = `https://wave.com/send-money?amount=${montant}&currency=XOF`;
        
        // Générer le QR code avec le lien Wave
        if (typeof QRCode !== 'undefined') {
            new QRCode(document.getElementById("qrcode"), {
                text: wavePaymentLink,
                width: 250,
                height: 250,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        } else {
            // Fallback si la bibliothèque n'est pas chargée
            document.getElementById("qrcode").innerHTML = `
                <div style="padding: 2rem; text-align: center;">
                    <p style="color: #dc3545; margin-bottom: 1rem;">QR Code non disponible</p>
                    <p style="color: #6c757d; font-size: 0.875rem; margin-bottom: 1rem;">Utilisez le lien Wave ci-dessous :</p>
                    <a href="${wavePaymentLink}" style="display: inline-block; padding: 0.75rem 1.5rem; background: #00d9ff; color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">
                        Ouvrir Wave
                    </a>
                </div>
            `;
        }
    </script>
</body>
</html>

