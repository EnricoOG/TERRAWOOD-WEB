@extends('layouts.app')

@section('content')

<style>
    .product-form-page {
        background: #F7F5EF;
        min-height: 85vh;
        padding: 50px 7%;
        font-family: 'Inter', sans-serif;
    }

    .form-card {
        background: white;
        max-width: 850px;
        margin: auto;
        padding: 35px;
        border-radius: 15px;
        box-shadow: 0 5px 25px rgba(8,39,68,0.06);
    }

    .form-card h1 {
        color: #082744;
        font-family: 'Manrope', sans-serif;
        font-size: 28px;
        margin-bottom: 8px;
    }

    .form-description {
        color: #718096;
        margin-bottom: 30px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        color: #293747;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        width: 100%;
        padding: 13px 15px;
        border: 1px solid #DCE2E8;
        border-radius: 8px;
        font-family: 'Inter', sans-serif;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-group textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #F5A623;
    }

    .featured-option {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 25px;
        color: #293747;
    }

    .featured-option input {
        width: 17px;
        height: 17px;
        accent-color: #F5A623;
    }

    .form-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-save {
        background: #082744;
        color: white;
        border: none;
        padding: 13px 25px;
        border-radius: 8px;
        font-weight: 700;
        cursor: pointer;
    }

    .btn-back {
        background: #EDF0F3;
        color: #293747;
        padding: 13px 25px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
    }

    .error-text {
        color: #DC3545;
        font-size: 13px;
        margin-top: 6px;
    }
</style>

<div class="product-form-page">

    <div class="form-card">

        <h1>Tambah Produk</h1>

        <p class="form-description">
            Masukkan informasi produk furnitur dan dekorasi TERRAWOOD.
        </p>

        @if($errors->any())
            <div style="background:#FDE8E8; padding:15px; border-radius:8px; margin-bottom:20px; color:#B42318;">
                Periksa kembali data produk yang kamu masukkan.
            </div>
        @endif

        <form
            action="{{ route('admin.products.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label>Nama Produk</label>
                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Sofa Minimalis Modern"
                    required
                >
                @error('name')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Kategori Produk</label>
                <select name="category_id" required>
                    <option value="">-- Pilih Kategori --</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Harga Produk (Rp)</label>
                <input
                    type="number"
                    name="price"
                    value="{{ old('price') }}"
                    min="0"
                    placeholder="Contoh: 2500000"
                    required
                >
                @error('price')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>Harga Diskon (Rp) — Opsional</label>
                <input type="number" name="discount_price" value="{{ old('discount_price') }}"
                       min="0" max="{{ old('price') }}" placeholder="Kosongkan jika tidak ada diskon">
                @error('discount_price')
                    <div class="error-text">{{ $message }}</div>
                @enderror
                <small>Harga diskon harus lebih rendah daripada harga normal.</small>
            </div>

            <div class="form-group">
                <label>Deskripsi Produk</label>
                <textarea
                    name="description"
                    placeholder="Jelaskan bahan, ukuran, warna, dan keunggulan produk..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>Foto Produk</label>
                <input
                    type="file"
                    name="image"
                    accept="image/*"
                >
                <small style="color:#718096">
                    Format gambar JPG, PNG, atau WEBP. Maksimal 2 MB.
                </small>
                @error('image')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <label class="featured-option">
                <input
                    type="checkbox"
                    name="is_featured"
                    value="1"
                    {{ old('is_featured') ? 'checked' : '' }}
                >
                Jadikan sebagai produk unggulan
            </label>

            <div class="form-actions">
                <button type="submit" class="btn-save">
                    Simpan Produk
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="btn-back"
                >
                    Kembali
                </a>
            </div>

        
            @include('admin.partials.translations', ['translationFields' => ['name' => ['label' => 'Product name'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => null])
        </form>

    </div>

</div>

@endsection