<div class="row g-3">
    <div class="col-md-6">
        <label for="form_user_name" class="form-label fw-semibold text-dark fs-13">Nama Lengkap <span class="text-danger">*</span></label>
        <input type="text" name="name" id="form_user_name" class="form-control user-input" placeholder="Masukkan nama lengkap..." required>
    </div>

    <div class="col-md-6">
        <label for="form_user_email" class="form-label fw-semibold text-dark fs-13">Alamat Email <span class="text-danger">*</span></label>
        <input type="email" name="email" id="form_user_email" class="form-control user-input" placeholder="contoh@domain.com" required>
    </div>

    <div class="col-md-12">
        <label for="form_user_status" class="form-label fw-semibold text-dark fs-13">Status Akun Pengguna <span class="text-danger">*</span></label>
        <select name="status" id="form_user_status" class="form-select user-input">
            <option value="active">Aktif (Disetujui &amp; Dapat Login)</option>
            <option value="pending">Menunggu Persetujuan (Pending Registration)</option>
            <option value="inactive">Nonaktif (Akses Login Diblokir)</option>
        </select>
        <small class="text-muted fs-12 d-block mt-1">Status aktivasi akun pengguna dalam sistem.</small>
    </div>

    <div class="col-12">
        <div class="card border mb-0">
            <div class="card-header bg-light py-2">
                <span class="fw-semibold text-dark fs-13">
                    <i class="ti ti-shield me-1 text-primary"></i> Peran Utamakan (Spatie Role)
                </span>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-3">
                    @foreach ($roles as $r)
                        @php
                            $roleBadge = match ($r->name) {
                                'superadmin' => 'text-danger',
                                'admin' => 'text-primary',
                                'user' => 'text-info',
                                default => 'text-secondary'
                            };
                        @endphp
                        <div class="form-check form-check-inline m-0">
                            <input type="checkbox" name="roles[]" value="{{ $r->name }}" id="u_role_{{ $r->id }}" class="form-check-input user-input user-role-checkbox" style="border: 2px solid #475569 !important; width: 1.2em; height: 1.2em; cursor: pointer;">
                            <label class="form-check-label fw-bold {{ $roleBadge }} text-capitalize fs-13 ms-1" for="u_role_{{ $r->id }}" style="cursor: pointer;">
                                {{ $r->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <label for="form_user_password" class="form-label fw-semibold text-dark fs-13" id="label_user_password">Kata Sandi (Password) <span class="text-danger">*</span></label>
        <input type="password" name="password" id="form_user_password" class="form-control user-input" placeholder="Minimal 8 karakter...">
        <small class="text-muted fs-12 d-block mt-1" id="help_user_password">Wajib diisi saat membuat akun baru.</small>
    </div>

    <div class="col-md-6">
        <label for="form_user_password_confirmation" class="form-label fw-semibold text-dark fs-13">Konfirmasi Kata Sandi</label>
        <input type="password" name="password_confirmation" id="form_user_password_confirmation" class="form-control user-input" placeholder="Ulangi kata sandi...">
    </div>
</div>
