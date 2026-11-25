@extends('layouts.app')

@include('partials.i18n')

@section('title', $product->localized('name') . ' | TERRAWOOD')

@section('content')

@php
    /* =====================================
       IKON (SVG)
    ===================================== */
    $ic = [
        'arrow'   => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
        'zoom'    => '<circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/>',
        'share'   => '<circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/>',
        'image'   => '<rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.09-3.09a2 2 0 0 0-2.82 0L6 21"/>',
        'leaf'    => '<path d="M11 20C5 17 4 11 7 5c5 0 9 3 9 8 0 3-2 6-5 7Z"/><path d="M5 21c2-5 6-8 12-11"/><path d="M16 4c2-1 4-1 5-1 0 2 0 4-1 6"/>',
        'shield'  => '<path d="m12 3 8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4Z"/><path d="m8.5 12 2.3 2.3 4.8-5"/>',
        'headset' => '<path d="M4 13v-2a8 8 0 0 1 16 0v2"/><path d="M4 13h3v6H6a2 2 0 0 1-2-2v-4Z"/><path d="M20 13h-3v6h1a2 2 0 0 0 2-2v-4Z"/><path d="M17 19c-1 2-3 2-5 2"/>',
        'globe'   => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3a14 14 0 0 1 0 18"/><path d="M12 3a14 14 0 0 0 0 18"/>',
        'x'       => '<path d="M18 6 6 18"/><path d="m6 6 12 12"/>',
    ];

    $icon = function ($name, $size = 18) use ($ic) {
        return '<svg class="dt-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
    };

    /* =====================================
       DATA PRODUK
    ===================================== */
    $categoryName = $product->category?->localized('name') ?? t3('Furnitur', 'Furniture', '家具');
    $categoryId   = $product->category?->id;

    $imageUrl = $product->image
        ? \Illuminate\Support\Facades\Storage::url($product->image)
        : null;

    $hasPrice  = !empty($product->price) && (float) $product->price > 0;

    // Harga efektif: pakai harga diskon bila valid (lebih kecil dari harga normal)
    $hasDiscount    = $hasPrice
        && !empty($product->discount_price)
        && (float) $product->discount_price > 0
        && (float) $product->discount_price < (float) $product->price;
    $effectivePrice = $hasDiscount ? (float) $product->discount_price : (float) ($product->price ?? 0);

    $priceText = $hasPrice
        ? 'Rp ' . number_format((float) $product->price, 0, ',', '.')
        : t3('Hubungi kami', 'Contact us', '联系我们');

    $descText  = trim((string) $product->localized('description'));
    $plainDesc = trim(strip_tags($descText !== '' ? $descText : t3('Produk pilihan dari TERRAWOOD.', 'A selected product from TERRAWOOD.', '来自 TERRAWOOD 的精选产品。')));
    $shortDesc = $descText !== '' ? \Illuminate\Support\Str::limit($plainDesc, 170) : '';
    $metaDesc  = \Illuminate\Support\Str::limit($plainDesc, 155);

    $productUrl = route('catalog.show', $product->slug);

    /* =====================================
       TOMBOL PESAN (logika sama seperti sebelumnya)
    ===================================== */
    if (auth()->check() && auth()->user()->role === 'user') {
        $orderUrl   = route('account.orders.create', $product->slug);
        $orderLabel = t3('Pesan Sekarang', 'Order Now', '立即下单');
    } elseif (auth()->check()) {
        $orderUrl   = route('login');
        $orderLabel = t3('Login sebagai Customer', 'Login as Customer', '以客户身份登录');
    } else {
        $orderUrl   = route('login');
        $orderLabel = t3('Login untuk Memesan', 'Login to Order', '登录后下单');
    }

    /* =====================================
       PRODUK TERKAIT
       (memakai $relatedProducts dari controller jika ada)
    ===================================== */
    if (isset($relatedProducts)) {
        $related = collect($relatedProducts)->take(4);
    } else {
        try {
            $related = \App\Models\Product::where('id', '!=', $product->id)
                ->when(data_get($product, 'category_id'), function ($query, $categoryKey) {
                    $query->where('category_id', $categoryKey);
                })
                ->latest()
                ->take(4)
                ->get();

            if ($related->isEmpty()) {
                $related = \App\Models\Product::where('id', '!=', $product->id)
                    ->latest()
                    ->take(4)
                    ->get();
            }
        } catch (\Throwable $e) {
            $related = collect();
        }
    }

    /* =====================================
       DATA TERSTRUKTUR (SEO)
    ===================================== */
    $schema = [
        '@context'    => 'https://schema.org',
        '@type'       => 'Product',
        'name'        => $product->localized('name'),
        'description' => $metaDesc,
        'category'    => $categoryName,
        'brand'       => ['@type' => 'Brand', 'name' => 'TERRAWOOD'],
        'url'         => $productUrl,
    ];

    if ($imageUrl) {
        $schema['image'] = url($imageUrl);
    }

    if ($hasPrice) {
        $schema['offers'] = [
            '@type'         => 'Offer',
            'priceCurrency' => 'IDR',
            'price'         => (string) (int) $effectivePrice,
            'url'           => $productUrl,
        ];
    }
@endphp

{{-- Meta SEO & pratinjau saat dibagikan (WhatsApp, dll.) --}}
@push('styles')
    <meta name="description" content="{{ $metaDesc }}">
    <link rel="canonical" href="{{ $productUrl }}">
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="TERRAWOOD">
    <meta property="og:title" content="{{ $product->localized('name') }} | TERRAWOOD">
    <meta property="og:description" content="{{ $metaDesc }}">
    <meta property="og:url" content="{{ $productUrl }}">
    @if($imageUrl)
        <meta property="og:image" content="{{ url($imageUrl) }}">
    @endif
@endpush

@include('partials.navbar')

<style>
    .detail-page,
    .detail-page *,
    .detail-page *::before,
    .detail-page *::after { box-sizing: border-box; }

    .detail-page {
        --d-navy: #082744;
        --d-gold: #F5A623;
        --d-ivory: #F7F5EF;
        --d-text: #293747;
        --d-muted: #718096;
        --d-line: #E9E5DC;
        --d-amber: #B47A13;
        --d-ease: cubic-bezier(.22, .61, .36, 1);

        min-height: 70vh;
        padding: 36px 6% 90px;
        background: var(--d-ivory);
        color: var(--d-text);
        font-family: 'Inter', sans-serif;
    }

    .detail-container {
        max-width: 1150px;
        margin: 0 auto;
    }

    .detail-page a { text-decoration: none; }

    .detail-page a:focus-visible,
    .detail-page button:focus-visible {
        outline: 2px solid var(--d-gold);
        outline-offset: 3px;
    }

    .dt-ic { display: block; flex-shrink: 0; }

    /* =====================================
       BREADCRUMB
    ===================================== */

    .breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 22px;
        color: var(--d-muted);
        font-size: 12.5px;
    }

    .breadcrumb a {
        color: var(--d-navy);
        font-weight: 600;
        transition: color .25s ease;
    }

    .breadcrumb a:hover { color: var(--d-amber); }

    .breadcrumb [aria-current] {
        color: var(--d-muted);
        font-weight: 600;
    }

    /* =====================================
       KARTU UTAMA
    ===================================== */

    .detail-card {
        display: grid;
        grid-template-columns: 1.05fr 1fr;
        overflow: hidden;
        border: 1px solid var(--d-line);
        border-radius: 22px;
        background: white;
        box-shadow: 0 14px 38px rgba(8,39,68,.07);
    }

    .detail-media {
        position: relative;
        min-height: 480px;
        background: linear-gradient(135deg, #ECE9E1, #F4F1EA);
    }

    .detail-zoom {
        position: absolute;
        inset: 0;
        display: block;
        width: 100%;
        height: 100%;
        padding: 0;
        border: 0;
        background: transparent;
        cursor: zoom-in;
        -webkit-tap-highlight-color: transparent;
    }

    .detail-zoom img {
        display: block;
        width: 100%;
        height: 100%;
        padding: 28px;
        object-fit: contain;
        transition: transform .5s var(--d-ease);
    }

    @media (hover: hover) {
        .detail-zoom:hover img { transform: scale(1.04); }
    }

    .zoom-hint {
        position: absolute;
        right: 16px;
        bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 14px;
        border-radius: 999px;
        background: rgba(8,39,68,.82);
        color: white;
        font-size: 12px;
        font-weight: 700;
        pointer-events: none;
    }

    .detail-no-image {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 20px;
        color: #9AA3AE;
        font-size: 14px;
        text-align: center;
    }

    .detail-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 44px;
    }

    .detail-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 16px;
    }

    .tag {
        padding: 6px 13px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: .6px;
        text-transform: uppercase;
    }

    .tag-cat {
        background: #FFF3DC;
        color: #8A5600;
        transition: background-color .25s ease;
    }

    a.tag-cat:hover { background: #FFE6BB; }

    .tag-featured {
        background: var(--d-navy);
        color: var(--d-gold);
    }

    .detail-info h1 {
        margin: 0 0 14px;
        color: var(--d-navy);
        font-size: clamp(26px, 3vw, 34px);
        font-weight: 800;
        line-height: 1.25;
    }

    .detail-price {
        margin-bottom: 18px;
        color: var(--d-navy);
        font-family: 'Manrope', sans-serif;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
    }

    .detail-price.is-ask {
        color: var(--d-amber);
        font-size: 22px;
    }

    .detail-summary {
        margin: 0 0 22px;
        color: var(--d-muted);
        font-size: 15px;
        line-height: 1.8;
    }

    .trust-list {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px 16px;
        margin: 0 0 28px;
        padding: 22px 0;
        border-top: 1px solid #EFEBE2;
        border-bottom: 1px solid #EFEBE2;
        list-style: none;
    }

    .trust-list li {
        display: flex;
        align-items: center;
        gap: 11px;
        color: var(--d-text);
        font-size: 12.5px;
        font-weight: 600;
        line-height: 1.35;
    }

    .trust-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #FFF3DC;
        color: #B87308;
    }

    /* =====================================
       TOMBOL AKSI
    ===================================== */

    .detail-actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 12px;
    }

    .detail-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        padding: 15px 26px;
        border: 0;
        border-radius: 999px;
        font-family: 'Manrope', 'Inter', sans-serif;
        font-size: 14px;
        font-weight: 800;
        line-height: 1;
        text-align: center;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
        touch-action: manipulation;
        transition:
            background-color .3s var(--d-ease),
            color .3s var(--d-ease),
            border-color .3s var(--d-ease),
            transform .3s var(--d-ease),
            box-shadow .3s var(--d-ease);
    }

    .detail-btn .dt-ic { transition: transform .3s var(--d-ease); }

    .btn-order {
        background: var(--d-gold);
        color: var(--d-navy);
        box-shadow: 0 8px 20px rgba(245,166,35,.3);
    }

    .btn-ghost {
        border: 1.5px solid #DCD5C6;
        background: white;
        color: var(--d-navy);
    }

    .detail-btn:active {
        transform: translateY(0) scale(.97);
        transition-duration: .12s;
    }

    @media (hover: hover) {
        .detail-btn:hover { transform: translateY(-2px); }

        .btn-order:hover {
            background: var(--d-navy);
            color: white;
            box-shadow: 0 12px 26px rgba(8,39,68,.25);
        }

        .btn-order:hover .dt-ic { transform: translateX(3px); }

        .btn-ghost:hover {
            border-color: var(--d-gold);
            background: #FFF9F0;
        }
    }

    /* =====================================
       DESKRIPSI
    ===================================== */

    .detail-section {
        margin-top: 26px;
        padding: 34px;
        border: 1px solid var(--d-line);
        border-radius: 20px;
        background: white;
    }

    .detail-section h2 {
        margin: 0 0 16px;
        color: var(--d-navy);
        font-size: 20px;
        font-weight: 800;
    }

    .detail-description {
        color: #4A5568;
        font-size: 15px;
        line-height: 1.9;
        white-space: pre-line;
    }

    /* =====================================
       PRODUK TERKAIT
    ===================================== */

    .related-section { margin-top: 46px; }

    .related-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 14px;
        margin-bottom: 18px;
    }

    .related-head h2 {
        margin: 0;
        color: var(--d-navy);
        font-size: 22px;
        font-weight: 800;
    }

    .related-head a {
        color: var(--d-amber);
        font-size: 13px;
        font-weight: 800;
        white-space: nowrap;
        transition: color .25s ease;
    }

    .related-head a:hover { color: var(--d-navy); }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .related-card {
        display: block;
        overflow: hidden;
        border: 1px solid var(--d-line);
        border-radius: 16px;
        background: white;
        box-shadow: 0 2px 10px rgba(8,39,68,.04);
        -webkit-tap-highlight-color: transparent;
        transition: transform .35s var(--d-ease), box-shadow .35s var(--d-ease), border-color .35s var(--d-ease);
    }

    .related-card:active {
        transform: scale(.985);
        transition-duration: .12s;
    }

    @media (hover: hover) {
        .related-card:hover {
            transform: translateY(-5px);
            border-color: #EBC98F;
            box-shadow: 0 12px 26px rgba(8,39,68,.1);
        }

        .related-card:hover .related-image img { transform: scale(1.05); }
    }

    .related-image {
        height: 170px;
        overflow: hidden;
        background: #ECE9E1;
    }

    .related-image img {
        width: 100%;
        height: 100%;
        padding: 10px;
        object-fit: contain;
        transition: transform .5s var(--d-ease);
    }

    .related-image .no-image {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #9AA3AE;
    }

    .related-body { padding: 14px 16px 16px; }

    .related-cat {
        color: var(--d-amber);
        font-size: 10.5px;
        font-weight: 800;
        letter-spacing: .7px;
        text-transform: uppercase;
    }

    .related-name {
        display: -webkit-box;
        min-height: 2.8em;
        margin: 6px 0;
        overflow: hidden;
        color: var(--d-navy);
        font-size: 14.5px;
        font-weight: 800;
        line-height: 1.4;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .related-price {
        color: var(--d-text);
        font-size: 13.5px;
        font-weight: 700;
    }

    /* =====================================
       BAR TOMBOL DI HP
    ===================================== */

    .mobile-bar,
    .mobile-bar-spacer { display: none; }

    /* =====================================
       LIGHTBOX & TOAST
    ===================================== */

    .lightbox {
        position: fixed;
        inset: 0;
        z-index: 100000;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 24px;
        background: rgba(6,29,51,.92);
        animation: lightboxIn .25s ease;
    }

    .lightbox[hidden] { display: none; }

    .lightbox img {
        max-width: min(1000px, 100%);
        max-height: 100%;
        border-radius: 14px;
        background: #F4F1EA;
        object-fit: contain;
    }

    .lightbox-close {
        position: absolute;
        top: 18px;
        right: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border: 0;
        border-radius: 50%;
        background: rgba(255,255,255,.14);
        color: white;
        cursor: pointer;
        transition: background-color .25s ease;
    }

    .lightbox-close:hover { background: rgba(255,255,255,.28); }

    .copy-toast {
        position: fixed;
        left: 50%;
        bottom: 96px;
        z-index: 100001;
        padding: 12px 22px;
        border-radius: 999px;
        background: var(--d-navy);
        color: white;
        font-size: 13px;
        font-weight: 700;
        box-shadow: 0 10px 28px rgba(0,0,0,.25);
        transform: translateX(-50%);
        animation: toastIn .3s var(--d-ease);
    }

    @keyframes lightboxIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(-50%) translateY(10px); }
        to   { opacity: 1; transform: translateX(-50%); }
    }

    /* =====================================
       RESPONSIVE
    ===================================== */

    @media (max-width: 1000px) {
        .related-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 800px) {
        .detail-page {
            padding: 24px 5% 40px;
        }

        .detail-card { grid-template-columns: 1fr; }

        .detail-media { min-height: 340px; }

        .detail-zoom img { padding: 18px; }

        .detail-info { padding: 28px 24px; }

        .trust-list { margin-bottom: 8px; }

        /* Tombol di dalam kartu disembunyikan, diganti bar menempel di bawah layar */
        .detail-actions .btn-order { display: none; }

        .detail-actions { margin-top: 18px; }

        .detail-section { padding: 24px 20px; }

        .related-section { margin-top: 36px; }

        .mobile-bar {
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
            border-top: 1px solid var(--d-line);
            background: white;
            box-shadow: 0 -8px 24px rgba(8,39,68,.08);
        }

        .mobile-price small {
            display: block;
            color: var(--d-muted);
            font-size: 11px;
            font-weight: 600;
        }

        .mobile-price strong {
            display: block;
            color: var(--d-navy);
            font-family: 'Manrope', sans-serif;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.2;
        }

        .mobile-bar .detail-btn {
            flex-shrink: 0;
            padding: 14px 22px;
            font-size: 13px;
        }

        .mobile-bar-spacer {
            display: block;
            height: 78px;
            background: #061D33;
        }

        /* Tombol WhatsApp melayang naik agar tidak menimpa bar */
        .whatsapp-float {
            bottom: calc(92px + env(safe-area-inset-bottom, 0px));
        }

        .copy-toast { bottom: 100px; }
    }

    @media (max-width: 500px) {
        .trust-list { grid-template-columns: 1fr; }

        .detail-actions .detail-btn,
        .detail-actions .wa-product-button {
            width: 100%;
        }

        .related-image { height: 130px; }

        .related-grid { gap: 12px; }

        .related-body { padding: 12px; }

        .related-name { font-size: 13px; }
    }

    @media (max-width: 340px) {
        .related-grid { grid-template-columns: 1fr; }
    }

    @media (hover: none) {
        .related-card:hover {
            transform: none;
            border-color: var(--d-line);
            box-shadow: 0 2px 10px rgba(8,39,68,.04);
        }

        .related-card:hover .related-image img { transform: none; }
    }

    @media (prefers-reduced-motion: reduce) {
        .lightbox,
        .copy-toast { animation: none; }

        .detail-zoom img,
        .related-image img { transition: none; }
    }
</style>

<div class="detail-page">
    <div class="detail-container">

        {{-- BREADCRUMB --}}
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">{{ t3('Beranda', 'Home', '首页') }}</a>
            <span aria-hidden="true">›</span>
            <a href="{{ route('catalog.index') }}">{{ t3('Katalog', 'Catalog', '目录') }}</a>
            @if($categoryId)
                <span aria-hidden="true">›</span>
                <a href="{{ route('catalog.index', ['category' => $categoryId]) }}">{{ $categoryName }}</a>
            @endif
            <span aria-hidden="true">›</span>
            <span aria-current="page">{{ \Illuminate\Support\Str::limit($product->localized('name'), 40) }}</span>
        </nav>

        <section class="detail-card">

            {{-- GAMBAR PRODUK --}}
            <div class="detail-media">

                @if($imageUrl)

                    <button type="button" class="detail-zoom" id="zoomBtn" aria-label="{{ t3('Perbesar gambar', 'Enlarge image', '放大图片') }} {{ $product->localized('name') }}">
                        <img
                            src="{{ $imageUrl }}"
                            alt="{{ $product->localized('name') }}"
                            width="800"
                            height="800"
                            decoding="async"
                        >
                        <span class="zoom-hint">{!! $icon('zoom', 16) !!} {{ t3('Perbesar', 'Zoom', '放大') }}</span>
                    </button>

                @else

                    <div class="detail-no-image">
                        {!! $icon('image', 40) !!}
                        {{ t3('Gambar produk belum tersedia', 'Product image not available yet', '暂无产品图片') }}
                    </div>

                @endif

            </div>

            {{-- INFORMASI PRODUK --}}
            <div class="detail-info">

                <div class="detail-tags">

                    @if($categoryId)
                        <a href="{{ route('catalog.index', ['category' => $categoryId]) }}" class="tag tag-cat">
                            {{ $categoryName }}
                        </a>
                    @else
                        <span class="tag tag-cat">{{ $categoryName }}</span>
                    @endif

                    @if($product->is_featured)
                        <span class="tag tag-featured">{{ t3('Unggulan', 'Featured', '精选') }}</span>
                    @endif

                </div>

                <h1>{{ $product->localized('name') }}</h1>

                <div class="detail-price {{ $hasPrice ? '' : 'is-ask' }}">
                    @if($product->discount_price && $product->discount_price < $product->price)
    <span style="display:block;text-decoration:line-through;color:#8893a0;font-size:14px;font-weight:500;">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
    <span style="display:block;color:#B47A13;">Rp {{ number_format((float) $product->discount_price, 0, ',', '.') }}</span>
@else
    {{ $priceText }}
@endif
                </div>

                @if($shortDesc !== '')
                    <p class="detail-summary">{{ $shortDesc }}</p>
                @endif

                {{-- Keunggulan (sama dengan yang ada di beranda; sesuaikan jika perlu) --}}
                <ul class="trust-list">

                    <li>
                        <span class="trust-icon">{!! $icon('leaf', 20) !!}</span>
                        {{ t3('Material berkualitas & ramah lingkungan', 'Quality & eco-friendly materials', '优质环保材料') }}
                    </li>

                    <li>
                        <span class="trust-icon">{!! $icon('shield', 20) !!}</span>
                        {{ t3('Desain modern dan elegan', 'Modern and elegant design', '现代优雅的设计') }}
                    </li>

                    <li>
                        <span class="trust-icon">{!! $icon('headset', 20) !!}</span>
                        {{ t3('Layanan profesional & responsif', 'Professional & responsive service', '专业且响应迅速的服务') }}
                    </li>

                    <li>
                        <span class="trust-icon">{!! $icon('globe', 20) !!}</span>
                        {{ t3('Pengiriman aman ke berbagai negara', 'Safe shipping to many countries', '安全配送至多个国家') }}
                    </li>

                </ul>

                {{-- TOMBOL AKSI --}}
                <div class="detail-actions">

                    <a href="{{ $orderUrl }}" class="detail-btn btn-order">
                        {{ $orderLabel }} {!! $icon('arrow', 16) !!}
                    </a>

                    @include('partials.wa-product-button', ['product' => $product])

                    <button type="button" class="detail-btn btn-ghost" id="shareBtn">
                        {!! $icon('share', 16) !!} {{ t3('Bagikan', 'Share', '分享') }}
                    </button>

                </div>

            </div>

        </section>

        {{-- DESKRIPSI --}}
        @if($descText !== '')

            <section class="detail-section">
                <h2>{{ t3('Deskripsi Produk', 'Product Description', '产品描述') }}</h2>
                <div class="detail-description">{{ $descText }}</div>
            </section>

        @endif

        {{-- PRODUK TERKAIT --}}
        @if($related->isNotEmpty())

            <section class="related-section">

                <div class="related-head">
                    <h2>{{ t3('Produk Lainnya', 'More Products', '更多产品') }}</h2>
                    <a href="{{ route('catalog.index') }}">{{ t3('Lihat Semua', 'View All', '查看全部') }} →</a>
                </div>

                <div class="related-grid">

                    @foreach($related as $item)

                        <a href="{{ route('catalog.show', $item->slug) }}" class="related-card">

                            <div class="related-image">
                                @if($item->image)
                                    <img
                                        src="{{ \Illuminate\Support\Facades\Storage::url($item->image) }}"
                                        alt="{{ $item->localized('name') }}"
                                        width="400"
                                        height="300"
                                        loading="lazy"
                                        decoding="async"
                                    >
                                @else
                                    <div class="no-image">{!! $icon('image', 28) !!}</div>
                                @endif
                            </div>

                            <div class="related-body">
                                <div class="related-cat">{{ $item->category?->localized('name') ?? t3('Furnitur', 'Furniture', '家具') }}</div>
                                <div class="related-name">{{ $item->localized('name') }}</div>
                                <div class="related-price">
                                    @if(!empty($item->price) && (float) $item->price > 0)
                                        Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                                    @else
                                        {{ t3('Hubungi kami', 'Contact us', '联系我们') }}
                                    @endif
                                </div>
                            </div>

                        </a>

                    @endforeach

                </div>

            </section>

        @endif

    </div>
</div>

{{-- BAR TOMBOL DI HP --}}
<div class="mobile-bar">

    <div class="mobile-price">
        <small>{{ t3('Harga', 'Price', '价格') }}</small>
        <strong>@if($product->discount_price && $product->discount_price < $product->price)
    <span style="display:block;text-decoration:line-through;color:#8893a0;font-size:14px;font-weight:500;">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
    <span style="display:block;color:#B47A13;">Rp {{ number_format((float) $product->discount_price, 0, ',', '.') }}</span>
@else
    {{ $priceText }}
@endif</strong>
    </div>

    <a href="{{ $orderUrl }}" class="detail-btn btn-order">
        {{ $orderLabel }}
    </a>

</div>

{{-- LIGHTBOX GAMBAR --}}
@if($imageUrl)
    <div class="lightbox" id="lightbox" hidden role="dialog" aria-modal="true" aria-label="{{ t3('Gambar produk', 'Product image', '产品图片') }}">
        <button type="button" class="lightbox-close" id="lightboxClose" aria-label="{{ t3('Tutup', 'Close', '关闭') }}">
            {!! $icon('x', 22) !!}
        </button>
        <img src="{{ $imageUrl }}" alt="{{ $product->localized('name') }}">
    </div>
@endif

@include('partials.footer')

<div class="mobile-bar-spacer" aria-hidden="true"></div>

{{-- DATA TERSTRUKTUR --}}
<script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =====================================
       LIGHTBOX GAMBAR
    ===================================== */

    const zoomButton = document.getElementById('zoomBtn');
    const lightbox = document.getElementById('lightbox');
    const lightboxClose = document.getElementById('lightboxClose');

    function openLightbox() {
        lightbox.hidden = false;
        document.body.style.overflow = 'hidden';
        lightboxClose.focus();
    }

    function closeLightbox() {
        lightbox.hidden = true;
        document.body.style.overflow = '';
        if (zoomButton) zoomButton.focus();
    }

    if (zoomButton && lightbox && lightboxClose) {

        zoomButton.addEventListener('click', openLightbox);

        lightboxClose.addEventListener('click', closeLightbox);

        lightbox.addEventListener('click', function (event) {
            if (event.target === lightbox) closeLightbox();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && !lightbox.hidden) closeLightbox();
        });

    }


    /* =====================================
       BAGIKAN PRODUK
    ===================================== */

    const shareButton = document.getElementById('shareBtn');

    function showToast(message) {

        const toast = document.createElement('div');

        toast.className = 'copy-toast';
        toast.setAttribute('role', 'status');
        toast.textContent = message;

        document.body.appendChild(toast);

        setTimeout(function () {
            toast.remove();
        }, 2500);

    }

    if (shareButton) {

        shareButton.addEventListener('click', async function () {

            const shareData = {
                title: document.title,
                url: window.location.href
            };

            if (navigator.share) {

                try {
                    await navigator.share(shareData);
                } catch (error) {
                    /* pengguna membatalkan */
                }

                return;
            }

            try {

                await navigator.clipboard.writeText(shareData.url);

                showToast(@json(t3('Link produk disalin', 'Product link copied', '产品链接已复制')));

            } catch (error) {

                window.prompt(@json(t3('Salin link produk ini:', 'Copy this product link:', '复制此产品链接：')), shareData.url);

            }

        });

    }

});
</script>

@endsection