@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0" style="border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);">
                <div class="card-header bg-gradient-primary text-white d-flex justify-content-between align-items-center" style="border-radius: 20px 20px 0 0;">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-chat-dots me-2"></i>Manajemen Pengaduan
                        </h5>
                        <small class="opacity-75 text-secondary">Kelola pengaduan dari masyarakat</small>
                    </div>
                    <span class="badge bg-light text-primary fs-6">{{ $pengaduans->count() }} Total</span>
                </div>
                
                <div class="card-body p-4">
                    @if($pengaduans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Subjek</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pengaduans as $index => $pengaduan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $pengaduan->nama }}</td>
                                        <td>{{ $pengaduan->email }}</td>
                                        <td>{{ Str::limit($pengaduan->subjek, 50) }}</td>
                                        <td>
                                            @if($pengaduan->status == 'pending')
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($pengaduan->status == 'processed')
                                                <span class="badge bg-info">Diproses</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </td>
                                        <td>{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.pengaduan.destroy', $pengaduan) }}" class="d-inline delete-form"
                                                      data-message="Apakah Anda yakin ingin menghapus pengaduan dari {{ $pengaduan->nama }}?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-inbox display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">Belum Ada Pengaduan</h4>
                            <p class="text-muted">Pengaduan dari masyarakat akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
