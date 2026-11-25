@extends('layouts.app')

@section('content')

<style>
    .partner-create-page {
        min-height: 85vh;
        padding: 35px;
        background: #f7f5ef;
        font-family: Arial, sans-serif;
        color: #293747;
    }

    .create-heading {
        margin-bottom: 28px;
    }

    .create-heading h2 {
        color: #082744;
        font-size: 28px;
        font-weight: 800;
        margin: 0 0 8px;
    }

    .create-heading p {
        color: #7a8490;
        margin: 0;
        font-size: 14px;
    }

    .create-wrapper {
        max-width: 950px;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 25px rgba(8,39,68,.06);
    }

    .create-banner {
        background: #082744;
        color: white;
        padding: 25px 30px;
        border-bottom: 4px solid #f5a623;
    }

    .create-banner h3 {
        margin: 0 0 7px;
        font-size: 19px;
        font-weight: 700;
    }

    .create-banner p {
        margin: 0;
        color: #d0dce7;
        font-size: 13px;
    }

    .create-form {
        padding: 30px;
    }

    .form-section-title {
        color: #082744;
        font-size: 15px;
        font-weight: 700;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 1px solid #eee;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 14px;
        margin-bottom: 9px;
        color: #293747;
    }

    .required {
        color: #dc3545;
    }

    .form-control-custom {
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

    .form-control-custom:focus {
        outline: none;
        border-color: #f5a623;
        box-shadow: 0 0 0 3px rgba(245,166,35,.12);
    }

    textarea.form-control-custom {
        resize: vertical;
        min-height: 120px;
    }

    .form-help {
        display: block;
        margin-top: 7px;
        color: #929aa3;
        font-size: 12px;
    }

    .form-error {
        color: #dc3545;
        font-size: 12px;
        margin-top: 6px;
    }

    .logo-upload {
        padding: 20px;
        border: 1px dashed #cbd3dc;
        background: #fafbfc;
        border-radius: 10px;
    }

    .logo-upload input {
        width: 100%;
        font-size: 13px;
    }

    .logo-preview {
        display: none;
        margin-top: 15px;
        max-width: 130px;
        max-height: 110px;
        object-fit: contain;
        padding: 7px;
        border: 1px solid #eee;
        border-radius: 8px;
        background: white;
    }

    .status-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 17px 20px;
        background: #f8fafc;
        border: 1px solid #e8edf2;
        border-radius: 9px;
        gap: 15px;
    }

    .status-box strong {
        display: block;
        color: #082744;
        font-size: 14px;
    }

    .status-box small {
        color: #87919b;
        font-size: 12px;
    }

    .status-toggle {
        width: 20px;
        height: 20px;
        accent-color: #f5a623;
        cursor: pointer;
    }

    .create-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #eee;
    }

    .btn-save {
        background: #f5a623;
        color: #082744;
        padding: 12px 23px;
        border-radius: 8px;
        border: none;
        font-weight: 700;
        cursor: pointer;
        text-decoration: none;
        font-size: 14px;
    }

    .btn-save:hover {
        background: #e69a19;
        color: #082744;
    }

    .btn-back {
        background: white;
        color: #536170;
        border: 1px solid #dfe3e8;
        padding: 12px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
    }

    .btn-back:hover {
        background: #f3f4f6;
        color: #082744;
    }

    .validation-alert {
        padding: 15px 18px;
        border-radius: 8px;
        margin-bottom: 22px;
        background: #fff0ef;
        color: #b42318;
        font-size: 13px;
    }

    @media(max-width: 600px) {
        .partner-create-page {
            padding: 20px 14px;
        }

        .create-form {
            padding: 20px;
        }

        .create-banner {
            padding: 22px;
        }

        .create-actions {
            flex-direction: column;
        }

        .create-actions a,
        .create-actions button {
            text-align: center;
        }
    }
</style>

<div class="partner-create-page">

    <div class="create-heading">
        <h2>Tambah Klien & Mitra</h2>
        <p>Tambahkan informasi perusahaan yang bekerja sama dengan TERRAWOOD.</p>
    </div>

    <div class="create-wrapper">

        <div class="create-banner">
            <h3>Informasi Klien & Mitra</h3>
            <p>Lengkapi formulir berikut untuk menyimpan data baru.</p>
        </div>

        <div class="create-form">

            @if($errors->any())
                <div class="validation-alert">
                    <strong>Data belum dapat disimpan.</strong>
                    <ul style="margin:8px 0 0; padding-left:20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.partners.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="form-section-title">
                    Informasi Perusahaan
                </div>

                <div class="form-group">
                    <label>Nama Perusahaan <span class="required">*</span></label>
                    <input
                        type="text"
                        name="name"
                        class="form-control-custom"
                        value="{{ old('name') }}"
                        placeholder="Contoh: PT. Nama Perusahaan"
                        required
                    >
                    @error('name')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Kerja Sama <span class="required">*</span></label>
                    <select name="type" class="form-control-custom" required>
                        <option value="">Pilih jenis data</option>
                        <option value="client" {{ old('type') == 'client' ? 'selected' : '' }}>
                            Klien
                        </option>
                        <option value="partner" {{ old('type') == 'partner' ? 'selected' : '' }}>
                            Mitra
                        </option>
                    </select>
                    @error('type')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Deskripsi Perusahaan</label>
                    <textarea
                        name="description"
                        class="form-control-custom"
                        placeholder="Tuliskan informasi singkat mengenai perusahaan atau bentuk kerja sama..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-section-title" style="margin-top:30px;">
                    Identitas dan Kontak
                </div>

                <div class="form-group">
                    <label>Logo Perusahaan</label>

                    <div class="logo-upload">
                        <input
                            type="file"
                            name="logo"
                            id="logo"
                            accept="image/png,image/jpeg,image/webp"
                        >

                        <small class="form-help">
                            Format PNG, JPG, atau WebP. Maksimal ukuran 2 MB.
                        </small>

                        <img id="logoPreview" class="logo-preview" alt="Preview logo">
                    </div>

                    @error('logo')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Website Perusahaan</label>
                    <input
                        type="url"
                        name="website"
                        class="form-control-custom"
                        value="{{ old('website') }}"
                        placeholder="https://www.perusahaan.com"
                    >
                    @error('website')
                        <div class="form-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-section-title" style="margin-top:30px;">
                    Pengaturan Publikasi
                </div>

                <div class="status-box">
                    <div>
                        <strong>Status Data</strong>
                        <small>Jika aktif, data dapat ditampilkan pada website publik.</small>
                    </div>

                    <input
                        type="checkbox"
                        name="is_active"
                        value="1"
                        class="status-toggle"
                        {{ old('is_active', '1') ? 'checked' : '' }}
                    >
                </div>

                <div class="create-actions">
                    <a href="{{ route('admin.partners.index') }}"
                       class="btn-back">
                        Kembali
                    </a>

                    <button type="submit" class="btn-save">
                        Simpan Data
                    </button>
                </div>

            
            @include('admin.partials.translations', ['translationFields' => ['name' => ['label' => 'Partner name'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => null])
        </form>

        </div>
    </div>

</div>

<script>
    document.getElementById('logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logoPreview');

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>

@endsection