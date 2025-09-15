@extends('layouts.admin')

@section('title', 'Detail Video')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Video</h1>
        <div>
            <a href="{{ route('admin.konten.video.edit', $video) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.konten.video.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @include('components.gif-notifications')

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Preview Video</h6>
                </div>
                <div class="card-body">
                    @if(strpos($video->video_url, 'youtube.com') !== false || strpos($video->video_url, 'youtu.be') !== false)
                        @php
                            $video_id = '';
                            if (strpos($video->video_url, 'youtube.com') !== false) {
                                parse_str(parse_url($video->video_url, PHP_URL_QUERY), $params);
                                $video_id = $params['v'] ?? '';
                            } elseif (strpos($video->video_url, 'youtu.be') !== false) {
                                $video_id = substr(parse_url($video->video_url, PHP_URL_PATH), 1);
                            }
                        @endphp
                        @if($video_id)
                            <div class="ratio ratio-16x9">
                                <iframe src="https://www.youtube.com/embed/{{ $video_id }}" 
                                        allowfullscreen></iframe>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                URL YouTube tidak valid: <a href="{{ $video->video_url }}" target="_blank">{{ $video->video_url }}</a>
                            </div>
                        @endif
                    @elseif(strpos($video->video_url, 'vimeo.com') !== false)
                        @php
                            $video_id = substr(parse_url($video->video_url, PHP_URL_PATH), 1);
                        @endphp
                        <div class="ratio ratio-16x9">
                            <iframe src="https://player.vimeo.com/video/{{ $video_id }}" 
                                    allowfullscreen></iframe>
                        </div>
                    @else
                        <div class="ratio ratio-16x9">
                            <video controls class="w-100">
                                <source src="{{ $video->video_url }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Video</h6>
                </div>
                <div class="card-body">
                    @if($video->thumbnail)
                        <div class="mb-3 text-center">
                            <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                 alt="Thumbnail" 
                                 class="img-fluid rounded"
                                 style="max-height: 200px;">
                        </div>
                    @endif

                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Judul:</strong></td>
                            <td>{{ $video->title }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge {{ $video->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                    {{ $video->status == 'active' ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Slug:</strong></td>
                            <td><code>{{ $video->slug }}</code></td>
                        </tr>
                        <tr>
                            <td><strong>URL Video:</strong></td>
                            <td>
                                <a href="{{ $video->video_url }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-link-45deg"></i> Buka Link
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat:</strong></td>
                            <td>{{ $video->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Diperbarui:</strong></td>
                            <td>{{ $video->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>

                    <div class="mt-3">
                        <strong>Deskripsi:</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            {{ $video->description }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.konten.video.toggle-status', $video) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn {{ $video->status == 'active' ? 'btn-warning' : 'btn-success' }} w-100">
                                <img src="{{ asset('icon/loading.gif') }}" alt="Toggle" style="width: 20px; height: 20px; margin-right: 5px;">
                                {{ $video->status == 'active' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        
                        <form action="{{ route('admin.konten.video.destroy', $video) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menghapus video ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <img src="{{ asset('icon/Delete.gif') }}" alt="Delete" style="width: 20px; height: 20px; margin-right: 5px;">
                                Hapus Video
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
