@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Dasbor', 'Dashboard', '用户中心') . ' | TERRAWOOD')

@section('content')
@php
    /* =====================================
       ICONS (SVG)
    ===================================== */
    $ic = [
    'bell'     => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
    'bag'      => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
    'clock'    => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
    'progress' => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
    'done'     => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
    'check'    => '<polyline points="20 6 9 17 4 12"/>',
    'truck'    => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
    'alert'    => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
    'arrow'    => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
    'logout'   => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>',
    'x'        => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
    'support'  => '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><line x1="4.93" x2="9.17" y1="4.93" y2="9.17"/><line x1="14.83" x2="19.07" y1="14.83" y2="19.07"/><line x1="14.83" x2="19.07" y1="9.17" y2="4.93"/><line x1="4.93" x2="9.17" y1="19.07" y2="14.83"/>',
    'mail'     => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
    /* Path WhatsApp yang sudah dioptimalkan untuk viewBox 24x24 (fill-based) */
    'wa'       => '<path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>',
];

$icon = function ($name, $size = 20) use ($ic) {
    /* Ikon WhatsApp menggunakan fill (solid), bukan stroke (outline) */
    if ($name === 'wa') {
        return '<svg class="acc-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    }
    return '<svg class="acc-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
};

    /* =====================================
       REAL CONTACT DATA
    ===================================== */
    $waNumber = '6281320122571';
    $waDisplay = '+62 813-2012-2571';
    $contactEmail = 'terrawoodfd@gmail.com';

    /* =====================================
       USER DATA
    ===================================== */
    $nameParts  = preg_split('/\s+/', trim((string) ($user->name ?? 'Customer')), -1, PREG_SPLIT_NO_EMPTY) ?: [];
    $firstName  = $nameParts[0] ?? 'Customer';
    $initials   = '';

    foreach (array_slice($nameParts, 0, 2) as $part) {
        $initials .= mb_strtoupper(mb_substr($part, 0, 1));
    }
    $initials = $initials ?: 'U';
    $dateLocale  = session('site_locale', 'en') === 'zh' ? 'zh_CN' : session('site_locale', 'en');
    $memberSince = $user->created_at?->locale($dateLocale)->translatedFormat('F Y') ?? t3('Baru Bergabung', 'Recently Joined', '最近加入');

    /* =====================================
       ORDER STATUS
    ===================================== */
    $statusAlias = [
        'pending'    => 'pending',
        'processing' => 'processing',
        'shipped'    => 'shipped',
        'completed'  => 'completed',
        'cancelled'  => 'cancelled',
        'canceled'   => 'cancelled',
        // Nilai status berbahasa Indonesia (dipakai di panel admin)
        'menunggu'   => 'pending',
        'diproses'   => 'processing',
        'dikirim'    => 'shipped',
        'selesai'    => 'completed',
        'dibatalkan' => 'cancelled',
    ];

    $statusLabels = [
        'pending'    => t3('Menunggu', 'Pending', '待处理'),
        'processing' => t3('Diproses', 'Processing', '处理中'),
        'shipped'    => t3('Dikirim', 'Shipped', '已发货'),
        'completed'  => t3('Selesai', 'Completed', '已完成'),
        'cancelled'  => t3('Dibatalkan', 'Cancelled', '已取消'),
    ];

    $stepIndex = [
        'pending'    => 1,
        'processing' => 2,
        'shipped'    => 3,
        'completed'  => 4,
    ];

    $statusNotes = [
        'pending'    => t3('Pesanan Anda menunggu konfirmasi dan verifikasi dari tim TERRAWOOD.', 'Your order is pending confirmation and verification from the TERRAWOOD team.', '您的订单正在等待 TERRAWOOD 团队确认与审核。'),
        'processing' => t3('Pesanan Anda sedang diproses dan dikerjakan dengan teliti oleh pengrajin kami.', 'Your order is currently being processed and carefully crafted by our artisans.', '您的订单正在由我们的工匠精心制作中。'),
        'shipped'    => t3('Pesanan Anda sedang dalam perjalanan ke alamat pengiriman.', 'Your order is on its way to your delivery address.', '您的订单正在配送至您的收货地址。'),
    ];

    $normalizeStatus = function ($raw) use ($statusAlias) {
        $key = strtolower(trim((string) $raw));
        return $statusAlias[$key] ?? $key;
    };

    $statusLabel = function ($key) use ($statusLabels) {
        return $statusLabels[$key] ?? ucfirst($key);
    };

    $statusClass = function ($key) use ($statusLabels) {
        return isset($statusLabels[$key]) ? 'status-' . $key : 'status-other';
    };

    /* =====================================
       ORDER DATA
    ===================================== */
    $orderItems = collect(method_exists($orders, 'items') ? $orders->items() : $orders);

    $statusCounts = $orderItems
        ->groupBy(fn($item) => $normalizeStatus($item->status))
        ->map(fn($group) => $group->count());

    $activeOrder = null;
    if (!method_exists($orders, 'currentPage') || $orders->currentPage() === 1) {
        $activeOrder = $orderItems->first(fn($item) => !in_array($normalizeStatus($item->status), ['completed', 'cancelled'], true));
    }

    $fallbackImage = asset('images/products/01_teak_stool_with_4_legs.png');
    $orderImage = function ($order) use ($fallbackImage) {
        $path = $order->product?->image ?? null;
        return $path ? asset('storage/' . ltrim((string) $path, '/')) : $fallbackImage;
    };

    /* =====================================
       NOTIFICATIONS & HELP
    ===================================== */
    $notifications = $user->notifications()->latest()->take(5)->get();
    $unreadCount = $user->unreadNotifications()->count();

    $waHelpUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode(t3('Halo TERRAWOOD, saya membutuhkan bantuan terkait akun/pesanan saya.', 'Hello TERRAWOOD, I need assistance regarding my account/order.', '您好 TERRAWOOD，我需要有关账户/订单的帮助。'));
    
    $waOrderUrl = function ($orderNumber) use ($waNumber) {
        return 'https://wa.me/' . $waNumber . '?text=' . rawurlencode(t3('Halo TERRAWOOD, saya ingin menanyakan pesanan dengan nomor ' . $orderNumber . '.', 'Hello TERRAWOOD, I would like to inquire about my order number ' . $orderNumber . '.', '您好 TERRAWOOD，我想咨询订单号 ' . $orderNumber . ' 的情况。'));
    };

    try {
        $suggestions = \App\Models\Product::where('is_featured', true)->latest()->take(4)->get();
    } catch (\Throwable $e) {
        $suggestions = collect();
    }
@endphp

<style>
    .account-page, .account-page *, .account-page *::before, .account-page *::after { box-sizing: border-box; }
    .account-page {
        --tw-navy: #082744;
        --tw-dark: #061D33;
        --tw-gold: #F5A623;
        --tw-orange: #FFA43A;
        --tw-ivory: #F7F5EF;
        --tw-text: #293747;
        --tw-muted: #687482;
        --tw-line: #E9E5DC;
        --tw-ease: cubic-bezier(.22, .61, .36, 1);

        min-height: 70vh;
        padding: 40px 6% 80px;
        background: var(--tw-ivory);
        color: var(--tw-text);
        font-family: 'Inter', sans-serif;
    }
    .account-container { max-width: 1250px; margin: 0 auto; }
    .account-page a { text-decoration: none; }
    .account-page a:focus-visible, .account-page button:focus-visible { outline: 2px solid var(--tw-gold); outline-offset: 3px; }
    .acc-ic { display: block; flex-shrink: 0; }

    /* BUTTONS */
    .acc-btn {
        display: inline-flex; align-items: center; justify-content: center; gap: 10px;
        padding: 12px 22px; border: 0; border-radius: 999px;
        font-family: 'Manrope', 'Inter', sans-serif; font-size: 13px; font-weight: 800; line-height: 1;
        white-space: nowrap; cursor: pointer; -webkit-tap-highlight-color: transparent;
        transition: background-color .3s var(--tw-ease), color .3s var(--tw-ease), border-color .3s var(--tw-ease), transform .3s var(--tw-ease), box-shadow .3s var(--tw-ease);
    }
    .acc-btn .acc-ic { transition: transform .3s var(--tw-ease); }
    .acc-btn--gold { background: var(--tw-gold); color: var(--tw-navy); box-shadow: 0 8px 20px rgba(245,166,35,.3); }
    .acc-btn--navy { background: var(--tw-navy); color: white; }
    .acc-btn--ghost { background: transparent; color: white; border: 1.5px solid rgba(255,255,255,.55); }
    .acc-btn--outline { background: white; color: var(--tw-navy); border: 1.5px solid #DCD5C6; }
    .acc-btn--wa { background: #20C76A; color: white; }
    .acc-btn--sm { padding: 10px 16px; font-size: 12px; }
    .acc-btn:active { transform: translateY(0) scale(.97); transition-duration: .12s; }
    @media (hover: hover) {
        .acc-btn:hover { transform: translateY(-2px); }
        .acc-btn:hover .acc-ic { transform: translateX(3px); }
        .acc-btn--gold:hover { background: white; }
        .acc-btn--navy:hover { background: var(--tw-gold); color: var(--tw-navy); }
        .acc-btn--ghost:hover { background: white; color: var(--tw-navy); border-color: white; }
        .acc-btn--outline:hover { background: #FFF9F0; border-color: var(--tw-gold); }
        .acc-btn--wa:hover { background: #17A956; }
    }

    /* ALERTS */
    .account-alert {
        display: flex; align-items: flex-start; gap: 12px; padding: 14px 16px; margin-bottom: 20px;
        border-radius: 12px; font-size: 14px; line-height: 1.6;
    }
    .account-alert > span:nth-child(2) { flex: 1; }
    .account-alert.success { background: #DDF5E6; color: #237344; border: 1px solid #B8E5C8; }
    .account-alert.error { background: #FFE2E2; color: #B42318; border: 1px solid #F5BABA; }
    .account-alert button { border: 0; background: transparent; color: inherit; cursor: pointer; padding: 2px; opacity: .7; transition: opacity .2s ease; }
    .account-alert button:hover { opacity: 1; }

    /* HERO PROFILE */
    .account-hero {
        position: relative; overflow: hidden; display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 24px; padding: 32px 36px; margin-bottom: 26px; border-radius: 20px;
        background: linear-gradient(115deg, #082744, #123e63); color: white; box-shadow: 0 14px 32px rgba(8,39,68,.14);
    }
    .account-hero::after {
        content: ""; position: absolute; right: -90px; top: -120px; width: 300px; height: 300px;
        border: 1px solid rgba(245,166,35,.25); border-radius: 50%; pointer-events: none;
    }
    .hero-user { position: relative; z-index: 1; display: flex; align-items: center; gap: 20px; min-width: 0; }
    .hero-avatar {
        display: flex; align-items: center; justify-content: center; width: 72px; height: 72px; min-width: 72px;
        border-radius: 50%; background: var(--tw-gold); color: var(--tw-navy); font-family: 'Manrope', sans-serif;
        font-size: 26px; font-weight: 800; letter-spacing: .5px; box-shadow: 0 0 0 5px rgba(245,166,35,.25);
    }
    .hero-eyebrow { margin: 0 0 6px; color: var(--tw-gold); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; }
    .hero-user h1 { margin: 0 0 6px; color: white; font-size: clamp(22px, 2.6vw, 30px); font-weight: 800; line-height: 1.2; }
    .hero-user p { margin: 0; color: #D6E0E9; font-size: 14px; word-break: break-word; }
    .hero-actions { position: relative; z-index: 1; display: flex; flex-wrap: wrap; gap: 12px; }
    .hero-actions form { margin: 0; }

    /* STATS */
    .account-stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; margin-bottom: 26px; }
    .acc-stat {
        display: flex; align-items: center; gap: 16px; padding: 20px; border: 1px solid var(--tw-line);
        border-radius: 16px; background: white; box-shadow: 0 2px 10px rgba(8,39,68,.04);
    }
    .acc-stat--alert { border-color: #F3D28F; background: linear-gradient(180deg, #FFFAF0, #ffffff); }
    .acc-stat-icon {
        display: flex; align-items: center; justify-content: center; width: 46px; height: 46px; min-width: 46px;
        border-radius: 12px; background: #FFF3DC; color: #B87308;
    }
    .acc-stat-label { display: block; color: var(--tw-muted); font-size: 12.5px; font-weight: 600; }
    .acc-stat strong {
        display: block; margin-top: 3px; color: var(--tw-navy); font-family: 'Manrope', sans-serif;
        font-size: 28px; font-weight: 800; line-height: 1.1; font-variant-numeric: tabular-nums;
    }
    .acc-stat--alert strong { color: #B87308; }

    /* MAIN GRID */
    .account-grid {
        display: grid; grid-template-columns: minmax(0, 1fr) 350px;
        grid-template-areas: "tracker notif" "orders notif" "orders help"; gap: 22px; align-items: start;
    }
    .account-grid.no-tracker { grid-template-areas: "orders notif" "orders help"; }
    .area-tracker { grid-area: tracker; }
    .area-notif   { grid-area: notif; }
    .area-orders  { grid-area: orders; }
    .area-help    { grid-area: help; }
    .acc-card {
        min-width: 0; padding: 26px; border: 1px solid var(--tw-line); border-radius: 18px;
        background: white; box-shadow: 0 2px 10px rgba(8,39,68,.04);
    }
    .acc-card-head { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; margin-bottom: 18px; }
    .acc-card-head h2 { margin: 0; color: var(--tw-navy); font-size: 19px; font-weight: 800; }

    /* STATUS BADGE */
    .status {
        display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; border-radius: 999px;
        font-size: 11.5px; font-weight: 800; white-space: nowrap;
    }
    .status::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .status-pending    { background: #FFF1D6; color: #A56800; }
    .status-processing { background: #E1EDFF; color: #2456A6; }
    .status-shipped    { background: #E8E1FF; color: #6743A5; }
    .status-completed  { background: #DDF5E6; color: #237344; }
    .status-cancelled  { background: #FFE2E2; color: #B42318; }
    .status-other      { background: #EEF1F4; color: #5B6775; }

    /* ACTIVE ORDER TRACKER */
    .tracker-card { border-top: 4px solid var(--tw-gold); }
    .tracker-head { display: flex; align-items: center; justify-content: space-between; gap: 14px; margin-bottom: 26px; }
    .tracker-order { display: flex; align-items: center; gap: 14px; min-width: 0; }
    .tracker-thumb { width: 56px; height: 56px; min-width: 56px; padding: 4px; border-radius: 12px; object-fit: contain; background: #ECE9E1; }
    .tracker-eyebrow { display: block; margin-bottom: 4px; color: var(--tw-orange); font-size: 11px; font-weight: 800; letter-spacing: 1.2px; text-transform: uppercase; }
    .tracker-order h2 { margin: 0; color: var(--tw-navy); font-size: 17px; font-weight: 800; line-height: 1.3; }
    .tracker-order p { margin: 3px 0 0; color: var(--tw-muted); font-size: 12.5px; }
    
    .tracker-steps { display: grid; grid-template-columns: repeat(4, 1fr); position: relative; margin-bottom: 10px; }
    .tracker-steps::before {
        content: ""; position: absolute; top: 19px; left: 12.5%; right: 12.5%; height: 3px; background: #E6E0D3; z-index: 0;
    }
    .t-step { position: relative; z-index: 1; text-align: center; }
    .t-step.is-done::after {
        content: ""; position: absolute; top: 19px; left: -50%; width: 100%; height: 3px; background: var(--tw-navy);
    }
    .t-step:first-child.is-done::after { left: 50%; width: 50%; }
    .t-dot {
        display: flex; align-items: center; justify-content: center; width: 40px; height: 40px; margin: 0 auto 10px;
        border: 2px solid #E6E0D3; border-radius: 50%; background: white; color: #B7B0A1;
    }
    .t-step.is-done .t-dot { border-color: var(--tw-navy); background: var(--tw-navy); color: white; }
    .t-step.is-current .t-dot {
        border-color: var(--tw-gold); background: var(--tw-gold); color: var(--tw-navy);
        box-shadow: 0 0 0 5px rgba(245,166,35,.25); animation: trackerPulse 2s ease-in-out infinite;
    }
    .t-label { display: block; color: var(--tw-muted); font-size: 12px; font-weight: 700; }
    .t-step.is-done .t-label, .t-step.is-current .t-label { color: var(--tw-navy); }
    @keyframes trackerPulse { 0%, 100% { box-shadow: 0 0 0 5px rgba(245,166,35,.25); } 50% { box-shadow: 0 0 0 9px rgba(245,166,35,.08); } }

    .tracker-note {
        margin: 24px 0 0; padding: 14px 16px; border-radius: 12px; background: #FFF9F0;
        color: var(--tw-text); font-size: 13.5px; line-height: 1.7;
    }
    .tracker-foot { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }

    /* ORDER HISTORY */
    .order-tabs { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 18px; }
    .order-tab {
        display: inline-flex; align-items: center; gap: 7px; padding: 8px 14px; border: 1.5px solid #E3DDCF;
        border-radius: 999px; background: white; color: var(--tw-muted); font-family: 'Inter', sans-serif;
        font-size: 12.5px; font-weight: 700; cursor: pointer; transition: all .25s var(--tw-ease);
    }
    .order-tab small {
        min-width: 20px; padding: 2px 6px; border-radius: 999px; background: #F1EDE3; color: var(--tw-navy); font-size: 11px; font-weight: 800; text-align: center;
    }
    .order-tab.active { border-color: var(--tw-navy); background: var(--tw-navy); color: white; }
    .order-tab.active small { background: rgba(255,255,255,.18); color: white; }
    @media (hover: hover) { .order-tab:not(.active):hover { border-color: var(--tw-gold); color: var(--tw-navy); } }

    .order-list { display: flex; flex-direction: column; gap: 12px; }
    .order-card {
        display: grid; grid-template-columns: 72px minmax(0, 1fr) auto; align-items: center; gap: 16px;
        padding: 16px; border: 1px solid #EEEAE2; border-radius: 14px; background: white;
        transition: border-color .3s var(--tw-ease), box-shadow .3s var(--tw-ease);
    }
    .order-card[hidden], .orders-filter-empty[hidden] { display: none; }
    @media (hover: hover) { .order-card:hover { border-color: #E5C88F; box-shadow: 0 8px 20px rgba(8,39,68,.06); } }
    .order-thumb { width: 72px; height: 72px; padding: 6px; border-radius: 12px; object-fit: contain; background: #ECE9E1; }
    .order-top { display: flex; align-items: center; flex-wrap: wrap; gap: 8px 10px; margin-bottom: 6px; }
    .order-number { color: var(--tw-navy); font-size: 13px; font-weight: 800; }
    .order-product { margin: 0 0 4px; color: var(--tw-navy); font-size: 15px; font-weight: 800; line-height: 1.35; }
    .order-meta { margin: 0; color: var(--tw-muted); font-size: 12.5px; }
    .order-progress { display: grid; grid-template-columns: repeat(4, 1fr); gap: 4px; max-width: 220px; margin-top: 12px; }
    .op-seg { height: 4px; border-radius: 4px; background: #E9E4D8; }
    .op-seg.on { background: var(--tw-gold); }
    .order-side { display: flex; flex-direction: column; align-items: flex-end; gap: 12px; }
    .order-total { color: var(--tw-navy); font-family: 'Manrope', sans-serif; font-size: 16px; font-weight: 800; white-space: nowrap; }
    .order-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 8px; }
    .orders-filter-empty, .empty-orders { padding: 36px 20px; border-radius: 14px; background: #F7F5EF; color: var(--tw-muted); font-size: 14px; text-align: center; }
    .empty-orders { padding: 56px 20px; background: transparent; }
    .empty-orders .empty-icon {
        display: flex; align-items: center; justify-content: center; width: 76px; height: 76px; margin: 0 auto 18px;
        border-radius: 50%; background: #FFF3DC; color: #B87308;
    }
    .empty-orders h3 { margin: 0 0 8px; color: var(--tw-navy); font-size: 19px; font-weight: 800; }
    .empty-orders p { margin: 0 auto 22px; max-width: 380px; line-height: 1.7; }
    .pagination-wrapper { margin-top: 22px; }
    .pagination-wrapper svg { display: inline-block; width: 20px; height: 20px; }

    /* NOTIFICATIONS */
    .notif-count { padding: 6px 12px; border-radius: 999px; background: var(--tw-gold); color: var(--tw-navy); font-size: 11.5px; font-weight: 800; }
    .notif-count.is-clear { background: #E7F4EC; color: #237344; }
    .notif-item {
        position: relative; display: flex; align-items: flex-start; gap: 13px; padding: 14px; margin-bottom: 10px;
        border: 1px solid #EEEAE2; border-radius: 12px; background: white; transition: border-color .25s var(--tw-ease);
    }
    .notif-item:last-child { margin-bottom: 0; }
    .notif-item.unread { border-color: #F5D99F; background: #FFF9ED; }
    .notif-item.unread::after {
        content: ""; position: absolute; top: 14px; right: 14px; width: 8px; height: 8px; border-radius: 50%; background: #E53935;
    }
    .notif-icon {
        display: flex; align-items: center; justify-content: center; width: 38px; height: 38px; min-width: 38px;
        border-radius: 50%; background: #EEF1F4; color: #5B6775;
    }
    .notif-item.unread .notif-icon { background: var(--tw-navy); color: var(--tw-gold); }
    .notif-body { flex: 1; min-width: 0; padding-right: 12px; }
    .notif-body p { margin: 0 0 6px; color: var(--tw-text); font-size: 13.5px; line-height: 1.6; }
    .notif-body small { color: var(--tw-muted); font-size: 12px; }
    .notif-body form { margin: 8px 0 0; }
    .notif-link {
        padding: 0; border: 0; background: none; color: var(--tw-orange); font-family: 'Inter', sans-serif;
        font-size: 12px; font-weight: 800; cursor: pointer; transition: color .2s ease;
    }
    .notif-link:hover { color: var(--tw-navy); }
    .notif-empty {
        padding: 34px 16px; border-radius: 12px; background: #F7F5EF; color: var(--tw-muted);
        font-size: 13.5px; line-height: 1.7; text-align: center;
    }
    .notif-empty .acc-ic { margin: 0 auto 10px; color: #B7B0A1; }

    /* HELP */
    .help-card {
        position: relative; overflow: hidden; padding: 26px; border-radius: 18px;
        background: linear-gradient(135deg, #082744, #0F3558); color: white;
    }
    .help-card::after {
        content: ""; position: absolute; right: -60px; bottom: -80px; width: 200px; height: 200px;
        border: 1px solid rgba(245,166,35,.25); border-radius: 50%; pointer-events: none;
    }
    .help-card > * { position: relative; z-index: 1; }
    .help-icon {
        display: flex; align-items: center; justify-content: center; width: 44px; height: 44px; margin-bottom: 14px;
        border-radius: 12px; background: rgba(245,166,35,.18); color: var(--tw-gold);
    }
    .help-card h2 { margin: 0 0 8px; color: white; font-size: 18px; font-weight: 800; }
    .help-card p { margin: 0 0 18px; color: #D6E0E9; font-size: 13.5px; line-height: 1.7; }

    /* RECOMMENDATIONS */
    .suggest-section { margin-top: 40px; }
    .suggest-head { display: flex; align-items: flex-end; justify-content: space-between; gap: 14px; margin-bottom: 18px; }
    .suggest-head h2 { margin: 0; color: var(--tw-navy); font-size: 21px; font-weight: 800; }
    .suggest-head a { color: var(--tw-orange); font-size: 13px; font-weight: 800; white-space: nowrap; transition: color .25s ease; }
    .suggest-head a:hover { color: var(--tw-navy); }
    .suggest-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    .suggest-card {
        position: relative; overflow: hidden; border-radius: 14px; background: white;
        box-shadow: 0 3px 12px rgba(8,39,68,.07); transition: transform .35s var(--tw-ease), box-shadow .35s var(--tw-ease);
    }
    .suggest-card:active { transform: scale(.985); }
    @media (hover: hover) { .suggest-card:hover { transform: translateY(-5px); box-shadow: 0 12px 26px rgba(8,39,68,.12); } }
    .suggest-image { height: 160px; background: #ECE9E1; }
    .suggest-image img { width: 100%; height: 100%; padding: 8px; object-fit: contain; }
    .suggest-info { padding: 14px 16px 16px; }
    .suggest-info a { display: block; color: var(--tw-navy); font-size: 14px; font-weight: 800; line-height: 1.4; }
    .suggest-info a::before { content: ""; position: absolute; inset: 0; }
    .suggest-price { margin-top: 6px; color: var(--tw-text); font-size: 13px; font-weight: 700; }

    /* RESPONSIVE */
    @media (max-width: 1000px) {
        .account-grid, .account-grid.no-tracker { grid-template-columns: minmax(0, 1fr); }
        .account-grid { grid-template-areas: "tracker" "notif" "orders" "help"; }
        .account-grid.no-tracker { grid-template-areas: "notif" "orders" "help"; }
        .suggest-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }
    @media (max-width: 700px) {
        .account-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 10px; }
        .acc-stat { gap: 12px; padding: 15px; }
        .acc-stat-icon { width: 38px; height: 38px; min-width: 38px; }
        .acc-stat strong { font-size: 23px; }
        .order-card { grid-template-columns: 60px minmax(0, 1fr); gap: 12px 14px; }
        .order-thumb { width: 60px; height: 60px; }
        .order-side { grid-column: 1 / -1; flex-direction: row; align-items: center; justify-content: space-between; flex-wrap: wrap; padding-top: 12px; border-top: 1px dashed #E9E4D8; }
    }
    @media (max-width: 550px) {
        .account-page { padding: 28px 5% 70px; }
        .account-hero { padding: 24px 20px; border-radius: 18px; }
        .hero-user { gap: 14px; }
        .hero-avatar { width: 58px; height: 58px; min-width: 58px; font-size: 21px; }
        .hero-user p { font-size: 12.5px; }
        .hero-actions { width: 100%; }
        .hero-actions > *, .hero-actions form { flex: 1; }
        .hero-actions .acc-btn { width: 100%; padding: 12px 14px; }
        .acc-card, .help-card { padding: 20px 18px; }
        .tracker-head { flex-direction: column; align-items: flex-start; }
        .t-label { font-size: 11px; }
        .t-dot { width: 34px; height: 34px; }
        .t-step::before { top: 16px; }
        .tracker-foot .acc-btn { flex: 1; }
        .order-actions { width: 100%; justify-content: stretch; }
        .order-actions .acc-btn { flex: 1; }
        .order-side { align-items: flex-start; }
        .suggest-grid { gap: 12px; }
        .suggest-image { height: 130px; }
        .suggest-info { padding: 12px; }
        .suggest-info a { font-size: 13px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .t-step.is-current .t-dot { animation: none; }
        .suggest-card, .acc-btn { transition: none; }
    }
</style>

<div class="account-page">
    <div class="account-container">

        {{-- SYSTEM ALERTS --}}
        @if(session('success'))
            <div class="account-alert success" role="status">
                {!! $icon('done', 20) !!}
                <span>{{ session('success') }}</span>
                <button type="button" data-dismiss aria-label="{{ t3('Tutup', 'Close', '关闭') }}">{!! $icon('x', 16) !!}</button>
            </div>
        @endif

        @if(session('error'))
            <div class="account-alert error" role="alert">
                {!! $icon('alert', 20) !!}
                <span>{{ session('error') }}</span>
                <button type="button" data-dismiss aria-label="{{ t3('Tutup', 'Close', '关闭') }}">{!! $icon('x', 16) !!}</button>
            </div>
        @endif

        {{-- HERO PROFILE --}}
        <section class="account-hero">
            <div class="hero-user">
                <div class="hero-avatar" aria-hidden="true">{{ $initials }}</div>
                <div>
                    <p class="hero-eyebrow">
                        {{ t3('Dasbor Pelanggan', 'Customer Dashboard', '客户中心') }}
                        @if($memberSince) · {{ t3('Anggota sejak', 'Member since', '加入时间') }} {{ $memberSince }} @endif
                    </p>
                    <h1>{{ t3('Selamat datang kembali, ' . $firstName . '!', 'Welcome back, ' . $firstName . '!', '欢迎回来，' . $firstName . '！') }}</h1>
                    <p>{{ $user->email }}</p>
                </div>
            </div>
            <div class="hero-actions">
                <a href="{{ route('catalog.index') }}" class="acc-btn acc-btn--gold">
                    {{ t3('Jelajahi Katalog', 'Explore Catalog', '浏览目录') }} {!! $icon('arrow', 16) !!}
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="acc-btn acc-btn--ghost">
                        {!! $icon('logout', 16) !!} {{ t3('Keluar', 'Sign Out', '退出登录') }}
                    </button>
                </form>
            </div>
        </section>

        {{-- ORDER STATS --}}
        <section class="account-stats">
            <div class="acc-stat">
                <span class="acc-stat-icon">{!! $icon('bag', 22) !!}</span>
                <div>
                    <span class="acc-stat-label">{{ t3('Total Pesanan', 'Total Orders', '订单总数') }}</span>
                    <strong>{{ $stats['total'] ?? 0 }}</strong>
                </div>
            </div>
            <div class="acc-stat {{ ($stats['pending'] ?? 0) > 0 ? 'acc-stat--alert' : '' }}">
                <span class="acc-stat-icon">{!! $icon('clock', 22) !!}</span>
                <div>
                    <span class="acc-stat-label">{{ t3('Menunggu', 'Pending', '待处理') }}</span>
                    <strong>{{ $stats['pending'] ?? 0 }}</strong>
                </div>
            </div>
            <div class="acc-stat">
                <span class="acc-stat-icon">{!! $icon('progress', 22) !!}</span>
                <div>
                    <span class="acc-stat-label">{{ t3('Diproses', 'Processing', '处理中') }}</span>
                    <strong>{{ $stats['processing'] ?? 0 }}</strong>
                </div>
            </div>
            <div class="acc-stat">
                <span class="acc-stat-icon">{!! $icon('done', 22) !!}</span>
                <div>
                    <span class="acc-stat-label">{{ t3('Selesai', 'Completed', '已完成') }}</span>
                    <strong>{{ $stats['completed'] ?? 0 }}</strong>
                </div>
            </div>
        </section>

        <div class="account-grid {{ $activeOrder ? '' : 'no-tracker' }}">

            {{-- ACTIVE ORDER TRACKER --}}
            @if($activeOrder)
                @php
                    $activeKey  = $normalizeStatus($activeOrder->status);
                    $activeStep = $stepIndex[$activeKey] ?? 1;
                    $trackSteps = [
                        1 => [$statusLabels['pending'], 'clock'],
                        2 => [$statusLabels['processing'], 'progress'],
                        3 => [$statusLabels['shipped'], 'truck'],
                        4 => [$statusLabels['completed'], 'done'],
                    ];
                @endphp

                <section class="acc-card tracker-card area-tracker">
                    <div class="tracker-head">
                        <div class="tracker-order">
                            <img class="tracker-thumb" src="{{ $orderImage($activeOrder) }}" alt="" width="56" height="56">
                            <div>
                                <span class="tracker-eyebrow">{{ t3('Pesanan Aktif', 'Active Order', '当前订单') }}</span>
                                <h2>{{ $activeOrder->product->name ?? t3('Produk Tidak Tersedia', 'Product Unavailable', '产品已下架') }}</h2>
                                <p>{{ t3('No.', 'No.', '编号') }} {{ $activeOrder->order_number }}</p>
                            </div>
                        </div>
                        <span class="status {{ $statusClass($activeKey) }}">{{ $statusLabel($activeKey) }}</span>
                    </div>

                    <div class="tracker-steps">
                        @foreach($trackSteps as $number => $step)
                            <div class="t-step {{ $number < $activeStep ? 'is-done' : ($number === $activeStep ? 'is-current' : '') }}">
                                <span class="t-dot">
                                    @if($number < $activeStep) {!! $icon('check', 18) !!}
                                    @else {!! $icon($step[1], 18) !!}
                                    @endif
                                </span>
                                <span class="t-label">{{ $step[0] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <p class="tracker-note">
                        {{ $statusNotes[$activeKey] ?? t3('Pantau perkembangan pesanan Anda di halaman detail.', 'Track your order progress on the details page.', '请在详情页查看订单进度。') }}
                    </p>

                    <div class="tracker-foot">
                        <a href="{{ route('account.orders.show', $activeOrder->id) }}" class="acc-btn acc-btn--navy acc-btn--sm">
                            {{ t3('Lihat Detail', 'View Details', '查看详情') }} {!! $icon('arrow', 15) !!}
                        </a>
                        <a href="{{ $waOrderUrl($activeOrder->order_number) }}" class="acc-btn acc-btn--outline acc-btn--sm" target="_blank" rel="noopener">
                            {!! $icon('wa', 15) !!} {{ t3('Tanya via WhatsApp', 'Inquire via WhatsApp', '通过 WhatsApp 咨询') }}
                        </a>
                    </div>
                </section>
            @endif

            {{-- ORDER NOTIFICATIONS --}}
            <section class="acc-card area-notif" id="notifications">
                <div class="acc-card-head">
                    <h2>{{ t3('Notifikasi Pesanan', 'Order Notifications', '订单通知') }}</h2>
                    @if($unreadCount > 0)
                        <span class="notif-count">{{ $unreadCount }} {{ t3('Belum Dibaca', 'Unread', '未读') }}</span>
                    @else
                        <span class="notif-count is-clear">{{ t3('Semua Dibaca', 'All Read', '全部已读') }}</span>
                    @endif
                </div>

                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <div class="notif-item {{ $notification->read_at ? '' : 'unread' }}">
                            <span class="notif-icon">{!! $icon('bell', 18) !!}</span>
                            <div class="notif-body">
                                <p>{{ $notification->data['message'] ?? t3('Ada pembaruan terkait pesanan Anda.', 'There is an update regarding your order.', '您的订单有更新。') }}</p>
                                <small title="{{ $notification->created_at->format('M d, Y H:i') }}">
                                    {{ $notification->created_at->locale($dateLocale)->diffForHumans() }}
                                </small>
                                @if(!empty($notification->data['order_id']))
                                    <form action="{{ route('account.notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="notif-link">{{ t3('Lihat Detail Pesanan', 'View Order Details', '查看订单详情') }} →</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="notif-empty">
                        {!! $icon('bell', 30) !!}
                        {{ t3('Belum ada notifikasi.', 'No notifications yet.', '暂无通知。') }}<br>
                        {{ t3('Pembaruan status pesanan akan muncul di sini.', 'Order status updates will appear here.', '订单状态更新将显示在此处。') }}
                    </div>
                @endif
            </section>

            {{-- ORDER HISTORY --}}
            <section class="acc-card area-orders" id="orders">
                <div class="acc-card-head">
                    <h2>{{ t3('Riwayat Pesanan Saya', 'My Order History', '我的订单记录') }}</h2>
                </div>

                @if($orders->count() > 0)
                    @if($statusCounts->count() > 1)
                        <div class="order-tabs" role="group" aria-label="{{ t3('Filter status pesanan', 'Filter order status', '按订单状态筛选') }}">
                            <button type="button" class="order-tab active" data-filter="all" aria-pressed="true">
                                {{ t3('Semua', 'All', '全部') }} <small>{{ $orderItems->count() }}</small>
                            </button>
                            @foreach(array_keys($statusLabels) as $statusKey)
                                @if(($statusCounts[$statusKey] ?? 0) > 0)
                                    <button type="button" class="order-tab" data-filter="{{ $statusKey }}" aria-pressed="false">
                                        {{ $statusLabels[$statusKey] }} <small>{{ $statusCounts[$statusKey] }}</small>
                                    </button>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="order-list">
                        @foreach($orderItems as $order)
                            @php
                                $key  = $normalizeStatus($order->status);
                                $step = $stepIndex[$key] ?? 0;
                            @endphp
                            <article class="order-card" data-status="{{ $key }}">
                                <img class="order-thumb" src="{{ $orderImage($order) }}" alt="" width="72" height="72" loading="lazy" decoding="async">
                                <div class="order-main">
                                    <div class="order-top">
                                        <span class="order-number">{{ $order->order_number }}</span>
                                        <span class="status {{ $statusClass($key) }}">{{ $statusLabel($key) }}</span>
                                    </div>
                                    <h3 class="order-product">{{ $order->product->name ?? t3('Produk Tidak Tersedia', 'Product Unavailable', '产品已下架') }}</h3>
                                    <p class="order-meta">{{ $order->quantity }} {{ t3('item', 'item(s)', '件') }} · {{ $order->created_at->locale($dateLocale)->translatedFormat('d M Y') }}</p>
                                    @if($step > 0)
                                        <div class="order-progress" aria-hidden="true">
                                            @for($i = 1; $i <= 4; $i++)
                                                <span class="op-seg {{ $i <= $step ? 'on' : '' }}"></span>
                                            @endfor
                                        </div>
                                    @endif
                                </div>
                                <div class="order-side">
                                    <div class="order-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                                    <div class="order-actions">
                                        <a href="{{ route('account.orders.show', $order->id) }}" class="acc-btn acc-btn--navy acc-btn--sm">{{ t3('Detail', 'Details', '详情') }}</a>
                                        <a href="{{ $waOrderUrl($order->order_number) }}" class="acc-btn acc-btn--outline acc-btn--sm" target="_blank" rel="noopener" aria-label="{{ t3('Tanya pesanan ' . $order->order_number . ' via WhatsApp', 'Inquire about order ' . $order->order_number . ' via WhatsApp', '通过 WhatsApp 咨询订单 ' . $order->order_number) }}">
                                            {!! $icon('wa', 14) !!} {{ t3('Tanya', 'Inquire', '咨询') }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                        <div class="orders-filter-empty" id="ordersFilterEmpty" hidden>
                            {{ t3('Tidak ada pesanan dengan status ini di halaman ini.', 'No orders with this status found on this page.', '本页没有该状态的订单。') }}
                        </div>
                    </div>

                    @if(method_exists($orders, 'hasPages') && $orders->hasPages())
                        <div class="pagination-wrapper">{{ $orders->links() }}</div>
                    @endif
                @else
                    <div class="empty-orders">
                        <div class="empty-icon">{!! $icon('bag', 32) !!}</div>
                        <h3>{{ t3('Belum Ada Pesanan', 'No Orders Yet', '暂无订单') }}</h3>
                        <p>{{ t3('Pesanan yang Anda buat akan muncul di sini beserta status prosesnya.', 'Orders you place will appear here, complete with their processing status.', '您下的订单及其处理状态将显示在此处。') }}</p>
                        <a href="{{ route('catalog.index') }}" class="acc-btn acc-btn--gold">{{ t3('Jelajahi Katalog', 'Explore Catalog', '浏览目录') }} {!! $icon('arrow', 16) !!}</a>
                    </div>
                @endif
            </section>

            {{-- HELP & SUPPORT --}}
            <aside class="help-card area-help">
                <div class="help-icon">{!! $icon('support', 22) !!}</div>
                <h2>{{ t3('Butuh Bantuan?', 'Need Assistance?', '需要帮助？') }}</h2>
                <p>{{ t3('Tim TERRAWOOD siap membantu pertanyaan Anda seputar pesanan, pengiriman, atau produk custom.', 'The TERRAWOOD team is ready to assist you with any questions regarding orders, shipping, or custom products.', 'TERRAWOOD 团队随时为您解答有关订单、配送或定制产品的任何问题。') }}</p>
                
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="{{ $waHelpUrl }}" class="acc-btn acc-btn--wa" target="_blank" rel="noopener">
                        {!! $icon('wa', 16) !!} {{ t3('Chat via WhatsApp', 'Chat via WhatsApp', '通过 WhatsApp 聊天') }}
                    </a>
                    <a href="mailto:{{ $contactEmail }}?subject=Customer%20Support%20Inquiry" class="acc-btn acc-btn--ghost" style="border-color: rgba(255,255,255,0.3);">
                        {!! $icon('mail', 16) !!} {{ $contactEmail }}
                    </a>
                </div>
            </aside>

        </div>

        {{-- PRODUCT RECOMMENDATIONS --}}
        @if($suggestions->isNotEmpty())
            <section class="suggest-section">
                <div class="suggest-head">
                    <h2>{{ t3('Mungkin Anda Juga Suka', 'You Might Also Like', '您可能还喜欢') }}</h2>
                    <a href="{{ route('catalog.index') }}">{{ t3('Lihat Katalog', 'View Catalog', '查看目录') }} →</a>
                </div>
                <div class="suggest-grid">
                    @foreach($suggestions as $product)
                        <div class="suggest-card">
                            <div class="suggest-image">
                                <img src="{{ $product->image ? asset('storage/' . ltrim($product->image, '/')) : $fallbackImage }}" alt="{{ $product->localized('name') ?? t3('Produk', 'Product', '产品') }}" width="400" height="300" loading="lazy" decoding="async">
                            </div>
                            <div class="suggest-info">
                                <a href="{{ route('catalog.show', $product->slug) }}">{{ $product->localized('name') ?? t3('Produk TERRAWOOD', 'TERRAWOOD Product', 'TERRAWOOD 产品') }}</a>
                                <div class="suggest-price">
                                    @if(!empty($product->discount_price) && (float) $product->discount_price > 0 && (float) $product->discount_price < (float) $product->price)
                                        <span style="display:block;text-decoration:line-through;color:#8893a0;font-size:12px;">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                        <span style="color:#B47A13;">Rp {{ number_format((float) $product->discount_price, 0, ',', '.') }}</span>
                                    @elseif(!empty($product->price))
                                        Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                    @else
                                        {{ t3('Hubungi Kami', 'Contact Us', '联系我们') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>

@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {
    /* Close success / error alerts */
    document.querySelectorAll('[data-dismiss]').forEach(function (button) {
        button.addEventListener('click', function () {
            const alertBox = button.closest('.account-alert');
            if (alertBox) alertBox.remove();
        });
    });

    /* Filter order status */
    const tabs = document.querySelectorAll('.order-tab');
    const cards = document.querySelectorAll('.order-card');
    const emptyMessage = document.getElementById('ordersFilterEmpty');

    if (!tabs.length) return;

    function applyFilter(filter) {
        let visible = 0;
        cards.forEach(function (card) {
            const show = filter === 'all' || card.dataset.status === filter;
            card.hidden = !show;
            if (show) visible++;
        });

        tabs.forEach(function (tab) {
            const isActive = tab.dataset.filter === filter;
            tab.classList.toggle('active', isActive);
            tab.setAttribute('aria-pressed', isActive ? 'true' : 'false');
        });

        if (emptyMessage) {
            emptyMessage.hidden = visible !== 0;
        }
    }

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            applyFilter(tab.dataset.filter);
        });
    });
});
</script>
@endsection