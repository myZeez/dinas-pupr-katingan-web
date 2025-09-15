@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card border-0" style="border-radius: 20px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);">
                <div class="card-header bg-gradient-success text-white d-flex justify-content-between align-items-center" style="border-radius: 20px 20px 0 0;">
                    <div>
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-star me-2 text-secondary"></i>Manajemen Ulasan
                        </h5>
                        <small class="opacity-75 text-muted">Kelola ulasan dan rating dari masyarakat</small>
                    </div>
                    <span class="badge bg-light text-success fs-6">{{ $ulasans->count() }} Total</span>
                </div>
                
                <div class="card-body p-4">
                    @if($ulasans->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Rating</th>
                                        <th>Ulasan</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($ulasans as $index => $ulasan)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $ulasan->nama }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $ulasan->rating)
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-muted"></i>
                                                @endif
                                            @endfor
                                            <small class="text-muted">({{ $ulasan->rating }}/5)</small>
                                        </td>
                                        <td>{{ Str::limit($ulasan->pesan, 50) }}</td>
                                        <td>
                                            @if($ulasan->is_published)
                                                <span class="badge bg-success">Published</span>
                                            @else
                                                <span class="badge bg-secondary">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $ulasan->created_at->format('d/m/Y') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.ulasan.show', $ulasan) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.ulasan.destroy', $ulasan) }}" class="d-inline delete-form" 
                                                      data-message="Apakah Anda yakin ingin menghapus ulasan dari {{ $ulasan->nama }}?">
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
                            <i class="bi bi-star display-1 text-muted"></i>
                            <h4 class="text-muted mt-3">Belum Ada Ulasan</h4>
                            <p class="text-muted">Ulasan dari masyarakat akan muncul di sini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
