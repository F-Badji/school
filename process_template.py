#!/usr/bin/env python3
"""
Script pour extraire et adapter le template WordPress pour Laravel Blade
en préservant les formulaires de connexion et d'inscription
"""

import re

# Lire le template HTML extrait
with open('template_html.html', 'r', encoding='utf-8') as f:
    template_html = f.read()

# Lire le home.blade.php actuel pour extraire les formulaires
with open('resources/views/home.blade.php', 'r', encoding='utf-8') as f:
    current_home = f.read()

# Extraire les formulaires de connexion et d'inscription
login_form_match = re.search(r'(<!-- Login Form Overlay -->.*?</form>\s*</div>)', current_home, re.DOTALL)
register_form_match = re.search(r'(<!-- Register Form Overlay -->.*?</form>\s*</div>\s*</div>\s*</div>)', current_home, re.DOTALL)

login_form = login_form_match.group(1) if login_form_match else ""
register_form = register_form_match.group(1) if register_form_match else ""

# Extraire les fonctions JavaScript pour les formulaires
js_match = re.search(r'(// Form toggle functions.*?// S\'assurer.*?</script>)', current_home, re.DOTALL)
js_functions = js_match.group(1) if js_match else ""

# Extraire le head du template WordPress
head_match = re.search(r'(<head>.*?</head>)', template_html, re.DOTALL)
template_head = head_match.group(1) if head_match else ""

# Extraire le body du template WordPress (sans les scripts WordPress)
body_match = re.search(r'(<body[^>]*>.*?</body>)', template_html, re.DOTALL)
template_body = body_match.group(1) if body_match else ""

# Nettoyer le body - retirer les scripts WordPress/Elementor
template_body = re.sub(r'<script[^>]*>.*?</script>', '', template_body, flags=re.DOTALL)
template_body = re.sub(r'<link[^>]*rel="stylesheet"[^>]*>', '', template_body)

# Trouver où insérer les formulaires dans le template (après le hero section)
# Chercher la section hero ou la première section principale
hero_section_match = re.search(r'(<div[^>]*data-elementor-type="wp-page"[^>]*>.*?<div[^>]*class="elementor-element[^"]*e-con-full[^"]*e-flex[^"]*e-con[^"]*e-parent[^"]*"[^>]*>.*?<div[^>]*class="elementor-element[^"]*e-flex[^"]*e-con-boxed[^"]*e-con[^"]*e-child[^"]*"[^>]*>.*?</div>\s*</div>)', template_body, re.DOTALL)

if hero_section_match:
    hero_section = hero_section_match.group(1)
    # Insérer les formulaires après la section hero
    template_body = template_body.replace(hero_section, hero_section + "\n\n" + login_form + "\n\n" + register_form)
else:
    # Si on ne trouve pas la section hero, insérer au début du body
    template_body = template_body.replace('<body', '<body>\n' + login_form + "\n\n" + register_form, 1)

# Créer le nouveau home.blade.php
new_home = f"""<!DOCTYPE html>
<html lang="fr">
{template_head.replace('<html lang="en-US">', '').replace('<head>', '<head>')}

{template_body}

<script>
{js_functions}
</script>
</html>
"""

# Sauvegarder
with open('resources/views/home.blade.php.new', 'w', encoding='utf-8') as f:
    f.write(new_home)

print("Template traité avec succès! Fichier créé: resources/views/home.blade.php.new")



