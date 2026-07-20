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

    {{-- Boutique grid --}}
    <section class="px-[60px] pb-20">
        {{-- Results bar --}}
        <div class="flex items-center justify-between mb-6">
            <div class="text-sm text-gray-600">
                Showing {{ $boutiques->count() }} boutique{{ $boutiques->count() !== 1 ? 's' : '' }}
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Sort by:</span>
                <select name="sort" onchange="window.location.href=this.value" class="border border-gray-300 bg-white pl-3 pr-8 py-2 pr-[35px] text-sm text-black focus:border-black focus:outline-none focus:ring-1 focus:ring-black">
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
    
</x-layouts.public>
