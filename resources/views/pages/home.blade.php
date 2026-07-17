<x-layouts.public>
    <x-slot:title>Hire Collective — Luxury Fashion Hire in Ireland</x-slot:title>

    {{-- Hero --}}
    <section class="flex bg-cream-200 h-[600px]">
        <div class="relative flex flex-col w-[70%] justify-end gap-4 px-[60px] py-20">
            <img src="{{ asset('images/hero1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
            <div class="overflow absolute top-0 left-0 w-full h-full bg-black/20"></div>
            <div class="relative">
                <h1 class="animate max-w-[600px] font-serif font-semibold text-[60px] leading-[1] text-white mb-2">Find your perfect outfit — all in one place</h1>
                <p class="animate animate-delay-100 max-w-[400px] text-sm leading-relaxed text-white mb-2">Hundreds of styles brought together from some of Ireland's most trusted hire boutiques.</p>
                <a href="{{ route('products.index') }}" class="animate animate-delay-200 mt-2 inline-flex items-center justify-center self-start bg-black px-6 py-3 text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                    BROWSE NOW
                </a>
            </div>
        </div>
        <div class="relative flex justify-center items-center w-[30%] overflow-hidden">
            <img src="{{ asset('images/hero2.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Fashion hero">
            <div class="overflow absolute top-0 left-0 w-full h-full bg-black/20"></div>
            <div class="relative">
                <h3 class="animate animate-delay-300 font-serif max-w-[200px] text-center text-xl font-normal uppercase text-white">Learn how it works</h3>
            </div>
        </div>
    </section>

    {{-- Interactive text section --}}
    <section class="relative flex items-center justify-center bg-white px-[60px] py-20" x-data="{ hoveredWord: null }">
        <p class="animate max-w-5xl font-serif text-center text-[48px] leading-[1.3] text-black">
            From
            <span
                @mouseenter="hoveredWord = 'hundreds'"
                @mouseleave="hoveredWord = null"
                class="relative font-bold cursor-pointer"
            >
                hundreds of styles
            </span>
            to
            <span
                @mouseenter="hoveredWord = 'realtime'"
                @mouseleave="hoveredWord = null"
                class="relative font-bold cursor-pointer"
            >
                real-time availability
            </span>, everything is
            <span
                @mouseenter="hoveredWord = 'styled'"
                @mouseleave="hoveredWord = null"
                class="relative font-bold cursor-pointer"
            >
                styled for every occasion
            </span>
            and designed for
            <span
                @mouseenter="hoveredWord = 'exclusive'"
                @mouseleave="hoveredWord = null"
                class="relative font-bold cursor-pointer"
            >
                exclusive members</span>.
        </p>

        {{-- Hover image for "hundreds of styles" --}}
        <div
            x-show="hoveredWord === 'hundreds'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-1/4 top-1/3 -translate-x-1/2 -translate-y-1/2"
            style="display: none;"
        >
            <div class="h-48 w-40 overflow-hidden bg-cream-100 shadow-xl">
                <img src="{{ asset('images/cat-dresses.jpg') }}" class="w-full h-full object-cover" alt="hundreds of styles">
            </div>
        </div>

        {{-- Hover image for "real-time availability" --}}
        <div
            x-show="hoveredWord === 'realtime'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-1/2 top-1/4 -translate-x-1/2 -translate-y-1/2"
            style="display: none;"
        >
            <div class="h-48 w-40 overflow-hidden bg-cream-100 shadow-xl">
                <img src="{{ asset('images/cat-suits.jpg') }}" class="w-full h-full object-cover" alt="real-time availability">
            </div>
        </div>

        {{-- Hover image for "styled for every occasion" --}}
        <div
            x-show="hoveredWord === 'styled'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute left-3/4 top-1/2 -translate-x-1/2 -translate-y-1/2"
            style="display: none;"
        >
            <div class="h-48 w-40 overflow-hidden bg-cream-100 shadow-xl">
                <img src="{{ asset('images/image1.jpg') }}" class="w-full h-full object-cover" alt="styled for every occasion">
            </div>
        </div>

        {{-- Hover image for "exclusive members" --}}
        <div
            x-show="hoveredWord === 'exclusive'"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="absolute right-1/4 top-2/3 -translate-x-1/2 -translate-y-1/2"
            style="display: none;"
        >
            <div class="h-48 w-40 overflow-hidden bg-cream-100 shadow-xl">
                <img src="{{ asset('images/image1.webp') }}" class="w-full h-full object-cover" alt="exclusive members">
            </div>
        </div>
    </section>


    {{-- Featured Edit of the Week --}}
    <section class="bg-cream-50 px-[60px] py-16">
        <div class="mb-12 flex items-center justify-between">
            <h2 class="animate font-serif text-[48px] uppercase font-normal text-black">Featured Edit of the Week</h2>
            <div class="flex items-center gap-4">
                <button class="swiper-button-prev-featured flex h-12 w-12 items-center justify-center border border-black bg-transparent text-black transition-colors hover:bg-black hover:text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </button>
                <button class="swiper-button-next-featured flex h-12 w-12 items-center justify-center border border-black bg-transparent text-black transition-colors hover:bg-black hover:text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="featured-swiper swiper relative">
            <div class="swiper-wrapper">
                @forelse ($latestProducts as $product)
                    <div class="swiper-slide">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="swiper-slide">
                        <p class="text-center text-[#666] py-12">No products available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    {{-- Product Categories --}}
    <section class="py-16">
        <div class="px-[60px] pb-12">
            <h2 class="animate font-serif text-[40px] font-normal text-black">PRODUCT CATEGORIES</h2>
        </div>

        {{-- Grid layout --}}
        <div class="flex flex-col">
            {{-- Top row: 2 items --}}
            <div class="grid grid-cols-2">
                <a href="{{ route('products.index', ['category' => 'pants']) }}" class="group relative h-[400px] overflow-hidden">
                    <img src="{{ asset('images/cat-all.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                        <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">All products</span>
                    </div>
                </a>
                <a href="{{ route('products.index', ['category' => 'tops']) }}" class="group relative h-[400px] overflow-hidden">
                    <img src="{{ asset('images/cat-suits.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                        <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Suits/Jumpsuits</span>
                    </div>
                </a>
            </div>

            {{-- Bottom row: 3 items --}}
            <div class="grid grid-cols-3">
                <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="group relative h-[400px] overflow-hidden">
                    <img src="{{ asset('images/cat-dresses.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                        <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Dresses</span>
                    </div>
                </a>
                <a href="{{ route('products.index', ['category' => 'sweaters']) }}" class="group relative h-[400px] overflow-hidden">
                    <img src="{{ asset('images/cat-hats.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                        <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Hats</span>
                    </div>
                </a>
                <a href="{{ route('products.index', ['category' => 'outerwear']) }}" class="group relative h-[400px] overflow-hidden">
                    <img src="{{ asset('images/cat-bags.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                        <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Bags</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- New Collection --}}
    <section class="bg-white px-[60px] py-16">
        <div class="mb-12 flex items-center justify-between">
            <h2 class="font-serif text-[40px] font-normal text-black">NEW ARRIVALS</h2>
            <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-base font-normal text-black hover:underline">
                View all
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>

        <div class="grid grid-cols-3 gap-6">
             @forelse ($latestProducts as $product)
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-3 text-center text-[#666]">No products available at the moment.</p>
            @endforelse
        </div>
    </section>

    {{-- CTA --}}
    <section class="relative h-[600px] overflow-hidden">
        <img src="{{ asset('images/cat-all.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="N.Y KNITWEAR">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative flex h-full flex-col items-center justify-center gap-8 px-[60px]">
            <h2 class="animate font-serif text-center text-white">
                <span class="mt-2 block text-[48px] font-bold uppercase tracking-[1px] leading-[1.2]"><span class="font-normal">For</span><br> Colaboration</span>
            </h2>
            <p class="text-white max-w-[500px] text-center">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolorem ducimus sunt deleniti, tempora, porro animi, minus labore excepturi deserunt reiciendis distinctio maiores laboriosam facilis. Modi tempora maiores quae temporibus excepturi.</p>
            <div class="animate animate-delay-100 flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                   Contact Us
                </a>
            </div>
        </div>
    </section>

    {{-- Brands We Represent --}}
    <section class="bg-white px-[60px] py-20">
        <div class="mb-12 flex items-center justify-between">
            <h2 class="animate font-serif text-[48px] uppercase font-normal text-black">Brands We Represent</h2>
            <div class="flex items-center gap-4">
                <button class="swiper-button-prev-brands flex h-12 w-12 items-center justify-center border border-black bg-transparent text-black transition-colors hover:bg-black hover:text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                    </svg>
                </button>
                <button class="swiper-button-next-brands flex h-12 w-12 items-center justify-center border border-black bg-transparent text-black transition-colors hover:bg-black hover:text-white">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="brands-swiper swiper relative">
            <div class="swiper-wrapper">
                @forelse ($featuredBoutiques as $boutique)
                    <div class="swiper-slide">
                        <x-boutique-card :boutique="$boutique" />
                    </div>
                @empty
                    <div class="swiper-slide">
                        <p class="text-center text-[#666] py-12">No boutiques available at the moment.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="animate mt-16 flex justify-center">
            <a href="{{ route('boutiques.index') }}" class="inline-flex items-center justify-center bg-black px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-gray-800">
                VIEW ALL BRANDS
                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- Made for the N.Y KNITWEAR --}}
    <section class="relative h-[600px] overflow-hidden">
        <img src="{{ asset('images/bg-img.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="N.Y KNITWEAR">
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative flex h-full flex-col items-center justify-center gap-8 px-[60px]">
            <h2 class="animate font-serif text-center text-white">
                <span class="mt-2 block text-[48px] font-bold uppercase tracking-[1px] leading-[1.2]"><span class="font-normal">Register</span> <br>your boutique</span>
            </h2>

            <div class="animate animate-delay-100 flex items-center gap-4">
                @auth
                    <a href="{{ route('account.overview') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                       Go to Account
                    </a>
                @else
                    <a href="{{ route('boutique.application.create') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                       Register Now
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Filter bar --}}
    <!-- <section class="flex items-end gap-4 bg-cream-50 px-[60px] py-6">
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
    </section> -->

    {{-- Category cards --}}
    <!-- <section class="flex gap-5 px-[60px] py-8">
        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">DRESS HIRE</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'hats']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">HAT HIRE</span>
        </a>
        <a href="{{ route('products.index', ['category' => 'bags']) }}" class="relative flex-1 overflow-hidden rounded-xl bg-cream-100" style="height:280px;">
            <span class="absolute bottom-6 left-6 text-lg font-bold tracking-[2px] text-white">BAG HIRE</span>
        </a>
    </section> -->

    {{-- Boutiques carousel --}}
    @if ($featuredBoutiques->isNotEmpty())
        <!-- <section class="px-10 py-10">
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
        </section> -->
    @endif

    {{-- Trust section --}}
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
