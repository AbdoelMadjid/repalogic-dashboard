<!-- PANEL 6: RIWAYAT AKTIVITAS SAYA (CLUSTER 7) -->
<div class="tab-pane fade" id="tab-activity-logs" role="tabpanel" aria-labelledby="tab-activity-logs-btn">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-history me-1.5"></i> Riwayat Aktivitas & Sesi Terkini Akun Anda</h5>
            <span class="badge bg-white bg-opacity-25 text-white fs-11 font-monospace">15 Log Terakhir</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle border mb-0">
                    <thead class="table-light align-middle text-center text-nowrap">
                        <tr class="align-middle text-center text-nowrap">
                            <th class="text-center align-middle text-nowrap" style="width: 18%;">Waktu (WIB)</th>
                            <th class="text-center align-middle text-nowrap" style="width: 15%;">Modul</th>
                            <th class="text-center align-middle text-nowrap" style="width: 14%;">Aksi / Event</th>
                            <th class="text-center align-middle text-nowrap">Deskripsi Aktivitas</th>
                            <th class="text-center align-middle text-nowrap" style="width: 15%;">Alamat IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentActivities ?? [] as $act)
                            <tr>
                                <td class="text-center align-middle text-nowrap fs-12 text-muted font-monospace">
                                    {{ $act->created_at ? $act->created_at->format('d/m/Y H:i:s') : '-' }}
                                </td>
                                <td class="text-center align-middle text-nowrap fs-12">
                                    <span class="badge bg-light text-dark border">{{ $act->log_name_label }}</span>
                                </td>
                                <td class="text-center align-middle text-nowrap">
                                    <span class="badge {{ $act->event_badge_class }} fs-11">
                                        <i class="{{ $act->event_icon }} me-1"></i> {{ ucfirst($act->event) }}
                                    </span>
                                </td>
                                <td class="align-middle fs-13 text-dark">
                                    {{ $act->description }}
                                </td>
                                <td class="text-center align-middle text-nowrap fs-12 font-monospace text-secondary">
                                    {{ $act->ip_address ?? '-' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="ti ti-info-circle fs-24 d-block mb-1 text-muted"></i>
                                    Belum ada catatan riwayat aktivitas personal.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
