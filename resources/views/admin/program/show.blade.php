@extends('layouts.admin')

@section('title', 'Detail Program')
@section('page-title', 'Detail Program')
@section('page-subtitle', 'Lihat detail program kerja')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.konten.program.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h1 class="h3 mb-3">{{ $program->nama_program }}</h1>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Status:</strong> 
                            @if($program->status == 'Berjalan')
                                <span class="badge bg-primary">{{ $program->status }}</span>
                            @elseif($program->status == 'Selesai')
                                <span class="badge bg-success">{{ $program->status }}</span>
                            @else
                                <span class="badge bg-warning">{{ $program->status }}</span>
                            @endif
                        </p>
                        <p><strong>Lokasi:</strong> {{ $program->lokasi }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tanggal Mulai:</strong> {{ $program->tanggal_mulai ? $program->tanggal_mulai->format('d F Y') : '-' }}</p>
                        <p><strong>Tanggal Selesai:</strong> {{ $program->tanggal_selesai ? $program->tanggal_selesai->format('d F Y') : '-' }}</p>
                    </div>
                </div>

                <h6>Deskripsi Program:</h6>
                <div class="bg-light p-4 rounded">
                    <div class="content">
                        {!! $program->deskripsi !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-tools me-2"></i>
                    Aksi
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.konten.program.edit', $program) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i>Edit Program
                    </a>
                    <a href="{{ route('admin.konten.program.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar
                    </a>
                    <form action="{{ route('admin.konten.program.destroy', $program) }}" method="POST" class="d-inline delete-form" 
                          data-message="Apakah Anda yakin ingin menghapus program {{ $program->nama_program }}?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-trash me-1"></i>
                            Hapus Program
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    Informasi
                </h6>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $program->created_at ? $program->created_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $program->updated_at ? $program->updated_at->format('d M Y, H:i') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Durasi:</strong></td>
                        <td>{{ $program->tanggal_mulai->diffInDays($program->tanggal_selesai) }} hari</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
