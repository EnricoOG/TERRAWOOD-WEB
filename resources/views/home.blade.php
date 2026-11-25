@extends('layouts.app')
@include('partials.i18n')
@section('title', t3('Beranda', 'Home', '首页') . ' | TERRAWOOD')
@push('styles')
<style>
:root {
    --tw-navy: #082744;
    --tw-dark: #061D33;
    --tw-gold: #F5A623;
    --tw-orange: #FFA43A;
    --tw-blue: #1677D2;
    --tw-blue-hover: #0D5EAD;
    --tw-ivory: #F7F5EF;
    --tw-text: #293747;
    --tw-muted: #687482;
    --tw-ease: cubic-bezier(.22, .61, .36, 1);
}

html {
    scroll-behavior: smooth;
    scroll-padding-top: 80px;
}

.home-page,
.home-page *,
.home-page *::before,
.home-page *::after { box-sizing: border-box; }

.home-page {
    overflow: hidden;
    background: var(--tw-ivory);
    font-family: 'Inter', sans-serif;
    color: var(--tw-text);
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
}

.home-page img { max-width: 100%; }

.home-page h1,
.home-page h2,
.home-page h3,
.home-page h4 {
    font-family: 'Manrope', sans-serif;
}

.home-page a { text-decoration: none; }

.home-page a:focus-visible,
.home-page button:focus-visible {
    outline: 2px solid var(--tw-orange);
    outline-offset: 3px;
}

.section-container {
    width: 86%;
    max-width: 1400px;
    margin: auto;
}

.section-label {
    color: #C47A1B;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: 3px;
    text-transform: uppercase;
    margin-bottom: 14px;
}

.section-title {
    color: var(--tw-navy);
    font-family: 'Manrope', sans-serif;
    font-size: clamp(30px, 3.2vw, 42px);
    line-height: 1.25;
    font-weight: 800;
}

.section-description {
    color: var(--tw-muted);
    font-size: 15px;
    line-height: 1.9;
    margin-top: 14px;
    max-width: 720px;
}

.section-heading.center .section-description {
    margin-left: auto;
    margin-right: auto;
}

.section-heading { margin-bottom: 38px; }
.section-heading.center { text-align: center; }

.reveal {
    opacity: 0;
    transform: translateY(22px);
    transition: opacity .6s ease, transform .6s ease;
}

.reveal.in {
    opacity: 1;
    transform: none;
}

/* HERO */
.hero {
    position: relative;
    min-height: 610px;
    background: var(--tw-navy);
    overflow: hidden;
}

.hero-track {
    display: flex;
    width: 100%;
    min-height: 610px;
    transition: transform .75s cubic-bezier(.65, 0, .35, 1);
    will-change: transform;
}

.hero-slide {
    display: grid;
    grid-template-columns: 1fr 1fr;
    flex: 0 0 100%;
    width: 100%;
    min-height: 610px;
}

.hero-left {
    grid-column: 2;
    grid-row: 1;
    background:
        radial-gradient(circle at 15% 15%, rgba(255,255,255,.22), transparent 35%),
        linear-gradient(145deg, #F5A623, #FFA43A);
    position: relative;
    min-height: 610px;
    overflow: hidden;
    display: flex;
    align-items: center;
    padding: 125px 8% 90px 12%;
}

.hero-left::before {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 50%;
    left: -145px;
    bottom: -190px;
    pointer-events: none;
}

.hero-left::after {
    content: "";
    position: absolute;
    width: 230px;
    height: 230px;
    border: 1px solid rgba(245,166,35,.24);
    border-radius: 50%;
    right: -145px;
    top: 80px;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 550px;
}

.hero-label {
    font-size: 11px;
    letter-spacing: 3.5px;
    color: var(--tw-navy);
    margin-bottom: 18px;
    font-weight: 800;
    text-transform: uppercase;
}

.hero-content h1 {
    font-family: 'Manrope', sans-serif;
    font-size: clamp(38px, 4.2vw, 62px);
    line-height: 1.12;
    font-weight: 800;
    color: var(--tw-navy);
    margin-bottom: 23px;
}

.hero-content h1 span {
    color: white;
    text-shadow: 0 8px 24px rgba(8, 39, 68, 0.12);
}

.hero-description {
    color: rgba(8,39,68,.86);
    font-size: 14px;
    line-height: 1.95;
    max-width: 440px;
    margin-bottom: 29px;
}

.hero-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 10px;
}

.hero-button,
.btn-email {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 14px;
    padding: 9px 9px 9px 28px;
    border: 0;
    border-radius: 999px;
    background: var(--tw-navy);
    color: white;
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: .3px;
    line-height: 1;
    cursor: pointer;
    box-shadow: 0 10px 24px rgba(8,39,68,.28);
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .35s var(--tw-ease),
        color .35s var(--tw-ease),
        transform .35s var(--tw-ease),
        box-shadow .35s var(--tw-ease);
    text-decoration: none;
}

.btn-email {
    background: #ffffff;
    color: var(--tw-navy);
    border: 1.5px solid rgba(8, 39, 68, 0.18);
    box-shadow: 0 8px 20px rgba(8, 39, 68, 0.08);
    padding-left: 22px;
    gap: 10px;
}

.btn-email svg {
    width: 18px;
    height: 18px;
    flex: 0 0 auto;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.btn-email .email-arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: var(--tw-navy);
    color: white;
    transition: transform .35s var(--tw-ease);
}

.btn-email .email-arrow svg {
    width: 14px;
    height: 14px;
    stroke: white;
}

.btn-arrow {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,.14);
    font-size: 15px;
    line-height: 1;
    transition:
        background-color .35s var(--tw-ease),
        color .35s var(--tw-ease),
        transform .35s var(--tw-ease);
}

.hero-button:focus-visible,
.btn-email:focus-visible {
    outline-color: var(--tw-navy);
    outline-offset: 4px;
}

@media (hover: hover) {
    .hero-button:hover {
        background: white;
        color: var(--tw-navy);
        transform: translateY(-2px);
        box-shadow: 0 14px 30px rgba(8,39,68,.3);
    }

    .hero-button:hover .btn-arrow {
        background: var(--tw-navy);
        color: white;
        transform: translateX(3px);
    }

    .btn-email:hover {
        background: var(--tw-navy);
        color: #ffffff;
        border-color: var(--tw-navy);
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(8, 39, 68, 0.2);
    }

    .btn-email:hover .email-arrow {
        background: #ffffff;
    }

    .btn-email:hover .email-arrow svg {
        stroke: var(--tw-navy);
    }
}

.hero-button:active,
.btn-email:active {
    transform: translateY(0) scale(.97);
    transition-duration: .12s;
}

.hero-kicker {
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(8,39,68,.72);
    font-size: 11px;
    letter-spacing: 1.5px;
    margin-top: 35px;
}

.hero-kicker::before {
    content: "";
    width: 35px;
    height: 1px;
    background: var(--tw-gold);
}

.hero-right {
    grid-column: 1;
    grid-row: 1;
    position: relative;
    min-height: 610px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 100px 7% 75px;
    overflow: hidden;
    background: var(--tw-navy);
}

.hero-right::before {
    content: "";
    position: absolute;
    inset: 0;
    background:
        radial-gradient(circle at 80% 18%, rgba(255,255,255,.09), transparent 38%),
        linear-gradient(135deg, #082744, #061D33);
}

.hero-product-frame {
    position: relative;
    z-index: 1;
    width: 100%;
    height: 455px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 12px;
}

.hero-product-image {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
}

.hero-image-caption {
    position: absolute;
    z-index: 2;
    left: 8%;
    bottom: 34px;
    color: rgba(255,255,255,.9);
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2px;
    text-transform: uppercase;
}

.hero-controls {
    position: absolute;
    right: 5%;
    bottom: 22px;
    display: flex;
    align-items: center;
    gap: 13px;
    z-index: 5;
    color: white;
    font-size: 14px;
}

.hero-counter { min-width: 55px; }
.hero-counter strong { font-size: 17px; font-weight: 800; }

.hero-controls button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    padding: 0;
    border: 1px solid rgba(255,255,255,.45);
    border-radius: 50%;
    background: rgba(8,39,68,.35);
    -webkit-backdrop-filter: blur(6px);
    backdrop-filter: blur(6px);
    color: white;
    cursor: pointer;
    font-size: 17px;
    line-height: 1;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .3s var(--tw-ease),
        color .3s var(--tw-ease),
        border-color .3s var(--tw-ease),
        transform .3s var(--tw-ease);
}

@media (hover: hover) {
    .hero-controls button:hover {
        background: var(--tw-gold);
        color: var(--tw-navy);
        border-color: var(--tw-gold);
        transform: scale(1.08);
    }
}

.hero-controls button:active {
    transform: scale(.94);
    transition-duration: .12s;
}

.hero-controls .hero-dots {
    display: flex;
    align-items: center;
    gap: 8px;
}

.hero-controls .hero-dots button {
    width: 9px;
    height: 9px;
    min-width: 9px;
    padding: 0;
    border: 0;
    border-radius: 6px;
    background: rgba(255,255,255,.45);
    -webkit-backdrop-filter: none;
    backdrop-filter: none;
    font-size: 0;
    transition: width .3s ease, background .3s ease;
}

.hero-controls .hero-dots button:hover {
    background: rgba(255,255,255,.8);
    transform: none;
}

.hero-controls .hero-dots button.active {
    width: 24px;
    background: var(--tw-gold);
}

.hero-slide.is-active .hero-content > * {
    animation: heroTextIn .8s var(--tw-ease) backwards;
}

.hero-slide.is-active .hero-content > *:nth-child(1) { animation-delay: .12s; }
.hero-slide.is-active .hero-content > *:nth-child(2) { animation-delay: .22s; }
.hero-slide.is-active .hero-content > *:nth-child(3) { animation-delay: .32s; }
.hero-slide.is-active .hero-content > *:nth-child(4) { animation-delay: .42s; }
.hero-slide.is-active .hero-content > *:nth-child(5) { animation-delay: .52s; }

.hero-slide.is-active .hero-product-image {
    animation: heroImageIn 1s var(--tw-ease) .1s backwards;
}

@keyframes heroTextIn {
    from { opacity: 0; transform: translateY(18px); }
    to   { opacity: 1; transform: none; }
}

@keyframes heroImageIn {
    from { opacity: 0; transform: translateY(12px) scale(.95); }
    to   { opacity: 1; transform: none; }
}

/* BENEFIT */
.benefit-strip {
    background: #FFF9F0;
    padding: 27px 7%;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    border-bottom: 1px solid #F0E6D8;
}

.benefit-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    padding: 8px 15px;
    border-right: 1px solid #E9B66F;
}

.benefit-item:last-child { border-right: none; }

.benefit-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #D58A22;
    background: #FFF0D8;
    border-radius: 12px;
}

.benefit-icon svg {
    width: 25px;
    height: 25px;
    stroke: currentColor;
    fill: none;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.benefit-item strong {
    color: var(--tw-navy);
    display: block;
    font-size: 14px;
    font-weight: 800;
}

.benefit-item span {
    display: block;
    color: var(--tw-muted);
    font-size: 12px;
    margin-top: 5px;
}

/* PRODUCTS */
.products-section {
    padding: 85px 7%;
    background: var(--tw-ivory);
}

.products-layout {
    display: grid;
    grid-template-columns: 270px 1fr;
    gap: 38px;
    align-items: center;
}

.products-intro .section-title { font-size: 32px; }

.products-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 17px;
}

.product-card {
    background: white;
    border-radius: 11px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(8,39,68,.07);
    transition: transform .3s ease, box-shadow .3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 12px 25px rgba(8,39,68,.12);
}

.product-image {
    height: 175px;
    background: #F8F6F1;
    overflow: hidden;
    display: grid;
    place-items: center;
    padding: 14px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    transform-origin: center;
    transition: transform .4s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.035);
}

.product-info { padding: 16px; }

.product-category {
    color: #C47A1B;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}

.product-name {
    color: var(--tw-navy);
    font-size: 14px;
    font-weight: 800;
    margin: 9px 0;
    line-height: 1.5;
    min-height: 42px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    color: var(--tw-text);
    font-size: 13px;
    font-weight: 800;
}

.price-original {
    display: block;
    color: #8B95A2;
    font-size: 12px;
    font-weight: 600;
    text-decoration: line-through;
    margin-bottom: 2px;
}

.price-discount {
    display: block;
    color: #B47A13;
    font-weight: 800;
}

.product-detail {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 13px;
    padding-bottom: 3px;
    color: #B66D14;
    font-size: 12px;
    font-weight: 800;
    background: linear-gradient(currentColor, currentColor) no-repeat 0 100% / 0 1.5px;
    transition:
        color .3s var(--tw-ease),
        background-size .35s var(--tw-ease);
}

.product-detail::before {
    content: "";
    position: absolute;
    inset: 0;
}

.product-detail span {
    display: inline-block;
    transition: transform .3s var(--tw-ease);
}

@media (hover: hover) {
    .product-card:hover .product-detail {
        color: var(--tw-navy);
        background-size: 100% 1.5px;
    }

    .product-card:hover .product-detail span {
        transform: translateX(4px);
    }
}

.products-link {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 14px;
    margin-top: 23px;
    padding: 8px 8px 8px 26px;
    border-radius: 999px;
    background: var(--tw-orange);
    color: var(--tw-navy);
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 800;
    letter-spacing: .3px;
    line-height: 1;
    box-shadow: 0 8px 20px rgba(255,164,58,.32);
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .35s var(--tw-ease),
        color .35s var(--tw-ease),
        transform .35s var(--tw-ease),
        box-shadow .35s var(--tw-ease);
}

.products-link .btn-arrow {
    width: 34px;
    height: 34px;
    background: rgba(8,39,68,.12);
}

.products-link:focus-visible {
    outline-color: var(--tw-navy);
    outline-offset: 4px;
}

@media (hover: hover) {
    .products-link:hover {
        background: var(--tw-navy);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(8,39,68,.28);
    }

    .products-link:hover .btn-arrow {
        background: var(--tw-orange);
        color: var(--tw-navy);
        transform: translateX(3px);
    }
}

.products-link:active {
    transform: translateY(0) scale(.97);
    transition-duration: .12s;
}

.product-empty {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    background: white;
    border-radius: 10px;
    color: var(--tw-muted);
    font-size: 14px;
}

/* ABOUT */
.about-section {
    display: grid;
    grid-template-columns: 42% 58%;
    min-height: 350px;
    background: var(--tw-navy);
}

.about-image {
    min-height: 350px;
    overflow: hidden;
    background: #EDE7DC;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 25px;
}

.about-image img {
    width: 100%;
    height: 100%;
    min-height: 300px;
    object-fit: contain;
}

.about-content {
    padding: 55px 8%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
}

.about-content .section-title {
    color: white;
    font-size: 34px;
}

.about-content p {
    color: rgba(255,255,255,.85);
    font-size: 14px;
    line-height: 1.9;
    margin-top: 15px;
    max-width: 640px;
}

.about-stats {
    display: flex;
    gap: 40px;
    margin-top: 30px;
    flex-wrap: wrap;
}

.about-stat strong {
    display: block;
    color: var(--tw-orange);
    font-size: 31px;
    font-family: 'Manrope', sans-serif;
    font-weight: 800;
}

.about-stat span {
    color: white;
    font-size: 12px;
}

/* PARTNERS */
.partners-section {
    padding: 75px 7%;
    background: white;
}

.partners-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.partner-card {
    min-height: 130px;
    padding: 22px;
    border: 1px solid #EEE7DB;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    text-align: center;
    transition: border-color .3s ease, transform .3s ease;
}

.partner-card:hover {
    border-color: var(--tw-gold);
    transform: translateY(-5px);
}

.partner-card img {
    max-width: 140px;
    max-height: 60px;
    object-fit: contain;
    margin-bottom: 12px;
}

.partner-card strong {
    color: var(--tw-navy);
    font-size: 14px;
}

.home-empty {
    grid-column: 1 / -1;
    background: rgba(255,255,255,.8);
    border: 1px dashed #D9CBB8;
    border-radius: 10px;
    text-align: center;
    padding: 35px 20px;
    color: var(--tw-muted);
    font-size: 14px;
}

/* TESTIMONIALS */
.testimonials-section {
    padding: 62px 7%;
    background: var(--tw-navy);
}

.testimonials-section .section-title { color: white; }
.testimonials-section .section-description { color: rgba(255,255,255,.8); }

.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
    max-width: 1120px;
    margin: 0 auto;
}

.testimonial-card {
    background: #FFF9F0;
    border-radius: 11px;
    padding: 20px;
    min-width: 0;
}

.testimonial-stars {
    color: #F5A623;
    letter-spacing: 2px;
    font-size: 15px;
    margin-bottom: 10px;
}

.testimonial-text {
    color: var(--tw-text);
    font-size: 14px;
    line-height: 1.75;
    font-style: italic;
    margin: 0;
}

.testimonial-person {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-top: 16px;
}

.testimonial-person img {
    width: 42px;
    height: 42px;
    min-width: 42px;
    object-fit: cover;
    border-radius: 50%;
    display: block;
}

.testimonial-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--tw-navy);
    color: var(--tw-gold);
    font-family: 'Manrope', sans-serif;
    font-size: 14px;
    font-weight: 800;
    flex-shrink: 0;
}

.testimonial-person strong {
    display: block;
    color: var(--tw-navy);
    font-size: 13px;
    font-weight: 800;
}

.testimonial-person span {
    color: var(--tw-muted);
    font-size: 11px;
    display: block;
    margin-top: 4px;
}

/* TEXT LINK */
.section-heading.split {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 20px;
}

.text-link {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding-bottom: 3px;
    color: #B66D14;
    font-size: 13px;
    font-weight: 800;
    white-space: nowrap;
    background: linear-gradient(currentColor, currentColor) no-repeat 0 100% / 0 1.5px;
    -webkit-tap-highlight-color: transparent;
    transition: color .3s var(--tw-ease), background-size .35s var(--tw-ease);
}

.text-link span {
    display: inline-block;
    transition: transform .3s var(--tw-ease);
}

.text-link:active { background-size: 100% 1.5px; }

@media (hover: hover) {
    .text-link:hover {
        color: var(--tw-navy);
        background-size: 100% 1.5px;
    }

    .text-link:hover span { transform: translateX(4px); }
}

/* CATEGORIES */
.categories-section {
    padding: 85px 7% 70px;
    background: white;
}

.categories-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 18px;
}

.category-tile {
    position: relative;
    display: block;
    aspect-ratio: 4 / 3;
    border-radius: 16px;
    overflow: hidden;
    background: linear-gradient(135deg, #0F3558, #061D33);
    box-shadow: 0 6px 18px rgba(8,39,68,.12);
    -webkit-tap-highlight-color: transparent;
    transition: transform .35s var(--tw-ease), box-shadow .35s var(--tw-ease);
}

.category-tile img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 20px 24px 76px;
    transition: transform .5s var(--tw-ease);
}

.category-label {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    padding: 38px 20px 18px;
    background: linear-gradient(to top, rgba(6,29,51,.95) 35%, rgba(6,29,51,0));
    color: white;
}

.category-label strong {
    display: block;
    font-family: 'Manrope', sans-serif;
    font-size: 17px;
    font-weight: 800;
    line-height: 1.25;
}

.category-label small {
    display: block;
    margin-top: 3px;
    color: var(--tw-orange);
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .4px;
}

.category-tile:active {
    transform: scale(.985);
    transition-duration: .12s;
}

@media (hover: hover) {
    .category-tile:hover {
        transform: translateY(-5px);
        box-shadow: 0 16px 32px rgba(8,39,68,.2);
    }

    .category-tile:hover img { transform: scale(1.05); }

    .category-tile:hover .btn-arrow {
        background: var(--tw-gold);
        color: var(--tw-navy);
        transform: translateX(3px);
    }
}

/* STATEMENT */
.statement-section {
    position: relative;
    overflow: hidden;
    padding: 105px 7%;
    background:
        radial-gradient(circle at 80% 0%, rgba(245,166,35,.16), transparent 45%),
        var(--tw-dark);
    text-align: center;
}

.statement-inner {
    position: relative;
    z-index: 1;
    max-width: 900px;
    margin: 0 auto;
}

.statement-section .section-label { color: var(--tw-gold); }

.home-page .statement-quote {
    font-family: var(--font-editorial, 'Playfair Display', serif);
    font-size: clamp(30px, 4.4vw, 56px);
    line-height: 1.2;
    font-weight: 500;
    letter-spacing: -.3px;
    color: white;
}

.statement-quote em {
    color: var(--tw-gold);
    font-style: italic;
}

.statement-points {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
    margin-top: 56px;
    padding-top: 34px;
    border-top: 1px solid rgba(255,255,255,.14);
    text-align: left;
}

.statement-points strong {
    display: block;
    margin-bottom: 8px;
    color: white;
    font-family: 'Manrope', sans-serif;
    font-size: 15px;
    font-weight: 800;
}

.statement-points strong::before {
    content: "";
    display: block;
    width: 28px;
    height: 2px;
    margin-bottom: 14px;
    background: var(--tw-gold);
}

.statement-points span {
    color: rgba(255,255,255,.72);
    font-size: 13.5px;
    line-height: 1.75;
}

/* SERVICES */
.services-section {
    padding: 85px 7%;
    background: white;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
}

.service-card {
    position: relative;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    padding: 28px 24px 24px;
    background: #FFF9F0;
    border: 1px solid #F0E6D8;
    border-radius: 16px;
    -webkit-tap-highlight-color: transparent;
    transition: transform .35s var(--tw-ease), box-shadow .35s var(--tw-ease), border-color .35s var(--tw-ease);
}

.service-card::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, var(--tw-gold), var(--tw-orange));
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .45s var(--tw-ease);
}

.service-index {
    position: absolute;
    top: 16px;
    right: 20px;
    font-family: 'Manrope', sans-serif;
    font-size: 34px;
    font-weight: 800;
    line-height: 1;
    color: rgba(8,39,68,.07);
}

.service-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 52px;
    height: 52px;
    margin-bottom: 20px;
    border-radius: 14px;
    background: #FFF0D8;
    color: #C47A1B;
}

.service-icon svg {
    width: 26px;
    height: 26px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.service-media {
    display: block;
    height: 140px;
    margin-bottom: 18px;
    overflow: hidden;
    border-radius: 10px;
    background: #ECE9E1;
}

.service-media img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.service-card h3 {
    margin-bottom: 10px;
    color: var(--tw-navy);
    font-size: 17px;
    font-weight: 800;
    line-height: 1.35;
}

.service-card p {
    flex: 1;
    color: var(--tw-muted);
    font-size: 13.5px;
    line-height: 1.75;
}

.service-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 20px;
    color: #B66D14;
    font-size: 12.5px;
    font-weight: 800;
}

.service-more span {
    display: inline-block;
    transition: transform .3s var(--tw-ease);
}

.service-card:active {
    transform: scale(.985);
    transition-duration: .12s;
}

@media (hover: hover) {
    .service-card:hover {
        transform: translateY(-5px);
        border-color: #EBC98F;
        box-shadow: 0 14px 30px rgba(8,39,68,.1);
    }

    .service-card:hover::before { transform: scaleX(1); }
    .service-card:hover .service-more span { transform: translateX(4px); }
}

/* PORTFOLIO */
.portfolio-section {
    padding: 85px 7%;
    background: var(--tw-ivory);
}

.portfolio-grid {
    display: grid;
    grid-template-columns: 1.4fr 1fr 1fr;
    grid-template-rows: 270px 270px;
    gap: 16px;
}

.portfolio-item {
    position: relative;
    display: block;
    overflow: hidden;
    border-radius: 16px;
    background: #ECE9E1;
    -webkit-tap-highlight-color: transparent;
}

.portfolio-item:nth-child(1) { grid-row: 1 / 3; }
.portfolio-item:nth-child(4) { grid-column: 2 / 4; }

.portfolio-item img {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .6s var(--tw-ease);
}

.portfolio-item img.is-fallback {
    object-fit: contain;
    padding: 28px;
}

.portfolio-caption {
    position: absolute;
    left: 0;
    right: 0;
    bottom: 0;
    padding: 46px 22px 20px;
    background: linear-gradient(to top, rgba(6,29,51,.9), rgba(6,29,51,0));
    color: white;
}

.portfolio-caption strong {
    display: block;
    font-family: 'Manrope', sans-serif;
    font-size: 16px;
    font-weight: 800;
    line-height: 1.3;
}

.portfolio-caption small {
    display: block;
    margin-top: 4px;
    color: var(--tw-orange);
    font-size: 11.5px;
    font-weight: 700;
    letter-spacing: .4px;
}

.portfolio-item:active img { transform: scale(1.03); }

@media (hover: hover) {
    .portfolio-item:hover img { transform: scale(1.06); }
}

/* STEPS */
.steps-section {
    padding: 85px 7%;
    background: #FFF9F0;
}

.steps-grid {
    position: relative;
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 24px;
}

.steps-grid::before {
    content: "";
    position: absolute;
    top: 34px;
    left: 12.5%;
    right: 12.5%;
    height: 2px;
    background: repeating-linear-gradient(90deg, #E4B574 0 8px, transparent 8px 16px);
}

.step-item {
    position: relative;
    padding: 0 8px;
    text-align: center;
}

.step-badge {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 68px;
    height: 68px;
    margin: 0 auto 20px;
    border: 2px solid #F0C98C;
    border-radius: 50%;
    background: white;
    color: #C47A1B;
    box-shadow: 0 6px 16px rgba(196,122,27,.15);
}

.step-badge svg {
    width: 28px;
    height: 28px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.step-number {
    position: absolute;
    top: -6px;
    right: -6px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: var(--tw-navy);
    color: white;
    font-family: 'Manrope', sans-serif;
    font-size: 12px;
    font-weight: 800;
}

.step-item h3 {
    margin-bottom: 8px;
    color: var(--tw-navy);
    font-size: 16px;
    font-weight: 800;
}

.step-item p {
    color: var(--tw-muted);
    font-size: 13.5px;
    line-height: 1.75;
}

.steps-cta {
    margin-top: 44px;
    text-align: center;
}

/* ARTICLES */
.articles-section {
    padding: 85px 7% 70px;
    background: var(--tw-ivory);
}

.articles-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 20px;
}

.article-card {
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border-radius: 16px;
    background: white;
    box-shadow: 0 3px 12px rgba(8,39,68,.07);
    -webkit-tap-highlight-color: transparent;
    transition: transform .35s var(--tw-ease), box-shadow .35s var(--tw-ease);
}

.article-thumb {
    display: block;
    aspect-ratio: 16 / 10;
    overflow: hidden;
    background: #ECE9E1;
}

.article-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s var(--tw-ease);
}

.article-thumb img.is-fallback {
    object-fit: contain;
    padding: 14px;
}

.article-body {
    display: flex;
    flex: 1;
    flex-direction: column;
    padding: 22px;
}

.article-date {
    margin-bottom: 10px;
    color: #B66D14;
    font-size: 11.5px;
    font-weight: 800;
    letter-spacing: .8px;
    text-transform: uppercase;
}

.article-card h3 {
    display: -webkit-box;
    margin-bottom: 10px;
    overflow: hidden;
    color: var(--tw-navy);
    font-size: 17px;
    font-weight: 800;
    line-height: 1.4;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.article-card p {
    display: -webkit-box;
    flex: 1;
    overflow: hidden;
    color: var(--tw-muted);
    font-size: 13.5px;
    line-height: 1.75;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
}

.article-more {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    margin-top: 16px;
    color: #B66D14;
    font-size: 12.5px;
    font-weight: 800;
}

.article-more span {
    display: inline-block;
    transition: transform .3s var(--tw-ease);
}

.article-card:active {
    transform: scale(.985);
    transition-duration: .12s;
}

@media (hover: hover) {
    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 28px rgba(8,39,68,.12);
    }

    .article-card:hover .article-thumb img { transform: scale(1.05); }
    .article-card:hover .article-more span { transform: translateX(4px); }
}

/* CTA */
.cta-section {
    padding: 20px 7% 90px;
    background: var(--tw-ivory);
}

.cta-box {
    position: relative;
    display: grid;
    grid-template-columns: 1.4fr 1fr;
    align-items: center;
    gap: 30px;
    overflow: hidden;
    padding: 56px;
    border-radius: 24px;
    background:
        radial-gradient(circle at 15% 15%, rgba(255,255,255,.22), transparent 35%),
        linear-gradient(145deg, #F5A623, #FFA43A);
}

.cta-box::before {
    content: "";
    position: absolute;
    right: -90px;
    bottom: -140px;
    width: 340px;
    height: 340px;
    border: 1px solid rgba(255,255,255,.25);
    border-radius: 50%;
    pointer-events: none;
}

.cta-box > div { position: relative; z-index: 1; }

.cta-label {
    margin-bottom: 14px;
    color: var(--tw-navy);
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 3.5px;
    text-transform: uppercase;
}

.cta-box h2 {
    margin-bottom: 12px;
    color: var(--tw-navy);
    font-size: clamp(26px, 3vw, 38px);
    font-weight: 800;
    line-height: 1.2;
}

.cta-box p {
    max-width: 520px;
    color: rgba(8,39,68,.82);
    font-size: 15px;
    line-height: 1.8;
}

.cta-actions {
    display: flex;
    flex-direction: column;
    align-items: stretch;
    gap: 12px;
    justify-self: end;
    max-width: 340px;
}

.cta-actions .hero-button,
.cta-actions .btn-email,
.cta-actions .cta-secondary {
    width: 100%;
    justify-content: center;
    text-align: center;
}

.cta-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 54px;
    padding: 0 28px;
    border: 2px solid var(--tw-navy);
    border-radius: 999px;
    color: var(--tw-navy);
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 13px;
    font-weight: 800;
    -webkit-tap-highlight-color: transparent;
    transition: background-color .35s var(--tw-ease), color .35s var(--tw-ease), transform .35s var(--tw-ease);
    text-decoration: none;
}

.cta-secondary:active {
    transform: scale(.97);
    transition-duration: .12s;
}

@media (hover: hover) {
    .cta-secondary:hover {
        background: var(--tw-navy);
        color: white;
        transform: translateY(-2px);
    }
}

/* CONTACT INFO */
.contact-info-card {
    background: #ffffff;
    border: 1px solid #EEE7DB;
    border-radius: 14px;
    padding: 18px 22px;
    display: flex;
    align-items: center;
    gap: 14px;
    transition: all .3s ease;
    text-decoration: none;
    color: var(--tw-text);
}

.contact-info-card:hover {
    border-color: var(--tw-gold);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(8,39,68,.08);
}

.contact-info-icon {
    width: 40px;
    height: 40px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #FFF0D8;
    color: #C47A1B;
    border-radius: 10px;
}

.contact-info-icon svg {
    width: 20px;
    height: 20px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
}

.contact-info-text strong {
    display: block;
    font-size: 11px;
    color: var(--tw-muted);
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.contact-info-text span {
    font-size: 13px;
    font-weight: 700;
    color: var(--tw-navy);
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-top: 20px;
    max-width: 640px;
}

/* TABLET */
@media(max-width: 1100px) {
    .services-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }

    .portfolio-grid {
        grid-template-columns: 1fr 1fr;
        grid-template-rows: 300px 220px 220px;
    }

    .portfolio-item:nth-child(1) { grid-column: 1 / 3; grid-row: 1; }
    .portfolio-item:nth-child(2) { grid-column: 1; grid-row: 2; }
    .portfolio-item:nth-child(3) { grid-column: 2; grid-row: 2; }
    .portfolio-item:nth-child(4) { grid-column: 1 / 3; grid-row: 3; }

    .steps-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 36px 24px;
    }

    .steps-grid::before { display: none; }

    .cta-box {
        grid-template-columns: 1fr;
        padding: 44px 36px;
    }

    .cta-actions {
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-self: start;
        max-width: none;
    }

    .products-layout { grid-template-columns: 220px 1fr; }
    .products-grid { grid-template-columns: repeat(2, 1fr); }
    .product-image { height: 190px; }
}

/* MOBILE */
@media(max-width: 760px) {
    .categories-section { padding: 56px 6% 48px; }
    .statement-section { padding: 72px 7%; }

    .services-section,
    .portfolio-section,
    .steps-section { padding: 56px 6%; }

    .articles-section { padding: 56px 6% 48px; }
    .cta-section { padding: 12px 6% 60px; }

    .section-heading.split {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }

    .categories-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .category-tile img { padding: 12px 14px 60px; }
    .category-label { padding: 30px 12px 12px; }
    .category-label strong { font-size: 14px; }
    .category-label small { font-size: 10.5px; }

    .category-label .btn-arrow {
        width: 28px;
        height: 28px;
        font-size: 12px;
    }

    .statement-points {
        grid-template-columns: 1fr;
        gap: 22px;
        margin-top: 40px;
    }

    .services-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .service-card { padding: 22px 20px; }

    .portfolio-grid {
        gap: 10px;
        grid-template-rows: 220px 150px 170px;
    }

    .portfolio-caption { padding: 34px 14px 14px; }
    .portfolio-caption strong { font-size: 13.5px; }

    .steps-grid {
        grid-template-columns: 1fr;
        gap: 26px;
    }

    .step-item {
        display: grid;
        grid-template-columns: 68px 1fr;
        gap: 16px;
        align-items: start;
        padding: 0;
        text-align: left;
    }

    .step-badge { margin: 0; }
    .steps-cta { margin-top: 36px; }

    .articles-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }

    .article-card {
        display: grid;
        grid-template-columns: 116px 1fr;
    }

    .article-thumb {
        aspect-ratio: auto;
        height: 100%;
        min-height: 128px;
    }

    .article-body { padding: 14px 16px; }
    .article-card h3 { margin-bottom: 4px; font-size: 14.5px; }
    .article-card p { display: none; }
    .article-more { margin-top: 8px; }

    .cta-box {
        padding: 34px 24px;
        border-radius: 20px;
    }

    .cta-box p { font-size: 14px; }

    .cta-actions {
        flex-direction: column;
        align-items: stretch;
        width: 100%;
        max-width: 340px;
    }

    .section-title { font-size: clamp(26px, 7vw, 32px); }

    .section-label {
        font-size: 12px;
        letter-spacing: 2.5px;
        margin-bottom: 10px;
    }

    .section-description { font-size: 14.5px; line-height: 1.8; }
    .section-heading { margin-bottom: 26px; }

    .hero, .hero-track { min-height: auto; }

    .hero-slide {
        grid-template-columns: 1fr;
        min-height: auto;
    }

    .hero-left, .hero-right {
        grid-column: auto;
        grid-row: auto;
    }

    .hero-left {
        min-height: 0;
        padding: 104px 7% 44px;
    }

    .hero-content { max-width: none; }

    .hero-label {
        font-size: 10.5px;
        letter-spacing: 3px;
        margin-bottom: 14px;
    }

    .hero-content h1 {
        font-size: clamp(34px, 10.5vw, 44px);
        margin-bottom: 16px;
    }

    .hero-description {
        font-size: 14.5px;
        line-height: 1.8;
        max-width: none;
        margin-bottom: 24px;
    }

    .hero-actions {
        flex-direction: column;
        width: 100%;
        max-width: 340px;
    }

    .hero-actions .hero-button,
    .hero-actions .btn-email {
        width: 100%;
        justify-content: center;
    }

    .hero-kicker { margin-top: 24px; font-size: 10px; }

    .hero-right {
        min-height: 0;
        padding: 26px 6% 78px;
    }

    .hero-product-frame {
        height: 250px;
        padding: 4px;
    }

    .hero-image-caption { display: none; }

    .hero-controls {
        left: 50%;
        right: auto;
        bottom: 22px;
        gap: 14px;
        transform: translateX(-50%);
    }

    .hero-counter { display: none; }

    .benefit-strip {
        grid-template-columns: repeat(2, 1fr);
        gap: 0;
        padding: 6px 5%;
    }

    .benefit-item {
        justify-content: flex-start;
        gap: 12px;
        padding: 16px 6px;
        border-right: none;
        border-bottom: 1px solid #F0DDC2;
    }

    .benefit-item:nth-last-child(-n+2) { border-bottom: none; }

    .benefit-icon {
        width: 40px;
        height: 40px;
        min-width: 40px;
    }

    .benefit-icon svg { width: 22px; height: 22px; }
    .benefit-item strong { font-size: 13px; line-height: 1.3; }
    .benefit-item span { font-size: 11.5px; line-height: 1.35; margin-top: 3px; }

    .products-section { padding: 56px 6%; }

    .products-layout {
        grid-template-columns: 1fr;
        gap: 26px;
    }

    .products-intro .section-title { font-size: clamp(26px, 7vw, 32px); }

    .products-link {
        width: 100%;
        max-width: 340px;
        margin-top: 18px;
        justify-content: space-between;
    }

    .products-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .product-image { height: 150px; }
    .product-info { padding: 12px; }
    .product-category { font-size: 10px; }

    .product-name {
        font-size: 13px;
        line-height: 1.4;
        margin: 6px 0;
        min-height: 2.8em;
    }

    .product-price { font-size: 12.5px; }
    .product-detail { margin-top: 10px; font-size: 11.5px; }

    .about-section { grid-template-columns: 1fr; }

    .about-image {
        min-height: 240px;
        padding: 20px;
    }

    .about-image img {
        min-height: 0;
        max-height: 240px;
    }

    .about-content { padding: 36px 7% 44px; }
    .about-content .section-title { font-size: clamp(26px, 7vw, 32px); }
    .about-content p { font-size: 14.5px; line-height: 1.8; }

    .about-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-top: 26px;
        padding-top: 22px;
        border-top: 1px solid rgba(255,255,255,.15);
    }

    .about-stat strong { font-size: 26px; }

    .about-stat span {
        display: block;
        font-size: 11.5px;
        line-height: 1.4;
    }

    .partners-section { padding: 52px 6%; }

    .partners-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
    }

    .partner-card {
        min-height: 104px;
        padding: 16px 12px;
    }

    .partner-card img {
        max-width: 110px;
        max-height: 48px;
        margin-bottom: 8px;
    }

    .partner-card strong { font-size: 12.5px; }

    .testimonials-section { padding: 52px 6%; }

    .testimonials-grid {
        display: flex;
        gap: 14px;
        max-width: none;
        margin: 0 -6vw;
        padding: 0 6vw 10px;
        overflow-x: auto;
        scroll-snap-type: x mandatory;
        scroll-padding: 0 6vw;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }

    .testimonials-grid::-webkit-scrollbar { display: none; }

    .testimonial-card {
        flex: 0 0 84%;
        scroll-snap-align: start;
    }

    .testimonials-grid .home-empty { flex: 0 0 calc(100vw - 12vw); }
    .testimonial-text { font-size: 13.5px; }

    .contact-grid {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 430px) {
    .hero-left { padding-top: 100px; }
    .hero-content h1 { font-size: clamp(32px, 10.5vw, 40px); }
    .hero-product-frame { height: 225px; }
    .product-image { height: 132px; }
    .about-stats { gap: 8px; }
    .about-stat strong { font-size: 24px; }
}

@media(max-width: 360px) {
    .benefit-strip { grid-template-columns: 1fr; }
    .benefit-item:nth-last-child(-n+2) { border-bottom: 1px solid #F0DDC2; }
    .benefit-item:last-child { border-bottom: none; }
}

@media(max-width: 340px) {
    .categories-grid { grid-template-columns: 1fr; }
    .products-grid { grid-template-columns: 1fr; }
    .product-image { height: 170px; }
}

@media (hover: none) {
    .category-tile:hover,
    .service-card:hover,
    .article-card:hover { transform: none; }

    .category-tile:hover img,
    .portfolio-item:hover img,
    .article-card:hover .article-thumb img { transform: none; }

    .product-card:hover {
        transform: none;
        box-shadow: 0 3px 12px rgba(8,39,68,.07);
    }

    .product-card:hover .product-image img { transform: none; }

    .partner-card:hover {
        transform: none;
        border-color: #EEE7DB;
    }

    .product-card:active { transform: scale(.985); }
}

@media(prefers-reduced-motion: reduce) {
    html { scroll-behavior: auto; }
    .hero-track { transition: none; }

    .hero-slide.is-active .hero-content > *,
    .hero-slide.is-active .hero-product-image { animation: none; }

    .reveal {
        opacity: 1;
        transform: none;
        transition: none;
    }
}
</style>
@endpush

@section('content')
@php
    $locale = session('site_locale', 'en');

    /* ========== KONTAK REAL ========== */
    $waNumber      = '6281320122571';
    $waDisplay     = '+62 813-2012-2571';
    $waMessage     = match($locale) {
        'id' => 'Halo TERRAWOOD, saya ingin berkonsultasi mengenai furnitur.',
        'zh' => '您好 TERRAWOOD，我想咨询家具相关问题。',
        default => 'Hello TERRAWOOD, I would like to consult about furniture.',
    };
    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waMessage);

    $contactEmail   = 'terrawoodfd@gmail.com';
    $emailSubject   = match($locale) {
        'id' => 'Konsultasi Furnitur TERRAWOOD',
        'zh' => 'TERRAWOOD 家具咨询',
        default => 'TERRAWOOD Furniture Consultation',
    };
    $emailUrl = 'mailto:' . $contactEmail . '?subject=' . rawurlencode($emailSubject);

    $address = match($locale) {
        'id' => 'Jawa Tengah, Indonesia',
        'zh' => '印度尼西亚 中爪哇',
        default => 'Central Java, Indonesia',
    };

    /* ========== ICONS ========== */
    $arrowIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>';

    $emailIcon = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>';

    /* ========== DATA ========== */
    $categories = $categories ?? collect();
    $services   = $services ?? collect();
    $portfolios = $portfolios ?? collect();
    $articles   = $articles ?? collect();
    $featuredProducts = $featuredProducts ?? collect();
    $partners = $partners ?? collect();
    $testimonials = $testimonials ?? collect();

    $pick = function ($model, array $keys, $default = null) {
        foreach ($keys as $key) {
            $value = data_get($model, $key);
            if (is_scalar($value) && $value !== '') return $value;
        }
        return $default;
    };

    $imageUrl = function ($path, $fallback = null) {
        if (empty($path)) return $fallback;
        if (preg_match('#^https?://#i', (string) $path)) return $path;
        return asset('storage/' . ltrim((string) $path, '/'));
    };

    $linkTo = function ($showRoute, $indexRoute, $model) use ($pick) {
        $slug = $pick($model, ['slug']);
        if ($slug && \Illuminate\Support\Facades\Route::has($showRoute)) {
            try { return route($showRoute, $slug); } catch (\Throwable $e) {}
        }
        return route($indexRoute);
    };

    $fallbackImages = [
        asset('images/products/01_teak_stool_with_4_legs.png'),
        asset('images/products/07_17_teak_side_table_with_branch_legs.png'),
        asset('images/products/16_teak_live_edge_corner_shelf_set_of_2.png'),
        asset('images/products/05_teak_plant_stand_24.png'),
    ];

    /* ========== BAHASA ========== */
    $t = function ($key) use ($locale) {
        $strings = [
            /* HERO 1 */
            'hero1_label' => ['en' => 'TERRAWOOD SIGNATURE COLLECTION', 'id' => 'Koleksi Signature TERRAWOOD', 'zh' => 'TERRAWOOD 精选系列'],
            'hero1_title1' => ['en' => 'Nature in', 'id' => 'Alam dalam', 'zh' => '自然于'],
            'hero1_title2' => ['en' => 'Every <span>Detail.</span>', 'id' => 'Setiap <span>Detail.</span>', 'zh' => '每个<span>细节。</span>'],
            'hero1_desc' => [
                'en' => 'Bring the warmth of nature into your space. Discover selected wooden furniture and décor with natural character and carefully crafted details.',
                'id' => 'Hadirkan kehangatan alam ke dalam ruang Anda. Temukan furnitur dan dekorasi kayu pilihan dengan karakter alami serta sentuhan pengerjaan yang teliti.',
                'zh' => '将自然的温暖融入您的空间。探索精选木质家具与装饰品，感受天然质感与精细工艺带来的独特魅力。'
            ],
            'hero1_btn' => ['en' => 'Explore the Collection', 'id' => 'Jelajahi Koleksi', 'zh' => '探索系列'],
            'hero1_kicker' => ['en' => 'CRAFTING COMFORT WITH NATURE', 'id' => 'KENYAMANAN YANG TUMBUH BERSAMA ALAM', 'zh' => '与自然共创舒适'],
            'hero1_caption' => ['en' => 'Natural teak wood collection', 'id' => 'Koleksi kayu jati alami', 'zh' => '天然柚木系列'],

            /* HERO 2 */
            'hero2_label' => ['en' => 'TIMELESS WOODEN FURNITURE', 'id' => 'FURNITUR KAYU ABADI', 'zh' => '永恒木质家具'],
            'hero2_title1' => ['en' => 'Crafted for', 'id' => 'Dirancang untuk', 'zh' => '专为'],
            'hero2_title2' => ['en' => '<span>Your Space.</span>', 'id' => '<span>Ruang Anda.</span>', 'zh' => '<span>您的空间。</span>'],
            'hero2_desc' => [
                'en' => 'Every space has its own story. Complete your home with wooden furniture that brings character, function, and natural beauty together.',
                'id' => 'Setiap ruang memiliki ceritanya sendiri. Lengkapi hunian Anda dengan furnitur kayu yang menghadirkan karakter, fungsi, dan keindahan alami.',
                'zh' => '每个空间都有自己的故事。以兼具个性、实用功能与自然之美的木质家具，完善您的生活空间。'
            ],
            'hero2_btn' => ['en' => 'Discover Products', 'id' => 'Lihat Produk', 'zh' => '探索产品'],
            'hero2_kicker' => ['en' => 'DESIGNED TO FEEL LIKE HOME', 'id' => 'DIRANCANG AGAR TERASA SEPERTI RUMAH', 'zh' => '为家而设计'],
            'hero2_caption' => ['en' => 'Handcrafted side table', 'id' => 'Meja samping hasil kerajinan tangan', 'zh' => '手工边桌'],

            /* HERO 3 */
            'hero3_label' => ['en' => 'CRAFTING COMFORT WITH NATURE', 'id' => 'KENYAMANAN BERSAMA ALAM', 'zh' => '与自然共创舒适'],
            'hero3_title1' => ['en' => 'Bring Nature', 'id' => 'Hadirkan Alam', 'zh' => '将自然'],
            'hero3_title2' => ['en' => '<span>Closer Home.</span>', 'id' => '<span>Lebih Dekat ke Rumah.</span>', 'zh' => '<span>带入家中。</span>'],
            'hero3_desc' => [
                'en' => 'From furniture to décor, TERRAWOOD offers selected pieces that help create spaces that feel warmer, more comfortable, and full of character.',
                'id' => 'Dari furnitur hingga dekorasi, TERRAWOOD menghadirkan koleksi pilihan yang membantu menciptakan ruang lebih hangat, nyaman, dan berkarakter.',
                'zh' => '从家具到装饰，TERRAWOOD 提供多样精选产品，帮助您打造更温暖、舒适且富有个性的空间。'
            ],
            'hero3_btn' => ['en' => 'About TERRAWOOD', 'id' => 'Tentang TERRAWOOD', 'zh' => '关于 TERRAWOOD'],
            'hero3_kicker' => ['en' => 'PT. TERRAWOOD FURNITUR DEKORASI', 'id' => 'PT. TERRAWOOD FURNITUR DEKORASI', 'zh' => 'PT. TERRAWOOD 家具装饰'],
            'hero3_caption' => ['en' => 'Natural home accents', 'id' => 'Aksen rumah alami', 'zh' => '自然家居装饰'],

            /* BENEFITS */
            'b1_strong' => ['en' => 'Premium Materials', 'id' => 'Material Premium', 'zh' => '优质材料'],
            'b1_span' => ['en' => 'Quality & Eco-friendly', 'id' => 'Berkualitas & Ramah Lingkungan', 'zh' => '高品质且环保'],
            'b2_strong' => ['en' => 'Modern Design', 'id' => 'Desain Modern', 'zh' => '现代设计'],
            'b2_span' => ['en' => 'Elegant & Functional', 'id' => 'Elegan & Fungsional', 'zh' => '优雅且实用'],
            'b3_strong' => ['en' => 'Professional Service', 'id' => 'Layanan Profesional', 'zh' => '专业服务'],
            'b3_span' => ['en' => 'Responsive & Trusted', 'id' => 'Responsif & Terpercaya', 'zh' => '响应迅速且可靠'],
            'b4_strong' => ['en' => 'Worldwide Shipping', 'id' => 'Pengiriman Aman', 'zh' => '全球配送'],
            'b4_span' => ['en' => 'Safe delivery worldwide', 'id' => 'Pengiriman aman ke seluruh dunia', 'zh' => '安全配送至全球各地'],

            /* CATEGORIES */
            'cat_label' => ['en' => 'OUR COLLECTION', 'id' => 'KOLEKSI KAMI', 'zh' => '我们的系列'],
            'cat_title' => ['en' => 'Shop by Category', 'id' => 'Belanja Berdasarkan Kategori', 'zh' => '按类别购物'],
            'cat_desc' => ['en' => 'Find the furniture and décor you are looking for.', 'id' => 'Temukan furnitur dan dekorasi yang Anda cari.', 'zh' => '找到您想要的家具和装饰。'],
            'cat_small' => ['en' => 'View collection', 'id' => 'Lihat koleksi', 'zh' => '查看系列'],

            /* PRODUCTS */
            'prod_label' => ['en' => 'FEATURED PRODUCTS', 'id' => 'PRODUK UNGGULAN', 'zh' => '精选产品'],
            'prod_title' => ['en' => 'Best Collection for Your Home', 'id' => 'Koleksi Terbaik untuk Hunian Anda', 'zh' => '您家的最佳系列'],
            'prod_desc' => ['en' => 'Discover a variety of furniture with modern designs and premium quality.', 'id' => 'Temukan berbagai pilihan furnitur dengan desain modern dan kualitas premium.', 'zh' => '探索各种现代设计和优质家具。'],
            'prod_link' => ['en' => 'View All Products', 'id' => 'Lihat Semua Produk', 'zh' => '查看所有产品'],
            'prod_detail' => ['en' => 'View Details', 'id' => 'Lihat Detail', 'zh' => '查看详情'],
            'prod_empty_title' => ['en' => 'Featured Products Coming Soon', 'id' => 'Produk Unggulan Segera Hadir', 'zh' => '精选产品即将推出'],
            'prod_empty_text' => ['en' => 'We are preparing the best collection for you.', 'id' => 'Kami sedang menyiapkan koleksi terbaik untuk Anda.', 'zh' => '我们正在为您准备最佳系列。'],
            'prod_contact' => ['en' => 'Contact Us', 'id' => 'Hubungi Kami', 'zh' => '联系我们'],

            /* STATEMENT */
            'stmt_label' => ['en' => 'OUR PHILOSOPHY', 'id' => 'FILOSOFI KAMI', 'zh' => '我们的理念'],
            'stmt_quote1' => ['en' => 'Every wood grain has a <em>story.</em>', 'id' => 'Setiap serat kayu punya <em>cerita.</em>', 'zh' => '每一道木纹都有<em>故事。</em>'],
            'stmt_quote2' => ['en' => 'We keep it alive in every touch.', 'id' => 'Kami menjaganya tetap utuh di setiap sentuhan.', 'zh' => '我们在每一次触碰中守护它。'],
            'stmt_p1_strong' => ['en' => 'Natural Materials', 'id' => 'Material Alami', 'zh' => '天然材料'],
            'stmt_p1_span' => ['en' => 'Selected wood with unique character in every piece.', 'id' => 'Kayu pilihan dengan karakter unik pada setiap potong.', 'zh' => '精选木材，每块都有独特个性。'],
            'stmt_p2_strong' => ['en' => 'Careful Craftsmanship', 'id' => 'Pengerjaan Teliti', 'zh' => '精细工艺'],
            'stmt_p2_span' => ['en' => 'Every detail is carefully finished to the last stage.', 'id' => 'Setiap detail diperhatikan hingga tahap akhir.', 'zh' => '每个细节都精心处理至最后阶段。'],
            'stmt_p3_strong' => ['en' => 'Long Lasting', 'id' => 'Tahan Lama', 'zh' => '持久耐用'],
            'stmt_p3_span' => ['en' => 'Designed to accompany your home for years.', 'id' => 'Dirancang untuk menemani hunian Anda bertahun-tahun.', 'zh' => '专为陪伴您的家多年而设计。'],

            /* SERVICES */
            'svc_label' => ['en' => 'SERVICES', 'id' => 'LAYANAN', 'zh' => '服务'],
            'svc_title' => ['en' => 'Solutions for Every Space', 'id' => 'Solusi untuk Setiap Ruang', 'zh' => '适合每个空间的解决方案'],
            'svc_link' => ['en' => 'View All Services', 'id' => 'Lihat Semua Layanan', 'zh' => '查看所有服务'],
            'svc_more' => ['en' => 'Learn more', 'id' => 'Selengkapnya', 'zh' => '了解更多'],

            /* PORTFOLIO */
            'pf_label' => ['en' => 'PORTFOLIO', 'id' => 'PORTOFOLIO', 'zh' => '作品集'],
            'pf_title' => ['en' => 'Our Selected Projects', 'id' => 'Proyek Pilihan Kami', 'zh' => '我们精选的项目'],
            'pf_link' => ['en' => 'View All Projects', 'id' => 'Lihat Semua Proyek', 'zh' => '查看所有项目'],

            /* STEPS */
            'step_label' => ['en' => 'ORDER PROCESS', 'id' => 'CARA PEMESANAN', 'zh' => '订购流程'],
            'step_title' => ['en' => 'Order Furniture in 4 Steps', 'id' => 'Pesan Furnitur dalam 4 Langkah', 'zh' => '4个步骤订购家具'],
            'step_desc' => ['en' => 'A simple process from choosing to receiving your product.', 'id' => 'Proses sederhana dari memilih hingga produk sampai.', 'zh' => '从选择到收货的简单流程。'],
            'step1_title' => ['en' => 'Choose Product', 'id' => 'Pilih Produk', 'zh' => '选择产品'],
            'step1_desc' => ['en' => 'Browse the catalog and choose furniture that fits your space.', 'id' => 'Jelajahi katalog dan pilih furnitur sesuai kebutuhan.', 'zh' => '浏览目录，选择适合您空间的家具。'],
            'step2_title' => ['en' => 'Consultation', 'id' => 'Konsultasi', 'zh' => '咨询'],
            'step2_desc' => ['en' => 'Contact us via WhatsApp to discuss size, material, and finish.', 'id' => 'Hubungi kami via WhatsApp untuk ukuran, material, dan finishing.', 'zh' => '通过WhatsApp联系我们讨论尺寸、材料和表面处理。'],
            'step3_title' => ['en' => 'Confirm & Production', 'id' => 'Konfirmasi & Produksi', 'zh' => '确认与生产'],
            'step3_desc' => ['en' => 'Once agreed, your order is processed with careful craftsmanship.', 'id' => 'Setelah disepakati, pesanan diproses dengan teliti.', 'zh' => '确认后，订单将精心加工。'],
            'step4_title' => ['en' => 'Delivery', 'id' => 'Pengiriman', 'zh' => '配送'],
            'step4_desc' => ['en' => 'Products are safely packed and delivered to your location.', 'id' => 'Produk dikemas aman dan dikirim ke lokasi Anda.', 'zh' => '产品安全包装并送达您的地址。'],
            'step_cta' => ['en' => 'Start Consultation', 'id' => 'Mulai Konsultasi', 'zh' => '开始咨询'],

            /* ABOUT */
            'about_label' => ['en' => 'ABOUT OUR COMPANY', 'id' => 'TENTANG PERUSAHAAN KAMI', 'zh' => '关于我们公司'],
            'about_title' => ['en' => 'About TERRAWOOD', 'id' => 'Tentang TERRAWOOD', 'zh' => '关于 TERRAWOOD'],
            'about_desc' => [
                'en' => 'PT. TERRAWOOD FURNITUR DEKORASI is a company specializing in furniture and interior decoration. We deliver quality products with modern, elegant designs and natural touches to create comfortable and aesthetically pleasing spaces.',
                'id' => 'PT. TERRAWOOD FURNITUR DEKORASI adalah perusahaan yang bergerak di bidang furnitur dan dekorasi interior. Kami menghadirkan produk berkualitas dengan desain modern, elegan, dan sentuhan alami untuk menciptakan ruang nyaman serta bernilai estetika tinggi.',
                'zh' => 'PT. TERRAWOOD 家具装饰是一家专注于家具和室内装饰的公司。我们提供现代、优雅设计并融入自然元素的优质产品，打造舒适且具美感的空间。'
            ],
            'stat1' => ['en' => 'Years Experience', 'id' => 'Tahun Pengalaman', 'zh' => '年经验'],
            'stat2' => ['en' => 'Satisfied Customers', 'id' => 'Pelanggan Puas', 'zh' => '满意客户'],
            'stat3' => ['en' => 'Completed Projects', 'id' => 'Proyek Selesai', 'zh' => '完成项目'],

            /* PARTNERS */
            'part_label' => ['en' => 'OUR PARTNERS', 'id' => 'MITRA KAMI', 'zh' => '我们的合作伙伴'],
            'part_title' => ['en' => 'Clients & Partners', 'id' => 'Klien & Mitra Kami', 'zh' => '客户与合作伙伴'],
            'part_desc' => ['en' => 'Building relationships and collaborations for the best results.', 'id' => 'Membangun kerja sama untuk hasil terbaik.', 'zh' => '建立合作关系以获得最佳成果。'],
            'part_empty' => ['en' => 'Partner information will be available soon.', 'id' => 'Informasi mitra akan segera tersedia.', 'zh' => '合作伙伴信息即将推出。'],

            /* TESTIMONIALS */
            'test_label' => ['en' => 'CUSTOMER REVIEWS', 'id' => 'TESTIMONI PELANGGAN', 'zh' => '客户评价'],
            'test_title' => ['en' => 'What They Say?', 'id' => 'Apa Kata Mereka?', 'zh' => '他们怎么说？'],
            'test_desc' => ['en' => 'Customer satisfaction is our top priority.', 'id' => 'Kepuasan pelanggan adalah prioritas utama kami.', 'zh' => '客户满意是我们的首要任务。'],
            'test_empty' => ['en' => 'Customer testimonials will be displayed soon.', 'id' => 'Testimoni pelanggan akan segera ditampilkan.', 'zh' => '客户评价即将显示。'],
            'test_role' => ['en' => 'TERRAWOOD Customer', 'id' => 'Pelanggan TERRAWOOD', 'zh' => 'TERRAWOOD 客户'],

            /* ARTICLES */
            'art_label' => ['en' => 'INSPIRATION', 'id' => 'INSPIRASI', 'zh' => '灵感'],
            'art_title' => ['en' => 'Latest Articles & Tips', 'id' => 'Artikel & Tips Terbaru', 'zh' => '最新文章与技巧'],
            'art_link' => ['en' => 'View All Articles', 'id' => 'Lihat Semua Artikel', 'zh' => '查看所有文章'],
            'art_more' => ['en' => 'Read More', 'id' => 'Baca selengkapnya', 'zh' => '阅读更多'],

            /* CTA */
            'cta_label' => ['en' => 'CUSTOM FURNITURE', 'id' => 'FURNITUR CUSTOM', 'zh' => '定制家具'],
            'cta_title' => [
                'en' => 'Have Your Own Design? Bring It to Life with TERRAWOOD.',
                'id' => 'Punya Desain Sendiri? Wujudkan Bersama TERRAWOOD.',
                'zh' => '有自己的设计？与 TERRAWOOD 一起将它变为现实。'
            ],
            'cta_desc' => [
                'en' => 'Tell us about your space and our team will help you from the initial concept to the finished product.',
                'id' => 'Ceritakan kebutuhan ruang Anda. Tim kami siap membantu dari konsep hingga produk jadi.',
                'zh' => '告诉我们您的空间需求，我们的团队将从概念到成品为您提供帮助。'
            ],
            'cta_wa' => ['en' => 'Consult via WhatsApp', 'id' => 'Konsultasi via WhatsApp', 'zh' => '通过 WhatsApp 咨询'],
            'cta_email' => ['en' => 'Send Email', 'id' => 'Kirim Email', 'zh' => '发送电子邮件'],
            'cta_catalog' => ['en' => 'View Catalog', 'id' => 'Lihat Katalog', 'zh' => '查看目录'],

            /* CONTACT */
            'contact_label_wa' => ['en' => 'WHATSAPP', 'id' => 'WHATSAPP', 'zh' => 'WHATSAPP'],
            'contact_label_email' => ['en' => 'EMAIL', 'id' => 'EMAIL', 'zh' => '电子邮件'],
            'contact_label_address' => ['en' => 'LOCATION', 'id' => 'LOKASI', 'zh' => '位置'],
        ];
        return $strings[$key][$locale] ?? $strings[$key]['en'] ?? '';
    };
@endphp

<div class="home-page">
    @include('partials.navbar')

    {{-- HERO SLIDER --}}
    <section class="hero" id="heroSlider" aria-roledescription="carousel" aria-label="{{ t3('Koleksi Unggulan TERRAWOOD', 'Featured TERRAWOOD Collection', 'TERRAWOOD 精选系列') }}">
        <div class="hero-track" id="heroTrack">
            {{-- SLIDE 1 --}}
            <div class="hero-slide">
                <div class="hero-left">
                    <div class="hero-content">
                        <p class="hero-label">{!! $t('hero1_label') !!}</p>
                        <h1>
                            {!! $t('hero1_title1') !!}
                            <br>
                            {!! $t('hero1_title2') !!}
                        </h1>
                        <p class="hero-description">{!! $t('hero1_desc') !!}</p>
                        <div class="hero-actions">
                            <a href="{{ route('catalog.index') }}" class="hero-button">
                                {!! $t('hero1_btn') !!}
                                <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                            </a>
                            <a href="{{ $emailUrl }}" class="btn-email">
                                {!! $emailIcon !!}
                                {!! $t('cta_email') !!}
                            </a>
                        </div>
                        <div class="hero-kicker">{!! $t('hero1_kicker') !!}</div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-product-frame">
                        <img src="{{ asset('images/products/01_teak_stool_with_4_legs.png') }}"
                             alt="Teak Stool - TERRAWOOD"
                             class="hero-product-image"
                             width="800" height="600"
                             loading="eager" fetchpriority="high" decoding="async">
                    </div>
                    <span class="hero-image-caption">{!! $t('hero1_caption') !!}</span>
                </div>
            </div>

            {{-- SLIDE 2 --}}
            <div class="hero-slide">
                <div class="hero-left">
                    <div class="hero-content">
                        <p class="hero-label">{!! $t('hero2_label') !!}</p>
                        <h1>
                            {!! $t('hero2_title1') !!}
                            <br>
                            {!! $t('hero2_title2') !!}
                        </h1>
                        <p class="hero-description">{!! $t('hero2_desc') !!}</p>
                        <div class="hero-actions">
                            <a href="{{ route('catalog.index') }}" class="hero-button">
                                {!! $t('hero2_btn') !!}
                                <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                            </a>
                            <a href="{{ $emailUrl }}" class="btn-email">
                                {!! $emailIcon !!}
                                {!! $t('cta_email') !!}
                            </a>
                        </div>
                        <div class="hero-kicker">{!! $t('hero2_kicker') !!}</div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-product-frame">
                        <img src="{{ asset('images/products/07_17_teak_side_table_with_branch_legs.png') }}"
                             alt="Teak Side Table - TERRAWOOD"
                             class="hero-product-image"
                             width="800" height="600"
                             loading="lazy" decoding="async">
                    </div>
                    <span class="hero-image-caption">{!! $t('hero2_caption') !!}</span>
                </div>
            </div>

            {{-- SLIDE 3 --}}
            <div class="hero-slide">
                <div class="hero-left">
                    <div class="hero-content">
                        <p class="hero-label">{!! $t('hero3_label') !!}</p>
                        <h1>
                            {!! $t('hero3_title1') !!}
                            <br>
                            {!! $t('hero3_title2') !!}
                        </h1>
                        <p class="hero-description">{!! $t('hero3_desc') !!}</p>
                        <div class="hero-actions">
                            <a href="#tentang" class="hero-button">
                                {!! $t('hero3_btn') !!}
                                <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                            </a>
                            <a href="{{ $emailUrl }}" class="btn-email">
                                {!! $emailIcon !!}
                                {!! $t('cta_email') !!}
                            </a>
                        </div>
                        <div class="hero-kicker">{!! $t('hero3_kicker') !!}</div>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-product-frame">
                        <img src="{{ asset('images/products/16_teak_live_edge_corner_shelf_set_of_2.png') }}"
                             alt="Corner Shelf - TERRAWOOD"
                             class="hero-product-image"
                             width="800" height="600"
                             loading="lazy" decoding="async">
                    </div>
                    <span class="hero-image-caption">{!! $t('hero3_caption') !!}</span>
                </div>
            </div>
        </div>

        <div class="hero-controls">
            <div class="hero-dots" id="heroDots"></div>
            <div class="hero-counter">
                <strong id="heroCurrent">01</strong> / 03
            </div>
            <button type="button" id="heroPrev" aria-label="{{ t3('Slide sebelumnya', 'Previous slide', '上一张') }}">←</button>
            <button type="button" id="heroNext" aria-label="{{ t3('Slide berikutnya', 'Next slide', '下一张') }}">→</button>
        </div>
    </section>

    {{-- BENEFIT STRIP --}}
    <section class="benefit-strip">
        <div class="benefit-item">
            <div class="benefit-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M11 20C5 17 4 11 7 5c5 0 9 3 9 8 0 3-2 6-5 7Z"/>
                    <path d="M5 21c2-5 6-8 12-11"/>
                    <path d="M16 4c2-1 4-1 5-1 0 2 0 4-1 6"/>
                </svg>
            </div>
            <div>
                <strong>{!! $t('b1_strong') !!}</strong>
                <span>{!! $t('b1_span') !!}</span>
            </div>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="m12 3 8 4v5c0 5-3.5 8-8 9-4.5-1-8-4-8-9V7l8-4Z"/>
                    <path d="m8.5 12 2.3 2.3 4.8-5"/>
                </svg>
            </div>
            <div>
                <strong>{!! $t('b2_strong') !!}</strong>
                <span>{!! $t('b2_span') !!}</span>
            </div>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 13v-2a8 8 0 0 1 16 0v2"/>
                    <path d="M4 13h3v6H6a2 2 0 0 1-2-2v-4Z"/>
                    <path d="M20 13h-3v6h1a2 2 0 0 0 2-2v-4Z"/>
                    <path d="M17 19c-1 2-3 2-5 2"/>
                </svg>
            </div>
            <div>
                <strong>{!! $t('b3_strong') !!}</strong>
                <span>{!! $t('b3_span') !!}</span>
            </div>
        </div>
        <div class="benefit-item">
            <div class="benefit-icon">
                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M3 12h18"/>
                    <path d="M12 3a14 14 0 0 1 0 18"/>
                    <path d="M12 3a14 14 0 0 0 0 18"/>
                    <path d="m16 8 2 2 3-3"/>
                </svg>
            </div>
            <div>
                <strong>{!! $t('b4_strong') !!}</strong>
                <span>{!! $t('b4_span') !!}</span>
            </div>
        </div>
    </section>

    {{-- CATEGORIES --}}
    @if($categories->isNotEmpty())
    <section class="categories-section" id="kategori">
        <div class="section-heading center">
            <p class="section-label">{!! $t('cat_label') !!}</p>
            <h2 class="section-title">{!! $t('cat_title') !!}</h2>
            <p class="section-description">{!! $t('cat_desc') !!}</p>
        </div>
        <div class="categories-grid">
            @foreach($categories as $category)
                @php
                    /* Foto kategori diunggah manual lewat Admin > Kategori.
                       Jika belum ada foto, tampilkan blok warna polos (tanpa foto otomatis). */
                    $catImage = $imageUrl($pick($category, ['image']));
                @endphp
                <a href="{{ route('catalog.index', ['category' => $category->id]) }}" class="category-tile">
                    @if($catImage)
                        <img src="{{ $catImage }}"
                             alt="{{ $category->localized('name') }}"
                             width="600" height="450"
                             loading="lazy" decoding="async"
                             style="object-fit:cover;padding:0;">
                    @else
                        <span aria-hidden="true" style="position:absolute;inset:0 0 70px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.22);">
                            <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20C5 17 4 11 7 5c5 0 9 3 9 8 0 3-2 6-5 7Z"/><path d="M5 21c2-5 6-8 12-11"/></svg>
                        </span>
                    @endif
                    <span class="category-label">
                        <span>
                            <strong>{{ $category->localized('name') }}</strong>
                            <small>{!! $t('cat_small') !!}</small>
                        </span>
                        <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- PRODUCTS --}}
    <section class="products-section" id="katalog">
        <div class="products-layout">
            <div class="products-intro">
                <p class="section-label">{!! $t('prod_label') !!}</p>
                <h2 class="section-title">{!! $t('prod_title') !!}</h2>
                <p class="section-description">{!! $t('prod_desc') !!}</p>
                <a href="{{ route('catalog.index') }}" class="products-link">
                    {!! $t('prod_link') !!}
                    <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                </a>
            </div>
            <div class="products-grid">
                @forelse($featuredProducts as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}"
                                     alt="{{ $product->localized('name') }}"
                                     width="400" height="300"
                                     loading="lazy" decoding="async">
                            @else
                                <img src="{{ asset('images/products/01_teak_stool_with_4_legs.png') }}"
                                     alt="TERRAWOOD Collection"
                                     width="400" height="300"
                                     loading="lazy" decoding="async">
                            @endif
                        </div>
                        <div class="product-info">
                            <div class="product-category">
                                {{ $product->category?->localized('name') ?? 'Furniture' }}
                            </div>
                            <h3 class="product-name">{{ $product->localized('name') }}</h3>
                            <div class="product-price">
                                @if(!empty($product->discount_price) && (float) $product->discount_price > 0 && (float) $product->discount_price < (float) $product->price)
                                    <span class="price-original">Rp {{ number_format((float) $product->price, 0, ',', '.') }}</span>
                                    <span class="price-discount">Rp {{ number_format((float) $product->discount_price, 0, ',', '.') }}</span>
                                @elseif(!empty($product->price))
                                    Rp {{ number_format((float) $product->price, 0, ',', '.') }}
                                @else
                                    {!! $t('prod_contact') !!}
                                @endif
                            </div>
                            <a href="{{ route('catalog.show', $product->slug) }}" class="product-detail">
                                {!! $t('prod_detail') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="product-empty">
                        <h3>{!! $t('prod_empty_title') !!}</h3>
                        <p>{!! $t('prod_empty_text') !!}</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- STATEMENT --}}
    <section class="statement-section">
        <div class="statement-inner">
            <p class="section-label">{!! $t('stmt_label') !!}</p>
            <h2 class="statement-quote">
                {!! $t('stmt_quote1') !!}
                <br>
                {!! $t('stmt_quote2') !!}
            </h2>
            <div class="statement-points">
                <div>
                    <strong>{!! $t('stmt_p1_strong') !!}</strong>
                    <span>{!! $t('stmt_p1_span') !!}</span>
                </div>
                <div>
                    <strong>{!! $t('stmt_p2_strong') !!}</strong>
                    <span>{!! $t('stmt_p2_span') !!}</span>
                </div>
                <div>
                    <strong>{!! $t('stmt_p3_strong') !!}</strong>
                    <span>{!! $t('stmt_p3_span') !!}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SERVICES --}}
    @if($services->isNotEmpty())
    <section class="services-section" id="layanan">
        <div class="section-heading split">
            <div>
                <p class="section-label">{!! $t('svc_label') !!}</p>
                <h2 class="section-title">{!! $t('svc_title') !!}</h2>
            </div>
            <a href="{{ route('services.index') }}" class="text-link">
                {!! $t('svc_link') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
            </a>
        </div>
        <div class="services-grid">
            @foreach($services as $service)
                @php
                    $svTitle = $pick($service, ['name', 'title'], 'TERRAWOOD Service');
                    $svText  = $pick($service, ['short_description', 'excerpt', 'summary', 'description'], '');
                    $svDesc  = \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode((string) $svText))), 110);
                    $svImage = $imageUrl($pick($service, ['image', 'thumbnail', 'photo']));
                    $svUrl   = $linkTo('services.show', 'services.index', $service);
                @endphp
                <a href="{{ $svUrl }}" class="service-card">
                    <span class="service-index" aria-hidden="true">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                    @if($svImage)
                        <span class="service-media">
                            <img src="{{ $svImage }}" alt="{{ $svTitle }}"
                                 width="400" height="280" loading="lazy" decoding="async">
                        </span>
                    @else
                        <span class="service-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24">
                                <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                            </svg>
                        </span>
                    @endif
                    <h3>{{ $svTitle }}</h3>
                    @if($svDesc !== '')
                        <p>{{ $svDesc }}</p>
                    @endif
                    <span class="service-more">
                        {!! $t('svc_more') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- PORTFOLIO --}}
    @if($portfolios->isNotEmpty())
    <section class="portfolio-section" id="proyek">
        <div class="section-heading split">
            <div>
                <p class="section-label">{!! $t('pf_label') !!}</p>
                <h2 class="section-title">{!! $t('pf_title') !!}</h2>
            </div>
            <a href="{{ route('portfolios.index') }}" class="text-link">
                {!! $t('pf_link') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
            </a>
        </div>
        <div class="portfolio-grid">
            @foreach($portfolios as $portfolio)
                @php
                    $ptTitle = $pick($portfolio, ['title', 'name', 'project_name'], 'TERRAWOOD Project');
                    $ptMeta  = $pick($portfolio, ['location', 'client_name', 'client', 'year']);
                    $ptPath  = $pick($portfolio, ['image', 'thumbnail', 'photo', 'cover', 'featured_image']);
                    $ptImage = $imageUrl($ptPath, $fallbackImages[$loop->index % count($fallbackImages)]);
                    $ptUrl   = $linkTo('portfolios.show', 'portfolios.index', $portfolio);
                @endphp
                <a href="{{ $ptUrl }}" class="portfolio-item">
                    <img src="{{ $ptImage }}" alt="{{ $ptTitle }}"
                         class="{{ $ptPath ? '' : 'is-fallback' }}"
                         width="800" height="600" loading="lazy" decoding="async">
                    <span class="portfolio-caption">
                        <strong>{{ $ptTitle }}</strong>
                        @if($ptMeta)
                            <small>{{ $ptMeta }}</small>
                        @endif
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- STEPS --}}
    <section class="steps-section" id="cara-pesan">
        <div class="section-heading center">
            <p class="section-label">{!! $t('step_label') !!}</p>
            <h2 class="section-title">{!! $t('step_title') !!}</h2>
            <p class="section-description">{!! $t('step_desc') !!}</p>
        </div>
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-badge">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                    <span class="step-number">1</span>
                </div>
                <div class="step-text">
                    <h3>{!! $t('step1_title') !!}</h3>
                    <p>{!! $t('step1_desc') !!}</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-badge">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>
                    </svg>
                    <span class="step-number">2</span>
                </div>
                <div class="step-text">
                    <h3>{!! $t('step2_title') !!}</h3>
                    <p>{!! $t('step2_desc') !!}</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-badge">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>
                    </svg>
                    <span class="step-number">3</span>
                </div>
                <div class="step-text">
                    <h3>{!! $t('step3_title') !!}</h3>
                    <p>{!! $t('step3_desc') !!}</p>
                </div>
            </div>
            <div class="step-item">
                <div class="step-badge">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/>
                        <path d="M15 18H9"/>
                        <path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/>
                        <circle cx="17" cy="18" r="2"/>
                        <circle cx="7" cy="18" r="2"/>
                    </svg>
                    <span class="step-number">4</span>
                </div>
                <div class="step-text">
                    <h3>{!! $t('step4_title') !!}</h3>
                    <p>{!! $t('step4_desc') !!}</p>
                </div>
            </div>
        </div>
        <div class="steps-cta">
            <a href="{{ $waUrl }}" class="hero-button" target="_blank" rel="noopener">
                {!! $t('step_cta') !!}
                <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
            </a>
        </div>
    </section>

    {{-- ABOUT --}}
    <section class="about-section" id="tentang">
        <div class="about-image">
            <img src="{{ asset('images/products/05_teak_plant_stand_24.png') }}"
                 alt="TERRAWOOD Plant Stand"
                 width="600" height="450"
                 loading="lazy" decoding="async">
        </div>
        <div class="about-content">
            <p class="section-label">{!! $t('about_label') !!}</p>
            <h2 class="section-title">{!! $t('about_title') !!}</h2>
            <p>{!! $t('about_desc') !!}</p>

            <div class="contact-grid">
                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="contact-info-card">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>
                        </svg>
                    </div>
                    <div class="contact-info-text">
                        <strong>{!! $t('contact_label_wa') !!}</strong>
                        <span>{{ $waDisplay }}</span>
                    </div>
                </a>

                <a href="{{ $emailUrl }}" class="contact-info-card">
                    <div class="contact-info-icon">
                        <svg viewBox="0 0 24 24">
                            <rect width="20" height="16" x="2" y="4" rx="2"/>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                        </svg>
                    </div>
                    <div class="contact-info-text">
                        <strong>{!! $t('contact_label_email') !!}</strong>
                        <span>{{ $contactEmail }}</span>
                    </div>
                </a>
            </div>

            <div class="about-stats">
                <div class="about-stat">
                    <strong data-count="10" data-suffix="+">10+</strong>
                    <span>{!! $t('stat1') !!}</span>
                </div>
                <div class="about-stat">
                    <strong data-count="5" data-suffix="K+">5K+</strong>
                    <span>{!! $t('stat2') !!}</span>
                </div>
                <div class="about-stat">
                    <strong data-count="200" data-suffix="+">200+</strong>
                    <span>{!! $t('stat3') !!}</span>
                </div>
            </div>
        </div>
    </section>

    {{-- PARTNERS --}}
    <section class="partners-section" id="mitra">
        <div class="section-heading center">
            <p class="section-label">{!! $t('part_label') !!}</p>
            <h2 class="section-title">{!! $t('part_title') !!}</h2>
            <p class="section-description">{!! $t('part_desc') !!}</p>
        </div>
        <div class="partners-grid">
            @forelse($partners as $partner)
                <div class="partner-card">
                    @if($partner->logo)
                        <img src="{{ asset('storage/' . $partner->logo) }}"
                             alt="{{ $partner->localized('name') }}"
                             width="140" height="60"
                             loading="lazy" decoding="async">
                    @endif
                    <strong>{{ $partner->localized('name') }}</strong>
                </div>
            @empty
                <div class="home-empty">{!! $t('part_empty') !!}</div>
            @endforelse
        </div>
    </section>

    {{-- TESTIMONIALS --}}
    <section class="testimonials-section" id="testimoni">
        <div class="section-heading center">
            <p class="section-label">{!! $t('test_label') !!}</p>
            <h2 class="section-title">{!! $t('test_title') !!}</h2>
            <p class="section-description">{!! $t('test_desc') !!}</p>
        </div>
        <div class="testimonials-grid">
            @forelse($testimonials as $testimonial)
                <div class="testimonial-card">
                    <div class="testimonial-stars" aria-label="{{ t3('Peringkat', 'Rating', '评分') }} {{ (int) $testimonial->rating }} / 5">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $testimonial->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                    <p class="testimonial-text">
                        "{{ $testimonial->testimonial }}"
                    </p>
                    <div class="testimonial-person">
                        @if($testimonial->customer_photo)
                            <img src="{{ asset('storage/' . $testimonial->customer_photo) }}"
                                 alt="{{ $testimonial->customer_name }}"
                                 width="42" height="42"
                                 loading="lazy" decoding="async">
                        @else
                            <div class="testimonial-avatar" aria-hidden="true">
                                {{ mb_strtoupper(mb_substr($testimonial->customer_name ?? 'T', 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <strong>{{ $testimonial->customer_name }}</strong>
                            <span>{!! $t('test_role') !!}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="home-empty">{!! $t('test_empty') !!}</div>
            @endforelse
        </div>
    </section>

    {{-- ARTICLES --}}
    @if($articles->isNotEmpty())
    <section class="articles-section" id="artikel">
        <div class="section-heading split">
            <div>
                <p class="section-label">{!! $t('art_label') !!}</p>
                <h2 class="section-title">{!! $t('art_title') !!}</h2>
            </div>
            <a href="{{ route('articles.index') }}" class="text-link">
                {!! $t('art_link') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
            </a>
        </div>
        <div class="articles-grid">
            @foreach($articles as $article)
                @php
                    $arTitle   = $pick($article, ['title'], 'TERRAWOOD Article');
                    $arPath    = $pick($article, ['image', 'thumbnail', 'cover', 'featured_image']);
                    $arImage   = $imageUrl($arPath, $fallbackImages[$loop->index % count($fallbackImages)]);
                    $arText    = $pick($article, ['excerpt', 'summary', 'description', 'content', 'body'], '');
                    $arExcerpt = \Illuminate\Support\Str::limit(trim(strip_tags(html_entity_decode((string) $arText))), 120);
                    $arDate    = $article->created_at?->locale($locale === 'zh' ? 'zh_CN' : ($locale === 'id' ? 'id' : 'en'))->translatedFormat('d F Y');
                    $arUrl     = $linkTo('articles.show', 'articles.index', $article);
                @endphp
                <a href="{{ $arUrl }}" class="article-card">
                    <span class="article-thumb">
                        <img src="{{ $arImage }}" alt="{{ $arTitle }}"
                             class="{{ $arPath ? '' : 'is-fallback' }}"
                             width="640" height="400"
                             loading="lazy" decoding="async">
                    </span>
                    <span class="article-body">
                        @if($arDate)
                            <span class="article-date">{{ $arDate }}</span>
                        @endif
                        <h3>{{ $arTitle }}</h3>
                        @if($arExcerpt !== '')
                            <p>{{ $arExcerpt }}</p>
                        @endif
                        <span class="article-more">
                            {!! $t('art_more') !!} <span aria-hidden="true">{!! $arrowIcon !!}</span>
                        </span>
                    </span>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- CTA --}}
    <section class="cta-section">
        <div class="cta-box">
            <div>
                <p class="cta-label">{!! $t('cta_label') !!}</p>
                <h2>{!! $t('cta_title') !!}</h2>
                <p>{!! $t('cta_desc') !!}</p>
            </div>
            <div class="cta-actions">
                <a href="{{ $waUrl }}" class="hero-button" target="_blank" rel="noopener">
                    {!! $t('cta_wa') !!}
                    <span class="btn-arrow" aria-hidden="true">{!! $arrowIcon !!}</span>
                </a>
                <a href="{{ $emailUrl }}" class="btn-email">
                    {!! $emailIcon !!}
                    {!! $t('cta_email') !!}
                </a>
                <a href="{{ route('catalog.index') }}" class="cta-secondary">
                    {!! $t('cta_catalog') !!}
                </a>
            </div>
        </div>
    </section>

    @include('partials.footer')
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    if ('IntersectionObserver' in window && !reduceMotion) {
        const revealObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in');
                    revealObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });

        document.querySelectorAll(
            '.benefit-strip, .products-intro, .products-grid, .about-content, ' +
            '.partners-section .section-heading, .partners-grid, ' +
            '.testimonials-section .section-heading, .testimonials-grid, ' +
            '.categories-section .section-heading, .categories-grid, .statement-inner, ' +
            '.services-section .section-heading, .services-grid, ' +
            '.portfolio-section .section-heading, .portfolio-grid, ' +
            '.steps-section .section-heading, .steps-grid, .steps-cta, ' +
            '.articles-section .section-heading, .articles-grid, .cta-box, .contact-grid'
        ).forEach(function (element) {
            element.classList.add('reveal');
            revealObserver.observe(element);
        });
    }

    const counters = document.querySelectorAll('[data-count]');
    function animateCount(element) {
        const target = parseFloat(element.dataset.count);
        const suffix = element.dataset.suffix || '';
        if (isNaN(target)) return;
        const duration = 1400;
        const startTime = performance.now();
        function tick(now) {
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            element.textContent = Math.round(target * eased) + suffix;
            if (progress < 1) window.requestAnimationFrame(tick);
        }
        window.requestAnimationFrame(tick);
    }

    if (counters.length && 'IntersectionObserver' in window && !reduceMotion) {
        const counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCount(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.6 });
        counters.forEach(function (counter) { counterObserver.observe(counter); });
    }

    const slider = document.getElementById('heroSlider');
    if (!slider) return;
    const track = document.getElementById('heroTrack');
    const slides = track.querySelectorAll('.hero-slide');
    const currentNumber = document.getElementById('heroCurrent');
    const prevButton = document.getElementById('heroPrev');
    const nextButton = document.getElementById('heroNext');
    const dotsWrap = document.getElementById('heroDots');
    const AUTO_SLIDE_DELAY = 15000;
    let currentIndex = 0;
    let sliderInterval = null;
    const totalSlides = slides.length;
    const dots = [];

    slides.forEach(function (slide, index) {
        const dot = document.createElement('button');
        dot.type = 'button';
        dot.setAttribute('aria-label', 'Slide ' + (index + 1));
        dot.addEventListener('click', function () {
            showSlide(index);
            startAutoSlide();
        });
        dotsWrap.appendChild(dot);
        dots.push(dot);
    });

    function showSlide(index) {
        currentIndex = (index + totalSlides) % totalSlides;
        track.style.transform = 'translateX(-' + (currentIndex * 100) + '%)';
        currentNumber.textContent = String(currentIndex + 1).padStart(2, '0');
        slides.forEach(function (slide, i) {
            const isActive = i === currentIndex;
            slide.classList.toggle('is-active', isActive);
            slide.inert = !isActive;
            slide.setAttribute('aria-hidden', isActive ? 'false' : 'true');
        });
        dots.forEach(function (dot, i) {
            const isActive = i === currentIndex;
            dot.classList.toggle('active', isActive);
            dot.setAttribute('aria-current', isActive ? 'true' : 'false');
        });
    }

    function nextSlide() { showSlide(currentIndex + 1); }
    function previousSlide() { showSlide(currentIndex - 1); }
    function stopAutoSlide() {
        clearInterval(sliderInterval);
        sliderInterval = null;
    }
    function startAutoSlide() {
        stopAutoSlide();
        if (reduceMotion || document.hidden) return;
        sliderInterval = setInterval(nextSlide, AUTO_SLIDE_DELAY);
    }

    nextButton.addEventListener('click', function () { nextSlide(); startAutoSlide(); });
    prevButton.addEventListener('click', function () { previousSlide(); startAutoSlide(); });
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
    slider.addEventListener('focusin', stopAutoSlide);
    slider.addEventListener('focusout', startAutoSlide);

    document.addEventListener('visibilitychange', function () {
        if (document.hidden) stopAutoSlide();
        else startAutoSlide();
    });

    let touchStartX = 0;
    let touchStartY = 0;
    slider.addEventListener('touchstart', function (event) {
        touchStartX = event.changedTouches[0].clientX;
        touchStartY = event.changedTouches[0].clientY;
    }, { passive: true });
    slider.addEventListener('touchend', function (event) {
        const deltaX = event.changedTouches[0].clientX - touchStartX;
        const deltaY = event.changedTouches[0].clientY - touchStartY;
        if (Math.abs(deltaX) > 50 && Math.abs(deltaX) > Math.abs(deltaY) * 1.5) {
            if (deltaX < 0) nextSlide();
            else previousSlide();
            startAutoSlide();
        }
    }, { passive: true });

    showSlide(0);
    startAutoSlide();
});
</script>
@endsection