@php
    $notifData = \App\Services\NotificationService::getNotifications();
    $notifItems = $notifData['items'];
    $totalCount = $notifData['total_count'];
    $unreadCount = $notifData['unread_count'];
@endphp

<div id="notification-dropdown-alert" class="topbar-item">
    <div class="dropdown">
        <button class="topbar-link dropdown-toggle drop-arrow-none position-relative" data-bs-toggle="dropdown" type="button"
            data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false" title="Pusat Notifikasi &amp; Pemberitahuan">
            <i class="ti ti-bell topbar-link-icon"></i>
            @if ($unreadCount > 0)
                <span class="badge badge-square bg-danger topbar-badge animate-pulse" style="font-size: 10px; padding: 2px 5px;">
                    {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                </span>
            @endif
        </button>

        <div class="dropdown-menu p-0 dropdown-menu-end dropdown-menu-lg shadow-lg border-0" style="border-radius: 0.85rem; overflow: hidden; min-width: 330px;">
            <!-- Header Notifikasi Multi-Type -->
            <div class="px-3 py-2.5 border-bottom bg-light bg-opacity-50">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="m-0 fs-13 fw-bold text-dark">
                            <i class="ti ti-bell-ringing me-1 text-primary"></i> Notifikasi
                        </h6>
                    </div>
                    <div class="col-auto">
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger-subtle text-danger border border-danger-subtle py-1 px-2 fs-11 fw-semibold">
                                {{ $unreadCount }} Baru
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success border border-success-subtle py-1 px-2 fs-11">
                                <i class="ti ti-check me-1"></i>Terbaru
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- List Item Notifikasi Universal -->
            <div style="max-height: 330px" data-simplebar="">
                @forelse ($notifItems as $item)
                    <a href="{{ $item['url'] }}"
                        class="dropdown-item notification-item py-2.5 px-3 text-wrap border-bottom border-light d-block hover-bg-light transition-all">
                        <div class="d-flex gap-2.5 align-items-center">
                            <!-- Avatar / Icon Bulat -->
                            <div class="position-relative flex-shrink-0">
                                @if (!empty($item['avatar']))
                                    <img src="{{ $item['avatar'] }}" alt="{{ $item['title'] }}"
                                        class="rounded-circle object-fit-cover border"
                                        style="width: 38px; height: 38px; object-fit: cover; object-position: top;">
                                @else
                                    <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary border" style="width: 38px; height: 38px;">
                                        <i class="{{ $item['icon'] }} fs-18"></i>
                                    </div>
                                @endif

                                @if ($item['type'] === 'registration')
                                    <span class="position-absolute bottom-0 end-0 bg-warning border border-2 border-white rounded-circle"
                                        style="width: 11px; height: 11px;" title="Registrasi Baru"></span>
                                @elseif ($item['type'] === 'chat_message')
                                    <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle"
                                        style="width: 11px; height: 11px;" title="Pesan Baru"></span>
                                @elseif ($item['type'] === 'deactivate_request')
                                    <span class="position-absolute bottom-0 end-0 bg-danger border border-2 border-white rounded-circle"
                                        style="width: 11px; height: 11px;" title="Permintaan Nonaktif"></span>
                                @endif
                            </div>

                            <!-- Detail Pesan Notifikasi -->
                            <div class="flex-grow-1 overflow-hidden">
                                <div class="d-flex justify-content-between align-items-center mb-0.5">
                                    <h6 class="mb-0 fs-13 fw-semibold text-dark text-truncate" style="max-width: 140px;">
                                        {{ $item['title'] }}
                                    </h6>
                                    <span class="badge {{ $item['badge_class'] }} border fs-10 px-1.5 py-0.5">
                                        {{ $item['badge_label'] }}
                                    </span>
                                </div>
                                <p class="text-muted fs-12 mb-1 text-truncate">
                                    {{ $item['subtitle'] ?: $item['message'] }}
                                </p>
                                <div class="d-flex align-items-center justify-content-between text-muted fs-11">
                                    <span><i class="ti ti-clock me-1"></i>{{ $item['time_ago'] }}</span>
                                    <span class="text-primary fw-medium"><i class="ti ti-arrow-right fs-12"></i> Buka</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="text-center py-4 px-3">
                        <div class="avatar-md mx-auto mb-2">
                            <span class="avatar-title bg-success-subtle text-success rounded-circle fs-24 d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="ti ti-circle-check"></i>
                            </span>
                        </div>
                        <h6 class="fs-13 fw-semibold mb-1 text-dark">Tidak Ada Pemberitahuan Baru</h6>
                        <p class="text-muted fs-12 mb-0">Semua tugas, registrasi, dan pesan sistem telah diproses.</p>
                    </div>
                @endforelse
            </div>

            <!-- Footer Link Universal -->
            @can('read manajemenpengguna/users')
                <a href="{{ route('admin.manajemenpengguna.users.index') }}"
                    class="dropdown-item text-center text-primary text-decoration-underline link-offset-2 fw-semibold notify-item border-top border-light py-2 fs-12 bg-light bg-opacity-25">
                    Kelola Semua Data Pengguna &rarr;
                </a>
            @endcan
        </div>
    </div>
</div>
