<!-- Card Permohonan Penonaktifan Akun (Danger Zone) -->
<div class="card shadow-sm border border-danger-subtle mb-4">
    <div class="card-header bg-danger text-white py-3">
        <h5 class="card-title text-white mb-0 fw-bold fs-13 d-flex align-items-center gap-1.5">
            <i class="ti ti-user-x me-1"></i>
            <span>Permohonan Penonaktifan Akun</span>
            <span class="badge bg-white bg-opacity-25 text-white font-monospace fs-10">Danger Zone</span>
        </h5>
    </div>
    <div class="card-body">
        @if ($user->isDeactivationRequested())
            <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start gap-3 p-3 mb-0 rounded-3" style="background-color: #fffbeb; color: #92400e;">
                <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 mt-1">
                    <i class="ti ti-hourglass-low fs-20"></i>
                </div>
                <div class="w-100">
                    <h6 class="fw-bold mb-1 text-dark">Permohonan Penonaktifan Sedang Diproses</h6>
                    <p class="fs-13 mb-2 text-muted">
                        Anda telah mengajukan permohonan penonaktifan akun pada <strong class="text-dark">{{ $user->deactivation_requested_at->format('d F Y (H:i)') }} WIB</strong>. Permintaan ini sedang menunggu tinjauan dan konfirmasi dari Administrator sistem.
                    </p>
                    @if(!empty($user->deactivation_reason))
                        <div class="p-3 bg-white border border-warning-subtle rounded-2 fs-13 mb-2">
                            <strong class="text-dark d-block mb-1"><i class="ti ti-notes me-1"></i>Alasan Pengajuan:</strong>
                            <span class="text-secondary fst-italic">"{{ $user->deactivation_reason }}"</span>
                        </div>
                    @endif
                    <form action="{{ route('admin.profil-pengguna.cancel-deactivation') }}" method="POST" data-confirm="Apakah Anda yakin ingin membatalkan permohonan penonaktifan akun Anda?">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-warning fw-semibold">
                            <i class="ti ti-x me-1"></i> Batalkan Permohonan Penonaktifan
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="mb-3">
                <h5 class="fw-bold text-dark fs-15 mb-1.5">Ingin menonaktifkan akun Anda?</h5>
                <p class="text-muted fs-13 mb-0">
                    Jika Anda ingin berhenti menggunakan layanan untuk sementara atau permanen, Anda dapat mengajukan permohonan penonaktifan akun kepada Administrator. Setelah disetujui, akun Anda tidak akan dapat digunakan untuk masuk ke dalam sistem.
                </p>
            </div>
            <button type="button" class="btn btn-outline-danger btn-sm w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#modal-request-deactivation">
                <i class="ti ti-user-off me-1"></i> Minta Nonaktifkan Akun
            </button>
        @endif
    </div>
</div>
