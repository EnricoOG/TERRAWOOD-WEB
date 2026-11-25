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
        background: var(--ivory);
        padding: 35px;
    }

    .page-heading {
        margin-bottom: 25px;
    }

    .page-heading h2 {
        color: var(--navy);
        font-size: 27px;
        font-weight: 800;
        margin: 0 0 7px;
    }

    .page-heading p {
        color: #718096;
        font-size: 14px;
        margin: 0;
    }

    .back-link {
        display: inline-block;
        margin-bottom: 18px;
        color: var(--navy);
        text-decoration: none;
        font-size: 13px;
        font-weight: 700;
    }

    .back-link:hover {
        color: #c5830d;
    }

    .form-card {
        max-width: 850px;
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 5px 25px rgba(8,39,68,.06);
    }

    .form-section-title {
        font-size: 17px;
        color: var(--navy);
        font-weight: 800;
        margin: 0 0 22px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group.full {
        grid-column: 1 / -1;
    }

    .form-label {
        display: block;
        color: var(--navy);
        font-weight: 700;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .required {
        color: #dc3545;
    }

    .form-control-custom {
        width: 100%;
        border: 1px solid #dce2e8;
        border-radius: 9px;
        padding: 12px 14px;
        font-size: 13px;
        color: var(--text);
        outline: none;
        background: white;
        transition: .2s;
        box-sizing: border-box;
    }

    .form-control-custom:focus {
        border-color: var(--gold);
        box-shadow: 0 0 0 3px rgba(245,166,35,.12);
    }

    textarea.form-control-custom {
        min-height: 130px;
        resize: vertical;
        line-height: 1.6;
    }

    .form-hint {
        font-size: 11px;
        color: #8994a3;
        margin-top: 6px;
    }

    .error-text {
        font-size: 12px;
        color: #dc3545;
        margin-top: 6px;
    }

    .rating-selector {
        display: flex;
        align-items: center;
        gap: 7px;
    }

    .rating-star {
        border: none;
        background: transparent;
        padding: 0;
        cursor: pointer;
        font-size: 32px;
        color: #d7dce2;
        transition: .15s;
    }

    .rating-star.active {
        color: var(--gold);
    }

    .rating-label {
        color: #718096;
        font-size: 12px;
        margin-left: 8px;
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-wrap: wrap;
    }

    .photo-preview {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        background: #edf0f3;
        display: none;
        border: 3px solid #f1f3f5;
    }

    .photo-placeholder {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: #edf0f3;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #8994a3;
        font-size: 12px;
        text-align: center;
    }

    .file-input {
        font-size: 12px;
        max-width: 100%;
    }

    .publish-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        background: #f8fafc;
        border: 1px solid #edf0f3;
        padding: 16px;
        border-radius: 10px;
    }

    .publish-title {
        font-size: 13px;
        font-weight: 800;
        color: var(--navy);
    }

    .publish-description {
        color: #8994a3;
        font-size: 11px;
        margin-top: 4px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 26px;
        flex-shrink: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .switch-slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background: #cbd5e1;
        border-radius: 30px;
        transition: .2s;
    }

    .switch-slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 4px;
        bottom: 4px;
        background: white;
        border-radius: 50%;
        transition: .2s;
    }

    .switch input:checked + .switch-slider {
        background: #16a34a;
    }

    .switch input:checked + .switch-slider:before {
        transform: translateX(22px);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 28px;
        padding-top: 22px;
        border-top: 1px solid #edf0f3;
    }

    .btn-cancel, .btn-save {
        padding: 12px 21px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 800;
        text-decoration: none;
        border: none;
        cursor: pointer;
    }

    .btn-cancel {
        background: #edf0f3;
        color: #475569;
    }

    .btn-save {
        background: var(--gold);
        color: var(--navy-dark);
    }

    .btn-save:hover {
        background: #e99a12;
    }

    .validation-alert {
        background: #feecec;
        border-left: 4px solid #dc3545;
        color: #a52626;
        border-radius: 8px;
        padding: 14px 17px;
        font-size: 13px;
        margin-bottom: 20px;
    }

    .validation-alert ul {
        margin: 7px 0 0;
        padding-left: 20px;
    }

    @media(max-width: 650px) {
        .testimonial-page {
            padding: 20px 14px;
        }

        .form-card {
            padding: 20px 16px;
        }

        .form-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .form-group.full {
            grid-column: auto;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .form-actions a, .form-actions button {
            text-align: center;
            width: 100%;
            box-sizing: border-box;
        }
    }
</style>

<div class="testimonial-page">

    <a href="{{ route('admin.testimonials.index') }}" class="back-link">
        ← Kembali ke Rating & Testimoni
    </a>

    <div class="page-heading">
        <h2>Tambah Testimoni Customer</h2>
        <p>Masukkan informasi dan pengalaman pelanggan TERRAWOOD.</p>
    </div>

    <div class="form-card">

        @if($errors->any())
            <div class="validation-alert">
                <strong>Data belum dapat disimpan.</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            action="{{ route('admin.testimonials.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <h3 class="form-section-title">Informasi Customer</h3>

            <div class="form-grid">

                <div class="form-group">
                    <label class="form-label">
                        Nama Customer <span class="required">*</span>
                    </label>

                    <input
                        type="text"
                        name="customer_name"
                        class="form-control-custom"
                        value="{{ old('customer_name') }}"
                        placeholder="Masukkan nama customer"
                        required
                    >

                    @error('customer_name')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email Customer</label>

                    <input
                        type="email"
                        name="customer_email"
                        class="form-control-custom"
                        value="{{ old('customer_email') }}"
                        placeholder="customer@email.com"
                    >

                    @error('customer_email')
                        <div class="error-text">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group full">
                    <label class="form-label">Foto Customer</label>

                    <div class="photo-upload">
                        <div class="photo-placeholder" id="photoPlaceholder">
                            Preview Foto
                        </div>

                        <img
                            src=""
                            class="photo-preview"
                            id="photoPreview"
                            alt="Preview foto customer"
                        >

                        <div>
                            <input
                                type="file"
                                name="customer_photo"
                                id="customerPhoto"
                                class="file-input"
                                accept="image/jpeg,image/png,image/webp"
                            >

                            <div class="form-hint">
                                Format JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                            </div>

                            @error('customer_photo')
                                <div class="error-text">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>

            <hr style="border:0;border-top:1px solid #edf0f3;margin:10px 0 25px;">

            <h3 class="form-section-title">Penilaian dan Testimoni</h3>

            <div class="form-group">
                <label class="form-label">
                    Rating Customer <span class="required">*</span>
                </label>

                <div class="rating-selector" id="ratingSelector">
                    @for($i = 1; $i <= 5; $i++)
                        <button
                            type="button"
                            class="rating-star {{ old('rating', 5) >= $i ? 'active' : '' }}"
                            data-rating="{{ $i }}"
                            aria-label="Rating {{ $i }}"
                        >★</button>
                    @endfor

                    <span class="rating-label" id="ratingLabel">
                        {{ old('rating', 5) }}/5 - Sangat Baik
                    </span>
                </div>

                <input
                    type="hidden"
                    name="rating"
                    id="ratingValue"
                    value="{{ old('rating', 5) }}"
                >

                @error('rating')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">
                    Isi Testimoni <span class="required">*</span>
                </label>

                <textarea
                    name="testimonial"
                    class="form-control-custom"
                    placeholder="Tuliskan pengalaman customer menggunakan produk atau layanan TERRAWOOD..."
                    required
                >{{ old('testimonial') }}</textarea>

                @error('testimonial')
                    <div class="error-text">{{ $message }}</div>
                @enderror
            </div>

            <hr style="border:0;border-top:1px solid #edf0f3;margin:10px 0 25px;">

            <h3 class="form-section-title">Pengaturan Publikasi</h3>

            <div class="form-group">
                <div class="publish-box">
                    <div>
                        <div class="publish-title">Tampilkan di Website</div>
                        <div class="publish-description">
                            Testimoni akan terlihat pada halaman publik TERRAWOOD jika diaktifkan.
                        </div>
                    </div>

                    <label class="switch">
                        <input
                            type="checkbox"
                            name="is_published"
                            value="1"
                            {{ old('is_published') ? 'checked' : '' }}
                        >
                        <span class="switch-slider"></span>
                    </label>
                </div>
            </div>

            <div class="form-actions">
                <a
                    href="{{ route('admin.testimonials.index') }}"
                    class="btn-cancel"
                >
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan Testimoni
                </button>
            </div>

        </form>
    </div>
</div>

<script>
    // Preview foto customer
    const photoInput = document.getElementById('customerPhoto');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    photoInput.addEventListener('change', function() {
        const file = this.files[0];

        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar.');
            this.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();

        reader.onload = function(event) {
            photoPreview.src = event.target.result;
            photoPreview.style.display = 'block';
            photoPlaceholder.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });

    // Rating bintang interaktif
    const ratingButtons = document.querySelectorAll('.rating-star');
    const ratingValue = document.getElementById('ratingValue');
    const ratingLabel = document.getElementById('ratingLabel');

    function updateRating(value) {
        ratingValue.value = value;

        ratingButtons.forEach(button => {
            const starValue = Number(button.dataset.rating);
            button.classList.toggle('active', starValue <= value);
        });

        const labels = {
            1: '1/5 - Sangat Buruk',
            2: '2/5 - Buruk',
            3: '3/5 - Cukup',
            4: '4/5 - Baik',
            5: '5/5 - Sangat Baik'
        };

        ratingLabel.textContent = labels[value];
    }

    ratingButtons.forEach(button => {
        button.addEventListener('click', function() {
            updateRating(Number(this.dataset.rating));
        });
    });

    updateRating(Number(ratingValue.value));
</script>
@endsection