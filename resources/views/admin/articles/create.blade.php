<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel - TERRAWOOD</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F7F5EF;
            color: #293747;
            padding: 35px;
        }

        .container {
            max-width: 850px;
            margin: auto;
        }

        .header {
            margin-bottom: 25px;
        }

        .header h1 {
            color: #082744;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .header p {
            color: #777;
            font-size: 14px;
        }

        .form-card {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.04);
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 9px;
            color: #082744;
        }

        input, textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ddd;
            border-radius: 7px;
            font-family: inherit;
            font-size: 14px;
            outline: none;
        }

        input:focus, textarea:focus {
            border-color: #F5A623;
        }

        textarea {
            resize: vertical;
            min-height: 120px;
        }

        input[type="file"] {
            background: #FAFAFA;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .checkbox-group input {
            width: auto;
        }

        .checkbox-group label {
            margin: 0;
            font-weight: 500;
        }

        .error {
            color: #C62828;
            font-size: 12px;
            margin-top: 6px;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 20px;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-save {
            background: #F5A623;
            color: #082744;
        }

        .btn-save:hover {
            background: #FFA43A;
        }

        .btn-back {
            background: #EAEAEA;
            color: #293747;
        }

        @media (max-width: 600px) {
            body {
                padding: 18px;
            }

            .form-card {
                padding: 20px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <div class="header">
        <h1>Tambah Artikel</h1>
        <p>Tambahkan artikel atau informasi terbaru untuk website TERRAWOOD.</p>
    </div>

    <div class="form-card">

        <form action="{{ route('admin.articles.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="title">Judul Artikel</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Masukkan judul artikel"
                    required
                >
                @error('title')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Kategori Artikel</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category') }}"
                    placeholder="Contoh: Tips Furnitur, Dekorasi, Interior"
                >
                @error('category')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="excerpt">Ringkasan Artikel</label>
                <textarea
                    id="excerpt"
                    name="excerpt"
                    placeholder="Tuliskan ringkasan singkat artikel..."
                >{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Isi Artikel</label>
                <textarea
                    id="content"
                    name="content"
                    placeholder="Tuliskan isi lengkap artikel..."
                    required
                    style="min-height: 220px;"
                >{{ old('content') }}</textarea>
                @error('content')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Gambar Artikel</label>
                <input
                    type="file"
                    id="image"
                    name="image"
                    accept="image/*"
                >
                <small style="display:block; margin-top:7px; color:#888;">
                    Format gambar: JPG, PNG, atau WEBP. Maksimal 2 MB.
                </small>
                @error('image')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="is_published"
                        name="is_published"
                        value="1"
                        {{ old('is_published') ? 'checked' : '' }}
                    >
                    <label for="is_published">
                        Publikasikan artikel sekarang
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-save">
                    Simpan Artikel
                </button>

                <a href="{{ route('admin.articles.index') }}"
                   class="btn btn-back">
                    Kembali
                </a>
            </div>

        
            @include('admin.partials.translations', ['translationFields' => ['title' => ['label' => 'Article title'], 'category' => ['label' => 'Category'], 'excerpt' => ['label' => 'Excerpt', 'type' => 'textarea'], 'content' => ['label' => 'Article content', 'type' => 'textarea']], 'translationRecord' => null])
        </form>

    </div>

</div>

</body>
</html>
