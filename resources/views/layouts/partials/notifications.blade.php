<!-- SweetAlert2 CSS & JS Assets -->
<link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                timer: 3500,
                timerProgressBar: true,
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
