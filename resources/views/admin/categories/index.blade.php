@extends('layouts.app')

@section('content')

<style>
    .category-page {
        padding: 35px;
        min-height: 80vh;
        background: #f7f5ef;
        color: #293747;
        font-family: Arial, sans-serif;
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .category-header h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .category-header p {
        color: #777;
        margin: 0;
    }

    .category-btn-add {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        background: #f5a623;
        color: #082744;
        font-weight: 700;
        text-decoration: none;
    }

    .category-btn-add:hover {
        background: #e69a19;
        color: #082744;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .category-card h3 {
        color: #082744;
        font-size: 18px;
        margin: 0 0 20px;
    }

    .category-table-wrap {
        overflow-x: auto;
    }

    .category-table {
        width: 100%;
        min-width: 650px;
        border-collapse: collapse;
    }

    .category-table th {
        background: #082744;
        color: white;
        padding: 15px 12px;
        text-align: left;
        font-size: 13px;
    }

    .category-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    .category-table tr:hover td {
        background: #faf9f5;
    }

    .category-count {
        display: inline-block;
        background: #e6efff;
        color: #2455a5;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .category-actions {
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

    .category-alert {
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

    .category-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #888;
    }

    .category-pagination {
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
        .category-page {
            padding: 20px 14px;
        }

        .category-card {
            padding: 15px;
        }

        .delete-modal-content {
            padding: 25px 18px;
        }
    }
</style>

<div class="category-page">

    <div class="category-header">
        <div>
            <h2>Kelola Kategori</h2>
            <p>Kelola kategori produk furnitur TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
           class="category-btn-add">
            + Tambah Kategori
        </a>
    </div>

    @if(session('success'))
        <div class="category-alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="category-alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="category-card">

        <h3>Daftar Kategori Produk</h3>

        <div class="category-table-wrap">

            <table class="category-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Jumlah Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($categories as $category)

                        <tr>

                            <td>
                                {{ $categories->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <div style="display:flex;align-items:center;gap:12px;">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}"
                                             alt="{{ $category->name }}"
                                             style="width:56px;height:42px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                                    @else
                                        <span title="Belum ada foto" style="width:56px;height:42px;border-radius:6px;background:#eef1f5;color:#9aa5b1;display:inline-flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0;">Tanpa foto</span>
                                    @endif
                                    <strong>{{ $category->name }}</strong>
                                </div>
                            </td>

                            <td>
                                {{ $category->description ?: '-' }}
                            </td>

                            <td>
                                <span class="category-count">
                                    {{ $category->products_count ?? $category->products()->count() }}
                                    Produk
                                </span>
                            </td>

                            <td>
                                <div class="category-actions">

                                    <a
                                        href="{{ route('admin.categories.edit', $category->id) }}"
                                        class="btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.categories.destroy', $category->id) }}"
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
                            <td colspan="5" class="category-empty">
                                <strong>Belum ada kategori produk.</strong>
                                <br>
                                Silakan klik Tambah Kategori untuk memasukkan data.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="category-pagination">
            {{ $categories->links() }}
        </div>

    </div>

</div>

<!-- POPUP KONFIRMASI HAPUS -->

<div class="delete-modal" id="deleteModal">

    <div class="delete-modal-content">

        <div class="delete-modal-icon">
            !
        </div>

        <h3>Hapus Kategori?</h3>

        <p>
            Apakah kamu yakin ingin menghapus kategori
            <strong id="deleteCategoryName"></strong>?
            Kategori yang masih memiliki produk mungkin tidak dapat dihapus.
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
        const name = row.querySelector('td:nth-child(2)').innerText.trim();

        document.getElementById('deleteCategoryName').innerText = name;

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
