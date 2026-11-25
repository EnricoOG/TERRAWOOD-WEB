@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Portofolio', 'Portfolio', '作品集') . ' | TERRAWOOD')

@section('content')

<style>
.portfolio-page {
    min-height: 100vh;
    background: #F7F5EF;
    color: #293747;
    font-family: 'Inter', sans-serif;
}

.portfolio-hero {
    background: #082744;
    padding: 100px 6% 85px;
    color: white;
    text-align: center;
}

.portfolio-hero span {
    color: #F5A623;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 3px;
    text-transform: uppercase;
}

.portfolio-hero h1 {
    font-family: 'Playfair Display', serif;
    font-size: clamp(36px, 5vw, 58px);
    margin: 18px 0;
}

.portfolio-hero p {
    max-width: 650px;
    margin: auto;
    color: #D5DEE6;
    line-height: 1.8;
    font-size: 15px;
}

.portfolio-container {
    max-width: 1250px;
    width: 88%;
    margin: auto;
    padding: 75px 0;
}

.portfolio-heading {
    margin-bottom: 35px;
}

.portfolio-heading span {
    color: #C47A1B;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: 2px;
}

.portfolio-heading h2 {
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    margin: 10px 0;
}

.portfolio-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 28px;
}

.portfolio-card {
    background: white;
    border-radius: 13px;
    overflow: hidden;
    box-shadow: 0 8px 28px rgba(8, 39, 68, .07);
    transition: .3s ease;
}

.portfolio-card:hover {
    transform: translateY(-7px);
    box-shadow: 0 15px 35px rgba(8, 39, 68, .13);
}

.portfolio-image {
    height: 245px;
    background: #E8E4DA;
    overflow: hidden;
}

.portfolio-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: .5s ease;
}

.portfolio-card:hover .portfolio-image img {
    transform: scale(1.06);
}

.portfolio-content {
    padding: 23px;
}

.portfolio-category {
    color: #C47A1B;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.portfolio-content h3 {
    font-size: 20px;
    margin: 10px 0;
    color: #082744;
}

.portfolio-client {
    color: #7A8490;
    font-size: 13px;
    margin-bottom: 13px;
}

.portfolio-description {
    color: #687481;
    font-size: 13px;
    line-height: 1.8;
}

.portfolio-date {
    border-top: 1px solid #EEEAE2;
    margin-top: 18px;
    padding-top: 15px;
    color: #87909A;
    font-size: 12px;
}

.portfolio-featured {
    display: inline-block;
    background: #FFF2D8;
    color: #A66A12;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    margin-top: 12px;
}

.portfolio-empty {
    text-align: center;
    background: white;
    border-radius: 12px;
    padding: 55px 20px;
    color: #7A8490;
    grid-column: 1 / -1;
}

.portfolio-cta {
    background: #082744;
    color: white;
    padding: 55px 25px;
    text-align: center;
    border-radius: 15px;
    margin-top: 75px;
}

.portfolio-cta h2 {
    font-family: 'Playfair Display', serif;
    font-size: 30px;
    margin-bottom: 12px;
}

.portfolio-cta p {
    color: #D5DEE6;
    margin-bottom: 25px;
}

.portfolio-cta a {
    display: inline-block;
    background: #F5A623;
    color: #082744;
    padding: 13px 27px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 700;
    font-size: 13px;
}

@media (max-width: 900px) {
    .portfolio-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .portfolio-hero {
        padding: 75px 6%;
    }

    .portfolio-grid {
        grid-template-columns: 1fr;
    }

    .portfolio-container {
        width: 90%;
        padding: 50px 0;
    }
}
</style>

<div class="portfolio-page">

    <section class="portfolio-hero">
        <span>{{ t3('Portofolio Kami', 'Our Portfolio', '我们的作品集') }}</span>
        <h1>{{ t3('Setiap Ruang Punya Cerita.', 'Every Space Has a Story.', '每个空间都有故事。') }}</h1>
        <p>
            {{ t3(
                'Jelajahi berbagai proyek furnitur dan dekorasi TERRAWOOD yang dirancang untuk menghadirkan kenyamanan, keindahan, dan karakter pada setiap ruang.',
                'Explore TERRAWOOD furniture and decor projects designed to bring comfort, beauty and character to every space.',
                '浏览 TERRAWOOD 的家具与装饰项目，为每个空间带来舒适、美感与个性。'
            ) }}
        </p>
    </section>

    <section class="portfolio-container">

        <div class="portfolio-heading">
            <span>{{ t3('PROYEK KAMI', 'OUR PROJECTS', '我们的项目') }}</span>
            <h2>{{ t3('Hasil Karya TERRAWOOD', 'TERRAWOOD Projects', 'TERRAWOOD 项目成果') }}</h2>
            <p>{{ t3('Beberapa proyek yang telah kami kerjakan.', 'Some of the projects we have completed.', '我们已完成的部分项目。') }}</p>
        </div>

        <div class="portfolio-grid">

            @forelse ($portfolios as $portfolio)

                <article class="portfolio-card">

                    <div class="portfolio-image">
                        @if ($portfolio->image)
                            <img
                                src="{{ asset('storage/' . $portfolio->image) }}"
                                alt="{{ $portfolio->localized('title') }}"
                            >
                        @else
                            <img
                                src="https://placehold.co/800x550/F0EDE5/082744?text=TERRAWOOD"
                                alt="{{ t3('Portofolio TERRAWOOD', 'TERRAWOOD Portfolio', 'TERRAWOOD 作品集') }}"
                            >
                        @endif
                    </div>

                    <div class="portfolio-content">

                        <span class="portfolio-category">
                            {{ $portfolio->localized('category') ?: t3('Furnitur & Dekorasi', 'Furniture & Decoration', '家具与装饰') }}
                        </span>

                        <h3>{{ $portfolio->localized('title') }}</h3>

                        @if ($portfolio->localized('client_name'))
                            <div class="portfolio-client">
                                {{ t3('Klien', 'Client', '客户') }}: {{ $portfolio->localized('client_name') }}
                            </div>
                        @endif

                        <p class="portfolio-description">
                            {{ \Illuminate\Support\Str::limit($portfolio->localized('description'), 120) }}
                        </p>

                        @if ($portfolio->project_date)
                            <div class="portfolio-date">
                                {{ t3('Tanggal Proyek', 'Project Date', '项目日期') }}:
                                {{ $portfolio->project_date->locale(session('site_locale', 'en') === 'zh' ? 'zh_CN' : session('site_locale', 'en'))->translatedFormat('d F Y') }}
                            </div>
                        @endif

                        @if ($portfolio->is_featured)
                            <span class="portfolio-featured">
                                {{ t3('PROYEK UNGGULAN', 'FEATURED PROJECT', '精选项目') }}
                            </span>
                        @endif

                    </div>
                </article>

            @empty

                <div class="portfolio-empty">
                    <h3>{{ t3('Belum Ada Portofolio', 'No Portfolio Yet', '暂无作品集') }}</h3>
                    <p>
                        {{ t3(
                            'Proyek TERRAWOOD akan ditampilkan di halaman ini.',
                            'TERRAWOOD projects will be displayed on this page.',
                            'TERRAWOOD 的项目将在此页面展示。'
                        ) }}
                    </p>
                </div>

            @endforelse

        </div>

        <div style="margin-top: 35px;">
            {{ $portfolios->links() }}
        </div>

        <div class="portfolio-cta">
            <h2>{{ t3('Mari Wujudkan Sesuatu yang Indah.', "Let's Create Something Beautiful.", '让我们一起创造美好。') }}</h2>
            <p>
                {{ t3(
                    'Wujudkan ruang impian bersama solusi furnitur dan dekorasi dari TERRAWOOD.',
                    'Create your dream space with TERRAWOOD furniture and decor solutions.',
                    '借助 TERRAWOOD 的家具与装饰方案，打造您的理想空间。'
                ) }}
            </p>
            <a href="{{ route('catalog.index') }}">
                {{ t3('Jelajahi Koleksi Kami', 'Explore Our Collection', '探索我们的系列') }}
            </a>
        </div>

    </section>

</div>

@endsection
