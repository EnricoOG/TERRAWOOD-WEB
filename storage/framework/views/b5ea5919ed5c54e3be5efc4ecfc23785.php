

<?php
    $siteLocale = session('site_locale', 'en');
    $contact = [
        'whatsapp'  => '6281320122571',
        'phone'     => '+62 813-2012-2571',
        'phone_raw' => '+6281320122571',
        'email'     => 'terrawoodfd@gmail.com',
        'address'   => match ($siteLocale) {
            'id'    => 'Jawa Tengah, Indonesia',
            'zh'    => '印度尼西亚 中爪哇',
            default => 'Central Java, Indonesia',
        },
    ];
?>

<?php if (! $__env->hasRenderedOnce('0063bd78-8d05-4904-94ee-b471f4203986')): $__env->markAsRenderedOnce('0063bd78-8d05-4904-94ee-b471f4203986'); ?>
<?php $__env->startPush('styles'); ?>
<style>
:root {
    --tw-dark: #061D33;
    --tw-orange: #FFA43A;
}

.footer,
.footer *,
.footer *::before,
.footer *::after { box-sizing: border-box; }

.footer { font-family: 'Inter', sans-serif; }

.footer h3 { font-family: 'Manrope', sans-serif; }

.footer a,
.whatsapp-float { text-decoration: none; }

.footer a:focus-visible,
.whatsapp-float:focus-visible {
    outline: 2px solid var(--tw-orange);
    outline-offset: 3px;
}

/* =====================================
   FOOTER
===================================== */

.footer {
    background: var(--tw-dark);
    color: white;
    padding: 60px 7% 23px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 1.3fr 1fr 1fr 1.2fr;
    gap: 40px;
    padding-bottom: 40px;
}

.footer-brand {
    display: flex;
    align-items: center;
}

.footer-logo {
    width: 175px;
    height: 70px;
    object-fit: contain;
    object-position: left center;
}

.footer-about p {
    color: rgba(255,255,255,.8);
    font-size: 13px;
    line-height: 1.9;
    margin-top: 16px;
    max-width: 260px;
}

.footer-column h3 {
    color: white;
    font-size: 15px;
    margin-bottom: 20px;
    font-weight: 800;
}

.footer-column a,
.footer-column p {
    display: block;
    color: rgba(255,255,255,.8);
    font-size: 13px;
    line-height: 2.5;
    transition: color .3s ease, transform .3s ease;
}

.footer-column a:hover {
    color: var(--tw-orange);
    transform: translateX(4px);
}

.footer-bottom {
    border-top: 1px solid rgba(255,255,255,.2);
    padding-top: 22px;
    display: flex;
    justify-content: space-between;
    gap: 15px;
    color: rgba(255,255,255,.75);
    font-size: 12px;
}

/* =====================================
   WHATSAPP BUTTON
===================================== */

.whatsapp-float {
    position: fixed;
    right: 22px;
    bottom: 22px;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #20C76A;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 5px 18px rgba(0,0,0,.2);
    z-index: 90;
    -webkit-tap-highlight-color: transparent;
    transition: transform .35s cubic-bezier(.22,.61,.36,1), box-shadow .35s cubic-bezier(.22,.61,.36,1);
}

.whatsapp-float:hover {
    transform: translateY(-4px) scale(1.05);
    color: white;
    box-shadow: 0 10px 24px rgba(0,0,0,.25);
}

.whatsapp-float:active {
    transform: scale(.95);
}

@media(max-width: 1100px) {
    .footer-grid { grid-template-columns: repeat(2, 1fr); }
}

@media(max-width: 760px) {
    .footer {
        padding: 44px 6% calc(22px + env(safe-area-inset-bottom, 0px));
    }

    .footer-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 28px 20px;
        padding-bottom: 30px;
    }

    .footer-about,
    .footer-column:last-child { grid-column: 1 / -1; }

    .footer-about p { max-width: none; }

    .footer-column h3 {
        margin-bottom: 8px;
        font-size: 14px;
    }

    .footer-column a,
    .footer-column p { line-height: 2.2; }

    .footer-bottom {
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
    }

    .whatsapp-float {
        right: 16px;
        bottom: calc(16px + env(safe-area-inset-bottom, 0px));
        width: 54px;
        height: 54px;
    }
}

@media (hover: none) {
    .footer-column a:hover { transform: none; }
}

@media(max-width: 340px) {
    .footer-grid { grid-template-columns: 1fr; }
}
.email-float {
    position:fixed;right:90px;bottom:22px;width:58px;height:58px;border-radius:50%;
    background:#082744;color:#fff;display:flex;align-items:center;justify-content:center;
    box-shadow:0 5px 18px rgba(0,0,0,.2);z-index:90;text-decoration:none;
    transition:transform .3s ease,box-shadow .3s ease;
}
.email-float:hover{transform:translateY(-4px);box-shadow:0 10px 24px rgba(0,0,0,.25);color:#fff}
@media(max-width:760px){.email-float{right:82px;bottom:calc(16px + env(safe-area-inset-bottom, 0px));width:54px;height:54px;}}
</style>
<?php $__env->stopPush(); ?>
<?php endif; ?>



<footer class="footer" id="kontak">

    <div class="footer-grid">

        <div class="footer-about">

            <div class="footer-brand">

                <img
                    src="<?php echo e(asset('images/terrawood-logo.png')); ?>"
                    alt="TERRAWOOD - Crafting Comfort with Nature"
                    class="footer-logo"
                    width="175"
                    height="70"
                    loading="lazy"
                    decoding="async"
                >

            </div>

            <p>
                <?php if($siteLocale === 'id'): ?>
                    Furniture yang menginspirasi, untuk hidup yang lebih baik. Menghadirkan kenyamanan dan keindahan dalam setiap ruang.
                <?php elseif($siteLocale === 'zh'): ?>
                    以家具启发美好生活，为每个空间带来舒适与美感。
                <?php else: ?>
                    Inspiring furniture for better living. Bringing comfort and beauty to every space.
                <?php endif; ?>
            </p>

        </div>


        <div class="footer-column">

            <h3><?php echo e($siteLocale === 'id' ? 'Navigasi' : ($siteLocale === 'zh' ? '导航' : 'Navigation')); ?></h3>

            <a href="<?php echo e(route('home')); ?>"><?php echo e($siteLocale === 'id' ? 'Beranda' : ($siteLocale === 'zh' ? '首页' : 'Home')); ?></a>
            <a href="<?php echo e(route('catalog.index')); ?>"><?php echo e($siteLocale === 'id' ? 'Katalog Produk' : ($siteLocale === 'zh' ? '产品目录' : 'Product Catalog')); ?></a>
            <a href="<?php echo e(route('services.index')); ?>"><?php echo e($siteLocale === 'id' ? 'Layanan' : ($siteLocale === 'zh' ? '服务' : 'Services')); ?></a>
            <a href="<?php echo e(route('home')); ?>#tentang"><?php echo e($siteLocale === 'id' ? 'Tentang Kami' : ($siteLocale === 'zh' ? '关于我们' : 'About Us')); ?></a>
            <a href="<?php echo e(route('articles.index')); ?>"><?php echo e($siteLocale === 'id' ? 'Artikel' : ($siteLocale === 'zh' ? '文章' : 'Articles')); ?></a>
            <a href="<?php echo e(route('portfolios.index')); ?>"><?php echo e($siteLocale === 'id' ? 'Portofolio' : ($siteLocale === 'zh' ? '作品集' : 'Portfolio')); ?></a>

        </div>


        <div class="footer-column">

            <h3><?php echo e($siteLocale === 'id' ? 'Layanan Kami' : ($siteLocale === 'zh' ? '我们的服务' : 'Our Services')); ?></h3>

            <a href="<?php echo e(route('services.index')); ?>">
                <?php echo e($siteLocale === 'id' ? 'Lihat Semua Layanan' : ($siteLocale === 'zh' ? '查看所有服务' : 'View All Services')); ?>

            </a>

            <a href="<?php echo e(route('portfolios.index')); ?>">
                <?php echo e($siteLocale === 'id' ? 'Hasil Proyek Kami' : ($siteLocale === 'zh' ? '项目成果' : 'Our Projects')); ?>

            </a>

            <a href="<?php echo e(route('home')); ?>#mitra">
                <?php echo e($siteLocale === 'id' ? 'Kerja Sama' : ($siteLocale === 'zh' ? '合作伙伴' : 'Partnerships')); ?>

            </a>

        </div>


        <div class="footer-column">

            <h3><?php echo e($siteLocale === 'id' ? 'Kontak Kami' : ($siteLocale === 'zh' ? '联系我们' : 'Contact Us')); ?></h3>

            <a href="tel:<?php echo e($contact['phone_raw']); ?>">📞 <?php echo e($contact['phone']); ?></a>
            <a href="mailto:<?php echo e($contact['email']); ?>">✉ <?php echo e($contact['email']); ?></a>
            <p>📍 <?php echo e($contact['address']); ?></p>

        </div>

    </div>


    <div class="footer-bottom">

        <span>
            © <?php echo e(date('Y')); ?> TERRAWOOD. All rights reserved.
        </span>

        <span>
            Crafting Comfort with Nature.
        </span>

    </div>

</footer>




<a
    href="https://wa.me/<?php echo e($contact['whatsapp']); ?>"
    class="whatsapp-float"
    target="_blank"
    rel="noopener"
    aria-label="<?php echo e($siteLocale === 'id' ? 'Hubungi TERRAWOOD melalui WhatsApp' : ($siteLocale === 'zh' ? '通过 WhatsApp 联系 TERRAWOOD' : 'Contact TERRAWOOD via WhatsApp')); ?>"
>

    <svg
        viewBox="0 0 32 32"
        width="31"
        height="31"
        aria-hidden="true"
    >
        <path
            fill="currentColor"
            d="M16.02 3.2A12.7 12.7 0 0 0 5.1 22.38L3.4 28.6l6.37-1.67A12.7 12.7 0 1 0 16.02 3.2Zm0 23.1c-1.98 0-3.92-.53-5.62-1.53l-.4-.24-3.78.99 1.01-3.68-.26-.42a10.38 10.38 0 1 1 9.05 4.88Zm5.7-7.77c-.31-.16-1.84-.91-2.12-1.01-.29-.1-.5-.16-.71.16-.21.31-.81 1.01-.99 1.22-.18.21-.36.23-.67.08-.31-.16-1.3-.48-2.47-1.53-.91-.81-1.53-1.81-1.71-2.12-.18-.31-.02-.48.14-.64.14-.14.31-.36.47-.54.16-.18.21-.31.31-.52.1-.21.05-.39-.03-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54h-.6c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.61s1.13 3.03 1.28 3.24c.16.21 2.22 3.39 5.38 4.75.75.32 1.33.51 1.78.65.75.24 1.44.2 1.98.12.6-.09 1.84-.75 2.1-1.48.26-.73.26-1.35.18-1.48-.08-.13-.29-.21-.6-.37Z"
        />
    </svg>

</a>

<a
    href="mailto:<?php echo e($contact['email']); ?>?subject=<?php echo e(rawurlencode('TERRAWOOD inquiry')); ?>"
    class="email-float"
    aria-label="<?php echo e($siteLocale === 'id' ? 'Hubungi TERRAWOOD melalui email' : ($siteLocale === 'zh' ? '通过电子邮件联系 TERRAWOOD' : 'Contact TERRAWOOD via email')); ?>"
    title="Email TERRAWOOD"
>
    <svg viewBox="0 0 24 24" width="26" height="26" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="5" width="18" height="14" rx="2"></rect>
        <path d="m3 7 9 6 9-6"></path>
    </svg>
</a>
<?php /**PATH C:\laragon\www\terrawood\resources\views/partials/footer.blade.php ENDPATH**/ ?>