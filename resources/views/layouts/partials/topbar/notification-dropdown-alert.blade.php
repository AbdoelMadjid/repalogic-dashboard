@php
    $notifData = \App\Services\NotificationService::getNotifications();
    $notifItems = $notifData['items'];
    $totalCount = $notifData['total_count'];
    $unreadCount = $notifData['unread_count'];
@endphp

<div id="notification-dropdown-alert" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" type="button"
            data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
            <i class="ti ti-bell topbar-link-icon"></i>
            @if ($unreadCount > 0)
                <span class="badge text-bg-danger badge-circle topbar-badge">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>

        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg">
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

            <div style="max-height: 300px" data-simplebar="">
                @forelse ($notifItems as $item)
                    <a href="{{ $item['url'] }}" class="dropdown-item notification-item py-2 text-wrap">
                        <span class="d-flex gap-3 align-items-center">
                            <span class="flex-shrink-0">
                                @if (!empty($item['avatar']))
                                    <img src="{{ $item['avatar'] }}" class="avatar-md rounded-circle object-fit-cover"
                                        alt="{{ $item['title'] }}" />
                                @else
                                    <span class="avatar-md flex-shrink-0">
                                        <span class="avatar-title text-bg-primary rounded-circle fs-20">
                                            <i class="{{ $item['icon'] }} fs-20"></i>
                                        </span>
                                    </span>
                                @endif
                            </span>
                            <span class="flex-grow-1 text-muted">
                                <span class="fw-medium text-body d-block">{{ $item['title'] }}</span>
                                <span class="fs-xs d-block text-truncate" style="max-width: 170px;">{{ $item['subtitle'] ?: $item['message'] }}</span>
                                <span class="fs-xs text-muted">{{ $item['time_ago'] }}</span>
                            </span>
                            <span class="badge {{ $item['badge_class'] }} fs-xs flex-shrink-0">
                                {{ $item['badge_label'] }}
                            </span>
                        </span>
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

            <!-- All-->
            @can('read manajemenpengguna/users')
                <a href="{{ route('admin.manajemenpengguna.users.index') }}"
                    class="dropdown-item text-center text-reset text-decoration-underline link-offset-2 fw-bold notify-item border-top border-light py-2">
                    Kelola Semua Pengguna
                </a>
            @endcan
        </div>
        <!-- End dropdown-menu -->
    </div>
    <!-- end dropdown-->
</div>
