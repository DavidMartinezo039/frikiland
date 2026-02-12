@if ($paginator->hasPages())
    <nav class="admin-pagination-wrapper">
        {{-- LINKS --}}
        <div class="pagination-links">

            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled">
                    <i class="bx bx-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">
                    <i class="bx bx-chevron-left"></i>
                </a>
            @endif


            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-btn active">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach


            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">
                    <i class="bx bx-chevron-right"></i>
                </a>
            @else
                <span class="pagination-btn disabled">
                    <i class="bx bx-chevron-right"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
