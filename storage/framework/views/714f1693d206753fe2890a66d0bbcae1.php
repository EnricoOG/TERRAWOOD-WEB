
<?php echo $__env->make('partials.i18n', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php
    $captchaSiteKey = config('services.recaptcha.site_key');
    $captchaLang    = ['id' => 'id', 'zh' => 'zh-CN'][session('site_locale', 'en')] ?? 'en';
?>

<?php if($captchaSiteKey): ?>
    <div class="auth-group captcha-group">
        <div class="captcha-scale">
            <div class="g-recaptcha"
                 data-sitekey="<?php echo e($captchaSiteKey); ?>"
                 data-callback="onCaptchaSolved"
                 data-expired-callback="onCaptchaExpired"></div>
        </div>
        <small class="auth-error" id="captchaError" role="alert" <?php if(!$errors->has('g-recaptcha-response')): ?> style="display:none;" <?php endif; ?>>
            <?php echo e($errors->first('g-recaptcha-response') ?: t3('Silakan centang "Saya bukan robot" terlebih dahulu.', 'Please tick "I\'m not a robot" first.', '请先勾选“我不是机器人”。')); ?>

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
    <script src="https://www.google.com/recaptcha/api.js?hl=<?php echo e($captchaLang); ?>" async defer></script>
<?php endif; ?>
<?php /**PATH C:\laragon\www\terrawood\resources\views/partials/captcha.blade.php ENDPATH**/ ?>