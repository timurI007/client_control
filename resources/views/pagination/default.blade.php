@if ($paginator->hasPages())
    <div>
        <p>
            {!! __('Showing') !!}
            <span class="bold">{{ $paginator->firstItem() }}</span>
            {!! __('to') !!}
            <span class="bold">{{ $paginator->lastItem() }}</span>
            {!! __('of') !!}
            <span class="bold">{{ $paginator->total() }}</span>
            {!! __('results') !!}
        </p>
    </div>
    <div>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span>@lang('pagination.previous')</span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">@lang('pagination.previous')</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span>{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span>{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">@lang('pagination.next')</a>
                </li>
            @else
                <li>
                    <span>@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    </div>
@endif
