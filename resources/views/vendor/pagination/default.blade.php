@if ($paginator->hasPages())
    <ul class="ui pagination menu">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled item"><span>&laquo;</span></li>
        @else
            <li class="item"><a href="{{ $paginator->previousPageUrl() }}" rel="prev">السابق</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled item "><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active item"><span>{{ $page }}</span></li>
                    @else
                        <li class="item"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="item"><a href="{{ $paginator->nextPageUrl() }}" rel="next">التالي</a></li>
        @else
            <li class="disabled item"><span>&raquo;</span></li>
        @endif
    </ul>
@endif
