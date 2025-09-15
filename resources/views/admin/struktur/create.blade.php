@extends('layouts.admin')

@section('title', 'Tambah Struktur Organisasi')

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Tambah Struktur Organisasi</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Struktur</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama') }}" required>
                                @error('nama')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip') }}" maxlength="20">
                                @error('nip')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Email, Telepon, dan Alamat field telah dihapus sesuai permintaan -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>

                                <!-- Category Selection Buttons -->
                                <div class="mb-3">
                                    <p class="text-muted mb-2">Pilih kategori jabatan terlebih dahulu:</p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach (\App\Models\Struktur::getJabatanCategories() as $key => $label)
                                            <button type="button" class="btn btn-outline-primary btn-sm category-btn"
                                                data-category="{{ $key }}"
                                                onclick="selectCategory('{{ $key }}', this)">
                                                {{ $label }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Jabatan Dropdown (Initially Hidden) -->
                                <div id="jabatan-dropdown" style="display: none;">
                                    <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan"
                                        name="jabatan" required>
                                        <option value="">Pilih Jabatan</option>
                                    </select>
                                    @error('jabatan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="golongan" class="form-label">Golongan</label>
                                <select class="form-select @error('golongan') is-invalid @enderror" id="golongan"
                                    name="golongan">
                                    <option value="">-- Pilih Golongan --</option>
                                    @foreach (\App\Models\Struktur::getGolonganOptions() as $golongan)
                                        <option value="{{ $golongan }}"
                                            {{ old('golongan') == $golongan ? 'selected' : '' }}>
                                            {{ $golongan }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('golongan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="unit_kerja" class="form-label">Unit Kerja</label>
                        <select class="form-select @error('unit_kerja') is-invalid @enderror" id="unit_kerja"
                            name="unit_kerja">
                            <option value="">Pilih Unit Kerja</option>
                            @foreach (\App\Models\Struktur::getUnitKerjaOptions() as $unitKerja)
                                <option value="{{ $unitKerja }}"
                                    {{ old('unit_kerja') == $unitKerja ? 'selected' : '' }}>
                                    {{ $unitKerja }}
                                </option>
                            @endforeach
                        </select>
                        @error('unit_kerja')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="urutan" class="form-label">Urutan <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                    id="urutan" name="urutan" value="{{ old('urutan', 0) }}" min="0" required>
                                @error('urutan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="text-muted">Urutan menentukan posisi dalam struktur organisasi</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status', 'aktif') == 'aktif' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="non-aktif" {{ old('status') == 'non-aktif' ? 'selected' : '' }}>
                                        Non-Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto"
                            name="foto" accept="image/*">
                        @error('foto')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <small class="text-muted">Format: jpeg, png, jpg. Maksimal 2MB</small>
                    </div>

                    <!-- Keterangan field telah dihapus sesuai permintaan -->

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simpan data jabatan di JavaScript untuk client-side filtering
        const jabatanData = {
            'pimpinan': @json(\App\Models\Struktur::getJabatanByCategory('pimpinan')),
            'sekretariat': @json(\App\Models\Struktur::getJabatanByCategory('sekretariat')),
            'bina_marga': @json(\App\Models\Struktur::getJabatanByCategory('bina_marga')),
            'cipta_karya': @json(\App\Models\Struktur::getJabatanByCategory('cipta_karya')),
            'tata_ruang': @json(\App\Models\Struktur::getJabatanByCategory('tata_ruang')),
            'sumber_daya_air': @json(\App\Models\Struktur::getJabatanByCategory('sumber_daya_air')),
            'staff_umum': @json(\App\Models\Struktur::getJabatanByCategory('staff_umum'))
        };

        function selectCategory(category, buttonElement) {
            console.log('Selecting category:', category);

            // Reset all category buttons
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('btn-primary');
                btn.classList.add('btn-outline-primary');
            });

            // Highlight selected button
            buttonElement.classList.remove('btn-outline-primary');
            buttonElement.classList.add('btn-primary');

            // Show loading state
            const jabatanSelect = document.getElementById('jabatan');
            const jabatanDropdown = document.getElementById('jabatan-dropdown');

            jabatanSelect.innerHTML = '<option value="">Loading...</option>';
            jabatanDropdown.style.display = 'block';

            // Use client-side data instead of AJAX
            setTimeout(() => {
                if (jabatanData[category]) {
                    // Clear previous options
                    jabatanSelect.innerHTML = '<option value="">Pilih Jabatan</option>';

                    // Add new options
                    jabatanData[category].forEach(jabatan => {
                        const option = document.createElement('option');
                        option.value = jabatan;
                        option.textContent = jabatan;

                        // Check if this was previously selected (for validation errors)
                        if ('{{ old('jabatan') }}' === jabatan) {
                            option.selected = true;
                        }

                        jabatanSelect.appendChild(option);
                    });

                    console.log('Successfully loaded', jabatanData[category].length,
                        'jabatan options for category:', category);
                } else {
                    jabatanSelect.innerHTML = '<option value="">No data available for this category</option>';
                    console.error('No data found for category:', category);
                }
            }, 200); // Small delay to show loading effect
        }

        // Auto-select category if there's an old jabatan value (for validation errors)
        document.addEventListener('DOMContentLoaded', function() {
            const oldJabatan = '{{ old('jabatan') }}';
            if (oldJabatan) {
                console.log('Old jabatan found:', oldJabatan);

                // Find which category this jabatan belongs to
                Object.keys(jabatanData).forEach(category => {
                    if (jabatanData[category].includes(oldJabatan)) {
                        const categoryBtn = document.querySelector(`[data-category="${category}"]`);
                        if (categoryBtn) {
                            console.log('Auto-selecting category:', category);
                            selectCategory(category, categoryBtn);
                            return;
                        }
                    }
                });
            }
        });
    </script>
@endsection
