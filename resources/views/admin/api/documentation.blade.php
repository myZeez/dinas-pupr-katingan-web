@extends('layouts.admin')

@section('title', 'API Documentation')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="fas fa-code"></i> API Documentation
            </h1>
            <p class="text-muted">Dokumentasi API DINAS PUPR Kabupaten Katingan dengan Swagger UI</p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ url('api/documentation') }}" target="_blank" class="btn btn-primary">
                <i class="fas fa-external-link-alt"></i> Buka Swagger UI
            </a>
            <button type="button" class="btn btn-outline-secondary" onclick="showApiInfo()">
                <i class="fas fa-info-circle"></i> Info API
            </button>
        </div>
    </div>

    <!-- API Overview Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-primary mb-3">
                        <i class="fas fa-heartbeat fa-2x"></i>
                    </div>
                    <h5 class="card-title">Health Check</h5>
                    <p class="card-text small text-muted">Endpoint untuk mengecek status API</p>
                    <span class="badge bg-success">GET /api/health</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-info mb-3">
                        <i class="fas fa-newspaper fa-2x"></i>
                    </div>
                    <h5 class="card-title">Berita API</h5>
                    <p class="card-text small text-muted">Endpoint untuk mengakses data berita</p>
                    <span class="badge bg-info">GET /api/v1/berita</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-warning mb-3">
                        <i class="fas fa-tasks fa-2x"></i>
                    </div>
                    <h5 class="card-title">Program API</h5>
                    <p class="card-text small text-muted">Endpoint untuk mengakses data program</p>
                    <span class="badge bg-warning">GET /api/v1/program</span>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card text-center h-100 border-0 shadow-sm">
                <div class="card-body">
                    <div class="text-danger mb-3">
                        <i class="fas fa-comments fa-2x"></i>
                    </div>
                    <h5 class="card-title">Pengaduan API</h5>
                    <p class="card-text small text-muted">Endpoint untuk submit & track pengaduan</p>
                    <span class="badge bg-danger">POST /api/v1/pengaduan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- API Documentation Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-book"></i> Swagger UI Integration
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6><i class="fas fa-info-circle"></i> Tentang API Documentation</h6>
                        <p class="mb-2">Dokumentasi API ini menggunakan <strong>Swagger UI</strong> yang menyediakan interface interaktif untuk:</p>
                        <ul class="mb-0">
                            <li>📖 Melihat seluruh endpoint yang tersedia</li>
                            <li>🧪 Testing API langsung dari browser</li>
                            <li>📝 Melihat request/response schema</li>
                            <li>🔍 Mencoba parameter dan payload</li>
                        </ul>
                    </div>

                    <!-- Embedded Swagger UI -->
                    <div class="border rounded p-3 bg-light">
                        <h6 class="mb-3">🚀 Quick Access</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">📋 Available Endpoints:</h6>
                                <ul class="list-unstyled">
                                    <li><code class="text-success">GET /api/health</code> - Health check</li>
                                    <li><code class="text-info">GET /api/v1/berita</code> - List berita</li>
                                    <li><code class="text-info">GET /api/v1/berita/{id}</code> - Get berita detail</li>
                                    <li><code class="text-warning">GET /api/v1/program</code> - List program</li>
                                    <li><code class="text-warning">GET /api/v1/program/{id}</code> - Get program detail</li>
                                    <li><code class="text-danger">POST /api/v1/pengaduan</code> - Submit pengaduan</li>
                                    <li><code class="text-danger">GET /api/v1/pengaduan/track/{ticket}</code> - Track pengaduan</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">🔧 Response Format:</h6>
                                <pre class="bg-dark text-light p-3 rounded small"><code>{
                                    "status": "success",
                                    "message": "Data retrieved successfully",
                                    "data": {
                                        // Response data here
                                    }
                                    }</code>
                                </pre>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="{{ url('api/documentation') }}" target="_blank" class="btn btn-primary btn-lg">
                                <i class="fas fa-external-link-alt"></i> Buka Swagger UI Lengkap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- API Testing Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-vial"></i> Quick API Test</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Test Endpoint</label>
                        <select class="form-select" id="testEndpoint">
                            <option value="/api/health">Health Check</option>
                            <option value="/api/v1/berita">Get Berita List</option>
                            <option value="/api/v1/program">Get Program List</option>
                        </select>
                    </div>
                    <button type="button" class="btn btn-success" onclick="testApi()">
                        <i class="fas fa-play"></i> Test API
                    </button>
                    <div id="apiResult" class="mt-3" style="display: none;">
                        <h6>Response:</h6>
                        <pre class="bg-dark text-light p-3 rounded small" id="apiResponse"></pre>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-download"></i> Download Documentation</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted">Download dokumentasi API dalam format JSON atau YAML:</p>
                    <div class="d-grid gap-2">
                        <a href="{{ url('storage/api-docs/api-docs.json') }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-file-code"></i> Download JSON
                        </a>
                        <a href="{{ url('api/documentation') }}" target="_blank" class="btn btn-outline-secondary">
                            <i class="fas fa-external-link-alt"></i> View Swagger UI
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showApiInfo() {
    Swal.fire({
        title: 'API Information',
        html: `
            <div style="text-align: left;">
                <h6>🌐 Base URL:</h6>
                <code>${window.location.origin}/api</code>
                
                <h6 class="mt-3">📊 API Version:</h6>
                <code>v1.0.0</code>
                
                <h6 class="mt-3">📝 Content-Type:</h6>
                <code>application/json</code>
                
                <h6 class="mt-3">🔒 Authentication:</h6>
                <code>Public API (No auth required for read operations)</code>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'OK'
    });
}

async function testApi() {
    const endpoint = document.getElementById('testEndpoint').value;
    const resultDiv = document.getElementById('apiResult');
    const responseDiv = document.getElementById('apiResponse');
    
    showLoading('Testing API...', 'Mengirim request ke endpoint');
    
    try {
        const response = await fetch(window.location.origin + endpoint);
        const data = await response.json();
        
        hideLoading();
        resultDiv.style.display = 'block';
        responseDiv.textContent = JSON.stringify(data, null, 2);
        
        showSuccess('API Test Berhasil!', `Response dari ${endpoint}`);
    } catch (error) {
        hideLoading();
        showError('API Test Gagal!', error.message);
    }
}

// Auto-load API health status on page load
document.addEventListener('DOMContentLoaded', function() {
    fetch(window.location.origin + '/api/health')
        .then(response => response.json())
        .then(data => {
            if (data.status === 'ok') {
                // Show success indicator somewhere
                console.log('API is healthy:', data);
            }
        })
        .catch(error => {
            console.error('API health check failed:', error);
        });
});
</script>
@endsection
