/**
 * Dukungan Aplikasi - Backup Database Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/backup-db.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Elements
    const radioFull = document.getElementById('type_full');
    const radioSelective = document.getElementById('type_selective');
    const panelSelective = document.getElementById('panel-selective-tables');
    const cardFull = document.getElementById('card-option-full');
    const cardSelective = document.getElementById('card-option-selective');

    const radioDownload = document.getElementById('target_download');
    const radioSave = document.getElementById('target_save');
    const cardDownload = document.getElementById('card-option-download');
    const cardSave = document.getElementById('card-option-save');

    function toggleBackupType() {
        if (radioSelective && radioSelective.checked) {
            if (panelSelective) panelSelective.style.display = 'block';
            if (cardSelective) cardSelective.classList.add('active');
            if (cardFull) cardFull.classList.remove('active');
        } else {
            if (panelSelective) panelSelective.style.display = 'none';
            if (cardFull) cardFull.classList.add('active');
            if (cardSelective) cardSelective.classList.remove('active');
        }
    }

    function toggleOutputTarget() {
        if (radioSave && radioSave.checked) {
            if (cardSave) cardSave.classList.add('active');
            if (cardDownload) cardDownload.classList.remove('active');
        } else {
            if (cardDownload) cardDownload.classList.add('active');
            if (cardSave) cardSave.classList.remove('active');
        }
    }

    if (radioFull && radioSelective) {
        radioFull.addEventListener('change', toggleBackupType);
        radioSelective.addEventListener('change', toggleBackupType);
    }

    if (radioDownload && radioSave) {
        radioDownload.addEventListener('change', toggleOutputTarget);
        radioSave.addEventListener('change', toggleOutputTarget);
    }

    // Interactive Card Clicking
    if (cardFull) cardFull.addEventListener('click', function() { if (radioFull) { radioFull.checked = true; toggleBackupType(); } });
    if (cardSelective) cardSelective.addEventListener('click', function() { if (radioSelective) { radioSelective.checked = true; toggleBackupType(); } });
    if (cardDownload) cardDownload.addEventListener('click', function() { if (radioDownload) { radioDownload.checked = true; toggleOutputTarget(); } });
    if (cardSave) cardSave.addEventListener('click', function() { if (radioSave) { radioSave.checked = true; toggleOutputTarget(); } });

    // Table Live Search Filtering
    const searchInput = document.getElementById('table-search-input');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const rows = document.querySelectorAll('#table-selective-list tbody tr');

            rows.forEach(row => {
                const tableName = row.getAttribute('data-table-name') || '';
                if (tableName.toLowerCase().includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }

    // Check All / Uncheck All Tables
    const checkAll = document.getElementById('check-all-tables');
    if (checkAll) {
        checkAll.addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.checkbox-table-item');
            checkboxes.forEach(cb => {
                const row = cb.closest('tr');
                if (row && row.style.display !== 'none') {
                    cb.checked = this.checked;
                }
            });
        });
    }

    // Relational Table Alert Notice when checking a table
    document.addEventListener('change', function(e) {
        if (e.target && e.target.classList.contains('checkbox-table-item')) {
            if (e.target.checked) {
                const parents = JSON.parse(e.target.getAttribute('data-parents') || '[]');
                const children = JSON.parse(e.target.getAttribute('data-children') || '[]');

                if (parents.length > 0 || children.length > 0) {
                    const relAlert = document.getElementById('relational-info-alert');
                    const relText = document.getElementById('relational-info-text');
                    
                    let infoMsg = `<strong>Tabel ${e.target.value}</strong> memiliki relasi: `;
                    if (parents.length > 0) {
                        infoMsg += `memerlukan data dari <code>${parents.join(', ')}</code>. `;
                    }
                    if (children.length > 0) {
                        infoMsg += `direferensikan oleh <code>${children.join(', ')}</code>. `;
                    }
                    infoMsg += `Disarankan menyertakan tabel relasi tersebut agar integritas data terjaga.`;

                    if (relAlert && relText) {
                        relText.innerHTML = infoMsg;
                        relAlert.style.display = 'flex';
                    }
                }
            }
        }
    });

    // Event Delegation for Delete Backup File Confirmation (Rule 2 & 9 Compliance)
    document.addEventListener('submit', function(e) {
        const form = e.target.closest('.form-delete-backup');
        if (form && !form.getAttribute('data-confirmed')) {
            e.preventDefault();
            const btn = form.querySelector('.btn-delete-backup');
            const fileName = btn ? btn.getAttribute('data-filename') : 'berkas backup';

            if (window.showConfirm) {
                window.showConfirm({
                    title: 'Hapus Berkas Backup?',
                    text: `Apakah Anda yakin ingin menghapus berkas "${fileName}"? Tindakan ini tidak dapat dibatalkan.`,
                    isDanger: true,
                    onConfirm: () => {
                        form.setAttribute('data-confirmed', 'true');
                        form.submit();
                    }
                });
            } else if (window.Swal) {
                Swal.fire({
                    title: 'Hapus Berkas Backup?',
                    html: `Apakah Anda yakin ingin menghapus berkas <strong>"${fileName}"</strong>?<br>Tindakan ini tidak dapat dibatalkan.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        confirmButton: 'btn btn-danger me-2',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.setAttribute('data-confirmed', 'true');
                        form.submit();
                    }
                });
            } else {
                form.submit();
            }
        }
    });
});
