
@extends('layouts.app')

@section('content')
<style>
    :root {
        --navy: #082744;
        --navy-dark: #061D33;
        --gold: #F5A623;
        --ivory: #F7F5EF;
        --text: #293747;
    }

    .testimonial-page {
        min-height: 100vh;
        padding: 35px;
        background: var(--ivory);
        color: var(--text);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
    }

    .page-header h2 {
        color: var(--navy);
        font-size: 27px;
        font-weight: 800;
        margin: 0 0 7px;
    }

    .page-header p {
        color: #718096;
        margin: 0;
        font-size: 14px;
    }

    .btn-add {
        background: var(--gold);
        color: var(--navy-dark);
        padding: 12px 20px;
        border-radius: 9px;
        text-decoration: none;
        font-weight: 700;
        transition: .2s;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #e99a12;
        color: var(--navy-dark);
        transform: translateY(-2px);
    }

    .table-card {
        background: white;
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 25px rgba(8, 39, 68, .06);
        overflow-x: auto;
    }

    .testimonial-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .testimonial-table th {
        background: var(--navy);
        color: white;
        padding: 15px 13px;
        text-align: left;
        font-size: 13px;
        white-space: nowrap;
    }

    .testimonial-table th:first-child {
        border-radius: 8px 0 0 0;
    }

    .testimonial-table th:last-child {
        border-radius: 0 8px 0 0;
    }

    .testimonial-table td {
        padding: 14px 13px;
        border-bottom: 1px solid #edf0f3;
        font-size: 13px;
        vertical-align: middle;
    }

    .testimonial-table tr:hover td {
        background: #fafbfd;
    }

    .customer-info {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 180px;
    }

    .customer-photo {
        width: 43px;
        height: 43px;
        border-radius: 50%;
        object-fit: cover;
        background: #edf0f3;
        flex-shrink: 0;
    }

    .customer-placeholder {
        width: 43px;
        height: 43px;
        border-radius: 50%;
        background: #edf0f3;
        display: flex;
        justify-content: center;
        align-items: center;
        color: var(--navy);
        font-weight: 800;
        flex-shrink: 0;
    }

    .customer-name {
        font-weight: 800;
        color: var(--navy);
    }

    .customer-email {
        font-size: 11px;
        color: #8994a3;
        margin-top: 3px;
    }

    .rating-stars {
        color: #f5a623;
        white-space: nowrap;
        font-size: 16px;
        letter-spacing: 1px;
    }

    .rating-number {
        color: #718096;
        font-size: 11px;
        margin-left: 4px;
    }

    .testimonial-text {
        max-width: 260px;
        line-height: 1.6;
        color: #64748b;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .status-published {
        background: #dcfce7;
        color: #15803d;
    }

    .status-hidden {
        background: #edf0f3;
        color: #64748b;
    }

    .action-buttons {
        display: flex;
        gap: 7px;
    }

    .btn-edit, .btn-delete {
        border: none;
        padding: 8px 12px;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #e8f1fb;
        color: #1761a0;
    }

    .btn-delete {
        background: #feecec;
        color: #c53030;
    }

    .empty-state {
        text-align: center;
        padding: 45px 15px;
        color: #8994a3;
    }

    .pagination-wrapper {
        margin-top: 20px;
    }

    /* Notifikasi */
    .toast-notification {
        position: fixed;
        top: 25px;
        right: 25px;
        z-index: 10001;
        background: white;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0,0,0,.15);
        display: flex;
        align-items: center;
        gap: 12px;
        min-width: 280px;
        max-width: calc(100% - 40px);
        border-left: 5px solid #16a34a;
        animation: toastIn .3s ease;
    }

    .toast-notification.error {
        border-left-color: #dc3545;
    }

    .toast-icon {
        font-size: 22px;
        font-weight: 800;
        color: #16a34a;
    }

    .toast-notification.error .toast-icon {
        color: #dc3545;
    }

    .toast-title {
        font-weight: 800;
        color: var(--navy);
        font-size: 14px;
    }

    .toast-message {
        font-size: 12px;
        color: #718096;
        margin-top: 3px;
    }

    .toast-close {
        margin-left: auto;
        border: none;
        background: none;
        color: #8994a3;
        cursor: pointer;
        font-size: 19px;
    }

    @keyframes toastIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    /* Modal hapus */
    .delete-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(6, 29, 51, .65);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        padding: 20px;
    }

    .delete-modal.show {
        display: flex;
    }

    .modal-content-custom {
        background: white;
        width: 100%;
        max-width: 420px;
        border-radius: 17px;
        padding: 32px;
        text-align: center;
        box-shadow: 0 15px 50px rgba(0,0,0,.2);
        animation: modalFade .2s ease;
    }

    @keyframes modalFade {
        from { opacity: 0; transform: translateY(12px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .warning-icon {
        width: 65px;
        height: 65px;
        border-radius: 50%;
        background: #fff1dc;
        color: #e99a12;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 30px;
        margin: 0 auto 18px;
    }

    .modal-content-custom h3 {
        color: var(--navy);
        font-size: 21px;
        font-weight: 800;
        margin-bottom: 10px;
    }

    .modal-content-custom p {
        color: #718096;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .delete-name {
        color: var(--navy);
        font-weight: 800;
    }

    .modal-actions {
        display: flex;
        gap: 10px;
    }

    .btn-cancel, .btn-confirm-delete {
        flex: 1;
        padding: 12px;
        border: none;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-cancel {
        background: #edf0f3;
        color: #475569;
    }

    .btn-confirm-delete {
        background: #dc3545;
        color: white;
    }

    @media(max-width: 768px) {
        .testimonial-page {
            padding: 20px 14px;
        }

        .page-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .modal-content-custom {
            padding: 25px 20px;
        }

        .toast-notification {
            top: 12px;
            right: 12px;
        }
    }
</style>

<div class="testimonial-page">

    <div class="page-header">
        <div>
            <h2>Rating & Testimoni Customer</h2>
            <p>Kelola penilaian dan pengalaman pelanggan TERRAWOOD.</p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="btn-add">
            + Tambah Testimoni
        </a>
    </div>

    <div class="table-card">
        <table class="testimonial-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Customer</th>
                    <th>Rating</th>
                    <th>Testimoni</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($testimonials as $testimonial)
                    <tr>
                        <td>
                            {{ $loop->iteration + ($testimonials->currentPage() - 1) * $testimonials->perPage() }}
                        </td>

                        <td>
                            <div class="customer-info">
                                @if($testimonial->customer_photo)
                                    <img
                                        src="{{ asset('storage/' . $testimonial->customer_photo) }}"
                                        class="customer-photo"
                                        alt="{{ $testimonial->customer_name }}"
                                    >
                                @else
                                    <div class="customer-placeholder">
                                        {{ strtoupper(substr($testimonial->customer_name, 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <div class="customer-name">
                                        {{ $testimonial->customer_name }}
                                    </div>
                                    <div class="customer-email">
                                        {{ $testimonial->customer_email ?: 'Tidak ada email' }}
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $testimonial->rating ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="rating-number">
                                ({{ $testimonial->rating }}/5)
                            </span>
                        </td>

                        <td>
                            <div class="testimonial-text">
                                {{ \Illuminate\Support\Str::limit($testimonial->testimonial, 85) }}
                            </div>
                        </td>

                        <td>
                            @if($testimonial->is_published)
                                <span class="status-badge status-published">
                                    Ditampilkan
                                </span>
                            @else
                                <span class="status-badge status-hidden">
                                    Disembunyikan
                                </span>
                            @endif
                        </td>

                        <td>{{ $testimonial->created_at->format('d/m/Y') }}</td>

                        <td>
                            <div class="action-buttons">
                                <a
                                    href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                    class="btn-edit"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.testimonials.destroy', $testimonial->id) }}"
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
                        <td colspan="7">
                            <div class="empty-state">
                                <h3>Belum Ada Testimoni</h3>
                                <p>Tambahkan testimoni customer untuk mulai mengelola ulasan.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pagination-wrapper">
            {{ $testimonials->links() }}
        </div>
    </div>
</div>

<!-- Popup Notifikasi -->
@if(session('success') || session('error'))
    <div class="toast-notification {{ session('error') ? 'error' : '' }}" id="toastNotification">
        <div class="toast-icon">
            {{ session('error') ? '!' : '✓' }}
        </div>

        <div>
            <div class="toast-title">
                {{ session('error') ? 'Terjadi Kesalahan' : 'Berhasil!' }}
            </div>
            <div class="toast-message">
                {{ session('error') ?? session('success') }}
            </div>
        </div>

        <button type="button" class="toast-close" onclick="closeToast()">
            &times;
        </button>
    </div>
@endif

<!-- Popup Konfirmasi Hapus -->
<div class="delete-modal" id="deleteModal">
    <div class="modal-content-custom">
        <div class="warning-icon">!</div>

        <h3>Hapus Testimoni?</h3>

        <p>
            Apakah kamu yakin ingin menghapus testimoni dari
            <span class="delete-name" id="deleteCustomerName"></span>?
            Data yang sudah dihapus tidak dapat dikembalikan.
        </p>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeDeleteModal()">
                Batal
            </button>

            <button type="button" class="btn-confirm-delete" onclick="confirmDelete()">
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
        const customerName = row.querySelector('td:nth-child(2) .customer-name').innerText.trim();

        document.getElementById('deleteCustomerName').innerText = customerName;
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

    function closeToast() {
        const toast = document.getElementById('toastNotification');
        if (toast) toast.remove();
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeDeleteModal();
            closeToast();
        }
    });

    const toast = document.getElementById('toastNotification');

    if (toast) {
        setTimeout(() => {
            toast.remove();
        }, 4000);
    }
</script>
@endsection