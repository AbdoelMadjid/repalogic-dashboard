/**
 * RepaLogic Dashboard - Web Push Notification & Service Worker Manager
 * Path: public/assets/js/web-push-manager.js
 */

(function() {
    'use strict';

    let swRegistration = null;
    let isInitialLoad = true;
    const SEEN_NOTIF_KEY = 'repalogic_seen_notif_ids';
    const SEEN_MSG_KEY = 'repalogic_seen_msg_ids';

    // Helper to get seen IDs from session
    function getSeenIds(key) {
        try {
            return JSON.parse(sessionStorage.getItem(key) || '[]');
        } catch (e) {
            return [];
        }
    }

    // Helper to add seen IDs to session
    function addSeenId(key, id) {
        const ids = getSeenIds(key);
        if (!ids.includes(id)) {
            ids.push(id);
            if (ids.length > 200) ids.shift(); // Keep bounded
            sessionStorage.setItem(key, JSON.stringify(ids));
        }
    }

    // 1. Register Service Worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
            navigator.serviceWorker.register('/sw.js', { scope: '/' })
                .then(function(reg) {
                    swRegistration = reg;
                    // Check for updates
                    reg.update();
                })
                .catch(function(err) {
                    console.warn('[WebPush] Service Worker registration skipped:', err.message);
                });
        });
    }

    // 2. Synthesize Notification Audio Chime (Web Audio API)
    function playNotificationChime() {
        try {
            const AudioContext = window.AudioContext || window.webkitAudioContext;
            if (!AudioContext) return;

            const ctx = new AudioContext();
            const now = ctx.currentTime;

            // First note (Tone 1)
            const osc1 = ctx.createOscillator();
            const gain1 = ctx.createGain();
            osc1.type = 'sine';
            osc1.frequency.setValueAtTime(587.33, now); // D5
            gain1.gain.setValueAtTime(0.12, now);
            gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.3);
            osc1.connect(gain1);
            gain1.connect(ctx.destination);
            osc1.start(now);
            osc1.stop(now + 0.3);

            // Second note (Tone 2 - higher chime)
            const osc2 = ctx.createOscillator();
            const gain2 = ctx.createGain();
            osc2.type = 'sine';
            osc2.frequency.setValueAtTime(880.00, now + 0.12); // A5
            gain2.gain.setValueAtTime(0.15, now + 0.12);
            gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.45);
            osc2.connect(gain2);
            gain2.connect(ctx.destination);
            osc2.start(now + 0.12);
            osc2.stop(now + 0.45);
        } catch (e) {
            // Audio context not allowed before user interaction, safely ignore
        }
    }

    // 3. Dispatch Web Push / Desktop Notification
    window.showWebPushNotification = function(data) {
        const title = data.title || 'Pemberitahuan Baru - RepaLogic';
        const body = data.body || data.message || '';
        const icon = data.icon || data.avatar || '/assets/images/logo-sm.png';
        const url = data.url || '/';
        const tag = data.tag || 'notif-' + Date.now();

        // Play audio chime
        playNotificationChime();

        // If Notification API supported and permission granted
        if ('Notification' in window && Notification.permission === 'granted') {
            const options = {
                body: body,
                icon: icon,
                badge: '/assets/images/logo-sm.png',
                tag: tag,
                data: { url: url },
                renotify: true,
                requireInteraction: false
            };

            // Preferred: via Service Worker registration
            if (swRegistration && swRegistration.showNotification) {
                swRegistration.showNotification(title, options);
            } else if (navigator.serviceWorker && navigator.serviceWorker.controller) {
                navigator.serviceWorker.controller.postMessage({
                    type: 'SHOW_NOTIFICATION',
                    title: title,
                    options: options
                });
            } else {
                // Fallback to Window Notification object
                try {
                    const notif = new Notification(title, options);
                    notif.onclick = function() {
                        window.focus();
                        if (url && url !== '/') {
                            window.location.href = url;
                        }
                        notif.close();
                    };
                } catch (e) {
                    console.warn('[WebPush] Notification fallback error:', e);
                }
            }
        } else {
            // Fallback to in-app Toast if desktop notification not permitted
            if (window.showToast && !document.hidden) {
                window.showToast(`<strong>${title}</strong>: ${body}`, 'info', 4000);
            }
        }
    };

    // 4. Request Web Push Permission API
    window.requestWebPushPermission = function(silent = false) {
        if (!('Notification' in window)) {
            if (!silent && window.showWarning) {
                window.showWarning('Browser Anda tidak mendukung fitur Desktop Push Notification.', 'Tidak Didukung');
            }
            return Promise.resolve('denied');
        }

        if (Notification.permission === 'granted') {
            if (!silent && window.showToast) {
                window.showToast('Izin Desktop Push Notification telah aktif.', 'success');
            }
            return Promise.resolve('granted');
        }

        if (Notification.permission === 'denied') {
            if (!silent && window.showWarning) {
                window.showWarning('Izin notifikasi telah diblokir di browser Anda. Silakan aktifkan izin notifikasi pada ikon gembok di sebelah URL browser.', 'Izin Diblokir');
            }
            return Promise.resolve('denied');
        }

        return Notification.requestPermission().then(function(permission) {
            if (permission === 'granted') {
                window.showWebPushNotification({
                    title: 'Notifikasi Desktop Aktif!',
                    body: 'Anda kini akan menerima pemberitahuan chat dan pertemanan saat browser diminimalkan.',
                    url: '/'
                });
                if (!silent && window.showToast) {
                    window.showToast('Notifikasi desktop berhasil diaktifkan!', 'success');
                }
            }
            return permission;
        });
    };

    // 5. Ingestion Hook for Notification & Message Polling Feeds
    window.processIncomingNotificationsForPush = function(items) {
        if (!Array.isArray(items) || items.length === 0) return;

        const seenIds = getSeenIds(SEEN_NOTIF_KEY);

        if (isInitialLoad) {
            // Populate seen IDs on first load
            items.forEach(item => {
                if (item && item.id) addSeenId(SEEN_NOTIF_KEY, item.id);
            });
            return;
        }

        items.forEach(item => {
            if (!item || !item.id || seenIds.includes(item.id)) return;

            addSeenId(SEEN_NOTIF_KEY, item.id);

            // Determine if push notification should be triggered
            const isFriendReq = item.type === 'friend_request';
            const isChatMsg = item.type === 'message' || item.type === 'chat';
            const isSelfReg = item.type === 'registration';
            const isResetReq = item.type === 'reset_password_request';
            const isDeactReq = item.type === 'deactivate_request' || item.type === 'activation_request';

            let pushTitle = 'Pemberitahuan Baru';
            if (isFriendReq) pushTitle = '👥 Ajakan Berteman Baru';
            else if (isChatMsg) pushTitle = `💬 Pesan dari ${item.title || 'Pengguna'}`;
            else if (isSelfReg) pushTitle = '👤 Pendaftaran Akun Baru';
            else if (isResetReq) pushTitle = '🔑 Permintaan Reset Password';
            else if (isDeactReq) pushTitle = '⚠️ Permintaan Akun Pengguna';

            window.showWebPushNotification({
                title: pushTitle,
                body: item.message || item.subtitle || 'Klik untuk melihat detail.',
                icon: item.avatar || '/assets/images/logo-sm.png',
                url: item.url || '/',
                tag: 'notif-' + item.id
            });
        });
    };

    window.processIncomingMessagesForPush = function(items) {
        if (!Array.isArray(items) || items.length === 0) return;

        const seenMsgIds = getSeenIds(SEEN_MSG_KEY);

        if (isInitialLoad) {
            items.forEach(msg => {
                if (msg && msg.id) addSeenId(SEEN_MSG_KEY, msg.id);
            });
            return;
        }

        items.forEach(msg => {
            if (!msg || !msg.id || seenMsgIds.includes(msg.id)) return;

            addSeenId(SEEN_MSG_KEY, msg.id);

            const senderName = msg.sender_name || msg.title || 'Pengguna';
            const snippet = msg.message || msg.last_message || 'Mengirimkan pesan baru.';
            const avatar = msg.avatar || msg.sender_avatar || '/assets/images/users/user-default.jpg';
            const targetUrl = msg.url || '/admin/profil-pengguna/messages';

            window.showWebPushNotification({
                title: `💬 Pesan Baru dari ${senderName}`,
                body: snippet,
                icon: avatar,
                url: targetUrl,
                tag: 'msg-' + msg.id
            });
        });
    };

    // Mark initial load finished after 3 seconds
    setTimeout(function() {
        isInitialLoad = false;
    }, 3000);
})();
