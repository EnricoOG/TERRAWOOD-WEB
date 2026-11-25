<?php

namespace App\Models\Concerns;

trait HasLocaleTranslations
{
    public function localized(string $field, ?string $locale = null): mixed
    {
        $locale = $locale ?: session('site_locale', 'en');
        $translations = $this->translations ?? [];
        $value = data_get($translations, $locale.'.'.$field);
        return is_string($value) && trim($value) !== '' ? $value : $this->getAttribute($field);
    }
}
