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
                @if ($product->county)
                    <div class="flex items-center gap-2">
                        <span class="w-[150px] text-[11px] font-semibold tracking-[1px] text-black mt-[1px]">REGION</span>
                        <span class="text-[13px] text-[#333]">{{ $product->county->getLabel() }}</span>
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
            <button
                type="button"
                x-on:click="$dispatch('open-modal', 'request-booking')"
                class="mt-4 flex h-12 w-full items-center justify-center bg-[#2C2C2C] text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-black"
            >
                REQUEST TO BOOK
            </button>

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

    {{-- Request a Booking Modal --}}
    <x-modal name="request-booking" maxWidth="md" focusable>
        <div class="p-8" x-data="bookingForm({{ $product->id }})" x-cloak>
            <template x-if="!submitted">
                <div>
                    <div class="flex items-center justify-between">
                        <h2 class="font-serif text-[28px] italic text-black">Request a Booking</h2>
                        <button type="button" x-on:click="$dispatch('close-modal', 'request-booking')" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-[13px] text-[#666]">Fill in the details below and we will get back to you within 24 hours.</p>

                    <form @submit.prevent="submitForm" class="mt-6 flex flex-col gap-5">
                        @if ($product->is_variable && $product->variants->isNotEmpty())
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[11px] font-semibold tracking-[1px] text-black">SIZE</label>
                                <select x-model="form.product_variant_id" class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                                    <option value="">Select a size</option>
                                    @foreach ($product->variants as $variant)
                                        <option value="{{ $variant->id }}">{{ $variant->size }} — €{{ number_format($variant->price, 2) }}</option>
                                    @endforeach
                                </select>
                                <p x-show="errors.product_variant_id" x-text="errors.product_variant_id" class="text-[11px] text-red-600"></p>
                            </div>
                        @endif

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">FULL NAME</label>
                            <input type="text" x-model="form.customer_name" placeholder="Enter your full name"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.customer_name" x-text="errors.customer_name" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">EMAIL ADDRESS</label>
                            <input type="email" x-model="form.customer_email" placeholder="your@email.com"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.customer_email" x-text="errors.customer_email" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">PHONE NUMBER</label>
                            <input type="tel" x-model="form.customer_phone" placeholder="+44 000 000 0000"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.customer_phone" x-text="errors.customer_phone" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">EVENT DATE</label>
                            <input type="date" x-model="form.desired_dates"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.desired_dates" x-text="errors.desired_dates" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">MESSAGE</label>
                            <textarea x-model="form.message" rows="4" placeholder="Tell us about your event and any special requirements..."
                                      class="w-full border border-[#D0D0D0] bg-white px-3 py-2.5 text-[13px] text-[#333]"></textarea>
                            <p x-show="errors.message" x-text="errors.message" class="text-[11px] text-red-600"></p>
                        </div>

                        <button type="submit" :disabled="loading"
                                class="mt-2 flex h-12 items-center justify-center bg-black text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-gray-800 disabled:opacity-50">
                            <span x-show="!loading">SEND REQUEST</span>
                            <span x-show="loading">SENDING...</span>
                        </button>
                    </form>
                </div>
            </template>

            <template x-if="submitted">
                <div class="py-8 text-center">
                    <svg class="mx-auto h-12 w-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    <h3 class="mt-4 font-serif text-[24px] italic text-black">Request Sent!</h3>
                    <p class="mt-2 text-[13px] text-[#666]">We'll get back to you within 24 hours.</p>
                    <button type="button" x-on:click="$dispatch('close-modal', 'request-booking'); resetForm()"
                            class="mt-6 inline-flex h-10 items-center justify-center border border-gray-300 px-6 text-[13px] font-medium text-gray-700 hover:bg-gray-50">
                        CLOSE
                    </button>
                </div>
            </template>
        </div>
    </x-modal>

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
