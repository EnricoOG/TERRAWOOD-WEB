<!DOCTYPE html>
<html lang="{{ session('site_locale', 'en') === 'zh' ? 'zh-CN' : session('site_locale', 'en') }}">
<head>
    @include('partials.i18n')
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'TERRAWOOD | Crafting Comfort with Nature')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/terrawood-mark.png') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500;1,600&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy: #082744;
            --navy-dark: #061D33;
            --gold: #F5A623;
            --gold-light: #FFA43A;
            --ivory: #F7F5EF;
            --charcoal: #293747;

            --font-heading: 'Manrope', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-editorial: 'Playfair Display', serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-body);
            color: var(--charcoal);
            background: var(--ivory);
        }

        h1, h2, h3, h4 {
            font-family: var(--font-heading);
        }

        a {
            text-decoration: none;
        }

        button {
            font-family: var(--font-body);
        }

        /* =====================================
           BADGE NOTIFIKASI (dipakai di navbar & tombol cadangan)
        ===================================== */

        .js-notification-badge[hidden] {
            display: none !important;
        }

        /* =====================================
           TOMBOL PROFIL & NOTIFIKASI CADANGAN
           (hanya tampil di halaman yang BELUM memakai
            partial navbar; otomatis disembunyikan jika sudah)
        ===================================== */

        .global-notification {
            position: fixed;
            top: 22px;
            right: 25px;
            z-index: 99999;

            width: 46px;
            height: 46px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            background: var(--navy);
            color: var(--gold);

            border: 2px solid rgba(255,255,255,.35);
            border-radius: 50%;

            box-shadow: 0 5px 18px rgba(0,0,0,.15);

            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 800;
            letter-spacing: .5px;
            line-height: 1;

            -webkit-tap-highlight-color: transparent;

            transition: background .3s ease,
                        color .3s ease,
                        transform .3s ease,
                        box-shadow .3s ease;
        }

        @media (hover: hover) {
            .global-notification:hover {
                background: var(--navy-dark);
                color: var(--gold);
                transform: translateY(-2px) scale(1.06);
                box-shadow: 0 8px 22px rgba(8,39,68,.25);
            }
        }

        .global-notification:active {
            transform: scale(.94);
        }

        .global-notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;

            min-width: 19px;
            height: 19px;
            padding: 0 4px;

            display: flex;
            align-items: center;
            justify-content: center;

            background: #E53935;
            color: white;

            border: 2px solid var(--ivory);
            border-radius: 20px;

            font-family: var(--font-body);
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }

        /* =====================================
           NOTIFICATION TOAST
        ===================================== */

        .notification-toast {
            position: fixed;
            top: 90px;
            right: 25px;
            z-index: 100000;

            width: min(360px, calc(100% - 40px));
            padding: 20px;

            background: var(--navy);
            color: white;

            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(0,0,0,.2);

            animation: notificationSlide .35s ease;
        }

        .notification-toast-title {
            color: var(--gold);
            font-family: var(--font-heading);
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 8px;
            padding-right: 22px;
        }

        .notification-toast-message {
            color: white;
            font-size: 12px;
            line-height: 1.7;
            margin-bottom: 12px;
        }

        .notification-toast-link {
            color: var(--gold);
            font-size: 12px;
            font-weight: 700;
        }

        .notification-toast-link:hover {
            color: white;
        }

        .notification-toast-close {
            position: absolute;
            top: 10px;
            right: 13px;

            border: none;
            background: transparent;
            color: white;

            font-size: 19px;
            cursor: pointer;
        }

        @keyframes notificationSlide {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .notification-toast {
                animation: none;
            }
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        /* Di HP, tombol cadangan dipindah ke kanan bawah agar tidak menutupi menu */
        @media(max-width: 900px) {
            .global-notification {
                top: auto;
                right: 16px;
                bottom: calc(86px + env(safe-area-inset-bottom, 0px));
                width: 44px;
                height: 44px;
                font-size: 13px;
            }

            .notification-toast {
                top: 82px;
                left: 15px;
                right: 15px;
                width: auto;
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    {{-- =====================================
         TOMBOL PROFIL CADANGAN
         Hanya dirender jika halaman belum memuat partial navbar
         (partial navbar memiliki avatar & notifikasi sendiri).
    ====================================== --}}

    @auth
        @if(auth()->user()->role === 'user' && empty($hasSiteNavbar))

            @php
                $globalUnreadCount = auth()->user()
                    ->unreadNotifications()
                    ->count();

                $globalInitials = '';

                $globalWords = preg_split(
                    '/\s+/',
                    trim((string) auth()->user()->name),
                    -1,
                    PREG_SPLIT_NO_EMPTY
                ) ?: [];

                foreach (array_slice($globalWords, 0, 2) as $globalWord) {
                    $globalInitials .= mb_strtoupper(mb_substr($globalWord, 0, 1));
                }

                if ($globalInitials === '') {
                    $globalInitials = 'U';
                }
            @endphp

            <a
                href="{{ route('account.index') }}#notifications"
                class="global-notification"
                id="globalNotificationLink"
                data-status-url="{{ route('account.notifications.status') }}"
                data-order-base="{{ url('/account/orders') }}"
                title="{{ t3('Profil dan Notifikasi', 'Profile and Notifications', '个人资料与通知') }}"
                aria-label="{{ t3('Profil dan Notifikasi', 'Profile and Notifications', '个人资料与通知') }}"
            >

                {{ $globalInitials }}

                <!-- Notification Badge -->
                <span
                    class="global-notification-badge js-notification-badge"
                    id="globalNotificationBadge"
                    @if($globalUnreadCount <= 0) hidden @endif
                >{{ $globalUnreadCount > 9 ? '9+' : $globalUnreadCount }}</span>

            </a>

        @endif
    @endauth


    {{-- =====================================
         MAIN CONTENT
    ====================================== --}}

    @yield('content')


    {{-- =====================================
         AUTOMATIC NOTIFICATION SCRIPT
    ====================================== --}}

    @auth
        @if(auth()->user()->role === 'user')

            <script>
                document.addEventListener('DOMContentLoaded', function () {

                    /*
                    Sumber data notifikasi:
                    - navbar baru  -> elemen #navProfile
                    - tombol cadangan -> elemen #globalNotificationLink
                    */

                    const profileLink =
                        document.getElementById('globalNotificationLink') ||
                        document.getElementById('navProfile');

                    if (!profileLink || !profileLink.dataset.statusUrl) return;

                    let latestNotificationId = null;
                    let firstCheck = true;

                    /*
                    =====================================
                    SHOW NOTIFICATION POPUP
                    =====================================
                    */

                    function showNotificationToast(notification) {

                        const toast = document.createElement('div');

                        toast.className = 'notification-toast';

                        const closeButton = document.createElement('button');

                        closeButton.className = 'notification-toast-close';
                        closeButton.type = 'button';
                        closeButton.setAttribute('aria-label', @json(t3('Tutup notifikasi', 'Close notification', '关闭通知')));
                        closeButton.textContent = '×';

                        closeButton.addEventListener('click', function () {
                            toast.remove();
                        });

                        const title = document.createElement('div');

                        title.className = 'notification-toast-title';
                        title.textContent = @json(t3('Pembaruan Pesanan TERRAWOOD', 'TERRAWOOD Order Update', 'TERRAWOOD 订单更新'));

                        const message = document.createElement('p');

                        message.className = 'notification-toast-message';
                        message.textContent = notification.message ||
                            @json(t3('Ada pembaruan pesanan Anda.', 'There is an update to your order.', '您的订单有更新。'));

                        toast.appendChild(closeButton);
                        toast.appendChild(title);
                        toast.appendChild(message);

                        if (notification.order_id && profileLink.dataset.orderBase) {

                            const link = document.createElement('a');

                            link.className = 'notification-toast-link';

                            link.href = profileLink.dataset.orderBase + '/' +
                                encodeURIComponent(notification.order_id);

                            link.textContent = @json(t3('Lihat Detail Pesanan', 'View Order Details', '查看订单详情')) + ' →';

                            toast.appendChild(link);
                        }

                        document.body.appendChild(toast);

                        setTimeout(function () {
                            toast.remove();
                        }, 7000);
                    }


                    /*
                    =====================================
                    UPDATE SEMUA BADGE (navbar & cadangan)
                    =====================================
                    */

                    function updateBadges(count) {

                        document.querySelectorAll('.js-notification-badge')
                            .forEach(function (badge) {

                                if (count > 0) {

                                    badge.textContent = count > 9 ? '9+' : count;
                                    badge.hidden = false;

                                } else {

                                    badge.hidden = true;

                                }

                            });
                    }


                    /*
                    =====================================
                    CHECK NOTIFICATIONS
                    =====================================
                    */

                    async function checkNotifications() {

                        /* Hemat permintaan saat tab tidak aktif */
                        if (document.hidden && !firstCheck) return;

                        try {

                            const response = await fetch(
                                profileLink.dataset.statusUrl,
                                {
                                    headers: {
                                        'Accept': 'application/json'
                                    },
                                    credentials: 'same-origin'
                                }
                            );

                            if (!response.ok) return;

                            const data = await response.json();

                            /*
                            UPDATE BADGE
                            */

                            updateBadges(Number(data.unread_count) || 0);

                            /*
                            FIRST CHECK
                            */

                            if (firstCheck) {

                                latestNotificationId =
                                    data.latest?.id ?? null;

                                firstCheck = false;

                                return;
                            }

                            /*
                            DETECT NEW NOTIFICATION
                            */

                            if (
                                data.latest &&
                                data.latest.id !== latestNotificationId
                            ) {

                                latestNotificationId = data.latest.id;

                                showNotificationToast(data.latest);
                            }

                        } catch (error) {

                            console.error(
                                'Gagal memeriksa notifikasi:',
                                error
                            );

                        }
                    }


                    /*
                    =====================================
                    RUN NOTIFICATION CHECK
                    =====================================
                    */

                    checkNotifications();

                    setInterval(checkNotifications, 10000);

                    /* Periksa segera saat tab kembali aktif */
                    document.addEventListener('visibilitychange', function () {

                        if (!document.hidden) {
                            checkNotifications();
                        }

                    });

                });
            </script>

        @endif
    @endauth


    {{-- =====================================
         ADDITIONAL PAGE SCRIPTS
    ====================================== --}}

    @stack('scripts')

<script>
(function () {
 const locale = @json(session('site_locale', 'en'));
 if (locale === 'id') return;
 const dict = {
 en: {
 'Beranda':'Home','Katalog Produk':'Product Catalog','Katalog':'Catalog','Layanan':'Services','Tentang Kami':'About Us','Artikel':'Articles','Portofolio':'Portfolio','Mitra':'Partners','Kontak Kami':'Contact Us','Navigasi':'Navigation','Layanan Kami':'Our Services','Lihat Semua Layanan':'View All Services','Hasil Proyek Kami':'Our Projects','Kerja Sama':'Partnership','Masuk':'Login','Keluar':'Logout','Daftar':'Register','Pesan Sekarang':'Order Now','Login untuk Memesan':'Login to Order','Login sebagai Customer':'Login as Customer','Koleksi unggulan TERRAWOOD':'Featured TERRAWOOD Collection','Belanja Berdasarkan Kategori':'Shop by Category','Produk Unggulan':'Featured Products','Produk Pilihan':'Selected Products','Lihat Semua Produk':'View All Products','Hubungi kami':'Contact Us','Tanya via WhatsApp':'Ask via WhatsApp','Email Us':'Email Us','Cari produk':'Search products','Cari':'Search','Semua Kategori':'All Categories','Tentang TERRAWOOD':'About TERRAWOOD','Mengapa Memilih Kami':'Why Choose Us','Keunggulan Kami':'Our Advantages','Testimoni':'Testimonials','Artikel Terbaru':'Latest Articles','Inspirasi':'Inspiration','Lihat Detail':'View Details','Selengkapnya':'Read More','Baca Selengkapnya':'Read More','Kembali':'Back','Kembali ke Detail Produk':'Back to Product Details','Checkout Pesanan':'Order Checkout','Harga Satuan':'Unit Price','Jumlah Produk':'Quantity','Total Pesanan':'Order Total','Alamat Pengiriman':'Shipping Address','Catatan':'Notes','Periksa kembali data pesanan:':'Please review your order information:','Status Pesanan':'Order Status','Belum ada gambar.':'No image available.','Crafting Comfort with Nature.':'Crafting Comfort with Nature.','Produk':'Products','Kategori':'Categories','Harga':'Price','Diskon':'Discount','Harga Diskon':'Discount Price','Harga Normal':'Regular Price','Pesan':'Order','Pesan Produk':'Order Product','Mulai Belanja':'Start Shopping','Pesanan':'Orders','Akun Saya':'My Account','Lihat Detail Pesanan':'View Order Details','Pembaruan Pesanan TERRAWOOD':'TERRAWOOD Order Update','Ada pembaruan pesanan Anda.':'There is an update to your order.','Lihat Detail Pesanan →':'View Order Details →','Tutup notifikasi':'Close notification','Semua':'All','Terbaru':'Newest','Harga Terendah':'Lowest Price','Harga Tertinggi':'Highest Price','Produk tidak ditemukan':'No products found','Hapus Filter':'Clear Filters','Pilih Kategori':'Select Category','Informasi':'Information','Klien & Mitra':'Clients & Partners','Testimoni':'Testimonials','Profil Saya':'My Profile','Notifikasi':'Notifications','Dashboard Admin':'Admin Dashboard','Kontak':'Contact','Unggulan':'Featured','Lihat koleksi':'View Collection','Produk ditemukan':'Products found','Hapus semua':'Clear All','Produk Belum Ditemukan':'No Products Found','Gambar produk belum tersedia':'Product image unavailable','Material berkualitas & ramah lingkungan':'Quality and eco-friendly materials','Desain modern dan elegan':'Modern and elegant design','Layanan profesional & responsif':'Professional and responsive service','Pengiriman aman ke berbagai negara':'Safe international shipping','Deskripsi Produk':'Product Description','Produk Lainnya':'Related Products','Bagikan':'Share','Harga':'Price','Semua Artikel':'All Articles','Baca Artikel':'Read Article','Informasi dan inspirasi untuk ruang yang lebih nyaman.':'Information and inspiration for a more comfortable space.','Artikel terbaru TERRAWOOD akan ditampilkan di halaman ini.':'Latest TERRAWOOD articles will appear here.','Solusi Furnitur dan Dekorasi':'Furniture and Decor Solutions','untuk Setiap Ruang.':'for Every Space.','Layanan Segera Hadir':'Services Coming Soon','Wujudkan Ruang Impian Anda':'Create Your Dream Space','Temukan furnitur yang sesuai dengan kebutuhan dan karakter ruang Anda bersama TERRAWOOD.':'Find furniture that suits your needs and your space with TERRAWOOD.','Hasil Karya TERRAWOOD':'TERRAWOOD Projects','Beberapa proyek yang telah kami kerjakan.':'Some of the projects we have completed.','Belum Ada Portofolio':'No Portfolio Yet','Portofolio proyek TERRAWOOD akan ditampilkan di halaman ini.':'TERRAWOOD project portfolio will appear here.','Wujudkan ruang impian bersama solusi furnitur dan dekorasi dari TERRAWOOD.':'Create your dream space with TERRAWOOD furniture and decor solutions.','Semua Artikel':'All Articles','Konten artikel belum tersedia.':'Article content is not available yet.','Bagikan artikel ini':'Share this article','Salin Tautan':'Copy Link','Tautan berhasil disalin':'Link copied successfully','Artikel Terkait':'Related Articles','Lihat semua artikel':'View all articles','Temukan Inspirasi untuk Ruang Anda':'Find Inspiration for Your Space','Jelajahi Katalog':'Explore Catalog','Jelajahi Koleksi':'Explore Collection','Temukan Produk':'Discover Products','Tentang TERRAWOOD':'About TERRAWOOD','Material Berkualitas':'Quality Materials','dan Ramah Lingkungan':'and Eco-Friendly','Desain Modern':'Modern Design','dan Elegan':'and Elegant','Layanan Profesional':'Professional Service','dan Responsif':'and Responsive','Koleksi Kami':'Our Collection','Pilih jenis furnitur dan dekorasi yang Anda cari.':'Choose the furniture and decor you are looking for.','Koleksi Terbaik untuk Hunian Anda':'Our Best Collection for Your Home','Temukan berbagai pilihan furnitur dengan desain modern':'Discover furniture with modern design','dan kualitas premium.':'and premium quality.','Produk Unggulan Segera Hadir':'Featured Products Coming Soon','Kami sedang menyiapkan koleksi terbaik untuk Anda.':'We are preparing our best collection for you.','Filosofi Kami':'Our Philosophy','Setiap serat kayu punya':'Every grain of wood has a','cerita.':'story.','Kami menjaganya tetap utuh di setiap sentuhan.':'We preserve its character in every detail.','Material Alami':'Natural Materials','Kayu pilihan dengan karakter yang tidak pernah sama.':'Selected wood with unique character.','Dikerjakan Teliti':'Carefully Crafted','Setiap detail diperhatikan hingga tahap akhir.':'Every detail is considered through the final stage.','Tahan Lama':'Built to Last','Dirancang untuk menemani hunian Anda bertahun-tahun.':'Designed to accompany your home for years.','Solusi untuk Setiap Ruang':'Solutions for Every Space','Proyek Pilihan Kami':'Our Selected Projects','Cara Pemesanan':'How to Order','Pesan Furnitur dalam 4 Langkah':'Order Furniture in 4 Steps','Proses yang sederhana dari memilih hingga produk sampai di tempat Anda.':'A simple process from selection to delivery.','Pilih Produk':'Choose a Product','Jelajahi katalog dan pilih furnitur yang sesuai dengan kebutuhan ruang Anda.':'Browse the catalog and choose furniture that suits your space.','Konsultasi':'Consultation','Hubungi kami via WhatsApp untuk membahas ukuran, material, dan finishing.':'Contact us via WhatsApp to discuss dimensions, materials, and finishes.','Konfirmasi & Produksi':'Confirmation & Production','Setelah kesepakatan, pesanan diproses dan dikerjakan dengan teliti.':'Once confirmed, your order is carefully produced.','Pengiriman':'Delivery','Produk dikemas dengan aman dan dikirim sampai ke lokasi Anda.':'Products are safely packed and delivered to your location.','Mulai Konsultasi':'Start Consultation','Tahun Pengalaman':'Years of Experience','Pelanggan Puas':'Satisfied Customers','Proyek Selesai':'Completed Projects','Klien & Mitra Kami':'Our Clients & Partners','Membangun hubungan dan kerja sama untuk hasil terbaik.':'Building relationships and partnerships for the best results.','Informasi mitra akan segera tersedia.':'Partner information will be available soon.','Testimoni Pelanggan':'Customer Testimonials','Apa Kata Mereka?':'What They Say','Kepuasan pelanggan adalah prioritas utama kami.':'Customer satisfaction is our top priority.','Pelanggan TERRAWOOD':'TERRAWOOD Customer','Testimoni pelanggan akan segera ditampilkan.':'Customer testimonials will be shown soon.','Beranda':'Home','Jelajahi Koleksi':'Explore the Collection','Temukan Produk':'Discover Products','Produk Unggulan Segera Hadir':'Featured Products Coming Soon','Kami sedang menyiapkan koleksi terbaik untuk Anda.':'We are preparing our finest collection for you.','Koleksi Kami':'Our Collection','Belanja Berdasarkan Kategori':'Shop by Category','Pilih jenis furnitur dan dekorasi yang Anda cari.':'Choose the type of furniture and décor you are looking for.','Koleksi Terbaik untuk Hunian Anda':'Our Finest Collection for Your Home','Temukan berbagai pilihan furnitur dengan desain modern':'Discover a range of furniture with modern designs','dan kualitas premium.':'and premium quality.','Filosofi Kami':'Our Philosophy','Setiap serat kayu punya':'Every grain of wood has a','cerita.':'story.','Kami menjaganya tetap utuh di setiap sentuhan.':'We preserve its character in every detail.','Material Alami':'Natural Materials','Kayu pilihan dengan karakter yang tidak pernah sama.':'Selected wood with a character that is never the same.','Dikerjakan Teliti':'Carefully Crafted','Setiap detail diperhatikan hingga tahap akhir.':'Every detail is considered through the final stage.','Tahan Lama':'Built to Last','Dirancang untuk menemani hunian Anda bertahun-tahun.':'Designed to accompany your home for years.','Solusi untuk Setiap Ruang':'Solutions for Every Space','Proyek Pilihan Kami':'Our Featured Projects','Cara Pemesanan':'How to Order','Pesan Furnitur dalam 4 Langkah':'Order Furniture in 4 Steps','Proses yang sederhana dari memilih hingga produk sampai di tempat Anda.':'A simple process from choosing a product to its delivery.','Pilih Produk':'Choose a Product','Jelajahi katalog dan pilih furnitur yang sesuai dengan kebutuhan ruang Anda.':'Browse the catalog and choose furniture that suits your space.','Konsultasi':'Consultation','Hubungi kami via WhatsApp untuk membahas ukuran, material, dan finishing.':'Contact us via WhatsApp to discuss dimensions, materials, and finishes.','Konfirmasi & Produksi':'Confirmation & Production','Setelah kesepakatan, pesanan diproses dan dikerjakan dengan teliti.':'Once confirmed, your order is carefully produced.','Pengiriman':'Delivery','Produk dikemas dengan aman dan dikirim sampai ke lokasi Anda.':'Products are safely packed and delivered to your location.','Mulai Konsultasi':'Start a Consultation','Tahun Pengalaman':'Years of Experience','Pelanggan Puas':'Satisfied Customers','Proyek Selesai':'Completed Projects','Klien & Mitra Kami':'Our Clients & Partners','Membangun hubungan dan kerja sama untuk hasil terbaik.':'Building relationships and partnerships for the best results.','Informasi mitra akan segera tersedia.':'Partner information will be available soon.','Testimoni Pelanggan':'Customer Testimonials','Apa Kata Mereka?':'What They Say','Kepuasan pelanggan adalah prioritas utama kami.':'Customer satisfaction is our top priority.','Pelanggan TERRAWOOD':'TERRAWOOD Customer','Testimoni pelanggan akan segera ditampilkan.':'Customer testimonials will be displayed soon.','Wujudkan ruang impian Anda':'Create Your Dream Space','Wujudkan Ruang Impian Anda':'Create Your Dream Space','Tentang TERRAWOOD':'About TERRAWOOD','Layanan Kami':'Our Services','Artikel Terbaru':'Latest Articles','Lihat Semua Artikel':'View All Articles','Lihat Semua Produk':'View All Products','Lihat Semua Layanan':'View All Services','Hasil Karya TERRAWOOD':'TERRAWOOD Projects','Beberapa proyek yang telah kami kerjakan.':'Some of the projects we have completed.','Belum Ada Portofolio':'No Portfolio Yet','Portofolio proyek TERRAWOOD akan ditampilkan di halaman ini.':'TERRAWOOD project portfolio will appear here.','Semua Artikel':'All Articles','Konten artikel belum tersedia.':'Article content is not available yet.','Bagikan artikel ini':'Share this article','Salin Tautan':'Copy Link','Tautan berhasil disalin':'Link copied successfully','Artikel Terkait':'Related Articles','Lihat semua artikel':'View all articles','Temukan Inspirasi untuk Ruang Anda':'Find Inspiration for Your Space','Jelajahi Katalog':'Explore the Catalog','Hubungi Kami':'Contact Us','Lihat Detail':'View Details','Baca Selengkapnya':'Read More','Selengkapnya':'Read More','Masuk':'Login','Daftar':'Register','Keluar':'Log Out','Pesan Sekarang':'Order Now','Cari produk':'Search products','Semua Kategori':'All Categories','Kategori':'Categories','Harga':'Price','Deskripsi Produk':'Product Description','Produk Lainnya':'Related Products','Bagikan':'Share','Kembali':'Back','Informasi':'Information','Kontak':'Contact','Profil Saya':'My Profile','Notifikasi':'Notifications','Dashboard Admin':'Admin Dashboard'},
 zh: {
 'Beranda':'首页','Katalog Produk':'产品目录','Katalog':'目录','Layanan':'服务','Tentang Kami':'关于我们','Artikel':'文章','Portofolio':'作品集','Mitra':'合作伙伴','Kontak Kami':'联系我们','Navigasi':'导航','Layanan Kami':'我们的服务','Lihat Semua Layanan':'查看所有服务','Hasil Proyek Kami':'项目成果','Kerja Sama':'合作','Masuk':'登录','Keluar':'退出','Daftar':'注册','Pesan Sekarang':'立即订购','Login untuk Memesan':'登录后订购','Login sebagai Customer':'客户登录','Koleksi unggulan TERRAWOOD':'TERRAWOOD精选系列','Belanja Berdasarkan Kategori':'按类别选购','Produk Unggulan':'精选产品','Produk Pilihan':'精选商品','Lihat Semua Produk':'查看所有产品','Hubungi kami':'联系我们','Tanya via WhatsApp':'通过 WhatsApp 咨询','Email Us':'发送邮件','Cari produk':'搜索产品','Cari':'搜索','Semua Kategori':'所有类别','Tentang TERRAWOOD':'关于 TERRAWOOD','Mengapa Memilih Kami':'为什么选择我们','Keunggulan Kami':'我们的优势','Testimoni':'客户评价','Artikel Terbaru':'最新文章','Inspirasi':'灵感','Lihat Detail':'查看详情','Selengkapnya':'了解更多','Baca Selengkapnya':'阅读更多','Kembali':'返回','Kembali ke Detail Produk':'返回产品详情','Checkout Pesanan':'订单结账','Harga Satuan':'单价','Jumlah Produk':'数量','Total Pesanan':'订单总额','Alamat Pengiriman':'配送地址','Catatan':'备注','Periksa kembali data pesanan:':'请检查订单信息：','Status Pesanan':'订单状态','Belum ada gambar.':'暂无图片。','Crafting Comfort with Nature.':'以自然打造舒适。','Produk':'产品','Kategori':'类别','Harga':'价格','Diskon':'折扣','Harga Diskon':'优惠价','Harga Normal':'原价','Pesan':'订购','Pesan Produk':'订购产品','Mulai Belanja':'开始购物','Pesanan':'订单','Akun Saya':'我的账户','Lihat Detail Pesanan':'查看订单详情','Pembaruan Pesanan TERRAWOOD':'TERRAWOOD订单更新','Ada pembaruan pesanan Anda.':'您的订单有更新。','Lihat Detail Pesanan →':'查看订单详情 →','Tutup notifikasi':'关闭通知','Semua':'全部','Terbaru':'最新','Harga Terendah':'价格从低到高','Harga Tertinggi':'价格从高到低','Produk tidak ditemukan':'未找到产品','Hapus Filter':'清除筛选','Pilih Kategori':'选择类别','Informasi':'信息','Klien & Mitra':'客户与合作伙伴','Testimoni':'评价','Profil Saya':'我的资料','Notifikasi':'通知','Dashboard Admin':'管理员面板','Kontak':'联系','Unggulan':'精选','Lihat koleksi':'查看系列','Hapus semua':'清除全部','Produk Belum Ditemukan':'未找到产品','Gambar produk belum tersedia':'暂无产品图片','Material berkualitas & ramah lingkungan':'优质环保材料','Desain modern dan elegan':'现代优雅设计','Layanan profesional & responsif':'专业及时服务','Pengiriman aman ke berbagai negara':'安全国际配送','Deskripsi Produk':'产品描述','Produk Lainnya':'相关产品','Bagikan':'分享','Harga':'价格','Semua Artikel':'所有文章','Baca Artikel':'阅读文章','Informasi dan inspirasi untuk ruang yang lebih nyaman.':'舒适空间的信息与灵感。','Artikel terbaru TERRAWOOD akan ditampilkan di halaman ini.':'TERRAWOOD最新文章将在此展示。','Solusi Furnitur dan Dekorasi':'家具与装饰解决方案','untuk Setiap Ruang.':'适用于每个空间。','Layanan Segera Hadir':'服务即将推出','Wujudkan Ruang Impian Anda':'打造梦想空间','Temukan furnitur yang sesuai dengan kebutuhan dan karakter ruang Anda bersama TERRAWOOD.':'与TERRAWOOD一起找到符合您需求和空间风格的家具。','Hasil Karya TERRAWOOD':'TERRAWOOD项目成果','Beberapa proyek yang telah kami kerjakan.':'我们完成的部分项目。','Belum Ada Portofolio':'暂无作品集','Portofolio proyek TERRAWOOD akan ditampilkan di halaman ini.':'TERRAWOOD项目作品将在此展示。','Wujudkan ruang impian bersama solusi furnitur dan dekorasi dari TERRAWOOD.':'通过TERRAWOOD家具与装饰方案打造梦想空间。','Konten artikel belum tersedia.':'文章内容暂不可用。','Bagikan artikel ini':'分享文章','Salin Tautan':'复制链接','Tautan berhasil disalin':'链接已复制','Artikel Terkait':'相关文章','Lihat semua artikel':'查看所有文章','Temukan Inspirasi untuk Ruang Anda':'寻找空间灵感','Jelajahi Katalog':'浏览产品目录','Jelajahi Koleksi':'探索系列','Temukan Produk':'发现产品','Material Berkualitas':'优质材料','dan Ramah Lingkungan':'环保材质','Desain Modern':'现代设计','dan Elegan':'优雅设计','Layanan Profesional':'专业服务','dan Responsif':'及时响应','Koleksi Kami':'我们的系列','Pilih jenis furnitur dan dekorasi yang Anda cari.':'选择您需要的家具和装饰类型。','Koleksi Terbaik untuk Hunian Anda':'为您的家精选系列','Temukan berbagai pilihan furnitur dengan desain modern':'探索现代设计家具','dan kualitas premium.':'以及优质品质。','Produk Unggulan Segera Hadir':'精选产品即将推出','Kami sedang menyiapkan koleksi terbaik untuk Anda.':'我们正在为您准备精选系列。','Filosofi Kami':'我们的理念','Setiap serat kayu punya':'每一纹理木材都有一个','cerita.':'故事。','Kami menjaganya tetap utuh di setiap sentuhan.':'我们在每一个细节中保留其自然特色。','Material Alami':'天然材料','Kayu pilihan dengan karakter yang tidak pernah sama.':'精选木材，纹理各不相同。','Dikerjakan Teliti':'精心制作','Setiap detail diperhatikan hingga tahap akhir.':'每个细节都经过认真处理。','Tahan Lama':'经久耐用','Dirancang untuk menemani hunian Anda bertahun-tahun.':'设计陪伴您的家多年。','Solusi untuk Setiap Ruang':'适合每个空间的方案','Proyek Pilihan Kami':'精选项目','Cara Pemesanan':'订购流程','Pesan Furnitur dalam 4 Langkah':'四步订购家具','Proses yang sederhana dari memilih hingga produk sampai di tempat Anda.':'从选择到送达，流程简单方便。','Pilih Produk':'选择产品','Jelajahi katalog dan pilih furnitur yang sesuai dengan kebutuhan ruang Anda.':'浏览目录，选择适合您空间的家具。','Konsultasi':'咨询','Hubungi kami via WhatsApp untuk membahas ukuran, material, dan finishing.':'通过 WhatsApp 联系我们，讨论尺寸、材料和表面处理。','Konfirmasi & Produksi':'确认与生产','Setelah kesepakatan, pesanan diproses dan dikerjakan dengan teliti.':'确认后，我们将认真制作您的订单。','Pengiriman':'配送','Produk dikemas dengan aman dan dikirim sampai ke lokasi Anda.':'产品将安全包装并配送至您的地点。','Mulai Konsultasi':'开始咨询','Tahun Pengalaman':'年经验','Pelanggan Puas':'满意客户','Proyek Selesai':'完成项目','Klien & Mitra Kami':'客户与合作伙伴','Membangun hubungan dan kerja sama untuk hasil terbaik.':'建立合作关系，共创最佳成果。','Informasi mitra akan segera tersedia.':'合作伙伴信息即将公布。','Testimoni Pelanggan':'客户评价','Apa Kata Mereka?':'他们怎么说？','Kepuasan pelanggan adalah prioritas utama kami.':'客户满意是我们的首要目标。','Pelanggan TERRAWOOD':'TERRAWOOD客户','Testimoni pelanggan akan segera ditampilkan.':'客户评价即将展示。','Beranda':'首页','Jelajahi Koleksi':'探索系列','Temukan Produk':'发现产品','Produk Unggulan Segera Hadir':'精选产品即将推出','Kami sedang menyiapkan koleksi terbaik untuk Anda.':'我们正在为您准备精选系列。','Koleksi Kami':'我们的系列','Belanja Berdasarkan Kategori':'按类别选购','Pilih jenis furnitur dan dekorasi yang Anda cari.':'选择您需要的家具和装饰类型。','Koleksi Terbaik untuk Hunian Anda':'为您的家精选系列','Temukan berbagai pilihan furnitur dengan desain modern':'探索多种现代设计家具','dan kualitas premium.':'以及优质品质。','Filosofi Kami':'我们的理念','Setiap serat kayu punya':'每一纹理木材都有一个','cerita.':'故事。','Kami menjaganya tetap utuh di setiap sentuhan.':'我们在每一个细节中保留其自然特色。','Material Alami':'天然材料','Kayu pilihan dengan karakter yang tidak pernah sama.':'精选木材，纹理各不相同。','Dikerjakan Teliti':'精心制作','Setiap detail diperhatikan hingga tahap akhir.':'每个细节都经过认真处理。','Tahan Lama':'经久耐用','Dirancang untuk menemani hunian Anda bertahun-tahun.':'设计陪伴您的家多年。','Solusi untuk Setiap Ruang':'适合每个空间的方案','Proyek Pilihan Kami':'精选项目','Cara Pemesanan':'订购流程','Pesan Furnitur dalam 4 Langkah':'四步订购家具','Proses yang sederhana dari memilih hingga produk sampai di tempat Anda.':'从选择到送达，流程简单方便。','Pilih Produk':'选择产品','Jelajahi katalog dan pilih furnitur yang sesuai dengan kebutuhan ruang Anda.':'浏览目录，选择适合您空间的家具。','Konsultasi':'咨询','Hubungi kami via WhatsApp untuk membahas ukuran, material, dan finishing.':'通过 WhatsApp 联系我们，讨论尺寸、材料和表面处理。','Konfirmasi & Produksi':'确认与生产','Setelah kesepakatan, pesanan diproses dan dikerjakan dengan teliti.':'确认后，我们将认真制作您的订单。','Pengiriman':'配送','Produk dikemas dengan aman dan dikirim sampai ke lokasi Anda.':'产品将安全包装并配送至您的地点。','Mulai Konsultasi':'开始咨询','Tahun Pengalaman':'年经验','Pelanggan Puas':'满意客户','Proyek Selesai':'完成项目','Klien & Mitra Kami':'客户与合作伙伴','Membangun hubungan dan kerja sama untuk hasil terbaik.':'建立合作关系，共创最佳成果。','Informasi mitra akan segera tersedia.':'合作伙伴信息即将公布。','Testimoni Pelanggan':'客户评价','Apa Kata Mereka?':'他们怎么说？','Kepuasan pelanggan adalah prioritas utama kami.':'客户满意是我们的首要目标。','Pelanggan TERRAWOOD':'TERRAWOOD客户','Wujudkan ruang impian Anda':'打造梦想空间','Wujudkan Ruang Impian Anda':'打造梦想空间','Tentang TERRAWOOD':'关于 TERRAWOOD','Layanan Kami':'我们的服务','Artikel Terbaru':'最新文章','Lihat Semua Artikel':'查看所有文章','Lihat Semua Produk':'查看所有产品','Lihat Semua Layanan':'查看所有服务','Hasil Karya TERRAWOOD':'TERRAWOOD项目成果','Beberapa proyek yang telah kami kerjakan.':'我们完成的部分项目。','Belum Ada Portofolio':'暂无作品集','Portofolio proyek TERRAWOOD akan ditampilkan di halaman ini.':'TERRAWOOD项目作品将在此展示。','Semua Artikel':'所有文章','Konten artikel belum tersedia.':'文章内容暂不可用。','Bagikan artikel ini':'分享文章','Salin Tautan':'复制链接','Tautan berhasil disalin':'链接已复制','Artikel Terkait':'相关文章','Lihat semua artikel':'查看所有文章','Temukan Inspirasi untuk Ruang Anda':'寻找空间灵感','Jelajahi Katalog':'浏览产品目录','Hubungi Kami':'联系我们','Lihat Detail':'查看详情','Baca Selengkapnya':'阅读更多','Selengkapnya':'了解更多','Masuk':'登录','Daftar':'注册','Keluar':'退出','Pesan Sekarang':'立即订购','Cari produk':'搜索产品','Semua Kategori':'所有类别','Kategori':'类别','Harga':'价格','Deskripsi Produk':'产品描述','Produk Lainnya':'相关产品','Bagikan':'分享','Kembali':'返回','Informasi':'信息','Kontak':'联系','Profil Saya':'我的资料','Notifikasi':'通知','Dashboard Admin':'管理员面板'
 }
 };
 const map = dict[locale]; if (!map) return;
 const translateTree = (root) => {
   const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT);
   const nodes=[]; while(walker.nextNode()) nodes.push(walker.currentNode);
   nodes.forEach(n=>{
     const raw=n.nodeValue; const t=raw.trim();
     if(map[t] && n.parentElement && !n.parentElement.closest('script,style,textarea,input,select,[data-no-translate]')) {
       n.nodeValue=raw.replace(t,map[t]);
     }
   });
   (root.querySelectorAll ? root.querySelectorAll('input[placeholder],textarea[placeholder],[aria-label],title') : []).forEach(el=>{
     ['placeholder','aria-label','title'].forEach(attr=>{const t=el.getAttribute(attr);if(t && map[t])el.setAttribute(attr,map[t]);});
   });
 };
 translateTree(document.body);
 // Translate content inserted later by page scripts without changing the language selector.
 const observer = new MutationObserver(records => records.forEach(record => {
   record.addedNodes.forEach(node => { if(node.nodeType===Node.ELEMENT_NODE) translateTree(node); });
 }));
 observer.observe(document.body,{childList:true,subtree:true});
 document.documentElement.lang=locale==='zh'?'zh-CN':'en';
})();
</script>
</body>
</html>