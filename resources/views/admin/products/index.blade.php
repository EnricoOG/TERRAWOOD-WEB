
@extends('layouts.app')

@section('content')

<style>
    .product-page {
        padding: 35px;
        min-height: 80vh;
        background: #f7f5ef;
        color: #293747;
        font-family: Arial, sans-serif;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .product-header h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .product-header p {
        color: #777;
        margin: 0;
    }

    .product-btn-add {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        background: #f5a623;
        color: #082744;
        font-weight: 700;
        text-decoration: none;
    }

    .product-btn-add:hover {
        background: #e69a19;
        color: #082744;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .product-card h3 {
        color: #082744;
        font-size: 18px;
        margin: 0 0 20px;
    }

    .product-table-wrap {
        overflow-x: auto;
    }

    .product-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .product-table th {
        background: #082744;
        color: white;
        padding: 15px 12px;
        text-align: left;
        font-size: 13px;
    }

    .product-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    .product-table tr:hover td {
        background: #faf9f5;
    }

    .product-image {
        width: 65px;
        height: 60px;
        object-fit: cover;
        border-radius: 7px;
        border: 1px solid #eee;
    }

    .product-no-image {
        width: 65px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f1f1;
        color: #888;
        border-radius: 7px;
        font-size: 11px;
    }

    .product-category {
        display: inline-block;
        background: #e6efff;
        color: #2455a5;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .product-featured {
        display: inline-block;
        background: #fff1d6;
        color: #956000;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .product-normal {
        display: inline-block;
        background: #eee;
        color: #666;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .product-actions {
        display: flex;
        gap: 7px;
    }

    .btn-edit,
    .btn-delete {
        padding: 7px 12px;
        border-radius: 5px;
        font-size: 12px;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #e6efff;
        color: #2455a5;
        border: 1px solid #d4e2fa;
    }

    .btn-delete {
        background: #fff0ef;
        color: #c0392b;
        border: 1px solid #f5d1ce;
    }

    .product-alert {
        padding: 13px 16px;
        border-radius: 7px;
        margin-bottom: 20px;
    }

    .alert-success {
        background: #e3f7eb;
        color: #20834a;
    }

    .alert-error {
        background: #fff0ef;
        color: #c0392b;
    }

    .product-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #888;
    }

    .product-pagination {
        margin-top: 22px;
    }

    /* POPUP KONFIRMASI HAPUS */

    .delete-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(6, 29, 51, .65);
        z-index: 9999;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .delete-modal.show {
        display: flex;
    }

    .delete-modal-content {
        background: white;
        width: 100%;
        max-width: 420px;
        padding: 30px;
        border-radius: 14px;
        text-align: center;
        box-shadow: 0 15px 45px rgba(0,0,0,.2);
        animation: modalAppear .2s ease;
    }

    @keyframes modalAppear {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .delete-modal-icon {
        width: 65px;
        height: 65px;
        margin: 0 auto 18px;
        border-radius: 50%;
        background: #fff0ef;
        color: #c0392b;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: bold;
    }

    .delete-modal-content h3 {
        color: #082744;
        font-size: 20px;
        margin-bottom: 10px;
    }

    .delete-modal-content p {
        color: #77818b;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .delete-modal-actions {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .delete-cancel {
        background: #eef0f2;
        color: #293747;
        border: none;
        padding: 11px 20px;
        border-radius: 7px;
        cursor: pointer;
    }

    .delete-confirm {
        background: #c0392b;
        color: white;
        border: none;
        padding: 11px 20px;
        border-radius: 7px;
        cursor: pointer;
    }

    .delete-cancel:hover {
        background: #dfe3e8;
    }

    .delete-confirm:hover {
        background: #a93226;
    }

    @media (max-width: 600px) {
        .product-page {
            padding: 20px 14px;
        }

        .product-card {
            padding: 15px;
        }

        .delete-modal-content {
            padding: 25px 18px;
        }
    }
</style>

<div class="product-page">

    <div class="product-header">
        <div>
            <h2>Kelola Produk</h2>
            <p>Kelola katalog produk furnitur PT. TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.products.create') }}"
           class="product-btn-add">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="product-alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="product-alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="product-card">

        <h3>Daftar Produk</h3>

        <div class="product-table-wrap">

            <table class="product-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Unggulan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($products as $product)

                        <tr>

                            <td>
                                {{ $products->firstItem() + $loop->index }}
                            </td>

                            <td>
                                @if($product->image)
                                    <img
                                        src="{{ asset('storage/' . $product->image) }}"
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                    >
                                @else
                                    <div class="product-no-image">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $product->name }}</strong>
                            </td>

                            <td>
                                <span class="product-category">
                                    {{ $product->category->name ?? 'Tanpa Kategori' }}
                                </span>
                            </td>

                            <td>
                                @if($product->price !== null)
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($product->is_featured)
                                    <span class="product-featured">
                                        Unggulan
                                    </span>
                                @else
                                    <span class="product-normal">
                                        Reguler
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="product-actions">

                                    <a
                                        href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.products.destroy', $product->id) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            class="btn-delete"
                                            onclick="openDeleteModal(this)"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="product-empty">
                                <strong>Belum ada produk.</strong>
                                <br>
                                Silakan klik Tambah Produk untuk memasukkan data.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="product-pagination">
            {{ $products->links() }}
        </div>

    </div>

</div>

<!-- POPUP KONFIRMASI HAPUS -->

<div class="delete-modal" id="deleteModal">

    <div class="delete-modal-content">

        <div class="delete-modal-icon">
            !
        </div>

        <h3>Hapus Produk?</h3>

        <p>
            Apakah kamu yakin ingin menghapus produk
            <strong id="deleteProductName"></strong>?
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="delete-modal-actions">

            <button
                type="button"
                class="delete-cancel"
                onclick="closeDeleteModal()"
            >
                Batal
            </button>

            <button
                type="button"
                class="delete-confirm"
                onclick="confirmDelete()"
            >
                Ya, Hapus
            </button>

        </div>

    </div>

</div>

<script>
    let selectedDeleteForm = null;

    function openDeleteModal(button) {
        selectedDeleteForm = button.closest('form');

        const row = button.closest('tr');
        const name = row.querySelector('td:nth-child(3)').innerText.trim();

        document.getElementById('deleteProductName').innerText = name;

        document.getElementById('deleteModal').classList.add('show');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.remove('show');

        selectedDeleteForm = null;
    }

    function confirmDelete() {
        if (selectedDeleteForm) {
            selectedDeleteForm.submit();
        }
    }

    document.getElementById('deleteModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeDeleteModal();
        }
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>

@endsection