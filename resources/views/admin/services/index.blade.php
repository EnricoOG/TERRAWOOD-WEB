@extends('layouts.app')

@section('content')

<style>
    /* =========================================================
       KELOLA LAYANAN - TERRAWOOD
       ========================================================= */

    .service-page,
    .service-page *,
    .service-page *::before,
    .service-page *::after {
        box-sizing: border-box;
    }

    .service-page {
        --navy: #082744;
        --navy-soft: #0d3558;
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
        animation: pageFadeIn .45s ease both;
    }

    @keyframes pageFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .service-page .icon {
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

    .service-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .service-eyebrow {
        display: inline-block;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--amber-dark);
    }

    .service-header h2 {
        color: var(--navy);
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.01em;
        margin: 0 0 6px;
    }

    .service-header p {
        color: var(--muted);
        font-size: 15px;
        margin: 0;
    }

    .service-btn-add {
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

    .service-btn-add:hover {
        background: var(--amber-dark);
        color: var(--navy);
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(245, 166, 35, .36);
    }

    .service-btn-add:active {
        transform: translateY(0);
    }

    /* ---------- ALERT ---------- */

    .service-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        font-weight: 500;
        transition: opacity .3s ease, transform .3s ease;
        animation: alertIn .35s ease both;
    }

    .service-alert span {
        flex: 1;
    }

    .service-alert.is-closing {
        opacity: 0;
        transform: translateY(-6px);
    }

    @keyframes alertIn {
        from { opacity: 0; transform: translateY(-8px); }
        to   { opacity: 1; transform: translateY(0); }
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

    .service-alert-close {
        background: transparent;
        border: none;
        color: inherit;
        opacity: .6;
        cursor: pointer;
        padding: 4px;
        border-radius: 6px;
        display: inline-flex;
        transition: opacity .2s ease, background .2s ease;
    }

    .service-alert-close:hover {
        opacity: 1;
        background: rgba(0, 0, 0, .06);
    }

    /* ---------- CARD ---------- */

    .service-card {
        background: #fff;
        border-radius: 16px;
        padding: 26px;
        border: 1px solid var(--line);
        box-shadow: 0 8px 28px rgba(8, 39, 68, .06);
        overflow: hidden;
    }

    .service-card-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 22px;
    }

    .service-card-title {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .service-card-title h3 {
        color: var(--navy);
        font-size: 19px;
        font-weight: 700;
        margin: 0;
    }

    .service-count {
        padding: 4px 11px;
        border-radius: 999px;
        background: var(--cream);
        color: var(--navy);
        font-size: 12px;
        font-weight: 700;
    }

    /* ---------- TOOLBAR ---------- */

    .service-toolbar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .service-search {
        position: relative;
    }

    .service-search .icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        width: 16px;
        height: 16px;
        color: var(--muted);
        pointer-events: none;
    }

    .service-input,
    .service-select {
        height: 40px;
        border: 1px solid #e2ded2;
        border-radius: 9px;
        background: #fff;
        color: var(--ink);
        font-size: 14px;
        font-family: inherit;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .service-input {
        width: 250px;
        padding: 0 14px 0 36px;
    }

    .service-select {
        padding: 0 12px;
        cursor: pointer;
    }

    .service-input:focus,
    .service-select:focus {
        outline: none;
        border-color: var(--amber);
        box-shadow: 0 0 0 3px rgba(245, 166, 35, .2);
    }

    /* ---------- TABLE ---------- */

    .service-table-wrap {
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .service-table {
        width: 100%;
        min-width: 780px;
        border-collapse: collapse;
    }

    .service-table th {
        background: var(--cream-deep);
        color: #5b6672;
        padding: 14px 16px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .06em;
        text-transform: uppercase;
        border-bottom: 1px solid var(--line);
        white-space: nowrap;
    }

    .service-table td {
        padding: 16px;
        border-bottom: 1px solid #f1eee6;
        font-size: 14px;
        vertical-align: middle;
        transition: background .2s ease;
    }

    .service-table tbody tr:last-child td {
        border-bottom: none;
    }

    .service-table tbody tr.service-row:hover td {
        background: #fcfbf7;
    }

    .service-row {
        animation: rowIn .45s ease both;
        animation-delay: calc(var(--i, 0) * 45ms);
    }

    @keyframes rowIn {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .service-no {
        color: var(--muted);
        font-weight: 600;
    }

    .service-thumb {
        width: 72px;
        height: 64px;
    }

    .service-image {
        display: block;
        width: 72px;
        height: 64px;
        object-fit: cover;
        border-radius: 10px;
        border: 1px solid var(--line);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .service-row:hover .service-image {
        transform: scale(1.05);
        box-shadow: 0 6px 16px rgba(8, 39, 68, .15);
    }

    .service-no-image {
        width: 72px;
        height: 64px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 3px;
        background: #f3f1ea;
        color: #9aa1a8;
        border-radius: 10px;
        border: 1px dashed #ddd8ca;
        font-size: 10px;
        font-weight: 600;
    }

    .service-no-image .icon {
        width: 18px;
        height: 18px;
    }

    .service-name {
        color: var(--navy);
        font-weight: 700;
        font-size: 15px;
    }

    .service-desc {
        color: #5f6b77;
        line-height: 1.55;
        max-width: 340px;
    }

    .service-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
    }

    .service-badge::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-active {
        background: var(--success-bg);
        color: var(--success-ink);
    }

    .badge-inactive {
        background: #eeeeee;
        color: #666;
    }

    /* ---------- ACTIONS ---------- */

    .service-actions {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .service-actions form {
        margin: 0;
    }

    .service-btn-edit,
    .service-btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 36px;
        padding: 0 13px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        font-family: inherit;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease, box-shadow .2s ease;
    }

    .service-btn-edit .icon,
    .service-btn-delete .icon {
        width: 15px;
        height: 15px;
    }

    .service-btn-edit {
        background: var(--info-bg);
        color: var(--info-ink);
        border: 1px solid #d4e2fa;
    }

    .service-btn-edit:hover {
        background: #d6e5ff;
        color: var(--info-ink);
        transform: translateY(-1px);
    }

    .service-btn-delete {
        background: var(--danger-bg);
        color: var(--danger-ink);
        border: 1px solid #f5d1ce;
    }

    .service-btn-delete:hover {
        background: #ffe1de;
        transform: translateY(-1px);
    }

    /* ---------- EMPTY STATE ---------- */

    .service-empty {
        text-align: center;
        padding: 56px 16px !important;
        color: var(--muted);
    }

    .service-empty-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 16px;
        border-radius: 50%;
        background: var(--cream);
        color: var(--amber-dark);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .service-empty-icon .icon {
        width: 28px;
        height: 28px;
    }

    .service-empty strong {
        display: block;
        color: var(--navy);
        font-size: 16px;
        margin-bottom: 4px;
    }

    .service-empty p {
        margin: 0 0 18px;
        font-size: 14px;
    }

    /* ---------- FOOTER / PAGINATION ---------- */

    .service-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 22px;
    }

    .service-footer-info {
        margin: 0;
        font-size: 13px;
        color: var(--muted);
    }

    .service-pagination svg {
        width: 18px;
        height: 18px;
    }

    .service-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .service-pagination .page-link {
        color: var(--navy);
    }

    .service-pagination .page-item.active .page-link {
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
        background: #fff;
        width: 100%;
        max-width: 430px;
        padding: 32px 30px 28px;
        border-radius: 18px;
        text-align: center;
        box-shadow: 0 24px 60px rgba(0, 0, 0, .25);
        transform: translateY(18px) scale(.97);
        transition: transform .25s ease;
    }

    .delete-modal.show .delete-modal-content {
        transform: translateY(0) scale(1);
    }

    .delete-modal-icon {
        width: 66px;
        height: 66px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: var(--danger-bg);
        color: var(--danger-ink);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .delete-modal-icon .icon {
        width: 30px;
        height: 30px;
    }

    .delete-modal-content h3 {
        color: var(--navy);
        font-size: 21px;
        font-weight: 800;
        margin: 0 0 10px;
    }

    .delete-modal-content p {
        color: #6d7782;
        font-size: 14px;
        line-height: 1.65;
        margin: 0 0 26px;
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
        font-size: 14px;
        font-weight: 600;
        font-family: inherit;
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

    body.service-modal-open {
        overflow: hidden;
    }

    /* ---------- FOCUS (AKSESIBILITAS) ---------- */

    .service-page a:focus-visible,
    .service-page button:focus-visible,
    .delete-modal button:focus-visible {
        outline: 3px solid rgba(245, 166, 35, .55);
        outline-offset: 2px;
    }

    /* ---------- RESPONSIF ---------- */

    @media (max-width: 900px) {
        .service-input {
            width: 200px;
        }
    }

    @media (max-width: 768px) {
        .service-page {
            padding: 22px 14px;
        }

        .service-card {
            padding: 16px;
        }

        .service-header h2 {
            font-size: 25px;
        }

        .service-btn-add {
            width: 100%;
            justify-content: center;
        }

        .service-toolbar,
        .service-search,
        .service-input,
        .service-select {
            width: 100%;
        }

        /* tabel berubah menjadi kartu di layar kecil */
        .service-table-wrap {
            border: none;
            overflow: visible;
        }

        .service-table,
        .service-table tbody,
        .service-table tr,
        .service-table td {
            display: block;
            width: 100%;
            min-width: 0;
        }

        .service-table thead {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
        }

        .service-table tr.service-row {
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 8px 14px;
            margin-bottom: 14px;
            background: #fff;
            box-shadow: 0 4px 14px rgba(8, 39, 68, .05);
        }

        .service-table td {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 10px 0;
            border-bottom: 1px dashed #eee9dc;
            text-align: right;
        }

        .service-table td:last-child {
            border-bottom: none;
        }

        .service-table td::before {
            content: attr(data-label);
            flex: 0 0 90px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .05em;
        }

        .service-table tbody tr.service-row:hover td {
            background: transparent;
        }

        .service-table td.service-empty {
            display: block;
            text-align: center;
            border-bottom: none;
        }

        .service-table td.service-empty::before {
            display: none;
        }

        .service-desc {
            max-width: none;
        }

        .service-footer {
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
        .service-page *,
        .service-page *::before,
        .service-page *::after,
        .delete-modal,
        .delete-modal-content {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="service-page">

    {{-- HEADER --}}
    <div class="service-header">
        <div>
            <span class="service-eyebrow">TERRAWOOD &middot; Panel Admin</span>
            <h2>Kelola Layanan</h2>
            <p>Kelola layanan furnitur dan dekorasi TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.services.create') }}" class="service-btn-add">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Layanan
        </a>
    </div>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="service-alert alert-success" role="status" data-alert="success">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                <polyline points="22 4 12 14.01 9 11.01"/>
            </svg>
            <span>{{ session('success') }}</span>
            <button type="button" class="service-alert-close" data-alert-close aria-label="Tutup notifikasi">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="service-alert alert-error" role="alert" data-alert="error">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ session('error') }}</span>
            <button type="button" class="service-alert-close" data-alert-close aria-label="Tutup notifikasi">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M18 6 6 18M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    {{-- DAFTAR LAYANAN --}}
    <div class="service-card">

        <div class="service-card-head">
            <div class="service-card-title">
                <h3>Daftar Layanan</h3>
                <span class="service-count">{{ $services->total() }} layanan</span>
            </div>

            @if($services->count())
                <div class="service-toolbar">
                    <div class="service-search">
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.35-4.35"/>
                        </svg>
                        <input
                            type="search"
                            id="serviceSearch"
                            class="service-input"
                            placeholder="Cari layanan di halaman ini..."
                            aria-label="Cari layanan"
                            autocomplete="off"
                        >
                    </div>

                    <select id="serviceStatus" class="service-select" aria-label="Filter status">
                        <option value="all">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Tidak Aktif</option>
                    </select>
                </div>
            @endif
        </div>

        <div class="service-table-wrap">

            <table class="service-table">

                <thead>
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th>Gambar</th>
                        <th>Nama Layanan</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($services as $service)

                        @php
                            $description = trim((string) $service->description);
                        @endphp

                        <tr
                            class="service-row"
                            style="--i: {{ $loop->index }};"
                            data-status="{{ $service->is_active ? 'active' : 'inactive' }}"
                            data-search="{{ \Illuminate\Support\Str::lower($service->name . ' ' . $description) }}"
                        >

                            <td data-label="No.">
                                <span class="service-no">{{ $services->firstItem() + $loop->index }}</span>
                            </td>

                            <td data-label="Gambar">
                                <div class="service-thumb">
                                    @if($service->image)
                                        <img
                                            src="{{ asset('storage/' . $service->image) }}"
                                            alt="{{ $service->name }}"
                                            class="service-image"
                                            width="72"
                                            height="64"
                                            loading="lazy"
                                            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                        >
                                        <div class="service-no-image" style="display: none;">
                                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                                <path d="M21 15l-5-5L5 21"/>
                                            </svg>
                                            No Image
                                        </div>
                                    @else
                                        <div class="service-no-image">
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

                            <td data-label="Nama">
                                <span class="service-name">{{ $service->name }}</span>
                            </td>

                            <td data-label="Deskripsi">
                                <span class="service-desc" @if($description) title="{{ $description }}" @endif>
                                    {{ $description !== '' ? \Illuminate\Support\Str::limit($description, 80) : '-' }}
                                </span>
                            </td>

                            <td data-label="Status">
                                @if($service->is_active)
                                    <span class="service-badge badge-active">Aktif</span>
                                @else
                                    <span class="service-badge badge-inactive">Tidak Aktif</span>
                                @endif
                            </td>

                            <td data-label="Aksi">
                                <div class="service-actions">

                                    <a
                                        href="{{ route('admin.services.edit', $service->id) }}"
                                        class="service-btn-edit"
                                    >
                                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/>
                                        </svg>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.services.destroy', $service->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            class="service-btn-delete"
                                            data-delete-trigger
                                            data-name="{{ $service->name }}"
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
                            <td colspan="6" class="service-empty">
                                <div class="service-empty-icon">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <polygon points="12 2 2 7 12 12 22 7 12 2"/>
                                        <polyline points="2 17 12 22 22 17"/>
                                        <polyline points="2 12 12 17 22 12"/>
                                    </svg>
                                </div>
                                <strong>Belum ada layanan.</strong>
                                <p>Mulai dengan menambahkan layanan pertama untuk TERRAWOOD.</p>
                                <a href="{{ route('admin.services.create') }}" class="service-btn-add">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 5v14M5 12h14"/>
                                    </svg>
                                    Tambah Layanan
                                </a>
                            </td>
                        </tr>

                    @endforelse

                    {{-- Muncul saat pencarian/filter tidak menemukan hasil --}}
                    <tr id="serviceNoResult" class="is-hidden">
                        <td colspan="6" class="service-empty">
                            <div class="service-empty-icon">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="11" cy="11" r="8"/>
                                    <path d="m21 21-4.35-4.35"/>
                                </svg>
                            </div>
                            <strong>Layanan tidak ditemukan.</strong>
                            <p>Coba gunakan kata kunci atau filter status yang lain.</p>
                        </td>
                    </tr>

                </tbody>

            </table>

        </div>

        <div class="service-footer">
            @if($services->total() > 0)
                <p class="service-footer-info">
                    Menampilkan {{ $services->firstItem() }}&ndash;{{ $services->lastItem() }}
                    dari {{ $services->total() }} layanan
                </p>
            @endif

            @if($services->hasPages())
                <div class="service-pagination">
                    {{ $services->links() }}
                </div>
            @endif
        </div>

    </div>

</div>

{{-- POPUP KONFIRMASI HAPUS --}}
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

        <h3 id="deleteModalTitle">Hapus Layanan?</h3>

        <p id="deleteModalDesc">
            Apakah kamu yakin ingin menghapus layanan
            <strong id="deleteServiceName"></strong>?
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

        /* ---------- PENCARIAN & FILTER STATUS (di halaman ini) ---------- */
        var searchInput  = document.getElementById('serviceSearch');
        var statusSelect = document.getElementById('serviceStatus');
        var noResultRow  = document.getElementById('serviceNoResult');
        var rows         = Array.prototype.slice.call(document.querySelectorAll('.service-row'));

        function applyFilter() {
            var keyword = searchInput.value.trim().toLowerCase();
            var status  = statusSelect.value;
            var visible = 0;

            rows.forEach(function (row) {
                var matchKeyword = !keyword || row.dataset.search.indexOf(keyword) !== -1;
                var matchStatus  = status === 'all' || row.dataset.status === status;
                var show = matchKeyword && matchStatus;

                row.classList.toggle('is-hidden', !show);
                if (show) visible++;
            });

            noResultRow.classList.toggle('is-hidden', visible !== 0);
        }

        if (searchInput && statusSelect && rows.length) {
            searchInput.addEventListener('input', applyFilter);
            statusSelect.addEventListener('change', applyFilter);
        }

        /* ---------- MODAL KONFIRMASI HAPUS ---------- */
        var modal      = document.getElementById('deleteModal');
        var nameEl     = document.getElementById('deleteServiceName');
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
            document.body.classList.add('service-modal-open');

            setTimeout(function () { cancelBtn.focus(); }, 60);
        }

        function closeDeleteModal() {
            modal.classList.remove('show');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('service-modal-open');

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