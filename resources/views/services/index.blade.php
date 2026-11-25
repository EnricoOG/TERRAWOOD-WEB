@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Layanan Kami', 'Our Services', '我们的服务') . ' | TERRAWOOD')

@section('content')

<style>
.services-page {
    background: #F7F5EF;
    min-height: 100vh;
    color: #293747;
}

.services-hero {
    background: linear-gradient(120deg, #061D33, #0B3558);
    padding: 110px 7% 75px;
    color: white;
    position: relative;
    overflow: hidden;
}

.services-hero::after {
    content: "";
    position: absolute;
    width: 350px;
    height: 350px;
    border: 45px solid rgba(245,166,35,.12);
    border-radius: 50%;
    right: -80px;
    top: -120px;
}

.services-hero-content {
    max-width: 850px;
    position: relative;
    z-index: 1;
}

.services-label {
    color: #FFA43A;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 4px;
    text-transform: uppercase;
    margin-bottom: 15px;
}

.services-hero h1 {
    font-size: clamp(35px, 5vw, 58px);
    line-height: 1.15;
    font-family: var(--font-heading);
    margin-bottom: 20px;
}

.services-hero h1 span {
    color: #FFA43A;
}

.services-hero p {
    max-width: 620px;
    color: rgba(255,255,255,.78);
    font-size: 14px;
    line-height: 1.9;
}

.services-container {
    width: 86%;
    max-width: 1350px;
    margin: auto;
    padding: 75px 0;
}

.services-heading {
    margin-bottom: 35px;
}

.services-heading span {
    color: #C47A1B;
    font-size: 11px;
    letter-spacing: 3px;
    font-weight: 800;
    text-transform: uppercase;
}

.services-heading h2 {
    color: #082744;
    font-size: clamp(25px, 3vw, 36px);
    font-family: var(--font-heading);
    margin: 10px 0;
}

.services-heading p {
    color: #687482;
    font-size: 13px;
    line-height: 1.8;
}

.services-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 25px;
}

.service-card {
    background: white;
    border-radius: 13px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(8,39,68,.07);
    transition: .3s;
}

.service-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 14px 30px rgba(8,39,68,.13);
}

.service-image {
    height: 230px;
    background: #E9E4DA;
    overflow: hidden;
}

.service-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .4s;
}

.service-card:hover .service-image img {
    transform: scale(1.06);
}

.service-content {
    padding: 24px;
}

.service-number {
    color: #C47A1B;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 2px;
}

.service-content h3 {
    color: #082744;
    font-size: 18px;
    margin: 10px 0;
}

.service-content p {
    color: #687482;
    font-size: 12px;
    line-height: 1.9;
    white-space: pre-line;
}

.service-decoration {
    margin-top: 18px;
    width: 45px;
    height: 3px;
    background: #F5A623;
    border-radius: 5px;
}

.services-empty {
    grid-column: 1 / -1;
    background: white;
    border: 1px dashed #D9CBB8;
    border-radius: 12px;
    padding: 55px 20px;
    text-align: center;
}

.services-empty h3 {
    color: #082744;
    margin-bottom: 10px;
}

.services-empty p {
    color: #687482;
    font-size: 13px;
}

.services-pagination {
    margin-top: 35px;
}

.services-cta {
    background: #FFF9F0;
    padding: 55px 7%;
    text-align: center;
}

.services-cta h2 {
    color: #082744;
    font-size: 28px;
    font-family: var(--font-heading);
    margin-bottom: 12px;
}

.services-cta p {
    color: #687482;
    font-size: 13px;
    margin-bottom: 22px;
}

.services-cta a {
    display: inline-block;
    padding: 13px 25px;
    border-radius: 30px;
    background: #F5A623;
    color: #082744;
    font-size: 12px;
    font-weight: 800;
    transition: .3s;
}

.services-cta a:hover {
    background: #082744;
    color: white;
}

@media(max-width: 900px) {
    .services-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media(max-width: 600px) {
    .services-hero {
        padding: 80px 7% 60px;
    }

    .services-container {
        width: 88%;
        padding: 55px 0;
    }

    .services-grid {
        grid-template-columns: 1fr;
    }

    .service-image {
        height: 220px;
    }
}
</style>

<div class="services-page">

    <section class="services-hero">
        <div class="services-hero-content">
            <div class="services-label">{{ t3('Layanan Kami', 'Our Services', '我们的服务') }}</div>

            <h1>
                {{ t3('Solusi Furnitur dan Dekorasi', 'Furniture and Decor Solutions', '家具与装饰解决方案') }}
                <span>{{ t3('untuk Setiap Ruang.', 'for Every Space.', '适用于每个空间。') }}</span>
            </h1>

            <p>
                {{ t3(
                    'TERRAWOOD menghadirkan layanan furnitur dan dekorasi dengan mengutamakan kualitas, kreativitas, serta kenyamanan untuk menciptakan ruang yang lebih indah dan fungsional.',
                    'TERRAWOOD delivers furniture and decor services that put quality, creativity and comfort first, creating spaces that are more beautiful and functional.',
                    'TERRAWOOD 提供家具与装饰服务，以品质、创意与舒适为先，打造更美观、更实用的空间。'
                ) }}
            </p>
        </div>
    </section>

    <section class="services-container">

        <div class="services-heading">
            <span>{{ t3('Yang Kami Tawarkan', 'What We Offer', '我们的服务内容') }}</span>
            <h2>{{ t3('Layanan Kami', 'Our Services', '我们的服务') }}</h2>
            <p>
                {{ t3(
                    'Jelajahi berbagai layanan yang kami hadirkan untuk memenuhi kebutuhan furnitur dan dekorasi Anda.',
                    'Explore the services we offer to meet your furniture and decor needs.',
                    '了解我们提供的各项服务，满足您的家具与装饰需求。'
                ) }}
            </p>
        </div>

        <div class="services-grid">

            @forelse($services as $service)

                <article class="service-card">

                    <div class="service-image">
                        @if($service->image)
                            <img
                                src="{{ asset('storage/' . $service->image) }}"
                                alt="{{ $service->localized('name') }}"
                            >
                        @else
                            <img
                                src="https://placehold.co/700x500/F7F5EF/082744?text=TERRAWOOD+Service"
                                alt="{{ t3('Layanan TERRAWOOD', 'TERRAWOOD Service', 'TERRAWOOD 服务') }}"
                            >
                        @endif
                    </div>

                    <div class="service-content">

                        <span class="service-number">
                            {{ t3('LAYANAN TERRAWOOD', 'TERRAWOOD SERVICE', 'TERRAWOOD 服务') }}
                        </span>

                        <h3>{{ $service->localized('name') }}</h3>

                        <p>{{ $service->localized('description') }}</p>

                        <div class="service-decoration"></div>

                    </div>

                </article>

            @empty

                <div class="services-empty">
                    <h3>{{ t3('Layanan Segera Hadir', 'Services Coming Soon', '服务即将推出') }}</h3>
                    <p>
                        {{ t3(
                            'Kami sedang menyiapkan berbagai layanan terbaik untuk memenuhi kebutuhan Anda.',
                            'We are preparing our best services to meet your needs.',
                            '我们正在准备最优质的服务，以满足您的需求。'
                        ) }}
                    </p>
                </div>

            @endforelse

        </div>

        <div class="services-pagination">
            {{ $services->links() }}
        </div>

    </section>

    <section class="services-cta">
        <h2>{{ t3('Wujudkan Ruang Impian Anda', 'Create Your Dream Space', '打造您的理想空间') }}</h2>

        <p>
            {{ t3(
                'Temukan furnitur yang sesuai dengan kebutuhan dan karakter ruang Anda bersama TERRAWOOD.',
                'Find furniture that suits your needs and the character of your space with TERRAWOOD.',
                '与 TERRAWOOD 一起，找到契合您需求与空间风格的家具。'
            ) }}
        </p>

        <a href="{{ route('catalog.index') }}">
            {{ t3('Jelajahi Katalog Produk', 'Explore the Product Catalog', '浏览产品目录') }} →
        </a>
    </section>

</div>

@endsection
