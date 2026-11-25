@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number . ' | TERRAWOOD')

@section('content')

@php
    /* =====================================
       IKON (SVG)
    ===================================== */
    $ic = [
        'back'     => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
        'arrow'    => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'clock'    => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'progress' => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
        'truck'    => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
        'done'     => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'check'    => '<polyline points="20 6 9 17 4 12"/>',
        'x'        => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'alert'    => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
        'info'     => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="16" y2="12"/><line x1="12" x2="12.01" y1="8" y2="8"/>',
        'user'     => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'pin'      => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
        'note'     => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'box'      => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'image'    => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
    ];

    $icon = function ($name, $size = 18) use ($ic) {
        return '<svg class="od-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    $waIcon = '<svg class="od-ic" width="18" height="18" viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16.02 3.2A12.7 12.7 0 0 0 5.1 22.38L3.4 28.6l6.37-1.67A12.7 12.7 0 1 0 16.02 3.2Zm0 23.1c-1.98 0-3.92-.53-5.62-1.53l-.4-.24-3.78.99 1.01-3.68-.26-.42a10.38 10.38 0 1 1 9.05 4.88Zm5.7-7.77c-.31-.16-1.84-.91-2.12-1.01-.29-.1-.5-.16-.71.16-.21.31-.81 1.01-.99 1.22-.18.21-.36.23-.67.08-.31-.16-1.3-.48-2.47-1.53-.91-.81-1.53-1.81-1.71-2.12-.18-.31-.02-.48.14-.64.14-.14.31-.36.47-.54.16-.18.21-.31.31-.52.1-.21.05-.39-.03-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54h-.6c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.61s1.13 3.03 1.28 3.24c.16.21 2.22 3.39 5.38 4.75.75.32 1.33.51 1.78.65.75.24 1.44.2 1.98.12.6-.09 1.84-.75 2.1-1.48.26-.73.26-1.35.18-1.48-.08-.13-.29-.21-.6-.37Z"/></svg>';

    /* =====================================
       STATUS PESANAN
    ===================================== */
    $statusAlias = [
        'pending'    => 'menunggu',
        'processing' => 'diproses',
        'shipped'    => 'dikirim',
        'completed'  => 'selesai',
        'cancelled'  => 'dibatalkan',
        'canceled'   => 'dibatalkan',
    ];

    $statusLabels = [
        'menunggu'   => 'Menunggu',
        'diproses'   => 'Diproses',
        'dikirim'    => 'Dikirim',
        'selesai'    => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    $stepIndex = [
        'menunggu' => 1,
        'diproses' => 2,
        'dikirim'  => 3,
        'selesai'  => 4,
    ];

    $statusKey   = $statusAlias[strtolower(trim((string) $order->status))] ?? strtolower(trim((string) $order->status));
    $statusLabel = $statusLabels[$statusKey] ?? ucfirst($statusKey);
    $statusClass = isset($statusLabels[$statusKey]) ? 'status-' . $statusKey : 'status-lain';
    $currentStep = $stepIndex[$statusKey] ?? 0;
    $isCancelled = $statusKey === 'dibatalkan';

    $trackSteps = [
        1 => ['Menunggu', 'clock'],
        2 => ['Diproses', 'progress'],
        3 => ['Dikirim', 'truck'],
        4 => ['Selesai', 'done'],
    ];

    /* Pembatalan hanya untuk pesanan berstatus "menunggu" (sama seperti sebelumnya) */
    $canCancel = $order->status === 'menunggu';

    /* =====================================
       PRODUK, HARGA, WHATSAPP
    ===================================== */
    $product  = $order->product;
    $imageUrl = $product?->image ? \Illuminate\Support\Facades\Storage::url($product->image) : null;

    $waNumber = '6281320122571';
    $waUrl    = 'https://wa.me/' . $waNumber . '?text='
              . rawurlencode('Halo TERRAWOOD, saya ingin menanyakan pesanan ' . $order->order_number . '.');
@endphp

@include('partials.navbar')

<style>
    .od-page,
    .od-page *,
    .od-page *::before,
    .od-page *::after { box-sizing: border-box; }

    .od-page {
        --o-navy: #082744;
        --o-gold: #F5A623;
        --o-ivory: #F7F5EF;
        --o-text: #293747;
        --o-muted: #718096;
        --o-line: #E9E5DC;
        --o-amber: #A56800;
        --o-ease: cubic-bezier(.22, .61, .36, 1);

        min-height: 70vh;
        padding: 36px 6% 80px;
        background: var(--o-ivory);
        color: var(--o-text);
        font-family: 'Inter', sans-serif;
    }

    .od-container {
        max-width: 1050px;
        margin: 0 auto;
    }

    .od-page a { text-decoration: none; }

    .od-page a:focus-visible,
    .od-page button:focus-visible {
        outline: 2px solid var(--o-gold);
        outline-offset: 3px;
    }

    .od-ic { display: block; flex-shrink: 0; }

    /* =====================================
       BREADCRUMB
    ===================================== */

    .breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
        color: var(--o-muted);
        font-size: 12.5px;
    }

    .breadcrumb a {
        color: var(--o-navy);
        font-weight: 600;
        transition: color .25s ease;
    }

    .breadcrumb a:hover { color: var(--o-amber); }

    /* =====================================
       TOMBOL
    ===================================== */

    .od-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 12px 22px;
        border: 0;
        border-radius: 999px;
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 800;
        line-height: 1;
        white-space: nowrap;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        transition:
            background-color .3s var(--o-ease),
            color .3s var(--o-ease),
            border-color .3s var(--o-ease),
            transform .3s var(--o-ease),
            box-shadow .3s var(--o-ease);
    }

    .od-btn .od-ic { transition: transform .3s var(--o-ease); }

    .od-btn--gold {
        background: var(--o-gold);
        color: var(--o-navy);
        box-shadow: 0 8px 20px rgba(245,166,35,.3);
    }

    .od-btn--navy {
        background: var(--o-navy);
        color: white;
    }

    .od-btn--outline {
        border: 1.5px solid #DCD5C6;
        background: white;
        color: var(--o-navy);
    }

    .od-btn--danger {
        border: 1.5px solid #B42318;
        background: white;
        color: #B42318;
    }

    .od-btn--danger-solid {
        background: #B42318;
        color: white;
    }

    .od-btn:active {
        transform: translateY(0) scale(.97);
        transition-duration: .12s;
    }

    .od-btn[disabled] {
        opacity: .75;
        cursor: progress;
        transform: none;
    }

    @media (hover: hover) {
        .od-btn:hover { transform: translateY(-2px); }

        .od-btn:hover .od-ic { transform: translateX(3px); }

        .od-btn--gold:hover { background: var(--o-navy); color: white; }

        .od-btn--navy:hover { background: var(--o-gold); color: var(--o-navy); }

        .od-btn--outline:hover {
            border-color: var(--o-gold);
            background: #FFF9F0;
        }

        .od-btn--danger:hover {
            background: #B42318;
            color: white;
        }

        .od-btn--danger-solid:hover { background: #921C14; }
    }

    /* =====================================
       ALERT
    ===================================== */

    .od-alert {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 14px 16px;
        margin-bottom: 20px;
        border-radius: 12px;
        font-size: 14px;
        line-height: 1.6;
    }

    .od-alert > span:nth-child(2) { flex: 1; }

    .od-alert.success {
        border: 1px solid #B8E5C8;
        background: #DDF5E6;
        color: #237344;
    }

    .od-alert.error {
        border: 1px solid #F5BABA;
        background: #FFE2E2;
        color: #B42318;
    }

    .od-alert button {
        padding: 2px;
        border: 0;
        background: transparent;
        color: inherit;
        cursor: pointer;
        opacity: .7;
        transition: opacity .2s ease;
    }

    .od-alert button:hover { opacity: 1; }

    /* =====================================
       HEADER PESANAN
    ===================================== */

    .od-header {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
        overflow: hidden;
        padding: 28px 32px;
        margin-bottom: 22px;
        border-radius: 20px;
        background: linear-gradient(115deg, #082744, #123e63);
        color: white;
        box-shadow: 0 14px 32px rgba(8,39,68,.14);
    }

    .od-header::after {
        content: "";
        position: absolute;
        right: -90px;
        top: -120px;
        width: 300px;
        height: 300px;
        border: 1px solid rgba(245,166,35,.25);
        border-radius: 50%;
        pointer-events: none;
    }

    .od-header > * {
        position: relative;
        z-index: 1;
    }

    .od-eyebrow {
        margin: 0 0 6px;
        color: var(--o-gold);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
    }

    .od-header h1 {
        margin: 0 0 8px;
        color: white;
        font-size: clamp(22px, 2.8vw, 30px);
        font-weight: 800;
        line-height: 1.2;
        word-break: break-word;
    }

    .od-header-meta {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        color: #D6E0E9;
        font-size: 13.5px;
    }

    .od-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .od-header .od-btn--outline {
        border-color: rgba(255,255,255,.55);
        background: transparent;
        color: white;
    }

    @media (hover: hover) {
        .od-header .od-btn--outline:hover {
            border-color: white;
            background: white;
            color: var(--o-navy);
        }
    }

    /* =====================================
       STATUS BADGE
    ===================================== */

    .status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 13px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        white-space: nowrap;
    }

    .status::before {
        content: "";
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-menunggu   { background: #FFF1D6; color: #A56800; }
    .status-diproses   { background: #E1EDFF; color: #2456A6; }
    .status-dikirim    { background: #E8E1FF; color: #6743A5; }
    .status-selesai    { background: #DDF5E6; color: #237344; }
    .status-dibatalkan { background: #FFE2E2; color: #B42318; }
    .status-lain       { background: #EEF1F4; color: #5B6775; }

    /* =====================================
       KARTU
    ===================================== */

    .od-card {
        min-width: 0;
        padding: 26px;
        border: 1px solid var(--o-line);
        border-radius: 18px;
        background: white;
        box-shadow: 0 2px 10px rgba(8,39,68,.04);
    }

    .od-card + .od-card { margin-top: 20px; }

    .od-card-title {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 0 0 20px;
        color: var(--o-navy);
        font-size: 18px;
        font-weight: 800;
    }

    .od-card-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #FFF3DC;
        color: #B87308;
    }

    .od-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(0, .95fr);
        gap: 22px;
        align-items: start;
    }

    /* =====================================
       PELACAK
    ===================================== */

    .od-tracker { margin-bottom: 22px; }

    .tracker-steps {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
    }

    .t-step {
        position: relative;
        text-align: center;
    }

    .t-step::before {
        content: "";
        position: absolute;
        top: 19px;
        left: -50%;
        right: 50%;
        height: 3px;
        background: #E6E0D3;
    }

    .t-step:first-child::before { display: none; }

    .t-step.is-done::before,
    .t-step.is-current::before { background: var(--o-navy); }

    .t-dot {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        margin: 0 auto 10px;
        border: 2px solid #E6E0D3;
        border-radius: 50%;
        background: white;
        color: #B7B0A1;
    }

    .t-step.is-done .t-dot {
        border-color: var(--o-navy);
        background: var(--o-navy);
        color: white;
    }

    .t-step.is-current .t-dot {
        border-color: var(--o-gold);
        background: var(--o-gold);
        color: var(--o-navy);
        box-shadow: 0 0 0 5px rgba(245,166,35,.25);
        animation: odPulse 2s ease-in-out infinite;
    }

    .t-label {
        display: block;
        color: var(--o-muted);
        font-size: 12px;
        font-weight: 700;
    }

    .t-step.is-done .t-label,
    .t-step.is-current .t-label { color: var(--o-navy); }

    @keyframes odPulse {
        0%, 100% { box-shadow: 0 0 0 5px rgba(245,166,35,.25); }
        50%      { box-shadow: 0 0 0 9px rgba(245,166,35,.08); }
    }

    .cancelled-box {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .cancelled-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        flex-shrink: 0;
        border-radius: 50%;
        background: #FFE2E2;
        color: #B42318;
    }

    .cancelled-box strong {
        display: block;
        margin-bottom: 3px;
        color: var(--o-navy);
        font-size: 15px;
    }

    .cancelled-box span {
        color: var(--o-muted);
        font-size: 13.5px;
        line-height: 1.6;
    }

    .od-status-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 14px 16px;
        margin-top: 22px;
        border-radius: 12px;
        background: #FFF9F0;
        color: var(--o-text);
        font-size: 13.5px;
        line-height: 1.7;
    }

    .od-status-note .od-ic {
        margin-top: 3px;
        color: #B87308;
    }

    /* =====================================
       PRODUK & BARIS DATA
    ===================================== */

    .od-product {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 20px;
        margin-bottom: 6px;
        border-bottom: 1px solid #EEEAE2;
    }

    .od-product-image {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 92px;
        height: 92px;
        flex-shrink: 0;
        overflow: hidden;
        border-radius: 14px;
        background: #ECE9E1;
        color: #9AA3AE;
    }

    .od-product-image img {
        display: block;
        width: 100%;
        height: 100%;
        padding: 6px;
        object-fit: contain;
    }

    .od-product h3 {
        margin: 0 0 6px;
        color: var(--o-navy);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.35;
    }

    .od-product p {
        margin: 0;
        color: var(--o-muted);
        font-size: 13px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        padding: 13px 0;
        border-bottom: 1px solid #EEEAE2;
        font-size: 14px;
    }

    .detail-row:last-child { border-bottom: 0; }

    .detail-row span:first-child {
        flex-shrink: 0;
        color: var(--o-muted);
    }

    .detail-row strong {
        color: var(--o-navy);
        text-align: right;
        word-break: break-word;
    }

    .od-total {
        display: flex;
        align-items: baseline;
        justify-content: space-between;
        gap: 12px;
        padding-top: 18px;
        color: var(--o-navy);
        font-size: 16px;
        font-weight: 800;
    }

    .od-total strong {
        color: #B47A13;
        font-family: 'Manrope', sans-serif;
        font-size: 24px;
    }

    .od-address-label {
        margin: 18px 0 6px;
        color: var(--o-navy);
        font-size: 14px;
        font-weight: 800;
    }

    .od-address {
        margin: 0;
        color: var(--o-muted);
        font-size: 14px;
        line-height: 1.8;
        white-space: pre-line;
    }

    .od-notes {
        padding: 15px 16px;
        border-radius: 12px;
        background: #F7F5EF;
        color: var(--o-muted);
        font-size: 14px;
        line-height: 1.7;
        white-space: pre-line;
    }

    .od-cancel-wrap { margin-top: 20px; }

    .od-cancel-wrap .od-btn { width: 100%; }

    /* =====================================
       DIALOG PEMBATALAN
    ===================================== */

    .cancel-modal {
        position: fixed;
        inset: 0;
        z-index: 100000;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(6,29,51,.72);
    }

    .cancel-modal.active { display: flex; }

    .cancel-modal-content {
        width: 100%;
        max-width: 430px;
        padding: 32px;
        border-radius: 20px;
        background: white;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        text-align: center;
        animation: odModalIn .25s ease;
    }

    @keyframes odModalIn {
        from { opacity: 0; transform: translateY(15px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .cancel-modal-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 66px;
        height: 66px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #FFF1D6;
        color: #B47A13;
    }

    .cancel-modal-content h3 {
        margin: 0 0 10px;
        color: var(--o-navy);
        font-size: 21px;
        font-weight: 800;
    }

    .cancel-modal-content p {
        margin: 0 0 24px;
        color: var(--o-muted);
        font-size: 14px;
        line-height: 1.7;
    }

    .cancel-modal-actions {
        display: flex;
        gap: 12px;
    }

    .cancel-modal-actions .od-btn,
    .cancel-modal-actions form { flex: 1; }

    .cancel-modal-actions form { margin: 0; }

    .cancel-modal-actions form .od-btn { width: 100%; }

    /* =====================================
       RESPONSIVE
    ===================================== */

    @media (max-width: 860px) {
        .od-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 550px) {
        .od-page { padding: 24px 5% 60px; }

        .od-header {
            padding: 22px 20px;
            border-radius: 18px;
        }

        .od-header-actions { width: 100%; }

        .od-header-actions .od-btn { flex: 1; }

        .od-card { padding: 20px 18px; }

        .t-label { font-size: 11px; }

        .t-dot {
            width: 34px;
            height: 34px;
        }

        .t-step::before { top: 16px; }

        .od-product-image {
            width: 76px;
            height: 76px;
        }

        .cancel-modal-content { padding: 26px 20px; }

        .cancel-modal-actions { flex-direction: column-reverse; }
    }

    @media (prefers-reduced-motion: reduce) {
        .t-step.is-current .t-dot { animation: none; }

        .cancel-modal-content { animation: none; }

        .od-btn { transition: none; }
    }
</style>

<div class="od-page">
    <div class="od-container">

        {{-- BREADCRUMB --}}
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('account.index') }}">Dashboard</a>
            <span aria-hidden="true">›</span>
            <span aria-current="page">{{ $order->order_number }}</span>
        </nav>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="od-alert success" role="status">
                {!! $icon('done', 20) !!}
                <span>{{ session('success') }}</span>
                <button type="button" data-dismiss aria-label="Tutup">{!! $icon('x', 16) !!}</button>
            </div>
        @endif

        @if(session('error'))
            <div class="od-alert error" role="alert">
                {!! $icon('alert', 20) !!}
                <span>{{ session('error') }}</span>
                <button type="button" data-dismiss aria-label="Tutup">{!! $icon('x', 16) !!}</button>
            </div>
        @endif

        {{-- HEADER PESANAN --}}
        <section class="od-header">

            <div>

                <p class="od-eyebrow">Detail Pesanan</p>

                <h1>{{ $order->order_number }}</h1>

                <div class="od-header-meta">
                    <span class="status {{ $statusClass }}">{{ $statusLabel }}</span>
                    <span>Dipesan {{ $order->created_at->locale('id')->translatedFormat('d F Y, H:i') }}</span>
                </div>

            </div>

            <div class="od-header-actions">

                <a href="{{ $waUrl }}"
                   class="od-btn od-btn--gold"
                   target="_blank"
                   rel="noopener">
                    {!! $waIcon !!} Tanya via WhatsApp
                </a>

                <a href="{{ route('account.index') }}" class="od-btn od-btn--outline">
                    {!! $icon('back', 16) !!} Dashboard
                </a>

            </div>

        </section>

        {{-- PELACAK STATUS --}}
        <section class="od-card od-tracker">

            @if($isCancelled)

                <div class="cancelled-box">

                    <span class="cancelled-icon">{!! $icon('x', 24) !!}</span>

                    <div>
                        <strong>Pesanan Dibatalkan</strong>
                        <span>
                            Pesanan ini telah dibatalkan dan tidak akan diproses
                            lebih lanjut.
                        </span>
                    </div>

                </div>

            @else

                <div class="tracker-steps">

                    @foreach($trackSteps as $number => $step)

                        @php
                            $stepState = $currentStep === 4 && $number <= 4
                                ? 'is-done'
                                : ($number < $currentStep ? 'is-done' : ($number === $currentStep ? 'is-current' : ''));
                        @endphp

                        <div class="t-step {{ $stepState }}">
                            <span class="t-dot">
                                @if($stepState === 'is-done')
                                    {!! $icon('check', 18) !!}
                                @else
                                    {!! $icon($step[1], 18) !!}
                                @endif
                            </span>
                            <span class="t-label">{{ $step[0] }}</span>
                        </div>

                    @endforeach

                </div>

            @endif

            <div class="od-status-note">

                {!! $icon('info', 18) !!}

                <span>
                    @if($statusKey === 'menunggu')
                        Pesanan Anda sedang menunggu konfirmasi admin TERRAWOOD.
                        Anda masih dapat membatalkan pesanan selama statusnya
                        belum berubah menjadi diproses.
                    @elseif($statusKey === 'diproses')
                        Pesanan Anda sedang diproses dan dikerjakan dengan teliti.
                        Kami akan memberi tahu Anda saat statusnya berubah.
                    @elseif($statusKey === 'dikirim')
                        Pesanan Anda sedang dalam perjalanan menuju alamat pengiriman.
                    @elseif($statusKey === 'selesai')
                        Pesanan telah selesai. Terima kasih telah berbelanja di TERRAWOOD.
                    @elseif($statusKey === 'dibatalkan')
                        Anda dapat memesan kembali produk ini kapan saja melalui katalog kami.
                    @else
                        Status pesanan akan diperbarui oleh admin TERRAWOOD.
                        Silakan kunjungi halaman ini kembali untuk melihat
                        perkembangan terbaru.
                    @endif
                </span>

            </div>

        </section>

        <div class="od-grid">

            {{-- KOLOM KIRI: PRODUK & HARGA --}}
            <div>

                <section class="od-card">

                    <h2 class="od-card-title">
                        <span class="od-card-icon">{!! $icon('box', 20) !!}</span>
                        Produk yang Dipesan
                    </h2>

                    <div class="od-product">

                        <div class="od-product-image">

                            @if($imageUrl)
                                <img
                                    src="{{ $imageUrl }}"
                                    alt="{{ $product->name }}"
                                    width="92"
                                    height="92"
                                >
                            @else
                                {!! $icon('image', 28) !!}
                            @endif

                        </div>

                        <div>
                            <h3>{{ $product?->name ?? 'Produk tidak tersedia' }}</h3>
                            <p>{{ $order->quantity }} produk</p>
                        </div>

                    </div>

                    <div class="detail-row">
                        <span>Harga Satuan</span>
                        <strong>Rp {{ number_format((float) $order->unit_price, 0, ',', '.') }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Jumlah</span>
                        <strong>{{ $order->quantity }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Biaya Pengiriman</span>
                        <strong>Dikonfirmasi admin</strong>
                    </div>

                    <div class="od-total">
                        <span>Total Pesanan</span>
                        <strong>Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}</strong>
                    </div>

                </section>

                @if($statusKey === 'selesai' || $isCancelled)

                    @if($product?->slug)

                        <section class="od-card" style="text-align:center;">

                            <p style="margin:0 0 16px;color:var(--o-muted);font-size:14px;line-height:1.7;">
                                Tertarik memesan produk ini lagi?
                            </p>

                            <a href="{{ route('catalog.show', $product->slug) }}" class="od-btn od-btn--gold">
                                Pesan Lagi {!! $icon('arrow', 16) !!}
                            </a>

                        </section>

                    @endif

                @endif

            </div>

            {{-- KOLOM KANAN: PENGIRIMAN & CATATAN --}}
            <div>

                <section class="od-card">

                    <h2 class="od-card-title">
                        <span class="od-card-icon">{!! $icon('pin', 20) !!}</span>
                        Informasi Pengiriman
                    </h2>

                    <div class="detail-row">
                        <span>Nama Penerima</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Nomor WhatsApp</span>
                        <strong>{{ $order->customer_phone }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Email</span>
                        <strong>{{ $order->customer_email ?: '-' }}</strong>
                    </div>

                    <p class="od-address-label">Alamat Pengiriman</p>

                    <p class="od-address">{{ $order->shipping_address }}</p>

                </section>

                <section class="od-card">

                    <h2 class="od-card-title">
                        <span class="od-card-icon">{!! $icon('note', 20) !!}</span>
                        Catatan Pesanan
                    </h2>

                    <div class="od-notes">
                        {{ $order->notes ?: 'Tidak ada catatan tambahan.' }}
                    </div>

                    @if($canCancel)

                        <div class="od-cancel-wrap">

                            <button
                                type="button"
                                class="od-btn od-btn--danger"
                                id="openCancel"
                            >
                                Batalkan Pesanan
                            </button>

                        </div>

                    @endif

                </section>

            </div>

        </div>

    </div>
</div>

{{-- DIALOG KONFIRMASI PEMBATALAN --}}
@if($canCancel)
    <div class="cancel-modal"
         id="cancelModal"
         role="dialog"
         aria-modal="true"
         aria-labelledby="cancelTitle">

        <div class="cancel-modal-content">

            <div class="cancel-modal-icon">{!! $icon('alert', 30) !!}</div>

            <h3 id="cancelTitle">Batalkan Pesanan?</h3>

            <p>
                Apakah Anda yakin ingin membatalkan pesanan
                <strong>{{ $order->order_number }}</strong>?
                Pesanan yang sudah dibatalkan tidak dapat diproses kembali.
            </p>

            <div class="cancel-modal-actions">

                <form id="cancelOrderForm"
                      action="{{ route('account.orders.cancel', $order->id) }}"
                      method="POST">
                    @csrf

                    <button type="submit" class="od-btn od-btn--danger-solid" id="confirmCancel">
                        Ya, Batalkan Pesanan
                    </button>
                </form>

                <button type="button" class="od-btn od-btn--outline" id="closeCancel">
                    Kembali
                </button>

            </div>

        </div>

    </div>
@endif

@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Tutup pesan sukses / error */

    document.querySelectorAll('[data-dismiss]').forEach(function (button) {

        button.addEventListener('click', function () {
            const alertBox = button.closest('.od-alert');

            if (alertBox) alertBox.remove();
        });

    });


    /* Dialog pembatalan */

    const modal = document.getElementById('cancelModal');
    const openButton = document.getElementById('openCancel');
    const closeButton = document.getElementById('closeCancel');
    const cancelForm = document.getElementById('cancelOrderForm');
    const confirmButton = document.getElementById('confirmCancel');

    if (!modal || !openButton) return;

    function openModal() {
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
        closeButton.focus();
    }

    function closeModal() {
        modal.classList.remove('active');
        document.body.style.overflow = '';
        openButton.focus();
    }

    openButton.addEventListener('click', openModal);

    closeButton.addEventListener('click', closeModal);

    modal.addEventListener('click', function (event) {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('active')) closeModal();
    });

    /* Cegah klik ganda saat membatalkan */

    cancelForm.addEventListener('submit', function () {
        confirmButton.disabled = true;
        confirmButton.textContent = 'Membatalkan...';
    });

    window.addEventListener('pageshow', function (event) {

        if (event.persisted) {
            confirmButton.disabled = false;
            confirmButton.textContent = 'Ya, Batalkan Pesanan';
            closeModal();
        }

    });

});
</script>

@endsection