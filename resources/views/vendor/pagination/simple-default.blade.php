@if ($paginator->hasPages())
    <nav>
        {{-- <ul class="pagination"> --}}
            {{-- Previous Page Link --}}
            <div style="margin-right: 35px">
                @if ($paginator->onFirstPage())
                    <span class="disabled" aria-disabled="true"><span>قبلی</span></span>
                @else
                    <span><a href="{{ $paginator->previousPageUrl() }}" rel="prev">قبلی</a></span>
                @endif

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <span><a href="{{ $paginator->nextPageUrl() }}" rel="next">بعدی</a></span>
                @else
                    <span class="disabled" aria-disabled="true"><span>بعدی</span></span>
                @endif
            </div>
        {{-- </ul> --}}
    </nav>
@endif
