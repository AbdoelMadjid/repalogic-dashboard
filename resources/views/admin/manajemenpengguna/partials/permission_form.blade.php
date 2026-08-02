<div class="row">
    <div class="col-12 mb-3">
        <label for="form_permission_target" class="form-label fw-semibold">Target Modul / Fitur Aplikasi <span class="text-danger">*</span></label>
        <input type="text" class="form-control permission-input" id="form_permission_target" name="target" placeholder="Contoh: dukunganaplikasi/menu, manajemenpengguna/role" required>
        <div class="form-text text-muted">Gunakan format slug rute modul (contoh: <code>manajemenpengguna/users</code>).</div>
    </div>

    <div class="col-12 mb-3">
        <label class="form-label fw-semibold">Pilih Tipe Aksi Permission (CRUD) <span class="text-danger">*</span></label>
        <div class="d-flex flex-wrap gap-3 p-3 bg-light rounded border">
            <div class="form-check">
                <input class="form-check-input action-checkbox permission-input" type="checkbox" name="actions[]" value="create" id="act_create" checked style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em;">
                <label class="form-check-label fw-bold text-success" for="act_create">CREATE</label>
            </div>
            <div class="form-check">
                <input class="form-check-input action-checkbox permission-input" type="checkbox" name="actions[]" value="read" id="act_read" checked style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em;">
                <label class="form-check-label fw-bold text-info" for="act_read">READ</label>
            </div>
            <div class="form-check">
                <input class="form-check-input action-checkbox permission-input" type="checkbox" name="actions[]" value="update" id="act_update" checked style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em;">
                <label class="form-check-label fw-bold text-warning" for="act_update">UPDATE</label>
            </div>
            <div class="form-check">
                <input class="form-check-input action-checkbox permission-input" type="checkbox" name="actions[]" value="delete" id="act_delete" checked style="border: 2px solid #475569 !important; width: 1.25em; height: 1.25em;">
                <label class="form-check-label fw-bold text-danger" for="act_delete">DELETE</label>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label for="form_permission_menu_id" class="form-label fw-semibold">Tautkan ke Modul Menu System (Opsional)</label>
        <select class="form-select permission-input" id="form_permission_menu_id" name="menu_id">
            <option value="">-- Standalone (Tidak Terikat Menu Mana Pun) --</option>
            @foreach ($parentMenus as $pMenu)
                <option value="{{ $pMenu->id }}" class="fw-bold">
                    {{ $pMenu->name }} ({{ $pMenu->getPermissionTarget() }})
                </option>

                @foreach ($pMenu->subMenus as $cMenu)
                    <option value="{{ $cMenu->id }}">
                        └─ {{ $cMenu->name }} ({{ $cMenu->getPermissionTarget() }})
                    </option>

                    @foreach ($cMenu->subMenus as $scMenu)
                        <option value="{{ $scMenu->id }}">
                            └─ └─ {{ $scMenu->name }} ({{ $scMenu->getPermissionTarget() }})
                        </option>
                    @endforeach
                @endforeach
            @endforeach
        </select>
        <div class="form-text text-muted">Menautkan modul menu akan mengaitkan permission ini secara otomatis pada matriks Hak Akses Role.</div>
    </div>
</div>
