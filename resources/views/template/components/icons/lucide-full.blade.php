@extends('layouts.vertical', ['title' => 'Lucide Icons'])

@section('html_attribute')
    data-menu-color="dark"
@endsection

@section('css')
    <style>
        .icon-grid-six {
            --lucide-icon-size: 24px;
            --lucide-icon-color: #000000;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(110px, 1fr));
            gap: 0.75rem;
            justify-items: center;
            align-items: stretch;
            text-align: center;
        }

        .icon-grid-six .inner-icon-item .avatar-title svg,
        .icon-grid-six .inner-icon-item .avatar-title [data-lucide] {
            width: var(--lucide-icon-size) !important;
            height: var(--lucide-icon-size) !important;
            color: var(--lucide-icon-color);
            stroke: currentColor;
            transition: color 0.2s ease-in-out, width 0.2s ease-in-out, height 0.2s ease-in-out;
        }

        .icon-toolbar {
            background: linear-gradient(180deg, rgba(13, 110, 253, 0.05), rgba(13, 110, 253, 0.01));
            border: 1px dashed rgba(33, 37, 41, 0.2);
            border-radius: 0.75rem;
            padding: 1rem;
        }

        .icon-toolbar .toolbar-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #6c757d;
            margin-bottom: 0.35rem;
            display: inline-block;
            font-weight: 600;
        }

        .icon-toolbar .toolbar-control {
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .icon-toolbar .color-control {
            min-height: 38px;
            border-radius: 0.5rem;
            padding: 0.2rem 0.3rem;
        }

        .icon-toolbar .toolbar-reset {
            min-height: 38px;
            height: 100%;
            border-radius: 0.5rem;
            padding-inline: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .snippet-board {
            border: 1px dashed rgba(33, 37, 41, 0.2);
            border-radius: 0.75rem;
            background-color: #f8f9fa;
            overflow: hidden;
            margin-bottom: 1rem;
        }

        .snippet-cell {
            padding: 0.9rem 1rem;
            min-height: 92px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .snippet-cell+.snippet-cell {
            border-left: 1px dashed rgba(33, 37, 41, 0.2);
        }

        .snippet-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #6c757d;
            margin-bottom: 0.45rem;
            font-weight: 600;
        }

        .snippet-preview {
            font-size: 48px;
            color: #000000;
            line-height: 1;
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .snippet-preview svg,
        .snippet-preview [data-lucide] {
            width: 48px !important;
            height: 48px !important;
            color: currentColor;
            stroke: currentColor;
        }

        .snippet-cell.centered {
            align-items: center;
            text-align: center;
        }

        .snippet-icon-name {
            margin-top: 0.45rem;
            font-size: 0.78rem;
            color: #6c757d;
            font-weight: 600;
        }

        .snippet-placeholder {
            color: #adb5bd;
            font-size: 0.82rem;
            font-weight: 500;
        }

        .snippet-code {
            font-family: var(--bs-font-monospace);
            background: #ffffff;
            border: 1px solid rgba(33, 37, 41, 0.1);
            border-radius: 0.5rem;
            padding: 0.55rem 0.7rem;
            margin: 0;
            color: #495057;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media (max-width: 991.98px) {
            .snippet-cell+.snippet-cell {
                border-left: 0;
                border-top: 1px dashed rgba(33, 37, 41, 0.2);
            }
        }

        .avatar-xxl {
            width: 100% !important;
            max-width: 115px;
            height: 115px !important;
        }

        .avatar-title {
            width: 100%;
            height: 100%;
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            justify-content: center !important;
            box-sizing: border-box;
        }

        .avatar-title .fw-semibold {
            font-size: 0.72rem;
            max-width: 90px;
        }

        .inner-icon-item {
            width: 100%;
            display: flex;
            justify-content: center;
            transition: all 0.2s ease-in-out;
            cursor: pointer;
            position: relative;
        }

        .inner-icon-item:hover {
            transform: scale(1.05);
            z-index: 5;
        }

        .inner-icon-item:active {
            transform: scale(0.95);
        }

        .inner-icon-item .copied-badge {
            position: absolute;
            top: 8px;
            right: 8px;
            z-index: 10;
            font-size: 0.68rem;
            letter-spacing: 0.03em;
            padding: 0.2rem 0.45rem;
        }

        .inner-icon-item.is-selected .avatar-title {
            background-color: rgba(13, 110, 253, 0.08);
            border-color: rgba(13, 110, 253, 0.45) !important;
            box-shadow: 0 0 0 2px rgba(13, 110, 253, 0.12);
        }
    </style>
@endsection

@section('content')
    @include('layouts.partials.page-title', ['subtitle' => 'Icons', 'title' => 'Lucide'])

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title mb-1">Overview</h4>
                        <p class="mb-0 text-muted">Lucide is an open-source library of clean, scalable SVG icons for web and app development, offering easy integration and customization.</p>
                    </div> <!-- end card-header-->

                    <div class="card-body border-top border-dashed">
                        <div
                            class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between gap-3 mb-3">
                            <div class="d-flex align-items-center gap-2 flex-wrap">
                                <h4 class="mt-0 mb-0">Icons</h4>
                                <p class="mb-0 text-muted"><i class="ti ti-info-circle me-1"></i> Click on any icon to copy
                                    its
                                    HTML code.</p>
                            </div>
                            <span id="iconVisibleCount" class="badge bg-light text-muted border">Showing 0 icons</span>
                        </div>

                        <div class="icon-toolbar mb-4">
                            <div class="row g-3 align-items-start">
                                <div class="col-lg-6">
                                    <div class="toolbar-control">
                                        <label for="iconSearch" class="toolbar-label">Search Icon</label>
                                        <div class="app-search">
                                            <input type="search" id="iconSearch" class="form-control"
                                                placeholder="Search icons...">
                                            <i class="ti ti-search app-search-icon text-muted"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="toolbar-control">
                                        <label for="iconSize" class="toolbar-label">Icon Size</label>
                                        <select id="iconSize" class="form-select">
                                            <option value="16">16</option>
                                            <option value="24" selected>24</option>
                                            <option value="32">32</option>
                                            <option value="48">48</option>
                                            <option value="64">64</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-lg-3">
                                    <div class="toolbar-control">
                                        <label for="iconColor" class="toolbar-label">Icon Color</label>
                                        <div class="d-flex align-items-stretch gap-2 flex-grow-1">
                                            <input type="color" id="iconColor"
                                                class="form-control form-control-color color-control" value="#000000"
                                                title="Choose icon color">
                                            <span id="iconColorValue"
                                                class="badge bg-light text-muted border flex-grow-1 d-inline-flex align-items-center justify-content-center">#000000</span>
                                            <button type="button" id="toolbarReset"
                                                class="btn btn-light border toolbar-reset" title="Reset toolbar">
                                                <i class="ti ti-refresh"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="snippet-board">
                            <div class="row g-0">
                                <div class="col-lg-3">
                                    <div class="snippet-cell centered">
                                        <div class="snippet-title">Preview Icon</div>
                                        <div class="d-flex align-items-center gap-3">
                                            <div id="snippetPreview" class="snippet-preview me-3"></div>
                                            <div>
                                                <div id="snippetIconName" class="snippet-icon-name snippet-placeholder">Belum dipilih</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="snippet-cell">
                                        <div class="snippet-title">Hasil Snippet Icon</div>
                                        <p id="snippetCode" class="snippet-code mb-0 snippet-placeholder">Belum ada snippet
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="snippet-cell">
                                        <div class="snippet-title">Action</div>
                                        <div class="d-flex gap-2">
                                            <button type="button" id="copySnippetBtn" class="btn btn-primary flex-grow-1"
                                                disabled>
                                                <i class="ti ti-copy me-1"></i>Copy Snippet
                                            </button>
                                            <button type="button" id="clearSelectionBtn" class="btn btn-light border">
                                                <i class="ti ti-restore"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="icon-grid-six">
                                <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="activity"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Activity</span>
                <span data-icon="data-lucide=&quot;activity&quot;" data-name="activity" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="airplay"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Airplay</span>
                <span data-icon="data-lucide=&quot;airplay&quot;" data-name="airplay" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="alarm-clock"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Alarm Clock</span>
                <span data-icon="data-lucide=&quot;alarm-clock&quot;" data-name="alarm-clock" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="alert-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Alert Circle</span>
                <span data-icon="data-lucide=&quot;alert-circle&quot;" data-name="alert-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="alert-octagon"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Alert Octagon</span>
                <span data-icon="data-lucide=&quot;alert-octagon&quot;" data-name="alert-octagon" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="alert-triangle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Alert Triangle</span>
                <span data-icon="data-lucide=&quot;alert-triangle&quot;" data-name="alert-triangle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="align-center"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Align Center</span>
                <span data-icon="data-lucide=&quot;align-center&quot;" data-name="align-center" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="align-justify"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Align Justify</span>
                <span data-icon="data-lucide=&quot;align-justify&quot;" data-name="align-justify" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="align-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Align Left</span>
                <span data-icon="data-lucide=&quot;align-left&quot;" data-name="align-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="align-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Align Right</span>
                <span data-icon="data-lucide=&quot;align-right&quot;" data-name="align-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="anchor"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Anchor</span>
                <span data-icon="data-lucide=&quot;anchor&quot;" data-name="anchor" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="aperture"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Aperture</span>
                <span data-icon="data-lucide=&quot;aperture&quot;" data-name="aperture" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="archive"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Archive</span>
                <span data-icon="data-lucide=&quot;archive&quot;" data-name="archive" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-big-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Big Down</span>
                <span data-icon="data-lucide=&quot;arrow-big-down&quot;" data-name="arrow-big-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-big-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Big Left</span>
                <span data-icon="data-lucide=&quot;arrow-big-left&quot;" data-name="arrow-big-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-big-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Big Right</span>
                <span data-icon="data-lucide=&quot;arrow-big-right&quot;" data-name="arrow-big-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-big-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Big Up</span>
                <span data-icon="data-lucide=&quot;arrow-big-up&quot;" data-name="arrow-big-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Down</span>
                <span data-icon="data-lucide=&quot;arrow-down&quot;" data-name="arrow-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-down-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Down Left</span>
                <span data-icon="data-lucide=&quot;arrow-down-left&quot;" data-name="arrow-down-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-down-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Down Right</span>
                <span data-icon="data-lucide=&quot;arrow-down-right&quot;" data-name="arrow-down-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Left</span>
                <span data-icon="data-lucide=&quot;arrow-left&quot;" data-name="arrow-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Right</span>
                <span data-icon="data-lucide=&quot;arrow-right&quot;" data-name="arrow-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Up</span>
                <span data-icon="data-lucide=&quot;arrow-up&quot;" data-name="arrow-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-up-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Up Left</span>
                <span data-icon="data-lucide=&quot;arrow-up-left&quot;" data-name="arrow-up-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="arrow-up-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Arrow Up Right</span>
                <span data-icon="data-lucide=&quot;arrow-up-right&quot;" data-name="arrow-up-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="at-sign"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">At Sign</span>
                <span data-icon="data-lucide=&quot;at-sign&quot;" data-name="at-sign" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="award"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Award</span>
                <span data-icon="data-lucide=&quot;award&quot;" data-name="award" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="badge-check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Badge Check</span>
                <span data-icon="data-lucide=&quot;badge-check&quot;" data-name="badge-check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="badge-dollar-sign"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Badge Dollar Sign</span>
                <span data-icon="data-lucide=&quot;badge-dollar-sign&quot;" data-name="badge-dollar-sign" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="badge-percent"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Badge Percent</span>
                <span data-icon="data-lucide=&quot;badge-percent&quot;" data-name="badge-percent" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="ban"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Ban</span>
                <span data-icon="data-lucide=&quot;ban&quot;" data-name="ban" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="banknote"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Banknote</span>
                <span data-icon="data-lucide=&quot;banknote&quot;" data-name="banknote" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bar-chart"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bar Chart</span>
                <span data-icon="data-lucide=&quot;bar-chart&quot;" data-name="bar-chart" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bar-chart-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bar Chart 2</span>
                <span data-icon="data-lucide=&quot;bar-chart-2&quot;" data-name="bar-chart-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bar-chart-3"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bar Chart 3</span>
                <span data-icon="data-lucide=&quot;bar-chart-3&quot;" data-name="bar-chart-3" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="baseline"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Baseline</span>
                <span data-icon="data-lucide=&quot;baseline&quot;" data-name="baseline" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="battery"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Battery</span>
                <span data-icon="data-lucide=&quot;battery&quot;" data-name="battery" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="battery-charging"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Battery Charging</span>
                <span data-icon="data-lucide=&quot;battery-charging&quot;" data-name="battery-charging" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="battery-full"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Battery Full</span>
                <span data-icon="data-lucide=&quot;battery-full&quot;" data-name="battery-full" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="battery-low"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Battery Low</span>
                <span data-icon="data-lucide=&quot;battery-low&quot;" data-name="battery-low" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bell"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bell</span>
                <span data-icon="data-lucide=&quot;bell&quot;" data-name="bell" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bell-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bell Off</span>
                <span data-icon="data-lucide=&quot;bell-off&quot;" data-name="bell-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bell-ring"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bell Ring</span>
                <span data-icon="data-lucide=&quot;bell-ring&quot;" data-name="bell-ring" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bluetooth"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bluetooth</span>
                <span data-icon="data-lucide=&quot;bluetooth&quot;" data-name="bluetooth" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="book"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Book</span>
                <span data-icon="data-lucide=&quot;book&quot;" data-name="book" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="book-open"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Book Open</span>
                <span data-icon="data-lucide=&quot;book-open&quot;" data-name="book-open" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bookmark"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bookmark</span>
                <span data-icon="data-lucide=&quot;bookmark&quot;" data-name="bookmark" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="bot"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Bot</span>
                <span data-icon="data-lucide=&quot;bot&quot;" data-name="bot" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="box"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Box</span>
                <span data-icon="data-lucide=&quot;box&quot;" data-name="box" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="briefcase"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Briefcase</span>
                <span data-icon="data-lucide=&quot;briefcase&quot;" data-name="briefcase" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="building"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Building</span>
                <span data-icon="data-lucide=&quot;building&quot;" data-name="building" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="calculator"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Calculator</span>
                <span data-icon="data-lucide=&quot;calculator&quot;" data-name="calculator" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="calendar"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Calendar</span>
                <span data-icon="data-lucide=&quot;calendar&quot;" data-name="calendar" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="camera"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Camera</span>
                <span data-icon="data-lucide=&quot;camera&quot;" data-name="camera" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="camera-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Camera Off</span>
                <span data-icon="data-lucide=&quot;camera-off&quot;" data-name="camera-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cast"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cast</span>
                <span data-icon="data-lucide=&quot;cast&quot;" data-name="cast" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Check</span>
                <span data-icon="data-lucide=&quot;check&quot;" data-name="check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="check-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Check Circle</span>
                <span data-icon="data-lucide=&quot;check-circle&quot;" data-name="check-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="check-circle-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Check Circle 2</span>
                <span data-icon="data-lucide=&quot;check-circle-2&quot;" data-name="check-circle-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="check-square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Check Square</span>
                <span data-icon="data-lucide=&quot;check-square&quot;" data-name="check-square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevron-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevron Down</span>
                <span data-icon="data-lucide=&quot;chevron-down&quot;" data-name="chevron-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevron-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevron Left</span>
                <span data-icon="data-lucide=&quot;chevron-left&quot;" data-name="chevron-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevron-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevron Right</span>
                <span data-icon="data-lucide=&quot;chevron-right&quot;" data-name="chevron-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevron-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevron Up</span>
                <span data-icon="data-lucide=&quot;chevron-up&quot;" data-name="chevron-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevrons-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevrons Down</span>
                <span data-icon="data-lucide=&quot;chevrons-down&quot;" data-name="chevrons-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevrons-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevrons Left</span>
                <span data-icon="data-lucide=&quot;chevrons-left&quot;" data-name="chevrons-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevrons-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevrons Right</span>
                <span data-icon="data-lucide=&quot;chevrons-right&quot;" data-name="chevrons-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chevrons-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chevrons Up</span>
                <span data-icon="data-lucide=&quot;chevrons-up&quot;" data-name="chevrons-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="chrome"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Chrome</span>
                <span data-icon="data-lucide=&quot;chrome&quot;" data-name="chrome" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Circle</span>
                <span data-icon="data-lucide=&quot;circle&quot;" data-name="circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="circle-dollar-sign"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Circle Dollar Sign</span>
                <span data-icon="data-lucide=&quot;circle-dollar-sign&quot;" data-name="circle-dollar-sign" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="circle-dot"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Circle Dot</span>
                <span data-icon="data-lucide=&quot;circle-dot&quot;" data-name="circle-dot" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="circle-ellipsis"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Circle Ellipsis</span>
                <span data-icon="data-lucide=&quot;circle-ellipsis&quot;" data-name="circle-ellipsis" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="clipboard"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Clipboard</span>
                <span data-icon="data-lucide=&quot;clipboard&quot;" data-name="clipboard" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="clipboard-check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Clipboard Check</span>
                <span data-icon="data-lucide=&quot;clipboard-check&quot;" data-name="clipboard-check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="clipboard-copy"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Clipboard Copy</span>
                <span data-icon="data-lucide=&quot;clipboard-copy&quot;" data-name="clipboard-copy" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="clipboard-list"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Clipboard List</span>
                <span data-icon="data-lucide=&quot;clipboard-list&quot;" data-name="clipboard-list" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="clock"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Clock</span>
                <span data-icon="data-lucide=&quot;clock&quot;" data-name="clock" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud</span>
                <span data-icon="data-lucide=&quot;cloud&quot;" data-name="cloud" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-drizzle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Drizzle</span>
                <span data-icon="data-lucide=&quot;cloud-drizzle&quot;" data-name="cloud-drizzle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-fog"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Fog</span>
                <span data-icon="data-lucide=&quot;cloud-fog&quot;" data-name="cloud-fog" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-lightning"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Lightning</span>
                <span data-icon="data-lucide=&quot;cloud-lightning&quot;" data-name="cloud-lightning" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Off</span>
                <span data-icon="data-lucide=&quot;cloud-off&quot;" data-name="cloud-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-rain"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Rain</span>
                <span data-icon="data-lucide=&quot;cloud-rain&quot;" data-name="cloud-rain" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-snow"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Snow</span>
                <span data-icon="data-lucide=&quot;cloud-snow&quot;" data-name="cloud-snow" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-sun"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Sun</span>
                <span data-icon="data-lucide=&quot;cloud-sun&quot;" data-name="cloud-sun" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cloud-upload"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cloud Upload</span>
                <span data-icon="data-lucide=&quot;cloud-upload&quot;" data-name="cloud-upload" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="code"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Code</span>
                <span data-icon="data-lucide=&quot;code&quot;" data-name="code" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="code-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Code 2</span>
                <span data-icon="data-lucide=&quot;code-2&quot;" data-name="code-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="coffee"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Coffee</span>
                <span data-icon="data-lucide=&quot;coffee&quot;" data-name="coffee" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cog"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cog</span>
                <span data-icon="data-lucide=&quot;cog&quot;" data-name="cog" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="command"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Command</span>
                <span data-icon="data-lucide=&quot;command&quot;" data-name="command" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="compass"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Compass</span>
                <span data-icon="data-lucide=&quot;compass&quot;" data-name="compass" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="contact"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Contact</span>
                <span data-icon="data-lucide=&quot;contact&quot;" data-name="contact" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="copy"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Copy</span>
                <span data-icon="data-lucide=&quot;copy&quot;" data-name="copy" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-down-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Down Left</span>
                <span data-icon="data-lucide=&quot;corner-down-left&quot;" data-name="corner-down-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-down-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Down Right</span>
                <span data-icon="data-lucide=&quot;corner-down-right&quot;" data-name="corner-down-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-left-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Left Down</span>
                <span data-icon="data-lucide=&quot;corner-left-down&quot;" data-name="corner-left-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-left-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Left Up</span>
                <span data-icon="data-lucide=&quot;corner-left-up&quot;" data-name="corner-left-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-right-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Right Down</span>
                <span data-icon="data-lucide=&quot;corner-right-down&quot;" data-name="corner-right-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-right-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Right Up</span>
                <span data-icon="data-lucide=&quot;corner-right-up&quot;" data-name="corner-right-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-up-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Up Left</span>
                <span data-icon="data-lucide=&quot;corner-up-left&quot;" data-name="corner-up-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="corner-up-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Corner Up Right</span>
                <span data-icon="data-lucide=&quot;corner-up-right&quot;" data-name="corner-up-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="cpu"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Cpu</span>
                <span data-icon="data-lucide=&quot;cpu&quot;" data-name="cpu" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="credit-card"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Credit Card</span>
                <span data-icon="data-lucide=&quot;credit-card&quot;" data-name="credit-card" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="crop"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Crop</span>
                <span data-icon="data-lucide=&quot;crop&quot;" data-name="crop" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="crosshair"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Crosshair</span>
                <span data-icon="data-lucide=&quot;crosshair&quot;" data-name="crosshair" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="crown"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Crown</span>
                <span data-icon="data-lucide=&quot;crown&quot;" data-name="crown" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="database"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Database</span>
                <span data-icon="data-lucide=&quot;database&quot;" data-name="database" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="delete"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Delete</span>
                <span data-icon="data-lucide=&quot;delete&quot;" data-name="delete" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="disc"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Disc</span>
                <span data-icon="data-lucide=&quot;disc&quot;" data-name="disc" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="download"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Download</span>
                <span data-icon="data-lucide=&quot;download&quot;" data-name="download" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="edit"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Edit</span>
                <span data-icon="data-lucide=&quot;edit&quot;" data-name="edit" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="edit-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Edit 2</span>
                <span data-icon="data-lucide=&quot;edit-2&quot;" data-name="edit-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="edit-3"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Edit 3</span>
                <span data-icon="data-lucide=&quot;edit-3&quot;" data-name="edit-3" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="external-link"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">External Link</span>
                <span data-icon="data-lucide=&quot;external-link&quot;" data-name="external-link" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="eye"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Eye</span>
                <span data-icon="data-lucide=&quot;eye&quot;" data-name="eye" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="eye-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Eye Off</span>
                <span data-icon="data-lucide=&quot;eye-off&quot;" data-name="eye-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="facebook"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Facebook</span>
                <span data-icon="data-lucide=&quot;facebook&quot;" data-name="facebook" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="fast-forward"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Fast Forward</span>
                <span data-icon="data-lucide=&quot;fast-forward&quot;" data-name="fast-forward" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="feather"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Feather</span>
                <span data-icon="data-lucide=&quot;feather&quot;" data-name="feather" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="figma"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Figma</span>
                <span data-icon="data-lucide=&quot;figma&quot;" data-name="figma" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File</span>
                <span data-icon="data-lucide=&quot;file&quot;" data-name="file" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Check</span>
                <span data-icon="data-lucide=&quot;file-check&quot;" data-name="file-check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-code"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Code</span>
                <span data-icon="data-lucide=&quot;file-code&quot;" data-name="file-code" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-digit"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Digit</span>
                <span data-icon="data-lucide=&quot;file-digit&quot;" data-name="file-digit" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-input"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Input</span>
                <span data-icon="data-lucide=&quot;file-input&quot;" data-name="file-input" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-minus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Minus</span>
                <span data-icon="data-lucide=&quot;file-minus&quot;" data-name="file-minus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-output"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Output</span>
                <span data-icon="data-lucide=&quot;file-output&quot;" data-name="file-output" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-plus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Plus</span>
                <span data-icon="data-lucide=&quot;file-plus&quot;" data-name="file-plus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-text"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File Text</span>
                <span data-icon="data-lucide=&quot;file-text&quot;" data-name="file-text" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="file-x"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">File X</span>
                <span data-icon="data-lucide=&quot;file-x&quot;" data-name="file-x" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="film"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Film</span>
                <span data-icon="data-lucide=&quot;film&quot;" data-name="film" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="filter"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Filter</span>
                <span data-icon="data-lucide=&quot;filter&quot;" data-name="filter" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="flag"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Flag</span>
                <span data-icon="data-lucide=&quot;flag&quot;" data-name="flag" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="folder"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Folder</span>
                <span data-icon="data-lucide=&quot;folder&quot;" data-name="folder" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="folder-minus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Folder Minus</span>
                <span data-icon="data-lucide=&quot;folder-minus&quot;" data-name="folder-minus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="folder-open"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Folder Open</span>
                <span data-icon="data-lucide=&quot;folder-open&quot;" data-name="folder-open" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="folder-plus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Folder Plus</span>
                <span data-icon="data-lucide=&quot;folder-plus&quot;" data-name="folder-plus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="frown"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Frown</span>
                <span data-icon="data-lucide=&quot;frown&quot;" data-name="frown" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="gamepad-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Gamepad 2</span>
                <span data-icon="data-lucide=&quot;gamepad-2&quot;" data-name="gamepad-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="gauge"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Gauge</span>
                <span data-icon="data-lucide=&quot;gauge&quot;" data-name="gauge" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="gift"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Gift</span>
                <span data-icon="data-lucide=&quot;gift&quot;" data-name="gift" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="git-branch"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Git Branch</span>
                <span data-icon="data-lucide=&quot;git-branch&quot;" data-name="git-branch" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="git-commit"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Git Commit</span>
                <span data-icon="data-lucide=&quot;git-commit&quot;" data-name="git-commit" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="git-fork"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Git Fork</span>
                <span data-icon="data-lucide=&quot;git-fork&quot;" data-name="git-fork" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="git-merge"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Git Merge</span>
                <span data-icon="data-lucide=&quot;git-merge&quot;" data-name="git-merge" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="git-pull-request"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Git Pull Request</span>
                <span data-icon="data-lucide=&quot;git-pull-request&quot;" data-name="git-pull-request" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="github"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Github</span>
                <span data-icon="data-lucide=&quot;github&quot;" data-name="github" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="gitlab"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Gitlab</span>
                <span data-icon="data-lucide=&quot;gitlab&quot;" data-name="gitlab" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="globe"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Globe</span>
                <span data-icon="data-lucide=&quot;globe&quot;" data-name="globe" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="grid"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Grid</span>
                <span data-icon="data-lucide=&quot;grid&quot;" data-name="grid" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="hard-drive"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Hard Drive</span>
                <span data-icon="data-lucide=&quot;hard-drive&quot;" data-name="hard-drive" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="hash"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Hash</span>
                <span data-icon="data-lucide=&quot;hash&quot;" data-name="hash" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="headphones"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Headphones</span>
                <span data-icon="data-lucide=&quot;headphones&quot;" data-name="headphones" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="headset"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Headset</span>
                <span data-icon="data-lucide=&quot;headset&quot;" data-name="headset" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="heart"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Heart</span>
                <span data-icon="data-lucide=&quot;heart&quot;" data-name="heart" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="help-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Help Circle</span>
                <span data-icon="data-lucide=&quot;help-circle&quot;" data-name="help-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="history"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">History</span>
                <span data-icon="data-lucide=&quot;history&quot;" data-name="history" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="home"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Home</span>
                <span data-icon="data-lucide=&quot;home&quot;" data-name="home" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="image"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Image</span>
                <span data-icon="data-lucide=&quot;image&quot;" data-name="image" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="inbox"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Inbox</span>
                <span data-icon="data-lucide=&quot;inbox&quot;" data-name="inbox" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="info"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Info</span>
                <span data-icon="data-lucide=&quot;info&quot;" data-name="info" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="instagram"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Instagram</span>
                <span data-icon="data-lucide=&quot;instagram&quot;" data-name="instagram" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="italic"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Italic</span>
                <span data-icon="data-lucide=&quot;italic&quot;" data-name="italic" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="key"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Key</span>
                <span data-icon="data-lucide=&quot;key&quot;" data-name="key" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="layers"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Layers</span>
                <span data-icon="data-lucide=&quot;layers&quot;" data-name="layers" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="layout"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Layout</span>
                <span data-icon="data-lucide=&quot;layout&quot;" data-name="layout" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="layout-dashboard"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Layout Dashboard</span>
                <span data-icon="data-lucide=&quot;layout-dashboard&quot;" data-name="layout-dashboard" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="life-buoy"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Life Buoy</span>
                <span data-icon="data-lucide=&quot;life-buoy&quot;" data-name="life-buoy" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="link"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Link</span>
                <span data-icon="data-lucide=&quot;link&quot;" data-name="link" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="linkedin"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Linkedin</span>
                <span data-icon="data-lucide=&quot;linkedin&quot;" data-name="linkedin" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="list"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">List</span>
                <span data-icon="data-lucide=&quot;list&quot;" data-name="list" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="loader"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Loader</span>
                <span data-icon="data-lucide=&quot;loader&quot;" data-name="loader" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="lock"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Lock</span>
                <span data-icon="data-lucide=&quot;lock&quot;" data-name="lock" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="log-in"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Log In</span>
                <span data-icon="data-lucide=&quot;log-in&quot;" data-name="log-in" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="log-out"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Log Out</span>
                <span data-icon="data-lucide=&quot;log-out&quot;" data-name="log-out" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="mail"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Mail</span>
                <span data-icon="data-lucide=&quot;mail&quot;" data-name="mail" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="map"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Map</span>
                <span data-icon="data-lucide=&quot;map&quot;" data-name="map" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="map-pin"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Map Pin</span>
                <span data-icon="data-lucide=&quot;map-pin&quot;" data-name="map-pin" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="maximize"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Maximize</span>
                <span data-icon="data-lucide=&quot;maximize&quot;" data-name="maximize" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="maximize-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Maximize 2</span>
                <span data-icon="data-lucide=&quot;maximize-2&quot;" data-name="maximize-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="meh"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Meh</span>
                <span data-icon="data-lucide=&quot;meh&quot;" data-name="meh" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="menu"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Menu</span>
                <span data-icon="data-lucide=&quot;menu&quot;" data-name="menu" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="message-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Message Circle</span>
                <span data-icon="data-lucide=&quot;message-circle&quot;" data-name="message-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="message-square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Message Square</span>
                <span data-icon="data-lucide=&quot;message-square&quot;" data-name="message-square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="mic"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Mic</span>
                <span data-icon="data-lucide=&quot;mic&quot;" data-name="mic" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="mic-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Mic Off</span>
                <span data-icon="data-lucide=&quot;mic-off&quot;" data-name="mic-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="minimize"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Minimize</span>
                <span data-icon="data-lucide=&quot;minimize&quot;" data-name="minimize" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="minimize-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Minimize 2</span>
                <span data-icon="data-lucide=&quot;minimize-2&quot;" data-name="minimize-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="minus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Minus</span>
                <span data-icon="data-lucide=&quot;minus&quot;" data-name="minus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="minus-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Minus Circle</span>
                <span data-icon="data-lucide=&quot;minus-circle&quot;" data-name="minus-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="minus-square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Minus Square</span>
                <span data-icon="data-lucide=&quot;minus-square&quot;" data-name="minus-square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="monitor"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Monitor</span>
                <span data-icon="data-lucide=&quot;monitor&quot;" data-name="monitor" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="moon"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Moon</span>
                <span data-icon="data-lucide=&quot;moon&quot;" data-name="moon" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="more-horizontal"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">More Horizontal</span>
                <span data-icon="data-lucide=&quot;more-horizontal&quot;" data-name="more-horizontal" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="more-vertical"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">More Vertical</span>
                <span data-icon="data-lucide=&quot;more-vertical&quot;" data-name="more-vertical" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="mouse-pointer"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Mouse Pointer</span>
                <span data-icon="data-lucide=&quot;mouse-pointer&quot;" data-name="mouse-pointer" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="move"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Move</span>
                <span data-icon="data-lucide=&quot;move&quot;" data-name="move" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="music"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Music</span>
                <span data-icon="data-lucide=&quot;music&quot;" data-name="music" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="navigation"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Navigation</span>
                <span data-icon="data-lucide=&quot;navigation&quot;" data-name="navigation" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="option"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Option</span>
                <span data-icon="data-lucide=&quot;option&quot;" data-name="option" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="package"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Package</span>
                <span data-icon="data-lucide=&quot;package&quot;" data-name="package" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="paperclip"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Paperclip</span>
                <span data-icon="data-lucide=&quot;paperclip&quot;" data-name="paperclip" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="pause"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Pause</span>
                <span data-icon="data-lucide=&quot;pause&quot;" data-name="pause" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="pause-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Pause Circle</span>
                <span data-icon="data-lucide=&quot;pause-circle&quot;" data-name="pause-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="pen-tool"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Pen Tool</span>
                <span data-icon="data-lucide=&quot;pen-tool&quot;" data-name="pen-tool" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="percent"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Percent</span>
                <span data-icon="data-lucide=&quot;percent&quot;" data-name="percent" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone</span>
                <span data-icon="data-lucide=&quot;phone&quot;" data-name="phone" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-call"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Call</span>
                <span data-icon="data-lucide=&quot;phone-call&quot;" data-name="phone-call" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-forwarded"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Forwarded</span>
                <span data-icon="data-lucide=&quot;phone-forwarded&quot;" data-name="phone-forwarded" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-incoming"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Incoming</span>
                <span data-icon="data-lucide=&quot;phone-incoming&quot;" data-name="phone-incoming" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-missed"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Missed</span>
                <span data-icon="data-lucide=&quot;phone-missed&quot;" data-name="phone-missed" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Off</span>
                <span data-icon="data-lucide=&quot;phone-off&quot;" data-name="phone-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="phone-outgoing"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Phone Outgoing</span>
                <span data-icon="data-lucide=&quot;phone-outgoing&quot;" data-name="phone-outgoing" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="pie-chart"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Pie Chart</span>
                <span data-icon="data-lucide=&quot;pie-chart&quot;" data-name="pie-chart" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="pin"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Pin</span>
                <span data-icon="data-lucide=&quot;pin&quot;" data-name="pin" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="play"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Play</span>
                <span data-icon="data-lucide=&quot;play&quot;" data-name="play" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="play-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Play Circle</span>
                <span data-icon="data-lucide=&quot;play-circle&quot;" data-name="play-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="plug"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Plug</span>
                <span data-icon="data-lucide=&quot;plug&quot;" data-name="plug" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="plus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Plus</span>
                <span data-icon="data-lucide=&quot;plus&quot;" data-name="plus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="plus-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Plus Circle</span>
                <span data-icon="data-lucide=&quot;plus-circle&quot;" data-name="plus-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="plus-square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Plus Square</span>
                <span data-icon="data-lucide=&quot;plus-square&quot;" data-name="plus-square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="power"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Power</span>
                <span data-icon="data-lucide=&quot;power&quot;" data-name="power" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="printer"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Printer</span>
                <span data-icon="data-lucide=&quot;printer&quot;" data-name="printer" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="radio"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Radio</span>
                <span data-icon="data-lucide=&quot;radio&quot;" data-name="radio" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="refresh-ccw"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Refresh Ccw</span>
                <span data-icon="data-lucide=&quot;refresh-ccw&quot;" data-name="refresh-ccw" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="refresh-cw"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Refresh Cw</span>
                <span data-icon="data-lucide=&quot;refresh-cw&quot;" data-name="refresh-cw" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="repeat"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Repeat</span>
                <span data-icon="data-lucide=&quot;repeat&quot;" data-name="repeat" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="rotate-ccw"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Rotate Ccw</span>
                <span data-icon="data-lucide=&quot;rotate-ccw&quot;" data-name="rotate-ccw" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="rotate-cw"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Rotate Cw</span>
                <span data-icon="data-lucide=&quot;rotate-cw&quot;" data-name="rotate-cw" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="rss"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Rss</span>
                <span data-icon="data-lucide=&quot;rss&quot;" data-name="rss" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="save"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Save</span>
                <span data-icon="data-lucide=&quot;save&quot;" data-name="save" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="scissors"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Scissors</span>
                <span data-icon="data-lucide=&quot;scissors&quot;" data-name="scissors" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="search"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Search</span>
                <span data-icon="data-lucide=&quot;search&quot;" data-name="search" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="send"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Send</span>
                <span data-icon="data-lucide=&quot;send&quot;" data-name="send" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="settings"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Settings</span>
                <span data-icon="data-lucide=&quot;settings&quot;" data-name="settings" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="share"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Share</span>
                <span data-icon="data-lucide=&quot;share&quot;" data-name="share" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="share-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Share 2</span>
                <span data-icon="data-lucide=&quot;share-2&quot;" data-name="share-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shield"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shield</span>
                <span data-icon="data-lucide=&quot;shield&quot;" data-name="shield" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shield-alert"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shield Alert</span>
                <span data-icon="data-lucide=&quot;shield-alert&quot;" data-name="shield-alert" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shield-check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shield Check</span>
                <span data-icon="data-lucide=&quot;shield-check&quot;" data-name="shield-check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shield-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shield Off</span>
                <span data-icon="data-lucide=&quot;shield-off&quot;" data-name="shield-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shopping-bag"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shopping Bag</span>
                <span data-icon="data-lucide=&quot;shopping-bag&quot;" data-name="shopping-bag" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shopping-cart"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shopping Cart</span>
                <span data-icon="data-lucide=&quot;shopping-cart&quot;" data-name="shopping-cart" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="shuffle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Shuffle</span>
                <span data-icon="data-lucide=&quot;shuffle&quot;" data-name="shuffle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="sidebar"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Sidebar</span>
                <span data-icon="data-lucide=&quot;sidebar&quot;" data-name="sidebar" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="skip-back"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Skip Back</span>
                <span data-icon="data-lucide=&quot;skip-back&quot;" data-name="skip-back" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="skip-forward"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Skip Forward</span>
                <span data-icon="data-lucide=&quot;skip-forward&quot;" data-name="skip-forward" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="slash"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Slash</span>
                <span data-icon="data-lucide=&quot;slash&quot;" data-name="slash" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="sliders"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Sliders</span>
                <span data-icon="data-lucide=&quot;sliders&quot;" data-name="sliders" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="smartphone"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Smartphone</span>
                <span data-icon="data-lucide=&quot;smartphone&quot;" data-name="smartphone" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="smile"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Smile</span>
                <span data-icon="data-lucide=&quot;smile&quot;" data-name="smile" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="speaker"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Speaker</span>
                <span data-icon="data-lucide=&quot;speaker&quot;" data-name="speaker" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Square</span>
                <span data-icon="data-lucide=&quot;square&quot;" data-name="square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="star"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Star</span>
                <span data-icon="data-lucide=&quot;star&quot;" data-name="star" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="sun"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Sun</span>
                <span data-icon="data-lucide=&quot;sun&quot;" data-name="sun" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="tablet"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Tablet</span>
                <span data-icon="data-lucide=&quot;tablet&quot;" data-name="tablet" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="tag"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Tag</span>
                <span data-icon="data-lucide=&quot;tag&quot;" data-name="tag" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="target"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Target</span>
                <span data-icon="data-lucide=&quot;target&quot;" data-name="target" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="terminal"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Terminal</span>
                <span data-icon="data-lucide=&quot;terminal&quot;" data-name="terminal" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="thermometer"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Thermometer</span>
                <span data-icon="data-lucide=&quot;thermometer&quot;" data-name="thermometer" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="thumbs-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Thumbs Down</span>
                <span data-icon="data-lucide=&quot;thumbs-down&quot;" data-name="thumbs-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="thumbs-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Thumbs Up</span>
                <span data-icon="data-lucide=&quot;thumbs-up&quot;" data-name="thumbs-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="toggle-left"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Toggle Left</span>
                <span data-icon="data-lucide=&quot;toggle-left&quot;" data-name="toggle-left" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="toggle-right"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Toggle Right</span>
                <span data-icon="data-lucide=&quot;toggle-right&quot;" data-name="toggle-right" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="tool"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Tool</span>
                <span data-icon="data-lucide=&quot;tool&quot;" data-name="tool" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="trash"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Trash</span>
                <span data-icon="data-lucide=&quot;trash&quot;" data-name="trash" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="trash-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Trash 2</span>
                <span data-icon="data-lucide=&quot;trash-2&quot;" data-name="trash-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="trello"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Trello</span>
                <span data-icon="data-lucide=&quot;trello&quot;" data-name="trello" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="trending-down"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Trending Down</span>
                <span data-icon="data-lucide=&quot;trending-down&quot;" data-name="trending-down" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="trending-up"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Trending Up</span>
                <span data-icon="data-lucide=&quot;trending-up&quot;" data-name="trending-up" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="triangle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Triangle</span>
                <span data-icon="data-lucide=&quot;triangle&quot;" data-name="triangle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="truck"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Truck</span>
                <span data-icon="data-lucide=&quot;truck&quot;" data-name="truck" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="tv"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Tv</span>
                <span data-icon="data-lucide=&quot;tv&quot;" data-name="tv" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="twitter"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Twitter</span>
                <span data-icon="data-lucide=&quot;twitter&quot;" data-name="twitter" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="type"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Type</span>
                <span data-icon="data-lucide=&quot;type&quot;" data-name="type" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="umbrella"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Umbrella</span>
                <span data-icon="data-lucide=&quot;umbrella&quot;" data-name="umbrella" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="underline"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Underline</span>
                <span data-icon="data-lucide=&quot;underline&quot;" data-name="underline" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="unlock"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Unlock</span>
                <span data-icon="data-lucide=&quot;unlock&quot;" data-name="unlock" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="upload"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Upload</span>
                <span data-icon="data-lucide=&quot;upload&quot;" data-name="upload" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="usb"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Usb</span>
                <span data-icon="data-lucide=&quot;usb&quot;" data-name="usb" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User</span>
                <span data-icon="data-lucide=&quot;user&quot;" data-name="user" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user-check"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User Check</span>
                <span data-icon="data-lucide=&quot;user-check&quot;" data-name="user-check" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User Circle</span>
                <span data-icon="data-lucide=&quot;user-circle&quot;" data-name="user-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user-minus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User Minus</span>
                <span data-icon="data-lucide=&quot;user-minus&quot;" data-name="user-minus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user-plus"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User Plus</span>
                <span data-icon="data-lucide=&quot;user-plus&quot;" data-name="user-plus" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="user-x"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">User X</span>
                <span data-icon="data-lucide=&quot;user-x&quot;" data-name="user-x" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="users"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Users</span>
                <span data-icon="data-lucide=&quot;users&quot;" data-name="users" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="video"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Video</span>
                <span data-icon="data-lucide=&quot;video&quot;" data-name="video" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="video-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Video Off</span>
                <span data-icon="data-lucide=&quot;video-off&quot;" data-name="video-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="voicemail"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Voicemail</span>
                <span data-icon="data-lucide=&quot;voicemail&quot;" data-name="voicemail" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="volume"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Volume</span>
                <span data-icon="data-lucide=&quot;volume&quot;" data-name="volume" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="volume-1"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Volume 1</span>
                <span data-icon="data-lucide=&quot;volume-1&quot;" data-name="volume-1" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="volume-2"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Volume 2</span>
                <span data-icon="data-lucide=&quot;volume-2&quot;" data-name="volume-2" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="volume-x"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Volume X</span>
                <span data-icon="data-lucide=&quot;volume-x&quot;" data-name="volume-x" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="wallet"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Wallet</span>
                <span data-icon="data-lucide=&quot;wallet&quot;" data-name="wallet" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="watch"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Watch</span>
                <span data-icon="data-lucide=&quot;watch&quot;" data-name="watch" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="wifi"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Wifi</span>
                <span data-icon="data-lucide=&quot;wifi&quot;" data-name="wifi" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="wifi-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Wifi Off</span>
                <span data-icon="data-lucide=&quot;wifi-off&quot;" data-name="wifi-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="wind"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Wind</span>
                <span data-icon="data-lucide=&quot;wind&quot;" data-name="wind" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="x"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">X</span>
                <span data-icon="data-lucide=&quot;x&quot;" data-name="x" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="x-circle"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">X Circle</span>
                <span data-icon="data-lucide=&quot;x-circle&quot;" data-name="x-circle" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="x-square"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">X Square</span>
                <span data-icon="data-lucide=&quot;x-square&quot;" data-name="x-square" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="youtube"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Youtube</span>
                <span data-icon="data-lucide=&quot;youtube&quot;" data-name="youtube" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="zap"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Zap</span>
                <span data-icon="data-lucide=&quot;zap&quot;" data-name="zap" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="zap-off"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Zap Off</span>
                <span data-icon="data-lucide=&quot;zap-off&quot;" data-name="zap-off" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="zoom-in"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Zoom In</span>
                <span data-icon="data-lucide=&quot;zoom-in&quot;" data-name="zoom-in" class="d-none"></span>
            </span>
        </div>
    </div>    <div class="inner-icon-item">
        <div class="avatar-xxl">
            <span class="avatar-title flex-column gap-1 border border-dashed rounded-3 p-1 text-center">
                <i data-lucide="zoom-out"></i>
                <span class="fw-semibold d-block w-100 text-truncate fs-11 text-body">Zoom Out</span>
                <span data-icon="data-lucide=&quot;zoom-out&quot;" data-name="zoom-out" class="d-none"></span>
            </span>
        </div>
    </div>
                        </div> <!-- end display-->

                        <div class="text-center mt-3">
                            <a href="<?php echo route('template.components.icons.lucide'); ?>" class="btn btn-primary"><i class="ti ti-arrow-left me-1"></i> Back to Lucide Overview</a>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row-->
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let selectedSnippet = '';
            let selectedIconName = '';

            async function copyToClipboard(text) {
                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(text);
                    } else {
                        throw new Error('Clipboard API unavailable');
                    }
                } catch (err) {
                    const textArea = document.createElement("textarea");
                    textArea.value = text;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    textArea.style.top = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        textArea.remove();
                    } catch (error) {
                        textArea.remove();
                        throw error;
                    }
                }
            }

            const snippetPreview = document.getElementById('snippetPreview');
            const snippetCode = document.getElementById('snippetCode');
            const snippetIconName = document.getElementById('snippetIconName');
            const copySnippetBtn = document.getElementById('copySnippetBtn');
            const clearSelectionBtn = document.getElementById('clearSelectionBtn');
            const snippetBoard = document.querySelector('.snippet-board');
            const cardHeaderAnchor = snippetBoard ? snippetBoard.closest('.card')?.querySelector('.card-header') : null;
            const searchInput = document.getElementById('iconSearch');
            const sizeInput = document.getElementById('iconSize');
            const colorInput = document.getElementById('iconColor');
            const colorValue = document.getElementById('iconColorValue');
            const resetButton = document.getElementById('toolbarReset');
            const visibleCountEl = document.getElementById('iconVisibleCount');
            const iconGrid = document.querySelector('.icon-grid-six');
            const iconItems = document.querySelectorAll('.inner-icon-item');

            function buildSnippet(iconName) {
                return `<i data-lucide="${iconName}"></i>`;
            }

            function setSnippet(iconName, iconElement) {
                selectedIconName = iconName;
                selectedSnippet = buildSnippet(iconName);

                if (snippetPreview) {
                    if (iconElement) {
                        snippetPreview.innerHTML = iconElement.outerHTML;
                    } else {
                        snippetPreview.innerHTML = `<i data-lucide="${iconName}"></i>`;
                        if (window.lucide) {
                            window.lucide.createIcons();
                        }
                    }
                }

                if (snippetCode) {
                    snippetCode.textContent = selectedSnippet;
                    snippetCode.classList.remove('snippet-placeholder');
                }

                if (snippetIconName) {
                    snippetIconName.textContent = iconName;
                    snippetIconName.classList.remove('snippet-placeholder');
                }

                if (copySnippetBtn) {
                    copySnippetBtn.disabled = false;
                }
            }

            function clearSnippetSelection() {
                selectedIconName = '';
                selectedSnippet = '';

                document.querySelectorAll('.inner-icon-item.is-selected').forEach(activeItem => {
                    activeItem.classList.remove('is-selected');
                    const activeBadge = activeItem.querySelector('.copied-badge');
                    if (activeBadge) activeBadge.remove();
                });

                if (snippetPreview) {
                    snippetPreview.innerHTML = '';
                }

                if (snippetCode) {
                    snippetCode.textContent = 'Belum ada snippet';
                    snippetCode.classList.add('snippet-placeholder');
                }

                if (snippetIconName) {
                    snippetIconName.textContent = 'Belum dipilih';
                    snippetIconName.classList.add('snippet-placeholder');
                }

                if (copySnippetBtn) {
                    copySnippetBtn.disabled = true;
                    copySnippetBtn.innerHTML = '<i class="ti ti-copy me-1"></i>Copy Snippet';
                }
            }

            document.addEventListener('click', function(e) {
                const item = e.target.closest('.inner-icon-item');
                if (!item) return;

                const span = item.querySelector('span[data-name]');
                if (span) {
                    document.querySelectorAll('.inner-icon-item.is-selected').forEach(activeItem => {
                        activeItem.classList.remove('is-selected');
                        const activeBadge = activeItem.querySelector('.copied-badge');
                        if (activeBadge) activeBadge.remove();
                    });

                    item.classList.add('is-selected');
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-success-subtle text-success border copied-badge';
                    badge.textContent = 'Copied';
                    item.appendChild(badge);

                    const iconName = span.getAttribute('data-name');
                    const svgOrI = item.querySelector('svg') || item.querySelector('[data-lucide]');
                    setSnippet(iconName, svgOrI);

                    if (cardHeaderAnchor) {
                        cardHeaderAnchor.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });

            if (copySnippetBtn) {
                copySnippetBtn.addEventListener('click', function() {
                    if (!selectedSnippet) return;

                    copyToClipboard(selectedSnippet).then(() => {
                        this.innerHTML = '<i class="ti ti-check me-1"></i>Copied';
                        setTimeout(() => {
                            this.innerHTML = '<i class="ti ti-copy me-1"></i>Copy Snippet';
                        }, 1200);
                    }).catch(err => {
                        console.error('Failed to copy: ', err);
                    });
                });
            }

            if (clearSelectionBtn) {
                clearSelectionBtn.addEventListener('click', function() {
                    clearSnippetSelection();
                });
            }

            function updateVisibleCount() {
                if (!visibleCountEl) return;
                const visible = Array.from(iconItems).filter(item => item.style.display !== 'none').length;
                visibleCountEl.textContent = `Showing ${visible} icons`;
            }

            function applySize(value) {
                if (!iconGrid) return;
                iconGrid.style.setProperty('--lucide-icon-size', `${value}px`);
            }

            function applyColor(value) {
                if (!iconGrid) return;
                iconGrid.style.setProperty('--lucide-icon-color', value);
                if (snippetPreview) {
                    snippetPreview.style.color = value;
                }
                if (colorValue) colorValue.textContent = value.toUpperCase();
            }

            function applyFilters() {
                const query = searchInput ? searchInput.value.toLowerCase().trim() : '';
                const words = query.split(/\s+/).filter(w => w.length > 0);

                iconItems.forEach(item => {
                    const iconSpan = item.querySelector('span[data-name]');
                    const nameSpan = item.querySelector('.fw-semibold');

                    let searchableText = '';
                    if (iconSpan) {
                        const dataName = iconSpan.getAttribute('data-name');
                        searchableText += dataName + ' ' + dataName.replace(/-/g, ' ') + ' ';
                    }
                    if (nameSpan) {
                        searchableText += nameSpan.textContent;
                    }

                    searchableText = searchableText.toLowerCase();
                    const matches = words.every(word => searchableText.includes(word));
                    item.style.display = (words.length === 0 || matches) ? '' : 'none';
                });

                updateVisibleCount();
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    applyFilters();
                });
            }

            if (sizeInput) {
                sizeInput.addEventListener('change', function() {
                    applySize(this.value);
                });
            }

            if (colorInput) {
                colorInput.addEventListener('input', function() {
                    applyColor(this.value);
                });
            }

            if (resetButton) {
                resetButton.addEventListener('click', function() {
                    if (searchInput) searchInput.value = '';
                    if (sizeInput) sizeInput.value = '24';
                    if (colorInput) colorInput.value = '#000000';

                    applySize(24);
                    applyColor('#000000');
                    applyFilters();
                });
            }

            applySize(sizeInput ? sizeInput.value : 24);
            applyColor(colorInput ? colorInput.value : '#000000');
            applyFilters();
            
            if (window.lucide) {
                window.lucide.createIcons();
            }
        });
    </script>
@endsection