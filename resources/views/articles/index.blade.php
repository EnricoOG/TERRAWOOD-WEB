@extends('layouts.app')

@include('partials.i18n')
@section('title', t3('Artikel', 'Articles', '文章') . ' | TERRAWOOD')

@section('content')

@php
    $items    = $articles->getCollection();
    // Artikel pertama di halaman 1 tampil besar sebagai artikel unggulan
    $featured = $articles->onFirstPage() ? $items->first() : null;
    $others   = $featured ? $items->slice(1) : $items;

    $readingTime = fn ($article) => max(1, (int) ceil(str_word_count(strip_tags((string) $article->localized('content'))) / 200));
    $formatDate  = fn ($date) => $date ? $date->copy()->locale(session('site_locale', 'en') === 'zh' ? 'zh_CN' : session('site_locale', 'en'))->translatedFormat('d F Y') : null;
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       ARTIKEL - TERRAWOOD
       ========================================================= */

    .article-page,
    .article-page *,
    .article-page *::before,
    .article-page *::after {
        box-sizing: border-box;
    }

    .article-page {
        --navy: #082744;
        --navy-deep: #061d33;
        --amber: #F5A623;
        --amber-dark: #e69a19;
        --amber-text: #A9660F;
        --cream: #F7F5EF;
        --ink: #293747;
        --muted: #687481;
        --line: #EEEAE2;

        min-height: 100vh;
        background: var(--cream);
        color: var(--ink);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    .article-page .icon {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
        fill: none;
        stroke: currentColor;
        stroke-width: 2;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    @keyframes articleRise {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* ---------- HERO ---------- */

    .article-hero {
        position: relative;
        overflow: hidden;
        padding: 100px 6% 135px;
        text-align: center;
        color: #fff;
        background:
            radial-gradient(900px 420px at 82% -15%, rgba(245, 166, 35, .22), transparent 62%),
            radial-gradient(700px 380px at 6% 110%, rgba(245, 166, 35, .10), transparent 60%),
            linear-gradient(160deg, #0c3560 0%, #082744 55%, #061d33 100%);
    }

    .article-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(90deg, rgba(255, 255, 255, .028) 0 2px, transparent 2px 16px);
        pointer-events: none;
    }

    .article-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 720px;
        margin: 0 auto;
    }

    .article-hero-inner > * {
        animation: articleRise .8s cubic-bezier(.2, .7, .2, 1) both;
    }

    .article-hero-inner > *:nth-child(2) { animation-delay: .1s; }
    .article-hero-inner > *:nth-child(3) { animation-delay: .2s; }

    .article-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: var(--amber);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .3em;
        text-transform: uppercase;
    }

    .article-eyebrow::before,
    .article-eyebrow::after {
        content: "";
        width: 34px;
        height: 1px;
        background: rgba(245, 166, 35, .6);
    }

    .article-hero h1 {
        margin: 20px 0 18px;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: clamp(36px, 5vw, 58px);
        font-weight: 700;
        line-height: 1.15;
    }

    .article-hero p {
        max-width: 620px;
        margin: 0 auto;
        color: #D5DEE6;
        font-size: 15px;
        line-height: 1.85;
    }

    /* ---------- CONTAINER ---------- */

    .article-container {
        max-width: 1250px;
        width: 88%;
        margin: 0 auto;
        padding: 75px 0 95px;
    }

    .article-container.has-featured {
        position: relative;
        z-index: 2;
        margin-top: -75px;
        padding-top: 0;
    }

    /* ---------- REVEAL SAAT SCROLL ---------- */

    .has-js [data-reveal] {
        opacity: 0;
        transform: translateY(26px);
        transition: opacity .7s ease, transform .7s cubic-bezier(.2, .7, .2, 1);
    }

    .has-js [data-reveal].is-visible {
        opacity: 1;
        transform: none;
    }

    /* ---------- PLACEHOLDER GAMBAR ---------- */

    .article-placeholder {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, #F3F0E8, #E3DDCF);
        color: var(--navy);
    }

    .article-placeholder .icon {
        width: 34px;
        height: 34px;
        stroke: var(--amber-text);
        stroke-width: 1.6;
    }

    .article-placeholder span {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: .28em;
    }

    /* ---------- ARTIKEL UNGGULAN ---------- */

    .article-featured {
        display: grid;
        grid-template-columns: 1.15fr 1fr;
        overflow: hidden;
        border-radius: 22px;
        background: #fff;
        box-shadow: 0 26px 60px rgba(8, 39, 68, .18);
        color: inherit;
        text-decoration: none;
        transition: box-shadow .4s ease, transform .4s cubic-bezier(.2, .7, .2, 1);
    }

    .article-featured-media {
        position: relative;
        min-height: 410px;
        overflow: hidden;
        background: #E8E4DA;
    }

    .article-featured-media img,
    .article-image img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .8s cubic-bezier(.2, .7, .2, 1);
    }

    .article-featured-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 46px 44px;
    }

    .article-featured-body h2 {
        margin: 14px 0 16px;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(26px, 3vw, 36px);
        font-weight: 700;
        line-height: 1.3;
        transition: color .25s ease;
    }

    .article-featured .article-excerpt {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 4;
        line-clamp: 4;
        overflow: hidden;
        margin: 0 0 22px;
        font-size: 15px;
    }

    .article-featured-cta {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        align-self: flex-start;
        margin-top: 26px;
        padding: 13px 24px;
        border-radius: 999px;
        background: var(--navy);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        transition: background .25s ease, gap .25s ease;
    }

    .article-featured-cta .icon {
        width: 16px;
        height: 16px;
    }

    /* ---------- LABEL & META ---------- */

    .article-chip {
        position: absolute;
        top: 16px;
        left: 16px;
        z-index: 2;
        padding: 6px 13px;
        border-radius: 999px;
        background: rgba(255, 255, 255, .93);
        color: var(--amber-text);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
    }

    .article-chip-solid {
        background: var(--amber);
        color: var(--navy);
    }

    .article-category {
        color: var(--amber-text);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .article-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px 16px;
        color: var(--muted);
        font-size: 12px;
    }

    .article-meta span {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* ---------- JUDUL BAGIAN ---------- */

    .article-heading {
        margin: 70px 0 34px;
    }

    .article-container:not(.has-featured) .article-heading {
        margin-top: 0;
    }

    .article-heading span {
        color: var(--amber-text);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .2em;
    }

    .article-heading h2 {
        margin: 10px 0 8px;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 34px;
        font-weight: 700;
    }

    .article-heading p {
        margin: 0;
        color: var(--muted);
        font-size: 14px;
    }

    /* ---------- GRID & KARTU ---------- */

    .article-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
    }

    .article-grid-item {
        display: flex;
    }

    .article-card {
        display: flex;
        flex-direction: column;
        width: 100%;
        overflow: hidden;
        border: 1px solid rgba(8, 39, 68, .05);
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(8, 39, 68, .06);
        color: inherit;
        text-decoration: none;
        transition: transform .4s cubic-bezier(.2, .7, .2, 1), box-shadow .4s ease;
    }

    .article-image {
        position: relative;
        aspect-ratio: 16 / 11;
        overflow: hidden;
        background: #E8E4DA;
    }

    .article-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 24px;
    }

    .article-content h3 {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        overflow: hidden;
        margin: 0 0 12px;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 21px;
        font-weight: 700;
        line-height: 1.4;
        transition: color .25s ease;
    }

    .article-excerpt {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        overflow: hidden;
        margin: 0 0 20px;
        color: var(--muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .article-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid var(--line);
    }

    .article-readmore {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: var(--navy);
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        transition: color .25s ease, gap .25s ease;
    }

    .article-readmore .icon {
        width: 15px;
        height: 15px;
    }

    @media (hover: hover) {
        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 24px 46px rgba(8, 39, 68, .15);
        }

        .article-card:hover .article-image img,
        .article-featured:hover .article-featured-media img {
            transform: scale(1.07);
        }

        .article-card:hover h3,
        .article-featured:hover h2 {
            color: var(--amber-text);
        }

        .article-card:hover .article-readmore {
            gap: 11px;
            color: var(--amber-text);
        }

        .article-featured:hover {
            transform: translateY(-5px);
            box-shadow: 0 34px 70px rgba(8, 39, 68, .22);
        }

        .article-featured:hover .article-featured-cta {
            gap: 15px;
            background: var(--amber-text);
        }
    }

    .article-card:focus-visible,
    .article-featured:focus-visible {
        outline: 3px solid var(--amber);
        outline-offset: 4px;
    }

    /* ---------- KOSONG ---------- */

    .article-empty {
        padding: 70px 20px;
        border-radius: 18px;
        background: #fff;
        box-shadow: 0 8px 28px rgba(8, 39, 68, .06);
        color: var(--muted);
        text-align: center;
    }

    .article-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 72px;
        height: 72px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: var(--cream);
        color: var(--amber-text);
    }

    .article-empty-icon .icon {
        width: 30px;
        height: 30px;
    }

    .article-empty h3 {
        margin: 0 0 8px;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 24px;
    }

    .article-empty p {
        max-width: 420px;
        margin: 0 auto;
        font-size: 14px;
        line-height: 1.8;
    }

    /* ---------- PAGINATION ---------- */

    .article-pagination {
        display: flex;
        justify-content: center;
        margin-top: 50px;
    }

    .article-pagination svg {
        width: 18px;
        height: 18px;
    }

    .article-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .article-pagination .page-link {
        color: var(--navy);
    }

    .article-pagination .page-item.active .page-link {
        border-color: var(--navy);
        background: var(--navy);
        color: #fff;
    }

    /* ---------- RESPONSIF ---------- */

    @media (max-width: 1000px) {
        .article-featured {
            grid-template-columns: 1fr;
        }

        .article-featured-media {
            min-height: 0;
            aspect-ratio: 16 / 9;
        }

        .article-featured-body {
            padding: 32px 28px 34px;
        }

        .article-container.has-featured {
            margin-top: -60px;
        }
    }

    @media (max-width: 900px) {
        .article-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .article-hero {
            padding: 75px 6% 105px;
        }

        .article-eyebrow::before,
        .article-eyebrow::after {
            width: 20px;
        }

        .article-grid {
            grid-template-columns: 1fr;
        }

        .article-container {
            width: 90%;
            padding: 50px 0 70px;
        }

        .article-container.has-featured {
            margin-top: -48px;
            padding-top: 0;
        }

        .article-heading {
            margin: 52px 0 26px;
        }

        .article-heading h2 {
            font-size: 28px;
        }

        .article-featured-body {
            padding: 26px 22px 28px;
        }

        .article-featured-cta {
            width: 100%;
            justify-content: center;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .article-page *,
        .article-page *::before,
        .article-page *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="article-page">

    <script>
        // Aktifkan animasi scroll hanya jika browser mendukung dan pengguna tidak membatasi animasi
        (function () {
            var supported = 'IntersectionObserver' in window;
            var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            if (supported && !reduced && document.currentScript) {
                document.currentScript.parentNode.classList.add('has-js');
            }
        })();
    </script>

    <section class="article-hero">
        <div class="article-hero-inner">
            <span class="article-eyebrow">{{ t3('Jurnal Kami', 'Our Journal', '我们的期刊') }}</span>
            <h1>{{ t3('Cerita & Inspirasi.', 'Stories & Inspiration.', '故事与灵感。') }}</h1>
            <p>
                {{ t3(
                    'Temukan inspirasi, informasi, dan berbagai cerita menarik seputar furnitur, dekorasi, desain interior, serta perkembangan TERRAWOOD.',
                    'Discover inspiration, information and engaging stories about furniture, decor, interior design and the latest from TERRAWOOD.',
                    '发现关于家具、装饰、室内设计以及 TERRAWOOD 动态的灵感、资讯与精彩故事。'
                ) }}
            </p>
        </div>
    </section>

    <section class="article-container {{ $featured ? 'has-featured' : '' }}">

        {{-- ARTIKEL UNGGULAN (halaman 1) --}}
        @if($featured)
            <div data-reveal>
                <a
                    href="{{ route('articles.show', $featured->slug) }}"
                    class="article-featured"
                    aria-label="{{ session('site_locale', 'en') === 'id' ? 'Baca artikel' : (session('site_locale') === 'zh' ? '阅读文章' : 'Read article') }} {{ $featured->title }}"
                >
                    <div class="article-featured-media">
                        <div class="article-placeholder" aria-hidden="true">
                            <svg class="icon" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="2"/>
                                <circle cx="8.5" cy="8.5" r="1.5"/>
                                <path d="M21 15l-5-5L5 21"/>
                            </svg>
                            <span>TERRAWOOD</span>
                        </div>

                        @if($featured->image)
                            <img
                                src="{{ asset('storage/' . $featured->image) }}"
                                alt="{{ $featured->title }}"
                                onerror="this.style.display='none'"
                            >
                        @endif

                        <span class="article-chip article-chip-solid">{{ session('site_locale', 'en') === 'id' ? 'Artikel Terbaru' : (session('site_locale') === 'zh' ? '最新文章' : 'Latest Article') }}</span>
                    </div>

                    <div class="article-featured-body">
                        <span class="article-category">
                            {{ $featured->category ?: 'TERRAWOOD Journal' }}
                        </span>

                        <h2>{{ $featured->title }}</h2>

                        <p class="article-excerpt">
                            {{ \Illuminate\Support\Str::limit($featured->excerpt ?: strip_tags((string) $featured->content), 220) }}
                        </p>

                        <div class="article-meta">
                            <span>
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                    <line x1="16" y1="2" x2="16" y2="6"/>
                                    <line x1="8" y1="2" x2="8" y2="6"/>
                                    <line x1="3" y1="10" x2="21" y2="10"/>
                                </svg>
                                {{ $formatDate($featured->published_at) ?? (session('site_locale', 'en') === 'id' ? 'Artikel TERRAWOOD' : (session('site_locale') === 'zh' ? 'TERRAWOOD 文章' : 'TERRAWOOD Articles')) }}
                            </span>
                            <span>
                                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"/>
                                    <polyline points="12 6 12 12 16 14"/>
                                </svg>
                                {{ t3($readingTime($featured) . ' menit baca', $readingTime($featured) . ' min read', '阅读约 ' . $readingTime($featured) . ' 分钟') }}
                            </span>
                        </div>

                        <span class="article-featured-cta">
                            {{ session('site_locale', 'en') === 'id' ? 'Baca Artikel' : (session('site_locale') === 'zh' ? '阅读文章' : 'Read Article') }}
                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
            </div>
        @endif

        {{-- DAFTAR ARTIKEL --}}
        @if($others->count())

            <div class="article-heading" data-reveal>
                <span>INSIGHTS &amp; INSPIRATION</span>
                <h2>{{ session('site_locale', 'en') === 'id' ? ($featured ? 'Artikel Lainnya' : 'Arsip Artikel') : (session('site_locale') === 'zh' ? ($featured ? '更多文章' : '文章归档') : ($featured ? 'More Articles' : 'Article Archive')) }}</h2>
                <p>Informasi dan inspirasi untuk ruang yang lebih nyaman.</p>
            </div>

            <div class="article-grid">

                @foreach($others as $article)

                    <div class="article-grid-item" data-reveal>
                        <a
                            href="{{ route('articles.show', $article->slug) }}"
                            class="article-card"
                            aria-label="{{ session('site_locale', 'en') === 'id' ? 'Baca artikel' : (session('site_locale') === 'zh' ? '阅读文章' : 'Read article') }} {{ $article->localized('title') }}"
                        >

                            <div class="article-image">
                                <div class="article-placeholder" aria-hidden="true">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                                        <circle cx="8.5" cy="8.5" r="1.5"/>
                                        <path d="M21 15l-5-5L5 21"/>
                                    </svg>
                                    <span>TERRAWOOD</span>
                                </div>

                                @if($article->image)
                                    <img
                                        src="{{ asset('storage/' . $article->image) }}"
                                        alt="{{ $article->localized('title') }}"
                                        loading="lazy"
                                        onerror="this.style.display='none'"
                                    >
                                @endif

                                <span class="article-chip">
                                    {{ $article->localized('category') ?: 'TERRAWOOD Journal' }}
                                </span>
                            </div>

                            <div class="article-content">

                                <h3>{{ $article->localized('title') }}</h3>

                                <p class="article-excerpt">
                                    {{ \Illuminate\Support\Str::limit($article->localized('excerpt') ?: strip_tags((string) $article->localized('content')), 130) }}
                                </p>

                                <div class="article-footer">

                                    <div class="article-meta">
                                        <span>
                                            <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                                <line x1="16" y1="2" x2="16" y2="6"/>
                                                <line x1="8" y1="2" x2="8" y2="6"/>
                                                <line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                            {{ $formatDate($article->published_at) ?? (session('site_locale', 'en') === 'id' ? 'Artikel TERRAWOOD' : (session('site_locale') === 'zh' ? 'TERRAWOOD 文章' : 'TERRAWOOD Articles')) }}
                                        </span>
                                    </div>

                                    <span class="article-readmore">
                                        {{ $readingTime($article) }} mnt baca
                                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </span>

                                </div>

                            </div>

                        </a>
                    </div>

                @endforeach

            </div>

        @elseif(!$featured)

            <div class="article-empty" data-reveal>
                <div class="article-empty-icon">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <h3>{{ session('site_locale', 'en') === 'id' ? 'Belum Ada Artikel' : (session('site_locale') === 'zh' ? '暂无文章' : 'No Articles Yet') }}</h3>
                <p>
                    {{ session('site_locale', 'en') === 'id' ? 'Artikel terbaru TERRAWOOD akan ditampilkan' : (session('site_locale') === 'zh' ? 'TERRAWOOD 最新文章将在此显示' : 'The latest TERRAWOOD articles will appear here') }}
                    di halaman ini.
                </p>
            </div>

        @endif

        @if($articles->hasPages())
            <div class="article-pagination">
                {{ $articles->links() }}
            </div>
        @endif

    </section>

</div>

<script>
    (function () {
        'use strict';

        var page = document.querySelector('.article-page');
        if (!page || !page.classList.contains('has-js')) return;

        var items = Array.prototype.slice.call(page.querySelectorAll('[data-reveal]'));

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -6% 0px' });

        items.forEach(function (el) {
            // kartu di dalam grid muncul bergantian per kolom
            if (el.classList.contains('article-grid-item')) {
                var position = Array.prototype.indexOf.call(el.parentNode.children, el);
                el.style.transitionDelay = ((position % 3) * 90) + 'ms';
            }

            observer.observe(el);
        });
    })();
</script>

@endsection