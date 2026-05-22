<x-layouts.public>
    <x-slot:title>{{ $boutique->name }} — Hire Collective</x-slot:title>
    <x-slot:metaDescription>{{ Str::limit(strip_tags($boutique->description), 160) }}</x-slot:metaDescription>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 bg-cream-50 px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <a href="{{ route('boutiques.index') }}" class="text-xs text-[#666] hover:underline">Boutiques</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <span class="text-xs text-black">{{ $boutique->name }}</span>
    </div>

    {{-- Hero section --}}
    <section class="flex bg-cream-200 px-[60px]" style="height:380px;">
        <div class="flex flex-col justify-center gap-4 py-10" style="width:50%;">
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
        </div>
        <div class="flex-1 overflow-hidden">
            @if ($boutique->cover_image)
                <img src="{{ Storage::url($boutique->cover_image) }}" alt="{{ $boutique->name }}" class="h-full w-full object-cover">
            @else
                <div class="h-full w-full bg-cream-100"></div>
            @endif
        </div>
    </section>

    {{-- Trust bar --}}
    <section class="flex items-center justify-between border border-[#F0F0F0] bg-cream-50 px-[60px] py-4">
        <div class="flex items-center gap-2">
            <svg class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 0 0 1.5-1.5V4.5a1.5 1.5 0 0 0-1.5-1.5H3.75a1.5 1.5 0 0 0-1.5 1.5v15a1.5 1.5 0 0 0 1.5 1.5Z"/></svg>
            <span class="text-xs text-[#333]">Designer &amp; Premium Brands</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/></svg>
            <span class="text-xs text-[#333]">Check Provisional Availability</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <span class="text-xs text-[#333]">Personal Styling Service</span>
        </div>
        <div class="flex items-center gap-2">
            <svg class="h-[18px] w-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/></svg>
            <span class="text-xs text-[#333]">5 Star Customer Experience</span>
        </div>
    </section>

    {{-- Dresses section --}}
    <section id="products" class="px-[60px] py-8">
        <div class="flex items-center justify-between">
            <h2 class="text-sm font-semibold tracking-[1.5px] text-black">DRESSES FROM {{ strtoupper($boutique->name) }}</h2>
            <a href="{{ route('products.index', ['boutique' => $boutique->slug]) }}" class="flex items-center gap-1 text-[11px] tracking-[0.5px] text-black hover:underline">
                VIEW ALL DRESSES
                <svg class="h-3.5 w-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        <div class="mt-5 grid grid-cols-6 gap-4">
            @forelse ($products->take(6) as $product)
                <a href="{{ route('products.show', [$boutique, $product]) }}" class="group block">
                    @if ($product->featured_image)
                        <div class="overflow-hidden rounded bg-cream-100" style="height:220px;">
                            <img src="{{ Storage::url($product->featured_image) }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition group-hover:scale-105">
                        </div>
                    @else
                        <div class="flex items-center justify-center rounded bg-cream-100" style="height:220px;">
                            <span class="text-xs text-[#999]">No image</span>
                        </div>
                    @endif
                    <div class="mt-2 flex flex-col gap-1">
                        <p class="text-xs font-medium text-black">{{ $product->name }}</p>
                        <p class="text-[11px] text-[#666]">
                            @if ($product->is_variable && $product->variants->count())
                                Size {{ $product->variants->min('size') }} - {{ $product->variants->max('size') }}
                            @endif
                        </p>
                        <p class="text-[13px] font-semibold text-black">
                            @if ($product->is_variable && $product->variants->count())
                                €{{ number_format($product->variants->min('price'), 0) }}
                            @elseif ($product->price)
                                €{{ number_format($product->price, 0) }}
                            @endif
                        </p>
                    </div>
                </a>
            @empty
                <p class="col-span-6 text-center text-[#666]">No items available at the moment.</p>
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
