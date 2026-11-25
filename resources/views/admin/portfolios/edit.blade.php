@extends('layouts.app')

@section('content')

@php
    // Saat validasi gagal, ikuti pilihan terakhir pengguna. Jika form baru dibuka, pakai data dari database.
    $isFeatured   = !empty(old()) ? (bool) old('is_featured') : (bool) $portfolio->is_featured;
    $hasImage     = !empty($portfolio->image);
    $currentImage = $hasImage ? asset('storage/' . $portfolio->image) : '';
@endphp

<style>
    /* =========================================================
       FORM PORTOFOLIO - TERRAWOOD
       ========================================================= */

    .sf-page,
    .sf-page *,
    .sf-page *::before,
    .sf-page *::after {
        box-sizing: border-box;
    }

    .sf-page {
        --navy: #082744;
        --amber: #f5a623;
        --amber-dark: #e69a19;
        --cream: #f7f5ef;
        --cream-deep: #faf8f2;
        --ink: #293747;
        --muted: #7a8591;
        --line: #ece9e0;
        --success-ink: #20834a;
        --danger-bg: #fff0ef;
        --danger-ink: #c0392b;

        padding: 36px;
        min-height: 80vh;
        background: var(--cream);
        color: var(--ink);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Inter, Roboto, "Helvetica Neue", Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        animation: sfFadeIn .45s ease both;
    }

    @keyframes sfFadeIn {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .sf-page .icon {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .sf-page .is-hidden {
        display: none !important;
    }

    .sf-wrap {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* ---------- HEADER ---------- */

    .sf-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 16px;
        color: var(--muted);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: color .2s ease, transform .2s ease;
    }

    .sf-back .icon {
        width: 16px;
        height: 16px;
    }

    .sf-back:hover {
        color: var(--navy);
        transform: translateX(-3px);
    }

    .sf-header {
        margin-bottom: 26px;
    }

    .sf-eyebrow {
        display: inline-block;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: var(--amber-dark);
    }

    .sf-header h2 {
        margin: 0 0 6px;
        color: var(--navy);
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -.01em;
    }

    .sf-header p {
        margin: 0;
        color: var(--muted);
        font-size: 15px;
    }

    /* ---------- ALERT ERROR ---------- */

    .sf-alert {
        display: flex;
        gap: 12px;
        padding: 16px 18px;
        margin-bottom: 22px;
        border-radius: 12px;
        background: var(--danger-bg);
        border: 1px solid #f5d1ce;
        color: var(--danger-ink);
        font-size: 14px;
        animation: sfFadeIn .35s ease both;
    }

    .sf-alert strong {
        display: block;
        margin-bottom: 4px;
    }

    .sf-alert ul {
        margin: 0;
        padding-left: 18px;
    }

    /* ---------- GRID & CARD ---------- */

    .sf-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 340px;
        gap: 24px;
        align-items: start;
    }

    .sf-card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 26px;
        box-shadow: 0 8px 28px rgba(8, 39, 68, .06);
    }

    .sf-side > .sf-card + .sf-card {
        margin-top: 24px;
    }

    .sf-card-title {
        margin: 0 0 4px;
        color: var(--navy);
        font-size: 17px;
        font-weight: 700;
    }

    .sf-card-sub {
        margin: 0 0 22px;
        color: var(--muted);
        font-size: 13px;
    }

    /* ---------- FIELD ---------- */

    .sf-field {
        margin-bottom: 22px;
    }

    .sf-field:last-child {
        margin-bottom: 0;
    }

    .sf-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .sf-row .sf-field {
        min-width: 0;
    }

    .sf-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
        color: var(--navy);
        font-size: 14px;
        font-weight: 700;
    }

    .sf-req {
        color: var(--danger-ink);
    }

    .sf-optional {
        margin-left: 4px;
        color: var(--muted);
        font-size: 12px;
        font-weight: 500;
    }

    .sf-counter {
        color: var(--muted);
        font-size: 12px;
        font-weight: 500;
    }

    .sf-input,
    .sf-textarea {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e2ded2;
        border-radius: 10px;
        background: #fff;
        color: var(--ink);
        font-family: inherit;
        font-size: 14px;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .sf-input[type="date"] {
        min-height: 46px;
    }

    .sf-textarea {
        min-height: 150px;
        line-height: 1.6;
        resize: vertical;
    }

    .sf-input::placeholder,
    .sf-textarea::placeholder {
        color: #a9afb5;
    }

    .sf-input:focus,
    .sf-textarea:focus {
        outline: none;
        border-color: var(--amber);
        box-shadow: 0 0 0 3px rgba(245, 166, 35, .2);
    }

    .sf-input.is-invalid,
    .sf-textarea.is-invalid {
        border-color: var(--danger-ink);
        background: #fffafa;
    }

    .sf-input.is-invalid:focus,
    .sf-textarea.is-invalid:focus {
        box-shadow: 0 0 0 3px rgba(192, 57, 43, .15);
    }

    .sf-error {
        display: flex;
        align-items: center;
        gap: 6px;
        margin: 8px 0 0;
        color: var(--danger-ink);
        font-size: 13px;
    }

    .sf-error .icon {
        width: 15px;
        height: 15px;
    }

    .sf-note {
        margin: 10px 0 0;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
    }

    /* ---------- CHIP KATEGORI ---------- */

    .sf-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
    }

    .sf-chip {
        padding: 6px 13px;
        border: 1px solid #e2ded2;
        border-radius: 999px;
        background: var(--cream-deep);
        color: var(--ink);
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
    }

    .sf-chip:hover {
        border-color: var(--amber);
        background: #fff8ea;
    }

    .sf-chip.is-active {
        border-color: var(--navy);
        background: var(--navy);
        color: #fff;
    }

    /* ---------- UPLOAD GAMBAR ---------- */

    .sf-file-input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
        overflow: hidden;
    }

    .sf-drop {
        display: block;
        padding: 14px;
        border: 2px dashed #ddd8ca;
        border-radius: 14px;
        background: var(--cream-deep);
        text-align: center;
        cursor: pointer;
        transition: border-color .2s ease, background .2s ease;
    }

    .sf-drop:hover,
    .sf-drop.is-dragover {
        border-color: var(--amber);
        background: #fff8ea;
    }

    .sf-drop.is-invalid {
        border-color: var(--danger-ink);
    }

    .sf-file-input:focus-visible + .sf-drop {
        outline: 3px solid rgba(245, 166, 35, .55);
        outline-offset: 2px;
    }

    .sf-preview {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        aspect-ratio: 4 / 3;
        margin-bottom: 12px;
        border-radius: 10px;
        background: #f1eee6;
        overflow: hidden;
    }

    .sf-preview img {
        display: block;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .sf-preview-empty {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        color: #a2a8ae;
        font-size: 12px;
        font-weight: 600;
    }

    .sf-preview-empty .icon {
        width: 34px;
        height: 34px;
    }

    .sf-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        padding: 4px 10px;
        border-radius: 999px;
        background: rgba(8, 39, 68, .82);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
    }

    .sf-drop-text strong {
        display: block;
        color: var(--navy);
        font-size: 14px;
    }

    .sf-drop-text span {
        display: block;
        margin-top: 3px;
        color: var(--muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .sf-remove {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 7px 12px;
        border: 1px solid #f5d1ce;
        border-radius: 8px;
        background: var(--danger-bg);
        color: var(--danger-ink);
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease;
    }

    .sf-remove:hover {
        background: #ffe1de;
    }

    .sf-remove .icon {
        width: 14px;
        height: 14px;
    }

    /* ---------- SWITCH ---------- */

    .sf-switch {
        position: relative;
        display: flex;
        align-items: center;
        gap: 14px;
        cursor: pointer;
    }

    .sf-switch input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .sf-switch-track {
        position: relative;
        flex-shrink: 0;
        width: 48px;
        height: 28px;
        border-radius: 999px;
        background: #d5d9de;
        transition: background .25s ease;
    }

    .sf-switch-track::after {
        content: "";
        position: absolute;
        top: 3px;
        left: 3px;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        background: #fff;
        box-shadow: 0 2px 5px rgba(0, 0, 0, .22);
        transition: transform .25s ease;
    }

    .sf-switch input:checked + .sf-switch-track {
        background: var(--amber-dark);
    }

    .sf-switch input:checked + .sf-switch-track::after {
        transform: translateX(20px);
    }

    .sf-switch input:focus-visible + .sf-switch-track {
        outline: 3px solid rgba(245, 166, 35, .55);
        outline-offset: 2px;
    }

    .sf-switch-text strong {
        display: block;
        color: var(--navy);
        font-size: 14px;
    }

    .sf-switch-text small {
        color: var(--muted);
        font-size: 12px;
    }

    /* ---------- TOMBOL ---------- */

    .sf-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 24px;
    }

    .sf-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 46px;
        padding: 0 26px;
        border: none;
        border-radius: 10px;
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
    }

    .sf-btn-primary {
        background: var(--amber);
        color: var(--navy);
        box-shadow: 0 6px 16px rgba(245, 166, 35, .28);
    }

    .sf-btn-primary:hover {
        background: var(--amber-dark);
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(245, 166, 35, .36);
    }

    .sf-btn-primary:disabled {
        opacity: .75;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .sf-btn-secondary {
        background: #fff;
        color: var(--ink);
        border: 1px solid #e2ded2;
    }

    .sf-btn-secondary:hover {
        background: #f3f1ea;
    }

    .sf-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(8, 39, 68, .25);
        border-top-color: var(--navy);
        border-radius: 50%;
        animation: sfSpin .7s linear infinite;
    }

    @keyframes sfSpin {
        to { transform: rotate(360deg); }
    }

    .sf-page a:focus-visible,
    .sf-page button:focus-visible {
        outline: 3px solid rgba(245, 166, 35, .55);
        outline-offset: 2px;
    }

    /* ---------- RESPONSIF ---------- */

    @media (max-width: 900px) {
        .sf-grid {
            grid-template-columns: minmax(0, 1fr);
        }
    }

    @media (max-width: 600px) {
        .sf-page {
            padding: 22px 14px;
        }

        .sf-card {
            padding: 18px;
        }

        .sf-row {
            grid-template-columns: minmax(0, 1fr);
            gap: 0;
        }

        .sf-header h2 {
            font-size: 25px;
        }

        .sf-actions {
            flex-direction: column-reverse;
        }

        .sf-btn {
            width: 100%;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .sf-page,
        .sf-page *,
        .sf-page *::before,
        .sf-page *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="sf-page">
    <div class="sf-wrap">

        <a href="{{ route('admin.portfolios.index') }}" class="sf-back">
            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Kembali ke daftar portofolio
        </a>

        <div class="sf-header">
            <span class="sf-eyebrow">TERRAWOOD &middot; Panel Admin</span>
            <h2>Edit Portofolio</h2>
            <p>Perbarui informasi dokumentasi proyek TERRAWOOD.</p>
        </div>

        @if($errors->any())
            <div class="sf-alert" role="alert">
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <div>
                    <strong>Perubahan belum bisa disimpan.</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form
            id="portfolioForm"
            action="{{ route('admin.portfolios.update', $portfolio->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="sf-grid">

                {{-- KOLOM KIRI: INFORMASI PROYEK --}}
                <div class="sf-card">
                    <h3 class="sf-card-title">Informasi Proyek</h3>
                    <p class="sf-card-sub">Detail proyek yang akan ditampilkan sebagai dokumentasi pekerjaan.</p>

                    <div class="sf-field">
                        <label class="sf-label" for="title">
                            <span>Nama Proyek <span class="sf-req">*</span></span>
                        </label>

                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="sf-input @error('title') is-invalid @enderror"
                            value="{{ old('title', $portfolio->title) }}"
                            autocomplete="off"
                            required
                        >

                        @error('title')
                            <p class="sf-error">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="sf-row">
                        <div class="sf-field">
                            <label class="sf-label" for="client_name">
                                <span>Nama Klien <span class="sf-optional">(opsional)</span></span>
                            </label>

                            <input
                                type="text"
                                id="client_name"
                                name="client_name"
                                class="sf-input @error('client_name') is-invalid @enderror"
                                value="{{ old('client_name', $portfolio->client_name) }}"
                                autocomplete="off"
                            >

                            @error('client_name')
                                <p class="sf-error">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="sf-field">
                            <label class="sf-label" for="project_date">
                                <span>Tanggal Proyek <span class="sf-optional">(opsional)</span></span>
                            </label>

                            <input
                                type="date"
                                id="project_date"
                                name="project_date"
                                class="sf-input @error('project_date') is-invalid @enderror"
                                value="{{ old('project_date', $portfolio->project_date?->format('Y-m-d')) }}"
                            >

                            @error('project_date')
                                <p class="sf-error">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="sf-field">
                        <label class="sf-label" for="category">
                            <span>Kategori Proyek <span class="sf-optional">(opsional)</span></span>
                        </label>

                        <input
                            type="text"
                            id="category"
                            name="category"
                            class="sf-input @error('category') is-invalid @enderror"
                            value="{{ old('category', $portfolio->category) }}"
                            placeholder="Contoh: Furnitur, Interior, Dekorasi"
                            autocomplete="off"
                        >

                        <div class="sf-chips" id="categoryChips" aria-label="Pilihan cepat kategori">
                            <button type="button" class="sf-chip" data-value="Furnitur">Furnitur</button>
                            <button type="button" class="sf-chip" data-value="Interior">Interior</button>
                            <button type="button" class="sf-chip" data-value="Dekorasi">Dekorasi</button>
                        </div>

                        @error('category')
                            <p class="sf-error">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="sf-field">
                        <label class="sf-label" for="description">
                            <span>Deskripsi Proyek <span class="sf-optional">(opsional)</span></span>
                            <span class="sf-counter" id="descCounter">0 karakter</span>
                        </label>

                        <textarea
                            id="description"
                            name="description"
                            class="sf-textarea @error('description') is-invalid @enderror"
                            rows="6"
                        >{{ old('description', $portfolio->description) }}</textarea>

                        @error('description')
                            <p class="sf-error">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                {{-- KOLOM KANAN: GAMBAR & STATUS --}}
                <div class="sf-side">

                    <div class="sf-card">
                        <h3 class="sf-card-title">Gambar Proyek</h3>
                        <p class="sf-card-sub">Unggah gambar baru hanya jika ingin menggantinya.</p>

                        <div class="sf-field">
                            <input
                                type="file"
                                id="image"
                                name="image"
                                class="sf-file-input"
                                accept="image/*"
                                data-max-mb="2"
                            >

                            <label for="image" id="dropzone" class="sf-drop @error('image') is-invalid @enderror">
                                <div class="sf-preview">
                                    <img
                                        id="previewImg"
                                        class="{{ $hasImage ? '' : 'is-hidden' }}"
                                        @if($hasImage)
                                            src="{{ $currentImage }}"
                                            data-original="{{ $currentImage }}"
                                        @endif
                                        alt="{{ $portfolio->title }}"
                                        onerror="this.classList.add('is-hidden'); document.getElementById('previewEmpty').classList.remove('is-hidden'); document.getElementById('previewBadge').classList.add('is-hidden');"
                                    >

                                    <div id="previewEmpty" class="sf-preview-empty {{ $hasImage ? 'is-hidden' : '' }}">
                                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="M21 15l-5-5L5 21"/>
                                        </svg>
                                        Belum ada gambar
                                    </div>

                                    <span id="previewBadge" class="sf-badge {{ $hasImage ? '' : 'is-hidden' }}">Gambar saat ini</span>
                                </div>

                                <div class="sf-drop-text">
                                    <strong>Klik untuk ganti gambar</strong>
                                    <span>atau seret dan lepas ke sini.<br>Format JPG, PNG, atau WEBP. Maksimal 2 MB.</span>
                                </div>
                            </label>

                            <button type="button" id="removeImage" class="sf-remove is-hidden">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M18 6 6 18M6 6l12 12"/>
                                </svg>
                                Batalkan gambar baru
                            </button>

                            <p class="sf-error is-hidden" id="imageClientError" role="alert">
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <line x1="12" y1="8" x2="12" y2="12"/>
                                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                                </svg>
                                <span id="imageClientErrorText"></span>
                            </p>

                            @error('image')
                                <p class="sf-error">
                                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10"/>
                                        <line x1="12" y1="8" x2="12" y2="12"/>
                                        <line x1="12" y1="16" x2="12.01" y2="16"/>
                                    </svg>
                                    {{ $message }}
                                </p>
                            @enderror

                            <p class="sf-note">Kosongkan jika tidak ingin mengganti gambar.</p>
                        </div>
                    </div>

                    <div class="sf-card">
                        <h3 class="sf-card-title">Status Proyek</h3>
                        <p class="sf-card-sub">Tandai proyek terbaik sebagai unggulan.</p>

                        <label class="sf-switch" for="is_featured">
                            <input
                                type="checkbox"
                                id="is_featured"
                                name="is_featured"
                                value="1"
                                {{ $isFeatured ? 'checked' : '' }}
                            >
                            <span class="sf-switch-track" aria-hidden="true"></span>
                            <span class="sf-switch-text">
                                <strong id="statusTitle">{{ $isFeatured ? 'Proyek unggulan' : 'Proyek reguler' }}</strong>
                                <small id="statusHint">{{ $isFeatured ? 'Proyek ditandai sebagai unggulan.' : 'Proyek tidak ditandai unggulan.' }}</small>
                            </span>
                        </label>
                    </div>

                </div>
            </div>

            <div class="sf-actions">
                <a href="{{ route('admin.portfolios.index') }}" class="sf-btn sf-btn-secondary">
                    Kembali
                </a>

                <button type="submit" id="submitBtn" class="sf-btn sf-btn-primary">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>

        
            @include('admin.partials.translations', ['translationFields' => ['title' => ['label' => 'Project title'], 'client_name' => ['label' => 'Client name'], 'category' => ['label' => 'Category'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => $portfolio])
        </form>
    </div>
</div>

<script>
    (function () {
        'use strict';

        var form        = document.getElementById('portfolioForm');
        var input       = document.getElementById('image');
        var drop        = document.getElementById('dropzone');
        var img         = document.getElementById('previewImg');
        var empty       = document.getElementById('previewEmpty');
        var badge       = document.getElementById('previewBadge');
        var removeBtn   = document.getElementById('removeImage');
        var clientError = document.getElementById('imageClientError');
        var clientText  = document.getElementById('imageClientErrorText');
        var maxMb       = parseFloat(input.getAttribute('data-max-mb')) || 2;
        var originalSrc = img.getAttribute('data-original') || '';
        var objectUrl   = null;

        /* ---------- Pratinjau gambar ---------- */
        function showImage(src, label) {
            img.src = src;
            img.classList.remove('is-hidden');
            empty.classList.add('is-hidden');
            badge.textContent = label;
            badge.classList.remove('is-hidden');
        }

        function showEmpty() {
            img.removeAttribute('src');
            img.classList.add('is-hidden');
            empty.classList.remove('is-hidden');
            badge.classList.add('is-hidden');
        }

        function clearObjectUrl() {
            if (objectUrl) {
                URL.revokeObjectURL(objectUrl);
                objectUrl = null;
            }
        }

        function setError(message) {
            if (message) {
                clientText.textContent = message;
                clientError.classList.remove('is-hidden');
                drop.classList.add('is-invalid');
            } else {
                clientError.classList.add('is-hidden');
                drop.classList.remove('is-invalid');
            }
        }

        // kembali ke gambar lama (atau kosong jika belum ada)
        function resetSelection() {
            clearObjectUrl();
            input.value = '';
            removeBtn.classList.add('is-hidden');

            if (originalSrc) {
                showImage(originalSrc, 'Gambar saat ini');
            } else {
                showEmpty();
            }
        }

        function handleFile(file) {
            if (!file) {
                resetSelection();
                return;
            }

            if (file.type.indexOf('image/') !== 0) {
                resetSelection();
                setError('File harus berupa gambar (JPG, PNG, atau WEBP).');
                return;
            }

            if (file.size > maxMb * 1024 * 1024) {
                resetSelection();
                setError('Ukuran gambar maksimal ' + maxMb + ' MB.');
                return;
            }

            setError(null);
            clearObjectUrl();
            objectUrl = URL.createObjectURL(file);
            showImage(objectUrl, originalSrc ? 'Gambar baru' : 'Pratinjau');
            removeBtn.classList.remove('is-hidden');
        }

        input.addEventListener('change', function () {
            handleFile(input.files && input.files[0]);
        });

        removeBtn.addEventListener('click', function () {
            setError(null);
            resetSelection();
        });

        ['dragenter', 'dragover'].forEach(function (name) {
            drop.addEventListener(name, function (event) {
                event.preventDefault();
                drop.classList.add('is-dragover');
            });
        });

        ['dragleave', 'drop'].forEach(function (name) {
            drop.addEventListener(name, function (event) {
                event.preventDefault();
                drop.classList.remove('is-dragover');
            });
        });

        drop.addEventListener('drop', function (event) {
            var files = event.dataTransfer && event.dataTransfer.files;
            if (!files || !files.length) return;

            try {
                var transfer = new DataTransfer();
                transfer.items.add(files[0]);
                input.files = transfer.files;
            } catch (e) { /* browser lama: pilih lewat klik */ }

            handleFile(files[0]);
        });

        /* ---------- Chip kategori ---------- */
        var categoryInput = document.getElementById('category');
        var chips         = Array.prototype.slice.call(document.querySelectorAll('#categoryChips .sf-chip'));

        function syncChips() {
            var current = categoryInput.value.trim().toLowerCase();

            chips.forEach(function (chip) {
                chip.classList.toggle('is-active', chip.getAttribute('data-value').toLowerCase() === current);
            });
        }

        chips.forEach(function (chip) {
            chip.addEventListener('click', function () {
                categoryInput.value = chip.getAttribute('data-value');
                syncChips();
                categoryInput.focus();
            });
        });

        categoryInput.addEventListener('input', syncChips);
        syncChips();

        /* ---------- Penghitung karakter deskripsi ---------- */
        var desc    = document.getElementById('description');
        var counter = document.getElementById('descCounter');

        function updateCounter() {
            counter.textContent = desc.value.length + ' karakter';
        }

        desc.addEventListener('input', updateCounter);
        updateCounter();

        /* ---------- Teks status unggulan ---------- */
        var toggle      = document.getElementById('is_featured');
        var statusTitle = document.getElementById('statusTitle');
        var statusHint  = document.getElementById('statusHint');

        toggle.addEventListener('change', function () {
            if (toggle.checked) {
                statusTitle.textContent = 'Proyek unggulan';
                statusHint.textContent  = 'Proyek ditandai sebagai unggulan.';
            } else {
                statusTitle.textContent = 'Proyek reguler';
                statusHint.textContent  = 'Proyek tidak ditandai unggulan.';
            }
        });

        /* ---------- Tombol simpan: status memproses ---------- */
        var submitBtn  = document.getElementById('submitBtn');
        var submitHtml = submitBtn.innerHTML;

        form.addEventListener('submit', function () {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="sf-spinner" aria-hidden="true"></span> Menyimpan...';
        });

        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = submitHtml;
            }
        });

        /* ---------- Fokus otomatis ke kolom yang bermasalah ---------- */
        var firstInvalid = document.querySelector('.sf-input.is-invalid, .sf-textarea.is-invalid');
        if (firstInvalid) firstInvalid.focus();
    })();
</script>

@endsection