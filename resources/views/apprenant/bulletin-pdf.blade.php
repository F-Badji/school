<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Bulletin de Notes - BJ Académie</title>
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
            background: linear-gradient(135deg, #1a1f3a 0%, #161b33 100%);
            color: white;
            padding: 20px 30px;
            text-align: center;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            letter-spacing: 1px;
        }

        .header p {
            font-size: 12px;
            opacity: 0.95;
        }

        .student-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 20px;
            border-left: 4px solid #1a1f3a;
        }

        .student-info h2 {
            font-size: 16px;
            color: #1a1f3a;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            font-weight: bold;
            color: #333;
            padding: 5px 10px 5px 0;
            width: 40%;
        }

        .info-value {
            display: table-cell;
            color: #555;
            padding: 5px 0;
        }

        .semester-section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }

        .semester-title {
            background: #1a1f3a;
            color: white;
            padding: 10px 15px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            border-radius: 4px;
        }

        .notes-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .notes-table th {
            background: #f8f9fa;
            color: #1a1f3a;
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #dee2e6;
            font-size: 10px;
        }

        .notes-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            font-size: 10px;
        }

        .notes-table tr:nth-child(even) {
            background: #f8f9fa;
        }

        .total-section {
            background: #e6f7ed;
            border: 2px solid #065b32;
            padding: 15px;
            border-radius: 4px;
            text-align: right;
            margin-top: 20px;
        }

        .total-label {
            font-size: 14px;
            font-weight: bold;
            color: #065b32;
        }

        .total-value {
            font-size: 18px;
            font-weight: bold;
            color: #065b32;
            margin-left: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px solid #e0e0e0;
        }

        .footer-text {
            margin-top: 10px;
            font-size: 9px;
            color: #888;
            line-height: 1.4;
        }

        .no-notes {
            text-align: center;
            padding: 20px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BJ ACADÉMIE</h1>
        <p>Bulletin de Notes</p>
    </div>

    <div class="student-info">
        <h2>Informations de l'Apprenant</h2>
        <div class="info-grid">
            <div class="info-row">
                <span class="info-label">Nom complet :</span>
                <span class="info-value">{{ $user->prenom }} {{ $user->nom }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email :</span>
                <span class="info-value">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Filière :</span>
                <span class="info-value">{{ $user->filiere ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Classe :</span>
                <span class="info-value">{{ $user->niveau_etude ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Date d'émission :</span>
                <span class="info-value">{{ $date->locale('fr')->isoFormat('D MMMM YYYY à HH:mm') }}</span>
            </div>
        </div>
    </div>

    @php
        // Organiser les notes par semestre
        $notesSem1 = collect($notes)->filter(function($note) {
            $month = \Carbon\Carbon::parse($note->created_at)->month;
            return ($month >= 1 && $month <= 6);
        });
        
        $notesSem2 = collect($notes)->filter(function($note) {
            $month = \Carbon\Carbon::parse($note->created_at)->month;
            return ($month >= 7 && $month <= 12);
        });
    @endphp

    <!-- Semestre 1 -->
    <div class="semester-section">
        <div class="semester-title">SEMESTRE 1</div>
        
        @if($notesSem1->count() > 0)
            <table class="notes-table">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Exercices</th>
                        <th>Devoirs</th>
                        <th>Examens</th>
                        <th>Moyenne</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notesSem1 as $note)
                        <tr>
                            <td>{{ $note->classe ?? 'Matière' }}</td>
                            <td>{{ $note->quiz ? number_format($note->quiz, 2) : '-' }}</td>
                            <td>{{ $note->devoir ? number_format($note->devoir, 2) : '-' }}</td>
                            <td>{{ $note->examen ? number_format($note->examen, 2) : '-' }}</td>
                            <td><strong>{{ $note->moyenne ? number_format($note->moyenne, 2) : '-' }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-notes">Aucune note enregistrée pour le Semestre 1</div>
        @endif
    </div>

    <!-- Semestre 2 -->
    <div class="semester-section">
        <div class="semester-title">SEMESTRE 2</div>
        
        @if($notesSem2->count() > 0)
            <table class="notes-table">
                <thead>
                    <tr>
                        <th>Matière</th>
                        <th>Exercices</th>
                        <th>Devoirs</th>
                        <th>Examens</th>
                        <th>Moyenne</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notesSem2 as $note)
                        <tr>
                            <td>{{ $note->classe ?? 'Matière' }}</td>
                            <td>{{ $note->quiz ? number_format($note->quiz, 2) : '-' }}</td>
                            <td>{{ $note->devoir ? number_format($note->devoir, 2) : '-' }}</td>
                            <td>{{ $note->examen ? number_format($note->examen, 2) : '-' }}</td>
                            <td><strong>{{ $note->moyenne ? number_format($note->moyenne, 2) : '-' }}</strong></td>
                            <td>{{ \Carbon\Carbon::parse($note->created_at)->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="no-notes">Aucune note enregistrée pour le Semestre 2</div>
        @endif
    </div>

    @php
        $moyenneGenerale = $notes->where('moyenne', '!=', null)->avg('moyenne');
    @endphp

    @if($moyenneGenerale)
        <div class="total-section">
            <span class="total-label">Moyenne Générale :</span>
            <span class="total-value">{{ number_format($moyenneGenerale, 2) }}/20</span>
        </div>
    @endif

    <div class="footer">
        <p class="footer-text">
            Ce bulletin de notes est généré automatiquement par le système BJ Académie. <br>
            Pour toute question, veuillez nous contacter à Bjacademie221@gmail.com.
        </p>
    </div>
</body>
</html>

















