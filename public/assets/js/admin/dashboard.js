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
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const routes = config.routes || {};

    // Helper untuk request AJAX JSON dengan CSRF
    async function sendAjax(url, method = 'POST', bodyData = {}) {
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: method !== 'GET' ? JSON.stringify(bodyData) : null
            });
            return await response.json();
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
                if (window.showToast) window.showToast(res.message, 'success');
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
                if (window.showToast) window.showToast(res.message, 'info');
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
            const friendshipId = btnAcceptFriend.getAttribute('data-friendship-id');
            const userName = btnAcceptFriend.getAttribute('data-user-name') || 'pengguna';
            const wrapper = btnAcceptFriend.closest('.contact-action-wrapper');
            const cardCol = btnAcceptFriend.closest('.dashboard-contact-col');
            const targetUrl = `${routes.acceptFriend}/${friendshipId}`;

            btnAcceptFriend.disabled = true;
            btnAcceptFriend.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Terima...';

            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                const userId = res.sender_id || cardCol?.getAttribute('data-user-id');
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
                if (window.showToast) window.showToast(res.message, 'success');
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
            const friendshipId = btnRejectFriend.getAttribute('data-friendship-id');
            const userName = btnRejectFriend.getAttribute('data-user-name') || 'pengguna';
            const wrapper = btnRejectFriend.closest('.contact-action-wrapper');
            const cardCol = btnRejectFriend.closest('.dashboard-contact-col');
            const targetUrl = `${routes.rejectFriend}/${friendshipId}`;

            btnRejectFriend.disabled = true;
            const res = await sendAjax(targetUrl, 'POST');

            if (res.success) {
                const userId = res.sender_id || cardCol?.getAttribute('data-user-id');
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
                btnRejectFriend.disabled = false;
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

    function renderVisibleContacts(isAppending = false) {
        if (!contactCards.length) return;

        const totalItems = matchedCards.length;
        const currentVisible = Math.min(visibleLimit, totalItems);

        // Hide all cards first
        contactCards.forEach(card => card.classList.add('d-none'));

        // Reveal matching cards up to visibleLimit
        const newlyRevealed = [];
        matchedCards.slice(0, currentVisible).forEach((card, idx) => {
            card.classList.remove('d-none');
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

    // Initial Render
    if (contactCards.length > 0) {
        renderVisibleContacts(false);
    }
});




