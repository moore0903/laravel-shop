@if ($paginator->hasPages())
    <div class="page fmyh">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a class="prev" href="javascript:void(0);">&lt;</a>
        @else
            <a class="prev" href="{{ $paginator->previousPageUrl() }}">&lt;</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a class="num cur">{{ $page }}</a>
                    @else
                        <a class="num" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a class="next" href="{{ $paginator->nextPageUrl() }}">&gt;</a>
        @else
            <a class="next" href="javascript:void(0);">&gt;</a>
        @endif
        <span class="all">当前页 {{ $paginator->currentPage() }}/{{ $paginator->lastPage() }} ，共 {{ $paginator->total() }} 条信息</span>
    </div>
@endif
