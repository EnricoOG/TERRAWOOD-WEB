@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Checkout Pesanan', 'Order Checkout', '订单结算') . ' | TERRAWOOD')

@section('content')

<style>
    .checkout-page {
        background: #F7F5EF;
        min-height: 100vh;
        padding: 55px 6%;
        color: #293747;
    }

    .checkout-container {
        max-width: 1100px;
        margin: auto;
    }

    .checkout-back {
        display: inline-block;
        margin-bottom: 25px;
        color: #082744;
        text-decoration: none;
        font-weight: 700;
        transition: color .25s ease;
    }

    .checkout-back:hover {
        color: #C47A1B;
    }

    .checkout-heading {
        margin-bottom: 28px;
    }

    .checkout-heading h1 {
        color: #082744;
        font-size: 32px;
        margin: 0 0 8px;
    }

    .checkout-heading p {
        color: #718096;
        margin: 0;
        line-height: 1.7;
    }

    .checkout-grid {
        display: grid;
        grid-template-columns: 1.1fr .9fr;
        gap: 25px;
        align-items: start;
    }

    .checkout-card {
        background: white;
        border: 1px solid #E9E5DC;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 10px 30px rgba(8, 39, 68, .04);
    }

    .checkout-card h2 {
        color: #082744;
        font-size: 20px;
        margin: 0 0 23px;
    }

    .form-group {
        margin-bottom: 19px;
    }

    .form-group label {
        display: block;
        color: #293747;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #DDD9D0;
        background: #FFFEFC;
        border-radius: 9px;
        padding: 13px 15px;
        font-size: 14px;
        outline: none;
        font-family: inherit;
        transition: border-color .2s, box-shadow .2s;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #F5A623;
        box-shadow: 0 0 0 3px rgba(245,166,35,.12);
    }

    .form-group textarea {
        min-height: 115px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-group input[readonly] {
        background: #F1F0EC;
        color: #718096;
        cursor: not-allowed;
    }

    .form-error {
        color: #B42318;
        font-size: 12px;
        margin-top: 6px;
    }

    .product-summary {
        display: flex;
        gap: 17px;
        align-items: center;
        margin-bottom: 24px;
    }

    .summary-image {
        width: 105px;
        height: 105px;
        flex-shrink: 0;
        border-radius: 11px;
        overflow: hidden;
        background: #EEEAE2;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #718096;
        font-size: 12px;
        text-align: center;
    }

    .summary-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .summary-info {
        min-width: 0;
    }

    .summary-info h3 {
        color: #082744;
        font-size: 17px;
        margin: 0 0 7px;
    }

    .summary-info p {
        color: #718096;
        font-size: 13px;
        margin: 0 0 7px;
    }

    .summary-info strong {
        color: #B47A13;
        font-size: 15px;
    }

    .price-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 0;
        border-bottom: 1px solid #EEEAE2;
        font-size: 14px;
    }

    .price-row span:first-child {
        color: #718096;
    }

    .price-row strong {
        color: #082744;
        text-align: right;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        gap: 12px;
        padding-top: 20px;
        margin-top: 5px;
        color: #082744;
        font-weight: 800;
        font-size: 17px;
    }

    .total-price {
        color: #B47A13;
        font-size: 21px;
        text-align: right;
    }

    .checkout-submit {
        width: 100%;
        border: none;
        background: #F5A623;
        color: #082744;
        border-radius: 10px;
        padding: 16px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        margin-top: 25px;
        transition: all .25s ease;
    }

    .checkout-submit:hover {
        background: #E99A15;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(245,166,35,.2);
    }

    .checkout-submit:active {
        transform: translateY(0);
    }

    .checkout-note {
        color: #718096;
        font-size: 12px;
        line-height: 1.7;
        margin-top: 15px;
    }

    .checkout-alert {
        padding: 14px 17px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
        line-height: 1.6;
    }

    .checkout-alert.error {
        background: #FFE2E2;
        color: #B42318;
        border: 1px solid #F5BABA;
    }

    .checkout-alert.success {
        background: #DDF5E6;
        color: #237344;
        border: 1px solid #B8E5C8;
    }

    .checkout-alert ul {
        padding-left: 20px;
    }

    @media(max-width: 800px) {
        .checkout-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 550px) {
        .checkout-page {
            padding: 35px 5%;
        }

        .checkout-heading h1 {
            font-size: 26px;
        }

        .checkout-card {
            padding: 20px;
        }

        .product-summary {
            align-items: flex-start;
        }

        .summary-image {
            width: 85px;
            height: 85px;
        }

        .total-row {
            font-size: 15px;
        }

        .total-price {
            font-size: 18px;
        }
    }
</style>

<div class="checkout-page">
    <div class="checkout-container">

        <a href="{{ route('catalog.show', $product->slug) }}"
           class="checkout-back">
            ← {{ t3('Kembali ke Detail Produk', 'Back to Product Details', '返回产品详情') }}
        </a>

        <div class="checkout-heading">
            <h1>{{ t3('Checkout Pesanan', 'Order Checkout', '订单结算') }}</h1>
            <p>
                {{ t3(
                    'Lengkapi informasi pengiriman untuk melanjutkan pesanan Anda bersama TERRAWOOD.',
                    'Complete your shipping information to continue your order with TERRAWOOD.',
                    '请填写配送信息，以继续您在 TERRAWOOD 的订单。'
                ) }}
            </p>
        </div>

        {{-- NOTIFIKASI ERROR --}}
        @if($errors->any())
            <div class="checkout-alert error">
                <strong>{{ t3('Periksa kembali data pesanan:', 'Please review your order information:', '请检查订单信息：') }}</strong>
                <ul style="margin-bottom:0;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="checkout-alert error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="checkout-alert success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('account.orders.store', $product->slug) }}"
              method="POST"
              id="checkoutForm">

            @csrf

            <div class="checkout-grid">

                {{-- INFORMASI CUSTOMER --}}
                <div class="checkout-card">

                    <h2>{{ t3('Informasi Pemesan', 'Customer Information', '订购人信息') }}</h2>

                    <div class="form-group">
                        <label>{{ t3('Nama Customer', 'Customer Name', '客户姓名') }}</label>
                        <input type="text"
                               value="{{ auth()->user()->name }}"
                               readonly>
                    </div>

                    <div class="form-group">
                        <label>{{ t3('Email', 'Email', '电子邮箱') }}</label>
                        <input type="email"
                               value="{{ auth()->user()->email }}"
                               readonly>
                    </div>

                    <div class="form-group">
                        <label>{{ t3('Nomor WhatsApp', 'WhatsApp Number', 'WhatsApp 号码') }} *</label>
                        <input type="tel"
                               name="customer_phone"
                               value="{{ old('customer_phone') }}"
                               placeholder="{{ t3('Contoh: 081234567890', 'Example: 081234567890', '例如：081234567890') }}"
                               maxlength="20"
                               required>

                        @error('customer_phone')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ t3('Jumlah Produk', 'Quantity', '数量') }} *</label>
                        <input type="number"
                               id="quantity"
                               name="quantity"
                               min="1"
                               max="100"
                               value="{{ old('quantity', 1) }}"
                               required>

                        @error('quantity')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ t3('Alamat Pengiriman', 'Shipping Address', '收货地址') }} *</label>
                        <textarea name="shipping_address"
                                  placeholder="{{ t3('Masukkan alamat lengkap pengiriman...', 'Enter your full shipping address...', '请输入完整的收货地址...') }}"
                                  required>{{ old('shipping_address') }}</textarea>

                        @error('shipping_address')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>{{ t3('Catatan Tambahan (Opsional)', 'Additional Notes (Optional)', '附加备注（可选）') }}</label>
                        <textarea name="notes"
                                  placeholder="{{ t3('Contoh: Patokan rumah atau permintaan khusus...', 'Example: landmark near your home or special requests...', '例如：住址附近的标志性地点或特殊要求...') }}">{{ old('notes') }}</textarea>

                        @error('notes')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- RINGKASAN PESANAN --}}
                <div class="checkout-card">

                    <h2>{{ t3('Ringkasan Pesanan', 'Order Summary', '订单摘要') }}</h2>

                    <div class="product-summary">

                        <div class="summary-image">

                            @if($product->image)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($product->image) }}"
                                    alt="{{ $product->localized('name') }}"
                                >
                            @else
                                {{ t3('Tidak ada gambar', 'No image', '暂无图片') }}
                            @endif

                        </div>

                        <div class="summary-info">
                            <h3>{{ $product->localized('name') }}</h3>

                            <p>
                                {{ $product->category?->localized('name') ?? t3('Furnitur', 'Furniture', '家具') }}
                            </p>

                            <strong>
                                Rp {{ number_format((float) (($product->discount_price && $product->discount_price < $product->price) ? $product->discount_price : $product->price), 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>

                    <div class="price-row">
                        <span>{{ t3('Harga Satuan', 'Unit Price', '单价') }}</span>

                        <strong>
                            Rp {{ number_format((float) (($product->discount_price && $product->discount_price < $product->price) ? $product->discount_price : $product->price), 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="price-row">
                        <span>{{ t3('Jumlah Produk', 'Quantity', '数量') }}</span>

                        <strong id="quantityDisplay">
                            {{ old('quantity', 1) }}
                        </strong>
                    </div>

                    <div class="total-row">
                        <span>{{ t3('Total Pesanan', 'Order Total', '订单总额') }}</span>

                        <span class="total-price" id="totalDisplay">
                            Rp 0
                        </span>
                    </div>

                    <button type="submit"
                            class="checkout-submit"
                            id="submitButton">
                        {{ t3('Buat Pesanan Sekarang', 'Place Order Now', '立即下单') }}
                    </button>

                    <p class="checkout-note">
                        {{ t3(
                            '* Pesanan akan tercatat dengan status Menunggu. Admin TERRAWOOD akan memproses pesanan Anda. Biaya pengiriman akan dikonfirmasi oleh admin.',
                            '* Your order will be recorded with the status Pending. The TERRAWOOD admin will process your order. Shipping costs will be confirmed by the admin.',
                            '* 订单将以“待处理”状态记录。TERRAWOOD 管理员将处理您的订单，运费将由管理员确认。'
                        ) }}
                    </p>

                </div>

            </div>

        </form>

    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const quantityInput = document.getElementById('quantity');
    const quantityDisplay = document.getElementById('quantityDisplay');
    const totalDisplay = document.getElementById('totalDisplay');
    const checkoutForm = document.getElementById('checkoutForm');

    const unitPrice = {{ (float) (($product->discount_price && $product->discount_price < $product->price) ? $product->discount_price : $product->price) }};

    function formatRupiah(value) {
        return 'Rp ' + new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(value);
    }

    function updateTotal() {

        let quantity = parseInt(quantityInput.value);

        if (isNaN(quantity)) {
            quantity = 1;
        }

        quantity = Math.min(100, Math.max(1, quantity));

        quantityDisplay.textContent = quantity;

        totalDisplay.textContent = formatRupiah(
            unitPrice * quantity
        );
    }

    quantityInput.addEventListener('input', updateTotal);

    quantityInput.addEventListener('change', function () {

        let quantity = parseInt(this.value);

        if (isNaN(quantity)) {
            quantity = 1;
        }

        quantity = Math.min(100, Math.max(1, quantity));

        this.value = quantity;

        updateTotal();
    });

    checkoutForm.addEventListener('submit', function (event) {

        const quantity = parseInt(quantityInput.value);

        if (isNaN(quantity) || quantity < 1 || quantity > 100) {
            event.preventDefault();

            quantityInput.value = 1;
            updateTotal();

            quantityInput.focus();

            return;
        }
    });

    updateTotal();

});
</script>

@endsection