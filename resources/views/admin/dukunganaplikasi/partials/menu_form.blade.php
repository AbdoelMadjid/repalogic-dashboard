<div class="row">
    <div class="col-md-6 mb-3">
        <label for="form_name" class="form-label">Nama Menu <span class="text-danger">*</span></label>
        <input type="text" class="form-control menu-input" id="form_name" name="name" placeholder="Contoh: Manajemen User" required>
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_data_lang" class="form-label">Translation Key (Data Lang)</label>
        <input type="text" class="form-control menu-input" id="form_data_lang" name="data_lang" placeholder="Contoh: manajemen-user (Otomatis jika kosong)">
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_main_menu_id" class="form-label">Main Menu Parent</label>
        <select class="form-select menu-input" id="form_main_menu_id" name="main_menu_id">
            <option value="">-- Tanpa Parent (Menu Utama) --</option>
            @foreach ($parentMenus as $pMenu)
                <option value="{{ $pMenu->id }}" class="fw-bold">{{ $pMenu->name }}</option>
                @if ($pMenu->subMenus && $pMenu->subMenus->count() > 0)
                    @foreach ($pMenu->subMenus as $cMenu)
                        <option value="{{ $cMenu->id }}">&nbsp;&nbsp;&nbsp;&nbsp;└─ {{ $cMenu->name }} (Sub-Menu L2)</option>
                    @endforeach
                @endif
            @endforeach
        </select>
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_category" class="form-label">Kategori / Header Sub-Menu</label>
        <input type="text" class="form-control menu-input" id="form_category" name="category" placeholder="Contoh: ADMINISTRASI APLIKASI">
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_icon" class="form-label">Icon (Khusus Menu Utama)</label>
        <div class="input-group">
            <span class="input-group-text"><i class="ti ti-category" id="form_icon_preview"></i></span>
            <input type="text" class="form-control menu-input" id="form_icon" name="icon" placeholder="ti ti-settings">
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Hak Akses Permission Spatie (Aksi CRUD)</label>
        <div class="border rounded p-2 bg-light-subtle d-flex flex-wrap gap-3">
            <div class="form-check">
                <input class="form-check-input menu-input action-checkbox" type="checkbox" name="actions[]" value="read" id="action_read" checked>
                <label class="form-check-label fw-medium" for="action_read">
                    <span class="badge bg-info">Read</span> Tampil
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input menu-input action-checkbox" type="checkbox" name="actions[]" value="create" id="action_create" checked>
                <label class="form-check-label fw-medium" for="action_create">
                    <span class="badge bg-success">Create</span> Tambah
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input menu-input action-checkbox" type="checkbox" name="actions[]" value="update" id="action_update" checked>
                <label class="form-check-label fw-medium" for="action_update">
                    <span class="badge bg-warning">Update</span> Edit
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input menu-input action-checkbox" type="checkbox" name="actions[]" value="delete" id="action_delete" checked>
                <label class="form-check-label fw-medium" for="action_delete">
                    <span class="badge bg-danger">Delete</span> Hapus
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label d-block">Diberikan Kepada Role (Siapa Saja Yang Bisa Akses)</label>
        <div class="border rounded p-2 bg-light-subtle d-flex flex-wrap gap-3">
            @foreach ($allRoles as $role)
                <div class="form-check">
                    <input class="form-check-input menu-input role-checkbox" type="checkbox" name="roles[]" value="{{ $role->name }}" id="role_{{ $role->name }}"
                        {{ in_array($role->name, ['superadmin', 'admin']) ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold text-capitalize" for="role_{{ $role->name }}">
                        <span class="badge bg-secondary-subtle text-dark border">{{ $role->name }}</span>
                    </label>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_orders" class="form-label">Urutan (Orders)</label>
        <input type="number" class="form-control menu-input" id="form_orders" name="orders" value="0">
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_route" class="form-label">Nama Route (Laravel Route Name)</label>
        <input type="text" class="form-control menu-input" id="form_route" name="route" placeholder="Contoh: admin.dukunganaplikasi.menu.index">
    </div>

    <div class="col-md-6 mb-3">
        <label for="form_url" class="form-label">URL Kustom (Opsional jika Route terisi)</label>
        <input type="text" class="form-control menu-input" id="form_url" name="url" placeholder="Contoh: admin/dukunganaplikasi/menu">
    </div>

    <div class="col-md-6 mb-2">
        <div class="form-check form-switch mt-4">
            <input class="form-check-input menu-input" type="checkbox" id="form_active" name="active" value="1" checked>
            <label class="form-check-label fw-bold" for="form_active">Aktifkan Menu Ini</label>
        </div>
    </div>
</div>
