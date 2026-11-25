@extends('layouts.app')

@section('content')

@php
    /* ---------- Ikon SVG ---------- */
    $ic = [
        'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
        'orders'    => '<circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>',
        'products'  => '<path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/>',
        'categories'=> '<path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"/><path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"/><path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"/>',
        'services'  => '<path d="m12 3-1.9 5.8a2 2 0 0 1-1.29 1.29L3 12l5.8 1.9a2 2 0 0 1 1.29 1.29L12 21l1.9-5.8a2 2 0 0 1 1.29-1.29L21 12l-5.8-1.9a2 2 0 0 1-1.29-1.29Z"/>',
        'articles'  => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'portfolios'=> '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
        'partners'  => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'star'      => '<polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>',
        'clock'     => '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>',
        'progress'  => '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
        'done'      => '<path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>',
        'plus'      => '<path d="M5 12h14"/><path d="M12 5v14"/>',
        'home'      => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'menu'      => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
        'logout'    => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>',
        'arrow'     => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'mail'      => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'sales'     => '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
    ];

    $icon = function ($name, $size = 20) use ($ic) {
        return '<svg class="ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    /* ---------- Sapaan & identitas admin ---------- */
    $now       = now()->timezone('Asia/Jakarta');
    $hour      = (int) $now->format('H');
    $greeting  = $hour < 11 ? 'Selamat pagi' : ($hour < 15 ? 'Selamat siang' : ($hour < 18 ? 'Selamat sore' : 'Selamat malam'));
    $today     = $now->locale('id')->translatedFormat('l, d F Y');
    $adminName = auth()->user()?->name ?? 'Administrator';
    $adminInit = mb_strtoupper(mb_substr($adminName, 0, 1));

    /* ---------- Status pesanan ---------- */
    $statusMap = [
        'menunggu'   => ['Menunggu', 'pending'],
        'diproses'   => ['Diproses', 'processing'],
        'dikirim'    => ['Dikirim', 'shipped'],
        'selesai'    => ['Selesai', 'completed'],
        'dibatalkan' => ['Dibatalkan', 'cancelled'],

        /* Cadangan jika status tersimpan dalam bahasa Inggris */
        'pending'    => ['Menunggu', 'pending'],
        'processing' => ['Diproses', 'processing'],
        'shipped'    => ['Dikirim', 'shipped'],
        'completed'  => ['Selesai', 'completed'],
        'cancelled'  => ['Dibatalkan', 'cancelled'],
    ];

    $pendingOrders = (int) ($stats['pending_orders'] ?? 0);
@endphp

<style>
    :root {
        --navy: #082744; --navy-dark: #061D33; --gold: #F5A623; --ivory: #F7F5EF;
        --text: #293747; --muted: #7a8696; --line: #ece7dc; --amber: #b87308;
        --ease: cubic-bezier(.22, .61, .36, 1);
    }

    .admin-dashboard,
    .admin-dashboard *,
    .admin-dashboard *::before,
    .admin-dashboard *::after { box-sizing: border-box; }

    .admin-dashboard { min-height: 100vh; display: flex; background: var(--ivory); color: var(--text); font-family: 'Inter', sans-serif; }
    .admin-dashboard h1, .admin-dashboard h2, .admin-dashboard h3, .admin-dashboard h4 { font-family: 'Manrope', 'Inter', sans-serif; }
    .admin-dashboard a { text-decoration: none; }
    .admin-dashboard a:focus-visible, .admin-dashboard button:focus-visible { outline: 2px solid var(--gold); outline-offset: 2px; }
    .ic { display: block; flex-shrink: 0; }
    body.drawer-open { overflow: hidden; }

    /* ===== SIDEBAR ===== */
    .admin-sidebar { position: sticky; top: 0; width: 260px; min-width: 260px; height: 100vh; overflow-y: auto; background: var(--navy-dark); color: white; padding: 26px 16px; display: flex; flex-direction: column; z-index: 60; }
    .sidebar-brand { padding: 0 12px 24px; border-bottom: 1px solid rgba(255,255,255,.1); margin-bottom: 22px; }
    .sidebar-brand h2 { font-size: 22px; font-weight: 800; letter-spacing: 2px; color: white; margin: 0; }
    .sidebar-brand span { display: block; margin-top: 4px; color: var(--gold); font-size: 11px; letter-spacing: 2.5px; font-weight: 700; }
    .sidebar-label { color: #7f93a8; font-size: 11px; font-weight: 800; letter-spacing: 1.8px; padding: 0 13px; margin-bottom: 10px; }
    .sidebar-label + .sidebar-menu { margin-bottom: 22px; }
    .sidebar-menu { display: flex; flex-direction: column; gap: 4px; }

    .sidebar-menu a, .sidebar-bottom a, .sidebar-bottom button {
        position: relative; display: flex; align-items: center; gap: 12px; color: #b9c6d3;
        padding: 12px 13px; border-radius: 10px; font-size: 14px; font-weight: 600;
        transition: background-color .25s var(--ease), color .25s var(--ease);
    }
    .sidebar-menu a:hover, .sidebar-bottom a:hover, .sidebar-bottom button:hover { background: rgba(255,255,255,.06); color: white; }
    .sidebar-menu a.active { background: rgba(245,166,35,.14); color: var(--gold); }
    .sidebar-menu a.active::before { content: ""; position: absolute; left: -16px; top: 10px; bottom: 10px; width: 3px; border-radius: 0 3px 3px 0; background: var(--gold); }

    .menu-badge { margin-left: auto; min-width: 22px; height: 22px; padding: 0 7px; border-radius: 11px; background: var(--gold); color: var(--navy); font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; }

    .sidebar-bottom button { width: 100%; border: 0; background: transparent; font-family: 'Inter', sans-serif; text-align: left; cursor: pointer; }
    .sidebar-bottom form { margin: 0; }
    .sidebar-bottom { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.1); }

    .sidebar-overlay { position: fixed; inset: 0; background: rgba(6,29,51,.55); opacity: 0; visibility: hidden; transition: opacity .3s var(--ease), visibility .3s var(--ease); z-index: 55; }
    .sidebar-overlay.show { opacity: 1; visibility: visible; }

    /* ===== MAIN ===== */
    .admin-main { flex: 1; min-width: 0; padding: 30px 36px 24px; }
    .topbar { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 26px; }
    .topbar-left { display: flex; align-items: center; gap: 14px; min-width: 0; }

    .menu-toggle { display: none; width: 42px; height: 42px; border: 1px solid var(--line); border-radius: 10px; background: white; color: var(--navy); cursor: pointer; align-items: center; justify-content: center; flex-shrink: 0; -webkit-tap-highlight-color: transparent; transition: background-color .25s var(--ease); }
    .menu-toggle:active { background: #f3efe5; }

    .topbar-title h1 { color: var(--navy); font-size: 28px; font-weight: 800; margin: 0 0 4px; }
    .topbar-title p { color: var(--muted); font-size: 14px; margin: 0; }

    .admin-profile { display: flex; align-items: center; gap: 11px; background: white; padding: 9px 15px 9px 10px; border: 1px solid var(--line); border-radius: 999px; box-shadow: 0 2px 10px rgba(8,39,68,.04); flex-shrink: 0; }
    .profile-avatar { width: 38px; height: 38px; background: var(--navy); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-family: 'Manrope', sans-serif; font-weight: 800; font-size: 15px; }
    .profile-info strong { display: block; color: var(--navy); font-size: 13.5px; line-height: 1.3; }
    .profile-info span { color: var(--muted); font-size: 12px; }

    /* ===== WELCOME ===== */
    .welcome-banner { position: relative; overflow: hidden; background: linear-gradient(115deg, #082744, #123e63); color: white; padding: 30px 32px; border-radius: 16px; display: flex; justify-content: space-between; align-items: center; gap: 20px; }
    .welcome-banner::after { content: ""; position: absolute; width: 260px; height: 260px; border: 1px solid rgba(245,166,35,.25); border-radius: 50%; right: -80px; top: -110px; pointer-events: none; }
    .welcome-banner > div { position: relative; z-index: 1; }
    .welcome-date { color: var(--gold); font-size: 12px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px; }
    .welcome-banner h2 { font-size: 23px; font-weight: 800; margin: 0 0 8px; }
    .welcome-banner p { font-size: 14px; color: #d1dce7; margin: 0; line-height: 1.7; }

    .banner-cta { display: inline-flex; align-items: center; gap: 10px; background: var(--gold); color: var(--navy); padding: 13px 20px; border-radius: 999px; font-size: 13px; font-weight: 800; white-space: nowrap; box-shadow: 0 8px 20px rgba(245,166,35,.3); -webkit-tap-highlight-color: transparent; transition: background-color .3s var(--ease), color .3s var(--ease), transform .3s var(--ease); }
    .banner-cta .ic { transition: transform .3s var(--ease); }
    @media (hover: hover) {
        .banner-cta:hover { background: white; transform: translateY(-2px); }
        .banner-cta:hover .ic { transform: translateX(3px); }
    }
    .banner-cta:active { transform: scale(.97); transition-duration: .12s; }
    .banner-ok { display: inline-flex; align-items: center; gap: 9px; padding: 12px 18px; border: 1px solid rgba(255,255,255,.22); border-radius: 999px; color: #d1dce7; font-size: 13px; font-weight: 600; white-space: nowrap; }

    /* ===== SECTION ===== */
    .section-heading { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; margin: 30px 0 16px; }
    .section-heading h3 { color: var(--navy); font-size: 19px; font-weight: 800; margin: 0; }
    .section-heading span { color: var(--muted); font-size: 13px; }

    /* ===== STATISTIK ===== */
    .stats-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 16px; }
    .stats-grid.compact { grid-template-columns: repeat(auto-fill, minmax(210px, 1fr)); gap: 12px; }

    .stat-card { display: block; position: relative; background: white; border-radius: 14px; padding: 20px; border: 1px solid var(--line); box-shadow: 0 2px 10px rgba(8,39,68,.04); -webkit-tap-highlight-color: transparent; transition: transform .3s var(--ease), border-color .3s var(--ease), box-shadow .3s var(--ease); }
    @media (hover: hover) {
        .stat-card:hover { transform: translateY(-3px); border-color: var(--gold); box-shadow: 0 10px 24px rgba(8,39,68,.09); }
        .stat-card:hover .stat-link .ic { transform: translateX(3px); }
    }
    .stat-card:active { transform: scale(.985); transition-duration: .12s; }
    .stat-card--alert { border-color: #f3d28f; background: linear-gradient(180deg, #fffaf0, #ffffff); }
    .stat-card--alert .stat-number { color: var(--amber); }

    .stat-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
    .stat-icon { width: 40px; height: 40px; background: #fff3dc; color: var(--amber); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-label { color: var(--muted); font-size: 13px; font-weight: 600; }
    .stat-number { color: var(--navy); font-family: 'Manrope', sans-serif; font-size: 32px; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
    .stat-link { display: inline-flex; align-items: center; gap: 6px; color: var(--amber); font-size: 12px; font-weight: 700; margin-top: 14px; }
    .stat-link .ic { transition: transform .3s var(--ease); }

    .stat-card.compact { display: flex; align-items: center; gap: 14px; padding: 16px; }
    .stat-card.compact .stat-number { font-size: 24px; }
    .stat-card.compact .stat-label { display: block; margin-top: 5px; font-size: 12.5px; }

    /* ===== AKSES CEPAT ===== */
    .quick-grid { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 12px; }
    .quick-link { display: flex; align-items: center; gap: 12px; background: white; border: 1px solid var(--line); border-radius: 12px; padding: 14px 16px; color: var(--navy); font-size: 14px; font-weight: 800; -webkit-tap-highlight-color: transparent; transition: border-color .3s var(--ease), background-color .3s var(--ease), transform .3s var(--ease); }
    .quick-link .qi { width: 34px; height: 34px; border-radius: 9px; background: #fff3dc; color: var(--amber); display: flex; align-items: center; justify-content: center; flex-shrink: 0; transition: background-color .3s var(--ease), color .3s var(--ease); }
    @media (hover: hover) {
        .quick-link:hover { border-color: var(--gold); background: #fffaf0; transform: translateY(-2px); }
        .quick-link:hover .qi { background: var(--gold); color: var(--navy); }
    }
    .quick-link:active { transform: scale(.98); transition-duration: .12s; }

    /* ===== PANEL & TABEL ===== */
    .dashboard-columns { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; align-items: start; }
    .dashboard-panel { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px rgba(8,39,68,.04); border: 1px solid var(--line); min-width: 0; }
    .panel-heading { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 16px; }
    .panel-heading h4 { color: var(--navy); font-size: 16px; font-weight: 800; margin: 0; }
    .panel-heading a { display: inline-flex; align-items: center; gap: 5px; color: var(--amber); font-size: 12px; font-weight: 800; white-space: nowrap; transition: color .25s var(--ease); }
    .panel-heading a .ic { transition: transform .3s var(--ease); }
    @media (hover: hover) {
        .panel-heading a:hover { color: var(--navy); }
        .panel-heading a:hover .ic { transform: translateX(3px); }
    }

    .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table th { text-align: left; padding: 11px 10px; color: var(--muted); background: #f8f6f0; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .data-table th:first-child { border-radius: 8px 0 0 8px; }
    .data-table th:last-child { border-radius: 0 8px 8px 0; }
    .data-table td { padding: 13px 10px; border-bottom: 1px solid #f1eee6; color: var(--text); vertical-align: middle; }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tbody tr { transition: background-color .2s var(--ease); }
    @media (hover: hover) { .data-table tbody tr:hover { background: #fcfbf7; } }
    .data-table--orders { min-width: 680px; }
    .data-table--customers { min-width: 520px; }

    .item-name { font-weight: 800; color: var(--navy); }
    .num { font-variant-numeric: tabular-nums; white-space: nowrap; }
    .mail-link { color: var(--amber); font-weight: 600; word-break: break-all; }
    @media (hover: hover) { .mail-link:hover { color: var(--navy); } }

    .cell-product { display: flex; align-items: center; gap: 11px; min-width: 0; }
    .thumb { width: 40px; height: 40px; border-radius: 8px; object-fit: cover; background: #ece9e1; flex-shrink: 0; }

    /* Badge status */
    .badge { display: inline-flex; align-items: center; gap: 6px; padding: 5px 11px; border-radius: 999px; font-size: 11.5px; font-weight: 800; white-space: nowrap; }
    .badge::before { content: ""; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }
    .badge--pending    { background: #fff3dc; color: #b87308; }
    .badge--processing { background: #e3f0fd; color: #1565b8; }
    .badge--shipped    { background: #E8E1FF; color: #6743A5; }
    .badge--completed  { background: #e2f6ea; color: #1b8a4b; }
    .badge--cancelled  { background: #fde8e8; color: #c0392b; }
    .badge--neutral    { background: #eef1f4; color: #5b6775; }

    .article-item, .testimonial-item { padding: 14px 0; border-bottom: 1px solid #f1eee6; }
    .article-item:first-of-type, .testimonial-item:first-of-type { padding-top: 4px; }
    .article-item:last-child, .testimonial-item:last-child { border-bottom: none; padding-bottom: 0; }
    .article-item strong, .testimonial-item strong { color: var(--navy); font-size: 14px; display: block; margin-bottom: 7px; line-height: 1.4; }
    .article-meta { display: flex; align-items: center; flex-wrap: wrap; gap: 8px; color: var(--muted); font-size: 12px; }
    .testimonial-item span { color: var(--muted); font-size: 12.5px; line-height: 1.6; }
    .star-rating { color: var(--gold); letter-spacing: 2px; font-size: 13px; margin-bottom: 6px; }

    .empty-data { text-align: center; color: var(--muted); padding: 26px 10px !important; font-size: 13px; }
    .dashboard-footer { color: #9aa3ae; font-size: 12px; text-align: center; padding: 34px 0 5px; }

    /* ===== RESPONSIF ===== */
    @media (max-width: 1100px) {
        .stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .quick-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    /* Sidebar menjadi drawer di tablet dan HP */
    @media (max-width: 850px) {
        .admin-sidebar { position: fixed; top: 0; left: 0; bottom: 0; width: 280px; min-width: 280px; height: 100%; transform: translateX(-100%); transition: transform .35s var(--ease), box-shadow .35s var(--ease); }
        .admin-sidebar.open { transform: none; box-shadow: 12px 0 40px rgba(0,0,0,.35); }
        .menu-toggle { display: inline-flex; }
        .admin-main { padding: 22px 20px; }
    }

    @media (max-width: 600px) {
        .admin-main { padding: 18px 14px; }
        .topbar { margin-bottom: 20px; }
        .topbar-title h1 { font-size: 21px; }
        .topbar-title p { font-size: 12px; }
        .profile-info { display: none; }
        .admin-profile { padding: 5px; }
        .welcome-banner { flex-direction: column; align-items: flex-start; padding: 22px 20px; }
        .welcome-banner h2 { font-size: 18px; }
        .welcome-banner p { font-size: 12.5px; }
        .banner-cta, .banner-ok { width: 100%; justify-content: space-between; }
        .section-heading { flex-direction: column; align-items: flex-start; gap: 2px; margin: 26px 0 14px; }
        .section-heading h3 { font-size: 17px; }
        .stats-grid { gap: 10px; }
        .stat-card { padding: 15px; }
        .stat-top { margin-bottom: 14px; }
        .stat-label { font-size: 11.5px; }
        .stat-number { font-size: 26px; }
        .stats-grid.compact { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .stat-card.compact { padding: 13px; gap: 10px; }
        .stat-card.compact .stat-icon { width: 34px; height: 34px; }
        .stat-card.compact .stat-number { font-size: 21px; }
        .stat-card.compact .stat-label { font-size: 11px; }
        .quick-link { padding: 12px; font-size: 12.5px; gap: 9px; }
        .quick-link .qi { width: 30px; height: 30px; }
        .dashboard-columns { grid-template-columns: 1fr; }
        .dashboard-panel { padding: 16px; }
    }

    @media (max-width: 340px) {
        .stats-grid, .stats-grid.compact { grid-template-columns: 1fr; }
    }

    @media (prefers-reduced-motion: reduce) {
        .admin-sidebar, .sidebar-overlay, .stat-card, .quick-link, .banner-cta { transition: none; }
    }
</style>

{{-- data-no-translate: mencegah skrip terjemahan di layout mengubah label admin (Produk → Products, dst.) --}}
<div class="admin-dashboard" data-no-translate>

    {{-- OVERLAY (drawer di HP) --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- SIDEBAR --}}
    <aside class="admin-sidebar" id="adminSidebar" aria-label="Menu admin">

        <div class="sidebar-brand">
            <h2>TERRAWOOD</h2>
            <span>ADMIN PANEL</span>
        </div>

        <div class="sidebar-label">MENU UTAMA</div>

        <nav class="sidebar-menu">

            <a href="{{ route('admin.dashboard') }}"
               class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               @if(request()->routeIs('admin.dashboard')) aria-current="page" @endif>
                {!! $icon('dashboard') !!}
                <span class="menu-text">Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                {!! $icon('orders') !!}
                <span class="menu-text">Pesanan</span>
                @if($pendingOrders > 0)
                    <span class="menu-badge">{{ $pendingOrders }}</span>
                @endif
            </a>

            <a href="{{ route('admin.customers.index') }}"
               class="{{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                {!! $icon('mail') !!}
                <span class="menu-text">Pelanggan Terdaftar</span>
            </a>

            <a href="{{ route('admin.sales.index') }}"
               class="{{ request()->routeIs('admin.sales.*') ? 'active' : '' }}">
                {!! $icon('sales') !!}
                <span class="menu-text">Analitik Penjualan</span>
            </a>

        </nav>

        <div class="sidebar-label">KONTEN WEBSITE</div>

        <nav class="sidebar-menu">

            <a href="{{ route('admin.products.index') }}"
               class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                {!! $icon('products') !!}
                <span class="menu-text">Produk</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
               class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                {!! $icon('categories') !!}
                <span class="menu-text">Kategori</span>
            </a>

            <a href="{{ route('admin.services.index') }}"
               class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                {!! $icon('services') !!}
                <span class="menu-text">Layanan</span>
            </a>

            <a href="{{ route('admin.articles.index') }}"
               class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                {!! $icon('articles') !!}
                <span class="menu-text">Artikel</span>
            </a>

            <a href="{{ route('admin.portfolios.index') }}"
               class="{{ request()->routeIs('admin.portfolios.*') ? 'active' : '' }}">
                {!! $icon('portfolios') !!}
                <span class="menu-text">Portofolio</span>
            </a>

            <a href="{{ route('admin.partners.index') }}"
               class="{{ request()->routeIs('admin.partners.*') ? 'active' : '' }}">
                {!! $icon('partners') !!}
                <span class="menu-text">Klien & Mitra</span>
            </a>

            <a href="{{ route('admin.testimonials.index') }}"
               class="{{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                {!! $icon('star') !!}
                <span class="menu-text">Rating & Testimoni</span>
            </a>

        </nav>

        <div class="sidebar-bottom">
            <a href="{{ url('/') }}" target="_blank" rel="noopener">
                {!! $icon('home') !!}
                <span class="menu-text">Lihat Website</span>
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    {!! $icon('logout') !!}
                    <span class="menu-text">Keluar</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- KONTEN UTAMA --}}
    <main class="admin-main">

        <header class="topbar">

            <div class="topbar-left">

                <button type="button"
                        class="menu-toggle"
                        id="menuToggle"
                        aria-label="Buka menu"
                        aria-controls="adminSidebar"
                        aria-expanded="false">
                    {!! $icon('menu', 22) !!}
                </button>

                <div class="topbar-title">
                    <h1>Dashboard</h1>
                    <p>Pusat pengelolaan website TERRAWOOD.</p>
                </div>

            </div>

            <div class="admin-profile">
                <div class="profile-avatar">{{ $adminInit }}</div>
                <div class="profile-info">
                    <strong>{{ $adminName }}</strong>
                    <span>Admin Panel</span>
                </div>
            </div>

        </header>

        {{-- SAMBUTAN --}}
        <section class="welcome-banner">

            <div>
                <div class="welcome-date">{{ $today }}</div>
                <h2>{{ $greeting }}, {{ $adminName }}!</h2>
                <p>
                    @if($pendingOrders > 0)
                        Ada {{ $pendingOrders }} pesanan baru yang menunggu konfirmasi Anda.
                    @else
                        Kelola produk, layanan, artikel, dan informasi perusahaan dalam satu tempat.
                    @endif
                </p>
            </div>

            @if($pendingOrders > 0)
                <a href="{{ route('admin.orders.index') }}" class="banner-cta">
                    Proses Pesanan {!! $icon('arrow', 18) !!}
                </a>
            @else
                <span class="banner-ok">
                    {!! $icon('done', 18) !!} Semua pesanan sudah ditangani
                </span>
            @endif

        </section>

        {{-- RINGKASAN PESANAN --}}
        <div class="section-heading">
            <h3>Ringkasan Pesanan</h3>
            <span>Klik kartu untuk melihat daftar pesanan</span>
        </div>

        <section class="stats-grid">

            <a href="{{ route('admin.orders.index') }}" class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Total Pesanan</span>
                    <span class="stat-icon">{!! $icon('orders') !!}</span>
                </div>
                <div class="stat-number">{{ $stats['orders'] ?? 0 }}</div>
                <span class="stat-link">Lihat Pesanan {!! $icon('arrow', 14) !!}</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
               class="stat-card {{ $pendingOrders > 0 ? 'stat-card--alert' : '' }}">
                <div class="stat-top">
                    <span class="stat-label">Menunggu Konfirmasi</span>
                    <span class="stat-icon">{!! $icon('clock') !!}</span>
                </div>
                <div class="stat-number">{{ $pendingOrders }}</div>
                <span class="stat-link">Lihat Pesanan {!! $icon('arrow', 14) !!}</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Sedang Diproses</span>
                    <span class="stat-icon">{!! $icon('progress') !!}</span>
                </div>
                <div class="stat-number">{{ $stats['processing_orders'] ?? 0 }}</div>
                <span class="stat-link">Lihat Pesanan {!! $icon('arrow', 14) !!}</span>
            </a>

            <a href="{{ route('admin.orders.index') }}" class="stat-card">
                <div class="stat-top">
                    <span class="stat-label">Pesanan Selesai</span>
                    <span class="stat-icon">{!! $icon('done') !!}</span>
                </div>
                <div class="stat-number">{{ $stats['completed_orders'] ?? 0 }}</div>
                <span class="stat-link">Lihat Pesanan {!! $icon('arrow', 14) !!}</span>
            </a>

        </section>

        {{-- PESANAN TERBARU --}}
        <section class="dashboard-panel" style="margin-top: 18px;">

            <div class="panel-heading">
                <h4>Pesanan Terbaru</h4>
                <a href="{{ route('admin.orders.index') }}">Lihat Semua {!! $icon('arrow', 14) !!}</a>
            </div>

            <div class="table-wrapper">
                <table class="data-table data-table--orders">
                    <thead>
                        <tr>
                            <th>Nomor Pesanan</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            @php
                                $st = $statusMap[strtolower((string) $order->status)]
                                    ?? [ucfirst((string) $order->status), 'neutral'];
                            @endphp
                            <tr>
                                <td class="item-name">{{ $order->order_number }}</td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->product->name ?? 'Produk dihapus' }}</td>
                                <td class="num">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td><span class="badge badge--{{ $st[1] }}">{{ $st[0] }}</span></td>
                                <td class="num">{{ $order->created_at?->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-data">Belum ada pesanan masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

        {{-- KONTEN WEBSITE --}}
        <div class="section-heading">
            <h3>Konten Website</h3>
            <span>Data terkini dari database</span>
        </div>

        <section class="stats-grid compact">

            <a href="{{ route('admin.products.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('products') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['products'] ?? 0 }}</div>
                    <span class="stat-label">Produk</span>
                </div>
            </a>

            <a href="{{ route('admin.categories.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('categories') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['categories'] ?? 0 }}</div>
                    <span class="stat-label">Kategori</span>
                </div>
            </a>

            <a href="{{ route('admin.services.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('services') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['services'] ?? 0 }}</div>
                    <span class="stat-label">Layanan</span>
                </div>
            </a>

            <a href="{{ route('admin.articles.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('articles') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['articles'] ?? 0 }}</div>
                    <span class="stat-label">Artikel</span>
                </div>
            </a>

            <a href="{{ route('admin.portfolios.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('portfolios') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['portfolios'] ?? 0 }}</div>
                    <span class="stat-label">Portofolio</span>
                </div>
            </a>

            <a href="{{ route('admin.partners.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('partners') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['partners'] ?? 0 }}</div>
                    <span class="stat-label">Klien & Mitra</span>
                </div>
            </a>

            <a href="{{ route('admin.testimonials.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('star') !!}</span>
                <div>
                    <div class="stat-number">{{ $stats['testimonials'] ?? 0 }}</div>
                    <span class="stat-label">Testimoni</span>
                </div>
            </a>

            <a href="{{ route('admin.customers.index') }}" class="stat-card compact">
                <span class="stat-icon">{!! $icon('mail') !!}</span>
                <div>
                    <div class="stat-number">{{ $customerCount ?? 0 }}</div>
                    <span class="stat-label">Pelanggan</span>
                </div>
            </a>

        </section>

        {{-- AKSES CEPAT --}}
        <div class="section-heading">
            <h3>Akses Cepat</h3>
            <span>Tambah konten baru</span>
        </div>

        <section class="quick-grid">

            <a href="{{ route('admin.products.create') }}" class="quick-link">
                <span class="qi">{!! $icon('plus', 18) !!}</span> Tambah Produk
            </a>

            <a href="{{ route('admin.articles.create') }}" class="quick-link">
                <span class="qi">{!! $icon('plus', 18) !!}</span> Tambah Artikel
            </a>

            <a href="{{ route('admin.portfolios.create') }}" class="quick-link">
                <span class="qi">{!! $icon('plus', 18) !!}</span> Tambah Portofolio
            </a>

            <a href="{{ route('admin.testimonials.create') }}" class="quick-link">
                <span class="qi">{!! $icon('plus', 18) !!}</span> Tambah Testimoni
            </a>

        </section>

        {{-- AKTIVITAS TERBARU --}}
        <div class="section-heading">
            <h3>Aktivitas Terbaru</h3>
            <span>Data terbaru dari database</span>
        </div>

        <section class="dashboard-columns">

            <div class="dashboard-panel">

                <div class="panel-heading">
                    <h4>Produk Terbaru</h4>
                    <a href="{{ route('admin.products.index') }}">Lihat Semua {!! $icon('arrow', 14) !!}</a>
                </div>

                <div class="table-wrapper">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="cell-product">
                                            <img
                                                class="thumb"
                                                src="{{ $product->image ? asset('storage/' . $product->image) : asset('images/products/01_teak_stool_with_4_legs.png') }}"
                                                alt=""
                                                width="40"
                                                height="40"
                                                loading="lazy"
                                            >
                                            <span class="item-name">{{ $product->name }}</span>
                                        </div>
                                    </td>
                                    <td class="num">
                                        @if(!empty($product->price))
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="empty-data">Belum ada produk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="dashboard-panel">

                <div class="panel-heading">
                    <h4>Artikel Terbaru</h4>
                    <a href="{{ route('admin.articles.index') }}">Lihat Semua {!! $icon('arrow', 14) !!}</a>
                </div>

                @forelse($recentArticles as $article)
                    <div class="article-item">
                        <strong>{{ $article->title }}</strong>
                        <div class="article-meta">
                            <span>{{ $article->created_at?->format('d M Y') }}</span>
                            <span class="badge {{ $article->is_published ? 'badge--completed' : 'badge--neutral' }}">
                                {{ $article->is_published ? 'Dipublikasikan' : 'Draft' }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="empty-data">Belum ada artikel.</div>
                @endforelse

            </div>

            <div class="dashboard-panel">

                <div class="panel-heading">
                    <h4>Testimoni Terbaru</h4>
                    <a href="{{ route('admin.testimonials.index') }}">Lihat Semua {!! $icon('arrow', 14) !!}</a>
                </div>

                @forelse($recentTestimonials as $testimonial)
                    @php $rating = max(0, min(5, (int) $testimonial->rating)); @endphp
                    <div class="testimonial-item">
                        <strong>{{ $testimonial->customer_name }}</strong>

                        <div class="star-rating" aria-label="Rating {{ $rating }} dari 5">
                            {{ str_repeat('★', $rating) }}{{ str_repeat('☆', 5 - $rating) }}
                        </div>

                        <span>{{ \Illuminate\Support\Str::limit($testimonial->testimonial, 75) }}</span>
                    </div>
                @empty
                    <div class="empty-data">Belum ada testimoni.</div>
                @endforelse

            </div>

        </section>

        {{-- PELANGGAN TERDAFTAR --}}
        <div class="section-heading">
            <h3>Pelanggan Terdaftar</h3>
            <span>{{ $customerCount ?? 0 }} total pelanggan</span>
        </div>

        <section class="dashboard-panel">

            <div class="panel-heading">
                <h4>Pendaftar Terbaru</h4>
                <a href="{{ route('admin.customers.index') }}">Lihat Semua {!! $icon('arrow', 14) !!}</a>
            </div>

            <div class="table-wrapper">
                <table class="data-table data-table--customers">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Negara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentCustomers as $customer)
                            <tr>
                                <td class="item-name">{{ $customer->name }}</td>
                                <td><a href="mailto:{{ $customer->email }}" class="mail-link">{{ $customer->email }}</a></td>
                                <td>{{ $customer->country ?: 'Belum diisi' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="empty-data">Belum ada pelanggan yang mendaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

        <footer class="dashboard-footer">
            © {{ date('Y') }} PT. TERRAWOOD FURNITUR DEKORASI
            · Crafting Comfort with Nature
        </footer>

    </main>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('adminSidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const toggle  = document.getElementById('menuToggle');

    if (!sidebar || !overlay || !toggle) return;

    function setDrawer(open) {
        sidebar.classList.toggle('open', open);
        overlay.classList.toggle('show', open);
        document.body.classList.toggle('drawer-open', open);
        toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
    }

    toggle.addEventListener('click', function () {
        setDrawer(!sidebar.classList.contains('open'));
    });

    overlay.addEventListener('click', function () {
        setDrawer(false);
    });

    sidebar.addEventListener('click', function (event) {
        if (event.target.closest('a')) setDrawer(false);
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') setDrawer(false);
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 850) setDrawer(false);
    });

});
</script>

@endsection