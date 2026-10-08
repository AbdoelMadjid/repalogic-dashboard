<!-- MODAL PERMINTAAN NONAKTIFKAN AKUN (RULE 4 COMPLIANCE) -->
<div class="modal fade" id="modal-request-deactivation" tabindex="-1" aria-labelledby="modalRequestDeactivationLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="ti ti-alert-triangle fs-22"></i>
                    <h5 class="modal-title text-white mb-0" id="modalRequestDeactivationLabel">Ajukan Penonaktifan Akun</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.profil-pengguna.request-deactivation') }}" method="POST" id="form-request-deactivation">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-danger border-0 d-flex align-items-start gap-2 mb-3 py-2 px-3 rounded-3" style="background-color: #fef2f2; color: #991b1b;">
                        <i class="ti ti-alert-circle fs-20 flex-shrink-0 mt-1"></i>
                        <div class="fs-13">
                            <strong>Perhatian:</strong> Permintaan penonaktifan akun akan dikirimkan langsung ke Administrator. Setelah disetujui, Anda tidak akan dapat masuk kembali hingga diaktifkan oleh admin.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="deactivation_reason" class="form-label fw-semibold text-dark">Alasan Penonaktifan (Opsional):</label>
                        <textarea name="reason" id="deactivation_reason" rows="3" class="form-control" placeholder="Tuliskan alasan mengapa Anda ingin menonaktifkan akun ini..." maxlength="500"></textarea>
                        <span class="fs-12 text-muted d-block mt-1">Alasan ini akan ditinjau oleh administrator sebelum akun dinonaktifkan.</span>
                    </div>
                </div>

                <div class="modal-footer bg-light py-3">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger px-4 fw-semibold">
                        <i class="ti ti-send me-1"></i> Kirim Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
