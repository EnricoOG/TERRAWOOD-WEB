@extends('layouts.app')

@section('content')

<style>
    .partner-page {
        padding: 35px;
        color: #293747;
        min-height: 80vh;
        background: #f7f5ef;
        font-family: Arial, sans-serif;
    }

    .partner-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        flex-wrap: wrap;
    }

    .partner-header h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 700;
        margin: 0 0 8px;
    }

    .partner-header p {
        color: #777;
        margin: 0;
    }

    .partner-btn {
        display: inline-block;
        padding: 11px 20px;
        border-radius: 7px;
        background: #f5a623;
        color: #082744;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .partner-btn:hover {
        background: #e69a19;
        color: #082744;
    }

    .partner-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 4px 18px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .partner-card h3 {
        color: #082744;
        font-size: 18px;
        margin: 0 0 20px;
    }

    .partner-table-wrap {
        overflow-x: auto;
    }

    .partner-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 750px;
    }

    .partner-table th {
        background: #082744;
        color: white;
        padding: 15px 12px;
        text-align: left;
        font-size: 13px;
    }

    .partner-table td {
        padding: 15px 12px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
    }

    .partner-table tr:hover td {
        background: #faf9f5;
    }

    .partner-logo {
        width: 55px;
        height: 55px;
        object-fit: contain;
        border-radius: 7px;
        border: 1px solid #eee;
        padding: 4px;
    }

    .partner-badge {
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-client {
        background: #e6efff;
        color: #2455a5;
    }

    .badge-partner {
        background: #fff1d6;
        color: #956000;
    }

    .badge-active {
        background: #e3f7eb;
        color: #20834a;
    }

    .badge-inactive {
        background: #eee;
        color: #666;
    }

    .partner-action {
        display: flex;
        gap: 7px;
    }

    .partner-action a,
    .partner-action button {
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

    .partner-alert {
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

    .partner-empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #888;
    }

    .partner-pagination {
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
        .partner-page {
            padding: 20px 14px;
        }

        .partner-card {
            padding: 15px;
        }

        .delete-modal-content {
            padding: 25px 18px;
        }
    }
</style>

<div class="partner-page">

    <div class="partner-header">
        <div>
            <h2>Klien & Mitra</h2>
            <p>Kelola informasi klien dan mitra PT. TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.partners.create') }}"
           class="partner-btn">
            + Tambah Data
        </a>
    </div>

    @if(session('success'))
        <div class="partner-alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="partner-alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="partner-card">

        <h3>Daftar Klien dan Mitra</h3>

        <div class="partner-table-wrap">
            <table class="partner-table">

                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Logo</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Website</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($partners as $partner)
                        <tr>

                            <td>
                                {{ $partners->firstItem() + $loop->index }}
                            </td>

                            <td>
                                @if($partner->logo)
                                    <img
                                        src="{{ asset('storage/' . $partner->logo) }}"
                                        alt="{{ $partner->name }}"
                                        class="partner-logo"
                                    >
                                @else
                                    <span>-</span>
                                @endif
                            </td>

                            <td>
                                <strong>{{ $partner->name }}</strong>
                            </td>

                            <td>
                                @if($partner->type === 'client')
                                    <span class="partner-badge badge-client">
                                        Klien
                                    </span>
                                @else
                                    <span class="partner-badge badge-partner">
                                        Mitra
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if($partner->website)
                                    <a href="{{ $partner->website }}"
                                       target="_blank"
                                       rel="noopener noreferrer">
                                        Kunjungi Website
                                    </a>
                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                @if($partner->is_active)
                                    <span class="partner-badge badge-active">
                                        Aktif
                                    </span>
                                @else
                                    <span class="partner-badge badge-inactive">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="partner-action">

                                    <a
                                        href="{{ route('admin.partners.edit', $partner->id) }}"
                                        class="btn-edit"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('admin.partners.destroy', $partner->id) }}"
                                        method="POST"
                                        class="form-hapus"
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
                            <td colspan="7" class="partner-empty">
                                <strong>Belum ada data klien atau mitra.</strong>
                                <br>
                                Silakan klik Tambah Data untuk memasukkan data baru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="partner-pagination">
            {{ $partners->links() }}
        </div>

    </div>

</div>

<!-- POPUP KONFIRMASI HAPUS -->

<div class="delete-modal" id="deleteModal">

    <div class="delete-modal-content">

        <div class="delete-modal-icon">
            !
        </div>

        <h3>Hapus Data?</h3>

        <p>
            Apakah kamu yakin ingin menghapus data
            <strong id="deletePartnerName"></strong>?
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

        document.getElementById('deletePartnerName').innerText = name;

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
