@extends('layouts.app')

{{--
    Layout admin bersama: sidebar, topbar, gaya dasar, dan tombol/form/alert umum.
    Pakai di halaman admin lain dengan:

        @extends('layouts.admin')
        @section('title', 'Judul | TERRAWOOD')
        @section('page_title', 'Judul Halaman')
        @section('page_subtitle', 'Keterangan singkat.')
        @section('admin')  ... isi halaman ...  @endsection
--}}

@section('content')

@php
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
        'home'      => '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
        'menu'      => '<line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>',
        'logout'    => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>',
        'mail'      => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
        'sales'     => '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
    ];

    $icon = function ($name, $size = 20) use ($ic) {
        return '<svg class="ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    $pendingOrders = \App\Models\Order::where('status', 'menunggu')->count();
    $adminName     = auth()->user()?->name ?? 'Administrator';
    $adminInit     = mb_strtoupper(mb_substr($adminName, 0, 1));

    // [nama route, pola route aktif, ikon, teks]
    $menu = [
        'MENU UTAMA' => [
            ['admin.dashboard',        'admin.dashboard',      'dashboard', 'Dashboard'],
            ['admin.orders.index',     'admin.orders.*',       'orders',    'Pesanan'],
            ['admin.customers.index',  'admin.customers.*',    'mail',      'Pelanggan Terdaftar'],
            ['admin.sales.index',      'admin.sales.*',        'sales',     'Analitik Penjualan'],
        ],
        'KONTEN WEBSITE' => [
            ['admin.products.index',     'admin.products.*',     'products',   'Produk'],
            ['admin.categories.index',   'admin.categories.*',   'categories', 'Kategori'],
            ['admin.services.index',     'admin.services.*',     'services',   'Layanan'],
            ['admin.articles.index',     'admin.articles.*',     'articles',   'Artikel'],
            ['admin.portfolios.index',   'admin.portfolios.*',   'portfolios', 'Portofolio'],
            ['admin.partners.index',     'admin.partners.*',     'partners',   'Klien & Mitra'],
            ['admin.testimonials.index', 'admin.testimonials.*', 'star',       'Rating & Testimoni'],
        ],
    ];
@endphp

<style>
    :root {
        --navy: #082744; --navy-dark: #061D33; --gold: #F5A623; --ivory: #F7F5EF;
        --text: #293747; --muted: #7a8696; --line: #ece7dc; --amber: #b87308;
        --ease: cubic-bezier(.22, .61, .36, 1);
    }

    .admin-dashboard, .admin-dashboard *, .admin-dashboard *::before, .admin-dashboard *::after { box-sizing: border-box; }
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
    .sidebar-menu a, .sidebar-bottom a, .sidebar-bottom button { position: relative; display: flex; align-items: center; gap: 12px; color: #b9c6d3; padding: 12px 13px; border-radius: 10px; font-size: 14px; font-weight: 600; transition: background-color .25s var(--ease), color .25s var(--ease); }
    .sidebar-menu a:hover, .sidebar-bottom a:hover, .sidebar-bottom button:hover { background: rgba(255,255,255,.06); color: white; }
    .sidebar-menu a.active { background: rgba(245,166,35,.14); color: var(--gold); }
    .sidebar-menu a.active::before { content: ""; position: absolute; left: -16px; top: 10px; bottom: 10px; width: 3px; border-radius: 0 3px 3px 0; background: var(--gold); }
    .menu-badge { margin-left: auto; min-width: 22px; height: 22px; padding: 0 7px; border-radius: 11px; background: var(--gold); color: var(--navy); font-size: 11px; font-weight: 800; display: inline-flex; align-items: center; justify-content: center; }
    .sidebar-bottom button { width: 100%; border: 0; background: transparent; font-family: 'Inter', sans-serif; text-align: left; cursor: pointer; }
    .sidebar-bottom form { margin: 0; }
    .sidebar-bottom { margin-top: auto; padding-top: 20px; border-top: 1px solid rgba(255,255,255,.1); }
    .sidebar-overlay { position: fixed; inset: 0; background: rgba(6,29,51,.55); opacity: 0; visibility: hidden; transition: opacity .3s var(--ease), visibility .3s var(--ease); z-index: 55; }
    .sidebar-overlay.show { opacity: 1; visibility: visible; }

    /* ===== MAIN & TOPBAR ===== */
    .admin-main { flex: 1; min-width: 0; padding: 30px 36px 24px; }
    .topbar { display: flex; align-items: center; justify-content: space-between; gap: 15px; margin-bottom: 26px; }
    .topbar-left { display: flex; align-items: center; gap: 14px; min-width: 0; }
    .menu-toggle { display: none; width: 42px; height: 42px; border: 1px solid var(--line); border-radius: 10px; background: white; color: var(--navy); cursor: pointer; align-items: center; justify-content: center; flex-shrink: 0; -webkit-tap-highlight-color: transparent; }
    .topbar-title h1 { color: var(--navy); font-size: 28px; font-weight: 800; margin: 0 0 4px; }
    .topbar-title p { color: var(--muted); font-size: 14px; margin: 0; }
    .admin-profile { display: flex; align-items: center; gap: 11px; background: white; padding: 9px 15px 9px 10px; border: 1px solid var(--line); border-radius: 999px; box-shadow: 0 2px 10px rgba(8,39,68,.04); flex-shrink: 0; }
    .profile-avatar { width: 38px; height: 38px; background: var(--navy); color: var(--gold); display: flex; align-items: center; justify-content: center; border-radius: 50%; font-family: 'Manrope', sans-serif; font-weight: 800; font-size: 15px; }
    .profile-info strong { display: block; color: var(--navy); font-size: 13.5px; line-height: 1.3; }
    .profile-info span { color: var(--muted); font-size: 12px; }

    /* ===== KOMPONEN UMUM ===== */
    .section-heading { display: flex; justify-content: space-between; align-items: baseline; gap: 10px; margin: 30px 0 16px; }
    .section-heading h3 { color: var(--navy); font-size: 19px; font-weight: 800; margin: 0; }
    .section-heading span { color: var(--muted); font-size: 13px; }

    .dashboard-panel { background: white; border-radius: 14px; padding: 22px; box-shadow: 0 2px 10px rgba(8,39,68,.04); border: 1px solid var(--line); min-width: 0; }
    .panel-heading { display: flex; justify-content: space-between; align-items: center; gap: 10px; margin-bottom: 16px; }
    .panel-heading h4 { color: var(--navy); font-size: 16px; font-weight: 800; margin: 0; }

    .table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .data-table { width: 100%; border-collapse: collapse; font-size: 13px; }
    .data-table th { text-align: left; padding: 11px 10px; color: var(--muted); background: #f8f6f0; font-size: 12px; font-weight: 700; white-space: nowrap; }
    .data-table th:first-child { border-radius: 8px 0 0 8px; }
    .data-table th:last-child { border-radius: 0 8px 8px 0; }
    .data-table td { padding: 13px 10px; border-bottom: 1px solid #f1eee6; vertical-align: middle; }
    .data-table tr:last-child td { border-bottom: none; }
    .data-table tfoot td { border-top: 2px solid var(--line); border-bottom: none; font-weight: 800; color: var(--navy); }
    .item-name { font-weight: 800; color: var(--navy); }
    .num { font-variant-numeric: tabular-nums; white-space: nowrap; }
    .text-right { text-align: right !important; }
    .empty-data { text-align: center; color: var(--muted); padding: 26px 10px !important; font-size: 13px; }

    .btn { display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 11px 18px; border: 0; border-radius: 10px; font-family: 'Inter', sans-serif; font-size: 13px; font-weight: 800; cursor: pointer; white-space: nowrap; -webkit-tap-highlight-color: transparent; transition: background-color .25s var(--ease), transform .2s var(--ease); }
    .btn:active { transform: scale(.97); }
    .btn--navy { background: var(--navy); color: #fff; }
    .btn--gold { background: var(--gold); color: var(--navy); }
    .btn--ghost { background: transparent; color: var(--navy); border: 1px solid var(--line); }
    @media (hover: hover) {
        .btn--navy:hover { background: var(--navy-dark); }
        .btn--gold:hover { background: #ffb83f; }
        .btn--ghost:hover { background: #fff; }
    }

    .field { display: grid; gap: 6px; font-size: 12.5px; font-weight: 700; color: var(--navy); }
    .field input { width: 100%; padding: 11px 12px; border: 1px solid #ddd6c8; border-radius: 9px; font: inherit; font-weight: 500; color: var(--text); background: #fff; }
    .field input:focus { outline: 2px solid var(--gold); outline-offset: 1px; border-color: var(--gold); }
    .field small { font-weight: 500; color: var(--muted); }

    .alert { padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; font-size: 13.5px; }
    .alert ul { margin: 6px 0 0 18px; }
    .alert--success { background: #e2f6ea; border: 1px solid #bfe6cf; color: #17653a; }
    .alert--error { background: #fde8e8; border: 1px solid #f6c7c4; color: #8a1f17; }

    .dashboard-footer { color: #9aa3ae; font-size: 12px; text-align: center; padding: 34px 0 5px; }

    /* ===== RESPONSIF ===== */
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
        .section-heading { flex-direction: column; align-items: flex-start; gap: 2px; margin: 26px 0 14px; }
        .section-heading h3 { font-size: 17px; }
        .dashboard-panel { padding: 16px; }
    }
    @media (prefers-reduced-motion: reduce) {
        .admin-sidebar, .sidebar-overlay, .btn { transition: none; }
    }
</style>

{{-- data-no-translate: skrip terjemahan di layouts.app tidak boleh mengubah label admin --}}
<div class="admin-dashboard" data-no-translate>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="admin-sidebar" id="adminSidebar" aria-label="Menu admin">

        <div class="sidebar-brand">
            <h2>TERRAWOOD</h2>
            <span>ADMIN PANEL</span>
        </div>

        @foreach($menu as $groupLabel => $items)
            <div class="sidebar-label">{{ $groupLabel }}</div>
            <nav class="sidebar-menu">
                @foreach($items as [$route, $pattern, $iconName, $text])
                    <a href="{{ route($route) }}"
                       class="{{ request()->routeIs($pattern) ? 'active' : '' }}"
                       @if(request()->routeIs($pattern)) aria-current="page" @endif>
                        {!! $icon($iconName) !!}
                        <span class="menu-text">{{ $text }}</span>
                        @if($route === 'admin.orders.index' && $pendingOrders > 0)
                            <span class="menu-badge">{{ $pendingOrders }}</span>
                        @endif
                    </a>
                @endforeach
            </nav>
        @endforeach

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

    <main class="admin-main">

        <header class="topbar">
            <div class="topbar-left">
                <button type="button" class="menu-toggle" id="menuToggle"
                        aria-label="Buka menu" aria-controls="adminSidebar" aria-expanded="false">
                    {!! $icon('menu', 22) !!}
                </button>

                <div class="topbar-title">
                    <h1>@yield('page_title', 'Admin')</h1>
                    <p>@yield('page_subtitle')</p>
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

        @yield('admin')

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

    toggle.addEventListener('click', function () { setDrawer(!sidebar.classList.contains('open')); });
    overlay.addEventListener('click', function () { setDrawer(false); });
    sidebar.addEventListener('click', function (e) { if (e.target.closest('a')) setDrawer(false); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') setDrawer(false); });
    window.addEventListener('resize', function () { if (window.innerWidth > 850) setDrawer(false); });
});
</script>

@endsection
