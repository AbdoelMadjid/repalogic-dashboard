# Project Rules & Architecture Guidelines

## 1. Views & Scripts in Vertical Layout (`layouts.vertical`)
- Layout `resources/views/layouts/vertical.blade.php` renders `@yield('content')` and does NOT have `@yield('script')`.
- All JavaScript `<script>` blocks for page-specific views MUST be placed inside `@section('content')` before `@endsection`.
- Do NOT use `@section('script')` as it will be ignored and scripts will not execute.

## 2. Event Delegation for Action Buttons & Modals
- Use Event Delegation for table/modal action buttons (e.g. `document.addEventListener('click', function(e) { const btn = e.target.closest('.btn-action-class'); ... })`).
- This ensures buttons work consistently across pagination, live search filtering, and when icons inside buttons are clicked.

## 3. Autoloading Standard
- Standard classes in `app/` (Controllers, Requests, Models) follow PSR-4 naming and do NOT require `composer dump-autoload` unless namespaces or folders are moved/renamed.

## 4. Modal Form Layout & Natural Page Scrolling
- Modals with large content or permission matrices MUST use clean modal dialog sizes (e.g. `modal-xl`).
- Do NOT use internal vertical scroll containers (`max-height` or `overflow-y: auto`) inside modal bodies. Allow the modal form to flow naturally with the browser's main scrollbar.

## 5. Spatie Permission Matrix Table Standard
- For Role & Access assignment forms, display Spatie permissions in a Matrix Table layout:
  - Columns: `MODUL / FITUR`, `CREATE`, `READ`, `UPDATE`, `DELETE`, `LAINNYA`, `SEMUA`.
  - Modules are grouped by Menu & Sub-Menu with level indicators (`Menu Utama`, `Sub: ...`) and target route badges (`manajemenpengguna/roles`).
  - High-contrast checkbox styling: `border: 2px solid #475569 !important`, `width: 1.25em; height: 1.25em`.
  - Top-right `Pilih Semua Permission` header checkbox + per-row `SEMUA` column checkboxes.

## 6. Safe JSON Serialization for Grouped Eloquent Collections
- When passing Eloquent collections that have been grouped (`->groupBy(...)`) to Blade `@json()`, ALWAYS chain `->values()` (e.g. `@json($collection->values())`).
- Reason: `groupBy()` preserves non-sequential database keys (e.g. `{"4": {...}, "12": {...}}`), causing JavaScript to parse it as an Object instead of an Array. This leads to `NaN` errors when indexing `collection[0]`.
- In JavaScript, always use `Array.isArray()` or `Object.values()` as a fallback before accessing index `[0]`.

## 7. Forbidden Custom Dataset Attribute `data-target`
- NEVER use `data-target="..."` as a custom data attribute on action buttons or non-numeric HTML elements.
- Reason: The global theme script `app.js` contains `initCounter()` which searches for ALL elements matching `[data-target]`. It attempts to parse `parseFloat(attr)` and animates the element's `innerText` to `NaN` if the attribute string is non-numeric.
- Use `data-module="..."`, `data-role="..."`, or `data-menu="..."` instead.

## 8. Table Header Alignment & Single-Line Formatting Standard
- ALL table headers (`<thead>`) across all pages, DataTables, and modal tables MUST be centered vertically and horizontally with single-line formatting.
- Always apply `align-middle text-center text-nowrap` to `<thead class="...">`, `<tr class="...">`, and individual `<th>` tags.
- This prevents header text from wrapping onto multiple lines and ensures uniform, clean table styling.

## 9. SweetAlert2 Universal Delete Confirmation Standard
- NEVER use native browser `confirm('...')` popups for delete or reset actions.
- Form submit confirmations MUST use the `data-confirm="..."` attribute on `<form data-confirm="Message text...">`.
- The global submit event listener in `layouts/partials/notifications.blade.php` automatically intercepts forms with `data-confirm`, presenting a modern SweetAlert2 modal with a 12px button gap and custom styling.

## 10. Module Directory Hierarchy & Flat View Naming Standard
- All classes and views for a module MUST follow a consistent folder hierarchy across `Controllers`, `Requests`, `Models`, and `views`:
  - Controllers: `app/Http/Controllers/Admin/{Kelompok}/{Modul}Controller.php`
  - Form Requests: `app/Http/Requests/Admin/{Kelompok}/{Modul}Request.php`
  - Models: `app/Models/Admin/{Kelompok}/{Modul}.php`
  - Views: `resources/views/admin/{kelompok}/{modul}.blade.php`
- Do NOT create a subfolder with `index.blade.php` for admin page views (e.g. use `resources/views/admin/dukunganaplikasi/translation.blade.php`, NOT `resources/views/admin/dukunganaplikasi/translation/index.blade.php`).
- Supporting modals, form elements, and guide components MUST be placed inside the `resources/views/admin/{kelompok}/partials/` folder (e.g. `translation_form.blade.php`, `bilingual_guide_modal.blade.php`).

## 11. Mandatory Changelog & README.md Update Standard
- Whenever new features are added, updated, or modified, and before performing a git push or tag release:
  1. Update `APP_VERSION` in `.env` / `config/app.php` (if releasing a new version).
  2. Add the timeline entry with exact timestamp (YYYY-MM-DD HH:mm WIB) in `resources/views/template/documentation/changelog.blade.php`.
  3. Add the release entry to the Release History table in `README.md`.

## 12. Card Header Color & Widget Styling Standard
- ALL main widget card headers (`<div class="card-header">`) across all pages MUST follow standardized theme styling:
  - Main Settings / Primary Action Widget Headers MUST use `class="card-header bg-primary text-white py-3"` with white title text (`<h5 class="card-title text-white mb-0">`).
  - Data / Content / Neutral Widget Headers MUST use clean white background (`class="card-header bg-white py-3"`).
  - Do NOT use generic `bg-light` for primary card headers.

