const puppeteer = require('puppeteer');

async function extractContactPage() {
    const browser = await puppeteer.launch({
        headless: true,
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    try {
        const page = await browser.newPage();
        
        // Accéder à la page de prévisualisation du template
        console.log('Accès à la page de prévisualisation...');
        await page.goto('https://preview.themeforest.net/item/universite-university-school-education-elementor-template-kit/full_screen_preview/60174981', {
            waitUntil: 'networkidle2',
            timeout: 60000
        });
        
        // Attendre que la page se charge
        await page.waitForTimeout(3000);
        
        // Chercher le lien "Contact" dans le menu
        console.log('Recherche du lien Contact...');
        await page.evaluate(() => {
            const contactLinks = Array.from(document.querySelectorAll('a')).filter(a => 
                a.textContent.trim().toUpperCase().includes('CONTACT') || 
                a.getAttribute('href')?.includes('contact')
            );
            if (contactLinks.length > 0) {
                contactLinks[0].click();
            }
        });
        
        await page.waitForTimeout(5000);
        
        // Attendre que la page de contact se charge
        await page.waitForSelector('body', { timeout: 30000 });
        
        // Extraire le contenu de la page de contact
        console.log('Extraction du contenu de la page de contact...');
        const contactPageContent = await page.evaluate(() => {
            // Trouver le conteneur principal de la page
            const mainContent = document.querySelector('main') || 
                              document.querySelector('.elementor-page') ||
                              document.querySelector('#page') ||
                              document.body;
            
            return mainContent.innerHTML;
        });
        
        // Extraire aussi le head pour les styles
        const headContent = await page.evaluate(() => {
            return document.head.innerHTML;
        });
        
        console.log('Contenu extrait avec succès!');
        console.log('Taille du contenu:', contactPageContent.length, 'caractères');
        
        // Sauvegarder dans un fichier
        const fs = require('fs');
        const output = {
            head: headContent,
            body: contactPageContent,
            url: page.url()
        };
        
        fs.writeFileSync('contact_page_extracted.json', JSON.stringify(output, null, 2));
        console.log('Contenu sauvegardé dans contact_page_extracted.json');
        
        // Aussi sauvegarder le HTML brut
        const fullHTML = await page.content();
        fs.writeFileSync('contact_page_full.html', fullHTML);
        console.log('HTML complet sauvegardé dans contact_page_full.html');
        
    } catch (error) {
        console.error('Erreur lors de l\'extraction:', error);
    } finally {
        await browser.close();
    }
}

extractContactPage();



