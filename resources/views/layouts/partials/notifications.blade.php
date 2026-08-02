<!-- SweetAlert2 CSS & JS Assets -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<style>
    /* Global Fix: Remove backdrop blur and dark overlay for ALL SweetAlert notifications & toasts */
    .swal2-container,
    .swal2-container.swal2-backdrop-show,
    .swal2-container.swal2-noanimation {
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
    }

    /* Transparent click-through overlay for Toast notifications across the system */
    .swal2-container.swal2-top,
    .swal2-container.swal2-top-start,
    .swal2-container.swal2-top-end,
    .swal2-container.swal2-top-left,
    .swal2-container.swal2-top-right,
    .swal2-container.swal2-center-start,
    .swal2-container.swal2-center-end,
    .swal2-container.swal2-bottom,
    .swal2-container.swal2-bottom-start,
    .swal2-container.swal2-bottom-end,
    .swal2-container.swal2-bottom-left,
    .swal2-container.swal2-bottom-right {
        background: transparent !important;
        pointer-events: none !important;
    }

    /* Ensure Toast popups remain clickable while container is transparent */
    .swal2-popup.swal2-toast,
    .swal2-container.swal2-top-end .swal2-popup,
    .swal2-container.swal2-top-start .swal2-popup,
    .swal2-container.swal2-bottom-end .swal2-popup,
    .swal2-container.swal2-bottom-start .swal2-popup,
    .swal2-container.swal2-top-right .swal2-popup,
    .swal2-container.swal2-top-left .swal2-popup,
    .swal2-container.swal2-bottom-right .swal2-popup,
    .swal2-container.swal2-bottom-left .swal2-popup {
        pointer-events: auto !important;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15) !important;
    }

    /* Add proper spacing gap between SweetAlert action buttons */
    .swal2-actions {
        gap: 12px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Global Event Delegation for Delete/Confirmation Forms (Replaces native browser confirm)
        document.addEventListener('submit', function(e) {
            const form = e.target;
            const dataConfirm = form.getAttribute('data-confirm');
            const onsubmitAttr = form.getAttribute('onsubmit');
            
            let confirmMsg = null;
            if (dataConfirm) {
                confirmMsg = dataConfirm;
            } else if (onsubmitAttr && onsubmitAttr.includes('confirm(')) {
                const match = onsubmitAttr.match(/confirm\(\s*['"]([^'"]+)['"]\s*\)/);
                if (match && match[1]) {
                    confirmMsg = match[1];
                }
            }

            if (confirmMsg) {
                e.preventDefault();
                e.stopPropagation();

                Swal.fire({
                    title: 'Konfirmasi Hapus',
                    text: confirmMsg,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="ti ti-trash me-1"></i> Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-light'
                    },
                    buttonsStyling: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.removeAttribute('onsubmit');
                        form.removeAttribute('data-confirm');
                        delete form.dataset.confirm;
                        form.submit();
                    }
                });
            }
        });

        // Intercept clicks on unprepared/unregistered menu items
        document.body.addEventListener('click', function(e) {
            const unpreparedLink = e.target.closest('.menu-unprepared');
            if (unpreparedLink) {
                e.preventDefault();
                e.stopPropagation();
                const menuTitle = unpreparedLink.getAttribute('data-menu-title') || 'Menu Ini';
                
                Swal.fire({
                    title: 'Belum Dapat Diakses',
                    html: `Fitur/Menu <strong>"${menuTitle}"</strong> sedang dalam tahap pengembangan dan rutenya belum aktif.`,
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-warning'
                    }
                });
            }
        });

        @if (session()->has('notify_swal'))
            const swalData = @json(session('notify_swal'));
            Swal.fire({
                title: swalData.title || 'Informasi',
                text: swalData.text || '',
                icon: swalData.icon || 'info',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        @elseif (session()->has('notify_toast'))
            const toastData = @json(session('notify_toast'));
            const Toast = Swal.mixin({
                toast: true,
                position: toastData.position || 'top-end',
                showConfirmButton: false,
                timer: 4500,
                timerProgressBar: true,
                backdrop: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
            Toast.fire({
                icon: toastData.icon || 'success',
                title: toastData.text || ''
            });
        @elseif (session()->has('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            });
        @elseif (session()->has('error'))
            Swal.fire({
                title: 'Gagal!',
                text: @json(session('error')),
                icon: 'error',
                confirmButtonText: 'OK',
                customClass: {
                    confirmButton: 'btn btn-danger'
                }
            });
        @endif
    });
</script>
