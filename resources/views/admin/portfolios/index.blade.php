@extends('layouts.app')

@section('content')

@php
    // Daftar kategori yang ada di halaman ini, dipakai untuk filter
    $categories = $portfolios->getCollection()
        ->pluck('category')
        ->map(fn ($c) => trim((string) $c))
        ->filter()
        ->unique(fn ($c) => \Illuminate\Support\Str::lower($c))
        ->sort()
        ->values();
@endphp

<style>
    /* =========================================================
       KELOLA PORTOFOLIO - TERRAWOOD
       ========================================================= */

    .pf-page,
    .pf-page *,
    .pf-page *::before,
    .pf-page *::after {
        box-sizing: border-box;
    }

    .pf-page {
        --navy: #082744;
        --amber: #f5a623;
        --amber-dark: #e69a19;
        --cream: #f7f5ef;
        --cream-deep: #faf8f2;
        --ink: #293747;
        --muted: #7a8591;
        --line: #ece9e0;
        --success-bg: #e3f7eb;
        --success-ink: #20834a;
        --danger-bg: #fff0ef;
        --danger-ink: #c0392b;
        --info-bg: #e6efff;
        --info-ink: #2455a5;

        padding: 36px;
        min-height: 80vh;
        background: var(--cream);
        color: var(--ink);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, Roboto, "Helvetica Neue", Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        animation: pfFadeIn .45s ease both;
    }

    @keyframes pfFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .pf-page .icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .is-hidden {
        display: none !important;
    }

    /* ---------- HEADER ---------- */

    .pf-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .pf-eyebrow {
        display: inline-block;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--amber-dark);
    }

    .pf-header h2 {
        margin: 0 0 6px;
        color: var(--navy);
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.01em;
    }

    .pf-header p {
        margin: 0;
        color: var(--muted);
        font-size: 15px;
    }

    .pf-btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 22px;
        border-radius: 10px;
        background: var(--amber);
        color: var(--navy);
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        box-shadow: 0 6px 16px rgba(245, 166, 35, .28);
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .pf-btn-add:hover {
        background: var(--amber-dark);
        color: var(--navy);
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(245, 166, 35, .36);
    }

    /* ---------- ALERT ---------- */

    .pf-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 500;
        transition: opacity .3s ease, transform .3s ease;
        animation: pfFadeIn .35s ease both;
    }

    .pf-alert span {
        flex: 1;
    }

    .pf-alert.is-closing {
        opacity: 0;
        transform: translateY(-6px);
    }

    .alert-success {
        background: var(--success-bg);
        color: var(--success-ink);
        border: 1px solid #c7ecd6;
    }

    .alert-error {
        background: var(--danger-bg);
        color: var(--danger-ink);
        border: 1px solid #f5d1ce;
    }

    .pf-alert-close {
        display: inline-flex;
        padding: 4px;
        border: none;
        border-radius: 6px;
        background: transparent;
        color: inherit;
        opacity: .6;
        cursor: pointer;
        transition: opacity .2s ease, background .2s ease;
    }

    .pf-alert-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, .06);
    }

    /* ---------- CARD ---------- */

    .pf-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 26px;
        box-shadow: 0 8px 28px rgba(8, 39, 68, .06);
        overflow: hidden;
    }

    .pf-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 22px;
    }

    .pf-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .pf-card-title h3 {
        margin: 0;
        color: var(--navy);
        font-size: 19px;
        font-weight: 700;
    }

    .pf-count {
        padding: 4px 11px;
        border-radius: 999px;
        background: var(--cream);
        color: var(--navy);
        font-size: 12px;
        font-weight: 700;
    }

    /* ---------- TOOLBAR ---------- */

    .pf-toolbar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pf-search {
        position: relative;
    }

    .pf-search .icon {
        position: absolute;
        left: 12px;
        top: 50%;
        width: 16px;
        height: 16px;
        color: var(--muted);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .pf-input,
    .pf-select {
        height: 40px;
        border: 1px solid #e2ded2;
        border-radius: 9px;
        background: #fff;
        color: var(--ink);
        font-family: inherit;
        font-size: 14px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .pf-input {
        width: 240px;
        padding: 0 14px 0 36px;
    }

    .pf-select {
        padding: 0 12px;
        cursor: pointer;
    }

    .pf-input:focus,
    .pf-select:focus {
        outline: none;
        border-color: var(--amber);
        box-shadow: 0 0 0 3px rgba(245, 166, 35, .2);
    }

    /* ---------- TABEL ---------- */

    .pf-table-wrap {
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .pf-table {
        width: 100%;
        min-width: 900px;
        border-collapse: collapse;
    }

    .pf-table th {
        padding: 14px 16px;
        border-bottom: 1px solid var(--line);
        background: var(--cream-deep);
        color: #5b6672;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .pf-table td {
        padding: 16px;
        border-bottom: 1px solid #f1eee6;
        font-size: 14px;
        vertical-align: middle;
        transition: background .2s ease;
    }

    .pf-table tbody tr:last-child td {
        border-bottom: none;
    }

    .pf-table tbody tr.pf-row:hover td {
        background: #fcfbf7;
    }

    .pf-row {
        animation: pfRowIn .45s ease both;
        animation-delay: calc(var(--i, 0) * 45ms);
    }

    @keyframes pfRowIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .pf-no {
        color: var(--muted);
        font-weight: 600;
    }

    .pf-thumb {
        width: 72px;
        height: 64px;
    }

    .pf-image {
        display: block;
        width: 72px;
        height: 64px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--line);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .pf-row:hover .pf-image {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(8, 39, 68, .15);
    }

    .pf-no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        width: 72px;
        height: 64px;
        border: 1px dashed #ddd8ca;
        border-radius: 10px;
        background: #f3f1ea;
        color: #9aa1a8;
        font-size: 10px;
        font-weight: 600;
    }

    .pf-no-image .icon {
        width: 18px;
        height: 18px;
    }

    .pf-title {
        color: var(--navy);
        font-weight: 700;
        font-size: 15px;
    }

    .pf-muted {
        color: #5f6b77;
    }

    .pf-chip {
        display: inline-block;
        padding: 5px 11px;
        border-radius: 999px;
        background: var(--cream);
        color: var(--navy);
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .pf-date {
        color: #5f6b77;
        white-space: nowrap;
    }

    .pf-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pf-badge .icon {
        width: 13px;
        height: 13px;
        fill: currentColor;
    }

    .pf-badge-featured {
        background: #fff2d6;
        color: #a96a00;
    }

    .pf-badge-regular {
        background: #edf0f3;
        color: #64748b;
    }

    .pf-badge-regular::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ---------- AKSI ---------- */

    .pf-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .pf-actions form {
        margin: 0;
    }

    .pf-btn-edit,
    .pf-btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 13px;
        border-radius: 8px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease;
    }

    .pf-btn-edit .icon,
    .pf-btn-delete .icon {
        width: 15px;
        height: 15px;
    }

    .pf-btn-edit {
        background: var(--info-bg);
        color: var(--info-ink);
        border: 1px solid #d4e2fa;
    }

    .pf-btn-edit:hover {
        background: #d6e5ff;
        color: var(--info-ink);
        transform: translateY(-1px);
    }

    .pf-btn-delete {
        background: var(--danger-bg);
        color: var(--danger-ink);
        border: 1px solid #f5d1ce;
    }

    .pf-btn-delete:hover {
        background: #ffe1de;
        transform: translateY(-1px);
    }

    /* ---------- EMPTY STATE ---------- */

    .pf-empty {
        padding: 56px 16px !important;
        text-align: center;
        color: var(--muted);
    }

    .pf-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: var(--cream);
        color: var(--amber-dark);
    }

    .pf-empty-icon .icon {
        width: 28px;
        height: 28px;
    }

    .pf-empty strong {
        display: block;
        margin-bottom: 4px;
        color: var(--navy);
        font-size: 16px;
    }

    .pf-empty p {
        margin: 0 0 18px;
        font-size: 14px;
    }

    /* ---------- FOOTER / PAGINATION ---------- */

    .pf-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 22px;
    }

    .pf-footer-info {
        margin: 0;
        color: var(--muted);
        font-size: 13px;
    }

    .pf-pagination svg {
        width: 18px;
        height: 18px;
    }

    .pf-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .pf-pagination .page-link {
        color: var(--navy);
    }

    .pf-pagination .page-item.active .page-link {
        background: var(--navy);
        border-color: var(--navy);
        color: #fff;
    }

    /* ---------- MODAL HAPUS ---------- */

    .delete-modal {
        position: fixed;
        inset: 0;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(6, 29, 51, .6);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        opacity: 0;
        visibility: hidden;
        transition: opacity .25s ease, visibility .25s ease;
    }

    .delete-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .delete-modal-content {
        width: 100%;
        max-width: 430px;
        padding: 32px 30px 28px;
        border-radius: 18px;
        background: #fff;
        text-align: center;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
        transform: translateY(18px) scale(.97);
        transition: transform .25s ease;
    }

    .delete-modal.show .delete-modal-content {
        transform: translateY(0) scale(1);
    }

    .delete-modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 66px;
        height: 66px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: var(--danger-bg);
        color: var(--danger-ink);
    }

    .delete-modal-icon .icon {
        width: 30px;
        height: 30px;
    }

    .delete-modal-content h3 {
        margin: 0 0 10px;
        color: var(--navy);
        font-size: 21px;
        font-weight: 800;
    }

    .delete-modal-content p {
        margin: 0 0 26px;
        color: #6d7782;
        font-size: 14px;
        line-height: 1.65;
    }

    .delete-modal-content p strong {
        color: var(--navy);
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .delete-cancel,
    .delete-confirm {
        min-width: 120px;
        height: 44px;
        padding: 0 22px;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease, transform .2s ease, opacity .2s ease;
    }

    .delete-cancel {
        background: #eef0f2;
        color: var(--ink);
    }

    .delete-cancel:hover {
        background: #dfe3e8;
    }

    .delete-confirm {
        background: var(--danger-ink);
        color: #fff;
    }

    .delete-confirm:hover {
        background: #a93226;
        transform: translateY(-1px);
    }

    .delete-confirm:disabled,
    .delete-cancel:disabled {
        opacity: .65;
        cursor: not-allowed;
        transform: none;
    }

    body.pf-modal-open {
        overflow: hidden;
    }

    .pf-page a:focus-visible,
    .pf-page button:focus-visible,
    .delete-modal button:focus-visible {
        outline: 3px solid rgba(245, 166, 35, .55);
        outline-offset: 2px;
    }

    /* ---------- RESPONSIF ---------- */

    @media (max-width: 900px) {
        .pf-input {
            width: 200px;
        }
    }

    @media (max-width: 768px) {
        .pf-page {
            padding: 22px 14px;
        }

        .pf-card {
            padding: 16px;
        }

        .pf-header h2 {
            font-size: 25px;
        }

        .pf-btn-add {
            width: 100%;
            justify-content: center;
        }

        .pf-toolbar,
        .pf-search,
        .pf-input,
        .pf-select {
            width: 100%;
        }

        /* tabel berubah menjadi kartu di layar kecil */
        .pf-table-wrap {
            border: none;
            overflow: visible;
        }

        .pf-table,
        .pf-table tbody,
        .pf-table tr,
        .pf-table td {
            display: block;
            width: 100%;
            min-width: 0;
        }

        .pf-table thead {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
        }

        .pf-table tr.pf-row {
            margin-bottom: 14px;
            padding: 8px 14px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(8, 39, 68, .05);
        }

        .pf-table td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 10px 0;
            border-bottom: 1px dashed #eee9dc;
            text-align: right;
        }

        .pf-table td:last-child {
            border-bottom: none;
        }

        .pf-table td::before {
            content: attr(data-label);
            flex: 0 0 90px;
            color: var(--muted);
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .05em;
            text-transform: uppercase;
        }

        .pf-table tbody tr.pf-row:hover td {
            background: transparent;
        }

        .pf-table td.pf-empty {
            display: block;
            text-align: center;
            border-bottom: none;
        }

        .pf-table td.pf-empty::before {
            display: none;
        }

        .pf-footer {
            flex-direction: column;
            align-items: flex-start;
        }

        .delete-modal-content {
            padding: 26px 18px 22px;
        }

        .delete-modal-actions {
            flex-direction: column-reverse;
        }

        .delete-cancel,
        .delete-confirm {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .pf-page *,
        .pf-page *::before,
        .pf-page *::after,
        .delete-modal,
        .delete-modal-content {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="pf-page">

    {{-- HEADER --}}
    <div class="pf-header">
        <div>
            <span class="pf-eyebrow">TERRAWOOD &middot; Panel Admin</span>
            <h2>Kelola Portofolio</h2>
            <p>Kelola dokumentasi proyek dan hasil pekerjaan TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.portfolios.create') }}" class="pf-btn-add">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Portofolio
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="pf-alert alert-success" role="status" data-alert="success">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('success') }}</span>
            <button type="button" class="pf-alert-close" data-alert-close aria-label="Tutup notifikasi">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="pf-alert alert-error" role="alert" data-alert="error">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
            <button type="button" class="pf-alert-close" data-alert-close aria-label="Tutup notifikasi">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- DAFTAR PORTOFOLIO --}}
    <div class="pf-card">

        <div class="pf-card-head">
            <div class="pf-card-title">
                <h3>Daftar Portofolio</h3>
                <span class="pf-count">{{ $portfolios->total() }} proyek</span>
            </div>

            @if($portfolios->count())
                <div class="pf-toolbar">
                    <div class="pf-search">
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input
                            type="search"
                            id="pfSearch"
                            class="pf-input"
                            placeholder="Cari proyek di halaman ini..."
                            aria-label="Cari proyek"
                            autocomplete="off"
                        >
                    </div>

                    @if($categories->count())
                        <select id="pfCategory" class="pf-select" aria-label="Filter kategori">
                            <option value="all">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ \Illuminate\Support\Str::lower($category) }}">{{ $category }}</option>
                            @endforeach
                        </select>
                    @endif

                    <select id="pfStatus" class="pf-select" aria-label="Filter status">
                        <option value="all">Semua Status</option>
                        <option value="featured">Unggulan</option>
                        <option value="regular">Reguler</option>
                    </select>
                </div>
            @endif
        </div>

        <div class="pf-table-wrap">

            <table class="pf-table">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Gambar</th>
                        <th>Nama Proyek</th>
                        <th>Klien</th>
                        <th>Kategori</th>
                        <th>Tanggal Proyek</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($portfolios as $portfolio)

                        <tr
                            class="pf-row"
                            style="--i: {{ $loop->index }};"
                            data-status="{{ $portfolio->is_featured ? 'featured' : 'regular' }}"
                            data-category="{{ \Illuminate\Support\Str::lower(trim((string) $portfolio->category)) }}"
                            data-search="{{ \Illuminate\Support\Str::lower($portfolio->title . ' ' . $portfolio->client_name . ' ' . $portfolio->category) }}"
                        >

                            <td data-label="No.">
                                <span class="pf-no">{{ $portfolios->firstItem() + $loop->index }}</span>
                            </td>

                            <td data-label="Gambar">
                                <div class="pf-thumb">
                                    @if($portfolio->image)
                                        <img
                                            src="{{ asset('storage/' . $portfolio->image) }}"
                                            alt="{{ $portfolio->title }}"
                                            class="pf-image"
                                            width="72"
                                            height="64"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >
                                        <div class="pf-no-image" style="display: none;">
                                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="M21 15l-5-5L5 21"/>
                                            </svg>
                                            No Image
                                        </div>
                                    @else
                                        <div class="pf-no-image">
                                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="M21 15l-5-5L5 21"/>
                                            </svg>
                                            No Image
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td data-label="Proyek">
                                <span class="pf-title">{{ $portfolio->title }}</span>
                            </td>

                            <td data-label="Klien">
                                <span class="pf-muted">{{ $portfolio->client_name ?: '-' }}</span>
                            </td>

                            <td data-label="Kategori">
                                @if($portfolio->category)
                                    <span class="pf-chip">{{ $portfolio->category }}</span>
                                @else
                                    <span class="pf-muted">-</span>
                                @endif
                            </td>

                            <td data-label="Tanggal">
                                <span class="pf-date">
                                    {{ $portfolio->project_date ? $portfolio->project_date->format('d/m/Y') : '-' }}
                                </span>
                            </td>

                            <td data-label="Status">
                                @if($portfolio->is_featured)
                                    <span class="pf-badge pf-badge-featured">
                                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                        </svg>
                                        Unggulan
                                    </span>
                                @else
                                    <span class="pf-badge pf-badge-regular">Reguler</span>
                                @endif
                            </td>

                            <td data-label="Aksi">
                                <div class="pf-actions">

                                    <a
                                        href="{{ route('admin.portfolios.edit', $portfolio->id) }}"
                                        class="pf-btn-edit"
                                    >
                                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.portfolios.destroy', $portfolio->id) }}"
                                        method="POST"
                                        class="delete-form"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            class="pf-btn-delete"
                                            data-delete-trigger
                                            data-name="{{ $portfolio->title }}"
                                        >
                                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <polyline points="3 6 5 6 21 6"/>
                                                <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                                <path d="M10 11v6M14 11v6"/>
                                                <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="8" class="pf-empty">
                                <div class="pf-empty-icon">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                </div>
                                <strong>Belum ada portofolio.</strong>
                                <p>Tambahkan dokumentasi proyek TERRAWOOD yang pertama.</p>
                                <a href="{{ route('admin.portfolios.create') }}" class="pf-btn-add">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                    Tambah Portofolio
                                </a>
                            </td>
                        </tr>

                    @endforelse

                    {{-- Muncul saat pencarian/filter tidak menemukan hasil --}}
                    <tr id="pfNoResult" class="is-hidden">
                        <td colspan="8" class="pf-empty">
                            <div class="pf-empty-icon">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.35-4.35"/>
                                </svg>
                            </div>
                            <strong>Proyek tidak ditemukan.</strong>
                            <p>Coba gunakan kata kunci atau filter yang lain.</p>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div class="pf-footer">
            @if($portfolios->total() > 0)
                <p class="pf-footer-info">
                    Menampilkan {{ $portfolios->firstItem() }}&ndash;{{ $portfolios->lastItem() }}
                    dari {{ $portfolios->total() }} proyek
                </p>
            @endif

            @if($portfolios->hasPages())
                <div class="pf-pagination">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>

    </div>

</div>

{{-- MODAL KONFIRMASI HAPUS --}}
<div
    class="delete-modal"
    id="deleteModal"
    role="dialog"
    aria-modal="true"
    aria-labelledby="deleteModalTitle"
    aria-describedby="deleteModalDesc"
    aria-hidden="true"
>
    <div class="delete-modal-content">

        <div class="delete-modal-icon">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                <line x1="12" y1="9" x2="12" y2="13"/>
                <line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>

        <h3 id="deleteModalTitle">Hapus Portofolio?</h3>

        <p id="deleteModalDesc">
            Apakah kamu yakin ingin menghapus portofolio
            <strong id="deletePortfolioName"></strong>?
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="delete-modal-actions">
            <button type="button" class="delete-cancel" id="deleteCancelBtn">
                Batal
            </button>

            <button type="button" class="delete-confirm" id="deleteConfirmBtn">
                Ya, Hapus
            </button>
        </div>

    </div>
</div>

<script>
    (function () {
        'use strict';

        /* ---------- NOTIFIKASI: tutup manual & hilang otomatis ---------- */
        document.querySelectorAll('[data-alert]').forEach(function (alertEl) {
            function closeAlert() {
                alertEl.classList.add('is-closing');
                setTimeout(function () { alertEl.remove(); }, 300);
            }

            var closeBtn = alertEl.querySelector('[data-alert-close]');
            if (closeBtn) closeBtn.addEventListener('click', closeAlert);

            if (alertEl.dataset.alert === 'success') {
                setTimeout(closeAlert, 6000);
            }
        });

        /* ---------- PENCARIAN & FILTER (di halaman ini) ---------- */
        var searchInput    = document.getElementById('pfSearch');
        var categorySelect = document.getElementById('pfCategory');
        var statusSelect   = document.getElementById('pfStatus');
        var noResultRow    = document.getElementById('pfNoResult');
        var rows           = Array.prototype.slice.call(document.querySelectorAll('.pf-row'));

        function applyFilter() {
            var keyword  = searchInput.value.trim().toLowerCase();
            var category = categorySelect ? categorySelect.value : 'all';
            var status   = statusSelect.value;
            var visible  = 0;

            rows.forEach(function (row) {
                var matchKeyword  = !keyword || row.dataset.search.indexOf(keyword) !== -1;
                var matchCategory = category === 'all' || row.dataset.category === category;
                var matchStatus   = status === 'all' || row.dataset.status === status;
                var show = matchKeyword && matchCategory && matchStatus;

                row.classList.toggle('is-hidden', !show);
                if (show) visible++;
            });

            noResultRow.classList.toggle('is-hidden', visible !== 0);
        }

        if (searchInput && statusSelect && rows.length) {
            searchInput.addEventListener('input', applyFilter);
            statusSelect.addEventListener('change', applyFilter);
            if (categorySelect) categorySelect.addEventListener('change', applyFilter);
        }

        /* ---------- MODAL KONFIRMASI HAPUS ---------- */
        var modal      = document.getElementById('deleteModal');
        var nameEl     = document.getElementById('deletePortfolioName');
        var cancelBtn  = document.getElementById('deleteCancelBtn');
        var confirmBtn = document.getElementById('deleteConfirmBtn');

        var targetForm = null;
        var lastFocus  = null;

        function openDeleteModal(trigger) {
            targetForm = trigger.closest('form');
            lastFocus  = trigger;

            nameEl.textContent = trigger.dataset.name || '';

            modal.classList.add('show');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('pf-modal-open');

            setTimeout(function () { cancelBtn.focus(); }, 60);
        }

        function closeDeleteModal() {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('pf-modal-open');

            targetForm = null;

            if (lastFocus) {
                lastFocus.focus();
                lastFocus = null;
            }
        }

        function resetConfirmState() {
            confirmBtn.disabled = false;
            cancelBtn.disabled  = false;
            confirmBtn.textContent = 'Ya, Hapus';
        }

        function confirmDelete() {
            if (!targetForm) return;

            confirmBtn.disabled = true;
            cancelBtn.disabled  = true;
            confirmBtn.textContent = 'Menghapus...';

            targetForm.submit();
        }

        document.querySelectorAll('[data-delete-trigger]').forEach(function (btn) {
            btn.addEventListener('click', function () { openDeleteModal(btn); });
        });

        cancelBtn.addEventListener('click', closeDeleteModal);
        confirmBtn.addEventListener('click', confirmDelete);

        // klik area gelap di luar kotak untuk menutup
        modal.addEventListener('click', function (event) {
            if (event.target === modal) closeDeleteModal();
        });

        document.addEventListener('keydown', function (event) {
            if (!modal.classList.contains('show')) return;

            if (event.key === 'Escape') {
                closeDeleteModal();
                return;
            }

            // fokus tetap berada di dalam modal
            if (event.key === 'Tab') {
                var focusables = [cancelBtn, confirmBtn].filter(function (el) { return !el.disabled; });
                if (!focusables.length) return;

                var first = focusables[0];
                var last  = focusables[focusables.length - 1];

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }
        });

        // jika pengguna menekan tombol "kembali" di browser
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                resetConfirmState();
                closeDeleteModal();
            }
        });
    })();
</script>

@endsection