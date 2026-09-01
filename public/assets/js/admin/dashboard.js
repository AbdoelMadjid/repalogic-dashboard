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
});
