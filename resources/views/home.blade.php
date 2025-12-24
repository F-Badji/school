<!DOCTYPE html><html lang="en-US"><head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="/">
	<title>Bj Académie</title>
<meta name="robots" content="max-image-preview:large">
	<style>img:is([sizes="auto" i], [sizes^="auto," i]) { contain-intrinsic-size: 3000px 1500px }
	@keyframes bounceArrow {
		0%, 100% { transform: translateY(0); }
		50% { transform: translateY(-10px); }
	}
	@keyframes floatSlow {
		0%, 100% { transform: translateY(0px) rotate(0deg); }
		25% { transform: translateY(-15px) rotate(1deg); }
		50% { transform: translateY(-10px) rotate(0deg); }
		75% { transform: translateY(-15px) rotate(-1deg); }
	}
	/* Styles pour les titres de posts - gras avec animation rouge au survol mais non cliquables */
	.post-title {
		font-weight: 900 !important;
		font-size: 1.2rem !important;
		color: #1a1a1a !important;
		cursor: default !important;
		transition: color 0.3s ease !important;
		user-select: none !important;
	}
	.post-title:hover {
		color: #DC2626 !important;
	}
	/* Style pour le bouton de connexion désactivé */
	#login-submit-btn:disabled {
		opacity: 0.6;
		cursor: not-allowed !important;
		background: #9ca3af !important;
		color: #ffffff !important;
	}
	#login-submit-btn:disabled:hover {
		background: #9ca3af !important;
		transform: none !important;
		box-shadow: none !important;
	}
	/* Styles professionnels pour les formulaires */
	#form-login-container,
	#form-register-container {
		background: linear-gradient(135deg, rgba(0, 0, 0, 0.75) 0%, rgba(0, 0, 0, 0.85) 100%) !important;
		backdrop-filter: blur(20px) saturate(180%);
		-webkit-backdrop-filter: blur(20px) saturate(180%);
		border: 1px solid rgba(255, 255, 255, 0.18) !important;
		border-radius: 24px !important;
		box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37),
					0 0 0 1px rgba(255, 255, 255, 0.05) inset,
					0 1px 0 rgba(255, 255, 255, 0.1) inset !important;
		padding: 2.5rem !important;
		transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
		max-width: 480px;
		margin: 2rem auto;
	}
	
	#form-login-container:hover,
	#form-register-container:hover {
		transform: translateY(-2px);
		box-shadow: 0 12px 40px 0 rgba(0, 0, 0, 0.45),
					0 0 0 1px rgba(255, 255, 255, 0.08) inset !important;
	}
	
	/* Typographie professionnelle */
	#form-login-container h2,
	#form-register-container h2 {
		color: white !important;
		font-size: 2rem !important;
		font-weight: 700 !important;
		letter-spacing: -0.02em;
		margin-bottom: 0.5rem !important;
		background: linear-gradient(135deg, #ffffff 0%, rgba(255, 255, 255, 0.9) 100%);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
		background-clip: text;
	}
	
	#form-login-container p,
	#form-register-container p {
		color: rgba(255, 255, 255, 0.85) !important;
		font-size: 0.95rem;
		line-height: 1.6;
		margin-bottom: 2rem !important;
	}
	
	/* Labels professionnels */
	#form-login-container label,
	#form-register-container label {
		color: rgba(255, 255, 255, 0.95) !important;
		font-size: 0.875rem !important;
		font-weight: 600 !important;
		letter-spacing: 0.01em;
		margin-bottom: 0.75rem !important;
		display: block;
		text-transform: uppercase;
		font-size: 0.75rem;
		letter-spacing: 0.1em;
	}
	
	/* Champs de saisie professionnels */
	#form-login-container input[type="text"],
	#form-login-container input[type="email"],
	#form-login-container input[type="password"],
	#form-login-container input[type="date"],
	#form-register-container input[type="text"],
	#form-register-container input[type="email"],
	#form-register-container input[type="password"],
	#form-register-container input[type="date"],
	#form-register-container select {
		color: white !important;
		background: rgba(255, 255, 255, 0.08) !important;
		border: 1.5px solid rgba(255, 255, 255, 0.2) !important;
		border-radius: 12px !important;
		padding: 0.875rem 1.25rem !important;
		font-size: 0.95rem;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		width: 100%;
		backdrop-filter: blur(10px);
	}
	
	#form-login-container input:focus,
	#form-register-container input:focus,
	#form-register-container select:focus {
		outline: none !important;
		background: rgba(255, 255, 255, 0.12) !important;
		border-color: rgba(255, 255, 255, 0.5) !important;
		box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1),
					0 4px 12px rgba(0, 0, 0, 0.15) !important;
		transform: translateY(-1px);
	}
	
	#form-login-container input::placeholder,
	#form-register-container input::placeholder {
		color: rgba(255, 255, 255, 0.5) !important;
		opacity: 1 !important;
		font-weight: 400;
	}
	
	/* Champ fichier professionnel */
	#form-register-container input[type="file"] {
		padding: 1rem !important;
		cursor: pointer;
	}
	
	#form-register-container input[type="file"]::file-selector-button {
		color: white !important;
		background: rgba(255, 255, 255, 0.15) !important;
		border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
		border-radius: 8px !important;
		padding: 0.5rem 1rem !important;
		margin-right: 1rem;
		font-weight: 600;
		transition: all 0.3s ease;
		cursor: pointer;
	}
	
	#form-register-container input[type="file"]::file-selector-button:hover {
		background: rgba(255, 255, 255, 0.25) !important;
		transform: scale(1.02);
	}
	
	/* Select professionnel */
	#form-register-container select {
		cursor: pointer;
		appearance: none;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='white' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
		background-repeat: no-repeat;
		background-position: right 1rem center;
		padding-right: 2.5rem !important;
	}
	
	#form-login-container select option,
	#form-register-container select option {
		color: #1a1a1a !important;
		background-color: white !important;
		padding: 0.75rem;
	}
	
	/* Boutons professionnels */
	#form-login-container button[type="submit"],
	#form-register-container button[type="submit"] {
		background: linear-gradient(135deg, rgba(255, 255, 255, 0.2) 0%, rgba(255, 255, 255, 0.15) 100%) !important;
		border: 1.5px solid rgba(255, 255, 255, 0.3) !important;
		border-radius: 12px !important;
		padding: 1rem 2rem !important;
		font-weight: 600 !important;
		letter-spacing: 0.05em;
		text-transform: uppercase;
		font-size: 0.875rem;
		transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
		width: 100%;
		margin-top: 1.5rem;
	}
	
	#form-login-container button[type="submit"]:hover:not(:disabled),
	#form-register-container button[type="submit"]:hover:not(:disabled) {
		background: linear-gradient(135deg, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.2) 100%) !important;
		border-color: rgba(255, 255, 255, 0.5) !important;
		transform: translateY(-2px);
		box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
	}
	
	#form-login-container button[type="submit"]:active:not(:disabled),
	#form-register-container button[type="submit"]:active:not(:disabled) {
		transform: translateY(0);
	}
	
	/* Liens et boutons texte */
	#form-login-container a,
	#form-register-container a,
	#form-login-container button[type="button"],
	#form-register-container button[type="button"] {
		color: rgba(255, 255, 255, 0.9) !important;
		font-weight: 600;
		transition: all 0.2s ease;
		text-decoration: none;
	}
	
	#form-login-container a:hover,
	#form-register-container a:hover,
	#form-login-container button[type="button"]:hover,
	#form-register-container button[type="button"]:hover {
		color: white !important;
		text-shadow: 0 0 8px rgba(255, 255, 255, 0.5);
	}
	
	/* Checkbox professionnel */
	#form-login-container input[type="checkbox"],
	#form-register-container input[type="checkbox"] {
		width: 1.25rem;
		height: 1.25rem;
		border-radius: 4px;
		border: 1.5px solid rgba(255, 255, 255, 0.3);
		background: rgba(255, 255, 255, 0.1);
		cursor: pointer;
		transition: all 0.2s ease;
	}
	
	#form-login-container input[type="checkbox"]:checked,
	#form-register-container input[type="checkbox"]:checked {
		background: rgba(255, 255, 255, 0.9);
		border-color: rgba(255, 255, 255, 0.9);
	}
	
	/* Espacement professionnel */
	#form-login-container .space-y-4 > * + *,
	#form-register-container .space-y-4 > * + * {
		margin-top: 1.5rem;
	}
	
	/* Animation d'entrée */
	@keyframes slideInUp {
		from {
			opacity: 0;
			transform: translateY(20px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
	}
	
	#form-login-container,
	#form-register-container {
		animation: slideInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1);
	}
	
	/* Messages d'erreur professionnels */
	#login-error-message,
	#form-register-container .text-red-500 {
		background: rgba(239, 68, 68, 0.15) !important;
		border: 1px solid rgba(239, 68, 68, 0.4) !important;
		border-radius: 12px !important;
		padding: 1rem 1.25rem !important;
		backdrop-filter: blur(10px);
		box-shadow: 0 4px 12px rgba(239, 68, 68, 0.1);
		margin-bottom: 1.5rem;
	}
	
	#login-error-message svg,
	#form-register-container .text-red-500 svg {
		color: rgba(248, 113, 113, 1) !important;
	}
	
	#login-error-message p,
	#form-register-container .text-red-500 {
		color: rgba(254, 226, 226, 0.95) !important;
		font-weight: 500;
		font-size: 0.875rem;
		line-height: 1.5;
	}
	
	/* Responsive design */
	@media (max-width: 640px) {
		#form-login-container,
		#form-register-container {
			padding: 1.75rem !important;
			margin: 1rem;
			border-radius: 20px !important;
		}
		
		#form-login-container h2,
		#form-register-container h2 {
			font-size: 1.75rem !important;
		}
	}
	</style>
	<link rel="alternate" type="application/rss+xml" title="Bj Académie » Feed" href="/">
<link rel="alternate" type="application/rss+xml" title="Bj Académie » Comments Feed" href="/">
<script>
window._wpemojiSettings = {"baseUrl":"https:\/\/s.w.org\/images\/core\/emoji\/16.0.1\/72x72\/","ext":".png","svgUrl":"https:\/\/s.w.org\/images\/core\/emoji\/16.0.1\/svg\/","svgExt":".svg","source":{"concatemoji":"https:\/\/kits.yumnatype.com\/universite\/wp-includes\/js\/wp-emoji-release.min.js?ver=6.8.3"}};
/*! This file is auto-generated */
!function(s,n){var o,i,e;function c(e){try{var t={supportTests:e,timestamp:(new Date).valueOf()};sessionStorage.setItem(o,JSON.stringify(t))}catch(e){}}function p(e,t,n){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);var t=new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data),a=(e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(n,0,0),new Uint32Array(e.getImageData(0,0,e.canvas.width,e.canvas.height).data));return t.every(function(e,t){return e===a[t]})}function u(e,t){e.clearRect(0,0,e.canvas.width,e.canvas.height),e.fillText(t,0,0);for(var n=e.getImageData(16,16,1,1),a=0;a<n.data.length;a++)if(0!==n.data[a])return!1;return!0}function f(e,t,n,a){switch(t){case"flag":return n(e,"\ud83c\udff3\ufe0f\u200d\u26a7\ufe0f","\ud83c\udff3\ufe0f\u200b\u26a7\ufe0f")?!1:!n(e,"\ud83c\udde8\ud83c\uddf6","\ud83c\udde8\u200b\ud83c\uddf6")&&!n(e,"\ud83c\udff4\udb40\udc67\udb40\udc62\udb40\udc65\udb40\udc6e\udb40\udc67\udb40\udc7f","\ud83c\udff4\u200b\udb40\udc67\u200b\udb40\udc62\u200b\udb40\udc65\u200b\udb40\udc6e\u200b\udb40\udc67\u200b\udb40\udc7f");case"emoji":return!a(e,"\ud83e\udedf")}return!1}function g(e,t,n,a){var r="undefined"!=typeof WorkerGlobalScope&&self instanceof WorkerGlobalScope?new OffscreenCanvas(300,150):s.createElement("canvas"),o=r.getContext("2d",{willReadFrequently:!0}),i=(o.textBaseline="top",o.font="600 32px Arial",{});return e.forEach(function(e){i[e]=t(o,e,n,a)}),i}function t(e){var t=s.createElement("script");t.src=e,t.defer=!0,s.head.appendChild(t)}"undefined"!=typeof Promise&&(o="wpEmojiSettingsSupports",i=["flag","emoji"],n.supports={everything:!0,everythingExceptFlag:!0},e=new Promise(function(e){s.addEventListener("DOMContentLoaded",e,{once:!0})}),new Promise(function(t){var n=function(){try{var e=JSON.parse(sessionStorage.getItem(o));if("object"==typeof e&&"number"==typeof e.timestamp&&(new Date).valueOf()<e.timestamp+604800&&"object"==typeof e.supportTests)return e.supportTests}catch(e){}return null}();if(!n){if("undefined"!=typeof Worker&&"undefined"!=typeof OffscreenCanvas&&"undefined"!=typeof URL&&URL.createObjectURL&&"undefined"!=typeof Blob)try{var e="postMessage("+g.toString()+"("+[JSON.stringify(i),f.toString(),p.toString(),u.toString()].join(",")+"));",a=new Blob([e],{type:"text/javascript"}),r=new Worker(URL.createObjectURL(a),{name:"wpTestEmojiSupports"});return void(r.onmessage=function(e){c(n=e.data),r.terminate(),t(n)})}catch(e){}c(n=g(i,f,p,u))}t(n)}).then(function(e){for(var t in e)n.supports[t]=e[t],n.supports.everything=n.supports.everything&&n.supports[t],"flag"!==t&&(n.supports.everythingExceptFlag=n.supports.everythingExceptFlag&&n.supports[t]);n.supports.everythingExceptFlag=n.supports.everythingExceptFlag&&!n.supports.flag,n.DOMReady=!1,n.readyCallback=function(){n.DOMReady=!0}}).then(function(){return e}).then(function(){var e;n.supports.everything||(n.readyCallback(),(e=n.source||{}).concatemoji?t(e.concatemoji):e.wpemoji&&e.twemoji&&(t(e.twemoji),t(e.wpemoji)))}))}((window,document),window._wpemojiSettings);
</script>
<link rel="stylesheet" id="hfe-widgets-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/header-footer-elementor/inc/widgets-css/frontend.css?ver=2.3.1" media="all">
<link rel="stylesheet" id="gum-elementor-addon-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon/css/style.css?ver=6.8.3" media="all">
<link rel="stylesheet" id="jkit-elements-main-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/css/elements/main.css?ver=2.6.13" media="all">
<style id="wp-emoji-styles-inline-css">

	img.wp-smiley, img.emoji {
		display: inline !important;
		border: none !important;
		box-shadow: none !important;
		height: 1em !important;
		width: 1em !important;
		margin: 0 0.07em !important;
		vertical-align: -0.1em !important;
		background: none !important;
		padding: 0 !important;
	}
</style>
<style id="classic-theme-styles-inline-css">
/*! This file is auto-generated */
.wp-block-button__link{color:#fff;background-color:#32373c;border-radius:9999px;box-shadow:none;text-decoration:none;padding:calc(.667em + 2px) calc(1.333em + 2px);font-size:1.125em}.wp-block-file__button{background:#32373c;color:#fff;text-decoration:none}
</style>
<style id="global-styles-inline-css">
:root{--wp--preset--aspect-ratio--square: 1;--wp--preset--aspect-ratio--4-3: 4/3;--wp--preset--aspect-ratio--3-4: 3/4;--wp--preset--aspect-ratio--3-2: 3/2;--wp--preset--aspect-ratio--2-3: 2/3;--wp--preset--aspect-ratio--16-9: 16/9;--wp--preset--aspect-ratio--9-16: 9/16;--wp--preset--color--black: #000000;--wp--preset--color--cyan-bluish-gray: #abb8c3;--wp--preset--color--white: #ffffff;--wp--preset--color--pale-pink: #f78da7;--wp--preset--color--vivid-red: #cf2e2e;--wp--preset--color--luminous-vivid-orange: #ff6900;--wp--preset--color--luminous-vivid-amber: #fcb900;--wp--preset--color--light-green-cyan: #7bdcb5;--wp--preset--color--vivid-green-cyan: #00d084;--wp--preset--color--pale-cyan-blue: #8ed1fc;--wp--preset--color--vivid-cyan-blue: #0693e3;--wp--preset--color--vivid-purple: #9b51e0;--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);--wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);--wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);--wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);--wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);--wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);--wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);--wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);--wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);--wp--preset--font-size--small: 13px;--wp--preset--font-size--medium: 20px;--wp--preset--font-size--large: 36px;--wp--preset--font-size--x-large: 42px;--wp--preset--spacing--20: 0.44rem;--wp--preset--spacing--30: 0.67rem;--wp--preset--spacing--40: 1rem;--wp--preset--spacing--50: 1.5rem;--wp--preset--spacing--60: 2.25rem;--wp--preset--spacing--70: 3.38rem;--wp--preset--spacing--80: 5.06rem;--wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);--wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);--wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);--wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);--wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);}:where(.is-layout-flex){gap: 0.5em;}:where(.is-layout-grid){gap: 0.5em;}body .is-layout-flex{display: flex;}.is-layout-flex{flex-wrap: wrap;align-items: center;}.is-layout-flex > :is(*, div){margin: 0;}body .is-layout-grid{display: grid;}.is-layout-grid > :is(*, div){margin: 0;}:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}.has-black-color{color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-color{color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-color{color: var(--wp--preset--color--white) !important;}.has-pale-pink-color{color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-color{color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-color{color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-color{color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-color{color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-color{color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-color{color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-color{color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-color{color: var(--wp--preset--color--vivid-purple) !important;}.has-black-background-color{background-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-background-color{background-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-background-color{background-color: var(--wp--preset--color--white) !important;}.has-pale-pink-background-color{background-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-background-color{background-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-background-color{background-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-background-color{background-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-background-color{background-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-background-color{background-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-background-color{background-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-background-color{background-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-background-color{background-color: var(--wp--preset--color--vivid-purple) !important;}.has-black-border-color{border-color: var(--wp--preset--color--black) !important;}.has-cyan-bluish-gray-border-color{border-color: var(--wp--preset--color--cyan-bluish-gray) !important;}.has-white-border-color{border-color: var(--wp--preset--color--white) !important;}.has-pale-pink-border-color{border-color: var(--wp--preset--color--pale-pink) !important;}.has-vivid-red-border-color{border-color: var(--wp--preset--color--vivid-red) !important;}.has-luminous-vivid-orange-border-color{border-color: var(--wp--preset--color--luminous-vivid-orange) !important;}.has-luminous-vivid-amber-border-color{border-color: var(--wp--preset--color--luminous-vivid-amber) !important;}.has-light-green-cyan-border-color{border-color: var(--wp--preset--color--light-green-cyan) !important;}.has-vivid-green-cyan-border-color{border-color: var(--wp--preset--color--vivid-green-cyan) !important;}.has-pale-cyan-blue-border-color{border-color: var(--wp--preset--color--pale-cyan-blue) !important;}.has-vivid-cyan-blue-border-color{border-color: var(--wp--preset--color--vivid-cyan-blue) !important;}.has-vivid-purple-border-color{border-color: var(--wp--preset--color--vivid-purple) !important;}.has-vivid-cyan-blue-to-vivid-purple-gradient-background{background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;}.has-light-green-cyan-to-vivid-green-cyan-gradient-background{background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;}.has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;}.has-luminous-vivid-orange-to-vivid-red-gradient-background{background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;}.has-very-light-gray-to-cyan-bluish-gray-gradient-background{background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;}.has-cool-to-warm-spectrum-gradient-background{background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;}.has-blush-light-purple-gradient-background{background: var(--wp--preset--gradient--blush-light-purple) !important;}.has-blush-bordeaux-gradient-background{background: var(--wp--preset--gradient--blush-bordeaux) !important;}.has-luminous-dusk-gradient-background{background: var(--wp--preset--gradient--luminous-dusk) !important;}.has-pale-ocean-gradient-background{background: var(--wp--preset--gradient--pale-ocean) !important;}.has-electric-grass-gradient-background{background: var(--wp--preset--gradient--electric-grass) !important;}.has-midnight-gradient-background{background: var(--wp--preset--gradient--midnight) !important;}.has-small-font-size{font-size: var(--wp--preset--font-size--small) !important;}.has-medium-font-size{font-size: var(--wp--preset--font-size--medium) !important;}.has-large-font-size{font-size: var(--wp--preset--font-size--large) !important;}.has-x-large-font-size{font-size: var(--wp--preset--font-size--x-large) !important;}
:where(.wp-block-post-template.is-layout-flex){gap: 1.25em;}:where(.wp-block-post-template.is-layout-grid){gap: 1.25em;}
:where(.wp-block-columns.is-layout-flex){gap: 2em;}:where(.wp-block-columns.is-layout-grid){gap: 2em;}
:root :where(.wp-block-pullquote){font-size: 1.5em;line-height: 1.6;}
</style>
<link rel="stylesheet" id="template-kit-export-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/template-kit-export/assets/public/template-kit-export-public.css?ver=1.0.23" media="all">
<link rel="stylesheet" id="hfe-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/header-footer-elementor/assets/css/header-footer-elementor.css?ver=2.3.1" media="all">
<link rel="stylesheet" id="elementor-frontend-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/frontend.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="elementor-post-3-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-3.css?ver=1759459613" media="all">
<link rel="stylesheet" id="font-awesome-5-all-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/css/all.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="font-awesome-4-shim-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/css/v4-shims.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="e-animation-fadeInUp-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/animations/styles/fadeInUp.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="e-animation-fadeIn-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/animations/styles/fadeIn.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-spacer-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-spacer.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-icon-list-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-icon-list.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-image-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-image.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-counter-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-counter.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-heading-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-heading.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-divider-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-divider.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="swiper-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/swiper/v8/css/swiper.min.css?ver=8.4.5" media="all">
<link rel="stylesheet" id="e-swiper-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/conditionals/e-swiper.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-image-carousel-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-image-carousel.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="e-animation-fadeInLeft-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/animations/styles/fadeInLeft.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="e-animation-fadeInRight-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/animations/styles/fadeInRight.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="sweetalert2-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/sweetalert2/sweetalert2.min.css?ver=11.6.16" media="all">
<link rel="stylesheet" id="e-animation-slideInLeft-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/animations/styles/slideInLeft.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-icon-box-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-icon-box.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="tiny-slider-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/tiny-slider/tiny-slider.css?ver=2.9.3" media="all">
<link rel="stylesheet" id="elementor-post-30-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-30.css?ver=1759460114" media="all">
<link rel="stylesheet" id="elementor-post-28-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-28.css?ver=1759459613" media="all">
<link rel="stylesheet" id="elementor-post-132-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-132.css?ver=1759459613" media="all">
<link rel="stylesheet" id="hello-elementor-css" href="https://kits.yumnatype.com/universite/wp-content/themes/hello-elementor/style.min.css?ver=2.8.1" media="all">
<link rel="stylesheet" id="hello-elementor-theme-style-css" href="https://kits.yumnatype.com/universite/wp-content/themes/hello-elementor/theme.min.css?ver=2.8.1" media="all">
<link rel="stylesheet" id="hfe-elementor-icons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css?ver=5.34.0" media="all">
<link rel="stylesheet" id="hfe-icons-list-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-icon-list.min.css?ver=3.24.3" media="all">
<link rel="stylesheet" id="hfe-social-icons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-social-icons.min.css?ver=3.24.0" media="all">
<link rel="stylesheet" id="hfe-social-share-icons-brands-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.css?ver=5.15.3" media="all">
<link rel="stylesheet" id="hfe-social-share-icons-fontawesome-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.css?ver=5.15.3" media="all">
<link rel="stylesheet" id="hfe-nav-menu-icons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.css?ver=5.15.3" media="all">
<link rel="stylesheet" id="ekit-widget-styles-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/widgets/init/assets/css/widget-styles.css?ver=3.5.1" media="all">
<link rel="stylesheet" id="ekit-responsive-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/widgets/init/assets/css/responsive.css?ver=3.5.1" media="all">
<link rel="stylesheet" id="elementor-gf-local-roboto-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/google-fonts/css/roboto.css?ver=1757035842" media="all">
<link rel="stylesheet" id="elementor-gf-local-robotoslab-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/google-fonts/css/robotoslab.css?ver=1757035844" media="all">
<link rel="stylesheet" id="elementor-gf-local-plusjakartasans-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/google-fonts/css/plusjakartasans.css?ver=1757997147" media="all">
<link rel="stylesheet" id="elementor-icons-jkiticon-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/fonts/jkiticon/jkiticon.css?ver=2.6.13" media="all">
<link rel="stylesheet" id="elementor-icons-ekiticons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/modules/elementskit-icon-pack/assets/css/ekiticons.css?ver=3.5.1" media="all">
<link rel="stylesheet" id="cute-alert-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/lib/cute-alert/style.css?ver=4.0.0" media="all">
<link rel="stylesheet" id="text-editor-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/css/text-editor.css?ver=4.0.0" media="all">
<script src="https://kits.yumnatype.com/universite/wp-includes/js/jquery/jquery.min.js?ver=3.7.1" id="jquery-core-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/jquery/jquery-migrate.min.js?ver=3.4.1" id="jquery-migrate-js"></script>
<script id="jquery-js-after">
!function($){"use strict";$(document).ready(function(){$(this).scrollTop()>100&&$(".hfe-scroll-to-top-wrap").removeClass("hfe-scroll-to-top-hide"),$(window).scroll(function(){$(this).scrollTop()<100?$(".hfe-scroll-to-top-wrap").fadeOut(300):$(".hfe-scroll-to-top-wrap").fadeIn(300)}),$(".hfe-scroll-to-top-wrap").on("click",function(){$("html, body").animate({scrollTop:0},300);return!1})})}(jQuery);
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/template-kit-export/assets/public/template-kit-export-public.js?ver=1.0.23" id="template-kit-export-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/font-awesome/js/v4-shims.min.js?ver=3.28.4" id="font-awesome-4-shim-js"></script>
<link rel="https://api.w.org/" href="/"><link rel="alternate" title="JSON" type="application/json" href="/"><link rel="EditURI" type="application/rsd+xml" title="RSD" href="/">
<meta name="generator" content="WordPress 6.8.3">
<link rel="canonical" href="/">
<link rel="shortlink" href="/">
<link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="/">
<link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="/">
<meta name="generator" content="Elementor 3.28.4; features: e_font_icon_svg, additional_custom_breakpoints, e_local_google_fonts, e_element_cache; settings: css_print_method-external, google_font-enabled, font_display-auto">
			<script>
			// Script de défilement immédiat - s'exécute avant tout le reste
			(function() {
				// Faire défiler vers le haut immédiatement
				if (window.scrollTo) {
					window.scrollTo(0, 0);
				}
				if (document.documentElement) {
					document.documentElement.scrollTop = 0;
				}
				if (document.body) {
					document.body.scrollTop = 0;
				}
				
				// Faire défiler aussi après le chargement
				window.addEventListener('load', function() {
					window.scrollTo(0, 0);
					document.documentElement.scrollTop = 0;
					document.body.scrollTop = 0;
				});
			})();
			</script>
			<script>
			// ============================================
			// FONCTIONS CRITIQUES - DÉFINIES DANS LE HEAD
			// ============================================
			// Ces fonctions DOIVENT être disponibles IMMÉDIATEMENT pour que les onclick fonctionnent
			console.log('🔧 Initialisation des fonctions globales dans le HEAD...');
			
			// Validation immédiate de la taille des fichiers - SÉCURITÉ CRITIQUE (définie dans le HEAD)
			window.validateFileSizeImmediate = function(input, errorElementId, fileName) {
				console.log('validateFileSizeImmediate appelée pour:', fileName, input ? input.files[0]?.name : 'no input');
				
				if (!input || !input.files || input.files.length === 0) {
					console.log('Aucun fichier sélectionné');
					return true;
				}
				
				const maxSize = 5 * 1024 * 1024; // 5MB en bytes (5242880 bytes)
				const file = input.files[0];
				
				if (!file) {
					return true;
				}
				
				console.log('Fichier sélectionné:', file.name, 'Taille:', (file.size / 1024 / 1024).toFixed(2), 'MB');
				
				// Vérification CRITIQUE de la taille
				if (file.size > maxSize) {
					const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
					const errorMessage = `⚠️ Le fichier "${file.name}" (${fileSizeMB} MB) dépasse la limite de 5 MB.\n\nLa taille du fichier doit être inférieure à 5 MB.\n\nVeuillez choisir un fichier plus petit.`;
					
					console.error('FICHIER TROP VOLUMINEUX:', file.name, fileSizeMB, 'MB');
					
					// Afficher l'erreur dans le DOM - FORCER L'AFFICHAGE
					const errorElement = document.getElementById(errorElementId);
					if (errorElement) {
						errorElement.textContent = `⚠️ Le fichier "${file.name}" (${fileSizeMB} MB) dépasse la limite de 5 MB. Veuillez choisir un fichier plus petit.`;
						errorElement.classList.remove('hidden');
						errorElement.style.display = 'block';
						errorElement.style.visibility = 'visible';
						errorElement.style.opacity = '1';
						console.log('Message d\'erreur affiché dans le DOM');
					} else {
						console.error('Élément d\'erreur non trouvé:', errorElementId);
					}
					
					// Réinitialiser le champ
					input.value = '';
					input.classList.add('border-red-500', 'border-2');
					
					// ALERTE OBLIGATOIRE - SÉCURITÉ CRITIQUE
					alert(errorMessage);
					
					// Scroll vers l'erreur
					if (errorElement) {
						setTimeout(function() {
							errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
						}, 100);
					}
					
					return false;
				} else {
					// Fichier valide - masquer les erreurs
					const errorElement = document.getElementById(errorElementId);
					if (errorElement) {
						errorElement.classList.add('hidden');
						errorElement.style.display = 'none';
						errorElement.textContent = '';
					}
					input.classList.remove('border-red-500', 'border-2');
					console.log('Fichier valide');
					return true;
				}
			};
			
			// Alias global pour compatibilité (accessible sans window.)
			validateFileSizeImmediate = window.validateFileSizeImmediate;
			
			window.showLoginForm = function() {
				console.log('=== DÉBUT showLoginForm ===');
				console.log('Timestamp:', new Date().toISOString());
				
				try {
					console.log('Étape 1: Recherche des éléments DOM...');
					const loginContainer = document.getElementById('form-login-container');
					const registerContainer = document.getElementById('form-register-container');
					const btnLogin = document.getElementById('btn-login');
					const btnRegister = document.getElementById('btn-register');

					console.log('Étape 2: Vérification des éléments trouvés...');
					console.log('- loginContainer:', loginContainer ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- registerContainer:', registerContainer ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- btnLogin:', btnLogin ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- btnRegister:', btnRegister ? 'TROUVÉ' : 'NON TROUVÉ');

					if (!loginContainer || !registerContainer) {
						console.error('❌ ERREUR: Formulaires non trouvés dans le DOM');
						console.error('- loginContainer existe:', !!loginContainer);
						console.error('- registerContainer existe:', !!registerContainer);
						alert('Erreur : Formulaires non trouvés dans le DOM. Vérifiez la console pour plus de détails.');
						return;
					}

					console.log('Étape 3: État actuel des formulaires...');
					console.log('- loginContainer.classList:', loginContainer.classList.toString());
					console.log('- loginContainer.style.display:', loginContainer.style.display);
					console.log('- loginContainer.style.visibility:', loginContainer.style.visibility);
					console.log('- registerContainer.classList:', registerContainer.classList.toString());
					console.log('- registerContainer.style.display:', registerContainer.style.display);
					console.log('- registerContainer.style.visibility:', registerContainer.style.visibility);

					console.log('Étape 4: Masquage du formulaire d\'inscription...');
					// SÉCURITÉ : Masquer TOUJOURS le formulaire d'inscription en premier
					registerContainer.classList.add('hidden');
					registerContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
					registerContainer.setAttribute('aria-hidden', 'true');
					console.log('✅ Formulaire d\'inscription masqué');
					console.log('- registerContainer.style.cssText après:', registerContainer.style.cssText);

					console.log('Étape 5: Affichage du formulaire de connexion...');
					// Afficher le formulaire de connexion - FORCER l'affichage
					loginContainer.classList.remove('hidden');
					loginContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
					loginContainer.setAttribute('aria-hidden', 'false');
					loginContainer.setAttribute('data-user-opened', 'true');
					console.log('✅ Classes et styles appliqués au formulaire de connexion');
					console.log('- loginContainer.classList après:', loginContainer.classList.toString());
					console.log('- loginContainer.style.cssText après:', loginContainer.style.cssText);
					
					// Vérification immédiate
					setTimeout(() => {
						console.log('Étape 6: Vérification de l\'affichage après 10ms...');
						const computedStyle = window.getComputedStyle(loginContainer);
						console.log('- computedStyle.display:', computedStyle.display);
						console.log('- computedStyle.visibility:', computedStyle.visibility);
						console.log('- computedStyle.opacity:', computedStyle.opacity);
						console.log('- loginContainer.offsetHeight:', loginContainer.offsetHeight);
						console.log('- loginContainer.offsetWidth:', loginContainer.offsetWidth);
						
						if (computedStyle.display === 'none' || computedStyle.visibility === 'hidden') {
							console.error('❌ PROBLÈME DÉTECTÉ: Le formulaire est toujours masqué malgré les styles !');
							console.error('Tentative de correction avec force brute...');
							loginContainer.style.setProperty('display', 'block', 'important');
							loginContainer.style.setProperty('visibility', 'visible', 'important');
							loginContainer.style.setProperty('opacity', '1', 'important');
							loginContainer.style.setProperty('position', 'relative', 'important');
							loginContainer.style.setProperty('z-index', '9999', 'important');
						} else {
							console.log('✅ Formulaire visible selon getComputedStyle');
						}
					}, 10);
					
					// Scroll vers le formulaire
					setTimeout(() => {
						console.log('Étape 7: Scroll vers le formulaire...');
						loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
					}, 50);
					
					// Vérifier les champs si la fonction existe
					setTimeout(() => {
						console.log('Étape 8: Vérification des champs...');
						if (typeof checkLoginFields === 'function') {
							checkLoginFields();
							console.log('✅ checkLoginFields appelé');
						} else {
							console.warn('⚠️ checkLoginFields n\'existe pas');
						}
					}, 100);

					// Gérer l'état des boutons dans le header
					console.log('Étape 9: Gestion de l\'état des boutons...');
					if (btnLogin && btnRegister) {
						btnLogin.disabled = true;
						btnLogin.style.opacity = '0.6';
						btnLogin.style.cursor = 'not-allowed';
						btnRegister.disabled = false;
						btnRegister.style.opacity = '1';
						btnRegister.style.cursor = 'pointer';
						console.log('✅ État des boutons mis à jour');
					} else {
						console.warn('⚠️ Boutons header non trouvés');
					}
					
					console.log('=== FIN showLoginForm - SUCCÈS ===');
				} catch (error) {
					console.error('❌ ERREUR CRITIQUE dans showLoginForm:', error);
					console.error('Stack trace:', error.stack);
					alert('Erreur lors de l\'ouverture du formulaire de connexion: ' + error.message + '\nVérifiez la console pour plus de détails.');
				}
			};

			window.showRegisterForm = function() {
				console.log('=== DÉBUT showRegisterForm ===');
				console.log('Timestamp:', new Date().toISOString());
				
				try {
					console.log('Étape 1: Recherche des éléments DOM...');
					const loginContainer = document.getElementById('form-login-container');
					const registerContainer = document.getElementById('form-register-container');
					const btnLogin = document.getElementById('btn-login');
					const btnRegister = document.getElementById('btn-register');

					console.log('Étape 2: Vérification des éléments trouvés...');
					console.log('- loginContainer:', loginContainer ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- registerContainer:', registerContainer ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- btnLogin:', btnLogin ? 'TROUVÉ' : 'NON TROUVÉ');
					console.log('- btnRegister:', btnRegister ? 'TROUVÉ' : 'NON TROUVÉ');

					if (!loginContainer || !registerContainer) {
						console.error('❌ ERREUR: Formulaires non trouvés dans le DOM');
						console.error('- loginContainer existe:', !!loginContainer);
						console.error('- registerContainer existe:', !!registerContainer);
						alert('Erreur : Formulaires non trouvés dans le DOM. Vérifiez la console pour plus de détails.');
						return;
					}

					console.log('Étape 3: État actuel des formulaires...');
					console.log('- loginContainer.classList:', loginContainer.classList.toString());
					console.log('- loginContainer.style.display:', loginContainer.style.display);
					console.log('- loginContainer.style.visibility:', loginContainer.style.visibility);
					console.log('- registerContainer.classList:', registerContainer.classList.toString());
					console.log('- registerContainer.style.display:', registerContainer.style.display);
					console.log('- registerContainer.style.visibility:', registerContainer.style.visibility);

					console.log('Étape 4: Masquage du formulaire de connexion...');
					// SÉCURITÉ : Masquer TOUJOURS le formulaire de connexion en premier
					loginContainer.classList.add('hidden');
					loginContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
					loginContainer.setAttribute('aria-hidden', 'true');
					console.log('✅ Formulaire de connexion masqué');
					console.log('- loginContainer.style.cssText après:', loginContainer.style.cssText);

					console.log('Étape 5: Affichage du formulaire d\'inscription...');
					// Afficher le formulaire d'inscription - FORCER l'affichage
					registerContainer.classList.remove('hidden');
					registerContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
					registerContainer.setAttribute('aria-hidden', 'false');
					registerContainer.setAttribute('data-user-opened', 'true');
					console.log('✅ Classes et styles appliqués au formulaire d\'inscription');
					console.log('- registerContainer.classList après:', registerContainer.classList.toString());
					console.log('- registerContainer.style.cssText après:', registerContainer.style.cssText);
					
					// Vérification immédiate
					setTimeout(() => {
						console.log('Étape 6: Vérification de l\'affichage après 10ms...');
						const computedStyle = window.getComputedStyle(registerContainer);
						console.log('- computedStyle.display:', computedStyle.display);
						console.log('- computedStyle.visibility:', computedStyle.visibility);
						console.log('- computedStyle.opacity:', computedStyle.opacity);
						console.log('- registerContainer.offsetHeight:', registerContainer.offsetHeight);
						console.log('- registerContainer.offsetWidth:', registerContainer.offsetWidth);
						
						if (computedStyle.display === 'none' || computedStyle.visibility === 'hidden') {
							console.error('❌ PROBLÈME DÉTECTÉ: Le formulaire est toujours masqué malgré les styles !');
							console.error('Tentative de correction avec force brute...');
							registerContainer.style.setProperty('display', 'block', 'important');
							registerContainer.style.setProperty('visibility', 'visible', 'important');
							registerContainer.style.setProperty('opacity', '1', 'important');
							registerContainer.style.setProperty('position', 'relative', 'important');
							registerContainer.style.setProperty('z-index', '9999', 'important');
						} else {
							console.log('✅ Formulaire visible selon getComputedStyle');
						}
					}, 10);
					
					// Scroll vers le formulaire
					setTimeout(() => {
						console.log('Étape 7: Scroll vers le formulaire...');
						registerContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
					}, 50);

					// Gérer l'état des boutons dans le header
					console.log('Étape 8: Gestion de l\'état des boutons...');
					if (btnLogin && btnRegister) {
						btnLogin.disabled = false;
						btnLogin.style.opacity = '1';
						btnLogin.style.cursor = 'pointer';
						btnRegister.disabled = true;
						btnRegister.style.opacity = '0.6';
						btnRegister.style.cursor = 'not-allowed';
						console.log('✅ État des boutons mis à jour');
					} else {
						console.warn('⚠️ Boutons header non trouvés');
					}
					
					console.log('=== FIN showRegisterForm - SUCCÈS ===');
				} catch (error) {
					console.error('❌ ERREUR CRITIQUE dans showRegisterForm:', error);
					console.error('Stack trace:', error.stack);
					alert('Erreur lors de l\'ouverture du formulaire d\'inscription: ' + error.message + '\nVérifiez la console pour plus de détails.');
				}
			};
			
			console.log('✅ Fonctions globales définies dans le HEAD:');
			console.log('- window.showLoginForm:', typeof window.showLoginForm);
			console.log('- window.showRegisterForm:', typeof window.showRegisterForm);
			</script>
			<style>
				.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
				.e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
					background-image: none !important;
				}
				@media screen and (max-height: 1024px) {
					.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
					.e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
						background-image: none !important;
					}
				}
				@media screen and (max-height: 640px) {
					.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
					.e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
						background-image: none !important;
					}
				}
			</style>
			<link rel="icon" href="/" sizes="32x32">
<link rel="icon" href="/" sizes="192x192">
<link rel="apple-touch-icon" href="/">
<meta name="msapplication-TileImage" content="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/cropped-logo-square-1-270x270.png">
<!-- Styles CSS spécifiques à la section de contact -->
<link rel="stylesheet" id="elementor-post-1749-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-1749.css?ver=1759460534" media="all">
<link rel="stylesheet" id="metform-ui-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/css/metform-ui.css?ver=4.0.0" media="all">
<!-- <link rel="stylesheet" id="metform-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/css/style.css?ver=4.0.0" media="all"> -->
<link rel="stylesheet" id="elementor-post-1762-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-1762.css?ver=1759460534" media="all">
<link rel="stylesheet" id="widget-image-box-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-image-box.min.css?ver=3.28.4" media="all">
<link rel="stylesheet" id="widget-social-icons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-social-icons.min.css?ver=3.28.4" media="all">
<!-- <link rel="stylesheet" id="e-apple-webkit-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/conditionals/apple-webkit.min.css?ver=3.28.4" media="all"> -->
<link rel="stylesheet" id="jeg-dynamic-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/lib/jeg-framework/assets/css/jeg-dynamic-styles.css?ver=1.3.0" media="all">
<!-- <link rel="stylesheet" id="owl.carousel-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon//css/owl.carousel.css?ver=6.8.3" media="all"> -->
<script src="https://kits.yumnatype.com/universite/wp-includes/js/wp-emoji-release.min.js?ver=6.8.3" defer=""></script><style></style>
<script>
// FONCTIONS GLOBALES - Définies AVANT le rendu du HTML pour être accessibles dans les attributs onclick/oninput
// Attacher explicitement à window pour garantir l'accès global
window.togglePassword = function(inputId, iconId) {
    console.log('[DEBUG togglePassword] Appelé avec:', { inputId, iconId });
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
    console.log('[DEBUG togglePassword] Éléments trouvés:', { 
        input: !!input, 
        icon: !!icon,
        inputType: input ? input.type : 'N/A',
        iconTagName: icon ? icon.tagName : 'N/A'
    });
    
    if (!input || !icon) {
        console.error('[DEBUG togglePassword] ERREUR: input ou icon non trouvé', { inputId, iconId, input, icon });
        return;
    }
    
    if (input.type === 'password') {
        console.log('[DEBUG togglePassword] Changement vers type="text"');
        input.type = 'text';
        // Icône œil barré (cacher)
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
        `;
        console.log('[DEBUG togglePassword] Icône changée vers œil barré');
    } else {
        console.log('[DEBUG togglePassword] Changement vers type="password"');
        input.type = 'password';
        // Icône œil normal (voir)
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
        `;
        console.log('[DEBUG togglePassword] Icône changée vers œil normal');
    }
}

// Fonction pour vérifier les champs du formulaire de connexion et activer/désactiver le bouton
window.checkLoginFields = function() {
    console.log('[DEBUG checkLoginFields] Fonction appelée');
    const emailField = document.getElementById('login-email');
    const passwordField = document.getElementById('login-password');
    const submitBtn = document.getElementById('login-submit-btn');
    
    console.log('[DEBUG checkLoginFields] Éléments trouvés:', {
        emailField: !!emailField,
        passwordField: !!passwordField,
        submitBtn: !!submitBtn
    });
    
    if (!emailField || !passwordField || !submitBtn) {
        console.error('[DEBUG checkLoginFields] ERREUR: Éléments non trouvés', {
            emailField: !!emailField,
            passwordField: !!passwordField,
            submitBtn: !!submitBtn
        });
        return;
    }
    
    const emailValue = emailField.value.trim();
    const passwordValue = passwordField.value.trim();
    const allFieldsFilled = emailValue.length > 0 && passwordValue.length > 0;
    
    console.log('[DEBUG checkLoginFields] Valeurs:', {
        emailValue: emailValue ? emailValue.substring(0, 5) + '...' : 'vide',
        passwordValue: passwordValue ? '***' : 'vide',
        allFieldsFilled
    });
    
    if (allFieldsFilled) {
        console.log('[DEBUG checkLoginFields] Activation du bouton');
        submitBtn.disabled = false;
        submitBtn.removeAttribute('disabled');
        submitBtn.style.opacity = '1';
        submitBtn.style.cursor = 'pointer';
        submitBtn.classList.remove('disabled');
        // Forcer l'activation même si un autre script essaie de le désactiver
        setTimeout(function() {
            if (submitBtn && emailValue && passwordValue) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            }
        }, 50);
    } else {
        console.log('[DEBUG checkLoginFields] Désactivation du bouton');
        submitBtn.disabled = true;
        submitBtn.style.opacity = '0.6';
        submitBtn.style.cursor = 'not-allowed';
    }
};

// Alias pour compatibilité
function togglePassword(inputId, iconId) {
    return window.togglePassword(inputId, iconId);
}

function checkLoginFields() {
    return window.checkLoginFields();
}

// Initialisation immédiate pour activer le bouton si les champs sont pré-remplis
(function() {
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof window.checkLoginFields === 'function') {
                    window.checkLoginFields();
                }
            }, 100);
        });
    } else {
        setTimeout(function() {
            if (typeof window.checkLoginFields === 'function') {
                window.checkLoginFields();
            }
        }, 100);
    }
})();
</script>
</head>

<body class="home wp-singular page-template page-template-elementor_header_footer page page-id-30 wp-theme-hello-elementor ehf-header ehf-footer ehf-template-hello-elementor ehf-stylesheet-hello-elementor jkit-color-scheme elementor-default elementor-template-full-width elementor-kit-3 elementor-page elementor-page-30 e--ua-blink e--ua-chrome e--ua-mac e--ua-webkit jkit-nav-menu-loaded" data-elementor-device-mode="tablet">
<div id="page" class="hfeed site">

		<header id="masthead" itemscope="itemscope" itemtype="https://schema.org/WPHeader" style="padding: 20px 0 !important;">
			<p class="main-title bhf-hidden" itemprop="headline"><a href="{{ route('home') }}" title="Bj Académie" rel="home">Bj Académie</a></p>
					<div data-elementor-type="wp-post" data-elementor-id="28" class="elementor elementor-28" style="padding: 0 30px !important;">
				<div class="elementor-element elementor-element-7a1804e e-flex e-con-boxed e-con e-child" data-id="7a1804e" data-element_type="container" style="padding: 0 !important; margin: 0 40px 0 0 !important; align-self: center !important; background: transparent !important; background-color: transparent !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; width: auto !important; height: auto !important; max-width: 220px !important; max-height: 220px !important; display: inline-block !important;">
					<div class="e-con-inner" style="padding: 0 !important; background: transparent !important; background-color: transparent !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; width: auto !important; height: auto !important; max-width: 220px !important; max-height: 220px !important; display: inline-block !important;">
				<a href="{{ route('home') }}" style="display: block; padding: 0 !important; margin: 0 !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; background: transparent !important; background-color: transparent !important; text-decoration: none;">
					<img src="{{ asset('assets/images/chapeau.jpg') }}" alt="BJ Académie" style="width: 220px; height: 220px; object-fit: contain; display: block; padding: 0 !important; margin: 0 !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; background: transparent !important; background-color: transparent !important;">
				</a>
				<!-- Adresse, E-mail et Téléphone supprimés -->
					</div>
				</div>
		<div class="elementor-element elementor-element-31e697c e-flex e-con-boxed e-con e-parent e-lazyloaded" data-id="31e697c" data-element_type="container">
					<div class="e-con-inner">
				<div class="elementor-element elementor-element-b7a3a52 elementor-widget elementor-widget-jkit_nav_menu" data-id="b7a3a52" data-element_type="widget" data-settings="{&quot;st_menu_item_text_hover_bg_background_background&quot;:&quot;classic&quot;,&quot;st_submenu_item_text_hover_bg_background_background&quot;:&quot;classic&quot;}" data-widget_type="jkit_nav_menu.default">
					<div class="jeg-elementor-kit jkit-nav-menu break-point-tablet submenu-click-title jeg_module_30__691fc3db1da1a" data-item-indicator="&lt;i aria-hidden=&quot;true&quot; class=&quot;jki jki-chevron-down-line&quot;&gt;&lt;/i&gt;"><button aria-label="open-menu" class="jkit-hamburger-menu"><i aria-hidden="true" class="jki jki-burger-menu-light"></i></button>
        <div class="jkit-menu-wrapper"><div class="jkit-menu-container"><ul id="menu-header" class="jkit-menu jkit-menu-direction-flex jkit-submenu-position-top"><li id="menu-item-9" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-9"><a href="{{ route('home') }}" aria-current="page">ACCUEIL</a></li>
<li id="menu-item-10" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-10"><a href="#about-section">À PROPOS</a></li>
<li id="menu-item-11" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-11"><a href="#academics-section">ACADÉMIQUE<i aria-hidden="true" class="jki jki-chevron-down-line"></i></a>
<ul class="sub-menu">
	<li id="menu-item-16" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-16"><a href="#academics-section">ACADÉMIQUE</a></li>
	<li id="menu-item-17" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-17"><a href="#faculties-section">DÉTAILS ACADÉMIQUES</a></li>
</ul>
</li>
<li id="menu-item-14" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-14"><a href="#pricing-section">TARIFS<i aria-hidden="true" class="jki jki-chevron-down-line"></i></a>
<ul class="sub-menu">
	<li id="menu-item-23" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-23"><a href="#pricing-section" onclick="event.preventDefault(); if(typeof handlePricingToggle === 'function') { const btn = document.querySelector('.pricing-toggle-btn[data-period=\'monthly\']'); if(btn) handlePricingToggle('monthly', btn); } else { document.querySelector('.pricing-toggle-btn[data-period=\'monthly\']')?.click(); } setTimeout(function(){ document.getElementById('pricing-section')?.scrollIntoView({behavior: 'smooth'}); }, 100); return false;">MENSUEL</a></li>
	<li id="menu-item-24" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-24"><a href="#pricing-section" onclick="event.preventDefault(); if(typeof handlePricingToggle === 'function') { const btn = document.querySelector('.pricing-toggle-btn[data-period=\'annual\']'); if(btn) handlePricingToggle('annual', btn); } else { document.querySelector('.pricing-toggle-btn[data-period=\'annual\']')?.click(); } setTimeout(function(){ document.getElementById('pricing-section')?.scrollIntoView({behavior: 'smooth'}); }, 100); return false;">ANNUEL</a></li>
</ul>
</li>
<li id="menu-item-27" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-27"><a href="#contact-section">CONTACT</a></li>
</ul></div>
            <div class="jkit-nav-identity-panel">
                <div class="jkit-nav-site-title"><a href="{{ route('home') }}" class="jkit-nav-logo" aria-label="Home Link" style="display: flex; align-items: center; gap: 10px; padding: 0 !important; margin: 0 !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; background: transparent !important; background-color: transparent !important; text-decoration: none;">
																<img src="{{ asset('assets/images/chapeau.jpg') }}" alt="BJ Académie" style="width: 180px; height: 180px; object-fit: contain; display: block; padding: 0 !important; margin: 0 !important; border: none !important; border-width: 0 !important; border-style: none !important; border-radius: 0 !important; box-shadow: none !important; -webkit-box-shadow: none !important; -moz-box-shadow: none !important; outline: none !important; background: transparent !important; background-color: transparent !important;">
															</a></div>
                <button aria-label="close-menu" class="jkit-close-menu"><i aria-hidden="true" class="jki jki-times-solid"></i></button>
            </div>
        </div>
        <div class="jkit-overlay"></div></div>				</div>
				<div class="elementor-element elementor-element-b628a23 elementor-widget elementor-widget-button" data-id="b628a23" data-element_type="widget" data-widget_type="button.default">
										<button type="button" onclick="showLoginForm()" id="btn-login" class="elementor-button elementor-button-link elementor-size-sm" style="cursor: pointer; border: none; background: inherit; color: white !important; font: inherit; padding: inherit; text-decoration: none; margin-right: 10px;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text" style="color: white !important;">CONNEXION</span>
					</span>
					</button>
										<button type="button" onclick="showRegisterForm()" id="btn-register" class="elementor-button elementor-button-link elementor-size-sm" style="cursor: pointer; border: none; background: inherit; color: white !important; font: inherit; padding: inherit; text-decoration: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text" style="color: white !important;">S'INSCRIRE</span>
					</span>
					</button>
								</div>
					</div>
				</div>
				</div>
				</header>

			<div data-elementor-type="wp-page" data-elementor-id="30" class="elementor elementor-30">
				<div class="elementor-element elementor-element-6154359 e-con-full e-flex e-con e-parent e-lazyloaded" data-id="6154359" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Graduation.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
		<div class="elementor-element elementor-element-05582f9 e-flex e-con-boxed e-con e-child" data-id="05582f9" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-83f15b5 e-con-full e-flex e-con e-child" data-id="83f15b5" data-element_type="container">
				<div class="elementor-element elementor-element-811d512 elementor-widget elementor-widget-jkit_animated_text" data-id="811d512" data-element_type="widget" data-widget_type="jkit_animated_text.default">
					<div class="jeg-elementor-kit jkit-animated-text jeg_module_30_1_691fc3db23d5b" data-style="highlighted" data-text="Éducation" data-shape="underline-zigzag"><h1 class="animated-text"><span class="normal-text style-color">Nous Concevons et Améliorons un Avenir Meilleur Pour Votre </span><span class="dynamic-wrapper style-color"><span class="dynamic-text">Éducation</span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 150" preserveAspectRatio="none"><linearGradient x1="0" y1="0" x2="100%" y2="100%" id="jkit-highlight-gradient"><stop offset="0"></stop><stop offset="100%"></stop></linearGradient><path class="style-gradient" stroke="url(#jkit-highlight-gradient)" d="M9.5,52.5s361-31,478,0" transform="translate(-9.11 -34.22)"></path><path class="style-gradient" stroke="url(#jkit-highlight-gradient)" d="M484.5,55.5s-386-2-432,15c0,0,317-12,358,5,0,0-177-4-227,11" transform="translate(-9.11 -34.22)"></path></svg></span><span class="normal-text style-color"></span></h1></div>				</div>
				<div class="elementor-element elementor-element-92c7db2 elementor-widget elementor-widget-hfe-infocard" data-id="92c7db2" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced" style="color: white !important;">
					Chez Bj Académie, nous offrons une formation professionnelle d'excellence conçue par des experts de l'industrie. Nos programmes combinent théorie et pratique pour développer les compétences techniques et professionnelles nécessaires à votre réussite.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-263b2f3 e-con-full e-flex e-con e-child" data-id="263b2f3" data-element_type="container">
				<div class="elementor-element elementor-element-df5ae5c elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-align-justify elementor-widget__width-inherit elementor-invisible elementor-widget elementor-widget-button" data-id="df5ae5c" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
										<button type="button" onclick="showRegisterForm()" class="elementor-button elementor-button-link elementor-size-sm" style="cursor: pointer; border: none; background: inherit; color: white !important; font: inherit; padding: inherit; text-decoration: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text" style="color: white !important;">S'INSCRIRE</span>
					</span>
					</button>
								</div>
				<div class="elementor-element elementor-element-8cc333b elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-align-justify elementor-widget__width-inherit elementor-invisible elementor-widget elementor-widget-button" data-id="8cc333b" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeIn&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="button.default">
										<button type="button" onclick="showLoginForm()" class="elementor-button elementor-button-link elementor-size-sm" style="cursor: pointer; border: none; background: inherit; color: white !important; font: inherit; padding: inherit; text-decoration: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text" style="color: white !important;">CONNEXION</span>
					</span>
					</button>
								</div>
				</div>
				</div>
				
				<!-- Login Form Overlay -->
				@php
					// Afficher les erreurs si elles existent
					$hasLogin = !empty(old('login'));
					
					// SÉCURITÉ CRITIQUE : Vérifier d'abord s'il y a des erreurs d'inscription
					// Si oui, NE JAMAIS afficher le formulaire de connexion
					$hasRegisterErrors = isset($errors) && ($errors->has('nom') || $errors->has('prenom') || $errors->has('date_naissance') || $errors->has('email') || $errors->has('phone') || $errors->has('location') || $errors->has('nationalite') || $errors->has('photo') || $errors->has('diplome') || $errors->has('carte_identite') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('terms'));
					
					// Le formulaire de connexion ne doit s'afficher QUE si :
					// 1. Il y a des erreurs de connexion (login OU password de connexion)
					// 2. ET il n'y a PAS d'erreurs d'inscription
					// 3. ET l'erreur password n'est PAS une erreur d'inscription (pas de password_confirmation)
					$hasLoginPasswordError = isset($errors) && $errors->has('password') && !$errors->has('password_confirmation') && !$hasRegisterErrors;
					$hasLoginLoginError = isset($errors) && $errors->has('login') && !$hasRegisterErrors;
					$hasLoginErrors = ($hasLoginLoginError || $hasLoginPasswordError);
					// Afficher les erreurs si elles existent (même sans old('login') pour les erreurs de blocage)
					$hasBlockedError = false;
					if (isset($errors) && $errors->has('login')) {
						foreach ($errors->get('login') as $error) {
							if (stripos($error, 'bloqué') !== false || stripos($error, 'bloque') !== false || stripos($error, 'blocked') !== false) {
								$hasBlockedError = true;
								break;
							}
						}
					}
					// Afficher l'erreur si elle existe (avec ou sans old('login'))
					$shouldShowError = $hasLoginErrors;
				@endphp
				<div id="form-login-container" class="mt-12 @if($hasLoginErrors) @else hidden @endif" style="@if($hasLoginErrors) display: block; visibility: visible; @else display: none; visibility: hidden; @endif" aria-hidden="@if($hasLoginErrors) false @else true @endif">
					<h2 class="text-2xl font-bold mb-2 text-white">Connexion</h2>
					<p class="text-white mb-6">Connectez-vous à votre compte pour continuer.</p>
					
					@if($hasLoginErrors)
						<div class="mb-6 p-4 rounded-xl border border-red-400/50 bg-red-500/10 backdrop-blur-sm shadow-lg" id="login-error-message" style="display: block !important; animation: slideInUp 0.4s ease-out;">
							<div class="flex items-start">
								<svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
								</svg>
								<div class="text-red-300 text-sm font-medium leading-relaxed">
									@if($errors->has('login'))
										@foreach($errors->get('login') as $error)
											<p class="mb-1">{{ $error }}</p>
										@endforeach
									@elseif($errors->has('password'))
										@foreach($errors->get('password') as $error)
											<p class="mb-1">{{ $error }}</p>
										@endforeach
									@else
										<p class="mb-1">Email ou mot de passe incorrect</p>
									@endif
								</div>
							</div>
						</div>
					@endif
					
					<form method="POST" action="{{ route('login.post') }}" id="login-form" class="space-y-4" autocomplete="off" data-1p-ignore="true" data-lpignore="true" data-dashlane-ignore="true" data-bitwarden-watching="false" data-safari-ignore="true" novalidate>
						@csrf
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Email</label>
							<input type="text" id="login-email" name="login" value="{{ old('login') }}" placeholder="votre.email@exemple.com" required
								autocomplete="off"
								data-1p-ignore="true"
								data-form-type="other"
								data-lpignore="true"
								data-dashlane-ignore="true"
								data-bitwarden-watching="false"
								data-bwignore="true"
								data-safari-ignore="true"
								data-kwignore="true"
								spellcheck="false"
								inputmode="email"
								readonly
								onfocus="this.removeAttribute('readonly'); checkLoginFields()"
								oninput="checkLoginFields()"
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('login') ? 'border-red-500 border-2' : '' }}">
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Mot de passe</label>
							<input type="password" id="login-password" name="password" placeholder="Votre mot de passe" required
								autocomplete="off"
								data-1p-ignore="true"
								data-form-type="other"
								data-lpignore="true"
								data-dashlane-ignore="true"
								data-bitwarden-watching="false"
								data-bwignore="true"
								data-kwignore="true"
								data-safari-ignore="true"
								spellcheck="false"
								readonly
								onfocus="this.removeAttribute('readonly'); checkLoginFields()"
								oninput="checkLoginFields()"
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('login') ? 'border-red-500 border-2' : '' }}">
						</div>
						<div class="flex items-center gap-2">
							<input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-gray-300 bg-white focus:ring-2" style="accent-color: #065b32;">
							<label for="remember" class="text-sm text-white">Se souvenir de moi</label>
						</div>
						<button type="submit" id="login-submit-btn" class="w-full btn-primary" disabled>
							Se connecter
						</button>
						<p class="text-center text-sm text-white">
							Pas encore de compte ? <button type="button" onclick="showRegisterForm()" class="text-white font-semibold hover:underline">S'inscrire</button>
						</p>
					</form>
				</div>

				<!-- Register Form Overlay -->
				@php
					$hasRegisterErrors = isset($errors) && ($errors->has('nom') || $errors->has('prenom') || $errors->has('date_naissance') || $errors->has('email') || $errors->has('phone') || $errors->has('location') || $errors->has('nationalite') || $errors->has('photo') || $errors->has('diplome') || $errors->has('carte_identite') || $errors->has('password') || $errors->has('password_confirmation') || $errors->has('terms'));
				@endphp
				<div id="form-register-container" class="mt-12 @if($hasRegisterErrors || session('error')) @else hidden @endif" style="@if($hasRegisterErrors || session('error')) display: block; visibility: visible; @else display: none; visibility: hidden; @endif" aria-hidden="@if($hasRegisterErrors || session('error')) false @else true @endif">
					<h2 class="text-2xl font-bold mb-2 text-white">Inscription</h2>
					<p class="text-white mb-6">Créez votre compte pour commencer votre apprentissage.</p>
					
					@if(session('error'))
						<div class="mb-6 p-4 rounded-xl border border-red-400/50 bg-red-500/10 backdrop-blur-sm shadow-lg" id="register-error-message" style="display: block !important; animation: slideInUp 0.4s ease-out;">
							<div class="flex items-start">
								<svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
								</svg>
								<div class="text-red-300 text-sm font-medium leading-relaxed">
									<p class="mb-1">{{ session('error') }}</p>
								</div>
							</div>
						</div>
					@endif
					
					<form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" id="register-form" class="space-y-4">
						@csrf
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Nom</label>
							<input type="text" name="nom" value="{{ old('nom') }}" placeholder="Votre nom" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('nom') ? 'border-red-500 border-2' : '' }}">
							@error('nom')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Prénom</label>
							<input type="text" name="prenom" value="{{ old('prenom') }}" placeholder="Votre prénom" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('prenom') ? 'border-red-500 border-2' : '' }}">
							@error('prenom')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Date de Naissance</label>
							<input type="date" name="date_naissance" value="{{ old('date_naissance') }}" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('date_naissance') ? 'border-red-500 border-2' : '' }}">
							@error('date_naissance')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Adresse email</label>
							<input type="email" name="email" value="{{ old('email') }}" placeholder="votre.email@exemple.com" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('email') ? 'border-red-500 border-2' : '' }}">
							@error('email')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Téléphone <span class="text-red-400">*</span></label>
							<input type="text" name="phone" value="{{ old('phone') }}" placeholder="+221 77 123 45 67" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('phone') ? 'border-red-500 border-2' : '' }}">
							@error('phone')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Ville <span class="text-red-400">*</span></label>
							<input type="text" name="location" value="{{ old('location') }}" placeholder="Ex: Dakar" required
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('location') ? 'border-red-500 border-2' : '' }}">
							@error('location')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Nationalité <span class="text-red-400">*</span></label>
							<select name="nationalite" required class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all text-white bg-white {{ isset($errors) && $errors->has('nationalite') ? 'border-red-500 border-2' : '' }}" style="color: white; background-color: rgba(255, 255, 255, 0.1);">
								<option value="" style="color: #000;">-- Sélectionner une nationalité --</option>
								<option value="SN">🇸🇳 Sénégal</option>
								<option value="FR">🇫🇷 France</option>
								<option value="CI">🇨🇮 Côte d'Ivoire</option>
								<option value="ML">🇲🇱 Mali</option>
								<option value="BF">🇧🇫 Burkina Faso</option>
								<option value="NE">🇳🇪 Niger</option>
								<option value="GN">🇬🇳 Guinée</option>
								<option value="BJ">🇧🇯 Bénin</option>
								<option value="TG">🇹🇬 Togo</option>
								<option value="CM">🇨🇲 Cameroun</option>
								<option value="CD">🇨🇩 République démocratique du Congo</option>
								<option value="CG">🇨🇬 Congo</option>
								<option value="GA">🇬🇦 Gabon</option>
								<option value="MG">🇲🇬 Madagascar</option>
								<option value="MU">🇲🇺 Maurice</option>
								<option value="MR">🇲🇷 Mauritanie</option>
								<option value="TD">🇹🇩 Tchad</option>
								<option value="CF">🇨🇫 République centrafricaine</option>
								<option value="GW">🇬🇼 Guinée-Bissau</option>
								<option value="GQ">🇬🇶 Guinée équatoriale</option>
								<option value="ST">🇸🇹 Sao Tomé-et-Principe</option>
								<option value="KM">🇰🇲 Comores</option>
								<option value="DJ">🇩🇯 Djibouti</option>
								<option value="RW">🇷🇼 Rwanda</option>
								<option value="BI">🇧🇮 Burundi</option>
								<option value="ET">🇪🇹 Éthiopie</option>
								<option value="ER">🇪🇷 Érythrée</option>
								<option value="SO">🇸🇴 Somalie</option>
								<option value="UG">🇺🇬 Ouganda</option>
								<option value="KE">🇰🇪 Kenya</option>
								<option value="TZ">🇹🇿 Tanzanie</option>
								<option value="MZ">🇲🇿 Mozambique</option>
								<option value="MW">🇲🇼 Malawi</option>
								<option value="ZM">🇿🇲 Zambie</option>
								<option value="ZW">🇿🇼 Zimbabwe</option>
								<option value="BW">🇧🇼 Botswana</option>
								<option value="NA">🇳🇦 Namibie</option>
								<option value="ZA">🇿🇦 Afrique du Sud</option>
								<option value="LS">🇱🇸 Lesotho</option>
								<option value="SZ">🇸🇿 Eswatini</option>
								<option value="AO">🇦🇴 Angola</option>
								<option value="DZ">🇩🇿 Algérie</option>
								<option value="MA">🇲🇦 Maroc</option>
								<option value="TN">🇹🇳 Tunisie</option>
								<option value="LY">🇱🇾 Libye</option>
								<option value="EG">🇪🇬 Égypte</option>
								<option value="SD">🇸🇩 Soudan</option>
								<option value="SS">🇸🇸 Soudan du Sud</option>
								<option value="GH">🇬🇭 Ghana</option>
								<option value="NG">🇳🇬 Nigeria</option>
								<option value="US">🇺🇸 États-Unis</option>
								<option value="CA">🇨🇦 Canada</option>
								<option value="GB">🇬🇧 Royaume-Uni</option>
								<option value="DE">🇩🇪 Allemagne</option>
								<option value="IT">🇮🇹 Italie</option>
								<option value="ES">🇪🇸 Espagne</option>
								<option value="PT">🇵🇹 Portugal</option>
								<option value="BE">🇧🇪 Belgique</option>
								<option value="CH">🇨🇭 Suisse</option>
								<option value="NL">🇳🇱 Pays-Bas</option>
								<option value="AT">🇦🇹 Autriche</option>
								<option value="SE">🇸🇪 Suède</option>
								<option value="NO">🇳🇴 Norvège</option>
								<option value="DK">🇩🇰 Danemark</option>
								<option value="FI">🇫🇮 Finlande</option>
								<option value="PL">🇵🇱 Pologne</option>
								<option value="CZ">🇨🇿 République tchèque</option>
								<option value="HU">🇭🇺 Hongrie</option>
								<option value="RO">🇷🇴 Roumanie</option>
								<option value="BG">🇧🇬 Bulgarie</option>
								<option value="GR">🇬🇷 Grèce</option>
								<option value="IE">🇮🇪 Irlande</option>
								<option value="IS">🇮🇸 Islande</option>
								<option value="LU">🇱🇺 Luxembourg</option>
								<option value="MT">🇲🇹 Malte</option>
								<option value="CY">🇨🇾 Chypre</option>
								<option value="EE">🇪🇪 Estonie</option>
								<option value="LV">🇱🇻 Lettonie</option>
								<option value="LT">🇱🇹 Lituanie</option>
								<option value="SK">🇸🇰 Slovaquie</option>
								<option value="SI">🇸🇮 Slovénie</option>
								<option value="HR">🇭🇷 Croatie</option>
								<option value="RS">🇷🇸 Serbie</option>
								<option value="ME">🇲🇪 Monténégro</option>
								<option value="BA">🇧🇦 Bosnie-Herzégovine</option>
								<option value="MK">🇲🇰 Macédoine du Nord</option>
								<option value="AL">🇦🇱 Albanie</option>
								<option value="MD">🇲🇩 Moldavie</option>
								<option value="UA">🇺🇦 Ukraine</option>
								<option value="BY">🇧🇾 Biélorussie</option>
								<option value="RU">🇷🇺 Russie</option>
								<option value="KZ">🇰🇿 Kazakhstan</option>
								<option value="UZ">🇺🇿 Ouzbékistan</option>
								<option value="TM">🇹🇲 Turkménistan</option>
								<option value="TJ">🇹🇯 Tadjikistan</option>
								<option value="KG">🇰🇬 Kirghizistan</option>
								<option value="GE">🇬🇪 Géorgie</option>
								<option value="AM">🇦🇲 Arménie</option>
								<option value="AZ">🇦🇿 Azerbaïdjan</option>
								<option value="TR">🇹🇷 Turquie</option>
								<option value="IL">🇮🇱 Israël</option>
								<option value="PS">🇵🇸 Palestine</option>
								<option value="JO">🇯🇴 Jordanie</option>
								<option value="LB">🇱🇧 Liban</option>
								<option value="SY">🇸🇾 Syrie</option>
								<option value="IQ">🇮🇶 Irak</option>
								<option value="IR">🇮🇷 Iran</option>
								<option value="SA">🇸🇦 Arabie Saoudite</option>
								<option value="AE">🇦🇪 Émirats arabes unis</option>
								<option value="QA">🇶🇦 Qatar</option>
								<option value="KW">🇰🇼 Koweït</option>
								<option value="BH">🇧🇭 Bahreïn</option>
								<option value="OM">🇴🇲 Oman</option>
								<option value="YE">🇾🇪 Yémen</option>
								<option value="AF">🇦🇫 Afghanistan</option>
								<option value="PK">🇵🇰 Pakistan</option>
								<option value="BD">🇧🇩 Bangladesh</option>
								<option value="IN">🇮🇳 Inde</option>
								<option value="NP">🇳🇵 Népal</option>
								<option value="BT">🇧🇹 Bhoutan</option>
								<option value="LK">🇱🇰 Sri Lanka</option>
								<option value="MV">🇲🇻 Maldives</option>
								<option value="CN">🇨🇳 Chine</option>
								<option value="MN">🇲🇳 Mongolie</option>
								<option value="KP">🇰🇵 Corée du Nord</option>
								<option value="KR">🇰🇷 Corée du Sud</option>
								<option value="JP">🇯🇵 Japon</option>
								<option value="TW">🇹🇼 Taïwan</option>
								<option value="HK">🇭🇰 Hong Kong</option>
								<option value="MO">🇲🇴 Macao</option>
								<option value="SG">🇸🇬 Singapour</option>
								<option value="MY">🇲🇾 Malaisie</option>
								<option value="TH">🇹🇭 Thaïlande</option>
								<option value="LA">🇱🇦 Laos</option>
								<option value="KH">🇰🇭 Cambodge</option>
								<option value="VN">🇻🇳 Viêt Nam</option>
								<option value="MM">🇲🇲 Birmanie</option>
								<option value="PH">🇵🇭 Philippines</option>
								<option value="ID">🇮🇩 Indonésie</option>
								<option value="BN">🇧🇳 Brunei</option>
								<option value="TL">🇹🇱 Timor oriental</option>
								<option value="PG">🇵🇬 Papouasie-Nouvelle-Guinée</option>
								<option value="FJ">🇫🇯 Fidji</option>
								<option value="NC">🇳🇨 Nouvelle-Calédonie</option>
								<option value="PF">🇵🇫 Polynésie française</option>
								<option value="VU">🇻🇺 Vanuatu</option>
								<option value="SB">🇸🇧 Îles Salomon</option>
								<option value="KI">🇰🇮 Kiribati</option>
								<option value="TV">🇹🇻 Tuvalu</option>
								<option value="NR">🇳🇷 Nauru</option>
								<option value="PW">🇵🇼 Palaos</option>
								<option value="FM">🇫🇲 Micronésie</option>
								<option value="MH">🇲🇭 Îles Marshall</option>
								<option value="AU">🇦🇺 Australie</option>
								<option value="NZ">🇳🇿 Nouvelle-Zélande</option>
								<option value="AR">🇦🇷 Argentine</option>
								<option value="BR">🇧🇷 Brésil</option>
								<option value="CL">🇨🇱 Chili</option>
								<option value="CO">🇨🇴 Colombie</option>
								<option value="PE">🇵🇪 Pérou</option>
								<option value="EC">🇪🇨 Équateur</option>
								<option value="BO">🇧🇴 Bolivie</option>
								<option value="PY">🇵🇾 Paraguay</option>
								<option value="UY">🇺🇾 Uruguay</option>
								<option value="VE">🇻🇪 Venezuela</option>
								<option value="GY">🇬🇾 Guyana</option>
								<option value="SR">🇸🇷 Suriname</option>
								<option value="GF">🇬🇫 Guyane française</option>
								<option value="FK">🇫🇰 Îles Malouines</option>
								<option value="MX">🇲🇽 Mexique</option>
								<option value="GT">🇬🇹 Guatemala</option>
								<option value="BZ">🇧🇿 Belize</option>
								<option value="SV">🇸🇻 Salvador</option>
								<option value="HN">🇭🇳 Honduras</option>
								<option value="NI">🇳🇮 Nicaragua</option>
								<option value="CR">🇨🇷 Costa Rica</option>
								<option value="PA">🇵🇦 Panama</option>
								<option value="CU">🇨🇺 Cuba</option>
								<option value="JM">🇯🇲 Jamaïque</option>
								<option value="HT">🇭🇹 Haïti</option>
								<option value="DO">🇩🇴 République dominicaine</option>
								<option value="PR">🇵🇷 Porto Rico</option>
								<option value="TT">🇹🇹 Trinité-et-Tobago</option>
								<option value="BB">🇧🇧 Barbade</option>
								<option value="GD">🇬🇩 Grenade</option>
								<option value="LC">🇱🇨 Sainte-Lucie</option>
								<option value="VC">🇻🇨 Saint-Vincent-et-les-Grenadines</option>
								<option value="AG">🇦🇬 Antigua-et-Barbuda</option>
								<option value="KN">🇰🇳 Saint-Kitts-et-Nevis</option>
								<option value="DM">🇩🇲 Dominique</option>
								<option value="BS">🇧🇸 Bahamas</option>
								<option value="TC">🇹🇨 Îles Turques-et-Caïques</option>
								<option value="VG">🇻🇬 Îles Vierges britanniques</option>
								<option value="VI">🇻🇮 Îles Vierges américaines</option>
								<option value="AW">🇦🇼 Aruba</option>
								<option value="CW">🇨🇼 Curaçao</option>
								<option value="SX">🇸🇽 Saint-Martin</option>
								<option value="BQ">🇧🇶 Pays-Bas caribéens</option>
								<option value="GP">🇬🇵 Guadeloupe</option>
								<option value="MQ">🇲🇶 Martinique</option>
								<option value="BL">🇧🇱 Saint-Barthélemy</option>
								<option value="MF">🇲🇫 Saint-Martin</option>
								<option value="PM">🇵🇲 Saint-Pierre-et-Miquelon</option>
								<option value="GL">🇬🇱 Groenland</option>
								<option value="FO">🇫🇴 Îles Féroé</option>
								<option value="AX">🇦🇽 Îles Åland</option>
								<option value="SJ">🇸🇯 Svalbard et Jan Mayen</option>
								<option value="GI">🇬🇮 Gibraltar</option>
								<option value="AD">🇦🇩 Andorre</option>
								<option value="MC">🇲🇨 Monaco</option>
								<option value="SM">🇸🇲 Saint-Marin</option>
								<option value="VA">🇻🇦 Vatican</option>
								<option value="LI">🇱🇮 Liechtenstein</option>
								<option value="RE">🇷🇪 La Réunion</option>
								<option value="YT">🇾🇹 Mayotte</option>
								<option value="SH">🇸🇭 Sainte-Hélène</option>
								<option value="GS">🇬🇸 Géorgie du Sud-et-les Îles Sandwich du Sud</option>
								<option value="TF">🇹🇫 Terres australes françaises</option>
								<option value="HM">🇭🇲 Île Heard et îles McDonald</option>
								<option value="CC">🇨🇨 Îles Cocos</option>
								<option value="CX">🇨🇽 Île Christmas</option>
								<option value="NF">🇳🇫 Île Norfolk</option>
								<option value="PN">🇵🇳 Îles Pitcairn</option>
								<option value="TK">🇹🇰 Tokelau</option>
								<option value="TO">🇹🇴 Tonga</option>
								<option value="WS">🇼🇸 Samoa</option>
								<option value="AS">🇦🇸 Samoa américaines</option>
								<option value="CK">🇨🇰 Îles Cook</option>
								<option value="NU">🇳🇺 Niue</option>
								<option value="WF">🇼🇫 Wallis-et-Futuna</option>
								<option value="AQ">🇦🇶 Antarctique</option>
								<option value="BV">🇧🇻 Île Bouvet</option>
								<option value="IO">🇮🇴 Territoire britannique de l'océan Indien</option>
								<option value="EH">🇪🇭 Sahara occidental</option>
								<option value="PS">🇵🇸 Palestine</option>
								<option value="TW">🇹🇼 Taïwan</option>
								<option value="HK">🇭🇰 Hong Kong</option>
								<option value="MO">🇲🇴 Macao</option>
							</select>
							@error('nationalite')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Photo</label>
							<input type="file" name="photo" id="photo-input" accept="image/*" required
								onchange="validateFileSizeImmediate(this, 'photo-error', 'Photo')"
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all border border-gray-300 text-white file:text-white {{ isset($errors) && $errors->has('photo') ? 'border-red-500 border-2' : '' }}" style="color: white;">
							<p class="text-xs text-white/70 mt-1">Formats acceptés : JPG, PNG, GIF (max 5MB)</p>
							<div id="photo-error" class="text-red-500 text-xs mt-1" style="display: none;"></div>
							@error('photo')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Diplôme</label>
							<input type="file" name="diplome" id="diplome-input" accept=".pdf,.jpg,.jpeg,.png" required
								onchange="validateFileSizeImmediate(this, 'diplome-error', 'Diplôme')"
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all border border-gray-300 text-white file:text-white {{ isset($errors) && $errors->has('diplome') ? 'border-red-500 border-2' : '' }}" style="color: white;">
							<p class="text-xs text-white/70 mt-1">Formats acceptés : PDF, JPG, PNG (max 5MB)</p>
							<div id="diplome-error" class="text-red-500 text-xs mt-1" style="display: none;"></div>
							@error('diplome')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Carte d'identité</label>
							<input type="file" name="carte_identite" id="carte_identite-input" accept=".pdf,.jpg,.jpeg,.png" required
								onchange="validateFileSizeImmediate(this, 'carte_identite-error', 'Carte d\'identité')"
								class="w-full px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all border border-gray-300 text-white file:text-white {{ isset($errors) && $errors->has('carte_identite') ? 'border-red-500 border-2' : '' }}" style="color: white;">
							<p class="text-xs text-white/70 mt-1">Formats acceptés : PDF, JPG, PNG (max 5MB)</p>
							<div id="carte_identite-error" class="text-red-500 text-xs mt-1" style="display: none;"></div>
							@error('carte_identite')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Mot de passe</label>
							<div class="relative">
								<input type="password" id="register-password" name="password" placeholder="Min. 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre" required minlength="8"
									autocomplete="off"
									data-1p-ignore="true"
									data-form-type="other"
									data-lpignore="true"
									data-dashlane-ignore="true"
									data-bitwarden-watching="false"
									spellcheck="false"
									class="w-full px-4 py-3 pr-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('password') ? 'border-red-500 border-2' : '' }}">
								<button type="button" onclick="togglePassword('register-password', 'register-password-toggle')" 
									class="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-gray-200 transition-colors focus:outline-none">
									<svg id="register-password-toggle" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
									</svg>
								</button>
							</div>
							<div id="password-requirements" class="text-xs mt-1 space-y-1" style="display: none;">
								<div id="req-length" class="text-white/70">✓ Au moins 8 caractères</div>
								<div id="req-uppercase" class="text-white/70">✓ Au moins une majuscule</div>
								<div id="req-lowercase" class="text-white/70">✓ Au moins une minuscule</div>
								<div id="req-digit" class="text-white/70">✓ Au moins un chiffre</div>
							</div>
							@error('password')
								<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
							@enderror
						</div>
						<div>
							<label class="block text-sm font-medium mb-2 text-white">Confirmer le mot de passe</label>
							<div class="relative">
								<input type="password" id="register-password-confirm" name="password_confirmation" placeholder="Répétez votre mot de passe" required
									autocomplete="off"
									data-1p-ignore="true"
									data-form-type="other"
									data-lpignore="true"
									data-dashlane-ignore="true"
									data-bitwarden-watching="false"
									spellcheck="false"
									class="w-full px-4 py-3 pr-12 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#065b32]/30 transition-all {{ isset($errors) && $errors->has('password_confirmation') ? 'border-red-500 border-2' : '' }}">
								<button type="button" onclick="togglePassword('register-password-confirm', 'register-password-confirm-toggle')" 
									class="absolute right-3 top-1/2 -translate-y-1/2 text-white hover:text-gray-200 transition-colors focus:outline-none">
									<svg id="register-password-confirm-toggle" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
									</svg>
								</button>
							</div>
						</div>
						<div class="flex items-start gap-2">
							<input type="checkbox" id="terms" name="terms" value="1" required
								class="w-4 h-4 mt-0.5 rounded border-gray-300 bg-white focus:ring-2 {{ isset($errors) && $errors->has('terms') ? 'border-red-500' : '' }}" style="accent-color: #065b32;">
							<label for="terms" class="text-xs text-white leading-relaxed">
								J'accepte les <a href="#" onclick="openTermsModal(); return false;" class="text-white font-semibold hover:underline">conditions d'utilisation</a> et la <a href="#" onclick="openPrivacyModal(); return false;" class="text-white font-semibold hover:underline">politique de confidentialité</a>
							</label>
						</div>
						@error('terms')
							<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
						@enderror
						<button type="submit" id="register-submit-btn" class="w-full btn-primary">
							Créer mon compte
						</button>
						<p class="text-center text-sm text-white">
							Déjà un compte ? <button type="button" onclick="showLoginForm()" class="text-white font-semibold hover:underline">Se connecter</button>
						</p>
					</form>
				</div>
				
					</div>
				</div>
		<div class="elementor-element elementor-element-3a8342f e-flex e-con-boxed e-con e-child" data-id="3a8342f" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-ed4c025 e-con-full e-flex elementor-invisible e-con e-child" data-id="ed4c025" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;,&quot;animation_delay&quot;:400}">
		<div class="elementor-element elementor-element-60f4c74 e-con-full e-flex e-con e-child" data-id="60f4c74" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;position&quot;:&quot;absolute&quot;}">
				<div class="elementor-element elementor-element-714eafe elementor-widget elementor-widget-spacer" data-id="714eafe" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-77b7128 e-con-full e-flex e-con e-child" data-id="77b7128" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-118b403 elementor-icon-list--layout-inline elementor-icon-list-ico-position-0 elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="118b403" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items elementor-inline-items">
							<li class="elementor-icon-list-item elementor-inline-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-user-tie-solid"></i>						</span>
										<span class="elementor-icon-list-text">Conférenciers Qualifiés</span>
									</li>
						</ul>
						</div>
				<div class="elementor-element elementor-element-b0eeffa elementor-widget elementor-widget-text-editor" data-id="b0eeffa" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Nos formateurs experts dispensent des cours en ligne interactifs et adaptés à votre rythme d'apprentissage.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-9c1172a e-con-full e-flex elementor-invisible e-con e-child" data-id="9c1172a" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;gradient&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;,&quot;animation_delay&quot;:200}">
				<div class="elementor-element elementor-element-95e87b6 elementor-icon-list--layout-inline elementor-icon-list-ico-position-0 elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="95e87b6" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items elementor-inline-items">
							<li class="elementor-icon-list-item elementor-inline-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-school-solid"></i>						</span>
										<span class="elementor-icon-list-text">Installations de Bourses</span>
									</li>
						</ul>
						</div>
				<div class="elementor-element elementor-element-0d0c1e0 elementor-widget elementor-widget-text-editor" data-id="0d0c1e0" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Nous proposons des bourses d'études et des facilités de paiement pour rendre la formation accessible à tous.</p>								</div>
				</div>
		<div class="elementor-element elementor-element-2b3974e e-con-full e-flex elementor-invisible e-con e-child" data-id="2b3974e" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
		<div class="elementor-element elementor-element-f237c1d e-con-full e-flex e-con e-child" data-id="f237c1d" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;position&quot;:&quot;absolute&quot;}">
				<div class="elementor-element elementor-element-fcf2f0c elementor-widget elementor-widget-spacer" data-id="fcf2f0c" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-f4fde3a e-con-full e-flex e-con e-child" data-id="f4fde3a" data-element_type="container">
				<div class="elementor-element elementor-element-90aa517 elementor-widget elementor-widget-image" data-id="90aa517" data-element_type="widget" data-widget_type="image.default">
															<img decoding="async" width="768" height="768" src="{{ asset('assets/images/micheal-obassi.jpg') }}" class="attachment-medium_large size-medium_large wp-image-220" alt="Micheal Obassi">															</div>
				<div class="elementor-element elementor-element-21091c7 elementor-widget elementor-widget-image" data-id="21091c7" data-element_type="widget" data-widget_type="image.default">
															<img loading="lazy" decoding="async" width="768" height="768" src="{{ asset('assets/images/aissatou-fall.jpg') }}" class="attachment-medium_large size-medium_large wp-image-219" alt="Aissatou Fall">															</div>
				<div class="elementor-element elementor-element-5f25e50 elementor-widget elementor-widget-image" data-id="5f25e50" data-element_type="widget" data-widget_type="image.default">
															<img loading="lazy" decoding="async" width="768" height="768" src="{{ asset('assets/images/moustapha-sy.jpg') }}" class="attachment-medium_large size-medium_large wp-image-218" alt="Moustapha Sy">															</div>
		<div class="elementor-element elementor-element-8b108e2 e-con-full e-flex e-con e-child" data-id="8b108e2" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-2e8bbd6 elementor-widget elementor-widget-counter" data-id="2e8bbd6" data-element_type="widget" data-widget_type="counter.default">
							<div class="elementor-counter">
						<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"></span>
				<span class="elementor-counter-number" data-duration="1000" data-to-value="2" data-from-value="0" data-delimiter=",">0</span>
				<span class="elementor-counter-number-suffix">K+</span>
			</div>
		</div>
						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-8dd7de2 e-con-full e-flex e-con e-child" data-id="8dd7de2" data-element_type="container">
				<div class="elementor-element elementor-element-61035eb elementor-icon-list--layout-inline elementor-icon-list-ico-position-0 elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="61035eb" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items elementor-inline-items">
							<li class="elementor-icon-list-item elementor-inline-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-medal-solid"></i>						</span>
										<span class="elementor-icon-list-text">Meilleurs Diplômés</span>
									</li>
						</ul>
						</div>
				<div class="elementor-element elementor-element-3bb1b1a elementor-widget elementor-widget-text-editor" data-id="3bb1b1a" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Nos diplômés sont reconnus dans le monde professionnel grâce à leur expertise acquise en formation à distance.</p>								</div>
				</div>
				</div>
					</div>
				</div>
				</div>
		<div id="about-section" class="elementor-element elementor-element-ac101a3 e-flex e-con-boxed e-con e-parent" data-id="ac101a3" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-1cbe37b e-con-full e-flex elementor-invisible e-con e-child" data-id="1cbe37b" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-a6b22aa elementor-widget elementor-widget-heading" data-id="a6b22aa" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">À PROPOS</div>				</div>
				<div class="elementor-element elementor-element-f2894a9 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="f2894a9" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-a0b6009 e-con-full e-flex e-con e-child" data-id="a0b6009" data-element_type="container">
		<div class="elementor-element elementor-element-b285500 e-con-full e-flex e-con e-child" data-id="b285500" data-element_type="container">
				<div class="elementor-element elementor-element-120f927 elementor-widget elementor-widget-jkit_heading" data-id="120f927" data-element_type="widget" data-widget_type="jkit_heading.default">
					<div class="jeg-elementor-kit jkit-heading  align- align-tablet- align-mobile- jeg_module_30_2_691fc3db26a78"><div class="heading-section-title  display-inline-block"><h2 class="heading-title">Bienvenue à <span class="style-color"><span>Bj Académie</span></span>, </h2></div></div>				</div>
				<div class="elementor-element elementor-element-01e87bf elementor-widget elementor-widget-jkit_heading" data-id="01e87bf" data-element_type="widget" data-widget_type="jkit_heading.default">
					<div class="jeg-elementor-kit jkit-heading  align- align-tablet- align-mobile- jeg_module_30_3_691fc3db270d8"><div class="heading-section-title  display-inline-block"><h2 class="heading-title">Créateur de Diplômés Exceptionnels</h2></div></div>				</div>
				<div class="elementor-element elementor-element-5557556 elementor-widget elementor-widget-text-editor" data-id="5557556" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Bj Académie est une institution de formation à distance de renom, spécialisée dans l'excellence académique et professionnelle. Depuis notre création, nous avons formé des milliers d'étudiants à travers des programmes innovants accessibles en ligne. Notre mission est de démocratiser l'accès à une éducation de qualité, en permettant à chacun d'apprendre à son rythme, depuis n'importe où dans le monde.</p>								</div>
				<div class="elementor-element elementor-element-925e1a3 counter-align_left elementor-widget__width-initial elementor-widget elementor-widget-counter" data-id="925e1a3" data-element_type="widget" data-widget_type="counter.default">
							<div class="elementor-counter">
			<div class="elementor-counter-title">Établi en</div>			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"></span>
				<span class="elementor-counter-number" data-duration="2000" data-to-value="2025" data-from-value="2000">2000</span>
				<span class="elementor-counter-number-suffix"></span>
			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-b8479bd elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-invisible elementor-widget elementor-widget-button" data-id="b8479bd" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
										<a class="elementor-button elementor-button-link elementor-size-sm" href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: #DC2626; border: none; cursor: pointer;">
						<span class="elementor-button-content-wrapper">
									<i aria-hidden="true" class="jki jki-arrow-up-solid" style="font-size: 24px; color: #ffffff; animation: bounceArrow 2s infinite;"></i>
					</span>
					</a>
								</div>
				</div>
		<div class="elementor-element elementor-element-a507eeb e-con-full e-flex e-con e-child" data-id="a507eeb" data-element_type="container">
		<div class="elementor-element elementor-element-3c634dd e-con-full e-flex e-con e-child" data-id="3c634dd" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
		<div class="elementor-element elementor-element-268c2b7 e-con-full e-flex e-con e-child" data-id="268c2b7" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-49b983f elementor-widget elementor-widget-spacer" data-id="49b983f" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-2c743d5 e-con-full e-flex e-con e-child" data-id="2c743d5" data-element_type="container">
				<div class="elementor-element elementor-element-e480601 elementor-widget__width-initial elementor-widget elementor-widget-counter" data-id="e480601" data-element_type="widget" data-widget_type="counter.default">
							<div class="elementor-counter">
			<div class="elementor-counter-title">Taux de Diplômation</div>			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"></span>
				<span class="elementor-counter-number" data-duration="2000" data-to-value="92" data-from-value="0" data-delimiter=",">0</span>
				<span class="elementor-counter-number-suffix">%</span>
			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-3ad7a9c elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="3ad7a9c" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Taux de satisfaction élevé de nos étudiants en formation à distance.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-76a57e6 e-con-full e-flex e-con e-child" data-id="76a57e6" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
		<div class="elementor-element elementor-element-b9aec3d e-con-full e-flex e-con e-child" data-id="b9aec3d" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-0a9abf8 elementor-widget elementor-widget-spacer" data-id="0a9abf8" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-01f4bb6 e-con-full e-flex e-con e-child" data-id="01f4bb6" data-element_type="container">
				<div class="elementor-element elementor-element-b521fb7 elementor-widget__width-initial elementor-widget elementor-widget-counter" data-id="b521fb7" data-element_type="widget" data-widget_type="counter.default">
							<div class="elementor-counter">
			<div class="elementor-counter-title">Étudiants de Notre Plateforme</div>			<div class="elementor-counter-number-wrapper">
				<span class="elementor-counter-number-prefix"></span>
				<span class="elementor-counter-number" data-duration="2000" data-to-value="2.4" data-from-value="0" data-delimiter=",">0</span>
				<span class="elementor-counter-number-suffix">M</span>
			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-e89ac93 elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="e89ac93" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Des milliers d'étudiants formés avec succès dans nos programmes en ligne.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-6407513 e-con-full e-flex e-con e-child" data-id="6407513" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
		<div class="elementor-element elementor-element-82ec308 e-con-full e-flex e-con e-child" data-id="82ec308" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-e009c00 elementor-widget elementor-widget-spacer" data-id="e009c00" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-e055399 e-con-full e-flex e-con e-parent" data-id="e055399" data-element_type="container">
				<div class="elementor-element elementor-element-f1fa027 elementor-widget__width-inherit elementor-invisible elementor-widget elementor-widget-image" data-id="f1fa027" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="image.default" style="position: relative;">
															<img loading="lazy" decoding="async" src="{{ asset('assets/images/Digital.jpg') }}" class="attachment-full size-full wp-image-397" alt="" style="animation: floatSlow 6s ease-in-out;">
															<div style="position: absolute; top: 0; left: 0; width: 60%; height: 100%; background: linear-gradient(to right, rgba(255, 255, 255, 0.6), rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1), transparent); z-index: 5;"></div>
															<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; z-index: 10;">
																<h2 style="font-size: 2.5rem; font-weight: 700; color: #ffffff; background: linear-gradient(180deg, #1a1f3a 0%, #161b33 100%); padding: 20px 40px; border-radius: 12px; text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5), 0 0 20px rgba(0, 0, 0, 0.3); letter-spacing: 2px; margin: 0; text-transform: uppercase; font-family: 'Arial', sans-serif; box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);">Nos partenaires</h2>
															</div>
															</div>
				</div>
		<div class="elementor-element elementor-element-9e830d4 e-flex e-con-boxed e-con e-parent" data-id="9e830d4" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-b37027e e-con-full e-flex e-con e-child" data-id="b37027e" data-element_type="container">
				<div class="elementor-element elementor-element-a610a95 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-heading" data-id="a610a95" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Reconnu et approuvé par un vaste écosystème d'entreprises partenaires.</h2>				</div>
				<div class="elementor-element elementor-element-c3857ac elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-text-editor" data-id="c3857ac" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Bj Académie est reconnue et approuvée par des milliers d'institutions éducatives à travers le monde. Nos diplômes sont reconnus internationalement et ouvrent les portes à de nombreuses opportunités professionnelles.</p>								</div>
				</div>
				<div class="elementor-element elementor-element-18b667b elementor-widget elementor-widget-image-carousel e-widget-swiper" data-id="18b667b" data-element_type="widget" data-settings="{&quot;slides_to_show&quot;:&quot;5&quot;,&quot;slides_to_show_tablet&quot;:&quot;3&quot;,&quot;slides_to_show_mobile&quot;:&quot;2&quot;,&quot;slides_to_scroll&quot;:&quot;1&quot;,&quot;slides_to_scroll_tablet&quot;:&quot;1&quot;,&quot;navigation&quot;:&quot;none&quot;,&quot;autoplay_speed&quot;:500,&quot;speed&quot;:3500,&quot;image_spacing_custom&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:100,&quot;sizes&quot;:[]},&quot;image_spacing_custom_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:48,&quot;sizes&quot;:[]},&quot;autoplay&quot;:&quot;yes&quot;,&quot;infinite&quot;:&quot;yes&quot;,&quot;image_spacing_custom_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}" data-widget_type="image-carousel.default">
							<div class="elementor-image-carousel-wrapper swiper swiper-initialized swiper-horizontal swiper-pointer-events" role="region" aria-roledescription="carousel" aria-label="Image Carousel" dir="ltr">
			<div class="elementor-image-carousel swiper-wrapper swiper-image-stretch" aria-live="off" id="swiper-wrapper-c735d234c7f3c10ea"><div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active" role="group" aria-roledescription="slide" data-swiper-slide-index="2" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner" style="background: transparent;"><img decoding="async" class="swiper-slide-image" src="{{ asset('assets/images/Sones.jpeg') }}" alt="SONES" style="object-fit: contain; max-height: 80px; background: transparent;"></figure></div><div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-next" role="group" aria-roledescription="slide" data-swiper-slide-index="3" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjVqOWOBeEJx-ztP2ZoVLtdTP6KBD149lf4g&s" alt="UCAD" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide swiper-slide-duplicate" role="group" aria-roledescription="slide" data-swiper-slide-index="4" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://www.sococim.com/sites/default/files/styles/logo_150x108/public/site_logo/credentialing_providers/Original%20JPG-SOCOCIM_Logo.jpg?itok=DYu0Qi7P" alt="SOCOCIM" style="object-fit: contain; max-height: 80px;"></figure></div>
								<div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="0" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://orange.africa-newsroom.com/files/large/3a46a62fb05c98e" alt="SONATEL" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide swiper-slide-prev" role="group" aria-roledescription="slide" data-swiper-slide-index="1" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://www.groupeisi.com/wp-content/uploads/2018/11/LOGO-NEW-GROUP.jpg" alt="ISI" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide swiper-slide-active" role="group" aria-roledescription="slide" data-swiper-slide-index="2" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner" style="background: transparent;"><img decoding="async" class="swiper-slide-image" src="{{ asset('assets/images/Sones.jpeg') }}" alt="SONES" style="object-fit: contain; max-height: 80px; background: transparent;"></figure></div><div class="swiper-slide swiper-slide-next" role="group" aria-roledescription="slide" data-swiper-slide-index="3" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQjVqOWOBeEJx-ztP2ZoVLtdTP6KBD149lf4g&s" alt="UCAD" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="4" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://www.sococim.com/sites/default/files/styles/logo_150x108/public/site_logo/credentialing_providers/Original%20JPG-SOCOCIM_Logo.jpg?itok=DYu0Qi7P" alt="SOCOCIM" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="5" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://yt3.googleusercontent.com/s_QZ8Zhj3liKuEsmyMX7pvq4a7w1jRFJC3P_e7Oc4uStCC05JBuj5X1Q6aJz6_eb3HW9EwnO=s900-c-k-c0x00ffffff-no-rj" alt="ENSI" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="6" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://media.licdn.com/dms/image/v2/C4D1BAQFpi0wvCBAw8A/company-background_10000/company-background_10000/0/1619443956191/centre_international_du_commerce_extrieur_du_senegal_cices_cover?e=2147483647&v=beta&t=AhEXCpp6Ovh0_NtrHha-nlofIb_uqqmvBYmWzc5ECtE" alt="CICES" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="7" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://www.pressafrik.com/photo/art/grande/41273716-34771026.jpg?v=1577786351" alt="SDE" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide" role="group" aria-roledescription="slide" data-swiper-slide-index="8" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://media.licdn.com/dms/image/v2/D5612AQHRQo8433SEyg/article-cover_image-shrink_720_1280/article-cover_image-shrink_720_1280/0/1677685285317?e=2147483647&v=beta&t=vyJcZkRzJdIOkCAmofU9dTvfPt2tOHiTtbZOw5rtmSc" alt="AIBD" style="object-fit: contain; max-height: 80px;"></figure></div>			<div class="swiper-slide swiper-slide-duplicate" role="group" aria-roledescription="slide" data-swiper-slide-index="0" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://orange.africa-newsroom.com/files/large/3a46a62fb05c98e" alt="SONATEL" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-prev" role="group" aria-roledescription="slide" data-swiper-slide-index="1" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner"><img decoding="async" class="swiper-slide-image" src="https://www.groupeisi.com/wp-content/uploads/2018/11/LOGO-NEW-GROUP.jpg" alt="ISI" style="object-fit: contain; max-height: 80px;"></figure></div><div class="swiper-slide swiper-slide-duplicate swiper-slide-duplicate-active" role="group" aria-roledescription="slide" data-swiper-slide-index="2" aria-hidden="true" inert="" style="width: 189.333px; margin-right: 100px;"><figure class="swiper-slide-inner" style="background: transparent;"><img decoding="async" class="swiper-slide-image" src="{{ asset('assets/images/Sones.jpeg') }}" alt="SONES" style="object-fit: contain; max-height: 80px; background: transparent;"></figure></div></div>
							
									<span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
						</div>
					</div>
				</div>
		<div id="academics-section" class="elementor-element elementor-element-49e3828 e-flex e-con-boxed e-con e-parent" data-id="49e3828" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-e54e8b3 e-con-full e-flex e-con e-child" data-id="e54e8b3" data-element_type="container">
		<div class="elementor-element elementor-element-0ba7415 e-con-full e-flex e-con e-child" data-id="0ba7415" data-element_type="container">
		<div class="elementor-element elementor-element-6d2a8a3 e-con-full e-flex elementor-invisible e-con e-child" data-id="6d2a8a3" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-397b23d elementor-widget elementor-widget-heading" data-id="397b23d" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">ACADÉMIQUE</div>				</div>
				<div class="elementor-element elementor-element-9c048b9 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="9c048b9" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-531aac2 elementor-widget elementor-widget-hfe-infocard" data-id="531aac2" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h2 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Excellence Académique à Portée de Main</h2>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Accédez à une formation d'excellence depuis chez vous grâce à notre plateforme d'apprentissage en ligne. Nos programmes académiques sont conçus pour s'adapter à votre emploi du temps, vous permettant d'étudier à votre rythme tout en bénéficiant d'un accompagnement personnalisé par nos formateurs experts.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
				<div class="elementor-element elementor-element-be696e1 elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-invisible elementor-widget elementor-widget-button" data-id="be696e1" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
										<a class="elementor-button elementor-button-link elementor-size-sm" href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: #DC2626; border: none; cursor: pointer;">
						<span class="elementor-button-content-wrapper">
									<i aria-hidden="true" class="jki jki-arrow-up-solid" style="font-size: 24px; color: #ffffff; animation: bounceArrow 2s infinite;"></i>
					</span>
					</a>
								</div>
				</div>
		<div class="elementor-element elementor-element-e58d0aa e-con-full e-flex e-con e-child" data-id="e58d0aa" data-element_type="container">
		<div class="elementor-element elementor-element-35dad1d e-con-full e-flex elementor-invisible e-con e-child" data-id="35dad1d" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInLeft&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-02748b5 elementor-align-justify elementor-widget__width-inherit elementor-widget elementor-widget-button" data-id="02748b5" data-element_type="widget" data-widget_type="button.default">
										<span class="elementor-button elementor-button-link elementor-size-sm" style="cursor: default; pointer-events: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text">Licences</span>
					</span>
					</span>
								</div>
				<div class="elementor-element elementor-element-e787eab elementor-widget elementor-widget-text-editor" data-id="e787eab" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Formations de niveau licence accessibles en ligne avec un accompagnement personnalisé et des ressources pédagogiques complètes.</p>								</div>
				</div>
		<div class="elementor-element elementor-element-4c876a3 e-con-full e-flex elementor-invisible e-con e-child" data-id="4c876a3" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInRight&quot;,&quot;animation_mobile&quot;:&quot;none&quot;,&quot;animation_delay&quot;:300}">
				<div class="elementor-element elementor-element-42d4122 elementor-align-justify elementor-widget__width-inherit elementor-widget elementor-widget-button" data-id="42d4122" data-element_type="widget" data-widget_type="button.default">
										<span class="elementor-button elementor-button-link elementor-size-sm" style="cursor: default; pointer-events: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text">Masters</span>
					</span>
					</span>
								</div>
				<div class="elementor-element elementor-element-6ba2f0c elementor-widget elementor-widget-text-editor" data-id="6ba2f0c" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Programmes de master en ligne pour approfondir vos compétences et accéder à des postes à responsabilité.</p>								</div>
				</div>
		<div class="elementor-element elementor-element-03e269c e-con-full e-flex elementor-invisible e-con e-child" data-id="03e269c" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInLeft&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-8de4fbc elementor-align-justify elementor-widget__width-inherit elementor-widget elementor-widget-button" data-id="8de4fbc" data-element_type="widget" data-widget_type="button.default">
										<span class="elementor-button elementor-button-link elementor-size-sm" style="cursor: default; pointer-events: none;">
						<span class="elementor-button-content-wrapper">
									<span class="elementor-button-text">Stage</span>
					</span>
					</span>
								</div>
				<div class="elementor-element elementor-element-68bd9dc elementor-widget elementor-widget-text-editor" data-id="68bd9dc" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Stages pratiques en entreprise pour acquérir de l'expérience professionnelle et mettre en pratique vos compétences dans un environnement réel.</p>								</div>
				</div>
				</div>
					</div>
				</div>
		<div id="faculties-section" class="elementor-element elementor-element-372f047 e-flex e-con-boxed e-con e-parent" data-id="372f047" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-2432962 e-con-full e-flex e-con e-child" data-id="2432962" data-element_type="container">
		<div class="elementor-element elementor-element-69df6d9 e-con-full e-flex elementor-invisible e-con e-child" data-id="69df6d9" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-5ec128f elementor-widget elementor-widget-heading" data-id="5ec128f" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">FACULTÉS</div>				</div>
				<div class="elementor-element elementor-element-7bcbf29 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="7bcbf29" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-1a0523c elementor-widget elementor-widget-hfe-infocard" data-id="1a0523c" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h2 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Explorez Nos Facultés Diverses</h2>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Découvrez notre large gamme de programmes de formation à distance dans diverses disciplines. Chaque faculté propose des cours en ligne adaptés à votre niveau et à vos objectifs professionnels.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-0a597a9 e-con-full e-flex e-con e-child" data-id="0a597a9" data-element_type="container">
		<div class="elementor-element elementor-element-82ee096 e-con-full e-flex e-con e-child" data-id="82ee096" data-element_type="container">
		<div class="elementor-element elementor-element-f7ea4f7 e-con-full e-flex e-con e-child" data-id="f7ea4f7" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Ginfo.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-0ee9f39 elementor-widget elementor-widget-hfe-infocard" data-id="0ee9f39" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Génie Informatique</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations complètes en génie informatique accessibles en ligne : programmation, architecture des systèmes, bases de données et développement logiciel avec projets pratiques virtuels.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-b829a08 e-con-full e-transform e-transform e-flex e-con e-child" data-id="b829a08" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-b7e85e0 elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="b7e85e0" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-edb6620 e-con-full e-flex e-con e-child" data-id="edb6620" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Glogiciel.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-14d8ec3 elementor-widget elementor-widget-hfe-infocard" data-id="14d8ec3" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Génie Logiciel et Informatique Appliquée à la Gestion des Entreprise (IAGE)</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations spécialisées en génie logiciel et informatique appliquée à la gestion d'entreprise : développement d'applications métier, systèmes d'information, gestion de projets IT et intégration des technologies dans les processus organisationnels.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-69e2adf e-con-full e-transform e-transform e-flex e-con e-child" data-id="69e2adf" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-e1f4adc elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="e1f4adc" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-dc82a13 e-con-full e-flex e-con e-child" data-id="dc82a13" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Csecurite.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-5fdd64a elementor-widget elementor-widget-hfe-infocard" data-id="5fdd64a" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Cybersécurité</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations spécialisées en cybersécurité accessibles en ligne : protection des systèmes d'information, analyse des menaces, gestion des risques numériques, éthique du hacking et certifications professionnelles avec laboratoires virtuels.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-edc544d e-con-full e-transform e-transform e-flex e-con e-child" data-id="edc544d" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-c9d2def elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="c9d2def" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-200622e e-con-full e-flex e-con e-child" data-id="200622e" data-element_type="container">
		<div class="elementor-element elementor-element-5dd64b0 e-con-full e-flex e-con e-child" data-id="5dd64b0" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/IA.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-25875cb elementor-widget elementor-widget-hfe-infocard" data-id="25875cb" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Data Science et Intelligence Artificielle (IA)</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations avancées en data science et intelligence artificielle accessibles en ligne : machine learning, deep learning, analyse de données massives, traitement du langage naturel et projets d'IA avec outils et plateformes professionnelles.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-55e1125 e-con-full e-transform e-transform e-flex e-con e-child" data-id="55e1125" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-b4fe958 elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="b4fe958" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-57db236 e-con-full e-flex e-con e-child" data-id="57db236" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/cloud.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-bd594cb elementor-widget elementor-widget-hfe-infocard" data-id="bd594cb" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Cloud Computing et Big Data</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations spécialisées en cloud computing et big data accessibles en ligne : architectures cloud, virtualisation, stockage distribué, traitement de données massives, Hadoop, Spark et solutions cloud avec projets pratiques sur plateformes professionnelles.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-7a8a032 e-con-full e-transform e-transform e-flex e-con e-child" data-id="7a8a032" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-9bb924b elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="9bb924b" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-6f58eb1 e-con-full e-flex e-con e-child" data-id="6f58eb1" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/reseaux.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-37722f8 elementor-widget elementor-widget-hfe-infocard" data-id="37722f8" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Réseaux et Télécommunications</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Formations complètes en réseaux et télécommunications accessibles en ligne : administration réseau, protocoles de communication, sécurité réseau, télécommunications mobiles et 5G, virtualisation réseau avec laboratoires et simulations pratiques.				</div>
							</div>
		</div>

						</div>
				</div>
		<div class="elementor-element elementor-element-b35b2bd e-con-full e-transform e-transform e-flex e-con e-child" data-id="b35b2bd" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;_transform_translateX_effect&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:0,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:-33,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateX_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;%&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_tablet&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]},&quot;_transform_translateY_effect_hover_mobile&quot;:{&quot;unit&quot;:&quot;px&quot;,&quot;size&quot;:&quot;&quot;,&quot;sizes&quot;:[]}}">
				<div class="elementor-element elementor-element-b57fa06 elementor-view-stacked elementor-shape-square elementor-widget elementor-widget-icon" data-id="b57fa06" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<i aria-hidden="true" class="jki jki-arrow-right-solid"></i>			</div>
		</div>
						</div>
				</div>
				</div>
				</div>
				<div class="elementor-element elementor-element-7d46d8d elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-align-center elementor-invisible elementor-widget elementor-widget-button" data-id="7d46d8d" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
										<a class="elementor-button elementor-button-link elementor-size-sm" href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: #DC2626; border: none; cursor: pointer;">
						<span class="elementor-button-content-wrapper">
									<i aria-hidden="true" class="jki jki-arrow-up-solid" style="font-size: 24px; color: #ffffff; animation: bounceArrow 2s infinite;"></i>
					</span>
					</a>
								</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-dcb6d62 e-flex e-con-boxed e-con e-parent" data-id="dcb6d62" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-a180d38 e-con-full e-flex elementor-invisible e-con e-child" data-id="a180d38" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}" style="background-image: url('{{ asset('assets/images/Activite.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-56477a3 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-heading" data-id="56477a3" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Activités d'Apprentissage à Bj Académie</h2>				</div>
		<div class="elementor-element elementor-element-1c4edd7 e-con-full e-flex e-con e-child" data-id="1c4edd7" data-element_type="container">
				<div class="elementor-element elementor-element-d52da29 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-text-editor" data-id="d52da29" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Participez à des activités d'apprentissage interactives en ligne : webinaires, travaux pratiques virtuels et projets collaboratifs.</p>								</div>
				<div class="elementor-element elementor-element-799f783 elementor-widget elementor-widget-jkit_video_button" data-id="799f783" data-element_type="widget" data-widget_type="jkit_video_button.default">
					<div class="jeg-elementor-kit jkit-video-button jeg_module_30_4_691fc3db29aab" data-autoplay="0" data-loop="0" data-controls="0" data-type="youtube" data-mute="0" data-start="0" data-end="0"><a href="https://www.youtube.com/watch?v=MLpWrANjFbI" class="jkit-video-popup-btn glow-enable" aria-label="video-button"><span class="icon-position-before"><i aria-hidden="true" class="jki jki-play-button-light"></i></span></a></div>				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-c837fe2 e-con-full e-flex elementor-invisible e-con e-child" data-id="c837fe2" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;,&quot;animation_delay&quot;:300}" style="background-image: url('{{ asset('assets/images/communaute.jpg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-77e2476 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-heading" data-id="77e2476" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Communauté & Événements en Ligne</h2>				</div>
		<div class="elementor-element elementor-element-d3ea890 e-con-full e-flex e-con e-child" data-id="d3ea890" data-element_type="container">
				<div class="elementor-element elementor-element-903db24 elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-text-editor" data-id="903db24" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Rejoignez notre communauté en ligne : clubs étudiants virtuels, événements numériques et réseautage professionnel.</p>								</div>
				<div class="elementor-element elementor-element-4633880 elementor-widget elementor-widget-jkit_video_button" data-id="4633880" data-element_type="widget" data-widget_type="jkit_video_button.default">
					<div class="jeg-elementor-kit jkit-video-button jeg_module_30_5_691fc3db2a1e4" data-autoplay="0" data-loop="0" data-controls="0" data-type="youtube" data-mute="0" data-start="0" data-end="0"><a href="https://www.youtube.com/watch?v=MLpWrANjFbI" class="jkit-video-popup-btn glow-enable" aria-label="video-button"><span class="icon-position-before"><i aria-hidden="true" class="jki jki-play-button-light"></i></span></a></div>				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-ff43529 e-flex e-con-boxed e-con e-parent" data-id="ff43529" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-8fed6f0 e-con-full e-flex e-con e-child" data-id="8fed6f0" data-element_type="container">
		<div class="elementor-element elementor-element-b541ed3 e-con-full e-flex elementor-invisible e-con e-child" data-id="b541ed3" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-1c11399 elementor-widget elementor-widget-heading" data-id="1c11399" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">Vie de la Communauté</div>				</div>
				<div class="elementor-element elementor-element-efb1248 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="efb1248" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-af1ecab elementor-widget elementor-widget-heading" data-id="af1ecab" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Développez et Améliorez Vos Compétences Transversales Partout</h2>				</div>
				<div class="elementor-element elementor-element-51f52dc elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="51f52dc" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Renforcez vos compétences transversales depuis n'importe où : communication, leadership, gestion du temps et résolution de problèmes grâce à nos modules en ligne interactifs.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-ec57d7e e-con-full e-flex e-con e-child" data-id="ec57d7e" data-element_type="container">
		<div class="elementor-element elementor-element-d2afc47 e-con-full e-flex e-con e-child" data-id="d2afc47" data-element_type="container">
		<div class="elementor-element elementor-element-f3aa3ea e-con-full e-flex e-con e-child" data-id="f3aa3ea" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Organisation.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-1a9cca6 elementor-invisible elementor-widget elementor-widget-hfe-infocard" data-id="1a9cca6" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;slideInLeft&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h4 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Organisations et Clubs Étudiants</h4>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Rejoignez nos clubs étudiants virtuels : débats en ligne, projets collaboratifs et réseautage professionnel pour enrichir votre expérience académique.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-491145b e-con-full e-flex e-con e-child" data-id="491145b" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Conference.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-e30102a elementor-invisible elementor-widget elementor-widget-hfe-infocard" data-id="e30102a" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;slideInLeft&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h4 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Arts, Culture et Bien-Être – BJ Académie</h4>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Plongez dans notre univers artistique et culturel : ateliers numériques, masterclass créatives, conférences interactives et activités de bien-être pour enrichir votre expérience en ligne.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-c0c6eaf e-con-full e-flex e-con e-child" data-id="c0c6eaf" data-element_type="container">
		<div class="elementor-element elementor-element-868eac0 e-con-full e-flex e-con e-child" data-id="868eac0" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Collab.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-0b8d1ea elementor-invisible elementor-widget elementor-widget-hfe-infocard" data-id="0b8d1ea" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;slideInLeft&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h4 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Leadership & Engagement Communautaire</h4>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Renforcez votre leadership en participant à des initiatives solidaires en ligne : projets collaboratifs, engagement communautaire virtuel et actions à impact social.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-41a00ae e-con-full e-flex e-con e-child" data-id="41a00ae" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Tradiition.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="elementor-element elementor-element-9f4603b elementor-invisible elementor-widget elementor-widget-hfe-infocard" data-id="9f4603b" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;slideInLeft&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h4 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Événements et Traditions en Ligne</h4>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Vivez nos traditions en ligne : cérémonies virtuelles, conférences thématiques, rencontres digitales et moments forts qui nourrissent notre identité communautaire.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-98a7789 e-flex e-con-boxed e-con e-parent" data-id="98a7789" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-f4306dd e-con-full e-flex e-con e-child" data-id="f4306dd" data-element_type="container">
		<div class="elementor-element elementor-element-9b80518 e-con-full e-flex e-con e-child" data-id="9b80518" data-element_type="container">
		<div class="elementor-element elementor-element-160ca6e e-con-full e-flex elementor-invisible e-con e-child" data-id="160ca6e" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-ec666c6 elementor-widget elementor-widget-heading" data-id="ec666c6" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">POURQUOI BJ ACADÉMIE ?</div>				</div>
				<div class="elementor-element elementor-element-56da615 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="56da615" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-6fdc370 elementor-widget elementor-widget-heading" data-id="6fdc370" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Pourquoi Nous Sommes le Bon Choix pour
Votre Avenir Éducatif</h2>				</div>
				</div>
				<div class="elementor-element elementor-element-a968c9a elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="a968c9a" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Bj Académie offre une formation à distance flexible, reconnue et adaptée à votre rythme. Nos programmes sont conçus pour vous préparer aux défis professionnels avec un accompagnement personnalisé et des ressources pédagogiques de qualité.</p>								</div>
				</div>
		<div class="elementor-element elementor-element-8fc06f1 e-con-full e-flex e-con e-child" data-id="8fc06f1" data-element_type="container">
		<div class="elementor-element elementor-element-9a6f162 e-con-full e-flex e-con e-child" data-id="9a6f162" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;}">
				<div class="elementor-element elementor-element-44e5891 elementor-widget elementor-widget-spacer" data-id="44e5891" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-229b995 elementor-widget elementor-widget-image" data-id="229b995" data-element_type="widget" data-widget_type="image.default">
															<img loading="lazy" decoding="async" src="{{ asset('assets/images/Academie.jpg') }}" class="attachment-full size-full wp-image-549" alt="BJ Académie">															</div>
		<div class="elementor-element elementor-element-1c9c32f e-con-full e-flex e-con e-child" data-id="1c9c32f" data-element_type="container">
		<div class="elementor-element elementor-element-760d44f e-con-full e-flex e-con e-child" data-id="760d44f" data-element_type="container">
				<div class="elementor-element elementor-element-5ce4ae6 elementor-view-default elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box" data-id="5ce4ae6" data-element_type="widget" data-widget_type="icon-box.default">
							<div class="elementor-icon-box-wrapper">

						<div class="elementor-icon-box-icon">
				<span class="elementor-icon">
				<i aria-hidden="true" class="jki jki-industry-solid"></i>				</span>
			</div>
			
						<div class="elementor-icon-box-content">

									<h5 class="elementor-icon-box-title">
						<span>
							Apprentissage Connecté au Monde Professionnel						</span>
					</h5>
				
									<p class="elementor-icon-box-description">
						Bénéficiez d'une formation directement connectée au monde du travail : collaborations avec des experts, projets appliqués et compétences adaptées aux attentes des entreprises.					</p>
				
			</div>
			
		</div>
						</div>
				<div class="elementor-element elementor-element-9a93a80 elementor-view-default elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box" data-id="9a93a80" data-element_type="widget" data-widget_type="icon-box.default">
							<div class="elementor-icon-box-wrapper">

						<div class="elementor-icon-box-icon">
				<span class="elementor-icon">
				<i aria-hidden="true" class="jki jki-swatchbook-solid"></i>				</span>
			</div>
			
						<div class="elementor-icon-box-content">

									<h5 class="elementor-icon-box-title">
						<span>
							Infrastructures Numériques de Pointe						</span>
					</h5>
				
									<p class="elementor-icon-box-description">
						Profitez d'un écosystème digital performant : ressources en ligne, espaces d'expérimentation virtuelle et technologies collaboratives pensées pour une formation de qualité.					</p>
				
			</div>
			
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-a3c85d4 e-con-full e-flex e-con e-child" data-id="a3c85d4" data-element_type="container">
				<div class="elementor-element elementor-element-6a1d54c elementor-view-default elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box" data-id="6a1d54c" data-element_type="widget" data-widget_type="icon-box.default">
							<div class="elementor-icon-box-wrapper">

						<div class="elementor-icon-box-icon">
				<span class="elementor-icon">
				<i aria-hidden="true" class="jki jki-book-reader-solid"></i>				</span>
			</div>
			
						<div class="elementor-icon-box-content">

									<h5 class="elementor-icon-box-title">
						<span>
							Mentorat et Accompagnement Personnalisé						</span>
					</h5>
				
									<p class="elementor-icon-box-description">
						Profitez d'un mentorat de qualité : experts disponibles à distance, conseils sur mesure et soutien continu pour vous aider à atteindre vos objectifs.					</p>
				
			</div>
			
		</div>
						</div>
				<div class="elementor-element elementor-element-a93d3e4 elementor-view-default elementor-position-top elementor-mobile-position-top elementor-widget elementor-widget-icon-box" data-id="a93d3e4" data-element_type="widget" data-widget_type="icon-box.default">
							<div class="elementor-icon-box-wrapper">

						<div class="elementor-icon-box-icon">
				<span class="elementor-icon">
				<i aria-hidden="true" class="jki jki-globe-americas-solid"></i>				</span>
			</div>
			
						<div class="elementor-icon-box-content">

									<h5 class="elementor-icon-box-title">
						<span>
							Collaboration Internationale						</span>
					</h5>
				
									<p class="elementor-icon-box-description">
						Participez à des projets globaux et échangez avec des étudiants du monde entier grâce à nos outils de collaboration en ligne.					</p>
				
			</div>
			
		</div>
						</div>
				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-38f0590 e-flex e-con-boxed e-con e-parent" data-id="38f0590" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-7cc8b21 e-con-full e-flex e-con e-child" data-id="7cc8b21" data-element_type="container">
		<div class="elementor-element elementor-element-a2608dc e-con-full e-flex elementor-invisible e-con e-child" data-id="a2608dc" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-b6e7d4d elementor-widget elementor-widget-heading" data-id="b6e7d4d" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">COMMENT POSTULER</div>				</div>
				<div class="elementor-element elementor-element-f03e75c elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="f03e75c" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-7d177c7 elementor-widget elementor-widget-heading" data-id="7d177c7" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Votre Voyage Commence Ici,<br>Étapes vers Votre Succès Éducatif</h2>				</div>
				<div class="elementor-element elementor-element-3391357 elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="3391357" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Le processus d'inscription en ligne est simple et rapide. Remplissez votre candidature, soumettez vos documents numériquement et commencez votre formation à distance dès votre admission.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-f2e0f54 e-con-full e-flex elementor-invisible e-con e-child" data-id="f2e0f54" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeIn&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
		<div class="elementor-element elementor-element-cde1d83 e-con-full elementor-hidden-mobile e-flex e-con e-child" data-id="cde1d83" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;background_background&quot;:&quot;classic&quot;}">
				</div>
		<div class="elementor-element elementor-element-ca9b605 e-con-full e-flex e-con e-child" data-id="ca9b605" data-element_type="container">
		<div class="elementor-element elementor-element-ef2a7fa e-con-full e-flex e-con e-child" data-id="ef2a7fa" data-element_type="container">
		<div class="elementor-element elementor-element-0e01725 e-con-full e-flex e-con e-child" data-id="0e01725" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-77b3812 elementor-widget elementor-widget-heading" data-id="77b3812" data-element_type="widget" data-widget_type="heading.default">
					<h3 class="elementor-heading-title elementor-size-default">1</h3>				</div>
				</div>
				<div class="elementor-element elementor-element-edc3d32 elementor-widget elementor-widget-heading" data-id="edc3d32" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Choisissez Votre Faculté
et Programme</h4>				</div>
				</div>
		<div class="elementor-element elementor-element-129b33d e-con-full e-flex e-con e-child" data-id="129b33d" data-element_type="container">
				<div class="elementor-element elementor-element-5350903 elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon" data-id="5350903" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-09e4d85 elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="09e4d85" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Remplissez votre candidature en ligne en quelques minutes. Notre formulaire d'inscription est simple et sécurisé, accessible 24/7 depuis n'importe quel appareil.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-438d0b7 e-con-full e-flex e-con e-child" data-id="438d0b7" data-element_type="container">
		<div class="elementor-element elementor-element-325c760 e-con-full e-flex e-con e-child" data-id="325c760" data-element_type="container">
		<div class="elementor-element elementor-element-a9657fb e-con-full e-flex e-con e-child" data-id="a9657fb" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-c8fffaa elementor-widget elementor-widget-heading" data-id="c8fffaa" data-element_type="widget" data-widget_type="heading.default">
					<h3 class="elementor-heading-title elementor-size-default">2</h3>				</div>
				</div>
				<div class="elementor-element elementor-element-4e1b745 elementor-widget elementor-widget-heading" data-id="4e1b745" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Examiner les Exigences
d'Admission</h4>				</div>
				</div>
		<div class="elementor-element elementor-element-a8017a5 e-con-full e-flex e-con e-child" data-id="a8017a5" data-element_type="container">
				<div class="elementor-element elementor-element-56eaed6 elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon" data-id="56eaed6" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-b3e5ca2 elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="b3e5ca2" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Consultez les prérequis de votre programme choisi. Nos conseillers en ligne sont disponibles pour vous guider dans la préparation de votre dossier d'admission.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-a1f76ef e-con-full e-flex e-con e-child" data-id="a1f76ef" data-element_type="container">
		<div class="elementor-element elementor-element-2fc2215 e-con-full e-flex e-con e-child" data-id="2fc2215" data-element_type="container">
		<div class="elementor-element elementor-element-922b723 e-con-full e-flex e-con e-child" data-id="922b723" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-5e2791c elementor-widget elementor-widget-heading" data-id="5e2791c" data-element_type="widget" data-widget_type="heading.default">
					<h3 class="elementor-heading-title elementor-size-default">3</h3>				</div>
				</div>
				<div class="elementor-element elementor-element-95d3eab elementor-widget elementor-widget-heading" data-id="95d3eab" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Soumettez les Documents
Requis</h4>				</div>
				</div>
		<div class="elementor-element elementor-element-cba7ba0 e-con-full e-flex e-con e-child" data-id="cba7ba0" data-element_type="container">
				<div class="elementor-element elementor-element-a178edf elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon" data-id="a178edf" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-b4a3e7b elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="b4a3e7b" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Téléchargez vos documents requis directement sur notre plateforme sécurisée : diplômes, relevés de notes, pièce d'identité et autres documents nécessaires à votre candidature.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-c8ad364 e-con-full e-flex e-con e-child" data-id="c8ad364" data-element_type="container">
		<div class="elementor-element elementor-element-309d0aa e-con-full e-flex e-con e-child" data-id="309d0aa" data-element_type="container">
		<div class="elementor-element elementor-element-bc25988 e-con-full e-flex e-con e-child" data-id="bc25988" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-6eba97c elementor-widget elementor-widget-heading" data-id="6eba97c" data-element_type="widget" data-widget_type="heading.default">
					<h3 class="elementor-heading-title elementor-size-default">4</h3>				</div>
				</div>
				<div class="elementor-element elementor-element-5667290 elementor-widget elementor-widget-heading" data-id="5667290" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Examen de la Candidature
et Entretien</h4>				</div>
				</div>
		<div class="elementor-element elementor-element-6221a6b e-con-full e-flex e-con e-child" data-id="6221a6b" data-element_type="container">
				<div class="elementor-element elementor-element-ecf8cbb elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon" data-id="ecf8cbb" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-6355fdd elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="6355fdd" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Notre équipe examine votre dossier dans les plus brefs délais. Si nécessaire, un entretien en ligne sera organisé pour mieux comprendre vos motivations et objectifs.</p>								</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-199f2ee e-con-full e-flex e-con e-child" data-id="199f2ee" data-element_type="container">
		<div class="elementor-element elementor-element-1b40616 e-con-full e-flex e-con e-child" data-id="1b40616" data-element_type="container">
		<div class="elementor-element elementor-element-0ad8d61 e-con-full e-flex e-con e-child" data-id="0ad8d61" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-1362180 elementor-widget elementor-widget-heading" data-id="1362180" data-element_type="widget" data-widget_type="heading.default">
					<h3 class="elementor-heading-title elementor-size-default">5</h3>				</div>
				</div>
				<div class="elementor-element elementor-element-d18acd9 elementor-widget elementor-widget-heading" data-id="d18acd9" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Recevez Votre Décision
d'Admission</h4>				</div>
				</div>
		<div class="elementor-element elementor-element-b516f0e e-con-full e-flex e-con e-child" data-id="b516f0e" data-element_type="container">
				<div class="elementor-element elementor-element-cce15d5 elementor-hidden-mobile elementor-view-default elementor-widget elementor-widget-icon" data-id="cce15d5" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-circle" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-d2e1f15 elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="d2e1f15" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Recevez votre décision d'admission par email ou par whatsApp dans un délai raisonnable. En cas d'acceptation, vous recevrez toutes les informations nécessaires pour commencer votre formation à distance.</p>								</div>
				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-8fcd4aa e-flex e-con-boxed e-con e-parent" data-id="8fcd4aa" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;gradient&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-ae7e1b8 e-con-full e-flex elementor-invisible e-con e-child" data-id="ae7e1b8" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;,&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
		<div class="elementor-element elementor-element-680127d e-con-full e-flex e-con e-child" data-id="680127d" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;}">
		<div class="elementor-element elementor-element-3568ee6 e-con-full e-flex e-con e-child" data-id="3568ee6" data-element_type="container">
				<div class="elementor-element elementor-element-7438d5b elementor-widget elementor-widget-spacer" data-id="7438d5b" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-e617d70 e-con-full e-flex e-con e-child" data-id="e617d70" data-element_type="container" data-settings="{&quot;position&quot;:&quot;absolute&quot;}">
				<div class="elementor-element elementor-element-3181db2 elementor-widget elementor-widget-spacer" data-id="3181db2" data-element_type="widget" data-widget_type="spacer.default">
							<div class="elementor-spacer">
			<div class="elementor-spacer-inner"></div>
		</div>
						</div>
				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-4312fce e-con-full e-flex e-con e-child" data-id="4312fce" data-element_type="container">
				<div class="elementor-element elementor-element-261c9c1 elementor-invisible elementor-widget elementor-widget-image" data-id="261c9c1" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:200}" data-widget_type="image.default">
															<img loading="lazy" decoding="async" src="{{ asset('assets/images/Support.jpg') }}" class="attachment-full size-full wp-image-685" alt="">															</div>
				</div>
				<div class="elementor-element elementor-element-7017789 elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="7017789" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h2 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Apprentissage Flexible et Excellence Académique</h2>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Profitez d'une formation flexible et performante : suivez vos cours à votre rythme, accédez à un contenu de qualité et renforcez vos compétences professionnelles où que vous soyez.				</div>
							</div>
		</div>

						</div>
				</div>
				<div class="elementor-element elementor-element-b81e8eb elementor-mobile-align-justify elementor-widget-mobile__width-inherit elementor-align-center elementor-invisible elementor-widget elementor-widget-button" data-id="b81e8eb" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:300}" data-widget_type="button.default">
										<a class="elementor-button elementor-button-link elementor-size-sm" href="#" onclick="window.scrollTo({top: 0, behavior: 'smooth'}); return false;" style="display: flex; align-items: center; justify-content: center; width: 60px; height: 60px; border-radius: 50%; background: #DC2626; border: none; cursor: pointer;">
						<span class="elementor-button-content-wrapper">
									<i aria-hidden="true" class="jki jki-arrow-up-solid" style="font-size: 24px; color: #ffffff; animation: bounceArrow 2s infinite;"></i>
					</span>
					</a>
								</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-cc621a2 e-flex e-con-boxed e-con e-parent" data-id="cc621a2" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-2f7d6db e-con-full e-flex e-con e-child" data-id="2f7d6db" data-element_type="container">
		<div class="elementor-element elementor-element-0614b3c e-con-full e-flex e-con e-child" data-id="0614b3c" data-element_type="container">
		<div class="elementor-element elementor-element-43b40cd e-con-full e-flex elementor-invisible e-con e-child" data-id="43b40cd" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-6379984 elementor-widget elementor-widget-heading" data-id="6379984" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">TÉMOIGNAGES</div>				</div>
				<div class="elementor-element elementor-element-d1fdcde elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="d1fdcde" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-7e630f9 elementor-widget elementor-widget-heading" data-id="7e630f9" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Histoires de Réussite Étudiante</h2>				</div>
				</div>
				<div class="elementor-element elementor-element-ce2414c elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="ce2414c" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Découvrez les témoignages de nos étudiants qui ont transformé leur carrière grâce à nos formations à distance. Leurs succès témoignent de la qualité de notre enseignement en ligne.</p>								</div>
				</div>
				<div class="elementor-element elementor-element-112ba40 elementor-widget__width-inherit elementor-invisible elementor-widget elementor-widget-jkit_testimonials" data-id="112ba40" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeIn&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:200}" data-widget_type="jkit_testimonials.default">
					<div class="jeg-elementor-kit jkit-testimonials arrow-bottom-middle style-4  jeg_module_30_6_691fc3db2d81b" data-id="jeg_module_30_6_691fc3db2d81b" data-settings="{&quot;autoplay&quot;:true,&quot;autoplay_speed&quot;:3500,&quot;autoplay_hover_pause&quot;:false,&quot;show_navigation&quot;:false,&quot;navigation_left&quot;:&quot;&lt;span&gt;&lt;svg aria-hidden=\&quot;true\&quot; class=\&quot;e-font-icon-svg e-fas-angle-left\&quot; viewBox=\&quot;0 0 256 512\&quot; xmlns=\&quot;http:\/\/www.w3.org\/2000\/svg\&quot;&gt;&lt;path d=\&quot;M31.7 239l136-136c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9L127.9 256l96.4 96.4c9.4 9.4 9.4 24.6 0 33.9L201.7 409c-9.4 9.4-24.6 9.4-33.9 0l-136-136c-9.5-9.4-9.5-24.6-.1-34z\&quot;&gt;&lt;\/path&gt;&lt;\/svg&gt;&lt;\/span&gt;&quot;,&quot;navigation_right&quot;:&quot;&lt;span&gt;&lt;svg aria-hidden=\&quot;true\&quot; class=\&quot;e-font-icon-svg e-fas-angle-right\&quot; viewBox=\&quot;0 0 256 512\&quot; xmlns=\&quot;http:\/\/www.w3.org\/2000\/svg\&quot;&gt;&lt;path d=\&quot;M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z\&quot;&gt;&lt;\/path&gt;&lt;\/svg&gt;&lt;\/span&gt;&quot;,&quot;show_dots&quot;:true,&quot;arrow_position&quot;:&quot;bottom&quot;,&quot;responsive&quot;:{&quot;desktop&quot;:{&quot;items&quot;:2,&quot;margin&quot;:32,&quot;breakpoint&quot;:1025},&quot;tablet&quot;:{&quot;items&quot;:2,&quot;margin&quot;:10,&quot;breakpoint&quot;:768},&quot;mobile&quot;:{&quot;items&quot;:1,&quot;margin&quot;:10,&quot;breakpoint&quot;:0}}}"><div class="testimonials-list">
            <div class="tns-outer" id="tns1-ow"><div class="tns-liveregion tns-visually-hidden" aria-live="polite" aria-atomic="true">slide <span class="current">5 to 6</span>  of 5</div><div id="tns1-mw" class="tns-ovh"><div class="tns-inner" id="tns1-iw"><div class="testimonials-track  tns-slider tns-carousel tns-subpixel tns-calc tns-horizontal" id="tns1" style="transform: translate3d(-36.3636%, 0px, 0px);"><div class="testimonial-item elementor-repeater-item-a809801 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg 917w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-800x800.jpg 800w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Excellente expérience avec Bj Académie ! Les cours sont bien structurés, les formateurs répondent rapidement aux questions et le diplôme obtenu est reconnu par les employeurs. Un investissement qui en vaut la peine."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-d7a29b1 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="{{ asset('assets/images/Robotique.jpg') }}" class="source-library" alt="Robotique"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Formation à distance de qualité supérieure ! Les vidéos de cours sont claires, les exercices pratiques sont pertinents et le support technique est disponible quand j'en ai besoin. Une expérience d'apprentissage exceptionnelle."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-a6c305b tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg 1000w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-800x800.jpg 800w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"L'accompagnement personnalisé et les webinaires interactifs ont rendu mon apprentissage très enrichissant. J'ai développé des compétences pratiques directement applicables dans mon secteur d'activité."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-2da15b8 tns-item" id="tns1-item0" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1024x1024.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1024x1024.jpg 1024w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1536x1536.jpg 1536w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-800x800.jpg 800w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc.jpg 2000w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"J'ai choisi Bj Académie pour sa flexibilité et je n'ai pas été déçu. Les modules sont progressifs, les quiz permettent de vérifier mes acquis et j'ai pu valider mes compétences professionnelles. Une formation adaptée aux besoins du marché."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-fd27f96 tns-item tns-slide-active" id="tns1-item1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1024x1024.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1024x1024.jpg 1024w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1536x1536.jpg 1536w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-800x800.jpg 800w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc.jpg 2000w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"La plateforme d'apprentissage de Bj Académie est intuitive et facile à utiliser. Les ressources sont accessibles 24/7, ce qui me permet de concilier mes études avec ma vie professionnelle. Un excellent choix pour une formation à distance !"</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-a809801 tns-item tns-slide-active" id="tns1-item2">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg 917w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-800x800.jpg 800w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Grâce à Bj Académie, j'ai pu obtenir mon diplôme tout en travaillant à temps plein. L'équipe pédagogique est réactive et bienveillante, et les évaluations sont adaptées à l'apprentissage en ligne. Je recommande vivement cette formation !"</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-d7a29b1 tns-item" id="tns1-item3" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="{{ asset('assets/images/Robotique.jpg') }}" class="source-library" alt="Robotique"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"La méthode pédagogique de Bj Académie est innovante et efficace. Les cas pratiques réels, les projets collaboratifs et les retours constructifs des formateurs m'ont permis d'acquérir une expertise reconnue dans mon domaine professionnel."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-a6c305b tns-item" id="tns1-item4" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc.jpg 1000w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/businessman-looking-at-the-camera-and-smile-while-2025-01-09-17-50-11-utc-800x800.jpg 800w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Les sessions de mentorat et le suivi personnalisé m'ont permis de progresser rapidement. La communauté étudiante est active et solidaire, ce qui rend l'apprentissage en ligne très agréable. Merci Bj Académie pour cette belle expérience !"</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-2da15b8 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1024x1024.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1024x1024.jpg 1024w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-1536x1536.jpg 1536w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc-800x800.jpg 800w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/front-view-of-student-with-backpack-in-corridor-in-2024-11-19-16-00-57-utc.jpg 2000w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Le système d'évaluation en ligne est transparent et équitable. Les certificats délivrés sont valorisés par les recruteurs et m'ont ouvert de nouvelles opportunités de carrière. Bj Académie a transformé mon parcours professionnel !"</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-fd27f96 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1024x1024.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1024x1024.jpg 1024w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-1536x1536.jpg 1536w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc-800x800.jpg 800w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/portrait-of-smiling-male-university-student-with-b-2024-10-19-05-42-11-utc.jpg 2000w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"Les ressources pédagogiques sont complètes et actualisées. J'apprécie particulièrement les sessions de questions-réponses en direct et la bibliothèque numérique riche en références. Une formation qui allie théorie et pratique avec excellence."</p></div>
                </div>
            </div><div class="testimonial-item elementor-repeater-item-a809801 tns-item tns-slide-cloned" aria-hidden="true" tabindex="-1">
                <div class="testimonial-box hover-from-left">
                    <div class="icon-content"></div><div class="comment-bio">
                <div class="bio-details">
                    <div class="profile-image"><img loading="lazy" decoding="async" width="800" height="800" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" class="source-library" alt="" url="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg" source="library" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc.jpg 917w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-300x300.jpg 300w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-150x150.jpg 150w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-768x768.jpg 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/feeling-chilled-2025-04-05-18-42-45-utc-800x800.jpg 800w" sizes="(max-width: 800px) 100vw, 800px"></div>
                    <ul class="rating-stars"><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-solid"></i></li><li><i aria-hidden="true" class="jki jki-star-half"></i></li></ul>
                    <span class="profile-info">
                        <strong class="profile-name"></strong>
                        <p class="profile-des"></p>
                    </span>
                </div>
            </div><div class="comment-content"><p>"L'interface de la plateforme est ergonomique et les contenus sont mis à jour régulièrement. Les forums de discussion avec les autres étudiants créent une vraie dynamique d'apprentissage. Bj Académie a dépassé mes attentes !"</p></div>
                </div>
            </div></div></div></div><div class="tns-nav" aria-label="Carousel Pagination"><button type="button" data-nav="0" aria-controls="tns1" style="" aria-label="Carousel Page 1 (Current Slide)" class="tns-nav-active"></button><button type="button" data-nav="1" tabindex="-1" aria-controls="tns1" style="" aria-label="Carousel Page 2"></button><button type="button" data-nav="2" tabindex="-1" aria-controls="tns1" style="" aria-label="Carousel Page 3"></button><button type="button" data-nav="3" tabindex="-1" aria-controls="tns1" style="display:none" aria-label="Carousel Page 4"></button><button type="button" data-nav="4" tabindex="-1" aria-controls="tns1" style="display:none" aria-label="Carousel Page 5"></button></div></div>
        </div></div>				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-b1ed131 e-flex e-con-boxed e-con e-parent" data-id="b1ed131" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-4e56930 e-con-full e-flex e-con e-child" data-id="4e56930" data-element_type="container">
		<div class="elementor-element elementor-element-70ded40 e-con-full e-flex elementor-invisible e-con e-child" data-id="70ded40" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-505ee6d elementor-widget elementor-widget-heading" data-id="505ee6d" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">ACTUALITÉS</div>				</div>
				<div class="elementor-element elementor-element-af77d51 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="af77d51" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-b841e08 elementor-widget elementor-widget-heading" data-id="b841e08" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Restez à Jour avec les Dernières<br>
Actualités et Événements sur plateforme</h2>				</div>
				<div class="elementor-element elementor-element-3c12905 elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="3c12905" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Découvrez les dernières actualités de Bj Académie : nouveaux programmes de formation, événements en ligne, réussites étudiantes et innovations pédagogiques dans l'enseignement à distance.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-2e43a3b e-con-full e-flex elementor-invisible e-con e-child" data-id="2e43a3b" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeIn&quot;,&quot;animation_mobile&quot;:&quot;none&quot;,&quot;animation_delay&quot;:200}">
				<div class="elementor-element elementor-element-ece87bc elementor-widget__width-inherit post-grid-col-3 post-grid-col-mobile-1 elementor-widget elementor-widget-gum_posts_grid" data-id="ece87bc" data-element_type="widget" data-widget_type="gum_posts_grid.default">
				<div class="elementor-widget-container">
					<div class="grid-posts"><div class="grid-post grid-col-3 image-position-top"><article id="post-924" class="post-924 post type-post status-publish format-standard has-post-thumbnail hentry category-news">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">ACTUALITÉS</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Robotique.jpg') }}');"><img decoding="async" src="{{ asset('assets/images/Robotique.jpg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">15 Octobre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Équipe Robotique BJ Académie</span></li></ul><h5 class="post-title">Équipe de Robotique Étudiante Remporte le Championnat National</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">Nos étudiants en robotique ont brillamment remporté le championnat national grâce à leurs compétences acquises en formation à distance et leurs projets innovants développés en ligne ...</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div><div class="grid-post grid-col-3 image-position-top"><article id="post-922" class="post-922 post type-post status-publish format-standard has-post-thumbnail hentry category-news">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">ACTUALITÉS</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Recherche.jpg') }}');"><img decoding="async" src="{{ asset('assets/images/Recherche.jpg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">22 Septembre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Département Recherche BJ Académie</span></li></ul><h5 class="post-title">Les Chercheurs de Bj Académie Publient une Percée en Durabilité</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">Nos chercheurs ont publié une étude majeure sur la durabilité environnementale, démontrant l'excellence de la recherche académique menée dans le cadre de nos programmes en ligne ...</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div><div class="grid-post grid-col-3 image-position-top"><article id="post-920" class="post-920 post type-post status-publish format-standard has-post-thumbnail hentry category-news">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">ACTUALITÉS</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Inculbateur.jpeg') }}');"><img decoding="async" src="{{ asset('assets/images/Inculbateur.jpeg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">28 Septembre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Faculté IAGE</span></li></ul><h5 class="post-title">Incubateur Digital de la Faculté IAGE (Informatique Appliquée à la Gestion des Entreprises)</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">Un nouvel incubateur virtuel a été lancé par la Faculté IAGE (Informatique Appliquée à la Gestion des Entreprises) pour soutenir les projets innovants de nos étudiants en informatique, favorisant le développement de solutions numériques, la création d'applications et l'innovation technologique en ligne.</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div><div class="grid-post grid-col-3 image-position-top"><article id="post-918" class="post-918 post type-post status-publish format-standard has-post-thumbnail hentry category-campus-life">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">Vie de la Communauté</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Durabilite.jpg') }}');"><img decoding="async" src="{{ asset('assets/images/Durabilite.jpg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">5 Octobre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Département Développement Durable</span></li></ul><h5 class="post-title">Nouvelles initiatives vertes en ligne pour la durabilité</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">BJ Académie lance de nouvelles initiatives écologiques entièrement virtuelles pour promouvoir la durabilité. Nos étudiants participent à des projets collaboratifs en ligne, sensibilisant et agissant ensemble pour un impact environnemental positif, même à distance.</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div><div class="grid-post grid-col-3 image-position-top"><article id="post-916" class="post-916 post type-post status-publish format-standard has-post-thumbnail hentry category-campus-life category-education category-event category-news">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">Vie de la Communauté</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Cyber.jpg') }}');"><img decoding="async" src="{{ asset('assets/images/Cyber.jpg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">12 Octobre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Faculté Cybersécurité</span></li></ul><h5 class="post-title">La Faculté de Cybersécurité Présente un Projet Étudiant Inspirant</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">Découvrez le projet réalisé par nos étudiants de la Faculté de Cybersécurité, illustrant leur expertise en protection des systèmes, gestion des risques et solutions de sécurité innovantes, développée grâce à nos programmes de formation en ligne.</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div><div class="grid-post grid-col-3 image-position-top"><article id="post-914" class="post-914 post type-post status-publish format-standard has-post-thumbnail hentry category-campus-life">
      <div class="post-top">
<ul class="meta-position-before posts-meta"><li class="list-meta category_meta"><a href="/"><span class="meta-text">Vie de la Communauté</span></a></li></ul>        <div class="blog-image" style="background-image: url('{{ asset('assets/images/Zone.jpg') }}');"><img decoding="async" src="{{ asset('assets/images/Zone.jpg') }}" title="" alt=""></div>
    <ul class="meta-position-after posts-meta"></ul>  </div>
        <div class="post-content">
      <ul class="meta-position-top posts-meta"><li class="list-meta date_meta"><i aria-hidden="true" class="icon icon-calendar1"></i><span class="meta-text">8 Octobre 2025</span></li><li class="meta-divider"></li><li class="list-meta author_meta"><i aria-hidden="true" class="icon icon-user"></i><span class="meta-text">Programme Extension BJ Académie</span></li></ul><h5 class="post-title">Le Programme d'Extension Favorise l'Apprentissage à Distance en Zones Rurales</h5><ul class="meta-position-mid posts-meta"></ul>      <div class="content-excerpt clearfix">Notre programme d'extension permet désormais à davantage d'étudiants vivant en zones rurales d'accéder à un apprentissage de qualité, grâce à nos cours entièrement en ligne et à un accompagnement à distance personnalisé.</div>      <ul class="meta-position-content posts-meta"></ul>        </div>
  <ul class="meta-position-bottom posts-meta"></ul></article>
</div></div><div class="not-empty">&nbsp;</div>				</div>
				</div>
				</div>
					</div>
				</div>
				</div>
		
		<!-- Script pour le toggle pricing - DOIT ÊTRE AVANT LES BOUTONS -->
		<script>
			// Fonction globale pour gérer le toggle pricing - DÉFINIE EN PREMIER
			window.handlePricingToggle = function(period, buttonElement) {
				console.log('🟢 [PRICING] handlePricingToggle appelé - période:', period);
				console.log('🟢 [PRICING] Bouton:', buttonElement);
				
				try {
					// Mettre à jour les boutons visuellement
					const allButtons = document.querySelectorAll('.pricing-toggle-btn');
					console.log('🔧 [PRICING] Nombre de boutons trouvés:', allButtons.length);
					
					allButtons.forEach(btn => {
						btn.classList.remove('active');
						btn.style.background = 'transparent';
						btn.style.color = '#666';
					});
					
					if (buttonElement) {
						buttonElement.classList.add('active');
						buttonElement.style.background = '#ffffff';
						buttonElement.style.color = '#1a1a1a';
						console.log('✅ [PRICING] Bouton activé visuellement');
					}
					
					// Mettre à jour les prix Licence
					const priceLicence = document.querySelector('.pricing-price-licence');
					const subtitleLicence = document.querySelector('.pricing-subtitle-licence');
					
					console.log('🔧 [PRICING] Éléments Licence:', {
						price: !!priceLicence,
						subtitle: !!subtitleLicence
					});
					
					if (priceLicence && subtitleLicence) {
						if (period === 'annual') {
							const amount = priceLicence.getAttribute('data-annual-amount');
							const label = priceLicence.getAttribute('data-annual-label');
							const subtitle = subtitleLicence.getAttribute('data-annual');
							
							console.log('🔧 [PRICING] Données annuelles Licence:', {amount, label, subtitle});
							
							if (amount && label) {
								priceLicence.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								if (subtitle) {
									subtitleLicence.textContent = subtitle;
								}
								console.log('✅ [PRICING] Prix Licence mis à jour (Annuel):', amount);
							} else {
								console.error('❌ [PRICING] Données annuelles manquantes pour Licence');
							}
						} else {
							const amount = priceLicence.getAttribute('data-monthly-amount');
							const label = priceLicence.getAttribute('data-monthly-label');
							const subtitle = subtitleLicence.getAttribute('data-monthly');
							
							if (amount && label) {
								priceLicence.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								if (subtitle) {
									subtitleLicence.textContent = subtitle;
								}
								console.log('✅ [PRICING] Prix Licence mis à jour (Mensuel):', amount);
							}
						}
					} else {
						console.error('❌ [PRICING] Éléments Licence non trouvés');
					}
					
					// Mettre à jour les prix Master
					const priceMaster = document.querySelector('.pricing-price-master');
					const subtitleMaster = document.querySelector('.pricing-subtitle-master');
					
					console.log('🔧 [PRICING] Éléments Master:', {
						price: !!priceMaster,
						subtitle: !!subtitleMaster
					});
					
					if (priceMaster && subtitleMaster) {
						if (period === 'annual') {
							const amount = priceMaster.getAttribute('data-annual-amount');
							const label = priceMaster.getAttribute('data-annual-label');
							const subtitle = subtitleMaster.getAttribute('data-annual');
							
							console.log('🔧 [PRICING] Données annuelles Master:', {amount, label, subtitle});
							
							if (amount && label) {
								priceMaster.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								if (subtitle) {
									subtitleMaster.textContent = subtitle;
								}
								console.log('✅ [PRICING] Prix Master mis à jour (Annuel):', amount);
							} else {
								console.error('❌ [PRICING] Données annuelles manquantes pour Master');
							}
						} else {
							const amount = priceMaster.getAttribute('data-monthly-amount');
							const label = priceMaster.getAttribute('data-monthly-label');
							const subtitle = subtitleMaster.getAttribute('data-monthly');
							
							if (amount && label) {
								priceMaster.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								if (subtitle) {
									subtitleMaster.textContent = subtitle;
								}
								console.log('✅ [PRICING] Prix Master mis à jour (Mensuel):', amount);
							}
						}
					} else {
						console.error('❌ [PRICING] Éléments Master non trouvés');
					}
					
					console.log('✅ [PRICING] Toggle terminé avec succès');
					return false;
				} catch(error) {
					console.error('❌ [PRICING] ERREUR dans handlePricingToggle:', error);
					console.error('❌ [PRICING] Stack:', error.stack);
					return false;
				}
			};
			
			console.log('✅ [PRICING] Fonction handlePricingToggle définie sur window');
			console.log('✅ [PRICING] Test de la fonction:', typeof window.handlePricingToggle);
		</script>
		
		<!-- Section Tarification -->
		<div id="pricing-section" class="elementor-element elementor-element-pricing-section e-flex e-con-boxed e-con e-parent" data-id="pricing-section" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-color: #f5f5f5; padding: 80px 0;">
			<div class="e-con-inner">
				<div class="elementor-element elementor-element-pricing-title e-con-full e-flex e-con e-child" data-id="pricing-title" data-element_type="container">
					<div class="elementor-element elementor-element-pricing-heading elementor-widget elementor-widget-heading" data-id="pricing-heading" data-element_type="widget" data-widget_type="heading.default">
						<h2 class="elementor-heading-title elementor-size-default" style="text-align: center; font-size: 48px; font-weight: 700; margin-bottom: 40px; color: #1a1a1a;">Modalités d'inscription</h2>
					</div>
					<div class="elementor-element elementor-element-pricing-toggle e-con-full e-flex e-con e-child" data-id="pricing-toggle" data-element_type="container" style="display: flex; justify-content: center; align-items: center; gap: 12px; margin-bottom: 60px;">
						<div style="display: flex; background: #f5f5f5; border-radius: 8px; padding: 4px; gap: 0;">
							<button class="pricing-toggle-btn active" data-period="monthly" onclick="handlePricingToggle('monthly', this)" style="padding: 12px 24px; border: none; background: #ffffff; color: #1a1a1a; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Mensuel</button>
							<button class="pricing-toggle-btn" data-period="annual" onclick="handlePricingToggle('annual', this)" style="padding: 12px 24px; border: none; background: transparent; color: #666; border-radius: 6px; font-weight: 600; cursor: pointer; transition: all 0.3s;">Annuel</button>
						</div>
					</div>
				</div>
				<div class="elementor-element elementor-element-pricing-cards e-con-full e-flex e-con e-child" data-id="pricing-cards" data-element_type="container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; max-width: 1200px; margin: 0 auto; padding: 0 20px;">
					<!-- Plan Light -->
					<div class="elementor-element elementor-element-pricing-card-light e-con-full e-flex e-con e-child" data-id="pricing-card-light" data-element_type="container" style="background: #ffffff; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; flex-direction: column;">
						<div style="margin-bottom: 16px;">
							<h3 style="font-size: 28px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px 0;">Licence</h3>
							<p style="font-size: 14px; color: #666; margin: 0;">Ouverture le 25 Novembre 2025</p>
						</div>
						<div style="margin-bottom: 24px;">
							<div class="pricing-price-licence" data-monthly-amount="25.000fcfa" data-monthly-label="l'inscription" data-annual-amount="160.000fcfa" data-annual-label="l'année" style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 4px;">25.000fcfa <span style="font-size: 14px; font-weight: 400; color: #666;">l'inscription</span></div>
							<p class="pricing-subtitle-licence" data-monthly="puis 20.000 fcfa par mois." data-annual="soit une réduction de 11%." style="font-size: 14px; color: #666; margin: 4px 0 0 0;">puis 20.000 fcfa par mois.</p>
						</div>
						<button type="button" onclick="showRegisterForm()" class="pricing-get-started-btn" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); border: none; border-radius: 8px; color: #1a1a1a; font-weight: 600; font-size: 16px; cursor: pointer; margin-top: auto; transition: all 0.3s;">M'inscrire</button>
						<div style="margin-top: 32px; display: flex; flex-direction: column; gap: 16px;">
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">50+ classes de maître</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Chat avec des personnes partageant les mêmes idées</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Offres spéciales</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Accès à la bibliothèque du confiseur</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Conférences sur la théorie de la confiserie</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Sessions intensives de formation thématiques chaque mois</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#10b981" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #1a1a1a;">Accompagnement par un mentor – réunions en ligne avec l'administrateur deux fois par mois</span>
							</div>
						</div>
					</div>
					<!-- Plan Basic -->
					<div class="elementor-element elementor-element-pricing-card-basic e-con-full e-flex e-con e-child" data-id="pricing-card-basic" data-element_type="container" style="background: #DC2626; border-radius: 16px; padding: 32px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; flex-direction: column; position: relative;">
						<div style="margin-bottom: 16px; margin-top: 8px;">
							<h3 style="font-size: 28px; font-weight: 700; color: #ffffff; margin: 0 0 8px 0;">Master</h3>
							<p style="font-size: 14px; color: rgba(255,255,255,0.8); margin: 0;">Ouverture le 04 Janvier 2025</p>
						</div>
						<div style="margin-bottom: 24px;">
							<div class="pricing-price-master" data-monthly-amount="25.000fcfa" data-monthly-label="l'inscription" data-annual-amount="160.000fcfa" data-annual-label="l'année" style="font-size: 32px; font-weight: 700; color: #ffffff; margin-bottom: 4px;">25.000fcfa <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">l'inscription</span></div>
							<p class="pricing-subtitle-master" data-monthly="puis 20.000 fcfa par mois." data-annual="soit une réduction de 11%." style="font-size: 14px; color: rgba(255,255,255,0.8); margin: 4px 0 0 0;">puis 20.000 fcfa par mois.</p>
						</div>
						<button type="button" onclick="showRegisterForm()" class="pricing-get-started-btn" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #FFD700 0%, #FFA500 100%); border: none; border-radius: 8px; color: #1a1a1a; font-weight: 600; font-size: 16px; cursor: pointer; margin-top: auto; transition: all 0.3s;">M'inscrire</button>
						<div style="margin-top: 32px; display: flex; flex-direction: column; gap: 16px;">
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">50+ classes de maître</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Chat avec des personnes partageant les mêmes idées</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Offres spéciales</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Accès à la bibliothèque du confiseur</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Conférences sur la théorie de la confiserie</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Sessions intensives de formation thématiques chaque mois</span>
							</div>
							<div style="display: flex; align-items: center; gap: 12px;">
								<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 20px; height: 20px; flex-shrink: 0;">
									<circle cx="10" cy="10" r="9" stroke="#ffffff" stroke-width="2" fill="none"/>
									<path d="M6 10 L9 13 L14 7" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
								</svg>
								<span style="font-size: 14px; color: #ffffff;">Accompagnement par un mentor – réunions en ligne avec l'administrateur deux fois par mois</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<style>
			.pricing-toggle-btn {
				pointer-events: auto !important;
				user-select: none !important;
				-webkit-user-select: none !important;
				-moz-user-select: none !important;
				position: relative !important;
				z-index: 10 !important;
			}
			.pricing-toggle-btn.active {
				background: #ffffff !important;
				color: #1a1a1a !important;
			}
			.pricing-toggle-btn:not(.active) {
				background: transparent !important;
				color: #666 !important;
			}
			.pricing-toggle-btn:hover {
				opacity: 0.8 !important;
			}
			.pricing-toggle-btn:active {
				transform: scale(0.98) !important;
			}
			.pricing-get-started-btn:hover {
				transform: translateY(-2px);
				box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
			}
			@media (max-width: 1024px) {
				.elementor-element-pricing-cards {
					grid-template-columns: repeat(2, 1fr) !important;
				}
			}
			@media (max-width: 768px) {
				.elementor-element-pricing-cards {
					grid-template-columns: 1fr !important;
				}
			}
			/* Supprimer TOUS les espacements et cadres autour du logo UNIQUEMENT - ne pas affecter les autres éléments */
			.elementor-element-96b0a2b,
			.elementor-element-96b0a2b *,
			.elementor-element-96b0a2b .elementor-widget-container,
			.elementor-element-96b0a2b .elementor-widget-image,
			.elementor-element-96b0a2b .elementor-widget-image *,
			.elementor-element-96b0a2b img,
			.elementor-element-96b0a2b a,
			.elementor-element-96b0a2b a span,
			div[data-id="96b0a2b"],
			div[data-id="96b0a2b"] * {
				padding: 0 !important;
				margin: 0 !important;
				line-height: 0 !important;
				border: none !important;
				border-width: 0 !important;
				outline: none !important;
				background: transparent !important;
				background-color: transparent !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
			}
			.elementor-element-96b0a2b img {
				object-fit: contain !important;
				background: transparent !important;
				background-color: transparent !important;
			}
			.elementor-element-96b0a2b .elementor-widget-container {
				background: transparent !important;
				background-color: transparent !important;
			}
			/* Supprimer les backgrounds des conteneurs parents */
			.elementor-element-7a1804e,
			.elementor-element-7a1804e .e-con-inner {
				background: transparent !important;
				background-color: transparent !important;
			}
			/* Espacements pour le header - éviter que les éléments collent - SÉLECTEURS TRÈS SPÉCIFIQUES */
			div[data-id="7a1804e"].elementor-element-7a1804e {
				padding: 0 !important;
				margin-right: 40px !important;
			}
			div[data-id="7a1804e"] .e-con-inner {
				padding: 0 !important;
				margin: 0 !important;
			}
			/* Structure du header : logo et contact sur la même ligne, boutons en dessous */
			.elementor-28 {
				display: flex !important;
				flex-direction: column !important;
			}
			/* Première ligne : logo et contact côte à côte sur la même ligne */
			.elementor-28 > div:first-child {
				display: flex !important;
				flex-direction: row !important;
				align-items: center !important;
				width: 100% !important;
				flex-wrap: nowrap !important;
			}
			/* Logo - aligné au centre verticalement */
			div[data-id="7a1804e"] {
				display: flex !important;
				align-items: center !important;
				flex-shrink: 0 !important;
				align-self: center !important;
			}
			/* Conteneur des infos de contact - aligné horizontalement sur la même ligne que le logo */
			div[data-id="2357019"] {
				display: flex !important;
				flex-direction: row !important;
				align-items: center !important;
				gap: 30px !important;
				margin-left: 40px !important;
				flex: 1 !important;
				align-self: center !important;
			}
			/* Chaque info de contact (Adresse, Email, Téléphone) - en ligne horizontale */
			div[data-id="4b60b9f"],
			div[data-id="67bd570"],
			div[data-id="45ad090"] {
				display: flex !important;
				flex-direction: row !important;
				align-items: center !important;
				flex-shrink: 0 !important;
				white-space: nowrap !important;
			}
			/* S'assurer que les icônes et textes sont alignés horizontalement */
			div[data-id="4b60b9f"] .elementor-widget-icon,
			div[data-id="67bd570"] .elementor-widget-icon,
			div[data-id="45ad090"] .elementor-widget-icon {
				display: flex !important;
				align-items: center !important;
				margin-right: 8px !important;
			}
			div[data-id="4b60b9f"] .hfe-infocard,
			div[data-id="67bd570"] .hfe-infocard,
			div[data-id="45ad090"] .hfe-infocard {
				display: flex !important;
				flex-direction: column !important;
				align-items: flex-start !important;
			}
			/* Deuxième ligne : boutons de navigation en dessous, centrés */
			.elementor-28 > div[data-id="31e697c"] {
				width: 100% !important;
				margin-top: 15px !important;
				display: flex !important;
				justify-content: center !important;
			}
			.elementor-28 > div[data-id="31e697c"] > .e-con-inner {
				display: flex !important;
				justify-content: center !important;
			}
			/* Suppression complète de tous les cadres autour du logo */
			div[data-id="7a1804e"].elementor-element-7a1804e,
			div[data-id="7a1804e"].e-con-boxed,
			div[data-id="7a1804e"].e-con,
			div[data-id="7a1804e"] {
				align-self: center !important;
				background: transparent !important;
				background-color: transparent !important;
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 40px 0 0 !important;
				display: inline-block !important;
				visibility: visible !important;
				opacity: 1 !important;
				width: auto !important;
				height: auto !important;
				max-width: 220px !important;
				max-height: 220px !important;
			}
			div[data-id="7a1804e"] * {
				display: block !important;
				visibility: visible !important;
			}
			div[data-id="7a1804e"] img {
				display: block !important;
				visibility: visible !important;
				opacity: 1 !important;
				width: 220px !important;
				height: 220px !important;
			}
			div[data-id="7a1804e"] a {
				display: inline-block !important;
				visibility: visible !important;
				width: auto !important;
				height: auto !important;
				max-width: 220px !important;
				max-height: 220px !important;
			}
			div[data-id="7a1804e"] {
				margin: 0 40px 0 0 !important;
			}
			div[data-id="7a1804e"] > .e-con-inner,
			div[data-id="7a1804e"] .e-con-inner {
				background: transparent !important;
				background-color: transparent !important;
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 !important;
				display: inline-block !important;
				visibility: visible !important;
				opacity: 1 !important;
				width: auto !important;
				height: auto !important;
				max-width: 220px !important;
				max-height: 220px !important;
			}
			div[data-id="7a1804e"] .e-con-inner * {
				display: block !important;
				visibility: visible !important;
			}
			div[data-id="96b0a2b"].elementor-element-96b0a2b,
			div[data-id="96b0a2b"].elementor-widget {
				background: transparent !important;
				background-color: transparent !important;
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				box-shadow: none !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 !important;
			}
			div[data-id="96b0a2b"] .elementor-widget-container,
			div[data-id="96b0a2b"] > .elementor-widget-container {
				background: transparent !important;
				background-color: transparent !important;
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				box-shadow: none !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 !important;
			}
			div[data-id="96b0a2b"] a,
			div[data-id="96b0a2b"] a:hover,
			div[data-id="96b0a2b"] a:focus,
			div[data-id="96b0a2b"] a:active {
				background: transparent !important;
				background-color: transparent !important;
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				box-shadow: none !important;
				outline: none !important;
				padding: 0 !important;
				margin: 0 !important;
			}
			div[data-id="96b0a2b"] img {
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				outline: none !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
			}
			/* Styles pour la nouvelle image chapeau.jpg - AUCUN CADRE */
			div[data-id="7a1804e"] img,
			div[data-id="7a1804e"] a img,
			div[data-id="7a1804e"] .e-con-inner img,
			div[data-id="7a1804e"] .e-con-inner a img,
			.jkit-nav-logo img,
			.jkit-nav-site-title img {
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				outline: none !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
				padding: 0 !important;
				margin: 0 !important;
				background: transparent !important;
				background-color: transparent !important;
				display: block !important;
				visibility: visible !important;
				opacity: 1 !important;
			}
			div[data-id="7a1804e"] a,
			div[data-id="7a1804e"] .e-con-inner a,
			.jkit-nav-logo,
			.jkit-nav-site-title a {
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				outline: none !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
				padding: 0 !important;
				margin: 0 !important;
				background: transparent !important;
				background-color: transparent !important;
				text-decoration: none !important;
			}
			/* Suppression des pseudo-éléments qui pourraient créer un cadre */
			div[data-id="7a1804e"]::before,
			div[data-id="7a1804e"]::after,
			div[data-id="96b0a2b"]::before,
			div[data-id="96b0a2b"]::after,
			div[data-id="7a1804e"] .e-con-inner::before,
			div[data-id="7a1804e"] .e-con-inner::after,
			div[data-id="96b0a2b"] .elementor-widget-container::before,
			div[data-id="96b0a2b"] .elementor-widget-container::after {
				display: none !important;
				content: none !important;
			}
			/* Suppression complète du cadre pour e-con-boxed sur le logo uniquement */
			div[data-id="7a1804e"].e-con-boxed {
				border: none !important;
				border-width: 0 !important;
				border-style: none !important;
				border-radius: 0 !important;
				box-shadow: none !important;
				-webkit-box-shadow: none !important;
				-moz-box-shadow: none !important;
				outline: none !important;
				background: transparent !important;
				background-color: transparent !important;
			}
			div[data-id="2357019"].elementor-element-2357019 {
				margin-left: 40px !important;
				padding: 0 !important;
				align-self: center !important;
				display: flex !important;
				flex-direction: row !important;
				align-items: center !important;
				gap: 30px !important;
				flex: 1 !important;
			}
			div[data-id="4b60b9f"].elementor-element-4b60b9f {
				align-items: flex-start !important;
			}
			/* Espacement vertical pour le header */
			#masthead {
				padding: 20px 0 !important;
			}
			.elementor-28 {
				padding: 0 30px !important;
			}
			/* Texte sur une seule ligne pour Adresse et Téléphone - UNIQUEMENT */
			div[data-id="973e0b5"] .hfe-infocard-text,
			div[data-id="37ebf69"] .hfe-infocard-text {
				white-space: nowrap !important;
				overflow: visible !important;
				text-overflow: clip !important;
			}
			/* Assurer que les conteneurs de texte ne coupent pas */
			div[data-id="973e0b5"] .hfe-infocard-text-wrap,
			div[data-id="37ebf69"] .hfe-infocard-text-wrap,
			div[data-id="973e0b5"] .elementor-widget-container,
			div[data-id="37ebf69"] .elementor-widget-container,
			div[data-id="973e0b5"] .hfe-infocard,
			div[data-id="37ebf69"] .hfe-infocard {
				overflow: visible !important;
				width: auto !important;
				min-width: fit-content !important;
				max-width: none !important;
			}
			/* Assurer que les conteneurs parents ne limitent pas la largeur */
			div[data-id="4b60b9f"] .elementor-element,
			div[data-id="67bd570"],
			div[data-id="45ad090"],
			div[data-id="4b60b9f"] {
				overflow: visible !important;
				width: auto !important;
				min-width: fit-content !important;
				max-width: none !important;
			}
			/* Rendre les icônes visibles - Adresse, Email, Téléphone */
			div[data-id="754a903"] .elementor-icon svg,
			div[data-id="754a903"] .elementor-icon svg path,
			div[data-id="c8a4ce7"] .elementor-icon svg,
			div[data-id="c8a4ce7"] .elementor-icon svg path,
			div[data-id="3bc7f8e"] .elementor-icon svg,
			div[data-id="3bc7f8e"] .elementor-icon svg path,
			div[data-id="754a903"] svg,
			div[data-id="754a903"] svg path,
			div[data-id="c8a4ce7"] svg,
			div[data-id="c8a4ce7"] svg path,
			div[data-id="3bc7f8e"] svg,
			div[data-id="3bc7f8e"] svg path {
				fill: #2563eb !important;
				color: #2563eb !important;
				stroke: #2563eb !important;
			}
			div[data-id="754a903"] .elementor-icon,
			div[data-id="c8a4ce7"] .elementor-icon,
			div[data-id="3bc7f8e"] .elementor-icon,
			div[data-id="754a903"] .elementor-icon-wrapper,
			div[data-id="c8a4ce7"] .elementor-icon-wrapper,
			div[data-id="3bc7f8e"] .elementor-icon-wrapper {
				color: #2563eb !important;
			}
			/* Forcer l'affichage complet du texte */
			div[data-id="973e0b5"] .hfe-infocard-text,
			div[data-id="37ebf69"] .hfe-infocard-text {
				display: inline-block !important;
				width: auto !important;
				max-width: none !important;
			}
			/* Forcer les espacements même si Elementor a des styles par défaut */
			.elementor-28 > .e-con-inner {
				padding: 0 20px !important;
			}
		</style>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				console.log('🔍 [DEBUG HEADER] Début de l\'analyse des espacements...');
				
				// Analyser le header
				const masthead = document.getElementById('masthead');
				if (masthead) {
					const mastheadStyles = window.getComputedStyle(masthead);
					console.log('📦 [DEBUG] #masthead:', {
						paddingTop: mastheadStyles.paddingTop,
						paddingBottom: mastheadStyles.paddingBottom,
						paddingLeft: mastheadStyles.paddingLeft,
						paddingRight: mastheadStyles.paddingRight,
						marginTop: mastheadStyles.marginTop,
						marginBottom: mastheadStyles.marginBottom,
						inlineStyle: masthead.getAttribute('style')
					});
				}
				
				// Analyser le conteneur principal (déjà analysé plus haut, commenté pour éviter la duplication)
				// const elementor28 = document.querySelector('.elementor-28');
				// if (elementor28) {
				// 	const styles28 = window.getComputedStyle(elementor28);
				// 	console.log('📦 [DEBUG] .elementor-28:', {
				// 		paddingTop: styles28.paddingTop,
				// 		paddingBottom: styles28.paddingBottom,
				// 		paddingLeft: styles28.paddingLeft,
				// 		paddingRight: styles28.paddingRight,
				// 		inlineStyle: elementor28.getAttribute('style')
				// 	});
				// }
				
				// Analyser le conteneur du logo - DÉBOGAGE CADRE
				const logoContainer = document.querySelector('[data-id="7a1804e"]');
				if (logoContainer) {
					const logoStyles = window.getComputedStyle(logoContainer);
					console.log('🔍 [DEBUG CADRE] Logo container [data-id="7a1804e"]:', {
						paddingTop: logoStyles.paddingTop,
						paddingBottom: logoStyles.paddingBottom,
						paddingLeft: logoStyles.paddingLeft,
						paddingRight: logoStyles.paddingRight,
						marginTop: logoStyles.marginTop,
						marginBottom: logoStyles.marginBottom,
						marginLeft: logoStyles.marginLeft,
						marginRight: logoStyles.marginRight,
						border: logoStyles.border,
						borderWidth: logoStyles.borderWidth,
						borderStyle: logoStyles.borderStyle,
						borderRadius: logoStyles.borderRadius,
						boxShadow: logoStyles.boxShadow,
						outline: logoStyles.outline,
						backgroundColor: logoStyles.backgroundColor,
						background: logoStyles.background,
						width: logoStyles.width,
						height: logoStyles.height,
						inlineStyle: logoContainer.getAttribute('style'),
						classes: logoContainer.className
					});
					
					const logoInner = logoContainer.querySelector('.e-con-inner');
					if (logoInner) {
						const innerStyles = window.getComputedStyle(logoInner);
						console.log('🔍 [DEBUG CADRE] Logo inner .e-con-inner:', {
							paddingTop: innerStyles.paddingTop,
							paddingBottom: innerStyles.paddingBottom,
							paddingLeft: innerStyles.paddingLeft,
							paddingRight: innerStyles.paddingRight,
							marginTop: innerStyles.marginTop,
							marginBottom: innerStyles.marginBottom,
							border: innerStyles.border,
							borderWidth: innerStyles.borderWidth,
							borderStyle: innerStyles.borderStyle,
							borderRadius: innerStyles.borderRadius,
							boxShadow: innerStyles.boxShadow,
							outline: innerStyles.outline,
							backgroundColor: innerStyles.backgroundColor,
							background: innerStyles.background,
							inlineStyle: logoInner.getAttribute('style')
						});
					} else {
						console.log('⚠️ [DEBUG CADRE] .e-con-inner non trouvé dans le logo container');
					}
					
					// Vérifier s'il y a une image
					const logoImage = logoContainer.querySelector('img');
					if (logoImage) {
						const imgStyles = window.getComputedStyle(logoImage);
						console.log('🔍 [DEBUG CADRE] Image du logo:', {
							display: imgStyles.display,
							width: imgStyles.width,
							height: imgStyles.height,
							border: imgStyles.border,
							borderWidth: imgStyles.borderWidth,
							borderStyle: imgStyles.borderStyle,
							borderRadius: imgStyles.borderRadius,
							boxShadow: imgStyles.boxShadow,
							outline: imgStyles.outline,
							padding: imgStyles.padding,
							margin: imgStyles.margin,
							inlineStyle: logoImage.getAttribute('style'),
							src: logoImage.src
						});
					} else {
						console.log('✅ [DEBUG CADRE] Image du logo supprimée - pas d\'image trouvée');
					}
					
					// Vérifier tous les enfants
					const allChildren = logoContainer.querySelectorAll('*');
					console.log('🔍 [DEBUG CADRE] Nombre d\'éléments enfants dans le logo container:', allChildren.length);
					allChildren.forEach((child, index) => {
						if (index < 5) { // Limiter à 5 premiers pour éviter trop de logs
							const childStyles = window.getComputedStyle(child);
							console.log(`🔍 [DEBUG CADRE] Enfant ${index} (${child.tagName}):`, {
								className: child.className,
								border: childStyles.border,
								borderWidth: childStyles.borderWidth,
								padding: childStyles.padding,
								backgroundColor: childStyles.backgroundColor,
								display: childStyles.display
							});
						}
					});
				} else {
					console.log('❌ [DEBUG CADRE] Logo container [data-id="7a1804e"] non trouvé');
				}
				
				// Analyser le conteneur des infos de contact (déjà analysé plus haut, commenté pour éviter la duplication)
				// const contactContainer = document.querySelector('[data-id="2357019"]');
				// if (contactContainer) {
				// 	const contactStyles = window.getComputedStyle(contactContainer);
				// 	console.log('📦 [DEBUG] Contact container [data-id="2357019"]:', {
				// 		marginLeft: contactStyles.marginLeft,
				// 		marginRight: contactStyles.marginRight,
				// 		paddingTop: contactStyles.paddingTop,
				// 		paddingBottom: contactStyles.paddingBottom,
				// 		inlineStyle: contactContainer.getAttribute('style')
				// 	});
				// }
				
				// Analyser tous les éléments avec padding: 0 !important
				const allElements = document.querySelectorAll('[style*="padding: 0 !important"], [style*="padding:0 !important"]');
				console.log('⚠️ [DEBUG] Éléments avec padding: 0 !important:', allElements.length);
				
				// FORCER LA SUPPRESSION DU CADRE DU LOGO
				console.log('🔧 [DEBUG CADRE] Application forcée de la suppression du cadre...');
				const logoContainerForce = document.querySelector('[data-id="7a1804e"]');
				if (logoContainerForce) {
					logoContainerForce.style.setProperty('border', 'none', 'important');
					logoContainerForce.style.setProperty('border-width', '0', 'important');
					logoContainerForce.style.setProperty('border-style', 'none', 'important');
					logoContainerForce.style.setProperty('border-radius', '0', 'important');
					logoContainerForce.style.setProperty('box-shadow', 'none', 'important');
					logoContainerForce.style.setProperty('-webkit-box-shadow', 'none', 'important');
					logoContainerForce.style.setProperty('-moz-box-shadow', 'none', 'important');
					logoContainerForce.style.setProperty('outline', 'none', 'important');
					logoContainerForce.style.setProperty('background', 'transparent', 'important');
					logoContainerForce.style.setProperty('background-color', 'transparent', 'important');
					logoContainerForce.style.setProperty('padding', '0', 'important');
					console.log('✅ [DEBUG CADRE] Styles forcés appliqués au logo container');
					
					const logoInnerForce = logoContainerForce.querySelector('.e-con-inner');
					if (logoInnerForce) {
						logoInnerForce.style.setProperty('border', 'none', 'important');
						logoInnerForce.style.setProperty('border-width', '0', 'important');
						logoInnerForce.style.setProperty('border-style', 'none', 'important');
						logoInnerForce.style.setProperty('border-radius', '0', 'important');
						logoInnerForce.style.setProperty('box-shadow', 'none', 'important');
						logoInnerForce.style.setProperty('-webkit-box-shadow', 'none', 'important');
						logoInnerForce.style.setProperty('-moz-box-shadow', 'none', 'important');
						logoInnerForce.style.setProperty('outline', 'none', 'important');
						logoInnerForce.style.setProperty('background', 'transparent', 'important');
						logoInnerForce.style.setProperty('background-color', 'transparent', 'important');
						logoInnerForce.style.setProperty('padding', '0', 'important');
						logoInnerForce.style.setProperty('display', 'block', 'important');
						logoInnerForce.style.setProperty('visibility', 'visible', 'important');
						logoInnerForce.style.setProperty('opacity', '1', 'important');
						console.log('✅ [DEBUG CADRE] Styles forcés appliqués au logo inner');
					}
					
					// Forcer la visibilité du conteneur principal
					logoContainerForce.style.setProperty('display', 'block', 'important');
					logoContainerForce.style.setProperty('visibility', 'visible', 'important');
					logoContainerForce.style.setProperty('opacity', '1', 'important');
					
					// Forcer la suppression de tous les cadres sur les images du logo ET garantir leur visibilité
					const logoImages = logoContainerForce.querySelectorAll('img');
					logoImages.forEach((img, index) => {
						console.log(`🔧 [DEBUG CADRE] Application des styles sans cadre sur l'image ${index + 1} du logo`);
						img.style.setProperty('border', 'none', 'important');
						img.style.setProperty('border-width', '0', 'important');
						img.style.setProperty('border-style', 'none', 'important');
						img.style.setProperty('border-radius', '0', 'important');
						img.style.setProperty('box-shadow', 'none', 'important');
						img.style.setProperty('-webkit-box-shadow', 'none', 'important');
						img.style.setProperty('-moz-box-shadow', 'none', 'important');
						img.style.setProperty('outline', 'none', 'important');
						img.style.setProperty('padding', '0', 'important');
						img.style.setProperty('margin', '0', 'important');
						img.style.setProperty('display', 'block', 'important');
						img.style.setProperty('visibility', 'visible', 'important');
						img.style.setProperty('opacity', '1', 'important');
						console.log(`✅ [DEBUG CADRE] Image ${index + 1} visible - src: ${img.src}`);
					});
					
					// Vérifier si l'image existe
					if (logoImages.length === 0) {
						console.log('⚠️ [DEBUG CADRE] Aucune image trouvée dans le logo container');
					} else {
						console.log(`✅ [DEBUG CADRE] ${logoImages.length} image(s) trouvée(s) dans le logo container`);
					}
					
					// Forcer la suppression de tous les cadres sur les liens
					const logoLinks = logoContainerForce.querySelectorAll('a');
					logoLinks.forEach((link, index) => {
						console.log(`🔧 [DEBUG CADRE] Application des styles sans cadre sur le lien ${index + 1}`);
						link.style.setProperty('border', 'none', 'important');
						link.style.setProperty('border-width', '0', 'important');
						link.style.setProperty('border-style', 'none', 'important');
						link.style.setProperty('border-radius', '0', 'important');
						link.style.setProperty('box-shadow', 'none', 'important');
						link.style.setProperty('-webkit-box-shadow', 'none', 'important');
						link.style.setProperty('-moz-box-shadow', 'none', 'important');
						link.style.setProperty('outline', 'none', 'important');
						link.style.setProperty('padding', '0', 'important');
						link.style.setProperty('margin', '0', 'important');
						link.style.setProperty('background', 'transparent', 'important');
						link.style.setProperty('background-color', 'transparent', 'important');
						link.style.setProperty('text-decoration', 'none', 'important');
					});
				}
				
				// Forcer la suppression de tous les cadres sur les images du menu mobile
				const mobileMenuImages = document.querySelectorAll('.jkit-nav-logo img, .jkit-nav-site-title img');
				mobileMenuImages.forEach((img, index) => {
					console.log(`🔧 [DEBUG CADRE] Application des styles sans cadre sur l'image ${index + 1} du menu mobile`);
					img.style.setProperty('border', 'none', 'important');
					img.style.setProperty('border-width', '0', 'important');
					img.style.setProperty('border-style', 'none', 'important');
					img.style.setProperty('border-radius', '0', 'important');
					img.style.setProperty('box-shadow', 'none', 'important');
					img.style.setProperty('-webkit-box-shadow', 'none', 'important');
					img.style.setProperty('-moz-box-shadow', 'none', 'important');
					img.style.setProperty('outline', 'none', 'important');
					img.style.setProperty('padding', '0', 'important');
					img.style.setProperty('margin', '0', 'important');
				});
				
				// Forcer la suppression de tous les cadres sur les liens du menu mobile
				const mobileMenuLinks = document.querySelectorAll('.jkit-nav-logo, .jkit-nav-site-title a');
				mobileMenuLinks.forEach((link, index) => {
					console.log(`🔧 [DEBUG CADRE] Application des styles sans cadre sur le lien ${index + 1} du menu mobile`);
					link.style.setProperty('border', 'none', 'important');
					link.style.setProperty('border-width', '0', 'important');
					link.style.setProperty('border-style', 'none', 'important');
					link.style.setProperty('border-radius', '0', 'important');
					link.style.setProperty('box-shadow', 'none', 'important');
					link.style.setProperty('-webkit-box-shadow', 'none', 'important');
					link.style.setProperty('-moz-box-shadow', 'none', 'important');
					link.style.setProperty('outline', 'none', 'important');
					link.style.setProperty('padding', '0', 'important');
					link.style.setProperty('margin', '0', 'important');
					link.style.setProperty('background', 'transparent', 'important');
					link.style.setProperty('background-color', 'transparent', 'important');
				});
				
				// FORCER LA VISIBILITÉ DES ICÔNES
				console.log('🔧 [DEBUG ICÔNES] Application forcée de la couleur des icônes...');
				const iconIds = ['754a903', 'c8a4ce7', '3bc7f8e'];
				iconIds.forEach(iconId => {
					const iconContainer = document.querySelector(`[data-id="${iconId}"]`);
					if (iconContainer) {
						const svgs = iconContainer.querySelectorAll('svg, svg path');
						svgs.forEach(svg => {
							svg.style.setProperty('fill', '#2563eb', 'important');
							svg.style.setProperty('color', '#2563eb', 'important');
						});
						const iconWrapper = iconContainer.querySelector('.elementor-icon');
						if (iconWrapper) {
							iconWrapper.style.setProperty('color', '#2563eb', 'important');
						}
						console.log(`✅ [DEBUG ICÔNES] Icône ${iconId} mise à jour`);
					} else {
						console.log(`⚠️ [DEBUG ICÔNES] Icône ${iconId} non trouvée`);
					}
				});
				allElements.forEach((el, index) => {
					if (index < 5) { // Limiter à 5 pour ne pas surcharger
						console.log(`  - Élément ${index + 1}:`, {
							tag: el.tagName,
							class: el.className,
							style: el.getAttribute('style')
						});
					}
				});
				
				// Vérifier les styles CSS appliqués
				const styleSheets = Array.from(document.styleSheets);
				let foundStyles = false;
				styleSheets.forEach((sheet, sheetIndex) => {
					try {
						const rules = Array.from(sheet.cssRules || []);
						rules.forEach((rule, ruleIndex) => {
							if (rule.selectorText && (
								rule.selectorText.includes('7a1804e') ||
								rule.selectorText.includes('2357019') ||
								rule.selectorText.includes('masthead')
							)) {
								console.log('📋 [DEBUG] Règle CSS trouvée:', {
									selector: rule.selectorText,
									style: rule.style.cssText
								});
								foundStyles = true;
							}
						});
					} catch (e) {
						// Ignorer les erreurs CORS
					}
				});
				
				if (!foundStyles) {
					console.log('⚠️ [DEBUG] Aucune règle CSS personnalisée trouvée dans les stylesheets');
				}
				
				console.log('✅ [DEBUG HEADER] Fin de l\'analyse');
				
				// Analyser spécifiquement la section Adresse, E-mail, Téléphone
				console.log('🔍 [DEBUG CONTACT] Analyse de la section contact...');
				const contactContainerDebug = document.querySelector('[data-id="2357019"]');
				if (contactContainerDebug) {
					const contactStyles = window.getComputedStyle(contactContainerDebug);
					console.log('📦 [DEBUG CONTACT] Conteneur [data-id="2357019"]:', {
						display: contactStyles.display,
						alignSelf: contactStyles.alignSelf,
						alignItems: contactStyles.alignItems,
						paddingTop: contactStyles.paddingTop,
						paddingBottom: contactStyles.paddingBottom,
						marginTop: contactStyles.marginTop,
						marginBottom: contactStyles.marginBottom,
						position: contactStyles.position,
						top: contactStyles.top,
						inlineStyle: contactContainerDebug.getAttribute('style')
					});
				}
				
				const contactInner = document.querySelector('[data-id="4b60b9f"]');
				if (contactInner) {
					const innerStyles = window.getComputedStyle(contactInner);
					console.log('📦 [DEBUG CONTACT] Conteneur interne [data-id="4b60b9f"]:', {
						display: innerStyles.display,
						alignItems: innerStyles.alignItems,
						alignSelf: innerStyles.alignSelf,
						paddingTop: innerStyles.paddingTop,
						marginTop: innerStyles.marginTop,
						inlineStyle: contactInner.getAttribute('style')
					});
				}
				
				// Analyser le conteneur parent
				const elementor28Debug = document.querySelector('.elementor-28');
				if (elementor28Debug) {
					const styles28 = window.getComputedStyle(elementor28Debug);
					console.log('📦 [DEBUG CONTACT] Conteneur parent .elementor-28:', {
						display: styles28.display,
						alignItems: styles28.alignItems,
						alignContent: styles28.alignContent,
						justifyContent: styles28.justifyContent,
						flexDirection: styles28.flexDirection,
						inlineStyle: elementor28Debug.getAttribute('style')
					});
				}
				
				// Analyser les éléments individuels (Adresse, E-mail, Téléphone)
				const adresseElement = document.querySelector('[data-id="973e0b5"]');
				const emailElement = document.querySelector('[data-id="0e72b14"]');
				const telephoneElement = document.querySelector('[data-id="37ebf69"]');
				
				[adresseElement, emailElement, telephoneElement].forEach((el, index) => {
					if (el) {
						const elStyles = window.getComputedStyle(el);
						const labels = ['Adresse', 'E-mail', 'Téléphone'];
						console.log(`📦 [DEBUG CONTACT] ${labels[index]} [data-id]:`, {
							marginTop: elStyles.marginTop,
							paddingTop: elStyles.paddingTop,
							position: elStyles.position,
							top: elStyles.top,
							alignSelf: elStyles.alignSelf,
							inlineStyle: el.getAttribute('style')
						});
					}
				});
				
				console.log('✅ [DEBUG CONTACT] Fin de l\'analyse contact');
			});
		</style>
			/* Préserver les styles des menus de navigation - RESTAURER COMPLÈTEMENT */
			.jkit-menu,
			.jkit-menu-wrapper,
			.jkit-menu-container,
			.jkit-menu li,
			.jkit-menu a,
			.elementor-element-b7a3a52,
			.elementor-element-b7a3a52 *,
			div[data-id="31e697c"],
			div[data-id="31e697c"] * {
				all: revert !important;
			}
			.elementor-element-b7a3a52 {
				all: revert !important;
			}
			.jkit-nav-menu {
				all: revert !important;
			}
			/* Supprimer tous les styles de cadre possibles */
			.elementor-element-96b0a2b::before,
			.elementor-element-96b0a2b::after,
			.elementor-element-96b0a2b .elementor-widget-container::before,
			.elementor-element-96b0a2b .elementor-widget-container::after,
			div[data-id="96b0a2b"]::before,
			div[data-id="96b0a2b"]::after {
				display: none !important;
				content: none !important;
			}
			/* Forcer la suppression de tous les styles Elementor par défaut */
			.elementor-widget-image[data-id="96b0a2b"],
			.elementor-widget-image[data-id="96b0a2b"] .elementor-widget-container {
				background: none !important;
				background-color: rgba(0,0,0,0) !important;
				border: 0 !important;
				padding: 0 !important;
				margin: 0 !important;
			}
			.elementor-element-96b0a2b a {
				gap: 10px !important;
				line-height: 1 !important;
			}
			.elementor-element-96b0a2b a span {
				line-height: 1 !important;
			}
			.jkit-nav-site-title,
			.jkit-nav-site-title *,
			.jkit-nav-site-title a,
			.jkit-nav-site-title a img,
			.jkit-nav-site-title a span {
				padding: 0 !important;
				margin: 0 !important;
				border: none !important;
				outline: none !important;
				background: transparent !important;
				background-color: transparent !important;
				box-shadow: none !important;
			}
			.jkit-nav-site-title a img {
				object-fit: contain !important;
				background: transparent !important;
				background-color: transparent !important;
			}
			.jkit-nav-site-title a {
				gap: 10px !important;
			}
		</style>
		<script>
			// Fonction globale simple pour gérer le toggle - SÉCURISÉE
			function handlePricingToggle(period, buttonElement) {
				console.log('🟢 [PRICING TOGGLE] handlePricingToggle appelé avec période:', period);
				
				try {
						// Mettre à jour les boutons
					const allButtons = document.querySelectorAll('.pricing-toggle-btn');
					allButtons.forEach(btn => {
						btn.classList.remove('active');
						btn.style.background = 'transparent';
						btn.style.color = '#666';
					});
					
					if (buttonElement) {
						buttonElement.classList.add('active');
						buttonElement.style.background = '#ffffff';
						buttonElement.style.color = '#1a1a1a';
					}
					
					// Mettre à jour les prix Licence
					const priceLicence = document.querySelector('.pricing-price-licence');
					const subtitleLicence = document.querySelector('.pricing-subtitle-licence');
					
						if (priceLicence && subtitleLicence) {
							if (period === 'annual') {
								const amount = priceLicence.getAttribute('data-annual-amount');
								const label = priceLicence.getAttribute('data-annual-label');
							if (amount && label) {
								priceLicence.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								subtitleLicence.textContent = subtitleLicence.getAttribute('data-annual') || '';
								console.log('✅ [PRICING TOGGLE] Prix Licence mis à jour (Annuel)');
							}
							} else {
								const amount = priceLicence.getAttribute('data-monthly-amount');
								const label = priceLicence.getAttribute('data-monthly-label');
							if (amount && label) {
								priceLicence.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								subtitleLicence.textContent = subtitleLicence.getAttribute('data-monthly') || '';
								console.log('✅ [PRICING TOGGLE] Prix Licence mis à jour (Mensuel)');
							}
							}
						}
						
					// Mettre à jour les prix Master
					const priceMaster = document.querySelector('.pricing-price-master');
					const subtitleMaster = document.querySelector('.pricing-subtitle-master');
					
						if (priceMaster && subtitleMaster) {
							if (period === 'annual') {
								const amount = priceMaster.getAttribute('data-annual-amount');
								const label = priceMaster.getAttribute('data-annual-label');
							if (amount && label) {
								priceMaster.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								subtitleMaster.textContent = subtitleMaster.getAttribute('data-annual') || '';
								console.log('✅ [PRICING TOGGLE] Prix Master mis à jour (Annuel)');
							}
							} else {
								const amount = priceMaster.getAttribute('data-monthly-amount');
								const label = priceMaster.getAttribute('data-monthly-label');
							if (amount && label) {
								priceMaster.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								subtitleMaster.textContent = subtitleMaster.getAttribute('data-monthly') || '';
								console.log('✅ [PRICING TOGGLE] Prix Master mis à jour (Mensuel)');
							}
						}
					}
					
					console.log('✅ [PRICING TOGGLE] Toggle terminé avec succès');
				} catch(error) {
					console.error('❌ [PRICING TOGGLE] Erreur dans handlePricingToggle:', error);
				}
				
				return false;
			}
			
			console.log('🔧 [PRICING TOGGLE] Fonction handlePricingToggle définie');
			
			// Script d'initialisation avancé (en plus de onclick)
			console.log('🔧 [PRICING TOGGLE] Script de pricing toggle chargé');
			
			// Fonction pour initialiser le système de toggle
			function initPricingToggle() {
				console.log('🔧 [PRICING TOGGLE] Initialisation du système de toggle...');
				
				const toggleButtons = document.querySelectorAll('.pricing-toggle-btn');
				const priceLicence = document.querySelector('.pricing-price-licence');
				const subtitleLicence = document.querySelector('.pricing-subtitle-licence');
				const priceMaster = document.querySelector('.pricing-price-master');
				const subtitleMaster = document.querySelector('.pricing-subtitle-master');
				
				console.log('🔧 [PRICING TOGGLE] Boutons trouvés:', toggleButtons.length);
				console.log('🔧 [PRICING TOGGLE] Prix Licence trouvé:', !!priceLicence);
				console.log('🔧 [PRICING TOGGLE] Prix Master trouvé:', !!priceMaster);
				
				if (toggleButtons.length === 0) {
					console.warn('⚠️ [PRICING TOGGLE] Aucun bouton trouvé, nouvelle tentative dans 500ms...');
					setTimeout(initPricingToggle, 500);
					return;
				}
				
				function updatePricing(period) {
					console.log('🔧 [PRICING TOGGLE] ========== DÉBUT updatePricing ==========');
					console.log('🔧 [PRICING TOGGLE] Période reçue:', period);
					console.log('🔧 [PRICING TOGGLE] Type de période:', typeof period);
					
					if (!period) {
						console.error('❌ [PRICING TOGGLE] Aucune période fournie à updatePricing!');
						return;
					}
					
					// Re-chercher les éléments à chaque fois pour être sûr de les avoir
					console.log('🔧 [PRICING TOGGLE] Recherche des éléments de prix...');
					const currentPriceLicence = document.querySelector('.pricing-price-licence');
					const currentSubtitleLicence = document.querySelector('.pricing-subtitle-licence');
					const currentPriceMaster = document.querySelector('.pricing-price-master');
					const currentSubtitleMaster = document.querySelector('.pricing-subtitle-master');
					
					console.log('🔧 [PRICING TOGGLE] Résultats de la recherche:', {
						priceLicence: !!currentPriceLicence,
						subtitleLicence: !!currentSubtitleLicence,
						priceMaster: !!currentPriceMaster,
						subtitleMaster: !!currentSubtitleMaster
					});
					
					// Mettre à jour les prix pour Licence
					console.log('🔧 [PRICING TOGGLE] Traitement Licence...');
					if (currentPriceLicence && currentSubtitleLicence) {
						console.log('✅ [PRICING TOGGLE] Éléments Licence trouvés');
						console.log('🔧 [PRICING TOGGLE] Contenu actuel priceLicence:', currentPriceLicence.innerHTML);
						console.log('🔧 [PRICING TOGGLE] Contenu actuel subtitleLicence:', currentSubtitleLicence.textContent);
						
						if (period === 'annual') {
							console.log('🔧 [PRICING TOGGLE] Mode ANNUEL pour Licence');
							const amount = currentPriceLicence.getAttribute('data-annual-amount');
							const label = currentPriceLicence.getAttribute('data-annual-label');
							console.log('🔧 [PRICING TOGGLE] Données annuelles Licence:', {
								amount: amount,
								label: label,
								amountExists: !!amount,
								labelExists: !!label
							});
							
							if (amount && label) {
								const newHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								console.log('🔧 [PRICING TOGGLE] Nouveau HTML pour priceLicence:', newHTML);
								currentPriceLicence.innerHTML = newHTML;
								console.log('✅ [PRICING TOGGLE] innerHTML mis à jour');
								
								const annualSubtitle = currentSubtitleLicence.getAttribute('data-annual');
								console.log('🔧 [PRICING TOGGLE] Sous-titre annuel:', annualSubtitle);
								if (annualSubtitle) {
									currentSubtitleLicence.textContent = annualSubtitle;
									console.log('✅ [PRICING TOGGLE] Sous-titre mis à jour:', annualSubtitle);
								} else {
									console.error('❌ [PRICING TOGGLE] Attribut data-annual manquant sur subtitleLicence');
								}
								
								console.log('✅ [PRICING TOGGLE] Prix Licence mis à jour (Annuel):', amount, label);
								console.log('🔧 [PRICING TOGGLE] Vérification finale priceLicence:', currentPriceLicence.innerHTML);
								console.log('🔧 [PRICING TOGGLE] Vérification finale subtitleLicence:', currentSubtitleLicence.textContent);
							} else {
								console.error('❌ [PRICING TOGGLE] Données annuelles manquantes pour Licence:', {
									amount: amount,
									label: label
								});
								console.error('❌ [PRICING TOGGLE] Tous les attributs data-annual:', {
									'data-annual-amount': currentPriceLicence.getAttribute('data-annual-amount'),
									'data-annual-label': currentPriceLicence.getAttribute('data-annual-label'),
									allAttributes: Array.from(currentPriceLicence.attributes).map(a => `${a.name}="${a.value}"`)
								});
							}
						} else {
							console.log('🔧 [PRICING TOGGLE] Mode MENSUEL pour Licence');
							const amount = currentPriceLicence.getAttribute('data-monthly-amount');
							const label = currentPriceLicence.getAttribute('data-monthly-label');
							console.log('🔧 [PRICING TOGGLE] Données mensuelles Licence:', {
								amount: amount,
								label: label
							});
							if (amount && label) {
								currentPriceLicence.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: #666;">' + label + '</span>';
								const monthlySubtitle = currentSubtitleLicence.getAttribute('data-monthly');
								if (monthlySubtitle) {
									currentSubtitleLicence.textContent = monthlySubtitle;
								}
								console.log('✅ [PRICING TOGGLE] Prix Licence mis à jour (Mensuel):', amount, label);
							}
						}
					} else {
						console.error('❌ [PRICING TOGGLE] Éléments Licence non trouvés:', {
							price: !!currentPriceLicence,
							subtitle: !!currentSubtitleLicence,
							priceElement: currentPriceLicence,
							subtitleElement: currentSubtitleLicence
						});
						console.error('❌ [PRICING TOGGLE] Recherche alternative...');
						const allPrices = document.querySelectorAll('[class*="pricing-price"]');
						console.error('❌ [PRICING TOGGLE] Tous les éléments avec pricing-price:', allPrices.length, allPrices);
					}
					
					// Mettre à jour les prix pour Master
					console.log('🔧 [PRICING TOGGLE] Traitement Master...');
					if (currentPriceMaster && currentSubtitleMaster) {
						console.log('✅ [PRICING TOGGLE] Éléments Master trouvés');
						console.log('🔧 [PRICING TOGGLE] Contenu actuel priceMaster:', currentPriceMaster.innerHTML);
						console.log('🔧 [PRICING TOGGLE] Contenu actuel subtitleMaster:', currentSubtitleMaster.textContent);
						
						if (period === 'annual') {
							console.log('🔧 [PRICING TOGGLE] Mode ANNUEL pour Master');
							const amount = currentPriceMaster.getAttribute('data-annual-amount');
							const label = currentPriceMaster.getAttribute('data-annual-label');
							console.log('🔧 [PRICING TOGGLE] Données annuelles Master:', {
								amount: amount,
								label: label,
								amountExists: !!amount,
								labelExists: !!label
							});
							
							if (amount && label) {
								const newHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								console.log('🔧 [PRICING TOGGLE] Nouveau HTML pour priceMaster:', newHTML);
								currentPriceMaster.innerHTML = newHTML;
								console.log('✅ [PRICING TOGGLE] innerHTML Master mis à jour');
								
								const annualSubtitle = currentSubtitleMaster.getAttribute('data-annual');
								console.log('🔧 [PRICING TOGGLE] Sous-titre annuel Master:', annualSubtitle);
								if (annualSubtitle) {
									currentSubtitleMaster.textContent = annualSubtitle;
									console.log('✅ [PRICING TOGGLE] Sous-titre Master mis à jour:', annualSubtitle);
								} else {
									console.error('❌ [PRICING TOGGLE] Attribut data-annual manquant sur subtitleMaster');
								}
								
								console.log('✅ [PRICING TOGGLE] Prix Master mis à jour (Annuel):', amount, label);
								console.log('🔧 [PRICING TOGGLE] Vérification finale priceMaster:', currentPriceMaster.innerHTML);
								console.log('🔧 [PRICING TOGGLE] Vérification finale subtitleMaster:', currentSubtitleMaster.textContent);
							} else {
								console.error('❌ [PRICING TOGGLE] Données annuelles manquantes pour Master:', {
									amount: amount,
									label: label
								});
								console.error('❌ [PRICING TOGGLE] Tous les attributs data-annual Master:', {
									'data-annual-amount': currentPriceMaster.getAttribute('data-annual-amount'),
									'data-annual-label': currentPriceMaster.getAttribute('data-annual-label'),
									allAttributes: Array.from(currentPriceMaster.attributes).map(a => `${a.name}="${a.value}"`)
								});
							}
						} else {
							console.log('🔧 [PRICING TOGGLE] Mode MENSUEL pour Master');
							const amount = currentPriceMaster.getAttribute('data-monthly-amount');
							const label = currentPriceMaster.getAttribute('data-monthly-label');
							console.log('🔧 [PRICING TOGGLE] Données mensuelles Master:', {
								amount: amount,
								label: label
							});
							if (amount && label) {
								currentPriceMaster.innerHTML = amount + ' <span style="font-size: 14px; font-weight: 400; color: rgba(255,255,255,0.8);">' + label + '</span>';
								const monthlySubtitle = currentSubtitleMaster.getAttribute('data-monthly');
								if (monthlySubtitle) {
									currentSubtitleMaster.textContent = monthlySubtitle;
								}
								console.log('✅ [PRICING TOGGLE] Prix Master mis à jour (Mensuel):', amount, label);
							}
						}
					} else {
						console.error('❌ [PRICING TOGGLE] Éléments Master non trouvés:', {
							price: !!currentPriceMaster,
							subtitle: !!currentSubtitleMaster,
							priceElement: currentPriceMaster,
							subtitleElement: currentSubtitleMaster
						});
					}
					
					console.log('🔧 [PRICING TOGGLE] ========== FIN updatePricing ==========');
				}
				
				// Supprimer tous les anciens listeners pour éviter les doublons
				toggleButtons.forEach(btn => {
					const newBtn = btn.cloneNode(true);
					btn.parentNode.replaceChild(newBtn, btn);
				});
				
				// Réattacher les listeners sur les nouveaux boutons
				const newToggleButtons = document.querySelectorAll('.pricing-toggle-btn');
				
				newToggleButtons.forEach((btn, index) => {
					const btnText = btn.textContent.trim();
					const btnPeriod = btn.getAttribute('data-period');
					console.log(`🔧 [PRICING TOGGLE] Attachement du listener au bouton ${index + 1}:`, {
						text: btnText,
						period: btnPeriod,
						hasActive: btn.classList.contains('active'),
						element: btn
					});
					
					// Fonction de gestion du clic
					const handleClick = function(e) {
						console.log('🟢 [PRICING TOGGLE] ========== DÉBUT handleClick ==========');
						console.log('🟢 [PRICING TOGGLE] Event:', e);
						console.log('🟢 [PRICING TOGGLE] This:', this);
						console.log('🟢 [PRICING TOGGLE] This.textContent:', this.textContent.trim());
						
						try {
							e.preventDefault();
							console.log('✅ [PRICING TOGGLE] preventDefault() appelé');
						} catch(err) {
							console.error('❌ [PRICING TOGGLE] Erreur preventDefault:', err);
						}
						
						try {
							e.stopPropagation();
							console.log('✅ [PRICING TOGGLE] stopPropagation() appelé');
						} catch(err) {
							console.error('❌ [PRICING TOGGLE] Erreur stopPropagation:', err);
						}
						
						try {
							e.stopImmediatePropagation();
							console.log('✅ [PRICING TOGGLE] stopImmediatePropagation() appelé');
						} catch(err) {
							console.error('❌ [PRICING TOGGLE] Erreur stopImmediatePropagation:', err);
						}
						
						const period = this.getAttribute('data-period');
						console.log('🟢 [PRICING TOGGLE] Période récupérée:', period);
						console.log('🟢 [PRICING TOGGLE] Bouton cliqué:', this.textContent.trim());
						
						if (!period) {
							console.error('❌ [PRICING TOGGLE] ATTRIBUT data-period MANQUANT sur le bouton!');
							console.error('❌ [PRICING TOGGLE] Attributs du bouton:', Array.from(this.attributes).map(a => `${a.name}="${a.value}"`));
							return false;
						}
						
						// Mettre à jour les boutons
						console.log('🔧 [PRICING TOGGLE] Mise à jour des styles des boutons...');
						newToggleButtons.forEach((b, idx) => {
							console.log(`🔧 [PRICING TOGGLE] Bouton ${idx}:`, {
								text: b.textContent.trim(),
								period: b.getAttribute('data-period'),
								beforeActive: b.classList.contains('active')
							});
							b.classList.remove('active');
							b.style.background = 'transparent';
							b.style.color = '#666';
							console.log(`✅ [PRICING TOGGLE] Bouton ${idx} désactivé`);
						});
						
						this.classList.add('active');
						this.style.background = '#ffffff';
						this.style.color = '#1a1a1a';
						console.log('✅ [PRICING TOGGLE] Bouton cliqué activé visuellement');
						
						// Mettre à jour les prix
						console.log('🔧 [PRICING TOGGLE] Appel de updatePricing avec période:', period);
						try {
							updatePricing(period);
							console.log('✅ [PRICING TOGGLE] updatePricing() terminé avec succès');
						} catch(err) {
							console.error('❌ [PRICING TOGGLE] ERREUR dans updatePricing:', err);
							console.error('❌ [PRICING TOGGLE] Stack trace:', err.stack);
						}
						
						console.log('🟢 [PRICING TOGGLE] ========== FIN handleClick ==========');
						return false;
					};
					
					// Ajouter plusieurs types d'événements
					console.log(`🔧 [PRICING TOGGLE] Ajout de onclick direct...`);
					btn.onclick = handleClick;
					console.log(`✅ [PRICING TOGGLE] onclick direct ajouté, valeur:`, btn.onclick);
					
					console.log(`🔧 [PRICING TOGGLE] Ajout de addEventListener avec capture=true...`);
					btn.addEventListener('click', handleClick, true);
					console.log(`✅ [PRICING TOGGLE] addEventListener(capture=true) ajouté`);
					
					console.log(`🔧 [PRICING TOGGLE] Ajout de addEventListener avec capture=false...`);
					btn.addEventListener('click', handleClick, false);
					console.log(`✅ [PRICING TOGGLE] addEventListener(capture=false) ajouté`);
					
					// Ajouter aussi touchstart pour mobile
					console.log(`🔧 [PRICING TOGGLE] Ajout de touchstart...`);
					btn.addEventListener('touchstart', function(e) {
						console.log('📱 [PRICING TOGGLE] Touchstart détecté');
						e.preventDefault();
						handleClick.call(this, e);
					}, { passive: false });
					console.log(`✅ [PRICING TOGGLE] touchstart ajouté`);
					
					// Vérifier que les listeners sont bien attachés
					console.log(`🔧 [PRICING TOGGLE] Vérification finale du bouton ${index + 1}:`, {
						onclick: typeof btn.onclick,
						hasListeners: btn.onclick !== null,
						classList: Array.from(btn.classList),
						attributes: Array.from(btn.attributes).map(a => `${a.name}="${a.value}"`)
					});
				});
				
				console.log('✅ [PRICING TOGGLE] Système de toggle initialisé avec succès');
			}
			
			// Essayer plusieurs fois pour s'assurer que les éléments sont chargés
			console.log('🔧 [PRICING TOGGLE] État du document:', document.readyState);
			console.log('🔧 [PRICING TOGGLE] Tentative d\'initialisation...');
			
			if (document.readyState === 'loading') {
				console.log('🔧 [PRICING TOGGLE] Document en cours de chargement, attente DOMContentLoaded...');
				document.addEventListener('DOMContentLoaded', function() {
					console.log('🔧 [PRICING TOGGLE] DOMContentLoaded déclenché');
					setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 1 (100ms)'); initPricingToggle(); }, 100);
					setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 2 (500ms)'); initPricingToggle(); }, 500);
					setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 3 (1000ms)'); initPricingToggle(); }, 1000);
				});
			} else {
				console.log('🔧 [PRICING TOGGLE] Document déjà chargé, initialisation immédiate...');
				setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 1 (100ms)'); initPricingToggle(); }, 100);
				setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 2 (500ms)'); initPricingToggle(); }, 500);
				setTimeout(function() { console.log('🔧 [PRICING TOGGLE] Tentative 3 (1000ms)'); initPricingToggle(); }, 1000);
			}
			
			// Observer les changements dans le DOM au cas où les éléments sont ajoutés dynamiquement
			console.log('🔧 [PRICING TOGGLE] Création du MutationObserver...');
			try {
				const observer = new MutationObserver(function(mutations) {
					const toggleButtons = document.querySelectorAll('.pricing-toggle-btn');
					if (toggleButtons.length > 0) {
						const hasListeners = toggleButtons[0].onclick !== null || toggleButtons[0].getAttribute('data-listener-attached') === 'true';
						if (!hasListeners) {
							console.log('🔧 [PRICING TOGGLE] Nouveaux boutons détectés, réinitialisation...');
							initPricingToggle();
						}
					}
				});
				
				observer.observe(document.body, {
					childList: true,
					subtree: true
				});
				console.log('✅ [PRICING TOGGLE] MutationObserver créé et actif');
			} catch(err) {
				console.error('❌ [PRICING TOGGLE] Erreur lors de la création du MutationObserver:', err);
			}
			
			console.log('✅ [PRICING TOGGLE] Script de pricing toggle complètement chargé');
		</script>
		
		<!-- Section Contact -->
		<div id="contact-section" data-elementor-type="wp-post" data-elementor-id="1749" class="elementor elementor-1749">
			<div class="elementor-element elementor-element-904a6e0 e-flex e-con-boxed e-con e-parent e-lazyloaded" data-id="904a6e0" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Contact.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
				<div class="e-con-inner">
		<div class="elementor-element elementor-element-80ea6be e-con-full e-flex e-con e-child" data-id="80ea6be" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-2a6d667 elementor-view-default elementor-widget elementor-widget-icon" data-id="2a6d667" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-square-full" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M512 512H0V0h512v512z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-aed4320 elementor-widget elementor-widget-jkit_animated_text" data-id="aed4320" data-element_type="widget" data-widget_type="jkit_animated_text.default">
					<div class="jeg-elementor-kit jkit-animated-text jeg_module_1749_1_691fe3d762be6" data-style="rotating" data-text="CONTACTEZ-NOUS" data-rotate="typing" data-delay="2500" data-letter-speed="75" data-delay-delete="10"><div class="animated-text"><span class="normal-text style-color"></span><span class="dynamic-wrapper style-color cursor-blink"><span class="dynamic-text show-text"><span class="dynamic-text-letter show-letter">C</span><span class="dynamic-text-letter show-letter">O</span><span class="dynamic-text-letter show-letter">N</span><span class="dynamic-text-letter show-letter">T</span><span class="dynamic-text-letter show-letter">A</span><span class="dynamic-text-letter show-letter">C</span><span class="dynamic-text-letter show-letter">T</span><span class="dynamic-text-letter show-letter">E</span><span class="dynamic-text-letter show-letter">Z</span><span class="dynamic-text-letter show-letter">-</span><span class="dynamic-text-letter show-letter">N</span><span class="dynamic-text-letter show-letter">O</span><span class="dynamic-text-letter show-letter">U</span><span class="dynamic-text-letter show-letter">S</span></span></span><span class="normal-text style-color"></span></div></div>				</div>
				</div>
				<div class="elementor-element elementor-element-7db353f elementor-widget__width-initial elementor-widget-mobile__width-inherit elementor-widget elementor-widget-heading animated fadeInUp" data-id="7db353f" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="heading.default">
					<h1 class="elementor-heading-title elementor-size-default">Nous Sommes Là Pour Vous Aider à Vous Connecter</h1>				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-1a3b277 e-flex e-con-boxed e-con e-parent" data-id="1a3b277" data-element_type="container">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-ae3da91 e-con-full e-flex e-con e-child" data-id="ae3da91" data-element_type="container">
		<div class="elementor-element elementor-element-decf80d e-con-full e-flex elementor-invisible e-con e-child" data-id="decf80d" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-f7cb370 elementor-widget elementor-widget-heading" data-id="f7cb370" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">Vie de la Communauté et Support Étudiant</div>				</div>
				<div class="elementor-element elementor-element-6b50ae8 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="6b50ae8" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-9765de1 elementor-widget elementor-widget-heading" data-id="9765de1" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Vous Avez une Question Spécifique ?
Envoyez-Nous Votre Demande !</h2>				</div>
				<div class="elementor-element elementor-element-df73da4 elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="df73da4" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Notre équipe de support étudiant est disponible en ligne pour répondre à toutes vos questions sur les programmes, l'inscription, les ressources pédagogiques et l'accompagnement. Contactez-nous via notre formulaire, par email ou par whatsApp.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-a8b05ac e-con-full e-flex e-con e-child" data-id="a8b05ac" data-element_type="container">
		<div class="elementor-element elementor-element-fffae2d e-con-full e-flex e-con e-child" data-id="fffae2d" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-bb3dc8d elementor-absolute e-transform elementor-widget elementor-widget-image" data-id="bb3dc8d" data-element_type="widget" data-settings="{&quot;_position&quot;:&quot;absolute&quot;,&quot;_transform_flipY_effect&quot;:&quot;transform&quot;}" data-widget_type="image.default">
															<img decoding="async" width="681" height="1024" src="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity-681x1024.png" class="attachment-large size-large wp-image-687" alt="" srcset="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity-681x1024.png 681w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity-199x300.png 199w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity-768x1156.png 768w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity-800x1204.png 800w, https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/2025/09/Ornament-white-opacity.png 864w" sizes="(max-width: 681px) 100vw, 681px">															</div>
				<div class="elementor-element elementor-element-157ed1c elementor-widget__width-inherit elementor-invisible elementor-widget elementor-widget-image" data-id="157ed1c" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;}" data-widget_type="image.default">
															<img loading="lazy" decoding="async" src="{{ asset('assets/images/Support.jpg') }}" class="attachment-large size-large wp-image-685" alt="">															</div>
		<div class="elementor-element elementor-element-4cbb9fa e-con-full e-flex e-con e-child" data-id="4cbb9fa" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;,&quot;position&quot;:&quot;absolute&quot;}">
				<div class="elementor-element elementor-element-36c5207 elementor-view-default elementor-widget elementor-widget-icon" data-id="36c5207" data-element_type="widget" data-widget_type="icon.default">
							<div class="elementor-icon-wrapper">
			<div class="elementor-icon">
			<svg aria-hidden="true" class="e-font-icon-svg e-fas-square-full" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M512 512H0V0h512v512z"></path></svg>			</div>
		</div>
						</div>
				<div class="elementor-element elementor-element-482849e elementor-widget elementor-widget-hfe-infocard" data-id="482849e" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Connectez-vous avec</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Bj Académie Aujourd'hui				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-5bb3ede e-con-full e-flex e-con e-child" data-id="5bb3ede" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
				<div class="elementor-element elementor-element-2f02b09 elementor-widget__width-inherit elementor-widget elementor-widget-metform" data-id="2f02b09" data-element_type="widget" data-widget_type="metform.default">
					<div id="mf-response-props-id-1762" data-previous-steps-style="" data-editswitchopen="" data-response_type="alert" data-erroricon="fas fa-exclamation-triangle" data-successicon="fas fa-check" data-messageposition="top" class="   mf-scroll-top-no">
		<div class="formpicker_warper formpicker_warper_editable" data-metform-formpicker-key="1762">
				
			<div class="mf-widget-container">
				
		<div id="metform-wrap-2f02b09-1762" class="mf-form-wrapper" data-form-id="1762" data-action="{{ route('contact.send') }}" data-wp-nonce="{{ csrf_token() }}" data-form-nonce="{{ csrf_token() }}" data-quiz-summery="false" data-save-progress="false" data-form-type="contact_form" data-stop-vertical-effect=""><form class="metform-form-content"><div class="mf-main-response-wrap   mf-response-msg-wrap" data-show="0"><div class="mf-response-msg"><i class="mf-success-icon fas fa-check"></i><p></p></div></div><div class="metform-form-main-wrapper"><div data-elementor-type="wp-post" data-elementor-id="1762" class="elementor elementor-1762"><div class="elementor-element elementor-element-d7a4700 e-flex e-con-boxed e-con e-parent" data-id="d7a4700" data-element_type="container"><div class="e-con-inner"><div class="elementor-element elementor-element-a6521ad e-grid e-con-full e-con e-child" data-id="a6521ad" data-element_type="container"><div class="elementor-element elementor-element-733bc54 elementor-widget__width-inherit elementor-widget elementor-widget-mf-text" data-id="733bc54" data-element_type="widget" data-settings="{&quot;mf_input_name&quot;:&quot;mf-text&quot;}" data-widget_type="mf-text.default"><div class="mf-input-wrapper"><label class="mf-input-label" for="mf-input-text-733bc54">Nom Complet 					<span class="mf-input-required-indicator"></span></label><input type="text" class="mf-input " id="mf-input-text-733bc54" name="mf-text" placeholder="Votre Nom Complet " required aria-invalid="false"></div></div><div class="elementor-element elementor-element-8817f30 elementor-widget__width-inherit elementor-widget elementor-widget-mf-email" data-id="8817f30" data-element_type="widget" data-settings="{&quot;mf_input_name&quot;:&quot;mf-email&quot;}" data-widget_type="mf-email.default"><div class="mf-input-wrapper"><label class="mf-input-label" for="mf-input-email-8817f30">Adresse E-mail 					<span class="mf-input-required-indicator"></span></label><input type="email" class="mf-input " id="mf-input-email-8817f30" name="mf-email" placeholder="Votre E-mail " required aria-invalid="false" value=""></div></div><div class="elementor-element elementor-element-36f9851 elementor-widget__width-inherit elementor-widget elementor-widget-mf-telephone" data-id="36f9851" data-element_type="widget" data-settings="{&quot;mf_input_name&quot;:&quot;mf-telephone&quot;}" data-widget_type="mf-telephone.default"><div class="mf-input-wrapper"><label class="mf-input-label" for="mf-input-telephone-36f9851">Numéro de Téléphone 					<span class="mf-input-required-indicator"></span></label><input type="tel" class="mf-input " id="mf-input-telephone-36f9851" name="mf-telephone" placeholder="Votre Numéro de Téléphone " required aria-invalid="false"></div></div><div class="elementor-element elementor-element-1a4e605 elementor-widget__width-inherit elementor-widget elementor-widget-mf-select" data-id="1a4e605" data-element_type="widget" data-widget_type="mf-select.default"><div class="mf-input-wrapper"><label class="mf-input-label" for="mf-input-select-1a4e605">Je suis 					<span class="mf-input-required-indicator"></span></label><select name="mf-select" id="mf-input-select-1a4e605" class="mf-input" required style="width: 100%; padding: 12px; border-radius: 8px; border: 1px solid #ddd; font-size: 16px; background-color: #fff; color: #333;"><option value="">Sélectionnez une Option</option><option value="value-1">Etudiant</option><option value="value-2">Professeur</option><option value="value-3">Parent</option><option value="value-4">Visiteur</option></select></div></div></div><div class="elementor-element elementor-element-c85ae1b elementor-widget__width-inherit elementor-widget elementor-widget-mf-textarea" data-id="c85ae1b" data-element_type="widget" data-settings="{&quot;mf_input_name&quot;:&quot;mf-textarea&quot;}" data-widget_type="mf-textarea.default"><div class="mf-input-wrapper"><label class="mf-input-label" for="mf-input-text-area-c85ae1b">Votre Message 					<span class="mf-input-required-indicator"></span></label><textarea class="mf-input mf-textarea " id="mf-input-text-area-c85ae1b" name="mf-textarea" placeholder="Écrivez votre message ici " cols="30" rows="10" maxlength="1000" required aria-invalid="false"></textarea></div></div><div class="elementor-element elementor-element-6ff0f93 mf-btn--justify mf-btn--tablet-justify mf-btn--mobile-justify elementor-widget__width-inherit elementor-widget elementor-widget-mf-button" data-id="6ff0f93" data-element_type="widget" data-widget_type="mf-button.default"><div class="mf-btn-wraper " data-mf-form-conditional-logic-requirement=""><button type="submit" class="metform-btn metform-submit-btn " id=""><span>ENVOYER LE MESSAGE </span></button></div></div></div></div></div></div></form></div>


		<!----------------------------- 
			* controls_data : find the the props passed indie of data attribute
			* props.SubmitResponseMarkup : contains the markup of error or success message
			* https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals
		--------------------------- -->

				

					</div>
		</div>
		</div>				</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-a165a17 e-flex e-con-boxed e-con e-parent" data-id="a165a17" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-36832a6 e-con-full e-flex e-con e-child" data-id="36832a6" data-element_type="container">
		<div class="elementor-element elementor-element-a6672a6 e-con-full e-flex e-con e-child" data-id="a6672a6" data-element_type="container">
		<div class="elementor-element elementor-element-3e335b7 e-con-full e-flex elementor-invisible e-con e-child" data-id="3e335b7" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-1f88cba elementor-widget elementor-widget-heading" data-id="1f88cba" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">INFORMATIONS DE CONTACT</div>				</div>
				<div class="elementor-element elementor-element-3c8e443 elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="3c8e443" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-7130e2a elementor-widget elementor-widget-heading" data-id="7130e2a" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Trouvez le Bon Contact<br>
pour Votre Demande</h2>				</div>
				</div>
				<div class="elementor-element elementor-element-acc173c elementor-widget__width-initial elementor-widget elementor-widget-text-editor" data-id="acc173c" data-element_type="widget" data-widget_type="text-editor.default">
									<p>Notre équipe est organisée en départements spécialisés pour mieux vous servir. Que ce soit pour les admissions, le support technique, les questions académiques ou financières, nous sommes là pour vous aider.</p>								</div>
				</div>
		<div class="elementor-element elementor-element-f95d46a e-con-full e-flex e-con e-child" data-id="f95d46a" data-element_type="container">
		<div class="elementor-element elementor-element-8cec32e e-con-full e-flex elementor-invisible e-con e-child" data-id="8cec32e" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-91ae4dc elementor-widget__width-initial elementor-widget elementor-widget-heading" data-id="91ae4dc" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Admissions et Étudiants Potentiels</h4>				</div>
				<div class="elementor-element elementor-element-f74f737 elementor-icon-list-ico-position-0 elementor-widget__width-initial elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="f74f737" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-envelope-solid"></i>						</span>
										<span class="elementor-icon-list-text">contact.bjacademie@gmail.com</span>
									</li>
								<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-phone-solid"></i>						</span>
										<span class="elementor-icon-list-text">(+221) 78 219 48 00 (Bureau des Admissions)</span>
									</li>
								<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-clock"></i>						</span>
										<span class="elementor-icon-list-text">Lundi - Samedi, 8h30 - 21h00</span>
									</li>
						</ul>
						</div>
				</div>
				<div class="elementor-element elementor-element-91eed35 elementor-widget-divider--view-line elementor-invisible elementor-widget elementor-widget-divider" data-id="91eed35" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:200}" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
		<div class="elementor-element elementor-element-ac10aee e-con-full e-flex elementor-invisible e-con e-child" data-id="ac10aee" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-2faaff9 elementor-widget__width-initial elementor-widget elementor-widget-heading" data-id="2faaff9" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Programmes Académiques et Facultés</h4>				</div>
				<div class="elementor-element elementor-element-6676d7c elementor-icon-list-ico-position-0 elementor-widget__width-initial elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="6676d7c" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-envelope-solid"></i>						</span>
										<span class="elementor-icon-list-text">contact.bjacademie@gmail.com</span>
									</li>
								<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-phone-solid"></i>						</span>
										<span class="elementor-icon-list-text">(+221) 78 219 48 00 (Affaires Académiques Générales)</span>
									</li>
						</ul>
						</div>
				</div>
				<div class="elementor-element elementor-element-2950813 elementor-widget-divider--view-line elementor-invisible elementor-widget elementor-widget-divider" data-id="2950813" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:200}" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
		<div class="elementor-element elementor-element-360aea7 e-con-full e-flex elementor-invisible e-con e-child" data-id="360aea7" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-6dee9d9 elementor-widget__width-initial elementor-widget elementor-widget-heading" data-id="6dee9d9" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Services Étudiants et Communauté d'Apprentissage en Ligne</h4>				</div>
				<div class="elementor-element elementor-element-3a9a50c elementor-icon-list-ico-position-0 elementor-widget__width-initial elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="3a9a50c" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-envelope-solid"></i>						</span>
										<span class="elementor-icon-list-text">contact.bjacademie@gmail.com</span>
									</li>
								<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-phone-solid"></i>						</span>
										<span class="elementor-icon-list-text">(+221) 78 219 48 00 (Bureau des Services aux Étudiants)</span>
									</li>
						</ul>
						</div>
				</div>
				<div class="elementor-element elementor-element-b5496f8 elementor-widget-divider--view-line elementor-invisible elementor-widget elementor-widget-divider" data-id="b5496f8" data-element_type="widget" data-settings="{&quot;_animation&quot;:&quot;fadeInUp&quot;,&quot;_animation_mobile&quot;:&quot;none&quot;,&quot;_animation_delay&quot;:200}" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
		<div class="elementor-element elementor-element-27496ea e-con-full e-flex elementor-invisible e-con e-child" data-id="27496ea" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-88f91ff elementor-widget__width-initial elementor-widget elementor-widget-heading" data-id="88f91ff" data-element_type="widget" data-widget_type="heading.default">
					<h4 class="elementor-heading-title elementor-size-default">Demandes Générales et Administration de l'Académie</h4>				</div>
				<div class="elementor-element elementor-element-ab9d440 elementor-icon-list-ico-position-0 elementor-widget__width-initial elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="ab9d440" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-envelope-solid"></i>						</span>
										<span class="elementor-icon-list-text">contact.bjacademie@gmail.com</span>
									</li>
								<li class="elementor-icon-list-item">
											<span class="elementor-icon-list-icon">
							<i aria-hidden="true" class="jki jki-phone-solid"></i>						</span>
										<span class="elementor-icon-list-text">(+221) 78 219 48 00 (Ligne Principale de l'Académie)</span>
									</li>
						</ul>
						</div>
				</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-0f412df e-con-full e-flex e-con e-parent" data-id="0f412df" data-element_type="container">
		<div class="elementor-element elementor-element-2144283 e-con-full e-flex e-con e-child" data-id="2144283" data-element_type="container">
		<div class="elementor-element elementor-element-0359326 e-con-full e-flex e-con e-child" data-id="0359326" data-element_type="container">
		<div class="elementor-element elementor-element-61835cd e-con-full e-flex elementor-invisible e-con e-child" data-id="61835cd" data-element_type="container" data-settings="{&quot;animation&quot;:&quot;fadeInUp&quot;,&quot;animation_mobile&quot;:&quot;none&quot;}">
				<div class="elementor-element elementor-element-ffac573 elementor-widget elementor-widget-heading" data-id="ffac573" data-element_type="widget" data-widget_type="heading.default">
					<div class="elementor-heading-title elementor-size-default">LOCALISATION</div>				</div>
				<div class="elementor-element elementor-element-64e3b1f elementor-widget-divider--view-line elementor-widget elementor-widget-divider" data-id="64e3b1f" data-element_type="widget" data-widget_type="divider.default">
							<div class="elementor-divider">
			<span class="elementor-divider-separator">
						</span>
		</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-ea14bce elementor-widget elementor-widget-heading" data-id="ea14bce" data-element_type="widget" data-widget_type="heading.default">
					<h2 class="elementor-heading-title elementor-size-default">Venez Nous Visiter Ici </h2>				</div>
				<div class="elementor-element elementor-element-fdb1aae elementor-widget__width-initial elementor-widget elementor-widget-hfe-infocard" data-id="fdb1aae" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Bj Académie est située au cœur de Dakar. Bien que nos formations soient principalement en ligne, vous pouvez nous rendre visite pour des rendez-vous d'admission, des séances d'information ou des événements spéciaux organisés sur place.				</div>
							</div>
		</div>

						</div>
				</div>
				</div>
				</div>
				<div class="elementor-element elementor-element-8ffb308 elementor-widget elementor-widget-google_maps" data-id="8ffb308" data-element_type="widget" data-widget_type="google_maps.default">
							<div class="elementor-custom-embed">
			<iframe loading="lazy" src="https://www.google.com/maps?q=Liberté+6+Conachap+Campenal,+Dakar,+Sénégal&output=embed&hl=fr&z=15" style="border:0; width: 100%; height: 100%; min-height: 450px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Liberté 6 Conachap Campenal, Dakar, Sénégal" aria-label="Liberté 6 Conachap Campenal, Dakar, Sénégal"></iframe>
				</div>
				</div>
					</div>
				</div>
				</div>
					</div>
				</div>
				</div>
		
		<footer itemtype="https://schema.org/WPFooter" itemscope="itemscope" id="colophon" role="contentinfo">
			<div class="footer-width-fixer">		<div data-elementor-type="wp-post" data-elementor-id="132" class="elementor elementor-132">
				<div class="elementor-element elementor-element-7ffaa86 e-flex e-con-boxed e-con e-parent" data-id="7ffaa86" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}" style="background-image: url('{{ asset('assets/images/Propos.jpeg') }}'); background-size: cover; background-position: center; background-repeat: no-repeat;">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-c43ebe5 e-con-full e-flex e-con e-child" data-id="c43ebe5" data-element_type="container">
				<div class="elementor-element elementor-element-48650de elementor-widget elementor-widget-heading" data-id="48650de" data-element_type="widget" data-widget_type="heading.default">
					<h5 class="elementor-heading-title elementor-size-default">À Propos de Bj Académie</h5>				</div>
				<div class="elementor-element elementor-element-459d899 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="459d899" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Notre Histoire</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Direction et Annuaire</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Vision et Mission</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Carrières</span>
									</li>
						</ul>
						</div>
				</div>
		<div class="elementor-element elementor-element-277086b e-con-full e-flex e-con e-child" data-id="277086b" data-element_type="container">
				<div class="elementor-element elementor-element-440a6d1 elementor-widget elementor-widget-heading" data-id="440a6d1" data-element_type="widget" data-widget_type="heading.default">
					<h5 class="elementor-heading-title elementor-size-default">Académique</h5>				</div>
				<div class="elementor-element elementor-element-34dc48a elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="34dc48a" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Programmes de Premier Cycle</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Programmes de Cycle Supérieur</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Apprentissage en Ligne</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Calendrier Académique</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Catalogue des Cours</span>
									</li>
						</ul>
						</div>
				</div>
		<div class="elementor-element elementor-element-9615600 e-con-full e-flex e-con e-child" data-id="9615600" data-element_type="container">
				<div class="elementor-element elementor-element-eabb2db elementor-widget elementor-widget-heading" data-id="eabb2db" data-element_type="widget" data-widget_type="heading.default">
					<h5 class="elementor-heading-title elementor-size-default">Recherche</h5>				</div>
				<div class="elementor-element elementor-element-5acc564 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="5acc564" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Groupes de Recherche</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Publications et Revues</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Centres de Recherche</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Subventions et Financement</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Innovation et Collaboration</span>
									</li>
						</ul>
						</div>
				</div>
		<div class="elementor-element elementor-element-06f8ee4 e-con-full e-flex e-con e-child" data-id="06f8ee4" data-element_type="container">
				<div class="elementor-element elementor-element-5667505 elementor-widget elementor-widget-heading" data-id="5667505" data-element_type="widget" data-widget_type="heading.default">
					<h5 class="elementor-heading-title elementor-size-default">Admissions</h5>				</div>
				<div class="elementor-element elementor-element-18dbc49 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="18dbc49" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Comment Postuler</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Frais de Scolarité</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Bourses d'Études</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Services aux Étudiants</span>
									</li>
						</ul>
						</div>
				</div>
					</div>
				</div>
		<div class="elementor-element elementor-element-cb77bca e-flex e-con-boxed e-con e-parent" data-id="cb77bca" data-element_type="container" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
					<div class="e-con-inner">
		<div class="elementor-element elementor-element-c272438 e-con-full e-flex e-con e-child" data-id="c272438" data-element_type="container">
		<div class="elementor-element elementor-element-ef1d55f e-con-full e-flex e-con e-child" data-id="ef1d55f" data-element_type="container">
				<div class="elementor-element elementor-element-29d8e20 elementor-position-top elementor-widget elementor-widget-image-box" data-id="29d8e20" data-element_type="widget" data-widget_type="image-box.default">
					<div class="elementor-image-box-wrapper"><figure class="elementor-image-box-img"><a href="{{ route('home') }}" style="display: flex; align-items: center; gap: 15px; text-decoration: none; color: inherit;">
																<img src="{{ asset('assets/images/chapeau.jpg') }}" alt="BJ Académie" style="width: 100px; height: 100px; object-fit: contain;">
																<span style="font-size: 36px; font-weight: bold; color: #fff; line-height: 1; white-space: nowrap; cursor: pointer;">Bj Académie</span>
															</a></figure><div class="elementor-image-box-content"><p class="elementor-image-box-description">Votre partenaire de confiance pour une formation professionnelle d'excellence accessible en ligne, où que vous soyez.</p></div></div>				</div>
				<div class="elementor-element elementor-element-807ad75 e-grid-align-left elementor-shape-rounded elementor-grid-0 elementor-widget elementor-widget-social-icons" data-id="807ad75" data-element_type="widget" data-widget_type="social-icons.default">
							<div class="elementor-social-icons-wrapper elementor-grid">
							<span class="elementor-grid-item">
					<a class="elementor-icon elementor-social-icon elementor-social-icon-icon-facebook elementor-repeater-item-08840f7" target="_blank">
						<span class="elementor-screen-only">Icon-facebook</span>
						<i class="icon icon-facebook"></i>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="elementor-icon elementor-social-icon elementor-social-icon-linkedin-in elementor-repeater-item-c51fb29" target="_blank">
						<span class="elementor-screen-only">Linkedin-in</span>
						<svg class="e-font-icon-svg e-fab-linkedin-in" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="elementor-icon elementor-social-icon elementor-social-icon-x-twitter elementor-repeater-item-c4abc01" target="_blank">
						<span class="elementor-screen-only">X-twitter</span>
						<svg class="e-font-icon-svg e-fab-x-twitter" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg"><path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z"></path></svg>					</a>
				</span>
							<span class="elementor-grid-item">
					<a class="elementor-icon elementor-social-icon elementor-social-icon-whatsapp" href="https://wa.me/221782194800" target="_blank" style="display: flex !important; align-items: center !important; justify-content: center !important; width: auto !important; height: auto !important; margin-top: 15px !important; position: relative !important; top: 8px !important;">
						<span class="elementor-screen-only">WhatsApp</span>
						<img src="{{ asset('assets/images/WhatsApp.png') }}" alt="WhatsApp" style="width: 50px !important; height: 50px !important; object-fit: contain; display: block !important;">
					</a>
				</span>
					</div>
						</div>
				</div>
		<div class="elementor-element elementor-element-81a385b e-con-full e-flex e-con e-child" data-id="81a385b" data-element_type="container">
		<div class="elementor-element elementor-element-e7be5bc e-con-full e-flex e-con e-child" data-id="e7be5bc" data-element_type="container">
				<div class="elementor-element elementor-element-bd0034f elementor-widget elementor-widget-hfe-infocard" data-id="bd0034f" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Contactez-Nous</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Sicap Liberté 6, Dakar, Sénégal				</div>
							</div>
		</div>

						</div>
				</div>
				<div class="elementor-element elementor-element-3e18668 elementor-icon-list--layout-traditional elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="3e18668" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items">
							<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">Téléphone : (+221) 78 219 48 00</span>
									</li>
								<li class="elementor-icon-list-item">
										<span class="elementor-icon-list-text">E-mail : contact.bjacademie@gmail.com</span>
									</li>
						</ul>
						</div>
				</div>
		<div class="elementor-element elementor-element-0b9570d e-con-full e-flex e-con e-child" data-id="0b9570d" data-element_type="container">
				<div class="elementor-element elementor-element-2562f62 elementor-widget elementor-widget-hfe-infocard" data-id="2562f62" data-element_type="widget" data-widget_type="hfe-infocard.default">
				<div class="elementor-widget-container">
					
		<div class="hfe-infocard">
									<div class="hfe-infocard-title-wrap">
				<h5 class="hfe-infocard-title elementor-inline-editing" data-elementor-setting-key="infocard_title" data-elementor-inline-editing-toolbar="basic">Lettre d'Information</h5>			</div>
						<div class="hfe-infocard-text-wrap">
				<div class="hfe-infocard-text elementor-inline-editing" data-elementor-setting-key="infocard_description" data-elementor-inline-editing-toolbar="advanced">
					Obtenez les dernières informations et actualités de Bj Académie.				</div>
							</div>
		</div>

						</div>
				</div>
				<div class="elementor-element elementor-element-d5d1e90 elementor-widget__width-inherit elementor-widget elementor-widget-metform" data-id="d5d1e90" data-element_type="widget" data-widget_type="metform.default">
					<div id="mf-response-props-id-166" data-previous-steps-style="" data-editswitchopen="" data-response_type="alert" data-erroricon="fas fa-exclamation-triangle" data-successicon="fas fa-check" data-messageposition="top" class="   mf-scroll-top-no">
		<div class="formpicker_warper formpicker_warper_editable" data-metform-formpicker-key="166">
				
			<div class="mf-widget-container">
				
		<!-- Formulaire d'abonnement newsletter professionnel -->
		<form id="newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}" style="display: flex; flex-direction: column; gap: 12px;">
			@csrf
			<div style="position: relative;">
				<input 
					type="email" 
					name="email" 
					id="newsletter-email" 
					placeholder="Votre E-mail" 
					required 
					style="width: 100%; padding: 12px 16px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.3); background: rgba(255,255,255,0.1); color: #fff; font-size: 14px; outline: none; transition: all 0.3s;"
					oninvalid="this.setCustomValidity('Veuillez entrer une adresse email valide')"
					oninput="this.setCustomValidity('')"
				>
				<div id="newsletter-error" style="display: none; color: #ff6b6b; font-size: 12px; margin-top: 5px;"></div>
			</div>
			<button 
				type="submit" 
				id="newsletter-submit-btn"
				style="width: 100%; padding: 12px 24px; background: #DC2626; color: #fff; border: none; border-radius: 8px; font-weight: 600; font-size: 14px; cursor: pointer; transition: all 0.3s; text-transform: uppercase;"
				onmouseover="this.style.background='#b91c1c'"
				onmouseout="this.style.background='#DC2626'"
			>
				S'ABONNER
			</button>
			<div id="newsletter-success" style="display: none; color: #10b981; font-size: 14px; margin-top: 8px; text-align: center; padding: 10px; background: rgba(16,185,129,0.1); border-radius: 6px;">
				<i class="fas fa-check-circle" style="margin-right: 5px;"></i>
				<span id="newsletter-success-message"></span>
			</div>
		</form>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				const newsletterForm = document.getElementById('newsletter-form');
				const newsletterEmail = document.getElementById('newsletter-email');
				const newsletterSubmitBtn = document.getElementById('newsletter-submit-btn');
				const newsletterError = document.getElementById('newsletter-error');
				const newsletterSuccess = document.getElementById('newsletter-success');
				const newsletterSuccessMessage = document.getElementById('newsletter-success-message');
				
				if (newsletterForm) {
					newsletterForm.addEventListener('submit', async function(e) {
						e.preventDefault();
						
						// Masquer les messages précédents
						newsletterError.style.display = 'none';
						newsletterSuccess.style.display = 'none';
						
						// Désactiver le bouton pendant l'envoi
						newsletterSubmitBtn.disabled = true;
						newsletterSubmitBtn.style.opacity = '0.6';
						newsletterSubmitBtn.textContent = 'ENVOI EN COURS...';
						
						// Validation côté client
						if (!newsletterEmail.value || !newsletterEmail.validity.valid) {
							newsletterError.textContent = 'Veuillez entrer une adresse email valide.';
							newsletterError.style.display = 'block';
							newsletterSubmitBtn.disabled = false;
							newsletterSubmitBtn.style.opacity = '1';
							newsletterSubmitBtn.textContent = 'S\'ABONNER';
							return;
						}
						
						try {
							const formData = new FormData(newsletterForm);
							const response = await fetch('{{ route("newsletter.subscribe") }}', {
								method: 'POST',
								body: formData,
								headers: {
									'X-Requested-With': 'XMLHttpRequest',
									'Accept': 'application/json'
								}
							});
							
							const data = await response.json();
							
							if (data.success) {
								newsletterSuccessMessage.textContent = data.message || 'Merci pour votre abonnement ! Vous recevrez désormais les dernières informations de Bj Académie.';
								newsletterSuccess.style.display = 'block';
								newsletterEmail.value = '';
								newsletterForm.reset();
								
								// Scroll vers le message de succès
								newsletterSuccess.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
							} else {
								newsletterError.textContent = data.message || 'Une erreur est survenue. Veuillez réessayer.';
								newsletterError.style.display = 'block';
								
								if (data.errors && data.errors.email) {
									newsletterError.textContent = data.errors.email[0];
								}
							}
						} catch (error) {
							console.error('Erreur newsletter:', error);
							newsletterError.textContent = 'Une erreur est survenue. Veuillez réessayer plus tard.';
							newsletterError.style.display = 'block';
						} finally {
							newsletterSubmitBtn.disabled = false;
							newsletterSubmitBtn.style.opacity = '1';
							newsletterSubmitBtn.textContent = 'S\'ABONNER';
						}
					});
				}
			});
		</script>


		<!----------------------------- 
			* controls_data : find the the props passed indie of data attribute
			* props.SubmitResponseMarkup : contains the markup of error or success message
			* https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Template_literals
		--------------------------- -->

				

					</div>
		</div>
		</div>				</div>
				</div>
				</div>
				</div>
		<div class="elementor-element elementor-element-f984606 e-con-full e-flex e-con e-child" data-id="f984606" data-element_type="container">
				<div class="elementor-element elementor-element-5a73b00 elementor-widget elementor-widget-copyright" data-id="5a73b00" data-element_type="widget" data-settings="{&quot;align&quot;:&quot;left&quot;}" data-widget_type="copyright.default">
				<div class="elementor-widget-container">
							<div class="hfe-copyright-wrapper">
							<span>© 2025 Bj Académie - Tous droits réservés</span>
					</div>
						</div>
				</div>
				<div class="elementor-element elementor-element-896d08e elementor-icon-list--layout-inline elementor-list-item-link-full_width elementor-widget elementor-widget-icon-list" data-id="896d08e" data-element_type="widget" data-widget_type="icon-list.default">
							<ul class="elementor-icon-list-items elementor-inline-items">
							<li class="elementor-icon-list-item elementor-inline-item">
										<span class="elementor-icon-list-text">Politique de Confidentialité</span>
									</li>
								<li class="elementor-icon-list-item elementor-inline-item">
										<span class="elementor-icon-list-text">Politique des Cookies</span>
									</li>
						</ul>
						</div>
				</div>
					</div>
				</div>
				</div>
				</div>
				</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</div>
		</footer>
	</div><!-- #page -->
<script type="speculationrules">
{"prefetch":[{"source":"document","where":{"and":[{"href_matches":"\/universite\/*"},{"not":{"href_matches":["\/universite\/wp-*.php","\/universite\/wp-admin\/*","\/universite\/wp-content\/uploads\/sites\/42\/*","\/universite\/wp-content\/*","\/universite\/wp-content\/plugins\/*","\/universite\/wp-content\/themes\/hello-elementor\/*","\/universite\/*\\?(.+)"]}},{"not":{"selector_matches":"a[rel~=\"nofollow\"]"}},{"not":{"selector_matches":".no-prefetch, .no-prefetch a"}}]},"eagerness":"conservative"}]}
</script>
			<script>
				const lazyloadRunObserver = () => {
					const lazyloadBackgrounds = document.querySelectorAll( `.e-con.e-parent:not(.e-lazyloaded)` );
					const lazyloadBackgroundObserver = new IntersectionObserver( ( entries ) => {
						entries.forEach( ( entry ) => {
							if ( entry.isIntersecting ) {
								let lazyloadBackground = entry.target;
								if( lazyloadBackground ) {
									lazyloadBackground.classList.add( 'e-lazyloaded' );
								}
								lazyloadBackgroundObserver.unobserve( entry.target );
							}
						});
					}, { rootMargin: '200px 0px 200px 0px' } );
					lazyloadBackgrounds.forEach( ( lazyloadBackground ) => {
						lazyloadBackgroundObserver.observe( lazyloadBackground );
					} );
				};
				const lazyloadEvents = [
					'DOMContentLoaded',
					'elementor/lazyload/observe',
				];
				lazyloadEvents.forEach( ( event ) => {
					document.addEventListener( event, lazyloadRunObserver );
				} );
			</script>
			<!-- Fichiers CSS externes commentés pour éviter les erreurs 404 -->
			<!-- <link rel="stylesheet" id="jeg-dynamic-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/css/dynamic-style.css?ver=2.6.13" media="all"> -->
			<!-- <link rel="stylesheet" id="owl.carousel-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/owl-carousel/owl.carousel.min.css?ver=2.2.1" media="all"> -->
			<link rel="stylesheet" id="widget-image-box-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-image-box.min.css?ver=3.28.4" media="all">
			<link rel="stylesheet" id="widget-social-icons-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/widget-social-icons.min.css?ver=3.28.4" media="all">
			<!-- <link rel="stylesheet" id="e-apple-webkit-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/css/conditionals/e-apple-webkit.min.css?ver=3.28.4" media="all"> -->
			<link rel="stylesheet" id="metform-ui-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/css/metform-ui.css?ver=4.0.0" media="all">
			<!-- <link rel="stylesheet" id="metform-style-css" href="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/css/metform-style.css?ver=4.0.0" media="all"> -->
<link rel="stylesheet" id="elementor-post-166-css" href="https://kits.yumnatype.com/universite/wp-content/uploads/sites/42/elementor/css/post-166.css?ver=1759459613" media="all">
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/jquery-numerator/jquery-numerator.min.js?ver=0.2.1" id="jquery-numerator-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/lib/swiper/v8/swiper.min.js?ver=8.4.5" id="swiper-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/lib/cute-alert/cute-alert.js?ver=4.0.0" id="cute-alert-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/themes/hello-elementor/assets/js/hello-frontend.min.js?ver=1.0.0" id="hello-theme-frontend-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/libs/framework/assets/js/frontend-script.js?ver=3.5.1" id="elementskit-framework-js-frontend-js"></script>
<script id="elementskit-framework-js-frontend-js-after">
		var elementskit = {
			resturl: 'https://kits.yumnatype.com/universite/wp-json/elementskit/v1/',
		}

		
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/widgets/init/assets/js/widget-scripts.js?ver=3.5.1" id="ekit-widget-scripts-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/sweetalert2/sweetalert2.min.js?ver=11.6.16" id="sweetalert2-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/tiny-slider/tiny-slider.js?ver=2.9.3" id="tiny-slider-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/js/webpack.runtime.min.js?ver=3.28.4" id="elementor-webpack-runtime-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/js/frontend-modules.min.js?ver=3.28.4" id="elementor-frontend-modules-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/jquery/ui/core.min.js?ver=1.13.3" id="jquery-ui-core-js"></script>
<script id="elementor-frontend-js-before">
var elementorFrontendConfig = {"environmentMode":{"edit":false,"wpPreview":false,"isScriptDebug":false},"i18n":{"shareOnFacebook":"Share on Facebook","shareOnTwitter":"Share on Twitter","pinIt":"Pin it","download":"Download","downloadImage":"Download image","fullscreen":"Fullscreen","zoom":"Zoom","share":"Share","playVideo":"Play Video","previous":"Previous","next":"Next","close":"Close","a11yCarouselPrevSlideMessage":"Previous slide","a11yCarouselNextSlideMessage":"Next slide","a11yCarouselFirstSlideMessage":"This is the first slide","a11yCarouselLastSlideMessage":"This is the last slide","a11yCarouselPaginationBulletMessage":"Go to slide"},"is_rtl":false,"breakpoints":{"xs":0,"sm":480,"md":768,"lg":1025,"xl":1440,"xxl":1600},"responsive":{"breakpoints":{"mobile":{"label":"Mobile Portrait","value":767,"default_value":767,"direction":"max","is_enabled":true},"mobile_extra":{"label":"Mobile Landscape","value":880,"default_value":880,"direction":"max","is_enabled":false},"tablet":{"label":"Tablet Portrait","value":1024,"default_value":1024,"direction":"max","is_enabled":true},"tablet_extra":{"label":"Tablet Landscape","value":1200,"default_value":1200,"direction":"max","is_enabled":false},"laptop":{"label":"Laptop","value":1366,"default_value":1366,"direction":"max","is_enabled":false},"widescreen":{"label":"Widescreen","value":2400,"default_value":2400,"direction":"min","is_enabled":false}},"hasCustomBreakpoints":false},"version":"3.28.4","is_static":false,"experimentalFeatures":{"e_font_icon_svg":true,"additional_custom_breakpoints":true,"container":true,"e_optimized_markup":true,"e_local_google_fonts":true,"hello-theme-header-footer":true,"nested-elements":true,"editor_v2":true,"e_element_cache":true,"home_screen":true,"launchpad-checklist":true},"urls":{"assets":"https:\/\/kits.yumnatype.com\/universite\/wp-content\/plugins\/elementor\/assets\/","ajaxurl":"https:\/\/kits.yumnatype.com\/universite\/wp-admin\/admin-ajax.php","uploadUrl":"https:\/\/kits.yumnatype.com\/universite\/wp-content\/uploads\/sites\/42"},"nonces":{"floatingButtonsClickTracking":"7018779507"},"swiperClass":"swiper","settings":{"page":[],"editorPreferences":[]},"kit":{"body_background_background":"classic","active_breakpoints":["viewport_mobile","viewport_tablet"],"global_image_lightbox":"yes","lightbox_enable_counter":"yes","lightbox_enable_fullscreen":"yes","lightbox_enable_zoom":"yes","lightbox_enable_share":"yes","lightbox_title_src":"title","lightbox_description_src":"description","hello_header_logo_type":"title","hello_header_menu_layout":"horizontal","hello_footer_logo_type":"logo"},"post":{"id":30,"title":"Bj Académie","excerpt":"","featuredImage":false}};
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementor/assets/js/frontend.min.js?ver=3.28.4" id="elementor-frontend-js"></script><span id="elementor-device-mode" class="elementor-screen-only"></span>
<script id="elementor-frontend-js-after">
var jkit_ajax_url = "https://kits.yumnatype.com/universite/?jkit-ajax-request=jkit_elements", jkit_nonce = "fa4c5d57f0";
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/testimonials.js?ver=2.6.13" id="jkit-element-testimonials-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/animated-text.js?ver=2.6.13" id="jkit-element-animatedtext-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/video-button.js?ver=2.6.13" id="jkit-element-videobutton-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/sticky-element.js?ver=2.6.13" id="jkit-sticky-element-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/nav-menu.js?ver=2.6.13" id="jkit-element-navmenu-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon/js/jquery.easing.1.3.js?ver=1.0" id="easing-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon/js/jquery.superslides.js?ver=1.0" id="superslides-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon/js/allscripts.js?ver=1.0" id="gum-elementor-addon-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon//js/owl.carousel.min.js?ver=2.2.1" id="owl.carousel-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/gum-elementor-addon/js/price-table.js?ver=1.0" id="gum-price-table-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/js/htm.js?ver=4.0.0" id="htm-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/vendor/react.min.js?ver=18.3.1.1" id="react-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/vendor/react-dom.min.js?ver=18.3.1.1" id="react-dom-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/escape-html.min.js?ver=6561a406d2d232a6fbd2" id="wp-escape-html-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/element.min.js?ver=a4eeeadd23c0d7ab1d2d" id="wp-element-js"></script>
<script id="metform-app-js-extra">
var mf = {"postType":"page","restURI":"https:\/\/kits.yumnatype.com\/universite\/wp-json\/metform\/v1\/forms\/views\/","minMsg1":"Minimum length should be ","Msg2":" character long.","maxMsg1":"Maximum length should be ","maxNum":"Maximum number should be ","minNum":"Minimum number should be "};
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/js/app.js?ver=4.0.0" id="metform-app-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/widgets/init/assets/js/animate-circle.min.js?ver=3.5.1" id="animate-circle-js"></script>
<script id="elementskit-elementor-js-extra">
var ekit_config = {"ajaxurl":"https:\/\/kits.yumnatype.com\/universite\/wp-admin\/admin-ajax.php","nonce":"3f673ea01c"};
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/elementskit-lite/widgets/init/assets/js/elementor.js?ver=3.5.1" id="elementskit-elementor-js"></script>

<script>
// Les fonctions showLoginForm et showRegisterForm sont déjà définies dans le HEAD
// Ici on attache seulement les event listeners aux boutons dès que le DOM est prêt
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INITIALISATION DES EVENT LISTENERS ===');
    console.log('Timestamp:', new Date().toISOString());
    
    // Vérifier que les fonctions existent
    console.log('Vérification des fonctions globales...');
    console.log('- window.showLoginForm existe:', typeof window.showLoginForm === 'function');
    console.log('- window.showRegisterForm existe:', typeof window.showRegisterForm === 'function');
    
    if (typeof window.showLoginForm !== 'function') {
        console.error('❌ ERREUR CRITIQUE: window.showLoginForm n\'est pas une fonction !');
    }
    if (typeof window.showRegisterForm !== 'function') {
        console.error('❌ ERREUR CRITIQUE: window.showRegisterForm n\'est pas une fonction !');
    }
    
    // Attacher aux boutons dans le header
    console.log('Recherche des boutons dans le header...');
    const btnLogin = document.getElementById('btn-login');
    const btnRegister = document.getElementById('btn-register');
    
    console.log('- btn-login trouvé:', !!btnLogin);
    console.log('- btn-register trouvé:', !!btnRegister);
    
    if (btnLogin) {
        console.log('Attachement de l\'event listener au bouton CONNEXION...');
        // NE PAS supprimer onclick, mais ajouter un listener en plus pour plus de sécurité
        const oldOnclick = btnLogin.getAttribute('onclick');
        console.log('- Ancien onclick:', oldOnclick);
        
        // Ajouter le listener en plus de onclick
        btnLogin.addEventListener('click', function(e) {
            console.log('🔵 CLIC DÉTECTÉ sur bouton CONNEXION (header) - Event Listener');
            e.preventDefault();
            e.stopPropagation();
            console.log('Appel de window.showLoginForm()...');
            if (typeof window.showLoginForm === 'function') {
                window.showLoginForm();
            } else {
                console.error('❌ window.showLoginForm n\'est pas une fonction !');
                alert('Erreur: La fonction showLoginForm n\'est pas disponible');
            }
        }, { capture: true, once: false });
        
        // S'assurer que onclick fonctionne aussi
        if (!oldOnclick || !oldOnclick.includes('showLoginForm')) {
            btnLogin.setAttribute('onclick', 'window.showLoginForm(); return false;');
            console.log('✅ Attribut onclick ajouté au bouton CONNEXION');
        }
        console.log('✅ Event listener attaché au bouton CONNEXION');
    } else {
        console.error('❌ Bouton btn-login non trouvé !');
    }
    
    if (btnRegister) {
        console.log('Attachement de l\'event listener au bouton S\'INSCRIRE...');
        // NE PAS supprimer onclick, mais ajouter un listener en plus pour plus de sécurité
        const oldOnclick = btnRegister.getAttribute('onclick');
        console.log('- Ancien onclick:', oldOnclick);
        
        // Ajouter le listener en plus de onclick
        btnRegister.addEventListener('click', function(e) {
            console.log('🔵 CLIC DÉTECTÉ sur bouton S\'INSCRIRE (header) - Event Listener');
            e.preventDefault();
            e.stopPropagation();
            console.log('Appel de window.showRegisterForm()...');
            if (typeof window.showRegisterForm === 'function') {
                window.showRegisterForm();
            } else {
                console.error('❌ window.showRegisterForm n\'est pas une fonction !');
                alert('Erreur: La fonction showRegisterForm n\'est pas disponible');
            }
        }, { capture: true, once: false });
        
        // S'assurer que onclick fonctionne aussi
        if (!oldOnclick || !oldOnclick.includes('showRegisterForm')) {
            btnRegister.setAttribute('onclick', 'window.showRegisterForm(); return false;');
            console.log('✅ Attribut onclick ajouté au bouton S\'INSCRIRE');
        }
        console.log('✅ Event listener attaché au bouton S\'INSCRIRE');
    } else {
        console.error('❌ Bouton btn-register non trouvé !');
    }
    
    // Attacher aux autres boutons dans la page
    console.log('Recherche des autres boutons dans la page...');
    const allLoginButtons = document.querySelectorAll('button[onclick*="showLoginForm"], button[onclick*="showLoginForm"]');
    console.log('- Nombre de boutons CONNEXION trouvés:', allLoginButtons.length);
    allLoginButtons.forEach((btn, index) => {
        console.log(`Attachement event listener au bouton CONNEXION #${index + 1}...`);
        // NE PAS supprimer onclick, ajouter le listener en plus
        btn.addEventListener('click', function(e) {
            console.log(`🔵 CLIC DÉTECTÉ sur bouton CONNEXION #${index + 1}`);
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.showLoginForm === 'function') {
                window.showLoginForm();
            } else {
                console.error('❌ window.showLoginForm n\'est pas une fonction !');
            }
        }, { capture: true, once: false });
        // S'assurer que onclick fonctionne
        if (!btn.getAttribute('onclick') || !btn.getAttribute('onclick').includes('showLoginForm')) {
            btn.setAttribute('onclick', 'window.showLoginForm(); return false;');
        }
    });
    
    const allRegisterButtons = document.querySelectorAll('button[onclick*="showRegisterForm"], button[onclick*="showRegisterForm"]');
    console.log('- Nombre de boutons S\'INSCRIRE trouvés:', allRegisterButtons.length);
    allRegisterButtons.forEach((btn, index) => {
        console.log(`Attachement event listener au bouton S'INSCRIRE #${index + 1}...`);
        // NE PAS supprimer onclick, ajouter le listener en plus
        btn.addEventListener('click', function(e) {
            console.log(`🔵 CLIC DÉTECTÉ sur bouton S'INSCRIRE #${index + 1}`);
            e.preventDefault();
            e.stopPropagation();
            if (typeof window.showRegisterForm === 'function') {
                window.showRegisterForm();
            } else {
                console.error('❌ window.showRegisterForm n\'est pas une fonction !');
            }
        }, { capture: true, once: false });
        // S'assurer que onclick fonctionne
        if (!btn.getAttribute('onclick') || !btn.getAttribute('onclick').includes('showRegisterForm')) {
            btn.setAttribute('onclick', 'window.showRegisterForm(); return false;');
        }
    });
    
    console.log('=== FIN INITIALISATION DES EVENT LISTENERS ===');
    console.log('Total boutons CONNEXION avec listeners:', allLoginButtons.length + (btnLogin ? 1 : 0));
    console.log('Total boutons S\'INSCRIRE avec listeners:', allRegisterButtons.length + (btnRegister ? 1 : 0));
});

// La fonction validateFileSizeImmediate est maintenant définie dans le HEAD (ligne ~419)
// pour être disponible immédiatement lors du chargement de la page

// Validation de la taille des fichiers (5MB maximum) - SÉCURITÉ CRITIQUE
function validateFileSize(input, errorElementId, fileName) {
    if (!input || !input.files || input.files.length === 0) {
        return true;
    }
    
    const maxSize = 5 * 1024 * 1024; // 5MB en bytes (5242880 bytes)
    const file = input.files[0];
    
    if (!file) {
        return true;
    }
    
    // Vérification CRITIQUE de la taille
    if (file.size > maxSize) {
        const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
        const errorMessage = `⚠️ Le fichier "${file.name}" (${fileSizeMB} MB) dépasse la limite de 5 MB.\n\nLa taille du fichier doit être inférieure à 5 MB.\n\nVeuillez choisir un fichier plus petit.`;
        
        // Afficher l'erreur dans le DOM - FORCER L'AFFICHAGE
        const errorElement = document.getElementById(errorElementId);
        if (errorElement) {
            errorElement.textContent = `⚠️ Le fichier "${file.name}" (${fileSizeMB} MB) dépasse la limite de 5 MB. Veuillez choisir un fichier plus petit.`;
            errorElement.classList.remove('hidden');
            errorElement.style.display = 'block !important';
            errorElement.style.visibility = 'visible !important';
            errorElement.style.opacity = '1 !important';
        } else {
            console.error('Error element not found:', errorElementId);
        }
        
        // Réinitialiser le champ
        input.value = '';
        input.classList.add('border-red-500', 'border-2');
        
        // ALERTE OBLIGATOIRE - SÉCURITÉ CRITIQUE
        alert(errorMessage);
        
        // Scroll vers l'erreur
        if (errorElement) {
            errorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
        
        return false;
    } else {
        // Fichier valide - masquer les erreurs
        const errorElement = document.getElementById(errorElementId);
        if (errorElement) {
            errorElement.classList.add('hidden');
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        }
        input.classList.remove('border-red-500', 'border-2');
        return true;
    }
}

// Initialisation de la validation des fichiers - SÉCURITÉ CRITIQUE
function initFileValidation() {
    // Validation des fichiers lors de la sélection
    const photoInput = document.getElementById('photo-input');
    const diplomeInput = document.getElementById('diplome-input');
    const carteIdentiteInput = document.getElementById('carte_identite-input');
    
    if (photoInput) {
        // Supprimer les anciens listeners pour éviter les doublons
        photoInput.removeEventListener('change', photoInput._validationHandler);
        photoInput._validationHandler = function() {
            console.log('Photo file selected, size:', this.files[0] ? (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB' : 'no file');
            validateFileSize(this, 'photo-error', 'Photo');
        };
        photoInput.addEventListener('change', photoInput._validationHandler);
    }
    
    if (diplomeInput) {
        diplomeInput.removeEventListener('change', diplomeInput._validationHandler);
        diplomeInput._validationHandler = function() {
            console.log('Diplome file selected, size:', this.files[0] ? (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB' : 'no file');
            validateFileSize(this, 'diplome-error', 'Diplôme');
        };
        diplomeInput.addEventListener('change', diplomeInput._validationHandler);
    }
    
    if (carteIdentiteInput) {
        carteIdentiteInput.removeEventListener('change', carteIdentiteInput._validationHandler);
        carteIdentiteInput._validationHandler = function() {
            console.log('Carte identite file selected, size:', this.files[0] ? (this.files[0].size / 1024 / 1024).toFixed(2) + ' MB' : 'no file');
            validateFileSize(this, 'carte_identite-error', 'Carte d\'identité');
        };
        carteIdentiteInput.addEventListener('change', carteIdentiteInput._validationHandler);
    }
}

// Validation du formulaire d'inscription - SÉCURITÉ CRITIQUE
document.addEventListener('DOMContentLoaded', function() {
    console.log('Initialisation de la validation des fichiers...');
    
    // Initialiser immédiatement
    initFileValidation();
    
    // Réinitialiser après un délai pour s'assurer que les éléments sont disponibles
    setTimeout(function() {
        initFileValidation();
    }, 500);
    
    // Validation en temps réel du mot de passe
    const passwordField = document.getElementById('register-password');
    if (passwordField) {
        passwordField.addEventListener('input', function() {
            const password = this.value;
            const requirementsDiv = document.getElementById('password-requirements');
            
            if (password.length > 0 && requirementsDiv) {
                requirementsDiv.style.display = 'block';
                
                // Vérifier chaque exigence
                const hasMinLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);
                const hasDigit = /[0-9]/.test(password);
                
                // Mettre à jour visuellement chaque exigence
                const reqLength = document.getElementById('req-length');
                const reqUppercase = document.getElementById('req-uppercase');
                const reqLowercase = document.getElementById('req-lowercase');
                const reqDigit = document.getElementById('req-digit');
                
                if (reqLength) {
                    reqLength.textContent = hasMinLength ? '✓ Au moins 8 caractères' : '✗ Au moins 8 caractères';
                    reqLength.className = hasMinLength ? 'text-green-400' : 'text-red-400';
                }
                if (reqUppercase) {
                    reqUppercase.textContent = hasUppercase ? '✓ Au moins une majuscule' : '✗ Au moins une majuscule';
                    reqUppercase.className = hasUppercase ? 'text-green-400' : 'text-red-400';
                }
                if (reqLowercase) {
                    reqLowercase.textContent = hasLowercase ? '✓ Au moins une minuscule' : '✗ Au moins une minuscule';
                    reqLowercase.className = hasLowercase ? 'text-green-400' : 'text-red-400';
                }
                if (reqDigit) {
                    reqDigit.textContent = hasDigit ? '✓ Au moins un chiffre' : '✗ Au moins un chiffre';
                    reqDigit.className = hasDigit ? 'text-green-400' : 'text-red-400';
                }
                
                // Mettre à jour la bordure du champ
                if (hasMinLength && hasUppercase && hasLowercase && hasDigit) {
                    this.classList.remove('border-red-500', 'border-2');
                    this.classList.add('border-green-500', 'border-2');
                } else {
                    this.classList.remove('border-green-500', 'border-2');
                    if (password.length > 0) {
                        this.classList.add('border-red-500', 'border-2');
                    }
                }
            } else if (requirementsDiv && password.length === 0) {
                requirementsDiv.style.display = 'none';
                this.classList.remove('border-red-500', 'border-green-500', 'border-2');
            }
        });
    }
    
    const registerForm = document.getElementById('register-form');
    
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            console.log('Form submission started - validating files...');
            
            // SÉCURITÉ : Vérifier que le mot de passe respecte les exigences
            const passwordField = document.getElementById('register-password');
            const passwordConfirmField = document.getElementById('register-password-confirm');
            
            if (passwordField && passwordConfirmField) {
                const password = passwordField.value;
                const passwordConfirm = passwordConfirmField.value;
                
                // Vérifier les exigences du mot de passe
                const hasMinLength = password.length >= 8;
                const hasUppercase = /[A-Z]/.test(password);
                const hasLowercase = /[a-z]/.test(password);
                const hasDigit = /[0-9]/.test(password);
                const isValidPassword = hasMinLength && hasUppercase && hasLowercase && hasDigit;
                
                if (!isValidPassword) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Afficher l'erreur visuellement
                    passwordField.classList.add('border-red-500', 'border-2');
                    
                    // Afficher un message d'erreur
                    let errorMsg = passwordField.parentElement.querySelector('.password-format-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'text-red-500 text-xs mt-1 password-format-error';
                        passwordField.parentElement.appendChild(errorMsg);
                    }
                    let errorText = 'Le mot de passe doit contenir : ';
                    const missing = [];
                    if (!hasMinLength) missing.push('au moins 8 caractères');
                    if (!hasUppercase) missing.push('une lettre majuscule');
                    if (!hasLowercase) missing.push('une lettre minuscule');
                    if (!hasDigit) missing.push('un chiffre');
                    errorMsg.textContent = errorText + missing.join(', ') + '.';
                    
                    // Scroll vers l'erreur
                    passwordField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    passwordField.focus();
                    
                    alert('⚠️ Le mot de passe doit contenir au moins 8 caractères, une lettre majuscule, une lettre minuscule et un chiffre.');
                    return false;
                }
                
                // Vérifier que les mots de passe correspondent
                if (password !== passwordConfirm) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Afficher l'erreur visuellement
                    passwordConfirmField.classList.add('border-red-500', 'border-2');
                    passwordField.classList.add('border-red-500', 'border-2');
                    
                    // Afficher un message d'erreur
                    let errorMsg = passwordConfirmField.parentElement.querySelector('.password-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.className = 'text-red-500 text-xs mt-1 password-error';
                        passwordConfirmField.parentElement.appendChild(errorMsg);
                    }
                    errorMsg.textContent = 'Les mots de passe ne correspondent pas.';
                    
                    // Scroll vers l'erreur
                    passwordConfirmField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    passwordConfirmField.focus();
                    
                    alert('⚠️ Les mots de passe ne correspondent pas. Veuillez vérifier votre saisie.');
                    return false;
                } else {
                    // Supprimer les erreurs visuelles si les mots de passe correspondent
                    passwordConfirmField.classList.remove('border-red-500', 'border-2');
                    passwordField.classList.remove('border-red-500', 'border-2');
                    const errorMsg = passwordConfirmField.parentElement.querySelector('.password-error');
                    if (errorMsg) {
                        errorMsg.remove();
                    }
                }
            }
            
            // Vérifier les conditions d'utilisation
            const termsCheckbox = document.getElementById('terms');
            if (!termsCheckbox || !termsCheckbox.checked) {
                e.preventDefault();
                alert('Vous devez accepter les conditions d\'utilisation et la politique de confidentialité pour créer un compte.');
                termsCheckbox.focus();
                termsCheckbox.parentElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                return false;
            }
            
            // Vérifier la taille des fichiers avant l'envoi - SÉCURITÉ CRITIQUE
            let hasError = false;
            const photoInput = document.getElementById('photo-input');
            const diplomeInput = document.getElementById('diplome-input');
            const carteIdentiteInput = document.getElementById('carte_identite-input');
            
            if (photoInput && photoInput.files.length > 0) {
                console.log('Validating photo file...');
                if (!validateFileSize(photoInput, 'photo-error', 'Photo')) {
                    hasError = true;
                    console.error('Photo file too large!');
                }
            }
            
            if (diplomeInput && diplomeInput.files.length > 0) {
                console.log('Validating diplome file...');
                if (!validateFileSize(diplomeInput, 'diplome-error', 'Diplôme')) {
                    hasError = true;
                    console.error('Diplome file too large!');
                }
            }
            
            if (carteIdentiteInput && carteIdentiteInput.files.length > 0) {
                console.log('Validating carte identite file...');
                if (!validateFileSize(carteIdentiteInput, 'carte_identite-error', 'Carte d\'identité')) {
                    hasError = true;
                    console.error('Carte identite file too large!');
                }
            }
            
            if (hasError) {
                e.preventDefault();
                e.stopPropagation();
                alert('⚠️ Un ou plusieurs fichiers dépassent la limite de 5 MB. Veuillez corriger avant de soumettre le formulaire.');
                return false;
            }
            
            console.log('All files validated successfully');
        });
    }
});

// Les fonctions showLoginForm et showRegisterForm sont maintenant définies au début du script (ligne ~2803)

// Initialisation sécurisée au chargement - GARANTIT LE MASQUAGE CORRECT
// IMPORTANT : Ce script ne doit PAS interférer avec les formulaires ouverts par l'utilisateur
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== INITIALISATION DES FORMULAIRES AU CHARGEMENT ===');
    console.log('Timestamp:', new Date().toISOString());
    
    const loginContainer = document.getElementById('form-login-container');
    const registerContainer = document.getElementById('form-register-container');
    const loginForm = document.getElementById('login-form');
    
    console.log('Éléments trouvés:');
    console.log('- loginContainer:', !!loginContainer);
    console.log('- registerContainer:', !!registerContainer);
    console.log('- loginForm:', !!loginForm);
    
    // Vérifier s'il y a des erreurs AVANT de masquer
    // SÉCURITÉ : Vérifier uniquement les erreurs spécifiques à chaque formulaire
    const hasLoginErrors = loginContainer && (loginContainer.querySelector('#login-error-message') || (loginContainer.querySelector('.text-red-500') && loginContainer.querySelector('input[name="login"], input[name="password"]')));
    const hasRegisterErrors = registerContainer && (registerContainer.querySelector('#register-error-message') || registerContainer.querySelector('.text-red-500'));
    const hasSessionError = @json(session('error') ? true : false);
    
    // SÉCURITÉ CRITIQUE : Si le formulaire d'inscription a des erreurs, NE JAMAIS afficher le formulaire de connexion
    // Si le formulaire de connexion a des erreurs, l'afficher SEULEMENT si l'inscription n'a pas d'erreurs
    if (hasLoginErrors && loginContainer && !hasRegisterErrors && !hasSessionError) {
        console.log('✅ Erreurs détectées dans le formulaire de connexion, AFFICHAGE');
        loginContainer.classList.remove('hidden');
        loginContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
        loginContainer.setAttribute('aria-hidden', 'false');
        if (registerContainer) {
            registerContainer.classList.add('hidden');
            registerContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
            registerContainer.setAttribute('aria-hidden', 'true');
        }
        // Scroll vers le formulaire avec erreurs
        setTimeout(() => {
            loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }
    
    // SÉCURITÉ CRITIQUE : Masquer les deux formulaires par défaut UNIQUEMENT au chargement initial
    // Ne pas toucher aux formulaires si l'utilisateur les a déjà ouverts ou s'il y a des erreurs
    if (loginContainer && registerContainer) {
        // Vérifier si un formulaire a été ouvert par l'utilisateur
        const userOpenedLogin = loginContainer.hasAttribute('data-user-opened');
        const userOpenedRegister = registerContainer.hasAttribute('data-user-opened');
        
        console.log('Vérification des attributs data-user-opened:');
        console.log('- userOpenedLogin:', userOpenedLogin);
        console.log('- userOpenedRegister:', userOpenedRegister);
        
        // Si l'utilisateur a déjà ouvert un formulaire ou s'il y a des erreurs, NE PAS le masquer
        if (userOpenedLogin || userOpenedRegister || hasLoginErrors || hasRegisterErrors) {
            console.log('✅ Formulaire déjà ouvert par l\'utilisateur ou erreurs présentes, NE PAS MASQUER');
            return;
        }
        
        console.log('Aucun formulaire ouvert par l\'utilisateur et aucune erreur, procéder au masquage initial...');
        
        // Si aucun formulaire n'a d'erreurs, masquer les deux
        if (!hasLoginErrors && !hasRegisterErrors) {
            loginContainer.classList.add('hidden');
            loginContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
            loginContainer.setAttribute('aria-hidden', 'true');
            
            registerContainer.classList.add('hidden');
            registerContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
            registerContainer.setAttribute('aria-hidden', 'true');
        } else {
            // Afficher UNIQUEMENT le formulaire qui a des erreurs, jamais les deux
            if (hasLoginErrors && !hasRegisterErrors) {
                // Masquer l'inscription
                registerContainer.classList.add('hidden');
                registerContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                registerContainer.setAttribute('aria-hidden', 'true');
                
                // Afficher la connexion
                loginContainer.classList.remove('hidden');
                loginContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                loginContainer.setAttribute('aria-hidden', 'false');
            } else if ((hasRegisterErrors || hasSessionError) && !hasLoginErrors) {
                // Masquer la connexion
                loginContainer.classList.add('hidden');
                loginContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                loginContainer.setAttribute('aria-hidden', 'true');
                
                // Afficher l'inscription
                registerContainer.classList.remove('hidden');
                registerContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                registerContainer.setAttribute('aria-hidden', 'false');
                
                // Scroll vers le formulaire avec erreurs
                setTimeout(() => {
                    registerContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }, 100);
            } else {
                // Si les deux ont des erreurs (ne devrait pas arriver), masquer les deux par sécurité
                loginContainer.classList.add('hidden');
                loginContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                loginContainer.setAttribute('aria-hidden', 'true');
                
                registerContainer.classList.add('hidden');
                registerContainer.style.cssText = 'display: none !important; visibility: hidden !important; opacity: 0 !important;';
                registerContainer.setAttribute('aria-hidden', 'true');
            }
        }
    }
    
    if (loginForm) {
        console.log('[DEBUG DOMContentLoaded] Formulaire de connexion trouvé');
        const loginEmail = document.getElementById('login-email');
        const loginPassword = document.getElementById('login-password');
        const loginSubmitBtn = document.getElementById('login-submit-btn');
        
        console.log('[DEBUG DOMContentLoaded] Éléments du formulaire:', {
            loginEmail: !!loginEmail,
            loginPassword: !!loginPassword,
            loginSubmitBtn: !!loginSubmitBtn,
            loginEmailId: loginEmail ? loginEmail.id : 'N/A',
            loginPasswordId: loginPassword ? loginPassword.id : 'N/A',
            loginSubmitBtnId: loginSubmitBtn ? loginSubmitBtn.id : 'N/A'
        });
        
        if (loginEmail && loginPassword && loginSubmitBtn) {
            console.log('[DEBUG DOMContentLoaded] Ajout des événements et vérification initiale');
            checkLoginFields();
            loginEmail.addEventListener('input', function() {
                console.log('[DEBUG] Événement input sur login-email, valeur:', loginEmail.value ? loginEmail.value.substring(0, 5) + '...' : 'vide');
                checkLoginFields();
            });
            loginEmail.addEventListener('change', function() {
                console.log('[DEBUG] Événement change sur login-email');
                checkLoginFields();
            });
            loginPassword.addEventListener('input', function() {
                console.log('[DEBUG] Événement input sur login-password, longueur:', loginPassword.value.length);
                checkLoginFields();
            });
            loginPassword.addEventListener('change', function() {
                console.log('[DEBUG] Événement change sur login-password');
                checkLoginFields();
            });
            
            // Ajouter un listener sur le bouton pour voir s'il est cliqué
            loginSubmitBtn.addEventListener('click', function(e) {
                console.log('[DEBUG] Bouton Se connecter cliqué');
                console.log('[DEBUG] État du bouton:', {
                    disabled: loginSubmitBtn.disabled,
                    type: loginSubmitBtn.type,
                    form: loginSubmitBtn.form ? loginSubmitBtn.form.id : 'N/A'
                });
                if (loginSubmitBtn.disabled) {
                    console.warn('[DEBUG] ATTENTION: Le bouton est désactivé!');
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs pour vous connecter.');
                }
            });
            
            // Gestionnaire AJAX pour éviter le rechargement de page
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Empêcher la soumission par défaut
                
                const formData = new FormData(loginForm);
                const submitBtn = loginForm.querySelector('#login-submit-btn');
                let errorMessageDiv = document.getElementById('login-error-message');
                
                // Désactiver le bouton pendant la soumission
                const originalBtnText = submitBtn ? submitBtn.textContent : 'Se connecter';
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Connexion en cours...';
                }
                
                // Afficher le formulaire s'il est caché
                if (loginContainer) {
                    loginContainer.classList.remove('hidden');
                    loginContainer.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                    loginContainer.setAttribute('aria-hidden', 'false');
                }
                
                fetch(loginForm.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    }
                })
                .then(response => {
                    // Vérifier si c'est une redirection (succès)
                    if (response.redirected || response.status === 302 || response.status === 200) {
                        // Si la réponse contient une redirection, suivre la redirection
                        if (response.redirected) {
                            window.location.href = response.url;
                            return;
                        }
                        // Vérifier si c'est une réponse JSON
                        const contentType = response.headers.get('content-type');
                        if (contentType && contentType.includes('application/json')) {
                            return response.json().then(data => {
                                if (data.redirect) {
                                    window.location.href = data.redirect;
                                }
                            });
                        }
                        // Sinon, c'est probablement du HTML avec erreurs
                        return response.text().then(html => {
                            // Parser le HTML pour extraire les erreurs
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const errorContainer = doc.querySelector('#login-error-message');
                            
                            if (errorContainer) {
                                // Créer ou mettre à jour le message d'erreur
                                if (!errorMessageDiv) {
                                    errorMessageDiv = document.createElement('div');
                                    errorMessageDiv.id = 'login-error-message';
                                    errorMessageDiv.className = 'mb-4 p-4 bg-white border-2 border-red-500 rounded-lg shadow-md';
                                    loginForm.insertBefore(errorMessageDiv, loginForm.firstChild);
                                }
                                errorMessageDiv.innerHTML = errorContainer.innerHTML;
                                errorMessageDiv.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                                
                                // Scroll vers le formulaire
                                setTimeout(() => {
                                    if (loginContainer) {
                                        loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                    }
                                }, 100);
                                
                                // Réactiver le bouton
                                if (submitBtn) {
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = originalBtnText;
                                }
                            } else {
                                // Pas d'erreur visible, peut-être une redirection
                                // Essayer de suivre la redirection
                                const redirectMatch = html.match(/window\.location\.href\s*=\s*['"]([^'"]+)['"]/);
                                if (redirectMatch) {
                                    window.location.href = redirectMatch[1];
                                } else {
                                    // Recharger la page pour suivre la redirection
                                    window.location.reload();
                                }
                            }
                        });
                    } else {
                        // Erreur HTTP
                        return response.json().catch(() => {
                            return response.text().then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const errorContainer = doc.querySelector('#login-error-message');
                                
                                if (errorContainer) {
                                    if (!errorMessageDiv) {
                                        errorMessageDiv = document.createElement('div');
                                        errorMessageDiv.id = 'login-error-message';
                                        errorMessageDiv.className = 'mb-4 p-4 bg-red-50 border-2 border-red-300 rounded-lg';
                                        loginForm.insertBefore(errorMessageDiv, loginForm.firstChild);
                                    }
                                    errorMessageDiv.innerHTML = errorContainer.innerHTML;
                                    errorMessageDiv.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                                    
                                    setTimeout(() => {
                                        if (loginContainer) {
                                            loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        }
                                    }, 100);
                                } else {
                                    // Message d'erreur générique
                                    if (!errorMessageDiv) {
                                        errorMessageDiv = document.createElement('div');
                                        errorMessageDiv.id = 'login-error-message';
                                        errorMessageDiv.className = 'mb-4 p-4 bg-red-50 border-2 border-red-300 rounded-lg';
                                        loginForm.insertBefore(errorMessageDiv, loginForm.firstChild);
                                    }
                                    errorMessageDiv.innerHTML = '<div class="flex items-start"><svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><div class="text-red-600 text-sm font-semibold"><p class="mb-1">Les identifiants fournis sont incorrects.</p></div></div>';
                                    errorMessageDiv.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                                    
                                    setTimeout(() => {
                                        if (loginContainer) {
                                            loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                                        }
                                    }, 100);
                                }
                                
                                // Réactiver le bouton
                                if (submitBtn) {
                                    submitBtn.disabled = false;
                                    submitBtn.textContent = originalBtnText;
                                }
                            });
                        });
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la connexion:', error);
                    
                    // Afficher un message d'erreur générique
                    if (!errorMessageDiv) {
                        errorMessageDiv = document.createElement('div');
                        errorMessageDiv.id = 'login-error-message';
                        errorMessageDiv.className = 'mb-4 p-4 bg-red-50 border-2 border-red-300 rounded-lg';
                        loginForm.insertBefore(errorMessageDiv, loginForm.firstChild);
                    }
                    errorMessageDiv.innerHTML = '<div class="flex items-start"><svg class="w-5 h-5 text-red-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg><div class="text-red-600 text-sm font-semibold"><p class="mb-1">Erreur de connexion. Veuillez réessayer.</p></div></div>';
                    errorMessageDiv.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important;';
                    
                    // Scroll vers le formulaire
                    setTimeout(() => {
                        if (loginContainer) {
                            loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    }, 100);
                    
                    // Réactiver le bouton
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalBtnText;
                    }
                });
            });
            
            console.log('[DEBUG DOMContentLoaded] Événements ajoutés avec succès');
        } else {
            console.error('[DEBUG DOMContentLoaded] ERREUR: Éléments du formulaire non trouvés', {
                loginEmail: !!loginEmail,
                loginPassword: !!loginPassword,
                loginSubmitBtn: !!loginSubmitBtn
            });
        }
    }
    
    // Afficher le formulaire de connexion s'il y a des erreurs
    if (loginContainer && !loginContainer.classList.contains('hidden')) {
        const hasErrors = loginContainer.querySelector('.text-red-500, .text-red-600, .bg-red-50, .bg-white, #login-error-message');
        if (hasErrors) {
            loginContainer.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }
});

// Fonctions pour les modaux (si nécessaire)
function openTermsModal() {
    // Implémentation si nécessaire
    alert('Conditions d\'utilisation');
}

function openPrivacyModal() {
    // Implémentation si nécessaire
    alert('Politique de confidentialité');
}

// Gestion de la navigation entre les pages
(function() {
    const currentPage = '{{ $currentPage ?? "home" }}';
    
    // Fonction pour faire défiler vers le haut - méthode plus agressive
    function scrollToTop() {
        // Utiliser toutes les méthodes possibles
        try {
            window.scrollTo(0, 0);
            window.scrollTo({ top: 0, left: 0, behavior: 'auto' });
        } catch(e) {}
        
        try {
            document.documentElement.scrollTop = 0;
            document.documentElement.scrollLeft = 0;
        } catch(e) {}
        
        try {
            document.body.scrollTop = 0;
            document.body.scrollLeft = 0;
        } catch(e) {}
        
        // Essayer aussi avec jQuery si disponible
        if (typeof jQuery !== 'undefined') {
            jQuery('html, body').scrollTop(0);
        }
    }
    
    // Faire défiler immédiatement (avant que la page ne soit complètement chargée)
    scrollToTop();
    
    // Faire défiler plusieurs fois pour s'assurer que ça fonctionne
    setTimeout(scrollToTop, 0);
    setTimeout(scrollToTop, 10);
    setTimeout(scrollToTop, 50);
    setTimeout(scrollToTop, 100);
    
    // Faire défiler aussi après le chargement complet
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            scrollToTop();
            setTimeout(scrollToTop, 10);
        });
    } else {
        scrollToTop();
    }
    
    // Faire défiler aussi après le chargement complet de la page
    window.addEventListener('load', function() {
        scrollToTop();
        setTimeout(scrollToTop, 10);
        setTimeout(scrollToTop, 50);
    });
    
    // Mettre à jour l'état actif du menu
    function updateMenu() {
        const menuItems = document.querySelectorAll('#menu-header a');
        menuItems.forEach(item => {
            item.parentElement.classList.remove('current-menu-item', 'current_page_item');
        });
        
        // Trouver et activer l'élément de menu correspondant
        const pageRouteMap = {
            'home': 'home',
            'about': 'about',
            'academics': 'academics',
            'academic-details': 'academic-details',
            'faculties': 'faculties',
            'faculty-details': 'faculty-details',
            'campus-life': 'campus-life',
            'blog': 'blog',
            'single-post': 'single-post',
            'staff': 'staff',
            'faq': 'faq',
            'event': 'event',
            'how-to-apply': 'how-to-apply',
            'contact': 'contact'
        };
        
        const currentRoute = pageRouteMap[currentPage] || 'home';
        menuItems.forEach(item => {
            const href = item.getAttribute('href');
            if (href && href.includes(currentRoute)) {
                item.parentElement.classList.add('current-menu-item', 'current_page_item');
                item.setAttribute('aria-current', 'page');
            } else {
                item.removeAttribute('aria-current');
            }
        });
    }
    
    // Mettre à jour le menu après le chargement
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', updateMenu);
    } else {
        updateMenu();
    }
})();

<!-- Scripts JavaScript spécifiques à la section de contact -->
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/js/htm.js?ver=4.0.0" id="htm-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/vendor/react.min.js?ver=18.3.1.1" id="react-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/vendor/react-dom.min.js?ver=18.3.1.1" id="react-dom-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/escape-html.min.js?ver=6561a406d2d232a6fbd2" id="wp-escape-html-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-includes/js/dist/element.min.js?ver=a4eeeadd23c0d7ab1d2d" id="wp-element-js"></script>
<script id="metform-app-js-extra">
var mf = {"postType":"envato_tk_templates","restURI":"https:\/\/kits.yumnatype.com\/universite\/wp-json\/metform\/v1\/forms\/views\/","minMsg1":"Minimum length should be ","Msg2":" character long.","maxMsg1":"Maximum length should be ","maxNum":"Maximum number should be ","minNum":"Minimum number should be "};
</script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/metform/public/assets/js/app.js?ver=4.0.0" id="metform-app-js"></script>
<script src="https://kits.yumnatype.com/universite/wp-content/plugins/jeg-elementor-kit/assets/js/elements/animated-text.js?ver=2.6.13" id="jkit-element-animatedtext-js"></script>

<script>
	// Système de navigation sécurisé et fiable
	(function() {
		'use strict';
		
		// Protection contre les appels multiples simultanés
		let isScrolling = false;
		let scrollTimeout = null;
		
		// Fonction centralisée de scroll sécurisée
		function secureScrollToSection(sectionId, offset = 80) {
			// Vérifications de sécurité
			if (isScrolling) {
				return false; // Empêcher les appels multiples
			}
			
			// Validation de l'ID (sécurité contre l'injection)
			if (!sectionId || typeof sectionId !== 'string' || !/^[a-zA-Z0-9_-]+$/.test(sectionId)) {
				console.error('ID de section invalide:', sectionId);
				return false;
			}
			
			// Vérifier que l'élément existe
			const targetSection = document.getElementById(sectionId);
			if (!targetSection) {
				console.error('Section non trouvée:', sectionId);
				return false;
			}
			
			// Vérifier que l'élément est visible et dans le DOM
			if (!targetSection.offsetParent && targetSection.style.display === 'none') {
				console.error('Section non visible:', sectionId);
				return false;
			}
			
			// Marquer comme en cours de scroll
			isScrolling = true;
			
			// Annuler tout scroll précédent
			if (scrollTimeout) {
				clearTimeout(scrollTimeout);
			}
			
			try {
				// Calculer la position exacte avec offset pour le header
				const elementPosition = targetSection.getBoundingClientRect().top;
				const offsetPosition = elementPosition + window.pageYOffset - offset;
				
				// Utiliser requestAnimationFrame pour un scroll fluide et fiable
				let startPosition = window.pageYOffset;
				let startTime = null;
				const duration = 600; // Durée en millisecondes
				
				function animateScroll(currentTime) {
					if (startTime === null) {
						startTime = currentTime;
					}
					
					const timeElapsed = currentTime - startTime;
					const progress = Math.min(timeElapsed / duration, 1);
					
					// Fonction d'easing pour un mouvement fluide
					const easeInOutQuad = progress < 0.5 
						? 2 * progress * progress 
						: 1 - Math.pow(-2 * progress + 2, 2) / 2;
					
					const currentPosition = startPosition + (offsetPosition - startPosition) * easeInOutQuad;
					window.scrollTo(0, currentPosition);
					
					if (progress < 1) {
						requestAnimationFrame(animateScroll);
					} else {
						// Scroll terminé
						isScrolling = false;
						scrollTimeout = null;
					}
				}
				
				// Démarrer l'animation
				requestAnimationFrame(animateScroll);
				
				return true;
			} catch (error) {
				console.error('Erreur lors du scroll:', error);
				isScrolling = false;
				scrollTimeout = null;
				return false;
			}
		}
		
		// Mapping sécurisé des sections - défini en dehors du DOMContentLoaded pour être accessible
		const sectionMap = {
			'about-section': { offset: 80 },
			'academics-section': { offset: 80 },
			'faculties-section': { offset: 80 },
			'pricing-section': { offset: 80 },
			'contact-section': { offset: 80 }
		};
		
		// Initialisation sécurisée après le chargement du DOM
		document.addEventListener('DOMContentLoaded', function() {
			
			// Fonction pour gérer les clics sur les liens d'ancrage
			function handleAnchorClick(e) {
				const href = this.getAttribute('href');
				
				// Vérifier que c'est un lien d'ancrage valide
				if (!href || !href.startsWith('#')) {
					return; // Laisser le comportement par défaut
				}
				
				// Extraire l'ID de la section
				const sectionId = href.substring(1);
				
				// Vérifier que la section est dans notre mapping (sécurité)
				if (!sectionMap.hasOwnProperty(sectionId)) {
					return; // Section non autorisée
				}
				
				// Empêcher le comportement par défaut
				e.preventDefault();
				e.stopPropagation();
				
				// Scroll sécurisé
				const config = sectionMap[sectionId];
				secureScrollToSection(sectionId, config.offset);
			}
			
			// Attacher les event listeners à tous les liens d'ancrage
			Object.keys(sectionMap).forEach(function(sectionId) {
				const links = document.querySelectorAll('a[href="#' + sectionId + '"]');
				links.forEach(function(link) {
					// Vérifier que le lien existe
					if (link && typeof link.addEventListener === 'function') {
						link.addEventListener('click', handleAnchorClick, { passive: false });
					}
				});
			});
			
			// Gérer aussi les ancres dans l'URL au chargement de la page
			if (window.location.hash) {
				const hash = window.location.hash.substring(1);
				if (sectionMap.hasOwnProperty(hash)) {
					// Attendre que la page soit complètement chargée
					setTimeout(function() {
						const config = sectionMap[hash];
						secureScrollToSection(hash, config.offset);
					}, 100);
				}
			}
			
			// Protection contre les modifications malveillantes
			Object.freeze(sectionMap);
		});
	})();
</script>

<script>
	// Le dropdown "Je suis" a été remplacé par un simple select HTML, plus besoin de code JavaScript complexe
</script>

<script>
	// Empêcher le clic sur les titres de posts tout en gardant le hover
	document.addEventListener('DOMContentLoaded', function() {
		const postTitles = document.querySelectorAll('.post-title');
		postTitles.forEach(function(title) {
			// Empêcher le clic
			title.addEventListener('click', function(e) {
				e.preventDefault();
				e.stopPropagation();
				return false;
			});
			// Empêcher le clic droit
			title.addEventListener('contextmenu', function(e) {
				e.preventDefault();
				return false;
			});
		});

		// Intercepter la soumission du formulaire de contact
		const contactForm = document.querySelector('#metform-wrap-2f02b09-1762 form');
		if (contactForm) {
			contactForm.addEventListener('submit', async function(e) {
				e.preventDefault();
				
				// Récupérer les données du formulaire
				const nomComplet = document.getElementById('mf-input-text-733bc54')?.value;
				const email = document.getElementById('mf-input-email-8817f30')?.value;
				const telephone = document.getElementById('mf-input-telephone-36f9851')?.value;
				const jeSuis = document.getElementById('mf-input-select-1a4e605')?.value;
				const message = document.getElementById('mf-input-text-area-c85ae1b')?.value;

				// Vérifier que tous les champs sont remplis
				if (!nomComplet || !email || !telephone || !jeSuis || !message) {
					alert('Veuillez remplir tous les champs du formulaire.');
					return;
				}

				// Afficher un message de chargement
				const submitBtn = contactForm.querySelector('.metform-submit-btn');
				const originalText = submitBtn?.querySelector('span')?.textContent;
				if (submitBtn) {
					submitBtn.disabled = true;
					if (submitBtn.querySelector('span')) {
						submitBtn.querySelector('span').textContent = 'Envoi en cours...';
					}
				}

				try {
					// Envoyer les données à notre route Laravel
					const response = await fetch('{{ route("contact.send") }}', {
						method: 'POST',
						headers: {
							'Content-Type': 'application/json',
							'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
							'Accept': 'application/json'
						},
						body: JSON.stringify({
							'mf-text': nomComplet,
							'mf-email': email,
							'mf-telephone': telephone,
							'mf-select': jeSuis,
							'mf-textarea': message
						})
					});

					const result = await response.json();

					if (result.success) {
						// Afficher un message de succès
						alert(result.message || 'Votre message a été envoyé avec succès !');
						// Réinitialiser le formulaire
						contactForm.reset();
					} else {
						// Afficher un message d'erreur
						alert(result.message || 'Une erreur est survenue. Veuillez réessayer.');
					}
				} catch (error) {
					console.error('Erreur lors de l\'envoi du formulaire:', error);
					alert('Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer plus tard.');
				} finally {
					// Réactiver le bouton
					if (submitBtn) {
						submitBtn.disabled = false;
						if (submitBtn.querySelector('span') && originalText) {
							submitBtn.querySelector('span').textContent = originalText;
						}
					}
				}
			});
		}
	});
</script>
 
</body></html>
