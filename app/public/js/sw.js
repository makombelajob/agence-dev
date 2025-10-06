// sw.js — Service Worker de base

self.addEventListener('install', event => {
    console.log('Service Worker: Installation…');
    // Forcer l’activation immédiate après l’installation
    self.skipWaiting();
});

self.addEventListener('activate', event => {
    console.log('Service Worker: Activé');
    // Nettoyage d’anciens caches si nécessaire
    event.waitUntil(clients.claim());
});

self.addEventListener('fetch', event => {
    // Exemple : stratégie "network first" simple
    event.respondWith(
        fetch(event.request).catch(() => {
            return new Response('⚠️ Vous êtes hors ligne.', {
                headers: { 'Content-Type': 'text/plain' }
            });
        })
    );
});
/**
 * Ferme automatiquement la navbar Bootstrap après un clic sur un lien
 */
// function autoCloseNavbar() {
//     const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
//     const navbarCollapse = document.querySelector('.navbar-collapse');

//     if (!navbarCollapse || navLinks.length === 0) return;

//     navLinks.forEach(link => {
//         link.addEventListener('click', () => {
//             const bsCollapse = new bootstrap.Collapse(navbarCollapse, { toggle: false });
//             bsCollapse.hide(); // Ferme le menu
//         });
//     });
// }

// Appel de la fonction
// autoCloseNavbar();
