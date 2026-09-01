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

    // ==========================================
    // DOM ELEMENTS - TABLE & PAGINATION
    // ==========================================
    const searchInput = document.getElementById('table-search-input');
    const lengthSelect = document.getElementById('table-length-select');
    const roleFilter = document.getElementById('table-filter-role');
    const statusFilter = document.getElementById('table-filter-status');
    const btnResetFilters = document.getElementById('btn-reset-filters');
    const tableInfoBar = document.getElementById('table-info-bar');
    const paginationUl = document.getElementById('table-pagination');

    let currentPage = 1;
    let pageSize = 25;

    // ==========================================
    // DOM ELEMENTS - USER MODAL (CREATE / EDIT / VIEW)
    // ==========================================
    const userModalElement = document.getElementById('userModal');
    const userModal = userModalElement && window.bootstrap && window.bootstrap.Modal ? new window.bootstrap.Modal(userModalElement) : null;
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

    // ==========================================
    // DOM ELEMENTS - BULK & QUICK ROLE ASSIGNMENT
    // ==========================================
    const checkAllPage = document.getElementById('check-all-page-users');
    const checkAllGlobal = document.getElementById('check-all-global-users');
    const checkAllLabel = document.getElementById('check-all-users-label');
    const selectedBadge = document.getElementById('selected-user-badge');
    const selectedCountSpan = document.getElementById('selected-user-count');
    const btnBulkAssignRole = document.getElementById('btn-bulk-assign-role');
    const btnDeselectAll = document.getElementById('btn-deselect-all-users');

    const bulkRoleModalEl = document.getElementById('bulkRoleModal');
    const bulkRoleModal = bulkRoleModalEl && window.bootstrap && window.bootstrap.Modal ? new window.bootstrap.Modal(bulkRoleModalEl) : null;
    const formBulkAssignRole = document.getElementById('formBulkAssignRole');
    const bulkRoleModalTitleText = document.getElementById('bulkRoleModalTitleText');
    const bulkRoleUserIdsContainer = document.getElementById('bulkRoleUserIdsContainer');
    const bulkRoleUserChipsList = document.getElementById('bulkRoleUserChipsList');
    const bulkRoleUserCountBadge = document.getElementById('bulkRoleUserCountBadge');
    const btnSelectAllModalRoles = document.getElementById('btn-select-all-modal-roles');
    const btnClearModalRoles = document.getElementById('btn-clear-modal-roles');

    // ==========================================
    // HELPER FUNCTIONS
    // ==========================================
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
                month: 'short',
                year: 'numeric'
            });
        } catch (e) {
            return dateStr;
        }
    }

    function resetTabsToFirst() {
        const firstTabBtn = document.querySelector('#userFormTabs .nav-link:first-child');
        if (firstTabBtn && window.bootstrap && window.bootstrap.Tab) {
            const tabInstance = new window.bootstrap.Tab(firstTabBtn);
            tabInstance.show();
        }
    }

    function getVisibleRows() {
        return Array.from(document.querySelectorAll('.user-row')).filter(row => row.style.display !== 'none');
    }

    function getMatchingRows() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedRole = roleFilter ? roleFilter.value.toLowerCase().trim() : '';
        const selectedStatus = statusFilter ? statusFilter.value.toLowerCase().trim() : '';

        return Array.from(document.querySelectorAll('.user-row')).filter(row => {
            const text = row.textContent.toLowerCase();
            let roles = [];
            try {
                roles = JSON.parse(row.getAttribute('data-roles') || '[]');
            } catch(e) {}
            const status = (row.getAttribute('data-status') || '').toLowerCase();

            const matchesQuery = query === '' || text.includes(query);
            const matchesRole = selectedRole === '' || roles.map(r => r.toLowerCase()).includes(selectedRole);
            const matchesStatus = selectedStatus === '' || status === selectedStatus;

            return matchesQuery && matchesRole && matchesStatus;
        });
    }

    // ==========================================
    // TABLE FILTER & PAGINATION ENGINE
    // ==========================================
    function updateTableDisplay() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedRole = roleFilter ? roleFilter.value.toLowerCase().trim() : '';
        const selectedStatus = statusFilter ? statusFilter.value.toLowerCase().trim() : '';
        const selectedLength = lengthSelect ? lengthSelect.value : '25';
        pageSize = selectedLength === 'all' ? Infinity : parseInt(selectedLength, 10);

        let matchingRows = [];
        document.querySelectorAll('.user-row').forEach(row => {
            const text = row.textContent.toLowerCase();
            let roles = [];
            try {
                roles = JSON.parse(row.getAttribute('data-roles') || '[]');
            } catch(e) {}
            const status = (row.getAttribute('data-status') || '').toLowerCase();

            const matchesQuery = query === '' || text.includes(query);
            const matchesRole = selectedRole === '' || roles.map(r => r.toLowerCase()).includes(selectedRole);
            const matchesStatus = selectedStatus === '' || status === selectedStatus;

            if (matchesQuery && matchesRole && matchesStatus) {
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
        updateBulkSelectionUI();
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

    // ==========================================
    // BULK SELECTION ENGINE
    // ==========================================
    function updateBulkSelectionUI() {
        const checkedItems = document.querySelectorAll('.user-check-item:checked');
        const count = checkedItems.length;

        if (selectedBadge) selectedBadge.style.display = count > 0 ? 'inline-flex' : 'none';
        if (selectedCountSpan) selectedCountSpan.textContent = count;
        if (btnBulkAssignRole) btnBulkAssignRole.disabled = count === 0;
        if (btnDeselectAll) btnDeselectAll.style.display = count > 0 ? 'inline-flex' : 'none';

        // Update row active styling
        document.querySelectorAll('.user-row').forEach(row => {
            const cb = row.querySelector('.user-check-item');
            if (cb && cb.checked) {
                row.classList.add('table-active');
            } else {
                row.classList.remove('table-active');
            }
        });

        // Update page check-all status
        const visibleRows = getVisibleRows();
        const visibleChecks = visibleRows.map(r => r.querySelector('.user-check-item')).filter(Boolean);
        const visibleCheckedCount = visibleChecks.filter(cb => cb.checked).length;

        if (checkAllPage) {
            checkAllPage.checked = visibleChecks.length > 0 && visibleCheckedCount === visibleChecks.length;
            checkAllPage.indeterminate = visibleCheckedCount > 0 && visibleCheckedCount < visibleChecks.length;
        }

        // Update global check-all status
        const matchingRows = getMatchingRows();
        const matchingChecks = matchingRows.map(r => r.querySelector('.user-check-item')).filter(Boolean);
        const matchingCheckedCount = matchingChecks.filter(cb => cb.checked).length;

        if (checkAllGlobal) {
            checkAllGlobal.checked = matchingChecks.length > 0 && matchingCheckedCount === matchingChecks.length;
            checkAllGlobal.indeterminate = matchingCheckedCount > 0 && matchingCheckedCount < matchingChecks.length;
        }

        if (checkAllLabel) {
            checkAllLabel.textContent = `Pilih Semua (${matchingRows.length})`;
        }
    }

    // ==========================================
    // DETAILS & CONFIG POPULATION
    // ==========================================
    function populateDetailsAndConfig(user) {
        const detail = (user && user.detail) ? user.detail : null;
        const configData = (user && user.config) ? user.config : null;

        const nikInput = document.getElementById('form_detail_nik');
        const phoneInput = document.getElementById('form_detail_phone_number');
        const birthPlaceInput = document.getElementById('form_detail_birth_place');
        const birthDateInput = document.getElementById('form_detail_birth_date');
        const genderInput = document.getElementById('form_detail_gender');
        const addressInput = document.getElementById('form_detail_address');

        if (nikInput) nikInput.value = detail ? (detail.nik || '') : '';
        if (phoneInput) phoneInput.value = detail ? (detail.phone_number || '') : '';
        if (birthPlaceInput) birthPlaceInput.value = detail ? (detail.birth_place || '') : '';
        if (birthDateInput) birthDateInput.value = detail ? (detail.birth_date || '') : '';
        if (genderInput) genderInput.value = detail ? (detail.gender || '') : '';
        if (addressInput) addressInput.value = detail ? (detail.address || '') : '';

        const detailEmptyAlert = document.getElementById('detail_empty_alert');
        const hasDetail = detail && (detail.nik || detail.telepon || detail.nama_ktp || detail.alamat_jalan || detail.foto_ktp);
        if (detailEmptyAlert) {
            if (hasDetail) {
                detailEmptyAlert.classList.add('d-none');
            } else {
                detailEmptyAlert.classList.remove('d-none');
            }
        }

        const viewNik = document.getElementById('view_detail_nik');
        const viewTelepon = document.getElementById('view_detail_telepon');
        const viewNamaKtp = document.getElementById('view_detail_nama_ktp');
        const viewTtl = document.getElementById('view_detail_ttl');
        const viewGender = document.getElementById('view_detail_jenis_kelamin');
        const viewGoldar = document.getElementById('view_detail_golongan_darah');
        const viewAgama = document.getElementById('view_detail_agama');
        const viewStatusNikah = document.getElementById('view_detail_status_perkawinan');
        const viewPekerjaan = document.getElementById('view_detail_pekerjaan');
        const viewWarga = document.getElementById('view_detail_kewarganegaraan');
        const viewAlamat = document.getElementById('view_detail_alamat_jalan');
        const viewRtRw = document.getElementById('view_detail_rt_rw_blok');
        const viewDesa = document.getElementById('view_detail_desa_kelurahan');
        const viewKec = document.getElementById('view_detail_kecamatan');
        const viewKab = document.getElementById('view_detail_kabupaten_kota');
        const viewProv = document.getElementById('view_detail_provinsi');
        const viewKodePos = document.getElementById('view_detail_kode_pos');
        const viewFotoKtpContainer = document.getElementById('view_detail_foto_ktp_container');

        if (viewNik) viewNik.textContent = detail && detail.nik ? detail.nik : '-';
        if (viewTelepon) {
            if (detail && detail.telepon) {
                const waUrl = detail.telepon_wa_url || `https://wa.me/${detail.telepon.replace(/\D/g, '')}`;
                viewTelepon.innerHTML = `<a href="${waUrl}" target="_blank" class="text-success text-decoration-none fw-semibold d-inline-flex align-items-center"><i class="ti ti-brand-whatsapp me-1"></i>${detail.telepon} <i class="ti ti-external-link fs-11 ms-1"></i></a>`;
            } else {
                viewTelepon.textContent = '-';
            }
        }
        if (viewNamaKtp) viewNamaKtp.textContent = detail && detail.nama_ktp ? detail.nama_ktp : (user ? user.name : '-');
        if (viewTtl) {
            const bp = detail && detail.tempat_lahir ? detail.tempat_lahir : '';
            const bd = detail && detail.tanggal_lahir ? formatDateOnly(detail.tanggal_lahir) : '';
            viewTtl.textContent = (bp && bd) ? `${bp}, ${bd}` : (bp || bd || '-');
        }
        if (viewGender) viewGender.textContent = detail && detail.jenis_kelamin ? detail.jenis_kelamin : '-';
        if (viewGoldar) viewGoldar.textContent = detail && detail.golongan_darah ? detail.golongan_darah : '-';
        if (viewAgama) viewAgama.textContent = detail && detail.agama ? detail.agama : '-';
        if (viewStatusNikah) viewStatusNikah.textContent = detail && detail.status_perkawinan ? detail.status_perkawinan : '-';
        if (viewPekerjaan) viewPekerjaan.textContent = detail && detail.pekerjaan ? detail.pekerjaan : '-';
        if (viewWarga) viewWarga.textContent = detail && detail.kewarganegaraan ? detail.kewarganegaraan : 'WNI';

        if (viewAlamat) viewAlamat.textContent = detail && detail.alamat_jalan ? detail.alamat_jalan : '-';
        if (viewRtRw) {
            const rt = detail && detail.rt ? detail.rt : '-';
            const rw = detail && detail.rw ? detail.rw : '-';
            const blok = detail && detail.blok ? detail.blok : '-';
            viewRtRw.textContent = `RT: ${rt} / RW: ${rw} / Blok: ${blok}`;
        }
        if (viewDesa) viewDesa.textContent = detail && detail.desa_kelurahan ? detail.desa_kelurahan : '-';
        if (viewKec) viewKec.textContent = detail && detail.kecamatan ? detail.kecamatan : '-';
        if (viewKab) viewKab.textContent = detail && detail.kabupaten_kota ? detail.kabupaten_kota : '-';
        if (viewProv) viewProv.textContent = detail && detail.provinsi ? detail.provinsi : '-';
        if (viewKodePos) viewKodePos.textContent = detail && detail.kode_pos ? detail.kode_pos : '-';

        if (viewFotoKtpContainer) {
            const ktpUrl = detail && detail.foto_ktp_url ? detail.foto_ktp_url : (detail && detail.foto_ktp ? `/storage/${detail.foto_ktp}` : null);
            if (ktpUrl) {
                viewFotoKtpContainer.innerHTML = `
                    <div class="d-flex align-items-center gap-2 mt-1">
                        <img src="${ktpUrl}" alt="KTP ${user ? user.name : ''}" class="img-thumbnail" style="max-height: 70px; max-width: 140px; object-fit: cover;">
                        <a href="${ktpUrl}" target="_blank" class="btn btn-xs btn-outline-primary"><i class="ti ti-zoom-in me-1"></i>Lihat Foto KTP</a>
                    </div>
                `;
            } else {
                viewFotoKtpContainer.innerHTML = `<span class="text-muted fs-12 fst-italic">Belum mengunggah berkas KTP</span>`;
            }
        }

        const mottoInput = document.getElementById('form_config_motto');
        const bioInput = document.getElementById('form_config_bio');
        const themeInput = document.getElementById('form_config_theme');

        if (mottoInput) mottoInput.value = configData ? (configData.motto || '') : '';
        if (bioInput) bioInput.value = configData ? (configData.bio || '') : '';
        if (themeInput) themeInput.value = configData ? (configData.theme || 'light') : 'light';

        const viewMotto = document.getElementById('view_config_motto');
        const viewBio = document.getElementById('view_config_bio');
        const viewTheme = document.getElementById('view_config_theme');
        const viewCoverPreview = document.getElementById('view_config_cover_preview');

        if (viewMotto) viewMotto.textContent = configData && configData.motto ? `"${configData.motto}"` : '-';
        if (viewBio) viewBio.textContent = configData && configData.bio ? configData.bio : '-';
        if (viewTheme) viewTheme.textContent = configData && configData.theme === 'dark' ? 'Mode Gelap (Dark Mode)' : 'Mode Terang (Light Mode)';

        if (viewCoverPreview) {
            if (configData && configData.cover_photo) {
                viewCoverPreview.src = `/storage/${configData.cover_photo}`;
            } else {
                viewCoverPreview.src = defaultCoverUrl;
            }
            const coverPos = configData && configData.cover_position ? configData.cover_position : 50;
            viewCoverPreview.style.objectPosition = `center ${coverPos}%`;
        }
    }

    function populateForm(user, isReadOnly = false) {
        const nameInput = document.getElementById('form_user_name');
        const emailInput = document.getElementById('form_user_email');
        const statusInput = document.getElementById('form_user_status');

        if (nameInput) nameInput.value = user.name || '';
        if (emailInput) emailInput.value = user.email || '';
        if (statusInput) statusInput.value = user.status || 'active';

        const viewName = document.getElementById('view_user_name');
        const viewEmail = document.getElementById('view_user_email');
        const viewStatus = document.getElementById('view_user_status');
        const viewRolesContainer = document.getElementById('view_user_roles_container');

        if (viewName) viewName.textContent = user.name || '-';
        if (viewEmail) viewEmail.textContent = user.email || '-';
        if (viewStatus) {
            let statusBadge = '<span class="badge bg-success-subtle text-success border border-success-subtle fs-12"><i class="ti ti-circle-check me-1"></i>Aktif</span>';
            if (user.status === 'pending') {
                statusBadge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-12"><i class="ti ti-clock me-1"></i>Menunggu Persetujuan</span>';
            } else if (user.status === 'rejected') {
                statusBadge = `<span class="badge bg-danger-subtle text-danger border border-danger-subtle fs-12"><i class="ti ti-user-x me-1"></i>Pendaftaran Ditolak</span>`;
            } else if (user.status === 'inactive') {
                statusBadge = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle fs-12"><i class="ti ti-ban me-1"></i>Nonaktif</span>';
            }
            viewStatus.innerHTML = statusBadge;
        }

        if (viewRolesContainer) {
            let rolesHtml = '';
            if (user.roles && user.roles.length > 0) {
                user.roles.forEach(r => {
                    const badgeClass = r.name === 'superadmin' ? 'bg-danger-subtle text-danger border-danger-subtle' :
                        (r.name === 'admin' ? 'bg-primary-subtle text-primary border-primary-subtle' :
                            (r.name === 'user' ? 'bg-info-subtle text-info border-info-subtle' : 'bg-secondary-subtle text-secondary border-secondary-subtle'));
                    rolesHtml += `<span class="badge ${badgeClass} border fs-12 text-capitalize me-1 mb-1"><i class="ti ti-shield me-1"></i>${r.name}</span>`;
                });
            } else {
                rolesHtml = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-12"><i class="ti ti-alert-circle me-1"></i>Belum Ada Role</span>';
            }
            viewRolesContainer.innerHTML = rolesHtml;
        }

        document.querySelectorAll('.user-role-checkbox').forEach(cb => cb.checked = false);
        if (user.roles && Array.isArray(user.roles)) {
            user.roles.forEach(r => {
                const cb = document.querySelector(`.user-role-checkbox[value="${r.name}"]`);
                if (cb) cb.checked = true;
            });
        }

        if (avatarPreview) {
            avatarPreview.src = user.avatar_url ? user.avatar_url : defaultAvatarUrl;
        }
        if (btnResetAvatar) {
            if (user.avatar) {
                btnResetAvatar.classList.remove('d-none');
            } else {
                btnResetAvatar.classList.add('d-none');
            }
        }

        const editOnlyContainers = document.querySelectorAll('.edit-only-container');
        const viewOnlyContainers = document.querySelectorAll('.view-only-container');

        if (isReadOnly) {
            editOnlyContainers.forEach(el => el.classList.add('d-none'));
            viewOnlyContainers.forEach(el => el.classList.remove('d-none'));
        } else {
            editOnlyContainers.forEach(el => el.classList.remove('d-none'));
            viewOnlyContainers.forEach(el => el.classList.add('d-none'));
        }

        const auditBox = document.getElementById('user_approval_audit_box');
        if (auditBox) {
            if (user.approved_at || user.approved_by) {
                auditBox.classList.remove('d-none');
                const elApprBy = document.getElementById('user_audit_approver_name');
                const elApprAt = document.getElementById('user_audit_approved_at');
                if (elApprBy) elApprBy.textContent = user.approver ? user.approver.name : `Admin #${user.approved_by || '-'}`;
                if (elApprAt) elApprAt.textContent = user.approved_at ? formatDateTime(user.approved_at) : '-';
            } else {
                auditBox.classList.add('d-none');
            }
        }

        populateDetailsAndConfig(user);
    }

    function openRoleModalForUsers(users, customTitle = null) {
        if (!bulkRoleModal || !bulkRoleUserIdsContainer) return;

        bulkRoleUserIdsContainer.innerHTML = '';
        
        const singleCard = document.getElementById('singleUserRoleCard');
        const multiBox = document.getElementById('multiUserRoleBox');
        const singleAvatar = document.getElementById('singleUserAvatar');
        const singleName = document.getElementById('singleUserName');
        const singleEmail = document.getElementById('singleUserEmail');
        const singleCurrentRoles = document.getElementById('singleUserCurrentRoles');

        if (bulkRoleModalTitleText) {
            bulkRoleModalTitleText.textContent = customTitle || (users.length === 1 ? `Atur Peran (Role): ${users[0].name}` : `Atur Peran (Role) untuk ${users.length} Pengguna Terpilih`);
        }

        if (users.length === 1) {
            const u = users[0];
            if (singleCard) singleCard.classList.remove('d-none');
            if (multiBox) multiBox.classList.add('d-none');

            if (singleAvatar) singleAvatar.src = u.avatar || defaultAvatarUrl;
            if (singleName) singleName.textContent = u.name || '-';
            if (singleEmail) singleEmail.textContent = u.email || '-';

            if (singleCurrentRoles) {
                let rolesHtml = '';
                if (u.roles && u.roles.length > 0) {
                    u.roles.forEach(rName => {
                        const badgeClass = rName === 'superadmin' ? 'bg-danger-subtle text-danger border-danger-subtle' :
                            (rName === 'admin' ? 'bg-primary-subtle text-primary border-primary-subtle' :
                                (rName === 'user' ? 'bg-info-subtle text-info border-info-subtle' : 'bg-secondary-subtle text-secondary border-secondary-subtle'));
                        rolesHtml += `<span class="badge ${badgeClass} border fs-11 text-capitalize me-1"><i class="ti ti-shield me-1"></i>${rName}</span>`;
                    });
                } else {
                    rolesHtml = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-11"><i class="ti ti-alert-circle me-1"></i>Belum Ada Role</span>';
                }
                singleCurrentRoles.innerHTML = rolesHtml;
            }
        } else {
            if (singleCard) singleCard.classList.add('d-none');
            if (multiBox) multiBox.classList.remove('d-none');

            if (bulkRoleUserCountBadge) {
                bulkRoleUserCountBadge.textContent = `${users.length} Pengguna`;
            }

            if (bulkRoleUserChipsList) {
                bulkRoleUserChipsList.innerHTML = '';
                users.forEach(u => {
                    const chip = document.createElement('div');
                    chip.className = 'user-chip';
                    chip.innerHTML = `
                        <img src="${u.avatar || defaultAvatarUrl}" alt="${u.name}" onerror="this.src='${defaultAvatarUrl}'">
                        <span>${u.name}</span>
                    `;
                    bulkRoleUserChipsList.appendChild(chip);
                });
            }
        }

        // Set action mode default to 'sync'
        const syncRadio = document.getElementById('mode_sync');
        if (syncRadio) {
            syncRadio.checked = true;
            document.querySelectorAll('.role-mode-card').forEach(c => c.classList.remove('active-mode'));
            const parentCard = syncRadio.closest('.role-mode-card');
            if (parentCard) parentCard.classList.add('active-mode');
        }

        // Reset roles checkboxes
        document.querySelectorAll('.bulk-role-checkbox').forEach(cb => cb.checked = false);

        // Pre-check existing roles if single user
        if (users.length === 1 && Array.isArray(users[0].roles)) {
            users[0].roles.forEach(roleName => {
                const cb = document.querySelector(`.bulk-role-checkbox[value="${roleName}"]`);
                if (cb) cb.checked = true;
            });
        }

        // Populate hidden user IDs
        users.forEach(u => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'user_ids[]';
            input.value = u.id;
            bulkRoleUserIdsContainer.appendChild(input);
        });

        bulkRoleModal.show();
    }

    // ==========================================
    // EVENT LISTENERS - MODAL & FORM
    // ==========================================
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

    if (btnResetAvatar) {
        btnResetAvatar.addEventListener('click', function(e) {
            e.preventDefault();
            if (avatarInput) avatarInput.value = '';
            if (avatarPreview) avatarPreview.src = defaultAvatarUrl;
            if (removeAvatarInput) removeAvatarInput.value = '1';
            btnResetAvatar.classList.add('d-none');
        });
    }

    // Event Delegation: User Action Buttons (Create, Edit, View)
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

    // Event Delegation: Quick Role Button on Table Row
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-quick-role');
        if (!btn) return;
        e.preventDefault();

        const userId = btn.getAttribute('data-user-id');
        const userName = btn.getAttribute('data-user-name');
        const userEmail = btn.getAttribute('data-user-email');
        const userAvatar = btn.getAttribute('data-user-avatar');
        let userRoles = [];
        try {
            userRoles = JSON.parse(btn.getAttribute('data-user-roles') || '[]');
        } catch(err) {}

        const targetUser = [{
            id: userId,
            name: userName,
            email: userEmail,
            avatar: userAvatar,
            roles: userRoles
        }];

        openRoleModalForUsers(targetUser, `Atur Peran (Role): ${userName}`);
    });

    // Event Delegation: Tolak Pendaftaran & Tolak Nonaktif
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

    // ==========================================
    // EVENT LISTENERS - CHECKBOX & BULK ACTIONS
    // ==========================================
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('user-check-item')) {
            updateBulkSelectionUI();
        }
    });

    document.addEventListener('click', function(e) {
        const cell = e.target.closest('.check-cell');
        if (cell && e.target.tagName !== 'INPUT') {
            const cb = cell.querySelector('.user-check-item');
            if (cb) {
                cb.checked = !cb.checked;
                updateBulkSelectionUI();
            }
        }
    });

    if (checkAllPage) {
        checkAllPage.addEventListener('change', function() {
            const isChecked = this.checked;
            const visibleRows = getVisibleRows();
            visibleRows.forEach(row => {
                const cb = row.querySelector('.user-check-item');
                if (cb) cb.checked = isChecked;
            });
            updateBulkSelectionUI();
        });
    }

    if (checkAllGlobal) {
        checkAllGlobal.addEventListener('change', function() {
            const isChecked = this.checked;
            const matchingRows = getMatchingRows();
            matchingRows.forEach(row => {
                const cb = row.querySelector('.user-check-item');
                if (cb) cb.checked = isChecked;
            });
            updateBulkSelectionUI();
        });
    }

    if (btnDeselectAll) {
        btnDeselectAll.addEventListener('click', function() {
            document.querySelectorAll('.user-check-item').forEach(cb => cb.checked = false);
            if (checkAllPage) {
                checkAllPage.checked = false;
                checkAllPage.indeterminate = false;
            }
            if (checkAllGlobal) {
                checkAllGlobal.checked = false;
                checkAllGlobal.indeterminate = false;
            }
            updateBulkSelectionUI();
        });
    }

    document.querySelectorAll('.role-mode-radio').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.role-mode-card').forEach(card => card.classList.remove('active-mode'));
            const parentCard = this.closest('.role-mode-card');
            if (parentCard) parentCard.classList.add('active-mode');
        });
    });

    if (btnSelectAllModalRoles) {
        btnSelectAllModalRoles.addEventListener('click', function() {
            document.querySelectorAll('.bulk-role-checkbox').forEach(cb => cb.checked = true);
        });
    }
    if (btnClearModalRoles) {
        btnClearModalRoles.addEventListener('click', function() {
            document.querySelectorAll('.bulk-role-checkbox').forEach(cb => cb.checked = false);
        });
    }

    if (btnBulkAssignRole) {
        btnBulkAssignRole.addEventListener('click', function() {
            const checkedBoxes = Array.from(document.querySelectorAll('.user-check-item:checked'));
            if (checkedBoxes.length === 0) return;

            const selectedUsers = checkedBoxes.map(cb => {
                let roles = [];
                try {
                    roles = JSON.parse(cb.getAttribute('data-roles') || '[]');
                } catch(err) {}
                return {
                    id: cb.getAttribute('data-id'),
                    name: cb.getAttribute('data-name'),
                    avatar: cb.getAttribute('data-avatar'),
                    roles: roles
                };
            });

            openRoleModalForUsers(selectedUsers);
        });
    }

    if (formBulkAssignRole) {
        formBulkAssignRole.addEventListener('submit', function(e) {
            e.preventDefault();

            const checkedRoles = Array.from(document.querySelectorAll('.bulk-role-checkbox:checked')).map(cb => cb.value);
            const userInputs = document.querySelectorAll('input[name="user_ids[]"]');
            const selectedMode = document.querySelector('input[name="action_mode"]:checked')?.value || 'sync';

            if (userInputs.length === 0) {
                if (window.showWarning) window.showWarning('Tidak ada pengguna yang dipilih.');
                return;
            }

            if (checkedRoles.length === 0 && selectedMode !== 'sync') {
                if (window.showWarning) window.showWarning('Pilih minimal satu peran (role) untuk mode tindakan ini.');
                return;
            }

            const modeLabel = selectedMode === 'sync' ? 'Mengatur Ulang (Sinkronisasi)' : (selectedMode === 'append' ? 'Menambahkan' : 'Mencabut');
            const roleListText = checkedRoles.length > 0 ? checkedRoles.join(', ') : '(Kosongkan Semua Role)';
            const userCount = userInputs.length;

            const confirmText = `Apakah Anda yakin ingin ${modeLabel} peran [${roleListText}] untuk ${userCount} pengguna terpilih?`;

            if (window.showConfirm) {
                window.showConfirm({
                    title: 'Konfirmasi Perubahan Role',
                    text: confirmText,
                    isDanger: selectedMode === 'remove' || (selectedMode === 'sync' && checkedRoles.length === 0),
                    onConfirm: () => {
                        formBulkAssignRole.submit();
                    }
                });
            } else {
                formBulkAssignRole.submit();
            }
        });
    }

    // ==========================================
    // TABLE CONTROLS & INITIAL LOAD
    // ==========================================
    if (lengthSelect) {
        lengthSelect.addEventListener('change', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    if (roleFilter) {
        roleFilter.addEventListener('change', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            currentPage = 1;
            updateTableDisplay();
        });
    }

    if (btnResetFilters) {
        btnResetFilters.addEventListener('click', function() {
            if (searchInput) searchInput.value = '';
            if (roleFilter) roleFilter.value = '';
            if (statusFilter) statusFilter.value = '';
            if (lengthSelect) lengthSelect.value = '25';
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
});
