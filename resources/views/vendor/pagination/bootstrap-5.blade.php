@if ($paginator->hasPages())
    <nav class="d-flex justify-content-between">
        <!-- Per Page Selection Form -->
        <div class="d-flex flex-fill mt">
            <form method="GET" action="{{ request()->url() }}" class="form-inline">
                @foreach (request()->except('perPage') as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach
                {{-- <label for="perPage" class="mr-2">{{ __('pagination.perPage') }}:</label> --}}
                <select name="perPage" id="perPage" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('perPage', 10) == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
        </div>

        <!-- Showing Info -->
        <div class="d-flex align-items-center">
            <p class="small text-muted">
                {{ __('pagination.showing') }}
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                {{ __('pagination.to') }}
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                {{ __('pagination.of') }}
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                {{ __('pagination.results') }}
            </p>
        </div>

        <!-- Pagination Controls -->
        <div class="d-flex justify-content-end flex-fill">
            <ul class="pagination">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{!! __('pagination.previous') !!}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                            rel="prev">{!! __('pagination.previous') !!}</a>
                    </li>
                @endif

                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled" aria-disabled="true"><span
                                class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active" aria-current="page"><span
                                        class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item"><a class="page-link"
                                        href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach


                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                            rel="next">{!! __('pagination.next') !!}</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">{!! __('pagination.next') !!}</span>
                    </li>
                @endif
            </ul>
        </div>

    </nav>
@endif
