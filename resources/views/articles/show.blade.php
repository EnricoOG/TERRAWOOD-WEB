@extends('layouts.app')
@include('partials.i18n')

@section('title', $article->localized('title') . ' | TERRAWOOD')

@section('content')

@php
    $content      = trim((string) $article->localized('content'));
    // Baris kosong dipakai sebagai pemisah paragraf
    $paragraphs   = $content !== ''
        ? array_values(array_filter(array_map('trim', preg_split('/(?:\R[ \t]*){2,}/', $content))))
        : [];
    $readingTime  = max(1, (int) ceil(str_word_count(strip_tags($content)) / 200));
    $formatDate   = fn ($date) => $date ? $date->copy()->locale(session('site_locale', 'en') === 'zh' ? 'zh_CN' : session('site_locale', 'en'))->translatedFormat('d F Y') : null;
    $publishedAt  = $formatDate($article->published_at);
    $categoryName = $article->localized('category') ?: 'TERRAWOOD Journal';
    $shareUrl     = url()->current();
    $hasCover     = !empty($article->image);
@endphp

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

<style>
    /* =========================================================
       DETAIL ARTIKEL - TERRAWOOD
       ========================================================= */

    .article-detail-page,
    .article-detail-page *,
    .article-detail-page *::before,
    .article-detail-page *::after {
        box-sizing: border-box;
    }

    .article-detail-page {
        --navy: #082744;
        --navy-deep: #061d33;
        --amber: #F5A623;
        --amber-dark: #e69a19;
        --amber-text: #A9660F;
        --cream: #F7F5EF;
        --ink: #293747;
        --muted: #687481;
        --line: #E5E0D6;

        min-height: 100vh;
        background: var(--cream);
        color: var(--ink);
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
    }

    .article-detail-page .icon {
        width: 15px;
        height: 15px;
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

    /* ---------- PROGRESS BACA ---------- */

    .reading-progress {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1100;
        width: 100%;
        height: 3px;
        background: linear-gradient(90deg, var(--amber), var(--amber-dark));
        transform: scaleX(0);
        transform-origin: left;
        pointer-events: none;
    }

    /* ---------- HERO ---------- */

    .article-detail-hero {
        position: relative;
        overflow: hidden;
        padding: 70px 6% 80px;
        text-align: center;
        color: #fff;
        background:
            radial-gradient(900px 420px at 85% -20%, rgba(245, 166, 35, .22), transparent 62%),
            radial-gradient(700px 380px at 5% 115%, rgba(245, 166, 35, .10), transparent 60%),
            linear-gradient(160deg, #0c3560 0%, #082744 55%, #061d33 100%);
    }

    .article-detail-hero.has-cover {
        padding-bottom: 160px;
    }

    .article-detail-hero::before {
        content: "";
        position: absolute;
        inset: 0;
        background: repeating-linear-gradient(90deg, rgba(255, 255, 255, .028) 0 2px, transparent 2px 16px);
        pointer-events: none;
    }

    .article-detail-hero-inner {
        position: relative;
        z-index: 1;
        max-width: 880px;
        margin: 0 auto;
    }

    .article-detail-hero-inner > * {
        animation: articleRise .8s cubic-bezier(.2, .7, .2, 1) both;
    }

    .article-detail-hero-inner > *:nth-child(2) { animation-delay: .08s; }
    .article-detail-hero-inner > *:nth-child(3) { animation-delay: .16s; }
    .article-detail-hero-inner > *:nth-child(4) { animation-delay: .24s; }

    .article-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 26px;
        padding: 8px 16px;
        border: 1px solid rgba(255, 255, 255, .18);
        border-radius: 999px;
        background: rgba(255, 255, 255, .08);
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        -webkit-backdrop-filter: blur(6px);
        backdrop-filter: blur(6px);
        transition: background .25s ease, gap .25s ease;
    }

    .article-back:hover {
        gap: 11px;
        background: rgba(255, 255, 255, .16);
        color: #fff;
    }

    .article-detail-hero .category {
        display: block;
        margin-bottom: 4px;
        color: var(--amber);
        font-size: 12px;
        font-weight: 700;
        letter-spacing: .22em;
        text-transform: uppercase;
    }

    .article-detail-hero h1 {
        max-width: 860px;
        margin: 18px auto 24px;
        font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
        font-size: clamp(30px, 5vw, 52px);
        font-weight: 700;
        line-height: 1.25;
    }

    .article-detail-meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 8px 22px;
        color: #C8D3DD;
        font-size: 13px;
    }

    .article-detail-meta span {
        display: inline-flex;
        align-items: center;
        gap: 7px;
    }

    .article-detail-meta .icon {
        color: var(--amber);
    }

    /* ---------- CONTAINER ---------- */

    .article-detail-container {
        max-width: 1000px;
        width: 88%;
        margin: 0 auto;
        padding: 60px 0 95px;
    }

    .article-detail-container.has-cover {
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

    /* ---------- GAMBAR UTAMA ---------- */

    .article-main-image {
        position: relative;
        z-index: 2;
        aspect-ratio: 16 / 9;
        max-height: 540px;
        width: 100%;
        margin: -110px 0 56px;
        overflow: hidden;
        border-radius: 22px;
        background: #E8E4DA;
        box-shadow: 0 30px 70px rgba(8, 39, 68, .28);
        animation: articleRise .9s .2s cubic-bezier(.2, .7, .2, 1) both;
    }

    .article-main-image img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

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
        width: 40px;
        height: 40px;
        stroke: var(--amber-text);
        stroke-width: 1.6;
    }

    .article-placeholder span {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .28em;
    }

    /* ---------- ISI ARTIKEL ---------- */

    .article-body {
        max-width: 740px;
        margin: 0 auto;
    }

    .article-intro {
        margin: 0 0 40px;
        padding: 4px 0 4px 24px;
        border-left: 4px solid var(--amber);
        color: #4b5a69;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 21px;
        line-height: 1.8;
    }

    .article-content-body {
        color: #3f4d5b;
        font-size: 17px;
        line-height: 1.95;
        overflow-wrap: anywhere;
    }

    .article-content-body p {
        margin: 0 0 1.5em;
    }

    .article-content-body h2,
    .article-content-body h3,
    .article-content-body h4 {
        margin: 1.8em 0 .6em;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        line-height: 1.4;
    }

    .article-content-body h2 { font-size: 29px; }
    .article-content-body h3 { font-size: 24px; }
    .article-content-body h4 { font-size: 20px; }

    .article-content-body ul,
    .article-content-body ol {
        margin: 0 0 1.5em;
        padding-left: 25px;
    }

    .article-content-body li {
        margin-bottom: 10px;
    }

    .article-content-body img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 14px;
    }

    .article-content-body blockquote {
        margin: 28px 0;
        padding: 20px 26px;
        border-left: 4px solid var(--amber);
        border-radius: 0 12px 12px 0;
        background: #F0EDE5;
        color: #526171;
    }

    /* ---------- BAGIKAN ---------- */

    .article-share {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-top: 52px;
        padding: 22px 0;
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
    }

    .article-share-label {
        display: inline-flex;
        align-items: center;
        gap: 9px;
        color: var(--navy);
        font-size: 14px;
        font-weight: 700;
    }

    .article-share-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .share-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        height: 42px;
        padding: 0 17px;
        border: 1px solid #E2DDD0;
        border-radius: 999px;
        background: #fff;
        color: var(--navy);
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: transform .25s ease, box-shadow .25s ease, background .25s ease, color .25s ease, border-color .25s ease;
    }

    @media (hover: hover) {
        .share-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(8, 39, 68, .12);
        }

        .share-wa:hover {
            border-color: #25D366;
            background: #25D366;
            color: #fff;
        }

        .share-fb:hover {
            border-color: #1877F2;
            background: #1877F2;
            color: #fff;
        }

        .share-copy:hover {
            border-color: var(--navy);
            background: var(--navy);
            color: #fff;
        }
    }

    /* ---------- ARTIKEL TERKAIT ---------- */

    .article-related {
        margin-top: 85px;
    }

    .article-related-top {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 28px;
    }

    .article-related-heading span {
        color: var(--amber-text);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .2em;
    }

    .article-related-heading h2 {
        margin: 10px 0 0;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 30px;
        font-weight: 700;
    }

    .article-related-all {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: var(--navy);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        transition: color .25s ease, gap .25s ease;
    }

    .article-related-all:hover {
        gap: 11px;
        color: var(--amber-text);
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 22px;
    }

    .related-item {
        display: flex;
    }

    .related-card {
        display: flex;
        flex-direction: column;
        width: 100%;
        overflow: hidden;
        border: 1px solid rgba(8, 39, 68, .05);
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 6px 22px rgba(8, 39, 68, .06);
        color: inherit;
        text-decoration: none;
        transition: transform .4s cubic-bezier(.2, .7, .2, 1), box-shadow .4s ease;
    }

    .related-image {
        position: relative;
        aspect-ratio: 16 / 10;
        overflow: hidden;
        background: #E8E4DA;
    }

    .related-image img {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .8s cubic-bezier(.2, .7, .2, 1);
    }

    .related-image .article-placeholder .icon {
        width: 30px;
        height: 30px;
    }

    .related-image .article-placeholder span {
        font-size: 11px;
    }

    .related-content {
        display: flex;
        flex: 1;
        flex-direction: column;
        padding: 18px 20px 20px;
    }

    .related-category {
        color: var(--amber-text);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .related-content h3 {
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
        line-clamp: 2;
        overflow: hidden;
        margin: 9px 0 12px;
        color: var(--navy);
        font-family: 'Playfair Display', Georgia, serif;
        font-size: 17px;
        font-weight: 700;
        line-height: 1.45;
        transition: color .25s ease;
    }

    .related-date {
        margin-top: auto;
        color: var(--muted);
        font-size: 12px;
    }

    @media (hover: hover) {
        .related-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 40px rgba(8, 39, 68, .14);
        }

        .related-card:hover .related-image img {
            transform: scale(1.07);
        }

        .related-card:hover h3 {
            color: var(--amber-text);
        }
    }

    .related-card:focus-visible,
    .article-back:focus-visible,
    .share-btn:focus-visible,
    .article-related-all:focus-visible,
    .article-bottom-cta a:focus-visible {
        outline: 3px solid var(--amber);
        outline-offset: 3px;
    }

    /* ---------- CTA ---------- */

    .article-bottom-cta {
        position: relative;
        overflow: hidden;
        margin-top: 70px;
        padding: 48px 36px;
        border-radius: 22px;
        background: linear-gradient(145deg, #0c3560 0%, #082744 60%, #061d33 100%);
        color: #fff;
        text-align: center;
    }

    .article-bottom-cta::before {
        content: "";
        position: absolute;
        top: -120px;
        right: -80px;
        width: 320px;
        height: 320px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(245, 166, 35, .28), transparent 65%);
        pointer-events: none;
    }

    .article-bottom-cta > * {
        position: relative;
    }

    .article-bottom-cta h3 {
        margin: 0 0 12px;
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(24px, 3vw, 30px);
        font-weight: 700;
    }

    .article-bottom-cta p {
        max-width: 520px;
        margin: 0 auto;
        color: #D5DEE6;
        font-size: 14px;
        line-height: 1.85;
    }

    .article-bottom-cta a {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 24px;
        padding: 14px 28px;
        border-radius: 999px;
        background: var(--amber);
        color: var(--navy);
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 10px 24px rgba(245, 166, 35, .3);
        transition: transform .25s ease, background .25s ease, gap .25s ease;
    }

    .article-bottom-cta a:hover {
        gap: 14px;
        background: #fff;
        transform: translateY(-2px);
    }

    /* ---------- TOAST ---------- */

    .article-toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        z-index: 1200;
        padding: 12px 22px;
        border-radius: 999px;
        background: var(--navy);
        box-shadow: 0 12px 30px rgba(0, 0, 0, .25);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        opacity: 0;
        transform: translate(-50%, 16px);
        transition: opacity .3s ease, transform .3s ease;
        pointer-events: none;
    }

    .article-toast.show {
        opacity: 1;
        transform: translate(-50%, 0);
    }

    /* ---------- RESPONSIF ---------- */

    @media (max-width: 900px) {
        .related-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 750px) {
        .article-detail-hero {
            padding: 55px 6% 65px;
        }

        .article-detail-hero.has-cover {
            padding-bottom: 120px;
        }

        .article-detail-container {
            width: 90%;
            padding: 40px 0 65px;
        }

        .article-detail-container.has-cover {
            padding-top: 0;
        }

        .article-main-image {
            margin: -80px 0 40px;
            border-radius: 16px;
        }

        .article-share {
            flex-direction: column;
            align-items: flex-start;
        }

        .article-related {
            margin-top: 65px;
        }

        .article-bottom-cta {
            margin-top: 55px;
            padding: 36px 22px;
        }
    }

    @media (max-width: 560px) {
        .related-grid {
            grid-template-columns: 1fr;
        }

        .article-intro {
            font-size: 18px;
        }

        .article-content-body {
            font-size: 16px;
        }

        .article-share-actions {
            width: 100%;
        }

        .share-btn {
            flex: 1;
            justify-content: center;
            padding: 0 12px;
        }

        .article-bottom-cta a {
            width: 100%;
            justify-content: center;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .article-detail-page *,
        .article-detail-page *::before,
        .article-detail-page *::after {
            animation: none !important;
            transition: none !important;
        }
    }
</style>

<div class="article-detail-page">

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

    <div class="reading-progress" id="readingProgress" aria-hidden="true"></div>

    <section class="article-detail-hero {{ $hasCover ? 'has-cover' : '' }}">

        <div class="article-detail-hero-inner">

            <div>
                <a href="{{ route('articles.index') }}" class="article-back">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M19 12H5M12 19l-7-7 7-7"/>
                    </svg>
                    {{ session('site_locale', 'en') === 'id' ? 'Semua Artikel' : (session('site_locale') === 'zh' ? '所有文章' : 'All Articles') }}
                </a>
            </div>

            <span class="category">{{ $categoryName }}</span>

            <h1>{{ $article->localized('title') }}</h1>

            <div class="article-detail-meta">
                @if($publishedAt)
                    <span>
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                            <line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/>
                            <line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $publishedAt }}
                    </span>
                @endif

                @if($content !== '')
                    <span>
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                        {{ t3($readingTime . ' menit baca', $readingTime . ' min read', '阅读约 ' . $readingTime . ' 分钟') }}
                    </span>
                @endif

                <span>TERRAWOOD Journal</span>
            </div>

        </div>

    </section>

    <section class="article-detail-container {{ $hasCover ? 'has-cover' : '' }}">

        @if($hasCover)
            <figure class="article-main-image">
                <div class="article-placeholder" aria-hidden="true">
                    <svg class="icon" viewBox="0 0 24 24">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <path d="M21 15l-5-5L5 21"/>
                    </svg>
                    <span>TERRAWOOD</span>
                </div>

                <img
                    src="{{ asset('storage/' . $article->image) }}"
                    alt="{{ $article->localized('title') }}"
                    onerror="this.style.display='none'"
                >
            </figure>
        @endif

        <div class="article-body" id="articleBody">

            @if($article->localized('excerpt'))
                <p class="article-intro">{{ $article->localized('excerpt') }}</p>
            @endif

            <div class="article-content-body">
                @forelse($paragraphs as $paragraph)
                    <p>{!! nl2br(e($paragraph)) !!}</p>
                @empty
                    <p>{{ session('site_locale', 'en') === 'id' ? 'Konten artikel belum tersedia.' : (session('site_locale') === 'zh' ? '文章内容暂不可用。' : 'Article content is not available yet.') }}</p>
                @endforelse
            </div>

            <div class="article-share">
                <span class="article-share-label">
                    <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="18" cy="5" r="3"/>
                        <circle cx="6" cy="12" r="3"/>
                        <circle cx="18" cy="19" r="3"/>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/>
                    </svg>
                    {{ session('site_locale', 'en') === 'id' ? 'Bagikan artikel ini' : (session('site_locale') === 'zh' ? '分享这篇文章' : 'Share this article') }}
                </span>

                <div class="article-share-actions">
                    <a
                        href="https://wa.me/?text={{ urlencode($article->localized('title') . ' - ' . $shareUrl) }}"
                        class="share-btn share-wa"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                        WhatsApp
                    </a>

                    <a
                        href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($shareUrl) }}"
                        class="share-btn share-fb"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/>
                        </svg>
                        Facebook
                    </a>

                    <button
                        type="button"
                        class="share-btn share-copy"
                        id="copyLinkBtn"
                        data-url="{{ $shareUrl }}"
                    >
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/>
                            <path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/>
                        </svg>
                        {{ session('site_locale', 'en') === 'id' ? 'Salin Tautan' : (session('site_locale') === 'zh' ? '复制链接' : 'Copy Link') }}
                    </button>
                </div>
            </div>

        </div>

        @if(isset($relatedArticles) && $relatedArticles->count() > 0)

            <section class="article-related">

                <div class="article-related-top" data-reveal>
                    <div class="article-related-heading">
                        <span>KEEP EXPLORING</span>
                        <h2>{{ session('site_locale', 'en') === 'id' ? 'Artikel Terkait' : (session('site_locale') === 'zh' ? '相关文章' : 'Related Articles') }}</h2>
                    </div>

                    <a href="{{ route('articles.index') }}" class="article-related-all">
                        {{ session('site_locale', 'en') === 'id' ? 'Lihat semua artikel' : (session('site_locale') === 'zh' ? '查看所有文章' : 'View all articles') }}
                        <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>

                <div class="related-grid">

                    @foreach($relatedArticles as $related)

                        <div class="related-item" data-reveal>
                            <a
                                href="{{ route('articles.show', $related->slug) }}"
                                class="related-card"
                            >

                                <div class="related-image">
                                    <div class="article-placeholder" aria-hidden="true">
                                        <svg class="icon" viewBox="0 0 24 24">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <path d="M21 15l-5-5L5 21"/>
                                        </svg>
                                        <span>TERRAWOOD</span>
                                    </div>

                                    @if($related->image)
                                        <img
                                            src="{{ asset('storage/' . $related->image) }}"
                                            alt="{{ $related->title }}"
                                            loading="lazy"
                                            onerror="this.style.display='none'"
                                        >
                                    @endif
                                </div>

                                <div class="related-content">

                                    <span class="related-category">
                                        {{ $related->category ?: 'Journal' }}
                                    </span>

                                    <h3>{{ $related->title }}</h3>

                                    @if($formatDate($related->published_at))
                                        <span class="related-date">{{ $formatDate($related->published_at) }}</span>
                                    @endif

                                </div>

                            </a>
                        </div>

                    @endforeach

                </div>

            </section>

        @endif

        <div class="article-bottom-cta" data-reveal>

            <h3>{{ t3('Temukan Inspirasi untuk Ruang Anda', 'Find Inspiration for Your Space', '为您的空间寻找灵感') }}</h3>

            <p>
                {{ t3(
                    'Jelajahi koleksi furnitur dan dekorasi TERRAWOOD untuk menciptakan ruang yang nyaman dan berkarakter.',
                    'Explore the TERRAWOOD furniture and decor collection to create a comfortable space with character.',
                    '探索 TERRAWOOD 家具与装饰系列，打造舒适且有个性的空间。'
                ) }}
            </p>

            <a href="{{ route('catalog.index') }}">
                {{ t3('Jelajahi Katalog', 'Explore Catalog', '浏览目录') }}
                <svg class="icon" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </a>

        </div>

    </section>

    <div class="article-toast" id="articleToast" role="status" aria-live="polite">
        {{ t3('Tautan berhasil disalin', 'Link copied successfully', '链接已复制') }}
    </div>

</div>

<script>
    (function () {
        'use strict';

        var page = document.querySelector('.article-detail-page');
        if (!page) return;

        /* ---------- Progress membaca ---------- */
        var bar  = document.getElementById('readingProgress');
        var body = document.getElementById('articleBody');
        var ticking = false;

        function updateProgress() {
            ticking = false;
            if (!bar || !body) return;

            var vh   = window.innerHeight;
            var rect = body.getBoundingClientRect();
            var top  = rect.top + window.pageYOffset;
            var from = top - vh * 0.35;
            var to   = top + rect.height - vh * 0.65;
            var span = to - from;

            var progress = span > 0 ? (window.pageYOffset - from) / span : (window.pageYOffset > from ? 1 : 0);
            progress = Math.min(1, Math.max(0, progress));

            bar.style.transform = 'scaleX(' + progress + ')';
        }

        function requestUpdate() {
            if (!ticking) {
                ticking = true;
                window.requestAnimationFrame(updateProgress);
            }
        }

        window.addEventListener('scroll', requestUpdate, { passive: true });
        window.addEventListener('resize', requestUpdate);
        updateProgress();

        /* ---------- Salin tautan ---------- */
        var copyBtn = document.getElementById('copyLinkBtn');
        var toast   = document.getElementById('articleToast');
        var toastTimer = null;

        function showToast(message) {
            toast.textContent = message;
            toast.classList.add('show');

            clearTimeout(toastTimer);
            toastTimer = setTimeout(function () {
                toast.classList.remove('show');
            }, 2200);
        }

        function fallbackCopy(text) {
            var area = document.createElement('textarea');
            area.value = text;
            area.setAttribute('readonly', '');
            area.style.position = 'fixed';
            area.style.opacity = '0';
            document.body.appendChild(area);
            area.select();

            try {
                document.execCommand('copy');
                showToast(@json(t3('Tautan berhasil disalin', 'Link copied successfully', '链接已复制')));
            } catch (e) {
                showToast('Gagal menyalin tautan');
            }

            document.body.removeChild(area);
        }

        if (copyBtn) {
            copyBtn.addEventListener('click', function () {
                var url = copyBtn.getAttribute('data-url');

                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(url).then(function () {
                        showToast(@json(t3('Tautan berhasil disalin', 'Link copied successfully', '链接已复制')));
                    }, function () {
                        fallbackCopy(url);
                    });
                } else {
                    fallbackCopy(url);
                }
            });
        }

        /* ---------- Animasi muncul saat scroll ---------- */
        if (page.classList.contains('has-js')) {
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
                // kartu terkait muncul bergantian per kolom
                if (el.classList.contains('related-item')) {
                    var position = Array.prototype.indexOf.call(el.parentNode.children, el);
                    el.style.transitionDelay = ((position % 3) * 90) + 'ms';
                }

                observer.observe(el);
            });
        }
    })();
</script>

@endsection