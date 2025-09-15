@php
    $currentPage = $paginator->currentPage();
    $lastPage = $paginator->lastPage();
    $hasPages = $lastPage > 1;

    // Calculate start and end pages for display
    $start = max(1, min($currentPage - 2, $lastPage - 4));
    $end = min($lastPage, max($currentPage + 2, 5));

    // Handle query string parameters
    $queryParams = request()->query();
    $urlBuilder = function ($page) use ($paginator, $queryParams) {
        if (method_exists($paginator, 'appends')) {
            return $paginator->appends($queryParams)->url($page);
        }
        return $paginator->url($page);
    };

    $previousUrl = $paginator->onFirstPage() ? null : $urlBuilder($currentPage - 1);
    $nextUrl = $paginator->hasMorePages() ? $urlBuilder($currentPage + 1) : null;
@endphp@if ($hasPages)
    @push('styles')
        <link rel="stylesheet" href="{{ asset('css/custom-pagination.css') }}">
    @endpush

    <nav class="custom-pagination" aria-label="Pagination Navigation">
        <ul class="custom-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="custom-page-item disabled">
                    <span class="custom-page-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span class="sr-only">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li class="custom-page-item">
                    <a class="custom-page-link" href="{{ $previousUrl }}" rel="prev">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m15 18-6-6 6-6" />
                        </svg>
                        <span class="sr-only">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- First Page Link --}}
            @if ($start > 1)
                <li class="custom-page-item">
                    <a class="custom-page-link" href="{{ $urlBuilder(1) }}">1</a>
                </li>
                @if ($start > 2)
                    <li class="custom-page-item disabled">
                        <span class="custom-page-link dots">...</span>
                    </li>
                @endif
            @endif

            {{-- Pagination Elements --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $currentPage)
                    <li class="custom-page-item active">
                        <span class="custom-page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="custom-page-item">
                        <a class="custom-page-link" href="{{ $urlBuilder($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Last Page Link --}}
            @if ($end < $lastPage)
                @if ($end < $lastPage - 1)
                    <li class="custom-page-item disabled">
                        <span class="custom-page-link dots">...</span>
                    </li>
                @endif
                <li class="custom-page-item">
                    <a class="custom-page-link" href="{{ $urlBuilder($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="custom-page-item">
                    <a class="custom-page-link" href="{{ $nextUrl }}" rel="next">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="sr-only">Selanjutnya</span>
                    </a>
                </li>
            @else
                <li class="custom-page-item disabled">
                    <span class="custom-page-link">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="m9 18 6-6-6-6" />
                        </svg>
                        <span class="sr-only">Selanjutnya</span>
                    </span>
                </li>
            @endif
        </ul>

        {{-- Page Info --}}
        <div class="custom-pagination-info">
            <p class="text-sm text-gray-600">
                Menampilkan {{ $paginator->firstItem() }} sampai {{ $paginator->lastItem() }}
                dari {{ $paginator->total() }} hasil
            </p>
        </div>
    </nav>
@endif
