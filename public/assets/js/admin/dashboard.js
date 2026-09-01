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

    // 4. Live Search & Modern Incremental Load More (12 Pengguna per Klik Anak Panah)
    const contactSearchInput = document.querySelector('#dashboard-contact-search');
    const contactCards = Array.from(document.querySelectorAll('.dashboard-contact-col'));
    const contactEmptyMsg = document.querySelector('#dashboard-contacts-empty');
    const loadmoreContainer = document.querySelector('#dashboard-contacts-loadmore-container');
    const loadmoreBtn = document.querySelector('#dashboard-contacts-loadmore-btn');
    const visibleCountSpan = document.querySelector('#contacts-visible-count');
    const totalCountSpan = document.querySelector('#contacts-total-count');

    const STEP_SIZE = 12;
    let visibleLimit = 12;
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

            return !keyword || name.includes(keyword) || email.includes(keyword) || phone.includes(keyword) || city.includes(keyword) || job.includes(keyword);
        });

        // Reset visible limit to initial 12 on new search
        visibleLimit = 12;
        renderVisibleContacts(false);
    }

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



