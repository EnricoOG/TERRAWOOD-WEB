@extends('layouts.app')

@section('title', 'Checkout Pesanan | TERRAWOOD')

@section('content')

@php
    /* =====================================
       IKON (SVG)
    ===================================== */
    $ic = [
        'user'  => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'pin'   => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'box'   => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'minus' => '<path d="M5 12h14"/>',
        'plus'  => '<path d="M5 12h14"/><path d="M12 5v14"/>',
        'lock'  => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
        'info'  => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/>',
        'alert' => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
        'check' => '<polyline points="20 6 9 17 4 12"/>',
        'arrow' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'image' => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
    ];

    $icon = function ($name, $size = 18) use ($ic) {
        return '<svg class="ck-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    /* =====================================
       DATA PRODUK & PEMESAN
    ===================================== */
    $hasPrice     = !empty($product->price) && (float) $product->price > 0;
    $unitPrice    = $hasPrice ? (float) $product->price : 0;
    $unitText     = $hasPrice ? 'Rp ' . number_format($unitPrice, 0, ',', '.') : 'Dikonfirmasi admin';
    $imageUrl     = $product->image ? \Illuminate\Support\Facades\Storage::url($product->image) : null;
    $categoryName = $product->category?->name ?? 'Furnitur';
    $oldQuantity  = max(1, min(100, (int) old('quantity', 1)));
@endphp

@include('partials.navbar')

<style>
    .checkout-page,
    .checkout-page *,
    .checkout-page *::before,
    .checkout-page *::after { box-sizing: border-box; }

    .checkout-page {
        --k-navy: #082744;
        --k-gold: #F5A623;
        --k-ivory: #F7F5EF;
        --k-text: #293747;
        --k-muted: #718096;
        --k-line: #E9E5DC;
        --k-amber: #B47A13;
        --k-ease: cubic-bezier(.22, .61, .36, 1);

        min-height: 70vh;
        padding: 36px 6% 90px;
        background: var(--k-ivory);
        color: var(--k-text);
        font-family: 'Inter', sans-serif;
    }

    .checkout-container {
        max-width: 1100px;
        margin: 0 auto;
    }

    .checkout-page a { text-decoration: none; }

    .checkout-page a:focus-visible,
    .checkout-page button:focus-visible,
    .checkout-page input:focus-visible,
    .checkout-page textarea:focus-visible {
        outline: 2px solid var(--k-gold);
        outline-offset: 3px;
    }

    .ck-ic { display: block; flex-shrink: 0; }

    /* =====================================
       BREADCRUMB & LANGKAH
    ===================================== */

    .breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 22px;
        color: var(--k-muted);
        font-size: 12.5px;
    }

    .breadcrumb a {
        color: var(--k-navy);
        font-weight: 600;
        transition: color .25s ease;
    }

    .breadcrumb a:hover { color: var(--k-amber); }

    .checkout-steps {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 0;
        margin: 0 0 26px;
        list-style: none;
    }

    .checkout-steps li {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #A8A090;
        font-size: 13px;
        font-weight: 700;
    }

    .checkout-steps li + li::before {
        content: "";
        display: block;
        width: 36px;
        height: 2px;
        border-radius: 2px;
        background: #E3DDCF;
    }

    .step-dot {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #ECE7DA;
        color: #8E8672;
        font-size: 12px;
        font-weight: 800;
    }

    .checkout-steps li.is-done { color: var(--k-navy); }

    .checkout-steps li.is-done .step-dot {
        background: var(--k-navy);
        color: white;
    }

    .checkout-steps li.is-current { color: var(--k-navy); }

    .checkout-steps li.is-current .step-dot {
        background: var(--k-gold);
        color: var(--k-navy);
        box-shadow: 0 0 0 4px rgba(245,166,35,.25);
    }

    .checkout-heading { margin-bottom: 26px; }

    .checkout-heading h1 {
        margin: 0 0 8px;
        color: var(--k-navy);
        font-size: clamp(26px, 3vw, 32px);
        font-weight: 800;
    }

    .checkout-heading p {
        margin: 0;
        color: var(--k-muted);
        line-height: 1.7;
    }

    /* =====================================
       ALERT
    ===================================== */

    .checkout-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    .checkout-alert ul {
        margin: 6px 0 0;
        padding-left: 18px;
    }

    .checkout-alert.error {
        border: 1px solid #F5BABA;
        background: #FFE2E2;
        color: #B42318;
    }

    .checkout-alert.success {
        border: 1px solid #B8E5C8;
        background: #DDF5E6;
        color: #237344;
    }

    /* =====================================
       GRID & KARTU
    ===================================== */

    .checkout-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.1fr) minmax(0, .9fr);
        gap: 24px;
        align-items: start;
    }

    .checkout-main {
        display: grid;
        gap: 20px;
    }

    .checkout-card {
        padding: 28px;
        border: 1px solid var(--k-line);
        border-radius: 18px;
        background: white;
        box-shadow: 0 10px 30px rgba(8,39,68,.04);
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 22px;
        color: var(--k-navy);
        font-size: 18px;
        font-weight: 800;
    }

    .card-title-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border-radius: 11px;
        background: #FFF3DC;
        color: #B87308;
    }

    .form-group { margin-bottom: 18px; }

    .form-group:last-child { margin-bottom: 0; }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--k-text);
        font-size: 13.5px;
        font-weight: 700;
    }

    .form-group label .req { color: #D92D20; }

    .form-group input[type="text"],
    .form-group input[type="email"],
    .form-group input[type="tel"],
    .form-group textarea {
        width: 100%;
        padding: 13px 15px;
        border: 1.5px solid #DDD9D0;
        border-radius: 12px;
        background: #FFFEFC;
        color: var(--k-text);
        font-family: inherit;
        font-size: 14px;
        transition: border-color .25s ease, box-shadow .25s ease, background-color .25s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: var(--k-gold);
        background: white;
        box-shadow: 0 0 0 4px rgba(245,166,35,.14);
        outline: none;
    }

    .form-group textarea {
        min-height: 115px;
        line-height: 1.6;
        resize: vertical;
    }

    .form-group input[readonly] {
        border-color: #E6E3DB;
        background: #F3F1EC;
        color: var(--k-muted);
        cursor: not-allowed;
    }

    .field-hint {
        display: flex;
        align-items: flex-start;
        gap: 7px;
        margin-top: 7px;
        color: var(--k-muted);
        font-size: 12px;
        line-height: 1.5;
    }

    .field-hint .ck-ic { margin-top: 1px; }

    .form-error {
        margin-top: 6px;
        color: #D92D20;
        font-size: 12px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Jumlah */

    .qty-stepper {
        display: inline-flex;
        align-items: stretch;
        overflow: hidden;
        border: 1.5px solid #DDD9D0;
        border-radius: 999px;
        background: white;
    }

    .qty-stepper button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 50px;
        border: 0;
        background: #F7F5EF;
        color: var(--k-navy);
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: background-color .25s ease, color .25s ease;
    }

    .qty-stepper button:active { background: var(--k-gold); }

    @media (hover: hover) {
        .qty-stepper button:hover {
            background: var(--k-gold);
            color: var(--k-navy);
        }
    }

    .qty-stepper input {
        width: 76px;
        height: 50px;
        padding: 0;
        border: 0;
        background: white;
        color: var(--k-navy);
        font-family: 'Manrope', sans-serif;
        font-size: 17px;
        font-weight: 800;
        text-align: center;
        -moz-appearance: textfield;
    }

    .qty-stepper input::-webkit-outer-spin-button,
    .qty-stepper input::-webkit-inner-spin-button {
        margin: 0;
        -webkit-appearance: none;
    }

    .qty-stepper input:focus { outline: none; }

    .qty-wrap:focus-within .qty-stepper {
        border-color: var(--k-gold);
        box-shadow: 0 0 0 4px rgba(245,166,35,.14);
    }

    /* =====================================
       RINGKASAN
    ===================================== */

    .summary-card {
        position: sticky;
        top: 96px;
    }

    .product-summary {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        margin-bottom: 6px;
        border-bottom: 1px solid #EEEAE2;
    }

    .summary-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 96px;
        height: 96px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 14px;
        background: #ECE9E1;
        color: #9AA3AE;
    }

    .summary-image img {
        display: block;
        width: 100%;
        height: 100%;
        padding: 6px;
        object-fit: contain;
    }

    .summary-info { min-width: 0; }

    .summary-category {
        color: var(--k-amber);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .7px;
        text-transform: uppercase;
    }

    .summary-info h3 {
        margin: 5px 0 6px;
        color: var(--k-navy);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.35;
    }

    .summary-info p {
        margin: 0;
        color: var(--k-muted);
        font-size: 13px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #EEEAE2;
        font-size: 14px;
    }

    .price-row span:first-child { color: var(--k-muted); }

    .price-row strong {
        color: var(--k-navy);
        text-align: right;
    }

    .price-row.is-soft strong {
        color: var(--k-amber);
        font-size: 13px;
    }

    .total-row {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        padding-top: 18px;
        color: var(--k-navy);
        font-size: 16px;
        font-weight: 800;
    }

    .total-price {
        color: var(--k-amber);
        font-family: 'Manrope', sans-serif;
        font-size: 24px;
        text-align: right;
    }

    .total-price.is-soft { font-size: 16px; }

    .checkout-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        width: 100%;
        height: 54px;
        margin-top: 22px;
        border: 0;
        border-radius: 999px;
        background: var(--k-gold);
        color: var(--k-navy);
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        box-shadow: 0 8px 20px rgba(245,166,35,.3);
        -webkit-tap-highlight-color: transparent;
        transition:
            background-color .3s var(--k-ease),
            color .3s var(--k-ease),
            transform .3s var(--k-ease),
            box-shadow .3s var(--k-ease);
    }

    .checkout-submit .ck-ic { transition: transform .3s var(--k-ease); }

    .checkout-submit:active {
        transform: scale(.98);
        transition-duration: .12s;
    }

    @media (hover: hover) {
        .checkout-submit:hover {
            background: var(--k-navy);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 12px 26px rgba(8,39,68,.25);
        }

        .checkout-submit:hover .ck-ic { transform: translateX(3px); }
    }

    .checkout-submit[disabled] {
        opacity: .75;
        cursor: progress;
        transform: none;
    }

    .submit-spinner {
        display: none;
        width: 18px;
        height: 18px;
        border: 2.5px solid rgba(8,39,68,.25);
        border-top-color: var(--k-navy);
        border-radius: 50%;
        animation: ckSpin .7s linear infinite;
    }

    .checkout-submit.is-loading .submit-spinner { display: block; }

    .checkout-submit.is-loading .ck-ic { display: none; }

    @keyframes ckSpin {
        to { transform: rotate(360deg); }
    }

    .checkout-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        margin-top: 18px;
        border-radius: 12px;
        background: #FFF9F0;
        color: var(--k-muted);
        font-size: 12.5px;
        line-height: 1.7;
    }

    .checkout-note .ck-ic {
        margin-top: 2px;
        color: #B87308;
    }

    /* Bar di HP */

    .checkout-bar,
    .checkout-bar-spacer { display: none; }

    /* =====================================
       RESPONSIVE
    ===================================== */

    @media (max-width: 860px) {
        .checkout-page { padding: 24px 5% 40px; }

        .checkout-grid { grid-template-columns: 1fr; }

        .summary-card { position: static; }

        .checkout-card { padding: 22px 20px; }

        .checkout-heading { margin-bottom: 20px; }

        .checkout-steps li + li::before { width: 22px; }

        /* Tombol di kartu ringkasan diganti bar menempel di bawah layar */
        .summary-card .checkout-submit { display: none; }

        .checkout-bar {
            position: fixed;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 80;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 12px 5% calc(12px + env(safe-area-inset-bottom, 0px));
            border-top: 1px solid var(--k-line);
            background: white;
            box-shadow: 0 -8px 24px rgba(8,39,68,.08);
        }

        .bar-total small {
            display: block;
            color: var(--k-muted);
            font-size: 11px;
            font-weight: 600;
        }

        .bar-total strong {
            display: block;
            color: var(--k-navy);
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.2;
        }

        .checkout-bar .checkout-submit {
            display: flex;
            width: auto;
            height: 48px;
            margin-top: 0;
            padding: 0 24px;
            font-size: 14px;
        }

        .checkout-bar-spacer {
            display: block;
            height: 78px;
            background: #061D33;
        }

        .whatsapp-float { bottom: calc(92px + env(safe-area-inset-bottom, 0px)); }
    }

    @media (max-width: 520px) {
        .form-row { grid-template-columns: 1fr; }

        .checkout-steps { gap: 8px; }

        .checkout-steps li { font-size: 12px; }

        .checkout-steps li + li::before { width: 14px; }

        .product-summary { gap: 13px; }

        .summary-image {
            width: 80px;
            height: 80px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .submit-spinner { animation-duration: 1.6s; }

        .checkout-submit { transition: none; }
    }
</style>

<div class="checkout-page">
    <div class="checkout-container">

        {{-- BREADCRUMB --}}
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('catalog.index') }}">Katalog</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('catalog.show', $product->slug) }}">{{ \Illuminate\Support\Str::limit($product->name, 32) }}</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page">Checkout</span>
        </nav>

        {{-- LANGKAH --}}
        <ol class="checkout-steps" aria-label="Langkah pemesanan">

            <li class="is-done">
                <span class="step-dot">{!! $icon('check', 14) !!}</span>
                Pilih Produk
            </li>

            <li class="is-current" aria-current="step">
                <span class="step-dot">2</span>
                Checkout
            </li>

            <li>
                <span class="step-dot">3</span>
                Pesanan Dibuat
            </li>

        </ol>

        <div class="checkout-heading">
            <h1>Checkout Pesanan</h1>
            <p>
                Lengkapi informasi pengiriman untuk melanjutkan
                pesanan Anda bersama TERRAWOOD.
            </p>
        </div>

        {{-- NOTIFIKASI --}}
        @if($errors->any())
            <div class="checkout-alert error" role="alert">
                {!! $icon('alert', 20) !!}
                <div>
                    <strong>Periksa kembali data pesanan:</strong>
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="checkout-alert error" role="alert">
                {!! $icon('alert', 20) !!}
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="checkout-alert success" role="status">
                {!! $icon('check', 20) !!}
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <form action="{{ route('account.orders.store', $product->slug) }}"
              method="POST"
              id="checkoutForm">

            @csrf

            <div class="checkout-grid">

                {{-- KOLOM KIRI --}}
                <div class="checkout-main">

                    {{-- INFORMASI PEMESAN --}}
                    <section class="checkout-card">

                        <h2 class="card-title">
                            <span class="card-title-icon">{!! $icon('user', 20) !!}</span>
                            Informasi Pemesan
                        </h2>

                        <div class="form-row">

                            <div class="form-group">
                                <label for="customer_name_view">Nama Customer</label>
                                <input type="text"
                                       id="customer_name_view"
                                       value="{{ auth()->user()->name }}"
                                       readonly>
                            </div>

                            <div class="form-group">
                                <label for="customer_email_view">Email</label>
                                <input type="email"
                                       id="customer_email_view"
                                       value="{{ auth()->user()->email }}"
                                       readonly>
                            </div>

                        </div>

                        <div class="form-group" style="margin-top:18px;">

                            <label for="customer_phone">
                                Nomor WhatsApp <span class="req">*</span>
                            </label>

                            <input type="tel"
                                   id="customer_phone"
                                   name="customer_phone"
                                   value="{{ old('customer_phone') }}"
                                   placeholder="Contoh: 081234567890"
                                   maxlength="20"
                                   inputmode="tel"
                                   autocomplete="tel"
                                   required>

                            <div class="field-hint">
                                {!! $icon('info', 14) !!}
                                Admin akan menghubungi nomor ini untuk mengonfirmasi pesanan Anda.
                            </div>

                            @error('customer_phone')
                                <div class="form-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </section>

                    {{-- JUMLAH --}}
                    <section class="checkout-card">

                        <h2 class="card-title">
                            <span class="card-title-icon">{!! $icon('box', 20) !!}</span>
                            Jumlah Produk
                        </h2>

                        <div class="form-group qty-wrap">

                            <label for="quantity">
                                Jumlah <span class="req">*</span>
                            </label>

                            <div class="qty-stepper">

                                <button type="button" id="qtyMinus" aria-label="Kurangi jumlah">
                                    {!! $icon('minus', 18) !!}
                                </button>

                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       min="1"
                                       max="100"
                                       value="{{ $oldQuantity }}"
                                       inputmode="numeric"
                                       required>

                                <button type="button" id="qtyPlus" aria-label="Tambah jumlah">
                                    {!! $icon('plus', 18) !!}
                                </button>

                            </div>

                            <div class="field-hint">
                                {!! $icon('info', 14) !!}
                                Minimal 1 dan maksimal 100 produk per pesanan.
                            </div>

                            @error('quantity')
                                <div class="form-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </section>

                    {{-- PENGIRIMAN --}}
                    <section class="checkout-card">

                        <h2 class="card-title">
                            <span class="card-title-icon">{!! $icon('pin', 20) !!}</span>
                            Pengiriman
                        </h2>

                        <div class="form-group">

                            <label for="shipping_address">
                                Alamat Pengiriman <span class="req">*</span>
                            </label>

                            <textarea id="shipping_address"
                                      name="shipping_address"
                                      placeholder="Masukkan alamat lengkap pengiriman (jalan, kelurahan, kecamatan, kota, kode pos)..."
                                      autocomplete="street-address"
                                      required>{{ old('shipping_address') }}</textarea>

                            @error('shipping_address')
                                <div class="form-error">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="form-group">

                            <label for="notes">Catatan Tambahan (Opsional)</label>

                            <textarea id="notes"
                                      name="notes"
                                      placeholder="Contoh: patokan rumah atau permintaan khusus...">{{ old('notes') }}</textarea>

                            @error('notes')
                                <div class="form-error">{{ $message }}</div>
                            @enderror

                        </div>

                    </section>

                </div>

                {{-- RINGKASAN PESANAN --}}
                <aside class="checkout-card summary-card">

                    <h2 class="card-title">Ringkasan Pesanan</h2>

                    <div class="product-summary">

                        <div class="summary-image">

                            @if($imageUrl)
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product->name }}"
                                    width="96"
                                    height="96"
                                >
                            @else
                                {!! $icon('image', 28) !!}
                            @endif

                        </div>

                        <div class="summary-info">
                            <div class="summary-category">{{ $categoryName }}</div>
                            <h3>{{ $product->name }}</h3>
                            <p>{{ $unitText }}</p>
                        </div>

                    </div>

                    <div class="price-row">
                        <span>Harga Satuan</span>
                        <strong>{{ $unitText }}</strong>
                    </div>

                    <div class="price-row">
                        <span>Jumlah Produk</span>
                        <strong id="quantityDisplay">{{ $oldQuantity }}</strong>
                    </div>

                    <div class="price-row is-soft">
                        <span>Biaya Pengiriman</span>
                        <strong>Dikonfirmasi admin</strong>
                    </div>

                    <div class="total-row">
                        <span>Total Pesanan</span>

                        <span class="total-price {{ $hasPrice ? '' : 'is-soft' }}" id="totalDisplay">
                            {{ $hasPrice ? 'Rp ' . number_format($unitPrice * $oldQuantity, 0, ',', '.') : 'Dikonfirmasi admin' }}
                        </span>
                    </div>

                    <button type="submit" class="checkout-submit js-submit">
                        <span class="submit-spinner" aria-hidden="true"></span>
                        <span class="submit-text">Buat Pesanan Sekarang</span>
                        {!! $icon('arrow', 18) !!}
                    </button>

                    <div class="checkout-note">
                        {!! $icon('lock', 16) !!}
                        <span>
                            Pesanan akan tercatat dengan status Menunggu.
                            Admin TERRAWOOD akan memproses pesanan Anda.
                            Biaya pengiriman akan dikonfirmasi oleh admin.
                        </span>
                    </div>

                </aside>

            </div>

        </form>

    </div>
</div>

{{-- BAR TOTAL DI HP --}}
<div class="checkout-bar">

    <div class="bar-total">
        <small>Total</small>
        <strong id="barTotal">
            {{ $hasPrice ? 'Rp ' . number_format($unitPrice * $oldQuantity, 0, ',', '.') : 'Dikonfirmasi admin' }}
        </strong>
    </div>

    <button type="submit" form="checkoutForm" class="checkout-submit js-submit">
        <span class="submit-spinner" aria-hidden="true"></span>
        <span class="submit-text">Buat Pesanan</span>
    </button>

</div>

@include('partials.footer')

<div class="checkout-bar-spacer" aria-hidden="true"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const unitPrice = @json($unitPrice);
    const hasPrice = @json($hasPrice);

    const form = document.getElementById('checkoutForm');
    const quantityInput = document.getElementById('quantity');
    const quantityDisplay = document.getElementById('quantityDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const barTotal = document.getElementById('barTotal');
    const minusButton = document.getElementById('qtyMinus');
    const plusButton = document.getElementById('qtyPlus');
    const submitButtons = document.querySelectorAll('.js-submit');

    function formatRupiah(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(value);
    }

    function clampQuantity(value) {

        let quantity = parseInt(value, 10);

        if (isNaN(quantity)) {
            quantity = 1;
        }

        return Math.min(100, Math.max(1, quantity));

    }

    function updateTotal() {

        const quantity = clampQuantity(quantityInput.value);

        quantityDisplay.textContent = quantity;

        if (hasPrice) {

            const total = formatRupiah(unitPrice * quantity);

            totalDisplay.textContent = total;
            barTotal.textContent = total;

        }

    }

    quantityInput.addEventListener('input', updateTotal);

    quantityInput.addEventListener('change', function () {
        this.value = clampQuantity(this.value);
        updateTotal();
    });

    minusButton.addEventListener('click', function () {
        quantityInput.value = clampQuantity(quantityInput.value) - 1 < 1
            ? 1
            : clampQuantity(quantityInput.value) - 1;
        updateTotal();
    });

    plusButton.addEventListener('click', function () {
        quantityInput.value = Math.min(100, clampQuantity(quantityInput.value) + 1);
        updateTotal();
    });


    /* Status memproses saat pesanan dikirim (mencegah pesanan ganda karena klik berulang) */

    form.addEventListener('submit', function (event) {

        const quantity = parseInt(quantityInput.value, 10);

        if (isNaN(quantity) || quantity < 1 || quantity > 100) {

            event.preventDefault();

            quantityInput.value = clampQuantity(quantityInput.value);
            updateTotal();
            quantityInput.focus();

            return;
        }

        submitButtons.forEach(function (button) {

            button.disabled = true;
            button.classList.add('is-loading');

            const label = button.querySelector('.submit-text');

            if (label) label.textContent = 'Memproses...';

        });

    });

    /* Saat pengguna menekan tombol Kembali, kembalikan tombol seperti semula */

    window.addEventListener('pageshow', function (event) {

        if (!event.persisted) return;

        submitButtons.forEach(function (button, index) {

            button.disabled = false;
            button.classList.remove('is-loading');

            const label = button.querySelector('.submit-text');

            if (label) {
                label.textContent = button.closest('.checkout-bar')
                    ? 'Buat Pesanan'
                    : 'Buat Pesanan Sekarang';
            }

        });

    });

    updateTotal();

});
</script>

@endsection