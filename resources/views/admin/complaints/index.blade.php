@extends('layouts.admin')

@section('title', 'Kelola Pengaduan')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Pengaduan</h1>
        </div>

        @include('components.gif-notifications')

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengaduan</h6>
            </div>
            <div class="card-body">
                @if ($complaints->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
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
                                @foreach ($complaints as $index => $complaint)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $complaint->name }}</td>
                                        <td>{{ $complaint->email }}</td>
                                        <td>{{ Str::limit($complaint->subject, 50) }}</td>
                                        <td>
                                            <span
                                                class="badge
                                        @if ($complaint->status == 'pending') badge-warning
                                        @elseif($complaint->status == 'in_progress') badge-info
                                        @elseif($complaint->status == 'resolved') badge-success
                                        @else badge-danger @endif">
                                                {{ $complaint->status_label }}
                                            </span>
                                        </td>
                                        <td>{{ $complaint->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.complaints.show', $complaint) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> Detail
                                                </a>
                                                <form action="{{ route('admin.complaints.destroy', $complaint) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Yakin ingin menghapus pengaduan ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        @include('components.custom-pagination', ['paginator' => $complaints])
                    </div>
                @else
                    <div class="text-center py-4">
                        <img src="{{ asset('Icon/loading.gif') }}" alt="No Data" style="width: 64px; height: 64px;">
                        <h5 class="mt-3">Belum ada pengaduan</h5>
                        <p class="text-muted">Pengaduan dari masyarakat akan muncul di sini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                },
                "pageLength": 25,
                "order": [
                    [5, "desc"]
                ]
            });
        });
    </script>
@endpush
