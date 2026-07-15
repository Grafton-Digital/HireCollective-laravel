@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="flex h-10 w-10 items-center justify-center border border-gray-300 text-gray-400 cursor-not-allowed">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="flex h-10 w-10 items-center justify-center border border-gray-300 text-black hover:bg-gray-100 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="flex h-10 w-10 items-center justify-center text-gray-500">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="flex h-10 w-10 items-center justify-center bg-black text-sm font-medium text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="flex h-10 w-10 items-center justify-center border border-gray-300 text-sm text-black hover:bg-gray-100 transition">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="flex h-10 w-10 items-center justify-center border border-gray-300 text-black hover:bg-gray-100 transition">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>
        @else
            <span class="flex h-10 w-10 items-center justify-center border border-gray-300 text-gray-400 cursor-not-allowed">
                <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </span>
        @endif
    </nav>
@endif
