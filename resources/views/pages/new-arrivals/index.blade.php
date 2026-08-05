<x-layouts.public>
    <x-slot:title>New Arrivals — Hire Collective</x-slot:title>

    {{-- Hero section --}}
    <section class="flex flex-col items-center justify-center  px-4 sm:px-[60px] py-16">
        <span class="text-xs font-medium tracking-[3px] text-gold">JUST ARRIVED</span>
        <h1 class="font-serif text-[48px] text-black">New Arrivals</h1>
        <p class="mt-3 text-sm text-[#666] text-center">The latest additions to our curated collection of luxury knitwear</p>
    </section>

    {{-- Filter section --}}
    <section class="bg-cream-50 px-4 nav:px-[60px] py-6" x-data="{ filtersOpen: false }">
        {{-- Mobile: toggle button --}}
        <div class="nav:hidden">
            <button @click="filtersOpen = !filtersOpen" type="button" class="flex w-full items-center justify-between border border-[#D0D0D0] bg-white px-4 py-3 text-sm font-medium text-black">
                <span>Filters @if(request()->hasAny(['category', 'size', 'colour', 'designer', 'county', 'price', 'occasion']))<span class="ml-1 inline-flex h-5 w-5 items-center justify-center bg-black text-[10px] text-white rounded-full">{{ collect(['category', 'size', 'colour', 'designer', 'county', 'price', 'occasion'])->filter(fn($f) => request($f))->count() }}</span>@endif</span>
                <svg class="h-4 w-4 transition-transform" :class="filtersOpen && 'rotate-180'" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
            </button>
        </div>

        {{-- Desktop: inline filters --}}
        <form method="GET" action="{{ route('new-arrivals') }}" class="hidden nav:flex items-end gap-4">
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">CATEGORY</label>
                <select name="category" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">SIZE</label>
                <select name="size" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Sizes</option>
                    @for ($i = 6; $i <= 18; $i += 2)
                        <option value="{{ $i }}" {{ request('size') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                    <option value="One Size" {{ request('size') === 'One Size' ? 'selected' : '' }}>One Size</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">COLOUR</label>
                <select name="colour" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Colours</option>
                    @foreach ($colours as $colour)
                        <option value="{{ $colour->slug }}" {{ request('colour') === $colour->slug ? 'selected' : '' }}>{{ $colour->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Designer</label>
                <select name="designer" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Designers</option>
                    @foreach ($designers as $designer)
                        <option value="{{ $designer }}" {{ request('designer') === $designer ? 'selected' : '' }}>{{ $designer }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Region/Location</label>
                <select name="county" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Locations</option>
                    @foreach ($counties as $county)
                        <option value="{{ $county->value }}" {{ request('county') === $county->value ? 'selected' : '' }}>{{ $county->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Price</label>
                <select name="price" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
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
                <select name="occasion" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Tags</option>
                    @foreach ($occasions as $occasion)
                        <option value="{{ $occasion->slug }}" {{ request('occasion') === $occasion->slug ? 'selected' : '' }}>{{ $occasion->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(request()->hasAny(['category', 'size', 'colour', 'designer', 'county', 'price', 'occasion', 'search']))
                <a href="{{ route('new-arrivals') }}" class="flex h-10 w-[120px] shrink-0 items-center justify-center border border-black text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">
                    CLEAR
                </a>
            @endif
        </form>

        {{-- Mobile: dropdown filters --}}
        <form method="GET" action="{{ route('new-arrivals') }}" x-show="filtersOpen" x-collapse class="nav:hidden mt-3 grid grid-cols-2 gap-3">
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">CATEGORY</label>
                <select name="category" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Categories</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">SIZE</label>
                <select name="size" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Sizes</option>
                    @for ($i = 6; $i <= 18; $i += 2)
                        <option value="{{ $i }}" {{ request('size') == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                    <option value="One Size" {{ request('size') === 'One Size' ? 'selected' : '' }}>One Size</option>
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">COLOUR</label>
                <select name="colour" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Colours</option>
                    @foreach ($colours as $colour)
                        <option value="{{ $colour->slug }}" {{ request('colour') === $colour->slug ? 'selected' : '' }}>{{ $colour->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Designer</label>
                <select name="designer" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Designers</option>
                    @foreach ($designers as $designer)
                        <option value="{{ $designer }}" {{ request('designer') === $designer ? 'selected' : '' }}>{{ $designer }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Region/Location</label>
                <select name="county" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Locations</option>
                    @foreach ($counties as $county)
                        <option value="{{ $county->value }}" {{ request('county') === $county->value ? 'selected' : '' }}>{{ $county->getLabel() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Price</label>
                <select name="price" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Prices</option>
                    <option value="0-50" {{ request('price') === '0-50' ? 'selected' : '' }}>€0 – €50</option>
                    <option value="50-100" {{ request('price') === '50-100' ? 'selected' : '' }}>€50 – €100</option>
                    <option value="100-150" {{ request('price') === '100-150' ? 'selected' : '' }}>€100 – €150</option>
                    <option value="150-200" {{ request('price') === '150-200' ? 'selected' : '' }}>€150 – €200</option>
                    <option value="200+" {{ request('price') === '200+' ? 'selected' : '' }}>€200+</option>
                </select>
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Event tags</label>
                <select name="occasion" onchange="this.form.submit()" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Tags</option>
                    @foreach ($occasions as $occasion)
                        <option value="{{ $occasion->slug }}" {{ request('occasion') === $occasion->slug ? 'selected' : '' }}>{{ $occasion->name }}</option>
                    @endforeach
                </select>
            </div>
            @if(request()->hasAny(['category', 'size', 'colour', 'designer', 'county', 'price', 'occasion', 'search']))
                <a href="{{ route('new-arrivals') }}" class="col-span-2 flex h-10 items-center justify-center border border-black text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">
                    CLEAR ALL
                </a>
            @endif
        </form>
    </section>

    {{-- Sort bar --}}
    <section class="flex items-center justify-end bg-white px-4 nav:px-[60px] py-4">
        <div class="flex items-center gap-2">
            <span class="w-[80px] px-2 text-xs text-[#666]">{{ $products->total() }} {{ Str::plural('item', $products->total()) }}</span>
            @if ($products->total() > 24)
                <select name="per_page" onchange="window.location.href='{{ route('new-arrivals') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), per_page: this.value, page: 1})" class="h-9 rounded border border-[#D0D0D0] pl-3 pr-8 text-xs text-black">
                    <option value="24" {{ request('per_page', '24') == '24' ? 'selected' : '' }}>24 per page</option>
                    @if ($products->total() > 48)
                        <option value="48" {{ request('per_page') == '48' ? 'selected' : '' }}>48 per page</option>
                    @endif
                    @if ($products->total() > 96)
                        <option value="96" {{ request('per_page') == '96' ? 'selected' : '' }}>96 per page</option>
                    @endif
                </select>
            @endif
            <select name="sort" onchange="window.location.href='{{ route('new-arrivals') }}?' + new URLSearchParams({...Object.fromEntries(new URLSearchParams(window.location.search)), sort: this.value})" class="h-9 rounded border border-[#D0D0D0] pl-3 pr-8 text-xs text-black">
                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Newest</option>
                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low–High</option>
                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High–Low</option>
            </select>
        </div>
    </section>

    {{-- Product grid --}}
    <section class="px-4 nav:px-[60px] py-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 nav:grid-cols-3 gap-3 nav:gap-5">
            @forelse ($products as $product)
                <x-product-card :product="$product" :show-boutique="true" />
            @empty
                <p class="col-span-3 py-12 text-center text-[#666]">No new arrivals match your filters.</p>
            @endforelse
        </div>

        @if ($products->hasPages())
            <div class="py-10">
                {{ $products->links('vendor.pagination.custom') }}
            </div>
        @endif
    </section>
</x-layouts.public>
