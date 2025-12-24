#!/usr/bin/env python3
"""
Script pour ajouter l'interface de support à tous les fichiers Blade des apprenants
"""

import re
import os

# Liste des fichiers à modifier
files_to_modify = [
    'resources/views/apprenant/messages.blade.php',
    'resources/views/apprenant/notes.blade.php',
    'resources/views/apprenant/examens.blade.php',
    'resources/views/apprenant/devoirs.blade.php',
    'resources/views/apprenant/calendrier.blade.php',
    'resources/views/apprenant/parametres.blade.php',
    'resources/views/apprenant/professeurs.blade.php',
    'resources/views/apprenant/professeur-profil.blade.php',
    'resources/views/apprenant/professeur-algorithmes.blade.php',
    'resources/views/apprenant/professeur-programmation-php.blade.php',
    'resources/views/apprenant/professeur-informatique-gestion.blade.php',
    'resources/views/apprenant/professeur-matiere-generique.blade.php',
    'resources/views/apprenant/cours-editeur.blade.php',
]

# Styles CSS à ajouter
support_styles = """
        /* Support Modal Styles */
        .support-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .support-modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .support-modal {
            background: white;
            border-radius: 24px;
            max-width: 600px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            transform: scale(0.9) translateY(20px);
            transition: all 0.3s ease;
            position: relative;
        }
        .support-modal-overlay.active .support-modal {
            transform: scale(1) translateY(0);
        }
        .support-modal-header {
            position: relative;
            padding: 0;
            border-radius: 24px 24px 0 0;
            overflow: hidden;
        }
        .support-modal-header img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .support-modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            z-index: 10;
        }
        .support-modal-close:hover {
            background: white;
            transform: rotate(90deg);
        }
        .support-modal-content {
            padding: 32px;
        }
        .support-modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1f3a;
            margin-bottom: 12px;
            text-align: center;
        }
        .support-modal-subtitle {
            font-size: 16px;
            color: #6b7280;
            text-align: center;
            margin-bottom: 32px;
        }
        .support-contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        .support-contact-card {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            display: block;
        }
        .support-contact-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            transition: left 0.5s ease;
        }
        .support-contact-card:hover::before {
            left: 100%;
        }
        .support-contact-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
            border-color: #3b82f6;
        }
        .support-contact-card.whatsapp:hover {
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            border-color: #25d366;
        }
        .support-contact-card.instagram:hover {
            background: linear-gradient(135deg, #e4405f 0%, #c13584 100%);
            border-color: #e4405f;
        }
        .support-contact-card.gmail:hover {
            background: linear-gradient(135deg, #ea4335 0%, #c5221f 100%);
            border-color: #ea4335;
        }
        .support-contact-card.whatsapp:hover *,
        .support-contact-card.instagram:hover *,
        .support-contact-card.gmail:hover * {
            color: white !important;
        }
        .support-contact-icon {
            width: 64px;
            height: 64px;
            margin: 0 auto 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        .support-contact-card:hover .support-contact-icon {
            transform: scale(1.1) rotate(5deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .support-contact-icon img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }
        .support-contact-label {
            font-size: 16px;
            font-weight: 600;
            color: #1a1f3a;
            margin-bottom: 4px;
            transition: color 0.3s ease;
        }
        .support-contact-value {
            font-size: 14px;
            color: #6b7280;
            transition: color 0.3s ease;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .support-contact-card {
            animation: fadeInUp 0.5s ease backwards;
        }
        .support-contact-card:nth-child(1) {
            animation-delay: 0.1s;
        }
        .support-contact-card:nth-child(2) {
            animation-delay: 0.2s;
        }
        .support-contact-card:nth-child(3) {
            animation-delay: 0.3s;
        }
"""

# HTML de la modale
support_modal_html = """
    <!-- Support Modal -->
    <div id="supportModal" class="support-modal-overlay">
        <div class="support-modal">
            <div class="support-modal-header">
                <img src="{{ asset('assets/images/assistance.jpeg') }}" alt="Assistance">
                <div class="support-modal-close" id="supportModalClose">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
            <div class="support-modal-content">
                <h2 class="support-modal-title">Besoin d'aide ?</h2>
                <p class="support-modal-subtitle">Contactez notre équipe de support via les canaux ci-dessous</p>
                
                <div class="support-contact-grid">
                    <a href="https://wa.me/221769719383" target="_blank" class="support-contact-card whatsapp">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/WhatsApp.png') }}" alt="WhatsApp">
                        </div>
                        <div class="support-contact-label">WhatsApp</div>
                        <div class="support-contact-value">Chat direct</div>
                    </a>
                    
                    <a href="mailto:filybadji2020@gmail.com" class="support-contact-card gmail">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Gmail.png') }}" alt="Gmail">
                        </div>
                        <div class="support-contact-label">Gmail</div>
                        <div class="support-contact-value">filybadji2020@gmail.com</div>
                    </a>
                    
                    <a href="#" class="support-contact-card instagram">
                        <div class="support-contact-icon">
                            <img src="{{ asset('assets/images/Instagram.png') }}" alt="Instagram">
                        </div>
                        <div class="support-contact-label">Instagram</div>
                        <div class="support-contact-value">Suivez-nous</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
"""

# JavaScript pour la modale
support_js = """
        // Support Modal functionality
        const supportBtn = document.getElementById('supportBtn');
        const supportModal = document.getElementById('supportModal');
        const supportModalClose = document.getElementById('supportModalClose');

        if (supportBtn && supportModal) {
            supportBtn.addEventListener('click', function(e) {
                e.preventDefault();
                supportModal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        }

        if (supportModalClose && supportModal) {
            supportModalClose.addEventListener('click', function() {
                supportModal.classList.remove('active');
                document.body.style.overflow = '';
            });
        }

        if (supportModal) {
            supportModal.addEventListener('click', function(e) {
                if (e.target === supportModal) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && supportModal.classList.contains('active')) {
                    supportModal.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });
        }
"""

def add_support_interface(filepath):
    """Ajoute l'interface de support à un fichier Blade"""
    if not os.path.exists(filepath):
        print(f"Fichier non trouvé: {filepath}")
        return False
    
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()
    
    # Vérifier si l'interface est déjà ajoutée
    if 'support-modal-overlay' in content:
        print(f"Interface déjà présente dans {filepath}")
        return False
    
    # 1. Modifier le bouton Support pour ajouter l'ID
    support_button_pattern = r'(<a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg ">\s*<svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">\s*<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18\.364 5\.636l-3\.536 3\.536m0 5\.656l3\.536 3\.536M9\.172 9\.172L5\.636 5\.636m3\.536 9\.192l-3\.536 3\.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>\s*</svg>\s*<span class="sidebar-text font-medium">Support</span>\s*</a>)'
    support_button_replacement = r'<a href="#" id="supportBtn" class="flex items-center gap-3 px-4 py-3 rounded-lg ">\n                    <svg class="w-6 h-6 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">\n                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>\n                    </svg>\n                    <span class="sidebar-text font-medium">Support</span>\n                </a>'
    content = re.sub(support_button_pattern, support_button_replacement, content, flags=re.MULTILINE | re.DOTALL)
    
    # 2. Ajouter les styles CSS avant </style>
    if '</style>' in content:
        content = content.replace('</style>', support_styles + '\n    </style>')
    
    # 3. Ajouter le JavaScript avant </script> (dernière occurrence)
    if '</script>' in content:
        # Trouver la dernière occurrence de </script> avant </body>
        last_script_pos = content.rfind('</script>', 0, content.find('</body>'))
        if last_script_pos != -1:
            content = content[:last_script_pos] + support_js + '\n    ' + content[last_script_pos:]
    
    # 4. Ajouter le HTML de la modale avant </body>
    if '</body>' in content:
        content = content.replace('</body>', support_modal_html + '\n</body>')
    
    # Sauvegarder le fichier
    with open(filepath, 'w', encoding='utf-8') as f:
        f.write(content)
    
    print(f"✓ Interface de support ajoutée à {filepath}")
    return True

if __name__ == '__main__':
    base_dir = '/Applications/XAMPP/xamppfiles/htdocs/education'
    for filepath in files_to_modify:
        full_path = os.path.join(base_dir, filepath)
        add_support_interface(full_path)




