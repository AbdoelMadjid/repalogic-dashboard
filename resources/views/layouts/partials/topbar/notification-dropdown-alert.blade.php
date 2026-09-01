@php
    $notifData = \App\Services\NotificationService::getNotifications();
    $notifItems = $notifData['items'];
    $totalCount = $notifData['total_count'];
    $unreadCount = $notifData['unread_count'];
@endphp

<div id="notification-dropdown-alert" class="topbar-item">
    <div class="dropdown" id="topbar-notif-dropdown-wrapper">
        <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button"
            id="topbar-notif-toggle-btn" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-bell topbar-link-icon"></i>
            <span id="topbar-notif-bell-badge" class="badge text-bg-danger badge-circle topbar-badge {{ $unreadCount > 0 ? '' : 'd-none' }}">
                {{ $unreadCount > 99 ? '99+' : ($unreadCount > 0 ? $unreadCount : '') }}
            </span>
        </button>

        <div id="topbar-notif-dropdown-content" class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-width: 360px; overflow-x: hidden;">
            @include('layouts.partials.topbar.notification-dropdown-content', [
                'notifItems' => $notifItems,
                'unreadCount' => $unreadCount,
                'totalCount' => $totalCount,
            ])
        </div>
        <!-- End dropdown-menu -->
    </div>
    <!-- end dropdown-->
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pollUrl = "{{ route('admin.notifications.poll') }}";
    const pollIntervalMs = 20000; // Poll setiap 20 detik
    const bellBadge = document.getElementById('topbar-notif-bell-badge');
    const dropdownContent = document.getElementById('topbar-notif-dropdown-content');
    const toggleBtn = document.getElementById('topbar-notif-toggle-btn');
    const csrfToken = "{{ csrf_token() }}";

    let isFetching = false;

    window.fetchNotificationsSilently = function(isUserAction = false) {
        if (isFetching) return;
        if (sessionStorage.getItem('repalogic_screen_locked') === 'true') return;
        if (!isUserAction && document.hidden) return;
        if (!isUserAction && dropdownContent && dropdownContent.classList.contains('show')) return;

        isFetching = true;

        fetch(pollUrl, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(response) {
            if (response.status === 401) {
                window.location.href = "{{ route('login') }}";
                return null;
            }
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(function(data) {
            if (data && data.success) {
                const count = parseInt(data.unread_count, 10) || 0;
                if (bellBadge) {
                    if (count > 0) {
                        bellBadge.textContent = count > 99 ? '99+' : count;
                        bellBadge.classList.remove('d-none');
                    } else {
                        bellBadge.classList.add('d-none');
                        bellBadge.textContent = '';
                    }
                }

                if (dropdownContent && data.html) {
                    dropdownContent.innerHTML = data.html;
                }
            }
        })
        .catch(function(err) {
            // Silently ignore network errors during background polling
        })
        .finally(function() {
            isFetching = false;
        });
    };

    // 1. Set Interval background polling (20 detik) tanpa memicu user activity event
    setInterval(function() {
        window.fetchNotificationsSilently(false);
    }, pollIntervalMs);

    // 2. Poll langsung saat tombol notifikasi diklik oleh user
    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            window.fetchNotificationsSilently(true);
        });
    }

    // 3. Poll langsung saat pengguna kembali aktif membuka tab browser (visibilitychange)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            window.fetchNotificationsSilently(false);
        }
    });

    // 4. Event Delegation saat Notifikasi Diklik oleh User (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const notifItem = e.target.closest('.btn-view-notif-detail');
        if (!notifItem) return;

        const notifId = notifItem.getAttribute('data-notif-id') || '';
        const title = notifItem.getAttribute('data-notif-title') || 'Notifikasi';
        const message = notifItem.getAttribute('data-notif-message') || '';
        const reason = notifItem.getAttribute('data-notif-reason') || '';
        const timeAgo = notifItem.getAttribute('data-notif-time') || '';
        const targetUrl = notifItem.getAttribute('data-notif-url') || '';

        // Jika notifikasi memiliki ID database (awalan db-)
        const cleanId = notifId.replace(/^db-/, '');
        if (cleanId && notifId.startsWith('db-')) {
            // Tandai sebagai dibaca di backend via AJAX
            fetch('/admin/notifications/' + cleanId + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function() {
                window.fetchNotificationsSilently(true);
            }).catch(function() {});
        }

        // Jika notifikasi ini merupakan pesan khusus / memiliki alasan penolakan / url javascript:void(0);
        if (reason || targetUrl === 'javascript:void(0);' || notifId.includes('deactivation-') || notifId.includes('db-')) {
            if (targetUrl === 'javascript:void(0);' || reason || notifId.startsWith('db-')) {
                e.preventDefault();

                if (typeof Swal !== 'undefined') {
                    // Formatting title: warnai kata "Ditolak" dengan warna merah (text-danger)
                    let formattedTitle = title;
                    if (formattedTitle.includes('Ditolak') && !formattedTitle.includes('text-danger')) {
                        formattedTitle = formattedTitle.replace('Ditolak', '<span class="text-danger">Ditolak</span>');
                    }

                    // Hapus kalimat "dengan alasan: ..." dari pesan karena sudah ada di box khusus bawahnya
                    let cleanMessage = message;
                    if (cleanMessage.includes('dengan alasan:')) {
                        cleanMessage = cleanMessage.split('dengan alasan:')[0].trim();
                        if (!cleanMessage.endsWith('.')) cleanMessage += '.';
                    }

                    let modalHtml = `<div class="text-start fs-14 text-dark lh-base mt-2">
                        <p class="mb-3 text-secondary">${cleanMessage}</p>`;

                    if (reason) {
                        modalHtml += `<div class="p-3 bg-light border-start border-danger border-4 rounded-2 fs-13 text-dark mb-3">
                            <strong class="text-danger d-block mb-1"><i class="ti ti-notes me-1"></i>Alasan Penolakan dari Admin:</strong>
                            <span class="fst-italic">"${reason}"</span>
                        </div>`;
                    }

                    modalHtml += `<div class="fs-12 text-muted mt-2 border-top pt-2 d-flex align-items-center gap-1">
                        <i class="ti ti-clock fs-14 text-primary"></i> ${timeAgo}
                    </div></div>`;

                    Swal.fire({
                        title: formattedTitle,
                        html: modalHtml,
                        icon: reason ? 'warning' : 'info',
                        confirmButtonText: 'Tutup / Mengerti',
                        customClass: {
                            confirmButton: 'btn btn-primary px-4'
                        },
                        buttonsStyling: false
                    }).then(function() {
                        window.fetchNotificationsSilently(true);
                    });
                }
            }
        }
    });
});
</script>
