<x-layouts.public>
    <x-slot:title>New Arrivals — Hire Collective</x-slot:title>

    {{-- Hero section --}}
    <section class="flex flex-col items-center justify-center py-16">
        <span class="text-xs font-medium tracking-[3px] text-gold">JUST ARRIVED</span>
        <h1 class="font-serif text-[48px] text-black">New Arrivals</h1>
        <p class="mt-3 text-sm text-[#666]">The latest additions to our curated collection of luxury knitwear</p>
    </section>

    {{-- Filter section --}}
    <section class="px-[60px] py-6">
        <form method="GET" action="{{ route('new-arrivals') }}" class="flex items-end gap-4">
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">CATEGORY</label>
                <select name="category" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">SIZE</label>
                <select name="size" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Sizes</option>
                    @for ($i = 6; $i <= 18; $i += 2)
                        <option value="{{ $i }}" {{ request('size') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                    <option value="One Size" {{ request('size') === 'One Size' ? 'selected' : '' }}>One Size</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">COLOUR</label>
                <select name="colour" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Colours</option>
                    @foreach ($colours as $colour)
                        <option value="{{ $colour->slug }}" {{ request('colour') === $colour->slug ? 'selected' : '' }}>{{ $colour->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Designer</label>
                <select name="designer" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Designers</option>
                    @foreach ($designers as $designer)
                        <option value="{{ $designer }}" {{ request('designer') === $designer ? 'selected' : '' }}>{{ $designer }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Region/Location</label>
                <select name="county" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Locations</option>
                    @foreach ($counties as $county)
                        <option value="{{ $county->value }}" {{ request('county') === $county->value ? 'selected' : '' }}>{{ $county->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Price</label>
                <select name="price" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Prices</option>
                    <option value="0-50" {{ request('price') === '0-50' ? 'selected' : '' }}>€0 – €50</option>
                    <option value="50-100" {{ request('price') === '50-100' ? 'selected' : '' }}>€50 – €100</option>
                    <option value="100-150" {{ request('price') === '100-150' ? 'selected' : '' }}>€100 – €150</option>
                    <option value="150-200" {{ request('price') === '150-200' ? 'selected' : '' }}>€150 – €200</option>
                    <option value="200+" {{ request('price') === '200+' ? 'selected' : '' }}>€200+</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Event tags</label>
                <select name="occasion" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Tags</option>
                    @foreach ($occasions as $occasion)
                        <option value="{{ $occasion->slug }}" {{ request('occasion') === $occasion->slug ? 'selected' : '' }}>{{ $occasion->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="flex h-10 w-[120px] items-center justify-center bg-black text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                SEARCH
            </button>
            @if(request()->hasAny(['category', 'size', 'colour', 'designer', 'county', 'price', 'occasion']))
                <a href="{{ route('new-arrivals') }}" class="flex h-10 w-[120px] items-center justify-center border border-black text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">
                    CLEAR
                </a>
            @endif
        </form>
    </section>

    {{-- Sort bar --}}
    <section class="flex items-center justify-end px-[60px] py-4">
        <div class="flex items-center gap-2">
            <span class="px-2 text-xs text-[#666]">{{ $products->total() }} {{ Str::plural('item', $products->total()) }}</span>
            <select name="sort" onchange="window.location.href='{{ route('new-arrivals') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})" class="h-9 rounded border border-[#D0D0D0] pl-3 pr-8 text-xs text-black">
                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest first</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low–High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High–Low</option>
            </select>
        </div>
    </section>

    <div class="h-px bg-[#E0E0E0]"></div>

    {{-- Product grid --}}
    <section class="px-[60px] py-6">
        <div class="grid grid-cols-3 gap-5">
            @forelse ($products as $product)
                <x-product-card :product="$product" :show-boutique="true" />
            @empty
                <p class="col-span-3 py-12 text-center text-[#666]">No new arrivals match your filters.</p>
            @endforelse
        </div>

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
