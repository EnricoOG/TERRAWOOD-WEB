{{--
    Helper 3 bahasa (ID / EN / 中文).
    Pemakaian: {{ t3('Teks Indonesia', 'English text', '中文文本') }}
    Bahasa diambil dari session('site_locale') (default: en), sama seperti navbar.
    Include sekali di bagian atas view:  @include('partials.i18n')
--}}
@php
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
@endphp
