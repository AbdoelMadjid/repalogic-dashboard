<!-- Back to Top Button -->
<button type="button" id="back-to-top" class="btn btn-primary btn-icon rounded-circle shadow-lg position-fixed"
        style="bottom: 30px; right: 30px; z-index: 1050; width: 44px; height: 44px; opacity: 0; visibility: hidden; transform: translateY(20px); transition: all 0.3s ease-in-out;"
        aria-label="Kembali ke atas">
    <i class="ti ti-arrow-up fs-lg"></i>
</button>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const backToTopBtn = document.getElementById('back-to-top');
        if (backToTopBtn) {
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopBtn.style.opacity = '1';
                    backToTopBtn.style.visibility = 'visible';
                    backToTopBtn.style.transform = 'translateY(0)';
                } else {
                    backToTopBtn.style.opacity = '0';
                    backToTopBtn.style.visibility = 'hidden';
                    backToTopBtn.style.transform = 'translateY(20px)';
                }
            });

            backToTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>
