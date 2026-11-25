@extends('layouts.app')

@section('content')

<style>
    .article-page {
        padding: 35px;
        min-height: 80vh;
        background: #f7f5ef;
        color: #293747;
        font-family: Arial, sans-serif;
    }

    .article-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 28px;
    }

    .article-header h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .article-header p {
        color: #777;
        margin: 0;
    }

    .article-btn-add {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        background: #f5a623;
        color: #082744;
        font-weight: 700;
        text-decoration: none;
    }

    .article-btn-add:hover {
        background: #e69a19;
        color: #082744;
    }

    .article-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .article-card h3 {
        color: #082744;
        font-size: 18px;
        margin: 0 0 20px;
    }

    .article-table-wrap {
        overflow-x: auto;
    }

    .article-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .article-table th {
        background: #082744;
        color: white;
        padding: 15px 12px;
        text-align: left;
        font-size: 13px;
    }

    .article-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        vertical-align: middle;
    }

    .article-table tr:hover td {
        background: #faf9f5;
    }

    .article-image {
        width: 75px;
        height: 60px;
        object-fit: cover;
        border-radius: 7px;
        border: 1px solid #eee;
    }

    .article-no-image {
        width: 75px;
        height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f1f1;
        color: #888;
        border-radius: 7px;
        font-size: 11px;
    }

    .article-category {
        display: inline-block;
        background: #e6efff;
        color: #2455a5;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
    }

    .article-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-published {
        background: #e3f7eb;
        color: #20834a;
    }

    .badge-draft {
        background: #fff1d6;
        color: #956000;
    }

    .article-actions {
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

    .article-alert {
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

    .article-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #888;
    }

    .article-pagination {
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
        .article-page {
            padding: 20px 14px;
        }

        .article-card {
            padding: 15px;
        }

        .delete-modal-content {
            padding: 25px 18px;
        }
    }
</style>

<div class="article-page">

    <div class="article-header">
        <div>
            <h2>Kelola Artikel</h2>
            <p>Kelola artikel dan informasi terbaru TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.articles.create') }}"
           class="article-btn-add">
            + Tambah Artikel
        </a>
    </div>

    @if(session('success'))
        <div class="article-alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="article-alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="article-card">

        <h3>Daftar Artikel</h3>

        <div class="article-table-wrap">

            <table class="article-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Judul Artikel</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal Publikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($articles as $article)

                        <tr>

                            <td>
                                {{ $articles->firstItem() + $loop->index }}
                            </td>

                            <td>
                                @if($article->image)
                                    <img
                                        src="{{ asset('storage/' . $article->image) }}"
                                        alt="{{ $article->title }}"
                                        class="article-image"
                                    >
                                @else
                                    <div class="article-no-image">
                                        No Image
                                    </div>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $article->title }}</strong>
                            </td>

                            <td>
                                <span class="article-category">
                                    {{ $article->category ?: 'Umum' }}
                                </span>
                            </td>

                            <td>
                                @if($article->is_published)
                                    <span class="article-badge badge-published">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="article-badge badge-draft">
                                        Draft
                                    </span>
                                @endif
                            </td>

                            <td>
                                {{ $article->published_at ? $article->published_at->format('d/m/Y') : '-' }}
                            </td>

                            <td>
                                <div class="article-actions">

                                    <a
                                        href="{{ route('admin.articles.edit', $article->id) }}"
                                        class="btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.articles.destroy', $article->id) }}"
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
                            <td colspan="7" class="article-empty">
                                <strong>Belum ada artikel.</strong>
                                <br>
                                Silakan klik Tambah Artikel untuk memasukkan data.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="article-pagination">
            {{ $articles->links() }}
        </div>

    </div>

</div>

<!-- POPUP KONFIRMASI HAPUS -->

<div class="delete-modal" id="deleteModal">

    <div class="delete-modal-content">

        <div class="delete-modal-icon">
            !
        </div>

        <h3>Hapus Artikel?</h3>

        <p>
            Apakah kamu yakin ingin menghapus artikel
            <strong id="deleteArticleName"></strong>?
            Artikel yang sudah dihapus tidak dapat dikembalikan.
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

        document.getElementById('deleteArticleName').innerText = name;

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
