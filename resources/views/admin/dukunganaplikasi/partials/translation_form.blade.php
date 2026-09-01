<div class="mb-3">
    <label for="form_module" class="form-label">Modul / Domain Terjemahan <span class="text-danger">*</span></label>
    <select class="form-select translation-input" id="form_module" name="module" required>
        <option value="sidebar_menu" selected>🧭 Sidebar: Menu Dinamis (Aplikasi)</option>
        <option value="sidebar_template">📂 Sidebar: Template Bawaan</option>
        <option value="topbar">🔔 Topbar & Navigasi Global</option>
        <option value="auth">🔐 Autentikasi & Akun</option>
        <option value="customizer">🎨 Admin Customizer</option>
        <option value="frontpage">🌐 Landing Page & Website</option>
    </select>
    <small class="text-muted">Pilih kelompok kamus tempat key terjemahan ini disimpan.</small>
</div>

<div class="mb-3">
    <label for="form_key" class="form-label">Key Terjemahan (Data Lang) <span class="text-danger">*</span></label>
    <input type="text" class="form-control translation-input" id="form_key" name="key" placeholder="Contoh: laporan-keuangan" required>
    <small class="text-muted">Gunakan format slug/huruf kecil dengan tanda hubung (misal: <code>laporan-keuangan</code>).</small>
</div>

<div class="mb-3">
    <label for="form_text_id" class="form-label">Terjemahan Bahasa Indonesia (ID) <span class="text-danger">*</span></label>
    <textarea class="form-control translation-input" id="form_text_id" name="text_id" rows="2" placeholder="Contoh: Laporan Keuangan" required></textarea>
</div>

<div class="mb-3">
    <label for="form_text_en" class="form-label">Terjemahan Bahasa Inggris (EN) <span class="text-danger">*</span></label>
    <textarea class="form-control translation-input" id="form_text_en" name="text_en" rows="2" placeholder="Contoh: Financial Reports" required></textarea>
</div>
