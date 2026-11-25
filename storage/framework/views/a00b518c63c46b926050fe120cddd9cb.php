<?php echo $__env->make('partials.i18n', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->startSection('title', t3('Buat Akun', 'Create Account', '创建账户') . ' | TERRAWOOD'); ?>
<?php $__env->startSection('content'); ?>
<?php
$ic = [
    'user'  => '<path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>',
    'mail'  => '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>',
    'lock'  => '<rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>',
    'eye'   => '<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
    'eyeoff'=> '<path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" x2="22" y1="2" y2="22"/>',
    'back'  => '<path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>',
    'arrow' => '<path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>',
    'check' => '<polyline points="20 6 9 17 4 12"/>',
    'alert' => '<circle cx="12" cy="12" r="10"/><line x1="12" x2="12" y1="8" y2="12"/><line x1="12" x2="12.01" y1="16" y2="16"/>',
    'bag'   => '<path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" x2="21" y1="6" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/>',
    'bell'  => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/>',
    'truck' => '<path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/>',
];
$icon = function ($name, $size = 18) use ($ic) {
    return '<svg class="au-ic" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . ($ic[$name] ?? '') . '</svg>';
};

    $countryLabels = [
        'Indonesia'      => ['Indonesia', 'Indonesia', '印度尼西亚'],
        'China'          => ['Tiongkok', 'China', '中国'],
        'United States'  => ['Amerika Serikat', 'United States', '美国'],
        'United Kingdom' => ['Inggris Raya', 'United Kingdom', '英国'],
        'Australia'      => ['Australia', 'Australia', '澳大利亚'],
        'Malaysia'       => ['Malaysia', 'Malaysia', '马来西亚'],
        'Singapore'      => ['Singapura', 'Singapore', '新加坡'],
        'Japan'          => ['Jepang', 'Japan', '日本'],
        'South Korea'    => ['Korea Selatan', 'South Korea', '韩国'],
        'Thailand'       => ['Thailand', 'Thailand', '泰国'],
        'India'          => ['India', 'India', '印度'],
        'Canada'         => ['Kanada', 'Canada', '加拿大'],
        'Germany'        => ['Jerman', 'Germany', '德国'],
        'France'         => ['Prancis', 'France', '法国'],
        'Netherlands'    => ['Belanda', 'Netherlands', '荷兰'],
        'Other'          => ['Lainnya', 'Other', '其他'],
    ];
    $countryLabel = fn ($c) => isset($countryLabels[$c]) ? t3(...$countryLabels[$c]) : $c;
?>
<style>
.auth-page,
.auth-page *,
.auth-page *::before,
.auth-page *::after { box-sizing: border-box; }
.auth-page {
    --u-navy: #082744;
    --u-dark: #061D33;
    --u-gold: #F5A623;
    --u-ivory: #F7F5EF;
    --u-text: #293747;
    --u-muted: #78818B;
    --u-ease: cubic-bezier(.22, .61, .36, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
    padding: 40px 20px;
    background:
        radial-gradient(circle at 88% 8%, rgba(245,166,35,.10), transparent 34%),
        var(--u-ivory);
    color: var(--u-text);
    font-family: 'Inter', sans-serif;
}
.auth-page a { text-decoration: none; }
.auth-page a:focus-visible,
.auth-page button:focus-visible,
.auth-page input:focus-visible,
.auth-page select:focus-visible {
    outline: 2px solid var(--u-gold);
    outline-offset: 3px;
}
.au-ic { display: block; flex-shrink: 0; }
.auth-card {
    display: grid;
    grid-template-columns: .9fr 1.1fr;
    width: 100%;
    max-width: 1050px;
    overflow: hidden;
    border-radius: 24px;
    background: white;
    box-shadow: 0 20px 55px rgba(8,39,68,.12);
}

/* =====================================
   BANNER
===================================== */
.auth-banner {
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    overflow: hidden;
    padding: 52px 40px;
    background: linear-gradient(145deg, #082744, #061D33);
    color: white;
}
.auth-banner::before,
.auth-banner::after {
    content: "";
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.auth-banner::before {
    right: -110px;
    bottom: -110px;
    width: 300px;
    height: 300px;
    border: 1px solid rgba(245,166,35,.35);
}
.auth-banner::after {
    left: -80px;
    top: -90px;
    width: 220px;
    height: 220px;
    border: 1px solid rgba(255,255,255,.08);
}
.auth-banner > * {
    position: relative;
    z-index: 1;
}
.auth-logo {
    display: inline-block;
    align-self: flex-start;
    margin-bottom: 30px;
}
.auth-logo img {
    display: block;
    width: 200px;
    height: auto;
}
.auth-banner h2 {
    margin: 0 0 16px;
    font-family: 'Playfair Display', serif;
    font-size: 34px;
    font-weight: 600;
    line-height: 1.25;
}
.auth-banner h2 em {
    color: var(--u-gold);
    font-style: italic;
}
.auth-banner p {
    margin: 0;
    color: #D7E0E8;
    font-size: 14px;
    line-height: 1.8;
}
.auth-points {
    display: grid;
    gap: 14px;
    padding: 0;
    margin: 30px 0 0;
    list-style: none;
}
.auth-points li {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #E6EDF3;
    font-size: 13.5px;
    font-weight: 600;
}
.auth-point-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    flex-shrink: 0;
    border-radius: 10px;
    background: rgba(245,166,35,.16);
    color: var(--u-gold);
}
.auth-quote {
    margin-top: 32px;
    color: var(--u-gold);
    font-family: 'Playfair Display', serif;
    font-size: 17px;
    font-style: italic;
}

/* =====================================
   FORM
===================================== */
.auth-form-area {
    padding: 44px 54px;
}
.auth-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 22px;
    color: var(--u-muted);
    font-size: 13px;
    font-weight: 600;
    transition: color .25s ease;
}
.auth-back .au-ic { transition: transform .3s var(--u-ease); }
.auth-back:hover { color: var(--u-navy); }
.auth-back:hover .au-ic { transform: translateX(-3px); }
.auth-form-area h1 {
    margin: 0 0 8px;
    color: var(--u-navy);
    font-size: 29px;
    font-weight: 800;
}
.auth-subtitle {
    margin: 0 0 26px;
    color: var(--u-muted);
    font-size: 14px;
}
.auth-alert {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 12px 14px;
    margin-bottom: 20px;
    border-radius: 10px;
    font-size: 13px;
    line-height: 1.6;
}
.auth-alert ul {
    margin: 6px 0 0;
    padding-left: 18px;
}
.auth-alert.success {
    border: 1px solid #B7E4C7;
    background: #ECFDF3;
    color: #167647;
}
.auth-alert.error {
    border: 1px solid #F5C2C0;
    background: #FFF0F0;
    color: #B42318;
}
.auth-group { margin-bottom: 18px; }
.auth-group label {
    display: block;
    margin-bottom: 8px;
    color: var(--u-text);
    font-size: 13px;
    font-weight: 700;
}
.auth-field { position: relative; }
.auth-field > .au-ic {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #9AA3AE;
    pointer-events: none;
    transition: color .25s ease;
}
.auth-field:focus-within > .au-ic { color: var(--u-gold); }
.auth-field input,
.auth-field select {
    width: 100%;
    height: 50px;
    padding: 0 46px 0 45px;
    border: 1.5px solid #DDE2E7;
    border-radius: 12px;
    background: #FCFCFB;
    color: var(--u-text);
    font-family: inherit;
    font-size: 14px;
    transition: border-color .25s ease, box-shadow .25s ease, background-color .25s ease;
    appearance: none;
}
.auth-field select {
    padding-right: 42px;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath fill='none' stroke='%239AA3AE' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' d='M1 1l5 5 5-5'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 16px center;
    cursor: pointer;
}
.auth-field input:focus,
.auth-field select:focus {
    border-color: var(--u-gold);
    background: white;
    box-shadow: 0 0 0 4px rgba(245,166,35,.14);
    outline: none;
}
.auth-field input.is-invalid,
.auth-field select.is-invalid { border-color: #E5A29B; }
.auth-toggle {
    position: absolute;
    right: 8px;
    top: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: 0;
    border-radius: 50%;
    background: transparent;
    color: #9AA3AE;
    cursor: pointer;
    transform: translateY(-50%);
    transition: background-color .2s ease, color .2s ease;
}
.auth-toggle:hover {
    background: #F1EDE3;
    color: var(--u-navy);
}
.auth-toggle .icon-hide { display: none; }
.auth-toggle[aria-pressed="true"] .icon-show { display: none; }
.auth-toggle[aria-pressed="true"] .icon-hide { display: block; }
.auth-error {
    display: block;
    margin-top: 6px;
    color: #D92D20;
    font-size: 12px;
}

/* Password strength indicator */
.strength {
    display: none;
    margin-top: 10px;
}
.strength.is-visible { display: block; }
.strength-bars {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 5px;
}
.strength-bars span {
    height: 5px;
    border-radius: 5px;
    background: #E9E4D8;
    transition: background-color .3s ease;
}
.strength[data-level="1"] .strength-bars span:nth-child(-n+1) { background: #E5484D; }
.strength[data-level="2"] .strength-bars span:nth-child(-n+2) { background: #F5A623; }
.strength[data-level="3"] .strength-bars span:nth-child(-n+3) { background: #7BC47F; }
.strength[data-level="4"] .strength-bars span:nth-child(-n+4) { background: #2E9E5B; }
.strength-text {
    display: flex;
    justify-content: space-between;
    gap: 10px;
    margin-top: 7px;
    color: var(--u-muted);
    font-size: 12px;
}
.strength-text strong { color: var(--u-navy); }
.match-hint {
    display: none;
    align-items: center;
    gap: 6px;
    margin-top: 7px;
    font-size: 12px;
    font-weight: 600;
}
.match-hint.is-visible { display: flex; }
.match-hint.ok { color: #167647; }
.match-hint.bad { color: #D92D20; }

.auth-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    height: 52px;
    margin-top: 8px;
    border: 0;
    border-radius: 999px;
    background: var(--u-gold);
    color: var(--u-navy);
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 800;
    letter-spacing: .4px;
    cursor: pointer;
    box-shadow: 0 8px 20px rgba(245,166,35,.3);
    -webkit-tap-highlight-color: transparent;
    transition:
        background-color .3s var(--u-ease),
        color .3s var(--u-ease),
        transform .3s var(--u-ease),
        box-shadow .3s var(--u-ease);
}
.auth-button .au-ic { transition: transform .3s var(--u-ease); }
.auth-button:active {
    transform: scale(.98);
    transition-duration: .12s;
}
@media (hover: hover) {
    .auth-button:hover {
        background: var(--u-navy);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 26px rgba(8,39,68,.25);
    }
    .auth-button:hover .au-ic { transform: translateX(3px); }
}
.auth-button[disabled] {
    opacity: .75;
    cursor: progress;
    transform: none;
}
.auth-spinner {
    display: none;
    width: 18px;
    height: 18px;
    border: 2.5px solid rgba(8,39,68,.25);
    border-top-color: var(--u-navy);
    border-radius: 50%;
    animation: authSpin .7s linear infinite;
}
.auth-button.is-loading .auth-spinner { display: block; }
.auth-button.is-loading .au-ic { display: none; }
@keyframes authSpin {
    to { transform: rotate(360deg); }
}
.auth-switch {
    margin-top: 22px;
    color: var(--u-muted);
    font-size: 13px;
    text-align: center;
}
.auth-switch a {
    color: var(--u-navy);
    font-weight: 800;
    transition: color .25s ease;
}
.auth-switch a:hover { color: #D99519; }

/* Google button */
.auth-google {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    height: 50px;
    margin-bottom: 18px;
    background: #fff;
    color: var(--u-text);
    border: 1.5px solid #DDE2E7;
    border-radius: 999px;
    font-family: 'Manrope', 'Inter', sans-serif;
    font-size: 13.5px;
    font-weight: 700;
    transition: border-color .25s ease, background-color .25s ease, transform .25s ease;
}
.auth-google:hover {
    border-color: var(--u-navy);
    background: #FAFAF7;
}
.auth-google svg {
    width: 18px;
    height: 18px;
    flex-shrink: 0;
}
.auth-divider {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0 0 18px;
    color: var(--u-muted);
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.auth-divider::before,
.auth-divider::after {
    content: "";
    flex: 1;
    height: 1px;
    background: #E5E7EB;
}

/* =====================================
   RESPONSIVE
===================================== */
@media (max-width: 800px) {
    .auth-page {
        align-items: flex-start;
        padding: 20px 14px 40px;
    }
    .auth-card {
        grid-template-columns: 1fr;
        border-radius: 20px;
    }
    .auth-banner { padding: 28px 26px; }
    .auth-logo { margin-bottom: 18px; }
    .auth-logo img { width: 150px; }
    .auth-banner h2 {
        margin-bottom: 0;
        font-size: 24px;
    }
    .auth-banner p,
    .auth-points,
    .auth-quote { display: none; }
    .auth-form-area { padding: 28px 24px 34px; }
    .auth-form-area h1 { font-size: 26px; }
}
@media (prefers-reduced-motion: reduce) {
    .auth-spinner { animation-duration: 1.6s; }
    .auth-button,
    .auth-back .au-ic,
    .strength-bars span { transition: none; }
}
</style>

<div class="auth-page">
    <div class="auth-card">

        
        <aside class="auth-banner">
            <a href="<?php echo e(route('home')); ?>" class="auth-logo" aria-label="<?php echo e(t3('Kembali ke beranda TERRAWOOD', 'Back to TERRAWOOD home', '返回 TERRAWOOD 首页')); ?>">
                <img
                    src="<?php echo e(asset('images/terrawood-logo-hd.png')); ?>"
                    alt="TERRAWOOD - Crafting Comfort with Nature"
                    width="200"
                    height="127"
                >
            </a>
            <h2><?php echo t3('Temukan <em>Kenyamanan</em> Anda', 'Discover Your <em>Comfort</em>', '发现属于您的<em>舒适</em>'); ?></h2>
            <p>
                <?php echo e(t3(
                    'Temukan furnitur dan dekorasi berkualitas yang menghadirkan kenyamanan dan keindahan alami di setiap ruang Anda.',
                    'Find quality furniture and décor that bring natural comfort and beauty into every space you create.',
                    '发现优质家具与装饰，为您打造的每个空间带来自然的舒适与美感。'
                )); ?>

            </p>
            <ul class="auth-points">
                <li>
                    <span class="auth-point-icon"><?php echo $icon('bag', 18); ?></span>
                    <?php echo e(t3('Pesan furnitur dengan mudah', 'Order furniture with ease', '轻松订购家具')); ?>

                </li>
                <li>
                    <span class="auth-point-icon"><?php echo $icon('truck', 18); ?></span>
                    <?php echo e(t3('Pantau status pesanan Anda', 'Track your order status', '追踪订单状态')); ?>

                </li>
                <li>
                    <span class="auth-point-icon"><?php echo $icon('bell', 18); ?></span>
                    <?php echo e(t3('Dapatkan pembaruan real-time', 'Receive real-time updates', '接收实时更新')); ?>

                </li>
            </ul>
            <div class="auth-quote">
                <?php echo e(t3('Buat akun. Temukan kenyamanan Anda.', 'Create an account. Discover your comfort.', '创建账户，发现您的舒适生活。')); ?>

            </div>
        </aside>

        
        <div class="auth-form-area">
            <a href="<?php echo e(route('home')); ?>" class="auth-back">
                <?php echo $icon('back', 16); ?> <?php echo e(t3('Kembali ke Beranda', 'Back to Home', '返回首页')); ?>

            </a>

            <h1><?php echo e(t3('Buat Akun', 'Create Account', '创建账户')); ?></h1>
            <p class="auth-subtitle">
                <?php echo e(t3('Bergabunglah dengan TERRAWOOD untuk menjelajahi koleksi eksklusif kami dan menikmati layanan premium.', 'Join TERRAWOOD to explore our exclusive collection and enjoy premium services.', '加入 TERRAWOOD，探索我们的专属系列并享受优质服务。')); ?>

            </p>

            <?php if(session('success')): ?>
                <div class="auth-alert success" role="status">
                    <?php echo $icon('check', 18); ?>

                    <span><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="auth-alert error" role="alert">
                    <?php echo $icon('alert', 18); ?>

                    <div>
                        <strong><?php echo e(t3('Mohon periksa kembali data Anda.', 'Please review your information.', '请检查您填写的信息。')); ?></strong>
                        <ul>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>

            <form action="<?php echo e(route('register.store')); ?>" method="POST" id="registerForm">

                
                <a href="<?php echo e(route('google.redirect')); ?>" class="auth-google">
                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <?php echo e(t3('Lanjutkan dengan Google', 'Continue with Google', '使用 Google 继续')); ?>

                </a>

                <div class="auth-divider"><?php echo e(t3('atau daftar dengan email', 'or register with email', '或使用邮箱注册')); ?></div>

                <?php echo csrf_field(); ?>

                <div class="auth-group">
                    <label for="country"><?php echo e(t3('Negara', 'Country', '国家/地区')); ?></label>
                    <div class="auth-field">
                        <?php echo $icon('user', 18); ?>

                        <select
                            id="country"
                            name="country"
                            required
                            class="<?php echo e($errors->has('country') ? 'is-invalid' : ''); ?>"
                        >
                            <option value=""><?php echo e(t3('Pilih negara Anda', 'Select your country', '请选择国家/地区')); ?></option>
                            <?php $__currentLoopData = ['Indonesia','China','United States','United Kingdom','Australia','Malaysia','Singapore','Japan','South Korea','Thailand','India','Canada','Germany','France','Netherlands','Other']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country); ?>" <?php if(old('country') === $country): echo 'selected'; endif; ?>><?php echo e($countryLabel($country)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="auth-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="auth-group">
                    <label for="name"><?php echo e(t3('Nama Lengkap', 'Full Name', '姓名')); ?></label>
                    <div class="auth-field">
                        <?php echo $icon('user', 18); ?>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="<?php echo e(old('name')); ?>"
                            placeholder="<?php echo e(t3('Masukkan nama lengkap Anda', 'Enter your full name', '请输入姓名')); ?>"
                            class="<?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>"
                            required
                            autocomplete="name"
                        >
                    </div>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="auth-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="auth-group">
                    <label for="email"><?php echo e(t3('Alamat Email', 'Email Address', '电子邮箱')); ?></label>
                    <div class="auth-field">
                        <?php echo $icon('mail', 18); ?>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?php echo e(old('email')); ?>"
                            placeholder="<?php echo e(t3('anda@contoh.com', 'you@example.com', 'you@example.com')); ?>"
                            class="<?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                            required
                            autocomplete="email"
                            inputmode="email"
                        >
                    </div>
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="auth-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="auth-group">
                    <label for="password"><?php echo e(t3('Kata Sandi', 'Password', '密码')); ?></label>
                    <div class="auth-field">
                        <?php echo $icon('lock', 18); ?>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="<?php echo e(t3('Minimal 8 karakter', 'Minimum 8 characters', '至少 8 个字符')); ?>"
                            class="<?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button
                            type="button"
                            class="auth-toggle"
                            data-toggle-password="password"
                            aria-label="<?php echo e(t3('Tampilkan kata sandi', 'Show password', '显示密码')); ?>"
                            aria-pressed="false"
                        >
                            <span class="icon-show"><?php echo $icon('eye', 18); ?></span>
                            <span class="icon-hide"><?php echo $icon('eyeoff', 18); ?></span>
                        </button>
                    </div>
                    <div class="strength" id="strength" data-level="0" aria-live="polite">
                        <div class="strength-bars" aria-hidden="true">
                            <span></span><span></span><span></span><span></span>
                        </div>
                        <div class="strength-text">
                            <span><?php echo e(t3('Kekuatan kata sandi', 'Password strength', '密码强度')); ?>: <strong id="strengthLabel">-</strong></span>
                        </div>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="auth-error"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="auth-group">
                    <label for="password_confirmation"><?php echo e(t3('Konfirmasi Kata Sandi', 'Confirm Password', '确认密码')); ?></label>
                    <div class="auth-field">
                        <?php echo $icon('lock', 18); ?>

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            placeholder="<?php echo e(t3('Masukkan ulang kata sandi Anda', 'Re-enter your password', '请再次输入密码')); ?>"
                            required
                            minlength="8"
                            autocomplete="new-password"
                        >
                        <button
                            type="button"
                            class="auth-toggle"
                            data-toggle-password="password_confirmation"
                            aria-label="<?php echo e(t3('Tampilkan kata sandi', 'Show password', '显示密码')); ?>"
                            aria-pressed="false"
                        >
                            <span class="icon-show"><?php echo $icon('eye', 18); ?></span>
                            <span class="icon-hide"><?php echo $icon('eyeoff', 18); ?></span>
                        </button>
                    </div>
                    <div class="match-hint" id="matchHint" aria-live="polite"></div>
                </div>

                
                <?php echo $__env->make('partials.captcha', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <button type="submit" class="auth-button" id="registerButton">
                    <span class="auth-spinner" aria-hidden="true"></span>
                    <span class="auth-button-text"><?php echo e(t3('BUAT AKUN', 'CREATE ACCOUNT', '创建账户')); ?></span>
                    <?php echo $icon('arrow', 18); ?>

                </button>
            </form>

            <div class="auth-switch">
                <?php echo e(t3('Sudah punya akun?', 'Already have an account?', '已有账户？')); ?>

                <a href="<?php echo e(route('login')); ?>"><?php echo e(t3('Masuk di sini', 'Sign in here', '在此登录')); ?></a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const strengthBox = document.getElementById('strength');
    const strengthLabel = document.getElementById('strengthLabel');
    const matchHint = document.getElementById('matchHint');

    /* Show / hide password */
    document.querySelectorAll('[data-toggle-password]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.dataset.togglePassword);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.setAttribute('aria-pressed', show ? 'true' : 'false');
            button.setAttribute('aria-label', show ? <?php echo json_encode(t3('Sembunyikan kata sandi', 'Hide password', '隐藏密码')) ?> : <?php echo json_encode(t3('Tampilkan kata sandi', 'Show password', '显示密码')) ?>);
        });
    });

    /* Password strength (hint only, does not block registration) */
    const levels = ['-', <?php echo json_encode(t3('Lemah', 'Weak', '弱')) ?>, <?php echo json_encode(t3('Cukup', 'Fair', '一般')) ?>, <?php echo json_encode(t3('Baik', 'Good', '良好')) ?>, <?php echo json_encode(t3('Kuat', 'Strong', '强')) ?>];
    function scorePassword(value) {
        if (!value) return 0;
        let score = 0;
        if (value.length >= 8) score++;
        if (value.length >= 12) score++;
        if (/[a-z]/.test(value) && /[A-Z]/.test(value)) score++;
        if (/\d/.test(value) && /[^A-Za-z0-9]/.test(value)) score++;
        else if (/\d/.test(value) || /[^A-Za-z0-9]/.test(value)) score += 0.5;
        if (value.length < 8) {
            return Math.min(1, Math.ceil(score));
        }
        return Math.max(1, Math.min(4, Math.floor(score)));
    }
    function updateStrength() {
        const value = passwordInput.value;
        const level = scorePassword(value);
        strengthBox.classList.toggle('is-visible', value.length > 0);
        strengthBox.dataset.level = String(level);
        strengthLabel.textContent = levels[level];
    }

    /* Confirm password match */
    function updateMatch() {
        const confirmValue = confirmInput.value;
        if (!confirmValue) {
            matchHint.className = 'match-hint';
            matchHint.textContent = '';
            return;
        }
        const matches = confirmValue === passwordInput.value;
        matchHint.className = 'match-hint is-visible ' + (matches ? 'ok' : 'bad');
        matchHint.textContent = matches ? <?php echo json_encode(t3('Kata sandi cocok', 'Passwords match', '密码一致')) ?> : <?php echo json_encode(t3('Kata sandi tidak cocok', "Passwords don't match", '密码不一致')) ?>;
    }

    passwordInput.addEventListener('input', function () {
        updateStrength();
        updateMatch();
    });
    confirmInput.addEventListener('input', updateMatch);
    updateStrength();
    updateMatch();

    /* Loading state on submit (prevents double-click) */
    const form = document.getElementById('registerForm');
    const button = document.getElementById('registerButton');
    if (form && button) {
        const label = button.querySelector('.auth-button-text');
        const originalText = label.textContent;
        form.addEventListener('submit', function (event) {
            /* Captcha wajib dicentang sebelum form dikirim */
            if (window.grecaptcha && form.querySelector('.g-recaptcha') && !grecaptcha.getResponse()) {
                event.preventDefault();
                var captchaError = document.getElementById('captchaError');
                if (captchaError) captchaError.style.display = 'block';
                return;
            }
            button.disabled = true;
            button.classList.add('is-loading');
            label.textContent = <?php echo json_encode(t3('MEMBUAT AKUN...', 'CREATING ACCOUNT...', '创建中...')) ?>;
        });
        /* Restore button state when user presses Back */
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                button.disabled = false;
                button.classList.remove('is-loading');
                label.textContent = originalText;
            }
        });
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\terrawood\resources\views/auth/register.blade.php ENDPATH**/ ?>