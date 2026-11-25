@extends('layouts.app')

@section('content')

<div style="max-width: 800px; margin: 45px auto; padding: 25px;">

    <h2 style="color: #082744;">Tambah Kategori</h2>
    <p style="color: #777; margin-bottom: 25px;">
        Tambahkan kategori produk furnitur dan dekorasi TERRAWOOD.
    </p>

    <div style="background: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,.06);">

        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Nama Kategori
                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Contoh: Rak"
                       required
                       style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 7px; box-sizing: border-box;">

                @error('name')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Deskripsi Kategori
                </label>

                <textarea name="description"
                          rows="5"
                          placeholder="Masukkan deskripsi kategori..."
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 7px; box-sizing: border-box;">{{ old('description') }}</textarea>

                @error('description')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-bottom: 25px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">
                    Foto Kategori (Opsional)
                </label>
                <input type="file"
                       name="image"
                       accept="image/*"
                       style="display: block; margin-top: 6px;">
                <small style="color: #777; display: block; margin-top: 6px;">
                    Foto ini tampil di bagian "Belanja Berdasarkan Kategori" di beranda. Jika kosong, kartu kategori tampil polos tanpa foto. Disarankan rasio 4:3, maks. 2 MB.
                </small>
                @error('image')
                    <small style="color: red;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit"
                        style="background: #F5A623; color: #082744; padding: 12px 22px; border: none; border-radius: 7px; font-weight: bold; cursor: pointer;">
                    Simpan Kategori
                </button>

                <a href="{{ route('admin.categories.index') }}"
                   style="background: #eee; color: #333; padding: 12px 22px; border-radius: 7px; text-decoration: none;">
                    Kembali
                </a>
            </div>

        
            @include('admin.partials.translations', ['translationFields' => ['name' => ['label' => 'Category name'], 'description' => ['label' => 'Description', 'type' => 'textarea']], 'translationRecord' => null])
        </form>
    </div>
</div>

@endsection