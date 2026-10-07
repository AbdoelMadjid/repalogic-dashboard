/**
 * RepaLogic Dashboard - Web Push Notification Service Worker
 * Path: public/sw.js
 */

self.addEventListener('install', function(event) {
    self.skipWaiting();
});

self.addEventListener('activate', function(event) {
    event.waitUntil(self.clients.claim());
});

/**
 * Handle notification click event: focus existing tab or open target URL.
 */
self.addEventListener('notificationclick', function(event) {
    event.notification.close();

    const targetUrl = event.notification.data && event.notification.data.url
        ? event.notification.data.url
        : '/';

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true }).then(function(clientList) {
            // If an open window matches target URL or domain, focus it and navigate
            for (let i = 0; i < clientList.length; i++) {
                const client = clientList[i];
                if ('focus' in client) {
                    if (client.url === targetUrl || targetUrl === '/') {
                        return client.focus();
                    }
                    if ('navigate' in client) {
                        client.navigate(targetUrl);
                        return client.focus();
                    }
                }
            }

            // Otherwise open a new window
            if (clients.openWindow) {
                return clients.openWindow(targetUrl);
            }
        })
    );
});

/**
 * Handle direct postMessage from client to show notification via service worker.
 */
self.addEventListener('message', function(event) {
    if (!event.data) return;

    if (event.data.type === 'SHOW_NOTIFICATION') {
        const title = event.data.title || 'Pemberitahuan Sistem';
        const options = event.data.options || {};
        self.registration.showNotification(title, options);
    }
});

/**
 * Handle native Web Push event.
 */
self.addEventListener('push', function(event) {
    let data = {};
    if (event.data) {
        try {
            data = event.data.json();
        } catch (e) {
            data = { title: 'Pemberitahuan Baru', body: event.data.text() };
        }
    }

    const title = data.title || 'RepaLogic Dashboard';
    const options = {
        body: data.body || 'Anda memiliki pesan / notifikasi baru.',
        icon: data.icon || '/assets/images/logo-sm.png',
        badge: data.badge || '/assets/images/logo-sm.png',
        tag: data.tag || 'repalogic-notif-' + Date.now(),
        data: {
            url: data.url || '/'
        },
        renotify: true,
        vibrate: [200, 100, 200]
    };

    event.waitUntil(self.registration.showNotification(title, options));
});
