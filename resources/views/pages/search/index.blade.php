<x-layouts.public>
    <x-slot:title>Search results for "{{ $search }}" — Hire Collective</x-slot:title>

    {{-- Search bar --}}
    <section class="bg-white px-4 md:px-[60px] pt-10 pb-6">
        <div class="mx-auto max-w-2xl">
            <form method="GET" action="{{ route('search.results') }}" class="relative">
                <svg class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                <input
                    type="text"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Search dresses, bags, hats, boutiques..."
                    class="w-full border border-gray-300 py-3 pl-12 pr-4 text-base text-black placeholder-gray-400 focus:outline-none focus:ring-0 focus:border-gray-300"
                    autofocus
                >
            </form>
        </div>
    </section>

    {{-- Results summary & filters --}}
    <section class="bg-white px-4 md:px-[60px] pb-4">
        <div class="flex items-center justify-between">
            <p class="text-sm text-[#666]">
                @if ($search)
                    Showing {{ $totalResults }} {{ Str::plural('result', $totalResults) }} for "{{ $search }}"
                @else
                    Enter a search term to find products and boutiques.
                @endif
            </p>
            @if ($search && $totalResults > 0)
                <div class="flex items-center gap-3">
                    <select onchange="window.location.href='{{ route('search.results') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), type: this.value, page: 1})" class="h-9 border border-[#D0D0D0] pl-3 pr-8 text-xs text-black">
                        <option value="all" {{ request('type', 'all') === 'all' ? 'selected' : '' }}>All</option>
                        <option value="products" {{ request('type') === 'products' ? 'selected' : '' }}>Products</option>
                        <option value="boutiques" {{ request('type') === 'boutiques' ? 'selected' : '' }}>Boutiques</option>
                    </select>
                    @if (request('type', 'all') !== 'boutiques')
                        <select onchange="window.location.href='{{ route('search.results') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})" class="h-9 border border-[#D0D0D0] pl-3 pr-8 text-xs text-black">
                            <option value="relevance" {{ request('sort', 'relevance') === 'relevance' ? 'selected' : '' }}>Relevance</option>
                            <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low–High</option>
                            <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High–Low</option>
                        </select>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @if ($search && $totalResults > 0)
        <section class="px-4 md:px-[60px] py-6">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($paginatedResults as $result)
                    @if ($result['type'] === 'boutique')
                        <x-boutique-card :boutique="$result['item']" />
                    @else
                        <x-product-card :product="$result['item']" :show-boutique="true" />
                    @endif
                @endforeach
            </div>

            {{-- Pagination --}}
            @if ($paginatedResults->hasPages())
                <div class="flex items-center justify-center gap-2 py-6">
                    @if ($paginatedResults->currentPage() > 1)
                        <a href="{{ $paginatedResults->previousPageUrl() }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m15.75 19.5-7.5-7.5 7.5-7.5"/></svg>
                        </a>
                    @endif
                    @foreach ($paginatedResults->getUrlRange(1, $paginatedResults->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                           class="{{ $page == $paginatedResults->currentPage() ? 'bg-black text-white' : 'border border-black text-black hover:bg-black hover:text-white' }} flex h-8 w-8 items-center justify-center text-[13px] font-medium">
                            {{ $page }}
                        </a>
                    @endforeach
                    @if ($paginatedResults->hasMorePages())
                        <a href="{{ $paginatedResults->nextPageUrl() }}">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                        </a>
                    @endif
                </div>
            @endif
        </section>
    @elseif ($search)
        {{-- No results --}}
        <section class="px-4 md:px-[60px] py-16 text-center">
            <p class="text-lg text-[#666]">No results found for "{{ $search }}"</p>
            <p class="mt-2 text-sm text-[#999]">Try a different search term or browse our collections.</p>
            <div class="mt-6 flex items-center justify-center gap-4">
                <a href="{{ route('products.index') }}" class="border border-black px-6 py-2.5 text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">BROWSE PRODUCTS</a>
                <a href="{{ route('boutiques.index') }}" class="border border-black px-6 py-2.5 text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">VIEW BOUTIQUES</a>
            </div>
        </section>
    @endif
</x-layouts.public>
