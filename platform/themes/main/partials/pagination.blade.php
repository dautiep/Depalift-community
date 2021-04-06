@if ($paginator->hasPages())

<ul class="pagination" role="navigation">
    {{-- Previous Page Link --}}
    <li class="pagination-other-current">
        <a href="{{$paginator->url(1)}}">
            <i class="fas fa-angle-double-left"></i>
        </a>
    </li>
    @if ($paginator->onFirstPage())
        <li class="pagination-other-current disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
            <a href="javascript:;">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li> 
    @else
        <li class="pagination-other-current">
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                <i class="fas fa-chevron-left"></i>
            </a>
        </li> 
    @endif

    @php
        $start = $paginator->currentPage() - $paginator->onEachSide; // show 3 pagination links before current
        $end = $paginator->currentPage() + $paginator->onEachSide; // show 3 pagination links after current
        if($start < 1) {
            $start = 1; // reset start to 1
            $end += 1;
        } 
        if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
    @endphp

    @if($start > 1)
        <li class="pagination-other-current">
            <a href="{{ $paginator->url(1) }}">{{1}}</a>
        </li>
        @if($paginator->currentPage() != $paginator->onEachSide + 2)
            {{-- "Three Dots" Separator --}}
            <li class="pagination-other-current disabled" aria-disabled="true"><span>...</span></li>
        @endif
    @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="pagination-other-current {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                <a href="{{ $paginator->url($i) }}">{{$i}}</a>
            </li>
        @endfor
        @if($end < $paginator->lastPage())
            @if($paginator->currentPage() + $paginator->onEachSide + 1 != $paginator->lastPage())
                {{-- "Three Dots" Separator --}}
                <li class="pagination-other-current disabled" aria-disabled="true"><span>...</span></li>
            @endif
            <li class="pagination-other-current">
                <a href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
            </li>
        @endif

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <li class="pagination-other-current">
            <a  href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li> 
    @else
        <li class="pagination-other-current disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
            <a href="javascript:;">
                <i class="fas fa-chevron-right"></i>
            </a>
        </li> 
    @endif
    <li class="pagination-other-current">
        <a href="{{$paginator->url($paginator->lastPage())}}">
            <i class="fas fa-angle-double-right"></i>
        </a>
    </li>
</ul>
@endif