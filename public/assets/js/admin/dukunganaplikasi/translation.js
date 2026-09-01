/**
 * Dukungan Aplikasi - Translation Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/translation.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    const config = window.TranslationConfig || {};
    const routes = config.routes || {};

    const modalEl = document.getElementById('translationModal');
    const translationModal = modalEl ? new bootstrap.Modal(modalEl) : null;
    const translationForm = document.getElementById('translationForm');
    const modalTitle = document.getElementById('translationModalTitle');
    const methodContainer = document.getElementById('methodSpoofingContainer');
    const btnSubmit = document.getElementById('btnSubmitForm');
    const inputs = document.querySelectorAll('.translation-input');

    // Pagination & Filter Client-Side Logic
    let currentPage = 1;
    let pageSize = 25;

    const searchInput = document.getElementById('table-search-input');
    const categorySelect = document.getElementById('table-category-select');
    const lengthSelect = document.getElementById('table-length-select');
    const tableInfoBar = document.getElementById('table-info-bar');
    const paginationUl = document.getElementById('table-pagination');

    function updateTableDisplay() {
        const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const selectedCat = categorySelect ? categorySelect.value : 'all';
        const selectedLength = lengthSelect ? lengthSelect.value : '25';
        pageSize = selectedLength === 'all' ? Infinity : parseInt(selectedLength, 10);

        let matchingRows = [];
        const activeGroups = new Set();

        document.querySelectorAll('.translation-row').forEach(row => {
            const rowGroup = row.getAttribute('data-group');
            const text = row.textContent.toLowerCase();
            const matchCat = (selectedCat === 'all' || rowGroup === selectedCat);
            const matchQuery = (query === '' || text.includes(query));

            if (matchCat && matchQuery) {
                matchingRows.push(row);
                activeGroups.add(rowGroup);
            } else {
                row.style.display = 'none';
            }
        });

        // Toggle Header Rows visibility based on whether their group has visible items
        document.querySelectorAll('.category-header-row').forEach(headerRow => {
            const group = headerRow.getAttribute('data-group');
            headerRow.style.display = activeGroups.has(group) ? '' : 'none';
        });

        const totalMatching = matchingRows.length;
        const totalPages = Math.ceil(totalMatching / pageSize) || 1;
        if (currentPage > totalPages) currentPage = totalPages;
        if (currentPage < 1) currentPage = 1;

        const startIndex = (currentPage - 1) * pageSize;
        const endIndex = pageSize === Infinity ? totalMatching : startIndex + pageSize;

        matchingRows.forEach((row, index) => {
            if (index >= startIndex && index < endIndex) {
                row.style.display = '';
                const noEl = row.querySelector('.translation-no');
                if (noEl) noEl.textContent = index + 1;
            } else {
                row.style.display = 'none';
            }
        });

        if (tableInfoBar) {
            if (totalMatching === 0) {
                tableInfoBar.innerHTML = 'Menampilkan <strong>0</strong> data terjemahan';
            } else {
                const dispStart = startIndex + 1;
                const dispEnd = Math.min(endIndex, totalMatching);
                tableInfoBar.innerHTML = `Menampilkan <strong>${dispStart}</strong> - <strong>${dispEnd}</strong> dari <strong>${totalMatching}</strong> data terjemahan`;
            }
        }

        renderPagination(totalPages);
    }

    function renderPagination(totalPages) {
        if (!paginationUl) return;
        paginationUl.innerHTML = '';
        if (totalPages <= 1) return;

        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-left"></i></a>`;
        prevLi.addEventListener('click', () => { if (currentPage > 1) { currentPage--; updateTableDisplay(); } });
        paginationUl.appendChild(prevLi);

        for (let i = 1; i <= totalPages; i++) {
            const pageLi = document.createElement('li');
            pageLi.className = `page-item ${i === currentPage ? 'active' : ''}`;
            pageLi.innerHTML = `<a class="page-link" href="javascript:void(0);">${i}</a>`;
            pageLi.addEventListener('click', () => { currentPage = i; updateTableDisplay(); });
            paginationUl.appendChild(pageLi);
        }

        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === totalPages ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="javascript:void(0);"><i class="ti ti-chevron-right"></i></a>`;
        nextLi.addEventListener('click', () => { if (currentPage < totalPages) { currentPage++; updateTableDisplay(); } });
        paginationUl.appendChild(nextLi);
    }

    if (searchInput) searchInput.addEventListener('input', () => { currentPage = 1; updateTableDisplay(); });
    if (categorySelect) categorySelect.addEventListener('change', () => { currentPage = 1; updateTableDisplay(); });
    if (lengthSelect) lengthSelect.addEventListener('change', () => { currentPage = 1; updateTableDisplay(); });

    updateTableDisplay();

    // EVENT DELEGATION FOR ACTION BUTTONS (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.btn-translation-action');
        if (!btn || !translationModal || !translationForm) return;

        const action = btn.getAttribute('data-action');
        const rowDataRaw = btn.getAttribute('data-row');
        const rowData = rowDataRaw ? JSON.parse(rowDataRaw) : null;

        if (methodContainer) methodContainer.innerHTML = '';
        translationForm.reset();
        inputs.forEach(i => i.removeAttribute('disabled'));
        if (btnSubmit) btnSubmit.classList.remove('d-none');

        if (action === 'create') {
            if (modalTitle) modalTitle.textContent = 'Tambah Key Terjemahan Baru';
            translationForm.action = routes.store || '';
            translationModal.show();
        } else if (action === 'edit' && rowData) {
            if (modalTitle) modalTitle.textContent = 'Edit Key Terjemahan: ' + rowData.key;
            if (methodContainer) methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
            const updateUrl = (routes.updateTemplate || '').replace(':key', encodeURIComponent(rowData.key));
            translationForm.action = updateUrl;

            const keyInput = document.getElementById('form_key');
            if (keyInput) keyInput.value = rowData.key;
            const textIdInput = document.getElementById('form_text_id');
            if (textIdInput) textIdInput.value = rowData.text_id;
            const textEnInput = document.getElementById('form_text_en');
            if (textEnInput) textEnInput.value = rowData.text_en;

            translationModal.show();
        } else if (action === 'view' && rowData) {
            if (modalTitle) modalTitle.textContent = 'Detail Key Terjemahan: ' + rowData.key;
            const keyInput = document.getElementById('form_key');
            if (keyInput) keyInput.value = rowData.key;
            const textIdInput = document.getElementById('form_text_id');
            if (textIdInput) textIdInput.value = rowData.text_id;
            const textEnInput = document.getElementById('form_text_en');
            if (textEnInput) textEnInput.value = rowData.text_en;

            inputs.forEach(i => i.setAttribute('disabled', 'disabled'));
            if (btnSubmit) btnSubmit.classList.add('d-none');

            translationModal.show();
        }
    });
});
