<x-layouts.public>
    <x-slot:title>Hire Collective — Luxury Fashion Hire in Ireland</x-slot:title>

    {{-- Hero --}}
    <section class="relative flex bg-cream-200" style="height:520px;">
        <div class="flex flex-col justify-center gap-4 px-[60px] py-20" style="width:500px;">
            <h1 class="font-serif text-[44px] italic leading-[1.2] text-black">Find your perfect outfit — all in one place</h1>
            <div class="h-0.5 w-[35px] bg-gold"></div>
            <p class="text-sm leading-relaxed text-[#333]">Hundreds of styles brought together from some of Ireland's most trusted hire boutiques.</p>
            <a href="{{ route('products.index') }}" class="mt-2 inline-flex items-center justify-center self-start bg-black px-6 py-3 text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                BROWSE NOW
            </a>
        </div>
        <div class="flex-1 overflow-hidden">
            {{-- Hero image placeholder — replace with actual image --}}
            <div class="h-full w-full bg-cream-100"></div>
        </div>
    </section>

    {{-- Filter bar --}}
    <section class="flex items-end gap-4 bg-cream-50 px-[60px] py-6">
        <form method="GET" action="{{ route('products.index') }}" class="flex flex-1 items-end gap-4">
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
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">CATEGORY</label>
                <select name="category" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Categories</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">OCCASION</label>
                <select name="occasion" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                    <option value="">All Occasions</option>
                </select>
            </div>
            <div class="flex flex-1 flex-col gap-1.5">
                <label class="text-2xs font-medium tracking-[1px] text-black">DATE</label>
                <input type="text" name="date" placeholder="Select date" class="h-10 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
            </div>
            <button type="submit" class="flex h-10 w-[120px] items-center justify-center bg-black text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                SEARCH
            </button>
        </form>
    </section>

    {{-- Category cards --}}
    <section class="flex gap-5 px-[60px] py-8">
        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">DRESS HIRE</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'hats']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">HAT HIRE</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'bags']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">BAG HIRE</span>
        </a>
    </section>

    {{-- Boutiques carousel --}}
    @if ($featuredBoutiques->isNotEmpty())
        <section class="px-10 py-10">
            <div class="flex items-center justify-between px-[20px]">
                <div></div>
                <h2 class="text-base font-medium tracking-[3px] text-black">BROWSE OUR TRUSTED BOUTIQUES</h2>
                <div></div>
            </div>
            <div class="mt-8 flex items-center gap-4">
                <button class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[#E0E0E0]">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                </button>
                <div class="flex flex-1 gap-4">
                    @foreach ($featuredBoutiques as $boutique)
                        <a href="{{ route('boutiques.show', $boutique) }}" class="flex flex-1 flex-col items-center gap-2 rounded-lg border border-[#E0E0E0] p-5">
                            <span class="font-serif text-base font-bold text-black">{{ strtoupper($boutique->name) }}</span>
                            <span class="text-xs text-[#666]">Dress Hire</span>
                        </a>
                    @endforeach
                </div>
                <button class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-[#E0E0E0]">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                </button>
            </div>
        </section>
    @endif

    {{-- Trust section --}}
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
