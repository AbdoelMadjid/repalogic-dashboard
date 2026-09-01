/**
 * Manajemen Pengguna (Users) Module JavaScript
 * Path: public/assets/js/admin/manajemenpengguna/users.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.UsersConfig || {};
    const routes = config.routes || {};
    const defaultAvatarUrl = config.defaultAvatarUrl || '/assets/images/users/default-avatar.svg';
    const defaultCoverUrl = config.defaultCoverUrl || '/assets/images/profile-bg.jpg';

    // Event delegation untuk tombol Tolak Pendaftaran & Tolak Nonaktif
    document.addEventListener('click', function(e) {
        const btnRejectReg = e.target.closest('.btn-reject-registration-modal');
        if (btnRejectReg) {
            const userId = btnRejectReg.getAttribute('data-user-id');
            const userName = btnRejectReg.getAttribute('data-user-name');
            const form = document.getElementById('form-reject-registration');
            const nameLabel = document.getElementById('reject-reg-user-name');

            if (form && userId) {
                form.action = `/admin/manajemenpengguna/users/${userId}/reject-registration`;
            }
            if (nameLabel) nameLabel.textContent = userName || 'Pengguna';

            const modalEl = document.getElementById('modal-reject-registration');
            if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                const modal = new window.bootstrap.Modal(modalEl);
                modal.show();
            }
        }

        const btnRejectDeact = e.target.closest('.btn-reject-deactivation-modal');
        if (btnRejectDeact) {
            const userId = btnRejectDeact.getAttribute('data-user-id');
            const userName = btnRejectDeact.getAttribute('data-user-name');
            const userReason = btnRejectDeact.getAttribute('data-user-reason');
            const form = document.getElementById('form-reject-deactivation');
            const nameLabel = document.getElementById('reject-deact-user-name');
            const reasonBox = document.getElementById('reject-deact-user-reason-box');

            if (form && userId) {
                form.action = `/admin/manajemenpengguna/users/${userId}/reject-deactivation`;
            }
            if (nameLabel) nameLabel.textContent = userName || 'Pengguna';
            if (reasonBox) {
                reasonBox.textContent = userReason ? `Alasan Pengajuan User: "${userReason}"` : 'Alasan Pengajuan User: Tidak mencantumkan alasan khusus.';
            }

            const modalEl = document.getElementById('modal-reject-deactivation');
            if (modalEl && window.bootstrap && window.bootstrap.Modal) {
                const modal = new window.bootstrap.Modal(modalEl);
                modal.show();
            }
        }
    });

    let currentPage = 1;
    let pageSize = 25;

    const searchInput = document.getElementById('table-search-input');
    const lengthSelect = document.getElementById('table-length-select');
    const tableInfoBar = document.getElementById('table-info-bar');
    const paginationUl = document.getElementById('table-pagination');

    function updateTableDisplay() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedLength = lengthSelect ? lengthSelect.value : '25';
        pageSize = selectedLength === 'all' ? Infinity : parseInt(selectedLength, 10);

        let matchingRows = [];
        document.querySelectorAll('.user-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            if (query === '' || text.includes(query)) {
                matchingRows.push(row);
            } else {
                row.style.display = 'none';
            }
        });

        const totalMatching = matchingRows.length;
        const totalPages = pageSize === Infinity ? 1 : (Math.ceil(totalMatching / pageSize) || 1);

        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = pageSize === Infinity ? 0 : (currentPage - 1) * pageSize;
        const endIndex = pageSize === Infinity ? totalMatching : Math.min(startIndex + pageSize, totalMatching);

        matchingRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        if (tableInfoBar) {
            if (totalMatching === 0) {
                tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> pengguna';
            } else if (pageSize === Infinity) {
                tableInfoBar.innerHTML = `Menampilkan semua <strong>${totalMatching}</strong> pengguna`;
            } else {
                tableInfoBar.innerHTML = `Menampilkan <strong>${startIndex + 1}</strong> sampai <strong>${endIndex}</strong> dari <strong>${totalMatching}</strong> pengguna`;
            }
        }

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        if (!paginationUl) return;

        if (totalPages <= 1 || pageSize === Infinity) {
            paginationUl.innerHTML = '';
            return;
        }

        let html = '';
        const prevDisabled = currentPage === 1 ? ' disabled' : '';
        html += `<li class="page-item${prevDisabled}" data-page="1" title="Halaman Awal"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-left fs-14"></i></a></li>`;
        html += `<li class="page-item${prevDisabled}" data-page="${currentPage - 1}" title="Sebelumnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left fs-14"></i></a></li>`;

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        for (let p = startPage; p <= endPage; p++) {
            const activeClass = p === currentPage ? ' active' : '';
            html += `<li class="page-item${activeClass}" data-page="${p}"><a class="page-link" href="javascript:void(0);">${p}</a></li>`;
        }

        const nextDisabled = currentPage === totalPages ? ' disabled' : '';
        html += `<li class="page-item${nextDisabled}" data-page="${currentPage + 1}" title="Berikutnya"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right fs-14"></i></a></li>`;
        html += `<li class="page-item${nextDisabled}" data-page="${totalPages}" title="Halaman Akhir"><a class="page-link" href="javascript:void(0);"><i class="ti ti-chevrons-right fs-14"></i></a></li>`;

        paginationUl.innerHTML = html;

        paginationUl.querySelectorAll('.page-item:not(.disabled)').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetPage = parseInt(this.getAttribute('data-page'), 10);
                if (targetPage && targetPage !== currentPage) {
                    currentPage = targetPage;
                    updateTableDisplay();
                }
            });
        });
    }

    if (lengthSelect) {
        lengthSelect.addEventListener('change', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    // Auto search jika terdapat parameter ?search= di URL
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('search');
    if (searchParam && searchInput) {
        searchInput.value = searchParam;
    }

    if (searchInput && searchInput.value.trim() !== '') {
        setTimeout(function() {
            searchInput.focus();
            searchInput.select();
        }, 150);
    }

    updateTableDisplay();

    // Modal & Action Handlers (Event Delegation)
    const userModalElement = document.getElementById('userModal');
    const userModal = userModalElement ? new bootstrap.Modal(userModalElement) : null;
    const userForm = document.getElementById('userForm');
    const modalTitle = document.getElementById('userModalTitle');
    const methodSpoofingContainer = document.getElementById('methodSpoofingContainer');
    const btnSubmitForm = document.getElementById('btnSubmitForm');
    const formInputs = document.querySelectorAll('.user-input');
    const passwordInput = document.getElementById('form_user_password');
    const passwordHelp = document.getElementById('help_user_password');
    const passwordLabel = document.getElementById('label_user_password');

    const avatarInput = document.getElementById('form_user_avatar');
    const avatarPreview = document.getElementById('form_avatar_preview');
    const btnResetAvatar = document.getElementById('btn_reset_avatar');
    const removeAvatarInput = document.getElementById('form_remove_avatar');

    // Live Avatar Preview Listener
    if (avatarInput) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    if (avatarPreview) avatarPreview.src = evt.target.result;
                    if (btnResetAvatar) btnResetAvatar.classList.remove('d-none');
                    if (removeAvatarInput) removeAvatarInput.value = '0';
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Reset Avatar Button Listener
    if (btnResetAvatar) {
        btnResetAvatar.addEventListener('click', function(e) {
            e.preventDefault();
            if (avatarInput) avatarInput.value = '';
            if (avatarPreview) avatarPreview.src = defaultAvatarUrl;
            if (removeAvatarInput) removeAvatarInput.value = '1';
            btnResetAvatar.classList.add('d-none');
        });
    }

    function formatDateTime(dateStr) {
        if (!dateStr) return '-';
        try {
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        } catch (e) {
            return dateStr;
        }
    }

    function formatDateOnly(dateStr) {
        if (!dateStr) return '-';
        try {
            const d = new Date(dateStr);
            if (isNaN(d.getTime())) return dateStr;
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            });
        } catch (e) {
            return dateStr;
        }
    }

    function resetTabsToFirst() {
        const firstTabBtn = document.getElementById('user-tab-account-btn');
        if (firstTabBtn) {
            const tabInstance = bootstrap.Tab.getOrCreateInstance(firstTabBtn);
            tabInstance.show();
        }
    }

    function populateDetailsAndConfig(user) {
        const detail = user ? user.detail : null;
        const detailEmptyAlert = document.getElementById('detail_empty_alert');

        if (detail) {
            if (detailEmptyAlert) detailEmptyAlert.classList.add('d-none');
            const elNik = document.getElementById('view_detail_nik');
            if (elNik) elNik.textContent = detail.nik || '-';
            const elNama = document.getElementById('view_detail_nama_ktp');
            if (elNama) elNama.textContent = detail.nama_ktp || '-';

            let ttl = [];
            if (detail.tempat_lahir) ttl.push(detail.tempat_lahir);
            if (detail.tanggal_lahir) ttl.push(formatDateOnly(detail.tanggal_lahir));
            const elTtl = document.getElementById('view_detail_ttl');
            if (elTtl) elTtl.textContent = ttl.length > 0 ? ttl.join(', ') : '-';

            const elJk = document.getElementById('view_detail_jenis_kelamin');
            if (elJk) elJk.textContent = detail.jenis_kelamin || '-';
            const elGoldar = document.getElementById('view_detail_golongan_darah');
            if (elGoldar) elGoldar.textContent = detail.golongan_darah || '-';
            const elAgama = document.getElementById('view_detail_agama');
            if (elAgama) elAgama.textContent = detail.agama || '-';
            const elKawin = document.getElementById('view_detail_status_perkawinan');
            if (elKawin) elKawin.textContent = detail.status_perkawinan || '-';
            const elKerja = document.getElementById('view_detail_pekerjaan');
            if (elKerja) elKerja.textContent = detail.pekerjaan || '-';
            const elWni = document.getElementById('view_detail_kewarganegaraan');
            if (elWni) elWni.textContent = detail.kewarganegaraan || 'WNI';

            const elAlamat = document.getElementById('view_detail_alamat_jalan');
            if (elAlamat) elAlamat.textContent = detail.alamat_jalan || '-';

            let rtrwblok = [];
            if (detail.blok) rtrwblok.push('Blok ' + detail.blok);
            if (detail.rt || detail.rw) rtrwblok.push('RT ' + (detail.rt || '-') + ' / RW ' + (detail.rw || '-'));
            const elRtRw = document.getElementById('view_detail_rt_rw_blok');
            if (elRtRw) elRtRw.textContent = rtrwblok.length > 0 ? rtrwblok.join(', ') : '-';

            const elDesa = document.getElementById('view_detail_desa_kelurahan');
            if (elDesa) elDesa.textContent = detail.desa_kelurahan || '-';
            const elKec = document.getElementById('view_detail_kecamatan');
            if (elKec) elKec.textContent = detail.kecamatan || '-';
            const elKab = document.getElementById('view_detail_kabupaten_kota');
            if (elKab) elKab.textContent = detail.kabupaten_kota || '-';
            const elProv = document.getElementById('view_detail_provinsi');
            if (elProv) elProv.textContent = detail.provinsi || '-';
            const elPos = document.getElementById('view_detail_kode_pos');
            if (elPos) elPos.textContent = detail.kode_pos || '-';

            const fotoKtpContainer = document.getElementById('view_detail_foto_ktp_container');
            if (fotoKtpContainer) {
                if (detail.foto_ktp_url) {
                    fotoKtpContainer.innerHTML = `
                        <a href="${detail.foto_ktp_url}" target="_blank" class="d-inline-block border rounded overflow-hidden shadow-sm" title="Klik untuk memperbesar Foto KTP">
                            <img src="${detail.foto_ktp_url}" alt="Foto KTP" class="img-fluid" style="max-height: 140px; object-fit: contain;">
                        </a>
                    `;
                } else {
                    fotoKtpContainer.innerHTML = '<span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>';
                }
            }
        } else {
            if (detailEmptyAlert) detailEmptyAlert.classList.remove('d-none');
            const elNik = document.getElementById('view_detail_nik');
            if (elNik) elNik.textContent = '-';
            const elNama = document.getElementById('view_detail_nama_ktp');
            if (elNama) elNama.textContent = '-';
            const elTtl = document.getElementById('view_detail_ttl');
            if (elTtl) elTtl.textContent = '-';
            const elJk = document.getElementById('view_detail_jenis_kelamin');
            if (elJk) elJk.textContent = '-';
            const elGoldar = document.getElementById('view_detail_golongan_darah');
            if (elGoldar) elGoldar.textContent = '-';
            const elAgama = document.getElementById('view_detail_agama');
            if (elAgama) elAgama.textContent = '-';
            const elKawin = document.getElementById('view_detail_status_perkawinan');
            if (elKawin) elKawin.textContent = '-';
            const elKerja = document.getElementById('view_detail_pekerjaan');
            if (elKerja) elKerja.textContent = '-';
            const elWni = document.getElementById('view_detail_kewarganegaraan');
            if (elWni) elWni.textContent = '-';
            const elAlamat = document.getElementById('view_detail_alamat_jalan');
            if (elAlamat) elAlamat.textContent = '-';
            const elRtRw = document.getElementById('view_detail_rt_rw_blok');
            if (elRtRw) elRtRw.textContent = '-';
            const elDesa = document.getElementById('view_detail_desa_kelurahan');
            if (elDesa) elDesa.textContent = '-';
            const elKec = document.getElementById('view_detail_kecamatan');
            if (elKec) elKec.textContent = '-';
            const elKab = document.getElementById('view_detail_kabupaten_kota');
            if (elKab) elKab.textContent = '-';
            const elProv = document.getElementById('view_detail_provinsi');
            if (elProv) elProv.textContent = '-';
            const elPos = document.getElementById('view_detail_kode_pos');
            if (elPos) elPos.textContent = '-';
            const fotoKtpContainer = document.getElementById('view_detail_foto_ktp_container');
            if (fotoKtpContainer) fotoKtpContainer.innerHTML = '<span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>';
        }

        // 3. Tab Preferensi & Sampul (user_configs)
        const userConfig = user ? user.config : null;
        const configEmptyAlert = document.getElementById('config_empty_alert');
        const completionPct = user ? (user.profile_completion_percentage || 0) : 0;

        const completionBadge = document.getElementById('view_config_completion_badge');
        const completionBar = document.getElementById('view_config_completion_bar');
        if (completionBadge) completionBadge.textContent = `${completionPct}%`;
        if (completionBar) {
            completionBar.style.width = `${completionPct}%`;
            completionBar.setAttribute('aria-valuenow', completionPct);
        }

        const coverImg = document.getElementById('view_config_cover_preview');
        const coverPosText = document.getElementById('view_config_cover_pos_text');
        const mottoBox = document.getElementById('view_config_motto_box');
        const themeBadge = document.getElementById('view_config_theme_badge');

        if (user && user.cover_bg_url) {
            if (coverImg) coverImg.src = user.cover_bg_url;
        } else {
            if (coverImg) coverImg.src = defaultCoverUrl;
        }

        const posY = (userConfig && userConfig.cover_position_y !== null && userConfig.cover_position_y !== undefined) ? userConfig.cover_position_y : (user && user.cover_position_y ? user.cover_position_y : 0);
        if (coverImg) coverImg.style.objectPosition = `center ${posY}%`;
        if (coverPosText) coverPosText.textContent = `${posY}%`;

        const motto = (userConfig && userConfig.motto) ? userConfig.motto : (user && user.motto ? user.motto : 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.');
        if (mottoBox) mottoBox.textContent = `"${motto}"`;

        const themeMode = (userConfig && userConfig.theme_mode) ? userConfig.theme_mode : 'light';
        if (themeBadge) {
            themeBadge.innerHTML = `<i class="ti ti-sun-moon me-1"></i> ${themeMode.toUpperCase()}`;
        }

        if (userConfig) {
            if (configEmptyAlert) configEmptyAlert.classList.add('d-none');
        } else {
            if (configEmptyAlert) configEmptyAlert.classList.remove('d-none');
        }
    }

    function populateForm(user, isViewMode = false) {
        // 1. Tab Akun & Kredensial
        const nameInput = document.getElementById('form_user_name');
        if (nameInput) nameInput.value = user.name || '';
        const emailInput = document.getElementById('form_user_email');
        if (emailInput) emailInput.value = user.email || '';
        const statusSelect = document.getElementById('form_user_status');
        if (statusSelect) statusSelect.value = user.status || 'active';

        if (avatarPreview) {
            avatarPreview.src = user.avatar_url ? user.avatar_url : defaultAvatarUrl;
        }

        if (btnResetAvatar) {
            if (!isViewMode && user.avatar) {
                btnResetAvatar.classList.remove('d-none');
            } else {
                btnResetAvatar.classList.add('d-none');
            }
        }

        const userRoles = user.role_names || (user.roles ? user.roles.map(r => r.name || r) : []);
        userRoles.forEach(rName => {
            const roleCb = document.querySelectorAll(`input[name="roles[]"][value="${rName}"]`);
            roleCb.forEach(cb => cb.checked = true);
        });

        // Audit Persetujuan
        const auditBox = document.getElementById('user_approval_audit_box');
        if (auditBox) {
            if (user.approved_at || user.approver) {
                auditBox.classList.remove('d-none');
                const elApprBy = document.getElementById('audit_approved_by');
                if (elApprBy) elApprBy.textContent = user.approver ? user.approver.name : (user.approved_by ? `User ID #${user.approved_by}` : '-');
                const elApprAt = document.getElementById('audit_approved_at');
                if (elApprAt) elApprAt.textContent = user.approved_at ? formatDateTime(user.approved_at) : '-';
            } else {
                auditBox.classList.add('d-none');
            }
        }

        // 2. Tab Identitas KTP & Preferensi
        populateDetailsAndConfig(user);
    }

    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-user-action');
        if (!btn || !userModal || !userForm) return;
        e.preventDefault();

        const action = btn.getAttribute('data-action');
        const userDataRaw = btn.getAttribute('data-user');
        const user = userDataRaw ? JSON.parse(userDataRaw) : null;

        userForm.reset();
        if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '';
        formInputs.forEach(input => input.disabled = false);
        if (btnSubmitForm) btnSubmitForm.classList.remove('d-none');
        document.querySelectorAll('.user-role-checkbox').forEach(cb => cb.checked = false);
        if (removeAvatarInput) removeAvatarInput.value = '0';
        if (btnResetAvatar) btnResetAvatar.classList.add('d-none');
        if (avatarPreview) avatarPreview.src = defaultAvatarUrl;

        resetTabsToFirst();

        if (action === 'create') {
            if (modalTitle) modalTitle.innerHTML = '<i class="ti ti-user-plus me-1 text-primary"></i> Tambah Pengguna Baru';
            userForm.action = routes.store || '';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Simpan Pengguna';
            if (passwordInput) passwordInput.required = true;
            if (passwordLabel) passwordLabel.innerHTML = 'Kata Sandi (Password) <span class="text-danger">*</span>';
            if (passwordHelp) passwordHelp.textContent = 'Wajib diisi saat membuat akun baru (minimal 8 karakter).';
            const statusSelect = document.getElementById('form_user_status');
            if (statusSelect) statusSelect.value = 'active';

            populateDetailsAndConfig(null);
            const auditBox = document.getElementById('user_approval_audit_box');
            if (auditBox) auditBox.classList.add('d-none');

        } else if (action === 'edit' && user) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-user-edit me-1 text-warning"></i> Edit Pengguna: ${user.name}`;
            userForm.action = `${routes.base}/${user.id}`;
            if (methodSpoofingContainer) methodSpoofingContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            if (btnSubmitForm) btnSubmitForm.innerHTML = '<i class="ti ti-device-floppy me-1"></i> Perbarui Pengguna';
            if (passwordInput) passwordInput.required = false;
            if (passwordLabel) passwordLabel.innerHTML = 'Kata Sandi Baru (Opsional)';
            if (passwordHelp) passwordHelp.textContent = 'Kosongkan jika tidak ingin mengubah kata sandi.';

            populateForm(user, false);

        } else if (action === 'view' && user) {
            if (modalTitle) modalTitle.innerHTML = `<i class="ti ti-eye me-1 text-info"></i> Detail Pengguna: ${user.name}`;
            userForm.action = '#';
            if (btnSubmitForm) btnSubmitForm.classList.add('d-none');
            populateForm(user, true);
            formInputs.forEach(input => input.disabled = true);
        }

        userModal.show();
    });
});
