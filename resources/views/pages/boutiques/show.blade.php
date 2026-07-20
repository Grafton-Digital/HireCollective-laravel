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

            <div class="flex w-[200px] h-[200px] rounded-[50%] bg-gray-300 overflow-hidden">
                @if ($boutique->logo)
                    <img src="{{ Storage::url($boutique->logo) }}" alt="{{ $boutique->name }}" class="h-full w-full object-contain">
                @else
                    <div class="h-full w-full flex items-center justify-center bg-cream-100">
                        <span class="font-serif text-6xl font-bold text-black">{{ substr($boutique->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>

            <div class="flex flex-col" style="width: calc(100% - 248px)">
                <h1 class="font-serif text-[56px] italic text-black">{{ $boutique->name }}</h1>
                <div class="flex items-center gap-1.5 mb-3">
                    <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                    <span class="text-[11px] text-[#666]">{{ $boutique->city }}, {{ $boutique->county }}</span>
                </div>
                <div class="text-sm leading-relaxed text-gray-600">
                    {{ $boutique->description }}
                </div>
            </div>
            
        </div>

        <!-- <div class="flex flex-col justify-center gap-4 py-10" style="width:50%;">
            <h1 class="font-serif text-[42px] italic text-black">{{ $boutique->name }}</h1>
            <div class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                <span class="text-[13px] text-[#666]">{{ $boutique->city }}, {{ $boutique->county }}</span>
            </div>
            @if ($boutique->description)
                <p class="text-sm leading-[1.6] text-[#333]" style="width:340px;">{{ Str::limit(strip_tags($boutique->description), 180) }}</p>
            @endif
            <div class="mt-2 flex items-center gap-3">
                <a href="#products" class="bg-black px-7 py-3 text-[11px] font-medium tracking-[1px] text-white hover:bg-gray-800">VIEW &amp; BOOK WITH BOUTIQUE</a>
                <a href="{{ route('enquiry.create', $boutique->products->first() ?? $boutique) }}" class="border border-black px-7 py-3 text-[11px] font-medium tracking-[1px] text-black hover:bg-black hover:text-white">MESSAGE BOUTIQUE</a>
            </div>
            <div class="mt-2 flex items-center gap-5">
                @if ($boutique->instagram)
                    <a href="{{ $boutique->instagram }}" class="flex items-center gap-1 text-xs text-[#666] hover:text-black" target="_blank">
                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/></svg>
                        Instagram
                    </a>
                @endif
                @if ($boutique->website)
                    <a href="{{ $boutique->website }}" class="flex items-center gap-1 text-xs text-[#666] hover:text-black" target="_blank">
                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                        Website
                    </a>
                @endif
                @if ($boutique->contact_email)
                    <a href="mailto:{{ $boutique->contact_email }}" class="flex items-center gap-1 text-xs text-[#666] hover:text-black">
                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        Email
                    </a>
                @endif
                @if ($boutique->phone)
                    <a href="tel:{{ $boutique->phone }}" class="flex items-center gap-1 text-xs text-[#666] hover:text-black">
                        <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        Phone
                    </a>
                @endif
            </div>
        </div> -->
        <!-- <div class="flex-1 overflow-hidden">
            @if ($boutique->cover_image)
                <img src="{{ Storage::url($boutique->cover_image) }}" alt="{{ $boutique->name }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full bg-cream-100"></div>
            @endif
        </div> -->
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
                <label class="text-2xs font-medium tracking-[1px] uppercase text-black">County</label>
                <select name="county" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Counties</option>
                    @foreach($counties as $county)
                        <option value="{{ $county }}" {{ request('county') == $county ? 'selected' : '' }}>
                            {{ $county }}
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

    {{-- Dresses section --}}
    <section id="products" class="px-[60px] py-8">
        <div class="grid grid-cols-3 gap-4">
            @forelse ($products as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No items available at the moment.</p>
            @endforelse
        </div>
    </section>

    {{-- Bottom section: About / Availability / Contact --}}
    <section class="flex gap-10 border-t border-[#E0E0E0] bg-cream-50 px-[60px] py-8">
        {{-- About column --}}
        <div class="flex flex-1 flex-col gap-3">
            <h3 class="text-xs font-semibold tracking-[1px] text-black">ABOUT {{ strtoupper($boutique->name) }}</h3>
            @if ($boutique->description)
                <div class="text-[13px] leading-[1.6] text-[#333]">
                    {!! Str::markdown($boutique->description) !!}
                </div>
            @endif
        </div>

        {{-- Availability column --}}
        <div class="flex flex-1 flex-col gap-3">
            <h3 class="text-xs font-semibold tracking-[1px] text-black">AVAILABILITY</h3>
            <p class="text-[13px] leading-[1.5] text-[#333]">Check provisional availability for your dates.</p>
            <div class="flex flex-col gap-2">
                <label class="text-2xs font-medium tracking-[0.5px] text-black">PICK UP DATE</label>
                <div class="flex h-[38px] items-center justify-between rounded border border-[#D0D0D0] px-3">
                    <span class="text-xs text-[#999]">Select date</span>
                    <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                </div>
                <label class="text-2xs font-medium tracking-[0.5px] text-black">RETURN DATE</label>
                <div class="flex h-[38px] items-center justify-between rounded border border-[#D0D0D0] px-3">
                    <span class="text-xs text-[#999]">Select date</span>
                    <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                </div>
            </div>
            <button class="flex h-10 items-center justify-center bg-gold text-[11px] font-semibold tracking-[1px] text-white">CHECK AVAILABILITY</button>
        </div>

        {{-- Contact column --}}
        <div class="flex flex-1 flex-col gap-3">
            <h3 class="text-xs font-semibold tracking-[1px] text-black">CONTACT</h3>
            @if ($boutique->phone)
                <div class="flex items-center gap-2">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    <span class="text-xs text-[#333]">{{ $boutique->phone }}</span>
                </div>
            @endif
            @if ($boutique->contact_email)
                <div class="flex items-center gap-2">
                    <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <span class="text-xs text-[#333]">{{ $boutique->contact_email }}</span>
                </div>
            @endif
            <div class="flex items-center gap-2">
                <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                <span class="text-xs text-[#333]">{{ $boutique->city }}, {{ $boutique->county }}</span>
            </div>
            @if ($boutique->opening_hours)
                <p class="mt-2 text-2xs font-semibold tracking-[0.5px] text-black">OPENING HOURS</p>
                <div class="flex flex-col gap-1 text-xs text-[#333]">
                    @foreach ($boutique->opening_hours as $day => $hours)
                        <div class="flex justify-between">
                            <span>{{ $day }}</span>
                            <span>{{ $hours }}</span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
</x-layouts.public>
