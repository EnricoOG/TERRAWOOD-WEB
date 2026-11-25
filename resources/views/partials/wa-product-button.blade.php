{{--
    Tombol "Tanya via WhatsApp" untuk halaman detail produk.
    Pemakaian: @include('partials.wa-product-button', ['product' => $product])
    Nomor WhatsApp diambil dari config/terrawood.php
--}}
@include('partials.i18n')
@php
    $waNumber = '6281320122571';

    $waText = t3(
                'Halo TERRAWOOD, saya tertarik dengan produk "' . $product->localized('name') . '". Apakah masih tersedia dan berapa estimasi harganya?',
                'Hello TERRAWOOD, I am interested in the product "' . $product->localized('name') . '". Is it still available, and what is the estimated price?',
                '您好 TERRAWOOD，我对产品“' . $product->localized('name') . '”感兴趣。请问是否有货，预计价格是多少？'
            ) . "\n"
            . url()->current();

    $waUrl = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($waText);
    $email = 'terrawoodfd@gmail.com';
    $mailSubject = t3('Pertanyaan produk: ', 'Product inquiry: ', '产品咨询：') . $product->localized('name');
    $mailBody = t3(
                'Halo TERRAWOOD, saya tertarik dengan ' . $product->localized('name') . '. Mohon informasi ketersediaan dan harganya.',
                'Hello TERRAWOOD, I am interested in ' . $product->localized('name') . '. Please share availability and pricing.',
                '您好 TERRAWOOD，我对 ' . $product->localized('name') . ' 感兴趣，请告知库存和价格。'
            ) . "\n" . url()->current();
    $mailUrl = 'mailto:' . $email . '?subject=' . rawurlencode($mailSubject) . '&body=' . rawurlencode($mailBody);
@endphp

@once
@push('styles')
<style>
.wa-product-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    background: #20C76A;
    color: #fff;
    padding: 15px 26px;
    border-radius: 30px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    font-weight: 800;
    text-decoration: none;
    box-shadow: 0 6px 18px rgba(32,199,106,.3);
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    transition:
        background-color .35s cubic-bezier(.22,.61,.36,1),
        transform .35s cubic-bezier(.22,.61,.36,1),
        box-shadow .35s cubic-bezier(.22,.61,.36,1);
}

.wa-product-button:hover,
.wa-product-button:focus-visible {
    background: #17A956;
    color: #fff;
    transform: translateY(-3px);
    box-shadow: 0 10px 22px rgba(32,199,106,.35);
}

.wa-product-button:active {
    transform: translateY(0) scale(.97);
    transition-duration: .12s;
}

.wa-product-button:focus-visible {
    outline: 2px solid #082744;
    outline-offset: 3px;
}

.wa-product-button svg {
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

@media(max-width: 430px) {
    .wa-product-button {
        width: 100%;
    }
}
</style>
@endpush
@endonce

<a
    href="{{ $waUrl }}"
    class="wa-product-button"
    target="_blank"
    rel="noopener"
>
    <svg viewBox="0 0 32 32" aria-hidden="true">
        <path
            fill="currentColor"
            d="M16.02 3.2A12.7 12.7 0 0 0 5.1 22.38L3.4 28.6l6.37-1.67A12.7 12.7 0 1 0 16.02 3.2Zm0 23.1c-1.98 0-3.92-.53-5.62-1.53l-.4-.24-3.78.99 1.01-3.68-.26-.42a10.38 10.38 0 1 1 9.05 4.88Zm5.7-7.77c-.31-.16-1.84-.91-2.12-1.01-.29-.1-.5-.16-.71.16-.21.31-.81 1.01-.99 1.22-.18.21-.36.23-.67.08-.31-.16-1.3-.48-2.47-1.53-.91-.81-1.53-1.81-1.71-2.12-.18-.31-.02-.48.14-.64.14-.14.31-.36.47-.54.16-.18.21-.31.31-.52.1-.21.05-.39-.03-.55-.08-.16-.71-1.71-.97-2.34-.26-.61-.52-.53-.71-.54h-.6c-.21 0-.55.08-.84.39-.29.31-1.1 1.07-1.1 2.61s1.13 3.03 1.28 3.24c.16.21 2.22 3.39 5.38 4.75.75.32 1.33.51 1.78.65.75.24 1.44.2 1.98.12.6-.09 1.84-.75 2.1-1.48.26-.73.26-1.35.18-1.48-.08-.13-.29-.21-.6-.37Z"
        />
    </svg>
    {{ t3('Tanya via WhatsApp', 'Ask via WhatsApp', '通过 WhatsApp 咨询') }}
</a>

<a href="{{ $mailUrl }}" class="wa-product-button email-product-button" style="background:#082744;box-shadow:0 6px 18px rgba(8,39,68,.2);margin-top:10px;">
    <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"></rect><path d="m3 7 9 6 9-6"></path></svg>
    {{ t3('Kirim Email', 'Email Us', '发送邮件') }}
</a>
