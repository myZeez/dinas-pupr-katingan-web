@extends('public.layouts.app')

@section('title', 'Struktur Organisasi')
@section('description', 'Struktur Organisasi Dinas PUPR Kabupaten Katingan - Kepemimpinan dan Staff')

@section('content')
<!-- Hero Section -->
<section class="py-4 text-white" style="background: linear-gradient(135deg, var(--secondary-color) 0%, #001f5c 100%);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <h1 class="display-6 fw-bold mb-3">Struktur Organisasi</h1>
                <p class="lead mb-3 fs-6">Struktur Organisasi Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan</p>
                <div class="d-flex flex-wrap gap-2">
                    <div class="badge bg-light text-dark px-2 py-1 fs-7">
                        <i class="bi bi-people me-1"></i>{{ $strukturs->count() }} Personil
                    </div>
                    <div class="badge bg-light text-dark px-2 py-1 fs-7">
                        <i class="bi bi-diagram-3 me-1"></i>{{ $strukturs->pluck('jabatan')->unique()->count() }} Jabatan
                    </div>
                </div>
            </div>
            <div class="col-lg-4" data-aos="fade-left">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}" class="text-white-50">Beranda</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Struktur</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>

<!-- Content Section -->
<section class="py-5">
    <div class="container-fluid px-4">
        @if($strukturs->count() > 0)
            @php
                // Filter struktur berdasarkan jabatan (case-insensitive)
                $kepalaDinas = $strukturs->filter(function($item) {
                    return stripos($item->jabatan, 'KEPALA DINAS') !== false;
                })->first();

                $sekretaris = $strukturs->filter(function($item) {
                    return stripos($item->jabatan, 'SEKRETARIS') !== false;
                })->first();

                $kepalaBidang = $strukturs->filter(function($item) {
                    return stripos($item->jabatan, 'KEPALA BIDANG') !== false ||
                           stripos($item->jabatan, 'PLT. KEPALA BIDANG') !== false;
                });

                $kasubag = $strukturs->filter(function($item) {
                    return stripos($item->jabatan, 'KEPALA SUB BAGIAN') !== false ||
                           stripos($item->jabatan, 'KASUBAG') !== false;
                });

                $staff = $strukturs->filter(function($item) {
                    return stripos($item->jabatan, 'KELOMPOK JABATAN') !== false ||
                           stripos($item->jabatan, 'STAFF') !== false ||
                           (stripos($item->jabatan, 'KEPALA') === false &&
                            stripos($item->jabatan, 'SEKRETARIS') === false);
                });
            @endphp

            <!-- Organization Tree Structure -->
            <div class="org-tree">

                <!-- Level 1: Kepala Dinas -->
                @if($kepalaDinas)
                <div class="tree-level level-1">
                    <div class="tree-node-wrapper">
                        <div class="tree-node kepala-dinas">
                            <div class="node-card">
                                <div class="node-badge">KEPALA DINAS</div>
                                @if($kepalaDinas->foto)
                                    <img src="{{ $kepalaDinas->foto_url }}" alt="{{ $kepalaDinas->nama }}" class="node-avatar">
                                @else
                                    <div class="node-avatar-placeholder">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                                <h5 class="node-name">{{ $kepalaDinas->nama }}</h5>
                                <p class="node-position">{{ $kepalaDinas->jabatan_label ?? 'Kepala Dinas' }}</p>
                                @if($kepalaDinas->golongan)
                                    <span class="node-info">{{ $kepalaDinas->golongan }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="tree-line-down"></div>
                    </div>
                </div>
                @endif

                <!-- Level 2: Sekretaris -->
                @if($sekretaris)
                <div class="tree-level level-2">
                    <div class="tree-node-wrapper">
                        <div class="tree-line-up"></div>
                        <div class="tree-node sekretaris">
                            <div class="node-card">
                                <div class="node-badge">SEKRETARIS</div>
                                @if($sekretaris->foto)
                                    <img src="{{ $sekretaris->foto_url }}" alt="{{ $sekretaris->nama }}" class="node-avatar">
                                @else
                                    <div class="node-avatar-placeholder">
                                        <i class="bi bi-person"></i>
                                    </div>
                                @endif
                                <h5 class="node-name">{{ $sekretaris->nama }}</h5>
                                <p class="node-position">{{ $sekretaris->jabatan_label ?? 'Sekretaris' }}</p>
                                @if($sekretaris->golongan)
                                    <span class="node-info">{{ $sekretaris->golongan }}</span>
                                @endif
                            </div>
                        </div>
                        @if($kepalaBidang->count() > 0)
                        <div class="tree-line-down"></div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Level 3: Kepala Bidang -->
                @if($kepalaBidang->count() > 0)
                <div class="tree-level level-3">
                    <div class="tree-branches">
                        <div class="branch-line-horizontal"></div>
                        <div class="tree-nodes-container">
                            @foreach($kepalaBidang as $index => $bidang)
                            <div class="tree-node-wrapper branch-item">
                                <div class="tree-line-up-branch"></div>
                                <div class="tree-node kepala-bidang">
                                    <div class="node-card">
                                        <div class="node-badge">KEPALA BIDANG</div>
                                        @if($bidang->foto)
                                            <img src="{{ $bidang->foto_url }}" alt="{{ $bidang->nama }}" class="node-avatar">
                                        @else
                                            <div class="node-avatar-placeholder">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                        <h5 class="node-name">{{ $bidang->nama }}</h5>
                                        <p class="node-position">{{ $bidang->jabatan_label }}</p>
                                        @if($bidang->golongan)
                                            <span class="node-info">{{ $bidang->golongan }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Level 4: Kasubag (if any) -->
                @if($kasubag->count() > 0)
                <div class="tree-level level-4">
                    <div class="tree-branches">
                        <div class="branch-line-horizontal"></div>
                        <div class="tree-nodes-container">
                            @foreach($kasubag as $subbag)
                            <div class="tree-node-wrapper branch-item">
                                <div class="tree-line-up-branch"></div>
                                <div class="tree-node kasubag">
                                    <div class="node-card small-card">
                                        <div class="node-badge small-badge">KASUBAG</div>
                                        @if($subbag->foto)
                                            <img src="{{ $subbag->foto_url }}" alt="{{ $subbag->nama }}" class="node-avatar small-avatar">
                                        @else
                                            <div class="node-avatar-placeholder small-avatar">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                        <h6 class="node-name small-name">{{ $subbag->nama }}</h6>
                                        <p class="node-position small-position">{{ $subbag->jabatan_label }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

            </div>

            <!-- Staff Section (Grid View) -->
            @if($staff->count() > 0)
            <div class="staff-section mt-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-primary">
                        <i class="bi bi-people-fill me-2"></i>Tim Staff
                    </h3>
                    <p class="text-muted">Personil pendukung operasional</p>
                </div>
                <div class="row g-3">
                    @foreach($staff as $anggota)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="staff-card">
                            @if($anggota->foto)
                                <img src="{{ $anggota->foto_url }}" alt="{{ $anggota->nama }}" class="staff-avatar">
                            @else
                                <div class="staff-avatar-placeholder">
                                    <i class="bi bi-person"></i>
                                </div>
                            @endif
                            <h6 class="staff-name">{{ $anggota->nama }}</h6>
                            <p class="staff-position">{{ $anggota->jabatan_label ?? 'Staff' }}</p>
                            @if($anggota->unit_kerja)
                                <small class="staff-unit">{{ $anggota->unit_kerja }}</small>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @else
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Data struktur organisasi belum tersedia.
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
// Animasi untuk node cards
document.addEventListener('DOMContentLoaded', function() {
    // Animate nodes on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    document.querySelectorAll('.tree-node').forEach(node => {
        node.style.opacity = '0';
        node.style.transform = 'translateY(20px)';
        node.style.transition = 'all 0.6s ease';
        observer.observe(node);
    });

    // Hover effects for cards
    const cards = document.querySelectorAll('.node-card, .staff-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>

<style>
/* Organization Tree Styles */
.org-tree {
    padding: 3rem 0;
    background: linear-gradient(to bottom, #f8f9fa 0%, #ffffff 100%);
}

.tree-level {
    margin: 0 auto;
    padding: 1.5rem 0;
}

.tree-node-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
}

/* Node Card Styles */
.node-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    border-radius: 20px;
    padding: 2rem 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    text-align: center;
    min-width: 280px;
    max-width: 320px;
    border: 2px solid #e3f2fd;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.node-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #2196f3 0%, #1976d2 100%);
}

.node-card:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 15px 40px rgba(33, 150, 243, 0.2);
    border-color: #2196f3;
}

.node-badge {
    background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
    color: white;
    font-size: 0.75rem;
    font-weight: bold;
    padding: 0.4rem 1rem;
    border-radius: 20px;
    margin-bottom: 1rem;
    display: inline-block;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.node-avatar {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #2196f3;
    margin: 0 auto 1rem;
    display: block;
    box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
}

.node-avatar-placeholder {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    border: 4px solid #2196f3;
    box-shadow: 0 5px 15px rgba(33, 150, 243, 0.3);
}

.node-avatar-placeholder i {
    font-size: 3rem;
    color: #2196f3;
}

.node-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.5rem;
    line-height: 1.3;
}

.node-position {
    font-size: 0.9rem;
    color: #2196f3;
    font-weight: 600;
    margin-bottom: 0.75rem;
}

.node-info {
    display: inline-block;
    background: #e3f2fd;
    color: #1976d2;
    font-size: 0.8rem;
    padding: 0.3rem 0.8rem;
    border-radius: 12px;
    font-weight: 600;
}

/* Small card variations */
.small-card {
    min-width: 220px;
    max-width: 240px;
    padding: 1.5rem 1rem;
}

.small-badge {
    font-size: 0.65rem;
    padding: 0.3rem 0.8rem;
}

.small-avatar,
.node-avatar.small-avatar,
.node-avatar-placeholder.small-avatar {
    width: 80px;
    height: 80px;
    border-width: 3px;
}

.small-avatar i {
    font-size: 2rem !important;
}

.small-name {
    font-size: 0.95rem;
}

.small-position {
    font-size: 0.8rem;
}

/* Tree Lines */
.tree-line-down,
.tree-line-up {
    width: 2px;
    height: 40px;
    background: linear-gradient(to bottom, #2196f3 0%, #1976d2 100%);
    position: relative;
}

.tree-line-down::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: #2196f3;
    border-radius: 50%;
}

.tree-line-up::before {
    content: '';
    position: absolute;
    top: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: #2196f3;
    border-radius: 50%;
}

/* Branches for multiple nodes */
.tree-branches {
    position: relative;
    width: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.branch-line-horizontal {
    width: 80%;
    height: 2px;
    background: linear-gradient(90deg, #2196f3 0%, #1976d2 50%, #2196f3 100%);
    margin-bottom: 40px;
    position: relative;
}

.tree-nodes-container {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 2rem;
    width: 100%;
}

.branch-item {
    flex: 0 1 auto;
}

.tree-line-up-branch {
    width: 2px;
    height: 40px;
    background: linear-gradient(to bottom, #2196f3 0%, #1976d2 100%);
    margin: 0 auto 1rem;
    position: relative;
}

.tree-line-up-branch::before {
    content: '';
    position: absolute;
    top: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 8px;
    height: 8px;
    background: #2196f3;
    border-radius: 50%;
    box-shadow: 0 0 0 3px rgba(33, 150, 243, 0.2);
}

/* Staff Section */
.staff-section {
    padding: 2rem 0;
}

.staff-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
    border: 1px solid #e3f2fd;
    transition: all 0.3s ease;
    height: 100%;
}

.staff-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(33, 150, 243, 0.15);
    border-color: #2196f3;
}

.staff-avatar {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #e3f2fd;
    margin: 0 auto 1rem;
    display: block;
}

.staff-avatar-placeholder {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    border: 3px solid #2196f3;
}

.staff-avatar-placeholder i {
    font-size: 2.5rem;
    color: #2196f3;
}

.staff-name {
    font-size: 1rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.4rem;
}

.staff-position {
    font-size: 0.85rem;
    color: #2196f3;
    margin-bottom: 0.5rem;
}

.staff-unit {
    color: #666;
    font-size: 0.75rem;
    display: block;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .tree-nodes-container {
        gap: 1.5rem;
    }

    .node-card {
        min-width: 240px;
        max-width: 280px;
    }
}

@media (max-width: 768px) {
    .org-tree {
        padding: 2rem 0;
    }

    .tree-nodes-container {
        flex-direction: column;
        align-items: center;
        gap: 2rem;
    }

    .branch-line-horizontal {
        display: none;
    }

    .tree-line-up-branch {
        height: 20px;
    }

    .node-card {
        min-width: 260px;
        max-width: 300px;
    }

    .branch-item {
        width: 100%;
        max-width: 320px;
    }
}

@media (max-width: 576px) {
    .node-card {
        min-width: 100%;
        padding: 1.5rem 1rem;
    }

    .node-avatar,
    .node-avatar-placeholder {
        width: 100px;
        height: 100px;
    }

    .staff-card {
        padding: 1rem;
    }
}

/* Animation keyframes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.tree-node {
    animation: fadeInUp 0.6s ease forwards;
}

/* Level specific animations */
.level-1 .tree-node {
    animation-delay: 0.1s;
}

.level-2 .tree-node {
    animation-delay: 0.3s;
}

.level-3 .tree-node {
    animation-delay: 0.5s;
}

.level-4 .tree-node {
    animation-delay: 0.7s;
}
</style>

@endsection
