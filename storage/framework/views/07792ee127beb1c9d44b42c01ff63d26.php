
<?php
    if (!function_exists('t3')) {
        function t3($id, $en = null, $zh = null)
        {
            return match (session('site_locale', 'en')) {
                'id'    => $id,
                'zh'    => $zh ?? $en ?? $id,
                default => $en ?? $id,
            };
        }
    }
?>
<?php /**PATH C:\laragon\www\terrawood\resources\views/partials/i18n.blade.php ENDPATH**/ ?>