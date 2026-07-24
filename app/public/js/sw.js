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
