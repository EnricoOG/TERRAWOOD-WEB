@php
    $translationFields = $translationFields ?? [];
    $translationRecord = $translationRecord ?? null;
    $localeLabels = ['en' => 'English', 'id' => 'Bahasa Indonesia', 'zh' => '中文（简体）'];
@endphp
<section class="tw-translation-fields" style="border:1px solid #e2e8f0;border-radius:12px;padding:20px;margin:24px 0;background:#fbfcfd">
    <h3 style="margin:0 0 6px;color:#082744">Content translations / Terjemahan Konten</h3>
    <p style="margin:0 0 16px;color:#64748b;font-size:13px">Isi teks untuk setiap bahasa. Konten lama tetap digunakan jika kolom terjemahan dikosongkan.</p>
    @foreach($localeLabels as $locale => $label)
        <details style="margin:10px 0;background:#fff;border:1px solid #e5e7eb;border-radius:8px;padding:12px" {{ $locale === 'en' ? 'open' : '' }}>
            <summary style="font-weight:700;cursor:pointer;color:#082744">{{ $label }}</summary>
            <div style="display:grid;gap:12px;margin-top:14px">
                @foreach($translationFields as $field => $config)
                    @php
                        $fieldLabel = $config['label'] ?? ucfirst($field);
                        $type = $config['type'] ?? 'text';
                        $value = old("translations.$locale.$field", data_get($translationRecord?->translations ?? [], "$locale.$field", ''));
                    @endphp
                    <label style="display:block;font-size:13px;font-weight:600;color:#334155">
                        {{ $fieldLabel }}
                        @if($type === 'textarea')
                            <textarea name="translations[{{ $locale }}][{{ $field }}]" rows="{{ $field === 'content' ? 6 : 3 }}" style="display:block;width:100%;margin-top:6px;padding:10px;border:1px solid #cbd5e1;border-radius:7px;font:inherit">{{ $value }}</textarea>
                        @else
                            <input type="text" name="translations[{{ $locale }}][{{ $field }}]" value="{{ $value }}" style="display:block;width:100%;margin-top:6px;padding:10px;border:1px solid #cbd5e1;border-radius:7px;font:inherit">
                        @endif
                    </label>
                @endforeach
            </div>
        </details>
    @endforeach
</section>
