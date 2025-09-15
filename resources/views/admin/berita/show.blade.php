@extends('layouts.admin')

@section('title', 'Detail Berita')
@section('page-title', 'Detail Berita')
@section('page-subtitle', 'Lihat detail informasi berita')

@section('content')

<!-- Back Button -->
<div class="mb-4 fade-in-up">
    <a href="{{ route('admin.konten.index', ['tab' => 'berita']) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar Berita
    </a>
</div>

<div class="row g-4 fade-in-up">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                @if($berita->thumbnail)
                    <img src="{{ asset('storage/' . $berita->thumbnail) }}" alt="{{ $berita->judul }}" class="img-fluid rounded-lg mb-4" style="max-height: 400px; width: 100%; object-fit: cover;">
                @endif
                
                <h1 class="h3 mb-3 fw-bold">{{ $berita->judul }}</h1>
                
                <div class="d-flex align-items-center text-muted mb-4">
                    <i class="bi bi-calendar-event me-2"></i>
                    <span>{{ $berita->tanggal ? $berita->tanggal->format('d F Y') : '-' }}</span>
                    <span class="mx-2">•</span>
                    <i class="bi bi-clock me-2"></i>
                    <span>{{ $berita->created_at ? $berita->created_at->format('H:i') : '-' }} WIB</span>
                </div>

                <div class="content">
                    {!! $berita->konten !!}
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-gear me-2"></i>
                    Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.konten.berita.edit', $berita) }}" class="btn btn-warning">
                        <i class="bi bi-pencil me-1"></i>Edit Berita
                    </a>
                    <a href="{{ route('admin.konten.index', ['tab' => 'berita']) }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                    <form action="{{ route('admin.konten.berita.destroy', $berita) }}" method="POST" class="d-inline" 
                          onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash me-1"></i>Hapus Berita
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-info-circle me-2"></i>
                    Informasi
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Slug:</strong></td>
                        <td>{{ $berita->slug }}</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $berita->created_at ? $berita->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $berita->updated_at ? $berita->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Karakter:</strong></td>
                        <td>{{ strlen($berita->konten) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
