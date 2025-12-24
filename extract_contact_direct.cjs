const puppeteer = require('puppeteer');
const fs = require('fs');

async function extractContactPage() {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    try {
        const page = await browser.newPage();
        await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36');
        
        console.log('Accès direct à la page de contact...');
        
        // Accéder directement à la page de contact du template
        await page.goto('https://kits.yumnatype.com/universite/template-kit/contact/', {
            waitUntil: 'networkidle2',
            timeout: 60000
        });
        
        await new Promise(resolve => setTimeout(resolve, 5000));
        
        console.log('URL actuelle:', page.url());
        
        // Extraire le contenu principal (sans header/footer)
        const mainContent = await page.evaluate(() => {
            // Chercher le conteneur principal Elementor
            const elementorPage = document.querySelector('[data-elementor-type="wp-page"]');
            if (elementorPage) {
                return elementorPage.outerHTML;
            }
            
            // Sinon chercher main
            const main = document.querySelector('main, .site-main, #main');
            if (main) {
                return main.innerHTML;
            }
            
            // Sinon retourner le body sans header/footer
            const body = document.body.cloneNode(true);
            const header = body.querySelector('header, #masthead');
            const footer = body.querySelector('footer, #colophon');
            if (header) header.remove();
            if (footer) footer.remove();
            return body.innerHTML;
        });
        
        console.log('Contenu extrait:', mainContent.length, 'caractères');
        
        // Sauvegarder
        fs.writeFileSync('contact_elementor_main.html', mainContent);
        console.log('✅ Sauvegardé dans contact_elementor_main.html');
        
        // Aussi sauvegarder le HTML complet pour référence
        const fullHTML = await page.content();
        fs.writeFileSync('contact_elementor_full.html', fullHTML);
        console.log('✅ HTML complet sauvegardé dans contact_elementor_full.html');
        
    } catch (error) {
        console.error('Erreur:', error.message);
    } finally {
        await browser.close();
    }
}

extractContactPage();

