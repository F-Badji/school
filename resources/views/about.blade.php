<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>À propos — BJ Académie</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; }
        body {
            background: #f5f5f5;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #cccccc;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }
        .header {
            background: #f5f5f5;
            border-bottom: 1px solid #cccccc;
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            font-size: 18px;
            font-weight: 600;
            margin: 0;
            color: #333333;
        }
        .back-link {
            color: #065b32;
            text-decoration: none;
            font-size: 14px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .content {
            padding: 30px;
        }
        .content h2 {
            color: #000000;
            font-size: 16px;
            font-weight: 600;
            margin-top: 30px;
            margin-bottom: 12px;
        }
        .content h2:first-of-type {
            margin-top: 0;
        }
        .content p {
            color: #333333;
            line-height: 1.6;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .content p strong {
            color: #000000;
            font-weight: 600;
        }
        .content ul {
            color: #333333;
            line-height: 1.6;
            margin-bottom: 15px;
            padding-left: 20px;
        }
        .content ul li {
            margin-bottom: 6px;
            font-size: 14px;
        }
        .footer {
            border-top: 1px solid #e0e0e0;
            padding: 15px 30px;
            background: #f9f9f9;
            text-align: right;
        }
        .footer-date {
            color: #666666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🏫 À propos de BJ Académie</h1>
            <a href="{{ route('home') }}" class="back-link">← Retour à l'accueil</a>
        </div>
        <div class="content">
            <h2>1. Notre mission</h2>
            <p>
                Chez BJ Académie, nous avons pour mission de rendre l'éducation de qualité accessible à tous, où qu'ils se trouvent.
            </p>
            <p>
                En tant qu'école de formation à distance et centre de perfectionnement professionnel, nous visons à favoriser l'épanouissement personnel et l'excellence professionnelle.
            </p>
            <p>
                Nous croyons que l'apprentissage continu est la clé du succès dans un monde en constante évolution.
            </p>
            <p>
                C'est pourquoi nos programmes de formation sont pratiques, flexibles et adaptés aux besoins réels du marché du travail.
            </p>
            
            <h2>2. Nos valeurs</h2>
            <p>
                Nos actions reposent sur des valeurs fortes qui guident notre vision :
            </p>
            <ul>
                <li>🎯 <strong>Excellence</strong> – Offrir des formations de haut niveau et un accompagnement de qualité.</li>
                <li>🌍 <strong>Accessibilité</strong> – Permettre à tous d'apprendre, quel que soit le lieu ou le niveau.</li>
                <li>💡 <strong>Innovation</strong> – Utiliser les technologies modernes et des approches pédagogiques actives.</li>
                <li>🤝 <strong>Éthique</strong> – Promouvoir la transparence, le respect et l'intégrité.</li>
                <li>🧭 <strong>Accompagnement</strong> – Suivre chaque apprenant tout au long de son parcours.</li>
            </ul>
            
            <h2>3. Nos domaines d'expertise</h2>
            <p>
                BJ Académie se spécialise dans plusieurs secteurs clés :
            </p>
            <ul>
                <li>Développement personnel et soft skills</li>
                <li>Formations professionnelles et métiers</li>
                <li>Technologies de l'information et du numérique</li>
                <li>Entrepreneuriat et gestion d'entreprise</li>
                <li>Langues et communication</li>
                <li>Marketing digital et communication en ligne</li>
            </ul>
            
            <h2>4. Notre pédagogie</h2>
            <p>
                Notre approche est centrée sur l'apprenant et axée sur la pratique.
            </p>
            <p>
                Chaque formation comprend :
            </p>
            <ul>
                <li>Des modules pédagogiques actualisés</li>
                <li>Des vidéos de cours et tutoriels pratiques</li>
                <li>Des quiz interactifs pour évaluer les acquis</li>
                <li>Un suivi personnalisé par des formateurs qualifiés</li>
                <li>Des sessions de tutorat individuelles</li>
                <li>Une certification reconnue à la fin du parcours</li>
            </ul>
            
            <h2>5. Nos engagements</h2>
            <p>
                Nous nous engageons à :
            </p>
            <ul>
                <li>✅ Offrir des formations de qualité répondant aux besoins du marché</li>
                <li>✅ Garantir la confidentialité et la sécurité des données personnelles</li>
                <li>✅ Fournir un support rapide et professionnel</li>
                <li>✅ Assurer une plateforme fluide, performante et sécurisée</li>
                <li>✅ Innover en continu pour améliorer l'expérience apprenant</li>
            </ul>
            
            <h2>6. Notre équipe</h2>
            <p>
                Notre équipe est composée de formateurs expérimentés et passionnés, chacun expert dans son domaine.
            </p>
            <p>
                Ils sont choisis pour :
            </p>
            <ul>
                <li>Leur compétence technique,</li>
                <li>Leur expérience terrain,</li>
                <li>Et leur capacité à transmettre le savoir de façon claire et motivante.</li>
            </ul>
            <p>
                L'équipe administrative accompagne également les apprenants pour un suivi complet et personnalisé.
            </p>
            
            <h2>7. Notre localisation</h2>
            <p>
                📍 <strong>Adresse :</strong> Sicap Liberté 6, 11500 Dakar, Sénégal<br>
                📞 <strong>Téléphone :</strong> +221 76 971 93 83<br>
                ✉️ <strong>E-mail :</strong> contact@academie.com
            </p>
            <p>
                Nos formations étant en ligne, les apprenants du monde entier peuvent suivre nos programmes depuis leur domicile.
            </p>
            
            <h2>8. Nos horaires</h2>
            <p>
                🕒 <strong>Heures d'ouverture :</strong><br>
                Lundi au Samedi — 08h à 18h
            </p>
            <p>
                Notre service d'assistance reste disponible pour répondre à toutes vos questions durant ces horaires.
            </p>
            
            <h2>9. Rejoignez-nous</h2>
            <p>
                ✨ Vous souhaitez acquérir de nouvelles compétences, vous reconvertir ou enrichir votre savoir ?
            </p>
            <p>
                BJ Académie est votre partenaire de réussite.
            </p>
            <p>
                Rejoignez notre communauté d'apprenants dès aujourd'hui et commencez votre parcours vers l'excellence.
            </p>
            
            <h2>10. Contact</h2>
            <p>
                📍 <strong>Adresse :</strong> Sicap Liberté 6, 11500 Dakar, Sénégal<br>
                📞 <strong>Téléphone :</strong> +221 76 971 93 83<br>
                ✉️ <strong>E-mail :</strong> contact@academie.com<br>
                🌐 <strong>Site web :</strong> www.academie.com
            </p>
        </div>
        <div class="footer">
            <p class="footer-date">✅ Dernière mise à jour : 31 Novembre 2025</p>
        </div>
    </div>
</body>
</html>

