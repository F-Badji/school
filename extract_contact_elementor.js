const puppeteer = require('puppeteer');
const fs = require('fs');

async function extractContactPage() {
    const browser = await puppeteer.launch({
        headless: false,
        args: ['--no-sandbox', '--disable-setuid-sandbox', '--disable-blink-features=AutomationControlled']
    });
    
    try {
        const page = await browser.newPage();
        
        // Définir un user agent pour éviter la détection
        await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        
        console.log('Accès à la page de prévisualisation...');
        await page.goto('https://preview.themeforest.net/item/universite-university-school-education-elementor-template-kit/full_screen_preview/60174981', {
            waitUntil: 'networkidle2',
            timeout: 60000
        });
        
        // Attendre que la page se charge complètement
        await page.waitForTimeout(5000);
        
        console.log('Recherche du lien Contact dans le menu...');
        
        // Attendre que le menu soit chargé
        await page.waitForSelector('a, button, .menu-item', { timeout: 30000 });
        
        // Chercher et cliquer sur le lien Contact
        const contactClicked = await page.evaluate(() => {
            // Chercher tous les liens qui contiennent "contact" ou "CONTACT"
            const allLinks = Array.from(document.querySelectorAll('a'));
            const contactLink = allLinks.find(a => {
                const text = a.textContent.trim().toUpperCase();
                const href = (a.getAttribute('href') || '').toLowerCase();
                return text.includes('CONTACT') || href.includes('contact');
            });
            
            if (contactLink) {
                contactLink.click();
                return true;
            }
            return false;
        });
        
        if (!contactClicked) {
            console.log('Lien Contact non trouvé, tentative avec URL directe...');
            // Essayer d'accéder directement à la page contact
            await page.goto('https://kits.yumnatype.com/universite/template-kit/contact/', {
                waitUntil: 'networkidle2',
                timeout: 60000
            });
        } else {
            // Attendre que la page de contact se charge
            await page.waitForTimeout(5000);
            await page.waitForNavigation({ waitUntil: 'networkidle2', timeout: 30000 }).catch(() => {
                console.log('Navigation timeout, continuons...');
            });
        }
        
        // Attendre que le contenu se charge
        await page.waitForTimeout(3000);
        
        console.log('URL actuelle:', page.url());
        
        // Extraire tout le contenu de la page
        console.log('Extraction du contenu de la page de contact...');
        
        const pageContent = await page.evaluate(() => {
            // Trouver le conteneur principal de la page de contact
            // Chercher dans le body, mais exclure header et footer
            const body = document.body;
            const header = document.querySelector('header, #masthead, .site-header');
            const footer = document.querySelector('footer, #colophon, .site-footer');
            
            // Cloner le body
            const bodyClone = body.cloneNode(true);
            
            // Supprimer header et footer du clone si présents
            if (header) {
                const headerClone = bodyClone.querySelector('header, #masthead, .site-header');
                if (headerClone) headerClone.remove();
            }
            if (footer) {
                const footerClone = bodyClone.querySelector('footer, #colophon, .site-footer');
                if (footerClone) footerClone.remove();
            }
            
            return {
                html: bodyClone.innerHTML,
                url: window.location.href
            };
        });
        
        // Extraire aussi le head pour les styles spécifiques
        const headContent = await page.evaluate(() => {
            return document.head.innerHTML;
        });
        
        console.log('Contenu extrait avec succès!');
        console.log('Taille du contenu:', pageContent.html.length, 'caractères');
        
        // Sauvegarder dans un fichier JSON
        const output = {
            url: pageContent.url,
            head: headContent,
            body: pageContent.html,
            timestamp: new Date().toISOString()
        };
        
        fs.writeFileSync('contact_page_elementor.json', JSON.stringify(output, null, 2));
        console.log('✅ Contenu sauvegardé dans contact_page_elementor.json');
        
        // Aussi sauvegarder le HTML complet de la page
        const fullHTML = await page.content();
        fs.writeFileSync('contact_page_elementor_full.html', fullHTML);
        console.log('✅ HTML complet sauvegardé dans contact_page_elementor_full.html');
        
        // Extraire uniquement la section de contenu principal (sans header/footer)
        const mainContent = await page.evaluate(() => {
            // Chercher le conteneur principal de contenu
            const main = document.querySelector('main, .site-main, #main, .elementor-page, [data-elementor-type="wp-page"]');
            if (main) {
                return main.innerHTML;
            }
            return null;
        });
        
        if (mainContent) {
            fs.writeFileSync('contact_page_elementor_main.html', mainContent);
            console.log('✅ Contenu principal sauvegardé dans contact_page_elementor_main.html');
        }
        
    } catch (error) {
        console.error('❌ Erreur lors de l\'extraction:', error);
        console.error(error.stack);
    } finally {
        await browser.close();
        console.log('Navigateur fermé.');
    }
}

extractContactPage();



