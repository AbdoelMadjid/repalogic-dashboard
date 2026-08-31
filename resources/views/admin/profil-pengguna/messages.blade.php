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
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}" data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}" data-user-role="{{ $c['role_name'] }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; display: block;" />
                                            </div>
                                            <div class="overflow-hidden">
                                                <span data-chat-search-field class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end ms-2">
                                            <span class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </div>
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
                                    <a href="javascript:void(0);" data-user-id="{{ $c['id'] }}" data-user-name="{{ $c['name'] }}" data-user-avatar="{{ $c['avatar'] }}" data-user-role="{{ $c['role_name'] }}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2.5 px-3 btn-select-chat {{ $isActive ? 'active' : '' }}">
                                        <div class="d-flex align-items-center gap-3 overflow-hidden flex-grow-1">
                                            <div class="flex-shrink-0">
                                                <img src="{{ $c['avatar'] }}" alt="{{ $c['name'] }}" class="rounded-circle object-fit-cover shadow-sm" style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; display: block;" />
                                            </div>
                                            <div class="overflow-hidden">
                                                <span data-chat-search-field class="text-nowrap fw-semibold fs-base mb-0 lh-base text-dark d-block">{{ $c['name'] }}</span>
                                                <span class="text-muted d-block fs-xs mb-0 text-truncate contact-last-msg">{{ $c['last_message'] }}</span>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-column gap-1 justify-content-center flex-shrink-0 align-items-end ms-2">
                                            <span class="text-muted fs-xs contact-last-time">{{ $c['last_message_time'] }}</span>
                                            <span class="badge text-bg-success fs-xxs contact-unread-badge {{ $c['unread_count'] > 0 ? '' : 'd-none' }}">{{ $c['unread_count'] }}</span>
                                        </div>
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

                <div class="d-flex align-items-center gap-3 flex-grow-1 overflow-hidden">
                    <div class="flex-shrink-0" id="active-chat-avatar-wrapper">
                        <img id="active-chat-avatar" src="{{ $activeUser ? $activeUser->avatar_url : asset('assets/images/users/default-avatar.svg') }}" alt="Avatar" class="rounded-circle object-fit-cover shadow-sm {{ $activeUser ? '' : 'd-none' }}" style="width: 42px; height: 42px; min-width: 42px; min-height: 42px; object-fit: cover; object-position: top; display: block;" />
                    </div>
                    <div class="overflow-hidden">
                        <h5 class="mb-1 lh-base fs-lg fw-bold text-truncate" id="active-chat-name">
                            {{ $activeUser ? $activeUser->name : 'Pilih Kontak' }}
                        </h5>
                        <p class="mb-0 lh-sm text-muted d-flex align-items-center gap-1 fs-12">
                            <i class="ti ti-circle-filled text-success fs-10"></i>
                            <span id="active-chat-status">Aktif &amp; Terhubung</span>
                            <span class="badge bg-primary-subtle text-primary border ms-2 fs-11" id="active-chat-role">{{ $activeUser ? $activeUser->role_name : '' }}</span>
                        </p>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-shrink-0">
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
                        <div class="d-flex align-items-start gap-2 my-3 chat-item {{ $isSender ? 'text-end justify-content-end' : '' }}" id="chat-msg-{{ $msg->id }}" data-msg-id="{{ $msg->id }}">
                            @if (!$isSender)
                                <img src="{{ $msgAvatar }}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
                            @endif
                            <div style="max-width: 75%;">
                                <div class="chat-message py-2 px-3 {{ $isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border' }} rounded shadow-sm text-start">
                                    @if ($msg->parent)
                                        <div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box" data-parent-id="{{ $msg->parent_id }}" role="button" title="Klik untuk menuju pesan yang dibalas">
                                            <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>{{ $msg->parent->sender ? ($msg->parent->sender_id === auth()->id() ? 'Anda' : $msg->parent->sender->name) : 'Pesan' }}</strong>
                                            <div class="text-muted text-truncate fs-12">{{ $msg->parent->body ?: ($msg->parent->attachment_name ?: 'Lampiran berkas') }}</div>
                                        </div>
                                    @endif
                                    @if ($msg->subject && $msg->subject !== 'Pesan Masuk')
                                        <strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>{{ $msg->subject }}</strong>
                                    @endif

                                    @if ($msg->attachment_url)
                                        @php
                                            $isImg = $msg->attachment_type === 'image' || in_array(strtolower(pathinfo($msg->attachment_url, PATHINFO_EXTENSION)), ['jpg','jpeg','png','webp','gif']);
                                        @endphp
                                        <div class="my-2">
                                            @if ($isImg)
                                                <div class="chat-attachment-image">
                                                    <a href="{{ $msg->attachment_url }}" class="d-inline-block position-relative rounded-3 overflow-hidden shadow-sm border btn-preview-img-modal" data-img-url="{{ $msg->attachment_url }}" data-img-name="{{ $msg->attachment_name ?: 'Gambar' }}">
                                                        <img src="{{ $msg->attachment_url }}" alt="{{ $msg->attachment_name ?: 'Gambar' }}" class="rounded-3" style="width: 240px; max-width: 100%; height: 160px; object-fit: cover; cursor: pointer; display: block; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                                                        <div class="position-absolute bottom-0 start-0 end-0 py-1 px-2 bg-dark bg-opacity-50 text-white d-flex align-items-center justify-content-between fs-11">
                                                            <span class="text-truncate me-2"><i class="ti ti-photo me-1"></i>{{ $msg->attachment_name ?: 'Gambar' }}</span>
                                                            <i class="ti ti-zoom-in fs-13"></i>
                                                        </div>
                                                    </a>
                                                </div>
                                            @else
                                                <div class="p-2 bg-white bg-opacity-75 rounded border d-flex align-items-center justify-content-between gap-2 shadow-sm fs-12">
                                                    <div class="d-flex align-items-center gap-2 overflow-hidden">
                                                        <i class="ti ti-file-text fs-24 text-primary flex-shrink-0"></i>
                                                        <div class="overflow-hidden text-start">
                                                            <span class="d-block fw-semibold text-dark text-truncate" title="{{ $msg->attachment_name ?: 'Lampiran Berkas' }}">{{ $msg->attachment_name ?: 'Berkas Unduhan' }}</span>
                                                            @if ($msg->attachment_size)
                                                                <span class="d-block text-muted fs-11">{{ round($msg->attachment_size / 1024, 1) }} KB</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <a href="{{ $msg->attachment_url }}" download="{{ $msg->attachment_name ?: 'berkas' }}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1 flex-shrink-0" title="Unduh Berkas">
                                                        <i class="ti ti-download"></i>
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endif

                                    @if (!empty($msg->body))
                                        <div class="fs-13 lh-base text-wrap" style="word-break: break-word;">{!! nl2br(e($msg->body)) !!}</div>
                                    @endif

                                    @if ($msg->reason)
                                        <div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                            <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> {{ $msg->reason }}
                                        </div>
                                    @endif
                                </div>
                                <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 {{ $isSender ? 'justify-content-end' : 'justify-content-start' }}">
                                    <span><i class="ti ti-clock me-0.5"></i> {{ $msg->created_at ? $msg->created_at->format('H:i') : '' }}</span>
                                    <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="{{ $msg->id }}" data-sender-name="{{ $senderName }}" data-msg-body="{{ e($msg->body ?: ($msg->attachment_name ?: 'Lampiran berkas')) }}" title="Balas Pesan Ini">
                                        <i class="ti ti-corner-up-left"></i> Balas
                                    </button>
                                </div>
                            </div>
                            @if ($isSender)
                                <img src="{{ $msgAvatar }}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />
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
            <div class="card-footer bg-body-secondary border-top border-dashed py-2.5 position-relative">
                <!-- EMOJI PICKER POPOVER -->
                <div id="emoji-picker-container" class="d-none position-absolute bg-white rounded-3 shadow-lg border p-2.5" style="bottom: 75px; right: 15px; width: 340px; max-width: calc(100vw - 30px); z-index: 1060; transition: all 0.2s ease-in-out;">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-2 mb-2">
                        <div class="d-flex align-items-center gap-1.5">
                            <i class="ti ti-mood-smile text-primary fs-16"></i>
                            <span class="fw-bold fs-13 text-dark">Sisipkan Emoji</span>
                        </div>
                        <button type="button" class="btn-close fs-10" id="btn-close-emoji" aria-label="Tutup"></button>
                    </div>

                    <!-- Quick Popular Reaction Bar -->
                    <div class="d-flex align-items-center gap-1 justify-content-between mb-2 px-1.5 py-1 bg-light rounded border">
                        <span class="fs-11 text-muted fw-semibold ps-1">Cepat:</span>
                        <div class="d-flex gap-1 overflow-x-auto">
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="👍" title="Jempol">👍</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="❤️" title="Hati">❤️</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="😂" title="Tertawa">😂</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🔥" title="Api Semangat">🔥</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🎉" title="Perayaan">🎉</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🙏" title="Terima Kasih">🙏</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="😊" title="Senyum">😊</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="👏" title="Tepuk Tangan">👏</button>
                            <button type="button" class="btn btn-sm p-0 border-0 fs-16 btn-insert-emoji" data-emoji="🚀" title="Roket">🚀</button>
                        </div>
                    </div>

                    <!-- Category Tabs -->
                    <div class="nav nav-pills nav-justified emoji-tabs mb-2 gap-1 bg-light p-1 rounded" id="emoji-category-tabs">
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 active btn-emoji-cat" data-category="smileys" title="Senyum & Emosi">😀</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="gestures" title="Gestur & Tangan">👍</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="hearts" title="Hati & Cinta">❤️</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="objects" title="Objek & Simbol">🎉</button>
                        <button type="button" class="nav-link py-1 px-1.5 fs-14 btn-emoji-cat" data-category="activities" title="Aktivitas & Lainnya">☕</button>
                    </div>

                    <!-- Search Input -->
                    <div class="mb-2">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white border-end-0 py-0 text-muted"><i class="ti ti-search fs-12"></i></span>
                            <input type="text" id="emoji-search-input" class="form-control border-start-0 py-1 fs-12" placeholder="Cari emoji (misal: senang, api, love)..." autocomplete="off">
                        </div>
                    </div>

                    <!-- Emoji Grid Container -->
                    <div id="emoji-grid-container" class="emoji-grid" style="max-height: 180px; overflow-y: auto; display: grid; grid-template-columns: repeat(8, 1fr); gap: 2px; padding: 2px;">
                        <!-- Rendered dynamically via JS -->
                    </div>
                </div>

                <form id="form-send-chat" action="javascript:void(0);" enctype="multipart/form-data">
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

                    <!-- PREVIEW BOX LAMPIRAN BERKAS / GAMBAR -->
                    <div id="attachment-preview-container" class="d-none bg-white p-2 mb-2 rounded border-start border-3 border-info shadow-sm position-relative">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2 overflow-hidden">
                                <div id="attachment-thumb-wrapper" class="flex-shrink-0 rounded bg-light border d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; overflow: hidden;">
                                    <img id="attachment-preview-img" src="" class="d-none w-100 h-100 object-fit-cover" alt="Preview">
                                    <i id="attachment-preview-icon" class="ti ti-file fs-20 text-info"></i>
                                </div>
                                <div class="overflow-hidden">
                                    <div class="fw-semibold text-dark fs-12 text-truncate" id="attachment-preview-name">berkas.pdf</div>
                                    <div class="text-muted fs-11" id="attachment-preview-size">0 KB</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close fs-10" id="btn-cancel-attachment" aria-label="Batal Lampiran"></button>
                        </div>
                    </div>

                    <div class="d-flex gap-2 align-items-center position-relative">
                        <div class="position-relative flex-grow-1 d-flex align-items-center">
                            <div class="app-search flex-grow-1 position-relative">
                                <input type="text" id="chat-message-input" class="form-control py-2 bg-light-subtle border-light" style="padding-right: 76px !important;" placeholder="Ketik pesan Anda di sini..." autocomplete="off" {{ $activeUser ? '' : 'disabled' }} />
                                <i class="ti ti-message app-search-icon text-muted"></i>
                            </div>
                            <div class="position-absolute end-0 me-2 d-flex align-items-center gap-1 z-2">
                                <!-- Tombol Lampirkan Berkas/Gambar -->
                                <input type="file" id="chat-file-input" class="d-none" accept="image/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar,.txt">
                                <button type="button" id="btn-attach-file" class="btn btn-sm btn-icon text-muted hover-text-primary" style="background: transparent; border: none; cursor: pointer; padding: 2px;" title="Kirim Gambar / Lampiran Berkas" {{ $activeUser ? '' : 'disabled' }}>
                                    <i class="ti ti-paperclip fs-18"></i>
                                </button>
                                <!-- Tombol Emoji -->
                                <button type="button" id="btn-toggle-emoji" class="btn btn-sm btn-icon text-muted hover-text-primary" style="background: transparent; border: none; cursor: pointer; padding: 2px;" title="Sisipkan Emoji / Emoticon" {{ $activeUser ? '' : 'disabled' }}>
                                    <i class="ti ti-mood-smile fs-18"></i>
                                </button>
                            </div>
                        </div>
                        <button type="submit" id="btn-send-message" class="btn btn-primary px-3 fw-semibold flex-shrink-0" {{ $activeUser ? '' : 'disabled' }}>
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

    <!-- MODAL LIGHTBOX PRATINJAU GAMBAR CHAT -->
    <div class="modal fade" id="chat-image-modal" tabindex="-1" aria-labelledby="chatImageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 580px;">
            <div class="modal-content border-0 shadow-lg bg-dark rounded-3 overflow-hidden">
                <div class="modal-header border-bottom border-secondary border-opacity-25 py-2.5 px-3 d-flex justify-content-between align-items-center bg-dark text-white">
                    <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                        <i class="ti ti-photo text-primary fs-16 flex-shrink-0"></i>
                        <span class="modal-title text-white fs-13 text-truncate fw-semibold" id="chatImageModalLabel">Pratinjau Gambar</span>
                    </div>
                    <div class="d-flex align-items-center gap-2 flex-shrink-0">
                        <a href="#" id="modal-download-image" download class="btn btn-sm btn-primary px-3 py-1 text-white shadow-sm" title="Unduh Gambar Ukuran Asli">
                            <i class="ti ti-download me-1"></i> Unduh Asli
                        </a>
                        <button type="button" class="btn-close btn-close-white fs-12" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body py-5 px-4 text-center d-flex flex-column align-items-center justify-content-center" style="background-color: #0f172a; min-height: 380px;">
                    <div class="position-relative d-inline-block shadow-lg rounded-3 overflow-hidden border border-secondary border-opacity-25 my-auto" style="max-width: 480px; width: 100%; max-height: 440px; background: #1e293b;">
                        <img id="modal-preview-full-img" src="" class="img-fluid d-block mx-auto rounded-3" style="max-height: 420px; width: auto; max-width: 100%; object-fit: contain;" alt="Pratinjau Gambar">
                    </div>
                    <div class="mt-3 text-white-50 fs-11 d-flex align-items-center gap-1">
                        <i class="ti ti-info-circle fs-13 text-info"></i> Pratinjau tampilan standar. Klik <strong class="text-white">Unduh Asli</strong> untuk resolusi penuh.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Rules 1 Compliance: Placement of script inside @section('content') before @endsection --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentUserId = {{ auth()->id() }};
            let currentUserAvatar = "{{ auth()->user()->avatar_url }}";

            const chatContainer = document.getElementById('chat-container');
            const chatForm = document.getElementById('form-send-chat');
            const chatInput = document.getElementById('chat-message-input');
            const activeReceiverInput = document.getElementById('active-receiver-id');
            const activeChatName = document.getElementById('active-chat-name');
            const activeChatRole = document.getElementById('active-chat-role');
            const activeChatAvatar = document.getElementById('active-chat-avatar');
            const btnViewUserDetail = document.getElementById('btn-view-user-detail');
            const contactSearchInput = document.getElementById('chat-contact-search');

            let activeUserId = activeReceiverInput ? activeReceiverInput.value : '';
            let lastMessageCount = {{ $messages->count() }};
            let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 'null' }};
            let userHasScrolledUp = false;

            // ==========================================
            // HELPER FUNCTIONS (UTILITIES & DOM)
            // ==========================================
            function escapeHtml(text) {
                if (text === null || typeof text === 'undefined') return '';
                return String(text)
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            function formatBytes(bytes) {
                if (!bytes || bytes === 0) return '0 B';
                const b = parseInt(bytes, 10);
                if (b >= 1048576) {
                    return (b / 1048576).toFixed(1) + ' MB';
                } else if (b >= 1024) {
                    return (b / 1024).toFixed(1) + ' KB';
                }
                return b + ' B';
            }

            function setChatContainerHtml(html) {
                if (!chatContainer) return;
                const sbContent = chatContainer.querySelector('.simplebar-content');
                if (sbContent) {
                    sbContent.innerHTML = html;
                } else {
                    chatContainer.innerHTML = html;
                }
            }

            function appendChatContainerHtml(html) {
                if (!chatContainer) return;
                const sbContent = chatContainer.querySelector('.simplebar-content');
                if (sbContent) {
                    sbContent.insertAdjacentHTML('beforeend', html);
                } else {
                    chatContainer.insertAdjacentHTML('beforeend', html);
                }
            }

            function getChatScrollElement() {
                if (!chatContainer) return null;
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

            function renderAttachmentHtml(msg) {
                if (!msg.attachment_url) return '';
                const isImg = msg.attachment_type === 'image' || (msg.attachment_url && /\.(jpg|jpeg|png|webp|gif)$/i.test(msg.attachment_url));
                const name = escapeHtml(msg.attachment_name || 'Lampiran Berkas');
                const sizeStr = msg.attachment_size_formatted || (msg.attachment_size ? formatBytes(msg.attachment_size) : '');

                if (isImg) {
                    return `<div class="chat-attachment-image my-2">
                        <a href="${msg.attachment_url}" class="d-inline-block position-relative rounded-3 overflow-hidden shadow-sm border btn-preview-img-modal" data-img-url="${msg.attachment_url}" data-img-name="${name}">
                            <img src="${msg.attachment_url}" alt="${name}" class="rounded-3" style="width: 240px; max-width: 100%; height: 160px; object-fit: cover; cursor: pointer; display: block; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                            <div class="position-absolute bottom-0 start-0 end-0 py-1 px-2 bg-dark bg-opacity-50 text-white d-flex align-items-center justify-content-between fs-11">
                                <span class="text-truncate me-2"><i class="ti ti-photo me-1"></i>${name}</span>
                                <i class="ti ti-zoom-in fs-13"></i>
                            </div>
                        </a>
                    </div>`;
                } else {
                    return `<div class="mt-1 mb-2 p-2 bg-white bg-opacity-75 rounded border d-flex align-items-center justify-content-between gap-2 shadow-sm fs-12">
                        <div class="d-flex align-items-center gap-2 overflow-hidden">
                            <i class="ti ti-file-text fs-24 text-primary flex-shrink-0"></i>
                            <div class="overflow-hidden text-start">
                                <span class="d-block fw-semibold text-dark text-truncate" title="${name}">${name}</span>
                                ${sizeStr ? `<span class="d-block text-muted fs-11">${sizeStr}</span>` : ''}
                            </div>
                        </div>
                        <a href="${msg.attachment_url}" download="${name}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1 flex-shrink-0" title="Unduh Berkas">
                            <i class="ti ti-download"></i>
                        </a>
                    </div>`;
                }
            }

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

                // Mark active contact item instantly
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

                // Update Header seketika (Instant 0ms Feedback)
                if (activeReceiverInput) activeReceiverInput.value = userId;
                if (activeChatName) activeChatName.textContent = userName;
                if (activeChatRole) activeChatRole.textContent = userRole;
                if (activeChatAvatar) {
                    activeChatAvatar.src = userAvatar || "{{ asset('assets/images/users/default-avatar.svg') }}";
                    activeChatAvatar.classList.remove('d-none');
                }

                // Aktifkan input chat langsung tanpa jeda
                if (chatInput) {
                    chatInput.disabled = false;
                    chatInput.focus();
                }
                if (document.getElementById('btn-send-message')) document.getElementById('btn-send-message').disabled = false;
                if (document.getElementById('btn-toggle-emoji')) document.getElementById('btn-toggle-emoji').disabled = false;
                if (document.getElementById('btn-attach-file')) document.getElementById('btn-attach-file').disabled = false;
                if (btnViewUserDetail) btnViewUserDetail.disabled = false;

                // Tampilkan placeholder transisi cepat di chat container
                setChatContainerHtml(`
                    <div class="text-center py-5 text-muted" id="chat-loading-placeholder">
                        <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                        <div class="fs-12 fw-medium">Memuat percakapan dengan ${escapeHtml(userName)}...</div>
                    </div>
                `);

                // Reset state balasan & lampiran saat ganti kontak
                cancelReplyState();
                cancelAttachmentState();

                // Load percakapan via AJAX
                loadConversation(userId, false);
            });

            const btnAttachFile = document.getElementById('btn-attach-file');
            const chatFileInput = document.getElementById('chat-file-input');
            const attachmentPreviewContainer = document.getElementById('attachment-preview-container');
            const attachmentPreviewImg = document.getElementById('attachment-preview-img');
            const attachmentPreviewIcon = document.getElementById('attachment-preview-icon');
            const attachmentPreviewName = document.getElementById('attachment-preview-name');
            const attachmentPreviewSize = document.getElementById('attachment-preview-size');
            const btnCancelAttachment = document.getElementById('btn-cancel-attachment');

            let selectedChatFile = null;

            function cancelAttachmentState() {
                selectedChatFile = null;
                if (chatFileInput) chatFileInput.value = '';
                if (attachmentPreviewContainer) attachmentPreviewContainer.classList.add('d-none');
                if (attachmentPreviewImg) {
                    attachmentPreviewImg.src = '';
                    attachmentPreviewImg.classList.add('d-none');
                }
                if (attachmentPreviewIcon) attachmentPreviewIcon.classList.remove('d-none');
            }

            if (btnAttachFile && chatFileInput) {
                btnAttachFile.addEventListener('click', function(e) {
                    e.preventDefault();
                    chatFileInput.click();
                });

                chatFileInput.addEventListener('change', function(e) {
                    const files = e.target.files;
                    if (!files || files.length === 0) return;

                    const file = files[0];

                    // Validasi ukuran berkas maksimal 10 MB
                    if (file.size > 10 * 1024 * 1024) {
                        if (typeof window.showWarning === 'function') {
                            window.showWarning('Ukuran berkas melebihi batas maksimal 10 MB.');
                        } else {
                            alert('Ukuran berkas melebihi batas maksimal 10 MB.');
                        }
                        chatFileInput.value = '';
                        return;
                    }

                    selectedChatFile = file;

                    if (attachmentPreviewContainer) {
                        attachmentPreviewContainer.classList.remove('d-none');
                        if (attachmentPreviewName) attachmentPreviewName.textContent = file.name;
                        if (attachmentPreviewSize) attachmentPreviewSize.textContent = formatBytes(file.size);

                        const isImage = file.type.startsWith('image/');
                        if (isImage && attachmentPreviewImg) {
                            const reader = new FileReader();
                            reader.onload = function(evt) {
                                attachmentPreviewImg.src = evt.target.result;
                                attachmentPreviewImg.classList.remove('d-none');
                                if (attachmentPreviewIcon) attachmentPreviewIcon.classList.add('d-none');
                            };
                            reader.readAsDataURL(file);
                        } else {
                            if (attachmentPreviewImg) attachmentPreviewImg.classList.add('d-none');
                            if (attachmentPreviewIcon) {
                                attachmentPreviewIcon.classList.remove('d-none');
                                if (file.name.endsWith('.pdf')) attachmentPreviewIcon.className = 'ti ti-file-type-pdf fs-22 text-danger';
                                else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) attachmentPreviewIcon.className = 'ti ti-file-type-doc fs-22 text-primary';
                                else if (file.name.endsWith('.xls') || file.name.endsWith('.xlsx')) attachmentPreviewIcon.className = 'ti ti-file-type-xls fs-22 text-success';
                                else if (file.name.endsWith('.zip') || file.name.endsWith('.rar')) attachmentPreviewIcon.className = 'ti ti-file-type-zip fs-22 text-warning';
                                else attachmentPreviewIcon.className = 'ti ti-file-text fs-22 text-info';
                            }
                        }
                    }
                });
            }

            if (btnCancelAttachment) {
                btnCancelAttachment.addEventListener('click', function(e) {
                    e.preventDefault();
                    cancelAttachmentState();
                });
            }

            // Event Delegation Buka Modal Lightbox Gambar (Rule 2 Compliance)
            document.addEventListener('click', function(e) {
                const imgBtn = e.target.closest('.btn-preview-img-modal');
                if (!imgBtn) return;
                e.preventDefault();

                const imgUrl = imgBtn.getAttribute('data-img-url');
                const imgName = imgBtn.getAttribute('data-img-name') || 'Pratinjau Gambar';

                const modalImg = document.getElementById('modal-preview-full-img');
                const modalLabel = document.getElementById('chatImageModalLabel');
                const downloadLink = document.getElementById('modal-download-image');

                if (modalImg) modalImg.src = imgUrl;
                if (modalLabel) modalLabel.textContent = imgName;
                if (downloadLink) {
                    downloadLink.href = imgUrl;
                    downloadLink.setAttribute('download', imgName);
                }

                const modalEl = document.getElementById('chat-image-modal');
                if (modalEl && window.bootstrap) {
                    const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
                    bsModal.show();
                }
            });

            // Event Delegation Klik Reply Quote Box untuk Scroll ke Pesan Asal (Rule 2 Compliance)
            document.addEventListener('click', function(e) {
                const replyBox = e.target.closest('.reply-quote-box');
                if (!replyBox) return;

                const parentId = replyBox.getAttribute('data-parent-id');
                if (!parentId) return;

                const targetMsgEl = document.getElementById(`chat-msg-${parentId}`);
                if (targetMsgEl) {
                    targetMsgEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

                    const msgBubble = targetMsgEl.querySelector('.chat-message') || targetMsgEl;
                    msgBubble.classList.remove('chat-message-highlight');
                    void msgBubble.offsetWidth; // Trigger DOM reflow to restart animation
                    msgBubble.classList.add('chat-message-highlight');

                    setTimeout(function() {
                        msgBubble.classList.remove('chat-message-highlight');
                    }, 1800);
                } else {
                    if (window.showToast) {
                        window.showToast('Pesan asal berada di luar riwayat saat ini.', 'info');
                    }
                }
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

                            // Sinkronkan avatar header aktif & kontak sidebar jika berubah
                            if (activeChatAvatar && tu.avatar) {
                                activeChatAvatar.src = tu.avatar;
                                activeChatAvatar.classList.remove('d-none');
                            }
                            const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${userId}"]`);
                            if (contactEl && tu.avatar) {
                                contactEl.setAttribute('data-user-avatar', tu.avatar);
                                const contactImg = contactEl.querySelector('img');
                                if (contactImg && contactImg.src !== tu.avatar) {
                                    contactImg.src = tu.avatar;
                                }
                            }
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
                            const summaryText = newLastMsg.body || (newLastMsg.attachment_type === 'image' ? '📷 [Foto / Gambar]' : ('📎 [' + (newLastMsg.attachment_name || 'Berkas') + ']'));
                            promoteContactToRecent(userId, summaryText, newLastMsg.time_formatted);

                            messages.forEach(function(msg) {
                                const isSender = msg.is_sender;
                                const avatar = isSender ? currentUserAvatar : (msg.sender_avatar || currentUserAvatar);
                                const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');
                                const replyText = msg.body || (msg.attachment_name || 'Lampiran');

                                html += `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}" id="chat-msg-${msg.id}" data-msg-id="${msg.id}">`;
                                if (!isSender) {
                                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                                }
                                html += `<div style="max-width: 75%;">
                                    <div class="chat-message py-2 px-3 ${isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border'} rounded shadow-sm text-start">`;
                                
                                if (msg.parent) {
                                    const parentId = msg.parent_id || (msg.parent ? msg.parent.id : '');
                                    html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box" data-parent-id="${parentId}" role="button" title="Klik untuk menuju pesan yang dibalas">
                                        <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                                        <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
                                    </div>`;
                                }

                                if (msg.subject && msg.subject !== 'Pesan Masuk') {
                                    html += `<strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>${escapeHtml(msg.subject)}</strong>`;
                                }

                                if (msg.attachment_url) {
                                    html += renderAttachmentHtml(msg);
                                }

                                if (msg.body) {
                                    html += `<div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
                                }

                                if (msg.reason) {
                                    html += `<div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                        <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> ${escapeHtml(msg.reason)}
                                    </div>`;
                                }
                                html += `</div>
                                    <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 ${isSender ? 'justify-content-end' : 'justify-content-start'}">
                                        <span><i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}</span>
                                        <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(replyText)}" title="Balas Pesan Ini">
                                            <i class="ti ti-corner-up-left"></i> Balas
                                        </button>
                                    </div>
                                </div>`;
                                if (isSender) {
                                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
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

                        // Update isi kontainer obrolan secara presisi
                        setChatContainerHtml(html);

                        lastMessageCount = newCount;
                        lastMessageId = newLastId;

                        // Sinkronkan badge dropdown pesan di topbar
                        if (typeof window.fetchMessagesSilently === 'function') {
                            window.fetchMessagesSilently(false);
                        }

                        // Pasang ulang scroll listener jika elemen di-recreate
                        attachScrollListener();

                        // Hanya scroll ke paling bawah jika bukan polling biasa ATAU jika user tidak sedang scroll ke atas & berada di bawah
                        if (!isPolling || (!userHasScrolledUp && wasNearBottom)) {
                            scrollToBottom(true);
                        }
                    }
                })
                .catch(function(err) {
                    console.error('Error loading conversation:', err);
                });
            }

            // Kirim Pesan via AJAX (Mendukung Teks, Reply Quote, dan Lampiran Berkas/Foto)
            if (chatForm) {
                chatForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!chatInput) return;

                    const messageText = chatInput.value.trim();
                    const receiverId = activeReceiverInput ? activeReceiverInput.value : '';
                    const replyParentInput = document.getElementById('reply-parent-id');
                    const parentId = (replyParentInput && replyParentInput.value.trim() !== '') ? parseInt(replyParentInput.value.trim(), 10) : null;
                    const replyNameEl = document.getElementById('reply-preview-name');
                    const replyBodyEl = document.getElementById('reply-preview-body');

                    if ((!messageText && !selectedChatFile) || !receiverId) return;

                    // Siapkan snapshot data optimistik sebelum form di-clear
                    const tempMsgId = 'temp_' + Date.now();
                    const capturedFile = selectedChatFile;
                    let capturedFileUrl = null;
                    if (capturedFile && capturedFile.type.startsWith('image/')) {
                        capturedFileUrl = (attachmentPreviewImg && attachmentPreviewImg.src) ? attachmentPreviewImg.src : URL.createObjectURL(capturedFile);
                    }
                    const capturedFileName = capturedFile ? capturedFile.name : null;
                    const capturedFileType = capturedFile ? (capturedFile.type.startsWith('image/') ? 'image' : 'file') : null;
                    const capturedFileSize = capturedFile ? capturedFile.size : null;
                    const capturedParent = parentId ? {
                        id: parentId,
                        sender_name: replyNameEl ? replyNameEl.textContent : 'Pesan',
                        body: replyBodyEl ? replyBodyEl.textContent : ''
                    } : null;

                    // Siapkan form data untuk background request
                    const formData = new FormData();
                    formData.append('receiver_id', receiverId);
                    if (parentId) formData.append('parent_id', parentId);
                    if (messageText) formData.append('body', messageText);
                    if (capturedFile) formData.append('attachment', capturedFile);

                    // 1. OPTIMISTIC UI: Langsung bersihkan input & render balon pesan seketika (0ms delay)
                    chatInput.value = '';
                    cancelReplyState();
                    cancelAttachmentState();
                    chatInput.focus();

                    const now = new Date();
                    const timeFormatted = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
                    const optimisticMsg = {
                        id: tempMsgId,
                        temp_id: tempMsgId,
                        is_sender: true,
                        body: messageText,
                        attachment_url: capturedFileUrl,
                        attachment_name: capturedFileName,
                        attachment_type: capturedFileType,
                        attachment_size: capturedFileSize,
                        attachment_size_formatted: capturedFileSize ? formatBytes(capturedFileSize) : null,
                        parent_id: parentId,
                        parent: capturedParent,
                        time_formatted: timeFormatted,
                        is_pending: true
                    };

                    appendSingleMessage(optimisticMsg);
                    scrollToBottom(true);

                    // Update ringkasan percakapan kontak aktif langsung di sidebar
                    const summaryText = messageText || (capturedFileType === 'image' ? '📷 [Foto / Gambar]' : ('📎 [' + (capturedFileName || 'Berkas') + ']'));
                    promoteContactToRecent(receiverId, summaryText, 'Baru saja');

                    // 2. Kirim ke server di latar belakang
                    fetch('/admin/profil-pengguna/messages/send', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(function(res) { return res.json(); })
                    .then(function(data) {
                        if (data && data.success) {
                            // Update status & ID pesan dari server
                            const tempEl = document.getElementById(`chat-msg-${tempMsgId}`);
                            if (tempEl) {
                                tempEl.id = `chat-msg-${data.message.id}`;
                                tempEl.setAttribute('data-msg-id', data.message.id);

                                const statusTimeEl = tempEl.querySelector('.chat-status-time');
                                if (statusTimeEl) {
                                    statusTimeEl.innerHTML = `<i class="ti ti-check text-primary me-0.5" title="Terkirim"></i> ${data.message.time_formatted || timeFormatted}`;
                                }

                                const btnReply = tempEl.querySelector('.btn-reply-msg');
                                if (btnReply) {
                                    btnReply.setAttribute('data-msg-id', data.message.id);
                                }

                                if (data.message.attachment_url) {
                                    const previewLink = tempEl.querySelector('.btn-preview-img-modal');
                                    if (previewLink) {
                                        previewLink.setAttribute('data-img-url', data.message.attachment_url);
                                        previewLink.href = data.message.attachment_url;
                                    }
                                    const downloadBtn = tempEl.querySelector('a[download]');
                                    if (downloadBtn) {
                                        downloadBtn.href = data.message.attachment_url;
                                    }
                                }
                            }

                            // Sinkronkan unread counts & topbar secara background
                            pollSidebarContacts();
                            if (typeof window.fetchMessagesSilently === 'function') {
                                window.fetchMessagesSilently(false);
                            }
                        } else {
                            markMessageFailed(tempMsgId, data && data.message ? data.message : 'Gagal mengirim pesan.');
                        }
                    })
                    .catch(function(err) {
                        markMessageFailed(tempMsgId, 'Koneksi terputus saat mengirim.');
                    });
                });
            }

            function markMessageFailed(tempId, errorText) {
                const tempEl = document.getElementById(`chat-msg-${tempId}`);
                if (tempEl) {
                    const statusTimeEl = tempEl.querySelector('.chat-status-time');
                    if (statusTimeEl) {
                        statusTimeEl.innerHTML = `<span class="badge bg-danger-subtle text-danger fs-xxs py-0.5 px-1"><i class="ti ti-alert-circle me-1"></i>${escapeHtml(errorText)}</span>`;
                    }
                }
                if (typeof window.showToast === 'function') {
                    window.showToast(errorText, 'error');
                }
            }

            function appendSingleMessage(msg) {
                if (!chatContainer) return;

                // Jika placeholder kosong ada, hapus
                const emptyPlaceholder = chatContainer.querySelector('#empty-chat-placeholder') || chatContainer.querySelector('#chat-loading-placeholder');
                if (emptyPlaceholder) emptyPlaceholder.remove();

                const isSender = msg.is_sender !== false;
                const isPending = msg.is_pending === true;
                const avatar = isSender ? currentUserAvatar : (msg.sender_avatar || currentUserAvatar);
                const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');
                const replyText = msg.body || (msg.attachment_name || 'Lampiran');
                const timeIndicator = isPending ? `<i class="ti ti-clock text-muted opacity-75 me-0.5" title="Mengirim..."></i> ${msg.time_formatted}` : `<i class="ti ti-check text-primary me-0.5" title="Terkirim"></i> ${msg.time_formatted}`;

                let html = `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}" id="chat-msg-${msg.id}" data-msg-id="${msg.id}">`;
                if (!isSender) {
                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                }
                html += `<div style="max-width: 75%;">
                    <div class="chat-message py-2 px-3 ${isSender ? 'bg-primary-subtle text-dark' : 'bg-light text-dark border'} rounded shadow-sm text-start">`;
                
                if (msg.parent) {
                    const parentId = msg.parent_id || (msg.parent ? msg.parent.id : '');
                    html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box" data-parent-id="${parentId}" role="button" title="Klik untuk menuju pesan yang dibalas">
                        <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                        <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
                    </div>`;
                }

                if (msg.attachment_url) {
                    html += renderAttachmentHtml(msg);
                }

                if (msg.body) {
                    html += `<div class="fs-13 lh-base text-wrap" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
                }

                html += `</div>
                    <div class="d-flex align-items-center gap-2 text-muted fs-xs mt-1 ${isSender ? 'justify-content-end' : 'justify-content-start'}">
                        <span class="chat-status-time">${timeIndicator}</span>
                        <button type="button" class="btn btn-link p-0 text-muted btn-reply-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-1 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(replyText)}" title="Balas Pesan Ini">
                            <i class="ti ti-corner-up-left"></i> Balas
                        </button>
                    </div>
                </div>`;
                if (isSender) {
                    html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                }
                html += `</div>`;

                appendChatContainerHtml(html);
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

            // Polling daftar kontak, pesan terakhir, badge unread, dan avatar terbaru secara real-time
            function pollSidebarContacts() {
                if (document.hidden) return;

                fetch('/admin/profil-pengguna/messages/poll-contacts', {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (!data || !data.success || !Array.isArray(data.contacts)) return;

                    // Real-time update avatar user aktif jika berubah
                    if (data.current_user_avatar && data.current_user_avatar !== currentUserAvatar) {
                        currentUserAvatar = data.current_user_avatar;
                        document.querySelectorAll('#chat-container .chat-avatar-sender').forEach(function(img) {
                            if (img.src !== data.current_user_avatar) {
                                img.src = data.current_user_avatar;
                            }
                        });
                    }

                    const listRecent = document.getElementById('list-recent-contacts');
                    const listOther = document.getElementById('list-other-contacts');
                    const secRecent = document.getElementById('section-recent-contacts');
                    const secOther = document.getElementById('section-other-contacts');
                    const badgeRecent = document.getElementById('badge-recent-count');
                    const badgeOther = document.getElementById('badge-other-count');

                    data.contacts.forEach(function(c) {
                        const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${c.id}"]`);
                        if (!contactEl) return;

                        // Real-time update avatar kontak di sidebar
                        if (c.avatar) {
                            contactEl.setAttribute('data-user-avatar', c.avatar);
                            const contactImg = contactEl.querySelector('img');
                            if (contactImg && contactImg.src !== c.avatar) {
                                contactImg.src = c.avatar;
                            }
                        }

                        const lastMsgEl = contactEl.querySelector('.contact-last-msg');
                        const lastTimeEl = contactEl.querySelector('.contact-last-time');
                        const unreadBadge = contactEl.querySelector('.contact-unread-badge');

                        if (lastMsgEl && c.last_message) lastMsgEl.textContent = c.last_message;
                        if (lastTimeEl && c.last_message_time) lastTimeEl.textContent = c.last_message_time;

                        const isContactActive = String(activeUserId) === String(c.id);

                        // Real-time update avatar header aktif, modal detail, dan chat bubbles lawan bicara
                        if (isContactActive && c.avatar) {
                            const activeHeaderAvatar = document.getElementById('active-chat-avatar');
                            if (activeHeaderAvatar && activeHeaderAvatar.src !== c.avatar) {
                                activeHeaderAvatar.src = c.avatar;
                                activeHeaderAvatar.classList.remove('d-none');
                            }
                            const modalAvatar = document.getElementById('modal-user-avatar');
                            if (modalAvatar && modalAvatar.src !== c.avatar) {
                                modalAvatar.src = c.avatar;
                            }
                            document.querySelectorAll('#chat-container .chat-avatar-opponent').forEach(function(img) {
                                if (img.src !== c.avatar) {
                                    img.src = c.avatar;
                                }
                            });
                        }

                        if (unreadBadge) {
                            if (isContactActive) {
                                unreadBadge.classList.add('d-none');
                                unreadBadge.textContent = '0';
                            } else if (c.unread_count > 0) {
                                unreadBadge.textContent = c.unread_count > 99 ? '99+' : c.unread_count;
                                unreadBadge.classList.remove('d-none');
                            } else {
                                unreadBadge.classList.add('d-none');
                                unreadBadge.textContent = '0';
                            }
                        }

                        // Jika kontak memiliki percakapan dan sebelumnya di 'other', pindahkan ke 'recent'
                        if (c.has_conversation && listOther && listRecent && listOther.contains(contactEl)) {
                            listRecent.prepend(contactEl);
                        }

                        // Jika ada pesan baru masuk (unread > 0), tempatkan di urutan teratas list recent
                        if (c.unread_count > 0 && listRecent && listRecent.contains(contactEl)) {
                            if (listRecent.firstElementChild !== contactEl) {
                                listRecent.prepend(contactEl);
                            }
                        }
                    });

                    if (badgeRecent && typeof data.recent_count !== 'undefined') badgeRecent.textContent = data.recent_count;
                    if (badgeOther && typeof data.other_count !== 'undefined') badgeOther.textContent = data.other_count;

                    if (secRecent) {
                        if (data.recent_count > 0) secRecent.classList.remove('d-none');
                        else secRecent.classList.add('d-none');
                    }

                    if (secOther) {
                        if (data.other_count > 0) {
                            secOther.classList.remove('d-none');
                            if (data.recent_count > 0) secOther.classList.add('mt-2');
                            else secOther.classList.remove('mt-2');
                        } else {
                            secOther.classList.add('d-none');
                        }
                    }
                })
                .catch(function(err) {});
            }

            // 1. Polling daftar kontak & badge unread sidebar setiap 3.5 detik
            setInterval(pollSidebarContacts, 3500);

            // 2. Polling obrolan aktif setiap 3.5 detik jika ada kontak yang sedang dibuka
            setInterval(function() {
                if (activeUserId && !document.hidden) {
                    loadConversation(activeUserId, true);
                }
            }, 3500);

            // ==========================================
            // EMOJI / EMOTION PICKER & INSERTION ENGINE
            // ==========================================
            const emojiPickerContainer = document.getElementById('emoji-picker-container');
            const btnToggleEmoji = document.getElementById('btn-toggle-emoji');
            const btnCloseEmoji = document.getElementById('btn-close-emoji');
            const emojiSearchInput = document.getElementById('emoji-search-input');
            const emojiGridContainer = document.getElementById('emoji-grid-container');

            const EMOJI_DATABASE = {
                smileys: [
                    { char: '😀', tags: 'senyum lebar gembira grinning happy smile' },
                    { char: '😃', tags: 'senyum ceria bahagia smiley joy' },
                    { char: '😄', tags: 'tertawa senang smile haha lol' },
                    { char: '😁', tags: 'nyengir gembira grin teeth' },
                    { char: '😆', tags: 'tertawa terbahak laughing ngakak' },
                    { char: '😅', tags: 'senyum keringat lega sweat smile whew' },
                    { char: '🤣', tags: 'tertawa guling rofl ngakak parah' },
                    { char: '😂', tags: 'menangis tertawa joy ngakak nangis' },
                    { char: '🙂', tags: 'senyum tipis ramah slightly smiling' },
                    { char: '🙃', tags: 'senyum terbalik sarkas upside down' },
                    { char: '😉', tags: 'kedip mata genit wink flirty' },
                    { char: '😊', tags: 'tersipu malu manis blush warm' },
                    { char: '😇', tags: 'malaikat suci baik angel innocent' },
                    { char: '🥰', tags: 'penuh cinta sayang hearts lovely' },
                    { char: '😍', tags: 'kagum suka cinta heart eyes love' },
                    { char: '🤩', tags: 'terpukau bintang star struck amazing' },
                    { char: '😘', tags: 'cium cinta blow kiss love' },
                    { char: '😗', tags: 'cium biasa kissing cute' },
                    { char: '😚', tags: 'cium mesra kissing closed eyes' },
                    { char: '😋', tags: 'lezat enak sedap yum delicious' },
                    { char: '😛', tags: 'melet lidah bercanda tongue' },
                    { char: '😜', tags: 'melet kedip konyol wink tongue crazy' },
                    { char: '🤪', tags: 'gila seru konyol zany goofy' },
                    { char: '😝', tags: 'melet tertawa squint tongue funny' },
                    { char: '🤗', tags: 'peluk hangat hugging friendly' },
                    { char: '🤭', tags: 'menutup mulut kaget hand over mouth oops' },
                    { char: '🤫', tags: 'diam rahasia sst shushing quiet secret' },
                    { char: '🤔', tags: 'mikir berpikir ide thinking question' },
                    { char: '🤐', tags: 'tutup mulut kunci zipper secret' },
                    { char: '🤨', tags: 'curiga heran raised eyebrow skeptic' },
                    { char: '😐', tags: 'netral datar neutral poker face' },
                    { char: '😑', tags: 'tanpa ekspresi jengkel expressionless' },
                    { char: '😶', tags: 'diam hening no mouth silent' },
                    { char: '😏', tags: 'senyum sinis nakal smirk sly' },
                    { char: '😒', tags: 'kesal tidak puas unamused annoyed' },
                    { char: '🙄', tags: 'memutar mata bosan rolling eyes whatever' },
                    { char: '😬', tags: 'meringis canggung grimace awkward' },
                    { char: '🤥', tags: 'bohong pinokio lying liar' },
                    { char: '😌', tags: 'lega tenang damai relieved peaceful' },
                    { char: '😔', tags: 'sedih murung lesu pensive sad' },
                    { char: '😪', tags: 'mengantuk lelah sleepy tired' },
                    { char: '🤤', tags: 'ngiler mau sedap drooling want' },
                    { char: '😴', tags: 'tidur zzz sleeping bed' },
                    { char: '😷', tags: 'masker sakit flu mask hospital' },
                    { char: '🤒', tags: 'demam panas sakit thermometer sick' },
                    { char: '🤕', tags: 'terluka perban head bandage hurt' },
                    { char: '🤢', tags: 'mual ingin muntah nauseated sick' },
                    { char: '🤮', tags: 'muntah vomiting sick gross' },
                    { char: '🤧', tags: 'bersin pilek sneezing cold flu' },
                    { char: '🥵', tags: 'kepanasan gerah hot face summer' },
                    { char: '🥶', tags: 'kedinginan beku cold face freezing' },
                    { char: '🥴', tags: 'pusing teler woozy tipsy' },
                    { char: '😵', tags: 'pusing pingsan dizzy knockout' },
                    { char: '🤯', tags: 'pikiran meledak kaget exploding mindblown' },
                    { char: '🤠', tags: 'koboi cowboy hat cool' },
                    { char: '🥳', tags: 'pesta perayaan selamat partying celebrate' },
                    { char: '😎', tags: 'keren kacamata gaya cool sunglass swag' },
                    { char: '🤓', tags: 'kutu buku pintar kacamata nerd smart geek' },
                    { char: '🧐', tags: 'mengamati teliti cek periksa monocle inspect' },
                    { char: '😕', tags: 'bingung ragu confused puzzled' },
                    { char: '😟', tags: 'cemas khawatir worried anxious' },
                    { char: '🙁', tags: 'cemberut sedikit sedih frowning sad' },
                    { char: '😮', tags: 'mulut terbuka kaget open mouth wow' },
                    { char: '😯', tags: 'terperangah hushed surprised' },
                    { char: '😲', tags: 'terkejut kaget astonished shocked' },
                    { char: '😳', tags: 'malu kaget merah flushed shy' },
                    { char: '🥺', tags: 'memohon sedih puppy eyes pleading please' },
                    { char: '😦', tags: 'kaget kecewa frowning open mouth' },
                    { char: '😧', tags: 'terpukul cemas anguished hurt' },
                    { char: '😨', tags: 'takut kaget fearful scared' },
                    { char: '😰', tags: 'keringat dingin anxious sweat panic' },
                    { char: '😥', tags: 'sedih lega sad relieved whew' },
                    { char: '😢', tags: 'menangis sedih air mata crying tear' },
                    { char: '😭', tags: 'menangis tersedu kejer sob weeping loud' },
                    { char: '😱', tags: 'berteriak takut jerit scream horror panic' },
                    { char: '😖', tags: 'jengkel tersiksa confounded frustrated' },
                    { char: '😣', tags: 'menahan sakit lelah persevering struggle' },
                    { char: '😞', tags: 'kecewa pupus sedih disappointed sad' },
                    { char: '😓', tags: 'putus asa letih downcast sweat' },
                    { char: '😩', tags: 'lelah letih pasrah weary exhausted' },
                    { char: '😫', tags: 'capek lelah sangat tired drained' },
                    { char: '🥱', tags: 'menguap mengantuk yawning sleepy' },
                    { char: '😤', tags: 'mendengus bertekad triumph steam furious' },
                    { char: '😡', tags: 'marah murka merah pouting enraged angry' },
                    { char: '😠', tags: 'marah kesal angry mad' },
                    { char: '🤬', tags: 'memaki sensor marah cursing mad swearing' },
                    { char: '😈', tags: 'iblis tersenyum jahat devil evil smile' },
                    { char: '👿', tags: 'iblis marah devil angry evil' },
                    { char: '💀', tags: 'tengkorak mati ngakak skull dead' },
                    { char: '💩', tags: 'kotoran lucu poop crap funny' },
                    { char: '🤡', tags: 'badut lelucon clown joke silly' },
                    { char: '👻', tags: 'hantu bayangan ghost spooky boo' },
                    { char: '👽', tags: 'alien luar angkasa ufo extraterrestrial' },
                    { char: '🤖', tags: 'robot bot mesin ai artificial' }
                ],
                gestures: [
                    { char: '👍', tags: 'jempol mantap setuju oke sip thumbs up ok' },
                    { char: '👎', tags: 'jempol bawah tidak setuju jelek thumbs down bad' },
                    { char: '👌', tags: 'oke sempurna pas mantap ok hand perfect' },
                    { char: '🤌', tags: 'pinched fingers maksud apa gesture' },
                    { char: '🤏', tags: 'sedikit kecil tipis pinching little bit' },
                    { char: '✌️', tags: 'damai peace salam dua jari victory' },
                    { char: '🤞', tags: 'semoga beruntung doa crossed fingers luck' },
                    { char: '🫰', tags: 'saranghae love jari korea finger heart' },
                    { char: '🤟', tags: 'aku cinta kamu metal gaul love you gesture' },
                    { char: '🤘', tags: 'musik rock metal keren rock on horns' },
                    { char: '🤙', tags: 'hubungi saya telepon santai call me hang loose' },
                    { char: '👈', tags: 'tunjuk kiri pointing left direction' },
                    { char: '👉', tags: 'tunjuk kanan ini pointing right here' },
                    { char: '👆', tags: 'tunjuk atas perhatikan pointing up look' },
                    { char: '👇', tags: 'tunjuk bawah cek ini pointing down check' },
                    { char: '☝️', tags: 'nomor satu satu telunjuk index pointing up one' },
                    { char: '🖐️', tags: 'lima tangan buka splayed fingers five' },
                    { char: '✋', tags: 'angkat tangan berhenti stop raised hand wait' },
                    { char: '🖖', tags: 'salam spock vulcan salute live long' },
                    { char: '🤝', tags: 'jabat tangan salaman deal sepakat handshake partner' },
                    { char: '👏', tags: 'tepuk tangan applause salut hebat clapping bravo' },
                    { char: '🙌', tags: 'angkat tangan syukur hore raising hands celebrate' },
                    { char: '🫶', tags: 'bentuk hati tangan cinta heart hands love' },
                    { char: '🤲', tags: 'berdoa memohon syukur palms up together pray' },
                    { char: '🙏', tags: 'terima kasih mohon maaf please thanks pray' },
                    { char: '🤜', tags: 'kepalan tos fist bump right' },
                    { char: '🤛', tags: 'kepalan tos bro fist bump left' },
                    { char: '✊', tags: 'kepalan tangan semangat juang raised fist power' },
                    { char: '👊', tags: 'tinju pukulan tos punch oncoming fist' },
                    { char: '👋', tags: 'lambaian tangan halo dadah waving hand bye hi' },
                    { char: '🫂', tags: 'pelukan erat hangat teman people hugging hug' },
                    { char: '💋', tags: 'bekas ciuman bibir kiss mark lips' },
                    { char: '💯', tags: 'seratus persen sempurna juara hundred points perfect' },
                    { char: '🔥', tags: 'api semangat panas gacor jos fire lit hot' },
                    { char: '✨', tags: 'kilauan bersinar baru estetik sparkles shine magic' },
                    { char: '🌟', tags: 'bintang bersinar terang glowing star shining' },
                    { char: '💥', tags: 'ledakan tabrakan boom collision blast' }
                ],
                hearts: [
                    { char: '❤️', tags: 'hati merah cinta sayang love red heart' },
                    { char: '🧡', tags: 'hati oranye hangat orange heart care' },
                    { char: '💛', tags: 'hati kuning sahabat yellow heart friend' },
                    { char: '💚', tags: 'hati hijau damai alam green heart nature' },
                    { char: '💙', tags: 'hati biru tenang setia blue heart trust' },
                    { char: '💜', tags: 'hati ungu elegan purple heart royal' },
                    { char: '🖤', tags: 'hati hitam keren misteri black heart cool' },
                    { char: '🤍', tags: 'hati putih suci tulus white heart pure' },
                    { char: '🤎', tags: 'hati cokelat brown heart warm' },
                    { char: '💔', tags: 'patah hati sedih putus broken heart sad' },
                    { char: '❤️‍🔥', tags: 'hati membara gelora rindu heart on fire passion' },
                    { char: '❤️‍🩹', tags: 'hati sembuh pulih mending heart healing' },
                    { char: '❣️', tags: 'tanda seru hati heart exclamation love' },
                    { char: '💕', tags: 'dua hati manis two hearts lovely' },
                    { char: '💞', tags: 'hati berputar harmonis revolving hearts' },
                    { char: '💓', tags: 'detak jantung berdebar beating heart heartbeat' },
                    { char: '💗', tags: 'hati membesar kasih growing heart expand' },
                    { char: '💖', tags: 'hati berkilau sparkling heart sparkle' },
                    { char: '💘', tags: 'panah asmara cupid cinta heart with arrow' },
                    { char: '💝', tags: 'kado cinta hadiah ribbon gift heart' },
                    { char: '💟', tags: 'dekorasi hati heart decoration ornament' }
                ],
                objects: [
                    { char: '🎉', tags: 'terompet pesta selamat perayaan party popper celebrate' },
                    { char: '🎊', tags: 'konfeti bola pesta kemeriahan confetti ball' },
                    { char: '🎁', tags: 'hadiah kado bingkisan kejutan gift wrapped present' },
                    { char: '🏆', tags: 'piala juara pemenang nomor satu trophy champion winner' },
                    { char: '🥇', tags: 'medali emas juara satu medal first place gold' },
                    { char: '🎯', tags: 'sasaran target fokus tepat bullseye direct hit goal' },
                    { char: '🚀', tags: 'roket meluncur cepat gas launch rocket fast' },
                    { char: '💡', tags: 'lampu bohlam ide terang cemerlang light bulb idea smart' },
                    { char: '📌', tags: 'pin paku semat penting tandai pushpin pin memo' },
                    { char: '📍', tags: 'lokasi titik pin koordinat map marker pin location' },
                    { char: '📝', tags: 'catatan tulis memo tugas agenda memo write note' },
                    { char: '📅', tags: 'kalender tanggal jadwal rapat calendar date schedule' },
                    { char: '🕒', tags: 'jam waktu pukul pengingat clock time watch' },
                    { char: '💼', tags: 'tas kerja koper kantor bisnis briefcase work business' },
                    { char: '💻', tags: 'laptop komputer kerja ngoding laptop computer tech' },
                    { char: '📱', tags: 'handphone telepon seluler hp smartphone mobile phone' },
                    { char: '🔒', tags: 'terkunci aman privasi rahasia locked secure privacy' },
                    { char: '🔑', tags: 'kunci akses kata sandi solusi key password unlock' },
                    { char: '✅', tags: 'centang hijau benar sukses selesai check mark ok done' },
                    { char: '❌', tags: 'silang merah salah batal tolak cross mark error cancel' },
                    { char: '⚠️', tags: 'peringatan awas hati-hati bahaya warning alert caution' },
                    { char: '❓', tags: 'tanda tanya kenapa ada apa question mark why' },
                    { char: '❗', tags: 'tanda seru penting perhatian exclamation mark important' },
                    { char: '💬', tags: 'balon obrolan chat pesan bicara speech balloon chat message' },
                    { char: '💭', tags: 'balon pikiran mikir impian thought balloon thinking' }
                ],
                activities: [
                    { char: '☕', tags: 'kopi teh hangat istirahat santai coffee tea break relax' },
                    { char: '🍕', tags: 'pizza makanan enak makan siang pizza food slice' },
                    { char: '🍔', tags: 'hamburger burger fastfood makan hamburger food' },
                    { char: '🍻', tags: 'bersulang cheers minum bersama beer toast drink' },
                    { char: '🥂', tags: 'gelas anggur perayaan selamat cheers champagne toast' },
                    { char: '🎂', tags: 'kue ulang tahun ultah selamat birthday cake sweet' },
                    { char: '🍰', tags: 'kue manis dessert lezat shortcake cake pastry' },
                    { char: '🍦', tags: 'es krim segar manis ice cream sweet cold' },
                    { char: '🍿', tags: 'popcorn nonton bioskop film movie snack' },
                    { char: '🚗', tags: 'mobil jalan perjalanan otw car auto drive travel' },
                    { char: '✈️', tags: 'pesawat terbang liburan perjalanan tugas airplane flight holiday' },
                    { char: '🏖️', tags: 'pantai liburan santai holiday healing beach summer vacation' },
                    { char: '🎵', tags: 'musik lagu nada santai music note song melody' },
                    { char: '🎮', tags: 'video game main permainan seru gamepad gaming play' },
                    { char: '⚽', tags: 'sepak bola olahraga tanding bola soccer football ball' },
                    { char: '🏀', tags: 'basket olahraga tim basketball ball sports' }
                ]
            };

            let currentEmojiCategory = 'smileys';

            function renderEmojiGrid(category = 'smileys', filterQuery = '') {
                if (!emojiGridContainer) return;

                let list = [];
                const query = filterQuery.toLowerCase().trim();

                if (query !== '') {
                    // Filter pencarian di semua kategori emoji
                    Object.keys(EMOJI_DATABASE).forEach(function(cat) {
                        EMOJI_DATABASE[cat].forEach(function(item) {
                            if (item.tags.includes(query) || item.char.includes(query)) {
                                if (!list.some(function(i) { return i.char === item.char; })) {
                                    list.push(item);
                                }
                            }
                        });
                    });
                } else {
                    list = EMOJI_DATABASE[category] || [];
                }

                if (list.length === 0) {
                    emojiGridContainer.innerHTML = `<div class="col-12 text-center py-3 text-muted fs-12" style="grid-column: 1 / -1;">
                        <i class="ti ti-mood-empty fs-18 d-block mb-1"></i>Emoji tidak ditemukan
                    </div>`;
                    return;
                }

                let html = '';
                list.forEach(function(item) {
                    html += `<button type="button" class="emoji-btn btn-insert-emoji" data-emoji="${item.char}" title="${item.char}">${item.char}</button>`;
                });

                emojiGridContainer.innerHTML = html;
            }

            // Inisialisasi awal render grid emoji
            renderEmojiGrid(currentEmojiCategory);

            // Toggle Popup Emoji Picker
            if (btnToggleEmoji && emojiPickerContainer) {
                btnToggleEmoji.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const isHidden = emojiPickerContainer.classList.contains('d-none');
                    if (isHidden) {
                        emojiPickerContainer.classList.remove('d-none');
                        if (emojiSearchInput) {
                            emojiSearchInput.value = '';
                            setTimeout(function() { emojiSearchInput.focus(); }, 100);
                        }
                        renderEmojiGrid(currentEmojiCategory);
                    } else {
                        emojiPickerContainer.classList.add('d-none');
                    }
                });
            }

            // Close Popup Emoji
            if (btnCloseEmoji && emojiPickerContainer) {
                btnCloseEmoji.addEventListener('click', function(e) {
                    e.preventDefault();
                    emojiPickerContainer.classList.add('d-none');
                });
            }

            // Tab Kategori Emoji
            document.querySelectorAll('#emoji-category-tabs .btn-emoji-cat').forEach(function(tabBtn) {
                tabBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.querySelectorAll('#emoji-category-tabs .btn-emoji-cat').forEach(function(b) { b.classList.remove('active'); });
                    tabBtn.classList.add('active');

                    const category = tabBtn.getAttribute('data-category');
                    currentEmojiCategory = category;
                    if (emojiSearchInput) emojiSearchInput.value = '';
                    renderEmojiGrid(category);
                });
            });

            // Pencarian Emoji Real-Time
            if (emojiSearchInput) {
                emojiSearchInput.addEventListener('keyup', function(e) {
                    const q = e.target.value;
                    renderEmojiGrid(currentEmojiCategory, q);
                });
            }

            // Event Delegation Sisipkan Emoji ke Kolom Input (Rule 2 Compliance)
            document.addEventListener('click', function(e) {
                const btnEmoji = e.target.closest('.btn-insert-emoji');
                if (!btnEmoji) return;
                e.preventDefault();

                const emoji = btnEmoji.getAttribute('data-emoji');
                if (!emoji || !chatInput) return;

                // Sisipkan emoji pada posisi kursor saat ini
                const startPos = chatInput.selectionStart || 0;
                const endPos = chatInput.selectionEnd || 0;
                const textBefore = chatInput.value.substring(0, startPos);
                const textAfter = chatInput.value.substring(endPos, chatInput.value.length);

                chatInput.value = textBefore + emoji + textAfter;
                const newPos = startPos + emoji.length;
                chatInput.setSelectionRange(newPos, newPos);
                chatInput.focus();
            });

            // Tutup Emoji Picker jika mengklik di luar area
            document.addEventListener('click', function(e) {
                if (!emojiPickerContainer || emojiPickerContainer.classList.contains('d-none')) return;
                if (!emojiPickerContainer.contains(e.target) && !btnToggleEmoji.contains(e.target)) {
                    emojiPickerContainer.classList.add('d-none');
                }
            });

            // Tutup Emoji Picker saat tombol ESC ditekan
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && emojiPickerContainer && !emojiPickerContainer.classList.contains('d-none')) {
                    emojiPickerContainer.classList.add('d-none');
                }
            });
        });
    </script>

    <style>
        .emoji-btn {
            font-size: 1.3rem;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: transform 0.12s ease, background-color 0.12s ease;
            user-select: none;
        }
        .emoji-btn:hover {
            background-color: #f1f5f9;
            transform: scale(1.25);
            z-index: 2;
        }
        .emoji-btn:active {
            transform: scale(0.92);
        }
        .emoji-tabs .nav-link {
            color: #64748b;
            border-radius: 6px;
            transition: all 0.15s ease;
        }
        .emoji-tabs .nav-link.active {
            background-color: #ffffff;
            color: #0f172a;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            font-weight: bold;
        }
        .reply-quote-box {
            cursor: pointer;
            transition: all 0.2s ease;
            user-select: none;
        }
        .reply-quote-box:hover {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08) !important;
            transform: translateY(-1px);
        }
        .reply-quote-box:active {
            transform: translateY(0);
        }
        @keyframes pulseMessageHighlight {
            0% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.8);
                outline: 2px solid #0d6efd;
            }
            40% {
                box-shadow: 0 0 0 8px rgba(13, 110, 253, 0);
                outline: 3px solid #0d6efd;
                background-color: rgba(13, 110, 253, 0.15) !important;
            }
            100% {
                box-shadow: 0 0 0 0 rgba(13, 110, 253, 0);
                outline: 0px solid transparent;
            }
        }
        .chat-message-highlight {
            animation: pulseMessageHighlight 1.8s ease-in-out !important;
        }
    </style>
@endsection
