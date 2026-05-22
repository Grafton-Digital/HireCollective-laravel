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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans text-gray-900 antialiased">
    {{-- Top banner --}}
    <div class="bg-cream-200 py-2 text-center">
        <p class="text-[11px] font-normal tracking-[1px] text-black">FREE DELIVERY ON ORDERS OVER €100</p>
    </div>

    {{-- Header --}}
    <header class="flex items-center justify-between bg-cream-50 px-[60px] py-4">
        <a href="{{ route('home') }}" class="font-serif text-2xl tracking-[3px] text-black">
            HIRE COLLECTIVE
        </a>

        {{-- Search bar (desktop) --}}
        <div class="hidden items-center gap-2 border border-[#D0D0D0] px-4 md:flex" style="height:40px; width:360px;">
            <span class="flex-1 text-[13px] text-[#999]">Search dresses, bags, hats, boutiques...</span>
            <svg class="h-[18px] w-[18px] text-[#666]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>

        {{-- Icons --}}
        <div class="flex items-center gap-5">
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/></svg>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z"/></svg>
        </div>
    </header>

    {{-- Navigation --}}
    <nav class="flex items-center justify-center gap-10 bg-cream-50 px-[60px] py-3">
        <a href="{{ route('products.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">OUTFITS</a>
        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">DRESSES</a>
        <a href="{{ route('products.index', ['category' => 'hats']) }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">HATS</a>
        <a href="{{ route('products.index', ['category' => 'bags']) }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">BAGS</a>
        <a href="{{ route('boutiques.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">BOUTIQUES</a>
        <a href="{{ route('pages.show', 'about') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
        <a href="{{ route('products.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">STYLING</a>
        @auth
            <a href="{{ route('dashboard.index') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">DASHBOARD</a>
        @endauth
    </nav>

    <main>
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer>
        <div class="bg-[#1A1A1A] px-[60px] py-12">
            <div class="flex flex-col gap-10 md:flex-row md:gap-10">
                <div class="flex-1">
                    <p class="font-serif text-lg tracking-[2px] text-white">HIRE COLLECTIVE</p>
                    <p class="mt-3 text-xs leading-relaxed text-[#AAA]">Ireland's luxury multi-boutique fashion hire marketplace. Discover, hire, and wear designer pieces from trusted Irish boutiques.</p>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">EXPLORE</p>
                    <div class="mt-3 flex flex-col gap-2">
                        <a href="{{ route('boutiques.index') }}" class="text-xs text-[#AAA] hover:text-white">All Boutiques</a>
                        <a href="{{ route('products.index', ['category' => 'dresses']) }}" class="text-xs text-[#AAA] hover:text-white">Dresses</a>
                        <a href="{{ route('products.index', ['category' => 'hats']) }}" class="text-xs text-[#AAA] hover:text-white">Hats</a>
                        <a href="{{ route('products.index', ['category' => 'bags']) }}" class="text-xs text-[#AAA] hover:text-white">Bags</a>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">COMPANY</p>
                    <div class="mt-3 flex flex-col gap-2">
                        <a href="{{ route('pages.show', 'about') }}" class="text-xs text-[#AAA] hover:text-white">About</a>
                        <a href="{{ route('pages.show', 'faq') }}" class="text-xs text-[#AAA] hover:text-white">FAQ</a>
                        <a href="#" class="text-xs text-[#AAA] hover:text-white">Terms & Conditions</a>
                        <a href="#" class="text-xs text-[#AAA] hover:text-white">Privacy Policy</a>
                    </div>
                </div>
                <div class="flex-1">
                    <p class="text-[11px] font-semibold tracking-[1px] text-white">GET IN TOUCH</p>
                    <p class="mt-3 text-xs text-[#AAA]">hello@hirecollective.ie</p>
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
