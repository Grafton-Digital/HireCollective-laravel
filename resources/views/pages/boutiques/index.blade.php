<x-layouts.public>
    <x-slot:title>Boutiques — Hire Collective</x-slot:title>
    <x-slot:metaDescription>Discover Ireland's finest luxury fashion hire boutiques. Dresses, hats, and bags for every occasion.</x-slot:metaDescription>

    {{-- Title section --}}
    <section class="px-[60px] py-12">
        <span class="text-[#c7a869] text-center text-sm block">DISCOVER</span>
        <h1 class="animate font-serif text-center text-[48px] uppercase font-normal text-black animate-visible">All Boutiques</h1>
        <p class="max-w-[520px] text-center text-sm leading-relaxed text-gray-600 mx-auto mb-6">Explore our curated selection of luxury knitwear boutiques, each handpicked for their exceptional craftsmanship and quality.</p>

        {{-- Search section --}}
        <form method="GET" action="{{ route('boutiques.index') }}" class="relative max-w-[500px] mx-auto">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Search boutiques..."
                class="w-full border border-gray-300 bg-white px-4 py-3 pr-24 text-sm text-black placeholder-gray-400 focus:border-black focus:outline-none focus:ring-1 focus:ring-black"
            />
            @if(request('search'))
                <a href="{{ route('boutiques.index') }}" class="absolute right-12 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </a>
            @endif
            <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </button>
        </form>
    </section>

    {{-- Filter bar --}}
    <!-- <section class="flex items-center justify-between bg-cream-50 px-[60px] py-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('boutiques.index') }}"
               class="{{ !request('category') ? 'bg-black text-white' : 'border border-black text-black' }} rounded-full px-5 py-2.5 text-xs font-medium tracking-[1px]">
                ALL BOUTIQUES
            </a>
            <a href="{{ route('boutiques.index', ['category' => 'dresses']) }}"
               class="{{ request('category') === 'dresses' ? 'bg-black text-white' : 'border border-black text-black' }} rounded-full px-5 py-2.5 text-xs font-medium tracking-[1px]">
                DRESS HIRE
            </a>
            <a href="{{ route('boutiques.index', ['category' => 'hats']) }}"
               class="{{ request('category') === 'hats' ? 'bg-black text-white' : 'border border-black text-black' }} rounded-full px-5 py-2.5 text-xs font-medium tracking-[1px]">
                HAT HIRE
            </a>
            <a href="{{ route('boutiques.index', ['category' => 'bags']) }}"
               class="{{ request('category') === 'bags' ? 'bg-black text-white' : 'border border-black text-black' }} rounded-full px-5 py-2.5 text-xs font-medium tracking-[1px]">
                BAG HIRE
            </a>
        </div>
        <div class="flex items-center gap-2">
            <span class="text-xs tracking-[1px] text-[#666]">SORT BY</span>
            <select name="sort" onchange="window.location.href=this.value" class="rounded border border-[#E0E0E0] px-3 py-2 text-xs text-black">
                <option value="{{ route('boutiques.index', array_merge(request()->query(), ['sort' => 'name'])) }}" {{ request('sort', 'name') === 'name' ? 'selected' : '' }}>A - Z</option>
                <option value="{{ route('boutiques.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
            </select>
        </div>
    </section> -->

    {{-- Boutique grid --}}
    <section class="px-[60px] pb-20">
        {{-- Results bar --}}
        <div class="flex items-center justify-between mb-6">
            <div class="text-sm text-gray-600">
                Showing {{ $boutiques->count() }} boutique{{ $boutiques->count() !== 1 ? 's' : '' }}
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select name="sort" onchange="window.location.href=this.value" class="border border-gray-300 bg-white px-3 py-2 pr-[35px] text-sm text-black focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'featured'])) }}" {{ request('sort', 'featured') === 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'name'])) }}" {{ request('sort') === 'name' ? 'selected' : '' }}>A - Z</option>
                    <option value="{{ route('boutiques.index', array_merge(request()->except('sort'), ['sort' => 'newest'])) }}" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-x-5 gap-y-20">
            @forelse ($boutiques as $boutique)
                <x-boutique-card :boutique="$boutique" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No boutiques found.</p>
            @endforelse
        </div>

        @if ($boutiques->hasPages())
            <div class="py-10">
                {{ $boutiques->links('vendor.pagination.custom') }}
            </div>
        @endif
    </section>

    {{-- Trust bar --}}
    <!-- <section class="flex items-center justify-between bg-cream-200 px-[60px] py-12">
        <div class="flex flex-col items-center gap-3">
            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V4.5a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v15a1.5 1.5 0 0 0 1.5 1.5Z"/></svg>
            <span class="text-[13px] text-[#333]">Hundreds of styles</span>
            <span class="text-[13px] text-[#666]">from trusted boutiques</span>
        </div>
        <div class="flex flex-col items-center gap-3">
            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
            <span class="text-[13px] text-[#333]">Real time availability</span>
            <span class="text-[13px] text-[#666]">for your event</span>
        </div>
        <div class="flex flex-col items-center gap-3">
            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <span class="text-[13px] text-[#333]">Styled for every</span>
            <span class="text-[13px] text-[#666]">occasion</span>
        </div>
        <div class="flex flex-col items-center gap-3">
            <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
            <span class="text-[13px] text-[#333]">Exclusive member</span>
            <span class="text-[13px] text-[#666]">benefits</span>
        </div>
    </section> -->
</x-layouts.public>
