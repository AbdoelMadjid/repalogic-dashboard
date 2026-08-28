@extends('layouts.vertical', ['title' => 'Pesan & Obrolan'])

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Komunikasi & Pesan', 'title' => 'Pesan & Obrolan'])

    <div class="outlook-box">
        <!-- LEFT SIDEBAR: LIST KONTAK & OBROLAN -->
        <div class="offcanvas-lg offcanvas-start outlook-left-menu outlook-left-menu-lg" tabindex="-1" id="chatSidebaroffcanvas">
            <div class="card h-100 mb-0 border-end-0 rounded-end-0">
                <div class="card-header p-3 border-light card-bg d-block">
                    <div class="d-flex gap-2">
                        <div class="app-search flex-grow-1">
                            <input type="text" id="chat-contact-search" class="form-control bg-light-subtle border-light" placeholder="Cari kontak pengguna..." />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>
                    </div>
                </div>
                <div id="chat-sidebar" class="card-body p-2" style="height: calc(100% - 100px)" data-simplebar data-simplebar-md>
                    <div class="list-group list-group-flush chat-list" id="chat-contacts-list">
                        <div id="section-recent-contacts" class="chat-section {{ $recentContacts->isEmpty() ? 'd-none' : '' }}">
                            <div class="px-3 py-2 fs-11 font-monospace fw-bold text-uppercase text-muted bg-light border-bottom d-flex align-items-center justify-content-between">
                                <span><i class="ti ti-messages me-1 text-primary"></i>Percakapan Aktif</span>
                                <span class="badge bg-primary-subtle text-primary border fs-10" id="badge-recent-count">{{ $recentContacts->count() }}</span>
                            </div>
                            <div id="list-recent-contacts">
                                @foreach ($recentContacts as $c)
                                    @php
                                        $isActive = $activeUser && $activeUser->id === $c['id'];
                                    @endphp
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}" data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}" data-user-role="{{ $c['role_name'] }}" class="list-group-item list-group-item-action d-flex gap-2 justify-content-between btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <span class="d-flex justify-content-start align-items-center gap-2 overflow-hidden">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}" class="img-fluid rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                                            </span>
                                            <span class="overflow-hidden">
                                                <span data-chat-search-field class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end">
                                            <span class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div id="section-other-contacts" class="chat-section {{ $otherContacts->isEmpty() ? 'd-none' : '' }} {{ $recentContacts->isNotEmpty() ? 'mt-2' : '' }}">
                            <div class="px-3 py-2 fs-11 font-monospace fw-bold text-uppercase text-muted bg-light border-top border-bottom d-flex align-items-center justify-content-between">
                                <span><i class="ti ti-users me-1 text-secondary"></i>Pengguna Lainnya</span>
                                <span class="badge bg-secondary-subtle text-secondary border fs-10" id="badge-other-count">{{ $otherContacts->count() }}</span>
                            </div>
                            <div id="list-other-contacts">
                                @foreach ($otherContacts as $c)
                                    @php
                                        $isActive = $activeUser && $activeUser->id === $c['id'];
                                    @endphp
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}" data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}" data-user-role="{{ $c['role_name'] }}" class="list-group-item list-group-item-action d-flex gap-2 justify-content-between btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <span class="d-flex justify-content-start align-items-center gap-2 overflow-hidden">
                                            <span class="avatar avatar-sm flex-shrink-0">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}" class="img-fluid rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;" />
                                            </span>
                                            <span class="overflow-hidden">
                                                <span data-chat-search-field class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </span>
                                        </span>
                                        <span class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end">
                                            <span class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div id="empty-contacts-msg" class="text-center py-4 px-2 text-muted fs-13 {{ ($recentContacts->isNotEmpty() || $otherContacts->isNotEmpty()) ? 'd-none' : '' }}">
                            Belum ada pengguna lain terdaftar.
                        </div>
                    </div>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>

        <!-- RIGHT MAIN CONTENT: AREA PERCAKAPAN CHAT -->
        <div class="card h-100 mb-0 rounded-start-0 flex-grow-1">
            <div class="card-header card-bg d-flex align-items-center justify-content-between py-2.5">
                <div class="d-lg-none d-inline-flex gap-2 me-2">
                    <button class="btn btn-default btn-icon" type="button" data-bs-toggle="offcanvas" data-bs-target="#chatSidebaroffcanvas" aria-controls="chatSidebaroffcanvas">
                        <i class="ti ti-menu-4 fs-lg"></i>
                    </button>
                </div>

                <div class="flex-grow-1">
                    <h5 class="mb-1 lh-base fs-lg fw-bold" id="active-chat-name">
                        {{ $activeUser ? $activeUser->name : 'Pilih Kontak' }}
                    </h5>
                    <p class="mb-0 lh-sm text-muted d-flex align-items-center gap-1 fs-12">
                        <i class="ti ti-circle-filled text-success fs-10"></i>
                        <span id="active-chat-status">Aktif &amp; Terhubung</span>
                        <span class="badge bg-primary-subtle text-primary border ms-2 fs-11" id="active-chat-role">{{ $activeUser ? $activeUser->role_name : '' }}</span>
                    </p>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <button type="button" id="btn-view-user-detail" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#user-detail-modal" title="Lihat Profil Pengguna Ini" {{ $activeUser ? '' : 'disabled' }}>
                        <i class="ti ti-user me-1"></i> Detail Akun
                    </button>
                </div>
            </div>

            <!-- MESSAGES BUBBLE CONTAINER -->
            <div id="chat-container" class="card-body pt-2 pb-3 chat-content-bar" data-simplebar style="height: calc(100vh - 280px); overflow-y: auto;">
                @if ($activeUser && $messages->isNotEmpty())
                    @foreach ($messages as $msg)
                        @php
                            $isSender = $msg->sender_id === auth()->id();
                            $msgAvatar = $isSender ? auth()->user()->avatar_url : ($msg->sender ? $msg->sender->avatar_url : asset('assets/images/users/default-avatar.svg'));
                            $senderName = $isSender ? 'Anda' : ($msg->sender ? $msg->sender->name : 'Pengguna');
                        @endphp
                        <div class="d-flex align-items-start gap-2 my-3 chat-item {{ $isSender ? 'text-end justify-content-end' : '' }}">
                            @if (!$isSender)
                                <img src="{{ $msgAvatar }}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
                            @endif
                            <div style="max-width: 75%;">
                                <div class="chat-message py-2 px-3 {{ $isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border' }} rounded shadow-sm text-start">
                                    @if ($msg->parent)
                                        <div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm">
                                            <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>{{ $msg->parent->sender ? $msg->parent->sender->name : 'Pesan' }}</strong>
                                            <div class="text-muted text-truncate fs-12">{{ $msg->parent->body }}</div>
                                        </div>
                                    @endif
                                    @if ($msg->subject && $msg->subject !== 'Pesan Masuk')
                                        <strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>{{ $msg->subject }}</strong>
                                    @endif
                                    <div class="fs-13 lh-base text-wrap" style="word-break: break-word;">{!! nl2br(e($msg->body)) !!}</div>
                                    @if ($msg->reason)
                                        <div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                            <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> {{ $msg->reason }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
                                    <span><i class="ti ti-clock me-0.5"></i> {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}</span>
                                    <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="{{ $msg->id }}" data-sender-name="{{ $senderName }}" data-msg-body="{{ e($msg->body) }}" title="Balas Pesan Ini">
                                        <i class="ti ti-corner-up-left"></i> Balas
                                    </button>
                                </div>
                            </div>
                            @if ($isSender)
                                <img src="{{ $msgAvatar }}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
                            @endif
                        </div>
                    @endforeach
                @elseif ($activeUser)
                    <div class="text-center py-5 text-muted" id="empty-chat-placeholder">
                        <div class="avatar-md mx-auto mb-2">
                            <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                                <i class="ti ti-messages"></i>
                            </span>
                        </div>
                        <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                        <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <h6 class="fs-14 fw-semibold text-dark">Pilih Kontak Pengguna</h6>
                        <p class="fs-12 mb-0">Pilih salah satu pengguna di sebelah kiri untuk memulai pesan.</p>
                    </div>
                @endif
            </div>
            <!-- end card-body -->

            <!-- FOOTER: INPUT PESAN & TOMBOL KIRIM -->
            <div class="card-footer bg-body-secondary border-top border-dashed py-2.5">
                <form id="form-send-chat" action="javascript:void(0);">
                    <input type="hidden" id="active-receiver-id" value="{{ $activeUser ? $activeUser->id : '' }}">
                    <input type="hidden" id="reply-parent-id" name="parent_id" value="">

                    <!-- PREVIEW BOX BALASAN PESAN -->
                    <div id="reply-preview-container" class="d-none bg-white p-2.5 mb-2 rounded border-start border-3 border-primary shadow-sm position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-12 fw-bold text-primary d-flex align-items-center gap-1">
                                <i class="ti ti-corner-up-left fs-14"></i> Membalas ke <span id="reply-preview-name" class="fw-semibold text-dark"></span>
                            </span>
                            <button type="button" class="btn-close fs-10" id="btn-cancel-reply" aria-label="Batal Balas"></button>
                        </div>
                        <div class="fs-12 text-muted text-truncate ps-1" id="reply-preview-body"></div>
                    </div>

                    <div class="d-flex gap-2 align-items-center">
                        <div class="app-search flex-grow-1">
                            <input type="text" id="chat-message-input" class="form-control py-2 bg-light-subtle border-light" placeholder="Ketik pesan Anda di sini..." autocomplete="off" {{ $activeUser ? '' : 'disabled' }} />
                            <i class="ti ti-message app-search-icon text-muted"></i>
                        </div>
                        <button type="submit" id="btn-send-message" class="btn btn-primary px-3 fw-semibold" {{ $activeUser ? '' : 'disabled' }}>
                            Kirim <i class="ti ti-send ms-1 fs-14"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end card-->
    </div>

    <!-- MODAL DETAIL AKUN PENGGUNA -->
    <div class="modal fade" id="user-detail-modal" tabindex="-1" aria-labelledby="userDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title text-white fs-15 fw-semibold" id="userDetailModalLabel">
                        <i class="ti ti-id me-1"></i> Detail Profil Pengguna
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <div class="mb-3 position-relative d-inline-block">
                        <img id="modal-user-avatar" src="{{ $activeUser ? $activeUser->avatar_url : asset('assets/images/users/default-avatar.svg') }}" class="rounded-circle img-thumbnail shadow-sm" style="width: 90px; height: 90px; object-fit: cover; object-position: top;" alt="Avatar Pengguna">
                    </div>
                    <h5 class="fw-bold mb-1 text-dark fs-16" id="modal-user-name">{{ $activeUser ? $activeUser->name : '-' }}</h5>
                    <p class="text-muted fs-13 mb-3" id="modal-user-email">{{ $activeUser ? $activeUser->email : '-' }}</p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-primary-subtle text-primary border px-3 py-1.5 fs-12" id="modal-user-role">
                            <i class="ti ti-shield-check me-1"></i>{{ $activeUser ? $activeUser->role_name : '-' }}
                        </span>
                        <span class="badge bg-success-subtle text-success border px-3 py-1.5 fs-12" id="modal-user-status">
                            <i class="ti ti-circle-check me-1"></i>{{ $activeUser ? ucfirst($activeUser->status) : 'Aktif' }}
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded border text-start fs-13">
                        <div class="row g-2">
                            <div class="col-5 text-muted"><i class="ti ti-mail me-1"></i> Alamat Email:</div>
                            <div class="col-7 fw-semibold text-dark text-truncate" id="modal-info-email">{{ $activeUser ? $activeUser->email : '-' }}</div>
                            
                            <div class="col-5 text-muted"><i class="ti ti-shield me-1"></i> Peran Akun:</div>
                            <div class="col-7 fw-semibold text-dark" id="modal-info-role">{{ $activeUser ? $activeUser->role_name : '-' }}</div>

                            <div class="col-5 text-muted"><i class="ti ti-calendar me-1"></i> Terdaftar Sejak:</div>
                            <div class="col-7 fw-semibold text-dark" id="modal-info-joined">{{ $activeUser && $activeUser->created_at ? $activeUser->created_at->format('d M Y') : '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Rules 1 Compliance: Placement of script inside @section('content') before @endsection --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentUserId = {{ auth()->id() }};
            const currentUserAvatar = "{{ auth()->user()->avatar_url }}";

            const chatContainer = document.getElementById('chat-container');
            const chatForm = document.getElementById('form-send-chat');
            const chatInput = document.getElementById('chat-message-input');
            const activeReceiverInput = document.getElementById('active-receiver-id');
            const activeChatName = document.getElementById('active-chat-name');
            const activeChatRole = document.getElementById('active-chat-role');
            const btnViewUserDetail = document.getElementById('btn-view-user-detail');
            const contactSearchInput = document.getElementById('chat-contact-search');

            let activeUserId = activeReceiverInput ? activeReceiverInput.value : '';
            let lastMessageCount = {{ $messages->count() }};
            let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 'null' }};
            let userHasScrolledUp = false;

            function getChatScrollElement() {
                if (!chatContainer) return null;
                if (window.SimpleBar) {
                    const sb = window.SimpleBar.instances.get(chatContainer);
                    if (sb && typeof sb.getScrollElement === 'function') {
                        const el = sb.getScrollElement();
                        if (el) return el;
                    }
                }
                const sbWrapper = chatContainer.querySelector('.simplebar-content-wrapper');
                if (sbWrapper) return sbWrapper;
                return chatContainer;
            }

            function isUserNearBottom() {
                const scrollEl = getChatScrollElement();
                if (!scrollEl) return true;
                const distanceToBottom = scrollEl.scrollHeight - scrollEl.scrollTop - scrollEl.clientHeight;
                return distanceToBottom < 120;
            }

            function attachScrollListener() {
                const scrollEl = getChatScrollElement();
                if (scrollEl) {
                    scrollEl.addEventListener('scroll', function() {
                        const distanceToBottom = scrollEl.scrollHeight - scrollEl.scrollTop - scrollEl.clientHeight;
                        userHasScrolledUp = distanceToBottom > 120;
                    }, { passive: true });
                }
            }
            setTimeout(attachScrollListener, 200);

            // Scroll container chat ke paling bawah
            function scrollToBottom(force = false) {
                if (!chatContainer) return;
                setTimeout(function() {
                    const scrollElement = getChatScrollElement();
                    if (scrollElement) {
                        scrollElement.scrollTop = scrollElement.scrollHeight;
                        userHasScrolledUp = false;
                    }
                }, 50);
            }

            scrollToBottom(true);

            // Pindahkan kontak ke bagian "Percakapan Aktif" secara teratur & urutkan ke posisi teratas
            function promoteContactToRecent(userId, messageText, timeText = 'Baru saja') {
                const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${userId}"]`);
                if (!contactEl) return;

                const lastMsgEl = contactEl.querySelector('.contact-last-msg');
                const lastTimeEl = contactEl.querySelector('.contact-last-time');
                if (lastMsgEl && messageText) lastMsgEl.textContent = messageText;
                if (lastTimeEl && timeText) lastTimeEl.textContent = timeText;

                const listRecent = document.getElementById('list-recent-contacts');
                const listOther = document.getElementById('list-other-contacts');
                const secRecent = document.getElementById('section-recent-contacts');
                const secOther = document.getElementById('section-other-contacts');
                const badgeRecent = document.getElementById('badge-recent-count');
                const badgeOther = document.getElementById('badge-other-count');

                if (!listRecent || !listOther) return;

                const isCurrentlyOther = listOther.contains(contactEl);

                if (isCurrentlyOther) {
                    listRecent.prepend(contactEl);

                    if (badgeRecent) {
                        const currentRecent = parseInt(badgeRecent.textContent.trim() || '0', 10);
                        badgeRecent.textContent = currentRecent + 1;
                    }
                    if (badgeOther) {
                        const currentOther = parseInt(badgeOther.textContent.trim() || '0', 10);
                        badgeOther.textContent = Math.max(0, currentOther - 1);
                    }

                    if (secRecent) secRecent.classList.remove('d-none');
                    if (secOther) {
                        if (listOther.children.length === 0) {
                            secOther.classList.add('d-none');
                        } else {
                            secOther.classList.add('mt-2');
                        }
                    }
                } else {
                    listRecent.prepend(contactEl);
                }
            }

            // Search Filter Kontak Sidebar (Rule 2 Compliance)
            if (contactSearchInput) {
                contactSearchInput.addEventListener('keyup', function(e) {
                    const query = e.target.value.toLowerCase().trim();
                    document.querySelectorAll('#chat-contacts-list .btn-select-chat').forEach(function(item) {
                        const name = item.getAttribute('data-user-name') ? item.getAttribute('data-user-name').toLowerCase() : '';
                        if (query === '' || name.includes(query)) {
                            item.style.setProperty('display', '', 'important');
                        } else {
                            item.style.setProperty('display', 'none', 'important');
                        }
                    });
                });
            }

            // Event Delegation Pilih Kontak dari Sidebar
            document.addEventListener('click', function(e) {
                const btnSelect = e.target.closest('.btn-select-chat');
                if (!btnSelect) return;
                e.preventDefault();

                const userId = btnSelect.getAttribute('data-user-id');
                const userName = btnSelect.getAttribute('data-user-name');
                const userAvatar = btnSelect.getAttribute('data-user-avatar');
                const userRole = btnSelect.getAttribute('data-user-role');

                if (!userId || userId === activeUserId) return;

                // Mark active contact item
                document.querySelectorAll('#chat-contacts-list .btn-select-chat').forEach(function(el) {
                    el.classList.remove('active');
                });
                btnSelect.classList.add('active');

                // Sembunyikan badge unread pada kontak ini
                const unreadBadge = btnSelect.querySelector('.contact-unread-badge');
                if (unreadBadge) unreadBadge.classList.add('d-none');

                activeUserId = userId;
                lastMessageCount = 0;
                lastMessageId = null;
                userHasScrolledUp = false;

                if (activeReceiverInput) activeReceiverInput.value = userId;
                if (activeChatName) activeChatName.textContent = userName;
                if (activeChatRole) activeChatRole.textContent = userRole;
                if (chatInput) chatInput.disabled = false;
                if (document.getElementById('btn-send-message')) document.getElementById('btn-send-message').disabled = false;

                if (btnViewUserDetail) {
                    btnViewUserDetail.disabled = false;
                }

                // Reset state balasan pesan saat ganti kontak
                cancelReplyState();

                // Load percakapan via AJAX
                loadConversation(userId, false);
            });

            // Event Delegation Tombol Balas Pesan (Rule 2 Compliance)
            document.addEventListener('click', function(e) {
                const btnReply = e.target.closest('.btn-reply-msg');
                if (!btnReply) return;
                e.preventDefault();

                const msgId = btnReply.getAttribute('data-msg-id');
                const senderName = btnReply.getAttribute('data-sender-name');
                const msgBody = btnReply.getAttribute('data-msg-body');

                const replyContainer = document.getElementById('reply-preview-container');
                const replyName = document.getElementById('reply-preview-name');
                const replyBody = document.getElementById('reply-preview-body');
                const replyParentInput = document.getElementById('reply-parent-id');

                if (replyContainer && replyParentInput) {
                    replyParentInput.value = msgId;
                    if (replyName) replyName.textContent = senderName;
                    if (replyBody) replyBody.textContent = msgBody;
                    replyContainer.classList.remove('d-none');
                    if (chatInput) chatInput.focus();
                }
            });

            const btnCancelReply = document.getElementById('btn-cancel-reply');
            if (btnCancelReply) {
                btnCancelReply.addEventListener('click', function(e) {
                    e.preventDefault();
                    cancelReplyState();
                });
            }

            function cancelReplyState() {
                const replyContainer = document.getElementById('reply-preview-container');
                const replyParentInput = document.getElementById('reply-parent-id');
                if (replyParentInput) replyParentInput.value = '';
                if (replyContainer) replyContainer.classList.add('d-none');
            }

            // Load Percakapan via AJAX
            function loadConversation(userId, isPolling = false) {
                if (!userId) return;

                fetch(`/admin/profil-pengguna/messages/conversation/${userId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.success && chatContainer) {
                        if (data.target_user) {
                            const tu = data.target_user;
                            if (document.getElementById('modal-user-avatar')) document.getElementById('modal-user-avatar').src = tu.avatar;
                            if (document.getElementById('modal-user-name')) document.getElementById('modal-user-name').textContent = tu.name;
                            if (document.getElementById('modal-user-email')) document.getElementById('modal-user-email').textContent = tu.email;
                            if (document.getElementById('modal-user-role')) document.getElementById('modal-user-role').innerHTML = `<i class="ti ti-shield-check me-1"></i>${tu.role_name}`;
                            if (document.getElementById('modal-user-status')) document.getElementById('modal-user-status').innerHTML = `<i class="ti ti-circle-check me-1"></i>${tu.status}`;
                            if (document.getElementById('modal-info-email')) document.getElementById('modal-info-email').textContent = tu.email;
                            if (document.getElementById('modal-info-role')) document.getElementById('modal-info-role').textContent = tu.role_name;
                            if (document.getElementById('modal-info-joined')) document.getElementById('modal-info-joined').textContent = tu.joined_at;
                        }

                        const messages = data.messages || [];
                        const newCount = messages.length;
                        const newLastMsg = newCount > 0 ? messages[newCount - 1] : null;
                        const newLastId = newLastMsg ? newLastMsg.id : null;

                        // Jika sedang polling dan tidak ada perubahan total/id pesan terakhir, abaikan re-render DOM
                        if (isPolling && newCount === lastMessageCount && newLastId === lastMessageId) {
                            return;
                        }

                        const wasNearBottom = isUserNearBottom();

                        let html = '';
                        if (newCount > 0) {
                            promoteContactToRecent(userId, newLastMsg.body, newLastMsg.time_formatted);

                            messages.forEach(function(msg) {
                                const isSender = msg.is_sender;
                                const avatar = isSender ? currentUserAvatar : msg.sender_avatar;
                                const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');

                                html += `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}">`;
                                if (!isSender) {
                                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                                }
                                html += `<div style="max-width: 75%;">
                                    <div class="chat-message py-2 px-3 ${isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border'} rounded shadow-sm text-start">`;
                                
                                if (msg.parent) {
                                    html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm">
                                        <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                                        <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
                                    </div>`;
                                }

                                if (msg.subject && msg.subject !== 'Pesan Masuk') {
                                    html += `<strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>${escapeHtml(msg.subject)}</strong>`;
                                }
                                html += `<div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
                                if (msg.reason) {
                                    html += `<div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                        <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> ${escapeHtml(msg.reason)}
                                    </div>`;
                                }
                                html += `</div>
                                    <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 ${isSender ? 'justify-content-end' : 'justify-content-start'}">
                                        <span><i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}</span>
                                        <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(msg.body)}" title="Balas Pesan Ini">
                                            <i class="ti ti-corner-up-left"></i> Balas
                                        </button>
                                    </div>
                                </div>`;
                                if (isSender) {
                                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                                }
                                html += `</div>`;
                            });
                        } else {
                            html = `<div class="text-center py-5 text-muted">
                                <div class="avatar-md mx-auto mb-2">
                                    <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                                        <i class="ti ti-messages"></i>
                                    </span>
                                </div>
                                <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                                <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                            </div>`;
                        }

                        if (window.SimpleBar) {
                            const sb = window.SimpleBar.instances.get(chatContainer);
                            if (sb) {
                                const contentEl = sb.getContentElement();
                                if (contentEl) contentEl.innerHTML = html;
                            } else {
                                chatContainer.innerHTML = html;
                            }
                        } else {
                            chatContainer.innerHTML = html;
                        }

                        lastMessageCount = newCount;
                        lastMessageId = newLastId;

                        // Pasang ulang scroll listener jika elemen di-recreate
                        attachScrollListener();

                        // Hanya scroll ke paling bawah jika bukan polling biasa ATAU jika user tidak sedang scroll ke atas & berada di bawah
                        if (!isPolling || (!userHasScrolledUp && wasNearBottom)) {
                            scrollToBottom(true);
                        }
                    }
                })
                .catch(function(err) {});
            }

            // Kirim Pesan via AJAX
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!chatInput) return;

                    const messageText = chatInput.value.trim();
                    const receiverId = activeReceiverInput ? activeReceiverInput.value : '';
                    const replyParentInput = document.getElementById('reply-parent-id');
                    const parentId = (replyParentInput && replyParentInput.value.trim() !== '') ? parseInt(replyParentInput.value.trim(), 10) : null;

                    if (!messageText || !receiverId) return;

                    chatInput.value = '';

                    fetch('/admin/profil-pengguna/messages/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            parent_id: parentId,
                            body: messageText
                        })
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data && data.success) {
                            cancelReplyState();

                            // Append pesan baru langsung ke UI
                            appendSingleMessage(data.message);
                            scrollToBottom(true);

                            // Pindahkan kontak ke "Percakapan Aktif" dan update waktu & ringkasan pesan
                            promoteContactToRecent(receiverId, messageText, 'Baru saja');
                        }
                    })
                    .catch(function(err) {});
                });
            }

            function appendSingleMessage(msg) {
                if (!chatContainer) return;

                // Jika placeholder kosong ada, hapus
                const emptyPlaceholder = chatContainer.querySelector('#empty-chat-placeholder');
                if (emptyPlaceholder) emptyPlaceholder.remove();

                const isSender = msg.is_sender !== false;
                const avatar = isSender ? currentUserAvatar : (msg.sender_avatar || currentUserAvatar);
                const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');

                let html = `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}">`;
                if (!isSender) {
                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                }
                html += `<div style="max-width: 75%;">
                    <div class="chat-message py-2 px-3 ${isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border'} rounded shadow-sm text-start">`;
                
                if (msg.parent) {
                    html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm">
                        <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                        <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
                    </div>`;
                }

                html += `<div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>
                    </div>
                    <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 ${isSender ? 'justify-content-end' : 'justify-content-start'}">
                        <span><i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}</span>
                        <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(msg.body)}" title="Balas Pesan Ini">
                            <i class="ti ti-corner-up-left"></i> Balas
                        </button>
                    </div>
                </div>`;
                if (isSender) {
                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                }
                html += `</div>`;

                if (window.SimpleBar) {
                    const sb = window.SimpleBar.instances.get(chatContainer);
                    if (sb) {
                        const contentEl = sb.getContentElement();
                        if (contentEl) {
                            contentEl.insertAdjacentHTML('beforeend', html);
                        }
                    } else {
                        chatContainer.insertAdjacentHTML('beforeend', html);
                    }
                } else {
                    chatContainer.insertAdjacentHTML('beforeend', html);
                }
            }

            function escapeHtml(text) {
                if (!text) return '';
                return text
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Polling otomatis setiap 5 detik untuk memperbarui percakapan aktif jika ada pesan baru
            setInterval(function() {
                if (activeUserId && !document.hidden) {
                    loadConversation(activeUserId);
                }
            }, 5000);
        });
    </script>
@endsection
