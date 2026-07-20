<x-layouts.public>
    <x-slot:title>{{ $product->name }} — {{ $boutique->name }} — Hire Collective</x-slot:title>
    <x-slot:metaDescription>{{ Str::limit(strip_tags($product->description), 160) }}</x-slot:metaDescription>

    {{-- Breadcrumb --}}
    <div class="flex items-center gap-2 bg-white px-[60px] py-3">
        <a href="{{ route('home') }}" class="text-xs text-[#666] hover:underline">Home</a>
        <span class="text-xs text-[#666]">&gt;</span>
        <a href="{{ route('products.index') }}" class="text-xs text-[#666] hover:underline">All Products</a>
        <span class="text-xs text-[#666]">&gt;</span>
        @if ($product->categories->isNotEmpty())
            <a href="{{ route('products.index', ['category' => $product->categories->first()->slug]) }}" class="text-xs text-[#666] hover:underline">{{ $product->categories->first()->name }}</a>
            <span class="text-xs text-[#666]">&gt;</span>
        @endif
        <span class="text-xs text-black">{{ $product->name }}</span>
    </div>

    {{-- Product hero --}}
    @php
        $availabilityData = is_string($product->availability)
            ? json_decode($product->availability, true)
            : ($product->availability ?? []);
        $availabilityData = $availabilityData ?: [];
    @endphp
    <section class="flex gap-12 bg-white px-[60px] py-8" x-data="productAvailabilityCalendar(@js($availabilityData))">
        {{-- Image column --}}
        <div class="w-[45%]">
            <x-product-gallery :product="$product" />
        </div>

        {{-- Detail column --}}
        <div class="flex w-[55%] flex-col gap-4">
            <h1 class="font-serif text-[40px] leading-tight text-black">{{ $product->name }}</h1>

            {{-- Designer --}}
            @if ($product->designer)
                <div class="flex items-center gap-2">
                    <span class="text-[11px] font-semibold tracking-[1px] text-black">DESIGNER</span>
                    <span class="text-[11px] text-black">—</span>
                    <span class="text-[13px] text-[#333]">{{ $product->designer }}</span>
                </div>
            @endif

            {{-- Price --}}
            <div class="flex items-baseline text-black font-semibold gap-2 border-b border-b-cream-50 pb-5">
                <span class="text-[20px]">from</span>
                <span class="text-[24px]">
                    @if ($product->is_variable && $product->variants->count())
                        €{{ number_format($product->variants->min('price'), 0) }}
                    @elseif ($product->price_per_day)
                        €{{ number_format($product->price_per_day, 0) }}
                    @elseif ($product->price)
                        €{{ number_format($product->price, 0) }}
                    @endif
                </span>
            </div>

            <div class="flex flex-col gap-y-3 py-2 border-b border-b-cream-50 pb-5">
                {{-- Size --}}
                @if ($product->is_variable && $product->variants->isNotEmpty())
                    <div class="flex gap-1.5">
                        <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">SIZE</span>
                        <span class="text-[13px] text-[#333]">UK {{ $product->variants->pluck('size')->join(' / EU ') }}</span>
                    </div>
                @elseif ($product->size)
                    <div class="flex gap-2">
                        <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">SIZE</span>
                        <span class="text-[13px] text-[#333]">{{ $product->size }}</span>
                    </div>
                @endif

                {{-- Colour --}}
                @if ($product->colours->isNotEmpty())
                    <div class="flex gap-2">
                        <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">COLOUR</span>
                        <div class="flex items-center gap-2">
                            @foreach ($product->colours as $colour)
                                <div
                                    class="h-5 w-5 rounded-full border border-gray-200 shadow-sm"
                                    style="background-color: {{ $colour->hex_code ?? '#333' }};"
                                    title="{{ $colour->name }}"
                                ></div>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Region --}}
                @if ($boutique->city)
                    <div class="flex items-center gap-2">
                        <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">REGION</span>
                        <span class="text-[13px] text-[#333]">{{ $boutique->city }}{{ $boutique->county ? ', ' . $boutique->county : '' }}</span>
                    </div>
                @endif

                {{-- Boutique --}}
                <div class="flex gap-1.5">
                    <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">BOUTIQUE</span>
                    <a href="{{ route('boutiques.show', $boutique) }}" class="text-[13px] text-[#C7984B] hover:underline">
                        {{ $boutique->name }} →
                    </a>
                </div>
            </div>

            {{-- Availability Calendar --}}
            <div class="mt-2">
                <p class="mb-3 text-[11px] font-semibold tracking-[1px] text-black">AVAILABILITY</p>

                <div class="bg-gray-50">
                    <div class="flex items-center justify-between px-4 py-3">
                        <button type="button" @click="previousMonth()" class="text-gray-400 hover:text-gray-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <span class="text-sm font-medium text-black" x-text="monthYear"></span>
                        <button type="button" @click="nextMonth()" class="text-gray-400 hover:text-gray-900">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    </div>

                    <div class="p-2">
                        <div class="grid grid-cols-7 gap-2">
                            <div class="text-center text-2xs font-medium text-[#666]">Mo</div>
                            <div class="text-center text-2xs font-medium text-[#666]">Tu</div>
                            <div class="text-center text-2xs font-medium text-[#666]">We</div>
                            <div class="text-center text-2xs font-medium text-[#666]">Th</div>
                            <div class="text-center text-2xs font-medium text-[#666]">Fr</div>
                            <div class="text-center text-2xs font-medium text-[#666]">Sa</div>
                            <div class="text-center text-2xs font-medium text-[#666]">Su</div>

                            <template x-for="(day, index) in calendarDays" :key="index">
                                <div
                                    class="calendar-day"
                                    :class="{
                                        'available': day.status === 'available' && day.isCurrentMonth,
                                        'unavailable': day.status === 'unavailable' && day.isCurrentMonth,
                                        'confirm': day.status === 'confirm' && day.isCurrentMonth,
                                        'other-month': !day.isCurrentMonth
                                    }"
                                    x-text="day.day"
                                ></div>
                            </template>
                        </div>
                    </div>

                    <div class="flex bg-white items-center gap-4 px-4 py-2.5 text-2xs">
                        <div class="flex items-center gap-1.5">
                            <div class="h-3 w-3" style="background-color: #dcfce7;"></div>
                            <span class="text-[#666]">Available</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="h-3 w-3" style="background-color: #fee2e2;"></div>
                            <span class="text-[#666]">Unavailable</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <div class="h-3 w-3" style="background-color: #fef3c7;"></div>
                            <span class="text-[#666]">Need to confirm</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Request to Book Button --}}
            <a href="{{ route('enquiry.create', $product) }}" class="mt-4 flex h-12 items-center justify-center bg-[#2C2C2C] text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-black">
                REQUEST TO BOOK
            </a>

            {{-- Description --}}
            @if ($product->description)
                <div class="mt-4">
                    <p class="mb-2 text-[11px] font-semibold tracking-[1px] text-black">DESCRIPTION</p>
                    <div class="text-[13px] leading-[1.8] text-[#333]">
                        {!! Str::markdown($product->description) !!}
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- You may also like --}}
    @if (isset($related) && $related->isNotEmpty())
        <section class="bg-cream-50 px-[60px] py-10">
            <h2 class="font-serif text-[26px] leading-tight text-black">YOU MAY ALSO LIKE</h2>
            <div class="mt-6 grid grid-cols-4 gap-5">
                @foreach ($related->take(4) as $relatedProduct)
                    <x-product-card :product="$relatedProduct" />
                @endforeach
            </div>
        </section>
    @endif
</x-layouts.public>
