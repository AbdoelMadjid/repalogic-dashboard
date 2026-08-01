@extends('layouts.vertical')

@section('content')
    @include('layouts.partials.page-title')

    <div class="row">
        <!-- Hero Banner -->
        <div class="col-12 mb-4">
            <div class="card border-0 bg-dark text-white shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-lg-5">
                    <span class="badge bg-primary text-white fw-semibold px-3 py-1.5 rounded-pill mb-3">Bootstrap 5.3 Color
                        Modes</span>
                    <h2 class="fw-bold text-white mb-2" data-lang="dark-mode">Dark Mode Integration</h2>
                    <p class="text-white-50 fs-16 mb-0">Learn how native dark mode toggle functions using
                        `data-bs-theme="dark"` attribute and CSS custom properties.</p>
                </div>
            </div>
        </div>

        <!-- How Dark Mode Works -->
        <div class="col-12 mb-4">
            <div class="card border shadow-sm">
                <div class="card-header bg-transparent py-3">
                    <h5 class="card-title mb-0 fw-bold"><i class="ti ti-moon-stars me-2 text-primary"></i>HTML Attribute &
                        JavaScript Persistence</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted fs-14 mb-3">Dark mode is toggled dynamically by setting the `data-bs-theme`
                        attribute on the root `<html>` element:</p>
                    <div class="bg-dark text-white p-3 rounded-3 font-monospace fs-13 mb-3">
                        <div class="text-success">&lt;!-- Light Mode --&gt;</div>
                        <div>&lt;html lang="en" data-bs-theme="light"&gt;</div>
                        <br>
                        <div class="text-success">&lt;!-- Dark Mode --&gt;</div>
                        <div>&lt;html lang="en" data-bs-theme="dark"&gt;</div>
                    </div>
                    <p class="text-muted fs-14 mb-0">
                        The current theme state is stored in `localStorage.setItem('theme', 'dark')` so user preferences
                        persist across browser reloads.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
