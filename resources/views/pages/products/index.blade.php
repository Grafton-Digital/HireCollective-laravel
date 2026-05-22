<x-layouts.public>
    <x-slot:title>{{ request('category') ? ucfirst(request('category')) : 'Browse' }} — Hire Collective</x-slot:title>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 bg-white px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <span class="text-xs text-black">{{ request('category') ? ucfirst(request('category')) : 'All Products' }}</span>
    </div>

    {{-- Title section --}}
    <section class="bg-white px-[60px] pb-2 pt-5">
        <h1 class="font-serif text-[38px] italic text-black">{{ request('category') ? ucfirst(request('category')) : 'All Products' }}</h1>
        <p class="mt-2 text-sm text-[#666]">Browse hundreds of designer {{ request('category', 'pieces') }} available to hire from Ireland's most trusted boutiques.</p>
    </section>

    {{-- Filter bar --}}
    <section class="flex items-center justify-between bg-white px-[60px] py-4">
        <form method="GET" action="{{ route('products.index') }}" class="flex items-center gap-2.5" id="filterForm">
            @if (request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/></svg>
            <span class="text-[11px] font-semibold tracking-[1px]">FILTERS</span>

            <select name="size" onchange="document.getElementById('filterForm').submit()" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="">Size</option>
                @for ($i = 6; $i <= 18; $i += 2)
                    <option value="{{ $i }}" {{ request('size') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>

            <select name="colour" onchange="document.getElementById('filterForm').submit()" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="">Colour</option>
                @foreach ($colours as $colour)
                    <option value="{{ $colour->slug }}" {{ request('colour') === $colour->slug ? 'selected' : '' }}>{{ $colour->name }}</option>
                @endforeach
            </select>

            <select name="occasion" onchange="document.getElementById('filterForm').submit()" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="">Occasion</option>
                @foreach ($occasions as $occasion)
                    <option value="{{ $occasion->slug }}" {{ request('occasion') === $occasion->slug ? 'selected' : '' }}>{{ $occasion->name }}</option>
                @endforeach
            </select>

            <select name="boutique" onchange="document.getElementById('filterForm').submit()" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="">Boutique</option>
                @foreach ($boutiques as $boutique)
                    <option value="{{ $boutique->slug }}" {{ request('boutique') === $boutique->slug ? 'selected' : '' }}>{{ $boutique->name }}</option>
                @endforeach
            </select>

            <select name="price" onchange="document.getElementById('filterForm').submit()" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="">Price</option>
                <option value="0-50" {{ request('price') === '0-50' ? 'selected' : '' }}>Under €50</option>
                <option value="50-100" {{ request('price') === '50-100' ? 'selected' : '' }}>€50 – €100</option>
                <option value="100+" {{ request('price') === '100+' ? 'selected' : '' }}>€100+</option>
            </select>
        </form>

        <div class="flex items-center gap-2">
            <span class="text-xs text-[#666]">{{ $products->total() }} {{ Str::plural(request('category', 'item'), $products->total()) }}</span>
            <select name="sort" onchange="window.location.href='{{ route('products.index') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})" class="h-9 rounded border border-[#D0D0D0] px-3 text-xs text-black">
                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low–High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High–Low</option>
            </select>
        </div>
    </section>

    <div class="h-px bg-[#E0E0E0]"></div>

    {{-- Product grid --}}
    <section class="px-[60px] py-6">
        <div class="grid grid-cols-4 gap-5">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-4 py-12 text-center text-[#666]">No products match your filters.</p>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($products->hasPages())
            <div class="flex items-center justify-center gap-2 py-6">
                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <a href="{{ $url }}"
                       class="{{ $page == $products->currentPage() ? 'bg-black text-white' : 'border border-black text-black hover:bg-black hover:text-white' }} flex h-8 w-8 items-center justify-center text-[13px] font-medium">
                        {{ $page }}
                    </a>
                @endforeach
                @if ($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                    </a>
                @endif
            </div>
        @endif
    </section>
</x-layouts.public>
