<div class="px-3 py-2 border-bottom">
    <div class="row align-items-center">
        <div class="col">
            <h6 class="m-0 fs-md fw-semibold" data-lang="topbar-messages-title">Messages</h6>
        </div>
        <div class="col text-end">
            @if ($unreadCount > 0)
                <a href="javascript:void(0);" class="badge badge-soft-success badge-label py-1">
                    {{ $unreadCount }} Belum Dibaca
                </a>
            @else
                <a href="javascript:void(0);" class="badge badge-soft-secondary badge-label py-1">
                    Semua Pesan Dibaca
                </a>
            @endif
        </div>
    </div>
</div>

<div style="max-height: 320px; overflow-x: hidden;" data-simplebar="">
    @forelse ($messageItems as $item)
        <a href="{{ $item['url'] }}"
            class="dropdown-item notification-item py-2 px-3 text-wrap overflow-hidden btn-view-message-detail {{ $item['is_read'] ? 'bg-light-subtle opacity-75' : '' }}"
            data-message-id="{{ $item['id'] }}"
            data-message-title="{{ strip_tags($item['title']) }}"
            data-message-content="{{ $item['message'] }}"
            data-message-reason="{{ $item['reason'] ?? '' }}"
            data-message-time="{{ $item['time_ago'] }}"
            data-message-url="{{ $item['url'] }}">
            <div class="d-flex gap-3 align-items-start">
                <div class="flex-shrink-0 mt-1">
                    @if (!empty($item['avatar']))
                        <img src="{{ $item['avatar'] }}" class="rounded-circle object-fit-cover shadow-sm"
                            style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;"
                            alt="{{ strip_tags($item['title']) }}" />
                    @else
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title {{ $item['is_read'] ? 'text-bg-secondary' : 'text-bg-success' }} rounded-circle fs-18">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1 text-muted d-flex justify-content-between align-items-start gap-2" style="min-width: 0;">
                    <div class="d-flex flex-column align-items-start gap-1" style="min-width: 0;">
                        <span class="fw-semibold text-body fs-13 lh-sm me-1">{!! $item['title'] !!}</span>
                        <div class="d-flex align-items-center gap-1 flex-wrap">
                            @if (!empty($item['badge_label']))
                                <span class="badge {{ $item['badge_class'] }} fs-xs px-2 py-0.5">
                                    {{ $item['badge_label'] }}
                                </span>
                            @endif
                            @if (!empty($item['unread_count_group']) && $item['unread_count_group'] > 0)
                                <span class="badge bg-danger text-white fs-xs px-1.5 py-0.5 shadow-sm" title="{{ $item['unread_count_group'] }} pesan belum dibaca">
                                    <i class="ti ti-message-dots me-1"></i>{{ $item['unread_count_group'] }} Chat
                                </span>
                            @elseif (!empty($item['total_count_group']) && $item['total_count_group'] > 1)
                                <span class="badge bg-light text-muted border fs-xs px-1.5 py-0.5">
                                    {{ $item['total_count_group'] }} Pesan
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex flex-column align-items-end text-end flex-shrink-0 ms-auto">
                        <span class="fs-xs text-muted text-nowrap mb-0.5">{{ $item['time_ago'] }}</span>
                        @if (!empty($item['is_read']))
                            <span class="text-muted status-read-text" style="font-size: 11px;">Sudah dibaca</span>
                        @else
                            <span class="text-warning fw-medium status-read-text" style="font-size: 11px;">Belum dibaca</span>
                        @endif
                    </div>
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-4 px-3">
            <div class="avatar-md mx-auto mb-2">
                <span class="avatar-title text-bg-success rounded-circle fs-22">
                    <i class="ti ti-mail-opened fs-22"></i>
                </span>
            </div>
            <h6 class="fs-md fw-semibold mb-1 text-body">Kotak Pesan Kosong</h6>
            <p class="text-muted fs-xs mb-0">Belum ada pesan atau pemberitahuan baru.</p>
        </div>
    @endforelse
</div>
