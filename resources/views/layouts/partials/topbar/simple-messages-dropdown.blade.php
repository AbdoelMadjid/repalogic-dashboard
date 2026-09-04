@php
    $messageData = \App\Services\NotificationService::getUserMessages();
    $messageItems = $messageData['items'];
    $totalCount = $messageData['total_count'];
    $unreadCount = $messageData['unread_count'];
    $showMessageDropdown = empty($appFeatures) || !empty($appFeatures->topbar_messages);
@endphp

<div id="simple-messages-dropdown" data-feature="topbar_messages" class="topbar-item" style="{{ $showMessageDropdown ? '' : 'display: none !important;' }}">
    <div class="dropdown" id="topbar-messages-dropdown-wrapper">
        <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button"
            id="topbar-messages-toggle-btn" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-mail topbar-link-icon"></i>
            <span id="topbar-messages-badge" class="badge text-bg-success badge-circle topbar-badge {{ $unreadCount > 0 ? '' : 'd-none' }}">
                {{ $unreadCount > 99 ? '99+' : ($unreadCount > 0 ? $unreadCount : '') }}
            </span>
        </button>

        <div id="topbar-messages-dropdown-content" class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg" style="min-width: 360px; overflow-x: hidden;">
            @include('layouts.partials.topbar.simple-messages-dropdown-content', [
                'messageItems' => $messageItems,
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
    const pollMessagesUrl = "{{ route('admin.notifications.poll-messages') }}";
    const pollIntervalMs = {{ ((int) \App\Models\Admin\DukunganAplikasi\AppSetting::get('polling_interval', 20)) * 1000 }};
    const msgBadge = document.getElementById('topbar-messages-badge');
    const msgDropdownContent = document.getElementById('topbar-messages-dropdown-content');
    const msgToggleBtn = document.getElementById('topbar-messages-toggle-btn');
    const csrfToken = "{{ csrf_token() }}";

    let isFetchingMsg = false;

    window.fetchMessagesSilently = function(isUserAction = false) {
        if (isFetchingMsg) return;
        if (sessionStorage.getItem('repalogic_screen_locked') === 'true') return;
        if (!isUserAction && document.hidden) return;
        if (!isUserAction && msgDropdownContent && msgDropdownContent.classList.contains('show')) return;

        isFetchingMsg = true;

        fetch(pollMessagesUrl, {
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
                if (msgBadge) {
                    if (count > 0) {
                        msgBadge.textContent = count > 99 ? '99+' : count;
                        msgBadge.classList.remove('d-none');
                    } else {
                        msgBadge.classList.add('d-none');
                        msgBadge.textContent = '';
                    }
                }

                if (msgDropdownContent && data.html) {
                    msgDropdownContent.innerHTML = data.html;
                }
            }
        })
        .catch(function(err) {
            // Silently fallback during background polling
        })
        .finally(function() {
            isFetchingMsg = false;
        });
    };

    // 1. Polling otomatis setiap 20 detik tanpa mengganggu idle timer
    setInterval(function() {
        window.fetchMessagesSilently(false);
    }, pollIntervalMs);

    // 2. Poll langsung saat ikon amplop pesan diklik
    if (msgToggleBtn) {
        msgToggleBtn.addEventListener('click', function() {
            window.fetchMessagesSilently(true);
        });
    }

    // 3. Poll saat tab browser kembali aktif
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            window.fetchMessagesSilently(false);
        }
    });

    // 4. Event Delegation saat Item Pesan Diklik (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const msgItem = e.target.closest('.btn-view-message-detail');
        if (!msgItem) return;

        const msgId = msgItem.getAttribute('data-message-id') || '';
        const title = msgItem.getAttribute('data-message-title') || 'Pesan Masuk';
        const content = msgItem.getAttribute('data-message-content') || '';
        const reason = msgItem.getAttribute('data-message-reason') || '';
        const timeAgo = msgItem.getAttribute('data-message-time') || '';
        const targetUrl = msgItem.getAttribute('data-message-url') || '';

        // 1. Optimistic UI update saat diklik: langsung ubah 'Belum dibaca' -> 'Sudah dibaca' & kurangi badge angka
        const statusSpan = msgItem.querySelector('.status-read-text');
        if (statusSpan && statusSpan.classList.contains('text-warning')) {
            statusSpan.classList.remove('text-warning', 'fw-medium');
            statusSpan.classList.add('text-muted');
            statusSpan.textContent = 'Sudah dibaca';
            msgItem.classList.add('bg-light-subtle', 'opacity-75');

            if (msgBadge && !msgBadge.classList.contains('d-none')) {
                let currentVal = parseInt(msgBadge.textContent, 10) || 0;
                if (currentVal > 1) {
                    msgBadge.textContent = (currentVal - 1) > 99 ? '99+' : (currentVal - 1);
                } else {
                    msgBadge.classList.add('d-none');
                    msgBadge.textContent = '';
                }
            }
        }

        // 2. Tandai sebagai dibaca di database via AJAX
        if (msgId) {
            const currentToken = typeof window.getCsrfToken === 'function' 
                ? window.getCsrfToken() 
                : (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}');

            fetch('/admin/notifications/' + encodeURIComponent(msgId) + '/read', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': currentToken,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(function() {
                window.fetchMessagesSilently(true);
            }).catch(function() {});
        }

        // 3. Langsung navigasi ke halaman chat (admin/profil-pengguna/messages?user_id=X)
        const finalUrl = (targetUrl && targetUrl !== 'javascript:void(0);') 
            ? targetUrl 
            : "{{ route('admin.profil-pengguna.messages.index') }}";

        window.location.href = finalUrl;
    });
});
</script>
