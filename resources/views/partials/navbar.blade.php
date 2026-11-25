{{-- Navbar bersama untuk semua halaman: @include('partials.navbar') --}}
@include('partials.i18n')
@php
    $isHome = request()->routeIs('home');

    /* ---------- Status login & inisial ---------- */
    $twAuth = auth()->check();
    $twUser = auth()->user();
    $twName = $twAuth ? trim((string) ($twUser->name ?? '')) : '';

    $twInitials = '';

    if ($twAuth) {
        $twWords = preg_split('/\s+/', $twName, -1, PREG_SPLIT_NO_EMPTY) ?: [];

        foreach (array_slice($twWords, 0, 2) as $twWord) {
            $twInitials .= mb_strtoupper(mb_substr($twWord, 0, 1));
        }

        if ($twInitials === '') {
            $twInitials = 'U';
        }
    }

    /* ---------- Link akun (aman walau route belum ada) ---------- */
    $twRoute = function ($name, $fallback = null) {
        return \Illuminate\Support\Facades\Route::has($name) ? route($name) : $fallback;
    };

    $twLoginUrl   = $twRoute('login', url('/login'));
    $twLogoutUrl  = $twRoute('logout', url('/logout'));
    $twAccountUrl = $twRoute('account.index');
    $twAdminUrl   = $twRoute('admin.dashboard');

    /* ---------- Peran pengguna & jumlah notifikasi ---------- */
    $twIsCustomer = $twAuth && ($twUser->role ?? null) === 'user';
    $twUnread     = 0;

    if ($twIsCustomer && method_exists($twUser, 'unreadNotifications')) {
        $twUnread = (int) $twUser->unreadNotifications()->count();
    }

    /* Beri tahu layout agar tombol profil melayang tidak muncul ganda */
    view()->share('hasSiteNavbar', true);

    /* ---------- Halaman yang sedang dibuka ---------- */
    $twCurrent = [
        'home'    => request()->routeIs('home'),
        'catalog' => request()->routeIs('catalog.*'),
        'info'    => request()->routeIs('services.*'),
        'inspire' => request()->routeIs('articles.*', 'portfolios.*'),
        'service' => request()->routeIs('services.*'),
        'article' => request()->routeIs('articles.*'),
        'portfolio' => request()->routeIs('portfolios.*'),
    ];

    /* ---------- Ikon SVG ---------- */
    $twIc = [
        'user'      => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
        'login'     => '<path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" x2="3" y1="12" y2="12"/>',
        'logout'    => '<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/>',
        'service'   => '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>',
        'about'     => '<path d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"/><path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"/><path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"/><path d="M10 6h4"/><path d="M10 10h4"/><path d="M10 14h4"/><path d="M10 18h4"/>',
        'contact'   => '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>',
        'article'   => '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>',
        'portfolio' => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
        'partner'   => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
        'testimony' => '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
        'orders'    => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
        'bell'      => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
        'dashboard' => '<rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/>',
        'chevron'   => '<polyline points="6 9 12 15 18 9"/>',
    ];

    $twIcon = function ($name, $size = 18) use ($twIc) {
        return '<svg class="nav-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($twIc[$name] ?? '') . '</svg>';
    };
@endphp

@once
@push('styles')
<style>
:root {
    --tw-navy: #082744;
    --tw-dark: #061D33;
    --tw-gold: #F5A623;
    --tw-orange: #FFA43A;
    --tw-ease: cubic-bezier(.22, .61, .36, 1);
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
}

.navbar,
.navbar *,
.navbar *::before,
.navbar *::after { box-sizing: border-box; }

.navbar {
    font-family: 'Inter', sans-serif;
    --nav-underline: #fff;
}

.navbar a { text-decoration: none; }

.navbar a:focus-visible,
.navbar button:focus-visible {
    outline: 2px solid var(--tw-orange);
    outline-offset: 3px;
}

.nav-ic { display: block; flex-shrink: 0; }

/* Penyangga agar konten halaman non-beranda tidak tertutup navbar */
.navbar-spacer { height: 70px; }

/* =====================================
   NAVBAR
===================================== */

.navbar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    min-height: 85px;
    padding: 0 5%;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    z-index: 100;
    gap: 20px;
    background: linear-gradient(to bottom, rgba(6,29,51,.72), rgba(6,29,51,0));
    transition: background .3s ease, box-shadow .3s ease, min-height .3s ease;
}

.navbar.scrolled {
    --nav-underline: var(--tw-gold);
    min-height: 70px;
    background: var(--tw-navy);
    box-shadow: 0 6px 24px rgba(0,0,0,.22);
}

.brand {
    display: flex;
    align-items: center;
    flex-shrink: 0;
    margin-right: auto;
}

.brand-logo {
    width: 165px;
    height: 60px;
    object-fit: contain;
    object-position: left center;
}

.nav-menu {
    display: flex;
    align-items: center;
    gap: 19px;
}

.nav-menu > a {
    color: white;
    font-size: 12px;
    font-weight: 700;
    transition: color .25s ease;
    white-space: nowrap;
    display: inline-block;
    -webkit-tap-highlight-color: transparent;
}

/* Garis bawah: muncul saat hover, ditekan/disentuh, fokus, menu terbuka, dan halaman aktif */

.nav-text {
    display: inline-block;
    padding: 4px 0;
    background: linear-gradient(var(--nav-underline), var(--nav-underline)) no-repeat 0 100% / 0 2px;
    transition: background-size .35s var(--tw-ease);
}

.nav-menu > a:not(.order-button):focus-visible .nav-text,
.nav-menu > a:not(.order-button):active .nav-text,
.nav-menu > a.is-current .nav-text,
.nav-dropdown-toggle:focus-visible .nav-text,
.nav-dropdown-toggle:active .nav-text,
.nav-dropdown.open .nav-text,
.nav-dropdown.is-current .nav-text {
    background-size: 100% 2px;
}

.nav-menu > a:not(.order-button):focus-visible,
.nav-menu > a:not(.order-button):active,
.nav-menu > a.is-current {
    color: white;
}

@media (hover: hover) {
    .nav-menu > a:not(.order-button):hover { color: var(--tw-orange); }

    .nav-menu > a:not(.order-button):hover .nav-text,
    .nav-dropdown-toggle:hover .nav-text {
        background-size: 100% 2px;
    }
}

/* TOMBOL PESAN SEKARANG */

.nav-menu .order-button {
    background: var(--tw-navy);
    color: white;
    padding: 14px 22px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 800;
    box-shadow: 0 5px 16px rgba(8,39,68,.25);
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .35s var(--tw-ease),
        color .35s var(--tw-ease),
        transform .35s var(--tw-ease),
        box-shadow .35s var(--tw-ease);
}

.nav-menu .order-button:hover,
.nav-menu .order-button:focus-visible {
    background: var(--tw-dark);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 10px 22px rgba(0,0,0,.18);
}

.nav-menu .order-button:active {
    transform: translateY(0) scale(.97);
    transition-duration: .12s;
}

/* Setelah scroll, tombol berubah emas agar tetap terlihat di navbar navy */
.navbar.scrolled .nav-menu .order-button {
    background: var(--tw-gold);
    color: var(--tw-navy);
    box-shadow: none;
}

.navbar.scrolled .nav-menu .order-button:hover,
.navbar.scrolled .nav-menu .order-button:focus-visible {
    background: white;
    color: var(--tw-navy);
}

/* =====================================
   DROPDOWN (Informasi & Inspirasi)
===================================== */

.nav-dropdown {
    position: relative;
    display: inline-flex;
    align-items: center;
}

.nav-dropdown-toggle {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    border: 0;
    background: transparent;
    color: white;
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 700;
    cursor: pointer;
    white-space: nowrap;
    padding: 8px 0;
    -webkit-tap-highlight-color: transparent;
    transition: color .25s ease;
}

.nav-dropdown-toggle:focus-visible,
.nav-dropdown.open .nav-dropdown-toggle { color: var(--tw-orange); }

@media (hover: hover) {
    .nav-dropdown-toggle:hover { color: var(--tw-orange); }
}

.dropdown-arrow {
    width: 12px;
    height: 12px;
    transition: transform .25s var(--tw-ease);
}

.nav-dropdown.open .dropdown-arrow { transform: rotate(180deg); }

.nav-dropdown-menu {
    display: none;
    position: absolute;
    top: calc(100% + 12px);
    left: 50%;
    transform: translateX(-50%);
    min-width: 232px;
    padding: 8px;
    background: white;
    border: 1px solid rgba(8,39,68,.08);
    border-radius: 14px;
    box-shadow: 0 16px 40px rgba(0,0,0,.2);
    z-index: 50;
}

.nav-dropdown.open .nav-dropdown-menu {
    display: block;
    animation: navDropIn .22s var(--tw-ease);
}

/* Item pilihan dengan ikon (dipakai juga di menu profil) */

.dd-item {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 8px 10px;
    border: 0;
    border-radius: 10px;
    background: transparent;
    color: var(--tw-navy);
    font-family: 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 700;
    text-align: left;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    transition: background-color .2s ease, color .2s ease;
}

.dd-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: #FFF3DF;
    color: #B66D14;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: background-color .25s var(--tw-ease), color .25s var(--tw-ease);
}

.dd-item.is-current { background: #FFF3DF; }

.dd-item:focus-visible { background: #FFF8EC; }

.dd-item:active { background: #FFF3DF; }

.dd-item:focus-visible .dd-icon,
.dd-item:active .dd-icon,
.dd-item.is-current .dd-icon {
    background: var(--tw-gold);
    color: var(--tw-navy);
}

@media (hover: hover) {
    .dd-item:hover { background: #FFF8EC; }

    .dd-item:hover .dd-icon {
        background: var(--tw-gold);
        color: var(--tw-navy);
    }
}

/* =====================================
   AKUN: TOMBOL MASUK & AVATAR INISIAL
===================================== */

.nav-auth {
    display: flex;
    align-items: center;
    flex-shrink: 0;
}

.nav-login {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 11px 18px;
    border: 1.5px solid rgba(255,255,255,.75);
    border-radius: 999px;
    color: white;
    font-size: 12px;
    font-weight: 800;
    white-space: nowrap;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .3s var(--tw-ease),
        color .3s var(--tw-ease),
        border-color .3s var(--tw-ease),
        transform .3s var(--tw-ease);
}

.nav-login:focus-visible {
    background: white;
    color: var(--tw-navy);
    border-color: white;
}

@media (hover: hover) {
    .nav-login:hover {
        background: white;
        color: var(--tw-navy);
        border-color: white;
        transform: translateY(-2px);
    }
}

.nav-login:active {
    background: white;
    color: var(--tw-navy);
    border-color: white;
    transform: scale(.97);
    transition-duration: .12s;
}

.nav-profile { position: relative; }

.nav-avatar {
    width: 42px;
    height: 42px;
    padding: 0;
    border: 2px solid rgba(255,255,255,.8);
    border-radius: 50%;
    background: var(--tw-gold);
    color: var(--tw-navy);
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: .5px;
    line-height: 1;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    transition:
        transform .3s var(--tw-ease),
        box-shadow .3s var(--tw-ease),
        border-color .3s var(--tw-ease);
}

.nav-profile.open .nav-avatar {
    border-color: white;
    box-shadow: 0 0 0 4px rgba(245,166,35,.35);
}

@media (hover: hover) {
    .nav-avatar:hover { transform: scale(1.06); }
}

.nav-avatar:active {
    transform: scale(.94);
    transition-duration: .12s;
}

.profile-menu {
    display: none;
    position: absolute;
    top: calc(100% + 14px);
    right: 0;
    width: 258px;
    padding: 8px;
    background: white;
    border: 1px solid rgba(8,39,68,.08);
    border-radius: 14px;
    box-shadow: 0 16px 40px rgba(0,0,0,.2);
    z-index: 60;
}

.nav-profile.open .profile-menu {
    display: block;
    animation: navProfileIn .22s var(--tw-ease);
}

.profile-head {
    display: flex;
    align-items: center;
    gap: 11px;
    padding: 8px 8px 12px;
    margin-bottom: 6px;
    border-bottom: 1px solid #F0ECE3;
}

.profile-head > div { min-width: 0; }

.profile-avatar-lg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--tw-navy);
    color: var(--tw-gold);
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.profile-head strong {
    display: block;
    color: var(--tw-navy);
    font-size: 13px;
    line-height: 1.35;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.profile-head .profile-email {
    display: block;
    color: #687482;
    font-size: 11.5px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.profile-menu form { margin: 0; }

/* Badge jumlah notifikasi */

.js-notification-badge[hidden] { display: none !important; }

.nav-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    min-width: 19px;
    height: 19px;
    padding: 0 5px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #E53935;
    color: white;
    border: 2px solid var(--tw-navy);
    border-radius: 20px;
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 800;
    line-height: 1;
    pointer-events: none;
}

.dd-count {
    margin-left: auto;
    min-width: 22px;
    height: 22px;
    padding: 0 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #E53935;
    color: white;
    border-radius: 11px;
    font-size: 11px;
    font-weight: 800;
}

.dd-logout { color: #C0392B; }

.dd-logout .dd-icon {
    background: #FDE8E8;
    color: #C0392B;
}

.dd-logout:focus-visible,
.dd-logout:active { background: #FFF1F0; }

.dd-logout:focus-visible .dd-icon,
.dd-logout:active .dd-icon {
    background: #C0392B;
    color: white;
}

@media (hover: hover) {
    .dd-logout:hover { background: #FFF1F0; }

    .dd-logout:hover .dd-icon {
        background: #C0392B;
        color: white;
    }
}

/* =====================================
   TOMBOL HAMBURGER (tampil di layar kecil)
===================================== */

.nav-toggle {
    display: none;
    width: 44px;
    height: 44px;
    border: 1px solid rgba(255,255,255,.45);
    border-radius: 10px;
    background: transparent;
    cursor: pointer;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    gap: 5px;
    flex-shrink: 0;
    -webkit-tap-highlight-color: transparent;
}

.nav-toggle span {
    display: block;
    width: 20px;
    height: 2px;
    background: white;
    border-radius: 2px;
    transition: transform .25s ease, opacity .25s ease;
}

.nav-toggle[aria-expanded="true"] span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
.nav-toggle[aria-expanded="true"] span:nth-child(2) { opacity: 0; }
.nav-toggle[aria-expanded="true"] span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

/* =====================================
   ANIMASI
===================================== */

@keyframes navOpen {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: none; }
}

@keyframes navDropIn {
    from { opacity: 0; transform: translateX(-50%) translateY(-6px); }
    to   { opacity: 1; transform: translateX(-50%); }
}

@keyframes navDropInStatic {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: none; }
}

@keyframes navProfileIn {
    from { opacity: 0; transform: translateY(-6px); }
    to   { opacity: 1; transform: none; }
}

/* =====================================
   RESPONSIVE
===================================== */

@media(max-width: 1100px) {
    .nav-menu { gap: 11px; }

    .nav-menu > a,
    .nav-dropdown-toggle { font-size: 11px; }

    .brand-logo { width: 145px; }

    .nav-login { padding: 10px 15px; }
}

@media(max-width: 900px) {
    .navbar {
        --nav-underline: var(--tw-gold);
        min-height: 72px;
        padding: 0 5%;
        gap: 10px;
        background: var(--tw-navy);
    }

    .navbar.scrolled { min-height: 66px; }

    .navbar-spacer { height: 66px; }

    /* Susunan di HP: logo | akun | hamburger */
    .nav-auth { order: 1; }

    .nav-toggle {
        display: flex;
        order: 2;
    }

    .nav-menu {
        order: 3;
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        flex-direction: column;
        align-items: stretch;
        gap: 0;
        padding: 8px 5% 24px;
        background: var(--tw-navy);
        box-shadow: 0 16px 30px rgba(0,0,0,.25);
        max-height: calc(100vh - 72px);
        overflow-y: auto;
    }

    .nav-menu.open {
        display: flex;
        animation: navOpen .28s var(--tw-ease);
    }

    .nav-menu > a,
    .nav-dropdown-toggle {
        font-size: 14px;
        padding: 10px 0;
        width: 100%;
        text-align: left;
        border-bottom: 1px solid rgba(255,255,255,.1);
    }

    .nav-menu > a { display: block; }

    .nav-dropdown-toggle {
        display: flex;
        justify-content: space-between;
    }

    .nav-dropdown-toggle .nav-text { flex: 0 0 auto; }

    .nav-dropdown {
        display: block;
        width: 100%;
    }

    .nav-dropdown-menu {
        position: static;
        transform: none;
        min-width: 0;
        margin: 0 0 6px;
        padding: 6px;
        background: rgba(255,255,255,.06);
        border: 0;
        border-radius: 12px;
        box-shadow: none;
    }

    .nav-dropdown.open .nav-dropdown-menu {
        animation: navDropInStatic .22s var(--tw-ease);
    }

    /* Item pilihan di menu HP (latar gelap) */
    .nav-dropdown-menu .dd-item { color: white; }

    .nav-dropdown-menu .dd-icon {
        background: rgba(255,255,255,.1);
        color: var(--tw-gold);
    }

    .nav-dropdown-menu .dd-item.is-current { background: rgba(255,255,255,.1); }

    .nav-dropdown-menu .dd-item:focus-visible,
    .nav-dropdown-menu .dd-item:active { background: rgba(255,255,255,.12); }

    .nav-dropdown-menu .dd-item:focus-visible .dd-icon,
    .nav-dropdown-menu .dd-item:active .dd-icon,
    .nav-dropdown-menu .dd-item.is-current .dd-icon {
        background: var(--tw-gold);
        color: var(--tw-navy);
    }

    .nav-menu .order-button {
        display: block;
        width: 100%;
        margin-top: 16px;
        padding: 15px 22px;
        text-align: center;
        font-size: 13px;
        border-bottom: 0;
        background: var(--tw-gold);
        color: var(--tw-navy);
        box-shadow: none;
    }

    .nav-menu .order-button:hover,
    .nav-menu .order-button:focus-visible {
        background: white;
        color: var(--tw-navy);
        transform: none;
    }

    /* Akun di HP: ringkas dan tidak menutupi menu */
    .nav-login { padding: 9px 15px; }

    .nav-avatar {
        width: 40px;
        height: 40px;
    }

    .profile-menu {
        position: fixed;
        top: 80px;
        left: 5%;
        right: 5%;
        width: auto;
        max-height: calc(100vh - 100px);
        overflow-y: auto;
    }
}

@media(max-width: 430px) {
    .brand-logo { width: 130px; }
}

@media(max-width: 360px) {
    .brand-logo { width: 112px; }

    .nav-login {
        padding: 8px 12px;
        gap: 6px;
    }
}

@media(prefers-reduced-motion: reduce) {
    html { scroll-behavior: auto; }

    .nav-menu.open,
    .nav-dropdown.open .nav-dropdown-menu,
    .nav-profile.open .profile-menu { animation: none; }

    .nav-text { transition: none; }
}
    .tw-language-switch { display:flex;align-items:center;gap:5px;margin-left:6px;color:#fff;font-size:12px;flex-shrink:0; }
    .tw-language-switch select { border:1px solid rgba(255,255,255,.45);background:rgba(8,39,68,.6);color:#fff;border-radius:20px;padding:7px 8px;font:700 11px Inter,sans-serif;cursor:pointer; }
    .navbar.scrolled .tw-language-switch select { background:#fff;color:var(--tw-navy);border-color:#fff; }
    @media(max-width:760px){.tw-language-switch{margin:0 0 0 8px}.tw-language-switch select{padding:6px 7px;}}
</style>
@endpush
@endonce

<nav class="navbar {{ $isHome ? '' : 'navbar-solid scrolled' }}" id="navbar" aria-label="{{ t3('Navigasi utama', 'Main navigation', '主导航') }}">

    <a href="{{ route('home') }}" class="brand">
        <img
            src="{{ asset('images/terrawood-logo.png') }}"
            alt="TERRAWOOD - Crafting Comfort with Nature"
            class="brand-logo"
            width="165"
            height="60"
        >
    </a>

    <button
        type="button"
        class="nav-toggle"
        id="navToggle"
        aria-label="{{ t3('Buka menu', 'Open menu', '打开菜单') }}"
        aria-expanded="false"
        aria-controls="navMenu"
    >
        <span></span>
        <span></span>
        <span></span>
    </button>

    <div class="nav-menu" id="navMenu">

        <a href="{{ route('home') }}"
           class="nav-link {{ $twCurrent['home'] ? 'is-current' : '' }}"
           @if($twCurrent['home']) aria-current="page" @endif>
            <span class="nav-text">{{ t3('Beranda', 'Home', '首页') }}</span>
        </a>

        <a href="{{ route('catalog.index') }}"
           class="nav-link {{ $twCurrent['catalog'] ? 'is-current' : '' }}"
           @if($twCurrent['catalog']) aria-current="page" @endif>
            <span class="nav-text">{{ t3('Katalog Produk', 'Product Catalog', '产品目录') }}</span>
        </a>

        <div class="nav-dropdown {{ $twCurrent['info'] ? 'is-current' : '' }}">

            <button
                type="button"
                class="nav-dropdown-toggle"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="nav-text">{{ t3('Jelajahi', 'Explore', '探索') }}</span>
                <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $twIc['chevron'] !!}</svg>
            </button>

            <div class="nav-dropdown-menu">

                <a href="{{ route('services.index') }}" class="dd-item {{ $twCurrent['service'] ? 'is-current' : '' }}">
                    <span class="dd-icon">{!! $twIcon('service') !!}</span>
                    <span>{{ t3('Layanan Kami', 'Our Services', '我们的服务') }}</span>
                </a>

                <a href="{{ route('home') }}#tentang" class="dd-item">
                    <span class="dd-icon">{!! $twIcon('about') !!}</span>
                    <span>{{ t3('Tentang Kami', 'About Us', '关于我们') }}</span>
                </a>

                <a href="{{ route('home') }}#kontak" class="dd-item">
                    <span class="dd-icon">{!! $twIcon('contact') !!}</span>
                    <span>{{ t3('Kontak', 'Contact', '联系') }}</span>
                </a>

            </div>

        </div>

        <div class="nav-dropdown {{ $twCurrent['inspire'] ? 'is-current' : '' }}">

            <button
                type="button"
                class="nav-dropdown-toggle"
                aria-expanded="false"
                aria-haspopup="true"
            >
                <span class="nav-text">{{ t3('Inspirasi', 'Inspiration', '灵感') }}</span>
                <svg class="dropdown-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $twIc['chevron'] !!}</svg>
            </button>

            <div class="nav-dropdown-menu">

                <a href="{{ route('articles.index') }}" class="dd-item {{ $twCurrent['article'] ? 'is-current' : '' }}">
                    <span class="dd-icon">{!! $twIcon('article') !!}</span>
                    <span>{{ t3('Artikel', 'Articles', '文章') }}</span>
                </a>

                <a href="{{ route('portfolios.index') }}" class="dd-item {{ $twCurrent['portfolio'] ? 'is-current' : '' }}">
                    <span class="dd-icon">{!! $twIcon('portfolio') !!}</span>
                    <span>{{ t3('Portofolio', 'Portfolio', '作品集') }}</span>
                </a>

                <a href="{{ route('home') }}#mitra" class="dd-item">
                    <span class="dd-icon">{!! $twIcon('partner') !!}</span>
                    <span>{{ t3('Klien & Mitra', 'Clients & Partners', '客户与合作伙伴') }}</span>
                </a>

                <a href="{{ route('home') }}#testimoni" class="dd-item">
                    <span class="dd-icon">{!! $twIcon('testimony') !!}</span>
                    <span>{{ t3('Testimoni', 'Testimonials', '客户评价') }}</span>
                </a>

            </div>

        </div>

        <a href="{{ route('catalog.index') }}" class="order-button">
            {{ t3('Pesan Sekarang', 'Order Now', '立即下单') }}
        </a>

    </div>

    {{-- AKUN: tombol Masuk (tamu) atau avatar inisial (sudah login) --}}
    <div class="nav-auth">

        @if($twAuth)

            <div class="nav-profile"
                 id="navProfile"
                 @if($twIsCustomer)
                     data-status-url="{{ route('account.notifications.status') }}"
                     data-order-base="{{ url('/account/orders') }}"
                 @endif
            >

                <button
                    type="button"
                    class="nav-avatar"
                    id="profileToggle"
                    aria-label="{{ t3('Menu akun', 'Account menu', '账户菜单') }}"
                    aria-expanded="false"
                    aria-haspopup="true"
                    aria-controls="profileMenu"
                >{{ $twInitials }}</button>

                @if($twIsCustomer)
                    <span
                        class="nav-badge js-notification-badge"
                        id="navNotificationBadge"
                        @if($twUnread <= 0) hidden @endif
                    >{{ $twUnread > 9 ? '9+' : $twUnread }}</span>
                @endif

                <div class="profile-menu" id="profileMenu">

                    <div class="profile-head">
                        <span class="profile-avatar-lg" aria-hidden="true">{{ $twInitials }}</span>
                        <div>
                            <strong>{{ $twName !== '' ? $twName : t3('Akun Saya', 'My Account', '我的账户') }}</strong>
                            @if(!empty($twUser->email))
                                <span class="profile-email">{{ $twUser->email }}</span>
                            @endif
                        </div>
                    </div>

                    @if($twIsCustomer && $twAccountUrl)

                        <a href="{{ $twAccountUrl }}" class="dd-item">
                            <span class="dd-icon">{!! $twIcon('user') !!}</span>
                            <span>{{ t3('Profil Saya', 'My Profile', '我的资料') }}</span>
                        </a>

                        <a href="{{ $twAccountUrl }}#notifications" class="dd-item">
                            <span class="dd-icon">{!! $twIcon('bell') !!}</span>
                            <span>{{ t3('Notifikasi', 'Notifications', '通知') }}</span>
                            <span
                                class="dd-count js-notification-badge"
                                @if($twUnread <= 0) hidden @endif
                            >{{ $twUnread > 9 ? '9+' : $twUnread }}</span>
                        </a>

                    @endif

                    @if(!$twIsCustomer && $twAdminUrl)

                        <a href="{{ $twAdminUrl }}" class="dd-item">
                            <span class="dd-icon">{!! $twIcon('dashboard') !!}</span>
                            <span>{{ t3('Dasbor Admin', 'Admin Dashboard', '管理后台') }}</span>
                        </a>

                    @endif

                    <form method="POST" action="{{ $twLogoutUrl }}">
                        @csrf
                        <button type="submit" class="dd-item dd-logout">
                            <span class="dd-icon">{!! $twIcon('logout') !!}</span>
                            <span>{{ t3('Keluar', 'Log Out', '退出登录') }}</span>
                        </button>
                    </form>

                </div>

            </div>

        @else

            <a href="{{ $twLoginUrl }}" class="nav-login">
                {!! $twIcon('login', 16) !!}
                <span>{{ t3('Masuk', 'Log In', '登录') }}</span>
            </a>

        @endif

    </div>

    <div class="tw-language-switch" aria-label="{{ t3('Pilih bahasa', 'Choose language', '选择语言') }}">
        <span aria-hidden="true">🌐</span>
        <select onchange="if(this.value) window.location.href=this.value" aria-label="{{ t3('Bahasa', 'Language', '语言') }}">
            <option value="{{ route('language.switch', 'en') }}" {{ session('site_locale', 'en') === 'en' ? 'selected' : '' }}>EN</option>
            <option value="{{ route('language.switch', 'id') }}" {{ session('site_locale', 'en') === 'id' ? 'selected' : '' }}>ID</option>
            <option value="{{ route('language.switch', 'zh') }}" {{ session('site_locale', 'en') === 'zh' ? 'selected' : '' }}>中文</option>
        </select>
    </div>
</nav>

@unless($isHome)
<div class="navbar-spacer" aria-hidden="true"></div>
@endunless

@once
<script>
document.addEventListener('DOMContentLoaded', function () {

    const navbar = document.getElementById('navbar');

    if (!navbar) return;


    /* =====================================
       NAVBAR: BERUBAH SAAT SCROLL
    ===================================== */

    let scrollTicking = false;

    function updateNavbar() {
        navbar.classList.toggle(
            'scrolled',
            navbar.classList.contains('navbar-solid') || window.scrollY > 40
        );
        scrollTicking = false;
    }

    window.addEventListener('scroll', function () {

        if (!scrollTicking) {
            window.requestAnimationFrame(updateNavbar);
            scrollTicking = true;
        }

    }, { passive: true });

    updateNavbar();


    /* =====================================
       ELEMEN
    ===================================== */

    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    const dropdowns = document.querySelectorAll('.nav-dropdown');
    const profile = document.getElementById('navProfile');
    const profileToggle = document.getElementById('profileToggle');


    /* =====================================
       FUNGSI BUKA / TUTUP
       (hanya satu panel terbuka pada satu waktu,
        sehingga profil tidak menutupi menu)
    ===================================== */

    function closeMobileMenu() {
        navMenu.classList.remove('open');
        navToggle.setAttribute('aria-expanded', 'false');
        navToggle.setAttribute('aria-label', @json(t3('Buka menu', 'Open menu', '打开菜单')));
    }

    function closeAllDropdowns() {

        dropdowns.forEach(function (dropdown) {

            dropdown.classList.remove('open');

            dropdown.querySelector('.nav-dropdown-toggle')
                .setAttribute('aria-expanded', 'false');

        });

    }

    function closeProfile() {

        if (!profile || !profileToggle) return;

        profile.classList.remove('open');
        profileToggle.setAttribute('aria-expanded', 'false');

    }


    /* =====================================
       MENU HAMBURGER (MOBILE)
    ===================================== */

    navToggle.addEventListener('click', function (event) {

        event.stopPropagation();

        const isOpen = navMenu.classList.toggle('open');

        navToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        navToggle.setAttribute('aria-label', isOpen ? @json(t3('Tutup menu', 'Close menu', '关闭菜单')) : @json(t3('Buka menu', 'Open menu', '打开菜单')));

        if (isOpen) {
            closeProfile();
        }

    });

    navMenu.addEventListener('click', function (event) {

        if (event.target.closest('a')) {
            closeMobileMenu();
        }

    });

    window.addEventListener('resize', function () {

        if (window.innerWidth > 900) {
            closeMobileMenu();
        }

    });


    /* =====================================
       DROPDOWN NAVBAR
    ===================================== */

    dropdowns.forEach(function (dropdown) {

        const toggle = dropdown.querySelector('.nav-dropdown-toggle');

        toggle.addEventListener('click', function (event) {

            event.stopPropagation();

            dropdowns.forEach(function (otherDropdown) {

                if (otherDropdown !== dropdown) {

                    otherDropdown.classList.remove('open');

                    otherDropdown.querySelector('.nav-dropdown-toggle')
                        .setAttribute('aria-expanded', 'false');

                }

            });

            const isOpen = dropdown.classList.toggle('open');

            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            if (isOpen) {
                closeProfile();
            }

        });

    });


    /* =====================================
       MENU PROFIL (SUDAH LOGIN)
    ===================================== */

    if (profile && profileToggle) {

        profileToggle.addEventListener('click', function (event) {

            event.stopPropagation();

            const isOpen = profile.classList.toggle('open');

            profileToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

            if (isOpen) {
                closeMobileMenu();
                closeAllDropdowns();
            }

        });

    }


    /* =====================================
       TUTUP SAAT KLIK DI LUAR / TEKAN ESC
    ===================================== */

    document.addEventListener('click', function (event) {

        if (!event.target.closest('.nav-dropdown')) {
            closeAllDropdowns();
        }

        if (!event.target.closest('.nav-profile')) {
            closeProfile();
        }

        if (!event.target.closest('.navbar')) {
            closeMobileMenu();
        }

    });

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeAllDropdowns();
            closeProfile();
            closeMobileMenu();
        }

    });

});
</script>
@endonce