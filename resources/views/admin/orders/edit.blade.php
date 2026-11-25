@extends('layouts.app')

@section('content')

<style>
.order-edit-page {
    min-height: 100vh;
    background: #F7F5EF;
    padding: 38px 4%;
    font-family: 'Inter', sans-serif;
    color: #293747;
}

.order-edit-container {
    max-width: 1100px;
    margin: auto;
}

.order-edit-heading { margin-bottom: 25px; }

.order-edit-heading h1 {
    color: #082744;
    font-size: 29px;
    font-weight: 800;
    margin: 0 0 8px;
}

.order-edit-heading p {
    color: #788596;
    font-size: 14px;
    margin: 0;
}

.order-edit-back {
    display: inline-block;
    color: #082744;
    font-weight: 700;
    font-size: 14px;
    text-decoration: none;
    margin-bottom: 20px;
}

.order-edit-back:hover { color: #F5A623; }

.order-edit-card {
    background: white;
    border: 1px solid #ece9e1;
    border-radius: 17px;
    padding: 30px;
    box-shadow: 0 5px 25px rgba(8,39,68,.05);
    margin-bottom: 22px;
}

.order-edit-title {
    font-size: 18px;
    color: #082744;
    font-weight: 800;
    margin-bottom: 22px;
    padding-bottom: 15px;
    border-bottom: 1px solid #edf0f3;
}

.order-edit-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.order-edit-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.order-edit-field.full { grid-column: 1 / -1; }

.order-edit-field label {
    font-size: 13px;
    color: #344357;
    font-weight: 700;
}

.order-edit-field input,
.order-edit-field select,
.order-edit-field textarea {
    width: 100%;
    border: 1px solid #dce2e8;
    border-radius: 9px;
    padding: 12px 14px;
    font-family: inherit;
    font-size: 14px;
    color: #293747;
    background: white;
    outline: none;
    transition: .2s;
}

.order-edit-field input:focus,
.order-edit-field select:focus,
.order-edit-field textarea:focus {
    border-color: #F5A623;
    box-shadow: 0 0 0 3px rgba(245,166,35,.12);
}

.order-edit-field textarea {
    resize: vertical;
    min-height: 105px;
}

.order-edit-field input[readonly] {
    background: #f5f7f9;
    color: #082744;
    font-weight: 700;
}

.order-edit-price {
    background: #f8f9fb;
    border: 1px solid #e8edf2;
    border-radius: 12px;
    padding: 20px;
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-top: 22px;
}

.order-edit-price-item span {
    display: block;
    font-size: 12px;
    color: #788596;
    margin-bottom: 8px;
}

.order-edit-price-item strong {
    color: #082744;
    font-size: 19px;
    font-weight: 800;
}

.order-edit-price-item.total {
    background: #082744;
    border-radius: 10px;
    padding: 13px;
}

.order-edit-price-item.total span { color: #d4dce5; }

.order-edit-price-item.total strong {
    color: #F5A623;
    font-size: 21px;
}

.order-edit-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: wrap;
    margin-top: 25px;
}

.order-edit-btn {
    border: none;
    border-radius: 9px;
    padding: 13px 22px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: .2s;
}

.order-edit-cancel {
    background: #edf0f3;
    color: #465466;
}

.order-edit-submit {
    background: #082744;
    color: white;
}

.order-edit-submit:hover {
    background: #F5A623;
    color: #061D33;
}

.order-edit-submit:disabled {
    opacity: .65;
    cursor: not-allowed;
}

.order-edit-error {
    color: #c53d3d;
    font-size: 12px;
}

.order-edit-toast {
    display: none;
    padding: 13px 16px;
    border-radius: 9px;
    background: #ffebeb;
    color: #b83232;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 18px;
}

.order-edit-toast.show { display: block; }

/* MODAL KONFIRMASI */
.order-confirm-overlay {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(5, 24, 42, .65);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.order-confirm-overlay.show { display: flex; }

.order-confirm-box {
    background: white;
    width: 100%;
    max-width: 440px;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: orderModalIn .2s ease;
}

@keyframes orderModalIn {
    from { opacity: 0; transform: translateY(15px) scale(.98); }
    to { opacity: 1; transform: translateY(0) scale(1); }
}

.order-confirm-icon {
    width: 55px;
    height: 55px;
    background: #fff3d9;
    color: #b8790b;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 25px;
    margin-bottom: 18px;
}

.order-confirm-box h3 {
    color: #082744;
    font-size: 21px;
    margin: 0 0 9px;
    font-weight: 800;
}

.order-confirm-box p {
    color: #788596;
    font-size: 13px;
    line-height: 1.7;
    margin: 0 0 18px;
}

.order-confirm-summary {
    background: #f6f8fa;
    border-radius: 10px;
    padding: 14px;
    margin-bottom: 22px;
}

.order-confirm-summary div {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 6px 0;
    font-size: 13px;
}

.order-confirm-summary span { color: #788596; }

.order-confirm-summary strong {
    color: #082744;
    text-align: right;
}

.order-confirm-actions {
    display: flex;
    gap: 10px;
}

.order-confirm-actions button {
    flex: 1;
    border: none;
    border-radius: 9px;
    padding: 13px 10px;
    font-family: inherit;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
}

.order-confirm-close {
    background: #edf0f3;
    color: #465466;
}

.order-confirm-save {
    background: #082744;
    color: white;
}

.order-confirm-save:hover {
    background: #F5A623;
    color: #061D33;
}

@media(max-width: 650px) {
    .order-edit-page { padding: 25px 4%; }
    .order-edit-card { padding: 20px; }
    .order-edit-grid,
    .order-edit-price { grid-template-columns: 1fr; }
    .order-edit-field.full { grid-column: auto; }
    .order-edit-heading h1 { font-size: 24px; }
    .order-confirm-box { padding: 23px; }
}
</style>

<div class="order-edit-page">
    <div class="order-edit-container">

        <a href="{{ route('admin.orders.index') }}" class="order-edit-back">
            ← Kembali ke Daftar Pesanan
        </a>

        <div class="order-edit-heading">
            <h1>Edit Pesanan</h1>
            <p>Perbarui informasi transaksi dan status pesanan customer.</p>
        </div>

        <form action="{{ route('admin.orders.update', $order->id) }}"
              method="POST" id="orderEditForm">

            @csrf
            @method('PUT')

            <div class="order-edit-card">
                <div class="order-edit-title">01. Informasi Pesanan</div>

                <div class="order-edit-grid">

                    <div class="order-edit-field full">
                        <label>Nomor Pesanan</label>
                        <input type="text" value="{{ $order->order_number }}" readonly>
                    </div>

                    <div class="order-edit-field">
                        <label>Nama Customer</label>
                        <input type="text" name="customer_name"
                               value="{{ old('customer_name', $order->customer_name) }}"
                               required>
                        @error('customer_name')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="order-edit-field">
                        <label>Nomor WhatsApp</label>
                        <input type="tel" name="customer_phone"
                               value="{{ old('customer_phone', $order->customer_phone) }}"
                               required>
                        @error('customer_phone')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="order-edit-field full">
                        <label>Email Customer</label>
                        <input type="email" name="customer_email"
                               value="{{ old('customer_email', $order->customer_email) }}">
                        @error('customer_email')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="order-edit-field full">
                        <label>Alamat Pengiriman</label>
                        <textarea name="shipping_address" required>{{ old('shipping_address', $order->shipping_address) }}</textarea>
                        @error('shipping_address')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="order-edit-card">
                <div class="order-edit-title">02. Produk dan Perhitungan Harga</div>

                <div class="order-edit-grid">

                    <div class="order-edit-field full">
                        <label>Pilih Produk</label>

                        <select name="product_id" id="editProductSelect" required>
                            <option value="">-- Pilih Produk --</option>

                            @foreach($products as $product)
                                <option value="{{ $product->id }}"
                                        data-price="{{ $product->price }}"
                                        {{ old('product_id', $order->product_id) == $product->id ? 'selected' : '' }}
                                        {{ $product->price === null ? 'disabled' : '' }}>
                                    {{ $product->name }}
                                    @if($product->price !== null)
                                        — Rp {{ number_format($product->price, 0, ',', '.') }}
                                    @else
                                        — Harga belum tersedia
                                    @endif
                                </option>
                            @endforeach
                        </select>

                        @error('product_id')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror

                        @if($products->isEmpty())
                            <span class="order-edit-error">
                                Belum ada produk yang tersedia.
                            </span>
                        @endif
                    </div>

                    <div class="order-edit-field">
                        <label>Harga Satuan</label>
                        <input type="text" id="editUnitPriceDisplay" readonly>
                    </div>

                    <div class="order-edit-field">
                        <label>Jumlah Produk</label>
                        <input type="number" name="quantity" id="editQuantity"
                               min="1" value="{{ old('quantity', $order->quantity) }}"
                               required>
                        @error('quantity')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                <div class="order-edit-price">
                    <div class="order-edit-price-item">
                        <span>Harga Satuan</span>
                        <strong id="editUnitSummary">Rp 0</strong>
                    </div>

                    <div class="order-edit-price-item">
                        <span>Jumlah Produk</span>
                        <strong id="editQuantitySummary">1 unit</strong>
                    </div>

                    <div class="order-edit-price-item total">
                        <span>Total Pesanan</span>
                        <strong id="editTotalSummary">Rp 0</strong>
                    </div>
                </div>
            </div>

            <div class="order-edit-card">
                <div class="order-edit-title">03. Status dan Catatan</div>

                <div class="order-edit-grid">

                    <div class="order-edit-field">
                        <label>Status Pesanan</label>

                        <select name="status" id="editOrderStatus" required>
                            <option value="menunggu" {{ old('status', $order->status) == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="diproses" {{ old('status', $order->status) == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="dikirim" {{ old('status', $order->status) == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                            <option value="selesai" {{ old('status', $order->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="dibatalkan" {{ old('status', $order->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>

                        @error('status')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="order-edit-field">
                        <label>Catatan Pesanan</label>
                        <input type="text" name="notes"
                               value="{{ old('notes', $order->notes) }}"
                               placeholder="Catatan tambahan">
                        @error('notes')
                            <span class="order-edit-error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <div class="order-edit-toast" id="orderEditToast"></div>

            <div class="order-edit-actions">
                <a href="{{ route('admin.orders.index') }}"
                   class="order-edit-btn order-edit-cancel">Batal</a>

                <button type="submit" id="orderEditSubmit"
                        class="order-edit-btn order-edit-submit"
                        {{ $products->isEmpty() ? 'disabled' : '' }}>
                    Simpan Perubahan →
                </button>
            </div>

        </form>
    </div>
</div>

<!-- MODAL KONFIRMASI -->
<div class="order-confirm-overlay" id="orderConfirmModal">
    <div class="order-confirm-box">
        <div class="order-confirm-icon">!</div>

        <h3>Konfirmasi Perubahan</h3>
        <p>
            Pastikan informasi pesanan sudah benar sebelum disimpan.
            Perubahan status akan diinformasikan kepada customer.
        </p>

        <div class="order-confirm-summary">
            <div>
                <span>Nomor Pesanan</span>
                <strong>{{ $order->order_number }}</strong>
            </div>
            <div>
                <span>Customer</span>
                <strong id="confirmCustomer">-</strong>
            </div>
            <div>
                <span>Status Baru</span>
                <strong id="confirmStatus">-</strong>
            </div>
            <div>
                <span>Total Pesanan</span>
                <strong id="confirmTotal">Rp 0</strong>
            </div>
        </div>

        <div class="order-confirm-actions">
            <button type="button" class="order-confirm-close" id="closeOrderConfirm">
                Periksa Kembali
            </button>

            <button type="button" class="order-confirm-save" id="confirmOrderSave">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
const editForm = document.getElementById('orderEditForm');
const editProductSelect = document.getElementById('editProductSelect');
const editQuantity = document.getElementById('editQuantity');
const editStatus = document.getElementById('editOrderStatus');
const editToast = document.getElementById('orderEditToast');
const confirmModal = document.getElementById('orderConfirmModal');
const submitButton = document.getElementById('orderEditSubmit');
const confirmSaveButton = document.getElementById('confirmOrderSave');

let isSubmitting = false;

function formatEditRupiah(value) {
    return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
}

function getEditPrice() {
    const option = editProductSelect.options[editProductSelect.selectedIndex];

    return option && option.dataset.price
        ? Number(option.dataset.price)
        : 0;
}

function updateEditCalculation() {
    const price = getEditPrice();
    const quantity = Math.max(parseInt(editQuantity.value) || 1, 1);
    const total = price * quantity;

    document.getElementById('editUnitPriceDisplay').value = formatEditRupiah(price);
    document.getElementById('editUnitSummary').textContent = formatEditRupiah(price);
    document.getElementById('editQuantitySummary').textContent = quantity + ' unit';
    document.getElementById('editTotalSummary').textContent = formatEditRupiah(total);
}

editProductSelect.addEventListener('change', updateEditCalculation);
editQuantity.addEventListener('input', updateEditCalculation);

updateEditCalculation();

function showEditToast(message) {
    editToast.textContent = message;
    editToast.classList.add('show');
    editToast.scrollIntoView({ behavior: 'smooth', block: 'center' });
}

editForm.addEventListener('submit', function(e) {
    e.preventDefault();

    if (isSubmitting) return;

    const option = editProductSelect.options[editProductSelect.selectedIndex];

    if (!editProductSelect.value || !option || !option.dataset.price) {
        showEditToast('Silakan pilih produk yang memiliki harga.');
        editProductSelect.focus();
        return;
    }

    if (!editQuantity.value || Number(editQuantity.value) < 1) {
        showEditToast('Jumlah produk minimal 1.');
        editQuantity.focus();
        return;
    }

    if (!editForm.reportValidity()) return;

    const quantity = Number(editQuantity.value);
    const total = getEditPrice() * quantity;

    document.getElementById('confirmCustomer').textContent =
        editForm.querySelector('[name="customer_name"]').value;

    document.getElementById('confirmStatus').textContent =
        editStatus.options[editStatus.selectedIndex].text;

    document.getElementById('confirmTotal').textContent =
        formatEditRupiah(total);

    confirmModal.classList.add('show');
    document.body.style.overflow = 'hidden';
});

function closeConfirmModal() {
    if (isSubmitting) return;

    confirmModal.classList.remove('show');
    document.body.style.overflow = '';
}

document.getElementById('closeOrderConfirm').addEventListener('click', closeConfirmModal);

confirmModal.addEventListener('click', function(e) {
    if (e.target === confirmModal) closeConfirmModal();
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && confirmModal.classList.contains('show')) {
        closeConfirmModal();
    }
});

confirmSaveButton.addEventListener('click', function() {
    if (isSubmitting) return;

    isSubmitting = true;

    confirmSaveButton.disabled = true;
    submitButton.disabled = true;

    confirmSaveButton.textContent = 'Menyimpan...';
    submitButton.textContent = 'Menyimpan...';

    editForm.submit();
});
</script>

@endsection
