@extends('public.layouts.app')

@section('title', $berita->judul)
@section('description', Str::limit(strip_tags($berita->konten), 160))

@section('content')
<!-- Article Header -->
<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-4" data-aos="fade-up">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('public.home') }}">Beranda</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('public.berita') }}">Berita</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($berita->judul, 30) }}</li>
                    </ol>
                </nav>

                <!-- Article Meta -->
                <div class="mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="d-flex align-items-center text-muted mb-3">
                        <i class="bi bi-calendar3 me-2"></i>
                        <span class="me-4">{{ $berita->tanggal ? $berita->tanggal->format('d F Y') : $berita->created_at->format('d F Y') }}</span>

                        @if($berita->author)
                        <i class="bi bi-person-fill me-2"></i>
                        <span class="me-4">{{ $berita->author }}</span>
                        @endif

                        <i class="bi bi-eye me-2"></i>
                        <span>{{ $berita->views_count ?? 0 }} kali dibaca</span>
                    </div>
                </div>

                <!-- Article Title -->
                <h1 class="display-6 fw-bold mb-4 no-select" style="color: var(--secondary-color);" data-aos="fade-up" data-aos-delay="200">
                    {{ $berita->judul }}
                </h1>

                <!-- Featured Image -->
                @if($berita->thumbnail)
                <div class="mb-5" data-aos="fade-up" data-aos-delay="300">
                    <div class="ratio ratio-16x9">
                        <img src="{{ $berita->thumbnail_url }}"
                             class="rounded-4 shadow-lg object-fit-cover no-select"
                             alt="{{ $berita->judul }}"
                             onerror="this.parentElement.parentElement.style.display='none';">
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Article Content -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Content -->
                <div class="content mb-5 no-select" data-aos="fade-up">
                    {!! nl2br($berita->konten) !!}
                </div>

                <!-- Share Buttons -->
                <div class="border-top pt-4 mb-5" data-aos="fade-up">
                    <h6 class="fw-bold mb-3">Bagikan Artikel:</h6>
                    <div class="d-flex gap-2">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                           target="_blank" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-facebook me-1"></i>Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($berita->judul) }}"
                           target="_blank" class="btn btn-outline-info btn-sm">
                            <i class="bi bi-twitter me-1"></i>Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($berita->judul . ' - ' . request()->fullUrl()) }}"
                           target="_blank" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-whatsapp me-1"></i>WhatsApp
                        </a>
                        <button class="btn btn-outline-secondary btn-sm" onclick="copyToClipboard()">
                            <i class="bi bi-link-45deg me-1"></i>Salin Link
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related News -->
@if($relatedBerita->count() > 0)
<section class="py-5" style="background-color: var(--bg-light);">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title no-select">Berita Terkait</h2>
            <p class="section-subtitle no-select">Artikel lainnya yang mungkin menarik untuk Anda</p>
        </div>

        <div class="row g-4">
            @foreach($relatedBerita as $related)
            <div class="col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <article class="card h-100 border-0 shadow-sm">
                    <div class="position-relative overflow-hidden" style="height: 200px;">
                        @if($related->thumbnail)
                            <img src="{{ $related->thumbnail_url }}"
                                 class="card-img-top h-100 no-select"
                                 alt="{{ $related->judul }}"
                                 style="object-fit: cover;"
                                 onerror="this.style.display='none'; this.parentElement.querySelector('.bg-light').style.display='flex';">
                        @endif

                        <div class="bg-light h-100 d-flex align-items-center justify-content-center"
                             style="{{ $related->thumbnail ? 'display: none;' : 'display: flex;' }}">
                            <i class="bi bi-image text-muted fs-1"></i>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-2 text-muted small mb-2 no-select">
                            <span>
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $related->tanggal ? $related->tanggal->format('d M Y') : $related->created_at->format('d M Y') }}
                            </span>
                            @if($related->author)
                                <span>
                                    <i class="bi bi-person-fill me-1"></i>
                                    {{ $related->author }}
                                </span>
                            @endif
                        </div>
                        <h5 class="card-title fw-bold mt-2 mb-3 no-select">
                            <a href="{{ route('public.berita.show', $related->slug) }}"
                               class="text-decoration-none" style="color: var(--secondary-color);">
                                {{ Str::limit($related->judul, 60) }}
                            </a>
                        </h5>
                        <p class="card-text text-muted no-select">
                            {{ Str::limit(strip_tags($related->konten), 100) }}
                        </p>
                        <a href="{{ route('public.berita.show', $related->slug) }}"
                           class="btn btn-outline-primary btn-sm">
                            Baca Artikel
                        </a>
                    </div>
                </article>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-5" data-aos="fade-up">
            <a href="{{ route('public.berita') }}" class="btn btn-primary">
                <i class="bi bi-grid me-2"></i>Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
@endif

<!-- Back to Top -->
<button class="btn btn-primary rounded-circle position-fixed bottom-0 end-0 m-4"
        id="backToTop" style="width: 50px; height: 50px; display: none; z-index: 1000;">
    <i class="bi bi-arrow-up"></i>
</button>
@endsection

@push('styles')
<style>
/* Text Selection Prevention */
.no-select {
    -webkit-user-select: none; /* Safari */
    -moz-user-select: none; /* Firefox */
    -ms-user-select: none; /* Internet Explorer/Edge */
    user-select: none; /* Standard syntax */
}

/* Additional protection for images */
.no-select img {
    -webkit-touch-callout: none;
    -webkit-user-drag: none;
    -khtml-user-drag: none;
    -moz-user-drag: none;
    -o-user-drag: none;
    user-drag: none;
    pointer-events: none;
}

/* Disable right-click on protected content */
.no-select {
    -webkit-touch-callout: none;
    -webkit-tap-highlight-color: transparent;
}

/* Content Styles */
.content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #444;
}

.content p {
    margin-bottom: 1.5rem;
}

.content h1, .content h2, .content h3, .content h4, .content h5, .content h6 {
    color: var(--secondary-color);
    font-weight: 600;
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.content img {
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1.5rem 0;
}

.content blockquote {
    border-left: 4px solid var(--primary-color);
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    background: var(--bg-light);
    padding: 1.5rem;
    border-radius: 0 10px 10px 0;
}

.breadcrumb-item a {
    text-decoration: none;
    color: var(--text-light);
}

.breadcrumb-item a:hover {
    color: var(--primary-color);
}

.card:hover {
    transform: translateY(-5px);
    transition: all 0.3s ease;
}

.card:hover .card-title a {
    color: var(--primary-color) !important;
}

#backToTop {
    transition: all 0.3s ease;
}

#backToTop:hover {
    transform: translateY(-3px);
}

/* Disable text highlighting with alternative methods */
::selection {
    background: transparent;
}

::-moz-selection {
    background: transparent;
}

/* Additional protection for content area */
.content::selection {
    background: transparent;
}

.content::-moz-selection {
    background: transparent;
}
</style>
@endpush

@push('scripts')
<script>
// Copy to clipboard function
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Show success message
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="bi bi-check me-1"></i>Tersalin!';
        btn.classList.remove('btn-outline-secondary');
        btn.classList.add('btn-success');

        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('btn-success');
            btn.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

// Back to top button
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Enhanced protection against text selection
document.addEventListener('DOMContentLoaded', function() {
    // Disable right-click context menu on protected content
    const protectedElements = document.querySelectorAll('.no-select');
    protectedElements.forEach(element => {
        element.addEventListener('contextmenu', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable drag for images and text
        element.addEventListener('dragstart', function(e) {
            e.preventDefault();
            return false;
        });

        // Disable select all with Ctrl+A on content area
        element.addEventListener('keydown', function(e) {
            if (e.ctrlKey && (e.key === 'a' || e.key === 'A')) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Disable F12, Ctrl+Shift+I, Ctrl+U (optional - for additional protection)
    document.addEventListener('keydown', function(e) {
        // Disable F12
        if (e.key === 'F12') {
            e.preventDefault();
            return false;
        }

        // Disable Ctrl+Shift+I (Developer Tools)
        if (e.ctrlKey && e.shiftKey && e.key === 'I') {
            e.preventDefault();
            return false;
        }

        // Disable Ctrl+U (View Source)
        if (e.ctrlKey && e.key === 'u') {
            e.preventDefault();
            return false;
        }

        // Disable Ctrl+S (Save Page)
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            return false;
        }
    });

    // Disable print screen (limited effectiveness)
    document.addEventListener('keyup', function(e) {
        if (e.key === 'PrintScreen') {
            navigator.clipboard.writeText('');
        }
    });
});

// Additional protection: Clear clipboard periodically (optional)
// setInterval(function() {
//     if (navigator.clipboard) {
//         navigator.clipboard.writeText('').catch(() => {});
//     }
// }, 5000);
</script>
@endpush
