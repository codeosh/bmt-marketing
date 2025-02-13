@if ($paginator->hasPages())
    <nav>
        <ul class="pagination justify-content-center pagination-sm">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
                </li>
            @endif

            {{-- Page Number Links --}}
            @php
                $currentPage = $paginator->currentPage();
                $totalPages = $paginator->lastPage();
                $start = max($currentPage - 2, 1);
                $end = min($currentPage + 2, $totalPages);

                // Adjust the range if near the start or end of pagination
                if ($currentPage < 3) {
                    $end = min(5, $totalPages);
                } elseif ($currentPage > $totalPages - 3) {
                    $start = max($totalPages - 4, 1);
                }
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
