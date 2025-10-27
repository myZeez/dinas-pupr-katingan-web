@extends('layouts.admin')

@section('title', 'Log Aktivitas')

@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Log Aktivitas Sistem</h1>
                        <p class="text-muted">Monitor aktivitas admin dan perubahan data</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                            data-bs-target="#cleanupModal">
                            <i class="bi bi-trash3"></i> Bersihkan Log Lama
                        </button>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card mb-4">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.activity-log.index') }}">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label class="form-label">Aksi</label>
                                    <select name="action" class="form-select">
                                        <option value="">Semua Aksi</option>
                                        @foreach ($actions as $action)
                                            <option value="{{ $action }}"
                                                {{ request('action') == $action ? 'selected' : '' }}>
                                                {{ ucfirst($action) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">User</label>
                                    <select name="user_id" class="form-select">
                                        <option value="">Semua User</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Dari Tanggal</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label">Sampai Tanggal</label>
                                    <input type="date" name="date_to" class="form-control"
                                        value="{{ request('date_to') }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Cari</label>
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Cari deskripsi..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label">&nbsp;</label>
                                    <div class="d-flex gap-1">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-search"></i>
                                        </button>
                                        @if (request()->hasAny(['action', 'user_id', 'date_from', 'date_to', 'search']))
                                            <a href="{{ route('admin.activity-log.index') }}"
                                                class="btn btn-outline-danger">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Activity Log Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Waktu</th>
                                        <th>User</th>
                                        <th>Aksi</th>
                                        <th>Deskripsi</th>
                                        <th>Model</th>
                                        <th>IP Address</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($activities as $activity)
                                        <tr>
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <span
                                                        class="fw-medium">{{ $activity->created_at->format('d/m/Y') }}</span>
                                                    <small
                                                        class="text-muted">{{ $activity->created_at->format('H:i:s') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div
                                                        class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center text-white me-2">
                                                        {{ substr($activity->user->name ?? 'U', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $activity->user->name ?? 'Unknown' }}
                                                        </div>
                                                        <small
                                                            class="text-muted">{{ $activity->user->email ?? 'No email' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $activity->action_color }}">
                                                    {{ ucfirst($activity->action) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-medium">{{ $activity->description }}</div>
                                                @if ($activity->url)
                                                    <small class="text-muted d-block">{{ $activity->method }}
                                                        {{ Str::limit($activity->url, 50) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($activity->model_type)
                                                    <div class="small">
                                                        <div>{{ class_basename($activity->model_type) }}</div>
                                                        @if ($activity->model_id)
                                                            <small class="text-muted">ID: {{ $activity->model_id }}</small>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-muted">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="font-monospace small">{{ $activity->ip_address }}</span>
                                            </td>
                                            <td>
                                                <div
                                                    class="status-indicator status-{{ $activity->status_code < 400 ? 'success' : 'danger' }}">
                                                    @if ($activity->status_code < 400)
                                                        <i class="bi bi-check-circle me-1"></i>
                                                    @else
                                                        <i class="bi bi-x-circle me-1"></i>
                                                    @endif
                                                    {{ $activity->status_code }}
                                                    @if ($activity->status_code == 200)
                                                        <small class="ms-1">Berhasil</small>
                                                    @elseif($activity->status_code >= 400 && $activity->status_code < 500)
                                                        <small class="ms-1">Error Client</small>
                                                    @elseif($activity->status_code >= 500)
                                                        <small class="ms-1">Error Server</small>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.activity-log.show', $activity) }}"
                                                    class="btn btn-outline-info btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                                                <h5 class="mt-3">Belum ada log aktivitas</h5>
                                                <p class="text-muted">Log aktivitas akan muncul saat admin melakukan aksi
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if ($activities->hasPages())
                            <div class="d-flex justify-content-center mt-4">
                                @include('components.custom-pagination', ['paginator' => $activities])
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cleanup Modal -->
    <div class="modal fade" id="cleanupModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bersihkan Log Lama</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.activity-log.cleanup') }}" method="POST" class="delete-form"
                    data-message="Apakah Anda yakin ingin menghapus log lama? Tindakan ini tidak dapat dibatalkan!">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="days" class="form-label">Hapus log yang lebih dari</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="days" name="days" value="30"
                                    min="1" max="365">
                                <span class="input-group-text">hari</span>
                            </div>
                            <div class="form-text">Log yang lebih lama dari jumlah hari ini akan dihapus permanen.</div>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Pastikan Anda telah
                            mempertimbangkan periode yang tepat.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">
                            <img src="{{ asset('Icon/Delete.gif') }}" alt="Delete"
                                style="width: 20px; height: 20px; margin-right: 5px;">
                            Bersihkan Log
                        </button>
                    </div>
                </form>
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

        .status-warning {
            background-color: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
        }

        .status-warning i {
            color: #ffc107;
        }

        .status-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }

        .status-info i {
            color: #17a2b8;
        }
    </style>
@endpush
