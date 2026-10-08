<!-- Card Edit Profil Singkat -->
<div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white py-3">
        <h5 class="card-title text-white mb-0 fw-bold"><i class="ti ti-user-edit me-1"></i> Edit Profil Singkat</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.profil-pengguna.update-quick') }}" method="POST" enctype="multipart/form-data" id="form-quick-edit-profil">
            @csrf
            <div class="mb-3 text-center">
                <div class="d-inline-block position-relative mb-2">
                    <img src="{{ $user->avatar_url }}" id="modal-avatar-preview" alt="avatar"
                        class="rounded-circle img-thumbnail shadow-sm"
                        style="width: 90px; height: 90px; min-width: 90px; min-height: 90px; object-fit: cover; object-position: center; aspect-ratio: 1 / 1;" />
                </div>
                <div class="d-flex justify-content-center align-items-center gap-1.5 flex-wrap">
                    <label for="modal-avatar-input" class="btn btn-sm btn-outline-primary fw-semibold cursor-pointer mb-0" title="Unggah file foto baru dari komputer / perangkat">
                        <i class="ti ti-camera me-1"></i> Pilih Foto Baru
                    </label>
                    <button type="button" class="btn btn-sm btn-outline-secondary fw-semibold mb-0" id="btn-re-crop-current" title="Sesuaikan, perbesar, atau geser posisi foto yang sedang aktif">
                        <i class="ti ti-crop me-1"></i> Edit Posisi
                    </button>
                    <input type="file" name="avatar" id="modal-avatar-input" class="d-none" accept="image/*">
                    <input type="file" name="avatar_original" id="modal-avatar-original-input" class="d-none" accept="image/*">
                    <input type="hidden" name="avatar_crop_data" id="modal-avatar-crop-data" value="">
                </div>
                <span class="fs-12 text-muted d-block mt-1">Format: JPG, PNG, WEBP, SVG (Maks 2MB)</span>
            </div>

            <div class="mb-3">
                <label for="modal_name" class="form-label fw-semibold text-dark fs-13">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="modal_name" name="name" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="modal_email" class="form-label fw-semibold text-dark fs-13">Alamat Email <span class="text-danger">*</span></label>
                <input type="email" class="form-control" id="modal_email" name="email" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="modal_password" class="form-label fw-semibold text-dark fs-13">Kata Sandi Baru</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="modal_password" name="password" placeholder="Kosongkan jika tidak diganti">
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password" title="Lihat/Sembunyikan Kata Sandi">
                        <i class="ti ti-eye"></i>
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="modal_password_confirmation" class="form-label fw-semibold text-dark fs-13">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <input type="password" class="form-control" id="modal_password_confirmation" name="password_confirmation" placeholder="Ulangi kata sandi baru">
                    <button class="btn btn-outline-secondary toggle-password" type="button" data-input-id="modal_password_confirmation" title="Lihat/Sembunyikan Kata Sandi">
                        <i class="ti ti-eye"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-primary btn-sm w-100 fw-semibold">
                <i class="ti ti-device-floppy me-1"></i> Simpan Perubahan Profil
            </button>
        </form>
    </div>
</div>
