/**
 * Dukungan Aplikasi - Backup Database Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/backup-db.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // =========================================================================
    // 1. Hashtag-Free Tab State Persistence (Rule 17 & 18 Compliance)
    // =========================================================================
    const tabButtons = document.querySelectorAll('#backupTab button[data-bs-toggle="tab"]');
    const STORAGE_TAB_KEY = 'repalogic_active_backup_tab';

    // Restore active tab from localStorage if available
    const savedTabTarget = localStorage.getItem(STORAGE_TAB_KEY);
    if (savedTabTarget) {
        const targetBtn = document.querySelector(`#backupTab button[data-bs-target="${savedTabTarget}"]`);
        if (targetBtn && typeof bootstrap !== 'undefined' && bootstrap.Tab) {
            const tabInstance = bootstrap.Tab.getOrCreateInstance(targetBtn);
            tabInstance.show();
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function(e) {
            const target = e.target.getAttribute('data-bs-target');
            if (target) {
                localStorage.setItem(STORAGE_TAB_KEY, target);
            }
        });
    });

    // =========================================================================
    // 2. Manual Backup Form Interactivity
    // =========================================================================
    const radioFull = document.getElementById('type_full');
    const radioSelective = document.getElementById('type_selective');
    const panelSelective = document.getElementById('panel-selective-tables');
    const cardFull = document.getElementById('card-option-full');
    const cardSelective = document.getElementById('card-option-selective');

    const radioDownload = document.getElementById('target_download');
    const radioSave = document.getElementById('target_save');
    const cardDownload = document.getElementById('card-output-download');
    const cardSave = document.getElementById('card-output-save');

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

    // =========================================================================
    // 3. Automated Scheduled Backup Interactivity
    // =========================================================================
    const scheduleEnabledSwitch = document.getElementById('backup_schedule_enabled');
    const scheduleDetailsContainer = document.getElementById('schedule-details-container');
    const scheduleFrequencySelect = document.getElementById('backup_schedule_frequency');
    const scheduleDayContainer = document.getElementById('schedule-day-container');
    const labelScheduleDay = document.getElementById('label-schedule-day');

    if (scheduleEnabledSwitch && scheduleDetailsContainer) {
        scheduleEnabledSwitch.addEventListener('change', function() {
            scheduleDetailsContainer.style.opacity = this.checked ? '1' : '0.6';
        });
    }

    if (scheduleFrequencySelect && scheduleDayContainer) {
        scheduleFrequencySelect.addEventListener('change', function() {
            const val = this.value;
            if (val === 'weekly') {
                scheduleDayContainer.style.display = 'block';
                if (labelScheduleDay) labelScheduleDay.innerHTML = '<i class="ti ti-calendar-event me-1 text-primary"></i>Hari Pelaksanaan (Mingguan)';
            } else if (val === 'monthly') {
                scheduleDayContainer.style.display = 'block';
                if (labelScheduleDay) labelScheduleDay.innerHTML = '<i class="ti ti-calendar-event me-1 text-primary"></i>Tanggal Pelaksanaan (Bulanan)';
            } else {
                scheduleDayContainer.style.display = 'none';
            }
        });
    }

    // Manual Trigger Scheduled Run Confirmation
    const formRunScheduledNow = document.getElementById('form-run-scheduled-now');
    if (formRunScheduledNow) {
        formRunScheduledNow.addEventListener('submit', function(e) {
            if (!this.getAttribute('data-confirmed')) {
                e.preventDefault();
                const form = this;
                if (window.showConfirm) {
                    window.showConfirm({
                        title: 'Jalankan Backup Terjadwal Sekarang?',
                        text: 'Sistem akan mengeksekusi proses dump database otomatis saat ini juga dan melakukan sinkronisasi ke cloud jika telah diaktifkan.',
                        isDanger: false,
                        onConfirm: () => {
                            form.setAttribute('data-confirmed', 'true');
                            form.submit();
                        }
                    });
                } else {
                    form.submit();
                }
            }
        });
    }

    // =========================================================================
    // 4. Cloud Storage Provider Selection & Test Connection
    // =========================================================================
    const cloudProviderCards = document.querySelectorAll('.card-cloud-provider');
    const panelConfigS3 = document.getElementById('panel-config-s3');
    const panelConfigGDrive = document.getElementById('panel-config-gdrive');

    function updateCloudProviderPanels(provider) {
        cloudProviderCards.forEach(c => {
            if (c.getAttribute('data-provider') === provider) {
                c.classList.add('active');
                const radio = c.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            } else {
                c.classList.remove('active');
            }
        });

        if (panelConfigS3) panelConfigS3.style.display = (provider === 's3') ? 'block' : 'none';
        if (panelConfigGDrive) panelConfigGDrive.style.display = (provider === 'gdrive') ? 'block' : 'none';
    }

    cloudProviderCards.forEach(card => {
        card.addEventListener('click', function() {
            const provider = this.getAttribute('data-provider') || 'none';
            updateCloudProviderPanels(provider);
        });
    });

    // Test Cloud Connection AJAX
    const btnTestCloud = document.getElementById('btn-test-cloud-conn');
    const testSpinner = document.getElementById('btn-test-cloud-spinner');
    const testResultAlert = document.getElementById('cloud-test-result-alert');
    const testIcon = document.getElementById('cloud-test-icon');
    const testMessage = document.getElementById('cloud-test-message');

    if (btnTestCloud) {
        btnTestCloud.addEventListener('click', function() {
            const activeRadio = document.querySelector('input[name="backup_cloud_driver"]:checked');
            const provider = activeRadio ? activeRadio.value : 'none';

            if (provider === 'none') {
                if (window.showWarning) {
                    window.showWarning('Pilih salah satu penyedia cloud storage (AWS S3 atau Google Drive) untuk melakukan uji koneksi.', 'Pilih Provider');
                }
                return;
            }

            const payload = {
                driver: provider,
                _token: window.BackupDbConfig?.csrfToken || document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            };

            if (provider === 's3') {
                payload.s3_key = document.getElementById('backup_cloud_s3_key')?.value || '';
                payload.s3_secret = document.getElementById('backup_cloud_s3_secret')?.value || '';
                payload.s3_bucket = document.getElementById('backup_cloud_s3_bucket')?.value || '';
                payload.s3_region = document.getElementById('backup_cloud_s3_region')?.value || '';
                payload.s3_endpoint = document.getElementById('backup_cloud_s3_endpoint')?.value || '';
                payload.s3_use_path_style = document.getElementById('backup_cloud_s3_use_path_style')?.checked ? 1 : 0;
            } else if (provider === 'gdrive') {
                payload.gdrive_folder_id = document.getElementById('backup_cloud_gdrive_folder_id')?.value || '';
                payload.gdrive_service_account = document.getElementById('backup_cloud_gdrive_service_account')?.value || '';
            }

            // Show Loading
            btnTestCloud.disabled = true;
            if (testSpinner) testSpinner.classList.remove('d-none');
            if (testResultAlert) testResultAlert.classList.add('d-none');

            fetch(window.BackupDbConfig.routes.testCloud, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': payload._token
                },
                body: JSON.stringify(payload)
            })
            .then(res => res.json())
            .then(data => {
                btnTestCloud.disabled = false;
                if (testSpinner) testSpinner.classList.add('d-none');

                if (testResultAlert && testIcon && testMessage) {
                    testResultAlert.classList.remove('d-none', 'alert-success', 'alert-danger');
                    testIcon.className = 'ti fs-18 flex-shrink-0';

                    if (data.success) {
                        testResultAlert.classList.add('alert-success');
                        testIcon.classList.add('ti-circle-check-filled', 'text-success');
                        testMessage.innerHTML = `<strong>Koneksi Berhasil!</strong> ${data.message}`;
                        if (window.showToast) window.showToast(data.message, 'success');
                    } else {
                        testResultAlert.classList.add('alert-danger');
                        testIcon.classList.add('ti-alert-circle-filled', 'text-danger');
                        testMessage.innerHTML = `<strong>Koneksi Gagal:</strong> ${data.message}`;
                        if (window.showError) window.showError(data.message, 'Uji Koneksi Gagal');
                    }
                }
            })
            .catch(err => {
                btnTestCloud.disabled = false;
                if (testSpinner) testSpinner.classList.add('d-none');

                if (testResultAlert && testIcon && testMessage) {
                    testResultAlert.classList.remove('d-none', 'alert-success', 'alert-danger');
                    testResultAlert.classList.add('alert-danger');
                    testIcon.className = 'ti ti-alert-circle-filled fs-18 text-danger flex-shrink-0';
                    testMessage.innerHTML = `<strong>Kesalahan Jaringan:</strong> ${err.message}`;
                }
            });
        });
    }

    // =========================================================================
    // 5. Event Delegation for Delete Backup File Confirmation (Rule 2 & 9 Compliance)
    // =========================================================================
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
