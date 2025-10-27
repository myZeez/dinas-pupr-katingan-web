@extends('layouts.admin')

@section('title', 'Kelola Video')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">Kelola Video</h1>
            <a href="{{ route('admin.konten.video.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Video
            </a>
        </div>

        @include('components.gif-notifications')

        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Video</h6>
            </div>
            <div class="card-body">
                @if ($videos->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Thumbnail</th>
                                    <th>Judul</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $index => $video)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($video->thumbnail)
                                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="Thumbnail"
                                                    style="width: 60px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light text-center"
                                                    style="width: 60px; height: 40px; line-height: 40px;">
                                                    <i class="bi bi-play-circle text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $video->title }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($video->description, 50) }}</small>
                                        </td>
                                        <td>
                                            <span
                                                class="badge {{ $video->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $video->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $video->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.konten.video.show', $video) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.konten.video.edit', $video) }}"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.konten.video.toggle-status', $video) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm {{ $video->status == 'active' ? 'btn-secondary' : 'btn-success' }}">
                                                        <i
                                                            class="bi bi-{{ $video->status == 'active' ? 'eye-slash' : 'eye' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('admin.konten.video.destroy', $video) }}"
                                                    method="POST" style="display: inline-block;"
                                                    onsubmit="return confirm('Yakin ingin menghapus video ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
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

                    <div class="d-flex justify-content-center">
                        @include('components.custom-pagination', ['paginator' => $videos])
                    </div>
                @else
                    <div class="text-center py-4">
                        <img src="{{ asset('Icon/loading.gif') }}" alt="No Data" style="width: 64px; height: 64px;">
                        <h5 class="mt-3">Belum ada video</h5>
                        <p class="text-muted">Video yang ditambahkan akan muncul di sini</p>
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
                    [4, "desc"]
                ]
            });
        });
    </script>
@endpush
