@extends('layouts.admin')

@section('title', 'Detail Log Aktivitas')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Detail Log Aktivitas</h1>
                    <p class="text-muted">Detail lengkap aktivitas sistem</p>
                </div>
                <div>
                    <a href="{{ route('admin.activity-log.index') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <!-- Activity Detail Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-dark">
                            <i class="bi bi-clock-history me-2"></i>Informasi Aktivitas
                        </h5>
                        <div class="status-indicator status-{{ $activityLog->status_code < 400 ? 'success' : 'danger' }}">
                            @if($activityLog->status_code < 400)
                                <i class="bi bi-check-circle me-1"></i>
                            @else
                                <i class="bi bi-x-circle me-1"></i>
                            @endif
                            {{ $activityLog->status_code }}
                            @if($activityLog->status_code == 200)
                                <small class="ms-1">Berhasil</small>
                            @elseif($activityLog->status_code >= 400 && $activityLog->status_code < 500)
                                <small class="ms-1">Error Client</small>
                            @elseif($activityLog->status_code >= 500)
                                <small class="ms-1">Error Server</small>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-info-circle me-2"></i>Informasi Dasar
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Waktu</label>
                                <div class="fw-medium">
                                    {{ $activityLog->created_at->format('d F Y, H:i:s') }}
                                    <small class="text-muted">
                                        ({{ $activityLog->created_at->diffForHumans() }})
                                    </small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">User</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-3">
                                        {{ substr($activityLog->user->name ?? 'U', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-medium">{{ $activityLog->user->name ?? 'Unknown User' }}</div>
                                        <small class="text-muted">{{ $activityLog->user->email ?? 'No email' }}</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Aksi</label>
                                <div>
                                    <span class="badge bg-{{ $activityLog->action_color }} fs-6">
                                        {{ $activityLog->action_label }}
                                    </span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">IP Address</label>
                                <div class="font-monospace">{{ $activityLog->ip_address }}</div>
                            </div>
                        </div>

                        <!-- Technical Information -->
                        <div class="col-lg-6">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-gear me-2"></i>Informasi Teknis
                            </h6>
                            
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">HTTP Method</label>
                                <div>
                                    <span class="badge bg-info">{{ strtoupper($activityLog->method) }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">URL</label>
                                <div class="font-monospace small bg-light p-2 rounded">
                                    {{ $activityLog->url ?? '-' }}
                                </div>
                            </div>

                            @if($activityLog->model_type)
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Model</label>
                                <div>
                                    <span class="badge bg-secondary">{{ class_basename($activityLog->model_type) }}</span>
                                    @if($activityLog->model_id)
                                        <span class="text-muted">ID: {{ $activityLog->model_id }}</span>
                                    @endif
                                </div>
                            </div>
                            @endif

                            @if($activityLog->user_agent)
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">User Agent</label>
                                <div class="small bg-light p-2 rounded" style="word-break: break-all;">
                                    {{ $activityLog->user_agent }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-chat-square-text me-2"></i>Deskripsi Aktivitas
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0">{{ $activityLog->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Changes/Data Section (if exists) -->
                    @if($activityLog->changes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold mb-3 text-primary">
                                <i class="bi bi-list-ul me-2"></i>Perubahan Data
                            </h6>
                            <div class="bg-light p-3 rounded">
                                <pre class="mb-0"><code>{{ json_encode(json_decode($activityLog->changes), JSON_PRETTY_PRINT) }}</code></pre>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Action Buttons -->
                <div class="card-footer bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">
                            <i class="bi bi-clock me-1"></i>
                            Log ID: {{ $activityLog->id }}
                        </div>
                        <div class="btn-group-vertical">
                            <a href="{{ route('admin.activity-log.index') }}" 
                               class="btn btn-action btn-detail">
                                <i class="bi bi-list"></i> Semua Log
                            </a>
                            @if($activityLog->user)
                            <a href="{{ route('admin.activity-log.index', ['user_id' => $activityLog->user->id]) }}" 
                               class="btn btn-action btn-edit">
                                <i class="bi bi-person"></i> Log User Ini
                            </a>
                            @endif
                            <a href="{{ route('admin.activity-log.index', ['action' => $activityLog->action]) }}" 
                               class="btn btn-action btn-view">
                                <i class="bi bi-filter"></i> Aksi Serupa
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 0.875rem;
}

/* Status Indicator Improvements */
.status-indicator {
    display: inline-flex;
    align-items: center;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.375rem 0.75rem;
    border-radius: 0.5rem;
    border: 1px solid;
}

.status-success {
    background-color: #d1edff;
    color: #0c63e4;
    border-color: #b3d9ff;
}

.status-success i {
    color: #28a745;
}

.status-danger {
    background-color: #f8d7da;
    color: #721c24;
    border-color: #f5c6cb;
}

.status-danger i {
    color: #dc3545;
}

/* Code formatting */
pre {
    max-height: 300px;
    overflow-y: auto;
    font-size: 0.875rem;
}

/* Card enhancements */
.card {
    border-radius: 12px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid #e9ecef;
}

.card-footer {
    border-top: 1px solid #e9ecef;
}
</style>
@endpush
