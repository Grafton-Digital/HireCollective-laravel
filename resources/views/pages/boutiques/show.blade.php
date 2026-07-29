<x-layouts.public>
    <x-slot:title>{{ $boutique->name }} — Hire Collective</x-slot:title>
    <x-slot:metaDescription>{{ Str::limit(strip_tags($boutique->description), 160) }}</x-slot:metaDescription>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <a href="{{ route('boutiques.index') }}" class="text-xs text-[#666] hover:underline">Boutiques</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <span class="text-xs text-black">{{ $boutique->name }}</span>
    </div>

    {{-- Hero section --}}
    <section class="flex px-[60px] border border-b-[#e5e7eb]" style="height:380px;">

        <div class="flex py-16 gap-x-12">

            <div class="flex w-[200px] h-auto overflow-hidden p-4"
                 @if($boutique->logo_background_color) style="background-color: {{ $boutique->logo_background_color }}" @endif>
                @if ($boutique->logo)
                    <img src="{{ Storage::url($boutique->logo) }}" alt="{{ $boutique->name }}" class="h-full w-full object-contain">
                @else
                    <div class="h-full w-full flex items-center justify-center bg-cream-50">
                        <span class="font-serif text-6xl font-bold text-black">{{ substr($boutique->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col" style="width: calc(100% - 248px)">
                <h1 class="font-serif text-[56px] italic text-black">{{ $boutique->name }}</h1>
                <div class="flex items-center gap-1.5 mb-3">
                    <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    <span class="text-[11px] text-[#666]">{{ $boutique->county }}</span>
                </div>
                <div class="text-sm leading-relaxed text-gray-600">
                    {{ $boutique->description }}
                </div>
            </div>
            
        </div>

    </section>

    <section class="flex items-end gap-4 px-[60px] py-6">
        <form method="GET" action="{{ route('boutiques.show', $boutique) }}" class="flex flex-1 items-end gap-4">

            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">CATEGORY</label>
                <select name="category" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
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
                    @foreach($colours as $colour)
                        <option value="{{ $colour->slug }}" {{ request('colour') == $colour->slug ? 'selected' : '' }}>
                            {{ $colour->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Designer</label>
                <select name="designer" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Designers</option>
                    @foreach($designers as $designer)
                        <option value="{{ $designer }}" {{ request('designer') == $designer ? 'selected' : '' }}>
                            {{ $designer }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Price Range</label>
                <select name="price_range" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Prices</option>
                    <option value="0-50" {{ request('price_range') == '0-50' ? 'selected' : '' }}>€0 - €50</option>
                    <option value="50-100" {{ request('price_range') == '50-100' ? 'selected' : '' }}>€50 - €100</option>
                    <option value="100-150" {{ request('price_range') == '100-150' ? 'selected' : '' }}>€100 - €150</option>
                    <option value="150-200" {{ request('price_range') == '150-200' ? 'selected' : '' }}>€150 - €200</option>
                    <option value="200+" {{ request('price_range') == '200+' ? 'selected' : '' }}>€200+</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">Occasion</label>
                <select name="occasion" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Occasions</option>
                    @foreach($occasions as $occasion)
                        <option value="{{ $occasion->slug }}" {{ request('occasion') == $occasion->slug ? 'selected' : '' }}>
                            {{ $occasion->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="flex h-10 w-[120px] items-center justify-center bg-black text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                SEARCH
            </button>
            @if(request()->hasAny(['category', 'size', 'colour', 'designer', 'price_range', 'occasion']))
                <a href="{{ route('boutiques.show', $boutique) }}" class="flex h-10 w-[120px] items-center justify-center border border-black text-xs font-medium tracking-[1.5px] text-black hover:bg-black hover:text-white">
                    CLEAR
                </a>
            @endif
        </form>
    </section>

    <section class="flex items-end gap-4 px-[60px] py-6">
        <div class="flex w-full items-center justify-between">
            <div class="text-sm text-gray-600">
                Showing {{ $products->count() }} product{{ $products->count() !== 1 ? 's' : '' }}
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select name="sort" onchange="window.location.href=this.value" class="border border-gray-300 bg-white pl-3 pr-8 py-2 pr-[35px] text-sm text-black focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
                    <option value="{{ route('boutiques.show', array_merge(['boutique' => $boutique], request()->except('sort'))) }}" {{ !request('sort') ? 'selected' : '' }}>Latest</option>
                    <option value="{{ route('boutiques.show', array_merge(['boutique' => $boutique], request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>Name (A-Z)</option>
                    <option value="{{ route('boutiques.show', array_merge(['boutique' => $boutique], request()->except('sort'), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                    <option value="{{ route('boutiques.show', array_merge(['boutique' => $boutique], request()->except('sort'), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                </select>
            </div>
        </div>
    </section>

    <section id="products" class="px-[60px] py-8">
        <div class="grid grid-cols-3 gap-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No items available at the moment.</p>
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
