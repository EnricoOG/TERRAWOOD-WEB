@extends('layouts.app')

@include('partials.i18n')

@section('title', t3('Detail Pesanan', 'Order Details', '订单详情') . ' | TERRAWOOD')

@section('content')

@php
    $dateLocale = session('site_locale', 'en') === 'zh' ? 'zh_CN' : session('site_locale', 'en');
    $statusKey = match (strtolower(trim((string) $order->status))) {
        'menunggu', 'pending'                 => 'pending',
        'diproses', 'processing'              => 'processing',
        'dikirim', 'shipped'                  => 'shipped',
        'selesai', 'completed'                => 'completed',
        'dibatalkan', 'cancelled', 'canceled' => 'cancelled',
        default                               => strtolower(trim((string) $order->status)),
    };
    $statusText = [
        'pending'    => t3('Menunggu', 'Pending', '待处理'),
        'processing' => t3('Diproses', 'Processing', '处理中'),
        'shipped'    => t3('Dikirim', 'Shipped', '已发货'),
        'completed'  => t3('Selesai', 'Completed', '已完成'),
        'cancelled'  => t3('Dibatalkan', 'Cancelled', '已取消'),
    ][$statusKey] ?? ucfirst((string) $order->status);
    $isPending   = $statusKey === 'pending';
    $isCancelled = $statusKey === 'cancelled';
@endphp

<style>
    .order-detail-page {
        background: #F7F5EF;
        min-height: 100vh;
        padding: 50px 6%;
        color: #293747;
    }

    .order-detail-container {
        max-width: 1050px;
        margin: auto;
    }

    .order-back {
        display: inline-block;
        margin-bottom: 25px;
        color: #082744;
        text-decoration: none;
        font-weight: 700;
    }

    .order-detail-heading {
        margin-bottom: 28px;
    }

    .order-detail-heading h1 {
        color: #082744;
        font-size: 30px;
        margin: 0 0 8px;
    }

    .order-detail-heading p {
        color: #718096;
        margin: 0;
    }

    .order-detail-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 22px;
        align-items: start;
    }

    .order-detail-card {
        background: white;
        padding: 27px;
        border: 1px solid #E9E5DC;
        border-radius: 16px;
        margin-bottom: 20px;
    }

    .order-detail-card h2 {
        color: #082744;
        font-size: 19px;
        margin: 0 0 22px;
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 0;
        border-bottom: 1px solid #EEEAE2;
        font-size: 14px;
    }

    .detail-row span:first-child {
        color: #718096;
    }

    .detail-row strong {
        color: #082744;
        text-align: right;
    }

    .order-product {
        display: flex;
        gap: 15px;
        align-items: center;
        margin-bottom: 22px;
    }

    .order-product-image {
        width: 90px;
        height: 90px;
        border-radius: 10px;
        overflow: hidden;
        background: #EEEAE2;
        flex-shrink: 0;
    }

    .order-product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .order-product h3 {
        color: #082744;
        font-size: 17px;
        margin: 0 0 7px;
    }

    .order-product p {
        color: #718096;
        font-size: 13px;
        margin: 0;
    }

    .order-total {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        padding-top: 20px;
        color: #082744;
        font-weight: 800;
        font-size: 17px;
    }

    .order-total strong {
        color: #B47A13;
        font-size: 20px;
    }

    .order-status {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .status-menunggu {
        background: #FFF1D6;
        color: #A56800;
    }

    .status-diproses {
        background: #E1EDFF;
        color: #2456A6;
    }

    .status-dikirim {
        background: #E8E1FF;
        color: #6743A5;
    }

    .status-selesai {
        background: #DDF5E6;
        color: #237344;
    }

    .status-dibatalkan {
        background: #FFE2E2;
        color: #B42318;
    }

    .order-status-info {
        background: #F7F5EF;
        padding: 17px;
        border-radius: 10px;
        margin-top: 18px;
        color: #718096;
        font-size: 13px;
        line-height: 1.7;
    }

    .order-notes {
        background: #F7F5EF;
        border-radius: 10px;
        padding: 15px;
        color: #718096;
        line-height: 1.7;
        font-size: 14px;
        white-space: pre-line;
    }

    /* Tombol pembatalan */
    .cancel-order-btn {
        width: 100%;
        margin-top: 18px;
        padding: 13px 18px;
        border: 1px solid #B42318;
        border-radius: 9px;
        background: white;
        color: #B42318;
        font-size: 14px;
        font-weight: 800;
        cursor: pointer;
        transition: .25s;
    }

    .cancel-order-btn:hover {
        background: #B42318;
        color: white;
    }

    /* Toast notification */
    .order-toast {
        position: fixed;
        top: 25px;
        right: 25px;
        z-index: 10001;
        max-width: 380px;
        padding: 16px 20px;
        border-radius: 12px;
        background: white;
        box-shadow: 0 10px 35px rgba(0,0,0,.15);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        font-weight: 700;
        animation: toastIn .3s ease;
    }

    .order-toast.success {
        border-left: 5px solid #237344;
        color: #237344;
    }

    .order-toast.error {
        border-left: 5px solid #B42318;
        color: #B42318;
    }

    @keyframes toastIn {
        from {
            opacity: 0;
            transform: translateX(25px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Modal konfirmasi */
    .cancel-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(6, 29, 51, .72);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .cancel-modal.active {
        display: flex;
    }

    .cancel-modal-content {
        width: 100%;
        max-width: 430px;
        background: white;
        border-radius: 18px;
        padding: 32px;
        text-align: center;
        box-shadow: 0 20px 60px rgba(0,0,0,.2);
        animation: modalIn .25s ease;
    }

    @keyframes modalIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .cancel-modal-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #FFF1D6;
        color: #B47A13;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 800;
    }

    .cancel-modal-content h3 {
        color: #082744;
        font-size: 21px;
        margin: 0 0 10px;
    }

    .cancel-modal-content p {
        color: #718096;
        font-size: 14px;
        line-height: 1.7;
        margin-bottom: 25px;
    }

    .cancel-modal-actions {
        display: flex;
        gap: 12px;
    }

    .cancel-modal-actions button {
        flex: 1;
        padding: 13px 10px;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .btn-cancel-back {
        border: 1px solid #D8DDE4;
        background: white;
        color: #293747;
    }

    .btn-cancel-confirm {
        border: 1px solid #B42318;
        background: #B42318;
        color: white;
    }

    .btn-cancel-confirm:hover {
        background: #921C14;
    }

    @media(max-width: 750px) {
        .order-detail-grid {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 500px) {
        .order-detail-page {
            padding: 30px 5%;
        }

        .order-detail-card {
            padding: 20px;
        }

        .order-detail-heading h1 {
            font-size: 25px;
        }

        .cancel-modal-content {
            padding: 25px 20px;
        }

        .cancel-modal-actions {
            flex-direction: column;
        }

        .order-toast {
            left: 15px;
            right: 15px;
            top: 15px;
        }
    }
</style>

<div class="order-detail-page">
    <div class="order-detail-container">

        <a href="{{ route('account.index') }}" class="order-back">
            ← {{ t3('Kembali ke Dashboard', 'Back to Dashboard', '返回用户中心') }}
        </a>

        <div class="order-detail-heading">
            <h1>{{ t3('Detail Pesanan', 'Order Details', '订单详情') }}</h1>
            <p>{{ t3('Informasi lengkap pesanan TERRAWOOD Anda.', 'Complete information about your TERRAWOOD order.', '您的 TERRAWOOD 订单完整信息。') }}</p>
        </div>

        <div class="order-detail-grid">

            <div>

                <div class="order-detail-card">
                    <h2>{{ t3('Informasi Pesanan', 'Order Information', '订单信息') }}</h2>

                    <div class="detail-row">
                        <span>{{ t3('Nomor Pesanan', 'Order Number', '订单编号') }}</span>
                        <strong>{{ $order->order_number }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>{{ t3('Tanggal Pesanan', 'Order Date', '下单时间') }}</span>
                        <strong>{{ $order->created_at->format('d/m/Y H:i') }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>Status</span>
                        <strong>
                            <span class="order-status status-{{ $order->status }}">
                                {{ $statusText }}
                            </span>
                        </strong>
                    </div>

                    <div class="order-status-info">
                        @if($isPending)
                            {{ t3(
                                'Pesanan Anda sedang menunggu konfirmasi admin TERRAWOOD. Anda masih dapat membatalkan pesanan selama statusnya belum berubah menjadi diproses.',
                                'Your order is awaiting confirmation from the TERRAWOOD admin. You can still cancel it as long as the status has not changed to processing.',
                                '您的订单正在等待 TERRAWOOD 管理员确认。在状态变为“处理中”之前，您仍可取消订单。'
                            ) }}
                        @elseif($isCancelled)
                            {{ t3(
                                'Pesanan ini telah dibatalkan dan tidak akan diproses lebih lanjut.',
                                'This order has been cancelled and will not be processed further.',
                                '此订单已取消，将不再继续处理。'
                            ) }}
                        @else
                            {{ t3(
                                'Status pesanan akan diperbarui oleh admin TERRAWOOD. Silakan kunjungi halaman ini kembali untuk melihat perkembangan terbaru.',
                                'The order status will be updated by the TERRAWOOD admin. Please revisit this page for the latest progress.',
                                '订单状态将由 TERRAWOOD 管理员更新，请稍后再次访问此页面查看最新进度。'
                            ) }}
                        @endif
                    </div>

                    @if($isPending)
                        <button
                            type="button"
                            class="cancel-order-btn"
                            onclick="openCancelModal()"
                        >
                            {{ t3('Batalkan Pesanan', 'Cancel Order', '取消订单') }}
                        </button>
                    @endif
                </div>

                <div class="order-detail-card">
                    <h2>{{ t3('Informasi Pengiriman', 'Shipping Information', '配送信息') }}</h2>

                    <div class="detail-row">
                        <span>{{ t3('Nama Penerima', 'Recipient Name', '收件人姓名') }}</span>
                        <strong>{{ $order->customer_name }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>{{ t3('Nomor WhatsApp', 'WhatsApp Number', 'WhatsApp 号码') }}</span>
                        <strong>{{ $order->customer_phone }}</strong>
                    </div>

                    <div class="detail-row">
                        <span>{{ t3('Email', 'Email', '电子邮箱') }}</span>
                        <strong>{{ $order->customer_email ?: '-' }}</strong>
                    </div>

                    <div style="margin-top:18px;">
                        <strong style="color:#082744;font-size:14px;">
                            {{ t3('Alamat Pengiriman', 'Shipping Address', '收货地址') }}
                        </strong>

                        <p style="color:#718096;line-height:1.8;font-size:14px;">
                            {{ $order->shipping_address }}
                        </p>
                    </div>
                </div>

            </div>

            <div>

                <div class="order-detail-card">
                    <h2>{{ t3('Produk yang Dipesan', 'Ordered Product', '订购的产品') }}</h2>

                    <div class="order-product">

                        <div class="order-product-image">
                            @if($order->product?->image)
                                <img
                                    src="{{ \Illuminate\Support\Facades\Storage::url($order->product->image) }}"
                                    alt="{{ $order->product->localized('name') }}"
                                >
                            @endif
                        </div>

                        <div>
                            <h3>
                                {{ $order->product?->localized('name') ?? t3('Produk tidak tersedia', 'Product unavailable', '产品已下架') }}
                            </h3>

                            <p>
                                {{ t3('Jumlah: ' . $order->quantity . ' produk', 'Quantity: ' . $order->quantity . ' item(s)', '数量：' . $order->quantity . ' 件') }}
                            </p>
                        </div>

                    </div>

                    <div class="detail-row">
                        <span>{{ t3('Harga Satuan', 'Unit Price', '单价') }}</span>
                        <strong>
                            Rp {{ number_format((float)$order->unit_price, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="detail-row">
                        <span>{{ t3('Jumlah', 'Quantity', '数量') }}</span>
                        <strong>{{ $order->quantity }}</strong>
                    </div>

                    <div class="order-total">
                        <span>{{ t3('Total Pesanan', 'Order Total', '订单总额') }}</span>

                        <strong>
                            Rp {{ number_format((float)$order->total_price, 0, ',', '.') }}
                        </strong>
                    </div>
                </div>

                <div class="order-detail-card">
                    <h2>{{ t3('Catatan Pesanan', 'Order Notes', '订单备注') }}</h2>

                    <div class="order-notes">
                        {{ $order->notes ?: t3('Tidak ada catatan tambahan.', 'No additional notes.', '无其他备注。') }}
                    </div>
                </div>

            </div>

        </div>

    </div>
</div>

{{-- Popup notifikasi --}}
@if(session('success'))
    <div class="order-toast success" id="orderToast">
        <span>✓</span>
        <span>{{ session('success') }}</span>
    </div>
@elseif(session('error'))
    <div class="order-toast error" id="orderToast">
        <span>!</span>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- Modal konfirmasi pembatalan --}}
@if($isPending)
    <div class="cancel-modal" id="cancelModal">
        <div class="cancel-modal-content">

            <div class="cancel-modal-icon">!</div>

            <h3>{{ t3('Batalkan Pesanan?', 'Cancel Order?', '确认取消订单？') }}</h3>

            <p>
                {{ t3('Apakah Anda yakin ingin membatalkan pesanan', 'Are you sure you want to cancel order', '您确定要取消订单') }}
                <strong>{{ $order->order_number }}</strong>{{ t3('?', '?', '吗？') }}
                {{ t3('Pesanan yang sudah dibatalkan tidak dapat diproses kembali.', 'A cancelled order cannot be processed again.', '已取消的订单无法再次处理。') }}
            </p>

            <div class="cancel-modal-actions">

                <button
                    type="button"
                    class="btn-cancel-back"
                    onclick="closeCancelModal()"
                >
                    {{ t3('Kembali', 'Back', '返回') }}
                </button>

                <form
                    id="cancelOrderForm"
                    action="{{ route('account.orders.cancel', $order->id) }}"
                    method="POST"
                    style="flex:1;"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn-cancel-confirm"
                        style="width:100%;"
                    >
                        {{ t3('Ya, Batalkan Pesanan', 'Yes, Cancel Order', '是的，取消订单') }}
                    </button>
                </form>

            </div>

        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
    function openCancelModal() {
        const modal = document.getElementById('cancelModal');

        if (modal) {
            modal.classList.add('active');
        }
    }

    function closeCancelModal() {
        const modal = document.getElementById('cancelModal');

        if (modal) {
            modal.classList.remove('active');
        }
    }

    // Tutup modal jika area luar diklik
    document.addEventListener('click', function(event) {
        const modal = document.getElementById('cancelModal');

        if (modal && event.target === modal) {
            closeCancelModal();
        }
    });

    // Notifikasi menghilang otomatis
    document.addEventListener('DOMContentLoaded', function() {
        const toast = document.getElementById('orderToast');

        if (toast) {
            setTimeout(function() {
                toast.style.transition = 'opacity .4s ease';
                toast.style.opacity = '0';

                setTimeout(function() {
                    toast.remove();
                }, 400);
            }, 3500);
        }
    });
</script>
@endpush
