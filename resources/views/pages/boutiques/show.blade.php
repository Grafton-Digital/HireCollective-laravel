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

        <div class="w-full flex py-16 gap-x-12">

            <div class="flex flex-col items-center">
                @if($boutique->website)
                    <a href="{{ $boutique->website }}" target="_blank" rel="noopener" class="flex w-[200px] h-auto overflow-hidden p-4"
                         @if($boutique->logo_background_color) style="background-color: {{ $boutique->logo_background_color }}" @endif>
                        @if ($boutique->logo)
                            <img src="{{ Storage::url($boutique->logo) }}" alt="{{ $boutique->name }}" class="h-full w-full object-contain">
                        @else
                            <div class="h-full w-full flex items-center justify-center bg-cream-50">
                                <span class="font-serif text-6xl font-bold text-black">{{ substr($boutique->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </a>
                @else
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
                @endif
                @if(!empty($boutique->social_links) || $boutique->website)
                    <div class="w-full mt-3 flex items-center gap-3">
                        @if($boutique->website)
                            <a href="{{ $boutique->website }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-900 transition-colors" title="Website">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>
                            </a>
                        @endif
                        @foreach(($boutique->social_links ?? []) as $platform => $handle)
                            <a href="{{ $handle }}" target="_blank" rel="noopener" class="text-gray-400 hover:text-gray-900 transition-colors" title="{{ ucfirst($platform === 'twitter' ? 'X' : $platform) }}">
                                @switch($platform)
                                    @case('instagram')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                        @break
                                    @case('tiktok')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.88 2.89 2.89 0 01-2.88-2.88 2.89 2.89 0 012.88-2.88c.28 0 .56.04.82.11V9.4a6.33 6.33 0 00-.82-.05A6.34 6.34 0 003.15 15.7a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V9.05a8.27 8.27 0 004.76 1.5V7.1a4.83 4.83 0 01-1-.41z"/></svg>
                                        @break
                                    @case('facebook')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                        @break
                                    @case('twitter')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @break
                                    @case('threads')
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.186 24h-.007c-3.581-.024-6.334-1.205-8.184-3.509C2.35 18.44 1.5 15.586 1.472 12.01v-.017c.03-3.579.879-6.43 2.525-8.482C5.845 1.205 8.6.024 12.18 0h.014c2.746.02 5.043.725 6.826 2.098 1.677 1.29 2.858 3.13 3.509 5.467l-2.04.569c-1.104-3.96-3.898-5.984-8.304-6.015-2.91.022-5.11.936-6.54 2.717C4.307 6.504 3.616 8.914 3.59 12c.025 3.086.718 5.496 2.057 7.164 1.43 1.783 3.631 2.698 6.54 2.717 2.623-.02 4.358-.631 5.8-2.045 1.647-1.613 1.618-3.593 1.09-4.798-.31-.71-.873-1.3-1.634-1.75-.192 1.352-.622 2.446-1.284 3.272-.886 1.102-2.14 1.704-3.73 1.79-1.202.065-2.361-.218-3.259-.801-1.063-.689-1.685-1.74-1.752-2.96-.065-1.17.408-2.243 1.33-3.023.88-.744 2.084-1.168 3.59-1.264 1.104-.07 2.132.02 3.062.267.03-.643.003-1.26-.082-1.838-.215-1.452-.778-2.422-1.73-2.97-.981-.566-2.293-.674-3.546-.296l-.614-1.94c1.795-.543 3.678-.395 5.156.406 1.38.748 2.29 2.08 2.604 3.807.088.483.14.995.157 1.534 1.09.59 1.943 1.39 2.477 2.392.78 1.463.89 3.944-.86 5.66-1.818 1.783-4.07 2.576-7.31 2.6zm-.04-8.95c-1.476.094-3.081.578-3.081 2.196 0 1.3 1.334 2.023 2.58 1.955 1.387-.075 2.554-.753 3.15-2.152.087-.205.162-.427.226-.665-.933-.266-1.925-.398-2.875-.334z"/></svg>
                                        @break
                                @endswitch
                            </a>
                        @endforeach
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
