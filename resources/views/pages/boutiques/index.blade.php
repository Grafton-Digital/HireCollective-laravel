<x-layouts.public>
    <x-slot:title>Boutiques — Hire Collective</x-slot:title>
    <x-slot:metaDescription>Discover Ireland's finest luxury fashion hire boutiques. Dresses, hats, and bags for every occasion.</x-slot:metaDescription>

    {{-- Title section --}}
    <section class="bg-cream-50 px-[60px] py-12">
        <h1 class="font-serif text-[42px] text-black">Our Trusted Boutiques</h1>
        <p class="mt-2 text-base text-[#666]">Discover Ireland's most loved hire boutiques.</p>
    </section>

    {{-- Filter bar --}}
    <section class="flex items-center justify-between bg-cream-50 px-[60px] py-6">
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
    </section>

    {{-- Boutique grid --}}
    <section class="bg-cream-50 px-[60px] py-5">
        <div class="grid grid-cols-3 gap-5">
            @forelse ($boutiques as $boutique)
                <x-boutique-card :boutique="$boutique" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No boutiques found.</p>
            @endforelse
        </div>

        @if ($boutiques->hasMorePages())
            <div class="flex justify-center py-10">
                <a href="{{ $boutiques->nextPageUrl() }}" class="rounded-full border border-black px-8 py-3.5 text-xs font-medium tracking-[1px] text-black hover:bg-black hover:text-white">
                    LOAD MORE BOUTIQUES
                </a>
            </div>
        @else
            <div class="py-10">
                {{ $boutiques->links() }}
            </div>
        @endif
    </section>

    {{-- Trust bar --}}
    <section class="flex items-center justify-between bg-cream-200 px-[60px] py-12">
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
    </section>
</x-layouts.public>
