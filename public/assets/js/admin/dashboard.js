/**
 * Dashboard Hub Interactivity & ApexCharts Engine
 * Module: Dynamic Dashboard Hub
 * Follows AGENTS.md JavaScript Standards
 */

document.addEventListener('DOMContentLoaded', function () {
    const config = window.DashboardConfig || {};

    // 1. Inisialisasi Grafik Tren Login 7 Hari (Hanya untuk Admin)
    const loginsChartEl = document.querySelector('#chart-logins-trend');
    if (loginsChartEl && typeof ApexCharts !== 'undefined' && config.chartDates) {
        const loginsOptions = {
            series: [
                {
                    name: 'Aktivitas Login',
                    data: config.chartLogins || [0, 0, 0, 0, 0, 0, 0]
                },
                {
                    name: 'Pendaftaran Baru',
                    data: config.chartRegistrations || [0, 0, 0, 0, 0, 0, 0]
                }
            ],
            chart: {
                height: 310,
                type: 'area',
                toolbar: {
                    show: false
                },
                fontFamily: 'inherit'
            },
            colors: ['#3e60d5', '#16a34a'],
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2.5
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: config.chartDates || [],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    style: {
                        colors: '#64748b',
                        fontSize: '12px'
                    },
                    formatter: function (val) {
                        return Math.floor(val);
                    }
                }
            },
            grid: {
                borderColor: '#f1f5f9',
                strokeDashArray: 4
            },
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'light'
            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                fontWeight: 500,
                labels: {
                    colors: '#475569'
                }
            }
        };

        const loginsChart = new ApexCharts(loginsChartEl, loginsOptions);
        loginsChart.render();
    }

    // 2. Inisialisasi Grafik Donut Distribusi Role Spatie (Hanya untuk Admin)
    const rolesChartEl = document.querySelector('#chart-roles-donut');
    if (rolesChartEl && typeof ApexCharts !== 'undefined' && config.roleLabels && config.roleLabels.length > 0) {
        const rolesOptions = {
            series: config.roleCounts || [],
            labels: config.roleLabels || [],
            chart: {
                height: 310,
                type: 'donut',
                fontFamily: 'inherit'
            },
            colors: ['#3e60d5', '#0284c7', '#0d9488', '#e11d48', '#d97706', '#64748b'],
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Total User',
                                fontSize: '14px',
                                fontWeight: 600,
                                color: '#475569',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontWeight: 500,
                labels: {
                    colors: '#475569'
                }
            },
            tooltip: {
                theme: 'light'
            }
        };

        const rolesChart = new ApexCharts(rolesChartEl, rolesOptions);
        rolesChart.render();
    }

    // 3. Event Delegation untuk Quick Approve / Reject Actions di Dashboard (Rule 2 Standard)
    document.addEventListener('click', function (e) {
        // Quick Approve User
        const btnApprove = e.target.closest('.btn-quick-approve-user');
        if (btnApprove) {
            e.preventDefault();
            const form = btnApprove.closest('form');
            const userName = btnApprove.getAttribute('data-user-name') || 'pengguna ini';

            if (window.showConfirm) {
                window.showConfirm({
                    title: 'Setujui Akun Pengguna?',
                    text: `Apakah Anda yakin ingin menyetujui dan mengaktifkan akun "${userName}"?`,
                    isDanger: false,
                    onConfirm: function () {
                        form.submit();
                    }
                });
            } else {
                form.submit();
            }
            return;
        }

        // Quick Approve Deactivation
        const btnApproveDeact = e.target.closest('.btn-quick-approve-deact');
        if (btnApproveDeact) {
            e.preventDefault();
            const form = btnApproveDeact.closest('form');
            const userName = btnApproveDeact.getAttribute('data-user-name') || 'pengguna ini';

            if (window.showConfirm) {
                window.showConfirm({
                    title: 'Setujui Penonaktifan Akun?',
                    text: `Apakah Anda yakin ingin menonaktifkan akun "${userName}" sesuai permohonan? Pengguna akan langsung diputus sesinya.`,
                    isDanger: true,
                    onConfirm: function () {
                        form.submit();
                    }
                });
            } else {
                form.submit();
            }
            return;
        }
    });

    // 4. Jaringan Pertemanan & Interaksi Like Profil (Rule 2 & Rule 9 Standard)
    function getCsrfToken() {
        if (typeof window.getCsrfToken === 'function') {
            return window.getCsrfToken();
        }
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || window.csrfToken || '';
    }
    const routes = config.routes || {};

    // Helper untuk request AJAX JSON dengan CSRF
    async function sendAjax(url, method = 'POST', bodyData = {}) {
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: method !== 'GET' ? JSON.stringify(bodyData) : null
            });

            let data = null;
            try {
                data = await response.json();
            } catch (err) {
                data = null;
            }

            if (!response.ok) {
                if (response.status === 419 || response.status === 401 || (data && data.session_expired)) {
                    if (window.showWarning) {
                        window.showWarning('Sesi Anda telah kedaluwarsa. Mengalihkan ke halaman login...');
                    }
                    setTimeout(function() {
                        window.location.href = (data && data.redirect) ? data.redirect : '/login';
                    }, 1500);
                }
                return data || { success: false, message: 'Terjadi kesalahan pada server.' };
            }

            return data || { success: true };
        } catch (error) {
            console.error('AJAX Error:', error);
            return { success: false, message: 'Terjadi kesalahan pada jaringan server.' };
        }
    }

    document.addEventListener('click', async function (e) {
        // A. Toggle Like Profil
        const btnLike = e.target.closest('.contact-like-btn');
        if (btnLike) {
            e.preventDefault();
            const userId = btnLike.getAttribute('data-user-id');
            const targetUrl = `${routes.toggleLike}/${userId}`;

            btnLike.classList.add('disabled');
            const res = await sendAjax(targetUrl, 'POST');
            btnLike.classList.remove('disabled');

            if (res.success) {
                const countSpan = btnLike.querySelector('.like-count');
                const icon = btnLike.querySelector('i');

                if (countSpan) countSpan.textContent = res.likes_count;

                if (res.liked) {
                    btnLike.classList.add('liked', 'active');
                    btnLike.setAttribute('title', 'Batal Suka Profil');
                    if (icon) {
                        icon.className = 'ti ti-heart-filled text-danger fs-12 me-1';
                    }
                    // Trigger pulse animation
                    btnLike.classList.add('heart-animating');
                    setTimeout(() => btnLike.classList.remove('heart-animating'), 500);
                } else {
                    btnLike.classList.remove('liked', 'active');
                    btnLike.setAttribute('title', 'Sukai Profil Pengguna Ini');
                    if (icon) {
                        icon.className = 'ti ti-heart text-white fs-12 me-1';
                    }
                }

                if (window.showToast) {
                    window.showToast(res.message, 'success');
                }
            } else {
                if (window.showError) window.showError(res.message || 'Gagal mengubah status like.');
            }
            return;
        }

        // B. Kirim Ajakan Berteman
        const btnAddFriend = e.target.closest('.btn-add-friend-action');
        if (btnAddFriend) {
            e.preventDefault();
            const userId = btnAddFriend.getAttribute('data-user-id');
            const userName = btnAddFriend.getAttribute('data-user-name') || 'pengguna';
            const wrapper = btnAddFriend.closest('.contact-action-wrapper');
            const cardCol = btnAddFriend.closest('.dashboard-contact-col');
            const targetUrl = `${routes.sendFriend}/${userId}`;

            btnAddFriend.disabled = true;
            btnAddFriend.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Mengirim...';

            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                if (cardCol) cardCol.setAttribute('data-friendship-status', 'pending_sent');
                if (wrapper) {
                    wrapper.innerHTML = `
                        <button type="button" class="btn btn-sm btn-warning-subtle text-warning border border-warning-subtle w-100 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-cancel-friend-action"
                            data-user-id="${userId}" data-user-name="${userName}">
                            <i class="ti ti-clock-pause"></i> Menunggu Respon <span class="badge bg-warning text-dark fs-xxs ms-1">Batal</span>
                        </button>
                    `;
                }

                // Update badge nama
                const nameHeader = cardCol?.querySelector('h5');
                if (nameHeader) {
                    const existingBadge = nameHeader.querySelector('.badge');
                    if (existingBadge) existingBadge.remove();
                    nameHeader.insertAdjacentHTML('beforeend', '<span class="badge bg-warning-subtle text-warning fs-xxs ms-1" title="Menunggu Respon Ajakan"><i class="ti ti-clock me-0.5"></i>Terkirim</span>');
                }

                if (window.showToast) window.showToast(res.message, 'success');
                if (typeof pollDashboardData === 'function') pollDashboardData();
            } else {
                btnAddFriend.disabled = false;
                btnAddFriend.innerHTML = '<i class="ti ti-user-plus"></i> Tambah Teman';
                if (window.showError) window.showError(res.message || 'Gagal mengirim ajakan berteman.');
            }
            return;
        }

        // C. Batalkan Ajakan Berteman
        const btnCancelFriend = e.target.closest('.btn-cancel-friend-action');
        if (btnCancelFriend) {
            e.preventDefault();
            const userId = btnCancelFriend.getAttribute('data-user-id');
            const userName = btnCancelFriend.getAttribute('data-user-name') || 'pengguna';
            const wrapper = btnCancelFriend.closest('.contact-action-wrapper');
            const cardCol = btnCancelFriend.closest('.dashboard-contact-col');
            const targetUrl = `${routes.cancelFriend}/${userId}`;

            btnCancelFriend.disabled = true;
            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                if (cardCol) cardCol.setAttribute('data-friendship-status', 'none');
                if (wrapper) {
                    wrapper.innerHTML = `
                        <div class="d-flex gap-1.5 w-100">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-add-friend-action"
                                data-user-id="${userId}" data-user-name="${userName}">
                                <i class="ti ti-user-plus"></i> Tambah Teman
                            </button>
                            <a href="${routes.messagesIndex}?user_id=${userId}" class="btn btn-sm btn-light border text-muted px-2" title="Kirim Pesan Langsung">
                                <i class="ti ti-messages"></i>
                            </a>
                        </div>
                    `;
                }

                // Hapus badge nama
                const nameHeader = cardCol?.querySelector('h5');
                if (nameHeader) {
                    const existingBadge = nameHeader.querySelector('.badge');
                    if (existingBadge) existingBadge.remove();
                }

                if (window.showToast) window.showToast(res.message, 'info');
                if (typeof pollDashboardData === 'function') pollDashboardData();
            } else {
                btnCancelFriend.disabled = false;
                if (window.showError) window.showError(res.message || 'Gagal membatalkan ajakan berteman.');
            }
            return;
        }

        // D. Terima Ajakan Berteman (Incoming)
        const btnAcceptFriend = e.target.closest('.btn-accept-friend-action');
        if (btnAcceptFriend) {
            e.preventDefault();
            const cardCol = btnAcceptFriend.closest('.dashboard-contact-col');
            const friendshipId = btnAcceptFriend.getAttribute('data-friendship-id') || cardCol?.getAttribute('data-user-id');
            const userName = btnAcceptFriend.getAttribute('data-user-name') || cardCol?.getAttribute('data-search-name') || 'pengguna';
            const wrapper = btnAcceptFriend.closest('.contact-action-wrapper');
            const targetUrl = `${routes.acceptFriend}/${friendshipId}`;

            btnAcceptFriend.disabled = true;
            btnAcceptFriend.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Terima...';

            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                const userId = res.sender_id || cardCol?.getAttribute('data-user-id') || friendshipId;
                if (cardCol) cardCol.setAttribute('data-friendship-status', 'friends');
                if (wrapper) {
                    wrapper.innerHTML = `
                        <div class="d-flex gap-1.5 w-100">
                            <a href="${routes.messagesIndex}?user_id=${userId}"
                                class="btn btn-sm btn-primary bg-primary text-white flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1">
                                <i class="ti ti-messages"></i> Chat
                            </a>
                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-success-subtle text-success border border-success-subtle dropdown-toggle fw-semibold px-2"
                                    data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pertemanan">
                                    <i class="ti ti-user-check me-0.5"></i> Teman
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                    <li>
                                        <button type="button" class="dropdown-item text-danger d-flex align-items-center gap-1.5 btn-unfriend-action"
                                            data-user-id="${userId}" data-user-name="${userName}">
                                            <i class="ti ti-user-x text-danger"></i> Hapus Pertemanan
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    `;
                }

                // Update badge nama
                const nameHeader = cardCol?.querySelector('h5');
                if (nameHeader) {
                    const existingBadge = nameHeader.querySelector('.badge');
                    if (existingBadge) existingBadge.remove();
                    nameHeader.insertAdjacentHTML('beforeend', '<span class="badge bg-success-subtle text-success fs-xxs ms-1" title="Sudah Berteman"><i class="ti ti-user-check me-0.5"></i>Teman</span>');
                }

                // Kosongkan input pencarian
                if (contactSearchInput) {
                    contactSearchInput.value = '';
                }

                // Berpindah ke tab 'Teman Saya' (friends)
                currentFilter = 'friends';
                filterButtons.forEach(b => {
                    if (b.getAttribute('data-filter') === 'friends') {
                        b.classList.add('active');
                    } else {
                        b.classList.remove('active');
                    }
                });
                filterContacts();

                if (window.showToast) window.showToast(res.message, 'success');
                if (typeof pollDashboardData === 'function') pollDashboardData();
            } else {
                btnAcceptFriend.disabled = false;
                btnAcceptFriend.innerHTML = '<i class="ti ti-check"></i> Terima';
                if (window.showError) window.showError(res.message || 'Gagal menerima ajakan berteman.');
            }
            return;
        }

        // E. Tolak Ajakan Berteman (Incoming)
        const btnRejectFriend = e.target.closest('.btn-reject-friend-action');
        if (btnRejectFriend) {
            e.preventDefault();
            const cardCol = btnRejectFriend.closest('.dashboard-contact-col');
            const friendshipId = btnRejectFriend.getAttribute('data-friendship-id') || cardCol?.getAttribute('data-user-id');
            const userName = btnRejectFriend.getAttribute('data-user-name') || cardCol?.getAttribute('data-search-name') || 'pengguna';
            const wrapper = btnRejectFriend.closest('.contact-action-wrapper');
            const targetUrl = `${routes.rejectFriend}/${friendshipId}`;

            btnRejectFriend.disabled = true;
            btnRejectFriend.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                const userId = res.sender_id || cardCol?.getAttribute('data-user-id') || friendshipId;
                if (cardCol) cardCol.setAttribute('data-friendship-status', 'none');
                if (wrapper) {
                    wrapper.innerHTML = `
                        <div class="d-flex gap-1.5 w-100">
                            <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-add-friend-action"
                                data-user-id="${userId}" data-user-name="${userName}">
                                <i class="ti ti-user-plus"></i> Tambah Teman
                            </button>
                            <a href="${routes.messagesIndex}?user_id=${userId}" class="btn btn-sm btn-light border text-muted px-2" title="Kirim Pesan Langsung">
                                <i class="ti ti-messages"></i>
                            </a>
                        </div>
                    `;
                }

                // Hapus badge nama jika ada
                const nameHeader = cardCol?.querySelector('h5');
                if (nameHeader) {
                    const existingBadge = nameHeader.querySelector('.badge');
                    if (existingBadge) existingBadge.remove();
                }

                // Kosongkan input pencarian
                if (contactSearchInput) {
                    contactSearchInput.value = '';
                }

                // Berpindah ke tab 'Semua' (all)
                currentFilter = 'all';
                filterButtons.forEach(b => {
                    if (b.getAttribute('data-filter') === 'all') {
                        b.classList.add('active');
                    } else {
                        b.classList.remove('active');
                    }
                });
                filterContacts();

                if (window.showToast) window.showToast(res.message, 'info');
                if (typeof pollDashboardData === 'function') pollDashboardData();
            } else {
                btnRejectFriend.disabled = false;
                btnRejectFriend.innerHTML = '<i class="ti ti-x"></i>';
                if (window.showError) window.showError(res.message || 'Gagal menolak ajakan berteman.');
            }
            return;
        }

        // F. Hapus Pertemanan (Unfriend)
        const btnUnfriend = e.target.closest('.btn-unfriend-action');
        if (btnUnfriend) {
            e.preventDefault();
            const userId = btnUnfriend.getAttribute('data-user-id');
            const userName = btnUnfriend.getAttribute('data-user-name') || 'pengguna ini';
            const cardCol = btnUnfriend.closest('.dashboard-contact-col');
            const wrapper = cardCol ? cardCol.querySelector('.contact-action-wrapper') : null;
            const targetUrl = `${routes.unfriend}/${userId}`;

            if (window.showConfirm) {
                window.showConfirm({
                    title: 'Hapus Pertemanan?',
                    text: `Apakah Anda yakin ingin menghapus "${userName}" dari daftar teman? Anda tetap dapat mengirimkan ajakan kembali nanti.`,
                    isDanger: true,
                    onConfirm: async function () {
                        const res = await sendAjax(targetUrl, 'DELETE');
                        if (res.success) {
                            if (cardCol) cardCol.setAttribute('data-friendship-status', 'none');
                            if (wrapper) {
                                wrapper.innerHTML = `
                                    <div class="d-flex gap-1.5 w-100">
                                        <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-add-friend-action"
                                            data-user-id="${userId}" data-user-name="${userName}">
                                            <i class="ti ti-user-plus"></i> Tambah Teman
                                        </button>
                                        <a href="${routes.messagesIndex}?user_id=${userId}" class="btn btn-sm btn-light border text-muted px-2" title="Kirim Pesan Langsung">
                                            <i class="ti ti-messages"></i>
                                        </a>
                                    </div>
                                `;
                            }
                            if (window.showToast) window.showToast(res.message, 'info');
                        } else {
                            if (window.showError) window.showError(res.message || 'Gagal menghapus pertemanan.');
                        }
                    }
                });
            }
            return;
        }
    });

    // 5. Live Search & Filter Pertemanan Tabs + Incremental Load More (12 Pengguna per Klik Anak Panah)
    const contactSearchInput = document.querySelector('#dashboard-contact-search');
    const contactCards = Array.from(document.querySelectorAll('.dashboard-contact-col'));
    const contactEmptyMsg = document.querySelector('#dashboard-contacts-empty');
    const loadmoreContainer = document.querySelector('#dashboard-contacts-loadmore-container');
    const loadmoreBtn = document.querySelector('#dashboard-contacts-loadmore-btn');
    const visibleCountSpan = document.querySelector('#contacts-visible-count');
    const totalCountSpan = document.querySelector('#contacts-total-count');
    const filterButtons = document.querySelectorAll('.btn-friend-filter');

    const STEP_SIZE = 12;
    let visibleLimit = 12;
    let currentFilter = 'all';
    let matchedCards = [...contactCards];
    const contactsGrid = document.querySelector('#dashboard-contacts-grid');

    function getCardRank(card) {
        const isMe = card.getAttribute('data-is-me') === '1' || String(card.getAttribute('data-user-id')) === String(config.userId);
        if (isMe) return 0; // Widget akun kita sendiri

        const status = card.getAttribute('data-friendship-status') || 'none';
        const isOnline = card.getAttribute('data-is-online') === '1';
        const isFriend = (status === 'friends');

        if (isFriend && isOnline) return 1; // Teman dan sedang Online
        if (isFriend && !isOnline) return 2; // Teman dan Offline
        if (!isFriend && isOnline) return 3; // Bukan teman tetapi sedang Online
        return 4; // Bukan teman dan Offline
    }

    function renderVisibleContacts(isAppending = false) {
        if (!contactCards.length) return;

        const totalItems = matchedCards.length;
        const currentVisible = Math.min(visibleLimit, totalItems);

        // Hide all cards first
        contactCards.forEach(card => card.classList.add('d-none'));

        // Reveal matching cards up to visibleLimit and maintain sorted DOM order
        const newlyRevealed = [];
        matchedCards.slice(0, currentVisible).forEach((card, idx) => {
            card.classList.remove('d-none');
            if (contactsGrid && card.parentElement === contactsGrid) {
                contactsGrid.appendChild(card);
            }
            if (isAppending && idx >= (visibleLimit - STEP_SIZE)) {
                newlyRevealed.push(card);
            }
        });

        // Update Empty state
        if (contactEmptyMsg) {
            if (totalItems === 0) {
                contactEmptyMsg.classList.remove('d-none');
            } else {
                contactEmptyMsg.classList.add('d-none');
            }
        }

        // Update Counter Text
        if (visibleCountSpan) {
            visibleCountSpan.textContent = currentVisible;
        }
        if (totalCountSpan) {
            totalCountSpan.textContent = totalItems;
        }

        // Handle Down Arrow Button Visibility (Hilang otomatis jika seluruh pengguna sudah tampil)
        if (loadmoreContainer) {
            if (currentVisible >= totalItems || totalItems === 0) {
                loadmoreContainer.classList.add('d-none');
            } else {
                loadmoreContainer.classList.remove('d-none');
                const remaining = totalItems - currentVisible;
                const nextStep = Math.min(STEP_SIZE, remaining);
                const btnTextSpan = loadmoreBtn?.querySelector('span');
                if (btnTextSpan) {
                    btnTextSpan.textContent = `Tampilkan ${nextStep} Pengguna Berikutnya`;
                }
            }
        }

        // Smooth scroll to the newly revealed cards if clicking load more
        if (isAppending && newlyRevealed.length > 0) {
            newlyRevealed[0].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    function filterContacts() {
        if (!contactCards.length) return;

        const keyword = (contactSearchInput?.value || '').toLowerCase().trim();

        matchedCards = contactCards.filter(function (card) {
            const name = (card.getAttribute('data-search-name') || '').toLowerCase();
            const email = (card.getAttribute('data-search-email') || '').toLowerCase();
            const phone = (card.getAttribute('data-search-phone') || '').toLowerCase();
            const city = (card.getAttribute('data-search-city') || '').toLowerCase();
            const job = (card.getAttribute('data-search-job') || '').toLowerCase();
            const status = card.getAttribute('data-friendship-status') || 'none';

            // Filter status
            let matchesStatus = true;
            if (currentFilter === 'friends') {
                matchesStatus = status === 'friends';
            } else if (currentFilter === 'incoming') {
                matchesStatus = status === 'pending_received';
            } else if (currentFilter === 'outgoing') {
                matchesStatus = status === 'pending_sent';
            }

            // Keyword match
            const matchesKeyword = !keyword || name.includes(keyword) || email.includes(keyword) || phone.includes(keyword) || city.includes(keyword) || job.includes(keyword);

            return matchesStatus && matchesKeyword;
        });

        // Urutkan kartu berdasarkan prioritas tampilan:
        // 0. Akun sendiri
        // 1. Teman & Online
        // 2. Teman & Offline
        // 3. Bukan teman & Online
        // 4. Bukan teman & Offline
        matchedCards.sort((a, b) => {
            const rankA = getCardRank(a);
            const rankB = getCardRank(b);
            if (rankA !== rankB) {
                return rankA - rankB;
            }
            const nameA = (a.getAttribute('data-search-name') || '').toLowerCase();
            const nameB = (b.getAttribute('data-search-name') || '').toLowerCase();
            return nameA.localeCompare(nameB);
        });

        // Reset visible limit to initial 12 on new search or filter
        visibleLimit = 12;
        renderVisibleContacts(false);
    }

    // Filter Buttons Event Delegation
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter') || 'all';
            filterContacts();
        });
    });

    if (contactSearchInput) {
        contactSearchInput.addEventListener('input', filterContacts);
    }

    // Event Delegation: Klik Tombol Anak Panah ke Bawah (Rule 2 Standard)
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('#dashboard-contacts-loadmore-btn');
        if (btn) {
            e.preventDefault();
            visibleLimit += STEP_SIZE;
            renderVisibleContacts(true);
        }
    });

    // URL Search & Filter Parameter Parsing (e.g. Dari Notifikasi Topbar: ?contact_search=Nama&filter=incoming)
    const urlParams = new URLSearchParams(window.location.search);
    const searchParam = urlParams.get('contact_search') || urlParams.get('search');
    const filterParam = urlParams.get('filter');

    if (filterParam && ['all', 'friends', 'incoming', 'outgoing'].includes(filterParam)) {
        currentFilter = filterParam;
        filterButtons.forEach(b => {
            if (b.getAttribute('data-filter') === filterParam) {
                b.classList.add('active');
            } else {
                b.classList.remove('active');
            }
        });
    }

    if (searchParam && contactSearchInput) {
        contactSearchInput.value = searchParam;
    }

    // Initial Render
    if (contactCards.length > 0) {
        if (searchParam || filterParam) {
            filterContacts();
            setTimeout(() => {
                contactSearchInput?.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }, 300);
        } else {
            renderVisibleContacts(false);
        }
    }

    // Intercept Klik Notifikasi Ajakan Berteman saat Pengguna sedang berada di Dashboard
    document.addEventListener('click', function (e) {
        const notifItem = e.target.closest('.btn-view-notif-detail');
        if (!notifItem) return;

        const notifType = notifItem.getAttribute('data-notif-type') || '';
        const targetUrl = notifItem.getAttribute('data-notif-url') || '';
        const senderName = notifItem.getAttribute('data-sender-name') || notifItem.getAttribute('data-notif-title') || '';

        if (notifType === 'friend_request' || targetUrl.includes('filter=incoming') || targetUrl.includes('contact_search=')) {
            const currentPath = window.location.pathname.replace(/\/+$/, '');
            const isDashboard = currentPath.endsWith('/dashboard') || currentPath.endsWith('/admin') || currentPath === '/admin';

            if (isDashboard) {
                e.preventDefault();

                // Tutup dropdown notifikasi topbar
                const dropdownToggle = document.getElementById('topbar-notif-toggle-btn');
                if (dropdownToggle && typeof bootstrap !== 'undefined') {
                    const dropdown = bootstrap.Dropdown.getInstance(dropdownToggle);
                    if (dropdown) dropdown.hide();
                }

                // Ubah filter aktif ke 'incoming' (Ajakan Masuk)
                currentFilter = 'incoming';
                filterButtons.forEach(b => {
                    if (b.getAttribute('data-filter') === 'incoming') {
                        b.classList.add('active');
                    } else {
                        b.classList.remove('active');
                    }
                });

                // Isi kata kunci pencarian dengan nama pengirim ajakan
                if (contactSearchInput) {
                    contactSearchInput.value = senderName;
                    filterContacts();
                    contactSearchInput.focus();
                    contactSearchInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }

                if (window.showToast) {
                    window.showToast(`Menampilkan ajakan berteman dari ${senderName}`, 'info');
                }
            }
        }
    });

    // 6. Real-Time Friendship, Likes & Dashboard Polling Engine
    function getActionWrapperHtml(userId, userName, status, friendshipId) {
        if (status === 'self' || String(userId) === String(config.userId)) {
            return `
                <a href="${routes.profileIndex || '#'}"
                    class="btn btn-sm btn-light border text-primary w-100 fw-semibold d-flex align-items-center justify-content-center gap-1">
                    <i class="ti ti-user"></i> Profil Saya
                </a>
            `;
        }
        if (status === 'friends') {
            return `
                <div class="d-flex gap-1.5 w-100">
                    <a href="${routes.messagesIndex}?user_id=${userId}"
                        class="btn btn-sm btn-primary bg-primary text-white flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1">
                        <i class="ti ti-messages"></i> Chat
                    </a>
                    <div class="dropdown">
                        <button type="button" class="btn btn-sm btn-success-subtle text-success border border-success-subtle dropdown-toggle fw-semibold px-2"
                            data-bs-toggle="dropdown" aria-expanded="false" title="Menu Pertemanan">
                            <i class="ti ti-user-check me-0.5"></i> Teman
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                            <li>
                                <button type="button" class="dropdown-item text-danger d-flex align-items-center gap-1.5 btn-unfriend-action"
                                    data-user-id="${userId}" data-user-name="${userName}">
                                    <i class="ti ti-user-x text-danger"></i> Hapus Pertemanan
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
            `;
        }
        if (status === 'pending_sent') {
            return `
                <button type="button" class="btn btn-sm btn-warning-subtle text-warning border border-warning-subtle w-100 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-cancel-friend-action"
                    data-user-id="${userId}" data-user-name="${userName}">
                    <i class="ti ti-clock-pause"></i> Menunggu Respon <span class="badge bg-warning text-dark fs-xxs ms-1">Batal</span>
                </button>
            `;
        }
        if (status === 'pending_received') {
            return `
                <div class="d-flex gap-1.5 w-100">
                    <button type="button" class="btn btn-sm btn-success text-white flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-accept-friend-action"
                        data-friendship-id="${friendshipId || ''}" data-user-name="${userName}">
                        <i class="ti ti-check"></i> Terima
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger px-2 fw-semibold btn-reject-friend-action"
                        data-friendship-id="${friendshipId || ''}" data-user-name="${userName}" title="Tolak Ajakan">
                        <i class="ti ti-x"></i>
                    </button>
                </div>
            `;
        }
        return `
            <div class="d-flex gap-1.5 w-100">
                <button type="button" class="btn btn-sm btn-outline-primary flex-grow-1 fw-semibold d-flex align-items-center justify-content-center gap-1 btn-add-friend-action"
                    data-user-id="${userId}" data-user-name="${userName}">
                    <i class="ti ti-user-plus"></i> Tambah Teman
                </button>
                <a href="${routes.messagesIndex}?user_id=${userId}" class="btn btn-sm btn-light border text-muted px-2" title="Kirim Pesan Langsung">
                    <i class="ti ti-messages"></i>
                </a>
            </div>
        `;
    }

    function getTitleBadgeHtml(status, isMe) {
        if (isMe) {
            return `<span class="badge bg-primary text-white fs-xxs ms-1">Anda</span>`;
        }
        if (status === 'friends') {
            return `<span class="badge bg-success-subtle text-success fs-xxs ms-1" title="Sudah Berteman"><i class="ti ti-user-check me-0.5"></i>Teman</span>`;
        }
        if (status === 'pending_sent') {
            return `<span class="badge bg-warning-subtle text-warning fs-xxs ms-1" title="Menunggu Respon Ajakan"><i class="ti ti-clock me-0.5"></i>Terkirim</span>`;
        }
        if (status === 'pending_received') {
            return `<span class="badge bg-info-subtle text-info fs-xxs ms-1" title="Mengajak Anda Berteman"><i class="ti ti-user-plus me-0.5"></i>Ajakan Masuk</span>`;
        }
        return '';
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function hexToRgba(hexStr, opacityPercent) {
        const hex = (hexStr || '#313a46').replace('#', '');
        let fullHex = hex;
        if (hex.length === 3) {
            fullHex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
        }
        const r = parseInt(fullHex.substring(0, 2), 16) || 49;
        const g = parseInt(fullHex.substring(2, 4), 16) || 58;
        const b = parseInt(fullHex.substring(4, 6), 16) || 70;
        const alpha = (opacityPercent !== undefined ? opacityPercent : 60) / 100;
        return {
            cover: `rgba(${r}, ${g}, ${b}, ${alpha})`,
            top: `rgba(${r}, ${g}, ${b}, ${Math.max(0, alpha - 0.25)})`
        };
    }

    let isPolling = false;
    let prevStats = null;

    async function pollDashboardData() {
        if (isPolling || !routes.pollDashboard || document.hidden) return;
        isPolling = true;

        try {
            const res = await fetch(routes.pollDashboard, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) {
                isPolling = false;
                return;
            }

            const data = await res.json();
            if (!data.success) {
                isPolling = false;
                return;
            }

            const stats = data.stats || {};
            const contacts = data.contacts || {};
            const currentUser = data.current_user;

            // A. Notifikasi Toast Realtime saat ada interaksi baru dari pengguna lain
            if (prevStats) {
                if (stats.incoming_requests_count > prevStats.incoming_requests_count) {
                    if (window.showToast) window.showToast('Ada ajakan berteman baru yang masuk!', 'info');
                }
                if (stats.profile_likes_count > prevStats.profile_likes_count) {
                    if (window.showToast) window.showToast('Seseorang baru saja menyukai profil Anda! ❤️', 'success');
                }
                if (stats.friends_count > prevStats.friends_count && prevStats.outgoing_requests_count > stats.outgoing_requests_count) {
                    if (window.showToast) window.showToast('Ajakan berteman Anda telah diterima!', 'success');
                }
                if (stats.outgoing_requests_count < prevStats.outgoing_requests_count && stats.friends_count === prevStats.friends_count) {
                    if (window.showToast) window.showToast('Status ajakan berteman Anda telah diperbarui.', 'info');
                }
            }
            prevStats = stats;

            // B. Update Hero Stats & Hero Card Current User Realtime
            const heroFriends = document.querySelector('#hero-friends-count');
            if (heroFriends) heroFriends.textContent = `${stats.friends_count.toLocaleString()} Teman`;

            const heroLikes = document.querySelector('#hero-likes-count');
            if (heroLikes) heroLikes.textContent = `${stats.profile_likes_count.toLocaleString()} Suka`;

            if (currentUser) {
                const heroCard = document.querySelector('.dashboard-hero-card');
                if (heroCard) {
                    if (currentUser.cover_bg_url) {
                        heroCard.style.backgroundImage = `url("${currentUser.cover_bg_url}")`;
                    }
                    heroCard.style.backgroundPosition = `center ${currentUser.cover_position_y || 50}%`;
                    if (currentUser.cover_height) {
                        heroCard.style.minHeight = `${currentUser.cover_height}px`;
                    }
                }
                const heroOverlay = document.querySelector('#dashboard-hero-overlay');
                if (heroOverlay && currentUser.cover_color) {
                    const rgba = hexToRgba(currentUser.cover_color, currentUser.cover_opacity);
                    const blurPx = parseInt(currentUser.cover_blur || 0);
                    heroOverlay.style.background = `linear-gradient(135deg, ${rgba.cover}, ${rgba.top})`;
                    heroOverlay.style.backdropFilter = blurPx > 0 ? `blur(${blurPx}px)` : 'none';
                    heroOverlay.style.webkitBackdropFilter = blurPx > 0 ? `blur(${blurPx}px)` : 'none';
                }
                const heroAvatar = document.querySelector('.hero-avatar-img');
                if (heroAvatar && currentUser.avatar_url && heroAvatar.src !== currentUser.avatar_url) {
                    heroAvatar.src = currentUser.avatar_url;
                }
            }

            // C. Update Filter Toolbar Badges Realtime
            const badgeAll = document.querySelector('#filter-badge-all');
            if (badgeAll) badgeAll.textContent = stats.total_users || contactCards.length;

            const badgeFriends = document.querySelector('#filter-badge-friends');
            if (badgeFriends) badgeFriends.textContent = stats.friends_count;

            const badgeIncoming = document.querySelector('#filter-badge-incoming');
            if (badgeIncoming) {
                badgeIncoming.textContent = stats.incoming_requests_count;
                if (stats.incoming_requests_count > 0) {
                    badgeIncoming.className = 'badge bg-danger text-white rounded-pill fs-xxs';
                } else {
                    badgeIncoming.className = 'badge bg-secondary-subtle text-secondary rounded-pill fs-xxs';
                }
            }

            const badgeOutgoing = document.querySelector('#filter-badge-outgoing');
            if (badgeOutgoing) {
                badgeOutgoing.textContent = stats.outgoing_requests_count;
                if (stats.outgoing_requests_count > 0) {
                    badgeOutgoing.className = 'badge bg-warning text-dark rounded-pill fs-xxs';
                } else {
                    badgeOutgoing.className = 'badge bg-secondary-subtle text-secondary rounded-pill fs-xxs';
                }
            }

            // D. Sync Each Contact Card in DOM (Cover, Avatar, Data Pengguna, Relasi)
            let needsRefilter = false;

            contactCards.forEach(card => {
                const uId = card.getAttribute('data-user-id');
                const cData = contacts[uId];
                if (!cData) return;

                const isMe = String(uId) === String(config.userId);
                const currentStatus = card.getAttribute('data-friendship-status');
                const newStatus = cData.friendship_status;

                // 1. Update Foto Cover Banner & Posisi Y
                const coverEl = card.querySelector('.contact-grid-cover');
                if (coverEl && cData.cover_bg_url) {
                    coverEl.style.backgroundImage = `url("${cData.cover_bg_url}")`;
                    coverEl.style.backgroundPosition = `center ${cData.cover_position_y || 50}%`;
                }

                // 1b. Update Overlay Ketebalan Warna & Efek Blur Cover
                const overlayEl = card.querySelector('.contact-grid-overlay-layer');
                if (overlayEl && cData.cover_color) {
                    const rgba = hexToRgba(cData.cover_color, cData.cover_opacity);
                    const blurPx = parseInt(cData.cover_blur || 0);
                    overlayEl.style.background = `linear-gradient(180deg, ${rgba.cover} 0%, ${rgba.top} 100%)`;
                    overlayEl.style.backdropFilter = blurPx > 0 ? `blur(${blurPx}px)` : 'none';
                    overlayEl.style.webkitBackdropFilter = blurPx > 0 ? `blur(${blurPx}px)` : 'none';
                }

                // 2. Update Motto Hidup di Cover
                const mottoEl = card.querySelector('.contact-cover-motto');
                if (mottoEl) {
                    if (cData.motto) {
                        mottoEl.textContent = `"${cData.motto}"`;
                        mottoEl.setAttribute('title', cData.motto);
                    } else {
                        mottoEl.textContent = '';
                    }
                }

                // 3. Update Avatar Gambar
                const avatarImg = card.querySelector('.contact-grid-avatar');
                if (avatarImg && cData.avatar_url && avatarImg.src !== cData.avatar_url) {
                    avatarImg.src = cData.avatar_url;
                }

                // 4. Update Nama & Badge Relasi
                const nameHeader = card.querySelector('h5');
                if (nameHeader) {
                    const badgeHtml = getTitleBadgeHtml(newStatus, isMe);
                    nameHeader.innerHTML = `${escapeHtml(cData.name)} ${badgeHtml}`;
                    nameHeader.setAttribute('title', cData.name);
                }

                // 5. Update Email
                const emailEl = card.querySelector('p.text-muted.fs-12');
                if (emailEl && cData.email) {
                    emailEl.innerHTML = `<i class="ti ti-mail me-1"></i>${escapeHtml(cData.email)}`;
                    emailEl.setAttribute('title', cData.email);
                }

                // 6. Update Meta List (Pekerjaan, Telepon/WA, Domisili, Poin Login)
                const metaListItems = card.querySelectorAll('ul.list-unstyled li');
                if (metaListItems.length >= 4) {
                    // Pekerjaan
                    const jobEl = metaListItems[0].querySelector('strong');
                    if (jobEl) jobEl.textContent = cData.pekerjaan || 'Belum diisi';

                    // Telepon / WA
                    if (cData.telepon) {
                        metaListItems[1].innerHTML = `
                            <span class="text-muted"><i class="ti ti-brand-whatsapp me-1 text-success"></i>Telepon / WA:</span>
                            <a href="${cData.telepon_wa_url || '#'}" target="_blank"
                                class="text-success fw-semibold text-truncate ps-2 text-decoration-none d-inline-flex align-items-center"
                                style="max-width: 140px;" title="Hubungi via WhatsApp (${cData.telepon})">
                                ${escapeHtml(cData.telepon)} <i class="ti ti-external-link fs-10 ms-1"></i>
                            </a>
                        `;
                    } else {
                        metaListItems[1].innerHTML = `
                            <span class="text-muted"><i class="ti ti-brand-whatsapp me-1 text-success"></i>Telepon / WA:</span>
                            <span class="text-muted fw-normal fst-italic ps-2">Belum diisi</span>
                        `;
                    }

                    // Domisili
                    const cityEl = metaListItems[2].querySelector('strong');
                    if (cityEl) cityEl.textContent = cData.kabupaten_kota || 'Belum diisi';

                    // Poin Login
                    const loginPointEl = metaListItems[3].querySelector('strong');
                    if (loginPointEl) loginPointEl.textContent = `${(cData.login_count || 0).toLocaleString()} Poin`;
                }

                // 7. Update Search Attributes
                card.setAttribute('data-search-name', (cData.name || '').toLowerCase());
                card.setAttribute('data-search-email', (cData.email || '').toLowerCase());
                card.setAttribute('data-search-phone', (cData.telepon || '').toLowerCase());
                card.setAttribute('data-search-city', (cData.kabupaten_kota || '').toLowerCase());
                card.setAttribute('data-search-job', (cData.pekerjaan || '').toLowerCase());

                // 8. Status Pertemanan Berubah -> Update Tombol Aksi
                if (currentStatus !== newStatus) {
                    card.setAttribute('data-friendship-status', newStatus);
                    needsRefilter = true;

                    const wrapper = card.querySelector('.contact-action-wrapper');
                    const userName = cData.name || 'Pengguna';
                    if (wrapper) {
                        wrapper.innerHTML = getActionWrapperHtml(uId, userName, newStatus, cData.friendship_id);
                    }
                }

                // 9. Update Like Count & Button State
                const likeCountEl = card.querySelector('.like-count');
                if (likeCountEl && likeCountEl.textContent != cData.likes_count) {
                    likeCountEl.textContent = cData.likes_count;
                }

                const likeBtn = card.querySelector('.contact-like-btn');
                if (likeBtn) {
                    const icon = likeBtn.querySelector('i');
                    if (cData.is_liked_by_me) {
                        likeBtn.classList.add('liked', 'active');
                        likeBtn.setAttribute('title', 'Batal Suka Profil');
                        if (icon) icon.className = 'ti ti-heart-filled text-danger fs-12 me-1';
                    } else {
                        likeBtn.classList.remove('liked', 'active');
                        likeBtn.setAttribute('title', 'Sukai Profil Pengguna Ini');
                        if (icon) icon.className = 'ti ti-heart text-white fs-12 me-1';
                    }
                }

                // 10. Update Online Presence & Rank Attribute
                const prevOnline = card.getAttribute('data-is-online');
                const newOnline = cData.is_online ? '1' : '0';
                if (prevOnline !== newOnline) {
                    card.setAttribute('data-is-online', newOnline);
                    needsRefilter = true;
                }

                const onlineCoverBadge = card.querySelector('.contact-grid-cover .badge');
                if (onlineCoverBadge) {
                    if (cData.is_online) {
                        onlineCoverBadge.className = 'badge bg-success text-white fs-xxs py-0.5 px-1.5 rounded-pill shadow-sm';
                        onlineCoverBadge.innerHTML = '<i class="ti ti-circle-filled text-white me-0.5"></i> Online';
                        onlineCoverBadge.setAttribute('title', 'Online Sekarang');
                    } else {
                        onlineCoverBadge.className = 'badge bg-dark bg-opacity-75 text-white-50 fs-xxs py-0.5 px-1.5 rounded-pill shadow-sm';
                        onlineCoverBadge.innerHTML = '<i class="ti ti-clock me-0.5"></i> Offline';
                        onlineCoverBadge.setAttribute('title', cData.last_seen || 'Offline');
                    }
                }
                const avatarDot = card.querySelector('.contact-grid-avatar + span');
                if (avatarDot) {
                    avatarDot.className = `position-absolute bottom-0 end-0 border border-2 border-white rounded-circle ${cData.is_online ? 'bg-success' : 'bg-secondary opacity-50'}`;
                }
            });

            if (needsRefilter) {
                filterContacts();
            }
        } catch (err) {
            console.warn('Realtime polling warning:', err);
        } finally {
            isPolling = false;
        }
    }

    // 7. Modal Riwayat Interaksi Pengguna (Activity History Modal Engine)
    const modalUserHistoryEl = document.getElementById('modalUserActivityHistory');
    let modalUserHistoryInstance = null;

    document.addEventListener('click', async function (e) {
        const btnHistory = e.target.closest('.btn-view-user-history');
        if (!btnHistory) return;

        e.preventDefault();
        const userId = btnHistory.getAttribute('data-user-id');
        if (!userId) return;

        if (!modalUserHistoryInstance && modalUserHistoryEl && typeof bootstrap !== 'undefined') {
            modalUserHistoryInstance = bootstrap.Modal.getOrCreateInstance(modalUserHistoryEl);
        }

        // Reset to first tab (Pertemanan)
        const firstModalTabBtn = document.getElementById('user-m-tab-friendship-btn');
        if (firstModalTabBtn && typeof bootstrap !== 'undefined') {
            const tabObj = bootstrap.Tab.getOrCreateInstance(firstModalTabBtn);
            if (tabObj) tabObj.show();
        }

        // Tampilkan placeholder loading pada modal
        const nameEl = document.getElementById('user-history-name');
        const emailEl = document.getElementById('user-history-email');
        const roleEl = document.getElementById('user-history-role');
        const avatarEl = document.getElementById('user-history-avatar');
        const coverBannerEl = document.getElementById('user-history-cover-banner');
        const onlineBadge = document.getElementById('user-history-online-badge');
        const mottoBox = document.getElementById('user-history-motto-box');
        const mottoEl = document.getElementById('user-history-motto');
        const fullChatBtn = document.getElementById('user-modal-btn-open-full-chat');
        const actionChatBtn = document.getElementById('user-modal-action-chat-btn');

        if (nameEl) nameEl.textContent = 'Memuat Data...';
        if (emailEl) emailEl.textContent = 'Mengambil informasi pengguna...';
        if (roleEl) roleEl.textContent = 'Memuat';
        if (onlineBadge) onlineBadge.classList.add('d-none');
        if (mottoBox) mottoBox.classList.add('d-none');
        if (avatarEl) avatarEl.src = '/assets/images/users/user-default.jpg';
        if (coverBannerEl) coverBannerEl.style.backgroundImage = 'none';

        // Set spinner pada konten tab
        const friendshipTimelineEl = document.getElementById('user-modal-friendship-timeline');
        const friendshipStatusBox = document.getElementById('user-modal-friendship-status-box');
        const friendshipStatusText = document.getElementById('user-modal-friendship-status-text');
        const friendshipTimeText = document.getElementById('user-modal-friendship-time-text');
        const myLikeStatusEl = document.getElementById('user-modal-my-like-status');
        const targetLikeStatusEl = document.getElementById('user-modal-target-like-status');
        const totalLikesCountEl = document.getElementById('user-modal-total-likes-count');
        const chatListEl = document.getElementById('user-modal-chat-list');
        const mediaListEl = document.getElementById('user-modal-media-list');

        const spinnerHtml = `
            <div class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                <div class="fs-12">Memuat riwayat interaksi...</div>
            </div>
        `;

        if (friendshipTimelineEl) friendshipTimelineEl.innerHTML = spinnerHtml;
        if (chatListEl) chatListEl.innerHTML = spinnerHtml;
        if (mediaListEl) mediaListEl.innerHTML = spinnerHtml;

        if (modalUserHistoryInstance) {
            modalUserHistoryInstance.show();
        }

        try {
            const url = `${routes.userHistory}/${userId}`;
            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            if (!res.ok) {
                if (window.showError) window.showError('Gagal memuat data riwayat pengguna.');
                return;
            }

            const data = await res.json();
            if (!data.success) {
                if (window.showError) window.showError(data.message || 'Gagal memuat data.');
                return;
            }

            const user = data.user || {};

            // Header info
            if (nameEl) nameEl.textContent = user.name || 'Pengguna';
            if (emailEl) emailEl.textContent = user.email || '-';
            if (roleEl) roleEl.textContent = (user.role_name || 'USER').toUpperCase();
            if (avatarEl && user.avatar_url) avatarEl.src = user.avatar_url;
            if (coverBannerEl && user.cover_bg_url) {
                coverBannerEl.style.backgroundImage = `url("${user.cover_bg_url}")`;
                coverBannerEl.style.backgroundPosition = `center ${user.cover_position_y || 50}%`;
            }

            if (onlineBadge) {
                if (user.is_online) {
                    onlineBadge.classList.remove('d-none');
                } else {
                    onlineBadge.classList.add('d-none');
                }
            }

            if (mottoBox && mottoEl) {
                if (user.motto) {
                    mottoEl.textContent = `"${user.motto}"`;
                    mottoBox.classList.remove('d-none');
                } else {
                    mottoBox.classList.add('d-none');
                }
            }

            const chatTargetUrl = `${routes.messagesIndex}?user_id=${user.id}`;
            if (fullChatBtn) fullChatBtn.href = chatTargetUrl;
            if (actionChatBtn) actionChatBtn.href = chatTargetUrl;

            // 1. Tab Pertemanan
            const fStatus = data.friendship_status;
            if (friendshipStatusText && friendshipTimeText) {
                if (fStatus === 'self') {
                    friendshipStatusText.innerHTML = '<span class="badge bg-primary px-2.5 py-1 rounded-pill"><i class="ti ti-user me-1"></i> Akun Anda Sendiri</span>';
                    friendshipTimeText.textContent = 'Ini adalah profil akun Anda sendiri.';
                } else if (fStatus === 'friends') {
                    friendshipStatusText.innerHTML = '<span class="badge bg-success px-2.5 py-1 rounded-pill"><i class="ti ti-check me-1"></i> Sudah Berteman</span>';
                    friendshipTimeText.textContent = `Anda dan ${user.name} saat ini terhubung sebagai teman.`;
                } else if (fStatus === 'pending_sent') {
                    friendshipStatusText.innerHTML = '<span class="badge bg-warning text-dark px-2.5 py-1 rounded-pill"><i class="ti ti-clock me-1"></i> Ajakan Terkirim</span>';
                    friendshipTimeText.textContent = `Menunggu respon konfirmasi dari ${user.name}.`;
                } else if (fStatus === 'pending_received') {
                    friendshipStatusText.innerHTML = '<span class="badge bg-info text-white px-2.5 py-1 rounded-pill"><i class="ti ti-user-plus me-1"></i> Ajakan Masuk</span>';
                    friendshipTimeText.textContent = `${user.name} telah mengirimkan ajakan berteman kepada Anda.`;
                } else {
                    friendshipStatusText.innerHTML = '<span class="badge bg-secondary px-2.5 py-1 rounded-pill"><i class="ti ti-user-x me-1"></i> Belum Berteman</span>';
                    friendshipTimeText.textContent = `Belum ada ajakan pertemanan yang aktif dengan ${user.name}.`;
                }
            }

            if (friendshipTimelineEl) {
                const fLogs = data.friendship_history || [];
                if (fLogs.length === 0) {
                    friendshipTimelineEl.innerHTML = `
                        <div class="text-center py-3 text-muted fs-12">
                            <i class="ti ti-clock-off fs-20 d-block mb-1 opacity-50"></i>
                            Belum ada riwayat transaksi pertemanan dengan ${user.name}.
                        </div>
                    `;
                } else {
                    let logsHtml = '';
                    fLogs.forEach((item, idx) => {
                        const sName = item.sender ? item.sender.name : 'User';
                        const rName = item.receiver ? item.receiver.name : 'User';
                        let badgeStatus = `<span class="badge bg-secondary-subtle text-secondary fs-xxs">${item.status}</span>`;
                        if (item.status === 'accepted') {
                            badgeStatus = '<span class="badge bg-success-subtle text-success fs-xxs"><i class="ti ti-check me-0.5"></i> Berteman</span>';
                        } else if (item.status === 'pending') {
                            badgeStatus = '<span class="badge bg-warning-subtle text-warning fs-xxs"><i class="ti ti-clock me-0.5"></i> Menunggu</span>';
                        } else if (item.status === 'rejected') {
                            badgeStatus = '<span class="badge bg-danger-subtle text-danger fs-xxs"><i class="ti ti-x me-0.5"></i> Ditolak</span>';
                        }

                        logsHtml += `
                            <div class="list-group-item px-3 py-2.5 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="bg-light rounded-circle p-1.5 text-primary border">
                                        <i class="ti ti-arrows-left-right fs-14"></i>
                                    </div>
                                    <div>
                                        <div class="fs-12 fw-semibold text-dark">
                                            <span>${escapeHtml(sName)}</span> <i class="ti ti-arrow-right fs-10 text-muted mx-0.5"></i> <span>${escapeHtml(rName)}</span>
                                        </div>
                                        <div class="fs-11 text-muted">${item.created_at_human || item.created_at}</div>
                                    </div>
                                </div>
                                <div>${badgeStatus}</div>
                            </div>
                        `;
                    });
                    friendshipTimelineEl.innerHTML = logsHtml;
                }
            }

            // 2. Tab Suka Profil
            if (myLikeStatusEl) {
                if (data.is_liked_by_me) {
                    myLikeStatusEl.innerHTML = `<span class="text-danger fw-bold"><i class="ti ti-heart-filled me-1"></i> Menyukai Profil Ini</span>`;
                } else {
                    myLikeStatusEl.innerHTML = `<span class="text-muted"><i class="ti ti-heart-off me-1"></i> Belum Disukai</span>`;
                }
            }

            if (targetLikeStatusEl) {
                if (data.is_liked_target_me) {
                    targetLikeStatusEl.innerHTML = `<span class="text-danger fw-bold"><i class="ti ti-heart-filled me-1"></i> Menyukai Profil Anda</span>`;
                } else {
                    targetLikeStatusEl.innerHTML = `<span class="text-muted"><i class="ti ti-heart-off me-1"></i> Belum Menyukai Anda</span>`;
                }
            }

            if (totalLikesCountEl) {
                totalLikesCountEl.textContent = data.total_likes_count || 0;
            }

            // 3. Tab Obrolan Chat
            if (chatListEl) {
                const cLogs = data.chat_history || [];
                if (cLogs.length === 0) {
                    chatListEl.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="ti ti-message-off fs-24 d-block mb-1.5 opacity-50"></i>
                            <div class="fs-12">Belum ada riwayat pesan obrolan dengan ${user.name}.</div>
                        </div>
                    `;
                } else {
                    let chatsHtml = '<div class="d-flex flex-column gap-2">';
                    cLogs.forEach(cMsg => {
                        const isFromMe = cMsg.sender_id === config.userId;
                        chatsHtml += `
                            <div class="d-flex flex-column ${isFromMe ? 'align-items-end' : 'align-items-start'}">
                                <div class="p-2.5 rounded-3 fs-12 ${isFromMe ? 'bg-primary text-white' : 'bg-white border text-dark shadow-sm'}" style="max-width: 80%;">
                                    ${cMsg.attachment_path ? '<div class="mb-1 opacity-75"><i class="ti ti-paperclip me-1"></i>[Lampiran Berkas]</div>' : ''}
                                    <div style="word-break: break-word;">${escapeHtml(cMsg.message || '')}</div>
                                </div>
                                <div class="fs-10 text-muted mt-0.5 px-1 d-flex align-items-center gap-1">
                                    <span>${cMsg.created_at_human || cMsg.created_at}</span>
                                    ${isFromMe ? (cMsg.is_read ? '<i class="ti ti-checks text-success fs-12" title="Dibaca"></i>' : '<i class="ti ti-check text-muted fs-12" title="Terkirim"></i>') : ''}
                                </div>
                            </div>
                        `;
                    });
                    chatsHtml += '</div>';
                    chatListEl.innerHTML = chatsHtml;
                    chatListEl.scrollTop = chatListEl.scrollHeight;
                }
            }

            // 4. Tab Riwayat Media
            if (mediaListEl) {
                const mLogs = data.media_history || [];
                if (mLogs.length === 0) {
                    mediaListEl.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="ti ti-photo-off fs-24 d-block mb-1.5 opacity-50"></i>
                            <div class="fs-12">Belum ada riwayat perubahan foto profil atau foto sampul.</div>
                        </div>
                    `;
                } else {
                    let mediaHtml = '';
                    mLogs.forEach(mItem => {
                        const isAvatar = mItem.media_type === 'avatar';
                        mediaHtml += `
                            <div class="list-group-item px-3 py-2.5 d-flex align-items-center justify-content-between gap-2">
                                <div class="d-flex align-items-center gap-2.5 min-w-0">
                                    <img src="${mItem.url}" alt="Preview" class="${isAvatar ? 'rounded-circle' : 'rounded'} border shadow-sm flex-shrink-0" style="width: 44px; height: 44px; object-fit: cover;">
                                    <div class="min-w-0">
                                        <div class="d-flex align-items-center gap-1.5 mb-0.5">
                                            <span class="badge ${isAvatar ? 'bg-primary-subtle text-primary' : 'bg-info-subtle text-info'} fs-xxs rounded-pill">
                                                <i class="ti ${isAvatar ? 'ti-user' : 'ti-photo'} me-0.5"></i> ${isAvatar ? 'Avatar Profil' : 'Foto Sampul'}
                                            </span>
                                            <span class="fs-12 fw-semibold text-dark text-truncate">${escapeHtml(mItem.description || 'Pembaruan')}</span>
                                        </div>
                                        <div class="fs-11 text-muted">${mItem.created_at_human || mItem.created_at}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    mediaListEl.innerHTML = mediaHtml;
                }
            }

        } catch (error) {
            console.error('Error fetching user history:', error);
            if (window.showError) window.showError('Terjadi kesalahan saat memuat riwayat pengguna.');
        }
    });

    // 8. Live Filter Search untuk Tabel Riwayat Pertemanan, Suka, Chat & Media
    function bindTableSearchFilter(inputId, rowSelector) {
        const inputEl = document.getElementById(inputId);
        if (!inputEl) return;

        inputEl.addEventListener('input', function () {
            const query = (this.value || '').toLowerCase().trim();
            const rows = document.querySelectorAll(rowSelector);

            rows.forEach(row => {
                const searchText = (row.getAttribute('data-search-text') || row.innerText || '').toLowerCase();
                if (!query || searchText.includes(query)) {
                    row.classList.remove('d-none');
                } else {
                    row.classList.add('d-none');
                }
            });
        });
    }

    bindTableSearchFilter('filter-friendship-history-search', '.friendship-history-row');
    bindTableSearchFilter('filter-likes-history-search', '.likes-history-row');
    bindTableSearchFilter('filter-chats-history-search', '.chats-history-row');
    bindTableSearchFilter('filter-media-history-search', '.media-history-row');

    // 9. Jalankan Polling setiap 3.5 detik (Real-time update)
    if (routes.pollDashboard) {
        setInterval(pollDashboardData, 3500);
        document.addEventListener('visibilitychange', function () {
            if (!document.hidden) {
                pollDashboardData();
            }
        });
    }
});






