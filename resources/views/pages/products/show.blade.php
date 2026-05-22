<x-layouts.public>
    <x-slot:title>{{ $product->name }} — {{ $boutique->name }} — Hire Collective</x-slot:title>
    <x-slot:metaDescription>{{ Str::limit(strip_tags($product->description), 160) }}</x-slot:metaDescription>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 bg-cream-50 px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-xs text-[#666] hover:underline">Dresses</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <span class="text-xs text-black">{{ $product->name }}</span>
    </div>

    {{-- Product hero --}}
    <section class="flex gap-12 bg-cream-50 px-[60px] py-6">
        {{-- Image column --}}
        <div class="flex-1">
            <x-product-gallery :product="$product" />
        </div>

        {{-- Detail column --}}
        <div class="flex flex-1 flex-col gap-5">
            <h1 class="font-serif text-[36px] italic text-black">{{ $product->name }}</h1>

            {{-- Price --}}
            <div class="flex items-end gap-2">
                <span class="text-[28px] font-semibold text-black">
                    @if ($product->is_variable && $product->variants->count())
                        €{{ number_format($product->variants->min('price'), 0) }}
                    @elseif ($product->price)
                        €{{ number_format($product->price, 0) }}
                    @endif
                </span>
                <span class="pb-1 text-[13px] text-[#666]">per hire</span>
            </div>

            {{-- Boutique --}}
            <div class="flex items-center gap-1.5">
                <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M13.5 21v-7.5a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349M3.75 21V9.349m0 0a3.001 3.001 0 0 0 3.75-.615A2.993 2.993 0 0 0 9.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 0 0 2.25 1.016c.896 0 1.7-.393 2.25-1.015a3.001 3.001 0 0 0 3.75.614m-16.5 0a3.004 3.004 0 0 1-.621-4.72l1.189-1.19A1.5 1.5 0 0 1 5.378 3h13.243a1.5 1.5 0 0 1 1.06.44l1.19 1.189a3 3 0 0 1-.621 4.72M6.75 18h3.75a.75.75 0 0 0 .75-.75V13.5a.75.75 0 0 0-.75-.75H6.75a.75.75 0 0 0-.75.75v3.75c0 .414.336.75.75.75Z"/></svg>
                <span class="text-[13px] text-[#666]">From <a href="{{ route('boutiques.show', $boutique) }}" class="underline hover:text-black">{{ $boutique->name }}</a>, {{ $boutique->city }}</span>
            </div>

            <div class="h-px bg-[#E0E0E0]"></div>

            {{-- Description --}}
            @if ($product->description)
                <div>
                    <p class="text-[11px] font-semibold tracking-[1px] text-black">DESCRIPTION</p>
                    <div class="mt-2 text-[13px] leading-[1.7] text-[#333]">
                        {!! Str::markdown($product->description) !!}
                    </div>
                </div>
            @endif

            {{-- Details section --}}
            <div class="flex flex-col gap-4">
                <div class="h-px bg-[#E0E0E0]"></div>

                {{-- Size --}}
                @if ($product->is_variable && $product->variants->isNotEmpty())
                    <div class="flex flex-col gap-2">
                        <p class="text-[11px] font-semibold tracking-[1px] text-black">SIZE</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->variants as $variant)
                                <span class="flex h-8 w-8 items-center justify-center border border-[#D0D0D0] text-xs text-black">{{ $variant->size }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Colour --}}
                @if ($product->colours->isNotEmpty())
                    <div class="flex flex-col gap-2">
                        <p class="text-[11px] font-semibold tracking-[1px] text-black">COLOUR</p>
                        <span class="text-[13px] text-[#333]">{{ $product->colours->pluck('name')->join(', ') }}</span>
                    </div>
                @endif

                {{-- Occasion --}}
                @if ($product->occasions->isNotEmpty())
                    <div class="flex flex-col gap-2">
                        <p class="text-[11px] font-semibold tracking-[1px] text-black">OCCASION</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach ($product->occasions as $occasion)
                                <span class="rounded-full border border-[#E0E0E0] px-3 py-1 text-[11px] text-[#333]">{{ $occasion->name }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="h-px bg-[#E0E0E0]"></div>
            </div>

            {{-- Availability section --}}
            <div class="flex flex-col gap-3">
                <p class="text-[11px] font-semibold tracking-[1px] text-black">CHECK AVAILABILITY</p>
                <div class="flex gap-3">
                    <div class="flex flex-1 flex-col gap-1">
                        <label class="text-2xs font-medium tracking-[0.5px] text-black">PICK UP DATE</label>
                        <div class="flex h-[38px] items-center justify-between rounded border border-[#D0D0D0] px-3">
                            <span class="text-xs text-[#999]">Select date</span>
                            <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                        </div>
                    </div>
                    <div class="flex flex-1 flex-col gap-1">
                        <label class="text-2xs font-medium tracking-[0.5px] text-black">RETURN DATE</label>
                        <div class="flex h-[38px] items-center justify-between rounded border border-[#D0D0D0] px-3">
                            <span class="text-xs text-[#999]">Select date</span>
                            <svg class="h-3.5 w-3.5 text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
                        </div>
                    </div>
                </div>
                @if ($product->is_available)
                    <div class="flex items-center gap-1.5 rounded bg-[#E8F5E9] px-3 py-1.5">
                        <svg class="h-3.5 w-3.5 text-[#2E7D32]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>
                        <span class="text-[11px] font-medium text-[#2E7D32]">Provisionally available for your dates</span>
                    </div>
                @endif
            </div>

            <div class="h-px bg-[#E0E0E0]"></div>

            {{-- Action buttons --}}
            <div class="flex flex-col gap-2.5">
                <a href="{{ route('enquiry.create', $product) }}" class="flex h-12 items-center justify-center rounded-sm bg-black text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-gray-800">
                    ENQUIRE NOW
                </a>
                <a href="{{ route('enquiry.create', $product) }}" class="flex h-12 items-center justify-center rounded-sm border border-black text-[13px] font-medium tracking-[1px] text-black hover:bg-black hover:text-white">
                    MESSAGE BOUTIQUE
                </a>
                <button class="flex items-center justify-center gap-1.5 py-2 text-xs text-[#666] hover:text-black">
                    <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
                    Add to Wishlist
                </button>
            </div>
        </div>
    </section>

    {{-- You may also like --}}
    @if (isset($related) && $related->isNotEmpty())
        <section class="px-[60px] py-10">
            <h2 class="text-center text-sm font-semibold tracking-[1.5px] text-black">YOU MAY ALSO LIKE</h2>
            <div class="mt-6 grid grid-cols-4 gap-5">
                @foreach ($related->take(4) as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </section>
    @endif

    {{-- Trust bar --}}
    <section class="flex items-center justify-between bg-cream-200 px-[60px] py-6">
        <div class="flex flex-col items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V4.5a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v15a1.5 1.5 0 0 0 1.5 1.5Z"/></svg>
            <span class="text-center text-[11px] text-[#333]">Hundreds of styles</span>
            <span class="text-center text-[11px] text-[#333]">from trusted boutiques</span>
        </div>
        <div class="flex flex-col items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
            <span class="text-center text-[11px] text-[#333]">Real time availability</span>
            <span class="text-center text-[11px] text-[#333]">for your event</span>
        </div>
        <div class="flex flex-col items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <span class="text-center text-[11px] text-[#333]">Styled for every</span>
            <span class="text-center text-[11px] text-[#333]">occasion</span>
        </div>
        <div class="flex flex-col items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
            <span class="text-center text-[11px] text-[#333]">Exclusive member</span>
            <span class="text-center text-[11px] text-[#333]">benefits</span>
        </div>
    </section>
</x-layouts.public>
