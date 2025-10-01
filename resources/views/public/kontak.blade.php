@extends('public.layouts.app')

@php
    $profil = \App\Models\Profil::first();
@endphp

@section('title')
    Kontak - {{ $profil->nama_instansi ?? 'Dinas PUPR Katingan' }}
@endsection

@push('meta')
    <meta name="description"
        content="Hubungi {{ $profil->nama_instansi ?? 'Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan' }} untuk informasi layanan, pertanyaan, atau saran.">
    <meta name="keywords" content="kontak, PUPR, Katingan, alamat, telepon, email, layanan publik">
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="py-4 py-md-5 text-white"
        style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8" data-aos="fade-right">
                    <h1 class="display-5 fw-bold mb-2 mb-md-3">Hubungi Kami</h1>
                    <p class="lead mb-0">Sampaikan pertanyaan, saran, atau kebutuhan layanan Anda kepada tim
                        {{ $profil->nama_instansi ?? 'Dinas PUPR Katingan' }}</p>
                </div>
                <div class="col-lg-4 d-none d-lg-block" data-aos="fade-left">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('public.home') }}"
                                    class="text-white-50">Beranda</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">Kontak</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Information Section -->
    <section class="py-4 py-md-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center mb-4 mb-md-5">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="section-title mb-2 mb-md-3">Informasi Kontak</h2>
                    <p class="text-muted">Berikut adalah informasi kontak resmi
                        {{ $profil->nama_instansi ?? 'Dinas PUPR Katingan' }}</p>
                </div>
            </div>

            <div class="row g-3 g-md-4">
                <!-- Alamat -->
                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="50">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-3 p-md-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-geo-alt-fill text-primary" style="font-size: 1.8rem;"></i>
                            </div>
                            <h5 class="card-title mb-3" style="font-size: 1.1rem;">Alamat Kantor</h5>
                            <p class="text-muted mb-0 small">
                                @if (isset($profil) && $profil->alamat)
                                    {{ $profil->alamat }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Telepon -->
                <div class="col-12 col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-3 p-md-4">
                            <div class="bg-success bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 60px; height: 60px;">
                                <i class="bi bi-telephone-fill text-success" style="font-size: 1.8rem;"></i>
                            </div>
                            <h5 class="card-title mb-3" style="font-size: 1.1rem;">Telepon</h5>
                            @if (isset($profil) && $profil->telepon)
                                <p class="text-muted mb-2">
                                    <a href="tel:{{ str_replace([' ', '-', '(', ')'], '', $profil->telepon) }}"
                                        class="text-decoration-none">
                                        {{ $profil->telepon }}
                                    </a>
                                </p>
                            @endif
                            @if (isset($profil) && $profil->whatsapp)
                                <p class="text-muted mb-0">
                                    <a href="https://wa.me/{{ str_replace(['+', ' ', '-', '(', ')'], '', $profil->whatsapp) }}?text=Halo%20Dinas%20PUPR%20Katingan"
                                        target="_blank" class="text-success text-decoration-none">
                                        <i class="bi bi-whatsapp me-1"></i>WhatsApp: {{ $profil->whatsapp }}
                                    </a>
                                </p>
                            @else
                                <p class="text-muted mb-0">
                                    <a href="https://wa.me/6281234567890?text=Halo%20Dinas%20PUPR%20Katingan"
                                        target="_blank" class="text-success text-decoration-none">
                                        <i class="bi bi-whatsapp me-1"></i>WhatsApp: +62 -
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="bg-warning bg-opacity-10 rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-envelope-fill text-warning" style="font-size: 2.5rem;"></i>
                            </div>
                            <h5 class="card-title mb-3">Email</h5>
                            @if (isset($profil) && $profil->email)
                                <p class="text-muted mb-2">
                                    <a href="mailto:{{ $profil->email }}" class="text-decoration-none">
                                        {{ $profil->email }}
                                    </a>
                                </p>
                            @else
                                <p class="text-muted mb-2">
                                    <a href="mailto:info@puprkatingan.go.id" class="text-decoration-none">
                                        -
                                    </a>
                                </p>
                            @endif
                            @if (isset($profil) && $profil->website)
                                <p class="text-muted mb-0">
                                    <a href="{{ str_starts_with($profil->website, 'http') ? $profil->website : 'https://' . $profil->website }}"
                                        target="_blank" class="text-decoration-none">
                                        <i
                                            class="bi bi-globe me-1"></i>{{ str_replace(['http://', 'https://'], '', $profil->website) }}
                                    </a>
                                </p>
                            @else
                                <p class="text-muted mb-0">
                                    <a href="https://puprkatingan.go.id" target="_blank" class="text-decoration-none">
                                        <i class="bi bi-globe me-1"></i>
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="text-center mb-5">
                        <h2 class="section-title">Kirim Pesan</h2>
                        <p class="text-muted">Isi form di bawah ini untuk mengirimkan pesan kepada kami</p>
                    </div>

                    <!-- Success Alert -->
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Error Alert -->
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Validation Error Alert -->
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form id="contactForm" method="POST" action="{{ route('public.kontak.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="nama" class="form-label">Nama Lengkap <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama" name="nama"
                                            value="{{ old('nama') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="{{ old('email') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telepon" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="telepon" name="telepon"
                                            value="{{ old('telepon') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="subjek" class="form-label">Subjek <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="subjek" name="subjek" required>
                                            <option value="">Pilih Subjek</option>
                                            <option value="Permohonan Informasi"
                                                {{ old('subjek') == 'Permohonan Informasi' ? 'selected' : '' }}>Permohonan
                                                Informasi</option>
                                            <option value="Konsultasi Teknis"
                                                {{ old('subjek') == 'Konsultasi Teknis' ? 'selected' : '' }}>Konsultasi
                                                Teknis</option>
                                            <option value="Pengaduan Pelayanan"
                                                {{ old('subjek') == 'Pengaduan Pelayanan' ? 'selected' : '' }}>Pengaduan
                                                Pelayanan</option>
                                            <option value="Perizinan IMB/SBG"
                                                {{ old('subjek') == 'Perizinan IMB/SBG' ? 'selected' : '' }}>Perizinan
                                                IMB/SBG</option>
                                            <option value="Penataan Ruang"
                                                {{ old('subjek') == 'Penataan Ruang' ? 'selected' : '' }}>Penataan Ruang
                                            </option>
                                            <option value="Infrastruktur Jalan"
                                                {{ old('subjek') == 'Infrastruktur Jalan' ? 'selected' : '' }}>
                                                Infrastruktur Jalan</option>
                                            <option value="Sumber Daya Air"
                                                {{ old('subjek') == 'Sumber Daya Air' ? 'selected' : '' }}>Sumber Daya Air
                                            </option>
                                            <option value="Kerjasama & Kemitraan"
                                                {{ old('subjek') == 'Kerjasama & Kemitraan' ? 'selected' : '' }}>Kerjasama
                                                & Kemitraan</option>
                                            <option value="Saran & Masukan"
                                                {{ old('subjek') == 'Saran & Masukan' ? 'selected' : '' }}>Saran & Masukan
                                            </option>
                                            <option value="Lainnya" {{ old('subjek') == 'Lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="pesan" class="form-label">Pesan <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="pesan" name="pesan" rows="5" required>{{ old('pesan') }}</textarea>
                                    </div>

                                    <!-- CAPTCHA -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            @if (app('App\Services\SimpleCaptchaService')->isRequired())
                                                {!! app('App\Services\SimpleCaptchaService')->generateHtml() !!}
                                                @error('captcha_answer')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                @error('captcha')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary btn-lg px-5">
                                            <i class="bi bi-send me-2"></i>Kirim Pesan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Review/Ulasan Form Section -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="text-center mb-5">
                        <h2 class="section-title">Berikan Ulasan</h2>
                        <p class="text-muted">Bagikan pengalaman Anda menggunakan layanan
                            {{ $profil->nama_instansi ?? 'Dinas PUPR Katingan' }}</p>
                    </div>

                    <!-- Success Alert for Review -->
                    @if (session('review_success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            {{ session('review_success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Error Alert for Review -->
                    @if ($errors->has('review_*'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    @if (str_contains($error, 'review_'))
                                        <li>{{ $error }}</li>
                                    @endif
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <form id="reviewForm" method="POST" action="{{ route('public.ulasan.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="review_nama" class="form-label">Nama Lengkap <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="review_nama" name="review_nama"
                                            value="{{ old('review_nama') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="review_email" class="form-label">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" class="form-control" id="review_email" name="review_email"
                                            value="{{ old('review_email') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="review_telepon" class="form-label">Nomor Telepon</label>
                                        <input type="tel" class="form-control" id="review_telepon"
                                            name="review_telepon" value="{{ old('review_telepon') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="layanan" class="form-label">Layanan yang Digunakan <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="layanan" name="layanan" required>
                                            <option value="">Pilih Layanan</option>
                                            <option value="IMB" {{ old('layanan') == 'IMB' ? 'selected' : '' }}>Izin
                                                Mendirikan Bangunan (IMB)</option>
                                            <option value="SBG" {{ old('layanan') == 'SBG' ? 'selected' : '' }}>
                                                Sertifikat Bangunan Gedung (SBG)</option>
                                            <option value="PKKPR" {{ old('layanan') == 'PKKPR' ? 'selected' : '' }}>
                                                Persetujuan Kesesuaian Kegiatan Pemanfaatan Ruang (PKKPR)</option>
                                            <option value="RTBL" {{ old('layanan') == 'RTBL' ? 'selected' : '' }}>
                                                Rencana Tata Bangunan dan Lingkungan (RTBL)</option>
                                            <option value="Advice Planning"
                                                {{ old('layanan') == 'Advice Planning' ? 'selected' : '' }}>Advice Planning
                                            </option>
                                            <option value="Lainnya" {{ old('layanan') == 'Lainnya' ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <label for="rating" class="form-label">Rating Kepuasan <span
                                                class="text-danger">*</span></label>
                                        <div class="rating-stars mb-3">
                                            <div class="d-flex gap-2 align-items-center">
                                                <div class="stars-container">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star star-rating"
                                                            data-rating="{{ $i }}"
                                                            style="font-size: 2rem; color: #ddd; cursor: pointer;"></i>
                                                    @endfor
                                                </div>
                                                <span class="rating-text ms-3 text-muted">Belum ada rating</span>
                                            </div>
                                            <input type="hidden" id="rating" name="rating"
                                                value="{{ old('rating') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label for="review_pesan" class="form-label">Ulasan & Saran <span
                                                class="text-danger">*</span></label>
                                        <textarea class="form-control" id="review_pesan" name="review_pesan" rows="5"
                                            placeholder="Ceritakan pengalaman Anda menggunakan layanan kami..." required>{{ old('review_pesan') }}</textarea>
                                    </div>

                                    <!-- CAPTCHA for Review -->
                                    <div class="col-12">
                                        <div class="mb-3">
                                            @if (app('App\Services\SimpleCaptchaService')->isRequired())
                                                {!! app('App\Services\SimpleCaptchaService')->generateHtml() !!}
                                                @error('captcha_answer')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                                @error('captcha')
                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                @enderror
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-warning btn-lg px-5">
                                            <i class="bi bi-star me-2"></i>Kirim Ulasan
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title">Lokasi Kantor</h2>
                <p class="text-muted">Temukan kami di peta untuk kunjungan langsung</p>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-10" data-aos="fade-up">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-0">
                            <!-- Simple Google Maps Embed -->
                            <div id="mapContainer"
                                style="height: 400px; border-radius: 15px; overflow: hidden; position: relative;">
                                <iframe
                                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7588!2d113.4179394!3d-1.8708794!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMcKwNTInMTUuMiJTIDExM8KwMjUnMDQuNiJF!5e0!3m2!1sid!2sid!4v1632000000000!5m2!1sid!2sid"
                                    width="100%" height="400" style="border:0; border-radius: 15px;"
                                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <div class="d-flex gap-2 flex-wrap justify-content-center">
                            <a href="https://maps.app.goo.gl/MqqqrdxZ46m1u94c6" target="_blank" class="btn btn-primary">
                                <i class="bi bi-geo-alt me-2"></i>Google Maps
                            </a>
                            <a href="https://www.openstreetmap.org/?mlat=-1.8708794&mlon=113.4179394&zoom=15"
                                target="_blank" class="btn btn-outline-primary">
                                <i class="bi bi-map me-2"></i>OpenStreetMap
                            </a>
                            <button onclick="copyCoordinates()" class="btn btn-outline-secondary">
                                <i class="bi bi-clipboard me-2"></i>Copy Koordinat
                            </button>
                            <a href="https://www.google.com/maps/dir/?api=1&destination=-1.8708794,113.4179394"
                                target="_blank" class="btn btn-outline-success">
                                <i class="bi bi-navigation me-2"></i>Rute
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <!-- Simple JavaScript -->
    <script>
        // Copy coordinates function
        function copyCoordinates() {
            const coordinates = "-1.8708794, 113.4179394";
            navigator.clipboard.writeText(coordinates).then(() => {
                // Show toast notification
                const toast = document.createElement('div');
                toast.className = 'toast';
                toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: #28a745;
                color: white;
                padding: 12px 20px;
                border-radius: 8px;
                z-index: 10000;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            `;
                toast.textContent = 'Koordinat berhasil disalin!';
                document.body.appendChild(toast);

                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 3000);
            }).catch(err => {
                alert('Koordinat: ' + coordinates);
            });
        }

        // Rating stars functionality
        function initializeRatingStars() {
            const stars = document.querySelectorAll('.star-rating');
            const ratingInput = document.getElementById('rating');
            const ratingText = document.querySelector('.rating-text');

            const ratingLabels = {
                1: 'Sangat Kurang',
                2: 'Kurang',
                3: 'Cukup',
                4: 'Baik',
                5: 'Sangat Baik'
            };

            stars.forEach(star => {
                star.addEventListener('mouseover', function() {
                    const rating = parseInt(this.dataset.rating);
                    highlightStars(rating);
                });

                star.addEventListener('mouseout', function() {
                    const currentRating = parseInt(ratingInput.value) || 0;
                    highlightStars(currentRating);
                });

                star.addEventListener('click', function() {
                    const rating = parseInt(this.dataset.rating);
                    ratingInput.value = rating;
                    highlightStars(rating);
                    ratingText.textContent = ratingLabels[rating];
                    ratingText.style.color = rating >= 4 ? '#28a745' : rating >= 3 ? '#ffc107' : '#dc3545';
                });
            });

            function highlightStars(rating) {
                stars.forEach((star, index) => {
                    if (index < rating) {
                        star.style.color = '#ffc107';
                        star.classList.remove('bi-star');
                        star.classList.add('bi-star-fill');
                    } else {
                        star.style.color = '#ddd';
                        star.classList.remove('bi-star-fill');
                        star.classList.add('bi-star');
                    }
                });
            }

            // Initialize with existing rating if any
            const existingRating = parseInt(ratingInput.value) || 0;
            if (existingRating > 0) {
                highlightStars(existingRating);
                ratingText.textContent = ratingLabels[existingRating];
            }
        }

        // Contact form handling
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize rating stars
            initializeRatingStars();

            // Contact form validation
            const contactForm = document.getElementById('contactForm');
            if (contactForm) {
                contactForm.addEventListener('submit', function(e) {
                    const nama = document.getElementById('nama').value.trim();
                    const email = document.getElementById('email').value.trim();
                    const subjek = document.getElementById('subjek').value;
                    const pesan = document.getElementById('pesan').value.trim();

                    if (!nama || !email || !subjek || !pesan) {
                        e.preventDefault();
                        alert('Semua field yang wajib diisi harus dilengkapi!');
                        return;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        alert('Format email tidak valid!');
                        return;
                    }

                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim...';
                    submitBtn.disabled = true;
                });
            }

            // Review form validation
            const reviewForm = document.getElementById('reviewForm');
            if (reviewForm) {
                reviewForm.addEventListener('submit', function(e) {
                    const nama = document.getElementById('review_nama').value.trim();
                    const email = document.getElementById('review_email').value.trim();
                    const layanan = document.getElementById('layanan').value;
                    const rating = document.getElementById('rating').value;
                    const pesan = document.getElementById('review_pesan').value.trim();

                    if (!nama || !email || !layanan || !rating || !pesan) {
                        e.preventDefault();
                        alert('Semua field yang wajib diisi harus dilengkapi!');
                        return;
                    }

                    if (parseInt(rating) < 1 || parseInt(rating) > 5) {
                        e.preventDefault();
                        alert('Silakan berikan rating dari 1 sampai 5 bintang!');
                        return;
                    }

                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        e.preventDefault();
                        alert('Format email tidak valid!');
                        return;
                    }

                    const submitBtn = this.querySelector('button[type="submit"]');
                    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengirim Ulasan...';
                    submitBtn.disabled = true;
                });
            }
        });
    </script>
@endpush
