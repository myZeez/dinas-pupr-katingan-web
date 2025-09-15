@extends('admin.layouts.app')

@section('title', 'Pengaturan CAPTCHA')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <h4 class="page-title">🛡️ Pengaturan CAPTCHA</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengaturan CAPTCHA</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="mdi mdi-check-all me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Konfigurasi reCAPTCHA</h4>
                        <p class="text-muted mb-0">Atur konfigurasi Google reCAPTCHA untuk melindungi form dari spam</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.captcha.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            @foreach ($settings as $setting)
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ $setting->label }}</label>

                                    @if ($setting->type === 'boolean')
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                name="settings[{{ $setting->key }}]" id="{{ $setting->key }}" value="1"
                                                {{ $setting->getCastedValue() ? 'checked' : '' }}>
                                            <label class="form-check-label" for="{{ $setting->key }}">
                                                Aktifkan
                                            </label>
                                        </div>
                                    @elseif($setting->type === 'select')
                                        <select class="form-control" name="settings[{{ $setting->key }}]" required>
                                            @foreach ($setting->options as $value => $label)
                                                <option value="{{ $value }}"
                                                    {{ $setting->value == $value ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @else
                                        <input type="{{ $setting->is_sensitive ? 'password' : 'text' }}"
                                            class="form-control" name="settings[{{ $setting->key }}]"
                                            value="{{ $setting->value }}"
                                            placeholder="Masukkan {{ strtolower($setting->label) }}">
                                    @endif

                                    @if ($setting->description)
                                        <small class="form-text text-muted">{{ $setting->description }}</small>
                                    @endif
                                </div>
                            @endforeach

                            <div class="text-end">
                                <button type="button" id="test-captcha" class="btn btn-info me-2">
                                    <i class="mdi mdi-test-tube me-1"></i>Test Konfigurasi
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save me-1"></i>Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Panduan Setup</h4>
                    </div>
                    <div class="card-body">
                        <div class="timeline-alt pb-0">
                            <div class="timeline-item">
                                <i class="mdi mdi-web bg-primary text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">1. Buat reCAPTCHA</h5>
                                    <p class="text-muted mb-0">Kunjungi
                                        <a href="https://www.google.com/recaptcha/admin" target="_blank">Google
                                            reCAPTCHA</a>
                                        untuk membuat kunci baru.
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-key bg-success text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">2. Salin Kunci</h5>
                                    <p class="text-muted mb-0">Salin Site Key dan Secret Key ke form di sebelah kiri.</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-domain bg-warning text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">3. Tambah Domain</h5>
                                    <p class="text-muted mb-0">Pastikan domain website sudah terdaftar di reCAPTCHA.</p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="mdi mdi-check-circle bg-info text-white timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <h5 class="mt-0 mb-1">4. Test & Aktifkan</h5>
                                    <p class="text-muted mb-0">Test konfigurasi dan aktifkan CAPTCHA untuk melindungi form.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="header-title">Status CAPTCHA</h4>
                    </div>
                    <div class="card-body">
                        <div id="captcha-status">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Test CAPTCHA configuration
            $('#test-captcha').click(function() {
                const btn = $(this);
                const originalText = btn.html();

                btn.html('<i class="mdi mdi-loading mdi-spin me-1"></i>Testing...').prop('disabled', true);

                $.get('{{ route('admin.captcha.test') }}')
                    .done(function(response) {
                        if (response.success) {
                            const data = response.data;
                            let statusHtml = `
                        <div class="alert alert-success">
                            <h6><i class="mdi mdi-check-circle me-1"></i>Konfigurasi Valid</h6>
                            <small>
                                Site Key: ${data.sitekey_length} karakter (${data.sitekey_format})<br>
                                Secret Key: ${data.secret_length} karakter (${data.secret_format})<br>
                                Status: ${data.required ? 'Aktif' : 'Nonaktif'}
                            </small>
                        </div>
                    `;
                            $('#captcha-status').html(statusHtml);
                        } else {
                            $('#captcha-status').html(`
                        <div class="alert alert-danger">
                            <h6><i class="mdi mdi-alert-circle me-1"></i>Test Gagal</h6>
                            <small>${response.message}</small>
                        </div>
                    `);
                        }
                    })
                    .fail(function() {
                        $('#captcha-status').html(`
                    <div class="alert alert-warning">
                        <h6><i class="mdi mdi-alert me-1"></i>Tidak Dapat Test</h6>
                        <small>Periksa konfigurasi server</small>
                    </div>
                `);
                    })
                    .always(function() {
                        btn.html(originalText).prop('disabled', false);
                    });
            });

            // Load status on page load
            $('#test-captcha').click();
        });
    </script>
@endpush
