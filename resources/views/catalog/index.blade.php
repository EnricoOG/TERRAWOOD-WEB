@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Katalog Produk', 'Product Catalog', '产品目录') . ' | TERRAWOOD')

@section('content')

@php
    /* =====================================
       IKON (SVG)
    ===================================== */
    $ic = [
        'search' => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/>',
        'x'      => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
        'arrow'  => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'image'  => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
    ];

    $icon = function ($name, $size = 18) use ($ic) {
        return '<svg class="cat-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    $waIcon = '<svg class="cat-ic" width="18" height="18" viewBox="0 0 32 32" aria-hidden="true"><path fill="currentColor" d="M16.02 3.2A12.7 12.7 0 0 0 5.1 22.38L3.4 28.6l6.37-1.67A12.7 12.7 0 1 0 16.02 3.2Zm0 23.1c-1.98 0-3.92-.53-5.62-1.53l-.4-.24-3.78.99 1.01-3.68-.26-.42a10.38 10.38 0 1 1 9.05 4.88Zm5.7-7.77c-.31-.16-1.84-.91-2.12-1.01-.29-.1-.5-.16-.71.16-.21.31-.81 1.01-.99 1.22-.18.21-.36.23-.67.08-.31-.16-1.3-.48-2.47-1.53-.91-.81-1.53-1.81-1.71-2.12-.18-.31-.02-.48.14-.64.14-.14.31-.36.47-.54.16-.18.21-.31.31-.52.1-.21.05-.39-.03-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54h-.6c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.61s1.13 3.03 1.28 3.24c.16.21 2.22 3.39 5.38 4.75.75.32 1.33.51 1.78.65.75.24 1.44.2 1.98.12.6-.09 1.84-.75 2.1-1.48.26-.73.26-1.35.18-1.48-.08-.13-.29-.21-.6-.37Z"/></svg>';

    /* =====================================
       WHATSAPP (nomor diatur di config/terrawood.php)
    ===================================== */
    $waNumber = '6281320122571';

    $waProductUrl = function ($productName) use ($waNumber) {
        return 'https://wa.me/' . $waNumber . '?text='
             . rawurlencode(t3(
                 'Halo TERRAWOOD, saya tertarik dengan produk "' . $productName . '". Apakah masih tersedia?',
                 'Hello TERRAWOOD, I am interested in the product "' . $productName . '". Is it still available?',
                 '您好 TERRAWOOD，我对产品“' . $productName . '”感兴趣。请问还有货吗？'
             ));
    };

    /* =====================================
       FILTER & URL
    ===================================== */
    $searchTerm = trim((string) ($search ?? ''));
    $sortValue  = $sort ?? null;

    $hasFilters = $searchTerm !== '' || filled($categoryId ?? null);

    /* Parameter yang dipertahankan saat memilih kategori (pencarian & urutan) */
    $queryWithoutCategory = collect(request()->query())
        ->except(['page', 'category'])
        ->filter(function ($value) { return filled($value); })
        ->all();

    $queryWithoutSearch = collect(request()->query())
        ->except(['page', 'search'])
        ->filter(function ($value) { return filled($value); })
        ->all();

    $categoryUrl = function ($id = null) use ($queryWithoutCategory) {
        $query = $queryWithoutCategory;

        if ($id) {
            $query['category'] = $id;
        }

        return route('catalog.index', $query);
    };

    $activeCategory = $categories->firstWhere('id', $categoryId ?? null);
@endphp

@include('partials.navbar')

<style>
    .catalog-page,
    .catalog-page *,
    .catalog-page *::before,
    .catalog-page *::after { box-sizing: border-box; }

    .catalog-page {
        --c-navy: #082744;
        --c-gold: #F5A623;
        --c-orange: #FFA43A;
        --c-ivory: #F7F5EF;
        --c-text: #293747;
        --c-muted: #718096;
        --c-line: #E9E5DC;
        --c-amber: #B47A13;
        --c-ease: cubic-bezier(.22, .61, .36, 1);

        min-height: 70vh;
        padding: 36px 6% 80px;
        background: var(--c-ivory);
        color: var(--c-text);
        font-family: 'Inter', sans-serif;
    }

    .catalog-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    .catalog-page a { text-decoration: none; }

    .catalog-page a:focus-visible,
    .catalog-page button:focus-visible,
    .catalog-page select:focus-visible {
        outline: 2px solid var(--c-gold);
        outline-offset: 3px;
    }

    .cat-ic { display: block; flex-shrink: 0; }

    /* =====================================
       HERO
    ===================================== */

    .catalog-hero {
        position: relative;
        overflow: hidden;
        padding: 44px 48px;
        margin-bottom: 28px;
        border-radius: 20px;
        background: linear-gradient(115deg, #082744, #123e63);
        color: white;
        box-shadow: 0 14px 32px rgba(8,39,68,.14);
    }

    .catalog-hero::before,
    .catalog-hero::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
    }

    .catalog-hero::before {
        right: -90px;
        top: -130px;
        width: 320px;
        height: 320px;
        border: 1px solid rgba(245,166,35,.28);
    }

    .catalog-hero::after {
        right: 60px;
        bottom: -110px;
        width: 200px;
        height: 200px;
        border: 1px solid rgba(255,255,255,.1);
    }

    .catalog-hero > * {
        position: relative;
        z-index: 1;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 18px;
        color: #B9C6D3;
        font-size: 12.5px;
    }

    .breadcrumb a {
        color: #D6E0E9;
        transition: color .25s ease;
    }

    .breadcrumb a:hover { color: var(--c-gold); }

    .breadcrumb [aria-current] {
        color: var(--c-gold);
        font-weight: 700;
    }

    .catalog-hero h1 {
        margin: 0 0 12px;
        font-size: clamp(30px, 4vw, 42px);
        font-weight: 800;
        line-height: 1.15;
    }

    .catalog-hero h1 span { color: var(--c-gold); }

    .catalog-hero p {
        max-width: 620px;
        margin: 0;
        color: #D6E0E9;
        font-size: 15px;
        line-height: 1.75;
    }

    /* =====================================
       PENCARIAN & URUTAN
    ===================================== */

    .catalog-tools {
        display: flex;
        align-items: stretch;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .catalog-search {
        display: flex;
        flex: 1;
        gap: 10px;
        min-width: 240px;
    }

    .search-field {
        position: relative;
        flex: 1;
        min-width: 0;
    }

    .search-field > .cat-ic {
        position: absolute;
        left: 17px;
        top: 50%;
        transform: translateY(-50%);
        color: #9AA3AE;
        pointer-events: none;
    }

    .search-field input {
        width: 100%;
        height: 50px;
        padding: 0 46px 0 47px;
        border: 1.5px solid #E2DED5;
        border-radius: 999px;
        background: white;
        color: var(--c-text);
        font-family: inherit;
        font-size: 14px;
        transition: border-color .25s ease, box-shadow .25s ease;
    }

    .search-field input:focus {
        border-color: var(--c-gold);
        box-shadow: 0 0 0 4px rgba(245,166,35,.15);
        outline: none;
    }

    .search-clear {
        position: absolute;
        right: 10px;
        top: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        color: #9AA3AE;
        transform: translateY(-50%);
        transition: background-color .2s ease, color .2s ease;
    }

    .search-clear:hover {
        background: #F1EDE3;
        color: var(--c-navy);
    }

    .catalog-submit {
        height: 50px;
        padding: 0 26px;
        border: 0;
        border-radius: 999px;
        background: var(--c-gold);
        color: var(--c-navy);
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        transition: background-color .3s var(--c-ease), color .3s var(--c-ease), transform .3s var(--c-ease);
    }

    .catalog-submit:active {
        transform: scale(.96);
        transition-duration: .12s;
    }

    @media (hover: hover) {
        .catalog-submit:hover {
            background: var(--c-navy);
            color: white;
        }
    }

    .catalog-sort select {
        min-width: 195px;
        height: 50px;
        padding: 0 44px 0 20px;
        border: 1.5px solid #E2DED5;
        border-radius: 999px;
        background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23082744' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E") no-repeat right 16px center / 14px;
        color: var(--c-navy);
        font-family: inherit;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        -webkit-appearance: none;
        appearance: none;
        transition: border-color .25s ease;
    }

    .catalog-sort select:hover { border-color: var(--c-gold); }

    /* =====================================
       CHIP KATEGORI
    ===================================== */

    .category-chips {
        position: relative;
        display: flex;
        gap: 8px;
        padding: 4px 2px 10px;
        margin-bottom: 6px;
        overflow-x: auto;
        scrollbar-width: none;
        -webkit-overflow-scrolling: touch;
    }

    .category-chips::-webkit-scrollbar { display: none; }

    .chip {
        flex: 0 0 auto;
        padding: 10px 18px;
        border: 1.5px solid #E3DDCF;
        border-radius: 999px;
        background: white;
        color: var(--c-muted);
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
        -webkit-tap-highlight-color: transparent;
        transition:
            background-color .25s var(--c-ease),
            color .25s var(--c-ease),
            border-color .25s var(--c-ease),
            transform .25s var(--c-ease);
    }

    .chip:active {
        transform: scale(.96);
        transition-duration: .12s;
    }

    .chip.active {
        border-color: var(--c-navy);
        background: var(--c-navy);
        color: white;
    }

    @media (hover: hover) {
        .chip:not(.active):hover {
            border-color: var(--c-gold);
            color: var(--c-navy);
        }
    }

    /* =====================================
       INFO HASIL & FILTER AKTIF
    ===================================== */

    .catalog-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin: 18px 0 22px;
    }

    .result-count {
        margin: 0;
        color: var(--c-muted);
        font-size: 14px;
    }

    .result-count strong { color: var(--c-navy); }

    .filter-tags {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .filter-tag {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 6px 8px 6px 13px;
        border-radius: 999px;
        background: #FFF3DC;
        color: #8A5600;
        font-size: 12px;
        font-weight: 700;
    }

    .filter-tag a {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: rgba(138,86,0,.12);
        color: #8A5600;
        transition: background-color .2s ease, color .2s ease;
    }

    .filter-tag a:hover {
        background: #8A5600;
        color: white;
    }

    .filter-reset {
        color: var(--c-amber);
        font-size: 12.5px;
        font-weight: 800;
        transition: color .25s ease;
    }

    .filter-reset:hover { color: var(--c-navy); }

    /* =====================================
       GRID & KARTU PRODUK
    ===================================== */

    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 22px;
    }

    .product-card {
        position: relative;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border: 1px solid var(--c-line);
        border-radius: 16px;
        background: white;
        box-shadow: 0 2px 10px rgba(8,39,68,.04);
        -webkit-tap-highlight-color: transparent;
        transition:
            transform .35s var(--c-ease),
            box-shadow .35s var(--c-ease),
            border-color .35s var(--c-ease);
    }

    .product-card:active {
        transform: scale(.985);
        transition-duration: .12s;
    }

    .product-image {
        position: relative;
        height: 230px;
        overflow: hidden;
        background: #ECE9E1;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        padding: 14px;
        object-fit: contain;
        transition: transform .5s var(--c-ease);
    }

    .product-no-image {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 8px;
        height: 100%;
        color: #9AA3AE;
        font-size: 13px;
    }

    .product-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        z-index: 1;
        padding: 5px 11px;
        border-radius: 999px;
        background: var(--c-gold);
        color: var(--c-navy);
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .4px;
    }

    .product-info {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 18px;
    }

    .product-category {
        color: var(--c-amber);
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: .7px;
        text-transform: uppercase;
    }

    .product-info h3 {
        display: -webkit-box;
        min-height: 2.8em;
        margin: 8px 0;
        overflow: hidden;
        color: var(--c-navy);
        font-size: 16px;
        font-weight: 800;
        line-height: 1.4;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-description {
        display: -webkit-box;
        flex: 1;
        margin-bottom: 14px;
        overflow: hidden;
        color: var(--c-muted);
        font-size: 13px;
        line-height: 1.6;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .product-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-bottom: 14px;
    }

    .product-price {
        color: var(--c-navy);
        font-family: 'Manrope', sans-serif;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.2;
    }

    .product-price.is-ask {
        color: var(--c-amber);
        font-size: 14px;
    }

    .product-wa {
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #E8F8EF;
        color: #1B9B52;
        -webkit-tap-highlight-color: transparent;
        transition: background-color .3s var(--c-ease), color .3s var(--c-ease), transform .3s var(--c-ease);
    }

    .product-wa:active {
        transform: scale(.92);
        transition-duration: .12s;
    }

    @media (hover: hover) {
        .product-wa:hover {
            background: #20C76A;
            color: white;
        }
    }

    .product-button {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-radius: 999px;
        background: var(--c-navy);
        color: white;
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 800;
        transition: background-color .3s var(--c-ease), color .3s var(--c-ease);
    }

    .product-button .cat-ic { transition: transform .3s var(--c-ease); }

    /* Membuat seluruh kartu bisa diklik */
    .product-button::before {
        content: "";
        position: absolute;
        inset: 0;
    }

    @media (hover: hover) {
        .product-card:hover {
            transform: translateY(-6px);
            border-color: #EBC98F;
            box-shadow: 0 14px 30px rgba(8,39,68,.1);
        }

        .product-card:hover .product-image img { transform: scale(1.05); }

        .product-card:hover .product-button {
            background: var(--c-gold);
            color: var(--c-navy);
        }

        .product-card:hover .product-button .cat-ic { transform: translateX(3px); }
    }

    /* =====================================
       TAMPILAN KOSONG
    ===================================== */

    .empty-catalog {
        grid-column: 1 / -1;
        padding: 64px 20px;
        border: 1px dashed #DCD5C6;
        border-radius: 18px;
        background: white;
        text-align: center;
    }

    .empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 76px;
        height: 76px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #FFF3DC;
        color: #B87308;
    }

    .empty-catalog h3 {
        margin: 0 0 8px;
        color: var(--c-navy);
        font-size: 20px;
        font-weight: 800;
    }

    .empty-catalog p {
        max-width: 380px;
        margin: 0 auto 24px;
        color: var(--c-muted);
        line-height: 1.7;
    }

    .empty-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 13px 26px;
        border-radius: 999px;
        background: var(--c-gold);
        color: var(--c-navy);
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 13px;
        font-weight: 800;
        transition: background-color .3s var(--c-ease), color .3s var(--c-ease);
    }

    @media (hover: hover) {
        .empty-btn:hover {
            background: var(--c-navy);
            color: white;
        }
    }

    .pagination-wrapper { margin-top: 38px; }

    /* =====================================
       RESPONSIVE
    ===================================== */

    @media (max-width: 1100px) {
        .product-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }

    @media (max-width: 750px) {
        .catalog-page { padding: 24px 5% 70px; }

        .catalog-hero {
            padding: 30px 24px;
            border-radius: 18px;
        }

        .catalog-hero p { font-size: 14px; }

        .catalog-tools { flex-direction: column; }

        .catalog-search { min-width: 0; }

        .catalog-sort select { width: 100%; }

        .category-chips {
            margin-right: -5vw;
            padding-right: 5vw;
            -webkit-mask-image: linear-gradient(to right, #000 88%, transparent);
            mask-image: linear-gradient(to right, #000 88%, transparent);
        }

        .catalog-meta { margin: 14px 0 18px; }

        .product-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .product-image { height: 165px; }

        .product-image img { padding: 10px; }

        .product-badge {
            top: 8px;
            left: 8px;
            padding: 4px 9px;
            font-size: 10px;
        }

        .product-info { padding: 12px; }

        .product-category { font-size: 10px; }

        .product-info h3 {
            margin: 6px 0;
            font-size: 13.5px;
        }

        .product-description { display: none; }

        .product-bottom {
            flex: 1;
            align-items: flex-end;
            margin-bottom: 10px;
        }

        .product-price { font-size: 14.5px; }

        .product-wa {
            width: 32px;
            height: 32px;
        }

        .product-button {
            padding: 10px;
            font-size: 12px;
        }
    }

    @media (max-width: 340px) {
        .product-grid { grid-template-columns: 1fr; }
    }

    /* Perangkat sentuh: tanpa efek hover yang menempel */
    @media (hover: none) {
        .product-card:hover {
            transform: none;
            border-color: var(--c-line);
            box-shadow: 0 2px 10px rgba(8,39,68,.04);
        }

        .product-card:hover .product-image img { transform: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .product-card,
        .product-image img,
        .chip { transition: none; }
    }
</style>

<div class="catalog-page">
    <div class="catalog-container">

        {{-- HERO --}}
        <section class="catalog-hero">

            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('home') }}">{{ t3('Beranda', 'Home', '首页') }}</a>
                <span aria-hidden="true">›</span>
                <span aria-current="page">{{ t3('Katalog', 'Catalog', '目录') }}</span>
            </nav>

            <h1>{!! t3('Jelajahi <span>Koleksi Kami.</span>', 'Explore Our <span>Collection.</span>', '探索我们的<span>系列产品。</span>') !!}</h1>

            <p>
                {{ t3(
                    'Temukan furnitur dan dekorasi berkualitas untuk menciptakan ruang yang nyaman, elegan, dan alami.',
                    'Discover quality furniture and decor to create a comfortable, elegant and natural space.',
                    '探索优质家具与装饰，打造舒适、优雅且自然的空间。'
                ) }}
                Crafting Comfort With Nature.
            </p>

        </section>

        {{-- PENCARIAN & URUTAN --}}
        <form action="{{ route('catalog.index') }}"
              method="GET"
              class="catalog-tools"
              role="search">

            @if(filled($categoryId ?? null))
                <input type="hidden" name="category" value="{{ $categoryId }}">
            @endif

            <div class="catalog-search">

                <div class="search-field">

                    {!! $icon('search', 18) !!}

                    <input
                        type="search"
                        name="search"
                        placeholder="{{ t3('Cari nama produk...', 'Search product name...', '搜索产品名称...') }}"
                        value="{{ $searchTerm }}"
                        autocomplete="off"
                        aria-label="{{ t3('Cari produk', 'Search products', '搜索产品') }}"
                    >

                    @if($searchTerm !== '')
                        <a href="{{ route('catalog.index', $queryWithoutSearch) }}"
                           class="search-clear"
                           aria-label="{{ t3('Hapus pencarian', 'Clear search', '清除搜索') }}">
                            {!! $icon('x', 16) !!}
                        </a>
                    @endif

                </div>

                <button type="submit" class="catalog-submit">
                    {{ t3('Cari', 'Search', '搜索') }}
                </button>

            </div>

            {{-- Urutan muncul otomatis jika controller mengirim variabel $sort --}}
            @isset($sort)
                <div class="catalog-sort">
                    <select name="sort" onchange="this.form.submit()" aria-label="{{ t3('Urutkan produk', 'Sort products', '产品排序') }}">
                        <option value="newest" {{ $sortValue === 'newest' ? 'selected' : '' }}>{{ t3('Terbaru', 'Newest', '最新') }}</option>
                        <option value="price_asc" {{ $sortValue === 'price_asc' ? 'selected' : '' }}>{{ t3('Harga Terendah', 'Price: Low to High', '价格从低到高') }}</option>
                        <option value="price_desc" {{ $sortValue === 'price_desc' ? 'selected' : '' }}>{{ t3('Harga Tertinggi', 'Price: High to Low', '价格从高到低') }}</option>
                        <option value="name_asc" {{ $sortValue === 'name_asc' ? 'selected' : '' }}>{{ t3('Nama A–Z', 'Name A–Z', '名称 A–Z') }}</option>
                    </select>
                </div>
            @endisset

        </form>

        {{-- KATEGORI --}}
        <nav class="category-chips" aria-label="{{ t3('Kategori produk', 'Product categories', '产品分类') }}">

            <a href="{{ $categoryUrl(null) }}"
               class="chip {{ filled($categoryId ?? null) ? '' : 'active' }}">
                {{ t3('Semua', 'All', '全部') }}
            </a>

            @foreach($categories as $category)

                @php $isActive = (string) ($categoryId ?? '') === (string) $category->id; @endphp

                <a href="{{ $categoryUrl($category->id) }}"
                   class="chip {{ $isActive ? 'active' : '' }}"
                   @if($isActive) aria-current="true" @endif>
                    {{ $category->localized('name') }}
                </a>

            @endforeach

        </nav>

        {{-- INFO HASIL & FILTER AKTIF --}}
        <div class="catalog-meta">

            <p class="result-count">
                @if($products->total() > 0)
                    {{ t3('Menampilkan', 'Showing', '显示') }}
                    <strong>{{ $products->firstItem() }}–{{ $products->lastItem() }}</strong>
                    {{ t3('dari', 'of', '共') }} <strong>{{ $products->total() }}</strong> {{ t3('produk', 'products', '件产品') }}
                @else
                    <strong>0</strong> {{ t3('produk ditemukan', 'products found', '件产品') }}
                @endif
            </p>

            @if($hasFilters)

                <div class="filter-tags">

                    @if($searchTerm !== '')
                        <span class="filter-tag">
                            “{{ \Illuminate\Support\Str::limit($searchTerm, 24) }}”
                            <a href="{{ route('catalog.index', $queryWithoutSearch) }}" aria-label="{{ t3('Hapus pencarian', 'Clear search', '清除搜索') }}">
                                {!! $icon('x', 12) !!}
                            </a>
                        </span>
                    @endif

                    @if($activeCategory)
                        <span class="filter-tag">
                            {{ $activeCategory->name }}
                            <a href="{{ $categoryUrl(null) }}" aria-label="{{ t3('Hapus kategori', 'Remove category', '移除分类') }}">
                                {!! $icon('x', 12) !!}
                            </a>
                        </span>
                    @endif

                    <a href="{{ route('catalog.index') }}" class="filter-reset">{{ t3('Hapus semua', 'Clear all', '全部清除') }}</a>

                </div>

            @endif

        </div>

        {{-- DAFTAR PRODUK --}}
        <div class="product-grid">

            @forelse($products as $product)

                @php
                    $pImage = $product->image
                        ? \Illuminate\Support\Facades\Storage::url($product->image)
                        : null;

                    $pHasPrice = !empty($product->price) && (float) $product->price > 0;
                @endphp

                <article class="product-card">

                    <div class="product-image">

                        @if($product->is_featured)
                            <span class="product-badge">{{ t3('Unggulan', 'Featured', '精选') }}</span>
                        @endif

                        @if($pImage)
                            <img
                                src="{{ $pImage }}"
                                alt="{{ $product->localized('name') }}"
                                width="480"
                                height="360"
                                loading="lazy"
                                decoding="async"
                            >
                        @else
                            <div class="product-no-image">
                                {!! $icon('image', 30) !!}
                                {{ t3('Foto segera hadir', 'Photo coming soon', '图片即将上线') }}
                            </div>
                        @endif

                    </div>

                    <div class="product-info">

                        <div class="product-category">
                            {{ $product->category?->localized('name') ?? t3('Furnitur', 'Furniture', '家具') }}
                        </div>

                        <h3>{{ $product->localized('name') }}</h3>

                        <div class="product-description">
                            {{ \Illuminate\Support\Str::limit($product->localized('description') ?? t3('Produk pilihan TERRAWOOD.', 'A TERRAWOOD selected product.', 'TERRAWOOD 精选产品。'), 75) }}
                        </div>

                        <div class="product-bottom">

                            @if($pHasPrice)
                                <div class="product-price">
                                    @if($product->discount_price && $product->discount_price < $product->price)
                                        <span style="display:block;text-decoration:line-through;color:#8893a0;font-size:12px;font-weight:500;">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                        <span style="display:block;color:#B47A13;">Rp {{ number_format((float) $product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                    @endif
                                </div>
                            @else
                                <div class="product-price is-ask">
                                    {{ t3('Hubungi kami', 'Contact us', '联系我们') }}
                                </div>
                            @endif

                            <a href="{{ $waProductUrl($product->localized('name')) }}"
                               class="product-wa"
                               target="_blank"
                               rel="noopener"
                               aria-label="{{ t3('Tanya ' . $product->localized('name') . ' via WhatsApp', 'Ask about ' . $product->localized('name') . ' via WhatsApp', '通过 WhatsApp 咨询 ' . $product->localized('name')) }}">
                                {!! $waIcon !!}
                            </a>

                        </div>

                        <a href="{{ route('catalog.show', $product->slug) }}"
                           class="product-button">
                            {{ t3('Lihat Detail', 'View Details', '查看详情') }} {!! $icon('arrow', 15) !!}
                        </a>

                    </div>

                </article>

            @empty

                <div class="empty-catalog">

                    <div class="empty-icon">{!! $icon('search', 32) !!}</div>

                    <h3>{{ t3('Produk Belum Ditemukan', 'No Products Found', '未找到产品') }}</h3>

                    <p>
                        {{ t3(
                            'Coba gunakan kata kunci atau kategori lainnya, atau lihat semua koleksi kami.',
                            'Try another keyword or category, or browse our full collection.',
                            '请尝试其他关键词或分类，或浏览我们的全部系列。'
                        ) }}
                    </p>

                    <a href="{{ route('catalog.index') }}" class="empty-btn">
                        {{ t3('Lihat Semua Produk', 'View All Products', '查看全部产品') }}
                    </a>

                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->except('page'))->links('vendor.pagination.terrawood') }}
            </div>
        @endif

    </div>
</div>

@include('partials.footer')

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* Geser chip kategori agar yang aktif terlihat di tengah (tanpa menggulir halaman) */

    const chips = document.querySelector('.category-chips');
    const activeChip = document.querySelector('.category-chips .chip.active');

    if (chips && activeChip) {

        const target = activeChip.offsetLeft - (chips.clientWidth - activeChip.offsetWidth) / 2;

        chips.scrollLeft = Math.max(0, target);

    }

});
</script>

@endsection