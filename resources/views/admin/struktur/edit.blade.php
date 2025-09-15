@extends('layouts.admin')

@section('title', 'Edit Struktur Organisasi')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="mb-0 text-dark fw-bold">Edit Struktur Organisasi</h4>
                    <a href="{{ route('admin.struktur.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.struktur.update', $struktur->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6">
                    <!-- Informasi Dasar -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 text-dark">
                                <i class="fas fa-user me-2 text-primary"></i>Informasi Dasar
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label fw-semibold">Nama Lengkap <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" value="{{ old('nama', $struktur->nama) }}"
                                    placeholder="Masukkan nama lengkap" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="nip" class="form-label fw-semibold">NIP</label>
                                <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" value="{{ old('nip', $struktur->nip) }}"
                                    placeholder="Nomor Induk Pegawai" maxlength="20">
                                @error('nip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>



                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="urutan" class="form-label fw-semibold">Urutan <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control @error('urutan') is-invalid @enderror"
                                            id="urutan" name="urutan" value="{{ old('urutan', $struktur->urutan) }}"
                                            min="1" required>
                                        @error('urutan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Urutan menentukan posisi dalam struktur organisasi</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label for="status" class="form-label fw-semibold">Status <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status"
                                            name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="aktif"
                                                {{ old('status', strtolower($struktur->status)) == 'aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="tidak_aktif"
                                                {{ old('status', strtolower($struktur->status)) == 'tidak_aktif' || old('status', $struktur->status) == 'Tidak Aktif' ? 'selected' : '' }}>
                                                Tidak Aktif</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Foto Profil -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 text-dark">
                                <i class="fas fa-camera me-2 text-primary"></i>Foto Profil
                            </h6>
                        </div>
                        <div class="card-body">
                            @if ($struktur->foto)
                                <div class="text-center mb-3">
                                    <img src="{{ asset('storage/' . $struktur->foto) }}" alt="Foto {{ $struktur->nama }}"
                                        class="img-thumbnail rounded" style="max-height: 200px; max-width: 200px;">
                                </div>
                            @endif

                            <div class="mb-0">
                                <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                    id="foto" name="foto" accept="image/*">
                                @error('foto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    Format: JPEG, PNG, JPG. Maksimal 2MB. Biarkan kosong jika tidak ingin mengubah foto.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6">
                    <!-- Jabatan & Posisi -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white py-3">
                            <h6 class="card-title mb-0 text-dark">
                                <i class="fas fa-briefcase me-2 text-primary"></i>Jabatan & Posisi
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label fw-semibold">Kategori Jabatan <span
                                        class="text-danger">*</span></label>
                                <div class="row g-2 mb-3">
                                    @foreach (\App\Models\Struktur::getJabatanCategories() as $category => $label)
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-primary btn-sm w-100 category-btn"
                                                data-category="{{ $category }}"
                                                onclick="selectCategory('{{ $category }}', this)">
                                                {{ $label }}
                                            </button>
                                        </div>
                                    @endforeach
                                </div>

                                <select class="form-select @error('jabatan') is-invalid @enderror" id="jabatan"
                                    name="jabatan" required>
                                    <option value="">Pilih Kategori Terlebih Dahulu</option>
                                </select>
                                @error('jabatan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="golongan" class="form-label fw-semibold">Golongan</label>
                                        <select class="form-select @error('golongan') is-invalid @enderror" id="golongan"
                                            name="golongan">
                                            <option value="">-- Pilih Golongan --</option>
                                            <option value="I/a"
                                                {{ old('golongan', $struktur->golongan) == 'I/a' ? 'selected' : '' }}>I/a
                                            </option>
                                            <option value="I/b"
                                                {{ old('golongan', $struktur->golongan) == 'I/b' ? 'selected' : '' }}>I/b
                                            </option>
                                            <option value="I/c"
                                                {{ old('golongan', $struktur->golongan) == 'I/c' ? 'selected' : '' }}>I/c
                                            </option>
                                            <option value="I/d"
                                                {{ old('golongan', $struktur->golongan) == 'I/d' ? 'selected' : '' }}>I/d
                                            </option>
                                            <option value="II/a"
                                                {{ old('golongan', $struktur->golongan) == 'II/a' ? 'selected' : '' }}>II/a
                                            </option>
                                            <option value="II/b"
                                                {{ old('golongan', $struktur->golongan) == 'II/b' ? 'selected' : '' }}>II/b
                                            </option>
                                            <option value="II/c"
                                                {{ old('golongan', $struktur->golongan) == 'II/c' ? 'selected' : '' }}>II/c
                                            </option>
                                            <option value="II/d"
                                                {{ old('golongan', $struktur->golongan) == 'II/d' ? 'selected' : '' }}>II/d
                                            </option>
                                            <option value="III/a"
                                                {{ old('golongan', $struktur->golongan) == 'III/a' ? 'selected' : '' }}>
                                                III/a</option>
                                            <option value="III/b"
                                                {{ old('golongan', $struktur->golongan) == 'III/b' ? 'selected' : '' }}>
                                                III/b</option>
                                            <option value="III/c"
                                                {{ old('golongan', $struktur->golongan) == 'III/c' ? 'selected' : '' }}>
                                                III/c</option>
                                            <option value="III/d"
                                                {{ old('golongan', $struktur->golongan) == 'III/d' ? 'selected' : '' }}>
                                                III/d</option>
                                            <option value="IV/a"
                                                {{ old('golongan', $struktur->golongan) == 'IV/a' ? 'selected' : '' }}>IV/a
                                            </option>
                                            <option value="IV/b"
                                                {{ old('golongan', $struktur->golongan) == 'IV/b' ? 'selected' : '' }}>IV/b
                                            </option>
                                            <option value="IV/c"
                                                {{ old('golongan', $struktur->golongan) == 'IV/c' ? 'selected' : '' }}>IV/c
                                            </option>
                                            <option value="IV/d"
                                                {{ old('golongan', $struktur->golongan) == 'IV/d' ? 'selected' : '' }}>IV/d
                                            </option>
                                            <option value="IV/e"
                                                {{ old('golongan', $struktur->golongan) == 'IV/e' ? 'selected' : '' }}>IV/e
                                            </option>
                                        </select>
                                        @error('golongan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-0">
                                        <label for="unit_kerja" class="form-label fw-semibold">Unit Kerja</label>
                                        <select class="form-select @error('unit_kerja') is-invalid @enderror"
                                            id="unit_kerja" name="unit_kerja">
                                            <option value="">Pilih Unit Kerja</option>
                                            @foreach (\App\Models\Struktur::getUnitKerjaOptions() as $option)
                                                <option value="{{ $option }}"
                                                    {{ old('unit_kerja', $struktur->unit_kerja) == $option ? 'selected' : '' }}>
                                                    {{ $option }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('unit_kerja')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- PLT Section - Only for Kepala Dinas -->
                    @if ($struktur->jabatan === 'Kepala Dinas')
                        <div class="card border-warning mb-4">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-tie"></i> Pengaturan PLT (Pelaksana Tugas)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Status Keaktifan</label>
                                            <div class="alert alert-info">
                                                <small><i class="fas fa-info-circle"></i> Field Status Keaktifan sedang
                                                    dalam perbaikan. Sementara menggunakan Status utama.</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" id="memerlukan_plt"
                                                    name="memerlukan_plt" value="1"
                                                    {{ old('memerlukan_plt', $struktur->memerlukan_plt) ? 'checked' : '' }}
                                                    onchange="togglePltDetails()">
                                                <label class="form-check-label" for="memerlukan_plt">
                                                    Memerlukan PLT (Pelaksana Tugas)
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- PLT Details Section -->
                                <div id="plt-details"
                                    style="display: {{ old('memerlukan_plt', $struktur->memerlukan_plt) ? 'block' : 'none' }};">
                                    <hr>
                                    <h6 class="text-warning mb-3">Detail PLT</h6>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih Jenis PLT</label>
                                                <div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="plt_type"
                                                            id="plt_internal" value="internal"
                                                            {{ old('plt_struktur_id', $struktur->plt_struktur_id) ? 'checked' : '' }}
                                                            onchange="togglePltType()">
                                                        <label class="form-check-label" for="plt_internal">
                                                            PLT dari Internal (Anggota yang sudah ada)
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="plt_type"
                                                            id="plt_manual" value="manual"
                                                            {{ old('plt_nama_manual', $struktur->plt_nama_manual) ? 'checked' : '' }}
                                                            onchange="togglePltType()">
                                                        <label class="form-check-label" for="plt_manual">
                                                            PLT Manual (Input manual nama dan jabatan)
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="plt_mulai" class="form-label">Mulai PLT</label>
                                                        <input type="date"
                                                            class="form-control @error('plt_mulai') is-invalid @enderror"
                                                            id="plt_mulai" name="plt_mulai"
                                                            value="{{ old('plt_mulai', $struktur->plt_mulai?->format('Y-m-d')) }}">
                                                        @error('plt_mulai')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="plt_selesai" class="form-label">Selesai PLT</label>
                                                        <input type="date"
                                                            class="form-control @error('plt_selesai') is-invalid @enderror"
                                                            id="plt_selesai" name="plt_selesai"
                                                            value="{{ old('plt_selesai', $struktur->plt_selesai?->format('Y-m-d')) }}">
                                                        @error('plt_selesai')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                        <small class="text-muted">Kosongkan jika belum ada tanggal
                                                            selesai</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="plt_status" class="form-label">Status PLT</label>
                                                        <select
                                                            class="form-select @error('plt_status') is-invalid @enderror"
                                                            id="plt_status" name="plt_status">
                                                            <option value="">Pilih Status PLT</option>
                                                            <option value="aktif"
                                                                {{ old('plt_status', $struktur->plt_status) == 'aktif' ? 'selected' : '' }}>
                                                                Aktif</option>
                                                            <option value="tidak_aktif"
                                                                {{ old('plt_status', $struktur->plt_status) == 'tidak_aktif' ? 'selected' : '' }}>
                                                                Tidak Aktif</option>
                                                            <option value="selesai"
                                                                {{ old('plt_status', $struktur->plt_status) == 'selesai' ? 'selected' : '' }}>
                                                                Selesai</option>
                                                        </select>
                                                        @error('plt_status')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Internal PLT Selection -->
                                    <div id="plt-internal-section"
                                        style="display: {{ old('plt_struktur_id', $struktur->plt_struktur_id) ? 'block' : 'none' }};">
                                        <div class="mb-3">
                                            <label for="plt_struktur_id" class="form-label">Pilih PLT dari
                                                Internal</label>
                                            <select class="form-select @error('plt_struktur_id') is-invalid @enderror"
                                                id="plt_struktur_id" name="plt_struktur_id">
                                                <option value="">Pilih Anggota untuk PLT</option>
                                                @foreach ($struktur->getEligibleForPlt() as $eligible)
                                                    <option value="{{ $eligible->id }}"
                                                        {{ old('plt_struktur_id', $struktur->plt_struktur_id) == $eligible->id ? 'selected' : '' }}>
                                                        {{ $eligible->nama }} - {{ $eligible->jabatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('plt_struktur_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Manual PLT Input -->
                                    <div id="plt-manual-section"
                                        style="display: {{ old('plt_nama_manual', $struktur->plt_nama_manual) ? 'block' : 'none' }};">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="plt_nama_manual" class="form-label">Nama PLT</label>
                                                    <input type="text"
                                                        class="form-control @error('plt_nama_manual') is-invalid @enderror"
                                                        id="plt_nama_manual" name="plt_nama_manual"
                                                        value="{{ old('plt_nama_manual', $struktur->plt_nama_manual) }}"
                                                        placeholder="Nama lengkap PLT">
                                                    @error('plt_nama_manual')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="plt_jabatan_manual" class="form-label">Jabatan PLT</label>
                                                    <input type="text"
                                                        class="form-control @error('plt_jabatan_manual') is-invalid @enderror"
                                                        id="plt_jabatan_manual" name="plt_jabatan_manual"
                                                        value="{{ old('plt_jabatan_manual', $struktur->plt_jabatan_manual) }}"
                                                        placeholder="Jabatan PLT">
                                                    @error('plt_jabatan_manual')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="plt_asal_instansi" class="form-label">Asal
                                                        Instansi</label>
                                                    <input type="text"
                                                        class="form-control @error('plt_asal_instansi') is-invalid @enderror"
                                                        id="plt_asal_instansi" name="plt_asal_instansi"
                                                        value="{{ old('plt_asal_instansi', $struktur->plt_asal_instansi) }}"
                                                        placeholder="Asal instansi PLT">
                                                    @error('plt_asal_instansi')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-0">
                                        <label for="plt_keterangan" class="form-label">Keterangan PLT</label>
                                        <textarea class="form-control @error('plt_keterangan') is-invalid @enderror" id="plt_keterangan"
                                            name="plt_keterangan" rows="3" placeholder="Keterangan tambahan tentang PLT">{{ old('plt_keterangan', $struktur->plt_keterangan) }}</textarea>
                                        @error('plt_keterangan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>

            <!-- Action Buttons -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
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
            jabatanSelect.innerHTML = '<option value="">Loading...</option>';

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

                        // Check if this was the current selected value or old value
                        const selectedValue = '{{ old('jabatan', $struktur->jabatan) }}';
                        if (selectedValue === jabatan) {
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

        // Auto-select correct category on page load
        document.addEventListener('DOMContentLoaded', function() {
            const currentJabatan = '{{ old('jabatan', $struktur->jabatan) }}';

            if (currentJabatan) {
                console.log('Current jabatan found:', currentJabatan);

                // Find which category this jabatan belongs to
                Object.keys(jabatanData).forEach(category => {
                    if (jabatanData[category].includes(currentJabatan)) {
                        const categoryBtn = document.querySelector(`[data-category="${category}"]`);
                        if (categoryBtn) {
                            console.log('Auto-selecting category:', category);
                            selectCategory(category, categoryBtn);
                            return;
                        }
                    }
                });
            }

            // Initialize PLT sections visibility
            togglePltDetails();
            togglePltType();
        });

        // PLT Functions
        function togglePltDetails() {
            const checkbox = document.getElementById('memerlukan_plt');
            const details = document.getElementById('plt-details');

            if (checkbox && details) {
                details.style.display = checkbox.checked ? 'block' : 'none';

                if (checkbox.checked) {
                    // Auto-select plt type if not selected
                    const internalRadio = document.getElementById('plt_internal');
                    const manualRadio = document.getElementById('plt_manual');

                    if (!internalRadio.checked && !manualRadio.checked) {
                        internalRadio.checked = true;
                        togglePltType();
                    }
                }
            }
        }

        function togglePltType() {
            const internalRadio = document.getElementById('plt_internal');
            const manualRadio = document.getElementById('plt_manual');
            const internalSection = document.getElementById('plt-internal-section');
            const manualSection = document.getElementById('plt-manual-section');

            if (internalRadio && manualRadio && internalSection && manualSection) {
                if (internalRadio.checked) {
                    internalSection.style.display = 'block';
                    manualSection.style.display = 'none';

                    // Clear manual fields
                    document.getElementById('plt_nama_manual').value = '';
                    document.getElementById('plt_jabatan_manual').value = '';
                    document.getElementById('plt_asal_instansi').value = '';
                } else if (manualRadio.checked) {
                    internalSection.style.display = 'none';
                    manualSection.style.display = 'block';

                    // Clear internal selection
                    document.getElementById('plt_struktur_id').value = '';
                } else {
                    internalSection.style.display = 'none';
                    manualSection.style.display = 'none';
                }
            }
        }
    </script>
@endsection
