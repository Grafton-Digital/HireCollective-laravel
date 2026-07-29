<x-layouts.public>
    <x-slot:title>Hire Collective — Luxury Fashion Hire in Ireland</x-slot:title>

    {{-- Hero --}}
    <section class="flex bg-cream-200 h-[600px]">
        <div class="relative flex flex-col w-[70%] justify-end gap-4 px-[60px] py-20">
            @if (!empty($content['hero']['left']['image']))
                <img src="{{ Storage::disk('public')->url($content['hero']['left']['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
            @else
                <img src="{{ asset('images/hero1.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Fashion hero">
            @endif
            <div class="overflow absolute top-0 left-0 w-full h-full bg-black/20"></div>
            <div class="relative">
                <h1 class="animate max-w-[600px] font-serif font-semibold text-[60px] leading-[1] text-white mb-2">{{ $content['hero']['left']['heading'] ?? 'Find your perfect outfit — all in one place' }}</h1>
                <p class="animate animate-delay-100 max-w-[400px] text-sm leading-relaxed text-white mb-2">{{ $content['hero']['left']['subtitle'] ?? 'Hundreds of styles brought together from some of Ireland\'s most trusted hire boutiques.' }}</p>
                <a href="{{ $content['hero']['left']['button_link'] ?? '/products' }}" class="animate animate-delay-200 mt-2 inline-flex items-center justify-center self-start bg-black px-6 py-3 text-xs font-medium tracking-[1.5px] text-white hover:bg-gray-800">
                    {{ strtoupper($content['hero']['left']['button_text'] ?? 'BROWSE NOW') }}
                </a>
            </div>
        </div>
        <div class="relative flex justify-center items-center w-[30%] overflow-hidden">
            @if (!empty($content['hero']['right']['image']))
                <img src="{{ Storage::disk('public')->url($content['hero']['right']['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Fashion hero">
            @else
                <img src="{{ asset('images/hero2.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Fashion hero">
            @endif
            <div class="overflow absolute top-0 left-0 w-full h-full bg-black/20"></div>
            <div class="relative">
                <a href="{{ route('how-it-works') }}" class="animate animate-delay-300 block max-w-[160px] font-serif max-w-[200px] text-center text-xl font-normal uppercase text-white hover:underline">{{ $content['hero']['right']['text'] ?? 'Learn how it works' }}</a>
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
            <h2 class="animate font-serif text-[48px] uppercase font-normal text-black">{{ $content['featured']['heading'] ?? 'Featured Edit of the Week' }}</h2>
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

        @if (!empty($content['categories']))
            @php
                $categories = collect($content['categories']);
                $topRow = $categories->take(2);
                $bottomRow = $categories->skip(2);
            @endphp
            <div class="flex flex-col">
                @if ($topRow->isNotEmpty())
                    <div class="grid grid-cols-{{ $topRow->count() }}">
                        @foreach ($topRow as $category)
                            <a href="{{ $category['link'] }}" class="group relative h-[400px] overflow-hidden">
                                @if (!empty($category['image']))
                                    <img src="{{ Storage::disk('public')->url($category['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="{{ $category['text'] }}">
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                                    <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">{{ $category['text'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if ($bottomRow->isNotEmpty())
                    <div class="grid grid-cols-{{ $bottomRow->count() }}">
                        @foreach ($bottomRow as $category)
                            <a href="{{ $category['link'] }}" class="group relative h-[400px] overflow-hidden">
                                @if (!empty($category['image']))
                                    <img src="{{ Storage::disk('public')->url($category['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="{{ $category['text'] }}">
                                @endif
                                <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                                    <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">{{ $category['text'] }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        @else
            {{-- Fallback: hardcoded categories --}}
            <div class="flex flex-col">
                <div class="grid grid-cols-2">
                    <a href="{{ route('products.index') }}" class="group relative h-[400px] overflow-hidden">
                        <img src="{{ asset('images/cat-all.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="All products">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                            <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">All products</span>
                        </div>
                    </a>
                    <a href="{{ route('products.index', ['category' => 'tops']) }}" class="group relative h-[400px] overflow-hidden">
                        <img src="{{ asset('images/cat-suits.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Suits/Jumpsuits">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                            <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Suits/Jumpsuits</span>
                        </div>
                    </a>
                </div>
                <div class="grid grid-cols-3">
                    <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="group relative h-[400px] overflow-hidden">
                        <img src="{{ asset('images/cat-dresses.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Dresses">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                            <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Dresses</span>
                        </div>
                    </a>
                    <a href="{{ route('products.index', ['category' => 'hats']) }}" class="group relative h-[400px] overflow-hidden">
                        <img src="{{ asset('images/cat-hats.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Hats">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                            <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Hats</span>
                        </div>
                    </a>
                    <a href="{{ route('products.index', ['category' => 'bags']) }}" class="group relative h-[400px] overflow-hidden">
                        <img src="{{ asset('images/cat-bags.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover -z-1" alt="Bags">
                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 transition-all duration-300 group-hover:bg-[#00000059]">
                            <span class="text-4xl font-normal tracking-[2px] text-white opacity-0 transition-opacity duration-300 group-hover:opacity-100">Bags</span>
                        </div>
                    </a>
                </div>
            </div>
        @endif
    </section>

    {{-- New Arrivals --}}
    <section class="bg-white px-[60px] py-16">
        <div class="mb-12 flex items-center justify-between">
            <h2 class="font-serif text-[40px] font-normal text-black">{{ $content['new_arrivals']['heading'] ?? 'NEW ARRIVALS' }}</h2>
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

    {{-- For Collaboration --}}
    <section class="relative h-[600px] overflow-hidden">
        @if (!empty($content['collaboration']['image']))
            <img src="{{ Storage::disk('public')->url($content['collaboration']['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Collaboration">
        @else
            <img src="{{ asset('images/cat-all.jpg') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Collaboration">
        @endif
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative flex h-full flex-col items-center justify-center gap-8 px-[60px]">
            <h2 class="animate font-serif text-center text-white">
                <span class="mt-2 block text-[48px] font-bold uppercase tracking-[1px] leading-[1.2]">{{ $content['collaboration']['heading'] ?? 'For Colaboration' }}</span>
            </h2>
            @if (!empty($content['collaboration']['text']))
                <p class="animate animate-delay-100 text-white max-w-[500px] text-center">{{ $content['collaboration']['text'] }}</p>
            @endif
            <div class="animate animate-delay-200 flex items-center gap-4">
                <button type="button" x-data @click="$dispatch('open-modal', 'collaboration-enquiry')" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                    {{ $content['collaboration']['button_text'] ?? 'Contact Us' }}
                </button>
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
            <a href="{{ $content['brands']['button_link'] ?? '/boutiques' }}" class="inline-flex items-center justify-center bg-black px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-gray-800">
                {{ strtoupper($content['brands']['button_text'] ?? 'VIEW ALL BRANDS') }}
                <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                </svg>
            </a>
        </div>
    </section>

    {{-- Register your boutique --}}
    <section class="relative h-[600px] overflow-hidden">
        @if (!empty($content['register']['image']))
            <img src="{{ Storage::disk('public')->url($content['register']['image']) }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Register your boutique">
        @else
            <img src="{{ asset('images/bg-img.webp') }}" class="absolute top-0 left-0 w-full h-full object-cover" alt="Register your boutique">
        @endif
        <div class="absolute inset-0 bg-black/40"></div>

        <div class="relative flex h-full flex-col items-center justify-center gap-8 px-[60px]">
            <h2 class="animate max-w-[400px] font-serif text-center text-white">
                <span class="mt-2 block text-[48px] font-bold uppercase tracking-[1px] leading-[1.2]">{{ $content['register']['heading'] ?? 'Register your boutique' }}</span>
            </h2>

            <div class="animate animate-delay-100 flex items-center gap-4">
                @auth
                    <a href="{{ route('account.overview') }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                       Go to Account
                    </a>
                @else
                    <a href="{{ $content['register']['button_link'] ?? '/boutique/apply' }}" class="inline-flex items-center justify-center border-[1px] border-white bg-transparent px-6 py-3 text-sm font-medium tracking-[1.5px] text-white transition-colors hover:bg-white hover:text-black">
                       {{ $content['register']['button_text'] ?? 'Register Now' }}
                    </a>
                @endauth
            </div>
        </div>
    </section>

    {{-- Collaboration Enquiry Modal --}}
    <x-modal name="collaboration-enquiry" maxWidth="md" focusable>
        <div class="p-8" x-data="collaborationForm()" x-cloak>
            <template x-if="!submitted">
                <div>
                    <div class="flex items-center justify-between">
                        <h2 class="font-serif text-[28px] italic text-black">Collaboration Enquiry</h2>
                        <button type="button" x-on:click="$dispatch('close-modal', 'collaboration-enquiry')" class="text-gray-400 hover:text-gray-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-2 text-[13px] text-[#666]">Interested in collaborating? Fill out the form below and our partnerships team will be in touch.</p>

                    <form @submit.prevent="submitForm" class="mt-6 flex flex-col gap-5">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">YOUR NAME *</label>
                            <input type="text" x-model="form.name" placeholder="Full name"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.name" x-text="errors.name" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">COMPANY / BRAND</label>
                            <input type="text" x-model="form.company" placeholder="Your brand or company name"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.company" x-text="errors.company" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">EMAIL *</label>
                            <input type="email" x-model="form.email" placeholder="your@email.com"
                                   class="h-11 w-full border border-[#D0D0D0] bg-white px-3 text-[13px] text-[#333]">
                            <p x-show="errors.email" x-text="errors.email" class="text-[11px] text-red-600"></p>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label class="text-[11px] font-semibold tracking-[1px] text-black">MESSAGE *</label>
                            <textarea x-model="form.message" rows="4" placeholder="Tell us about your collaboration idea..."
                                      class="w-full border border-[#D0D0D0] bg-white px-3 py-2.5 text-[13px] text-[#333]"></textarea>
                            <p x-show="errors.message" x-text="errors.message" class="text-[11px] text-red-600"></p>
                        </div>

                        <button type="submit" :disabled="loading"
                                class="mt-2 flex h-12 items-center justify-center bg-black text-[13px] font-semibold tracking-[1.5px] text-white hover:bg-gray-800 disabled:opacity-50">
                            <span x-show="!loading">SEND ENQUIRY</span>
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
                    <h3 class="mt-4 font-serif text-[24px] italic text-black">Enquiry Sent!</h3>
                    <p class="mt-2 text-[13px] text-[#666]">Thank you for your interest. We'll be in touch shortly.</p>
                    <button type="button" x-on:click="$dispatch('close-modal', 'collaboration-enquiry'); resetForm()"
                            class="mt-6 inline-flex h-10 items-center justify-center border border-gray-300 px-6 text-[13px] font-medium text-gray-700 hover:bg-gray-50">
                        CLOSE
                    </button>
                </div>
            </template>
        </div>
    </x-modal>
</x-layouts.public>
