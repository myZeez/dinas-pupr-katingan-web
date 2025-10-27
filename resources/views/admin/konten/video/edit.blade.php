@extends('layouts.admin')

@section('title', 'Edit Video')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Video</h1>
        <a href="{{ route('admin.konten.video.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @include('components.gif-notifications')

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Video</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.konten.video.update', $video) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Video *</label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $video->title) }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      required>{{ old('description', $video->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="video_url" class="form-label">URL Video *</label>
                            <input type="url" 
                                   class="form-control @error('video_url') is-invalid @enderror" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url', $video->video_url) }}" 
                                   placeholder="https://www.youtube.com/watch?v=..."
                                   required>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Mendukung: YouTube, Vimeo, atau URL video langsung</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail</label>
                            
                            @if($video->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $video->thumbnail) }}" 
                                         alt="Current Thumbnail" 
                                         class="img-fluid rounded" 
                                         style="max-height: 150px;">
                                    <div class="form-text">
                                        <small>Thumbnail saat ini</small>
                                    </div>
                                </div>
                            @endif
                            
                            <input type="file" 
                                   class="form-control @error('thumbnail') is-invalid @enderror" 
                                   id="thumbnail" 
                                   name="thumbnail" 
                                   accept="image/*">
                            @error('thumbnail')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <small>Format: JPG, PNG. Maksimal 5MB. Kosongkan jika tidak ingin mengubah</small>
                            </div>
                            
                            <div id="thumbnail-preview" class="mt-3" style="display: none;">
                                <img id="preview-image" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="active" {{ old('status', $video->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $video->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <img src="{{ asset('Icon/Succes.gif') }}" alt="Update" style="width: 20px; height: 20px; margin-right: 5px;">
                            Update Video
                        </button>
                        <a href="{{ route('admin.konten.video.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        <a href="{{ route('admin.konten.video.show', $video) }}" class="btn btn-info ms-2">
                            <i class="bi bi-eye"></i> Lihat Video
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Preview thumbnail
    $('#thumbnail').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-image').attr('src', e.target.result);
                $('#thumbnail-preview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#thumbnail-preview').hide();
        }
    });
});
</script>
@endpush