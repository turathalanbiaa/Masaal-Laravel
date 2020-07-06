@if ($paginator->hasPages())
    <div class="ui pagination teal menu">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <div class="item disabled"><span>«</span></div>
        @else
            <a class="item" href="{{ $paginator->previousPageUrl() }}" rel="prev">«</a>
        @endif

        {{-- First Page Link --}}
        @if($paginator->currentPage() == 1)
            <div class="item disabled">1</div>
        @else
            <a class="item" href="{{ $paginator->url(1) }}">1</a>
        @endif

        {{-- 3 Dots more than two items form start --}}
        @if($paginator->currentPage() > 2)
            <a class="item"><span>...</span></a>
        @endif

        {{-- Range of items links --}}
        @if($paginator->lastPage() >= 3)
            @foreach(range(2, $paginator->lastPage()-1) as $i)
                @if($i >= $paginator->currentPage() && $i <= $paginator->currentPage())
                    @if ($i == $paginator->currentPage())
                        <a class="item active"><span>{{ $i }}</span></a>
                    @else
                        <a class="item" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                @endif
            @endforeach
        @endif

        {{-- 3 Dots more than two items form end--}}
        @if($paginator->currentPage() < $paginator->lastPage() - 1)
            <div class="item"><span>...</span></div>
        @endif

        {{-- Last Page Link --}}
        @if($paginator->currentPage() == $paginator->lastPage())
            <div class="item disabled">{{ $paginator->lastPage() }}</div>
        @else
            <a class="item" href="{{ $paginator->url($paginator->lastPage()) }}">{{ $paginator->lastPage() }}</a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="item" href="{{ $paginator->nextPageUrl() }}" rel="next">»</a>
        @else
            <div class="item disabled"><span>»</span></div>
        @endif
    </div>
@endif