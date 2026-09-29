/**
 * Dukungan Aplikasi - Profil Aplikasi Module JavaScript
 * Path: public/assets/js/admin/dukunganaplikasi/profil-aplikasi.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Live Preview Image Uploads using Event Delegation (Rule 2 & 15 Compliance)
    document.addEventListener('change', function(e) {
        const target = e.target;
        if (target && target.matches('input[type="file"][data-preview-id]')) {
            const previewId = target.getAttribute('data-preview-id');
            const previewImg = document.getElementById(previewId);
            
            if (previewImg && target.files && target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    previewImg.src = evt.target.result;
                };
                reader.readAsDataURL(target.files[0]);
            }
        }
    });

    // Form Submit Loading State
    const form = document.getElementById('form-profil-aplikasi');
    const submitBtn = document.getElementById('btn-submit-profil');
    if (form && submitBtn) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1.5" role="status" aria-hidden="true"></span> Menyimpan Profil...';
        });
    }
});
