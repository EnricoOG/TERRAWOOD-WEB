@extends('layouts.app')

@section('content')

<style>
:root {
    --order-navy: #082744;
    --order-dark: #061D33;
    --order-gold: #F5A623;
    --order-ivory: #F7F5EF;
    --order-text: #293747;
}

.orders-page {
    min-height: 100vh;
    background: var(--order-ivory);
    padding: 38px 4%;
    color: var(--order-text);
    font-family: 'Inter', sans-serif;
}

.orders-container {
    max-width: 1500px;
    margin: auto;
}

.orders-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 18px;
    margin-bottom: 28px;
}

.orders-heading h1 {
    color: var(--order-navy);
    font-size: 30px;
    font-weight: 800;
    margin: 0 0 7px;
}

.orders-heading p {
    font-size: 15px;
    color: #718096;
    margin: 0;
}

.order-primary-btn {
    background: var(--order-navy);
    color: white;
    padding: 13px 21px;
    border-radius: 10px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: .2s;
}

.order-primary-btn:hover {
    background: var(--order-gold);
    color: var(--order-dark);
    transform: translateY(-2px);
}

.orders-summary {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 17px;
    margin-bottom: 25px;
}

.order-summary-card {
    background: white;
    border-radius: 15px;
    padding: 21px;
    border: 1px solid #eeeae1;
    box-shadow: 0 5px 20px rgba(8,39,68,.04);
}

.order-summary-card span {
    display: block;
    color: #778394;
    font-size: 13px;
    margin-bottom: 10px;
}

.order-summary-card strong {
    color: var(--order-navy);
    font-size: 27px;
    font-weight: 800;
}

.orders-panel {
    background: white;
    border-radius: 17px;
    border: 1px solid #eeeae1;
    box-shadow: 0 5px 25px rgba(8,39,68,.05);
    overflow: hidden;
}

.orders-toolbar {
    padding: 22px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    border-bottom: 1px solid #eeeae1;
}

.orders-toolbar h2 {
    color: var(--order-navy);
    font-size: 19px;
    font-weight: 800;
    margin: 0;
}

.orders-filters {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.orders-filters input,
.orders-filters select {
    border: 1px solid #dce2e8;
    border-radius: 9px;
    padding: 10px 13px;
    outline: none;
    font-size: 13px;
    min-height: 42px;
    background: white;
}

.orders-filters input {
    width: 280px;
}

.orders-filters select {
    min-width: 160px;
}

.orders-filters input:focus,
.orders-filters select:focus {
    border-color: var(--order-gold);
    box-shadow: 0 0 0 3px rgba(245,166,35,.12);
}

.order-search-btn {
    background: var(--order-navy);
    color: white;
    border: none;
    border-radius: 9px;
    padding: 10px 17px;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: .2s;
}

.order-search-btn:hover {
    background: var(--order-gold);
    color: var(--order-dark);
}

.order-reset-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 14px;
    border: 1px solid #dce2e8;
    border-radius: 9px;
    text-decoration: none;
    color: #64748b;
    font-size: 13px;
    font-weight: 700;
}

.order-reset-btn:hover {
    background: #f1f5f9;
    color: var(--order-navy);
}

.orders-result-info {
    padding: 13px 22px;
    color: #718096;
    font-size: 12px;
    border-bottom: 1px solid #edf0f3;
}

.orders-table-wrap {
    width: 100%;
    overflow-x: auto;
}

.orders-table {
    width: 100%;
    min-width: 1050px;
    border-collapse: collapse;
}

.orders-table th {
    background: #f8f9fb;
    color: #657386;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: .5px;
    padding: 16px 17px;
    text-align: left;
    white-space: nowrap;
}

.orders-table td {
    padding: 17px;
    border-top: 1px solid #edf0f3;
    font-size: 13px;
    color: #465466;
    vertical-align: middle;
}

.orders-table tbody tr:hover {
    background: #fcfbf8;
}

.order-number {
    color: var(--order-navy);
    font-weight: 800;
    font-size: 13px;
}

.customer-name {
    color: var(--order-navy);
    font-weight: 700;
    margin-bottom: 4px;
}

.customer-contact {
    color: #8994a2;
    font-size: 12px;
}

.order-product {
    font-weight: 600;
    color: #465466;
}

.order-total {
    font-weight: 800;
    color: var(--order-navy);
    white-space: nowrap;
}

.order-status {
    display: inline-block;
    padding: 7px 11px;
    border-radius: 30px;
    font-size: 11px;
    font-weight: 800;
    white-space: nowrap;
}

.status-menunggu {
    background: #fff3d9;
    color: #a66b00;
}

.status-diproses {
    background: #e7efff;
    color: #315da7;
}

.status-dikirim {
    background: #e5f4ff;
    color: #1476a5;
}

.status-selesai {
    background: #e4f6eb;
    color: #24804b;
}

.status-dibatalkan {
    background: #ffebeb;
    color: #bc4141;
}

.order-actions {
    display: flex;
    align-items: center;
    gap: 7px;
}

.order-action {
    width: 34px;
    height: 34px;
    border: none;
    border-radius: 8px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    cursor: pointer;
    font-size: 14px;
    transition: .2s;
}

.action-detail {
    background: #e8f2ff;
    color: #2563a5;
}

.action-edit {
    background: #fff2d9;
    color: #a56a00;
}

.action-delete {
    background: #ffebeb;
    color: #c13f3f;
}

.order-action:hover {
    transform: translateY(-2px);
    filter: brightness(.95);
}

.orders-empty {
    text-align: center;
    padding: 55px 20px;
    color: #8994a2;
}

.orders-empty strong {
    display: block;
    color: var(--order-navy);
    font-size: 17px;
    margin-bottom: 8px;
}

.orders-pagination {
    padding: 20px;
    border-top: 1px solid #edf0f3;
}

.order-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(3, 19, 34, .65);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    padding: 20px;
}

.order-modal-overlay.active {
    display: flex;
}

.order-modal {
    background: white;
    width: 100%;
    max-width: 420px;
    padding: 30px;
    border-radius: 17px;
    text-align: center;
    box-shadow: 0 20px 60px rgba(0,0,0,.2);
    animation: orderModalIn .2s ease;
}

@keyframes orderModalIn {
    from {opacity: 0; transform: translateY(12px);}
    to {opacity: 1; transform: translateY(0);}
}

.order-modal-icon {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: #fff0e8;
    color: #d65d38;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 25px;
    margin: 0 auto 16px;
}

.order-modal h3 {
    font-size: 21px;
    color: var(--order-navy);
    margin: 0 0 9px;
    font-weight: 800;
}

.order-modal p {
    font-size: 14px;
    color: #778394;
    line-height: 1.6;
    margin-bottom: 23px;
}

.order-modal-buttons {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.order-modal-buttons button {
    border: none;
    border-radius: 9px;
    padding: 11px 18px;
    font-weight: 700;
    cursor: pointer;
    font-size: 13px;
}

.order-cancel-btn {
    background: #edf0f3;
    color: #465466;
}

.order-confirm-btn {
    background: #c74343;
    color: white;
}

.order-confirm-btn:hover {
    background: #a92f2f;
}

.order-toast {
    position: fixed;
    top: 22px;
    right: 22px;
    z-index: 10000;
    background: #e5f6eb;
    color: #216d40;
    padding: 15px 21px;
    border-radius: 11px;
    box-shadow: 0 8px 30px rgba(0,0,0,.12);
    font-size: 14px;
    font-weight: 700;
    display: none;
    max-width: 380px;
}

.order-toast.error {
    background: #ffebeb;
    color: #b83232;
}

.order-toast.show {
    display: block;
    animation: orderToastIn .3s ease;
}

@keyframes orderToastIn {
    from {opacity: 0; transform: translateX(20px);}
    to {opacity: 1; transform: translateX(0);}
}

@media(max-width: 900px) {
    .orders-summary {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media(max-width: 600px) {
    .orders-page {
        padding: 25px 4%;
    }

    .orders-heading h1 {
        font-size: 24px;
    }

    .orders-summary {
        gap: 10px;
    }

    .order-summary-card {
        padding: 16px;
    }

    .order-summary-card strong {
        font-size: 22px;
    }

    .orders-toolbar {
        padding: 17px;
    }

    .orders-filters {
        width: 100%;
    }

    .orders-filters input,
    .orders-filters select,
    .order-search-btn,
    .order-reset-btn {
        width: 100%;
    }

    .order-modal {
        padding: 25px 20px;
    }
}
</style>

<div class="orders-page">
    <div class="orders-container">

        {{-- HEADER --}}
        <div class="orders-heading">
            <div>
                <h1>Pesanan Customer</h1>
                <p>Kelola dan pantau seluruh transaksi pelanggan TERRAWOOD.</p>
            </div>

            <a href="{{ route('admin.orders.create') }}" class="order-primary-btn">
                <span>＋</span> Tambah Pesanan
            </a>
        </div>

        {{-- STATISTIK --}}
        <div class="orders-summary">

            <div class="order-summary-card">
                <span>Total Pesanan</span>
                <strong>{{ $stats['total'] }}</strong>
            </div>

            <div class="order-summary-card">
                <span>Menunggu Konfirmasi</span>
                <strong>{{ $stats['pending'] }}</strong>
            </div>

            <div class="order-summary-card">
                <span>Sedang Diproses</span>
                <strong>{{ $stats['processing'] }}</strong>
            </div>

            <div class="order-summary-card">
                <span>Pesanan Selesai</span>
                <strong>{{ $stats['completed'] }}</strong>
            </div>

        </div>

        {{-- DAFTAR PESANAN --}}
        <div class="orders-panel">

            <div class="orders-toolbar">
                <h2>Daftar Transaksi</h2>

                {{-- FORM PENCARIAN DAN FILTER --}}
                <form
                    action="{{ route('admin.orders.index') }}"
                    method="GET"
                    class="orders-filters"
                >

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nomor, nama, email, WhatsApp..."
                    >

                    <select name="status">
                        <option value="">Semua Status</option>

                        <option value="menunggu"
                            {{ request('status') === 'menunggu' ? 'selected' : '' }}>
                            Menunggu
                        </option>

                        <option value="diproses"
                            {{ request('status') === 'diproses' ? 'selected' : '' }}>
                            Diproses
                        </option>

                        <option value="dikirim"
                            {{ request('status') === 'dikirim' ? 'selected' : '' }}>
                            Dikirim
                        </option>

                        <option value="selesai"
                            {{ request('status') === 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>

                        <option value="dibatalkan"
                            {{ request('status') === 'dibatalkan' ? 'selected' : '' }}>
                            Dibatalkan
                        </option>
                    </select>

                    <button type="submit" class="order-search-btn">
                        Cari
                    </button>

                    @if(request()->filled('search') || request()->filled('status'))
                        <a
                            href="{{ route('admin.orders.index') }}"
                            class="order-reset-btn"
                        >
                            Reset
                        </a>
                    @endif

                </form>
            </div>

            <div class="orders-result-info">
                Menampilkan
                <strong>{{ $orders->firstItem() ?? 0 }}</strong>
                sampai
                <strong>{{ $orders->lastItem() ?? 0 }}</strong>
                dari
                <strong>{{ $orders->total() }}</strong>
                pesanan.
            </div>

            {{-- TABEL --}}
            <div class="orders-table-wrap">

                <table class="orders-table">

                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nomor Pesanan</th>
                            <th>Customer</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($orders as $index => $order)

                            <tr>

                                <td>
                                    {{ $orders->firstItem() + $index }}
                                </td>

                                <td>
                                    <span class="order-number">
                                        {{ $order->order_number }}
                                    </span>
                                </td>

                                <td>
                                    <div class="customer-name">
                                        {{ $order->customer_name }}
                                    </div>

                                    <div class="customer-contact">
                                        {{ $order->customer_phone }}
                                    </div>
                                </td>

                                <td>
                                    <span class="order-product">
                                        {{ $order->product?->name ?? 'Produk dihapus' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->quantity }} unit
                                </td>

                                <td>
                                    <span class="order-total">
                                        Rp {{ number_format((float) $order->total_price, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    <span class="order-status status-{{ $order->status }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>

                                <td>
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>

                                <td>
                                    <div class="order-actions">

                                        <a
                                            href="{{ route('admin.orders.show', $order->id) }}"
                                            class="order-action action-detail"
                                            title="Detail Pesanan"
                                        >
                                            ◉
                                        </a>

                                        <a
                                            href="{{ route('admin.orders.edit', $order->id) }}"
                                            class="order-action action-edit"
                                            title="Edit Pesanan"
                                        >
                                            ✎
                                        </a>

                                        <button
                                            type="button"
                                            class="order-action action-delete"
                                            title="Hapus Pesanan"
                                            onclick="openOrderDeleteModal(
                                                '{{ route('admin.orders.destroy', $order->id) }}',
                                                @js($order->order_number)
                                            )"
                                        >
                                            ×
                                        </button>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="9">

                                    <div class="orders-empty">
                                        <strong>
                                            @if(request()->filled('search') || request()->filled('status'))
                                                Pesanan Tidak Ditemukan
                                            @else
                                                Belum Ada Pesanan
                                            @endif
                                        </strong>

                                        @if(request()->filled('search') || request()->filled('status'))
                                            Coba ubah kata kunci pencarian atau filter status.
                                        @else
                                            Data pesanan customer akan muncul di sini.
                                        @endif
                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            <div class="orders-pagination">
                {{ $orders->links() }}
            </div>

        </div>

    </div>
</div>

{{-- MODAL HAPUS --}}
<div class="order-modal-overlay" id="orderDeleteModal">

    <div class="order-modal">

        <div class="order-modal-icon">!</div>

        <h3>Hapus Pesanan?</h3>

        <p>
            Apakah kamu yakin ingin menghapus pesanan
            <strong id="deleteOrderNumber"></strong>?
            Data yang dihapus tidak dapat dikembalikan.
        </p>

        <div class="order-modal-buttons">

            <button
                type="button"
                class="order-cancel-btn"
                onclick="closeOrderDeleteModal()"
            >
                Batal
            </button>

            <form method="POST" id="orderDeleteForm">
                @csrf
                @method('DELETE')

                <button type="submit" class="order-confirm-btn">
                    Ya, Hapus
                </button>
            </form>

        </div>

    </div>

</div>

{{-- TOAST NOTIFIKASI --}}
<div class="order-toast" id="orderToast"></div>

@if(session('success'))
    <div
        id="orderSuccessMessage"
        data-message="{{ session('success') }}"
    ></div>
@endif

@if($errors->any())
    <div
        id="orderErrorMessage"
        data-message="{{ $errors->first() }}"
    ></div>
@endif

@endsection

@push('scripts')
<script>
function openOrderDeleteModal(url, number) {
    const modal = document.getElementById('orderDeleteModal');

    document.getElementById('orderDeleteForm').action = url;
    document.getElementById('deleteOrderNumber').textContent = number;

    modal.classList.add('active');
}

function closeOrderDeleteModal() {
    document.getElementById('orderDeleteModal').classList.remove('active');
}

// Tutup modal jika area luar diklik.
document.getElementById('orderDeleteModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeOrderDeleteModal();
    }
});

// Tutup modal dengan tombol Escape.
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeOrderDeleteModal();
    }
});

// Toast notifikasi.
function showOrderToast(message, error = false) {
    const toast = document.getElementById('orderToast');

    if (!toast || !message) return;

    toast.textContent = message;
    toast.classList.toggle('error', error);
    toast.classList.add('show');

    setTimeout(function() {
        toast.classList.remove('show');
    }, 3500);
}

document.addEventListener('DOMContentLoaded', function() {
    const successMessage = document.getElementById('orderSuccessMessage');
    const errorMessage = document.getElementById('orderErrorMessage');

    if (successMessage) {
        showOrderToast(successMessage.dataset.message);
    }

    if (errorMessage) {
        showOrderToast(errorMessage.dataset.message, true);
    }
});
</script>
@endpush