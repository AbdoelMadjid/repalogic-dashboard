@extends('layouts.vertical', ['title' => 'Pesan & Obrolan'])

@section('content')

    <link href="{{ asset('assets/css/admin/profil-pengguna/messages.css') }}" rel="stylesheet" type="text/css" />

    @include('layouts.partials.page-title', [
        'subtitle' => 'Komunikasi & Pesan',
        'title' => 'Pesan & Obrolan',
    ])

    <div class="outlook-box">
        <!-- LEFT SIDEBAR: LIST KONTAK & OBROLAN -->
        <div class="offcanvas-lg offcanvas-start outlook-left-menu outlook-left-menu-lg" tabindex="-1"
            id="chatSidebaroffcanvas">
            <div class="card h-100 mb-0 border-end-0 rounded-end-0">
                <div class="card-header p-3 border-light card-bg d-block">
                    <div class="d-flex gap-2">
                        <div class="app-search flex-grow-1">
                            <input type="text" id="chat-contact-search" class="form-control bg-light-subtle border-light"
                                placeholder="Cari kontak pengguna..." />
                            <i class="ti ti-search app-search-icon text-muted"></i>
                        </div>
                    </div>
                </div>
                <div id="chat-sidebar" class="card-body p-2" style="height: calc(100% - 100px)" data-simplebar
                    data-simplebar-md>
                    <div class="list-group list-group-flush chat-list" id="chat-contacts-list">
                        <div id="section-recent-contacts"
                            class="chat-section {{ $recentContacts->isEmpty() ? 'd-none' : '' }}">
                            <div
                                class="px-3 py-2 fs-11 font-monospace fw-bold text-uppercase text-muted bg-light border-bottom d-flex align-items-center justify-content-between">
                                <span><i class="ti ti-messages me-1 text-primary"></i>Percakapan Aktif</span>
                                <span class="badge bg-primary-subtle text-primary border fs-10"
                                    id="badge-recent-count">{{ $recentContacts->count() }}</span>
                            </div>
                            <div id="list-recent-contacts">
                                @foreach ($recentContacts as $c)
                                    @php
                                        $isActive = $activeUser && $activeUser->id === $c['id'];
                                    @endphp
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}"
                                        data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}"
                                        data-user-cover="{{ $c['cover_bg_url'] ?? asset('assets/images/profile-bg.jpg') }}"
                                        data-user-cover-pos="{{ $c['cover_position_y'] ?? 0 }}"
                                        data-user-motto="{{ $c['motto'] ?? '' }}"
                                        data-user-role="{{ $c['role_name'] }}"
                                        data-user-online="{{ !empty($c['is_online']) ? '1' : '0' }}"
                                        data-user-last-seen="{{ $c['last_seen_human'] ?? 'Offline' }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                                            <div class="flex-shrink-0 position-relative">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}"
                                                    class="rounded-circle object-fit-cover shadow-sm"
                                                    style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; display: block;" />
                                                <span
                                                    class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle contact-online-dot {{ !empty($c['is_online']) ? 'bg-success' : 'bg-secondary opacity-50' }}"
                                                    style="width: 11px; height: 11px; transform: translate(15%, 15%);"
                                                    title="{{ !empty($c['is_online']) ? 'Online Sekarang' : $c['last_seen_human'] ?? 'Offline' }}"></span>
                                            </div>
                                            <div class="overflow-hidden">
                                                <span data-chat-search-field
                                                    class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span
                                                    class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end ms-2">
                                            <span
                                                class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span
                                                class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div id="section-other-contacts"
                            class="chat-section {{ $otherContacts->isEmpty() ? 'd-none' : '' }} {{ $recentContacts->isNotEmpty() ? 'mt-2' : '' }}">
                            <div
                                class="px-3 py-2 fs-11 font-monospace fw-bold text-uppercase text-muted bg-light border-top border-bottom d-flex align-items-center justify-content-between">
                                <span><i class="ti ti-users me-1 text-secondary"></i>Pengguna Lainnya</span>
                                <span class="badge bg-secondary-subtle text-secondary border fs-10"
                                    id="badge-other-count">{{ $otherContacts->count() }}</span>
                            </div>
                            <div id="list-other-contacts">
                                @foreach ($otherContacts as $c)
                                    @php
                                        $isActive = $activeUser && $activeUser->id === $c['id'];
                                    @endphp
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}"
                                        data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}"
                                        data-user-cover="{{ $c['cover_bg_url'] ?? asset('assets/images/profile-bg.jpg') }}"
                                        data-user-cover-pos="{{ $c['cover_position_y'] ?? 0 }}"
                                        data-user-motto="{{ $c['motto'] ?? '' }}"
                                        data-user-role="{{ $c['role_name'] }}"
                                        data-user-online="{{ !empty($c['is_online']) ? '1' : '0' }}"
                                        data-user-last-seen="{{ $c['last_seen_human'] ?? 'Offline' }}"
                                        class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                                            <div class="flex-shrink-0 position-relative">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}"
                                                    class="rounded-circle object-fit-cover shadow-sm"
                                                    style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; display: block;" />
                                                <span
                                                    class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle contact-online-dot {{ !empty($c['is_online']) ? 'bg-success' : 'bg-secondary opacity-50' }}"
                                                    style="width: 11px; height: 11px; transform: translate(15%, 15%);"
                                                    title="{{ !empty($c['is_online']) ? 'Online Sekarang' : $c['last_seen_human'] ?? 'Offline' }}"></span>
                                            </div>
                                            <div class="overflow-hidden">
                                                <span data-chat-search-field
                                                    class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span
                                                    class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end ms-2">
                                            <span
                                                class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span
                                                class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <div id="empty-contacts-msg"
                            class="text-center py-4 px-2 text-muted fs-13 {{ $recentContacts->isNotEmpty() || $otherContacts->isNotEmpty() ? 'd-none' : '' }}">
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
                    <button class="btn btn-default btn-icon" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#chatSidebaroffcanvas" aria-controls="chatSidebaroffcanvas">
                        <i class="ti ti-menu-4 fs-lg"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center gap-3 flex-grow-1 overflow-hidden">
                    <div class="flex-shrink-0 position-relative" id="active-chat-avatar-wrapper">
                        <img id="active-chat-avatar"
                            src="{{ $activeUser ? $activeUser->avatar_url : asset('assets/images/users/default-avatar.svg') }}"
                            alt="Avatar"
                            class="rounded-circle object-fit-cover shadow-sm {{ $activeUser ? '' : 'd-none' }}"
                            style="width: 42px; height: 42px; min-width: 42px; min-height: 42px; object-fit: cover; object-position: top; display: block;" />
                        <span id="active-chat-online-dot"
                            class="position-absolute bottom-0 end-0 border border-2 border-white rounded-circle {{ $activeUser && $activeUser->is_online ? 'bg-success' : 'bg-secondary opacity-50' }} {{ $activeUser ? '' : 'd-none' }}"
                            style="width: 12px; height: 12px; transform: translate(15%, 15%);"></span>
                    </div>
                    <div class="overflow-hidden">
                        <h5 class="mb-1 lh-base fs-lg fw-bold text-truncate" id="active-chat-name">
                            {{ $activeUser ? $activeUser->name : 'Pilih Kontak' }}
                        </h5>
                        <p class="mb-0 lh-sm text-muted d-flex align-items-center gap-1 fs-12">
                            <span
                                id="active-chat-status">{{ $activeUser ? ($activeUser->is_online ? 'Online Sekarang' : $activeUser->last_seen_human) : 'Pilih pengguna untuk mulai mengobrol' }}</span>
                            <span class="badge bg-primary-subtle text-primary border ms-2 fs-11"
                                id="active-chat-role">{{ $activeUser ? $activeUser->role_name : '' }}</span>
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
                    <button type="button" id="btn-toggle-search" class="btn btn-sm btn-outline-secondary"
                        title="Cari Pesan dalam Obrolan Ini" {{ $activeUser ? '' : 'disabled' }}>
                        <i class="ti ti-search"></i>
                    </button>
                    <button type="button" id="btn-clear-chat" class="btn btn-sm btn-outline-danger"
                        title="Bersihkan Seluruh Riwayat Obrolan"
                        {{ $activeUser && $messages->isNotEmpty() ? '' : 'disabled' }}>
                        <i class="ti ti-trash me-1"></i> Bersihkan Obrolan
                    </button>
                    <button type="button" id="btn-view-user-detail" class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal" data-bs-target="#user-detail-modal" title="Lihat Profil Pengguna Ini"
                        {{ $activeUser ? '' : 'disabled' }}>
                        <i class="ti ti-user me-1"></i> Detail Akun
                    </button>
                </div>
            </div>

            <!-- IN-CHAT SEARCH BAR -->
            <div id="in-chat-search-bar" class="bg-light-subtle border-bottom px-3 py-2 d-none"
                style="transition: all 0.2s ease;">
                <div class="d-flex align-items-center gap-2">
                    <div class="input-group input-group-sm flex-grow-1">
                        <span class="input-group-text bg-white border-end-0 text-muted"><i
                                class="ti ti-search fs-14"></i></span>
                        <input type="text" id="input-search-in-chat" class="form-control border-start-0 ps-1 fs-12"
                            placeholder="Ketik kata kunci pesan...">
                        <button class="btn btn-outline-secondary border-start-0" type="button"
                            id="btn-clear-in-chat-search" style="display:none;"><i class="ti ti-x fs-12"></i></button>
                    </div>
                    <span class="fs-12 text-muted text-nowrap d-none" id="search-match-count">0 dari 0</span>
                    <button type="button" class="btn btn-sm btn-light border px-2 py-1" id="btn-search-prev"
                        title="Pesan Sebelumnya" disabled><i class="ti ti-chevron-up"></i></button>
                    <button type="button" class="btn btn-sm btn-light border px-2 py-1" id="btn-search-next"
                        title="Pesan Selanjutnya" disabled><i class="ti ti-chevron-down"></i></button>
                    <button type="button" class="btn btn-sm btn-link text-muted p-1" id="btn-close-search"
                        title="Tutup Pencarian"><i class="ti ti-x fs-16"></i></button>
                </div>
            </div>

            <!-- PINNED MESSAGE FLOATING BANNER -->
            <div id="pinned-message-banner"
                class="alert border-0 rounded-0 mb-0 py-2 px-3 d-flex align-items-center justify-content-between d-none"
                style="background-color: #f0fdf4; color: #166534; border-bottom: 1px solid #bbf7d0 !important;">
                <div class="d-flex align-items-center gap-2 overflow-hidden me-2 flex-grow-1" id="btn-jump-to-pinned"
                    role="button" title="Klik untuk melompat ke pesan yang disematkan" style="cursor: pointer;">
                    <i class="ti ti-pin-filled fs-16 flex-shrink-0 text-success"></i>
                    <div class="text-truncate fs-12">
                        <strong class="fw-semibold text-success">Pesan Disematkan:</strong> <span id="pinned-text-preview"
                            class="text-dark">...</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-link text-success p-0 text-decoration-none flex-shrink-0"
                    id="btn-unpin-banner" title="Lepas Sematan"><i class="ti ti-x fs-14"></i></button>
            </div>

            <!-- MESSAGES BUBBLE CONTAINER -->
            <div id="chat-container" class="card-body pt-2 pb-3 chat-content-bar position-relative" data-simplebar
                style="height: calc(100vh - 280px); overflow-y: auto;">
                @if ($activeUser && $messages->isNotEmpty())
                    @foreach ($messages as $msg)
                        @php
                            $isSender = $msg->sender_id === auth()->id();
                            $msgAvatar = $isSender
                                ? auth()->user()->avatar_url
                                : ($msg->sender
                                    ? $msg->sender->avatar_url
                                    : asset('assets/images/users/default-avatar.svg'));
                            $senderName = $isSender ? 'Anda' : ($msg->sender ? $msg->sender->name : 'Pengguna');
                            $reactions = is_array($msg->reactions) ? $msg->reactions : [];
                            $isPinned = (bool) $msg->is_pinned;
                            $isForwarded = (bool) $msg->is_forwarded;
                        @endphp
                        <div class="d-flex align-items-start gap-2 my-3 chat-item {{ $isSender ? 'text-end justify-content-end' : '' }}"
                            id="chat-msg-{{ $msg->id }}" data-msg-id="{{ $msg->id }}">
                            @if (!$isSender)
                                <img src="{{ $msgAvatar }}"
                                    class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent"
                                    style="width: 36px; height: 36px; object-fit: cover; object-position: top;"
                                    alt="Avatar" />
                            @endif
                            <div style="max-width: 75%;">
                                <div
                                    class="chat-message py-2 px-3 {{ $isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border' }} rounded shadow-sm text-start position-relative">
                                    @if ($isForwarded)
                                        <div class="fs-11 text-muted fst-italic mb-1 d-flex align-items-center gap-1">
                                            <i class="ti ti-arrow-forward-up fs-12 text-primary"></i> Diteruskan
                                        </div>
                                    @endif

                                    @if ($msg->parent)
                                        <div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box"
                                            data-parent-id="{{ $msg->parent_id }}" role="button"
                                            title="Klik untuk menuju pesan yang dibalas">
                                            <strong class="d-block text-primary fs-11 mb-0.5"><i
                                                    class="ti ti-corner-up-left me-1"></i>{{ $msg->parent->sender ? ($msg->parent->sender_id === auth()->id() ? 'Anda' : $msg->parent->sender->name) : 'Pesan' }}</strong>
                                            <div class="text-muted text-truncate fs-12">
                                                {{ $msg->parent->body ?: ($msg->parent->attachment_name ?: 'Lampiran berkas') }}
                                            </div>
                                        </div>
                                    @endif
                                    @if ($msg->subject && $msg->subject !== 'Pesan Masuk')
                                        <strong class="d-block text-primary fs-12 mb-1"><i
                                                class="ti ti-bell me-1"></i>{{ $msg->subject }}</strong>
                                    @endif

                                    @if ($msg->attachment_url)
                                        @php
                                            $isVoice =
                                                $msg->attachment_type === 'voice' ||
                                                in_array(
                                                    strtolower(pathinfo($msg->attachment_url, PATHINFO_EXTENSION)),
                                                    ['mp3', 'wav', 'ogg', 'webm', 'm4a', 'aac', 'flac'],
                                                );
                                            $isImg =
                                                !$isVoice &&
                                                ($msg->attachment_type === 'image' ||
                                                    in_array(
                                                        strtolower(pathinfo($msg->attachment_url, PATHINFO_EXTENSION)),
                                                        ['jpg', 'jpeg', 'png', 'webp', 'gif'],
                                                    ));
                                        @endphp
                                        <div class="my-2">
                                            @if ($isVoice)
                                                <div class="voice-player-card p-2 rounded-3 bg-white bg-opacity-75 border d-flex align-items-center gap-2 shadow-sm"
                                                    style="min-width: 220px; max-width: 280px;">
                                                    <button type="button"
                                                        class="btn btn-sm btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center btn-play-voice flex-shrink-0"
                                                        style="width: 32px; height: 32px;"
                                                        data-audio-src="{{ $msg->attachment_url }}"
                                                        title="Putar Pesan Suara">
                                                        <i class="ti ti-player-play fs-14"></i>
                                                    </button>
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center fs-xxs text-muted mb-1">
                                                            <span class="voice-current-time">0:00</span>
                                                            <span class="voice-duration">🎙️ Pesan Suara</span>
                                                        </div>
                                                        <div class="progress voice-progress rounded-pill bg-secondary-subtle"
                                                            style="height: 5px; cursor: pointer;">
                                                            <div class="progress-bar bg-primary rounded-pill"
                                                                role="progressbar" style="width: 0%"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @elseif ($isImg)
                                                <div class="chat-attachment-image">
                                                    <a href="{{ $msg->attachment_url }}"
                                                        class="d-inline-block position-relative rounded-3 overflow-hidden shadow-sm border btn-preview-img-modal"
                                                        data-img-url="{{ $msg->attachment_url }}"
                                                        data-img-name="{{ $msg->attachment_name ?: 'Gambar' }}">
                                                        <img src="{{ $msg->attachment_url }}"
                                                            alt="{{ $msg->attachment_name ?: 'Gambar' }}"
                                                            class="rounded-3"
                                                            style="width: 240px; max-width: 100%; height: 160px; object-fit: cover; cursor: pointer; display: block; transition: transform 0.2s ease;"
                                                            onmouseover="this.style.transform='scale(1.02)'"
                                                            onmouseout="this.style.transform='scale(1)'">
                                                        <div
                                                            class="position-absolute bottom-0 start-0 end-0 py-1 px-2 bg-dark bg-opacity-50 text-white d-flex align-items-center justify-content-between fs-11">
                                                            <span class="text-truncate me-2"><i
                                                                    class="ti ti-photo me-1"></i>{{ $msg->attachment_name ?: 'Gambar' }}</span>
                                                            <i class="ti ti-zoom-in fs-13"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @else
                                                <div
                                                    class="p-2 bg-white bg-opacity-75 rounded border d-flex align-items-center justify-content-between gap-2 shadow-sm fs-12">
                                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                                        <i class="ti ti-file-text fs-24 text-primary flex-shrink-0"></i>
                                                        <div class="overflow-hidden text-start">
                                                            <span class="d-block fw-semibold text-dark text-truncate"
                                                                title="{{ $msg->attachment_name ?: 'Lampiran Berkas' }}">{{ $msg->attachment_name ?: 'Berkas Unduhan' }}</span>
                                                            @if ($msg->attachment_size)
                                                                <span
                                                                    class="d-block text-muted fs-11">{{ round($msg->attachment_size / 1024, 1) }}
                                                                    KB</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="{{ $msg->attachment_url }}"
                                                        download="{{ $msg->attachment_name ?: 'berkas' }}"
                                                        target="_blank"
                                                        class="btn btn-sm btn-outline-primary px-2 py-1 flex-shrink-0"
                                                        title="Unduh Berkas">
                                                        <i class="ti ti-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if (!empty($msg->body))
                                        <div class="fs-13 lh-base text-wrap message-body-text"
                                            style="word-break: break-word;">{!! nl2br(e($msg->body)) !!}</div>
                                    @endif

                                    @if ($msg->reason)
                                        <div
                                            class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                            <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong>
                                            {{ $msg->reason }}
                                        </div>
                                    @endif
                                </div>

                                <!-- REACTIONS CONTAINER -->
                                <div class="chat-reactions-container d-flex flex-wrap gap-1 mt-1 {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}"
                                    id="chat-reactions-{{ $msg->id }}">
                                    @foreach ($reactions as $emoji => $users)
                                        @if (!empty($users))
                                            @php $hasReacted = in_array(auth()->id(), $users); @endphp
                                            <button type="button"
                                                class="btn btn-xs py-0.5 px-1.5 rounded-pill border {{ $hasReacted ? 'bg-primary-subtle text-primary border-primary' : 'bg-light text-dark border-secondary-subtle' }} btn-reaction-pill fs-xxs d-inline-flex align-items-center gap-1"
                                                data-msg-id="{{ $msg->id }}" data-emoji="{{ $emoji }}"
                                                title="{{ count($users) }} orang bereaksi {{ $emoji }}">
                                                <span>{{ $emoji }}</span>
                                                <span class="fw-semibold">{{ count($users) }}</span>
                                            </button>
                                        @endif
                                    @endforeach
                                </div>

                                <!-- MESSAGE ACTION BUTTONS -->
                                <div
                                    class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
                                    <span class="chat-status-time"><i class="ti ti-clock me-0.5"></i>
                                        {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}</span>
                                    @if ($isPinned)
                                        <span
                                            class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator"
                                            title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i>
                                            Sematan</span>
                                    @endif
                                    <button type="button"
                                        class="btn btn-link p-0 text-muted btn-react-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover"
                                        data-msg-id="{{ $msg->id }}" title="Beri Reaksi Emoji">
                                        <i class="ti ti-mood-smile"></i>
                                    </button>
                                    <button type="button"
                                        class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover"
                                        data-msg-id="{{ $msg->id }}" data-sender-name="{{ $senderName }}"
                                        data-msg-body="{{ e($msg->body ?: ($msg->attachment_name ?: 'Lampiran berkas')) }}"
                                        title="Balas Pesan Ini">
                                        <i class="ti ti-corner-up-left"></i> Balas
                                    </button>
                                    <button type="button"
                                        class="btn btn-link p-0 text-muted btn-forward-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover"
                                        data-msg-id="{{ $msg->id }}" title="Teruskan Pesan">
                                        <i class="ti ti-arrow-forward-up"></i> Teruskan
                                    </button>
                                    <button type="button"
                                        class="btn btn-link p-0 text-muted btn-pin-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover"
                                        data-msg-id="{{ $msg->id }}" data-is-pinned="{{ $isPinned ? '1' : '0' }}"
                                        title="{{ $isPinned ? 'Lepas Sematan' : 'Sematkan Pesan' }}">
                                        <i class="ti {{ $isPinned ? 'ti-pinned-off text-warning' : 'ti-pin' }}"></i>
                                        {{ $isPinned ? 'Lepas Pin' : 'Pin' }}
                                    </button>
                                    <button type="button"
                                        class="btn btn-link p-0 text-danger btn-delete-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover ms-1"
                                        data-msg-id="{{ $msg->id }}" data-is-sender="{{ $isSender ? '1' : '0' }}"
                                        title="{{ $isSender ? 'Hapus / Tarik untuk Semua Orang' : 'Hapus untuk Saya' }}">
                                        <i class="ti ti-trash"></i> Hapus
                                    </button>
                                </div>
                            </div>
                            @if ($isSender)
                                <img src="{{ $msgAvatar }}"
                                    class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender"
                                    style="width: 36px; height: 36px; object-fit: cover; object-position: top;"
                                    alt="Avatar" />
                            @endif
                        </div>
                    @endforeach
                @elseif ($activeUser)
                    <div class="text-center py-5 text-muted chat-placeholder-box" id="empty-chat-placeholder">
                        <div class="avatar-md mx-auto mb-2">
                            <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                                <i class="ti ti-messages"></i>
                            </span>
                        </div>
                        <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                        <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                    </div>
                @else
                    <div class="text-center py-5 text-muted chat-placeholder-box" id="empty-select-contact-placeholder">
                        <h6 class="fs-14 fw-semibold text-dark">Pilih Kontak Pengguna</h6>
                        <p class="fs-12 mb-0">Pilih salah satu pengguna di sebelah kiri untuk memulai pesan.</p>
                    </div>
                @endif
            </div>
            <!-- end card-body -->

            <!-- FLOATING QUICK REACTION BAR -->
            <div id="quick-reaction-popover"
                class="d-none position-absolute bg-white rounded-pill shadow-lg border px-2 py-1 d-flex align-items-center gap-1.5 z-3"
                style="transition: all 0.15s ease;">
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="👍" title="Suka">👍</button>
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="❤️" title="Hati">❤️</button>
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="😂" title="Tertawa">😂</button>
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="😮" title="Kaget">😮</button>
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="😢" title="Sedih">😢</button>
                <button type="button" class="btn btn-link p-0 border-0 fs-18 btn-quick-react text-decoration-none"
                    data-emoji="🙏" title="Terima Kasih">🙏</button>
            </div>

            <!-- FOOTER: INPUT PESAN & TOMBOL KIRIM -->
            <div class="card-footer bg-body-secondary border-top border-dashed py-2.5 position-relative">
                <!-- EMOJI PICKER POPOVER -->
                <div id="emoji-picker-container"
                    class="d-none position-absolute bg-white rounded-3 shadow-lg border p-2.5"
                    style="bottom: 75px; right: 15px; width: 340px; max-width: calc(100vw - 30px); z-index: 1060; transition: all 0.2s ease-in-out;">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
                        <div class="d-flex align-items-center gap-1.5">
                            <i class="ti ti-mood-smile text-primary fs-16"></i>
                            <span class="fw-bold fs-13 text-dark">Sisipkan Emoji</span>
                        </div>
                        <button type="button" class="btn-close fs-10" id="btn-close-emoji" aria-label="Tutup"></button>
                    </div>

                    <!-- Quick Popular Reaction Bar -->
                    <div
                        class="d-flex align-items-center gap-1 justify-content-between mb-2 px-1.5 py-1 bg-light rounded border">
                        <span class="fs-11 text-muted fw-semibold ps-1">Cepat:</span>
                        <div class="d-flex gap-1 overflow-x-auto">
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="👍"
                                title="Jempol">👍</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="❤️"
                                title="Hati">❤️</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="😂"
                                title="Tertawa">😂</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🔥"
                                title="Api Semangat">🔥</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🎉"
                                title="Perayaan">🎉</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🙏"
                                title="Terima Kasih">🙏</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="😊"
                                title="Senyum">😊</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="👏"
                                title="Tepuk Tangan">👏</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🚀"
                                title="Roket">🚀</button>
                        </div>
                    </div>

                    <!-- Category Tabs -->
                    <div class="nav nav-pills nav-justified emoji-tabs mb-2 gap-1 bg-light p-1 rounded"
                        id="emoji-category-tabs">
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 active btn-emoji-cat"
                            data-category="smileys" title="Senyum & Emosi">😀</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="gestures"
                            title="Gestur & Tangan">👍</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="hearts"
                            title="Hati & Cinta">❤️</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="objects"
                            title="Objek & Simbol">🎉</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat"
                            data-category="activities" title="Aktivitas & Lainnya">☕</button>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 py-0 text-muted"><i
                                    class="ti ti-search fs-12"></i></span>
                            <input type="text" id="emoji-search-input" class="form-control border-start-0 py-1 fs-12"
                                placeholder="Cari emoji (misal: senang, api, love)..." autocomplete="off">
                        </div>
                    </div>

                    <!-- Emoji Grid Container -->
                    <div id="emoji-grid-container" class="emoji-grid"
                        style="max-height: 180px; overflow-y: auto; display: grid; grid-template-columns: repeat(8, 1fr); gap: 2px; padding: 2px;">
                        <!-- Rendered dynamically via JS -->
                    </div>
                </div>

                <form id="form-send-chat" action="javascript:void(0);" enctype="multipart/form-data">
                    <input type="hidden" id="active-receiver-id" value="{{ $activeUser ? $activeUser->id : '' }}">
                    <input type="hidden" id="reply-parent-id" name="parent_id" value="">

                    <!-- PREVIEW BOX BALASAN PESAN -->
                    <div id="reply-preview-container"
                        class="d-none bg-white p-2.5 mb-2 rounded border-start border-3 border-primary shadow-sm position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="fs-12 fw-bold text-primary d-flex align-items-center gap-1">
                                <i class="ti ti-corner-up-left fs-14"></i> Membalas ke <span id="reply-preview-name"
                                    class="fw-semibold text-dark"></span>
                            </span>
                            <button type="button" class="btn-close fs-10" id="btn-cancel-reply"
                                aria-label="Batal Balas"></button>
                        </div>
                        <div class="fs-12 text-muted text-truncate ps-1" id="reply-preview-body"></div>
                    </div>

                    <!-- PREVIEW BOX LAMPIRAN BERKAS / GAMBAR -->
                    <div id="attachment-preview-container"
                        class="d-none bg-white p-2 mb-2 rounded border-start border-3 border-info shadow-sm position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <div id="attachment-thumb-wrapper"
                                    class="flex-shrink-0 rounded bg-light border d-flex align-items-center justify-content-center"
                                    style="width: 42px; height: 42px; overflow: hidden;">
                                    <img id="attachment-preview-img" src=""
                                        class="d-none w-100 h-100 object-fit-cover" alt="Preview">
                                    <i id="attachment-preview-icon" class="ti ti-file fs-20 text-info"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark fs-12 text-truncate" id="attachment-preview-name">
                                        berkas.pdf</div>
                                    <div class="text-muted fs-11" id="attachment-preview-size">0 KB</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close fs-10" id="btn-cancel-attachment"
                                aria-label="Batal Lampiran"></button>
                        </div>
                    </div>

                    <!-- VOICE RECORDING BAR -->
                    <div id="voice-recording-container"
                        class="d-none align-items-center justify-content-between flex-grow-1 bg-danger-subtle px-3 py-1.5 mb-1 rounded-pill border border-danger-subtle">
                        <div class="d-flex align-items-center gap-2">
                            <span class="spinner-grow spinner-grow-sm text-danger" role="status"
                                style="width: 10px; height: 10px;"></span>
                            <span id="voice-recording-timer" class="fs-13 fw-bold text-danger font-monospace">00:00</span>
                            <span class="fs-12 text-danger ms-1">Merekam suara...</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" id="btn-cancel-voice"
                                class="btn btn-sm btn-link text-danger p-0 text-decoration-none fs-12"
                                title="Batal Rekam">
                                <i class="ti ti-trash me-0.5"></i> Batal
                            </button>
                            <button type="button" id="btn-send-voice"
                                class="btn btn-sm btn-danger rounded-circle p-1 d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 32px; height: 32px;" title="Kirim Pesan Suara">
                                <i class="ti ti-send fs-14"></i>
                            </button>
                        </div>
                    </div>

                    <!-- NORMAL INPUT CONTAINER -->
                    <div class="d-flex gap-2 align-items-center position-relative" id="chat-input-row">
                        <div class="position-relative flex-grow-1 d-flex align-items-center">
                            <div class="app-search flex-grow-1 position-relative">
                                <input type="text" id="chat-message-input"
                                    class="form-control py-2 bg-light-subtle border-light"
                                    style="padding-right: 105px !important;" placeholder="Ketik pesan Anda di sini..."
                                    autocomplete="off" {{ $activeUser ? '' : 'disabled' }} />
                                <i class="ti ti-message app-search-icon text-muted"></i>
                            </div>
                            <div class="position-absolute end-0 me-2 d-flex align-items-center gap-1 z-2">
                                <!-- Tombol Rekam Suara (Voice Note) -->
                                <button type="button" id="btn-record-voice"
                                    class="btn btn-sm btn-icon text-muted hover-text-danger"
                                    style="background: transparent; border: none; cursor: pointer; padding: 2px;"
                                    title="Rekam Pesan Suara (Voice Note)" {{ $activeUser ? '' : 'disabled' }}>
                                    <i class="ti ti-microphone fs-18 text-danger"></i>
                                </button>
                                <!-- Tombol Lampirkan Berkas/Gambar -->
                                <input type="file" id="chat-file-input" class="d-none"
                                    accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt,audio/*">
                                <button type="button" id="btn-attach-file"
                                    class="btn btn-sm btn-icon text-muted hover-text-primary"
                                    style="background: transparent; border: none; cursor: pointer; padding: 2px;"
                                    title="Kirim Gambar / Lampiran Berkas" {{ $activeUser ? '' : 'disabled' }}>
                                    <i class="ti ti-paperclip fs-18"></i>
                                </button>
                                <!-- Tombol Emoji -->
                                <button type="button" id="btn-toggle-emoji"
                                    class="btn btn-sm btn-icon text-muted hover-text-primary"
                                    style="background: transparent; border: none; cursor: pointer; padding: 2px;"
                                    title="Sisipkan Emoji / Emoticon" {{ $activeUser ? '' : 'disabled' }}>
                                    <i class="ti ti-mood-smile fs-18"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" id="btn-send-message"
                            class="btn btn-primary px-3 fw-semibold flex-shrink-0" {{ $activeUser ? '' : 'disabled' }}>
                            Kirim <i class="ti ti-send ms-1 fs-14"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- end card-->
    </div>

    <!-- MODAL DETAIL AKUN PENGGUNA -->
    <div class="modal fade" id="user-detail-modal" tabindex="-1" aria-labelledby="userDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden">
                <!-- TOP COVER BANNER WITH FOTO SAMPUL PENGGUNA -->
                <div id="modal-user-cover" class="position-relative overflow-hidden user-detail-cover"
                    style="height: 140px; background-image: url('{{ $activeUser ? $activeUser->cover_bg_url : asset('assets/images/profile-bg.jpg') }}'); background-size: cover; background-position: center {{ $activeUser ? $activeUser->cover_position_y : 0 }}%;">
                    <div class="position-absolute top-0 start-0 end-0 bottom-0 d-flex justify-content-between align-items-start p-3 user-detail-cover-overlay"
                        style="background: linear-gradient(180deg, rgba(15,23,42,0.7) 0%, rgba(15,23,42,0.2) 60%, rgba(15,23,42,0.8) 100%);">
                        <div class="d-flex align-items-center gap-1.5 text-white">
                            <i class="ti ti-id fs-18"></i>
                            <span class="fs-14 fw-semibold text-white">Detail Profil Pengguna</span>
                        </div>
                        <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>

                <div class="modal-body px-4 pt-0 pb-4 text-center">
                    <!-- AVATAR OVERLAPPING COVER BANNER -->
                    <div class="mb-3 position-relative d-inline-block" style="margin-top: -48px;">
                        <img id="modal-user-avatar"
                            src="{{ $activeUser ? $activeUser->avatar_url : asset('assets/images/users/default-avatar.svg') }}"
                            class="rounded-circle border border-3 border-white shadow"
                            style="width: 96px; height: 96px; min-width: 96px; min-height: 96px; object-fit: cover; object-position: top; background-color: #fff;"
                            alt="Avatar Pengguna">
                    </div>
                    <h5 class="fw-bold mb-1 text-dark fs-16" id="modal-user-name">
                        {{ $activeUser ? $activeUser->name : '-' }}</h5>
                    <p class="text-muted fs-13 mb-2" id="modal-user-email">{{ $activeUser ? $activeUser->email : '-' }}
                    </p>

                    <p class="text-muted fst-italic fs-12 px-3 mb-3 text-truncate" id="modal-user-motto" title="{{ $activeUser ? $activeUser->motto : '' }}">
                        "{{ $activeUser ? $activeUser->motto : 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.' }}"
                    </p>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <span class="badge bg-primary-subtle text-primary border px-3 py-1.5 fs-12" id="modal-user-role">
                            <i class="ti ti-shield-check me-1"></i>{{ $activeUser ? $activeUser->role_name : '-' }}
                        </span>
                        <span class="badge bg-success-subtle text-success border px-3 py-1.5 fs-12"
                            id="modal-user-status">
                            <i
                                class="ti ti-circle-check me-1"></i>{{ $activeUser ? ucfirst($activeUser->status) : 'Aktif' }}
                        </span>
                    </div>

                    <div class="bg-light p-3 rounded border text-start fs-13">
                        <div class="row g-2">
                            <div class="col-5 text-muted"><i class="ti ti-mail me-1"></i> Alamat Email:</div>
                            <div class="col-7 fw-semibold text-dark text-truncate" id="modal-info-email">
                                {{ $activeUser ? $activeUser->email : '-' }}</div>

                            <div class="col-5 text-muted"><i class="ti ti-brand-whatsapp me-1 text-success"></i> Telepon / WA:</div>
                            <div class="col-7 fw-semibold text-dark text-truncate" id="modal-info-telepon">
                                @if ($activeUser && !empty($activeUser->detail?->telepon))
                                    <a href="{{ $activeUser->detail->telepon_wa_url }}" target="_blank" class="text-success text-decoration-none">
                                        {{ $activeUser->detail->telepon }} <i class="ti ti-external-link fs-11 ms-0.5"></i>
                                    </a>
                                @else
                                    <span class="text-muted fst-italic fw-normal">-</span>
                                @endif
                            </div>

                            <div class="col-5 text-muted"><i class="ti ti-shield me-1"></i> Peran Akun:</div>
                            <div class="col-7 fw-semibold text-dark" id="modal-info-role">
                                {{ $activeUser ? $activeUser->role_name : '-' }}</div>

                            <div class="col-5 text-muted"><i class="ti ti-calendar me-1"></i> Terdaftar Sejak:</div>
                            <div class="col-7 fw-semibold text-dark" id="modal-info-joined">
                                {{ $activeUser && $activeUser->created_at ? $activeUser->created_at->format('d M Y') : '-' }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 justify-content-end">
                    <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL TERUSKAN PESAN (FORWARD MODAL) -->
    <div class="modal fade" id="forward-message-modal" tabindex="-1" aria-labelledby="forwardMessageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white py-2.5 px-3">
                    <h6 class="modal-title fs-14 fw-semibold text-white mb-0" id="forwardMessageModalLabel">
                        <i class="ti ti-arrow-forward-up me-1"></i> Teruskan Pesan
                    </h6>
                    <button type="button" class="btn-close btn-close-white btn-sm" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-3">
                    <div class="mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0"><i
                                    class="ti ti-search fs-12 text-muted"></i></span>
                            <input type="text" id="forward-contact-search"
                                class="form-control border-start-0 ps-1 fs-12" placeholder="Cari kontak pengguna...">
                        </div>
                    </div>
                    <div class="list-group list-group-flush border rounded-2 overflow-y-auto" id="forward-contact-list"
                        style="max-height: 240px;">
                        <!-- Rendered dynamically via JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL LIGHTBOX PRATINJAU GAMBAR CHAT -->
    <div class="modal fade" id="chat-image-modal" tabindex="-1" aria-labelledby="chatImageModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
            <div class="modal-content border-0 shadow-lg bg-dark rounded-3 overflow-hidden">
                <div
                    class="modal-header border-bottom border-secondary border-opacity-25 py-2.5 px-3 d-flex justify-content-between align-items-center bg-dark text-white">
                    <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                        <i class="ti ti-photo text-primary fs-16 flex-shrink-0"></i>
                        <span class="modal-title text-white fs-13 text-truncate fw-semibold"
                            id="chatImageModalLabel">Pratinjau Gambar</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <a href="#" id="modal-download-image" download
                            class="btn btn-sm btn-primary px-3 py-1 text-white shadow-sm"
                            title="Unduh Gambar Ukuran Asli">
                            <i class="ti ti-download me-1"></i> Unduh Asli
                        </a>
                        <button type="button" class="btn-close btn-close-white fs-12" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body py-5 px-4 text-center d-flex flex-column align-items-center justify-content-center"
                    style="background-color: #0f172a; min-height: 380px;">
                    <div class="position-relative d-inline-block shadow-lg rounded-3 overflow-hidden border border-secondary border-opacity-25 my-auto"
                        style="max-width: 480px; width: 100%; max-height: 440px; background: #1e293b;">
                        <img id="modal-preview-full-img" src="" class="img-fluid d-block mx-auto rounded-3"
                            style="max-height: 420px; width: auto; max-width: 100%; object-fit: contain;"
                            alt="Pratinjau Gambar">
                    </div>
                    <div class="mt-3 text-white-50 fs-11 d-flex align-items-center gap-1">
                        <i class="ti ti-info-circle fs-13 text-info"></i> Pratinjau tampilan standar. Klik <strong
                            class="text-white">Unduh Asli</strong> untuk resolusi penuh.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rules 1 Compliance: Placement of script inside @section('content') before @endsection --}}
    <script>
        window.MessagesConfig = {
            currentUserId: {{ auth()->id() }},
            currentUserAvatar: "{{ auth()->user()->avatar_url }}",
            defaultAvatar: "{{ asset('assets/images/users/default-avatar.svg') }}",
            defaultCover: "{{ asset('assets/images/profile-bg.jpg') }}",
            initialMessageCount: {{ $messages->count() }},
            initialLastMessageId: {{ $messages->isNotEmpty() ? $messages->last()->id : 'null' }}
        };
    </script>
    <script src="{{ asset('assets/js/admin/profil-pengguna/messages.js') }}"></script>
@endsection
