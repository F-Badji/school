import puppeteer from 'puppeteer';

const url = 'https://preview.themeforest.net/item/universite-university-school-education-elementor-template-kit/full_screen_preview/60174981';

async function extractTemplate() {
    console.log('Lancement du navigateur...');
    const browser = await puppeteer.launch({
        headless: false, // Afficher le navigateur pour contourner Cloudflare
        args: ['--no-sandbox', '--disable-setuid-sandbox']
    });
    
    try {
        const page = await browser.newPage();
        
        // Définir un user agent réaliste
        await page.setUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36');
        
        console.log('Chargement de la page...');
        await page.goto(url, {
            waitUntil: 'networkidle2',
            timeout: 60000
        });
        
        // Attendre que la page soit complètement chargée
        console.log('Attente du chargement complet...');
        await new Promise(resolve => setTimeout(resolve, 5000));
        
        // Attendre que l'iframe soit chargé et extraire son contenu
        console.log('Recherche de l\'iframe...');
        const iframeUrl = 'https://kits.yumnatype.com/universite/';
        
        // Naviguer directement vers l'URL du template
        console.log('Navigation vers le template...');
        await page.goto(iframeUrl, {
            waitUntil: 'networkidle2',
            timeout: 60000
        });
        
        // Attendre que la page soit complètement chargée
        await new Promise(resolve => setTimeout(resolve, 5000));
        
        // Extraire le HTML complet
        console.log('Extraction du HTML...');
        const html = await page.content();
        
        // Extraire tous les styles (inline et dans les balises <style>)
        const styles = await page.evaluate(() => {
            let allStyles = '';
            
            // Récupérer tous les styles inline
            const styleSheets = Array.from(document.styleSheets);
            styleSheets.forEach(sheet => {
                try {
                    const rules = Array.from(sheet.cssRules || []);
                    rules.forEach(rule => {
                        allStyles += rule.cssText + '\n';
                    });
                } catch (e) {
                    // Ignorer les erreurs CORS
                }
            });
            
            // Récupérer les balises <style>
            const styleTags = Array.from(document.querySelectorAll('style'));
            styleTags.forEach(tag => {
                allStyles += tag.innerHTML + '\n';
            });
            
            return allStyles;
        });
        
        // Sauvegarder le HTML
        const fs = await import('fs');
        fs.writeFileSync('template_html.html', html, 'utf8');
        console.log('HTML sauvegardé dans template_html.html');
        
        // Sauvegarder les styles
        fs.writeFileSync('template_styles.css', styles, 'utf8');
        console.log('Styles sauvegardés dans template_styles.css');
        
        // Extraire aussi les liens vers les ressources externes (CSS, JS)
        const resources = await page.evaluate(() => {
            const links = Array.from(document.querySelectorAll('link[rel="stylesheet"]'));
            const scripts = Array.from(document.querySelectorAll('script[src]'));
            
            return {
                css: links.map(link => link.href),
                js: scripts.map(script => script.src)
            };
        });
        
        fs.writeFileSync('template_resources.json', JSON.stringify(resources, null, 2), 'utf8');
        console.log('Ressources sauvegardées dans template_resources.json');
        
        console.log('Extraction terminée!');
        
    } catch (error) {
        console.error('Erreur lors de l\'extraction:', error);
    } finally {
        await browser.close();
    }
}

extractTemplate();

