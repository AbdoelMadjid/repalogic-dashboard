@if ($paginator->hasPages())
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 w-100">
        <div class="text-muted fs-12 text-center text-md-start">
            <span class="fw-semibold text-dark">{{ $paginator->firstItem() ?? 0 }}</span> - <span class="fw-semibold text-dark">{{ $paginator->lastItem() ?? 0 }}</span> <span class="text-muted">/ total</span> <span class="fw-semibold text-dark">{{ $paginator->total() }}</span>
        </div>

        <div>
            <ul class="pagination pagination-sm mb-0 flex-wrap justify-content-center justify-content-md-end gap-1">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true" aria-label="Sebelumnya">
                        <span class="page-link" aria-hidden="true"><i class="ti ti-chevron-left"></i></span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Sebelumnya" title="Halaman Sebelumnya"><i class="ti ti-chevron-left"></i></a>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Selanjutnya" title="Halaman Selanjutnya"><i class="ti ti-chevron-right"></i></a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true" aria-label="Selanjutnya">
                        <span class="page-link" aria-hidden="true"><i class="ti ti-chevron-right"></i></span>
                    </li>
                @endif
            </ul>
        </div>
    </div>
@endif
