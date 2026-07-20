{{-- Top banner --}}
<div class="bg-cream-200 py-2 text-center">
    <p class="text-[11px] font-normal tracking-[1px] text-black">FREE DELIVERY ON ORDERS OVER €100</p>
</div>

{{-- Header --}}
<header class="relative flex items-center justify-between bg-cream-50 px-4 py-4 md:px-[60px]" x-data="{
    mobileMenuOpen: false,
    searchOpen: false,
    newFavoritesCount: 0,
    init() {
        this.updateNewFavoritesCount();
    },
    updateNewFavoritesCount() {
        const favorites = JSON.parse(localStorage.getItem('favorites') || '[]');
        const viewedFavorites = JSON.parse(localStorage.getItem('viewedFavorites') || '[]');

        // Count how many favorites haven't been viewed
        const favoriteIds = favorites.map(f => f.id);
        const newIds = favoriteIds.filter(id => !viewedFavorites.includes(id));

        this.newFavoritesCount = newIds.length;
    }
}" @favorite-added.window="updateNewFavoritesCount()" @favorite-removed.window="updateNewFavoritesCount()">
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
            <a href="{{ route('about') }}" class="text-xs font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
        </nav>
    </div>

    {{-- Center: Logo --}}
    <a href="{{ route('home') }}" class="font-serif text-[26px] tracking-[3px] text-black md:text-2xl">
        HIRE COLLECTIVE
    </a>

    {{-- Right section: Icons --}}
    <div class="flex w-full max-w-[338px] items-center justify-end gap-4">
        <button @click="searchOpen = true" class="h-5 w-5">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </button>
        <a href="{{ route('favorites.index') }}" class="relative h-5 w-5">
            <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>
            <span
                x-show="newFavoritesCount > 0"
                x-text="newFavoritesCount"
                class="absolute -right-2 -top-2 flex h-4 min-w-[16px] items-center justify-center rounded-full bg-red-500 px-1 text-[10px] font-semibold text-white"
                style="display: none;"
            ></span>
        </a>
        <a href="{{ route('account.overview') }}" class="h-5 w-5">
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
            <a href="{{ route('about') }}" class="text-[18px] font-normal tracking-[1px] text-black hover:underline">HOW IT WORKS</a>
        </nav>
    </div>
</header>
