{{--
    Google reCAPTCHA v2 ("I'm not a robot").
    Pemakaian di dalam <form>:  @include('partials.captcha')
    Kunci diambil dari config('services.recaptcha.site_key') (isi lewat .env: RECAPTCHA_SITE_KEY).
    Jika site key kosong, captcha tidak ditampilkan (supaya web tetap bisa jalan saat development).
--}}
@include('partials.i18n')
@php
    $captchaSiteKey = config('services.recaptcha.site_key');
    $captchaLang    = ['id' => 'id', 'zh' => 'zh-CN'][session('site_locale', 'en')] ?? 'en';
@endphp

@if($captchaSiteKey)
    <div class="auth-group captcha-group">
        <div class="captcha-scale">
            <div class="g-recaptcha"
                 data-sitekey="{{ $captchaSiteKey }}"
                 data-callback="onCaptchaSolved"
                 data-expired-callback="onCaptchaExpired"></div>
        </div>
        <small class="auth-error" id="captchaError" role="alert" @if(!$errors->has('g-recaptcha-response')) style="display:none;" @endif>
            {{ $errors->first('g-recaptcha-response') ?: t3('Silakan centang "Saya bukan robot" terlebih dahulu.', 'Please tick "I\'m not a robot" first.', '请先勾选“我不是机器人”。') }}
        </small>
    </div>

    <style>
        .captcha-group { margin-bottom: 18px; }
        .captcha-scale { transform-origin: 0 0; }
        @media (max-width: 380px) {
            .captcha-scale { transform: scale(.88); height: 70px; }
        }
    </style>

    <script>
        function onCaptchaSolved() {
            var e = document.getElementById('captchaError');
            if (e) e.style.display = 'none';
        }
        function onCaptchaExpired() {}
    </script>
    <script src="https://www.google.com/recaptcha/api.js?hl={{ $captchaLang }}" async defer></script>
@endif
