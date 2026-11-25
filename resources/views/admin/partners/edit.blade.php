@extends('layouts.app')

@section('content')

<style>
    .partner-edit-page {
        min-height: 85vh;
        padding: 35px;
        background: #f7f5ef;
        color: #293747;
        font-family: Arial, sans-serif;
    }

    .edit-heading {
        margin-bottom: 28px;
    }

    .edit-heading h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .edit-heading p {
        color: #7a8490;
        margin: 0;
        font-size: 14px;
    }

    .edit-wrapper {
        max-width: 950px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(8,39,68,.06);
    }

    .edit-banner {
        background: #082744;
        color: white;
        padding: 25px 30px;
        border-bottom: 4px solid #f5a623;
    }

    .edit-banner h3 {
        margin: 0 0 7px;
        font-size: 19px;
        font-weight: 700;
    }

    .edit-banner p {
        margin: 0;
        color: #d0dce7;
        font-size: 13px;
    }

    .edit-form {
        padding: 30px;
    }

    .edit-section-title {
        color: #082744;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
    }

    .edit-group {
        margin-bottom: 22px;
    }

    .edit-group label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 9px;
        color: #293747;
    }

    .edit-required {
        color: #dc3545;
    }

    .edit-control {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #dfe3e8;
        border-radius: 8px;
        font-size: 14px;
        color: #293747;
        background: #fff;
        box-sizing: border-box;
        transition: .2s;
    }

    .edit-control:focus {
        outline: none;
        border-color: #f5a623;
        box-shadow: 0 0 0 3px rgba(245,166,35,.12);
    }

    textarea.edit-control {
        resize: vertical;
        min-height: 120px;
    }

    .edit-help {
        display: block;
        margin-top: 7px;
        color: #929aa3;
        font-size: 12px;
    }

    .edit-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 6px;
    }

    .current-logo-box {
        padding: 18px;
        border: 1px solid #e8edf2;
        border-radius: 10px;
        background: #fafbfc;
        margin-bottom: 15px;
    }

    .current-logo {
        width: 120px;
        height: 100px;
        object-fit: contain;
        padding: 5px;
        background: white;
        border: 1px solid #eee;
        border-radius: 8px;
        display: block;
        margin-bottom: 10px;
    }

    .no-logo {
        color: #929aa3;
        font-size: 13px;
        padding: 20px 0;
    }

    .new-logo-preview {
        display: none;
        max-width: 130px;
        max-height: 110px;
        object-fit: contain;
        padding: 7px;
        border: 1px solid #eee;
        border-radius: 8px;
        margin-top: 15px;
    }

    .edit-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 17px 20px;
        background: #f8fafc;
        border: 1px solid #e8edf2;
        border-radius: 9px;
        gap: 15px;
    }

    .edit-status strong {
        display: block;
        color: #082744;
        font-size: 14px;
    }

    .edit-status small {
        color: #87919b;
        font-size: 12px;
    }

    .edit-toggle {
        width: 20px;
        height: 20px;
        accent-color: #f5a623;
        cursor: pointer;
    }

    .edit-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #eee;
    }

    .btn-update {
        background: #f5a623;
        color: #082744;
        padding: 12px 23px;
        border-radius: 8px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-update:hover {
        background: #e69a19;
    }

    .btn-cancel {
        background: white;
        color: #536170;
        border: 1px solid #dfe3e8;
        padding: 12px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-cancel:hover {
        background: #f3f4f6;
        color: #082744;
    }

    .edit-validation {
        padding: 15px 18px;
        border-radius: 8px;
        margin-bottom: 22px;
        background: #fff0ef;
        color: #b42318;
        font-size: 13px;
    }

    @media(max-width: 600px) {
        .partner-edit-page {
            padding: 20px 14px;
        }

        .edit-form {
            padding: 20px;
        }

        .edit-banner {
            padding: 22px;
        }

        .edit-actions {
            flex-direction: column;
        }

        .edit-actions a,
        .edit-actions button {
            text-align: center;
        }
    }
</style>

<div class="partner-edit-page">

    <div class="edit-heading">
        <h2>Edit Klien & Mitra</h2>
        <p>Perbarui informasi klien dan mitra PT. TERRAWOOD.</p>
    </div>

    <div class="edit-wrapper">

        <div class="edit-banner">
            <h3>Perbarui Informasi Perusahaan</h3>
            <p>Pastikan informasi yang diperbarui sudah benar sebelum disimpan.</p>
        </div>

        <div class="edit-form">

            @if($errors->any())
                <div class="edit-validation">
                    <strong>Data belum dapat diperbarui.</strong>
                    <ul style="margin:8px 0 0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.partners.update', $partner->id) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="edit-section-title">
                    Informasi Perusahaan
                </div>

                <div class="edit-group">
                    <label>Nama Perusahaan <span class="edit-required">*</span></label>

                    <input
                        type="text"
                        name="name"
                        class="edit-control"
                        value="{{ old('name', $partner->name) }}"
                        placeholder="Masukkan nama perusahaan"
                        required
                    >

                    @error('name')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-group">
                    <label>Jenis Kerja Sama <span class="edit-required">*</span></label>

                    <select name="type" class="edit-control" required>
                        <option value="client"
                            {{ old('type', $partner->type) == 'client' ? 'selected' : '' }}>
                            Klien
                        </option>

                        <option value="partner"
                            {{ old('type', $partner->type) == 'partner' ? 'selected' : '' }}>
                            Mitra
                        </option>
                    </select>

                    @error('type')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-group">
                    <label>Deskripsi Perusahaan</label>

                    <textarea
                        name="description"
                        class="edit-control"
                        placeholder="Tuliskan informasi perusahaan"
                    >{{ old('description', $partner->description) }}</textarea>

                    @error('description')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-section-title" style="margin-top:30px;">
                    Identitas dan Kontak
                </div>

                <div class="edit-group">
                    <label>Logo Saat Ini</label>

                    <div class="current-logo-box">
                        @if($partner->logo)
                            <img
                                src="{{ asset('storage/' . $partner->logo) }}"
                                alt="{{ $partner->name }}"
                                class="current-logo"
                            >
                            <small class="edit-help">
                                Logo yang tersimpan saat ini.
                            </small>
                        @else
                            <div class="no-logo">
                                Belum ada logo yang diunggah.
                            </div>
                        @endif
                    </div>

                    <label>Ganti Logo (Opsional)</label>

                    <input
                        type="file"
                        name="logo"
                        id="editLogo"
                        class="edit-control"
                        accept="image/png,image/jpeg,image/webp"
                    >

                    <small class="edit-help">
                        Format PNG, JPG, atau WebP. Maksimal 2 MB.
                        Kosongkan jika tidak ingin mengganti logo.
                    </small>

                    <img
                        id="editLogoPreview"
                        class="new-logo-preview"
                        alt="Preview logo baru"
                    >

                    @error('logo')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-group">
                    <label>Website Perusahaan</label>

                    <input
                        type="url"
                        name="website"
                        class="edit-control"
                        value="{{ old('website', $partner->website) }}"
                        placeholder="https://www.perusahaan.com"
                    >

                    @error('website')
                        <div class="edit-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="edit-section-title" style="margin-top:30px;">
                    Pengaturan Publikasi
                </div>

                <div class="edit-status">
                    <div>
                        <strong>Status Data</strong>
                        <small>Data aktif dapat ditampilkan pada website publik.</small>
                    </div>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="edit-toggle"
                        {{ old('is_active', $partner->is_active) ? 'checked' : '' }}
                    >
                </div>

                <div class="edit-actions">
                    <a href="{{ route('admin.partners.index') }}"
                       class="btn-cancel">
                        Kembali
                    </a>

                    <button type="submit" class="btn-update">
                        Simpan Perubahan
                    </button>
                </div>

            
            @include('admin.partials.translations', ['translationFields' => ['name' => ['label' => 'Partner name'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => $partner])
        </form>

        </div>
    </div>

</div>

<script>
    document.getElementById('editLogo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('editLogoPreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
            preview.removeAttribute('src');
        }
    });
</script>

@endsection