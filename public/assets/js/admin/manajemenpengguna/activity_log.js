/**
 * Activity Log Module JavaScript
 * Standardized per Repalogic Dashboard Architecture Guidelines
 */

document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const config = window.ActivityLogConfig || {};
    const routes = config.routes || {};

    // 1. Custom Date Range Toggle
    const dateRangeSelect = document.getElementById('filter-date-range');
    const customDateContainer = document.getElementById('custom-date-container');

    if (dateRangeSelect && customDateContainer) {
        dateRangeSelect.addEventListener('change', function () {
            if (this.value === 'custom') {
                customDateContainer.classList.remove('d-none');
            } else {
                customDateContainer.classList.add('d-none');
            }
        });
    }

    // 2. Modal Detail Populator with Event Delegation (Rule 2)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-view-detail');
        if (!btn) return;

        const logId = btn.getAttribute('data-id');
        if (!logId) return;

        fetchDetail(logId);
    });

    function fetchDetail(id) {
        const detailModalEl = document.getElementById('modal-detail-log');
        if (!detailModalEl) return;

        const modal = new bootstrap.Modal(detailModalEl);
        modal.show();

        // Clear existing values
        document.getElementById('detail-causer-name').innerText = 'Memuat...';
        document.getElementById('detail-causer-email').innerText = '...';
        document.getElementById('detail-log-module').innerText = '...';
        document.getElementById('detail-event-badge').innerText = '...';
        document.getElementById('detail-event-badge').className = 'badge bg-secondary';
        document.getElementById('detail-created-at').innerText = '...';
        document.getElementById('detail-time-ago').innerText = '...';
        document.getElementById('detail-ip-address').innerText = '...';
        const uaEl = document.getElementById('detail-user-agent');
        if (uaEl) {
            uaEl.innerText = '...';
            uaEl.title = '';
        }
        document.getElementById('detail-description').innerText = 'Memuat rincian aktivitas...';
        document.getElementById('diff-table-body').innerHTML = '<tr><td colspan="3" class="text-center py-3 text-muted">Memuat data diff...</td></tr>';
        document.getElementById('json-viewer-content').innerHTML = '<code>Memuat data JSON...</code>';

        fetch(`${routes.showDetail}/${id}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(res => {
            if (!res.success || !res.data) {
                if (window.showError) window.showError('Gagal memuat rincian data log aktivitas.');
                return;
            }

            const data = res.data;

            // Populate Metadata
            document.getElementById('detail-causer-avatar').src = data.causer_avatar;
            document.getElementById('detail-causer-name').innerText = data.causer_name;
            document.getElementById('detail-causer-email').innerText = data.causer_email;
            document.getElementById('detail-log-module').innerText = data.log_name_label;
            
            const eventBadge = document.getElementById('detail-event-badge');
            eventBadge.className = `badge ${data.event_badge_class}`;
            eventBadge.innerHTML = `<i class="${data.event_icon} me-1"></i>${data.event.toUpperCase()}`;

            document.getElementById('detail-created-at').innerText = data.created_at;
            document.getElementById('detail-time-ago').innerText = data.time_ago;
            document.getElementById('detail-ip-address').innerText = data.ip_address;
            
            if (uaEl) {
                uaEl.innerText = data.user_agent;
                uaEl.title = data.user_agent;
            }

            document.getElementById('detail-description').innerText = data.description;

            // Populate JSON Viewer
            const jsonFormatted = JSON.stringify(data.properties || {}, null, 2);
            document.getElementById('json-viewer-content').innerHTML = `<code>${escapeHtml(jsonFormatted)}</code>`;

            // Populate Diff Visualizer
            renderVisualDiff(data.properties);
        })
        .catch(err => {
            console.error(err);
            if (window.showError) window.showError('Terjadi kesalahan saat memuat data dari server.');
        });
    }

    function renderVisualDiff(properties) {
        const tableBody = document.getElementById('diff-table-body');
        const emptyState = document.getElementById('diff-empty-state');
        const tableContainer = document.getElementById('diff-table-container');

        if (!properties || (Object.keys(properties).length === 0)) {
            emptyState.classList.remove('d-none');
            tableContainer.classList.add('d-none');
            return;
        }

        emptyState.classList.add('d-none');
        tableContainer.classList.remove('d-none');

        const oldData = properties.old || {};
        const newData = properties.attributes || {};

        // Collect all distinct keys
        const allKeys = Array.from(new Set([...Object.keys(oldData), ...Object.keys(newData)]));

        if (allKeys.length === 0) {
            emptyState.classList.remove('d-none');
            tableContainer.classList.add('d-none');
            return;
        }

        let html = '';
        allKeys.forEach(key => {
            const hasOld = Object.prototype.hasOwnProperty.call(oldData, key);
            const hasNew = Object.prototype.hasOwnProperty.call(newData, key);

            const oldVal = hasOld ? formatValue(oldData[key]) : '<span class="text-muted fst-italic">[Tidak ada data sebelumnya]</span>';
            const newVal = hasNew ? formatValue(newData[key]) : '<span class="text-muted fst-italic">[Tidak diubah / Dihapus]</span>';

            const isDifferent = hasOld && hasNew && (JSON.stringify(oldData[key]) !== JSON.stringify(newData[key]));

            let oldClass = 'diff-neutral';
            let newClass = 'diff-neutral';

            if (hasOld && !hasNew) {
                oldClass = 'diff-old';
            } else if (!hasOld && hasNew) {
                newClass = 'diff-new';
            } else if (isDifferent) {
                oldClass = 'diff-old';
                newClass = 'diff-new';
            }

            html += `
                <tr>
                    <td class="fw-semibold text-dark align-middle font-monospace fs-12">
                        <i class="ti ti-code-dots me-1 text-primary"></i>${escapeHtml(key)}
                    </td>
                    <td>
                        <div class="diff-value-box ${oldClass}">${oldVal}</div>
                    </td>
                    <td>
                        <div class="diff-value-box ${newClass}">${newVal}</div>
                    </td>
                </tr>
            `;
        });

        tableBody.innerHTML = html;
    }

    function formatValue(val) {
        if (val === null || val === undefined) {
            return '<span class="text-muted fst-italic">NULL</span>';
        }
        if (typeof val === 'boolean') {
            return val ? '<span class="text-success fw-bold">TRUE (1)</span>' : '<span class="text-danger fw-bold">FALSE (0)</span>';
        }
        if (typeof val === 'object') {
            return `<pre class="mb-0 fs-11"><code>${escapeHtml(JSON.stringify(val, null, 2))}</code></pre>`;
        }
        return escapeHtml(String(val));
    }

    function escapeHtml(str) {
        if (typeof str !== 'string') return str;
        return str
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
});
