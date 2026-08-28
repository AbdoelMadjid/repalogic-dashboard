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
                        @forelse ($contacts as $c)
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
                        @empty
                            <div class="text-center py-4 px-2 text-muted fs-13">
                                Belum ada pengguna lain terdaftar.
                            </div>
                        @endforelse
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
                    <a href="{{ route('admin.manajemenpengguna.users.index', ['search' => $activeUser ? $activeUser->name : '']) }}" id="btn-view-user-detail" class="btn btn-sm btn-outline-primary" title="Lihat Profil Pengguna Ini">
                        <i class="ti ti-user me-1"></i> Detail Akun
                    </a>
                </div>
            </div>

            <!-- MESSAGES BUBBLE CONTAINER -->
            <div id="chat-container" class="card-body pt-2 pb-3 chat-content-bar" data-simplebar style="height: calc(100vh - 280px); overflow-y: auto;">
                @if ($activeUser && $messages->isNotEmpty())
                    @foreach ($messages as $msg)
                        @php
                            $isSender = $msg->sender_id === auth()->id();
                            $msgAvatar = $isSender ? auth()->user()->avatar_url : ($msg->sender ? $msg->sender->avatar_url : asset('assets/images/users/default-avatar.svg'));
                        @endphp
                        <div class="d-flex align-items-start gap-2 my-3 chat-item {{ $isSender ? 'text-end justify-content-end' : '' }}">
                            @if (!$isSender)
                                <img src="{{ $msgAvatar }}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
                            @endif
                            <div style="max-width: 75%;">
                                <div class="chat-message py-2 px-3 {{ $isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border' }} rounded shadow-sm text-start">
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
                                <div class="text-muted fs-xs mt-1 {{ $isSender ? 'text-end' : 'text-start' }}">
                                    <i class="ti ti-clock me-0.5"></i>
                                    {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}
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

            // Scroll container chat ke paling bawah
            function scrollToBottom() {
                if (!chatContainer) return;
                setTimeout(function() {
                    if (window.SimpleBar) {
                        const sb = window.SimpleBar.instances.get(chatContainer);
                        if (sb) {
                            const scrollElement = sb.getScrollElement();
                            if (scrollElement) scrollElement.scrollTop = scrollElement.scrollHeight;
                            return;
                        }
                    }
                    chatContainer.scrollTop = chatContainer.scrollHeight;
                }, 50);
            }

            scrollToBottom();

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
                if (activeReceiverInput) activeReceiverInput.value = userId;
                if (activeChatName) activeChatName.textContent = userName;
                if (activeChatRole) activeChatRole.textContent = userRole;
                if (chatInput) chatInput.disabled = false;
                if (document.getElementById('btn-send-message')) document.getElementById('btn-send-message').disabled = false;

                if (btnViewUserDetail) {
                    btnViewUserDetail.href = `/admin/manajemenpengguna/users?search=${encodeURIComponent(userName)}`;
                }

                // Load percakapan via AJAX
                loadConversation(userId);
            });

            // Load Percakapan via AJAX
            function loadConversation(userId) {
                if (!userId) return;

                fetch(`/admin/messages/conversation/${userId}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.success && chatContainer) {
                        let html = '';
                        if (data.messages && data.messages.length > 0) {
                            data.messages.forEach(function(msg) {
                                const isSender = msg.is_sender;
                                const avatar = isSender ? currentUserAvatar : msg.sender_avatar;

                                html += `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}">`;
                                if (!isSender) {
                                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                                }
                                html += `<div style="max-width: 75%;">
                                    <div class="chat-message py-2 px-3 ${isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border'} rounded shadow-sm text-start">`;
                                if (msg.subject && msg.subject !== 'Pesan Masuk') {
                                    html += `<strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>${msg.subject}</strong>`;
                                }
                                html += `<div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
                                if (msg.reason) {
                                    html += `<div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                        <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> ${escapeHtml(msg.reason)}
                                    </div>`;
                                }
                                html += `</div>
                                    <div class="text-muted fs-xs mt-1 ${isSender ? 'text-end' : 'text-start'}">
                                        <i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}
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

                        scrollToBottom();
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

                    if (!messageText || !receiverId) return;

                    chatInput.value = '';

                    fetch('/admin/messages/send', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId,
                            body: messageText
                        })
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data && data.success) {
                            // Append pesan baru langsung ke UI
                            appendSingleMessage(data.message);
                            scrollToBottom();

                            // Update last message pada sidebar kontak
                            const activeContactEl = document.querySelector(`#chat-contacts-list .btn-select-chat[data-user-id="${receiverId}"]`);
                            if (activeContactEl) {
                                const lastMsgEl = activeContactEl.querySelector('.contact-last-msg');
                                const lastTimeEl = activeContactEl.querySelector('.contact-last-time');
                                if (lastMsgEl) lastMsgEl.textContent = messageText;
                                if (lastTimeEl) lastTimeEl.textContent = 'Baru saja';
                            }
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

                const html = `<div class="d-flex align-items-start gap-2 my-3 chat-item text-end justify-content-end">
                    <div style="max-width: 75%;">
                        <div class="chat-message py-2 px-3 bg-primary-subtle text-dark rounded shadow-sm text-start">
                            <div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>
                        </div>
                        <div class="text-muted fs-xs mt-1 text-end">
                            <i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}
                        </div>
                    </div>
                    <img src="${msg.sender_avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
                </div>`;

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
