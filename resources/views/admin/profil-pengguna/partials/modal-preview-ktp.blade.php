<!-- MODAL PREVIEW FOTO KTP (RULE 4 COMPLIANCE: Clean modal-lg layout) -->
@php
    $detail = $user->detail ?? null;
@endphp

@if (!empty($detail?->foto_ktp_url))
    <div class="modal fade" id="modal-preview-ktp" tabindex="-1" aria-labelledby="modalPreviewKtpLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white py-3">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ti ti-id fs-22"></i>
                        <h5 class="modal-title text-white mb-0" id="modalPreviewKtpLabel">Preview Berkas Foto KTP</h5>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center bg-light">
                    <div class="bg-white p-2 rounded border shadow-sm d-inline-block w-100 mb-3">
                        <img src="{{ $detail->foto_ktp_url }}" alt="Foto KTP {{ $user->name }}" class="img-fluid rounded" style="max-height: 520px; width: 100%; object-fit: contain;">
                    </div>
                    <div class="text-start bg-white p-3 rounded border">
                        <div class="row g-2 fs-13">
                            <div class="col-sm-6">
                                <span class="text-muted d-block"><i class="ti ti-credit-card me-1"></i> NIK:</span>
                                <strong class="text-dark">{{ $detail->nik ?? '-' }}</strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted d-block"><i class="ti ti-user me-1"></i> Nama Lengkap (KTP):</span>
                                <strong class="text-dark">{{ $detail->nama_ktp ?? $user->name }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-2 px-3 d-flex justify-content-between align-items-center">
                    <a href="{{ $detail->foto_ktp_url }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="ti ti-external-link me-1"></i> Buka di Tab Baru
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ $detail->foto_ktp_url }}" download="KTP-{{ \Illuminate\Support\Str::slug($user->name) }}" class="btn btn-sm btn-primary">
                            <i class="ti ti-download me-1"></i> Unduh Berkas
                        </a>
                        <button type="button" class="btn btn-sm btn-secondary px-3" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
