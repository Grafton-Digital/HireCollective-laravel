<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Hire Collective — Luxury Dress, Hat & Bag Hire' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Ireland\'s luxury multi-boutique fashion hire marketplace. Browse independent dress, hat, and bag hire boutiques in one place.' }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-gray-900 antialiased">
    {{-- Top banner --}}
    <div class="bg-cream-200 py-2 text-center">
        <p class="text-[11px] font-normal tracking-[1px] text-black">FREE DELIVERY ON ORDERS OVER €100</p>
    </div>

    {{-- Header --}}
    <header class="relative flex items-center justify-between bg-cream-50 px-4 py-4 md:px-[60px]" x-data="{ mobileMenuOpen: false, searchOpen: false }">
        {{-- Left section: Burger menu + links --}}
        <div class="flex items-center gap-6">
            {{-- Burger menu button --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="h-6 w-6">
                <svg x-show="!mobileMenuOpen" class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
                <svg x-show="mobileMenuOpen" class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>

            {{-- Navigation links --}}
            <nav class="hidden items-center gap-6 md:flex">
                <a href="#" class="text-xs text-red-500 font-normal tracking-[1px] hover:underline">NEW</a>
                <a href="{{ route('products.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">All PRODUCTS</a>
                <a href="{{ route('pages.show', 'about') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
            </nav>
        </div>

        {{-- Center: Logo --}}
        <a href="{{ route('home') }}" class="font-serif text-[26px] tracking-[3px] text-black md:text-2xl">
            HIRE COLLECTIVE
        </a>

        {{-- Right section: Icons --}}
        <div class="flex w-full max-w-[305px] items-center justify-end gap-4">
            <button @click="searchOpen = true" class="h-5 w-5">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </button>
            <a href="#" class="h-5 w-5">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            </a>
            <a href="#" class="h-5 w-5">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
            </a>
        </div>

        {{-- Search overlay --}}
        <div
            x-show="searchOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="absolute inset-0 z-50 flex items-center bg-white px-4 md:px-[60px]"
            style="display: none;"
        >
            <button @click="searchOpen = false" class="mr-4 h-6 w-6 flex-shrink-0">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-1 items-center">
                <input
                    type="text"
                    name="search"
                    placeholder="Search dresses, bags, hats, boutiques..."
                    class="flex-1 border-none border-black bg-transparent py-2 text-base text-black placeholder-gray-400 focus:outline-none"
                    x-ref="searchInput"
                    @keydown.escape="searchOpen = false"
                    style="border-bottom: 1px solid #dadada;"
                >
                <button type="submit" class="ml-4 h-6 w-6 flex-shrink-0">
                    <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <circle cx="11" cy="11" r="8"/>
                        <path d="m21 21-4.3-4.3"/>
                    </svg>
                </button>
            </form>
        </div>

        {{-- Fullscreen menu --}}
        <div
            x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed w-[300px] inset-0 z-50 bg-cream-50"
            style="display: none;"
        >
            {{-- Close button --}}
            <div class="absolute left-[24px] top-[54px]">
                <button @click="mobileMenuOpen = false" class="h-6 w-6">
                    <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Menu items --}}
            <nav class="flex h-full flex-col justify-center gap-6 p-6">
                <a href="#" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">NEW</a>
                <a href="{{ route('products.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">All PRODUCTS</a>
                <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">DRESSES</a>
                <a href="{{ route('products.index', ['category' => 'hats']) }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">HATS</a>
                <a href="{{ route('products.index', ['category' => 'bags']) }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">BAGS</a>
                <a href="{{ route('boutiques.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">BOUTIQUES</a>
                <a href="{{ route('pages.show', 'about') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
                <a href="{{ route('products.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">STYLING</a>
                @auth
                    <a href="{{ route('dashboard.index') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">DASHBOARD</a>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer>
        <div class="bg-[#1A1A1A] px-[60px] py-12">
            <div class="flex flex-col gap-10 md:flex-row md:gap-10">
                <div class="flex-1">
                    <p class="font-serif text-[24px] tracking-[2px] text-white">HIRE COLLECTIVE</p>
                    <p class="mt-3 text-[14px] leading-relaxed text-[#AAA]">Ireland's luxury multi-boutique fashion hire marketplace. Discover, hire, and wear designer pieces from trusted Irish boutiques.</p>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">EXPLORE</p>
                    <div class="mt-3 flex flex-col gap-2">
                        <a href="{{ route('boutiques.index') }}" class="text-[14px] text-[#AAA] hover:text-white">All Boutiques</a>
                        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-[14px] text-[#AAA] hover:text-white">Dresses</a>
                        <a href="{{ route('products.index', ['category' => 'hats']) }}" class="text-[14px] text-[#AAA] hover:text-white">Hats</a>
                        <a href="{{ route('products.index', ['category' => 'bags']) }}" class="text-[14px] text-[#AAA] hover:text-white">Bags</a>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">COMPANY</p>
                    <div class="mt-3 flex flex-col gap-2">
                        <a href="#" class="text-[14px] text-[#AAA] hover:text-white">How it works</a>
                        <a href="#" class="text-[14px] text-[#AAA] hover:text-white">Terms & Conditions</a>
                        <a href="#" class="text-[14px] text-[#AAA] hover:text-white">Privacy Policy</a>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">GET IN TOUCH</p>
                    <p class="mt-3 text-[14px] text-[#AAA]">hello@hirecollective.ie</p>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between bg-[#111] px-[60px] py-4">
            <p class="text-[11px] text-[#AAA]">&copy; {{ date('Y') }} Hire Collective. All rights reserved.</p>
            <div class="flex items-center gap-5">
                <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Terms</a>
                <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Privacy</a>
                <a href="#" class="text-[11px] text-[#AAA] hover:text-white">Cookies</a>
            </div>
        </div>
    </footer>
</body>
</html>
