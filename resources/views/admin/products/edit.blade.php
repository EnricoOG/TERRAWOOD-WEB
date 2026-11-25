@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 850px; margin: 50px auto; padding: 30px; background: #fff; border-radius: 14px; box-shadow: 0 5px 25px rgba(0,0,0,.08);">

    <h2 style="color: #082744; margin-bottom: 25px;">
        Edit Produk
    </h2>

    @if ($errors->any())
        <div style="background: #ffe5e5; color: #a40000; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <ul style="margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div style="margin-bottom: 18px;">
            <label>Nama Produk</label>
            <input type="text" name="name"
                   value="{{ old('name', $product->name) }}"
                   required
                   style="width: 100%; padding: 12px; margin-top: 7px; border: 1px solid #ddd; border-radius: 7px;">
        </div>

        <div style="margin-bottom: 18px;">
            <label>Kategori</label>
            <select name="category_id" required
                    style="width: 100%; padding: 12px; margin-top: 7px; border: 1px solid #ddd; border-radius: 7px;">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 18px;">
            <label>Harga Produk (Rp)</label>
            <input type="number" name="price"
                   value="{{ old('price', $product->price) }}"
                   min="0" required
                   style="width: 100%; padding: 12px; margin-top: 7px; border: 1px solid #ddd; border-radius: 7px;">
        </div>

        <div style="margin-bottom: 18px;">
            <label>Harga Diskon (Rp) — Opsional</label>
            <input type="number" name="discount_price"
                   value="{{ old('discount_price', $product->discount_price) }}"
                   min="0" max="{{ old('price', $product->price) }}"
                   placeholder="Kosongkan jika tidak ada diskon"
                   style="width: 100%; padding: 12px; margin-top: 7px; border: 1px solid #ddd; border-radius: 7px;">
            @error('discount_price')
                <div style="color:#b42318;margin-top:6px;">{{ $message }}</div>
            @enderror
            <small>Harga diskon harus lebih rendah daripada harga normal.</small>
        </div>

        <div style="margin-bottom: 18px;">
            <label>Deskripsi</label>
            <textarea name="description" rows="5"
                      style="width: 100%; padding: 12px; margin-top: 7px; border: 1px solid #ddd; border-radius: 7px;">{{ old('description', $product->description) }}</textarea>
        </div>

        <div style="margin-bottom: 18px;">
            <label>Gambar Produk Saat Ini</label><br>

            @if ($product->image)
                <img src="{{ asset('storage/' . $product->image) }}"
                     alt="{{ $product->name }}"
                     style="width: 150px; height: 120px; object-fit: cover; border-radius: 8px; margin-top: 10px;">
            @else
                <p>Belum ada gambar.</p>
            @endif
        </div>

        <div style="margin-bottom: 18px;">
            <label>Ganti Gambar (Opsional)</label>
            <input type="file" name="image" accept="image/*"
                   style="display: block; margin-top: 10px;">
        </div>

        <div style="margin-bottom: 25px;">
            <label>
                <input type="checkbox" name="is_featured" value="1"
                    {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                Jadikan Produk Unggulan
            </label>
        </div>

        <button type="submit"
                style="background: #082744; color: white; padding: 12px 25px; border: none; border-radius: 7px; cursor: pointer;">
            Simpan Perubahan
        </button>

        <a href="{{ route('admin.products.index') }}"
           style="margin-left: 12px; color: #082744; text-decoration: none;">
            Kembali
        </a>

    
            @include('admin.partials.translations', ['translationFields' => ['name' => ['label' => 'Product name'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => $product])
        </form>
</div>
@endsection