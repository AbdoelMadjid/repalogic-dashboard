<div class="px-3 py-2 border-bottom">
    <div class="row align-items-center">
        <div class="col">
            <h6 class="m-0 fs-md fw-semibold">Notifikasi</h6>
        </div>
        <div class="col text-end">
            @if ($unreadCount > 0)
                <a href="javascript:void(0);" class="badge badge-soft-danger badge-label py-1">
                    {{ $unreadCount }} Baru
                </a>
            @else
                <a href="javascript:void(0);" class="badge badge-soft-success badge-label py-1">
                    Semua Beres
                </a>
            @endif
        </div>
    </div>
</div>

<div style="max-height: 320px; overflow-x: hidden;" data-simplebar="">
    @forelse ($notifItems as $item)
        <a href="{{ $item['url'] }}"
            class="dropdown-item notification-item py-2 px-3 text-wrap overflow-hidden btn-view-notif-detail"
            data-notif-id="{{ $item['id'] }}"
            data-notif-title="{{ $item['title'] }}"
            data-notif-message="{{ $item['message'] }}"
            data-notif-reason="{{ $item['reason'] ?? '' }}"
            data-notif-time="{{ $item['time_ago'] }}"
            data-notif-url="{{ $item['url'] }}">
            <div class="d-flex gap-3 align-items-start">
                <div class="flex-shrink-0 mt-1">
                    @if (!empty($item['avatar']))
                        <img src="{{ $item['avatar'] }}" class="rounded-circle object-fit-cover shadow-sm"
                            style="width: 38px; height: 38px; min-width: 38px; min-height: 38px; object-fit: cover; object-position: top; aspect-ratio: 1 / 1;"
                            alt="{{ $item['title'] }}" />
                    @else
                        <div class="avatar-md flex-shrink-0">
                            <span class="avatar-title text-bg-primary rounded-circle fs-18">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1 text-muted" style="min-width: 0;">
                    <div class="d-flex justify-content-between align-items-center gap-2 mb-1">
                        <span class="fw-semibold text-body text-truncate fs-14 me-1">{{ $item['title'] }}</span>
                        <span class="fs-xs text-muted flex-shrink-0 text-nowrap">{{ $item['time_ago'] }}</span>
                    </div>
                    <div class="fs-xs text-muted text-truncate mb-1">{{ $item['subtitle'] ?: $item['message'] }}</div>
                    @if (!empty($item['badge_label']))
                        <div>
                            <span class="badge {{ $item['badge_class'] }} fs-xs px-2 py-1">
                                {{ $item['badge_label'] }}
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </a>
    @empty
        <div class="text-center py-4 px-3">
            <div class="avatar-md mx-auto mb-2">
                <span class="avatar-title text-bg-success rounded-circle fs-22">
                    <i class="ti ti-circle-check fs-22"></i>
                </span>
            </div>
            <h6 class="fs-md fw-semibold mb-1 text-body">Tidak Ada Notifikasi Baru</h6>
            <p class="text-muted fs-xs mb-0">Semua tugas dan pemberitahuan telah diproses.</p>
        </div>
    @endforelse
</div>

<!-- Footer Link Khusus Superadmin & Admin -->
@if (auth()->check() && auth()->user()->hasAnyRole(['superadmin', 'admin']))
    <a href="{{ route('admin.manajemenpengguna.users.index') }}"
        class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
        Kelola Semua Pengguna
    </a>
@endif
